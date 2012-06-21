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
function wpsp_shows_metabox_schedules( $post ) {
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
	
	echo "<div><form>\n";
	echo "</form></div>\n";
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

function wpsp_save_postdata( $post_id ) {
	global $post, $new_meta_boxes;
 
	foreach($new_meta_boxes as $meta_box) {
		// Verify
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
		}
		 
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id )) return $post_id;
		} else {
			if ( !current_user_can( 'edit_post', $post_id )) return $post_id;
		}
		$data = $_POST[$meta_box['name'].'_value'];
		
		if(get_post_meta($post_id, $meta_box['name'].'_value') == "") {
			add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
		} elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true)) {
			update_post_meta($post_id, $meta_box['name'].'_value', $data);
		} elseif($data == "") {
			delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
		}
	}
}

function wpsp_genre_ajax_add() {
	global $wpdb; // this is how you get access to the database

	$whatever = intval( $_POST['whatever'] );

	$whatever += 10;

        echo $whatever;

	die(); // this is required to return a proper result
}

function wpsp_genre_ajax_del() {
	global $wpdb; // this is how you get access to the database

	$whatever = intval( $_POST['whatever'] );

	$whatever += 10;

        echo $whatever;

	die(); // this is required to return a proper result
}
function wpsp_genre_ajax_save() {
	global $wpdb; // this is how you get access to the database

	$whatever = intval( $_POST['whatever'] );

	$whatever += 10;

        echo $whatever;

	die(); // this is required to return a proper result
}

function wpsp_genre_ajax_get() {
	global $wpdb; // this is how you get access to the database

	$whatever = intval( $_POST['whatever'] );

	$whatever += 10;

        echo $whatever;

	die(); // this is required to return a proper result
}

// Option Page for the plugin
function wpsp_shows_options_page() {
	$nonce = wp_nonce_field('wpsp_update_options');
?>
<div class="wrap">
	<?php screen_icon(); ?>
<h2>WPSP Options Page</h2>
<p>
<form method="post" action="options.php">
<?php echo $nonce; ?>
Enter Text: <input name="wpsp_option_categories" type="text" id="wpsp_option_categories"
value="<?php echo get_option('wpsp_option_categories'); ?>" />
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="wpsp_option_categories" />
<input type="submit" value="Save Changes" />
</form>
</p>
</div>
<?php
}

// create some of the nonces
function wpsp_shows_create_nonces() {
	global $wp_ajax_add_genre_nonce;
	global $wp_ajax_del_genre_nonce;
	global $wp_ajax_save_genre_nonce;
	global $wp_ajax_get_genre_nonce;

	global $wp_ajax_add_schedules_nonce;
	global $wp_ajax_del_schedules_nonce;
	global $wp_ajax_save_schedules_nonce;
	global $wp_ajax_get_schedules_nonce;
	
	$wp_ajax_add_genre_nonce = wp_create_nonce( 'wp_ajax_add_genre' );
	$wp_ajax_del_genre_nonce = wp_create_nonce( 'wp_ajax_del_genre' );
	$wp_ajax_save_genre_nonce = wp_create_nonce( 'wp_ajax_save_genre' );
	$wp_ajax_get_genre_nonce = wp_create_nonce( 'wp_ajax_get_genre' );
	
	$wp_ajax_add_schedules_nonce = wp_create_nonce( 'wp_ajax_add_schedule' );
	$wp_ajax_del_schedules_nonce = wp_create_nonce( 'wp_ajax_del_schedule' );
	$wp_ajax_save_schedules_nonce = wp_create_nonce( 'wp_ajax_save_schedule' );
	$wp_ajax_get_schedules_nonce = wp_create_nonce( 'wp_ajax_get_schedule' );
	
	wp_localize_script( 'wpsp_ajax_request_genres', 'wpsp_ajax_genre', array(
		'wp_ajax_add_genre_nonce'	=> $wp_ajax_add_genre_nonce,
		'wp_ajax_del_genre_nonce'	=> $wp_ajax_del_genre_nonce,
		'wp_ajax_save_genre_nonce'	=> $wp_ajax_save_genre_nonce,
		'wp_ajax_get_genre_nonce'	=> $wp_ajax_get_genre_nonce,
		 )
	);

	wp_localize_script( 'wpsp_ajax_request_schedules', 'wpsp_ajax_schedule', array(
		'wp_ajax_add_schedules_nonce'	=> $wp_ajax_add_schedules_nonce,
		'wp_ajax_del_schedules_nonce'	=> $wp_ajax_del_schedules_nonce,
		'wp_ajax_save_schedules_nonce'	=> $wp_ajax_save_schedules_nonce,
		'wp_ajax_get_schedules_nonce'	=> $wp_ajax_get_schedules_nonce,
		 )
	);
}


// Add the metaboxes
function wpsp_shows_add_metaboxes() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box('wpsp_shows_metabox_schedules',	__('Sendezeiten'), 		'wpsp_shows_metabox_schedules', 	'wpsp_shows', 'side', 'low'); // metabox for start and endtime of a show
		add_meta_box('wpsp_shows_metabox_genre',		__('Genre'),			'wpsp_shows_metabox_genre', 		'wpsp_shows', 'side', 'low'); // metabox for genre of a show
	}
}

function wpsp_shows_administration_menu() {
	if ( function_exists('add_options_page') ) {
		add_options_page('wpsp_administration', __('WPSP Settings'), 'manage_options', 'wpsp_shows', 'wpsp_shows_options_page');
	}
}

?>