<?php
    global $post;
    
    /* author avatar */
    if( _core::method( 'post_settings' , 'useAuthorBox' , $post -> ID ) ){
        echo cosmo_avatar( $post -> post_author , 50 );
    }

    /* post title */
    echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'single' , 'post_title' , 'text' , get_the_title() , 'span' );
?>

<?php if( _core::method( 'post_settings' , 'useAuthorBox' , $post -> ID ) ) : ?>

    <span class="author">
        <a href="<?php echo get_author_posts_url( $post -> post_author ) ?>">
            <?php echo __( 'by' , _DEV_ ) . ' ' . get_the_author_meta( 'display_name' , $post -> post_author ); ?>
        </a>
        <?php
            if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'enb_follow' ) ){
                _core::method( '_follow' , 'get_follow_btn' , $post -> post_author );
            }
        ?>
        <a href="<?php echo get_permalink( $post -> ID ) ?>" class="time">
            <?php
                if ( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'time' ) ) {
                    echo human_time_diff( get_the_time( 'U' , $post -> ID ) , current_time( 'timestamp' ) ) . ' ' . __( 'ago' , _DEV_ );
                }else{
                    echo date_i18n( get_option( 'date_format' ) , get_the_time( 'U' , $post -> ID ) );
                }
            ?>
        </a>
    </span>

<?php else : ?>

    <span class="author">
        <a href="<?php echo get_permalink( $post -> ID ) ?>">
            <?php
                if ( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'time' ) ) {
                    echo human_time_diff( get_the_time( 'U' , $post -> ID ) , current_time( 'timestamp' ) ) . ' ' . __( 'ago' , _DEV_ );
                }else{
                    echo date_i18n( get_option( 'date_format' ) , get_the_time( 'U' , $post -> ID ) );
                }
            ?>
        </a>
    </span>

<?php endif; ?>