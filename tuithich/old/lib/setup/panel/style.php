<?php
    /* FAVICON */
    $path_parts = pathinfo( _settings::get( 'settings' , 'style' , 'general' , 'favicon' ) );
    
    if( strlen( _settings::get( 'settings' , 'style' , 'general' , 'favicon' ) ) && $path_parts['extension'] != 'ico' ){
        $icon_hint = '<span style="color:#cc0000;">' . __( 'Error, please select "ico" type media file' , _DEV_ ) . '</span>';
    }else{
        $icon_hint = __( "Please select 'ico' type media file. Make sure you allow uploading 'ico' type in General Settings -> Upload file types" , _DEV_ );
    }

	_panel::$fields['settings']['style']['general']['bg_title'] = array( 
		'type' => 'ni--title' ,
		'title' => __( 'Select theme background' , _DEV_ )
	);

	$pattern_path = 'pattern/s.pattern.';
    $pattern = array(
        "flowers"=>"flowers.png" , "flowers_2"=>"flowers_2.png" , "flowers_3"=>"flowers_3.png" , "flowers_4"=>"flowers_4.png" ,"circles"=>"circles.png","dots"=>"dots.png","grid"=>"grid.png","noise"=>"noise.png",
        "paper"=>"paper.png","rectangle"=>"rectangle.png","squares_1"=>"squares_1.png","squares_2"=>"squares_2.png","thicklines"=>"thicklines.png","thinlines"=>"thinlines.png" , "none"=>"none.png"
    );

	_panel::$fields[ 'settings' ][ 'style' ][ 'general' ][ 'background' ] = array(
		'type' => 'ni--radio-icon' , 
		'value' => $pattern , 
		'path' => $pattern_path , 'in_row' => 6 
	);
    
    _panel::$fields[ 'settings' ][ 'style' ][ 'general' ][ 'color' ] = array(
        'type' => 'st--select',
        'values' => array(
            'day' => __( 'White' , _DEV_ ),
            'night' => __( 'Dark' , _DEV_ ),
            'darkheader' => __( 'Dark Header' , _DEV_ ),
            'color' => __( 'Custom' , _DEV_ )
        ),
        'label' => __( 'Select theme style' , _DEV_ ),
        'action' => "tools.sh.select( this , { 'color' : '.bg_color' } )"
    );
    
    if( _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'color' ) == 'color' ){
        $bgclasses = 'bg_color';
    }else{
        $bgclasses = 'bg_color hidden';
    }
    
	_panel::$fields['settings']['style']['general']['background_color'] = array(
		'type' => 'st--color-picker' ,
		'label' => __( 'Set background color' , _DEV_ ),
		'hint' => __( 'To set a background image go to' , _DEV_ ) . ' <a href="themes.php?page=custom-background">' . __( 'Appearence - Background'  , _DEV_ ) . '</a>',
        'classes' => $bgclasses
	);
    
    _panel::$fields[ 'settings' ][ 'style' ][ 'general' ][ 'switcher' ] = array(
        'type' => 'st--logic-radio',
        'label' => __( 'Display style switcher' , _DEV_ )
        
    );
    
    _panel::$fields['settings']['style']['general']['fixed-layout']=array(
		'type' => 'st--logic-radio',
		'label' => __( 'Fixed width layout' , _DEV_ )
	);

	/*_panel::$fields['settings']['style']['general']['boxed-grid-view']=array(
		'type' => 'st--logic-radio',
		'label' => __( 'Boxed grig view' , _DEV_ )
        
	);*/
	
	_panel::$fields[ 'settings' ][ 'style' ][ 'general' ][ 'favicon' ] = array(
        'type' => 'st--upload',
        'label' => __( 'Custom favicon' , _DEV_ ),
        'id' => 'favicon_path',
        'hint' => $icon_hint
    );
    
    /* LOGO TYPE */
    _panel::$fields[ 'settings' ][ 'style' ][ 'general' ][ 'logo_type' ] = array(
        'type' => 'st--select',
        'label' => __( 'Logo type ' , _DEV_ ),
        'values' => array(
            'text' => __( 'Text logo' , _DEV_ ),
            'image' => __( 'Image logo' , _DEV_ ),
        ),
        'action' => "tools.sh.select( this , { 'text' : '.lg_text' , 'image' : '.lg_image'  } )"
    );
    
    if( _settings::get( 'settings' , 'style' , 'general' , 'logo_type' ) == 'text' ){
        $lg_image   = 'lg_image hidden';
        $lg_text    = 'lg_text';
    }else{
        $lg_image   = 'lg_image';
        $lg_text    = 'lg_text hidden';
    }
    
    _panel::$fields[ 'settings' ][ 'style' ][ 'general' ][ 'logo_upload' ] = array(
        'type' => 'st--upload',
        'label' => __( 'Custom logo URL' , _DEV_ ),
        'id' => 'logo_path',
        'classes' => $lg_image
    );
    
    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'general' , 'logo_text' , true ,
        /* font classes     */  $lg_text ,
        /* preview text     */  __( 'Text for preview ' , _DEV_ ) ,

        /* default value    */
        array(
            'PT+Sans+Narrow' , 32 , 'normal' , /* family , size ( px ) , weight */
            '' , 'none' , 'left' , 32 , /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ) ,

            /* padding      */
            array( null, null, 0, null ) ,

            /* border : top/right/bottom/left      */
            array(null ,null ,null ,null)
        ),

        /* hover value color , decoration */
        array( '' , 'none' )
    );
    
	/* SINGLE */
	_panel::$fields[ 'settings' ][ 'style' ][ 'single' ][ 'post_title' ] = array(
        'type' => 'ni--title',
        'title' => __( 'Post Title styles' , _DEV_ )
    );
	
	/* PTGS - Page Tab Group Set */
    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'single' , 'post_title' , false,
        /* font classes     */  'single_post_title',
        /* preview text     */  __( 'Text for preview ' , _DEV_ ),
        /* default value    */
        array(
            'PT+Sans+Narrow' , 26 , 'normal', /* family , size ( px ) , weight */
            '' , 'none' , null , 24, /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ),

            /* padding      */
            array( null, null, null, null ),

            /* border : top/right/bottom/left      */
            array(null ,null ,null ,null)
        )

        /* hover value color , decoration */
        /* array( '#990000' , 'none' ) */
    );
	
	
	_panel::$fields[ 'settings' ][ 'style' ][ 'single' ][ 'post_text' ] = array(
        'type' => 'ni--title',
        'title' => __( 'Post content text styles' , _DEV_ )
    );
	
	/* PTGS - Page Tab Group Set */
    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'single' , 'post_text' , false,
        /* font classes     */  'single_post_text',
        /* preview text     */  __( 'Text for preview ' , _DEV_ ),
        /* default value    */
        array(
            null , null , 'normal', /* family , size ( px ) , weight */
            '' , 'none' , null , null, /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ),

            /* padding      */
            array( null, null, null, null ) ,

            /* border : top/right/bottom/left      */
            array(null ,null ,null ,null)
        )

        /* hover value color , decoration */
        /* array( '#990000' , 'none' ) */
    );
	
	/* PAGE */
	_panel::$fields[ 'settings' ][ 'style' ][ 'page' ][ 'post_title' ] = array(
        'type' => 'ni--title',
        'title' => __( 'Page Title styles' , _DEV_ )
    );
	
	/* PTGS - Page Tab Group Set */
    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'page' , 'post_title' , false,
        /* font classes     */  'single_post_title',
        /* preview text     */  __( 'Text for preview ' , _DEV_ ),
        /* default value    */
        array(
            'PT+Sans+Narrow' , 26 , 'normal', /* family , size ( px ) , weight */
            '' , 'none' , null , 24 , /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ),

            /* padding      */
            array( null, null, null, null ),

            /* border : top/right/bottom/left      */
            array(null ,null ,null ,null)
        )

        /* hover value color , decoration */
        //array( '#990000' , 'none' )
    );

	_panel::$fields[ 'settings' ][ 'style' ][ 'page' ][ 'post_text' ] = array(
        'type' => 'ni--title',
        'title' => __( 'Post content text styles' , _DEV_ )
    );
	
	/* PTGS - Page Tab Group Set */
    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'page' , 'post_text' , false,
        /* font classes     */  'single_post_text',
        /* preview text     */  __( 'Text for preview ' , _DEV_ ),

        /* default value    */
        array(
            null , null , 'normal', /* family , size ( px ) , weight */
            '' , 'none' , null , null, /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ),

            /* padding      */
            array( null, null, null, null ),

            /* border : top/right/bottom/left */
            array(null ,null ,null ,null)
        )

        /* hover value color , decoration */
        /* array( '#990000' , 'none' ) */
    );
    
    /* ARCHIVE STYLE */
    _panel::$fields[ 'settings' ][ 'style' ][ 'archive' ][ 'page-title-title' ] = array(
        'type' => 'ni--title',
        'title' => __( ' Style customizations for archive page title' , _DEV_ )
    );

    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'archive' , 'title' , false ,
        /* font classes     */  '' ,
        /* preview text     */  __( 'Page Text for preview ' , _DEV_ ) ,

        /* default value    */
        array(
            'PT+Sans+Narrow' , 26 , 'normal' , /* family , size ( px ) , weight */
            '' , 'none' , 'left' , 24 , /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ) ,

            /* padding      */
            array( null, null, 0, null ) ,

            /* border : top/right/bottom/left      */
            array(null ,null ,null ,null)
        )

        /* hover value color , decoration */
        /* array( '#990000' , 'none' )    */
    );
    
    _panel::$fields[ 'settings' ][ 'style' ][ 'archive' ][ 'post-title-title' ] = array(
        'type' => 'ni--title',
        'title' => __( ' Style customizations for post title from archive ( list view )' , _DEV_ )
    );
    
    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'archive' , 'post-title' , true ,
        /* font classes     */  '' ,
        /* preview text     */  __( 'Post title for preview ' , _DEV_ ) ,

        /* default value    */
        array(
            'PT+Sans+Narrow' , 20 , 'normal' , /* family , size ( px ) , weight */
            '' , 'none' , 'left' , 20 , /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ) ,

            /* padding      */
            array( null, null, 0, null ) ,

            /* border : top/right/bottom/left      */
            array(null ,null ,null ,null)
        ),

        /* hover value color , decoration */
        array( '' , 'none' )
    );
    
    _panel::$fields[ 'settings' ][ 'style' ][ 'archive' ][ 'post-excerpt-title' ] = array(
        'type' => 'ni--title',
        'title' => __( ' Style customizations for post content from archive ( list view )' , _DEV_ )
    );
    
    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'archive' , 'post-excerpt' , false ,
        /* font classes     */  '' ,
        /* preview text     */  __( 'Post title for preview' , _DEV_ ) ,

        /* default value    */
        array(
            '' , 12 , 'normal' , /* family , size ( px ) , weight */
            '' , 'none' , 'left' , 13 , /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ) ,

            /* padding      */
            array( null, null, 0, null ) ,

            /* border : top/right/bottom/left      */
            array(null ,null ,null ,null)
        )

        /* hover value color , decoration */
        /* array( '#FA5D5D' , 'none' ) */
    );
	
	/* SIDEBAR WIDGETS */
	_panel::$fields[ 'settings' ][ 'style' ][ 'sidebars' ][ 'widget_title' ] = array(
        'type' => 'ni--title',
        'title' => __( 'Widget title' , _DEV_ )
    );
	
	/* PTGS - Page Tab Group Set */
    _text::fields (
        /* PTGS,link        */  'settings' , 'style' , 'sidebars' , 'widget_title' , true,
        /* font classes     */  'sdb_widget_title',
        /* preview text     */  __( 'Text for preview ' , _DEV_ ),
        /* default value    */
        array(
            '' , null , null, /* family , size ( px ) , weight */
            '' , 'none' , null , null, /* color, decoration, align , line-height */

            /* margin       */
            array( null, null, null , null ),

            /* padding      */
            array( null, null, null, null ),

            /* border : top/right/bottom/left */
            array(null ,null ,null ,null)
        )

        /* hover value color , decoration */
        /* array( '#990000' , 'none' ) */
    );
?>