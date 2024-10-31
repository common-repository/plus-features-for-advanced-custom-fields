<?php
/**
 * The file that defines Dual_Range_Slider field render behavior.
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
 * Renders Dual_Range_Slider field content
 *
 * @since 1.2.0
 */
class ACFP_Render_Dual_Range_Slider extends ACFP_Render {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		$this->content = $this->get_acfp_dual_range_slider_render_content( $this->format, $this->field_value );
	}

	/**
	 * Function to get dual range slider render content
	 *
	 * @since 1.2.0
	 *
	 * @param string $format format to be displayed.
	 * @param string $field_value field value.
	 * @return string
	 */
	public function get_acfp_dual_range_slider_render_content( $format, $field_value ) {
		if ( 'min' === $format ) {
			if ( array_key_exists( 'min', $field_value ) ) {
				$content = esc_html( $field_value['min'] );
			} else {
				$content = '';
			}
		} elseif ( 'max' === $format ) {
			if ( array_key_exists( 'max', $field_value ) ) {
				$content = esc_html( $field_value['max'] );
			} else {
				$content = '';
			}
		} else {
			$content = implode( ', ', $field_value );
		}
		return $content;
	}
}
