<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */

// when showing Backend, load the required javascripts and css styles
function wp_shows_load_backendscript() {
	global $wpsp_path;
    $wpsp_path_backend_script = $wpsp_path."assets/js/backend.js";
    $wpsp_path_backend_css = $wpsp_path."assets/css/backend.css";
    wp_enqueue_script('wpsp_path_backend_script', $wpsp_path_backend_script);
    wp_enqueue_style('wpsp_path_backend_style', $wpsp_path_backend_css);
    wp_enqueue_script('jquery');
	
}

?>