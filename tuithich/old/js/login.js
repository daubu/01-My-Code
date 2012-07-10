var user_archives_link;

function redirect(){
	if( document.referrer.indexOf( login_url ) != -1 ){
		document.location = user_archives_link;
	}else{
		var goto = document.referrer;
		if( goto.indexOf( '?' ) != -1 ){
			goto += '&a=b';
		}else{
			goto += '?a=b';
		}
		document.location = goto;
	}
}

jQuery( '#register_form' ).ready( function(){
	jQuery( '#register_form' ).submit( function( event ){
		jQuery.ajax({
			url: ajaxurl,
			data: '&action=cosmo_register&'+jQuery( '#register_form' ).serialize(),
			type: 'POST',
			cache: false,
			success: function (data) {
				if( data.indexOf( 'success' ) != -1 ){
					user_archives_link = login_url;
					jQuery( '#registration_error' ).removeClass( 'login-error' );
					jQuery( '#registration_error' ).addClass( 'login-success' );
					jQuery( '#registration_error' ).html( __( 'Registration successful. Your password will be emailed to you' ) );
					setTimeout( redirect , 1000 );
				}else{
					jQuery( '#registration_error' ).html( data );
				}
			}
		});
	event.preventDefault();
	});
});
jQuery( '#register_form' ).submit(function(event){
	if( !jQuery( '#check_email' ).val().length || !jQuery( '#user_email' ).val().length || !( jQuery( '#check_email' ).val().length>1 ) || !( jQuery( '#user_email' ).val().length>1 ) )
	{
		jQuery("#registration_error").html( __( 'Enter your e-mail and e-mail verification' ) );
		event.preventDefault();
	}
	else if( jQuery( '#check_email' ).val() != jQuery( '#user_email').val() )
	{
		jQuery("#registration_error").html( __( "Emails don't match" ) );
		event.preventDefault();
	}
	else if( !jQuery( '#user_login' ).val().length || !( jQuery( '#user_login' ).val().length>1 ) )
	{
		jQuery( '#registration_error' ).html( __( "Enter a username" ) );
		event.preventDefault();
	}
});
		
jQuery( '#cosmo-loginform' ).ready( function(){
	jQuery( '#cosmo-loginform' ).submit( function(event){
        jQuery( '#ajax-indicator' ).show();
		jQuery.ajax({
			url: ajaxurl,
			data: '&action=cosmo_login&'+jQuery( '#cosmo-loginform' ).serialize(),
			type: 'POST',
			cache: false,
			success: function (data) {
                jQuery( '#ajax-indicator' ).hide();
				if( data.indexOf( 'success' ) != -1 ){
					user_archives_link = eval( data );
					jQuery( '#registration_error' ).removeClass( 'login-error' );
					jQuery( '#registration_error' ).addClass( 'login-success' );
                    
					jQuery( '#registration_error' ).html( __( 'Login successful' ) );
					setTimeout( redirect , 1000 );
				}else{
					if( data.indexOf( 'Lost your password' ) != -1 )
					{
						data = __( 'Incorrect password' );
					}
					jQuery( '#registration_error' ).html( data );
				}
			}
		});
		event.preventDefault();
	});
});

jQuery( '#lostpasswordform' ).ready( function(){
	jQuery( '#lostpasswordform' ).submit( function(){
		jQuery( '#registration_error' ).html( __( 'Please check your email' ) );
	});
});