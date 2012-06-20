function wpsp_genres_ajax_add( formular, responseitem ) {
	jQuery.post(
		wpsp_ajax.ajaxurl,
		{
			action : 'wp_ajax_add_genre',
			wpsp_genre_title : $( "#" + formular + ' #wpsp_genre_title' ).val(),
			wpsp_genre_description : $( "#" + formular + ' #wpsp_genre_description' ).val(),
			wpsp_genre_color : $( "#" + formular + ' #wpsp_genre_color' ).val(),
			
			// send the nonce along with the request
			wp_ajax_add_genre_nonce : wpsp_ajax_genre.wp_ajax_add_genre_nonce
		},
		function( response ) {
			$(responseitem).html( response );
		}
	);
}

function wpsp_genres_ajax_del( formular, responseitem ) {
	jQuery.post(
		wpsp_ajax.ajaxurl,
		{
			action : 'wp_ajax_del_genre',
			wpsp_genre_id : $( "#" + formular + ' #wpsp_genre_id' ).val(),
			
			// send the nonce along with the request
			wp_ajax_del_genre_nonce : wpsp_ajax_genre.wp_ajax_del_genre_nonce
		},
		function( response ) {
			$(responseitem).html( response );
		}
	);
}

function wpsp_genres_ajax_save( formular, responseitem ) {
	jQuery.post(
		wpsp_ajax.ajaxurl,
		{
			action : 'wp_ajax_save_genre',
			wpsp_genre_id : $( "#" + formular + ' #wpsp_genre_id' ).val(),
			wpsp_genre_title : $( "#" + formular + ' #wpsp_genre_title' ).val(),
			wpsp_genre_description : $( "#" + formular + ' #wpsp_genre_description' ).val(),
			wpsp_genre_color : $( "#" + formular + ' #wpsp_genre_color' ).val(),
			
			// send the nonce along with the request
			wp_ajax_save_genre_nonce : wpsp_ajax_genre.wp_ajax_save_genre_nonce
		},
		function( response ) {
			$(responseitem).html( response );
		}
	);
}

function wpsp_genres_ajax_get( formular, responseitem ) {
	jQuery.post(
		wpsp_ajax.ajaxurl,
		{
			action : 'wp_ajax_get_genre',
			wpsp_genre_id : $( "#" + formular + ' #wpsp_genre_id' ).val(),
			
			// send the nonce along with the request
			wp_ajax_get_genre_nonce : wpsp_ajax_genre.wp_ajax_get_genre_nonce
		},
		function( response ) {
			$(responseitem).html( response );
		}
	);
}
