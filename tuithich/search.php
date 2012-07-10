<?php get_header(); ?>

        <section class="b_content clearfix" id="main">
            <div class="b_page">

                <?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'lsearch' ); wp_reset_query(); ?>

                <section id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'lsearch' ); ?>>
                    <div id="content" role="main">
                        
                        <div class="content-title">
                            <div class="title">
                                <h1 class="entry-title">
                                    <?php
                                        if( have_posts () ){
                                            $label = _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'labels' , 'search' );
                                            $label = str_replace( '%s%' , get_query_var( 's' ) , $label );
                                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , $label , 'span' );
                                        }else{
                                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , __( 'Sorry, no results found for' , _DEV_ ) . ': ' . get_query_var( 's' ) , 'span' );
                                        }
                                    ?>
                                </h1>
                            </div>
                        </div>

                        <?php if( _core::method( 'post_settings' , 'useGrid' , 'lsearch' ) ) : ?>

                            <div class="masonry-container">
                                <div class="grid-view">

                        <?php else : ?>

                            <div class="element last">
                                <div class="list-view">

                        <?php endif; ?>

                                <?php _core::method( 'post' , 'loop' , 'lsearch' ); ?>

                            </div>
                        </div>

                        <?php get_template_part( 'templates/pagination' ); ?>
                    </div>
                </section>

                <?php _core::method( 'layout' , 'archiveSidebar' , 'right' , 'lsearch' ); wp_reset_query(); ?>

            </div>
        </section>
            
<?php get_footer(); ?>