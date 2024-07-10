<?php
/**
 * @package Astrid-Child
 */

/**
 * Styles
 */
function astrid_child_custom_styles($custom)
{
    $custom = "";
    
    //Menu style
    $sticky_menu = get_theme_mod("sticky_menu", "sticky");
    if ($sticky_menu == "static") {
        $custom .= ".site-header.has-header { position: absolute;padding:15px 0;}";
        $custom .= ".site-header.header-scrolled {padding:15px 0;}";
        $custom .= ".header-clone {display:none;}";
    } else {
        $custom .= ".site-header {position: fixed;}";
    }

    $menu_style = get_theme_mod('menu_style','inline');
	if ($menu_style == 'centered') {
		$custom .= ".site-header .container { display: block;}"."\n";
		$custom .= ".site-branding { width: 100%; text-align: center;margin-bottom:15px;padding-top:15px;}"."\n";
		$custom .= ".main-navigation { width: 100%;float: none; clear:both;}"."\n";
		$custom .= ".main-navigation ul { float: none;text-align:center;}"."\n";
		$custom .= ".main-navigation li { float: none; display: inline-block;}"."\n";
		$custom .= ".main-navigation ul ul li { display: block; text-align: left;}"."\n";
	}

    //Footer background
    $footer_image = get_theme_mod("footer_background_img");
    if ($footer_image) {
        $custom .=
            ".footer-wrapper { background:url(" .
            esc_url($footer_image) .
            ") no-repeat center;background-size:cover;}";
    }

    //Button sizes
    $buttons_tb_padding = get_theme_mod("buttons_tb_padding", "12");
    $buttons_lr_padding = get_theme_mod("buttons_lr_padding", "30");
    $buttons_font_size = get_theme_mod("buttons_font_size", "14");
    $buttons_rad = get_theme_mod("buttons_radius", "0");
    $custom .=
        ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { padding-top:" .
        intval($buttons_tb_padding) .
        "px;padding-bottom:" .
        intval($buttons_tb_padding) .
        "px; }";
    $custom .=
        ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"]{ padding-left:" .
        intval($buttons_lr_padding) .
        "px;padding-right:" .
        intval($buttons_lr_padding) .
        "px; }";
    $custom .=
        ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-size:" .
        intval($buttons_font_size) .
        "px; }";
    $custom .=
        ".button,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { border-radius:" .
        intval($buttons_rad) .
        "px; }";

    //Single templates
    $ap_emp_fullwidth = get_theme_mod("ap_emp_fullwidth", "0");
    if ($ap_emp_fullwidth == 1) {
        $custom .= ".page-template-single-employee .content-area { width:100%;}";
        $custom .= ".page-template-single-employee .widget-area { display:none;}";
    }
    $ap_emp_center = get_theme_mod("ap_emp_center", "0");
    if ($ap_emp_center == 1) {
        $custom .= ".page-template-single-employee .content-area { text-align:center;}";
    }
    $ap_emp_sidebyside = get_theme_mod("ap_emp_sidebyside", "0");
    if ($ap_emp_sidebyside == 1) {
        $custom .=
            "@media screen and (min-width:991px) { .page-template-single-employee .single-thumb { width:50%;float:left;padding-right:30px;} }";
        $custom .=
            "@media screen and (min-width:991px) { .page-template-single-employee .entry-content { width:50%;float:left;} }";
    }
    $ap_service_fullwidth = get_theme_mod("ap_service_fullwidth", "0");
    if ($ap_service_fullwidth == 1) {
        $custom .= ".page-template-single-service .content-area { width:100%;}";
        $custom .= ".page-template-single-service .widget-area { display:none;}";
    }
    $ap_service_center = get_theme_mod("ap_service_center", "0");
    if ($ap_service_center == 1) {
        $custom .= ".page-template-single-service .content-area { text-align:center;}";
    }
    $ap_service_sidebyside = get_theme_mod("ap_service_sidebyside", "0");
    if ($ap_service_sidebyside == 1) {
        $custom .=
            "@media screen and (min-width:991px) { .page-template-single-service .single-thumb { width:50%;float:left;padding-right:30px;} }";
        $custom .=
            "@media screen and (min-width:991px) { .page-template-single-service .entry-content { width:50%;float:left;} }";
    }
    $ap_project_fullwidth = get_theme_mod("ap_project_fullwidth", "0");
    if ($ap_project_fullwidth == 1) {
        $custom .= ".page-template-single-project .content-area { width:100%;}";
        $custom .= ".page-template-single-project .widget-area { display:none;}";
    }
    $ap_project_center = get_theme_mod("ap_project_center", "0");
    if ($ap_project_center == 1) {
        $custom .= ".page-template-single-project .content-area { text-align:center;}";
    }
    $ap_project_sidebyside = get_theme_mod("ap_project_sidebyside", "0");
    if ($ap_project_sidebyside == 1) {
        $custom .=
            "@media screen and (min-width:991px) { .page-template-single-project .single-thumb { width:50%;float:left;padding-right:30px;} }";
        $custom .=
            "@media screen and (min-width:991px) { .page-template-single-project .entry-content { width:50%;float:left;} }";
    }

    global $post;
    //Single styles
    $single_body_background = get_post_meta(get_the_ID(), "_astrid_child_body_background_key", true);
    $single_post_background = get_post_meta(get_the_ID(), "_astrid_child_post_background_key", true);
    $single_text_color = get_post_meta(get_the_ID(), "_astrid_child_text_color_key", true);
    $hide_menu = get_post_meta(get_the_ID(), "_astrid_child_hide_menu_key", true);
    $hide_title = get_post_meta(get_the_ID(), "_astrid_child_hide_title_key", true);
    $hide_footer = get_post_meta(get_the_ID(), "_astrid_child_hide_footer_key", true);

    if (is_single()) {
        $custom .=
            ".postid-" .
            $post->ID .
            " .site-content > .container { background-color:" .
            esc_attr($single_post_background) .
            " ;}";
        $custom .=
            ".postid-" . $post->ID . " .hentry { background-color:" . esc_attr($single_post_background) . " ;}";
        $custom .=
            ".postid-" .
            $post->ID .
            " .widget-area .widget { background-color:" .
            esc_attr($single_post_background) .
            " ;}";
        $custom .= ".postid-" . $post->ID . " { color:" . esc_attr($single_text_color) . " ;}";
    } elseif (is_page()) {
        $custom .=
            ".page-id-" .
            $post->ID .
            " .site-content > .container { background-color:" .
            esc_attr($single_post_background) .
            " ;}";
        $custom .=
            ".page-id-" . $post->ID . " .hentry { background-color:" . esc_attr($single_post_background) . " ;}";
        $custom .=
            ".page-id-" .
            $post->ID .
            " .widget-area .widget { background-color:" .
            esc_attr($single_post_background) .
            " ;}";
        $custom .= ".page-id-" . $post->ID . " { color:" . esc_attr($single_text_color) . " ;}";
    }
    if (is_single() && $single_body_background) {
        $custom .=
            ".postid-" .
            $post->ID .
            " { background-color:" .
            esc_attr($single_body_background) .
            " !important; background-image: none !important;}";
    } elseif (is_page() && $single_body_background) {
        $custom .=
            ".page-id-" .
            $post->ID .
            " { background-color:" .
            esc_attr($single_body_background) .
            " !important; background-image: none !important;}";
    }

    if ($hide_menu) {
        if (is_single()) {
            $custom .= ".postid-" . $post->ID . " .site-header,.header-clone { display: none;}";
        } elseif (is_page()) {
            $custom .= ".page-id-" . $post->ID . " .site-header,.header-clone { display: none;}";
        }
    }
    if ($hide_title) {
        if (is_single()) {
            $custom .= ".postid-" . $post->ID . " .entry-header { display: none;}";
        } elseif (is_page()) {
            $custom .= ".page-id-" . $post->ID . " .entry-header { display: none;}";
        }
    }
    if ($hide_footer) {
        if (is_single()) {
            $custom .=
                ".postid-" .
                $post->ID .
                " .footer-widgets,.postid-" .
                $post->ID .
                " .site-footer,.postid-" .
                $post->ID .
                " .footer-info { display: none;}";
        } elseif (is_page()) {
            $custom .=
                ".page-id-" .
                $post->ID .
                " .footer-widgets,.page-id-" .
                $post->ID .
                " .site-footer, .page-id-" .
                $post->ID .
                " .footer-info { display: none;}";
        }
    }

    wp_add_inline_style("astrid-child-style", $custom);
}
add_action("wp_enqueue_scripts", "astrid_child_custom_styles");
