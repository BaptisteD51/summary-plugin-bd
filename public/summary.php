<?php

include_once 'header.php';

class Summary
{
    public static $headers = [];

    public static function collect_headers(string $content)
    {
        $regex = '/<h([2-6])(.*)>(.+)<\/h\1>/';
        $results = preg_match_all($regex, $content, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {
            self::$headers[] = new Header(intval($matches[1][$i]), $matches[3][$i], $matches[0][$i], trim($matches[2][$i]));
        }
    }

    private static function create_summary_markup()
    {
        $headers = self::$headers;

        if (count($headers) == 0) {
            return;
        }

        $html = '<section class="summary-wrapper"><ol class="summary">';

        for ($i = 0; $i < count($headers); $i++) {
            $html .= '<li>';
            $html .= $headers[$i]->create_anchor_markup();

            // Checks if this the last header
            if (($i + 1) == count($headers)) {
                $html .= '</li>';
                // close all ol tags
                for ($j = 0; $j < ($headers[$i]->level - 2); $j++) {
                    $html .= '</li></ol>';
                }
            }
            // Checks if the next header is on the same level  
            else if ($headers[$i]->level == $headers[$i + 1]->level) {
                $html .= '</li>';
            }
            // Checks if the next header is on an inferior level. If true, open a sub list
            else if ($headers[$i]->level < $headers[$i + 1]->level) {
                $html .= '<ol class="summary-submenu level-' . $headers[$i + 1]->level . '">';
            }
            // Checks if the next header is on an superior level. If true, close the sub list
            else if ($headers[$i]->level > $headers[$i + 1]->level) {
                $html .= '</li></li></ol>';
            }
        }

        $html .= '</ol></section>';

        return $html;
    }

    /**
     * Add an id attribute to the headers
     */
    public static function replace_headers(string $content)
    {
        foreach (self::$headers as $header) {
            $content = str_replace($header->html, $header->create_new_html(), $content);
        }

        return $content;
    }

    /** 
     * Append the summary at the right place
     */
    public static function append_summary($content)
    {
        $position = strpos($content, self::$headers[0]->html);
        $before = substr($content, 0, $position);
        $after = substr($content, $position);
        return $before . self::create_summary_markup() . $after;
    }

    /**
     * Triggers the_content filter and add all what we need in the page source code 
     */
    public static function display()
    {
        function sumbd_the_content($content)
        {
            // Checks if I'm on the post post type
            if (is_singular('post') && in_the_loop() && is_main_query()) {
                Summary::collect_headers($content);

                if (Summary::$headers != []) {
                    $content = Summary::append_summary($content);
                    $content = Summary::replace_headers($content);
                }
            }
            return $content;
        }

        add_filter('the_content', 'sumbd_the_content', 1);
    }
}
