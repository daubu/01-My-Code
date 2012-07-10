<?php get_header(); ?>

<section class="b_content clearfix" id="main">
    <div class="b_page">
        
        <?php if( have_posts() ) : ?>
            <?php while( have_posts() ) : the_post(); ?>
                    
                <?php /* secondary left */ ?>
                <?php _core::method( 'layout' , 'singularSidebar' , $post -> ID , 'left' ); wp_reset_query(); ?>

                <?php /* primary */ ?>
                <section id="primary" <?php _core::method( 'layout' , 'singularClasses' , $post -> ID ); ?>>
                    <div id="content" role="main">
                        
                        <?php /* title */ ?>
                        <div class="content-title">
                            <div class="title">
                                <h1 class="entry-title"><?php get_template_part( '/templates/single/title' ); ?></h1>
                            </div>
                        </div>
                        
                        <?php /* meta left */ ?>
                        <?php _core::method( 'layout' , 'singularMeta' , $post -> ID , 'left' ); ?>

                        <?php /* content */ ?>
                        <div <?php _core::method( 'layout' , 'contentClasses' , $post -> ID ); ?>>
                            <article <?php post_class(); ?> >

                                <?php /* thumbnail ( map + video player ) */?>
                                <?php get_template_part( '/templates/single/header' ); ?>

                                <div class="entry-content">
                                    <div class="b_text">
                                        
                                        <?php /* post format */ ?>
                                        <?php get_template_part( '/templates/single/format' ); ?>
                                        
                                        <?php /* post content */ ?>
                                        <?php echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'single' , 'post_text' , 'content' , $post , 'span' ); ?>

										<?php /* aditional info */ ?>
										<?php get_template_part( '/templates/single/additional' ); ?>
							
										<footer class="entry-footer">
											<?php /* attached coduments */ ?>
											<?php get_template_part( '/templates/single/attachdocs' ); ?>
                                            
                                            <?php /* social sharing */ ?>
                            				<?php get_template_part( '/templates/social' ); ?>
                            
											<?php /* post navigation */ ?>
											<?php get_template_part( '/templates/navigation' ); ?>
										</footer>

                                    </div>
                                </div>
                            </article>
                            
                            <?php /* program */ ?>
                            <?php echo _core::method( '_program' , 'getProgram' , $post -> ID ); ?>

                            
                            
                            <?php /* other post */ ?>
                            <?php get_template_part( '/templates/single/related' );  ?>
                            
                            <?php /* advertising zone */ ?>
                            <?php get_template_part( '/templates/advertising-comments' ); ?>

                            <?php /* comments */ ?>
                            <?php get_template_part( '/templates/comments' ); ?>
                            
                        </div>

                        <?php /* meta right */ ?>
                        <?php _core::method( 'layout' , 'singularMeta' , $post -> ID , 'right' ); ?>
        
                    </div>
                </section>
        
                <?php /* secondary right */ ?>
                <?php _core::method( 'layout' , 'singularSidebar' , $post -> ID , 'right' ); wp_reset_query(); ?>
        
            <?php endwhile; ?>
            
        <?php endif; ?>
        
    </div>
</section>
        
<?php get_footer(); ?>