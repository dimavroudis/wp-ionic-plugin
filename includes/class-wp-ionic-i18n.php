<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mavrou.gr
 * @since      1.0.0
 *
 * @package    Wp_Ionic
 * @subpackage Wp_Ionic/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Ionic
 * @subpackage Wp_Ionic/includes
 * @author     Dimitriοs Mavroudis <im.dimitrismavroudis@gmail.com>
 */
class Wp_Ionic_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-ionic',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
