<?php
/**
 * Code for ACFP_Posts_FBER_List_Layout class
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders/module/posts
 */

if ( ! class_exists( 'ACFP_Posts_FBER_List_Layout' ) ) {

	/**
	 * Layout for Featured Byline Excerpt Read more(FBER) list.
	 *
	 * @author thewpcatalyst
	 * @since 1.4.0
	 */
	class ACFP_Posts_FBER_List_Layout extends ACFP_Posts_Layout {

		/**
		 * Initialize function
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function init() {
			$this->name = 'fber-list';
		}

		/**
		 * Renders the layout
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function layout() {
			$post_layout = $this->post_layout;
			?>
			<div class="acfp-posts-fber-list">
				<?php foreach ( $this->posts as $post ) : ?>
					<div class="post">
					<?php $post_layout->set_data( $post, $this->field_value, $this->attrs, $this->field_definitions )->layout(); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php
		}

	}
}
