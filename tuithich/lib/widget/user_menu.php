<?php
    class widget_user_menu extends WP_Widget {

        function widget_user_menu() {
            $widget_ops = array( 'classname' => 'widget_user_menu ' , 'description' => __( 'User menu' , _DEV_ ) );
            $this -> WP_Widget( 'widget_user_menu' , _CT_ . ': ' . __( 'User menu' , _DEV_ ) , $widget_ops );
        }

        function widget( $args , $instance ) {

            /* prints the widget*/
            extract($args, EXTR_SKIP);

            if( isset( $instance['title'] ) ){
                $title = $instance['title'];
            }else{
                $title = '';
            }
			
            echo $before_widget; ?>

			<?php if( !empty( $title ) ) : ?>

				<?php echo $before_title . $title . $after_title; ?>

			<?php endif; ?>
			
            <?php if( is_user_logged_in() ) : ?>
                

                <ul>
                    <?php /* My timeline */ ?>
                    <li class="my-timeline"><a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>"><?php _e( 'My timeline' , _DEV_ ); ?></a></li>
                    
                    <?php /* Following */ ?>
                    <?php $following = _core::method( '_follow' , 'get_following' , get_current_user_id() );  ?>
                    <?php if( !empty( $following ) && is_array( $following ) ) : ?>
                    
                        <li class="following"><a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>#following"><?php _e( 'Following' , _DEV_ ); ?></a></li>
                    
                    <?php endif; ?>
                    
                    <?php /* Followers */ ?>
                    <?php $followers = _core::method( '_follow' , 'get_followers' , get_current_user_id() ); ?>    
                    <?php if( !empty( $followers ) && is_array( $followers ) ) : ?>
                    
                        <li class="followers"><a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>#followers"><?php _e( 'Followers' , _DEV_ ); ?></a></li>
                    
                    <?php endif; ?>
                    
                    <?php /* Settings */ ?>
                    <?php $settings_page = _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "settings-page" ); ?>

                    <?php if( is_numeric( $settings_page ) ): ?>

                        <li class="settings"><a href="<?php echo get_permalink( $settings_page ); ?>"><?php _e( 'My settings' , _DEV_ ); ?></a></li>

                    <?php endif; ?>
                        
                    <?php /* My profile  */ ?>
                    <li class="my-profile"><a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>"><?php _e( 'My profile' , _DEV_ ); ?></a></li>

                    <?php /* My added posts */ ?>
                    <?php $my_posts = _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "post-page" ); ?>
                    <?php if( is_numeric( $my_posts ) ) : ?>

                        <li class="my-posts"><a href="<?php echo get_permalink($my_posts)?>"><?php _e( 'My added posts' , _DEV_ ); ?></a></li>

                    <?php endif; ?>
                        
                    <?php /* My favorites  */ ?>
                    <?php 
                        $resources = _core::method( '_resources' , 'get' );
                        $favorites = false;
                        foreach( $resources as $res ){
                            if( isset( $res[ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] ) && $res[ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] == 'yes' ){
                                $favorites = true;
                                break;
                            }
                        }
                    ?>
                    <?php if( $favorites ) : ?>
                        
                        <li class="my-favorites"><a href="<?php echo get_author_posts_url( get_current_user_id() ); ?>#favorites"><?php _e( 'My favorites' , _DEV_ ); ?></a></li>
                        
                    <?php endif; ?>  
                    
                    <?php /* Submit post */ ?>
                    <?php $post_item_page = _core::method( "_settings" , "get" , "settings" , "general" , "upload" , "post_item_page" ); ?>
                    <?php if( is_numeric( $post_item_page ) ) : ?>
                        
                        <li class="my-add"><a href="<?php echo get_permalink( $post_item_page ); ?>"><?php _e( 'Submit post' , _DEV_ ); ?></a></li>
                        
                    <?php endif; ?>
                </ul>

            <?php else : ?>

                
                            
                <form method="post" action="wp-login.php" id="cosmo-loginform" name="loginform">
			
                    <p class="login-username">
                        <label for="username"><?php _e( 'Username' , _DEV_ ); ?></label>
                        <input type="text" tabindex="100" size="20" value="" class="input" id="username" name="login">
                    </p>
                    
                    <p class="login-password">
                        <label for="password"><?php _e( 'Password' , _DEV_ ); ?></label>
                        <input type="password" tabindex="200" size="20" value="" class="input" id="password" name="password">
                    </p>
                    
                    <p class="login-submit">
                        <input type="submit" tabindex="300" value="<?php _e( 'Log In' , _DEV_ ); ?>" class="button-primary" id="wp-submit-button" name="wp-submit">
                        
                        <?php
                            if( !( _core::method( '_settings' , 'get' , 'settings' , 'social' , 'facebook' , 'secret' ) == '' || _core::method( '_settings' , 'get' , 'settings' , 'social' , 'facebook' , 'app_id' ) == '' ) ){
                                ?>
                                <div class="facebook">
                                    <?php _core::method( '_facebook' , 'login' ); ?>
                                </div>    
                                <?php
                            }
                        ?>                    
                    </p>
                    
                    <?php if( _core::method("_settings","logic","settings","general","theme","enb-login") ) : ?>
                    
                        <?php
                            
                            $idpage = _core::method( '_settings' , 'get' , 'settings' , 'general' , 'theme' , 'login-page' );
                            
                            $register_link = get_permalink( $idpage );
                            $recover_link = $register_link;

                            if(strpos($register_link,"?")){
                                $register_link .= "&action=register";
                                $recover_link .= "&action=recover";
                            }else{
                                $register_link .= "?action=register";
                                $recover_link .= "?action=recover";
                            }
                        ?>
                    
                        <p class="pswd">
                            <span><a href="<?php echo $recover_link; ?>"><?php echo __( 'Lost your password?' , _DEV_ ); ?></a></span><?php if( _core::method( "_settings" , "logic" , "settings" , "general" , "theme" , "enb-login" ) ){?> | <span><a href="<?php echo $register_link; ?>"><?php echo __( 'Register' , _DEV_ );?></a></span><?php } ?>
                        </p>
                        
                    <?php endif; ?>
                    
                    <p class="error-mssg-login">
                        <span class="login-error" id="registration_error"></span>
                    </p>
			
                </form>

            <?php endif; ?>
            
            <?php echo $after_widget;
        }

        function update( $new_instance, $old_instance) {

            /*save the widget*/
            $instance = $old_instance;
            $instance['title']  = strip_tags( $new_instance['title'] );
			
            return $instance;
        }

        function form($instance) {

            /* widget form in backend */
            $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
            $title    = strip_tags( $instance['title'] );
			
        ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title',_DEV_) ?>:
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>

        <?php
        
        }

    }
?>