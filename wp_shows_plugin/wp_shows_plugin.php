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
register_activation_hook(__FILE__, 'wp_shows_plugin_activation');
register_deactivation_hook(__FILE__, 'wp_shows_plugin_deactivation');

// set some basic path variables
$wpsp_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$wpsp_path_lang = dirname( plugin_basename( __FILE__ ) ) ."/";

// include translations
load_plugin_textdomain( 'wpsp', false, $wpsp_path);

// include the database activation and deactivation steps
include "database/activate_db_1.0.0.php";
include "database/deactivate_db_1.0.0.php";
include "admin/wpsp_administration.php";
require "dao/wpsp_Genre.php";

function wp_shows_plugin_activation() {
	plugin_activate_db_1_0_0(); // to find under plugin database activation scripts
}

function wp_shows_plugin_deactivation() {
	plugin_deactivate_db_1_0_0(); // to find under plugin database deactivation scripts
}

// function for creating the admin menu
function wp_shows_create_show_adminmenu() {
	add_submenu_page('edit.php?post_type=wpsp_shows', __('Optionen'), __('Optionen'), 'manage_options', 'wpsp-options', 'wpsp_settings' );
}

// functions for editing the shows in the admin panel
function wp_shows_create_show_posttype() {
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
	$nonce= wp_create_nonce('wpsp_shows_nonce');
}

function wpsp_shows_posts_columns($columns) {
	return array(
		'cb'         => '<input type="checkbox" />',
        'title'      => __('Sendung'),
        'datum'      => __('Datum'),
        'start_time' => __('Beginn'),
        'end_time'   => __('Ende'),
        'genre'      => __('Genre'),
		'repeat'     => __('Wiederkehrend'),
		'moderator'  => __('Moderator'),
    );
}

function wpsp_shows_sortable_columns() {
	return array(
		'title'      => 'Sendung',
		'datum'      => 'Datum',
		'start_time' => 'Beginn',
		'end_time'   => 'Ende',
		'genre'      => 'Genre',
		'moderator'  => 'Moderator',
	);
}

function wpsp_shows_posts_custom_column($column) {
	switch ( $column ) {
		case "start_time":
			$start_time = get_post_meta( $post_id, 'wpsp_start_time', true);
			echo $start_time;
			break;
		case "end_time":
			$end_time = get_post_meta( $post_id, 'wpsp_end_time', true);
			echo $end_time;
			break;
		case "genre":
			$genre_id = get_post_meta( $post_id, 'wpsp_genre', true);
			$genre = new wpsp_Genre($genre_id);
			echo $genre->title;
			break;
	}
}

// Add a Show Type to the feed
/**
function wpsp_shows_add_to_feed( $qv ) {
	if ( isset($qv['feed']) && !isset($qv['post_type']) ) {
		$qv['post_type'] = array('post', 'wpsp_shows');
	}
	return $qv;
}
**/

// MetaBoxes for Show - custom fields in Admin UI
function wpsp_shows_metabox_startendtime( $post ) {
	$starttime = get_post_meta( $post->ID, 'wpsp_start_time', true );
	$endtime = get_post_meta( $post->ID, 'wpsp_start_time', true );
	echo "<div style=\"height: 5px\"></div>\n";
	echo "<div class=\"wpsp_startendtime_input\">";
	echo "<label for=\"wpsp_starttime_".$post->ID."\">".__('Von').":</label><select id=\"wpsp_starttime_".$post->ID."\" name=\"wpsp_start_time\" value=\"".$starttime."\">";
	$timearray = array ('00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00');
	foreach ($timearray as $timestring) {
		echo "<option>$timestring</option>";
	}
	echo "</select>\n";
	
	echo "<label for=\"wpsp_endtime_".$post->ID."\">".__('Bis').":</label><select id=\"wpsp_endtime_".$post->ID."\" name=\"wpsp_end_time\" value=\"".$endtime."\">";
	foreach ($timearray as $timestring) {
		echo "<option>$timestring</option>";
	}
	echo "</select></div>\n";
}

function wpsp_shows_metabox_genre( $post ) {
	$genres = wpsp_Genre::getAll();
	echo "<div style=\"height: 5px\"></div>\n";
	foreach ($genres as $genre) {
		echo "<div class=\"wpsp_genre_input\"><input id=\"wpsp_genre_".$genre->ID."\" type=\"checkbox\" name=\"wpsp_genre\" value=\"".$genre->ID."\"></input>";
		echo "<label for=\"wpsp_genre_".$genre->ID."\" class=\"wpsp_genre_input_label\"><span class=\"wpsp_genre_input_colorbox\" style=\"background-color: #".$genre->color."\">&nbsp;&nbsp;&nbsp;</span>".$genre->title;
		echo "</label></div>\n";
	}
}

// Add the metaboxes
function wp_shows_add_metaboxes() {
	add_meta_box('wpsp_metabox_startendtime',	'Start-/Endzeit', 	'wpsp_shows_metabox_startendtime', 	'wpsp_shows', 'side', 'low'); // metabox for start and endtime of a show
	add_meta_box('wpsp_metabox_genre',			'Genre',			'wpsp_shows_metabox_genre', 		'wpsp_shows', 'side', 'low'); // metabox for genre of a show
}

// include the init scripts
add_action('init', 'wp_shows_load_frontendscript');
add_action('init', 'wp_shows_create_show_posttype');

// add actions for showing the admin menu
add_action('admin_menu', 'wp_shows_create_show_adminmenu');
add_action('admin_init', 'wp_shows_load_backendscript');
add_action('admin_init', 'wp_shows_add_metaboxes');

// add actions for administrating shows on admin panel
add_action('manage_wpsp_shows_posts_columns', 'wpsp_shows_posts_columns');					// custom column names
add_filter('manage_posts_custom_column', 'wpsp_shows_posts_custom_column'); 				// show the values for custom columns
add_filter('manage_edit-wpsp_shows_sortable_columns', 'wpsp_shows_sortable_columns');		// making the columns sortable
// add_filter('request', 'wpsp_shows_add_to_feed');											// add the shows to the blog feed


?>
