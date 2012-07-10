<?php
    class body{
        public function attrClass( $classes = '' ){
            if( is_home() && is_front_page() ){
                if( !empty( $classes ) ){
                    $classes .= ' home';
                }else{
                    $classes = 'home';
                }
            }
                    
            if( _core::method( '_settings' , 'logic' , 'settings' , 'style' , 'general' , 'fixed-layout' ) ){
                if( _core::method( '_settings' , 'logic' , 'settings' , 'style' , 'general' , 'boxed-layout' ) ){
                    if( !empty( $classes ) ){
                        $classes .= ' larger';
                    }else{
                        $classes .= 'larger';
                    }
                }
            }
        
            if( isset( $_GET[ 'fp_type' ] ) && !empty( $_GET[ 'fp_type' ] ) ){
                if( !empty( $classes ) ){
                    $classes .= ' custom_posts';
                }else{
                    $classes .= 'custom_posts';
                }
            }
            
            /* night / day / color */
            $classes .= ' ' . _core::method( 'layout' , 'style' ) ;
            
            body_class( $classes );
        }
        
        public function preload(){
            ?>
                <div style="display:none" id="ajax-indicator">
                    <div style="position:absolute; margin-left:-77px; margin-top:-39px; top:50%; left:50%;">
                        <object width="150" height="150" type="application/x-shockwave-flash" data="<?php echo get_template_directory_uri() ?>/images/preloader.swf" id="ajax-indicator-swf" style="visibility: visible;">
                            <param name="quality" value="high" />
                            <param name="allowscriptaccess" value="always" />
                            <param name="wmode" value="transparent" />
                            <param name="scale" value="noborder" />
                        </object>
                    </div>
                </div>
            <?php
        }
        
        
        public function header(){
                if( _core::method( '_settings' , 'logic' , 'settings' , 'style' , 'general' , 'fixed-layout' ) ){
                    $cl = '';
                }else{
                    $cl = 'full-width';
                }
            ?>
                <body <?php _core::method( 'body' , 'attrClass' ); _core::method( 'body' , 'style' ); ?>>
                    
                    <?php _core::method( 'body' , 'preload' ); ?>
                    
                    <div class="b_body" id="wrapper" >
                        <div class="b_body_c <?php echo $cl; ?>">
							<div id="fb-root"></div>
                        <?php
                            _core::method( 'header' , 'main' );
        }
        
        public function footer(){
                        _core::method( 'footer' , 'main' );
                    ?>
                    </div>
                </div>
            <?php
        }
        
        public function style(){
            global $post;
            
            $bgstyle = '';
            
            if( is_singular() ){
                $posts_settings = _core::method( '_meta' , 'get' , (int)$post -> ID , 'posts-settings' );

                /* GENERAL STYLE */
                $background = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background' );
                $color = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background_color' );

                if( ( isset( $posts_settings[ 'background-color' ] ) && !empty( $posts_settings[ 'background-color' ] ) ) || ( isset( $posts_settings[ 'background-image' ] ) && !empty( $posts_settings[ 'background-image' ] ) ) ){
                    $single = '';
                    
                    if( isset( $posts_settings[ 'background-color' ] ) && !empty( $posts_settings[ 'background-color' ] ) ){
                        if( _settings::$default[ 'settings' ][ 'style' ][ 'general' ][ 'background_color' ] != $posts_settings[ 'background-color' ] ){
                            $single .= 'background-color: ' . $posts_settings[ 'background-color' ] . ' !important;';
                        }else{
                            if( _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'color' ) == 'color' ){
                                $single .= 'background-color: ' . $color . ' !important;';
                            }
                        }
                    }

                    if( isset( $posts_settings[ 'background-image' ] ) && !empty( $posts_settings[ 'background-image' ] ) ){
                        $single .= "background-image: url('" . $posts_settings[ 'background-image' ] . "');";

                        if( isset( $posts_settings[ 'background-posi$tion' ] ) && !empty( $posts_settings[ 'background-position' ] ) ){
                            $single .= "background-position: " . $posts_settings[ 'background-position' ] . ";";
                        }

                        if( isset( $posts_settings[ 'background-repeat' ] ) && !empty( $posts_settings[ 'background-repeat' ] ) ){
                            $single .= "background-repeat: " . $posts_settings[ 'background-repeat' ] . ";";
                        }

                        if( isset( $posts_settings[ 'background-attachment-type' ] ) && !empty( $posts_settings[ 'background-attachment-type' ] ) ){
                            $single .= "background-attachment: " . $posts_settings[ 'background-attachment-type' ] . ";";
                        }
                    }else{
                        if( strlen( $background ) > 1 && !strpos( "none.png" , $background ) ){
                            $single .= "background-image: url('" . str_replace( "s.pattern" , "pattern" , $background ) . "');";
                            $single .= "background-repeat: repeat;";
                        }
                    }
                    
                    echo ' style="' . $single . '"';
                }else{
                    /* GENERAL CUSTOM CSS */
                    $background = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background' );
                    $color = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background_color' );

                    $general = '';
                    if( strlen( $background ) > 1 && !strpos( "none.png" , $background ) ){
                        $bgstyle .= "background-image: url('" . str_replace( "s.pattern" , "pattern" , $background ) . "');";
                        $bgstyle .= "background-repeat: repeat;";
                        if( _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'color' ) == 'color' ){
                            $bgstyle .= "background-color: " . $color . ";";   
                        }
                    }

                    if( !empty( $bgstyle ) ){
                        $general .= ' style="' . $bgstyle .  '"';
                    }

                    echo $general;
                }
            }else{
                /* GENERAL CUSTOM CSS */
                $background = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background' );
                $color = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'background_color' );

                $general = '';
                if( strlen( $background ) > 1 && !strpos( "none.png" , $background ) ){
                    $bgstyle .= "background-image: url('" . str_replace( "s.pattern" , "pattern" , $background ) . "');";
                    $bgstyle .= "background-repeat: repeat;";
                    if( _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'color' ) == 'color' ){
                        $bgstyle .= "background-color: " . $color . ";";
                    }
                }

                if( !empty( $bgstyle ) ){
                    $general .= ' style="' . $bgstyle .  '"';
                }

                echo $general;
            }
        }
    }
?>