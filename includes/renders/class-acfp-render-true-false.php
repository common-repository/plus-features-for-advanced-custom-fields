<?php
/**
 * The file that defines text field render behavior.
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
 * Renders Text field content
 *
 * @since 1.2.0
 */
class ACFP_Render_True_False extends ACFP_Render {
	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		if ( true === $this->field_value ) {
			$this->content = $this->checked_content;
		} else {
			$this->content = $this->unchecked_content;
		}
	}
}
