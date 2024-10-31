<?php
/**
 * The file that defines radio field render behavior.
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
 * Renders radio field content
 *
 * @since 1.2.0
 */
class ACFP_Render_Radio extends ACFP_Render {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		if ( is_array( $this->field_value ) && array_key_exists( 'value', $this->field_value ) ) {
			if ( 'values' === $this->display ) {
				$this->content = $this->field_value['value'];
			} else {
				$this->content = $this->field_value['label'];
			}
		} elseif ( is_string( $this->field_value ) ) {
			$this->content = $this->field_value;
		} else {
			$this->content = '';
		}
	}

}
