<?php
    class layout{
        public static function useSingularSidebar( $postID ){
            
            $post = get_post( $postID );
            
            if( !empty( $post ) && !is_wp_error( $post ) ){
                if( $post -> post_type == 'page' ){
                    $template = 'page';
                }else{
                    $template = 'single';
                }
            }else{
                $template = 'single';
            }
            
            $position = _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , $template );
            $meta = _core::method( '_meta' , 'get' , $postID , 'layout' );
            
            if( $position != 'full' ){
                if( isset( $meta[ 'style' ] ) && !empty( $meta[ 'style' ] ) ){
                    if( $meta[ 'style' ] != 'full' ){
                        $result = true;
                    }else{
                        $result = false;
                    }
                }else{
                    $result = true;
                }
            }else{
                if( isset( $meta[ 'style' ] ) && !empty( $meta[ 'style' ] ) ){
                    if( $meta[ 'style' ] != 'full' ){
                        $result = true;
                    }else{
                        $result = false;
                    }
                }else{
                    $result = false;
                }
            }
            
            return $result;
        }
        
        public static function useArchiveSidebar( $template ){
            $position = _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , $template );
            
            if( $position != 'full' ){
                $result = true;
            }else{
                $result = false;
            }
            
            return $result;
        }
        
        public static function singularSidebarPosition( $postID ){
            
            $post = get_post( $postID );
            
            if( !empty( $post ) && !is_wp_error( $post ) ){
                if( $post -> post_type == 'page' ){
                    $template = 'page';
                }else{
                    $template = 'single';
                }
            }else{
                $template = 'single';
            }
            
            $position = _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , $template );
            $meta = _core::method( '_meta' , 'get' , $postID , 'layout' );
            
            if( isset( $meta[ 'style' ] ) && !empty( $meta[ 'style' ] ) ){
                $result = $meta[ 'style' ];
            }else{
                $result = $position;
            }
            
            return $result;
        }
        
        public static function singularSidebar( $postID , $position ){
            
            $meta = _core::method( '_meta' , 'get' , $postID , 'layout' );
            
            if( _core::method( 'layout' , 'useSingularSidebar' , $postID ) ){
                
                if( $position == 'right' ){
                    $classes = 'b';
                }else{
                    $classes = 'fl';
                }

                if( $position == _core::method( 'layout' , 'singularSidebarPosition' ,  $postID ) ){
                                        
                    echo '<section id="secondary" class="widget-area w_290 ' . $classes . '" role="complementary">';
                    
                    if( isset( $meta[ 'sidebar' ] ) && !empty( $meta[ 'sidebar' ] ) && $meta[ 'sidebar' ] != 'main' ){
                        
                        dynamic_sidebar(  $meta[ 'sidebar' ] );
                    }else{
                        get_sidebar();
                    }
                    echo '</section>';
                }
            }
        }
        
        public static function singularMeta( $postID , $position ){
                                
            if( _core::method( 'post_settings' , 'useMeta' , $postID ) || _core::method( 'post_settings' , 'useRelated' , $postID ) ){
                if( _core::method( 'layout' , 'useSingularSidebar' , $postID ) ){

                    if( _core::method( 'layout' , 'singularSidebarPosition' ,  $postID ) == 'full' ){
                        if( $position == 'right' ){
                            
                                echo '<div ' . _core::method( 'layout' , 'singularMetaClasses' , $postID ) . '>';
                                
                                if( _core::method( 'post_settings' , 'useMeta' , $postID ) ){
                                    
                                    echo '<div class="entry-meta ">';

                                    get_template_part( '/templates/single/meta' );

                                    echo '</div>';

                                    get_template_part( '/templates/single/tags' );
                                    get_template_part( '/templates/single/source' );
                                    
                                }
                                
                                get_template_part( '/templates/single/related' );
                                
                                echo '</div>';
                        }
                    }else{
                        if( _core::method( 'layout' , 'singularSidebarPosition' ,  $postID ) != $position ){
                            
                            
                            echo '<div ' . _core::method( 'layout' , 'singularMetaClasses' , $postID ) . '>';
                            
                            if( _core::method( 'post_settings' , 'useMeta' , $postID ) ){
                                
                                echo '<div class="entry-meta ">';

                                get_template_part( '/templates/single/meta' );

                                echo '</div>';

                                get_template_part( '/templates/single/tags' );
                                get_template_part( '/templates/single/source' );
                                
                            }
                            
                            get_template_part( '/templates/single/related' );

                            echo '</div>';
                        }
                    }
                }else{
                    if( $position == 'right' ){
                        echo '<div ' . _core::method( 'layout' , 'singularMetaClasses' , $postID ) . '>';
                        
                        if( _core::method( 'post_settings' , 'useMeta' , $postID ) ){
                            
                            echo '<div class="entry-meta ">';

                            get_template_part( '/templates/single/meta' );

                            echo '</div>';


                            get_template_part( '/templates/single/tags' );
                            get_template_part( '/templates/single/source' );
							get_template_part( '/templates/single/facebook_like' );
                            
                        }
                        
                        //get_template_part( '/templates/single/related' );
                        
                        echo '</div>';
                    }
                }
            }
        }
        
        public static function singularClasses( $postID ){
            $sidebar = _core::method( 'layout' , 'singularSidebarPosition' , $postID );
            
            if( $sidebar == 'right' ){
                $position = 'fl';
                $size = 'w_610';
            }else{
                if( $sidebar == 'left' ){
                    $position = 'b';
                    $size = 'w_610';
                }else{
                    $position = '';
                    $size = 'w_930';
                }
            }
            
            if( _core::method( 'post_settings' , 'useMeta' , $postID ) || _core::method( 'post_settings' , 'useRelated' , $postID ) ){
                echo 'class="' . $size . ' ' . $position . ' meta"';
            }else{
                echo 'class="' . $size . ' ' . $position . '"';
            }
        }
        
        public static function contentClasses( $postID ){
            $sidebar = _core::method( 'layout' , 'singularSidebarPosition' , $postID );
            
            if( $sidebar == 'right' ){
                
                if( _core::method( 'post_settings' , 'useMeta' , $postID ) || _core::method( 'post_settings' , 'useRelated' , $postID ) ){
                    $position = 'b';
                    $size = 'w_450';
                }else{
                    $position = 'fl';
                    $size = 'w_610';
                }
                
            }else{
                if( $sidebar == 'left' ){
                    if( _core::method( 'post_settings' , 'useMeta' , $postID ) || _core::method( 'post_settings' , 'useRelated' , $postID ) ){
                        $position = 'fl';
                        $size = 'w_450';
                    }else{
                        $position = '';
                        $size = '';
                    }
                }else{
                    $position = '';
                    
                    if( _core::method( 'post_settings' , 'useMeta' , $postID ) || _core::method( 'post_settings' , 'useRelated' , $postID ) ){
                        $size = 'w_770';
                    }else{
                        $size = 'w_930';
                    }
                }
            }
            
            if( _core::method( '_settings' , 'logic' , 'settings' , 'style' , 'general' , 'fixed-layout'  ) ){
                echo 'class="' . $size . ' ' . $position . ' single"';
            }else{
                echo 'class="' . $position . ' single"';
            }
        }
        
        public static function singularMetaClasses( $postID ){
            $sidebar = _core::method( 'layout' , 'singularSidebarPosition' , $postID );
            
            if( $sidebar == 'right' ){
                $position = 'fl';
            }else{
                $position = 'b';
            }
            
            if( _core::method( '_settings' , 'logic' , 'settings' , 'style' , 'general' , 'fixed-layout'  ) ){
                return 'class="sidebar ' . $position . ' w_130"';
            }else{
                return 'class="sidebar ' . $position . '"';
            }
        }
        
        public static function singularLn( $postID ){
            $sidebar = _core::method( 'layout' , 'singularSidebarPosition' , $postID );
            
            if( $sidebar == 'full' ){
                
                if( _core::method( 'post_settings' , 'useMeta' , $postID ) || _core::method( 'post_settings' , 'useRelated' , $postID ) ){
                    $size = 770;
                }else{
                    $size = 930;
                }
                
            }else{
                if( _core::method( 'post_settings' , 'useMeta' , $postID ) || _core::method( 'post_settings' , 'useRelated' , $postID ) ){
                    $size = 450;
                }else{
                    $size = 610;
                }
            }
            
            return $size;
        }
        
        
        public static function archiveSidebar( $position , $template ){
            
            $sidebar = _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , $template . '_sidebar' );
            
            if( _core::method( 'layout' , 'useArchiveSidebar' , $template ) ){
                
                if( $position == 'right' ){
                    $classes = 'b';
                }else{
                    $classes = 'fl';
                }

                if( $position == _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , $template ) ){
                                        
                    echo '<section id="secondary" class="widget-area w_290 ' . $classes . '" role="complementary">';
                    
                    if( !empty( $sidebar ) && $sidebar != 'main' ){
                        
                        dynamic_sidebar(  $sidebar );
                    }else{
                        get_sidebar();
                    }
                    echo '</section>';
                }
            }
        }
        
        public static function archiveClasses( $template ){
            $sidebar = _core::method( '_settings' , 'get' , 'settings' , 'layout' , 'style' , $template );
            
            if( $sidebar == 'full' ){
                $position = '';
                $size = 'w_930';
            }else{
                $size = 'w_610';
                
                if( $sidebar == 'right' ){
                    $position = 'fl';
                }else{
                    $position = 'b';
                }    
            }
            
            echo 'class="' . $size . ' ' . $position . '"';
            
        }
        
        public function is_grid( $template ){
            
            if( _core::method( '_settings' , 'logic' , 'settings' , 'layout' , 'style' , $template . '_view'  ) ){
                $grid = false;
            }else{
                $grid = true;
            }
            return $grid;
        }
        
        public function style(){
            if( isset( $_COOKIE[ ZIP_NAME  . 'style' ] ) ){
                if(  $_COOKIE[ ZIP_NAME  . 'style' ] == 'night' ){
                    $result = 'night';
                }else{
                    if( $_COOKIE[ ZIP_NAME  . 'style' ] == 'day' ){
                        $result = 'day';
                    }else{
                        if( $_COOKIE[ ZIP_NAME  . 'style' ] == 'darkheader' ){
                            $result = 'color';
                        }else{
                            if( _core::method(  '_settings' , 'get' , 'settings' , 'style' , 'general' , 'color' ) == 'night' ){
                                $result = 'night';
                            }else{
                                if( _core::method(  '_settings' , 'get' , 'settings' , 'style' , 'general' , 'color' ) == 'darkheader' ){
                                    $result = 'color';
                                }else{
                                    $result = 'day';
                                }
                            }
                        }
                    }
                }
            }else{
                if( _core::method(  '_settings' , 'get' , 'settings' , 'style' , 'general' , 'color' ) == 'night' ){
                    $result = 'night';
                }else{
                    if( _core::method(  '_settings' , 'get' , 'settings' , 'style' , 'general' , 'color' ) == 'darkheader' ){
                        $result = 'color';
                    }else{
                        $result = 'day';
                    }
                }
            }
            
            return $result;
        }
    }
?>