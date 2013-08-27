<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
//error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

    //error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    // This gets the theme name from the stylesheet
    $themename = wp_get_theme();
    $themename = preg_replace("/\W/", "_", strtolower($themename) );

    $optionsframework_settings = get_option( 'optionsframework' );
    $optionsframework_settings['id'] = $themename;
    update_option( 'optionsframework', $optionsframework_settings );
    //error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //error_log(print_r(get_option($optionsframework_settings), true)) ;
    //error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

    $display_array = array(
        'block' => __('Block', 'options_framework_theme'),
        'inline' => __('Inline', 'options_framework_theme'),
        'inline block' => __('Inline-Block', 'options_framework_theme'),
        'none' => __('None', 'options_framework_theme')
    );

    // Test data
    $width_array = array(
        '0' => __('0', 'options_framework_theme'),
        '1' => __('1', 'options_framework_theme'),
        '2' => __('2', 'options_framework_theme'),
        '3' => __('3', 'options_framework_theme'),
        '4' => __('4', 'options_framework_theme'),
        '5' => __('5', 'options_framework_theme'),
        '6' => __('6', 'options_framework_theme'),
        '7' => __('7', 'options_framework_theme'),
        '8' => __('8', 'options_framework_theme'),
        '9' => __('9', 'options_framework_theme'),
        '10' => __('10', 'options_framework_theme'),
        '20' => __('20', 'options_framework_theme'),
        '25' => __('25', 'options_framework_theme'),
        '50' => __('50', 'options_framework_theme')
    );

    // Test data
    $test_array = array(
        'one' => __('One', 'options_framework_theme'),
        'two' => __('Two', 'options_framework_theme'),
        'three' => __('Three', 'options_framework_theme'),
        'four' => __('Four', 'options_framework_theme'),
        'five' => __('Five', 'options_framework_theme')
    );

    // Multicheck Array
    $multicheck_array = array(
        'one' => __('French Toast', 'options_framework_theme'),
        'two' => __('Pancake', 'options_framework_theme'),
        'three' => __('Omelette', 'options_framework_theme'),
        'four' => __('Crepe', 'options_framework_theme'),
        'five' => __('Waffle', 'options_framework_theme')
    );

    // Multicheck Defaults
    $multicheck_defaults = array(
        'one' => '1',
        'five' => '1'
    );

    // Background Defaults
    $background_defaults = array(
        'color' => '',
        'image' => '',
        'repeat' => 'repeat',
        'position' => 'top center',
        'attachment'=>'scroll' );

    // Typography Defaults
    $typography_defaults = array(
        'size' => '12px',
        'face' => 'Georgia',
        'style' => 'normal',
        'color' => '#000000' );
        
    // Typography Options
    $typography_options = array(
        'sizes' => array( '6','8', '9', '10', '12','14','16','18', '20' ),
        //'sizes' => array( '0.25','0.50','0.75','0.80','1.00', '1.20', '1.25', '1.40' ),
        //'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
        'faces' => array(
            'Georgia' => 'Georgia',
            'Trebuchet MS' => 'Trebuchet MS',
            'Verdana' => 'Verdana',
            'Helvetica' => 'Helvetica',
            'Helvetica Neue' => 'Helvetica Neue',
            'Arial' => 'Arial'
               ),
        'styles' => array(
            'normal' => 'Normal',
            'bold' => 'Bold',
            'italic' => 'Italic',
               ),
        'color' => true
    );

    // Pull all the categories into an array
    $options_categories = array();
    $options_categories_obj = get_categories();
    foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
    }
    
    // Pull all tags into an array
    $options_tags = array();
    $options_tags_obj = get_tags();
    foreach ( $options_tags_obj as $tag ) {
        $options_tags[$tag->term_id] = $tag->name;
    }


    // Pull all the pages into an array
    $options_pages = array();
    $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
    $options_pages[''] = 'Select a page:';
    foreach ($options_pages_obj as $page) {
        $options_pages[$page->ID] = $page->post_title;
    }

    // If using image radio buttons, define a directory path
    $imagepath =  get_template_directory_uri() . '/images/';

    $imagepath_bg_sm =  get_stylesheet_directory_uri() . '/images/fibblesnork/sm/';
    $imagepath_bg_lg =  get_stylesheet_directory_uri() . '/images/fibblesnork/lg/';

    $options = array();

    /**  Colors Tab **/
    $options[] = array(
        'name' => __('Colors', 'options_framework_theme'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Link', 'options_framework_theme'),
        'desc' => __('Color to display links.', 'options_framework_theme'),
        'id' => 'acme_color_link',
        'std' => '#0000EE',
        'type' => 'color' );

    $options[] = array(
        'name' => __('Visited Link', 'options_framework_theme'),
        'desc' => __('Color to display visited links.', 'options_framework_theme'),
        'id' => 'acme_color_visited_link',
        'std' => '#551A8B',
        'type' => 'color' );

    $options[] = array(
        'name' => __('Active/Hover Link', 'options_framework_theme'),
        'desc' => __('Color to display links which are active or hovered over.', 'options_framework_theme'),
        'id' => 'acme_color_active_hover_link',
        'std' => '#EE0000',
        'type' => 'color' );

    $options[] = array(
        'name' => __('Widget Title Border Color', 'options_framework_theme'),
        'desc' => __('Color to display the border which appears under widget titles.', 'options_framework_theme'),
        'id' => 'acme_color_widget_title_border',
        'std' => '#EE0000',
        'type' => 'color' );

    $options[] = array(
        'name' => __('Entry Title Border Color', 'options_framework_theme'),
        'desc' => __('Color to display the border which appears under entry titles.', 'options_framework_theme'),
        'id' => 'acme_color_entry_title_border',
        'std' => '#EE0000',
        'type' => 'color' );

    $options[] = array(
        'name' => __('Sticky Post Background Color', 'options_framework_theme'),
        'desc' => __('Color to display the background of sticky posts.', 'options_framework_theme'),
        'id' => 'acme_color_sticky_post_background',
        'std' => '#E0E0E0',
        'type' => 'color' );

    /**  Header Tab **/
    $options[] = array(
        'name' => __('Header', 'options_framework_theme'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Custom Header Support', 'options_framework_theme'),
        'desc' => __('This theme supports Custom Header Images using this site\'s <a href="' . admin_url('themes.php?page=custom-header') . '">Custom Header</a> feature to upload your own header.  The remainder of the settings on this page affect the CSS applied to the various elements which comprise the header.  The content for the Site Title and Site Descritption (aka Tagline) are set on ths site\'s <a href="' . admin_url('options-general.php') . '">General Settings</a> page.', 'options_framework_theme'),
        'type' => 'info');

    $options[] = array(
        'name' => __('Site Description', 'options_framework_theme'),
        'desc' => __('Site Description Display<i>(default is "Block", set to "None" to hide this block)</i>.', 'options_framework_theme'),
        'id' => 'acme_site_description_display',
        'std' => 'block',
        'type' => 'select',
        'class'=> 'mini',
        'options' => $display_array);

    $options[] = array(
        'name' => __('Site Title', 'options_framework_theme'),
        'desc' => __('Site Title Display<i>(default is "Block", set to "None" to hide this block)</i>.', 'options_framework_theme'),
        'id' => 'acme_site_title_display',
        'std' => 'block',
        'type' => 'select',
        'class'=> 'mini',
        'options' => $display_array);

    $options[] = array(
        'name' => __('Branding Image', 'options_framework_theme'),
        'desc' => __('WordPress refers to the site\'s header image as the "branding" image.  The following settings allow you to control how the "branding" image is displayed and the borders which surround it.', 'options_framework_theme'),
        'type' => 'info');

    $options[] = array(
        'name' => __('Header Width', 'options_framework_theme'),
        'desc' => __('Header Width <i>(in pixels)</i>.', 'options_framework_theme'),
        'id' => 'acme_branding_image_width',
        'std' => '940',
        'class' => 'mini',
        'type' => 'text');

    $options[] = array(
        'name' => __('Header Height', 'options_framework_theme'),
        'desc' => __('Header Height <i>(in pixels)</i>.', 'options_framework_theme'),
        'id' => 'acme_branding_image_height',
        'std' => '198',
        'class' => 'mini',
        'type' => 'text');

    $options[] = array(
        'name' => __('Branding Image Display', 'options_framework_theme'),
        'desc' => __('Branding Image Display<i>(default is "Block", set to "None" to hide this block)</i>.', 'options_framework_theme'),
        'id' => 'acme_branding_image_display',
        'std' => 'block',
        'type' => 'select',
        'class'=> 'mini',
        'options' => $display_array);

    $options[] = array(
        'name' => __('Branding Image Border Top', 'options_framework_theme'),
        'desc' => __('Branding Image Border Top <i>(width in pixels)</i>.', 'options_framework_theme'),
        'id' => 'acme_branding_image_border_top',
        'std' => 'three',
        'type' => 'select',
        'class' => 'mini', //mini, tiny, small
        'options' => $width_array);

    $options[] = array(
        'name' => __('Branding Image Border Bottom', 'options_framework_theme'),
        'desc' => __('Branding Image Border Bottom <i>(width in pixels)</i>.', 'options_framework_theme'),
        'id' => 'acme_branding_image_border_bottom',
        'std' => 'three',
        'type' => 'select',
        'class' => 'mini', //mini, tiny, small
        'options' => $width_array);

    $options[] = array(
        'name' => __('Branding Image Border Left', 'options_framework_theme'),
        'desc' => __('Branding Image Border Left <i>(width in pixels)</i>.', 'options_framework_theme'),
        'id' => 'acme_branding_image_border_left',
        'std' => 'three',
        'type' => 'select',
        'class' => 'mini', //mini, tiny, small
        'options' => $width_array);

    $options[] = array(
        'name' => __('Branding Image Border Right', 'options_framework_theme'),
        'desc' => __('Branding Image Border Right <i>(width in pixels)</i>.', 'options_framework_theme'),
        'id' => 'acme_branding_image_border_right',
        'std' => 'three',
        'type' => 'select',
        'class' => 'mini', //mini, tiny, small
        'options' => $width_array);

    $options[] = array(
        'name' => __('Branding Image Border Color', 'options_framework_theme'),
        'desc' => __('<i>(default is black #000000)</i>.', 'options_framework_theme'),
        'id' => 'acme_branding_image_border_color',
        'std' => '#000000',
        'type' => 'color' );
        
    /**  Background Tab **/
    /*
    $options[] = array(
        'name' => __('Background', 'options_framework_theme'),
        'type' => 'heading');

    $options[] = array(
        'name' => 'Background Image Selector',
        'desc' => 'Images for page background.',
        'id' => 'acme_background_image',
        'std' => 'bricks-red-40',
        'type' => "images",
        'options' => array(
            //'1col-fixed' => $imagepath . '1col.png',
            //'2c-l-fixed' => $imagepath . '2cl.png',
            //'2c-r-fixed' => $imagepath . '2cr.png',
            'bricks-aqua-40' => $imagepath_bg_sm . 'bricks-aqua-40.jpg',
            'bricks-aqua-60' => $imagepath_bg_lg . 'bricks-aqua-60.jpg',
            'bricks-black-40' => $imagepath_bg_sm . 'bricks-black-40.jpg',
            'bricks-black-60' => $imagepath_bg_lg . 'bricks-black-60.jpg',
            'bricks-blue-40' => $imagepath_bg_sm . 'bricks-blue-40.jpg',
            'bricks-blue-60' => $imagepath_bg_lg . 'bricks-blue-60.jpg',
            'bricks-brown-40' => $imagepath_bg_sm . 'bricks-brown-40.jpg',
            'bricks-brown-60' => $imagepath_bg_lg . 'bricks-brown-60.jpg',
            'bricks-gray-40' => $imagepath_bg_sm . 'bricks-gray-40.jpg',
            'bricks-gray-60' => $imagepath_bg_lg . 'bricks-gray-60.jpg',
            'bricks-green-40' => $imagepath_bg_sm . 'bricks-green-40.jpg',
            'bricks-green-60' => $imagepath_bg_lg . 'bricks-green-60.jpg',
            'bricks-grey-40' => $imagepath_bg_sm . 'bricks-grey-40.jpg',
            'bricks-grey-60' => $imagepath_bg_lg . 'bricks-grey-60.jpg',
            'bricks-ltblue-40' => $imagepath_bg_sm . 'bricks-ltblue-40.jpg',
            'bricks-ltblue-60' => $imagepath_bg_lg . 'bricks-ltblue-60.jpg',
            'bricks-ltbrown-40' => $imagepath_bg_sm . 'bricks-ltbrown-40.jpg',
            'bricks-ltbrown-60' => $imagepath_bg_lg . 'bricks-ltbrown-60.jpg',
            'bricks-mauve-40' => $imagepath_bg_sm . 'bricks-mauve-40.jpg',
            'bricks-mauve-60' => $imagepath_bg_lg . 'bricks-mauve-60.jpg',
            'bricks-orange-40' => $imagepath_bg_sm . 'bricks-orange-40.jpg',
            'bricks-orange-60' => $imagepath_bg_lg . 'bricks-orange-60.jpg',
            'bricks-pink-40' => $imagepath_bg_sm . 'bricks-pink-40.jpg',
            'bricks-pink-60' => $imagepath_bg_lg . 'bricks-pink-60.jpg',
            'bricks-purpblue-40' => $imagepath_bg_sm . 'bricks-purpblue-40.jpg',
            'bricks-purpblue-60' => $imagepath_bg_lg . 'bricks-purpblue-60.jpg',
            'bricks-purple-40' => $imagepath_bg_sm . 'bricks-purple-40.jpg',
            'bricks-purple-60' => $imagepath_bg_lg . 'bricks-purple-60.jpg',
            'bricks-red-40' => $imagepath_bg_sm . 'bricks-red-40.jpg',
            'bricks-red-60' => $imagepath_bg_lg . 'bricks-red-60.jpg',
            'bricks-tan-40' => $imagepath_bg_sm . 'bricks-tan-40.jpg',
            'bricks-tan-60' => $imagepath_bg_lg . 'bricks-tan-60.jpg',
            'bricks-white-40' => $imagepath_bg_sm . 'bricks-white-40.jpg',
            'bricks-white-60' => $imagepath_bg_lg . 'bricks-white-60.jpg',
            'bricks-yellow-40' => $imagepath_bg_sm . 'bricks-yellow-40.jpg',
            'bricks-yellow-60' => $imagepath_bg_lg . 'bricks-yellow-60.jpg',
        )
    );
     */

    /**  Typography Tab **/
    $options[] = array(
        'name' => __('Typography', 'options_framework_theme'),
        'type' => 'heading');
        
    $options[] = array( 'name' => __('Default Typography', 'options_framework_theme'),
        'desc' => __('Default Typography.', 'options_framework_theme'),
        'id' => 'acme_default_typography',
        'std' => $typography_defaults,
        'type' => 'typography',
        'options' => $typography_options
           );
        
    $options[] = array(
        'name' => __('Block Quote Typography', 'options_framework_theme'),
        'desc' => __('Block Quote typography options.', 'options_framework_theme'),
        'id' => "acme_blockquote_typography",
        'std' => $typography_defaults,
        'type' => 'typography',
        'options' => $typography_options
           );

    $options[] = array(
        'name' => __('Post/Page Content Typography', 'options_framework_theme'),
        'desc' => __('Post/Page Content typography options.', 'options_framework_theme'),
        'id' => "acme_post_page_content_typography",
        'std' => $typography_defaults,
        'type' => 'typography',
        'options' => $typography_options
           );

    $options[] = array(
        'name' => __('Sticky Post Content Typography', 'options_framework_theme'),
        'desc' => __('Sticky Post Content typography options.', 'options_framework_theme'),
        'id' => "acme_sticky_post_content_typography",
        'std' => $typography_defaults,
        'type' => 'typography',
        'options' => $typography_options
           );

/**
    $options[] = array(
        'name' => __('Basic Settings', 'options_framework_theme'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Input Text Mini', 'options_framework_theme'),
        'desc' => __('A mini text input field.', 'options_framework_theme'),
        'id' => 'example_text_mini',
        'std' => 'Default',
        'class' => 'mini',
        'type' => 'text');

    $options[] = array(
        'name' => __('Input Text', 'options_framework_theme'),
        'desc' => __('A text input field.', 'options_framework_theme'),
        'id' => 'example_text',
        'std' => 'Default Value',
        'type' => 'text');

    $options[] = array(
        'name' => __('Textarea', 'options_framework_theme'),
        'desc' => __('Textarea description.', 'options_framework_theme'),
        'id' => 'example_textarea',
        'std' => 'Default Text',
        'type' => 'textarea');

    $options[] = array(
        'name' => __('Input Select Small', 'options_framework_theme'),
        'desc' => __('Small Select Box.', 'options_framework_theme'),
        'id' => 'example_select',
        'std' => 'three',
        'type' => 'select',
        'class' => 'mini', //mini, tiny, small
        'options' => $test_array);

    $options[] = array(
        'name' => __('Input Select Wide', 'options_framework_theme'),
        'desc' => __('A wider select box.', 'options_framework_theme'),
        'id' => 'example_select_wide',
        'std' => 'two',
        'type' => 'select',
        'options' => $test_array);

    if ( $options_categories ) {
    $options[] = array(
        'name' => __('Select a Category', 'options_framework_theme'),
        'desc' => __('Passed an array of categories with cat_ID and cat_name', 'options_framework_theme'),
        'id' => 'example_select_categories',
        'type' => 'select',
        'options' => $options_categories);
    }
    
    if ( $options_tags ) {
    $options[] = array(
        'name' => __('Select a Tag', 'options_check'),
        'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
        'id' => 'example_select_tags',
        'type' => 'select',
        'options' => $options_tags);
    }

    $options[] = array(
        'name' => __('Select a Page', 'options_framework_theme'),
        'desc' => __('Passed an pages with ID and post_title', 'options_framework_theme'),
        'id' => 'example_select_pages',
        'type' => 'select',
        'options' => $options_pages);

    $options[] = array(
        'name' => __('Input Radio (one)', 'options_framework_theme'),
        'desc' => __('Radio select with default options "one".', 'options_framework_theme'),
        'id' => 'example_radio',
        'std' => 'one',
        'type' => 'radio',
        'options' => $test_array);

    $options[] = array(
        'name' => __('Example Info', 'options_framework_theme'),
        'desc' => __('This is just some example information you can put in the panel.', 'options_framework_theme'),
        'type' => 'info');

    $options[] = array(
        'name' => __('Input Checkbox', 'options_framework_theme'),
        'desc' => __('Example checkbox, defaults to true.', 'options_framework_theme'),
        'id' => 'example_checkbox',
        'std' => '1',
        'type' => 'checkbox');

    $options[] = array(
        'name' => __('Advanced Settings', 'options_framework_theme'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Check to Show a Hidden Text Input', 'options_framework_theme'),
        'desc' => __('Click here and see what happens.', 'options_framework_theme'),
        'id' => 'example_showhidden',
        'type' => 'checkbox');
        
    $options[] = array(
        'name' => __('Hidden Text Input', 'options_framework_theme'),
        'desc' => __('This option is hidden unless activated by a checkbox click.', 'options_framework_theme'),
        'id' => 'example_text_hidden',
        'std' => 'Hello',
        'class' => 'hidden',
        'type' => 'text');

    $options[] = array(
        'name' => __('Uploader Test', 'options_framework_theme'),
        'desc' => __('This creates a full size uploader that previews the image.', 'options_framework_theme'),
        'id' => 'example_uploader',
        'type' => 'upload');

 */
    $options[] = array(
        'name' => __('Background', 'options_framework_theme'),
        'type' => 'heading' );

    $options[] = array(
        'name' =>  __('Customize the Background', 'options_framework_theme'),
        'desc' => __('Change the background CSS by selecting a color and/or background image.', 'options_framework_theme'),
        'id' => 'acme_background',
        'std' => $background_defaults,
        'type' => 'background' );

    /*
    $options[] = array(
        'name' => __('Multicheck', 'options_framework_theme'),
        'desc' => __('Multicheck description.', 'options_framework_theme'),
        'id' => 'example_multicheck',
        'std' => $multicheck_defaults, // These items get checked by default
        'type' => 'multicheck',
        'options' => $multicheck_array);

    $options[] = array(
        'name' => __('Colorpicker', 'options_framework_theme'),
        'desc' => __('No color selected by default.', 'options_framework_theme'),
        'id' => 'example_colorpicker',
        'std' => '',
        'type' => 'color' );
**/

    $options[] = array(
        'name' => __('Footer', 'options_framework_theme'),
        'type' => 'heading' );

    $options[] = array(
        'name' => __('Site Info', 'options_framework_theme'),
        'desc' => __('Site Info Display<i>(default is "Block", set to "None" to hide this block)</i>.', 'options_framework_theme'),
        'id' => 'acme_site_info_display',
        'std' => 'block',
        'type' => 'select',
        'class'=> 'mini',
        'options' => $display_array);

    $options[] = array(
        'name' => __('Site Info Typography', 'options_framework_theme'),
        'desc' => __('Site Info typography options.', 'options_framework_theme'),
        'id' => "acme_site_info_typography",
        'std' => $typography_defaults,
        'type' => 'typography',
        'options' => $typography_options
           );

    /**
     * For $settings options see:
     * http://codex.wordpress.org/Function_Reference/wp_editor
     *
     * 'media_buttons' are not supported as there is no post to attach items to
     * 'textarea_name' is set by the 'id' you choose
     */

     $wp_editor_settings = array(
        'wpautop' => true, // Default
        'textarea_rows' => 5,
        'tinymce' => array( 'plugins' => 'wordpress' )
    );
    
    $options[] = array(
        'name' => __('Site Credits', 'options_framework_theme'),
        'desc' => sprintf( __( 'Customize how the site credits appear.  Available keyword substitions:  %%DAY%%, %%MONTH%%, %%YEAR%%, %%SITENAME%%, %%TAGLINE%%')),
        'id' => 'acme_credits',
        'type' => 'editor',
        'std' => '<p style="text-align: right;">Copyright &copy; 2012-%YEAR%, %SITENAME% - All rights reserved.<br></p>',
        'settings' => $wp_editor_settings );

    //  Custom CSS
    $options[] = array(
        'name' => __('CSS', 'options_framework_theme'),
        'type' => 'heading' );

    $options[] = array(
        'name' => __('Additional CSS', 'options_framework_theme'),
        'desc' => __('Additional CSS rules to output in the header.', 'options_framework_theme'),
        'id' => 'acme_additional_css',
        'std' => '/**  Additional CSS **/',
        'settings' => array('rows' => 20),
        'type' => 'textarea');

    return $options;
}

function optionsframework_options_defaults() {
    $options = optionsframework_options() ;

    $defaults = array() ;

    foreach($options as $option)
        $defaults[$option['id']] = array_key_exists('std', $option) ? $option['std'] : '' ;

    return $defaults ;
}
?>
