<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://avalonstudios.eu
 * @since             1.0.0
 * @package           Aabr
 *
 * @wordpress-plugin
 * Plugin Name:       Avalon's ACF Block Registration
 * Plugin URI:        https://gitlab.com/plugin-repo
 * Description:       Register ACF Pro blocks in, what I think, is a decent way
 * Version:           1.0.0
 * Author:            Sam Hayman
 * Author URI:        https://avalonstudios.eu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       aabr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AABR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-aabr-activator.php
 */
function activate_aabr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aabr-activator.php';
	Aabr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-aabr-deactivator.php
 */
function deactivate_aabr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aabr-deactivator.php';
	Aabr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_aabr' );
register_deactivation_hook( __FILE__, 'deactivate_aabr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-aabr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_aabr() {

	$plugin = new Aabr();
	$plugin->run();

}
run_aabr();
