<?php
/**
 * The file defines core functions and variables for all layouts
 *
 * This class is extended by layouts in this plugin.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders/module
 */

if ( ! class_exists( 'ACFP_Layout' ) ) {

	/**
	 * The file defines core functions and variables for all layouts
	 *
	 * @since      1.4.0
	 * @package    Acfp
	 * @subpackage Acfp/includes/renders/module
	 * @author     the WP Catalyst <thewpcatalyst@gmail.com>
	 */
	class ACFP_Layout {

		/**
		 * Holds ACFP instance.
		 *
		 * @since 1.4.0
		 *
		 * @var ACFP
		 */
		protected ACFP $acfp;

		/**
		 * The name of the layout.
		 *
		 * @since 1.4.0
		 *
		 * @var string
		 */
		protected string $name;

		/**
		 * Undocumented function
		 *
		 * @since 1.4.0
		 *
		 * @param  ACFP $acfp instance.
		 */
		public function __construct( ACFP $acfp ) {
			$this->init();
			$this->acfp = $acfp;
		}

		/**
		 * Initialize function
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function init() {

		}

		/**
		 * Returns the name of layout.
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public function get_name() {
			return $this->name;
		}

		/**
		 * Enqueues Stylesheet files.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function enqueue_styles() {

		}

		/**
		 * Enqueues Javascript files.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

		}

	}
}
