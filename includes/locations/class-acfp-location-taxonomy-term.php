<?php
/**
 * ACFP_Location_Taxonomy_Term File.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/locations
 */

/**
 * Location Taxonomy Term class.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.4.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/locations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'ACFP_Location_Taxonomy_Term' ) ) :

	/**
	 * Location Taxonomy Term class.
	 *
	 * @author thewpcatalyst
	 * @since 1.4.0
	 */
	class ACFP_Location_Taxonomy_Term extends ACF_Location {

		/**
		 * Initializes props.
		 *
		 * @since   1.4.0
		 *
		 * @return  void
		 */
		public function initialize() {
			$this->name        = 'taxonomy_term';
			$this->label       = __( 'Taxonomy Term', 'acfp' );
			$this->category    = 'forms';
			$this->object_type = 'term';
		}

		/**
		 * Retrieves tag Id from the URL
		 *
		 * The method should be used withing this class as utilizes $_GET.
		 *
		 * @since 1.4.0
		 *
		 * @return int|false
		 */
		private function get_tag_id_from_url() {
			$url_parameters = $_GET;
			if ( isset( $url_parameters['tag_ID'] ) ) {
				$tag_id = absint( $url_parameters['tag_ID'] );
				return $tag_id;
			}
			return false;// on fail.
		}


		/**
		 * Matches the provided rule against the screen args returning a bool result.
		 *
		 * @since   1.4.0
		 *
		 * @param   array $rule The location rule.
		 * @param   array $screen The screen args.
		 * @param   array $field_group The field group settings.
		 * @return  bool
		 */
		public function match( $rule, $screen, $field_group ) {
			if ( isset( $screen['taxonomy'] ) ) {
				$taxonomy = $screen['taxonomy'];
				$tag_id   = $this->get_tag_id_from_url();
				if ( ! $tag_id ) {
					return false;
				}
			} else {
				return false;
			}

			return $this->compare_to_rule( $tag_id, $rule );
		}

		/**
		 * Returns an array of possible values for this rule type.
		 *
		 * @since   1.4.0
		 *
		 * @param   array $rule A location rule.
		 * @return  array
		 */
		public function get_values( $rule ) {
			return acfp_get_taxonomy_terms();
		}


	}
endif; // class_exists check.
