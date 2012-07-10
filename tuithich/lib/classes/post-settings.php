<?php
    class post_settings{
        public function useSocial( $postID ){
            
            $resources = _core::method( '_resources' , 'get' );
            $customID = _attachment::getCustomIDByPostID( $postID );
            $meta = _core::method( '_meta' , 'get' , $postID , 'posts-settings' );
            
            if( isset( $resources[ $customID ] ) ){
                
                $resource = $resources[ $customID ];
                $result = false;

                if( isset( $resource[ 'boxes' ][ 'posts-settings' ][ 'social-use' ] ) &&  $resource[ 'boxes' ][ 'posts-settings' ][ 'social-use' ] == 'yes' ){
                    if( isset( $meta[ 'social' ] ) ){
                        if( empty( $meta[ 'social' ] ) ){
                            if( isset( $resource[ 'boxes' ][ 'posts-settings' ][ 'social-default' ] ) && $resource[ 'boxes' ][ 'posts-settings' ][ 'social-default' ] != 'no' ){
                                $result = true;
                            }else{
                                $result = false;
                            }
                        }else{
                            if( $meta[ 'social' ] == 'yes' ){
                                $result = true;
                            }
                        }
                    }else{
                        if( isset( $resource[ 'boxes' ][ 'posts-settings' ][ 'social-single-default' ] ) && $resource[ 'boxes' ][ 'posts-settings' ][ 'social-single-default' ] != 'no' ){
                            $result = true;
                        }else{
                            $result = false;
                        }
                    }
                }

                return $result;
            }
        }
        
        public function useSource( $postID ){
            
            $resources = _core::method( '_resources' , 'get' );
            $customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $postID );
            $result = false;
            
            if( isset( $resources[ $customID ] ) ){
            
                $resource = $resources[ $customID ];
                if( isset( $resource[ 'boxes' ][ 'posts-settings' ][ 'source-use' ] ) && $resource[ 'boxes' ][ 'posts-settings' ][ 'source-use' ] == 'yes' ){
                    
                    $meta = _core::method( '_meta' , 'get' , $postID , 'posts-settings' );
                    if( !empty( $meta[ 'source' ] ) ){
                        $result = true;
                    }
                }
            }
            
            return $result;
        }
        
        public function useTags( $postID ){
            $result = false; 
            
            $resources = _core::method( '_resources' , 'get' );
            $customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $postID );
            
            if( isset( $resources[ $customID ] ) ){
                
                $resource = $resources[ $customID ];
                
                if( isset( $resource[ 'taxonomy' ] ) && !empty( $resource[ 'taxonomy' ] ) ){


                    foreach(  $resource[ 'taxonomy' ] as $taxonomy ){

                        if( isset( $taxonomy[ 'hierarchical' ] ) && $taxonomy[ 'hierarchical' ] == 'hierarchical' ){
                            continue;
                        }

                        $terms = wp_get_post_terms( $postID , $taxonomy[ 'slug' ] , array( "fields" => "all" ) );

                        if( !empty( $terms ) ){
                            $result = true;
                            break;
                        }
                    }
                }

                return $result;
            }
        }
        
        public function useCategory( $postID ){
            $result = false; 
            
            $resources = _core::method( '_resources' , 'get' );
            $customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $postID );
            
            if( isset( $resources[ $customID ] ) ){
                
                $resource = $resources[ $customID ];
    
                if( isset( $resource[ 'taxonomy' ] ) && !empty( $resource[ 'taxonomy' ] ) ){

                    foreach(  $resource[ 'taxonomy' ] as $taxonomy ){

                        if( isset( $taxonomy[ 'hierarchical' ] ) && $taxonomy[ 'hierarchical' ] == 'hierarchical' ){
                            $terms = wp_get_post_terms( $postID , $taxonomy[ 'slug' ] , array( "fields" => "all" ) );

                            if( !empty( $terms ) ){
                                $result = true;
                                break;
                            }
                        }else{
                            continue;
                        }
                    }
                }

                return $result;
            }
        }
        
        
        
        public function getTags( $resource , $postID ){
            $result = array();
			if( isset( $resource[ 'taxonomy' ] ) ){
				if(  $resource[ 'slug' ] == 'post' ){
					$resource[ 'taxonomy' ] = array(
						array(
							'hierarchical' => 'hierarchical',
							'slug' => 'category'
						),
						array(
							'hierarchical' => '',
							'slug' => 'post_tag'
						)
					);
				}
			} 
            if( isset( $resource[ 'taxonomy' ] ) && !empty( $resource[ 'taxonomy' ] ) ){
                if(  $resource[ 'slug' ] == 'post' ){
                    $resource[ 'taxonomy' ] = array(
                        array(
                            'hierarchical' => 'hierarchical',
                            'slug' => 'category',
							'ptitle' => 'Caegories'
                        ),
                        array(
                            'hierarchical' => '',
                            'slug' => 'post_tag',
							'ptitle' => 'Tags'
                        )
                    );
                }
                
                foreach(  $resource[ 'taxonomy' ] as $taxonomy ){

                    if( $taxonomy[ 'hierarchical' ] == 'hierarchical' ){
                        continue;
                    }

                    $terms = wp_get_post_terms( $postID , $taxonomy[ 'slug' ] , array( "fields" => "all" ) );

                    if( !empty( $terms ) ){
                        $result[] = array( 'data' => $terms , 'ptitle' => $taxonomy[ 'ptitle' ] , 'slug' => $taxonomy[ 'slug' ] );
                    }
                }
            }
            
            return $result;
        }
        
        public function useAttachdocs( $postID ){
            $result = false;
            
            $resources = _core::method( '_resources' , 'get' );
            $customID = _attachment::getCustomIDByPostID(  $postID );
            
            if( isset( $resources[ $customID ] ) ){
            
                $resource = $resources[ $customID ];
                $meta = _core::method( '_meta' , 'get' , $postID , 'attachdocs' );
                
                if( isset( $resource[ 'boxes' ][ 'attachdocs' ] ) ) {
                    if( !empty( $meta ) && is_array( $meta ) ){
                        $result = true;
                    }
                }
            }
            
            return $result;
        }
        
        public function useAuthorBox( $postID ){
            $resources = _core::method( '_resources' , 'get' );
            $customID = _attachment::getCustomIDByPostID( $postID );

            if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'author-box-use' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'author-box-use' ] == 'yes' ){
                $meta = _core::method( '_meta' , 'get' , $postID , 'posts-settings' , 'author-box' );
                if(  empty( $meta ) ){
                    $result = true;
                }else{
                    if( $meta == 'yes' ){
                        $result = true;
                    }else{
                        $result = false;
                    }
                }
            }else{
                $result = false;
            }
            
            return $result;
        }
        
        public function useRelated( $postID ){
            
            $result = false;
            
            $resources = _core::method( '_resources' , 'get' );
            $customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $postID );

            if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-use' ] ) &&  $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-use' ] == 'yes' ) {
        
                $similar = _core::method( '_meta' , 'get' , $postID , 'posts-settings' , 'similar' );
        
                if( empty( $similar ) || _core::method( '_meta' , 'logic' , $postID , 'posts-settings' , 'similar' ) ) {
            
                    $slug = $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-criteria' ];
                    $terms = wp_get_post_terms( $postID , $slug , array("fields" => "all") );
                    $t = array();

                    foreach( $terms as $term ){
                        array_push( $t , $term -> slug );
                    }
            
            
                    if( !empty( $t ) && is_array( $t ) ) {

                        $layout = _core::method( '_meta' , 'get' , $postID , 'layout' );
                        $similar_number = $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-number' ];

                        $args = array(
                            'tax_query' => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy' => $slug,
                                    'field' => 'slug',
                                    'terms' => $t
                                )
                            ),
                            'posts_per_page' => $similar_number,
                            'post_type' => $resources[ $customID ][ 'slug' ],
                            'post_status' => 'publish',
                            'post__not_in' => array( $postID )
                        );

                        $query = new WP_Query( $args );
                
                        if( count( $query -> posts ) > 0 ) {
                            $result = true;
                        }
                    }
                }
            }
            
            return $result;
        }
        
        public function isEmptyMeta( $postID ){
            
            $post = get_post( $postID );
            
            if( empty( $post) || is_wp_error( $post )  ){
                return false;
            }
            
            if( 
                comments_open( $postID ) || 
                _likes::useLikes( $postID ) || 
                function_exists( 'stats_get_csv' ) || 
                ( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_edit_delete' ) && is_user_logged_in() && ($post -> post_author == get_current_user_id() || current_user_can('administrator') ) ) ||
                _core::method( 'post_settings' , 'useCategory' , $postID ) ||
                _core::method( 'post_settings' , 'useTags' , $postID ) ||
                _core::method( 'post_settings' , 'useSource' , $postID ) ||  
                _core::method( 'post_settings' , 'useRelated' , $postID ) ){
                
                $result = false;
            }else{
                $result = true;
            }
            
            return $result;
        }
        
        public function useMeta( $postID ){
            
            $result = false;
            
            $resources = _core::method( '_resources' , 'get' );
            $customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $postID );
            $meta = _core::method( '_meta' , 'get' , $postID , 'posts-settings' );
            
            if( isset( $resources[ $customID ] ) && !_core::method( 'post_settings' , 'isEmptyMeta' , $postID ) ){
                
                $resource = $resources[ $customID ];
                $result = false;

                if( isset( $resource[ 'boxes' ][ 'posts-settings' ][ 'meta-use' ] ) &&  $resource[ 'boxes' ][ 'posts-settings' ][ 'meta-use' ] == 'yes' ){
                    if( isset( $meta[ 'meta' ] ) ){
                        if( empty( $meta[ 'meta' ] ) ){
                            if( isset( $resource[ 'boxes' ][ 'posts-settings' ][ 'meta' ] ) && $resource[ 'boxes' ][ 'posts-settings' ][ 'meta' ] != 'no' ){
                                $result = true;
                            }else{
                                $result = false;
                            }
                        }else{
                            if( $meta[ 'meta' ] == 'yes' ){
                                $result = true;
                            }
                        }
                    }else{
                        if( isset( $resource[ 'boxes' ][ 'posts-settings' ][ 'meta' ] ) && $resource[ 'boxes' ][ 'posts-settings' ][ 'meta' ] != 'no' ){
                            $result = true;
                        }else{
                            $result = false;
                        }
                    }
                }
            }
            
            return $result;
        }
        
        public function useGrid( $template ){
            
            if( _core::method( '_settings' , 'logic' , 'settings' , 'layout' , 'style' , $template . '_view'  ) ){
                $grid = false;
            }else{
                $grid = true;
            }
            
            return $grid;
        }
    }
?>
