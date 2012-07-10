<?php
    if( $post->ID == _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "settings-page" ) ){
        get_template_part( 'user_profile_update' );
    }

	if( $post -> ID == _core::method( "_settings" , "get" , "settings" , "general" , "upload" , "post_item_page" ) || $post->ID == _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "settings-page" ) ) :
		wp_enqueue_script( 'upload' , get_template_directory_uri().'/js/uploader.js' );
	endif;

    get_header();
?>

        <section class="b_content clearfix" id="main">
            <div class="b_page">
                
                <?php if( $post -> ID == _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "login-page" ) ) : ?>

                    <?php if( isset( $_GET[ 'a' ] ) && $_GET[ 'a' ] == 'follow' ) : ?>

                        <p class="not_logged_msg"><?php _e( 'You need to sign in to follow someone.' , _DEV_ ); ?></p>

                    <?php endif; ?>

                    <?php if( isset( $_GET[ 'a' ] ) && $_GET[ 'a' ] == 'like' ) : ?>

                        <p class="not_logged_msg"><?php _e( 'You need to sign in to vote for a post.' , _DEV_ ); ?></p>

                    <?php endif; ?>

                <?php endif; ?>    
                
            
                <?php while( have_posts () ) : the_post(); $postID = $post -> ID; ?>
                
                    <?php /* left sidebar */ ?>
                    <?php _core::method( 'layout' , 'singularSidebar' , $post -> ID , 'left' );  wp_reset_query(); ?>
                
                    <?php /* page content */ ?>    
                    <section  <?php _core::method( 'layout' , 'singularClasses' , $post -> ID ); ?>>
                        <div id="content" role="main">

                            <?php /* page title  */ ?>            
                            <div class="content-title">

                                <div class="title">
                                    <h1 class="entry-title">
                                        <?php get_template_part( '/templates/page/title' ); ?>
                                    </h1>
                                </div>

                            </div>

                            <?php if( $post -> ID == _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "post-page" ) && $post -> ID != '' ) : ?>

                                <div class="w_690 my-posts">

                                    <?php _core::method( "post" , "my_posts" , get_current_user_id() ); ?>

                                </div>

                            <?php elseif( $post -> ID == _core::method( "_settings" , "get" , "settings" , "general" , "upload" , "post_item_page" )  && $post -> ID != '' ) : ?>

                                <?php /* post item page ( trebuieste de facut mai deductibil ) */ ?>
                                <?php get_template_part( 'post_item' ); ?>

                            <?php elseif($post -> ID == _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "login-page" )  && $post -> ID != '' ) : ?>

                                <?php /* login page */ ?>
                                <?php get_template_part( 'login' ); ?>

                            <?php elseif($post->ID == _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "settings-page" )  && $post -> ID != '' ) : ?>

                                <?php /* user profile */ ?>
                                <div <?php _core::method( 'layout' , 'contentClasses' , $post -> ID ); ?>>

                                    <?php get_template_part( 'user_profile' ); ?>

                                </div>

                            <?php else : ?>

                                <?php /* meta left */ ?>
                                <?php _core::method( 'layout' , 'singularMeta' , $post -> ID , 'left' ); ?>

                                <?php /* default WordPress page */ ?>
                                <div <?php _core::method( 'layout' , 'contentClasses' , $post -> ID ); ?>>
                                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post' , $postID ); ?>>

                                        <?php /* if use featured images */ ?>
                                        <?php if( _core::method(  '_settings' , 'logic' , 'settings' , 'blogging' , 'pages' , 'enb-featured' ) ) : ?>
                                            <?php if ( has_post_thumbnail( $post -> ID ) ) : ?>

                                                <header class="entry-header">
                                                    <div class="featimg">

                                                        <div class="img">
                                                            <?php echo wp_get_attachment_image( get_post_thumbnail_id( $post -> ID ) , 'single' ); ?>
                                                        </div>

                                                    </div>
                                                </header>

                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <div class="entry-content">
                                            <div class="b_text">

                                                <?php /* post content */ ?>
                                                <?php echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'single' , 'post_text' , 'content' , $post , 'span' ); ?>

                                                
                                                
                                                <?php /* post navigation */ ?>
                                                <?php get_template_part( '/templates/navigation' ); ?>

                                            </div>
                                        </div>
                                    </article>
                                    
                                    <?php /* social sharing */ ?>
                                    <?php get_template_part( '/templates/social' ); ?>
                                    
                                    
                                    <?php /* advertising zone */ ?>
                                    <?php get_template_part( '/templates/advertising-comments' ); ?>

                                    <?php /* comments */ ?>
                                    <?php get_template_part( '/templates/comments' ); ?>
                                </div>

                                <?php /* meta right */ ?>
                                <?php _core::method( 'layout' , 'singularMeta' , $post -> ID , 'right' ); ?>

                            <?php endif; ?>

                        </div>
                    </section>

                    <?php  /* right sidebar */ ?>
                    <?php _core::method( 'layout' , 'singularSidebar' , $post -> ID , 'right' ); wp_reset_query(); ?>
                    
                <?php endwhile; ?>
                        
            </div>
        </section>

<?php get_footer(); ?>