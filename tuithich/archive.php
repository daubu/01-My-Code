<?php get_header(); ?>

        <section class="b_content clearfix" id="main">
            <div class="b_page">

                <?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'archive' ); wp_reset_query(); ?>
                
                <section id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'archive' ); ?>>
                    <div id="content" role="main">
                        
                        <div class="content-title">
                            <div class="title">
                                <h1 class="entry-title">
                                    <?php
                                        if ( is_day() ) {
                                            $label = _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'labels' , 'daily_archives' );
                                            $label = str_replace( '%date%' , get_the_date() , $label );
                                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , $label , 'span' );
                                        }else if ( is_month() ) {
                                            $label = _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'labels' , 'monthly_archives' );
                                            $label = str_replace( '%month%' , get_the_date( 'F' ) , $label );
                                            $label = str_replace( '%year%' , get_the_date( 'Y' ) , $label );
                                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , $label , 'span' );
                                        }else if ( is_year() ) {
                                            $label = _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'labels' , 'yearly_archives' );
                                            $label = str_replace( '%year%' , get_the_date( 'Y' ) , $label );
                                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , $label , 'span' );
                                        }else {
                                            $label = _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'labels' , 'blog_archives' );
                                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'title' , 'text' , $label , 'span' );
                                        }
                                    ?>
                                </h1>
                            </div>
                        </div>
                        
                        <?php if( _core::method( 'post_settings' , 'useGrid' , 'archive' ) ) : ?>
                        
                            <div class="masonry-container">
                                <div class="grid-view">
                            
                        <?php else : ?>
                                    
                            <div class="element last">
                                <div class="list-view">
                        
                        <?php endif; ?>

                                <?php _core::method( 'post' , 'loop' , 'archive' ); ?>

                            </div>
                        </div>

                        <?php get_template_part( 'templates/pagination' ); ?>
                    </div>
                </section>
                
                <?php _core::method( 'layout' , 'archiveSidebar' , 'right' , 'archive' ); wp_reset_query(); ?>
                
            </div>
        </section>
        
<?php get_footer(); ?>