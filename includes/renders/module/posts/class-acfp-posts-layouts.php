<?php
/**
 * Code for ACFP_Posts_Layouts class
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders/module/posts
 */

if ( ! class_exists( 'ACFP_Posts_Layouts' ) ) {
	/**
	 * Contains common functions in posts layouts.
	 *
	 * The posts layout classes will be extending this.
	 *
	 * @author thewpcatalyst
	 * @since 1.4.0
	 */
	class ACFP_Posts_Layouts {
		/**
		 * Holds ACFP instance.
		 *
		 * @since 1.4.0
		 *
		 * @var ACFP
		 */
		protected ACFP $acfp;



		/**
		 * Whether multiple posts are being rendered.
		 *
		 * @since 1.4.0
		 *
		 * @var boolean
		 */
		public bool $is_multiple;

		/**
		 * Posts layout
		 *
		 * @since 1.4.0
		 *
		 * @var string
		 */
		public string $posts_layout;

		/**
		 * Post layout
		 *
		 * @since 1.4.0
		 *
		 * @var string
		 */
		public string $post_layout;

		/**
		 * Field value.
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
		 * Constructor for the class.
		 *
		 * @since 1.4.0
		 *
		 * @param  ACFP  $acfp Instance of ACFP.
		 * @param  mixed $field_value field value.
		 * @param  mixed $attrs array for attributes.
		 * @param  mixed $field_definitions field settings from ACF.
		 *
		 * @return void
		 */
		public function __construct( ACFP $acfp, $field_value, $attrs, $field_definitions ) {
			$this->init();
			$this->acfp              = $acfp;
			$this->field_value       = $field_value;
			$this->attrs             = $attrs;
			$this->field_definitions = $field_definitions;

			if ( count( $field_value ) > 1 ) {
				$this->is_multiple = true;
			} else {
				$this->is_multiple = false;
			}
			$this->posts_layout = $attrs['posts_layout'];
			$this->post_layout  = $attrs['post_layout'];

			$this->layout_selector();

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
		 * Contains logic for selecting a layout.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		private function layout_selector() {
			$acfp        = $this->acfp;
			$post_layout = $acfp->get_post_layout_by_name( $this->post_layout );
			if ( 'false' === $this->posts_layout ) {
				// no posts layout. So the post layout is displayed directly.
				if ( is_array( $this->field_value ) ) {
					foreach ( $this->field_value as $value ) {
						$post = acfp_get_post( $value );
						$post_layout->set_data( $post, $this->field_value, $this->attrs, $this->field_definitions )->layout();
					}
				} else {
					$post = acfp_get_post( $this->field_value );
					$post_layout->set_data( $post, $this->field_value, $this->attrs, $this->field_definitions )->layout();
				}
			} else {
				$posts_layout = $acfp->get_posts_layout_by_name( $this->posts_layout );
				if ( ! $posts_layout ) {
					// layout not found. set default.
					$posts_layout = $acfp->get_posts_layout_by_name( 'simple-grid' );
				}

				if ( ! $post_layout ) {
					// layout not found. set default layout.
					$post_layout = $acfp->get_post_layout_by_name( 'simple-card' );
				}

				$posts_layout->set_data( $this->field_value, $this->attrs, $this->field_definitions, $post_layout )->layout();
			}

		}
	}
}
