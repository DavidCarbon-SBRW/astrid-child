<?php

/**
 * Metabox for the single Header
 */

function astrid_header_shortcode_metabox()
{
    new Astrid_Header_Shortcode();
}

if (is_admin()) {
    add_action("load-post.php", "astrid_header_shortcode_metabox");
    add_action("load-post-new.php", "astrid_header_shortcode_metabox");
}

class Astrid_Header_Shortcode
{
    public function __construct()
    {
        add_action("add_meta_boxes", [$this, "add_meta_box"]);
        add_action("save_post", [$this, "save"]);
    }

    public function add_meta_box($post_type)
    {
        global $post;
        add_meta_box(
            "astrid_header_shortcode_metabox",
            __("Header shortcode", "astrid"),
            [$this, "render_meta_box_content"],
            "page",
            "side",
            "default"
        );
    }

    public function save($post_id)
    {
        if (!isset($_POST["astrid_header_shortcode_nonce"])) {
            return $post_id;
        }

        $nonce = $_POST["astrid_header_shortcode_nonce"];

        if (!wp_verify_nonce($nonce, "astrid_header_shortcode")) {
            return $post_id;
        }

        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return $post_id;
        }

        if ("clients" == $_POST["post_type"]) {
            if (!current_user_can("edit_page", $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can("edit_post", $post_id)) {
                return $post_id;
            }
        }

        $shortcode = isset($_POST["astrid_single_header_shortcode"])
            ? wp_kses_post($_POST["astrid_single_header_shortcode"])
            : "";
        update_post_meta($post_id, "_astrid_single_header_shortcode", $shortcode);
    }

    public function render_meta_box_content($post)
    {
        wp_nonce_field("astrid_header_shortcode", "astrid_header_shortcode_nonce");

        $shortcode = get_post_meta($post->ID, "_astrid_single_header_shortcode", true);
        ?>
		<p><em><?php _e('Add a shortcode that will run just for this page\'s header', "astrid"); ?></em></p>
		<p><input type="text" class="widefat" id="astrid_single_header_shortcode" name="astrid_single_header_shortcode" value="<?php echo esc_html(
      $shortcode
  ); ?>"></p>	

	<?php
    }
}