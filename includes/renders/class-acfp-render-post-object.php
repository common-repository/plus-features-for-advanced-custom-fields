<?php
/**
 * The file that defines post object field render behavior.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.3.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders
 */

if ( ! class_exists( 'ACFP_Render_Post_Object' ) ) {
	/**
	 * Renders post object field content
	 *
	 * @since 1.3.0
	 */
	class ACFP_Render_Post_Object extends ACFP_Render {
		/**
		 * Generate html content.
		 *
		 * @since 1.3.0
		 *
		 * @return void
		 */
		protected function generate() {
			$this->content = $this->generate_posts( $this->field_value );

		}

		/**
		 * Renders Posts
		 *
		 * @since 1.4.0
		 *
		 * @param  mixed $field_value field value being rendered.
		 *
		 * @return string
		 */
		protected function generate_posts( $field_value ) {
			ob_start();
			new ACFP_Posts_Layouts( $this->acfp, $field_value, $this->attrs, $this->field_definitions );
			return ob_get_clean();
		}
	}
}

