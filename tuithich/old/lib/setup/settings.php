<?php
    /* SETTINGS GENERAL */
	_settings::$default[ 'settings' ][ 'general' ][ 'theme' ][ 'time' ]                         = 'yes';
	_settings::$default[ 'settings' ][ 'general' ][ 'theme' ][ 'fb-comments' ]                  = 'no';
	_settings::$default[ 'settings' ][ 'general' ][ 'theme' ][ 'enb_follow' ]                  	= 'yes';
	_settings::$default[ 'settings' ][ 'general' ][ 'theme' ][ 'copyright' ]                    = '<a href="http://cosmothemes.com">FacePress by CosmoThemes</a> Copyright © %year%';
    
    _settings::$default[ 'settings' ][ 'general' ][ 'upload' ][ 'enb_edit_delete' ]             = 'yes';
    _settings::$default[ 'settings' ][ 'general' ][ 'upload' ][ 'post_item_page' ]              = 'yes';
    
    /* FRONT PAGE */
    _settings::$default[ 'settings' ][ 'front_page' ][ 'resource' ][ 'type' ]                   = 'latest-post';
    _settings::$default[ 'settings' ][ 'front_page' ][ 'resource' ][ 'welcome' ]                = 'yes';
    _settings::$default[ 'settings' ][ 'front_page' ][ 'resource' ][ 'welcome-description' ]    = 'Welcome to FacePress - the simplest way for everyone to publish, collect and share content.<br />
You can create your collection by posting content or following active users. Display your posts in timeline, grid or list-view or display on your mainpage your latest or a static post.';
    
    /* BLOGGING */
    /* POST */
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'enb-featured' ]                = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'enb-featured-border' ]         = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'similar' ]                     = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'similar-number' ]              = 3;
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'similar-criteria' ]            = 'post_tag';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'meta' ]                        = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'meta-position' ]               = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'social' ]                      = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'author-box' ]                  = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'posts' ][ 'source' ]                      = 'yes';
    
    /* PAGE */
    _settings::$default[ 'settings' ][ 'blogging' ][ 'pages' ][ 'social' ]                      = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'pages' ][ 'meta' ]                        = 'no';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'pages' ][ 'meta-position' ]               = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'pages' ][ 'source' ]                      = 'no';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'pages' ][ 'author-box' ]                  = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'pages' ][ 'enb-featured' ]                = 'no';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'pages' ][ 'enb-featured-border' ]         = 'no';
    
    /* ATTACHMENT */
    
    /* LIKES */
    _settings::$default[ 'settings' ][ 'blogging' ][ 'likes' ][ 'use' ]                         = 'yes';
    _settings::$default[ 'settings' ][ 'blogging' ][ 'likes' ][ 'limit' ]                       =  50;
    
    /* ARCHIVE */
    _settings::$default[ 'settings' ][ 'blogging' ][ 'archive' ][ 'grid-excerpt' ]              = 180;
	_settings::$default[ 'settings' ][ 'blogging' ][ 'archive' ][ 'timeline-excerpt' ]              = 180;
    _settings::$default[ 'settings' ][ 'blogging' ][ 'archive' ][ 'list-excerpt' ]              = 300;
    
    
    /* SETTINGS STYLE GENERAL */
    _settings::$default[ 'settings' ][ 'style' ][ 'general' ][ 'logo_type' ]                    = 'text';
    _settings::$default[ 'settings' ][ 'style' ][ 'general' ][ 'background' ]                   =  get_template_directory_uri() . '/lib/core/images/pattern/s.pattern.none.png';
    
    _settings::$default[ 'settings' ][ 'style' ][ 'general' ][ 'color']                         = 'day';
    
    if( _core::method( 'layout' , 'style' ) == 'night'){
        _settings::$default[ 'settings' ][ 'style' ][ 'general' ][ 'background_color' ]         = '#383838';
    }else{
        _settings::$default[ 'settings' ][ 'style' ][ 'general' ][ 'background_color' ]         = '#ffffff';
    }
    
    /* SETTINGS LAYOUT STYLE */
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'front_page' ]                    = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'front_page_view' ]               = 'yes';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'l404' ]                          = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'author' ]                        = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'author_view' ]                   = 'yes';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'page' ]                          = 'full';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'single' ]                        = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'blog_page' ]                     = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'blog_page_view' ]                = 'yes';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'lsearch' ]                       = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'lsearch_view' ]                  = 'yes';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'archive' ]                       = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'archive_view' ]                  = 'yes';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'category' ]                      = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'category_view' ]                 = 'yes';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'tag' ]                           = 'left';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'tag_view' ]                      = 'yes';
    _settings::$default[ 'settings' ][ 'layout' ][ 'style' ][ 'attachment' ]                    = 'left';

	/* MENUS SETTINGS */
    _settings::$default[ 'settings' ][ 'menus' ][ 'menus' ][ 'home' ]                           = 'yes';
    _settings::$default[ 'settings' ][ 'menus' ][ 'menus' ][ 'home-label' ]                     = __( 'Home' , _DEV_ );
	_settings::$default[ 'settings' ][ 'menus' ][ 'menus' ][ 'header' ]                         = 4;
    _settings::$default[ 'settings' ][ 'menus' ][ 'menus' ][ 'footer' ]                         = 4;
	
	/* PAYMENT SETTINGS */
	_settings::$default[ 'settings' ][ 'payment' ][ 'paypal' ][ 'currency' ]                    = 'USD';
    
    /* SETTINGS SLIDESHOW GENERAL */
	$slideshows_created=get_posts( array(
            'post_type' => 'slideshow',
            'post_status' => 'publish'
        ) ); 
		
	if(count($slideshows_created)>=1){	
		_settings::$default[ 'settings' ][ 'slideshow' ][ 'general' ][ 'item' ]					= $slideshows_created[0]->ID; 
	}
    
    _settings::$default[ 'settings' ][ 'slideshow' ][ 'general' ][ 'limit' ]                    = 20;
    
    /* EXTRA */
    _settings::$default[ 'extra' ][ 'settings' ][ 'notifications' ][ 'version' ]                = 'yes';
	_settings::$default[ 'extra' ][ 'settings' ][ 'notifications' ][ 'news' ]                   = 'yes';

	/* LABELS */
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'daily_archives' ]				= __( 'Daily archives' , _DEV_ ) . ': %date%';
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'monthly_archives' ]	 		= __( 'Monthly archives' , _DEV_ ) . ': %month% %year%';
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'yearly_archives' ] 			= __( 'Yearly archives' , _DEV_ ) . ': %year%';
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'blog_archives' ]	 			= __( 'Blog archives' , _DEV_ );
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'blog_page' ]	 				= __( 'Blog page' , _DEV_ );
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'post_type' ]					= __( 'Post type' , _DEV_ ) . ' %type%';
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'author_archives' ] 			= __( 'Author archives' , _DEV_ );
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'search' ] 					= __( 'Search results for' , _DEV_ ) . ': %s%';
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'category' ]					= __( 'Category archives' , _DEV_ ) . ': %cat%';
	_settings::$default[ 'settings' ][ 'blogging' ][ 'labels' ][ 'tag' ]  						= __( 'Tag archives' , _DEV_ ) . ': %tag%';

	/* user registration */
	_settings::$default[ 'settings' ][ 'general' ][ 'user_registration' ][ 'email_subject' ]	= __( '%sitename% Your user name and password' , _DEV_ );
	_settings::$default[ 'settings' ][ 'general' ][ 'user_registration' ][ 'message' ]			= __( "User name: %username%\nPassword: %password%\n%loginurl%" , _DEV_ );

	/* frontend posts */
	_settings::$default[ 'settings' ][ 'general' ][ 'upload' ][ 'timeline_default_category' ]	= 1;
?>