<div class="new_meta">
    <ul>
		<?php 
			global $global_use_hat;
			if( !isset( $global_use_hat ) || !$global_use_hat ): ?>
			<li class="user">
				<a href="<?php echo get_author_posts_url( $post-> post_author ); ?>">
					<?php echo cosmo_avatar( $post-> post_author , 24 , DEFAULT_AVATAR ); ?>
					<strong>
						<?php echo get_the_author_meta( 'display_name' , $post-> post_author ) ?>
					</strong>
				</a>
				<?php _core::method( '_follow' , 'get_follow_btn' , $post -> post_author ); ?>
			</li>
			<?php endif; ?>
        <?php $flag = true; ?>
        <?php /* views */ ?>
        <?php if ( function_exists( 'stats_get_csv' ) ) : $views = stats_get_csv( 'postviews' , "&post_id=" . $post -> ID); $flag = false; ?>
                
            <li class="views">
                <a href="<?php echo get_permalink( $post -> ID ) ?>">

                    <strong>
                        <?php echo (int)$views[0]['views']; ?>
                    </strong>

                    <?php if( (int)$views[0]['views'] == 1) : ?>

                        <span><?php _e( 'view' , _DEV_ ); ?></span>

                    <?php else : ?>

                        <span><?php _e( 'views' , _DEV_ ); ?></span>

                    <?php endif; ?>

                </a>
            </li>
            
        <?php endif; ?>
            
        <?php /* comments reply */ ?>
        <?php if ( comments_open( $post -> ID ) ) : ?>

            <?php
				$comments_label = __( 'replies' , _DEV_ );
                if ( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'fb_comments' ) ) :
                    $comments = '<fb:comments-count href="' . get_permalink( $post->ID ) . '"></fb:comments-count>';
                else :
                    $comments = get_comments_number( $post->ID );
					if($comments == 1){
						$comments_label = __( 'reply' , _DEV_ );
					}
                endif;
                
                if ( $flag  ) : 
                    $classes = 'no_bg fmr';
                else :
                    $classes = '';
                endif;
            ?>

            <li class="replies <?php echo $classes; ?>">
                <a href="<?php echo get_comments_link( $post->ID ); ?>">
                    <strong><?php echo $comments; ?></strong>
                    <span><?php echo $comments_label; ?></span>
                </a>
            </li>

        <?php endif; ?>
    </ul>
    
    <?php _core::hook( 'meta-grid-hover' ); ?>
</div>