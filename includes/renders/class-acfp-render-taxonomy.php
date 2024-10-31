<?php
/**
 * The file that defines taxonomy field render behavior.
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

/**
 * Renders Taxonomy field content
 *
 * @since 1.3.0
 */
class ACFP_Render_Taxonomy extends ACFP_Render {
	/**
	 * Generate html content.
	 *
	 * @since 1.3.0
	 *
	 * @return void
	 */
	protected function generate() {
		$this->content = $this->field_value;
	}
}
