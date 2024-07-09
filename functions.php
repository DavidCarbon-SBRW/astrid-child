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
require get_theme_file_path( 'inc/customizer.php' );
/* Styles */
require get_theme_file_path( 'inc/styles.php' );
/* Implement the Custom Header feature. */
require get_theme_file_path( 'inc/header-shortcode.php' );
/* Widgets */
function astrid_pro_load_widgets() {

    $astrid_widgets = array('employees', 'map', 'posts', 'pricing', 'services', 'timeline');
    foreach ( $astrid_widgets as $astrid_widget) {
        locate_template( '/inc/widgets/' . $astrid_widget . '-widget.php', true, false );
    }
}
add_action('after_setup_theme', 'astrid_pro_load_widgets');

/** Widgets **/
function astrid_child_widgets_init() {
    register_widget( 'Atframework_Map' );
    register_widget( 'Atframework_Timeline' );
    register_widget( 'Atframework_Pricing' );
    register_widget( 'Atframework_Employees_Carousel' ); 
    register_widget( 'Atframework_Posts_Carousel' ); 
    register_widget( 'Atframework_Services_Carousel' ); 
}
add_action( 'widgets_init', 'astrid_child_widgets_init' );

/** Scripts **/

function astrid_child_customizer_scripts() {
    wp_enqueue_script( 'astrid-child-customizer', get_stylesheet_directory_uri() . '/js/customizer.min.js', array( 'customize-preview' ), '', true );
}
add_action( 'customize_preview_init', 'astrid_child_customizer_scripts' );

function astrid_child_scripts() {
    wp_enqueue_style( 'astrid-child-style', get_stylesheet_directory_uri() . '/css/styles/addons.min.css');
    wp_enqueue_script( 'astrid-child-scripts', get_stylesheet_directory_uri() . '/js/scripts.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'astrid-child-main', get_stylesheet_directory_uri() . '/js/main.min.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'astrid_child_scripts' );

/** Footer **/

/* Custom Footer Credits */
function astrid_custom_credits() {
    $credits = get_theme_mod('footer_credits');
    if ($credits) {
        echo $credits;
    } else {
		echo '<a href="' . esc_url( __( 'https://wordpress.org/', 'astrid' ) ) . '" target=”_blank”>';
			printf( __( 'Powered by %s', 'astrid' ), 'WordPress' );
		echo '</a>';
    }
}

function astrid_remove_add_footer_actions() {
    remove_action( 'astrid_footer', 'astrid_footer_credits' );
    add_action( 'astrid_footer', 'astrid_custom_credits' );  
}
add_action( 'init', 'astrid_remove_add_footer_actions' );

/** Customizer styles **/
function astrid_child_customizer_styles($hook) {
    if ( ( 'customize.php' != $hook ) && ( 'widgets.php' != $hook ) ) {
        return;
    }   
    wp_enqueue_style( 'astrid-child-customizer-styles', get_stylesheet_directory_uri() . '/css/customizer.min.css' ); 
}
add_action( 'admin_enqueue_scripts', 'astrid_child_customizer_styles' );