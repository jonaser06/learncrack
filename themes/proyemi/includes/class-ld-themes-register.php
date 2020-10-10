<?php

if ( ( class_exists( 'LearnDash_Theme_Register' ) ) && ( ! class_exists( 'LearnDash_Theme_Register_Proyemi' ) ) ) {
	/**
	 * Class to create the settings section.
	 */
	class LearnDash_Theme_Register_Proyemi extends LearnDash_Theme_Register {

		/**
		 * Protected constructor for class
		 */
		protected function __construct() {
			$this->theme_key          = 'proyemi';
			$this->theme_name         = esc_html__( 'Proyemi', 'learndash' );
			$this->theme_base_dir     = trailingslashit( LEARNDASH_LMS_PLUGIN_DIR ) . 'themes/' . $this->theme_key;
			$this->theme_base_url     = trailingslashit( LEARNDASH_LMS_PLUGIN_URL ) . 'themes/' . $this->theme_key;
			$this->theme_template_dir = $this->theme_base_dir . '/templates';
			$this->theme_template_url = $this->theme_base_url . '/templates';
		}
		
	}
}

add_action(
	'learndash_themes_init',
	function() {
		LearnDash_Theme_Register_Proyemi::add_theme_instance( 'proyemi' );
	}
);

include_once __DIR__ . '/helpers.php';