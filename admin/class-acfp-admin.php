<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.0.0
 *
 * @package    Acfp
 * @subpackage Acfp/admin
 */

if ( ! class_exists( 'ACFP_Admin' ) ) {

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    Acfp
	 * @subpackage Acfp/admin
	 * @author     the WP Catalyst <thewpcatalyst@gmail.com>
	 */
	class ACFP_Admin {

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
		 * Holds ACFP class instance
		 *
		 * @var ACFP
		 */
		private $acfp;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
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
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Acfp_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Acfp_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/acfp-admin.css', array(), $this->version, 'all' );

		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Acfp_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Acfp_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/acfp-admin.js', array( 'jquery' ), $this->version, false );

		}


		/**
		 * Fired on WordPress init action.
		 *
		 * @return void
		 */
		public function init() {
		}

		/**
		 * Fired on acf/init action.
		 *
		 * @since    1.4.0
		 *
		 * @return void
		 */
		public function acf_init() {
			$this->include_locations();
		}

		/**
		 * Contains locations to be included.
		 *
		 * @since    1.4.0
		 *
		 * @return void
		 */
		public function include_locations() {
			$acfp_locations_classes = array(
				'ACFP_Location_Taxonomy_Term'        => 'includes/locations/class-acfp-location-taxonomy-term.php',
				'ACFP_Location_Taxonomy_Term_Parent' => 'includes/locations/class-acfp-location-taxonomy-term-parent.php',
				'ACFP_Location_Descendants_Of_Taxonomy_Term' => 'includes/locations/class-acfp-location-descendants-of-taxonomy-term.php',
			);
			if ( function_exists( 'acf_register_location_type' ) ) {
				foreach ( $acfp_locations_classes as $location_class => $class_path ) {
					require_once plugin_dir_path( dirname( __FILE__ ) ) . $class_path;
					acf_register_location_type( $location_class );
				}
			}
		}
	}
}
