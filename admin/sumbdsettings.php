<?php
class Sumbdsettings{
    public const OPTION_GROUP = "sumbd_options"; // contain all the options of the setting page
    public const OPTION_NAME_1 = "sumbd_display_on"; // there can be several options for a settings page
    public const OPTION_NAME_2 = "sumbd_max_level";
    public const OPTION_NAME_3 = "sumbd_styling";

    public static function register(){
        add_action('admin_menu', [self::class,'add_page_to_settings_menu']); // to add a menu page
        add_action('admin_init', [self::class,'register_settings']); // to add an option
    }

    public static function add_page_to_settings_menu(){
        add_options_page(
            'Summary : settings',
            'Summary', // may add a logo latter
            'manage_options',
            self::OPTION_GROUP,
            [self::class, 'render_settings_page']
        );
    }

    public static function render_settings_page(){
        ?>

        <h1>Summary Settings</h1>

        <!--<h2>Post types on which to display a summary:</h2>-->

        <form action="options.php" method="post">
            <?php 
            settings_fields(self::OPTION_GROUP); // for security reasons
            do_settings_sections(self::OPTION_GROUP);
            submit_button();
            ?>
        </form>

        <?php
        var_dump(get_option('sumbd_styling'));
    }

    public static function register_settings(){
        register_setting(self::OPTION_GROUP, self::OPTION_NAME_1);
        add_settings_section(
            'sumbd_display_on_section', 
            'Post types',
            function(){
                echo 'Choose post types on which to display a summary';
            },
            self::OPTION_GROUP,
        );

        add_settings_field(
            'sumbd_post_types',
            'Post types:',
            function(){
                $post_types = get_option(self::OPTION_NAME_1);
                $post_types_with_summary = isset( $post_types ) ? (array) $post_types : []; // le (array) force la conversion en tableau

                foreach(self::get_post_types() as $post_type):
                ?>
                <p>
                    <label for="<?php echo $post_type; ?>"><?php echo $post_type; ?></label>
                    <input type="checkbox" name="<?php echo self::OPTION_NAME_1; ?>[]" id="<?php echo $post_type; ?>" value="<?php echo $post_type; ?>" <?php checked( in_array($post_type, $post_types_with_summary), 1)?>>
                </p>
                
                <?php
                endforeach;
            },
            self::OPTION_GROUP, // I don't know why
            'sumbd_display_on_section' //settings section to link with
        );

        // Option 2

        register_setting(self::OPTION_GROUP, self::OPTION_NAME_2);
        add_settings_section(
            'sumbd_max_level_section', 
            'Max level to display',
            function(){
                echo 'Choose the max header level you want the summary to display:';
            },
            self::OPTION_GROUP,
        );

        add_settings_field(
            'sumbd_header_level',
            'Level:',
            function(){

                $level = get_option(self::OPTION_NAME_2);

                ?>

                <label for="level-2">H2</label><input type="radio" name="<?php echo self::OPTION_NAME_2; ?>" value="2" id="level-2" <?php checked($level, 2);?>>
                <label for="level-3">H3</label><input type="radio" name="<?php echo self::OPTION_NAME_2; ?>" value="3" id="level-3" <?php checked($level, 3);?>>
                <label for="level-4">H4</label><input type="radio" name="<?php echo self::OPTION_NAME_2; ?>" value="4" id="level-4" <?php checked($level, 4);?>>
                <label for="level-5">H5</label><input type="radio" name="<?php echo self::OPTION_NAME_2; ?>" value="5" id="level-5" <?php checked($level, 5);?>>
                <label for="level-6">H6</label><input type="radio" name="<?php echo self::OPTION_NAME_2; ?>" value="6" id="level-6" <?php checked($level, 6);?>>

                <?php
            },
            self::OPTION_GROUP,
            'sumbd_max_level_section'
        );

        // Option 3
        register_setting(self::OPTION_GROUP, self::OPTION_NAME_3);
        add_settings_section(
            'sumbd_styling_section', 
            'Customize appearance',
            function(){
                echo 'You can customize the appearance of your summary:';
            },
            self::OPTION_GROUP,
        );

        add_settings_field(
            'sumbd_styling_customize',
            'Customize appearance (uncheck id you want to add your own CSS):',
            function(){
                $customize = get_option(self::OPTION_NAME_3)['customize'];
                ?>
                    <input type="hidden" name="sumbd_styling[customize]">
                    <input type="checkbox" name="sumbd_styling[customize]" <?php checked($customize,true);?>>
                <?php
            },
            self::OPTION_GROUP,
            'sumbd_styling_section',
        );

        add_settings_field(
            'sumbd_styling_background_color',
            'Background color:',
            function(){
                $background_color = get_option(self::OPTION_NAME_3)['background_color'];
                ?>
                    <input class="sumbd-customize-setting" type="color" name="sumbd_styling[background_color]" value="<?php echo $background_color; ?>">
                <?php
            },
            self::OPTION_GROUP,
            'sumbd_styling_section',
        );

        add_settings_field(
            'sumbd_styling_text_color',
            'Text color:',
            function(){
                $text_color = get_option(self::OPTION_NAME_3)['text_color'];
                ?>
                    <input class="sumbd-customize-setting" type="color" name="sumbd_styling[text_color]" value="<?php echo $text_color; ?>">
                <?php
            },
            self::OPTION_GROUP,
            'sumbd_styling_section',
        );

        add_settings_field(
            'sumbd_styling_border_width',
            'Border width:',
            function(){
                $border_width = get_option(self::OPTION_NAME_3)['border_width'];
                ?>
                    <input class="sumbd-customize-setting" type="range" name="sumbd_styling[border_width]" min="0" max ="10" value="<?php echo $border_width; ?>">
                <?php
            },
            self::OPTION_GROUP,
            'sumbd_styling_section',
        );

        add_settings_field(
            'sumbd_styling_border_radius',
            'Border radius:',
            function(){
                $border_width = get_option(self::OPTION_NAME_3)['border_radius'];
                ?>
                    <input class="sumbd-customize-setting" type="range" name="sumbd_styling[border_radius]" min="0" max ="25" value="<?php echo $border_width;?>">
                <?php
            },
            self::OPTION_GROUP,
            'sumbd_styling_section',
        );

        add_settings_field(
            'sumbd_styling_border_color',
            'Border color:',
            function(){
                $border_color = get_option(self::OPTION_NAME_3)['border_color'];
                ?>
                    <input class="sumbd-customize-setting" type="color" name="sumbd_styling[border_color]" value="<?php echo $border_color; ?>">
                <?php
            },
            self::OPTION_GROUP,
            'sumbd_styling_section',
        );

        add_settings_field(
            'sumbd_styling_center',
            'Center summary:',
            function(){
                $center = get_option(self::OPTION_NAME_3)['center'];
                ?>
                    <input type="hidden" name="sumbd_styling[center]" value="0">
                    <label for="center_summary">Center </label><input class="sumbd-customize-setting" type="checkbox" name="sumbd_styling[center]" value="1" id="center_summary" <?php checked($center,true);?>>
                <?php
            },
            self::OPTION_GROUP,
            'sumbd_styling_section',
        );

    }
    
    public static function get_post_types(){
        $allPostTypes = get_post_types(['public' => true,]);
        
        // the attachment post type isn't relevant for a summary
        $allPostTypes = array_filter($allPostTypes, function($postType){
            return $postType != "attachment";
        });

        return $allPostTypes;
    }
}