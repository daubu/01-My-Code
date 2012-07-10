<?php if( $post -> ID == _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "login-page" ) ) : ?>
    
    <?php
        
        if( isset( $_GET['action'] ) && $_GET['action'] == 'register' ){
            
            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'page' , 'post_title' , 'text' , __( 'Registration' , _DEV_ ), 'span' );
            
        }elseif( isset($_GET['action']) && $_GET['action']=='recover' ){
            
            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'page' , 'post_title' , 'text' , __( 'Recover password' , _DEV_ ), 'span' );
            
        }else{
            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'page' , 'post_title' , 'text' , __( 'Login' , _DEV_ ), 'span' );
        }
    ?>

<?php else : ?>

    <?php
        if( _core::method( 'post_settings' , 'useAuthorBox' , $post -> ID ) ){
            echo cosmo_avatar( $post -> post_author , 50 );
        }

        echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'single' , 'post_title' , 'text' , get_the_title() , 'span' );
    ?>

    <?php if( _core::method( 'post_settings' , 'useAuthorBox' , $post -> ID ) ) : ?>
            
        <span class="author">
            
            <a href="<?php echo get_author_posts_url( $post -> post_author ) ?>">
                <?php echo __( 'by' , _DEV_ ) . ' ' . get_the_author_meta( 'display_name' , $post -> post_author ); ?>
            </a>

        </span>

        <?php if( _core::method( '_settings' , 'login' , 'settings' , 'general' , 'theme' , 'enb_follow' ) ) :  _core::method( '_follow' , 'get_follow_btn' , $post -> post_author ); endif; ?>

    <?php endif; ?>
      
<?php endif; ?>