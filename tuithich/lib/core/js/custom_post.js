var $slidePanel;

jQuery.fn.slideToElem = function(delay, callback) {
	delay = delay || 300;
	var pos = jQuery(this).offset();
	jQuery('html, body').animate({ scrollTop: pos.top }, delay, callback);
};

jQuery(function(){
	jQuery('#slidePanel')
		.bind('fly', function(e, state, obj) {
			var $this = jQuery(this).stop();
			if (state === true) {
				
				var h2top = jQuery('.loop-container-view').offset().top;
				var pos = jQuery(obj).offset().top; 
				/* var top_possition is defined in /js/all.js.php*/
				$this.show().animate({ top: parseInt(pos) - top_possition + 'px' }, 300); /* w/ small slider*/
			} else {
				$this
					.animate({ top: '700px' }, 300, function() {
						$this.hide();
					});
			} 
		});
		/*jQuery('#slidePanel').bind('click', function() {
			jQuery(this).trigger('fly', false);
		});*/
	
	/* Lightbox  */
	jQuery('a.openFly').live('click', function(e) {
		e.preventDefault();
		var $this = jQuery(this),
			postId = $this.data('id');
			
		if (!postId) return;
		
		jQuery('#ajax-indicator').show();
		jQuery.ajax({
			url: ajaxurl,
			data: '&action=get_single_posts&post_id='+postId,
			type: 'POST',
			cache: false,
			success: function (data) { 
				jQuery('#ajax-indicator').hide();
				jQuery('#slidePanel').html(data);
				//jQuery('#slidePanel').find(".hotkeys-meta").hide();
				$this.slideToElem(300, function() {
					jQuery('#slidePanel').trigger('fly', [true, $this]);
				});
			},
			error: function (xhr) {
				
			}
		});
	});
	
});	

	function get_c_post(custom_posts,active_post_type,nr_posts,post_view, light_box , container_id, taxonomies, terms, labels, index){
		jQuery('#ajax-indicator').show();
		jQuery('#'+container_id).hide();
		jQuery.ajax({
			url: ajaxurl,
			data: '&action=list_posts&active_post_type='+active_post_type+'&custom_posts='+custom_posts+'&nr_posts='+nr_posts+'&post_view='+post_view+'&light_box='+light_box+'&container_id='+container_id+( taxonomies ? ( '&taxonomies='+taxonomies ) : '' ) + ( terms ? ( '&terms='+terms ) : '' ) + ( labels ? ( '&labels='+labels ) : '' ) + ( index ? ( '&index='+index ) : '' ),
			type: 'POST',
			cache: false,
			success: function (data) { 
				jQuery('#ajax-indicator').hide();
				
				jQuery( '#'+container_id ).parents( 'aside' ).css( 'float' , 'none' );
				jQuery('#'+container_id).html(data);
				jQuery('#'+container_id).fadeIn(400,function(){
					jQuery( '#'+container_id ).find( '.masonry-container' ).masonry({
						itemSelector: '.item',
						columnWidth: 290,
						gutterWidth: 30,
						isAnimated: true
					});
					jQuery( '#'+container_id ).find( '.masonry-container' ).masonry( 'reload' );
					jQuery('.hovermore').mosaic();
				});
				
			}
		});
		
	}
	
	function get_post_box( widget_posts_ids , index , targetElem){
		jQuery('#ajax-indicator').show();
		
		jQuery.ajax({
			url: ajaxurl,
			data: '&action=get_single_posts&index='+index+'&widget_posts_ids='+widget_posts_ids,
			type: 'POST',
			cache: false,
			success: function (data) { 
				jQuery('#ajax-indicator').hide();
				jQuery( targetElem ).html( data );
				jQuery( targetElem ).find( '#map_canvas' ).hide();
				jQuery.scrollTo( (jQuery( '#ref' ).offset().top - 15), 400 );
				jQuery( '.hide_post' ).delay( 400 ).slideDown( 'slow' , function(){
					jQuery( targetElem ).find( '#map_canvas' ).show();
					jQuery( map.vr.canvas ).gmapFrontEnd( map_args );
				});
				
			},
			error: function (xhr) {
				
			}
		});
	}

	function close_post(){ 
		jQuery('.hide_post').slideUp();
		jQuery('.hide_post').html('');
	}