<div class="h-meta">
    <div class="entry-meta">
        
        <ul>
            <li>
                <a href="<?php echo get_permalink( $post -> ID ); ?>">
                    <?php
                        if ( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'time' ) ) {
                            echo human_time_diff( get_the_time( 'U' , $post -> ID ) , current_time( 'timestamp' ) ) . ' ' . __( 'ago' , _DEV_ );
                        } else {
                            echo date_i18n( get_option( 'date_format' ) , get_the_time( 'U' , $post -> ID ) );
                        }
                    ?>
                </a>
            </li>
            
            
            <?php if( _likes::useLikes( $post -> ID ) ) : echo _core::method( '_likes' , 'contentLike' , $post -> ID , false ); endif; ?>
        </ul>
        
        <?php _core::hook( 'meta-grid' ); ?>
        
    </div>
</div>