<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://devexhub.com/services/web-development/
 * @since             1.5
 * @package           Devexhub_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       Devexhub Gallery
 * Plugin URI:        https://devexhub.com/
 * Description:       This plugin allows you to create a responsive gallery page in the frontend.
 * Version:           1.8
 * Author:            Team Devexhub
 * Developed By:      Gurjaint Narwal
 * Designed By:       Akshay Kumar
 * Author URI:        https://devexhub.com/services/web-development/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       devexhub-gallery
 * Domain Path:       /languages
**/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DEVEXHUB_GALLERY_VERSION', '1.8' );

/** Start Set Devexhub Plugin Path Function **/
function Devexhub_gallery_plugin_file_path(){
    $path = dirname(__FILE__).'/devexhub-galleryt.php';
    return $path;
}
/** Close Set Devexhub Plugin Path Function **/

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-devexhub-gallery-activator.php
 */
function activate_devexhub_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-devexhub-gallery-activator.php';
	Devexhub_Gallery_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-devexhub-gallery-deactivator.php
 */
function deactivate_devexhub_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-devexhub-gallery-deactivator.php';
	Devexhub_Gallery_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_devexhub_gallery' );
register_deactivation_hook( __FILE__, 'deactivate_devexhub_gallery' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-devexhub-gallery.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

/** Start set plugin path function **/
function DH_gallery_plugin_file_path(){
    $currentfilpath = plugin_dir_url( __FILE__ );
    return $currentfilpath;
}
/** Close set plugin path function **/

function run_devexhub_gallery() {
	$plugin = new Devexhub_Gallery();
	$plugin->run();
}
run_devexhub_gallery();