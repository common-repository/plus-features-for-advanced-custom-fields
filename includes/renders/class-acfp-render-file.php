<?php
/**
 * The file that defines file field render behavior.
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
 * Renders file field content
 *
 * @since 1.2.0
 */
class ACFP_Render_File extends ACFP_Render {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		$this->content = $this->get_file_render_content(
			$this->field_value,
			$this->format,
			$this->link_text,
			$this->tag_class,
			$this->tag_id,
			$this->style
		);
	}

	/**
	 * Gets file html content to be rendered on front end.
	 *
	 * @since 1.2.0
	 *
	 * @param mixed  $field_value field value.
	 * @param string $format format.
	 * @param string $link_text link text.
	 * @param string $tag_class class.
	 * @param string $tag_id tag id.
	 * @param string $style tag style.
	 * @return string
	 */
	public function get_file_render_content( $field_value, string $format, string $link_text, string $tag_class, string $tag_id, string $style ) {
		if ( is_int( $field_value ) ) {
			// image set to return Image ID.
			$field_value = acfp_get_attachment( $field_value );
		}
		if ( is_array( $field_value ) ) {
			if ( ! $link_text ) {
				$link_text = $field_value['filename'];
			}
			ob_start();
			?>
			<div class="acfp-file-container">
				<div class="file-icon">
					<img data-name="icon" src="<?php echo esc_url( $field_value['icon'] ); ?>" alt=""/>
				</div>
				<div class="file-info">
					<p>
						<strong data-name="title"><?php echo esc_html( $field_value['title'] ); ?></strong>
					</p>
					<p>
						<strong><?php esc_html_e( 'File name', 'acfp' ); ?>:</strong> 
						<a data-name="filename" href="<?php echo esc_url( $field_value['url'] ); ?>" target="_blank"><?php echo esc_html( $link_text ); ?></a>
					</p>
					<p>
						<strong><?php esc_html_e( 'File size', 'acfp' ); ?>:</strong>
						<span data-name="filesize"><?php echo esc_html( size_format( $field_value['filesize'] ) ); ?></span>
					</p>
				</div>
			</div>
			<?php
			$content = ob_get_clean();

		} elseif ( is_string( $field_value ) ) {
			if ( ! $link_text ) {
				$link_text = $field_value;
			}
			$content = acfp_get_link_tag_html( $field_value, $link_text, $tag_class, $tag_id, $style );
		}
		return $content;

	}

}
