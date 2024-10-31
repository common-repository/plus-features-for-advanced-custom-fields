<?php
/**
 * Code for ACFP_Posts_Layout class
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders/module/posts
 */

if ( ! class_exists( 'ACFP_Posts_Layout' ) ) {
	/**
	 * Defines common functions for all posts layouts.
	 *
	 * @author thewpcatalyst
	 * @since 1.4.0
	 */
	class ACFP_Posts_Layout extends ACFP_Layout {

		/**
		 * Holds WP_Post objects to be rendered
		 *
		 * @since 1.4.0
		 *
		 * @var array
		 */
		public array $posts = array();

		/**
		 * Field value
		 *
		 * @since 1.4.0
		 *
		 * @var mixed
		 */
		public $field_value;

		/**
		 * Shortcode attributes.
		 *
		 * @since 1.4.0
		 *
		 * @var mixed
		 */
		public $attrs;

		/**
		 * Field definitions/settings.
		 *
		 * @since 1.4.0
		 *
		 * @var mixed
		 */
		public $field_definitions;

		/**
		 * Post layout
		 *
		 * @since 1.4.0
		 *
		 * @var string
		 */
		public $post_layout;

		/**
		 * Whether layout data has been set or not.
		 *
		 * @since 1.4.0
		 *
		 * @var boolean
		 */
		public bool $is_data_set = false;

		/**
		 * Sets data to be used in rendering the layout.
		 *
		 * @since 1.4.0
		 *
		 * @param  mixed $field_value retrieved field value.
		 * @param  mixed $attrs shortcode attributes.
		 * @param  mixed $field_definitions detailed info about the field on ACF.
		 * @param  mixed $post_layout layout to render a post.
		 *
		 * @return ACFP_Posts_Layout
		 */
		public function set_data( $field_value, $attrs, $field_definitions, $post_layout ) {
			$this->reset_data();// reset data before adding new one.
			$this->field_value       = $field_value;
			$this->attrs             = $attrs;
			$this->field_definitions = $field_definitions;
			$this->post_layout       = $post_layout;
			$this->is_data_set       = true;
			$this->convert_field_value_to_posts();
			$this->after_setting_data();
			return $this;
		}

		/**
		 * Fired after setting layout data.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function after_setting_data() {

		}

		/**
		 * Renders the layout
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function layout() {

		}

		/**
		 * Converts this class $field_value and to WP_Post object(s) and adds the post using this add_post().
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function convert_field_value_to_posts() {

			if ( $this->field_value ) {
				if ( is_array( $this->field_value ) ) {
					foreach ( $this->field_value as $post ) {
						$post = acfp_get_post( $post );
						$this->add_post( $post );
					}
				} else {
					$post = acfp_get_post( $this->field_value );
					$this->add_post( $post );
				}
			}
		}

		/**
		 * Adds a WP_Post object to this class $posts variable.
		 *
		 * @since 1.4.0
		 *
		 * @param  WP_Post $post instance of WP_Post.
		 *
		 * @return void
		 */
		public function add_post( WP_Post $post ) {
			$this->posts[] = $post;
		}

		/**
		 * Resets data before adding new data
		 *
		 * Useful in variables that are not assigned directly in set_data() method. This is useful in arrays.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function reset_data() {
			$this->posts       = array();
			$this->is_data_set = false;
		}

	}
}
