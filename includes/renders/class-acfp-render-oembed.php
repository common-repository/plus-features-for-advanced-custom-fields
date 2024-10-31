<?php
/**
 * The file that defines oembed field render behavior.
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
 * Renders oembed field content
 *
 * @since 1.2.0
 */
class ACFP_Render_Oembed extends ACFP_Render {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		$this->content = $this->get_oembed_render_content( $this->field_value );
	}

	/**
	 * Returns oembed render content.
	 *
	 * @since 1.2.0
	 *
	 * @param string $field_value field value.
	 * @return string
	 */
	public function get_oembed_render_content( $field_value ) {
		return $field_value;
	}

}
