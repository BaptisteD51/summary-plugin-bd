<?php
class Sumbdsettings{
    public const OPTION_GROUP = "sumbd_options";
    public const OPTION_NAME = "display_on";

    public static function add_setting_page(){
        add_action('admin_menu', [self::class,'setting_page']); // to add a menu page
        add_action('admin_init', [self::class,'register_settings']); // to add an option
    }

    public static function setting_page(){
        add_options_page(
            'Summary : settings',
            'Summary',
            'manage_options',
            'summary_settings',
            [self::class, 'render_page']
        );
    }

    public static function render_page(){
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
    }

    public static function register_settings(){
        register_setting(self::OPTION_GROUP, self::OPTION_NAME);
        add_settings_section(
            'sumbd_option_section', 
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
                $options = get_option(self::OPTION_NAME);
                $checkedfields = isset( $options['post_types'] ) ? (array) $options['post_types'] : []; // le (array) force la conversion en tableau

                foreach(self::get_post_types() as $post_type):
                ?>
                <p>
                    <label for="<?php echo $post_type; ?>"><?php echo $post_type; ?></label>
                    <input type="checkbox" name="<?php echo self::OPTION_NAME; ?>[post_types][]" id="<?php echo $post_type; ?>" value="<?php echo $post_type; ?>" <?php checked( in_array($post_type, $checkedfields), 1)?>>
                </p>
                
                <?php
                endforeach;
            },
            self::OPTION_GROUP,
            'sumbd_option_section' //settings section to link with
        );

    }
    
    public static function get_post_types(){
        $allPostTypes = get_post_types(['public'   => true,]);
        
        // the attachment post type isn't relevant for a summary
        $allPostTypes = array_filter($allPostTypes, function($postType){
            return $postType != "attachment";
        });

        return $allPostTypes;
    }
}