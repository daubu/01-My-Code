<?php
    get_header();
    /* if on change from wp special page for blog page and special page for front-page */
    if( isset( $wp_query -> queried_object -> ID ) &&  $wp_query -> queried_object -> ID == get_option( 'page_for_posts' ) ){
        global $wp_query;
        
        if( (int) get_query_var('paged') > 0 ){
            $paged = get_query_var('paged');
        }else{
            if( (int) get_query_var('page') > 0 ){
                $paged = get_query_var('page');
            }else{
                $paged = 1;
            }
        }
        
        $wp_query = new WP_Query( array( 'post_type' => 'post' , 'post_status' => 'publish' , 'paged' => $paged ) );
    }
?>

        <section class="b_content clearfix" id="main">
            <div class="b_page">
        
                <?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'blog_page' ); wp_reset_query(); ?>

                <section id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'blog_page' ); ?>>
                    <div id="content" role="main">
                        
                        <div class="content-title">
                            <div class="title">
                                <h1 class="entry-title">
                                    <?php
                                        if( have_posts () ){
                                            if( isset( $_GET[ 'fp_type' ] ) ){
                                                $title = _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'labels' , 'post_type' );
                                                $title = str_replace( '%type%' , $_GET['fp_type'] , $title );
                                            }else{
                                                $title = _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'labels' , 'blog_page' );
                                            }
                                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , $title , 'span' );
                                        }else{
                                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , __( 'Sorry, no posts found' , _DEV_ ) , 'span' );
                                        }
                                    ?>
                                </h1>
                            </div>
                        </div>
                        
                        <?php if( _core::method( 'post_settings' , 'useGrid' , 'blog_page' ) ) : ?>
                        
                            <div class="masonry-container">
                                <div class="grid-view">
                            
                        <?php else : ?>
                                    
                            <div class="element last">
                                <div class="list-view">
                        
                        <?php endif; ?>

                                <?php _core::method( 'post' , 'loop' , 'blog_page' ); ?>

                            </div>
                        </div>

                        <?php get_template_part( 'templates/pagination' ); ?>
                    </div>
                </section>

                <?php _core::method( 'layout' , 'archiveSidebar' , 'right' , 'blog_page' ); wp_reset_query(); ?>

            </div>
        </section>

<?php get_footer(); ?>