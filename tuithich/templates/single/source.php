<?php if( _core::method( 'post_settings' , 'useSource' , $post -> ID ) ) : $meta = _core::method( '_meta' , 'get' , $post -> ID , 'posts-settings' ); ?>

    <?php if( !empty( $meta[ 'source' ] ) ) : ?>
        <aside class="widget">
            
            <div class="source no_source">
                <h4 class="widget-title"><?php _e( 'Source' , _DEV_ ); ?></h4>
                <span class="delimiter">&nbsp;</span>
                <p>
                    <span>
                        <?php if( preg_match( "/^http/" , $meta[ 'source' ] ) || preg_match( "/^www/" , $meta[ 'source' ] ) ) : ?>
                        
                            <a href="<?php echo $meta[ 'source' ]; ?>" target="_blank"><?php echo $meta[ 'source' ] ?></a>
                            
                        <?php else : ?>
                            
                            <?php echo $meta[ 'source' ]; ?>
                            
                        <?php endif; ?>    
                    </span>
                </p>
            </div>

        </aside>

    <?php endif; ?>

<?php endif; ?>
                            