<?php
/**
 * The common-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.3.1
 *
 * @package    Acfp
 * @subpackage Acfp/common
 */

if ( ! class_exists( 'ACFP_Common' ) ) {
	/**
	 * The common-specific functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the common-specific stylesheet and JavaScript.
	 *
	 * @package    Acfp
	 * @subpackage Acfp/common
	 * @author     the WP Catalyst <thewpcatalyst@gmail.com>
	 */
	class ACFP_Common {
		/**
		 * The ID of this plugin.
		 *
		 * @since    1.3.1
		 * @access   private
		 * @var      string    $plugin_name    The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.3.1
		 * @access   private
		 * @var      string    $version    The current version of this plugin.
		 */
		private $version;

		/**
		 * Holds ACFP class instance
		 *
		 * @since    1.3.1
		 *
		 * @var ACFP
		 */
		private $acfp;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.3.1
		 * @param      Acfp $acfp       Acfp class instance..
		 */
		public function __construct( Acfp $acfp ) {
			$this->acfp        = $acfp;
			$this->plugin_name = $acfp->get_plugin_name();
			$this->version     = $acfp->get_version();

		}

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.3.1
		 */
		public function enqueue_styles() {

		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.3.1
		 */
		public function enqueue_scripts() {

		}

		/**
		 * Fired on WordPress init action.
		 *
		 * @since    1.3.1
		 *
		 * @return void
		 */
		public function init() {
		}

		/**
		 * Fired on acf/init action.
		 *
		 * @since    1.3.1
		 *
		 * @return void
		 */
		public function acf_init() {
			$this->include_field_types();
		}

		/**
		 * Includes extra fields
		 *
		 * @since    1.3.1
		 *
		 * @return void
		 */
		public function include_field_types() {
			if ( ! class_exists( 'ACF' ) ) {
				return;
			}

			$acfp_field_types_classes = array(
				'ACFP_ACF_Field_Dual_Range_Slider' => 'includes/fields/class-acfp-acf-field-dual-range-slider.php',
				'ACFP_ACF_Link_Field'              => 'includes/fields/class-acfp-acf-link-field.php',
			);

			// phpcs:ignore WordPress.NamingConventions.ValidHookName
			$acfp_field_types_classes = apply_filters( 'acfp/include_field_types', $acfp_field_types_classes, $this->acfp );

			foreach ( $acfp_field_types_classes as $field_type_class => $class_path ) {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . $class_path;
				acf_register_field_type( $field_type_class );
			}
		}
	}
}
