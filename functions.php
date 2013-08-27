<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

function acme_optionsframework_option_name()
{
	//error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    return 'TwentyTen-ACME' ;
}
//add_action('optionsframework_option_name', 'acme_optionsframework_option_name') ;

/* 
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */
 
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_stylesheet_directory_uri() . '/of/inc/' );
	require_once dirname( __FILE__ ) . '/of/inc/options-framework.php';
	require_once dirname( __FILE__ ) . '/of/functions.php';
}

define('ACME_MAJOR_RELEASE', '0');
define('ACME_MINOR_RELEASE', '3');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails, custom headers and backgrounds, and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', get_template_directory() . '/languages' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		'default-color' => 'f1f1f1',
	) );

    //  Load the Options Framework to get the theme options
    //  If nothing is returned, initialize the default values

    $of = get_option( 'optionsframework' );

    // If the option has no saved data, load the defaults

    if ( ! get_option( $of['id'] ) )
    {
        //error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
		optionsframework_setdefaults();
        $of = get_option( 'optionsframework' );
	}
    //error_log(print_r($of, true)) ;
    $acme = get_option( $of['id'] );
    //error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //error_log(print_r($acme['acme_background'], true)) ;

	// The custom header business starts here.

	$custom_header_support = array(
		// The default image to use.
		// The %s is a placeholder for the theme template directory URI.
		'default-image' => get_bloginfo('stylesheet_directory') . '/images/TwentyTen-ACME_Logo_v1.png',
		// The height and width of our custom header.
		'width' => apply_filters( 'twentyten_header_image_width', $acme['acme_branding_image_width'] ),
		'height' => apply_filters( 'twentyten_header_image_height', $acme['acme_branding_image_height'] ),
		// Support flexible heights.
		'flex-height' => false,
		// Don't support text inside the header image.
		'header-text' => false,
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'twentyten_admin_header_style',
	);

	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', '' );
		define( 'NO_HEADER_TEXT', true );
		define( 'HEADER_IMAGE', $custom_header_support['default-image'] );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( '', $custom_header_support['admin-head-callback'] );
		add_custom_background();
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// ... and thus ends the custom header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
  		'std' => array(
			'url' => get_bloginfo('stylesheet_directory') . '/images/TwentyTen-ACME_Logo_v1.png',
			'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/TwentyTen-ACME_Logo_v1-thumbnail.png',
			/* translators: header image description */
			'description' => __( 'TwentyTen-ACME', 'twentyten' )
		)
	) );
}

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
    $of = get_option( 'optionsframework' );
    $of_options = get_option( $of['id'] );

?>
#branding img {
    border-top: <?php printf('%spx solid %s;\n', $of['acme_branding_img_border_top'], $of['acme_branding_img_border_color']);?>
    border-right: <?php printf('%spx solid %s;\n', $of['acme_branding_img_border_right'], $of['acme_branding_img_border_color']);?>
    border-bottom: <?php printf('%spx solid %s;\n', $of['acme_branding_img_border_bottom'], $of['acme_branding_img_border_color']);?>
    border-left: <?php printf('%spx solid %s;\n', $of['acme_branding_img_border_left'], $of['acme_branding_img_border_color']);?>

?>
</style>
<?php
}

/**
 * acme_theme_options_css()
 *
 * Generate inline CSS based on the Theme Options settings.
 */
function acme_theme_options_css() {
?>
<style type="text/css">
<?php
    $of = get_option( 'optionsframework' );
    //error_log(sprintf('->%s<-', print_r($of, true))) ;
    $acme = get_option( $of['id'] );
    //error_log(print_r($acme, true)) ;
    //wp_die('here') ;
	$imagepath_bg_lg =  get_stylesheet_directory_uri() . '/images/fibblesnork/lg/';
    $img = &$acme['acme_background_image'] ;
    $size = (substr($img, strlen($img) - 2, 2) == '40') ? 'sm' : 'lg' ;
  	$imagepath =  sprintf('%s/images/fibblesnork/%s/%s.jpg', get_stylesheet_directory_uri(), $size, $img) ;

    //  Handle background ...

    $bg = &$acme['acme_background'] ;

    if (is_array($bg))
    {
        printf('body, body.login {%s', PHP_EOL) ;
        foreach ($bg as $key => $value)
            if (!empty($value))
            {
                if ($key == 'image')
                    printf('    background-%s: url(%s);%s', $key, $value, PHP_EOL) ;
                else
                    printf('    background-%s: %s;%s', $key, $value, PHP_EOL) ;
            }
        printf('}%s', PHP_EOL) ;
    }
?>
/** Page background **/
/*
body, body.login {
    background: url("<?php printf('%s', $imagepath);?>") repeat scroll -5px 0 #FFFFFF;
}
*/

/**  Site typography **/
body {
    font-family: <?php printf('"%s", sans-serif;%s', $acme['acme_default_typography']['face'], PHP_EOL);?>
    font-size: <?php printf('%s;%s', $acme['acme_default_typography']['size'], PHP_EOL);?>
    color: <?php printf('%s;%s', $acme['acme_default_typography']['color'], PHP_EOL);?>
}

#content {
    font-family: <?php printf('"%s", sans-serif;%s', $acme['acme_post_page_content_typography']['face'], PHP_EOL);?>
    font-size: <?php printf('%s;%s', $acme['acme_post_page_content_typography']['size'], PHP_EOL);?>
    color: <?php printf('%s;%s', $acme['acme_post_page_content_typography']['color'], PHP_EOL);?>
}

blockquote {
    font-family: <?php printf('"%s", sans-serif;%s', $acme['acme_blockquote_typography']['face'], PHP_EOL);?>
    font-size: <?php printf('%s;%s', $acme['acme_blockquote_typography']['size'], PHP_EOL);?>
    color: <?php printf('%s;%s', $acme['acme_blockquote_typography']['color'], PHP_EOL);?>
}

.home .sticky .entry-content {
    font-family: <?php printf('"%s", sans-serif;%s', $acme['acme_post_page_content_typography']['face'], PHP_EOL);?>
    font-size: <?php printf('%s;%s', $acme['acme_sticky_post_content_typography']['size'], PHP_EOL);?>
    color: <?php printf('%s;%s', $acme['acme_sticky_post_content_typography']['color'], PHP_EOL);?>
}

/**  Site Title **/
#site-title{
    display: <?php printf('%s;%s', $acme['acme_site_title_display'], PHP_EOL);?>
}

/**  Site Descriptioin (tagline) **/
#site-description {
    display: <?php printf('%s;%s', $acme['acme_site_description_display'], PHP_EOL);?>
}

/**  Site Infoo (footer) **/
#site-info {
    display: <?php printf('%s;%s', $acme['acme_site_info_display'], PHP_EOL);?>
    font-family: <?php printf('"%s", sans-serif;%s', $acme['acme_site_info_typography']['face'], PHP_EOL);?>
    font-size: <?php printf('%s;%s', $acme['acme_site_info_typography']['size'], PHP_EOL);?>
    color: <?php printf('%s;%s', $acme['acme_site_info_typography']['color'], PHP_EOL);?>
}

#site-info a {
    color: <?php printf('%s;%s', $acme['acme_site_info_typography']['color'], PHP_EOL);?>
}

/**  Branding Image **/
#branding img {
    display: <?php printf('%s;%s', $acme['acme_branding_image_display'], PHP_EOL);?>
    border-top: <?php printf('%spx solid %s;%s', $acme['acme_branding_image_border_top'], $acme['acme_branding_image_border_color'], PHP_EOL);?>
    border-right: <?php printf('%spx solid %s;%s', $acme['acme_branding_image_border_right'], $acme['acme_branding_image_border_color'], PHP_EOL);?>
    border-bottom: <?php printf('%spx solid %s;%s', $acme['acme_branding_image_border_bottom'], $acme['acme_branding_image_border_color'], PHP_EOL);?>
    border-left: <?php printf('%spx solid %s;%s', $acme['acme_branding_image_border_left'], $acme['acme_branding_image_border_color'], PHP_EOL);?>
}

/** Links **/
a:link {
    color: <?php printf('%s;%s', $acme['acme_color_link'], PHP_EOL);?>
}

a:visited {
    color: <?php printf('%s;%s', $acme['acme_color_visited_link'], PHP_EOL);?>
}

a:active,
a:hover {
    color: <?php printf('%s;%s', $acme['acme_color_active_hover_link'], PHP_EOL);?>
}

.widget-title {
    border-bottom: 3px solid <?php printf('%s;%s', $acme['acme_color_widget_title_border'], PHP_EOL);?>
}

.entry-title {
    border-bottom: 4px solid <?php printf('%s;%s', $acme['acme_color_entry_title_border'], PHP_EOL);?>
}

.home .sticky {
    margin-left: -10px;
    background-color: <?php printf('%s;%s', $acme['acme_color_sticky_post_background'], PHP_EOL);?>
}

<?php printf('%s%s', $acme['acme_additional_css'], PHP_EOL);?>
</style>
<?php

}
add_action('wp_head', 'acme_theme_options_css');

/**
 * acme_wp_head()
 *
 */
function acme_wp_head() {
    printf('<meta name="viewport" content="width=device-width" />%s', PHP_EOL) ;
	printf('<link rel="shortcut icon" href="%s/images/favicon.ico" >%s', get_stylesheet_directory_uri(), PHP_EOL) ;

    /**
     * Add support for mobile menus by incorporating
     * the Dropdown-Menus plugin as part of the theme.
     *
     * @see http://wordpress.org/plugins/dropdown-menus/
     */

    if (!is_admin()) {
        if ( ! function_exists( 'dropdown_menu' ) )
            include( 'dropdown-menus/dropdown-menus.php' );
    }
    
    //  TwentyTen-ACME needs jQuery!
    wp_enqueue_script('jquery') ;
    
    //  Load Chosen jQuery plugin to handle dropdown menus on mobile devices

    wp_register_script( 'acme-chosen',
        sprintf('%s/js/chosen/chosen.jquery.min.js', get_stylesheet_directory_uri()), array('jquery'));

    wp_enqueue_script('acme-chosen') ;

    wp_enqueue_style('acme-chosen-css',
        sprintf('%s/js/chosen/chosen.css', get_stylesheet_directory_uri())) ;
}
add_action('wp_head', 'acme_wp_head');

/**
 * twentyten_acme_wp_footer()
 *
 * By default TwentyTen doesn't have an easy way to add the mobile menu
 * block we want nor is there any obvious hooks to use.  Instead of copy
 * and modifying one of TwentyTen template files (which means updates would
 * never be incorporated automatically), we'll use the standard WordPress
 * wp_footer action to construct a DIV element for the mobile menu block.
 * The DIV for the mobile menu block are hidden initially.  When the page
 * loads, a jQuery script will "move" the block to its proper location and
 * then make it visible.
 *
 */
function twentyten_acme_wp_footer()
{
?>
<div id="mobile-menus"><?php dropdown_menu( array(
		'theme_location' => 'primary',
    	'dropdown_title' => '&mdash;&mdash; ' . __('Main Menu', 'twentyten') . ' &mdash;&mdash;',
    	'indent_string' => '&mdash; ',
    	'indent_after' => ''
	) ); ?></div>

<!--  Move the DIV to its proper location -->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#mobile-menus').appendTo($('#masthead'));

        // Create the dropdown base
        //$("<select />").appendTo("#mobile-menus");
        //$("#masthead select").attr("id", "mobile-menus");
        $("#mobile-menus select").addClass("chzn-select");
        /*
        $("#mobile-menus select").attr("data-placeholder", "Go to ...");

        // Create default option "Go to..."
        $("<option />", {
            //"selected": "selected",
            "value"   : "",
            "text"    : ""
        }).appendTo("#mobile-menus select");

        // Populate dropdown with menu items
        $("#access div.menu-header a").each(function() {
            var el = $(this);
            $("<option />", {
            "value"   : el.attr("href"),
            "text"    : el.text()
            }).appendTo("#mobile-menus select");
        });
         */

        // To make dropdown actually work
        // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
        //$("#mobile-menus select").change(function() {
        //    window.location = $(this).find("option:selected").val();
        //});
        $(".chzn-select").chosen({
            disable_search: true,
            width: "100%"
        }) ;
    }) ;

</script>
    
<?php
}

add_action('wp_footer', 'twentyten_acme_wp_footer');

//add_filter( 'dropdown_blank_item_text', 'dropdown_menu_use_menu_title', 10, 2 );
function dropdown_menu_use_menu_title( $title, $args ) {
	return '&mdash;mdash; ' . $args->menu->name . ' &mdash&mdash;';
}

//  Force the menu to return to the default
add_filter( 'dropdown_menus_select_current', '__return_false' );

/**
 * Action to add theme credits
 *
 */
function acme_credits()
{
    $of = get_option( 'optionsframework' );
    $acme = get_option( $of['id'] );
    $txt = is_array($acme) && array_key_exists('acme_credits', $acme) ? trim($acme['acme_credits']) : '' ;
    //error_log(print_r($txt, true)) ;
    //$defaults = optionsframework_options_defaults() ;


    if (empty($txt))
    {
        $txt = __('<p style="text-align: right;">Copyright &copy; 2012-%YEAR%, %SITENAME% - All rights reserved.', 'twentyten') ;
        $txt .= __('<br/><a href="%THEMEURI%">%THEMENAME% %THEMEVERSION%</a> is a child theme of <a href="%PARENTURI%">%PARENTNAME% %PARENTVERSION%</a></p>', 'twentyten') ;
    }

    $theme = wp_get_theme() ;
    $parent = wp_get_theme($theme->get('Template')) ;

    $patterns = array(
        'day' => '/%DAY%/',
        'month' => '/%MONTH%/',
        'year' => '/%YEAR%/',
        'sitename' => '/%SITENAME%/',
        'tagline' => '/%TAGLINE%/',
        'version' => '/%VERSION%/',
        'themename' => '/%THEMENAME%/',
        'themeversion' => '/%THEMEVERSION%/',
        'themeuri' => '/%THEMEURI%/',
        'parentname' => '/%PARENTNAME%/',
        'parentversion' => '/%PARENTVERSION%/',
        'parenturi' => '/%PARENTURI%/',
    ) ;

    $replacements = array(
        'day' => date('d'),
        'month' => date('m'),
        'year' => date('Y') ,
        'sitename' => get_bloginfo('name'), 
        'tagline' => get_bloginfo('description'),
        'version' => sprintf('v%s.%s', ACME_MAJOR_RELEASE, ACME_MINOR_RELEASE),
        'themename' => $theme->Name,
        'themeversion' => sprintf('v%s', $theme->get('Version')),
        'themeuri' => $theme->get('ThemeURI'),
        'parentname' => $parent->Name,
        'parentversion' => sprintf('v%s', $parent->get('Version')),
        'parenturi' => $parent->get('ThemeURI'),
    ) ;

    $txt = sprintf('<div id="acme-footer">%s</div>', preg_replace($patterns, $replacements, $txt)) ;

    $x = of_get_default_values() ;
    //error_log(print_r($x, true)) ;

    echo $txt ;
}

add_action('twentyten_credits', 'acme_credits') ;

/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 * 
 * @see http://wptheming.com/options-framework-plugin/
 */

if ( !function_exists( 'of_get_option' ) ) {
function acme_get_option($name, $default = false) {
	
	$optionsframework_settings = get_option('optionsframework');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
	}
}
}


//  Load AdRotate customizations
require_once(dirname( __FILE__ ) . '/xtra/adrotate.php');

//  Load WooCommerce customizations
require_once(dirname( __FILE__ ) . '/xtra/woocommerce.php');

?>
