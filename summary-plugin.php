<?php
/**
 * Plugin Name: sumbd Plugin
 * Description: Adds a sumbd at the top of your articles to easily navigate to your headers
 * Version: 1.0
 * Author: Baptiste Dufour
 * Author URI: https://baptistedufour.fr/
 */

/**
 * Triggers on plugin activation
 */
function sumbd_activate(){
    return;
}

register_activation_hook(__FILE__,'sumbd_activate');

/**
 * Triggers on plugin deactivation
 */
function sumbd_deactivate(){
    return;
}

register_deactivation_hook(__FILE__,'sumbd_deactivate');

/**
 * Triggers on plugin uninstall (it is also possible to do it with an uninstall.php file)
 */
function sumbd_uninstall(){
    return;
}

register_uninstall_hook(__FILE__,'sumbd_uninstall');

//echo plugins_url( 'README.md', __FILE__ ); // Works a little bit like get_template_directory_uri in themes


// The plugin functionality in themselves

include_once 'public/summary.php';
include_once 'public/header.php';

Summary::display();