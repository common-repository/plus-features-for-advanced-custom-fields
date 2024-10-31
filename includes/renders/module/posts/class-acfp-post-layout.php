<?php
/**
 * Code for Post Layout class.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders/module/posts
 */

if ( ! class_exists( 'ACFP_Post_Layout' ) ) {

	/**
	 * Contains common functions in post layout
	 *
	 * @author thewpcatalyst
	 * @since 1.4.0
	 */
	class ACFP_Post_Layout extends ACFP_Layout implements ACFP_Post_Layout_Interface {

		/**
		 * Holds WP_Post to be rendered.
		 *
		 * @since 1.4.0
		 *
		 * @var WP_Post
		 */
		protected WP_Post $post;

		/**
		 * Whether layout data has been set or not.
		 *
		 * @since 1.4.0
		 *
		 * @var boolean
		 */
		public bool $is_data_set = false;

		/**
		 * Constructor that fires init().
		 *
		 * @since 1.4.0
		 */
		public function __construct() {
			$this->init();
		}

		/**
		 * Sets data to be used in layout rendering.
		 *
		 * @since 1.4.0
		 *
		 * @param  WP_Post $post Post to be rendered.
		 * @param  mixed   $field_value retrieved field value.
		 * @param  mixed   $a shortcode attributes.
		 * @param  mixed   $field_definitions detail info about the field on ACF.
		 *
		 * @return ACFP_Post_Layout
		 */
		public function set_data( WP_Post $post, $field_value, $a, $field_definitions ) {
			$this->reset_data();
			$this->post        = $post;
			$this->is_data_set = true;
			$this->after_setting_data();
			return $this;// used for chaining.
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
		 * Will be called fired after construct to initialize some variables from extending classes.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function init() {

		}

		/**
		 * Returns terms associated with a post.
		 *
		 * @since 1.4.0
		 *
		 * @return void // todo: To add logic to return terms.
		 */
		public function get_terms() {

		}

		/**
		 * Returns post ID.
		 *
		 * @since 1.4.0
		 *
		 * @return int
		 */
		public function get_post_ID() {
			$post = $this->post;
			return $post->ID;
		}

		/**
		 * Returns post title.
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public function get_post_title() {
			$post = $this->post;
			return $post->post_title;
		}

		/**
		 * Return post content.
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public function get_post_content() {
			$post = $this->post;
			return get_the_content( '', false, $post );
		}

		/**
		 * Returns post excerpt
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public function get_post_excerpt() {
			$post    = $this->post;
			$excerpt = get_the_excerpt( $post );
			// phpcs:ignore WordPress.NamingConventions.ValidHookName
			$excerpt_length  = apply_filters( 'acfp/excerpt_length', 100 );
			$trimmed_excerpt = strlen( $excerpt ) > $excerpt_length ? substr( $excerpt, 0, $excerpt_length ) . '...' : $excerpt;
			return $trimmed_excerpt;
		}

		/**
		 * Returns post URL
		 *
		 * @since 1.4.0
		 *
		 * @return string|false
		 */
		public function get_post_url() {
			return get_permalink( $this->post );
		}

		/**
		 * Returns featured image ID
		 *
		 * @since 1.4.0
		 *
		 * @return int|false
		 */
		public function get_featured_image_id() {
			return get_post_thumbnail_id( $this->post );
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
		 * Returns responsive featured image.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function responsive_featured_image() {

			// Get the featured image ID.
			$featured_image_id = get_post_thumbnail_id( $this->post );

			// Check if there's a featured image.
			if ( $featured_image_id ) {
				// Get the responsive image HTML.
				echo wp_get_attachment_image(
					$featured_image_id, // Attachment ID.
					'large', // Image size (you can change this to any registered image size).
					false, // No link.
					array(
						'class' => 'acfp-featured-image', // Add your responsive image class here.
					)
				);
			}
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
			$this->is_data_set = false;
		}


	}
}
