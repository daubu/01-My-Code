<?php get_header(); ?>

        <section class="b_content clearfix" id="main">
            <div class="b_page">

                <?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'l404' ); wp_reset_query(); ?>

                <section id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'l404' ); ?>>
                    <div id="content" role="main">
                        
                        <div class="content-title">
                            <div class="title">
                                <h1 class="entry-title">
                                    <?php echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , __( 'Error 404, page, post or resource can not be found' , _DEV_ ) , 'span' ); ?>
                                </h1>
                            </div>
                        </div>
                        
                        <div class="element last">
                            <div class="list-view">
                                <?php get_template_part( 'loop' , '404' ); ?>
                            </div>    
                        </div>
                        
                    </div>
                </section>    

                <?php _core::method( 'layout' , 'archiveSidebar' , 'right' , 'l404' ); wp_reset_query(); ?>

            </div>
        </section>

<?php get_footer(); ?>