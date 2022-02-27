<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Ionic
 * @subpackage Wp_Ionic/includes
 * @author     Dimitriοs Mavroudis <im.dimitris.mavroudis@gmail.com>
 */
class Wp_Ionic_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		$settings  = get_option('wp_ionic_settings');
		if (!$settings) {
			$settings = array(
				'description' => '',
				'featuredPosts' => [],
				'featuredCategories' => [],
				'featuredPages' => [],
				'links' => [],
				'comments' => true,
			);

			update_option('wp_ionic_settings',  wp_json_encode($settings));
		}
	}
}
