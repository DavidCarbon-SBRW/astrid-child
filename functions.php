<?php
/**
 * Astrid child functions
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 */

/**
 * CUSTOM FUNCTIONS CODE BELOW
 */

/** Files **/

/* Function Extentions (Usually to make life easier) */
require get_theme_file_path("inc/function-extentions.php");
/* Customizer (Menu) Addons */
require get_theme_file_path("inc/customizer.php");
/* Add (Injected) Child Theme Inline CSS */
require get_theme_file_path('inc/styles.php');
/* Implement the Custom Header feature. */
require get_theme_file_path("inc/header-shortcode.php");

/* Widgets */
/* Note: Function Name Required to Load It Properly */
function astrid_pro_load_widgets()
{
    $astrid_widgets = ["employees", "map", "posts", "pricing", "services", "timeline"];
    foreach ($astrid_widgets as $astrid_widget) 
    {
        locate_template("/inc/widgets/" . $astrid_widget . "-widget.php", true, false);
    }
}
add_action("after_setup_theme", "astrid_pro_load_widgets");

/** Widgets **/
function astrid_child_widgets_init()
{
    register_widget("Atframework_Map");
    register_widget("Atframework_Timeline");
    register_widget("Atframework_Pricing");
    register_widget("Atframework_Employees_Carousel");
    register_widget("Atframework_Posts_Carousel");
    register_widget("Atframework_Services_Carousel");
}
add_action("widgets_init", "astrid_child_widgets_init");

/** Customizer styles (Admin Screen Only) **/

function astrid_child_customizer_styles($hook)
{
    if ("customize.php" != $hook && "widgets.php" != $hook) 
    {
        return;
    }
    
    wp_enqueue_style("astrid-child-customizer-styles", get_stylesheet_directory_uri() . "/css/customizer.min.css", '', get_theme_version(true));
}
add_action("admin_enqueue_scripts", "astrid_child_customizer_styles");

function astrid_child_customizer_scripts()
{
    wp_enqueue_script("astrid-child-customizer", get_stylesheet_directory_uri() . "/js/customizer.min.js", '', get_theme_version(true), true);
}
add_action("customize_preview_init", "astrid_child_customizer_scripts");

/** Header **/

function astrid_child_scripts()
{
    /* Cache Data */
    $Theme_Parent = get_template_directory_uri();
    $Theme_Child = get_stylesheet_directory_uri();
    $Theme_Parent_Version = get_theme_version(true);
    $Theme_Child_Version = get_theme_version();
    /* Use Optimized HTML Heading for Fonts */
    echo '<link rel="preload" href="'. $Theme_Child . '/fonts/open-sans-v40-latin_latin-ext-300.woff2" as="font" type="font/woff2" crossorigin="anonymous">';
    echo '<link rel="preload" href="'. $Theme_Child . '/fonts/open-sans-v40-latin_latin-ext-300italic.woff2" as="font" type="font/woff2" crossorigin="anonymous">';
    echo '<link rel="preload" href="'. $Theme_Child . '/fonts/open-sans-v40-latin_latin-ext-600.woff2" as="font" type="font/woff2" crossorigin="anonymous">';
    echo '<link rel="preload" href="'. $Theme_Child . '/fonts/open-sans-v40-latin_latin-ext-600italic.woff2" as="font" type="font/woff2" crossorigin="anonymous">';
    echo '<link rel="preload" href="'. $Theme_Child . '/fonts/josefin-sans-v32-latin_latin-ext-300.woff2" as="font" type="font/woff2" crossorigin="anonymous">';
    echo '<link rel="preload" href="'. $Theme_Child . '/fonts/josefin-sans-v32-latin_latin-ext-300italic.woff2" as="font" type="font/woff2" crossorigin="anonymous">';
    /* CSS */
    wp_enqueue_style('base-style-colors', $Theme_Child . '/css/styles/base.colors.min.css', '', $Theme_Child_Version);
    wp_enqueue_style('base-child-style', $Theme_Child . '/css/styles/addons.min.css', '', $Theme_Child_Version);
    wp_enqueue_style('base-style', $Theme_Parent . '/css/styles/base.min.css', '', $Theme_Parent_Version);
    wp_enqueue_style('base-icons', $Theme_Parent . '/fonts/font-awesome.min.css', '', $Theme_Parent_Version);
    /* Scripts */
    wp_enqueue_script('base-child-scripts', $Theme_Child . '/js/scripts.min.js', array('jquery'), $Theme_Child_Version, true);
    wp_enqueue_script('base-child-main', $Theme_Child . '/js/main.min.js', array('jquery'), $Theme_Child_Version, true);
    wp_enqueue_script('base-scripts', $Theme_Parent . '/js/combined.min.js', array('jquery'), $Theme_Parent_Version, true );

	if (is_singular() && comments_open() && get_option('thread_comments')) 
    {
		wp_enqueue_script('comment-reply');
	}

	if (astrid_blog_layout() == 'masonry-layout' && (is_home() || is_archive())) 
    {
		wp_enqueue_script('base-masonry-init', $Theme_Parent . '/js/masonry-init.min.js', array('masonry'), $Theme_Parent_Version, true );		
	}
    
    wp_add_inline_style("DEBUG", "");
}
add_action('wp_enqueue_scripts', 'astrid_child_scripts');

/** Footer **/

/* Custom Footer Credits */
function astrid_custom_credits()
{
    $credits = get_theme_mod("footer_credits");
    if ($credits) {
        echo $credits;
    } else {
        echo '<a href="' . esc_url(__("https://wordpress.org/", "astrid")) . '" target=”_blank”>';
        printf(__("Powered by %s", "astrid"), "WordPress");
        echo "</a>";
    }
}

/** Removal **/

/* Disables WordPress related Functions Classes that gets outputed in the Site Code */
function disable_wordpress_functions()
{
    /* Remove WordPress Generator Meta Tag*/
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters' );
    remove_action('wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles');
    remove_action('wp_enqueue_scripts', 'wp_enqueue_emoji_styles');
    /* Remove Emoji Styles and Scripts */
    remove_action('wp_head', 'print_emoji_detection_script', 7); // Remove Emoji's Styles and Scripts.
    remove_action('embeded_head', 'print_emoji_detection_script');
    remove_action('admin_print_scripts', 'print_emoji_detection_script'); // Remove Emoji's Styles and Scripts.
    remove_action('wp_print_styles', 'print_emoji_styles'); // Remove Emoji's Styles and Scripts.
    remove_action('admin_print_styles', 'print_emoji_styles'); // Remove Emoji's Styles and Scripts.
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
    add_filter('emoji_svg_url', '__return_false');
    /* Styles */
    wp_deregister_style('wp-reset-editor-styles');
    wp_deregister_style('wp-format-library');
    wp_deregister_style('wp-block-library');
    wp_deregister_style('wp-block-library-theme');
    wp_deregister_style('wp-block-directory');
    wp_deregister_style('wp-edit-blocks');
}
add_action("init", 'disable_wordpress_functions', 1);

/* Change Parents Theme functions */
function change_parent_theme_functions() 
{
    /* Disable Parents Php Theme File */
    remove_action('wp_enqueue_scripts', 'astrid_scripts');
    remove_action('wp_enqueue_scripts', 'astrid_custom_styles' );
    remove_action("astrid_footer", "astrid_footer_credits");
    /* Replace Footer Function with new one*/
    add_action("astrid_footer", "astrid_custom_credits");
}
add_action('init', 'change_parent_theme_functions');