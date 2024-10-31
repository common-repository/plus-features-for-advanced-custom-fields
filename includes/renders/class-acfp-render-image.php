<?php
/**
 * The file that defines image field render behavior.
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
 * Renders image field content
 *
 * @since 1.2.0
 */
class ACFP_Render_Image extends ACFP_Render {

	/**
	 * Generate html content.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	protected function generate() {
		$this->content = $this->get_image_render_content(
			$this->field_value,
			$this->tag_class,
			$this->tag_id,
			$this->alt,
			$this->width,
			$this->height,
			$this->style,
			$this->size,
			$this->media_sizes
		);
	}

	/**
	 * Function to get image render content
	 *
	 * @since 1.2.0
	 *
	 * @param string $field_value field value.
	 * @param string $tag_class tag class.
	 * @param string $tag_id tag id.
	 * @param string $alt alternative text incase image fails to load.
	 * @param int    $width image width.
	 * @param int    $height image height.
	 * @param string $style tag style.
	 * @param string $size WordPress thumbnail size to be rendered.
	 * @param string $media_sizes media sizes https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images.
	 * @return string
	 */
	public function get_image_render_content( $field_value, $tag_class, $tag_id, $alt, $width, $height, $style, $size, $media_sizes ) {
		$content     = '';
		$image_width = $width;
		if ( is_int( $field_value ) ) {
			// image set to return Image ID.
			$field_value = acfp_get_attachment( $field_value );
		}

		if ( is_array( $field_value ) ) {
			$url = $field_value['url'];
			if ( '' === $alt ) {
				$alt = $field_value['alt'];
			}

			$sizes               = $field_value['sizes'];
			$sizes               = $this->group_wordpress_image_sizes_with_their_sizes( $sizes );
			$srcset              = '';
			$srcset_added_widths = array();// init array of added widths to srcset.
			foreach ( $sizes as $size_array ) {
				$src_url       = $size_array['value'];
				$size_from_url = $this->extract_image_size_from_url( $src_url );// size extracted from URL.
				$w             = '';
				if ( $size_from_url ) {// size from url is given priority.
					$w = $size_from_url['width'] . 'w';
				} else {
					$w = $size_array['width_value'] . 'w';
				}
				if ( ! in_array( array( $src_url => $w ), $srcset_added_widths, true ) ) {
					array_push( $srcset_added_widths, array( $src_url => $w ) );
				}
			}
			$sizes_count = count( $srcset_added_widths );

			for ( $i = 0;$i < $sizes_count;$i++ ) {

				if ( 0 === $i ) {
					// first item.
					foreach ( $srcset_added_widths[ $i ] as $thumb_url => $width ) {
						$srcset .= $thumb_url . ' ' . $width;
					}
				} else {
					foreach ( $srcset_added_widths[ $i ] as $thumb_url => $width ) {
						$srcset .= ', ' . $thumb_url . ' ' . $width;
					}
				}
			}
			$content = '<img
			' . acfp_get_class_attr( array( $tag_class ) ) . ' 
			' . acfp_get_tag_id_attr( $tag_id ) . ' 
			srcset="' . esc_attr( $srcset ) . '"
			src="' . esc_url( $url ) . '"
			alt="' . esc_attr( $alt ) . '" 
			' . acfp_get_width_attr( $image_width ) . '
			' . acfp_get_height_attr( $height ) . '   
			' . $this->get_media_sizes_render_content( $media_sizes ) . ' 
			' . acfp_get_style_attr( $style ) . ' 
			"/>';
		} elseif ( is_string( $field_value ) ) {
			$content = '<img 
			' . acfp_get_class_attr( array( $tag_class ) ) . ' 
			' . acfp_get_tag_id_attr( $tag_id ) . ' 
			src="' . esc_attr( $field_value ) . '" 
			alt="' . esc_attr( $alt ) . '" 
			' . acfp_get_width_attr( $image_width ) . '
			' . acfp_get_height_attr( $height ) . ' 
			' . acfp_get_style_attr( $style ) . '/>';
		}

		return $content;

	}

	/**
	 * Groups returned images urls with their sizes.
	 *
	 * @since 1.2.0
	 *
	 * @param array $sizes sizes to be grouped.
	 * @return array
	 */
	public function group_wordpress_image_sizes_with_their_sizes( $sizes ) {
		$result = array();
		$keys   = array_keys( $sizes );
		$count  = count( $keys );

		for ( $i = 0; $i < $count; $i += 3 ) {
			$key          = $keys[ $i ];
			$value        = $sizes[ $key ];
			$width_key    = $keys[ $i + 1 ];
			$width_value  = $sizes[ $width_key ];
			$height_key   = $keys[ $i + 2 ];
			$height_value = $sizes[ $height_key ];

			$result[] = array(
				'key'          => $key,
				'value'        => $value,
				'width_key'    => $width_key,
				'width_value'  => $width_value,
				'height_key'   => $height_key,
				'height_value' => $height_value,
			);
		}

		return $result;
	}


	/**
	 * Extracts image size from url.
	 *
	 * @since 1.2.0
	 *
	 * @param string $url WordPress image url.
	 * @return array|false
	 */
	public function extract_image_size_from_url( $url ) {
		$parsed_url = wp_parse_url( $url );

		// Check if the URL is valid and contains a path.
		if ( ! $parsed_url || empty( $parsed_url['path'] ) ) {
			return false;
		}

		// Extract the filename from the path.
		$filename = basename( $parsed_url['path'] );

		// Use regular expressions to extract the image size.
		if ( preg_match( '/-(\d+)x(\d+)\./i', $filename, $matches ) ) {
			$width  = $matches[1];
			$height = $matches[2];
			return array(
				'width'  => $width,
				'height' => $height,
			);
		} else {
			return false;
		}
	}

	/**
	 * Function to return media size render content where possible.
	 *
	 * @since 1.2.0
	 *
	 * @param string $media_sizes media sizes.
	 * @return string
	 */
	public function get_media_sizes_render_content( string $media_sizes ) {
		if ( '' !== $media_sizes && false !== $media_sizes ) {
			$media_sizes = 'sizes="' . esc_attr( $media_sizes ) . '" ';
		}
		return $media_sizes;
	}
}
