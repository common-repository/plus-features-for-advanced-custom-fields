<?php
/**
 * ACFP_Location_Taxonomy_Term_Parent File.
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

if ( ! class_exists( 'ACFP_Location_Taxonomy_Term_Parent' ) ) :

	/**
	 * Location Taxonomy Term class.
	 *
	 * @author thewpcatalyst
	 * @since 1.4.0
	 */
	class ACFP_Location_Taxonomy_Term_Parent extends ACF_Location {

		/**
		 * Initializes props.
		 *
		 * @since   1.4.0
		 *
		 * @return  void
		 */
		public function initialize() {
			$this->name        = 'taxonomy_term_parent';
			$this->label       = __( 'Taxonomy Term Parent', 'acfp' );
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

			$result = $this->term_has_specific_parent( $tag_id, $rule['value'] );

			// Return result taking into account the operator type.
			if ( '!=' === $rule['operator'] ) {
				return ! $result;
			}
			return $result;
		}

		/**
		 * Check if a term belongs to a particular parent.
		 *
		 * @since 1.4.0
		 *
		 * @param  mixed $term_id Id of the term to be checked.
		 * @param  mixed $parent_term_id The parent term ID.
		 *
		 * @return boolean
		 */
		public function term_has_specific_parent( $term_id, $parent_term_id ) {
			$term = get_term( $term_id );
			if ( is_wp_error( $term ) ) {
				return false;
			}
			return ( $term->parent === $parent_term_id );
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
