<?php
    include 'help.php';
    
    if( function_exists( 'wp_get_theme' ) ){
       $theme_name = wp_get_theme();    
    }else{

        $theme_name = get_current_theme();
    }

    /* RESOURCES INCLUDE 
     *  - custom posts settings
     *  - custom posts taxonomy
     *  - custom posts meta boxes
     *  - custom sidebars 
     */
    
    _panel::$menu[ 'resources' ]['custom'] = array(
        'post' => array(
            'label' => __( 'Custom posts' , _DEV_ ),
            'title' => $theme_name . ' ' . __( 'custom post builder' , _DEV_ ),
            'title' => $theme_name . ' ' . __( 'custom post builder' , _DEV_ ),
            'description' => __( 'Create different types of custom posts: locations, papers, people, general, etc.' , _DEV_ ),
            'type' => 'main' , 
            'menu_label' => __( 'Custom posts' , _DEV_ ), 
            'main_label' => __( 'Resources' , _DEV_ ),
            'main_title' => $theme_name . ' ' . __( 'custom resources builder' , _DEV_ ),
            'update' => false,
            'classes' => 'resource-builder',
			'icon' => get_template_directory_uri().'/lib/core/images/icon-1.png'
        ),
        'sidebar' => array(
            'label' => __( 'Sidebars' , _DEV_ ),
            'title' => $theme_name . ' ' . __( 'custom sidebars builder' , _DEV_ ),
            'description' => __( 'General page description for custom sidebars.' , _DEV_ ),
            'menu_label' => __( 'Sidebar' , _DEV_ ), 
            'main_label' => __( 'Sidebar' , _DEV_ ),
            'update' => false
        ),
    );
    
    /* SETTINGS INCLUDE 
     *  - all theme settings 
     */
    _panel::$menu[ 'settings' ]['general'] = array(
		'theme' => array(
            'label' => __( 'Theme general settings' , _DEV_ ) ,
            'title' => $theme_name . ' ' . __( 'General theme settings' , _DEV_ ),
            'description' => __( 'Theme general settings: styles, layout, etc.' , _DEV_ ),
            'type' => 'main',
            'menu_label' => __( 'Theme settings' , _DEV_ ),
            'main_label' => __( 'Theme settings' , _DEV_ ),
            'classes' => 'theme-settings',
			'icon' => get_template_directory_uri().'/lib/core/images/icon-2.png'
        ),
        'upload' => array(
            'label' => __( 'Front-end submitting' , _DEV_ ),
            'title' => __( 'Front-end submitting settings' , _DEV_ ),
            'description' => __( 'Front-end submitting' , _DEV_ ),
            'menu_label' => __( 'Front-end submitting' , _DEV_ ),
        ),
        'user_registration' => array(
            'label' => __( 'User registration' , _DEV_ ),
            'title' => __( 'User registration' , _DEV_ ),
            'description' => __( 'User registraion' , _DEV_ ),
            'menu_label' => __( 'User registration' , _DEV_ ),
        )
    );
    
    _panel::$menu[ 'settings' ]['front_page'] = array(
        'resource' => array(
            'label' => __( 'Mainpage' , _DEV_ ) ,
            'title' => __( 'Mainpage resource type' , _DEV_ ) ,
            'description' => __( 'General page description.' , _DEV_ ) ,
            'main_label' => __( 'Mainpage' , _DEV_ )
        )
    );
    _panel::$menu[ 'settings' ]['layout'] = array(
        'style' => array(
            'label' => __( 'Layout' , _DEV_ ),
            'title' => __( 'Layout settings' , _DEV_ ),
            'description' => __( 'General page description.' , _DEV_ ),
            'main_label' => __( 'Layout' , _DEV_ )
        )
    );

	_panel::$menu[ 'settings' ]['menus'] = array(
        'menus' => array(
            'label' => __( 'Menus' , _DEV_ ),
            'title' => __( 'Menu settings' , _DEV_ ),
            'description' => __( 'Menu settings.' , _DEV_ ),
            'main_label' => __( 'Menus' , _DEV_ )
        )
    );
    
    _panel::$menu[ 'settings' ][ 'blogging' ] = array(
        'posts' => array(
            'label' => __( 'Blogging' , _DEV_ ),
            'title' => __( 'General posts settings' , _DEV_ ),
            'description' => __( 'General page description.' , _DEV_ ),
            'main_label' => __( 'Blogging' , _DEV_ ) 
        ),
        'pages' => array(
            'label' => __( 'Pages' , _DEV_ ),
            'title' => __( 'General pages settings' , _DEV_ ),
            'description' => __( 'General pages description.' , _DEV_ )
        ),
        'likes' => array(
            'label' => __( 'Likes' , _DEV_ ),
            'title' => __( 'General likes settings' , _DEV_ ),
            'description' => __( 'General likes description.' , _DEV_ )
        ),
		
		'archive' => array(
			'label' => __( 'Archive' , _DEV_ ),
			'title' => __( 'General archive settings' , _DEV_ ),
			'description' => __( 'General archive description' , _DEV_ )
		),

		'labels' => array(
			'label' => __( 'Labels' , _DEV_ ),
			'title' => __( 'Set page labels' , _DEV_ ),
			'description' => __( 'Set page labels' , _DEV_ )
		),
        
        'seo' => array(
            'label' => __( 'SEO' , _DEV_ ),
            'title' => __( 'Keywords and description' , _DEV_ ),
            'description' => __( 'Set genral blog keywords and description' , _DEV_ ),
        )
        
    );
    _panel::$menu[ 'settings' ][ 'social' ] = array(
        'facebook' => array(
            'label' => __( 'Social' , _DEV_ ),
            'title' => __( 'Social settings' , _DEV_ ),
            'description' => __( 'General page description.' , _DEV_ ),
            'main_label' => __( 'Social' , _DEV_ ) 
        )
    );
    
    _panel::$menu[ 'settings' ][ 'ads' ] = array(
        'general' => array(
            'label' => __( 'Advertising' , _DEV_ ),
            'title' => __( 'Add your ads' , _DEV_ ),
            'description' => __( 'General page description.' , _DEV_ ),
            'main_label' => __( 'Advertising' , _DEV_ ) 
        )
    );
    
    _panel::$menu[ 'settings' ]['style'] = array(
        'general' => array(
            'label' => __( 'Style' , _DEV_ ),
            'title' => __( 'General theme style' , _DEV_ ),
            'description' => __( 'General page description.' , _DEV_ ),
            'main_label' => __( 'Style' , _DEV_ ) 
        ),
        'single' => array(
            'label' => __( 'Post' , _DEV_ ) ,
            'title' => __( 'Post text style' , _DEV_ ),
            'description' => __( 'General page description.' , _DEV_ )
        ),
        'page' => array(
            'label' => __( 'Page' , _DEV_ ),
            'title' => __( 'Pages text style' , _DEV_ ),
            'description' => __( 'General page description.' , _DEV_ )
        ),
        'archive' => array(
            'label' => __( 'Archive' , _DEV_ ),
            'title' => __( 'Archive text style' , _DEV_ ),
            'description' => __( 'General page description.' , _DEV_ )
        ),
        'sidebars' => array(
            'label' => __( 'Sidebar widgets' , _DEV_ ),
            'title' => __( 'Sidebars widgets text style' , _DEV_ ),
            'description' => __( 'From here you can adjust the styles for text on sidebar widgets' , _DEV_ )
        )
    );
	    
    /* EXTRA INCLUDE
     *  - notification settings
     *  - export resource structure
     *  - export sidebars
     *  - export tooltips
     */
    _panel::$menu[ 'extra' ]['settings'] = array(
        'css' => array(
            'label' => __( 'Custom CSS' , _DEV_ ),
            'title' => $theme_name . ' ' . __( 'extra options' , _DEV_ ),
            'description' => __( 'Extra options: Import / Export data, custom CSS, notifications, etc' , _DEV_ ),
            'type' => 'main',
            'menu_label' => __( 'Extra options' , _DEV_ ),
            'main_label' => __( 'Custom CSS' , _DEV_ ),
            'main_title' => $theme_name . ' ' . __( 'extra options' , _DEV_ ),
            'classes' => 'extra-settings',
			'icon' => get_template_directory_uri().'/lib/core/images/icon-3.png'
        ),
        'io' => array(
            'label' => __( 'Import / Export' , _DEV_ ),
            'title' => __( 'Import / Export Structure' , _DEV_ ),
            'description' => __( 'Import / Export' , _DEV_ ),
            'main_label' => __( 'Import / Export' , _DEV_ ),
            'update' => false
        ),
        'notifications' => array(
            'label' => __( 'Notifications' , _DEV_ ),
            'title' => __( 'CosmoThemes notifications' , _DEV_ ),
            'description' => __( 'Notifications' , _DEV_ ),
            'main_label' => __( 'Notifications' , _DEV_ )
        ),
    );

	_panel::$menu[ 'settings' ][ 'tooltips' ] = array(
		'general' => array(
			'label' => __( 'Tooltips' , _DEV_ ),
			'title' => __( 'Tooltips settings' , _DEV_ ),
			'description' => __( 'Tooltips general settings.' , _DEV_ ),
			'main_label' => __( 'Tooltips' , _DEV_ ),
			'update' => false
		)
	);
    
    /* PANEL SETTINGS */
    /* REGISTER GROUP AND PROPRIETES FOR PAGES */
    
    /* SETTINGS GENERAL THEME */
    include 'panel/general.php';
    
    /* SETTINGS FRONT-PAGE */
    include 'panel/front-page.php';
    
    /* SETTINGS GENERAL THEME */
    include 'panel/upload.php';
    
    /* SETTINGS STYLE */
    include 'panel/style.php';
    
    /* SETTINGS LAYOUT STYLE */
    include 'panel/layout.php';
    
	/* SETTINGS MENUS */
	include 'panel/menu.php';

    /* SETTINGS BLOGGING */
    include 'panel/blogging.php';
    
    /* SETTINGS SEO */
    include 'panel/seo.php';
    
    /* SETTINGS SOCIAL */
    include 'panel/social.php';
    
    /* SETTINGS ADVERTISINGS */
    include 'panel/ads.php';
    
    /* PANEL EXTRA */
    /* CUSTOM CSS EXPORT CUSTOM POSTS STRUCTURE */
    include 'panel/extra.php';
    
    /* REGISTER FIELDS */
    _settings::$register = _panel::$fields;
    
    /* NO NEED REGISTER FIELDS */
    /* PANEL CUSTOM RESOURCE */
    _panel::$fields['resources']['custom']['post']['panel'] = array( 'type' => 'ni--resources-custom-posts' );
    _panel::$fields['resources']['custom']['sidebar']['panel'] = array( 'type' => 'ni--resource-custom-sidebars' );
	_panel::$fields['settings']['tooltips']['general']['panel'] = array( 'type' => 'ni--resource-tooltip' );
?>