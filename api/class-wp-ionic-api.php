<?php

/**
 * The api-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Ionic
 * @subpackage Wp_Ionic/api
 * @author     Dimitriοs Mavroudis <im.dimitris.mavroudis@gmail.com>
 */
class Wp_Ionic_Api
{

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct()
	{
	}

	/**
	 * Register the Rest API routes
	 *
	 * @since    1.0.0
	 */
	public function register_routes()
	{
		register_rest_route('wpionic/v1', '/settings', array(
			'methods' => 'GET',
			'callback' => array($this, 'get_settings'),
		));
	}

	/**
	 * Returns an array with the settings need for the app
	 *
	 * @since    1.0.0
	 */
	public function get_settings()
	{
		$settings = json_decode(get_option('wp_ionic_settings'));
		$settings->name = get_bloginfo('name');
		$settings->language = get_bloginfo('language');
		$settings->gmt_offset = get_option('gmt_offset');
		return $settings;
	}
}
