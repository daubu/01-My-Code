function close_dl(){ //clode demo login box
	jQuery('#lightbox-shadow').hide();
	jQuery('#demo-container').hide();
}

function login_show(){ // show demo login box
	jQuery('#lightbox-shadow').show();
	jQuery('#demo-container').show();
}

jQuery(document).ready(function(){
	
	if( jQuery( '#demo-container').length > 0 ){
		if( jQuery.cookie('demo_login') != 'yes' ){
			setTimeout("login_show()" , 3000 );
			jQuery.cookie("demo_login",'yes', {expires: 365, path: '/'}); // set cookies to show it only for the first time
		}
		var screen_width = jQuery(window).width();
		if (screen_width >= 400){
			jQuery('#demo-container').css('left',(screen_width/2)-200);
		}
	}
	
	// Related posts
	if( jQuery( '.sidebar .box-related' ).length > 0 ){
		jQuery( window ).resize( function(){
			var width = jQuery( '.sidebar' ).width();
			if( width >= 210 ){
				jQuery( '.sidebar .grid-view article' ).width( 90 );
				jQuery( '.sidebar .grid-view article:nth-child(even)' ).css( 'margin-left' , '30px' );
				jQuery( '.sidebar .grid-view article.noimg' ).css( 'min-height' , '90px' );
			}else{
				jQuery( '.sidebar .grid-view article' ).width( width ).css( 'margin-left' , '0px' );
				jQuery( '.sidebar .grid-view article.noimg' ).css( 'min-height' , '50px' );
				
			}
		});
		jQuery( window ).trigger( 'resize' );
	}

	//Script for grid-view
	jQuery(function(){
	jQuery('.masonry-container').masonry({
		itemSelector: '.item',
		columnWidth: 287,
		gutterWidth: 30,
		isAnimated: true
		});
		jQuery( '.masonry-container img.size' ).load( function(){
			jQuery('.masonry-container').masonry( 'reload' );
		});
	});

	//timeline form
	jQuery('textarea.timeline_text').focus(function () {
         jQuery(this).addClass('focused');
		 if(jQuery(this).val() == 'What\'s on your mind?' ){ /*use translation in wp version */
			jQuery(this).val('');
		 }
		 jQuery('div.timeline_title').removeClass('hidden');
		 jQuery('div.form_btn_submit').removeClass('hidden');
    });
	jQuery('textarea.timeline_text').blur(function () {
         
		 if(jQuery(this).val() == ''){jQuery(this).val('What\'s on your mind?')}
    });
	
	//Scroll to top
	jQuery(window).scroll(function() {
		if(jQuery(this).scrollTop() != 0) {
			jQuery('#toTop').fadeIn();	
		} else {
			jQuery('#toTop').fadeOut();
		}
	});
	jQuery('#toTop').click(function() {
		jQuery('body,html').animate({scrollTop:0},300);
	});

	
	/* Superfish menu */
	jQuery("ul.sf-menu").supersubs({
			minWidth:    12,
			maxWidth:    32,
			extraWidth:  1
		}).superfish({
			delay: 200,
			speed: 250
		});
	/* Superfish menu */
	jQuery("ul.sf-menu-um").supersubs({
			minWidth:    12,
			maxWidth:    32,
			extraWidth:  1
		}).superfish({
			delay: 200,
			speed: 250
		});	

	/* Mosaic fade */
	jQuery('.hovermore, .readmore, .full-screen').mosaic();
	jQuery('.circle, .gallery-icon').mosaic({
		opacity:	0.5
	});
	jQuery('.fade').mosaic({
		animation:	'slide'
	});
	
	/* Dynamic twitter widget */
	if (jQuery().slides) {
		jQuery(".dynamic .cosmo_twitter").slides({
			play: 5000,
			effect: 'fade',
			generatePagination: false,
			autoHeight: true
		});
	}
	
	/* show/hide color switcher */
	jQuery('.show_colors').toggle(function(){
		jQuery(".style_switcher").animate({
		    left: "10px"

		  }, 500 );
	}, function () {
		jQuery(".style_switcher").animate({
		    left: "-152px"

		  }, 500 );

	});
	
	/* Day/night */
    
    function editor(){
        
        jQuery(function(){
            
            if( jQuery( 'body'  ).hasClass( 'night' ) ){
            
                jQuery( '#image_content_ifr' ).contents().find( 'body' ).css( { 'color' : '#ffffff' } );
                jQuery( '#image_content_ifr' ).contents().find( 'p' ).css( { 'color' : '#ffffff' } );

            }else{
                
                jQuery( '#image_content_ifr' ).contents().find( 'body' ).css( { 'color' : '#272727' } );
                jQuery( '#image_content_ifr' ).contents().find( 'p' ).css( { 'color' : '#272727' } );
            }
        });
    }
	
	jQuery('p.day_night span').click(function(){
		jQuery('[name="darkheader"]').attr('checked',false);
		jQuery('body').removeClass('color');			
		if( jQuery(this).hasClass( 'day' ) ){
			jQuery(this).removeClass('day');
			jQuery('body').removeClass('day');		
			jQuery('div.logo img').attr('src',themeurl+'/images/logo.white.png');	
			
			jQuery(this).addClass('night');
			jQuery('body').addClass('night');
            jQuery.cookie( cookies_prefix + 'style' , 'night' , {expires: 365, path: '/' } );
		}else{
			jQuery(this).removeClass('night');
			jQuery('body').removeClass('night');
			jQuery('div.logo img').attr('src',themeurl+'/images/logo.png');		
			jQuery(this).addClass('day');
			jQuery('body').addClass('day')
            jQuery.cookie( cookies_prefix + 'style' , 'day' , {expires: 365, path: '/' } );
		}
        
        editor();
    });	
    
    jQuery( '#image_content-tmce' ).click(function(){
        editor();
    });
    
	jQuery('[name="darkheader"]').click(function(){
        
		if(jQuery('[name="darkheader"]').attr('checked') ){
			jQuery('body').addClass('color');
			jQuery('body').removeClass('night');
			jQuery('div.logo img').attr('src',themeurl+'/images/logo.white.png');	
			jQuery('body').removeClass('day');
			jQuery.cookie("boxed",'yes', {expires: 365, path: '/'});
			jQuery.cookie( cookies_prefix + 'style' , 'darkheader' , {expires: 365, path: '/' } );
			//setBoxedCookies('yes');
		}
		else{
			if(jQuery('p.day_night span').attr('class') == 'night'){
				jQuery('div.logo img').attr('src',themeurl+'/images/logo.white.png');	
			}else{
				jQuery('div.logo img').attr('src',themeurl+'/images/logo.png');	
			}
			jQuery('body').removeClass('color');
			jQuery('body').addClass(jQuery('p.day_night span').attr('class'));
			jQuery.cookie( cookies_prefix + 'style' , jQuery('p.day_night span').attr('class') , {expires: 365, path: '/' } );
			//setBoxedCookies('no');
		}
        
        editor();
	});
	
	//footer widgets
	jQuery('div.footer-area aside').each(function(index) {
		
		if(((index+1) % 3) == 1){  
			jQuery(this).addClass('first');
		}
		
	});
	jQuery('div.footer-area aside').each(function(index) {
		
		if(((index+1) % 3) == 0){  
			
			jQuery('<div class="clearfix"></div>').insertAfter(this);
		}
		
	});
	
	/* Hide title from menu items */
	jQuery(function(){
		jQuery("li.menu-item > a").hover(function(){
			jQuery(this).stop().attr('title', '');},
			function(){jQuery(this).stop().attr();
		});
	});
	
	/* Icons annimation */
	/*$("#nav-shadow p").append('<img class="shadow" src="images/icons-shadow.png" width="100%" height="27" alt="" />');*/
	jQuery("#nav-shadow p").hover(function() {
		var e = this;
		jQuery(e).find("a").stop().animate({marginTop: "-20px"}, 250, function() {
			jQuery(e).find("a").animate({marginTop: "-15px"}, 250);
		});
	jQuery(e).find("img.shadow").stop().animate({width: "80%", height: "20px", marginLeft: "8px", opacity: 0.25}, 250);
	},function(){
		var e = this;
		jQuery(e).find("a").stop().animate({marginTop: "0px"}, 250, function() {
			jQuery(e).find("a").animate({marginTop: "0px"}, 250);
		});
	jQuery(e).find("img.shadow").stop().animate({width: "100%", height: "27px", marginLeft: "0", opacity: 1}, 250);
	});

	/* Social-media icons annimation */
	/*jQuery(".hotkeys-meta span").hover(function() {
		var e = this;
		jQuery(e).find("a").stop().animate({marginTop: "-8px"}, 250, function() {
			jQuery(e).find("a").animate({marginTop: "-8px"}, 250);
		});
	},function(){
		var e = this;
		jQuery(e).find("a").stop().animate({marginTop: "0px"}, 250, function() {
			jQuery(e).find("a").animate({marginTop: "0px"}, 250);
		});
	});*/
	
	/* Social-media icons annimation */
	/*jQuery(".social-media li").hover(function() {
		var e = this;
		jQuery(e).find("a").stop().animate({marginTop: "-8px"}, 250, function() {
			jQuery(e).find("a").animate({marginTop: "-8px"}, 250);
		});
	},function(){
		var e = this;
		jQuery(e).find("a").stop().animate({marginTop: "0px"}, 250, function() {
			jQuery(e).find("a").animate({marginTop: "0px"}, 250);
		});
	});*/
	
	/* Widget tabber */
    jQuery( 'ul.widget_tabber li a' ).click(function(){
        jQuery(this).parent('li').parent('ul').find('li').removeClass('active');
        jQuery(this).parent('li').parent('ul').parent('div').find( 'div.tab_menu_content.tabs-container').fadeTo( 200 , 0 );
        jQuery(this).parent('li').parent('ul').parent('div').find( 'div.tab_menu_content.tabs-container').hide();
        jQuery( jQuery( this ).attr('href') + '_panel' ).fadeTo( 200 , 1 );
        jQuery( this ).parent('li').addClass('active');
    });
	

	/* content tabber */
    jQuery( 'ul.content_tabber li a' ).click(function(){
        jQuery(this).parent('li').parent('ul').find('li').removeClass('active');
        jQuery(this).parent('li').parent('ul').parent('div').find( 'div.tab_content.tabs-container').fadeTo( 200 , 0 );
        jQuery(this).parent('li').parent('ul').parent('div').find( 'div.tab_content.tabs-container').hide();
        jQuery( jQuery( this ).attr('href') + '_panel' ).fadeTo( 200 , 1 );
        jQuery( this ).parent('li').addClass('active');
		jQuery(window).trigger("resize");
	
    });
	
	 /* Initialize tabs */
	(typeof(jQuery.fn.tabs) === 'function') && jQuery(function() { 
		jQuery('.cosmo-tabs').tabs({fxFade: true, fxSpeed: 'fast'});
		jQuery('.tabs-nav li:first-child a').click();
	});

	/*Case when by default the toggle is closed */
	jQuery(".open_title").toggle(function(){ 
			jQuery(this).next('div').slideDown();
			jQuery(this).find('a').removeClass('show');
			jQuery(this).find('a').addClass('hide');
			jQuery(this).find('.title_closed').hide();
			jQuery(this).find('.title_open').show();
		}, function () {
		
			jQuery(this).next('div').slideUp();
			jQuery(this).find('a').removeClass('hide');
			jQuery(this).find('a').addClass('show');		 
			jQuery(this).find('.title_open').hide();
			jQuery(this).find('.title_closed').show();
			
	});
	
	/*Case when by default the toggle is oppened */		
	jQuery(".close_title").toggle(function(){ 
			jQuery(this).next('div').slideUp();
			jQuery(this).find('a').removeClass('hide');
			jQuery(this).find('a').addClass('show');		 
			jQuery(this).find('.title_open').hide();
			jQuery(this).find('.title_closed').show();
		}, function () {
			jQuery(this).next('div').slideDown();
			jQuery(this).find('a').removeClass('show');
			jQuery(this).find('a').addClass('hide');
			jQuery(this).find('.title_closed').hide();
			jQuery(this).find('.title_open').show();
			
	});	
	
	/*Accordion*/
	jQuery('.cosmo-acc-container').hide();
	jQuery('.cosmo-acc-trigger:first').addClass('active').next().show();
	jQuery('.cosmo-acc-trigger').click(function(){
		if( jQuery(this).next().is(':hidden') ) {
			jQuery('.cosmo-acc-trigger').removeClass('active').next().slideUp();
			jQuery(this).toggleClass('active').next().slideDown();
		}
		return false;
	}); 

	/* Determine screen resolution */
	var $body = jQuery('body'),
		wSizes = [1600, 1440, 1280, 1024, 800],
		wSizesClasses = ['w1600', 'w1440', 'w1280', 'w1024', 'w800'];
		
	jQuery(window).bind('resize', function() {
		$body.removeClass(wSizesClasses.join(' '));
		var size = jQuery(this).width();
		for (var i=0; i<wSizes.length; i++) {
			if (size >= wSizes[i]) {
				$body.addClass(wSizesClasses[i]);
				break;
			}
		}
	}).trigger('resize');
	
});

    

/* Hide Tooltip */
jQuery(function() {

    jQuery( '.demo-tooltip' ).tour();

    jQuery('a.close').click(function() {
        jQuery( jQuery( this ).attr('href') ).slideUp();
        jQuery.cookie( cookies_prefix + "tooltip" , 'closed' , {expires: 365, path: '/'});
        /* jQuery('.delimiter').removeClass('hidden'); */
        return false;
    });
});
    
	
function contact( action , form , container ){
    jQuery( document ).ready(function(){

        var name  = jQuery( form ).find("input[name=\"name\"]").val();
        var email = jQuery( form ).find("input[name=\"email\"]").val();
		var contact_email = jQuery( form ).find("input[name=\"contact_email\"]").val();
        var phone  = jQuery( form ).find("input[name=\"phone\"]").val();
        var mssg  = jQuery( form ).find("textarea[name=\"message\"]").val();


        jQuery.post( ajaxurl ,
                {
                    "action" : action ,
                    "name" : name,
                    "email" : email,
					"contact_email" : contact_email, 
                    "phone" : phone,
                    "message" : mssg,
                    "btn_send" : "btn_send"
                } ,
                function( data ){
                    var result = '';
                    var array  = data.split( '","' );
                    if( array.constructor.toString().indexOf("Array") == -1 ){
                        for(var i = 0; i < array.length; i++ ){
                            if( jQuery.trim( array[i] ) == mail.email ){
                                result = result + array[i] + '<br />';
                                jQuery( form ).find( "input[name=\"email\"]" ).addClass( 'send-error' );
                            }

                            if( jQuery.trim( array[i] ) == mail.name ){
                                result = result + array[i] + '<br />';
                                jQuery( form ).find( "input[name=\"name\"]" ).addClass( 'send-error' );
                            }

                            if( jQuery.trim( array[i] ) == mail.message ){
                                result = result + array[i] + '<br />';
                                jQuery( form ).find( "textarea[name=\"message\"]" ).addClass( 'send-error' );
                            }
                        }
                        if( result.toString().length > 0 ){
                            jQuery( container ).html( result );
                        }else{
                            jQuery( container ).html( data );

                                jQuery('#name').val('');
                                jQuery('#email').val('');
                                jQuery('#comment').val('');
                                jQuery('#contact_name').val('');
                                jQuery('#contact_email').val('');
                                jQuery('#contact_phone').val('');
                                jQuery('#contact_message').val('');
                        }
                    }else{
                        jQuery( container ).html( data );
                    }
        });
    });
}	    

