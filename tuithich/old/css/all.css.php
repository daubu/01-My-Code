<?php
    header( 'Content-type:text/css' );
    include '../../../../wp-load.php';
    
    include 'generic.css.php';
    
    $noinclude = array( 'generic.css.php' , 'all.css.php' , 'iehacks.css' , 'iehacks7.css' , 'wp_editor_day.css' , 'wp_editor_night.css','custom.css'  );
    $files = scandir( get_template_directory() . '/css' );
    $custom = false;
    foreach( $files as $file ){
        if( file_exists( $file ) && !in_array( $file , $noinclude ) && is_file( $file ) ){
            echo "\n/* file : " . $file . " */\n";
            include $file;
        }
        
        if( $file == 'custom.css' ){
            $custom = true;
        }
    }
    
    /* custom css // use options _options::value(  'css' , 'custom' , 'file' ) */
    if( $custom ){
        include 'custom.css';
    }
    
    echo _core::method( '_settings' , 'get' , 'extra' , 'settings' , 'css' , 'header-css' );
    echo _core::method( '_settings' , 'get' , 'extra' , 'settings' , 'css' , 'general-css' );
    
    $bgstyle = '';
    
    /* CUSTOM CSS ON SINGLE */
    if( isset( $_GET[ 'post' ] ) && (int)$_GET[ 'post' ] > 0 ){
        $posts_settings = _core::method( '_meta' , 'get' , (int)$_GET[ 'post' ] , 'posts-settings' );
        
        /* GENERAL STYLE */
        $background = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background' );
        $color = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background_color' );
        
        if( ( isset( $posts_settings[ 'background-color' ] ) && !empty( $posts_settings[ 'background-color' ] ) ) || ( isset( $posts_settings[ 'background-image' ] ) && !empty( $posts_settings[ 'background-image' ] ) ) ){
           
        }else{
            /* GENERAL CUSTOM CSS */
            $background = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background' );
            $color = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background_color' );

            $general = '';
            if( strlen( $background ) > 1 && !strpos( "none.png" , $background ) ){
                $bgstyle .= "\tbackground-image: url('" . str_replace( "s.pattern" , "pattern" , $background ) . "');\n";
                $bgstyle .= "\tbackground-repeat: repeat;\n";
                $bgstyle .= "\tbackground-color: " . $color . ";\n";   
            }
        }
    }else{
        /* GENERAL CUSTOM CSS */
        $background = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background' );
        $color = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background_color' );
        
        $general = '';
        if( strlen( $background ) > 1 && !strpos( "none.png" , $background ) ){
            $bgstyle .= "\tbackground-image: url('" . str_replace( "s.pattern" , "pattern" , $background ) . "');\n";
            $bgstyle .= "\tbackground-repeat: repeat;\n";
            $bgstyle .= "\tbackground-color: " . $color . ";\n";   
        }
    }
    
    $slidepanel  = "div#slidePanel.slide-panel {\n";
    $slidepanel .= $bgstyle;
    $slidepanel .= "}\n";
    
    echo $slidepanel;
    
    include '../lib/core/css/shortcode.css';
	
	if( _core::method( "_settings" , "logic" , "settings" , 'general' , 'theme' , 'custom_gallery' ) ){
		
		$custom_gallery = ".gallery-icon .mosaic-overlay { background: #fff url(../images/hover-magnify-small.png) no-repeat center 50%; opacity: 0; -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=00)'; filter: alpha(opacity=00); display: none; }
		.gallery-icon .mosaic-overlay { display: none; z-index: 5; position: absolute; top: 0; left: 0;  width: 290px; height: 145px; }


		.gallery { margin: 0 auto 18px; float: left; display: inline-block; }
		.gallery .gallery-item { float: left; margin: 10px 25px 10px 0!important; text-align: left; position: relative;}

		.gallery.colls-2 .gallery-item:nth-child(2n+0) { margin:10px 0 10px 0!important; }
		.gallery.colls-3 .gallery-item:nth-child(3n+0) { margin:10px 0 10px 0!important; }
		.gallery.colls-4 .gallery-item:nth-child(4n+0) { margin:10px 0 10px 0!important; }

		.gallery-columns-2 .gallery-item { width: 50%; }
		.gallery-columns-4 .gallery-item { width: 25%; }
		.gallery-columns-2 .attachment-medium { max-width: 92%; height: auto; }
		.gallery-columns-4 .attachment-thumbnail { max-width: 84%; height: auto; }
		.gallery .gallery-caption { text-align: left; font-size: 14px; line-height: 20px; margin-bottom: 15px; font-family: 'PT Sans Narrow', Helvetica, Arial, sans-serif; font-weight: normal }
		.gallery dl { margin: 0; }
		.gallery img { width: 290px; height: 145px; background: whiteSmoke; border: none!important;}
		.gallery br+br { display: none; }";
		
		echo $custom_gallery;
	}
?>

body td.mceIframeContainer.mceFirst.mceLast{ background-color: #ffffff; }
body.night td.mceIframeContainer.mceFirst.mceLast{ border: 1px solid #272727; background-color: #333333 }