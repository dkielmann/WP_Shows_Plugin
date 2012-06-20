<?php
/**
 * @package WP_Show_Plugin
 * @author Daniel Kielmann
 * @version 0.1.0
 */

 // function for creating the admin menu
function wpsp_shows_create_show_adminmenu() {
	add_submenu_page('edit.php?post_type=wpsp_shows', __('Optionen'), __('Optionen'), 'manage_options', 'wpsp-options', 'wpsp_settings' );
}
 
// when showing Backend, load the required javascripts and css styles
function wpsp_shows_load_backendscript() {
	global $wpsp_path;
    $wpsp_path_backend_script = $wpsp_path."assets/js/backend.js";
    $wpsp_path_backend_css = $wpsp_path."assets/css/backend.css";
    wp_enqueue_script('wpsp_path_backend_script', $wpsp_path_backend_script);
    wp_enqueue_style('wpsp_path_backend_style', $wpsp_path_backend_css);
    wp_enqueue_script('jquery');
	
}

// MetaBoxes for Show - custom fields in Admin UI
function wpsp_shows_metabox_shedules( $post ) {
	echo "<div style=\"height: 5px\"></div>\n";
	echo "<div>Hier müssen Die Sendezeiten verwaltet werden</div>";
}

function wpsp_shows_metabox_genre( $post ) {
	$genres = wpsp_Genre::getAll();
	echo "<div style=\"height: 5px\"></div>\n";
	foreach ($genres as $genre) {
		echo "<div class=\"wpsp_genre_input\"><input id=\"wpsp_genre_".$genre->ID."\" type=\"checkbox\" name=\"wpsp_genre\" value=\"".$genre->ID."\"></input>";
		echo "<label for=\"wpsp_genre_".$genre->ID."\" class=\"wpsp_genre_input_label\"><span class=\"wpsp_genre_input_colorbox\" style=\"background-color: #".$genre->color."\">&nbsp;&nbsp;&nbsp;</span>".$genre->title;
		echo "</label></div>\n";
	}
	
	echo "<div>Hier Formular für 'Genre hinzufügen'</div>\n";
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

// Add the metaboxes
function wpsp_shows_add_metaboxes() {
	add_meta_box('wpsp_metabox_startendtime',	__('Sendezeiten'), 		'wpsp_shows_metabox_startendtime', 	'wpsp_shows', 'side', 'low'); // metabox for start and endtime of a show
	add_meta_box('wpsp_metabox_genre',			__('Genre'),			'wpsp_shows_metabox_genre', 		'wpsp_shows', 'side', 'low'); // metabox for genre of a show
}
?>