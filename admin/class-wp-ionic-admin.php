<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Ionic
 * @subpackage Wp_Ionic/admin
 * @author     Dimitriοs Mavroudis <im.dimitris.mavroudis@gmail.com>
 */
class Wp_Ionic_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version, $plugin_path)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_path = $plugin_path;
	}

	/**
	 * Adds the option in WordPress Admin menu
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function options_page()
	{
		add_options_page(__('WP Ionic', 'wp-ionic'), __('WP Ionic', 'wp-ionic'), 'manage_options', 'wp-ionic', array(
			$this,
			'options_page_content',
		));
	}

	/**
	 * Adds the admin page content
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function options_page_content()
	{

		include_once('partials/admin-display.php');
	}

	/**
	 * Save plugin settings
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	private function save_settings()
	{

		if (isset($_POST['nonce_wp_ionic_submitSettings']) && wp_verify_nonce($_POST['nonce_wp_ionic_submitSettings'], 'wp_ionic_submitSettings')) {

			$more_links = array();

			if (isset($_POST['more_link']) && $_POST['more_link'] !== '') {
				$links_indexes = explode(',', $_POST['more_link']);
				foreach ($links_indexes as $i => $index) {
					$more_links[$i]['label'] = isset($_POST['more_link_' . $index . '_label']) ? sanitize_text_field($_POST['more_link_' . $index . '_label']) : '';
					$more_links[$i]['url'] = isset($_POST['more_link_' . $index . '_url']) ? sanitize_text_field($_POST['more_link_' . $index . '_url']) : '';
					$more_links[$i]['icon'] = isset($_POST['more_link_' . $index . '_icon']) ? sanitize_text_field($_POST['more_link_' . $index . '_icon']) : '';
				}
			}

			$new_settings = array(
				'description' => isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '',
				'featured_posts' => isset($_POST['featured_posts']) ? $_POST['featured_posts'] : [],
				'featured_categories' => isset($_POST['featured_categories']) ? $_POST['featured_categories'] : [],
				'featured_pages' => isset($_POST['featured_pages']) ? $_POST['featured_pages'] : [],
				'links' => $more_links,
				'comments' => isset($_POST['comments']) ? 'enabled' : 'disabled',
			);

			$updated = update_option('wp_ionic_settings',  wp_json_encode($new_settings));
		}
	}

	/**
	 * Get plugin settings
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	private function get_settings()
	{
		return json_decode(get_option('wp_ionic_settings'), true);
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook)
	{

		if ('settings_page_wp-ionic' !== $hook) {
			return;
		}

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-ionic-admin.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . '_select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook)
	{

		if ('settings_page_wp-ionic' !== $hook) {
			return;
		}

		wp_enqueue_script($this->plugin_name . '_select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-ionic-admin.js', array('jquery', $this->plugin_name . '_select2'), $this->version, true);
	}

	/**
	 * Set custom links in plugins page
	 *
	 * @since    1.0.0
	 *
	 * @param   array $actions
	 * @param   string $plugin_file
	 *
	 * @return  array    $actions
	 */
	public function action_links($actions, $plugin_file)
	{
		if ($plugin_file === $this->plugin_path) {
			$settings  = array(
				'settings' => '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=wp-ionic')) . '">' . __('Settings', 'wp-ionic') . '</a>',
			);
			$actions   = array_merge($settings, $actions);
		}

		return $actions;
	}
}
