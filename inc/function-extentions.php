<?php
/**
 * @package Astrid-Child
 */

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

/**
 * {PLACEHOLDER DESCRIPTION}
 *
 * @param array|null $plugins. If null, returns empty array
 * @return plugin array that matches 'wpemoji'
 */
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