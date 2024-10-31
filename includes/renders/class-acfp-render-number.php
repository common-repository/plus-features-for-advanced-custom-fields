<?php
/**
 * The file that defines nunber field render behavior.
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
 * Renders number field content
 *
 * @since 1.2.0
 */
class ACFP_Render_Number extends ACFP_Render {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		$this->content = $this->get_number_render_content( $this->format, $this->field_value, $this->decimals, $this->decimal_separator, $this->thousands_separator );
	}

	/**
	 * Renders number content
	 *
	 * @since 1.2.0
	 *
	 * @param string $format format to be displayed.
	 * @param mixed  $field_value field value.
	 * @param string $decimals number of decimals.
	 * @param string $decimal_separator character to be used as decimal separator.
	 * @param string $thousands_separator character to be used as thousand separator.
	 * @return string
	 */
	public function get_number_render_content( $format, $field_value, $decimals, $decimal_separator, $thousands_separator ) {
		if ( 'separators_decimals' === $format ) {
			$content = number_format( $field_value, $decimals, $decimal_separator, $thousands_separator );
		} else {
			$content = $field_value;
		}
		return $content;
	}
}
