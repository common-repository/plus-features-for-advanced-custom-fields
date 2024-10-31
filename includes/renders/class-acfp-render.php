<?php
/**
 * The file that defines Parent class to generate field type html content.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.2.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/renders
 */

if ( ! class_exists( 'ACFP_Render' ) ) {
	/**
	 * Parent class to generate field type html content.
	 *
	 * @since 1.2.0
	 */
	class ACFP_Render {
		/**
		 * Field value
		 *
		 * @var mixed
		 */
		protected $field_value;

		/**
		 * Format to be generated.
		 *
		 * @var string
		 */
		protected string $format;

		/**
		 * Tag id.
		 *
		 * @var string
		 */
		protected string $tag_id;

		/**
		 * Tag class.
		 *
		 * @var string
		 */
		protected string $tag_class;

		/**
		 * Style.
		 *
		 * @var string
		 */
		protected string $style;

		/**
		 * Hide if empty.
		 *
		 * @var boolean
		 */
		protected bool $hide_if_empty;

		/**
		 * Empty message.
		 *
		 * @var string
		 */
		protected string $empty_message;

		/**
		 * Stores the ordered list type.
		 *
		 * @var string
		 */
		protected string $ordered_list_type;

		/**
		 * Stores generated html content.
		 *
		 * @var string
		 */
		protected string $content;

		/**
		 * Display.
		 *
		 * @var string
		 */
		protected string $display;

		/**
		 * Tag to wrap the field value.
		 *
		 * @var string
		 */
		protected string $wrap_tag;


		// number specific variables.
		/**
		 * Number of decimals.
		 *
		 * @used Number.
		 *
		 * @var string
		 */
		protected string $decimals;

		/**
		 * Character to be used as decimal separator.
		 *
		 * @used Number.
		 *
		 * @var string
		 */
		protected string $decimal_separator;
		/**
		 * Character to be used as thousand separator.
		 *
		 * @used Number.
		 *
		 * @var string
		 */
		protected string $thousands_separator;

		// used in email,urls.

		/**
		 *  Text to be rendered on the page instead of the actual link.
		 *
		 * @var string
		 */
		protected string $link_text;

		/**
		 * Alternative text incase image fails to load.
		 *
		 * @used image.
		 * @var string
		 */
		protected string $alt;

		/**
		 * Element width.
		 *
		 * @used image.
		 * @var string
		 */
		protected string $width;

		/**
		 * Element height.
		 *
		 * @used image.
		 * @var string
		 */
		protected string $height;

		/**
		 * WordPress thumbnail size to be rendered.
		 *
		 * @used image.
		 * @var string
		 */
		protected string $size;

		/**
		 * Media sizes.
		 *
		 * @url https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images
		 * @used image.
		 * @var string
		 */
		protected string $media_sizes;

		/**
		 * Checked content
		 *
		 * @used true_false.
		 * @var string
		 */
		protected string $checked_content;

		/**
		 * Unchecked content
		 *
		 * @used true_false.
		 * @var string
		 */
		protected string $unchecked_content;

		/**
		 * Rel content.
		 *
		 * @since 1.3.0
		 *
		 * @var string
		 */
		protected string $rel;

		/**
		 * Contains field definitions.
		 *
		 * @since 1.4.0
		 *
		 * @var mixed
		 */
		protected $field_definitions;

		/**
		 * Holds all passed attributes
		 *
		 * @since 1.4.0
		 *
		 * @var mixed
		 */
		protected $attrs;

		/**
		 * Holds acfp instance.
		 *
		 * @since 1.4.0
		 *
		 * @var ACFP
		 */
		protected ACFP $acfp;

		/**
		 * Constructor.
		 *
		 * @since 1.2.0
		 * @since 1.4.0 added @param $field_definitions.
		 * @since 1.4.0 added @param $acfp.
		 *
		 * @param ACFP  $acfp ACFP instance.
		 * @param mixed $field_value Field value.
		 * @param array $attrs Array of shortcode attributes.
		 * @param mixed $field_definitions Field definitions. //todo: define the param type.
		 */
		public function __construct( ACFP $acfp, $field_value, array $attrs, $field_definitions ) {
			$this->acfp                = $acfp;
			$this->attrs               = $attrs;
			$this->empty_message       = $attrs['empty_message'];// Used in select and checkbox.
			$this->link_text           = $attrs['link_text'];// Used in email,urls,file.
			$this->format              = $attrs['format'];// Used in email,url: link. Number: separators_decimals. File: to be added. Select: ordered_list, unordered_list.In select, defaults unordered_list. "acfp_dual_range_slider: min, max.
			$this->decimals            = $attrs['decimals'];// Used in number.
			$this->decimal_separator   = $attrs['decimal_separator'];// Used in number.
			$this->thousands_separator = $attrs['thousands_separator'];// Used in number.
			$this->alt                 = $attrs['alt'];// Used in image.
			$this->width               = $attrs['width'];// Used in image.
			$this->height              = $attrs['height'];// Used in image.
			$this->style               = $attrs['style'];// Used in image.
			$this->size                = $attrs['size'];// Used in image.
			$this->media_sizes         = $attrs['media_sizes'];// Used in image.
			$this->tag_id              = $attrs['tag_id'];// Used in email,url,image.
			$this->tag_class           = $attrs['tag_class'];// Used in email,url,image.
			$this->hide_if_empty       = boolval( $attrs['hide_if_empty'] );// used in select,checkboxes field types.
			$this->ordered_list_type   = $attrs['ordered_list_type'];// used in select for ordered list. In select, this defaults to labels.
			$this->display             = $attrs['display'];// button group.
			$this->wrap_tag            = $attrs['wrap_tag'];
			$this->checked_content     = $attrs['checked_content'];// Used in true_false.
			$this->unchecked_content   = $attrs['unchecked_content'];// Used in true_false.
			$this->rel                 = $attrs['rel'];// Used in url and link.
			$this->field_value         = $field_value;

			$this->field_definitions = $field_definitions;

			// setup defaults.
			$this->validate_and_set_defaults();
			$this->generate();
			$this->wrap();
		}

		/**
		 * Method validates values and set the default values if wrong value is supplied.
		 *
		 * @since 1.2.0
		 *
		 * @return void
		 */
		protected function validate_and_set_defaults() {
		}

		/**
		 * Wraps html $content in a tag.
		 *
		 * @since 1.2.0
		 *
		 * @return void
		 */
		protected function wrap() {
			$this->content = acfp_get_wrap_tag( $this->wrap_tag, $this->content, $this->tag_class, $this->tag_id, $this->style );
		}

		/**
		 * Return html content generated.
		 *
		 * @since 1.2.0
		 *
		 * @return string
		 */
		public function get_html() {
			return $this->content;
		}
	}
}
