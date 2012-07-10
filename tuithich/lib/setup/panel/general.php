<?php
	_panel::$fields[ 'settings' ][ 'general' ][ 'theme' ][ 'settings-page' ] = array(
        'type' => 'st--search',
        'label' => __( 'Select My Settings page' , _DEV_ ),
        'query' => array(
            'post_type' => 'page',
            'post_status' => 'publish'
        ),
        'hint' => __( 'Create a blank page then select it from the list to generate My Settings page' , _DEV_ )
    );

    _panel::$fields[ 'settings' ][ 'general' ][ 'theme' ][ 'post-page' ] = array(
        'type' => 'st--search',
        'label' => __( 'Select My Posts page' , _DEV_ ),
        'query' => array(
            'post_type' => 'page',
            'post_status' => 'publish'
        ),
        'hint' => __( 'Create a blank page then select it from the list to generate My Posts page' , _DEV_ )
    );
      
	/* LOG IN */

	if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'enb-login' ) ){
        $classes = 'enb-login-options';
    }else{
        $classes = 'enb-login-options hidden';
    }

	
    _panel::$fields[ 'settings' ][ 'general' ][ 'theme' ][ 'enb-login' ] = array(
        'type' => 'st--logic-radio',
        'label' => __( 'Enable user login' , _DEV_ ),
        'hint' => __( 'Choose Yes to display login link and user menu in header area, then make sure you select the Log in page' , _DEV_ ),
		'action' => "tools.sh.check( this , { 'yes' : '.enb-login-options' } )"
    );
    
	_panel::$fields['settings']['general']['theme']['login-page']= array(
		'type'=>'st--search',
		'label'=>__('Select Log In page', _DEV_ ),
		'query'=>array(
			'post_type'=>'page',
			'post_status'=>'publish'
		),
		'hint'=> __( 'Create a blank page then select it from the list to generate the Login page' , _DEV_ ),
		'classes' => $classes
	);
    
    
	
    _panel::$fields[ 'settings' ][ 'general' ][ 'theme' ][ 'show-breadcrumbs' ] = array(
        'type' => 'st--logic-radio',
        'label' => __( 'Show breadcrumbs'  , _DEV_ ),
    );
    
    _panel::$fields[ 'settings' ][ 'general' ][ 'theme' ][ 'time' ] = array(
        'type' => 'st--logic-radio', 
        'label' => __( 'Use human time' , _DEV_ ), 
        'hint' => __( 'If set No will use WordPress time format' , _DEV_ ) 
    );
	
 	_panel::$fields[ 'settings' ]['general']['theme']['fb-comments'] = array(
         'type' => 'st--logic-radio', 
         'label' => __( 'Use Facebook comments' , _DEV_ ),
		 'action' => "tools.sh.check( this , { 'yes' : '.fb-app-id-hint' } )"
     );

	
	if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'fb-comments' ) ){
        $classes = 'fb-app-id-hint';
    }else{
        $classes = 'fb-app-id-hint hidden';
    }
	
	_panel::$fields['settings']['general']['theme']['fb-app-id-hint']= array(
		'type'=>'st--hint',
		'value'=>__( 'You can set Facebook application ID' , _DEV_ ) . ' <a href="admin.php?page=settings__social__facebook">' . __( 'here' , _DEV_) . '</a> ',
		'classes' => $classes
	);
	
	_panel::$fields['settings']['general']['theme']['enb_follow']=array(
		'type'=> 'st--logic-radio',
		'label'=>__( 'Enable following users' )
	);
	
	_panel::$fields['settings']['general']['theme']['show-admin-bar']=array(
		'type'=> 'st--logic-radio',
		'label'=>__( 'Show WordPress admin bar' )
	);
	
	_panel::$fields['settings']['general']['theme']['custom_gallery']=array(
		'type'=> 'st--logic-radio',
		'label'=>__( 'Use custom gallery short code' ),
		'hint' => __('Enable this option only if you want to use the standard gallery short code. By enabling it, 4 more image copies will be created each time a image will be uploaded.',_DEV_)
		
	);
	
	_panel::$fields[ 'settings' ]['general']['theme']['code'] = array(
        'type' => 'st--textarea', 
        'label' => __( 'Tracking code' , _DEV_ ), 
        'hint' => __( 'Paste your Google Analytics or other tracking code here.<br />It will be added into the footer of this theme' , _DEV_ ) 
    );
    
        
	_panel::$fields[ 'settings' ][ 'general' ][ 'theme' ][ 'copyright' ] = array(
        'type' => 'st--textarea',
        'label' => __( 'Copyright text' , _DEV_ ),
        'hint' => __( 'Type here the Copyright text that will appear in the footer.<br />To display the current year use "%year%"' , _DEV_ )
    );

	_panel::$fields[ 'settings' ][ 'general' ][ 'user_registration' ][ 'email_subject' ] = array(
		'label' => __( 'Subject for the registration email' , _DEV_ ),
		'type' => 'st--text',
		'hint' => '%sitename%&mdash;'.__( 'Site name' , _DEV_ )
	);

	_panel::$fields[ 'settings' ][ 'general' ][ 'user_registration' ][ 'message' ] = array(
		'label' => __( 'Text for the registration email' , _DEV_ ),
		'type' => 'st--textarea',
		'hint' => '%sitename%&mdash;'.__( 'Site name' , _DEV_ ).
					'<br>%username%&mdash;'.__( 'User login used at registration' , _DEV_ ).
					'<br>%password%&mdash;'.__( 'The generated user password' , _DEV_ ).
					'<br>%loginurl%&mdash;'.__( 'The link to login page' , _DEV_ )
	);
?>