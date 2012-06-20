function wpsp_schedules_ajax_add( formular, responseitem ) {
	jQuery.post(
		wpsp_ajax.ajaxurl,
		{
			action : 'wp_ajax_add_schedules',
			wpsp_schedules_showID : $( "#" + formular + ' #wpsp_schedules_showID' ).val(),
			wpsp_schedules_ts_start : $( "#" + formular + ' #wpsp_schedules_ts_start' ).val(),
			wpsp_schedules_ts_duration : $( "#" + formular + ' #wpsp_schedules_ts_duration' ).val(),
			wpsp_schedules_repeatit : $( "#" + formular + ' #wpsp_schedules_repeatit' ).val(),
			wpsp_schedules_repeatcount : $( "#" + formular + ' #wpsp_schedules_repeatcount' ).val(),
			wpsp_schedules_repeatintervall : $( "#" + formular + ' #wpsp_schedules_repeatintervall' ).val(),
			wpsp_schedules_repeattimes : $( "#" + formular + ' #wpsp_schedules_repeattimes' ).val(),
			wpsp_schedules_repeatuntil : $( "#" + formular + ' #wpsp_schedules_repeatuntil' ).val(),

			// send the nonce along with the request
			wp_ajax_add_schedules_nonce : wpsp_ajax_schedules.wp_ajax_add_schedules_nonce
		},
		function( response ) {
			$(responseitem).html( response );
		}
	);
}

function wpsp_schedules_ajax_del( formular, responseitem ) {
	jQuery.post(
		wpsp_ajax.ajaxurl,
		{
			action : 'wp_ajax_del_schedules',
			wpsp_schedules_id : $( "#" + formular + ' #wpsp_schedules_id' ).val(),
			
			// send the nonce along with the request
			wp_ajax_del_schedules_nonce : wpsp_ajax_schedules.wp_ajax_del_schedules_nonce
		},
		function( response ) {
			$(responseitem).html( response );
		}
	);
}

function wpsp_schedules_ajax_save( formular, responseitem ) {
	jQuery.post(
		wpsp_ajax.ajaxurl,
		{
			action : 'wp_ajax_save_schedules',
			wpsp_schedules_id : $( "#" + formular + ' #wpsp_schedules_id' ).val(),
			wpsp_schedules_showID : $( "#" + formular + ' #wpsp_schedules_showID' ).val(),
			wpsp_schedules_ts_start : $( "#" + formular + ' #wpsp_schedules_ts_start' ).val(),
			wpsp_schedules_ts_duration : $( "#" + formular + ' #wpsp_schedules_ts_duration' ).val(),
			wpsp_schedules_repeatit : $( "#" + formular + ' #wpsp_schedules_repeatit' ).val(),
			wpsp_schedules_repeatcount : $( "#" + formular + ' #wpsp_schedules_repeatcount' ).val(),
			wpsp_schedules_repeatintervall : $( "#" + formular + ' #wpsp_schedules_repeatintervall' ).val(),
			wpsp_schedules_repeattimes : $( "#" + formular + ' #wpsp_schedules_repeattimes' ).val(),
			wpsp_schedules_repeatuntil : $( "#" + formular + ' #wpsp_schedules_repeatuntil' ).val(),
			
			// send the nonce along with the request
			wp_ajax_save_schedules_nonce : wpsp_ajax_schedules.wp_ajax_save_schedules_nonce
		},
		function( response ) {
			$(responseitem).html( response );
		}
	);
}

function wpsp_schedules_ajax_get( formular, responseitem ) {
	jQuery.post(
		wpsp_ajax.ajaxurl,
		{
			action : 'wp_ajax_get_schedules',
			wpsp_schedules_id : $( "#" + formular + ' #wpsp_schedules_id' ).val(),
			
			// send the nonce along with the request
			wp_ajax_get_schedules_nonce : wpsp_ajax_schedules.wp_ajax_get_schedules_nonce
		},
		function( response ) {
			$(responseitem).html( response );
		}
	);
}
