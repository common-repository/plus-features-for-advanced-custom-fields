<?php
/**
 * Code for ACFP_Post_Simple_Card_Layout class
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders/module/posts
 */

if ( ! class_exists( 'ACFP_Post_Simple_Card_Layout' ) ) {

	/**
	 * Simple Card Layout for a post
	 *
	 * @author thewpcatalyst
	 * @since 1.4.0
	 */
	class ACFP_Post_Simple_Card_Layout extends ACFP_Post_Layout {

		/**
		 * Fired in construct to initialize some variables
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function init() {
			$this->name = 'simple-card';
		}

		/**
		 * Renders the layout
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function layout() {
			$post_id      = $this->get_post_ID();
			$post_title   = $this->get_post_title();
			$post_content = $this->get_post_content();
			$post_excerpt = $this->get_post_excerpt();
			$post_url     = $this->get_post_url();
			?>
			<div class="acfp-post-simple-card post-<?php echo esc_attr( $post_id ); ?>">
				<div class="post-featured-image">
					<a href="<?php echo esc_attr( $post_url ); ?>"><?php $this->responsive_featured_image(); ?></a>	
				</div>
				<div class="post-terms">	
				</div>
				<div class="post-title">
					<h3>
					<a href="<?php echo esc_attr( $post_url ); ?>"><?php echo esc_html( $post_title ); ?></a>
					</h3>
				</div>
				<div class="post-excerpt">
					<?php
						echo wp_kses_post( $post_excerpt );
					?>
				</div>
				<div class="post-read-more">
					<a href="<?php echo esc_attr( $post_url ); ?>"><?php esc_html_e( 'Read More', 'acfp' ); ?> </a>
				</div >
			</div >
			<?php
		}

	}
}
