<?php
/**
 * The file that defines rendering interface
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since 1.2.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders
 */

/**
 * Interface to generate render html content.
 *
 * @since 1.2.0
 */
interface ACFP_Render_Field_Type {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 */
	public function generate();
}
