<?php
/**
 * The file that defines shortcodes
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.0.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/shortcodes
 */

if ( ! class_exists( 'ACFP_Shortcode' ) ) {
	/**
	 * Class responsible for creating shortcode.
	 */
	class ACFP_Shortcode {

		/**
		 * Holds instance of ACFP.
		 *
		 * @var ACFP
		 */
		protected ACFP $acfp;

		/**
		 * Holds plugin name
		 *
		 * @var string
		 */
		protected $plugin_name;

		/**
		 * Holds plugin version
		 *
		 * @var string
		 */
		protected $version;

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
		 * Fired on init WordPress action.
		 */
		public function init() {
			add_shortcode( 'acfp', array( $this, 'acfp_shortcode' ) );
		}

		/**
		 * Shortcode function
		 *
		 * @param array $atts array of attributes passed on shortcode.
		 * @return string
		 */
		public function acfp_shortcode( $atts ) {
			// Return if ACF is not active.
			if ( ! class_exists( 'ACF' ) ) {
				return;
			}

			// Return if the ACF shortcode is disabled.
			if ( ! acf_get_setting( 'enable_shortcode' ) ) {
				return;
			}

			if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {
				// Prevent the ACF shortcode in FSE block template parts by default.
				// phpcs:ignore WordPress.NamingConventions.ValidHookName
				if ( ! doing_filter( 'the_content' ) && ! apply_filters( 'acf/shortcode/allow_in_block_themes_outside_content', false ) ) {
					return;
				}
			}

			// Limit previews of ACF shortcode data for users without publish_posts permissions.
			// phpcs:ignore WordPress.NamingConventions.ValidHookName
			$preview_capability = apply_filters( 'acf/shortcode/preview_capability', 'publish_posts' );
			if ( is_preview() && ! current_user_can( $preview_capability ) ) {
				// phpcs:ignore WordPress.NamingConventions.ValidHookName
				return apply_filters( 'acf/shortcode/preview_capability_message', __( '[ACF shortcode value disabled for preview]', 'acfp' ) );
			}

			// Mitigate issue where some AJAX requests can return ACF field data.
			// phpcs:ignore WordPress.NamingConventions.ValidHookName
			$ajax_capability = apply_filters( 'acf/ajax/shortcode_capability', 'edit_posts' );
			if ( wp_doing_ajax() && ( false !== $ajax_capability ) && ! current_user_can( $ajax_capability ) ) {
				return;
			}

			// phpcs:ignore WordPress.NamingConventions.ValidHookName
			$access_already_prevented = apply_filters( 'acf/prevent_access_to_unknown_fields', false );
			$filter_applied           = false;

			if ( ! $access_already_prevented ) {
				$filter_applied = true;
				add_filter( 'acf/prevent_access_to_unknown_fields', '__return_true' );
			}

			$a             = shortcode_atts(
				$this->shortcode_pairs(),
				$atts
			);
			$content       = '';
			$field         = $a['field'];
			$object        = $a['object'];
			$empty_message = $a['empty_message'];
			$field_type    = $a['field_type'];// Todo: No longer needed.

			if ( 'current_post' === $object ) {
				$post_id = acfp_get_post_id();
				if ( is_numeric( $post_id ) ) {
					if ( '' !== $field ) {
						if ( function_exists( 'get_field' ) ) {
							$field_value = get_field( $field, $post_id );
							if ( $field_value || is_bool( $field_value ) ) {// is_bool() allows true/false fields to be processed when unchecked.
								// retrieve field type dynamically.
								$field_definitions = acfp_get_field_definitions( $field, $post_id );
								if ( $field_definitions ) {// check if field definitions are available.
									$field_type = $field_definitions['type'];
									$content    = $this->render_field_by_type( $field_type, $field_value, $a, $field_definitions );
								}
							} else {
								$content = $empty_message;
							}
						}
					}
				}
			}

			if ( $filter_applied ) {
				remove_filter( 'acf/prevent_access_to_unknown_fields', '__return_true' );
			}

			return $content;
		}

		/**
		 * Returns entire list of supported attributes and their defaults.
		 *
		 * @since 1.2.0
		 *
		 * @return array
		 */
		protected function shortcode_pairs() {
			return array(
				'field'               => '',
				'object'              => 'current_post', // current_post.
				'field_type'          => '', // type of field being requested.
				'empty_message'       => '',
				'field_type'          => false, // deprecated. //Todo: to add deprecation on read me. // Todo: No longer needed.
				'link_text'           => '', // Used in email.
				'format'              => '', // Used in email: link. Used in number: separators_decimals.
				'decimals'            => 2, // used in number.
				'decimal_separator'   => '.', // used in number.
				'thousands_separator' => ',', // used in number.
				'alt'                 => '', // used in image.
				'width'               => '100px', // used in image.
				'height'              => '100px', // used in image.
				'style'               => '', // used in image.
				'size'                => '', // used in image.
				'media_sizes'         => '', // used in image.
				'tag_id'              => '', // used in image.
				'tag_class'           => '', // used in image.
				'hide_if_empty'       => true,
				'ordered_list_type'   => '1',
				'display'             => '', // used in select: values, labels. In page link: post_title, values.
				'wrap_tag'            => '',
				'unchecked_content'   => 'false', // used in true_false field type.
				'checked_content'     => 'true', // used in true_false field type.
				'rel'                 => '', // Used in url and link.

				'posts_layout'        => 'simple-grid', // Used in post and relationship. Layout for all post.
				'post_layout'         => 'simple-card', // Used in post and relationship. layout for a single post.
			);
		}

		/**
		 * Function to render field by type.
		 *
		 * @since 1.2.0
		 * @since 1.4.0 added @param $field_definitions.
		 *
		 * @param string $field_type field type.
		 * @param mixed  $field_value field value.
		 * @param array  $a attributes.
		 * @param mixed  $field_definitions Field definitions.
		 *
		 * @return string
		 */
		protected function render_field_by_type( string $field_type, $field_value, array $a, $field_definitions ) {
			$render  = null;
			$content = '';

			switch ( $field_type ) {
				case 'text':
					$render = new ACFP_Render_Text( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'textarea':
					$render = new ACFP_Render_Textarea( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'range':
					$render = new ACFP_Render_Range( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'number':
					$render = new ACFP_Render_Number( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'email':
					$render = new ACFP_Render_Email( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'url':
					$render = new ACFP_Render_URL( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'acfp_dual_range_slider':
					$render = new ACFP_Render_Dual_Range_Slider( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'image':
					$render = new ACFP_Render_Image( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'file':
					$render = new ACFP_Render_File( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'wysiwyg':
					$render = new ACFP_Render_WYSIWYG( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'oembed':
					$render = new ACFP_Render_Oembed( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'select':
					$render = new ACFP_Render_Select( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'checkbox':
					$render = new ACFP_Render_Checkbox( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'radio':
					$render = new ACFP_Render_Radio( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'button_group':
					$render = new ACFP_Render_Button_Group( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'true_false':
					$render = new ACFP_Render_True_False( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'link':
					$render = new ACFP_Render_Link( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'page_link':
					$render = new ACFP_Render_Page_Link( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'post_object':
					$render = new ACFP_Render_Post_Object( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'relationship':
					$render = new ACFP_Render_Relationship( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'taxonomy':
					$render = new ACFP_Render_Taxonomy( $this->acfp, $field_value, $a, $field_definitions );
					break;
				case 'user':
					$render = new ACFP_Render_User( $this->acfp, $field_value, $a, $field_definitions );
					break;
			}

			if ( null !== $render ) {
				$content = $render->get_html();
			}

			return $content;
		}
	}
}
