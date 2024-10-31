<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.0.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes
 */

if ( ! class_exists( 'Acfp' ) ) {
	/**
	 * The core plugin class.
	 *
	 * This is used to define internationalization, admin-specific hooks, and
	 * public-facing site hooks.
	 *
	 * Also maintains the unique identifier of this plugin as well as the current
	 * version of the plugin.
	 *
	 * @since      1.0.0
	 * @package    Acfp
	 * @subpackage Acfp/includes
	 * @author     the WP Catalyst <thewpcatalyst@gmail.com>
	 */
	class Acfp {

		/**
		 * Global Settings for the plugin
		 *
		 * @since 1.4.0
		 *
		 * @var array
		 */
		protected array $settings;

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      Acfp_Loader    $loader    Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $version    The current version of the plugin.
		 */
		protected $version;

		/**
		 * Supported field types in shortcode.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $shortcode_supported_field_types.
		 */
		protected $shortcode_supported_field_types;

		/**
		 * ACFP Directory url
		 *
		 * @var string
		 */
		protected $plugin_base_url;

		/**
		 * Holds layouts for multiple posts
		 *
		 * @since 1.4.0
		 *
		 * @var array
		 */
		protected array $posts_layouts = array();

		/**
		 * Holds layouts for a single post.
		 *
		 * @since 1.4.0
		 *
		 * @var array
		 */
		protected array $post_layouts = array();

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			if ( defined( 'ACFP_VERSION' ) ) {
				$this->version = ACFP_VERSION;
			} else {
				$this->version = '1.4.0';
			}
			$this->plugin_name                     = 'acfp';
			$this->plugin_base_url                 = plugin_dir_url( __DIR__ );
			$this->shortcode_supported_field_types = array(
				'text',
				'textarea',
				'email',
				'number',
				'range',
				'email',
				'url',
				'acfp_dual_range_slider',
				'image',
				'file',
				'wysiwyg',
				'oembed',
				'select',
				'checkbox',
				'radio',
			);

			$this->load_settings();
			$this->load_dependencies();
			$this->set_locale();
			$this->add_layouts();
			$this->define_common_hooks();
			$this->define_admin_hooks();
			$this->define_public_hooks();
			$this->init();// called after everything has been set.
		}

		/**
		 * Initializes global settings
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function load_settings() {
			$this->settings = array(
				'debug'                  => false,
				'enqueue_foundation_css' => true,
			);
		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - Acfp_Loader. Orchestrates the hooks of the plugin.
		 * - Acfp_i18n. Defines internationalization functionality.
		 * - Acfp_Admin. Defines all hooks for the admin area.
		 * - Acfp_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acfp-loader.php';

			/**
			 * The class responsible for defining internationalization functionality
			 * of the plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acfp-i18n.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acfp-admin.php';

			/**
			 * The class responsible for defining all actions that occur in both admin and public area.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-acfp-common.php';
			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-acfp-public.php';

			/**
			 * Class responsible for acfp shortcode.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/class-acfp-shortcode.php';

			/**
			 * File holding useful functions.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/acfp-utility.php';

			// render content.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/interface-acfp-render-field-type.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-link.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-select.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-checkbox.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-radio.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-number.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-oembed.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-wysiwyg.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-email.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-url.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-dual-range-slider.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-image.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-file.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-range.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-text.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-textarea.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-button-group.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-true-false.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-user.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-taxonomy.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-page-link.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/module/class-acfp-layout.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/module/posts/interface-acfp-post-layout.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/module/posts/class-acfp-posts-layout.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/module/posts/class-acfp-posts-layouts.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/module/posts/class-acfp-post-layout.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/module/posts/class-acfp-post-simple-card-layout.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/module/posts/class-acfp-posts-fber-list-layout.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/module/posts/class-acfp-posts-simple-grid-layout.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-post-object.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/renders/class-acfp-render-relationship.php';

			// Mods.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/fields/mods/class-acfp-acf-link-field-mod.php';
			$this->loader = new Acfp_Loader();
		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the Acfp_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function set_locale() {

			$plugin_i18n = new Acfp_i18n();

			$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		}

		/**
		 * Register all of the hooks related to both admin and public area functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_common_hooks() {
			$plugin_shortcode = new ACFP_Shortcode( $this );
			$this->loader->add_action( 'init', $plugin_shortcode, 'init' );

			$plugin_acf_link_mod = new ACFP_ACF_Link_Field_Mod( $this );
			$this->loader->add_action( 'acf/init', $plugin_acf_link_mod, 'acf_init' );
			$this->loader->add_action( 'acf/register_scripts', $plugin_acf_link_mod, 'enqueue_extra_scripts_after_acf_scripts_and_styles', 10, 2 );
			$this->loader->add_action( 'acf/load_value/type=link', $plugin_acf_link_mod, 'load_value', 10, 3 );
			$this->loader->add_action( 'after_wp_tiny_mce', $plugin_acf_link_mod, 'after_wp_tiny_mce' );

			$plugin_common = new ACFP_Common( $this );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_common, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_common, 'enqueue_scripts' );

			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_common, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_common, 'enqueue_scripts' );

			$this->loader->add_action( 'acf/init', $plugin_common, 'acf_init' );
			$this->loader->add_action( 'init', $plugin_common, 'init' );
		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_admin_hooks() {
			$plugin_admin = new ACFP_Admin( $this );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
			$this->loader->add_action( 'init', $plugin_admin, 'init' );
			$this->loader->add_action( 'acf/init', $plugin_admin, 'acf_init' );
		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_public_hooks() {
			$plugin_public = new Acfp_Public( $this->get_plugin_name(), $this->get_version() );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

			$posts_layouts = $this->get_posts_layouts();
			foreach ( $posts_layouts as $posts_layout ) {
				$this->loader->add_action( 'wp_enqueue_scripts', $posts_layout, 'enqueue_styles' );
				$this->loader->add_action( 'wp_enqueue_scripts', $posts_layout, 'enqueue_scripts' );
			}

		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    1.0.0
		 */
		public function run() {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since     1.0.0
		 * @return    string    The name of the plugin.
		 */
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @since     1.0.0
		 * @return    Acfp_Loader    Orchestrates the hooks of the plugin.
		 */
		public function get_loader() {
			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since     1.0.0
		 * @return    string    The version number of the plugin.
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Gets plugin_base_url
		 *
		 * @since 1.0.0
		 *
		 * @return string
		 */
		public function get_plugin_base_url() {
			return $this->plugin_base_url;
		}

		/**
		 * Gets shortcode_supported_field_types
		 *
		 * @return array
		 */
		public function get_shortcode_supported_field_types() {
			return $this->shortcode_supported_field_types;
		}

		/**
		 * Returns all settings.
		 *
		 * @since 1.4.0
		 *
		 * @return array
		 */
		public function get_settings() {
			return $this->settings;
		}


		/**
		 * Adds layouts instances.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function add_layouts() {
			// posts layouts.
			$this->add_posts_layout( acfp_create_instance( 'ACFP_Posts_FBER_List_Layout', $this ) );
			$this->add_posts_layout( acfp_create_instance( 'ACFP_Posts_Simple_Grid_Layout', $this ) );
			// post layouts.
			$this->add_post_layout( acfp_create_instance( 'ACFP_Post_Simple_Card_Layout', $this ) );
		}

		/**
		 * Adds a single posts layout
		 *
		 * @since 1.4.0
		 *
		 * @param  mixed $posts_layout_instance //todo: define the param type.
		 *
		 * @return void
		 */
		public function add_posts_layout( $posts_layout_instance ) {
			$this->posts_layouts[] = $posts_layout_instance;

		}

		/**
		 * Adds a single post layouts
		 *
		 * @since 1.4.0
		 *
		 * @param  mixed $post_layout_instance //todo: define the param type.
		 *
		 * @return void
		 */
		public function add_post_layout( $post_layout_instance ) {
			$this->post_layouts[] = $post_layout_instance;
		}

		/**
		 * Retrieves posts layouts.
		 *
		 * @since 1.4.0
		 *
		 * @return array
		 */
		public function get_posts_layouts() {
			return $this->posts_layouts;
		}

		/**
		 * Retrieves post layouts.
		 *
		 * @since 1.4.0
		 *
		 * @return array
		 */
		public function get_post_layouts() {
			return $this->post_layouts;
		}

		/**
		 * Returns posts layout retrieved using using name.
		 *
		 * @since 1.4.0
		 *
		 * @param  string $name the name of layout.
		 *
		 * @return ACFP_Posts_Layout|false
		 */
		public function get_posts_layout_by_name( string $name ) {
			foreach ( $this->posts_layouts as $posts_layout ) {
				if ( $name === $posts_layout->get_name() ) {
					return $posts_layout;
				}
			}
			return false;// fail.
		}


		/**
		 * Returns post layout retrieved using using name.
		 *
		 * @since 1.4.0
		 *
		 * @param  string $name the name of layout.
		 *
		 * @return ACFP_Post_Layout|false
		 */
		public function get_post_layout_by_name( string $name ) {
			foreach ( $this->post_layouts as $post_layout ) {
				if ( $name === $post_layout->get_name() ) {
					return $post_layout;
				}
			}
			return false;// fail.
		}



		/**
		 * Executes necessary code after plugin initialization.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		private function init() {
			// phpcs:ignore WordPress.NamingConventions.ValidHookName
			do_action( 'acfp/init', $this ); // fired after everything has been set.
		}

	}
}
