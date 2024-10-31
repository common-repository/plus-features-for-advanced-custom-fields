<?php
/**
 * The file that defines acfp global functions
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.0.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes
 */

if ( ! function_exists( 'acfp_get_post_id' ) ) {
	/**
	 * Returns post id and false incase of an error.
	 *
	 * @since 1.0.0
	 *
	 * @return int|false
	 */
	function acfp_get_post_id() {
		return get_the_ID();
	}
}

if ( ! function_exists( 'acfp_get_field_definitions' ) ) {
	/**
	 * Gets fields definition by field name or field key and post ID
	 *
	 * @since 1.0.0
	 *
	 * @param string $field_name_or_key Field name or key.
	 * @param mixed  $post_id post ID.
	 * @return array|false
	 */
	function acfp_get_field_definitions( $field_name_or_key, $post_id ) {
		$groups = acf_get_field_groups( array( 'post_id' => $post_id ) );
		foreach ( $groups as $group ) {
			$fields = acf_get_fields( $group['key'] );
			foreach ( $fields as $field ) {
				if ( $field['name'] === $field_name_or_key || $field['key'] === $field_name_or_key ) {
					return $field;
				}
			}
		}
		return false;
	}
}


if ( ! function_exists( 'acfp_get_attachment' ) ) {
	/**
	 * Function to get attachment details in array from ID
	 *
	 * @since 1.1.0
	 *
	 * @param integer $attachment_id attachment ID.
	 * @return array|false
	 */
	function acfp_get_attachment( int $attachment_id ) {
		if ( function_exists( 'acf_get_attachment' ) ) {
			return acf_get_attachment( $attachment_id );
		}
		return false;
	}
}


// helpers in render.
if ( ! function_exists( 'acfp_get_style_attr' ) ) {
	/**
	 * Function to return style render content where possible.
	 *
	 * @since 1.2.0
	 *
	 * @param string $style tag class.
	 * @return string
	 */
	function acfp_get_style_attr( string $style ) {
		if ( '' !== $style && false !== $style ) {
			$style = 'style="' . esc_attr( $style ) . '" ';
		}
		return $style;
	}
}

if ( ! function_exists( 'acfp_get_tag_id_attr' ) ) {
	/**
	 * Function to return tag id render content where possible.
	 *
	 * @since 1.2.0
	 *
	 * @param string $tag_id tag id.
	 * @return string
	 */
	function acfp_get_tag_id_attr( string $tag_id ) {
		if ( '' !== $tag_id && false !== $tag_id ) {
			$tag_id = 'id="' . esc_attr( $tag_id ) . '" ';
		}
		return $tag_id;
	}
}

if ( ! function_exists( 'acfp_get_width_attr' ) ) {
		/**
		 * Function to return width render content where possible.
		 *
		 * @since 1.2.0
		 *
		 * @param string $width tag class.
		 * @return string
		 */
	function acfp_get_width_attr( string $width ) {
		if ( '' !== $width && false !== $width ) {
			$width = 'width="' . esc_attr( $width ) . '" ';
		}
		return $width;
	}
}

if ( ! function_exists( 'acfp_get_height_attr' ) ) {
	/**
	 * Function to return height render content where possible.
	 *
	 * @since 1.2.0
	 *
	 * @param string $height tag class.
	 * @return string
	 */
	function acfp_get_height_attr( string $height ) {
		if ( '' !== $height && false !== $height ) {
			$height = 'height="' . esc_attr( $height ) . '" ';
		}
		return $height;
	}
}

if ( ! function_exists( 'acfp_get_class_attr' ) ) {
	/**
	 * Function to return tag class render content where possible.
	 *
	 * @since 1.2.0
	 *
	 * @param array $classes tag classes.
	 * @return string
	 */
	function acfp_get_class_attr( array $classes ) {
		$classes_str = '';
		foreach ( $classes as $class ) {
			$class = trim( $class );
			if ( '' !== $class ) {
				$classes_str .= $class . ' ';
			}
		}
		$classes_str = trim( $classes_str );
		$tag_class   = '';
		if ( '' !== $classes_str ) {
			$tag_class = 'class="' . esc_attr( $classes_str ) . '" ';
		}
		return $tag_class;
	}
}

if ( ! function_exists( 'acfp_get_type_attr' ) ) {
	/**
	 * Function to return type render content where possible.
	 *
	 * @since 1.2.0
	 *
	 * @param string $type tag class.
	 * @return string
	 */
	function acfp_get_type_attr( string $type ) {
		if ( '' !== $type && false !== $type ) {
			$type = 'type="' . esc_attr( $type ) . '" ';
		}
		return $type;
	}
}

if ( ! function_exists( 'acfp_get_ordered_list' ) ) {
	/**
	 * Generates ordered list
	 *
	 * @since 1.2.0
	 *
	 * @param array  $values values to be listed.
	 * @param string $id list id.
	 * @param array  $classes classes for the list.
	 * @param string $style list css style.
	 * @param bool   $hide_if_empty determines if list will be empty if no value is passed.
	 * @param string $type type of list item marker. Default 1. Accepted values A,a, I, and i.
	 * @return string
	 */
	function acfp_get_ordered_list( array $values, string $id, array $classes, string $style, bool $hide_if_empty = true, $type = '1' ) {
		if ( empty( $values ) && $hide_if_empty ) {
			return '';
		}
		$list = '<ol ' . acfp_get_tag_id_attr( $id ) . acfp_get_class_attr( $classes ) . acfp_get_style_attr( $style ) . acfp_get_type_attr( $type ) . '>';
		foreach ( $values as $value ) {
			$list .= acfp_get_li( $value );
		}
		$list .= '</ol>';
		return $list;
	}
}

if ( ! function_exists( 'acfp_get_unordered_list' ) ) {
	/**
	 * Generates unordered list
	 *
	 * @since 1.2.0
	 *
	 * @param array  $values values to be listed.
	 * @param string $id list id.
	 * @param array  $classes classes for the list.
	 * @param string $style list css style.
	 * @param bool   $hide_if_empty determines if list will be empty if no value is passed.
	 * @return string
	 */
	function acfp_get_unordered_list( array $values, string $id, array $classes, string $style, bool $hide_if_empty = true ) {
		if ( empty( $values ) && $hide_if_empty ) {
			return '';
		}
		$list = '<ul ' . acfp_get_tag_id_attr( $id ) . acfp_get_class_attr( $classes ) . acfp_get_style_attr( $style ) . '>';
		foreach ( $values as $value ) {
			$list .= acfp_get_li( $value );
		}
		$list .= '</ul>';
		return $list;
	}
}

if ( ! function_exists( 'acfp_get_li' ) ) {
	/**
	 * Returns li element.
	 *
	 * @since 1.2.0
	 *
	 * @param string $inner_html inner html for li tag.
	 * @return string
	 */
	function acfp_get_li( string $inner_html ) {
		return '<li>' . $inner_html . '</li>';
	}
}

if ( ! function_exists( 'acfp_get_wrap_tag' ) ) {
	/**
	 * Wraps content in a tag.
	 *
	 * @since 1.2.0
	 *
	 * @param string $wrap_tag tag to wrap content.
	 * @param string $inner_html content to be wrapped.
	 * @param string $tag_class class to be added on the tag.
	 * @param string $tag_id id to be added on the tag.
	 * @param string $style style to be associated with tag.
	 * @return string
	 */
	function acfp_get_wrap_tag( string $wrap_tag, string $inner_html, string $tag_class, string $tag_id, string $style ) {
		$wrap_tag = trim( $wrap_tag );
		if ( '' === $wrap_tag || 'false' === $wrap_tag || false === $wrap_tag ) {
			return $inner_html;
		}
		return '<' . $wrap_tag . ' ' . acfp_get_class_attr( array( $tag_class ) ) . acfp_get_tag_id_attr( $tag_id ) . acfp_get_style_attr( $style ) . ' >' . $inner_html . '</' . $wrap_tag . '>';
	}
}

if ( ! function_exists( 'acfp_get_link_tag_html' ) ) {
	/**
	 * Generates link tag html
	 *
	 * Generates A tag in other words.
	 *
	 * @since 1.2.0
	 * @since 1.3.0 added $rel='' parameter.
	 *
	 * @param string $field_value Field value.
	 * @param string $link_text Link text.
	 * @param string $tag_class class to be added on the tag.
	 * @param string $tag_id id to be added on the tag.
	 * @param string $style style to be associated with tag.
	 * @param string $rel rel content in a tag.
	 * @return string
	 */
	function acfp_get_link_tag_html( string $field_value, string $link_text, string $tag_class, string $tag_id, string $style, string $rel = '' ) {
		return '<a ' . acfp_get_class_attr( array( $tag_class ) ) . acfp_get_tag_id_attr( $tag_id ) . acfp_get_style_attr( $style ) . acfp_get_rel_attr( array( $rel ) ) . ' href="' . esc_url( $field_value ) . '">' . esc_html( $link_text ) . '</a>';
	}
}

if ( ! function_exists( 'acfp_get_rel_attr' ) ) {
	/**
	 * Function to return rel render content where possible.
	 *
	 * @since 1.3.0
	 *
	 * @param array $values tag classes.
	 * @param bool  $has_trailing_space determines whether to add space between values. Default true.
	 * @return string
	 */
	function acfp_get_rel_attr( array $values, bool $has_trailing_space = true ) {
		$values_str = '';
		foreach ( $values as $value ) {
			$value = trim( $value );
			if ( '' !== $value ) {
				$values_str .= $value;
				if ( $has_trailing_space ) {
					$values_str .= ' ';
				}
			}
		}
		$values_str = trim( $values_str );
		$tag_value  = '';
		if ( '' !== $values_str ) {
			$tag_value = 'rel="' . esc_attr( $values_str ) . '" ';
		}
		return $tag_value;
	}
}

if ( ! function_exists( 'acfp_get_url_render_content' ) ) {

	/**
	 * Function to get url render content
	 *
	 * @since 1.3.0
	 *
	 * Added  $tag_class,$tag_id,$style
	 *
	 * @param string $format format to be displayed. With format set to link, the function returns an a tag. Otherwise field value is returned as it is.
	 * @param string $field_value field value.
	 * @param string $link_text text to be rendered on the page instead of the actual link.
	 * @param string $tag_class tag class.
	 * @param string $tag_id tag id.
	 * @param string $style tag style.
	 * @param string $rel rel content in a tag.
	 * @return string
	 */
	function acfp_get_url_render_content( $format, $field_value, $link_text, $tag_class, $tag_id, $style, string $rel = '' ) {
		if ( 'link' === $format ) {
			if ( ! $link_text ) {
				$link_text = $field_value;
			}
			$content = acfp_get_link_tag_html( $field_value, $link_text, $tag_class, $tag_id, $style, $rel );
		} else {
			$content = $field_value;
		}
		return $content;
	}
}

if ( ! function_exists( 'acfp_get_post_title' ) ) {
	/**
	 * Retrieves post title using post id or post object.
	 *
	 * @since 1.3.0
	 *
	 * @param  mixed $post post id or post object.
	 *
	 * @return string|false returns false on fail and post title as string.
	 */
	function acfp_get_post_title( $post = 0 ) {
		$post       = get_post( $post );
		$post_title = isset( $post->post_title ) ? $post->post_title : false;
		$post_id    = isset( $post->ID ) ? $post->ID : 0;
		// phpcs:ignore WordPress.NamingConventions.ValidHookName
		return apply_filters( 'acfp/the_title', $post_title, $post_id );
	}
}

if ( ! function_exists( 'acfp_get_post_title_from_url' ) ) {
	/**
	 * Retrieves post title using post url
	 *
	 * @since 1.3.0
	 *
	 * @param  string $url Post url.
	 *
	 * @return string|false returns false on fail and post title as string.
	 */
	function acfp_get_post_title_from_url( string $url ) {
		$post_id = url_to_postid( $url );
		if ( 0 === $post_id ) {
			return false;
		}
		return acfp_get_post_title( $post_id );
	}
}


/**
 * Retrieves available terms.
 *
 * Original function is acf_get_taxonomy_terms
 *
 * @since 1.4.0
 *
 * @param  array   $taxonomies taxonomies.
 * @param  boolean $only_hierarchical determines whether to retrieve all the terms or terms from hierarchical taxonomies.
 *
 * @return array terms found.
 */
function acfp_get_taxonomy_terms( $taxonomies = array(), $only_hierarchical = false ) {

	// force array.
	$taxonomies = acf_get_array( $taxonomies );

	// get pretty taxonomy names.
	$taxonomies = acf_get_pretty_taxonomies( $taxonomies );

	// vars.
	$r = array();

	// populate $r.
	foreach ( array_keys( $taxonomies ) as $taxonomy ) {

		// vars.
		$label           = $taxonomies[ $taxonomy ];
		$is_hierarchical = is_taxonomy_hierarchical( $taxonomy );
		$terms           = acf_get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);

		// bail early i no terms.
		if ( empty( $terms ) ) {
			continue;
		}

		// sort into hierachial order!
		if ( $is_hierarchical ) {

			$terms = _get_term_children( 0, $terms, $taxonomy );

		}

		if ( $only_hierarchical ) {
			// only add the term when it is hierarchical.
			if ( $is_hierarchical ) {
				// add placeholder.
				$r[ $label ] = array();

				// add choices.
				foreach ( $terms as $term ) {
					$json = json_encode( $term );

					$k                 = $term->term_id;
					$r[ $label ][ $k ] = acf_get_term_title( $term );

				}
			}
		} else {

			// add placeholder.
			$r[ $label ] = array();

			// add choices.
			foreach ( $terms as $term ) {
				$json = json_encode( $term );

				$k                 = $term->term_id;
				$r[ $label ][ $k ] = acf_get_term_title( $term );

			}
		}
	}

	// return.
	return $r;

}

if ( ! function_exists( 'acfp_get_post' ) ) {

	/**
	 * Retrieves post object.
	 *
	 * @since 1.4.0
	 *
	 * @param  mixed $post post or post id to be converted.
	 *
	 * @return WP_Post|array|null
	 */
	function acfp_get_post( $post ) {
		return get_post( $post );
	}

	/**
	 * Creates class instance and passes arguments to constructor
	 *
	 * @since 1.4.0
	 *
	 * @param  string $class_name Class Name.
	 * @param  mixed  ...$args arguments to be passed to the constructor.
	 * @throws Exception Class '$class_name' not found.
	 *
	 * @return instance
	 */
	function acfp_create_instance( string $class_name, ...$args ) {
		// Check if the class exists.
		if ( ! class_exists( $class_name ) ) {
			throw new Exception( "Class '$class_name' not found" );
		}

		// Use reflection to create an instance of the class.
		$reflection_class = new ReflectionClass( $class_name );
		// Get the constructor.
		$constructor = $reflection_class->getConstructor();

		if ( null === $constructor ) {
			// If no constructor is defined, simply create an instance without constructor.
			return $reflection_class->newInstanceWithoutConstructor();
		}

		// Get the parameters of the constructor.
		$params           = $constructor->getParameters();
		$constructor_args = array();

		foreach ( $params as $param ) {
			// Check if argument is provided, otherwise use null as default.
			$constructor_args[] = isset( $args[ $param->getPosition() ] ) ? $args[ $param->getPosition() ] : null;
		}

		// Create an instance of the class using the constructor with arguments.
		return $reflection_class->newInstanceArgs( $constructor_args );
	}

	/**
	 * Undocumented function
	 *
	 * @since 1.4.0
	 *
	 * @param  mixed $setting_key the setting name used to store the value.
	 * @param  mixed $default_value default value if no value is stored in the settings.
	 *
	 * @return mixed
	 */
	function acfp_get_setting( $setting_key, $default_value = null ) {
		global $acfp;
		$settings = $acfp->get_settings();
		if ( array_key_exists( $setting_key, $settings ) ) {
			$value = $settings[ $setting_key ];
		} else {
			$value = $default_value;
		}
		// phpcs:ignore WordPress.NamingConventions.ValidHookName
		return apply_filters( "acfp/settings/{$setting_key}", $value );
	}

	/**
	 * Returns .min when debug is false and '' when true
	 *
	 * @since 1.4.0
	 *
	 * @return string
	 */
	function acfp_get_minify_suffix_if_needed() {
		$debug = acfp_get_setting( 'debug' );
		return $debug ? '' : '.min';
	}

	/**
	 * Enqueues foundation styles.
	 *
	 * @since 1.4.0
	 *
	 * @return void
	 */
	function acfp_enqueue_foundation_styles() {
		if ( acfp_get_setting( 'enqueue_foundation_css' ) ) {
			global $acfp;
			$suffix = acfp_get_minify_suffix_if_needed();
			wp_enqueue_style( 'foundation', $acfp->get_plugin_base_url() . 'assets/build/public/foundation/foundation' . $suffix . '.css', array(), '1.0', 'all' );
		}
	}
}
