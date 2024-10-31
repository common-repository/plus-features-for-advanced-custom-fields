<?php
/**
 * Dual range slider field type definition.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.0.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/fields
 */

/**
 * The ACFP_ACF_Field_Dual_Range_Slider class
 *
 * @since 1.0.0
 */
class ACFP_ACF_Field_Dual_Range_Slider  extends \acf_field {
	/**
	 * Settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Variable to add extra ID if need be
	 *
	 * @var string
	 */
	public $id;

	/**
	 *  __construct
	 *
	 *  This function will setup the field type data
	 *
	 *  @type    function
	 *  @date    5/03/2014
	 *  @since   5.0.0
	 */
	public function __construct() {
		$this->id = 'dual_range_slider';

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		$this->name = 'acfp_dual_range_slider';

		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		$this->label = __( 'Dual Range Slider', 'acfp' );

		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		$this->category = 'basic';

		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		$this->defaults = array(
			'step'              => '1',
			'min_value'         => '0',
			'default_min_value' => '0',
			'max_value'         => '100',
			'default_max_value' => '100',
		);

		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/

		$this->l10n = array(
			'error' => __( 'Error! Please enter a higher value', 'TEXTDOMAIN' ),
		);

		$current_dir_path   = str_replace( '\\', '/', __DIR__ );
		$abspath            = str_replace( '\\', '/', ABSPATH );
		$url_to_fields      = site_url( str_replace( $abspath, '', $current_dir_path ) );
		$url_to_plugin_base = str_replace( '/includes/fields', '', $url_to_fields );

		$this->env = array(
			'url_to_fields'      => $url_to_fields, // URL to the fields directory.
			'url_to_plugin_base' => $url_to_plugin_base, // URL to plugin root folder.
			'version'            => '1.0.0', // Replace this with your theme or plugin version constant.
		);

		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/

		// do not delete!
		parent::__construct();

	}


	/**
	 *  Function render_field_settings()
	 *
	 *  Create extra settings for your field. These are visible when editing a field.
	 *
	 *  @type    action
	 *  @since   3.6
	 *  @date    23/01/13
	 *
	 *  @param   $field (array) the $field being edited.
	 */
	public function render_field_settings( $field ) {
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Step', 'acfp' ),
				'instructions' => __( 'Slider step value', 'acfp' ),
				'type'         => 'number',
				'name'         => 'step',
				'required'     => 1,
			)
		);
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Minimum value', 'acfp' ),
				'instructions' => __( 'Minimum slider value', 'acfp' ),
				'type'         => 'number',
				'name'         => 'min_value',
				'required'     => 1,
			)
		);
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Default minimum value', 'acfp' ),
				'instructions' => __( 'Default minimum slider value', 'acfp' ),
				'type'         => 'number',
				'name'         => 'default_min_value',
				'required'     => 1,
			)
		);
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Maximum value', 'acfp' ),
				'instructions' => __( 'Maximum slider value', 'acfp' ),
				'type'         => 'number',
				'name'         => 'max_value',
				'required'     => 1,
			)
		);
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Default maximum value', 'acfp' ),
				'instructions' => __( 'Default maximum slider value', 'acfp' ),
				'type'         => 'number',
				'name'         => 'default_max_value',
				'required'     => 1,
			)
		);

	}



	/**
	 *  Function render_field().
	 *
	 *  Create the HTML interface for your field
	 *
	 *  @type    action
	 *  @since   3.6
	 *  @date    23/01/13
	 *  @param    $field the $field being rendered.
	 */
	public function render_field( $field ) {
		$field_id    = esc_attr( $this->id );
		$min         = intval( $field['min_value'] );
		$max         = intval( $field['max_value'] );
		$field_value = $field['value'];
		if ( is_array( $field_value ) && array_key_exists( 'min', $field_value ) && array_key_exists( 'max', $field_value ) ) {
			$from_slider_value = $field_value['min'];
			$to_slider_value   = $field_value['max'];
		} else {
			$from_slider_value = intval( $field['default_min_value'] );
			$to_slider_value   = intval( $field['default_max_value'] );
		}
		$step = floatval( $field['step'] );

		?>

		<div class="acfp_dual_range_slider_container">
			<div class="sliders_control">
				<input class="fromSlider" id="fromSlider-<?php echo esc_attr( $field['name'] . $field_id ); ?>" type="range" value="<?php echo esc_attr( $from_slider_value ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>"/>
				<input class="toSlider" id="toSlider-<?php echo esc_attr( $field['name'] . $field_id ); ?>" type="range" value="<?php echo esc_attr( $to_slider_value ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>"/>
			</div>
			<div class="number_control">
				<div class="number_control_container">
					<div class="number_text_min">Min</div>
					<input class="number_input_from" type="number" id="fromInput-<?php echo esc_attr( $field['name'] . $field_id ); ?>" value="<?php echo esc_attr( $from_slider_value ); ?>"  min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>"/>
				</div>
				<div class="number_control_container">
					<div class="number_text_max">Max</div>
					<input class="number_input_to" type="number" id="toInput-<?php echo esc_attr( $field['name'] . $field_id ); ?>" value="<?php echo esc_attr( $to_slider_value ); ?>" min="<?php echo esc_attr( $min ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>"/>
				</div>
				<div class="number_control_container">
					<input class="acfp_dual_range_slider_value_input" type="text" 
					style="display: none;"
					id="<?php echo esc_attr( $field['name'] . $field_id ); ?>"
					name="<?php echo esc_attr( $field['name'] ); ?>"
					value="<?php echo esc_attr( $from_slider_value . ',' . $to_slider_value ); ?>"
					/>
				</div>
			</div>
		</div>
		<?php
	}


	/**
	 * Enqueues CSS and JavaScript needed by HTML in the render_field() method.
	 *
	 * Callback for admin_enqueue_script.
	 *
	 * @return void
	 */
	public function input_admin_enqueue_scripts() {
		$url_to_plugin_base = trailingslashit( $this->env['url_to_plugin_base'] );
		$version            = $this->env['version'];

		wp_register_script(
			$this->name,
			"{$url_to_plugin_base}assets/build/js/acfp-field-dual-range-slider.min.js",
			array( 'acf-input' ),
			$version,
			false
		);

		wp_register_style(
			$this->name,
			"{$url_to_plugin_base}assets/build/css/acfp-field-dual-range-slider.min.css",
			array( 'acf-input' ),
			$version
		);

		wp_enqueue_script( $this->name );
		wp_enqueue_style( $this->name );
	}

	/**
	 *  The update_value()
	 *
	 *  This filter is applied to the $value before it is saved in the db
	 *
	 *  @type    filter
	 *  @since   3.6
	 *  @date    23/01/13
	 *
	 *  @param    mixed $value  the value found in the database.
	 *  @param    mixed $post_id  the                                         $post_id from which the value was loaded.
	 *  @param    array $field  the field array holding all the field options.
	 *  @return  $value
	 */
	public function update_value( $value, $post_id, $field ) {
		return $this->get_desired_value( $value );
	}

	/**
	 *  The validate_value()
	 *
	 *  This filter is used to perform validation on the value prior to saving.
	 *  All values are validated regardless of the field's required setting. This allows you to validate and return
	 *  messages to the user if the value is not correct
	 *
	 *  @type    filter
	 *  @date    11/02/2014
	 *  @since   5.0.0
	 *
	 *  @param   boolean $valid  validation status based on the value and the field's required setting.
	 *  @param   mixed   $value  the                                                                     $_POST value.
	 *  @param   array   $field  the field array holding all the field options.
	 *  @param   string  $input the corresponding input name for                                       $_POST value.
	 *  @return  $valid
	 */
	public function validate_value( $valid, $value, $field, $input ) {
		$desired_value = $this->get_desired_value( $value );
		if ( false === $desired_value ) {
			return __( 'Wrong data format', 'acfp' );
		} elseif ( $desired_value['min'] > $desired_value['max'] ) {
			return __( 'Maximum value cannot be larger than the min value', 'acfp' );
		} elseif ( $desired_value['min'] < $field['min_value'] ) {
			return __( 'Minimum value cannot be less than the slider min value', 'acfp' );
		} elseif ( $desired_value['max'] > $field['max_value'] ) {
			return __( 'Maximum value cannot be large than the slider max value', 'acfp' );
		}
		return $valid;
	}

	/**
	 * Returns an array of the desired value or false in case of fail
	 *
	 * @param mixed $value value to be converted to desired array.
	 *
	 * @return array|false
	 */
	public function get_desired_value( $value ) {
		if ( is_string( $value ) ) {
			$input_array   = explode( ',', $value );
			$desired_array = array();
			if ( array_key_exists( 0, $input_array ) && array_key_exists( 1, $input_array ) ) {
				$desired_array['min'] = trim( $input_array[0] );
				$desired_array['max'] = trim( $input_array[1] );
				return $desired_array;
			} else {
				return false;
			}
		} elseif ( is_array( $value ) && array_key_exists( 'min', $value ) && array_key_exists( 'max', $value ) ) {
			return $value;
		}
		return false;
	}
}
