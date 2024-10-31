<?php
/**
 * The file that defines page link field render behavior.
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

if ( ! class_exists( 'ACFP_Render_Page_Link' ) ) {
	/**
	 * Renders page link field content
	 *
	 * @since 1.3.0
	 */
	class ACFP_Render_Page_Link extends ACFP_Render {

		/**
		 * Method validates values and set the default values if wrong value is supplied.
		 *
		 * @since 1.2.0
		 *
		 * @return void
		 */
		protected function validate_and_set_defaults() {
			if ( is_array( $this->field_value ) ) {
				if ( 'ordered_list' !== $this->format && 'unordered_list' !== $this->format ) {
					$this->format = 'unordered_list';
				}
			}
			if ( 'values' !== $this->display && 'page_title' !== $this->display ) {
				$this->display = 'page_title';
			}
		}
		/**
		 * Generate html content.
		 *
		 * @since 1.2.0
		 *
		 * @return void
		 */
		protected function generate() {
			if ( is_string( $this->field_value ) ) {
				if ( 'link' === $this->format && '' === $this->link_text && 'post_title' === $this->display ) {
					$post_title = acfp_get_post_title_from_url( $this->field_value );
					if ( $post_title ) {
						$this->link_text = $post_title;
					} else {
						$this->link_text = $value;
					}
				}
				$this->content = acfp_get_url_render_content( 'link', $this->field_value, $this->link_text, $this->tag_class, $this->tag_id, $this->style, $this->rel );
				?>
				<?php

			} elseif ( is_array( $this->field_value ) ) {
				$links = array();
				foreach ( $this->field_value as $value ) {
					$post_title = acfp_get_post_title_from_url( $value );
					if ( $post_title ) {
						$this->link_text = $post_title;
					} else {
						$this->link_text = $value;
					}
					if ( 'unordered_list' === $this->format ) {
						$links[] = acfp_get_url_render_content( 'link', $value, $this->link_text, $this->tag_class, $this->tag_id, $this->style, $this->rel );
					}
				}
				$this->content = acfp_get_unordered_list( $links, $this->tag_id, array( $this->tag_class ), $this->style, $this->hide_if_empty );
			}
		}
	}
}
