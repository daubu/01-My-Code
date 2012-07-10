<?php if( _core::method( "_settings" , "logic" , "settings" , "general" , "theme" , "enb-login" ) ) : ?>
	<div class="login-form b w_130">
		<div class="fr">
            
            <?php if( is_user_logged_in() ) : $u_id = get_current_user_id(); $picture = _core::method( '_facebook' , 'picture' ); ?>
            
                <?php $cusom_avatar = wp_get_attachment_image_src( get_user_meta( $u_id , 'custom_avatar' , true ) , array( 24 , 24 ) ); ?>
                <?php if( strlen( $picture ) && ( !isset( $cusom_avatar[0] ) || ( isset( $cusom_avatar[0] ) && empty(  $cusom_avatar[0] ) ) ) ) : ?>

                    <a href="http://facebook.com/profile.php?id=<?php echo _core::method( '_facebook' , 'id' ); ?>" class="profile-pic simplemodal-login simplemodal-none"><img src="<?php echo $picture; ?>" width="24" width="24" /></a>
                    
                <?php else : ?>
                    
                    <a href="#" class="profile-pic simplemodal-login simplemodal-none"><?php echo cosmo_avatar( get_current_user_id() , 24 , DEFAULT_AVATAR );?></a>
                    
                <?php endif; ?>    
                    
            <?php else : ?>
                    
                <a href="#" class="profile-pic simplemodal-login simplemodal-none"><?php echo cosmo_avatar( get_current_user_id() , 24 , DEFAULT_AVATAR );?></a>
                
            <?php endif; ?>
            
			<div class="cosmo-icons">
				<ul class="sf-menu">
					    
                    <?php if( is_user_logged_in() ) : $user = wp_get_current_user(); ?>

                        <li class="signin dropdown">

                            <a class="dynamic-settings-style-menu-top_menu username" href=""><?php echo $user->user_login;?></a>
                            <ul>
                                <?php /* Settings */ ?>
                                <?php $settings_page = _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "settings-page" ); ?>
                                <?php if( is_numeric( $settings_page ) ): ?>

                                    <li class="settings"><a class="dynamic-settings-style-menu-top_menu" href="<?php echo get_permalink( $settings_page ); ?>"><?php _e( 'My settings' , _DEV_ ); ?></a></li>

                                <?php endif; ?>

                                <?php /* My profile  */ ?>
                                <li class="my-profile"><a class="dynamic-settings-style-menu-top_menu" href="<?php echo get_author_posts_url( get_current_user_id() ); ?>"><?php _e( 'My profile' , _DEV_ ); ?></a></li>

                                <?php /* My added posts */ ?>
                                <?php $my_posts = _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "post-page" ); ?>
                                <?php if( is_numeric( $my_posts ) ) : ?>

                                    <li class="my-posts"><a class="dynamic-settings-style-menu-top_menu" href="<?php echo get_permalink($my_posts)?>"><?php _e( 'My added posts' , _DEV_ ); ?></a></li>

                                <?php endif; ?>

                                <?php /* Submit post */ ?>
                                <?php $post_item_page = _core::method( "_settings" , "get" , "settings" , "general" , "upload" , "post_item_page" ); ?>
                                <?php if( is_numeric( $post_item_page ) ) : ?>

                                    <li class="my-add"><a class="dynamic-settings-style-menu-top_menu" href="<?php echo get_permalink( $post_item_page ); ?>"><?php _e( 'Submit post' , _DEV_ ); ?></a></li>

                                <?php endif; ?>

                                <li class="my-logout"><a class="dynamic-settings-style-menu-top_menu" href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e( 'Log out' , _DEV_ ); ?></a></li>

                            </ul>
                        </li>

                    <?php else : ?>

                        <?php $login_page = _core::method( '_settings' , 'get' , 'settings' , 'general' , 'theme' , 'login-page' ); ?>

                        <li class="signin"><a class="dynamic-settings-style-menu-top_menu username" href="<?php echo get_permalink( $login_page ); ?>"><?php _e( 'Sign in' , _DEV_ ); ?></a></li>

                    <?php endif; ?>
					
				</ul>
			</div>
            <?php _core::hook( 'login' ); ?>
		</div>
        
	</div>
    
<?php endif; ?>