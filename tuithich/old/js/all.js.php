<?php
    header( 'Content-type:text/javascript' );
    include '../../../../wp-load.php';
    
    $initScript  = '';

	/* ajax url */
    $siteurl = get_option( 'siteurl' );
    if( !empty($siteurl) ){
        $siteurl = rtrim( $siteurl , '/' ) . '/wp-admin/admin-ajax.php' ;
    }else{
        $siteurl = home_url('/wp-admin/admin-ajax.php');
    }
?>
<?php if( false ){ ?><script><?php }?>
    
    var mail = new Object();
    mail = {
        'name' : "<?php _e( 'Error, fill all required fields ( name )'  , _DEV_ );?>",
        'email' : "<?php _e( 'Error, fill all required fields ( email )' , _DEV_ ) ?>",
        'message' : "<?php _e( 'Error, fill all required fields ( message )' , _DEV_ )?>"
    };
    
<?php

    if( isset( $_GET[ 'post' ] ) &&  (int)$_GET[ 'post' ] > 0 ){
        $postID = (int)$_GET[ 'post' ];
        
    }else{
        $postID = 0;
    }
?>
    
/* ================================================================================================================================================ */
/* SUPERFISH , SUPERSUBS , MOSAIC , COOKIE , HTML5 , CALCULATION , MASONRY MODERNIZR-TRANSITIONS                                                                                                                  */
/* ================================================================================================================================================ */
    
<?php    
    
	
    
    include 'jquery.cookie.js';
    include 'jquery.superfish.js';
	include 'jquery.supersubs.js';
    include 'jquery.mosaic.1.0.1.min.js';
?> 

    
<?php	
	if( (int)_widgets::count_widget('widget_custom_post') > 0){ 
		
       
?>		
			var top_possition = 100;
<?php	
		
		include '../lib/core/js/custom_post.js';
	}
?>

/* ================================================================================================================================================ */
/* PRETTY PHOTO                                                                                                                                     */
/* ================================================================================================================================================ */
    
<?php    
	include 'jquery.prettyPhoto.js';
	include 'prettyPhoto.settings.js';
?>

/* ================================================================================================================================================ */
/* JSCROLL PANEL , TOOLTIPS                                                                                                                                    */
/* ================================================================================================================================================ */
<?php
    include 'jquery.jscrollpane.min.js';
    include 'jquery.mousewheel.js';
    include 'jquery.easing.min.js';
    include "tour.js";
    include 'functions.js';
    include 'likes.js';
    if(_core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'enb_follow' )){
        include 'follow.js';
    }
?>
    
    /* ================================================================================================================================================ */
    /* GENERAL VARS                                                                                                                                     */
    /* ================================================================================================================================================ */
    
    var ajaxurl = "<?php echo $siteurl; ?>";
    var cookies_prefix = "<?php echo ZIP_NAME; ?>";  
    var themeurl = "<?php echo get_template_directory_uri(); ?>";
       
    function removePost( postID , homeUrl ){
        jQuery(function(){
            jQuery.post( ajaxurl , {
                'action': 'remove_post',
                'post_id': postID
            } , function (data) {
                document.location = homeUrl; 
            });
        });
    }
    
	/* ================================================================================================================================================ */
    /* LOGIN VAR                                                                                                                                     */
    /* ================================================================================================================================================ */

	likes.registration_required=<?php echo (_core::method( '_settings' , 'logic' , 'settings' , 'blogging' , 'likes' , 'req-registr' ) && !is_user_logged_in() )? 'true' : 'false'; ?>;

	<?php 	$login_page=_core::method( '_settings' , 'get' , 'settings' , 'general' , 'theme' , 'login-page' );
			if( is_numeric( $login_page ) ){?>
				likes.login_url="<?php echo add_query_arg( 'a', 'like', get_permalink($login_page) ); ?>";
				var login_url = "<?php echo get_permalink($login_page); ?>";
	<?php	}else{ ?>
                var login_url = "<?php echo home_url('/'); ?>";
    <?php   } ?>
    
    
    <?php include 'login.js'; ?>
    
	/* ================================================================================================================================================ */
    /* TABS                                                                                                                                     */
    /* ================================================================================================================================================ */

<?php include "jquery.tabs.pack.js"; ?>

	/* ================================================================================================================================================ */
    /* FRONTEND                                                                                                                                     */
    /* ================================================================================================================================================ */

<?php 

    include "frontend.js"; 
    
    if( _core::method( '_map' , 'markerExists' , $postID  ) && $postID > 0 ){
        include "../lib/core/js/map.js";
    }
?>    

	/* ================================================================================================================================================ */
    /* TRANSLATIONS                                                                                                                                     */
    /* ================================================================================================================================================ */

<?php
	
	include "translations.js.php";

?>

	/* ================================================================================================================================================ */
    /* SCROLL TO                                                                                                                                     */
    /* ================================================================================================================================================ */

<?php include "jquery.scrollTo-1.4.2-min.js";?>


	/* ================================================================================================================================================ */
    /* Twitter widget                                                                                                                               */
    /* ================================================================================================================================================ */

<?php

	/* ================================================================================================================================================ */
    /* Masonry                                                                                                                               */
    /* ================================================================================================================================================ */

	include "jquery.masonry.min.js"; ?>

<?php

	/* ================================================================================================================================================ */
    /* Wait for images                                                                                                                               */
    /* ================================================================================================================================================ */

	include "jquery.waitforimages.js"; 
?>

<?php

	/* ================================================================================================================================================ */
    /* Autoresize                                                                                                                               */
    /* ================================================================================================================================================ */

	include "autoresize.jquery.js"; 
?>

<?php include "slides.min.jquery.js";?>
	/* twitter widget */
	if (jQuery().slides) {
		jQuery(".dynamic .cosmo_twitter").slides({
			play: 5000,
			effect: 'fade',
			generatePagination: false,
			autoHeight: true
		});
	}
    
    <?php ob_start(); ob_clean(); ?>
        jQuery('.scroll-pane').jScrollPane();
        
    <?php $initScript .= trim( ob_get_clean() ); ?>

    /* ================================================================================================================================================ */
    /*  JQUERY SETTINGS                                                                                                                                 */
    /* ================================================================================================================================================ */
    
    jQuery(function(){
        <?php echo $initScript; ?>

    });

<?php if( false ){?></script><?php }?>