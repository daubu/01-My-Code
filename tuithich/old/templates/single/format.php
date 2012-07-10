<?php
    if( get_post_format( $post -> ID ) == 'link' ){

        echo _core::method( 'post' , 'get_attached_files' , $post -> ID );

    }else if( get_post_format( $post -> ID ) == 'audio' ){

        $audio = new AudioPlayer();	
        echo $audio -> processContent( _core::method( 'post' , 'get_audio_files' , $post -> ID ) );

    }else if( get_post_format( $post -> ID ) == 'video' ){

        $video_format = _core::method( '_meta' , 'get' , $post -> ID , 'format' );
        
        if(isset( $video_format[ 'video_ids' ] ) && !empty( $video_format[ 'video_ids' ] ) ){

            foreach( $video_format[ "video_ids" ] as $videoid ){

                if( isset( $video_format[ "video_urls" ] ) && is_array( $video_format[ "video_urls" ] ) && isset( $video_format[ "video_urls" ][ $videoid ] ) ){

                    $video_url = $video_format[ "video_urls" ][ $videoid ];
                    $youtube_id = _core::method( 'post' , 'get_youtube_video_id' , $video_url );
                    $vimeo_id= _core::method( 'post' , 'get_vimeo_video_id' , $video_url );
                    
                    if(  strlen( $youtube_id ) > 1 ){
                        echo _core::method( 'post' , 'get_embeded_video' , $youtube_id , "youtube" , 0 , '100%' );
                        echo '<p class="delimiter blank"></p>';
                        
                    }else if( strlen($vimeo_id) > 1 ){
                        echo _core::method( 'post' , 'get_embeded_video' , $vimeo_id , "vimeo"  , 0 , '100%' );
                        echo '<p class="delimiter blank"></p>';
                    }

                }else{
                    echo _core::method( 'post' , 'get_local_video' , urlencode( wp_get_attachment_url( $videoid ) )  , '100%' );
                    echo '<p class="delimiter blank"></p>';
                }
            }
        }

    }else if( get_post_format( $post->ID ) == "image" ){

        $image_format = _core::method( '_meta' , 'get' , $post -> ID , 'format' );
        
        if( isset( $image_format[ 'images' ] ) && is_array( $image_format[ 'images' ] ) ){

            echo '<div class="attached_imgs_gallery">';

            foreach( $image_format['images'] as $index => $img_id ){

                $thumbnail = wp_get_attachment_image_src( $img_id, 'large-single');
                $full_image = wp_get_attachment_url( $img_id );
                $url = $thumbnail[ 0 ];
                $width = $thumbnail[ 1 ];
                $height = $thumbnail[ 2 ];
                echo '<div class="attached_imgs_gallery-element">';
                //echo '<a title="" rel="prettyPhoto[' . get_the_ID() . ']" href="' . $full_image . '">';


                echo '<img alt="" src="' . $url . '" />';
                //echo '</a>';
                echo '</div>';

            }

            echo '</div>';
        }
    }
?>