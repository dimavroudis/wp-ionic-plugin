<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mavrou.gr
 * @since      1.0.0
 *
 * @package    Wp_Ionic
 * @subpackage Wp_Ionic/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Ionic
 * @subpackage Wp_Ionic/admin
 * @author     Dimitriοs Mavroudis <im.dimitrismavroudis@gmail.com>
 */
class Wp_Ionic_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Adds the option in WordPress Admin menu
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function options_page() {
		add_options_page( __( 'WP Ionic', 'wp-ionic' ), __( 'WP Ionic', 'wp-ionic' ), 'manage_options', 'wp-ionic', array(
			$this,
			'options_page_content',
		) );
	}

	/**
	 * Adds the admin page content
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function options_page_content() {

		include_once( 'partials/admin-display.php' );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		if ( 'settings_page_wp-ionic' !== $hook ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-ionic-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '_select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		if ( 'settings_page_wp-ionic' !== $hook ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name . '_select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-ionic-admin.js', array( 'jquery', $this->plugin_name . '_select2' ), $this->version, true );
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
	public function action_links( $actions, $plugin_file ) {

		if ( $plugin_file === $this->plugin_path ) {
			$settings  = array(
				'settings' => '<a href="' . esc_url( get_admin_url( null, 'options-general.php?page=wp-ionic' ) ) . '">' . __( 'Settings', 'wp-ionic' ) . '</a>',
			);
			$actions   = array_merge( $converter, $actions );
			$actions   = array_merge( $settings, $actions );
		}

		return $actions;

	}

}
