<?php
/**
 * The file that defines link field render behavior.
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
 * Renders link field content
 *
 * @since 1.2.0
 */
class ACFP_Render_Link  extends ACFP_Render {

	/**
	 * Holds generated html code.
	 *
	 * @since 1.2.0
	 *
	 * @var string
	 */
	protected string $content;

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		$this->content = '';
		if ( is_array( $this->field_value ) ) {
			$rel_content        = acfp_get_rel_attr( array( $this->field_value['nofollow'] ), false );
			$allowed_attributes = array(
				'rel' => array(),
			);
			ob_start();
			?>
			<a href="<?php echo esc_url( $this->field_value['url'] ); ?>" target="<?php echo esc_attr( $this->field_value['target'] ); ?>"  <?php echo wp_kses( $rel_content, $allowed_attributes ); ?>><?php echo esc_html( $this->field_value['title'] ); ?></a>
			<?php
			$this->content = ob_get_clean();
		} elseif ( is_string( $this->field_value ) ) {
			$this->content = acfp_get_url_render_content( $this->format, $this->field_value, $this->link_text, $this->tag_class, $this->tag_id, $this->style );
		}
	}

}
