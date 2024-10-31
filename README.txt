=== Plus Features for Advanced Custom Fields ===
Contributors: thewpcatalyst
Donate link: <https://bmc.link/thewpcatalyst>
Tags: acfp, plus, acf, advanced custom fields, dual, range, slider, input, dual range slider
Requires at least: 5.0
Tested up to: 6.5
Stable tag: 1.4.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: <http://www.gnu.org/licenses/gpl-2.0.html>

Adds Dual range slider to Advanced Custom Fields(ACF) plugin and supports some shortcodes for Email and URL links, Numbers with separators, and text.

== Description ==

Plus Features for Advanced Custom Fields adds a Dual Range Slider field type to the advanced custom field plugin and some basic shortcodes for basic fields in the current post. The Dual Range Slider field type allows you to choose minimum and maximum values.

== Installation ==

Requires <https://wordpress.org/plugins/advanced-custom-fields/> to be installed.

1. Upload `acfp` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to WordPress Admin -> ACF-> Field group -> Select/edit your preferred field group, on field type go to the **Choice** section and select Dual Range Slider.
1. Define your preferred settings.

== Usage ==

= Code =

Get Dual range slider value code:

    if ( function_exists( 'get_field' ) ) {
        $min_max_array = get_field( 'dual_range_slider' );
            if ( is_array( $min_max_array ) && array_key_exists( 'min', $min_max_array ) && array_key_exists( 'max', $min_max_array ) ) {
            echo 'Min value is: ' . wp_kses( $min_max_array['min'] , array()) . '<br>';
            echo 'Max value is: ' . wp_kses( $min_max_array['max'] , array());
        }
    }

Update Dual range slider PHP code:

    if(function_exists( 'update_field' ) ){
        $value=array(
            'min'=>20,
            'max'=> 35,
        );
        $is_updated=update_field('dual_range_slider_field_name', $value);
        var_dump($is_updated);
    }

Get link value with nofollow

    if ( function_exists( 'get_field' ) && function_exists( 'acfp_get_rel_attr' ) ) {
        $link = get_field( 'link_field_name' );
        echo '<pre>';
        var_dump( $link );
        echo '<pre>';
        if ( is_array( $link ) ) {//return format set to array
            if ( array_key_exists( 'nofollow', $link ) ) {
                $rel_content        = acfp_get_rel_attr( array( $link['nofollow'] ), false );
                $allowed_attributes = array(
                    'rel' => array(),
                );
                ?>
                <a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>"  <?php echo wp_kses( $rel_content, $allowed_attributes ); ?>><?php echo esc_html( $link['title'] ); ?></a>
                <?php
            } else {
                ?>
                <a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
                <?php
            }
        } elseif(is_string( $link )) {
            echo esc_html( $link );
        }
    }

Update link value with nofollow

    if ( function_exists( 'update_field' ) ) {
        $value      = array (
            'title' => 'Sample page',
            'url' => 'http://localhost/dev/sample-page/',
            'target' => '_blank',
            'nofollow' => 'nofollow',
        );
        $is_updated = update_field( 'link_field_name', $value );
        var_dump( $is_updated );
    }


== Objects supported by shortcode ==

- Current Post (current_post)-> The current post where the field is placed on.

== Shortcode supported field types ==
Below are the supported field types:
- text
- textarea
- email
- number
- range
- email
- url
- acfp_dual_range_slider
- image
- file
- WYSIWYG
- oembed
- select
- checkbox
- radio
- button_group
- true_false
- link
- Page Link
- Post Object
- Relationship

== Shortcode Attributes ==

= field =
Specifies field name or field key for the field to be retrieved.
**Supported in:** All supported fields
**Example:** field="field_name_or_key"

= object [Optional] =
The object where the shortcode should retrieve data from.
**Supported in:** All supported fields.
**Accepted values:** "current_post"
**Example:** object="current_post"

= field_type [Optional] =
Specifies the type of the field you are trying to retrieve.
**Supported in:** All supported fields
**Example:** field_type="text"

= empty_message [Optional] =
Alternative value when the field is empty.
**Supported in:** select, and checkbox
**Example:** empty_message ="No value selected."

= link_text [Optional] =
Clickable text to be displayed as a link instead of showing the URL.
**Supported in:** email, url, file
**Example:** link_text="Click here"
**Overrides:** Post title in page link.

= format [Optional] =
Specifies the format of value to be displayed.
**Supported in:** checkbox, acfp_dual_range_slider, email, number, select, url
**Example:** in URL and email format="link", 
in checkbox, select format="ordered_list" or format="unordered_list", 
in number format="separators_decimals", 
in acfp_dual_range_slider format="max" or format="min"

= decimals [Optional] =
The number of decimals.
**Supported in:** number
**Example:** decimals="4"

= decimal_separator [Optional] =
Character to be used in separating decimals.
**Supported in:** number
**Example:** decimal_separator="."

= thousands_separator [Optional] =
Character to be used in separating thousands.
**Supported in:** number
**Example:** decimal_separator=","

= alt [Optional] =
Alternative text in case the image fails to load.
**Supported in:** image
**Example:** image="my_image"

= width [Optional] =
Image width.
**Supported in:** image
**Example:** width="100px"

= height [Optional] =
Image height.
**Supported in:** image
**Example:** height="100px"

= style [Optional] =
Style attribute for wrapper tag.
**Supported in:** All supported fields
**Example:** style="color:green;text-align:center"

= media_sizes [Optional] =
Media sizes.
**Supported in:** image
**Example:** media_sizes="(max-width: 600px) 480px, 800px"

= tag_id [Optional] =
ID attribute for wrapper tag.
**Supported in:** All supported fields
**Example:** id="my-unique-id"

= tag_class [Optional] =
Class attribute for wrapper tag.
**Supported in:** All supported fields
**Example:** class="my-class-name"

= hide_if_empty [Optional] =
Determines whether list tags will not be shown when there is no selected value in the select or checkbox field type.
**Supported in:** checkbox, select
**Example:** hide_if_empty="true"

= ordered_list_type [Optional] =
Specifies the type of ordered list to be displayed.
**Supported in:** checkbox, select,
*Accepted values:** "1", "a" "A", "i" and "I".
**Example:** ordered_list_type="a"

= display [Optional] =
Specifies whether to display values or labels.
**Supported in:** button group, checkbox, radio, select,
*Accepted values:** "labels", "values", "page_title"
**Example:** display="values"

= wrap_tag [Optional] =
Tag to wrap field content.
**Supported in:** All supported fields
**Example:** wrap_tag="div"

= checked_content [Optional] =
Content to be shown when a checkbox is checked.
**Supported in:** true_false
**Example:** checked_content="Field checked"

= unchecked_content [Optional] =
Content to be shown when a checkbox is unchecked.
**Supported in:** true_false
**Example:** checked_content="Field unchecked"

= rel [Optional] =
rel content for links.
**Supported in:** URL, links
**Example:** rel="nofollow"

= posts_layout [Optional] =
Layout to be used for rendering posts.
**Supported in:** Post Object, Relationship
**Value 1:** simple-grid
**Value 2:** fber-list
**Value 3:** false
**Example:** posts_layout="simple-grid"

= post_layout [Optional] =
Layout to be used for rendering a post.
**Supported in:** Post Object, Relationship
**Value 1:** simple-card
**Example:** post_layout="simple-card"

== Shortcodes Examples ==

[acfp field="text_field_name" field_type="text"]

[acfp field="text_area_field_name" field_type="textarea"]

[acfp field="range_field_name" field_type="range" ]

[acfp field="number_field_name" field_type="number"]

[acfp field="number_field_name" format = "separators_decimals" decimal_separator=","  thousands_separator="." decimals="4" field_type="number"]

[acfp field="email_field_name" format="link" link_text="my email" field_type="email"]

[acfp field="email_field_name"  link_text="my email" field_type="email"]

[acfp field="url_field_name" format="link" link_text="my link" field_type="url"]

[acfp field="url_field_name"  link_text="my link" field_type="url"]

[acfp field="dual_range_slider_field_name"  field_type="acfp_dual_range_slider" format="min"]

[acfp field="dual_range_slider_field_name"  field_type="acfp_dual_range_slider" format="max"]

[acfp field="dual_range_slider_field_name"  field_type="acfp_dual_range_slider"]

[acfp field="image_field_name"  field_type="image" alt="A simple image"]

[acfp field="image_field_name"  field_type="image" alt="A simple image" media_sizes="(max-width: 600px) 480px, 800px" tag_id="my-img-id" tag_class="my-img-class" ]

[acfp field="file_field_name"  field_type="file" ]

[acfp field="wysiwyg_field_name"  field_type="wysiwyg" ]

[acfp field="oembed_field_name"  field_type="oembed" ]

[acfp field="select_field_name"  field_type="select" ]

[acfp field="select_field_name" format="unordered_list" display="labels" field_type="select" ]

[acfp field="select_field_name" format="unordered_list" display="values" field_type="select" ]

[acfp field="select_field_name" format="ordered_list" display="labels" field_type="select" ]

[acfp field="select_field_name" format="ordered_list" display="values" field_type="select" ]

[acfp field="checkbox_field_name" format="ordered_list" display="values" field_type="checkbox" ]

[acfp field="checkbox_field_name" format="ordered_list" display="values" field_type="checkbox" ]

[acfp field="radio_button_field_name" display="values" field_type="radio" ]

[acfp field="radio_button_field_name" display="labels" field_type="radio" ]

[acfp field="button_group_field_name" display="labels" field_type="button_group" wrap_tag="div"]

[acfp field="button_group_field_name" display="values" wrap_tag="div"]

[acfp field="truefalse_field_name" field_type="true_false" wrap_tag="div"]

[acfp field="truefalse_field_name" field_type="true_false" wrap_tag="div" unchecked_content="Unchecked" checked_content="Checked"]

[acfp field="link_field_name"  field_type="link" wrap_tag="div"]

[acfp field="page_link_field_name"]

[acfp field="post_object_field_name"]

[acfp field="post_object_field_name" posts_layout="simple-grid"]

[acfp field="post_object_field_name"  posts_layout="fber-list"]

[acfp field="post_object_field_name"  posts_layout="false"]

[acfp field="relationship_field_name"]

[acfp field="relationship_field_name"  posts_layout="simple-grid"]

[acfp field="relationship_field_name"  posts_layout="fber-list"]

[acfp field="relationship_field_name"  posts_layout="false"]

== Frequently Asked Questions ==

= How can I utilize the values selected in the dual range slider on my templates? =

You can add custom code in your template files as shown below:

    if ( function_exists( 'get_field' ) ) {
        $min_max_array = get_field( 'dual_range_slider' );
        if ( is_array( $min_max_array ) && array_key_exists( 'min', $min_max_array ) && array_key_exists( 'max', $min_max_array ) ) {
            echo 'Min value is: ' . wp_kses( $min_max_array['min'] , array()) . '<br>';
            echo 'Max value is: ' . wp_kses( $min_max_array['max'] , array());
        }
    }

= How can I update the dual range slider field using PHP code? =

You can update the field using an array with max and min keys as shown below:

    if(function_exists( 'update_field' ) ){
        $value=array(
            'min'=>20,
            'max'=> 35,
        );
        $is_updated=update_field('dual_range_slider_field_name', $value);
        var_dump($is_updated);
    }

= How can I stop enqueueing Foundation style? =

You can add the filter below in your theme functions.php:

    // Prevents foundation .css from being enqueued.
    add_filter(
        'acfp/settings/enqueue_foundation_css',
        function( $value ) {
            return false;
        }
    );


== Screenshots ==

1. Dual Range Slider in Admin dashboard post edit.
2. Dual Range slider field settings.
3. Settings continuation.
4. rel="nofollow" on ACF link field type.

== Changelog ==

= 1.4.0 =
New: Supports Page Link, Post Object, and Relationship Field types.

= 1.3.1 =
Fixed: JavaScript exception.

= 1.3.0 =
Added rel="nofollow" on ACF link field type.
Added shortcode support for button_group, true_false and link.

= 1.2.0 =
The field types below are now supported in acfp shortcode:
- text
- textarea
- email
- number
- range
- email
- url
- acfp_dual_range_slider
- image
- file
- WYSIWYG
- oembed
- select
- checkbox
- radio

= 1.1.0 =
Supports ACF shortcode security filters.
Added step settings to dual range slider.
Added shortcode support for ACF images, files, WYSIWYG, and oEmbed.
Enhancement- Dual Range slider now has set settings.

= 1.0.0 =
Beginning of ACF Plus.

== Upgrade Notice ==

= 1.4.0 =
New: Supports Page Link, Post Object, and Relationship Field types.
