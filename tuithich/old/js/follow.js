
function follow(author_id){
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=follow&author_id='+author_id,
		type: 'POST',
		cache: false,
		success: function () { 
			jQuery('.user'+author_id).removeClass('follow');
			jQuery('.user'+author_id).addClass('follow-no');
            jQuery('.user'+author_id).attr('onclick','unfollow('+author_id+')');
            jQuery('.user'+author_id).attr('title',__('Unfollow'));
		},
		error: function () {
			
		}
	});
}

function unfollow(author_id){
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=unfollow&author_id='+author_id,
		type: 'POST',
		cache: false,
		success: function () { 
			jQuery('.user'+author_id).removeClass('follow-no');
			jQuery('.user'+author_id).addClass('follow');
            jQuery('.user'+author_id).attr('onclick','follow('+author_id+')');
            jQuery('.user'+author_id).attr('title',__('Follow'));
		},
		error: function () {
			
		}
	});
}


function big_follow( author_id , item ){
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=follow&author_id='+author_id,
		type: 'POST',
		cache: false,
		success: function () {
			jQuery( item ).parent().removeClass('btn_follow');
			jQuery( item ).parent().addClass('btn_followed');
			jQuery( item ).attr('onclick','big_unfollow('+author_id+' , this )');
			jQuery( item ).attr('title',__('Unfollow'));
			jQuery( item ).find( 'strong' ).html( __( 'Unfollow' ) );
		},
		error: function () {
			
		}
	});
}

function big_unfollow( author_id , item ){
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=unfollow&author_id='+author_id,
		type: 'POST',
		cache: false,
		success: function () { 
			jQuery( item ).parent().removeClass('btn_followed');
			jQuery( item ).parent().addClass('btn_follow');
			jQuery( item ).attr('onclick','big_follow('+author_id+' , this )');
			jQuery( item ).attr('title',__('Follow'));
			jQuery( item ).find( 'strong' ).html( __( 'Follow' ) );
		},
		error: function () {
			
		}
	});
}