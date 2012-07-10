<?php
    $resources = _core::method( '_resources' , 'get' );
    $customID  = _core::method( '_resources' , 'getCustomIdByPostType' , $post -> post_type );
?>

    <?php if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-use' ] ) &&  $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-use' ] == 'yes' ) : ?>
        
        <?php $similar = _core::method( '_meta' , 'get' , $post -> ID , 'posts-settings' , 'similar' ); ?>
        
        <?php if( empty( $similar ) || _core::method( '_meta' , 'logic' , $post -> ID , 'posts-settings' , 'similar' ) ) : ?>
            
            <?php 
            
                $slug = $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-criteria' ];
                $terms = wp_get_post_terms( $post -> ID , $slug , array("fields" => "all") );
                $t = array();
                
                foreach( $terms as $term ){
                    array_push( $t , $term -> slug );
                }
            ?>
            
            <?php if( !empty( $t ) && is_array( $t ) ) : ?>

                <?php 
                    $layout = _core::method( '_meta' , 'get' , $post -> ID , 'layout' );
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
                        'post__not_in' => array( $post -> ID )
                    );

                    $query = new WP_Query( $args );
                ?>

                <?php if( count( $query -> posts ) > 0 ) : ?>
                    <?php if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-view' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-view' ] != 'list-view' ) : ?>
                        
                        <aside class="widget">
                            <div class="box-related">

                                <h4 class="widget-title"><?php _e( 'Similar posts' , _DEV_ ); ?></h4>
                                <p class="delimiter">&nbsp;</p>

                                <div class="grid-view">

                                    <?php foreach( $query -> posts as $similar ) : ?>

                                        <?php /* related articles */ ?>

                                        <article class="<?php if( !has_post_thumbnail( $similar -> ID ) ){ echo 'noimg';} ?>">
                                            
                                            <?php if( has_post_thumbnail( $similar -> ID ) ) : ?>
                                            
                                                <div class="hovermore">

                                                    <div class="details mosaic-overlay">
                                                        <footer class="entry-footer">
                                                            <h2>
                                                                <a href="<?php echo get_permalink( $similar -> ID ); ?>" title="<?php echo $similar -> post_title; ?>">
                                                                    <?php 
                                                                        if( strlen( $similar -> post_title ) > 25 ){
                                                                            echo mb_substr( $similar -> post_title , 0 , 25 ) . ' ...';
                                                                        }else{
                                                                            echo $similar -> post_title;
                                                                        }
                                                                    
                                                                    ?>
                                                                </a>
                                                            </h2>
                                                        </footer>
                                                        <div class="format-hover">&nbsp;</div>
                                                    </div>

                                                    <?php
                                                        if( has_post_thumbnail( $similar -> ID ) ){
                                                            $src = wp_get_attachment_image_src( get_post_thumbnail_id( $similar -> ID ) , 'thumbnail' );
                                                            echo '<a href="'. get_permalink( $similar -> ID ) . '"><img src="' . $src[ 0 ] . '" class="size"><span class="stripes">&nbsp;</span></a>';
                                                        }
                                                    ?>

                                                    
                                                    <!--<div class="corner">&nbsp;</div>-->

                                                </div>
                                            
                                            <?php else : ?>
                                            
                                                <footer class="entry-footer">
                                                    <h2><a href="<?php echo get_permalink( $similar -> ID ); ?>"><?php echo $similar -> post_title; ?></a></h2>
                                                </footer>
                                            
                                            <?php endif; ?>

                                        </article>

                                    <?php endforeach; ?>

                                </div>

                            </div>
                        </aside>

                    <?php endif; ?>
                <?php endif; ?>

            <?php endif; ?>

        <?php endif; ?>
    <?php endif; ?>
