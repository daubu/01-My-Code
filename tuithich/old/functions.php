<?php
    /* FOR DEBUGING ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    /*
        include get_template_directory() . '/lib/core/deb.php';
        _deb::inc();
    */

    /* DEFINES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    /*
        _DEV_   - developer name used in translation                            ex : __( 'Title for translate' , _DEV_ ); or _e( 'Title for translate' , _DEV_ );
        _DEVL_  - developer logo url used in admin panel
    */
    if( !defined( '_DEV_' ) ){
        define( '_DEV_' , 'cosmotheme' );
    }
	define( '_CT_' , 'CosmoThemes' );
    define( '_DEVL_' , get_template_directory_uri() . '/lib/core/images/freetotryme.png' );
    define( '_RES_' , 'cosmo_custom_posts' );
    define( '_SBAR_' , 'cosmo_custom_sidebars' );
	define( '_TLTP_' , 'cosmo_tooltip' );
    define( '_WG_' , 'widgets_relations' );
	define('ZIP_NAME'   , 'FacePress' );
	define('DEFAULT_AVATAR_100'   , get_template_directory_uri()."/images/default_avatar_100.jpg" );
	define('DEFAULT_AVATAR'   , get_template_directory_uri() . "/images/default_avatar.jpg" );
	define('BLOCK_TITLE_LEN' , 50 );
	define( 'POSTS_PER_AUTHOR_PAGE' , 20 );
	define( 'AUTHORS_PER_FOLLOWING_AND_FOLLOWERS' , 50 );
	
    /* ADMIN SIDE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
    include get_template_directory() . '/lib/main.php';
	
	
	if(is_admin() && ini_get('allow_url_fopen') == '1'){
		/*New version check*/	
		
		if( _core::method( '_settings' , 'logic' , "extra" , "settings" , "notifications" , "version" ) ) {
			function versionNotify(){
				echo _core::method( '_api_call' , 'compareVersions' ); 
			}
		
			/* Add hook for admin <head></head> */
			add_action( 'admin_head' , 'versionNotify' );
		}

		/* Cosmo news */
		if( _core::method( '_settings' , 'logic' , "extra" , "settings" , "notifications" , "news") && !isset( $_GET['post_id'] )  && !isset( $_GET['post'] ) ) {
			function doCosmoNews(){
				echo _core::method( '_api_call' , 'getCosmoNews' ); 
			}
		
			/* Add hook for admin <head></head> */
			add_action( 'admin_head' , 'doCosmoNews' );
		}	
	}
	
	if( function_exists( 'add_theme_support' ) ){
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
    }

    _core::method( '_image' , 'add_size' );
    
	if (version_compare($wp_version, '3.4', '>=')) { 
		add_theme_support( 'custom-background' );
	}else{ 
		if( function_exists( 'add_custom_background' ) ){
			add_custom_background();
		}else{
			add_theme_support( 'custom-background' );
		}
	}	
    
	/* add_theme_support( 'post-formats' , array( 'image' , 'video' , 'audio' ) ); */
	add_editor_style('editor-style.css');
	
	/* Localization */
    load_theme_textdomain( _DEV_ );
    load_theme_textdomain( _DEV_ , get_template_directory() . '/languages' );
    
    if ( function_exists( 'load_child_theme_textdomain' ) ){
        load_child_theme_textdomain( _DEV_ );
    }

	if( !_core::method( "_settings" , "logic" , "settings" , 'general' , 'theme' , 'show-admin-bar' ) ){
		add_filter( 'show_admin_bar' , '__return_false' );
	}
?>