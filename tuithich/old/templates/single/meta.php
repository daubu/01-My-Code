<?php 
    global $post;
    
    $resources = _core::method( '_resources' , 'get' );
    $customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $post -> ID );
?>

    <ul>
        <?php /* single likes */ ?>
        <?php if( _likes::useLikes( $post -> ID ) ) : echo _core::method( '_likes' , 'contentLike' , $post -> ID ); endif; ?>

        <?php /* single count comments */ ?>
        <?php if ( comments_open( $post -> ID ) ) : ?>

            <?php if ( _core::method( 'settings' , 'general' , 'theme' , 'fb-comments' ) ) : ?>

                <?php /* facebook comments */ ?>

                <li class="cosmo-comments">
                    <a href="<?php echo get_comments_link( $post -> ID ); ?>">
                        <span class="fb_comments_count">
                            <fb:comments-count href="<?php echo get_permalink( $post -> ID ) ?>"></fb:comments-count>
                        </span> <?php _e( 'comments' , _DEV_ ); ?>
                    </a>
                </li>

            <?php else : ?>

                <?php /* blog comments */ ?>

                <li class="cosmo-comments">
                    <a href="<?php echo get_comments_link( $post -> ID ); ?>">

                        <?php if( get_comments_number( $post -> ID ) == 1 ) : ?>

                            <span class="fb_comments_count"><?php echo get_comments_number( $post -> ID ); ?></span> 
                            <?php _e( 'comment' , _DEV_ ); ?>

                        <?php else : ?>

                            <span class="fb_comments_count"><?php echo get_comments_number( $post -> ID ); ?></span> 
                            <?php _e( 'comments' , _DEV_ ); ?>

                        <?php endif; ?>

                    </a>
                </li>

            <?php endif; ?>
        <?php endif; ?>

        <?php if ( function_exists( 'stats_get_csv' ) ) : $views = stats_get_csv( 'postviews' , "&post_id=" . $post -> ID ); ?>

            <?php /* views count ( statistics )  */ ?>

            <li class="views">
                <a href="<?php echo get_permalink( $post -> ID) ?>">

                    <?php 
                        if( (int)$views[0]['views'] == 1) : _e( 'view' , _DEV_ );

                        else : _e( 'views' , _DEV_ );

                        endif;
                    ?>

                    <span>
                        <?php echo (int)$views[0]['views']; ?>
                    </span>
                </a>
            </li>
        <?php endif; ?>
    </ul>

    <?php

        /* single meta categories */
        if( !empty( $resources[ $customID ][ 'taxonomy' ] ) && is_array( $resources[ $customID ][ 'taxonomy' ] ) ){
            foreach( $resources[ $customID ][ 'taxonomy' ] as $taxonomy ){
                if( isset( $taxonomy[ 'hierarchical' ] ) && $taxonomy[ 'hierarchical' ] == 'hierarchical' ){
                    $terms = wp_get_post_terms( $post -> ID , $taxonomy[ 'slug' ] , array( "fields" => "all" ) );

                    if( !empty( $terms ) ){
                        echo '<ul class="category">';

                        foreach( $terms as $term ){
                            if( isset( $term -> slug ) && isset( $term -> name  ) ){
                                echo '<li><a href="' . get_term_link( $term -> slug , $taxonomy[ 'slug' ] ) . '">' . $term -> name . '</a></li>';
                            }
                        }

                        echo '</ul>';
                    }
                }
            }
        }
    ?>

    <?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_edit_delete' ) && is_user_logged_in() && ($post -> post_author == get_current_user_id() || current_user_can('administrator') ) ) : ?>

        <?php /* single meta actions ( edit | delete  ) */ ?>

        <ul>
            <?php if( $post -> post_type != 'post' ) : ?>
            
                <?php /* standart edit form for custom posts */ ?>
                <li class="edit_post" title="<?php _e( 'Edit post' , _DEV_ ); ?>">

                    <?php edit_post_link( __( 'Edit' , _DEV_ ) ); ?>

                </li>
                
            <?php else : ?>
                <?php if( is_numeric( _core::method( '_settings' , 'get' , 'settings' , 'general' , 'upload' , 'post_item_page' ) ) ) : ?>
                
                    <?php /* if is set page for front-end submit */ ?>
                    <?php $link = get_page_link( _core::method( '_settings' , 'get' , 'settings' , 'general' , 'upload' , 'post_item_page' ) ); ?>
                    <?php 
                        if( strpos( $link , "?" ) ){
                            $link .= "&post=" . $post -> ID;
                        }else{
                            $link .= "?post=" . $post -> ID;
                        }
                    ?>

                    <li class="edit_post" title="<?php _e( 'Edit post' , _DEV_ ); ?>">
                        <a href="<?php  echo  $link; ?>">
                            <?php echo _e( 'Edit' , _DEV_ ); ?>
                        </a>
                    </li>
                    
                <?php else : ?>
                    
                    <?php /* standart edit form for custom posts */ ?>
                    <li class="edit_post" title="<?php _e( 'Edit post' , _DEV_ ); ?>">

                        <?php edit_post_link( __( 'Edit' , _DEV_ ) ); ?>

                    </li>
                    
                <?php endif;?>
            <?php endif; ?>
                    
            <li class="delete_post" title="<?php _e( 'Remove post' , _DEV_ ); ?>"><a href="javascript:void(0);" onclick="if( confirm( '<?php _e( 'Confirm to delete this post.' , _DEV_ ); ?>') ){ removePost( <?php echo $post -> ID ?> , '<?php echo home_url(); ?>' ); }"><?php _e( 'Delete' , _DEV_ ); ?></a></li>

        </ul>

    <?php endif; ?>