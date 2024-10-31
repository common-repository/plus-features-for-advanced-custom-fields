<?php

class ACFP_ACF_Link_Field extends \acf_field_link {

	function render_field( $field ) {
		// vars.
		$div = array(
			'id'    => $field['id'],
			'class' => $field['class'] . ' acf-link',
		);

		// render scripts/styles.
		acf_enqueue_uploader();

		// get link.
		$link = $this->get_link( $field['value'] );

		// classes.
		if ( $link['url'] ) {
			$div['class'] .= ' -value';
		}

		if ( '_blank' === $link['target'] ) {
			$div['class'] .= ' -external';
		}
		?>
<div <?php echo acf_esc_attrs( $div ); ?>>

<div class="acf-hidden">
	<a class="link-node" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>" nofollow="<?php echo esc_attr( $link['nofollow'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
		<?php foreach ( $link as $k => $v ) : ?>
			<?php
			acf_hidden_input(
				array(
					'class' => "input-$k",
					'name'  => $field['name'] . "[$k]",
					'value' => $v,
				)
			);
			?>
	<?php endforeach; ?>
</div>

<a href="#" class="button" data-name="add" target=""><?php _e( 'Select Link', 'acf' ); ?></a>

<div class="link-wrap">
	<span class="link-title"><?php echo esc_html( $link['title'] ); ?></span>
	<a class="link-url" href="<?php echo esc_url( $link['url'] ); ?>" target="_blank"><?php echo esc_html( $link['url'] ); ?></a>
	<i class="acf-icon -link-ext acf-js-tooltip" title="<?php _e( 'Opens in a new window/tab', 'acf' ); ?>"></i><a class="acf-icon -pencil -clear acf-js-tooltip" data-name="edit" href="#" title="<?php _e( 'Edit', 'acf' ); ?>"></a><a class="acf-icon -cancel -clear acf-js-tooltip" data-name="remove" href="#" title="<?php _e( 'Remove', 'acf' ); ?>"></a>
</div>

</div>
		<?php

	}

	/**
	 * Gets links from db value..
	 *
	 * @param string $value field value.
	 * @return array
	 */
	function get_link( $value = '' ) {

		// vars.
		$link = array(
			'title'    => '',
			'url'      => '',
			'target'   => '',
			'nofollow' => '',
		);

		// array (ACF 5.6.0)
		if ( is_array( $value ) ) {

			$link = array_merge( $link, $value );

			// post id (ACF < 5.6.0)
		} elseif ( is_numeric( $value ) ) {

			$link['title'] = get_the_title( $value );
			$link['url']   = get_permalink( $value );

			// string (ACF < 5.6.0)
		} elseif ( is_string( $value ) ) {

			$link['url'] = $value;

		}

		// return
		return $link;

	}
}


