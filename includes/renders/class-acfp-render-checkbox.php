<?php
/**
 * The file that defines checkbox field render behavior.
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
 * Renders checkbox field content
 *
 * @since 1.2.0
 */
class ACFP_Render_Checkbox extends ACFP_Render {

	/**
	 * Method validates values and set the default values if wrong value is supplied.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function validate_and_set_defaults() {
		if ( 'ordered_list' !== $this->format && 'unordered_list' !== $this->format ) {
			$this->format = 'unordered_list';
		}
		if ( 'values' !== $this->display && 'labels' !== $this->display ) {
			$this->display = 'labels';
		}
	}

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		if ( empty( $this->field_value ) && ! empty( $this->empty_message ) ) {
			$this->content = $this->empty_message;
			return;
		}

		if ( is_array( $this->field_value ) ) {
			if ( array_key_exists( 'value', $this->field_value ) ) {
				// not multiselect.
				if ( 'values' === $this->display ) {
					$this->content = $this->field_value['value'];
				} else {
					$this->content = $this->field_value['label'];
				}
			} else {
				// multiselect.
				$values = array();
				$labels = array();
				foreach ( $this->field_value as $value ) {
					if ( is_array( $value ) ) {
						// with return set to array.
						array_push( $values, $value['value'] );
						array_push( $labels, $value['label'] );
					} else {
						// value/label.
						array_push( $values, $value );
						array_push( $labels, $value );
					}
				}
				if ( 'ordered_list' === $this->format && 'values' === $this->display ) {
					// ordered_list_values.
					$this->content = acfp_get_ordered_list( $values, $this->tag_id, array( $this->tag_class ), $this->style, $this->hide_if_empty, $this->ordered_list_type );
				} elseif ( 'ordered_list' === $this->format && 'labels' === $this->display ) {
					// ordered_list_labels.
					$this->content = acfp_get_ordered_list( $labels, $this->tag_id, array( $this->tag_class ), $this->style, $this->hide_if_empty, $this->ordered_list_type );
				} elseif ( 'unordered_list' === $this->format && 'values' === $this->display ) {
					// unordered_list_values.
					$this->content = acfp_get_unordered_list( $values, $this->tag_id, array( $this->tag_class ), $this->style, $this->hide_if_empty );
				} elseif ( 'unordered_list' === $this->format && 'labels' === $this->display ) {
					// Default: unordered_list_labels.
					$this->content = acfp_get_unordered_list( $labels, $this->tag_id, array( $this->tag_class ), $this->style, $this->hide_if_empty );
				}
			}
		}
	}
}
