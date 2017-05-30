<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://paulpoot.eu
 * @since      1.0.0
 *
 * @package    Freedom_Blackout
 * @subpackage Freedom_Blackout/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Freedom_Blackout
 * @subpackage Freedom_Blackout/admin
 * @author     Paul Poot <development@paulpoot.eu>
 */
class Freedom_Blackout_Admin {

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
	* Register the administration menu for this plugin into the WordPress Dashboard menu.
	*
	* @since    1.0.0
	*/
	public function add_plugin_admin_menu() {

		/*
		* Add a settings page for this plugin to the Settings menu.
		*
		* NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		*
		*        Administration Menus: http://codex.wordpress.org/Administration_Menus
		*
		*/

		add_options_page( 'Freedom Blackout', 'Freedom Blackout', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);

	}

	/**
	* Add settings action link to the plugins page.
	*
	* @since    1.0.0
	*/

	public function add_action_links( $links ) {

		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/

		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);

		return array_merge(  $settings_link, $links );

	}

	/**
	* Render the settings page for this plugin.
	*
	* @since    1.0.0
	*/

	public function display_plugin_setup_page() {

		include_once( 'partials/freedom-blackout-admin-display.php' );

	}

	/**
	* Register plugin settings
	*
	* @since    1.0.0
	*/

	public function options_update() {

    	register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));

 	}

	/**
	* Validate user input
	*
	* @since    1.0.0
	*/

	public function validate($input) {

		$valid = array();

		// Sanitize values
		$valid['cover_percentage'] = $this->sanitize_percentage($input['cover_percentage']);
		$valid['cover_message'] = sanitize_text_field($input['cover_message']);
		$valid['cover_url'] = esc_url($input['cover_url']);

		return $valid;

	}

	/**
	* Check if input is percentage, otherwise return 100
	*
	* @since    1.0.0
	*/

	private function sanitize_percentage($input) {

		// Check if input is an integer and if it's a value from 0 to 100
		if( filter_var($input, FILTER_VALIDATE_INT) && ($input >= 0 && $input <= 100) ) {
			return $input;
		} else {
			return 100;
		}

	}
}