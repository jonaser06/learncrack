<?php
/**
 * LearnDash Settings Page certificate Options.
 *
 * @package LearnDash
 * @subpackage Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ( class_exists( 'LearnDash_Settings_Page' ) ) && ( ! class_exists( 'LearnDash_Settings_Page_Certificates_Options' ) ) ) {
	/**
	 * Class to create the settings page.
	 */
	class LearnDash_Settings_Page_Certificates_Options extends LearnDash_Settings_Page {

		/**
		 * Public constructor for class
		 */
		public function __construct() {

			$this->parent_menu_page_url = 'edit.php?post_type=sfwd-certificates';
			$this->menu_page_capability = LEARNDASH_ADMIN_CAPABILITY_CHECK;
			$this->settings_page_id     = 'certificate-options';
			$this->settings_page_title  = esc_html_x( 'Settings', 'Course Settings', 'learndash' );
			$this->settings_tab_title   = $this->settings_page_title;

			parent::__construct();
		}
	}
}
add_action(
	'learndash_settings_pages_init',
	function() {
		LearnDash_Settings_Page_Certificates_Options::add_page_instance();
	}
);
