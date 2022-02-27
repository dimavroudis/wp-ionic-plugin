<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://mavrou.gr
 * @since             1.0.0
 * @package           Wp_Ionic
 *
 * @wordpress-plugin
 * Plugin Name:       WP Ionic
 * Plugin URI:        wp-ionic
 * Description:       Integrate your WordPress Website with WP Ionic based Apps
 * Version:           1.0.2
 * Author:            Dimitriοs Mavroudis
 * Author URI:        https://mavrou.gr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-ionic
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Current plugin version.
 */
define('WP_IONIC_VERSION', '1.0.2');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-ionic-activator.php
 */
function activate_wp_ionic()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-wp-ionic-activator.php';
	Wp_Ionic_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-ionic-deactivator.php
 */
function deactivate_wp_ionic()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-wp-ionic-deactivator.php';
	Wp_Ionic_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_ionic');
register_deactivation_hook(__FILE__, 'deactivate_wp_ionic');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wp-ionic.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_ionic()
{

	$plugin_path = plugin_basename(__FILE__);
	$plugin = new Wp_Ionic($plugin_path);
	$plugin->run();
}
run_wp_ionic();
