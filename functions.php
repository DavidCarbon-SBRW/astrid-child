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

/* Customizer Addons */
require get_theme_file_path("inc/customizer.php");

function disable_emojicons_tinymce($plugins)
{
    if (is_array($plugins)) 
    {
        return array_diff($plugins, array('wpemoji'));
    }
    else
    {
        return array();
    }
}

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

/* Remove (Injected) Parents Theme Inline CSS and Fonts */
function remove_parent_theme_functions() 
{
    /* Disable Parents Php Theme File */
    remove_action('wp_enqueue_scripts', 'astrid_scripts');
    remove_action('wp_enqueue_scripts', 'astrid_custom_styles' );
    add_action('wp_enqueue_scripts','astrid_child_custom_styles');
}
add_action("init", 'remove_parent_theme_functions', 1);

/**
 * Remove Parent Theme fonts
 *
 * Note: Removed due to Main Parent Function being Disabled
 *
function remove_parent_theme_fonts() 
{
    wp_dequeue_style('astrid-body-fonts');
    wp_deregister_style('astrid-body-fonts');
    wp_dequeue_style('astrid-body-fonts');
    wp_deregister_style('astrid-body-fonts');
    wp_dequeue_style('astrid-headings-fonts');
    wp_deregister_style('astrid-headings-fonts');
    wp_dequeue_style('font-awesome');
    wp_deregister_style('font-awesome');
}
add_action( 'wp_enqueue_scripts', 'remove_parent_theme_fonts', 1);
*/

/* Add (Injected) Child Theme Inline CSS */
require get_theme_file_path( 'inc/styles.php' );
/* Implement the Custom Header feature. */
require get_theme_file_path("inc/header-shortcode.php");
/* Widgets */
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

/**
 * Get the version number of a WordPress theme.
 *
 * @param bool|null $theme_slug The slug of the theme. If null, retrieves the current theme (child theme).
 * @return string The version number of the theme.
 */
function get_theme_version($theme_slug = false) 
{
    if ($theme_slug) 
    {
        $theme = wp_get_theme('astrid');
    }
    else
    {
        $theme = wp_get_theme();
    }
    
    return $theme->get('Version');
}

/** Scripts **/

function astrid_child_customizer_scripts()
{
    wp_enqueue_script("astrid-child-customizer", get_stylesheet_directory_uri() . "/js/customizer.min.js", get_theme_version(true), true);
}
add_action("customize_preview_init", "astrid_child_customizer_scripts");

function astrid_child_scripts()
{
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
}
add_action("wp_enqueue_scripts", "astrid_child_scripts");

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

function astrid_remove_add_footer_actions()
{
    remove_action("astrid_footer", "astrid_footer_credits");
    add_action("astrid_footer", "astrid_custom_credits");
}
add_action("init", "astrid_remove_add_footer_actions");

/** Customizer styles **/
function astrid_child_customizer_styles($hook)
{
    if ("customize.php" != $hook && "widgets.php" != $hook) 
    {
        return;
    }
    
    wp_enqueue_style("astrid-child-customizer-styles", get_stylesheet_directory_uri() . "/css/customizer.min.css", '', get_theme_version(true));
}
add_action("admin_enqueue_scripts", "astrid_child_customizer_styles");