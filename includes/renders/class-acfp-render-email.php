<?php
/**
 * The file that defines email field render behavior.
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
 * Renders email field content
 *
 * @since 1.2.0
 */
class ACFP_Render_Email extends ACFP_Render {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		$this->content = $this->get_email_render_content(
			$this->format,
			$this->field_value,
			$this->link_text,
			$this->tag_class,
			$this->tag_id,
			$this->style
		);
	}

	/**
	 * Function to get email render content
	 *
	 * @since 1.2.0
	 *
	 * @param string $format format to be displayed.
	 * @param string $field_value field value.
	 * @param string $link_text text to be rendered on the page instead of the actual link.
	 * @param string $tag_class tag class.
	 * @param string $tag_id tag id.
	 * @param string $style tag style.
	 * @return string
	 */
	public function get_email_render_content( $format, $field_value, $link_text, $tag_class, $tag_id, $style ) {
		if ( 'link' === $format ) {
			if ( ! $link_text ) {
				$link_text = $field_value;
			}
			$content = acfp_get_link_tag_html( $field_value, $link_text, $tag_class, $tag_id, $style );
		} else {
			$content = $field_value;
		}
		return $content;
	}

}
