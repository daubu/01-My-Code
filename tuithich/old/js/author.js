
author = new Object();

author.get_timeline = function( user_id , skip ){
	jQuery( '#tabber_timeline_panel .author-get-more' ).remove();

	jQuery( '#ajax-indicator' ).show();
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=get_author_timeline&user_id='+user_id+
				( skip ? ( '&skip='+skip ) : '' )
			,
		type: 'POST',
		cache: false,
		success: function (data) {
            jQuery( '.timeline .purgatory div.timeline_is_empty' ).remove();
            jQuery( '.grid-view .firstdiv div.timeline_is_empty' ).remove();
			jQuery( '.timeline .purgatory' ).append( data );
			jQuery( '.timeline .purgatory' ).waitForImages({
				finished: function(){
					jQuery( '#ajax-indicator' ).hide();
					jQuery( '.timeline .purgatory article' ).each( function( index, item ){
						var first = jQuery( '.grid-view .firstdiv' ).height();
						var second = jQuery( '.grid-view .seconddiv' ).height();
						var height = jQuery( item ).height();
						if( ( first - 30 ) <= second ){
							jQuery( '.grid-view .firstdiv' ).append( item );
						}else{
							jQuery( '.grid-view .seconddiv' ).append( item );
						}
					});
					var get_more = jQuery( '.timeline .purgatory .author-get-more' );
					jQuery( '.timeline' ).append( get_more );
					if( jQuery( '.timeline .purgatory div.timeline_is_empty' ).length > 0 ){
						var timeline_is_empty = jQuery( '.timeline .purgatory div.timeline_is_empty' );
						jQuery( '.grid-view .firstdiv' ).append( timeline_is_empty );
						jQuery( '.timeline .timeline_bg' ).hide();
					}
				}
			});
			jQuery( '.hovermore' ).mosaic();
		}
	});
}

author.get_following = function( user_id , skip ){
	jQuery( '#tabber_following_panel .author-get-more' ).remove();
	jQuery( '#tabber_following_panel p.item' ).remove();
	jQuery( '#ajax-indicator' ).show();
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=get_author_following&user_id='+user_id+
		( skip ? ( '&skip='+skip ) : '' )
		,
	type: 'POST',
	cache: false,
	success: function (data) {
		if( jQuery( '#tabber_following_panel article' ).length == 0 ){
			jQuery( '#tabber_following_panel' ).hide();
		}
		jQuery( '#tabber_following_panel .author-posts-container' ).append( data );
		var get_more = jQuery( '#tabber_following_panel .author-posts-container' ).find( '.author-get-more' );
		jQuery( '#tabber_following_panel' ).append( get_more );
		if( jQuery( '#tabber_following_panel .author-posts-container img' ).length > 0 ){
			jQuery( '#tabber_following_panel .author-posts-container' ).waitForImages({
				finished:function(){
					jQuery( '#ajax-indicator' ).hide();
					jQuery( '#tabber_following_panel' ).show();
					jQuery( '#tabber_following_panel .masonry-container' ).masonry( 'reload' );
				},
				waitForAll:true
			});
		}else{
			jQuery( '#ajax-indicator' ).hide();
			jQuery( '#tabber_following_panel' ).show();
			jQuery( '#tabber_following_panel .masonry-container' ).masonry( 'reload' );
		}
		jQuery( '.hovermore' ).mosaic();
	}
	});
}

author.get_new = function( skip ){
	jQuery( '#tabber_frontpage_new_posts_panel .author-get-more' ).remove();
	jQuery( '#tabber_frontpage_new_posts_panel p.item' ).remove();
	jQuery( '#ajax-indicator' ).show();
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=get_new_posts'+( skip ? ( '&skip='+skip ) : '' )
		,
		type: 'POST',
		cache: false,
		success: function (data) {
			if( jQuery( '#tabber_frontpage_new_posts_panel article' ).length == 0) {
				jQuery( '#tabber_frontpage_new_posts_panel' ).hide();
			}
			jQuery( '#tabber_frontpage_new_posts_panel .author-posts-container' ).append( data );
			var get_more = jQuery( '#tabber_frontpage_new_posts_panel .author-posts-container' ).find( '.author-get-more' );
			jQuery( '#tabber_frontpage_new_posts_panel' ).append( get_more );
			if( jQuery( '#tabber_frontpage_new_posts_panel .author-posts-container img' ).length > 0 ){
				jQuery( '#tabber_frontpage_new_posts_panel .author-posts-container' ).waitForImages({
					finished:function(){
						jQuery( '#ajax-indicator' ).hide();
						jQuery( '#tabber_frontpage_new_posts_panel' ).show();
						jQuery( '#tabber_frontpage_new_posts_panel .masonry-container' ).masonry( 'reload' );
					},
					waitForAll:true
				});
			}else{
				jQuery( '#ajax-indicator' ).hide();
				jQuery( '#tabber_frontpage_new_posts_panel' ).show();
				jQuery( '#tabber_frontpage_new_posts_panel .masonry-container' ).masonry( 'reload' );
			}
			jQuery( '.hovermore' ).mosaic();
		}
	});
}

author.get_popular = function( skip ){
	jQuery( '#tabber_popular_posts_panel .author-get-more' ).remove();
	jQuery( '#tabber_popular_posts_panel p.item' ).remove();
	jQuery( '#ajax-indicator' ).show();
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=get_popular_posts'+( skip ? ( '&skip='+skip ) : '' )
		,
		type: 'POST',
		cache: false,
		success: function (data) {
			if( jQuery( '#tabber_popular_posts_panel article' ).length == 0 ){
				jQuery( '#tabber_popular_posts_panel' ).hide();
			}
			jQuery( '#tabber_popular_posts_panel .author-posts-container' ).append( data );
			var get_more = jQuery( '#tabber_popular_posts_panel .author-posts-container' ).find( '.author-get-more' );
			jQuery( '#tabber_popular_posts_panel' ).append( get_more );
			if( jQuery( '#tabber_popular_posts_panel .author-posts-container p.item' ).length > 0 ){
				var is_empty = jQuery( '#tabber_popular_posts_panel .author-posts-container p.item' );
				jQuery( '#tabber_popular_posts_panel' ).append( is_empty );
			}
			if( jQuery( '#tabber_popular_posts_panel .author-posts-container img' ).length > 0 ){
				jQuery( '#tabber_popular_posts_panel .author-posts-container' ).waitForImages({
					finished:function(){
						jQuery( '#ajax-indicator' ).hide();
						jQuery( '#tabber_popular_posts_panel' ).show();
						jQuery( '#tabber_popular_posts_panel .masonry-container' ).masonry( 'reload' );
					},
					waitForAll:true
				});
			}else{
				jQuery( '#ajax-indicator' ).hide();
				jQuery( '#tabber_popular_posts_panel' ).show();
				jQuery( '#tabber_popular_posts_panel .masonry-container' ).masonry( 'reload' );
			}
			jQuery( '.hovermore' ).mosaic();
		}
	});
}

author.get_followers = function( user_id , skip ){
	jQuery( '#tabber_followers_panel .author-get-more' ).remove();
	jQuery( '#tabber_followers_panel p.item' ).remove();
	jQuery( '#ajax-indicator' ).show();
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=get_author_followers&user_id='+user_id+
		( skip ? ( '&skip='+skip ) : '' )
		,
		type: 'POST',
		cache: false,
		success: function (data) {
			if( jQuery( '#tabber_followers_panel article' ).length == 0 ){
				jQuery( '#tabber_followers_panel' ).hide();
			}
			jQuery( '#tabber_followers_panel .author-posts-container' ).append( data );
			var get_more = jQuery( '#tabber_followers_panel .author-posts-container' ).find( '.author-get-more' );
			jQuery( '#tabber_followers_panel' ).append( get_more );
			if( jQuery( '#tabber_followers_panel .author-posts-container img' ).length > 0 ){
				jQuery( '#tabber_followers_panel .author-posts-container' ).waitForImages({
					finished:function(){
						jQuery( '#ajax-indicator' ).hide();
						jQuery( '#tabber_followers_panel' ).show();
						jQuery( '#tabber_followers_panel .masonry-container' ).masonry( 'reload' );
					},
					waitForAll:true
				});
			}else{
				jQuery( '#ajax-indicator' ).hide();
				jQuery( '#tabber_followers_panel' ).show();
				jQuery( '#tabber_followers_panel .masonry-container' ).masonry( 'reload' );
			}
			jQuery( '.hovermore' ).mosaic();
		}
	});
}

author.get_posts = function( user_id , skip ){
	jQuery( '#tabber_posts_panel .author-get-more' ).remove();
	jQuery( '#tabber_posts_panel p.item' ).remove();
	jQuery( '#ajax-indicator' ).show();
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=get_author_posts&user_id='+user_id+
		( skip ? ( '&skip='+skip ) : '' )
		,
		type: 'POST',
		cache: false,
		success: function (data) {
			if( jQuery( '#tabber_posts_panel article' ).length == 0 ){
				jQuery( '#tabber_posts_panel' ).hide();
			}
			jQuery( '#tabber_posts_panel .author-posts-container' ).append( data );
			var get_more = jQuery( '#tabber_posts_panel .author-posts-container' ).find( '.author-get-more' );
			jQuery( '#tabber_posts_panel' ).append( get_more );
			if( jQuery( '#tabber_posts_panel .author-posts-container img' ).length > 0 ){
				jQuery( '#tabber_posts_panel .author-posts-container' ).waitForImages({
					finished:function(){
						jQuery( '#ajax-indicator' ).hide();
						jQuery( '#tabber_posts_panel' ).show();
						jQuery( '#tabber_posts_panel .masonry-container' ).masonry( 'reload' );
					},
					waitForAll:true
				});
			}else{
				jQuery( '#ajax-indicator' ).hide();
				jQuery( '#tabber_posts_panel' ).show();
				jQuery( '#tabber_posts_panel .masonry-container' ).masonry( 'reload' );
			}
			jQuery( '.hovermore' ).mosaic();
		}
	});
};

jQuery( function(){
	jQuery( '#new_posts_menu_item' ).click( function(){
		if( jQuery( '#tabber_frontpage_new_posts_panel .author-posts-container article' ).length == 0 ){
			author.get_new( 1 );
		}
	});
	
	jQuery( '#popular_posts_menu_item' ).click( function(){
		if( jQuery( '#tabber_popular_posts_panel .author-posts-container article' ).length == 0 ){
			author.get_popular( 1 );
		}
	});
	
	jQuery( '#timeline_menu_item' ).click( function(){
		if( jQuery( '#tabber_timeline_panel .grid-view article' ).not( '#mini-form' ).length == 0 ){
			author.get_timeline( -1 , 1 );
		}
	});
	
	if( document.location.hash.length && ( document.location.hash == '#favorites' || document.location.hash == '#tabber_voted' ) ){
		setTimeout( "jQuery( '#voted_menu_item' ).click()" , 100 );
	}else if( document.location.hash.length && ( document.location.hash == '#following' || document.location.hash == '#tabber_following' ) ){
		setTimeout( "jQuery( '#following_menu_item' ).click()" , 100 );
	}else if( document.location.hash.length && document.location.hash == '#tabber_timeline' ){
		setTimeout( "jQuery( '#timeline_menu_item' ).click()" , 100 );
	}else if( document.location.hash.length && document.location.hash == '#tabber_posts' ){
		setTimeout( "jQuery( '#posts_menu_item' ).click()" , 100 );
	}else if( document.location.hash.length && document.location.hash == '#tabber_popular_posts' ){
		setTimeout( "jQuery( '#popular_posts_menu_item' ).click()" , 100 );
	}else if( document.location.hash.length && document.location.hash == '#tabber_frontpage_new_posts' ){
		setTimeout( "jQuery( '#new_posts_menu_item' ).click()" , 100 );
	}if( document.location.hash.length && ( document.location.hash == '#followers' || document.location.hash == '#tabber_followers' ) ){
		setTimeout( "jQuery( '#followers_menu_item' ).click()" , 100 );
	}
	
	var get_more = jQuery( '#tabber_timeline_panel .author-posts-container' ).find( '.author-get-more' );
	jQuery( '#tabber_timeline_panel' ).append( get_more );
	var get_more = jQuery( '#tabber_following_panel .author-posts-container' ).find( '.author-get-more' );
	jQuery( '#tabber_following_panel' ).append( get_more );
	var get_more = jQuery( '#tabber_followers_panel .author-posts-container' ).find( '.author-get-more' );
	jQuery( '#tabber_followers_panel' ).append( get_more );
	var get_more = jQuery( '#tabber_posts_panel .author-posts-container' ).find( '.author-get-more' );
	jQuery( '#tabber_posts_panel' ).append( get_more );
	
	var get_more = jQuery( '#tabber_frontpage_new_posts_panel .author-posts-container' ).find( '.author-get-more' );
	jQuery( '#tabber_frontpage_new_posts_panel' ).append( get_more );
	var get_more = jQuery( '#tabber_popular_posts_panel .author-posts-container' ).find( '.author-get-more' );
	jQuery( '#tabber_popular_posts_panel' ).append( get_more );
	
});