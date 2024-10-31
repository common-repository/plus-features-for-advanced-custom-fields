<?php
/**
 * ACFP_ACF_Link_Field_Mod definition.
 *
 * @link       https://profiles.wordpress.org/thewpcatalyst/
 * @since      1.0.0
 *
 * @package    Acfp
 * @subpackage Acfp/includes/fields/mods
 */

/**
 * Modifies acf link field behavior.
 *
 * @since 1.3.0
 */
class ACFP_ACF_Link_Field_Mod {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.3.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.3.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Holds ACFP class instance
	 *
	 * @var ACFP
	 */
	private $acfp;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.3.0
	 * @param      Acfp $acfp       Acfp class instance..
	 */
	public function __construct( Acfp $acfp ) {
		$this->acfp        = $acfp;
		$this->plugin_name = $acfp->get_plugin_name();
		$this->version     = $acfp->get_version();
	}

	/**
	 * Fired on acf/load_value hook.
	 *
	 * @since 1.3.0
	 *
	 * @param  mixed $value value of the field.
	 * @param  mixed $post_id the id where field is currently placed.
	 * @param  array $field Field array.
	 *
	 * @return mixed
	 */

	/**
	 * Fired on acf/init action.
	 *
	 * @since    1.3.1
	 *
	 * @return void
	 */
	public function acf_init() {
		$this->remove_acf_link_field_type_hooks();// they will be re-added on this plugin.
	}

	/**
	 * Removes the original hooks added on acf_field_link. This prevents overridden functions from been called.
	 *
	 * @since    1.3.1
	 *
	 * @return void
	 */
	public function remove_acf_link_field_type_hooks() {
		$instance = acf_get_field_type( 'link' );
		// value.
		if ( $instance instanceof acf_field_link ) {
			$this->remove_field_type_filter( $instance->name, 'acf/load_value', array( $instance, 'load_value' ), 10, 3 );
			$this->remove_field_type_filter( $instance->name, 'acf/update_value', array( $instance, 'update_value' ), 10, 3 );
			$this->remove_field_type_filter( $instance->name, 'acf/format_value', array( $instance, 'format_value' ), 10, 3 );
			$this->remove_field_type_filter( $instance->name, 'acf/validate_value', array( $instance, 'validate_value' ), 10, 4 );
			$this->remove_field_type_action( $instance->name, 'acf/delete_value', array( $instance, 'delete_value' ), 10, 3 );

			// field.
			$this->remove_field_type_filter( $instance->name, 'acf/validate_rest_value', array( $instance, 'validate_rest_value' ), 10, 3 );
			$this->remove_field_type_filter( $instance->name, 'acf/validate_field', array( $instance, 'validate_field' ), 10, 1 );
			$this->remove_field_type_filter( $instance->name, 'acf/load_field', array( $instance, 'load_field' ), 10, 1 );
			$this->remove_field_type_filter( $instance->name, 'acf/update_field', array( $instance, 'update_field' ), 10, 1 );
			$this->remove_field_type_filter( $instance->name, 'acf/duplicate_field', array( $instance, 'duplicate_field' ), 10, 1 );
			$this->remove_field_type_action( $instance->name, 'acf/delete_field', array( $instance, 'delete_field' ), 10, 1 );
			$this->remove_field_type_action( $instance->name, 'acf/render_field', array( $instance, 'render_field' ), 9, 1 );

			$this->remove_field_type_action( $instance->name, 'acf/render_field_settings', array( $instance, 'render_field_settings' ), 9, 1 );
			$this->remove_field_type_filter( $instance->name, 'acf/prepare_field', array( $instance, 'prepare_field' ), 10, 1 );
			$this->remove_field_type_filter( $instance->name, 'acf/translate_field', array( $instance, 'translate_field' ), 10, 1 );

			// input actions.
			$this->remove_action( 'acf/input/admin_enqueue_scripts', array( $instance, 'input_admin_enqueue_scripts' ), 10, 0 );
			$this->remove_action( 'acf/input/admin_head', array( $instance, 'input_admin_head' ), 10, 0 );
			$this->remove_action( 'acf/input/form_data', array( $instance, 'input_form_data' ), 10, 1 );
			$this->remove_filter( 'acf/input/admin_l10n', array( $instance, 'input_admin_l10n' ), 10, 1 );
			$this->remove_action( 'acf/input/admin_footer', array( $instance, 'input_admin_footer' ), 10, 1 );

			// field group actions.
			$this->remove_action( 'acf/field_group/admin_enqueue_scripts', array( $instance, 'field_group_admin_enqueue_scripts' ), 10, 0 );
			$this->remove_action( 'acf/field_group/admin_head', array( $instance, 'field_group_admin_head' ), 10, 0 );
			$this->remove_action( 'acf/field_group/admin_footer', array( $instance, 'field_group_admin_footer' ), 10, 0 );

			foreach ( acf_get_combined_field_type_settings_tabs() as $tab_key => $tab_label ) {
				$this->remove_field_type_action( $instance->name, "acf/field_group/render_field_settings_tab/{$tab_key}", array( $instance, "render_field_{$tab_key}_settings" ), 9, 1 );
			}
		}

	}

	/**
	 * Removes field specific filter
	 *
	 * @since    1.3.1
	 *
	 * @param string  $field_type_name the name used to register the field.
	 * @param string  $tag name of the hook.
	 * @param string  $function_to_add callback.
	 * @param integer $priority priority.
	 * @param integer $accepted_args number of args.
	 * @return void
	 */
	protected function remove_field_type_filter( string $field_type_name, string $tag = '', $function_to_add = '', int $priority = 10, int $accepted_args = 1 ) {
		$tag .= '/type=' . $field_type_name;
		$this->remove_filter( $tag, $function_to_add, $priority, $accepted_args );

	}

	/**
	 * Removes filter
	 *
	 * @since    1.3.1
	 *
	 * @param string  $tag name of the hook.
	 * @param mixed   $function_to_add callback.
	 * @param integer $priority priority.
	 * @param integer $accepted_args number of args.
	 * @return void
	 */
	protected function remove_filter( string $tag = '', $function_to_add = '', int $priority = 10, int $accepted_args = 1 ) {
		remove_filter( $tag, $function_to_add, $priority, $accepted_args );
	}

	/**
	 * Removes field specific action
	 *
	 * @since    1.3.1
	 *
	 * @param string  $field_type_name the name used to register the field.
	 * @param string  $tag name of the hook.
	 * @param string  $function_to_add callback.
	 * @param integer $priority priority.
	 * @param integer $accepted_args number of args.
	 * @return void
	 */
	protected function remove_field_type_action( string $field_type_name, string $tag = '', $function_to_add = '', int $priority = 10, int $accepted_args = 1 ) {
		$tag .= '/type=' . $field_type_name;
		$this->remove_action( $tag, $function_to_add, $priority, $accepted_args );
	}

	/**
	 * Removes action
	 *
	 * @since    1.3.1
	 *
	 * @param string  $tag name of the hook.
	 * @param string  $function_to_add callback.
	 * @param integer $priority priority.
	 * @param integer $accepted_args number of args.
	 * @return void
	 */
	protected function remove_action( string $tag = '', $function_to_add = '', int $priority = 10, int $accepted_args = 1 ) {
		remove_action( $tag, $function_to_add, $priority, $accepted_args );
	}

	/**
	 * Register the JavaScript after ACF core scripts and styles have been registered.
	 *
	 * @since    1.3.1
	 *
	 * @param  mixed $version ACF version.
	 * @param  mixed $suffix ACF suffix for '.min' or ''.
	 *
	 * @return void
	 */
	public function enqueue_extra_scripts_after_acf_scripts_and_styles( $version, $suffix ) {
		wp_enqueue_script( $this->plugin_name . '-acfp-input-override', $this->acfp->get_plugin_base_url() . 'assets/build/common/js/acfp-input-override' . $suffix . '.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Fired on acf/load_value hook.
	 *
	 * @since 1.3.0
	 *
	 * @param  mixed $value value of the field.
	 * @param  mixed $post_id the id where field is currently placed.
	 * @param  array $field Field array.
	 *
	 * @return mixed
	 */
	public function load_value( $value, $post_id, $field ) {
		if ( is_array( $value ) && ! array_key_exists( 'nofollow', $value ) ) {
			$value['nofollow'] = '';
		}
		return $value;
	}

	/**
	 * Fired on after_wp_tiny_mce action.
	 *
	 * @since 1.3.0
	 *
	 * @return void
	 */
	public function after_wp_tiny_mce() {
		/**
		 * Add a 'Add rel="nofollow" to link' checkbox to the WordPress link editor
		 *
		 * @see https://danielbachhuber.com/tip/rel-nofollow-link-modal/
		 */

		?>
		<script>
			var originalWpLink;
			// Ensure both TinyMCE, underscores and wpLink are initialized
			if ( typeof tinymce !== 'undefined' && typeof _ !== 'undefined' && typeof wpLink !== 'undefined' ) {
				// Ensure the #link-options div is present, because it's where we're appending our checkbox.
				if ( tinymce.$('#link-options').length ) {
					// Append our checkbox HTML to the #link-options div, which is already present in the DOM.
					tinymce.$('#link-options').append(<?php echo json_encode( '<div class="link-nofollow"><label><span></span><input type="checkbox" id="wp-link-nofollow" /> Add rel="nofollow" to link</label></div>' ); ?>);
					// Clone the original wpLink object so we retain access to some functions.
					originalWpLink = _.clone( wpLink );
					wpLink.addRelNofollow = tinymce.$('#wp-link-nofollow');
					// Override the original wpLink object to include our custom functions.
					wpLink = _.extend( wpLink, {
						/**
						 * Fetch attributes for the generated link based on
						 * the link editor form properties.
						 *
						 * In this case, we're calling the original getAttrs()
						 * function, and then including our own behavior.
						 */
						getAttrs: function() {
							var attrs = originalWpLink.getAttrs();
							attrs.rel = wpLink.addRelNofollow.prop( 'checked' ) ? 'nofollow' : false;
							return attrs;
						},
						/**
						 * Build the link's HTML based on attrs when inserting
						 * into the text editor.
						 *
						 * In this case, we're completely overriding the existing
						 * function.
						 */
						buildHtml: function( attrs ) {
							var html = '<a href="' + attrs.href + '"';

							if ( attrs.target ) {
								html += ' target="' + attrs.target + '"';
							}
							if ( attrs.rel ) {
								html += ' rel="' + attrs.rel + '"';
							}
							return html + '>';
						},
						/**
						 * Set the value of our checkbox based on the presence
						 * of the rel='nofollow' link attribute.
						 *
						 * In this case, we're calling the original mceRefresh()
						 * function, then including our own behavior
						 */
						mceRefresh: function( searchStr, text ) {
							originalWpLink.mceRefresh( searchStr, text );
							var editor = window.tinymce.get( window.wpActiveEditor )
							if ( typeof editor !== 'undefined' && ! editor.isHidden() ) {
								var linkNode = editor.dom.getParent( editor.selection.getNode(), 'a[href]' );
								if ( linkNode ) {
									wpLink.addRelNofollow.prop( 'checked', 'nofollow' === editor.dom.getAttrib( linkNode, 'rel' ) );
								}
							}
						}
					});
				}
			}
		</script>
		<style>
		/**/#wp-link #link-options .link-nofollow {
			padding: 3px 0 0;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		</style>
			<?php
	}
}
