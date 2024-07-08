<?php
/**
 * Plugin Name: Bd's Summary Plugin 
 * Description: Adds a summary at the top of your post, pages or custom post types, to easily navigate to your headers
 * Version: 1.0
 * Author: Baptiste Dufour
 * Author URI: https://baptistedufour.fr/
 */

require_once 'admin/sumbdsettings.php';
require_once 'public/sumbdview.php';

/**
 * Triggers on plugin activation
 */
function sumbd_activate(){
}

register_activation_hook(__FILE__,'sumbd_activate');

/**
 * Triggers on plugin deactivation
 */
function sumbd_deactivate(){
}

register_deactivation_hook(__FILE__,'sumbd_deactivate');

/**
 * Triggers on plugin uninstall (it is also possible to do it with an uninstall.php file)
 */
function sumbd_uninstall(){
    delete_option(Sumbdsettings::OPTION_NAME_1);
}

register_uninstall_hook(__FILE__,'sumbd_uninstall');

//echo plugins_url( 'README.md', __FILE__ ); // Works a little bit like get_template_directory_uri in themes
// plugin_dir_url(__FILE__) to get the directory

// The plugin Settings and options

Sumbdsettings::register();

// The plugin functionalities in themselves

Sumbdview::display();
