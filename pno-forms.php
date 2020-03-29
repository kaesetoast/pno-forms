<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Pno_Forms
 *
 * @wordpress-plugin
 * Plugin Name:       PNO Forms Plugin
 * Plugin URI:        http://example.com/pno-forms-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pno-forms
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
define( 'PNO_FORMS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pno-forms-activator.php
 */
function activate_pno_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pno-forms-activator.php';
	Pno_Forms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pno-forms-deactivator.php
 */
function deactivate_pno_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pno-forms-deactivator.php';
	Pno_Forms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pno_forms' );
register_deactivation_hook( __FILE__, 'deactivate_pno_forms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pno-forms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pno_forms() {

	$plugin = new Pno_Forms();
	$plugin->run();

}
run_pno_forms();
