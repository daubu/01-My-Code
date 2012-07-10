
var likes = new Object();

likes.vote = function( item , postID ){ 
	if(likes.registration_required){
		if(likes.login_url){
			document.location.href=likes.login_url;
		}else{
			alert("Registration is required to vote a post, but registration is disabled");
		}
	}else{
		jQuery(function(){
			jQuery( '#ajax-indicator' ).css( 'display' , 'block' );
			jQuery.post( ajaxurl , {
				'action' : 'set_like',
				'postID' : postID
			} , function( result ){
				jQuery( '#ajax-indicator' ).css( 'display' , 'none' );
                
                jQuery( item ).parent().addClass("voted");
                
                if( jQuery( item ).parent( 'li' ).length ){
                    if(  jQuery( item ).parent( 'li' ).hasClass( "voted" ) ){
                        if( parseInt( result ) < parseInt( jQuery( item ).find( 'span' ).text() ) ){
                            jQuery( item ).parent( 'li' ).removeClass("voted");
                        }else{
                            if( parseInt( result ) > parseInt( jQuery( item ).find( 'span' ).text() ) ){
                                jQuery( item ).parent( 'li' ).addClass("voted");
                            }
                        }
                    }
                    
                    jQuery( item ).find( 'span' ).html( result );
                }else{
                    if( jQuery( item ).parent().hasClass( "voted" ) ){
                        if( parseInt( result) < parseInt( jQuery( item ).text() ) ){
                            jQuery( item ).parent().removeClass("voted");
                        }else{
                            if( parseInt( result) > parseInt( jQuery( item ).text() ) ){
                                jQuery( item ).parent().addClass("voted");
                            }
                        }
                    }
                    
                    jQuery( item ).html( result );
                }
			});    
		});
	}
}

likes.my = function( author_id , postID , data , customID , append , surpress_click){
	jQuery( '#tabber_voted_panel .author-get-more' ).remove();
	jQuery(function(){
		jQuery(".post_type_selectors").removeClass("current");
		jQuery("#post_type_selected"+customID).addClass("current");
		if(data.length<1){
			//jQuery( '#content .element' ).remove();
			//jQuery( '#content .entry-footer' ).remove();
			jQuery( '#ajax-indicator').css('display','block');
		}

		jQuery.post( ajaxurl , {'action' : 'my_likes' , 'author_id' : author_id , 'postID' : postID , 'data' : data , 'customID' : customID } , function( result ){
			if( result.substr( 0 , 1 ) == '{' ){
				var opt = eval("(" + result + ')');
				likes.my( opt.postID , opt.data , customID );
			}else{
				var data = result;
				if( append ){
					jQuery( '#tabber_voted_panel .author-posts-container' ).append( data );
					jQuery( '#tabber_voted_panel .author-posts-container' ).find( '.did-not-find-voted-posts' ).remove();
				}else{
					jQuery( '#tabber_voted_panel' ).hide();
					jQuery( '#tabber_voted_panel .author-posts-container' ).html( data );
					if( !surpress_click ){
						jQuery( '#voted_menu_item' ).click();
					}
				}
				
				if( jQuery( '#tabber_voted_panel .author-posts-container img' ).length > 0 ){
					jQuery( '#tabber_voted_panel .author-posts-container' ).waitForImages({
						finished:function(){
							jQuery( '#ajax-indicator' ).hide();
							jQuery( '#tabber_voted_panel' ).show();
							jQuery( '#tabber_voted_panel .masonry-container' ).masonry( 'reload' );
						},
						waitForAll:true
					});
				}else{
					jQuery( '#ajax-indicator' ).hide();
					jQuery( '#tabber_voted_panel' ).show();
					jQuery( '#tabber_voted_panel .masonry-container' ).masonry( 'reload' );
				}
				
				var get_more = jQuery( '#tabber_voted_panel .author-posts-container' ).find( '.author-get-more' );
				jQuery( '#tabber_voted_panel' ).append( get_more );
				jQuery( '.hovermore' ).mosaic();
			} 
		}); 
	});
}