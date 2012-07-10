<?php
    class thumbnail{
        public function border_class( $attr = '' ){
            if( _core::method( "_settings" , "logic" , "settings" , "blogging" , "posts" , "enb-featured-border" ) ){
                if( !empty( $attr ) ){
                    echo 'class="' . $attr . ' noborder"';
                }else{
                    echo 'class="noborder"';
                }
            }else{
                echo 'class="' . $attr . '"';
            }
        }
        
        public function single( $postID ){
            $map = _meta::get( $postID , 'map' );
                                                        
            $map_id = '';

            if( _core::method( '_map' , 'markerExists' , $post -> ID  ) ){
                $map_id = 'id="map_canvas"';
                _core::method( '_box' , 'mapFrontEnd' , $post -> ID );
            }
                                                        
            if( strlen( $map_id ) == 0 ){
                if( get_post_format( $postID ) == 'video' ){

                    $video_format = _core::method( '_meta' , 'get' , $postID , 'format' );

                    if( strlen( $video_format[ "feat_url" ] ) > 1 ){
                        $video_url = $video_format[ "feat_url" ];
                        $youtube_id = _core::method( 'post' , 'get_youtube_video_id' , $video_url );
                        $vimeo_id= _core::method( 'post' , 'get_vimeo_video_id' , $video_url );
                        if( $youtube_id != '0'  ){
                            echo _core::method( 'post' , 'get_embeded_video' , $youtube_id , "youtube" );
                        }else if( $vimeo_id != '0' ){
                            echo _core::method( 'post' , 'get_embeded_video' , $vimeo_id , "vimeo" );
                        }
                    }else if( is_numeric( $video_format[ "feat_id" ] ) ){
                        echo _core::method( 'post' , 'get_local_video' , urlencode( wp_get_attachment_url( $video_format[ "feat_id" ] ) ) );
                    }
                }else if( has_post_thumbnail() ){
                    if($border){
                        echo _core::method( '_image' , 'thumbnail' , $postID , _layout::$size[ 'image' ][ _layout::length( $postID ,  'single' ) ] ); 
                    }else{
                        echo wp_get_attachment_image( get_post_thumbnail_id( $postID ) , array( 610 , 9999 ) );
                    }
                }
            }
        }
    }
?>