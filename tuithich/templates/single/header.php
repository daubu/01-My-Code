<?php
    $marker = _core::method( '_map' , 'markerExists' , $post -> ID  );
    $enb_featured = _core::method( '_settings' , 'logic' , 'settings' , 'blogging' , 'posts' , 'enb-featured' );
    $has_thumbnail = has_post_thumbnail( $post -> ID );
    $format = get_post_format( $post -> ID );
    
    $map_id = '';
    
?>

<?php if(  $marker || (  $enb_featured && $has_thumbnail) || (  $format == 'video'  ) )  : ?>

    <?php
        $map = _meta::get( $post -> ID , 'map' );

        if( $marker ){
            $map_id = 'id="map_canvas"';
            _core::method( '_box' , 'mapFrontEnd' , $post -> ID );
        }
    ?>
    
    <header class="entry-header">
        <div class="hovermore">
            
            <?php if( empty( $map_id ) && get_post_format( $post -> ID ) != 'video' ) : ?>
            
                <?php if( has_post_thumbnail( $post -> ID ) ) : ?>
            
                    <?php $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'fullwidth' ); ?>
                                    
                <?php endif; ?>
            
            <?php endif; ?>
            
            <div class="featimg">
                <div class="img" <?php echo $map_id; ?> >
                    <?php 
                        if( strlen( $map_id ) == 0 ){
                            if( get_post_format( $post -> ID ) == 'video' ){

                                $video_format = _core::method( '_meta' , 'get' , $post -> ID , 'format' );

                                if( isset( $video_format[ 'feat_url' ] ) && strlen( $video_format[ "feat_url" ] ) > 1 ){

                                    $video_url = $video_format[ "feat_url" ];
                                    $youtube_id = _core::method( 'post' , 'get_youtube_video_id' , $video_url );
                                    $vimeo_id = _core::method( 'post' , 'get_vimeo_video_id' , $video_url );

                                    if( $youtube_id != '0'  ){

                                        echo _core::method( 'post' , 'get_embeded_video' , $youtube_id , "youtube" , 0 , '100%' );

                                    }else if( $vimeo_id != '0' ){

                                        echo _core::method( 'post' , 'get_embeded_video' , $vimeo_id , "vimeo" , 0 , '100%' );
                                    }
                                }else if( isset( $video_format[ 'feat_id' ] ) && is_numeric( $video_format[ "feat_id" ] ) ){

                                    echo _core::method( 'post' , 'get_local_video' , urlencode( wp_get_attachment_url( $video_format[ "feat_id" ] ) ) , '100%' );
                                }
                            }else if( has_post_thumbnail( $post -> ID ) ){
                                
                                if( _core::method( '_settings' , 'logic' , 'settings' , 'style' , 'general' , 'fixed-layout'  ) ) {
                                    if( _core::method( 'layout' , 'useSingularSidebar' , $post -> ID ) ){
                                        $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'small-single' );

                                    }else{
                                        $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'large-single' );
                                    }
                                }else{
                                    $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'large-single' );
                                }
                        
                                echo '<img src="' . $src[0] . '" alt="' . $post -> post_title . '" />';
                            }
                        }
                    ?>
                </div>
            </div>
            
        </div>
    </header>

<?php endif; ?>