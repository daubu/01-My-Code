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

                    //$args = array(
//                        'tax_query' => array(
//                            'relation' => 'AND',
//                            array(
//                                'taxonomy' => $slug,
//                                'field' => 'slug',
//                                'terms' => $t
//                            )
//                        ),
//                        'posts_per_page' => $similar_number,
//                        'post_type' => $resources[ $customID ][ 'slug' ],
//                        'post_status' => 'publish',
//                        'post__not_in' => array( $post -> ID )
//                    );
					$orig_post = $post;
					global $post;
					$tags = wp_get_post_tags($post->ID);
					if ($tags) {
						$tag_ids = array();
						foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
							$args=array(
							'tag__in' => $tag_ids,
							'post__not_in' => array($post->ID),
							'posts_per_page'=> $similar_number, // Number of related posts that will be shown.
							'caller_get_posts'=>1,
							'orderby' => rand
							);
					}
					else
					{
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
					}

                    $query = new WP_Query( $args );
                ?>

                <?php if( count( $query -> posts ) > 0 ) : ?>
                    <?php if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-view' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'similar-view' ] != 'list-view' ) : ?>
                        
                        <aside class="widget">
                            <div class="box-related">

                                <h3 class="related-title"><?php _e( 'Similar posts' , _DEV_ ); ?></h3>
                                <p class="delimiter">&nbsp;</p>

                                <div class="grid-view">

                                    <?php foreach( $query -> posts as $similar ) : ?>

                                        <?php /* related articles */ ?>

                                        <article class="items <?php if( !has_post_thumbnail( $similar -> ID ) ){ echo 'noimg';} ?>">
                                            
                                            <?php if( has_post_thumbnail( $similar -> ID ) ) : ?>
                                            
                                                <div class="hovermore">

                                                    

                                                    <?php
                                                        if( has_post_thumbnail( $similar -> ID ) ){
                                                            $src = wp_get_attachment_image_src( get_post_thumbnail_id( $similar -> ID ) , 'thumbnail' );
                                                            echo '<img src="' . $src[ 0 ] . '" class="size">';
                                                        }
                                                    ?>

                                                    <a class="stripes" href="<?php echo get_permalink( $similar -> ID ) ?>"></a>
                                                    <div class="corner">&nbsp;</div>

                                                </div>
                                            	<h2>
                                                    <a href="<?php echo get_permalink( $similar -> ID ); ?>" title="<?php echo $similar -> post_title; ?>">
                                                        <?php echo $similar -> post_title; ?>
                                                    </a>
                                                </h2>
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
                <?php endif; $post = $orig_post; wp_reset_query(); ?> 
				
            <?php endif; ?>

        <?php endif; ?>
    <?php endif; ?>
