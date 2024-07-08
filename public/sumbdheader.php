<?php
class Sumbdheader{
    public $level;
    public $content;
    public $html;
    public $attributes;
    public $anchor;
    
    function __construct(int $level, string $content, string $html, string $attributes)
    {
        $this->level = $level;
        $this->content = $content;
        $this->html = $html;
        $this->attributes = $attributes;
        $this->anchor = rawurlencode( preg_replace('/ /', '-', $content) );
    }

    /**
     * Create an anchor link to the header
     */
    public function create_anchor_markup(){
        $html = '<a href="#'.$this->anchor . '">' . $this->content . '</a>';
        return $html;
    }

    /**
     * Create a new header with an id attribute
     */
    public function create_new_html(){
        $html = '<h' . $this->level . ' id="' . $this->anchor . '" ' . $this->attributes . '">';
        $html .= $this->content . '</h' . $this->level . '>';

        return $html;
    }
}