<?php
    class _likes{
        public static function load(){
            $method = isset( $_POST['method'] ) ? $_POST['method'] : exit;
            $args   = isset( $_POST['args'] ) ? $_POST['args'] : exit;
            $object = new _resources();
            if( is_array( $method ) ){
                foreach( $method as $m ){
                    if( method_exists( $object , $m ) ){
                        echo call_user_func_array( array( '_resources' , $m ), $args );
                    }
                }
            }else{
                if( method_exists( $object , $method ) ){
                    echo call_user_func_array( array( '_resources' , $method ), $args );
                }
            }
            exit;
        }
        
        public static function antiLoop(){
            $id = md5( md5( $_SERVER['HTTP_USER_AGENT'] ) );
            
            $time = mktime();

            $user = get_option('set_user_like');

            if( is_array( $user ) && array_key_exists( $id , $user ) ){
                if( (int) $user[ $id ] + 2  < (int) $time  ){
                    $user[ $id ]  = (int) $time;
                    update_option( 'set_user_like' , $user );
                    return false;
                }else{
                    $user[ $id ]  = (int) $time;
                    update_option( 'set_user_like' , $user );
                    return true;
                }
            }else{
                $user[ $id ]  = (int) $time;
                update_option( 'set_user_like' , $user );
                return true;
            }
        }
        
        public static function set( $post_id = 0 ){
            if( $post_id == 0 ){
                $post_id = isset( $_POST[ 'postID' ] ) ? $_POST[ 'postID' ] : 0;
                $ajax = true;
            }
            
			/* actually it may be like or hate */
            $likes = _meta::get( $post_id , 'like' );
            
            if( empty( $likes ) || !is_array( $likes  ) ){
                $likes = array();
            }
			
            /*if( self::antiLoop() ){
                $response = (int)count( $likes );
                
                if( $ajax ){
                    echo $response;
                    exit();
                }else{
                    return $response;
                }
            }*/

            $user       = true;
            $user_ip    = true;
						
            $ip     = $_SERVER['REMOTE_ADDR'];

            if( is_user_logged_in () ){
                $user_id = get_current_user_id();
            }else{
                $user_id = 0;
            }

            if( $user_id > 0 ){
                /* likes/hates by user */
                foreach( $likes as  $like ){
                    if( isset( $like['user_id'] ) && $like['user_id'] == $user_id ){  
						/* if this user already clicked this button for this post */
                        $user   = false;
                        $user_ip = false;
                    }
                }
            }else{
                if( !self::useLikes( $post_id ) ){
                    if( $ajax ){
                        exit();
                    }else{
                        return '';
                    }
                }
                foreach( $likes as  $like ){
                    if( isset( $like['ip'] ) && ( $like['ip'] == $ip ) ){
						/* if a user from the same IP already clicked this button for this post */
                        $user = false;
                        $user_ip = false;
                    }
                }
            }

            if( $user && $user_ip ){
                /* add like */ 
                $likes[] = array( 'user_id' => $user_id , 'ip' => $ip );
                _meta::set( $post_id , 'nr_like' , count( $likes ) );
                _meta::set( $post_id , 'like' ,  $likes );
                $date = _meta::get( $post_id , 'hot_date' );
                if( empty( $date ) ){
                    if( ( count( $likes ) >= (int)self::minLikes( $post_id ) ) ){
                        _meta::set( $post_id , 'hot_date' , mktime() );
                    }
                }else{
                    if( ( count( $likes ) < (int)self::minLikes( $post_id ) ) ){
                        _meta::remove( $post_id , 'hot_date' );
                    }
                }
            }else{
                if( !empty( $likes ) && is_array( $like ) ){
                    foreach( $likes as $index => $like ){
                        if( $user_id > 0 ){
                            if( isset( $like[ 'user_id' ] ) && $like[ 'user_id' ] == $user_id ){
                                unset( $likes[ $index ] );
                            }
                        }else{
                            if( isset( $like['ip'] ) && ( $like['ip'] == $ip ) && ( $like[ 'user_id' ] == 0 ) ){
                                unset( $likes[ $index ] );
                            }
                        }
                    }

                    _meta::set( $post_id , 'nr_like' , count( $likes ) );
                    _meta::set( $post_id , 'like' ,  $likes );

                    if( ( count( $likes ) < (int)self::minLikes( $post_id ) ) ){
                        _meta::remove( $post_id , 'hot_date' );
                    }
                }
            }

            $response = (int)count( $likes );
                
            if( $ajax ){
                echo $response;
                exit();
            }else{
                return $response;
            }
        }
        
        public static function generate(){
            global $wp_query;
            
            $customID = isset( $_POST[ 'customID' ] ) ? $_POST[ 'customID' ] : exit;
            $paged = isset( $_POST[ 'page' ] ) ? $_POST[ 'page' ] : 1;
            
            $resources  = _core::method( '_resources' , '_get' );
            if( $paged == 1 ){
                if( isset( $resources[ $customID ] ) ){
                    $resources[ $customID ][ 'boxes' ][ 'posts-settings' ]['likes-use'] = 'yes';
                    update_option( _RES_ , $resources );
                }else{
                    if( _core::method( '_resources' , 'getCustomIdByPostType' , 'post' ) == $customID ){
                        _settings::edit( '_settings' , 'get' , 'settings' , 'blogging' , 'likes' , 'use' , 'yes' );
                    }
                }
            }
            
            $resources  = _core::method( '_resources' , 'get' );
            
            if( isset( $resources[ $customID ] ) ){
                $wp_query = new WP_Query( array('posts_per_page' => 150 , 'post_type' => $resources[ $customID ][ 'slug' ] , 'paged' => $paged ) );

                foreach( $wp_query -> posts as $post ){
                    $likes = array();
                    $ips = array();
                    $nr = rand( 60 , 200 );
                    while( count( $likes ) < $nr ){
                        $ip = rand( -255 , -100 ) .  '100'  . rand( -255 , -100 ) . rand( -255 , -100 );

                        $ips[ $ip ] = $ip;

                        if( count( $ips )  > count( $likes ) ){
                            $likes[] = array( 'user_id' => 0 , 'ip' => $ip );
                        }
                    }

                    _meta::set( $post -> ID , 'nr_like' , count( $likes ) );
                    _meta::set( $post -> ID , 'like' ,  $likes );
                    _meta::set( $post -> ID , 'hot_date' , mktime() );
                }

                if( $wp_query -> max_num_pages >= $paged ){
                    if( $wp_query -> max_num_pages == $paged ){
                        echo 0;
                    }else{
                        echo $paged + 1;
                    }
                }
            }
            
            exit();
        }
        
        public static function reset( ){
            global $wp_query;
            $customID = isset( $_POST[ 'customID' ] ) ? $_POST[ 'customID' ] : exit;
            $newLimit = isset( $_POST[ 'newLimit' ] ) ? $_POST[ 'newLimit' ] : exit;
            $paged = isset( $_POST[ 'page' ] ) ? $_POST[ 'page' ] : 1;
            
            $resources  = _core::method( '_resources' , '_get' );
            if( $paged == 1 ){
                if( isset( $resources[ $customID ] ) ){
                    $resources[ $customID ][ 'boxes' ][ 'posts-settings' ]['likes-use'] = 'yes';
                    $resources[ $customID ][ 'boxes' ][ 'posts-settings' ]['likes-limit'] = $newLimit;
                    update_option( _RES_ , $resources );
                }else{
                    if( _core::method( '_resources' , 'getCustomIdByPostType' , 'post' ) == $customID ){
                        _settings::edit( '_settings' , 'get' , 'settings' , 'blogging' , 'likes' , 'use' , 'yes' );
                        _settings::edit( '_settings' , 'get' , 'settings' , 'blogging' , 'likes' , 'limit' , $newLimit );
                    }
                }
            }
            
            
            
            $resources  = _core::method( '_resources' , 'get' );
            
            if( isset( $resources[ $customID ] ) ){
                $wp_query = new WP_Query( array('posts_per_page' => 150 , 'post_type' => $resources[ $customID ][ 'slug' ] , 'paged' => $paged ) );
                foreach( $wp_query -> posts as $post ){
                    $likes = _meta::get( $post -> ID , 'like' );
                    _meta::set( $post -> ID , 'nr_like' , count( $likes ) );
                    if( count( $likes ) < (int)$newLimit ){
                        delete_post_meta( $post -> ID, 'hot_date' );
                    }else{
                        if( (int)_meta::get( $post -> ID , 'hot_date' ) > 0 ){

                        }else{
                            _meta::set( $post -> ID , 'hot_date' , mktime() );
                        }
                    }
                }
                if( $wp_query -> max_num_pages >= $paged ){
                    if( $wp_query -> max_num_pages == $paged ){
                        echo 0;
                    }else{
                        echo $paged + 1;
                    }
                }
            }

            exit();
        }
        
        public static function remove(){
            global $wp_query;
            
            $customID = isset( $_POST[ 'customID' ] ) ? $_POST[ 'customID' ] : exit;
            $paged = isset( $_POST[ 'page' ] ) ? $_POST[ 'page' ] : 1;
            
            $resources  = _core::method( '_resources' , '_get' );
            
            if( $paged == 1 ){
                if( isset( $resources[ $customID ] ) ){
                    $resources[ $customID ][ 'boxes' ][ 'posts-settings' ]['likes-use'] = 'yes';
                    update_option( _RES_ , $resources );
                }else{
                    if( _core::method( '_resources' , 'getCustomIdByPostType' , 'post' ) == $customID ){
                        _settings::edit( '_settings' , 'get' , 'settings' , 'blogging' , 'likes' , 'use' , 'yes' );
                    }
                }
            }
            
            $resources  = _core::method( '_resources' , 'get' );
            
            if( isset( $resources[ $customID ] ) ){
                $wp_query = new WP_Query( array('posts_per_page' => 150 , 'post_type' => $resources[ $customID ][ 'slug' ] , 'paged' => $paged ) );
                foreach( $wp_query -> posts as $post ){
                    _meta::remove( $post -> ID , 'nr_like' );
                    _meta::remove( $post -> ID , 'like' );
                    _meta::remove( $post -> ID , 'hot_date' );
                }
                if( $wp_query -> max_num_pages >= $paged ){
                    if( $wp_query -> max_num_pages == $paged ){
                        echo 0;
                    }else{
                        echo $paged + 1;
                    }
                }
            }

            exit();
        }
        
        public static function count( $post_id ){
            $result = _meta::get( $post_id , 'like' );
            return count( $result );
        }
        
        public static function contentLike( $postID , $short = true ){
            if( _core::method( '_likes' , 'isVoted' , $postID ) ){
                $voted_class = 'voted';
            }else{
                $voted_class = '';
            }
            if( $short ){
                return '<li class="love '.$voted_class.'"><a href="javascript:void(0)" onclick="javascript:likes.vote( jQuery( this ) , ' . $postID . ' );" title="' . __( 'Like this?' , _DEV_ ) . '">' . __( 'like this' , _DEV_ ) . '<span>' . (int)_meta::get( $postID , 'nr_like' ) . '</span></a></li>';
            }else{
                return '<li class="love '.$voted_class.'"><a href="javascript:void(0)" onclick="javascript:likes.vote( jQuery( this ) , ' . $postID . ' );"><span>' . (int)_meta::get( $postID , 'nr_like' ) . '</span></a></li>';
            }
        }
        
        public static function isVoted( $post_id ){
            $ip  = $_SERVER['REMOTE_ADDR'];
            $likes = _meta::get( $post_id , 'like' );
            
            if( is_array($likes) && sizeof($likes)){ 
                if( is_user_logged_in () ){
                    $user_id = get_current_user_id();
                }else{
                    $user_id = 0;
                }

                if( $user_id > 0 ){
                    foreach( $likes as $like ){
                        if( isset( $like[ 'user_id' ] ) && $like[ 'user_id' ] == $user_id ){
                            return true;
                        }
                    }
                }else{
                    foreach( $likes as $like ){
                        if( isset( $like[ 'ip' ] ) && $like[ 'ip' ] == $ip ){
                            return true;
                        }
                    }
                }
            }    

            return false;
        }
        
        public static function useLikes( $postID ){
            $customID = _attachment::getCustomIDByPostID( $postID );
            $resources = _core::method( '_resources' , 'get' );
            
            $meta = _core::method( '_meta' , 'get' , $postID , 'posts-settings' );
            
            if( !isset( $meta[ 'likes' ] ) ){
                if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] == 'yes' ){
                    return true;
                }else{
                    return false;
                }
            }else{
                if( empty( $meta[ 'likes' ] ) ){
                    if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] == 'yes' ){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] == 'yes' ){
                        if( $meta[ 'likes' ] == 'no' ){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
            }
        }
        
        public static function minLikes( $postID ){
            $customID = _attachment::getCustomIDByPostID( $postID );
            $resources = _core::method( '_resources' , 'get' );
            
            if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'featured-limit' ] ) && (int)$resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'featured-limit' ] > 0 ){
                return $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'featured-limit' ];
            }else{
                return 0;
            }
        }
    }
?>