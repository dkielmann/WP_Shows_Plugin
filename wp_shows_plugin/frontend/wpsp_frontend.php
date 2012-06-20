<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */

// when showing Frontend, load the required javascripts and css styles
function wpsp_shows_load_frontendscript() {
    if(!is_admin()){
        global $wpsp_path;
        $wpsp_path_frontend_script = $wpsp_path."frontend.js";
        $wpsp_path_frontend_css = $wpsp_path."frontend.css";
        wp_enqueue_script('jquery');
        wp_enqueue_script('wpsp_path_frontend_script', $wpsp_path_frontend_script, '', '', true);
        wp_enqueue_style('wpsp_path_frontend_style', $wpsp_path_frontend_css);
    }
}

?>