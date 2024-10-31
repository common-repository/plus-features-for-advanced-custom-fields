<?php
/**
 * Code for ACFP_Posts_Simple_Grid_Layout class
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders/module/posts
 */

if ( ! class_exists( 'ACFP_Posts_Simple_Grid_Layout' ) ) {

	/**
	 * Simple_Grid Posts Layout
	 *
	 * @author thewpcatalyst
	 * @since 1.4.0
	 */
	class ACFP_Posts_Simple_Grid_Layout extends ACFP_Posts_Layout {

		/**
		 * Initialize function
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function init() {
			$this->name = 'simple-grid';
		}

		/**
		 * Enqueues Stylesheet files.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function enqueue_styles() {
			if ( $this->is_data_set ) {
				acfp_enqueue_foundation_styles();
			}
		}

		/**
		 * Enqueues Javascript files.
		 *
		 * @since 1.4.0
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

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
			<div class="acfp-posts-simple-grid grid-x  grid-margin-x"   >
				<?php foreach ( $this->posts as $post ) : ?>
					<div class="cell small-12 medium-6 large-4 xlarge-3 columns" style="margin-bottom: 20px;">
					<?php $post_layout->set_data( $post, $this->field_value, $this->attrs, $this->field_definitions )->layout(); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php
		}

	}
}
