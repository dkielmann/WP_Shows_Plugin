<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */
 
/*
Plugin Name: WP_Show_Plugin (wpsp)
Plugin URI: https://github.com/dkielmann/WP_Shows_Plugin/wiki
Description: A plugin for administration and sheduling of show plans for online radio stations
Author: Daniel Kielmann
Version: 0.1.0
Author URI: http://www.autoscout24.de
*/

// register functions for activation and deactivation of plugin
register_activation_hook(__FILE__, 'wpsp_shows_plugin_activation');
register_deactivation_hook(__FILE__, 'wpsp_shows_plugin_deactivation');

// set some basic path variables
$wpsp_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$wpsp_path_lang = dirname( plugin_basename( __FILE__ ) ) ."/";

// include translations
load_plugin_textdomain( 'wpsp', false, $wpsp_path);

// include the database activation and deactivation steps
include "database/activate_db_1.0.0.php";
include "database/deactivate_db_1.0.0.php";
include "admin/wpsp_administration.php";
include "frontend/wpsp_frontend.php";
require "dao/wpsp_Genre.php";
require "dao/wpsp_Scheduling.php";

function wpsp_shows_plugin_activation() {
	plugin_activate_db_1_0_0(); // to find under plugin database activation scripts
}

function wpsp_shows_plugin_deactivation() {
	plugin_deactivate_db_1_0_0(); // to find under plugin database deactivation scripts
}

// functions for editing the shows in the admin panel
function wpsp_shows_create_show_posttype() {
    register_post_type('wpsp_shows',
        array(
            'labels' => array(
                'name' => __('Sendungen'),
                'singular_name' => __('Sendung'),
                'add_new' => __('Neue Sendung hinzufügen'),
				'edit_item' => __('Sendung bearbeiten'),
				'not found' => __('Sendung konnte nicht gefunden werden'),
            ),
            'public' => true,
            'has_archive' => true,
			'capability_type' => 'post',
			'supports' => array ('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'page-attributes'),
        )
    );
}

// include the init scripts
add_action('init', 'wpsp_shows_load_frontendscript');
add_action('init', 'wpsp_shows_create_show_posttype');

// add actions for showing the admin menu
add_action('admin_menu', 'wpsp_shows_create_show_adminmenu');
add_action('admin_menu', 'wpsp_shows_administration_menu');
add_action('admin_init', 'wpsp_shows_load_backendscript');
add_action('admin_init', 'wpsp_shows_add_metaboxes');

// add actions for administrating shows on admin panel
add_action('manage_wpsp_shows_posts_columns', 			'wpsp_shows_posts_columns');					// custom column names
add_filter('manage_posts_custom_column', 				'wpsp_shows_posts_custom_column'); 				// show the values for custom columns
add_filter('manage_edit-wpsp_shows_sortable_columns', 	'wpsp_shows_sortable_columns');					// making the columns sortable
// add_filter('request', 'wpsp_shows_add_to_feed');														// add the shows to the blog feed

// functions for administrating Genres
add_action('admin_head', 'wpsp_genre_ajax_javascript');
add_action('wp_ajax_add_genre', 'wpsp_genre_ajax_add');
add_action('wp_ajax_del_genre', 'wpsp_genre_ajax_del');
add_action('wp_ajax_save_genre', 'wpsp_genre_ajax_save');
add_action('wp_ajax_get_genre', 'wpsp_genre_ajax_get');

// embed the javascript file that makes the AJAX request
wp_enqueue_script( 'wpsp_ajax_request_schedules', $wpsp_path."assets/js/schedules_ajax.js", array( 'jquery' ) );
wp_enqueue_script( 'wpsp_ajax_request_genres', $wpsp_path."assets/js/genres_ajax.js", array( 'jquery' ) );
wp_localize_script( 'wpsp_ajax_request', 'wpsp_ajax', array(
    // URL to wp-admin/admin-ajax.php to process the request
    'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
     )
);

add_action('admin_init', 'wpsp_shows_create_nonces');

?>
