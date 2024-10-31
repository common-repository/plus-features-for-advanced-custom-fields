<?php
/**
 * The file that defines URL field render behavior.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.2.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders
 */

/**
 * Renders URL field content
 *
 * @since 1.2.0
 */
class ACFP_Render_URL extends ACFP_Render {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		if ( is_string( $this->field_value ) ) {
			$this->content = acfp_get_url_render_content( $this->format, $this->field_value, $this->link_text, $this->tag_class, $this->tag_id, $this->style, $this->rel );
		} else {
			$this->content = '';
		}
	}
}
