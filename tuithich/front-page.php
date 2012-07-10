<?php
    /* blog on front page */
    if( ( _core::method( '_settings' , 'get' , 'settings' , 'front_page' , 'resource' , 'type' ) == 'selected-page' ) &&  ( (int)_core::method( '_settings' , 'get' , 'settings' , 'front_page' , 'resource' , 'page' ) === (int)get_option( 'page_for_posts' ) ) ){
        global $wp_query;
        
        if( (int) get_query_var( 'paged' ) > 0 ){
            $paged = get_query_var( 'paged' );
        }else{
            if( (int) get_query_var( 'page' ) > 0 ){
                $paged = get_query_var( 'page' );
            }else{
                $paged = 1;
            }
        }
            
        $wp_query = new WP_Query( array( 'post_type' => 'post' , 'post_status' => 'publish', 'paged' => $paged ) );
        get_template_part( 'index' );
        exit();
    }
    
    /* list custom posts type */
    if( isset( $_GET[ 'fp_type' ] ) ){
        global $wp_query;
        
        if( (int) get_query_var( 'paged' ) > 0 ){
            $paged = get_query_var( 'paged' );
        }else{
            if( (int) get_query_var( 'page' ) > 0 ){
                $paged = get_query_var( 'page' );
            }else{
                $paged = 1;
            }
        }
            
        $wp_query = new WP_Query( array( 'post_type' => $_GET[ 'fp_type' ] , 'post_status' => 'publish' , 'paged' => $paged ) );
        get_template_part( 'index' );
        exit();
    }
    
    global $wp_query;
    
    $type = _core::method( '_settings' , 'get' , 'settings' , 'front_page' , 'resource' , 'type' );
	
	if( $type == 'time-line' ) :
		wp_enqueue_script( 'author' , get_template_directory_uri().'/js/author.js' );
		//wp_enqueue_script( 'timeline_upload' , get_template_directory_uri().'/js/timeline_uploader.js' );
	endif;

	get_header();
    
?>
        <!-- (?) -->
        <div id="ref"></div>
        <section class="hide_post bg" style="display: none"></section>
        <!-- (?) -->
        
        <section class="b_content clearfix" id="main">
            
            <div class="slide-panel" id="slidePanel">
            </div>

            <div class="b_page">
                <?php if( $type != 'widgets' ) : ?>
                
                    <?php 
                        switch( $type ){
                            case 'latest-post' : {
                                $query = new WP_Query( 
                                    array(
                                        'posts_per_page' => 1,
                                        'orderby' => 'post_date',
                                        'post_type' => 'post',
                                        'post_status' => 'publish'
                                    )
                                );
                                break;
                            }
                            case 'selected-post' : {
                                $postID = _core::method( '_settings' , 'get' , 'settings' , 'front_page' , 'resource' , 'post' );
                                $resources = _core::method( '_resources' , 'get' );
                                $customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $postID );
                                if( isset( $resources[ $customID ] ) ){
                                    $query = new WP_Query(
                                        array(
                                            'p' => $postID , 'post_type' => $resources[ $customID ][ 'slug' ]
                                        )
                                    );
                                }
                                break;
                            }
                            case 'selected-page' : {
                                $query = new WP_Query(
                                    array(
                                        'page_id' =>  _core::method( '_settings' , 'get' , 'settings' , 'front_page' , 'resource' , 'page' )
                                    )
                                );
                                break;
                            }
                        }
                    ?>
						<?php if( $type == 'time-line' ) : ?>
															
							<?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'front_page' ); ?>
							
							<div id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'front_page' ); ?>>
								<div id="content" role="main">
									<div class="content_tabber">
										<ul class="content_tabber sf-menu sf-js-enabled sf-shadow">
											
											<?php									
													$post_tab_classes = 'active';
											?>
											<li class="<?php echo $post_tab_classes?>">
												<a id="new_posts_menu_item" href="#tabber_frontpage_new_posts"><?php echo __( 'New' , _DEV_ );?></a>
											</li>
											<?php
												if( _core::method( '_settings' , 'logic' , 'settings' , 'blogging' , 'likes' , 'use' ) ) :
											?>
													<li>
														<a id="popular_posts_menu_item" href="#tabber_popular_posts"><?php echo __( 'Popular' , _DEV_ );?></a>
													</li>
											<?php
												endif;
											?>
										</ul>
										
										
											<div id="tabber_frontpage_new_posts_panel" class="loop-container-view tab_content tabs-container" <?php if( !strlen( $post_tab_classes ) ) echo 'style="display:none"'?>>
												<?php
													if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ) : ?>
                        
														<div class="masonry-container">
															<div class="grid-view author-posts-container">
														
													<?php else : ?>
																
														<div class="element last">
															<div class="list-view author-posts-container">
													
													<?php endif; ?>
													<?php 
														if( strlen( $post_tab_classes ) ):?>
														<script>
															if( !( document.location.hash.length && document.location.hash.length > 5 ) ){
																author.get_new( 1 );
															}
														</script>
													<?php
														endif;
													?>

														</div>
													</div>
											</div>
											<?php
												if( _core::method( '_settings' , 'logic' , 'settings' , 'blogging' , 'likes' , 'use' ) ) :
											?>
												<div id="tabber_popular_posts_panel" class="loop-container-view tab_content tabs-container hidden">
												<?php
													if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ) : ?>
                        
														<div class="masonry-container">
															<div class="grid-view author-posts-container">
														
													<?php else : ?>
																
														<div class="element last">
															<div class="list-view author-posts-container">
													
													<?php endif; ?>
														</div>
													</div>
												</div>
										<?php endif; ?>
									</div>
								</div>
							</div>    
							<?php _core::method( 'layout' , 'archiveSidebar' , 'right' , 'front_page' ); ?>
						<?php else : ?>
							
						
							<?php if(  isset( $query ) && count( $query -> posts ) > 0 ) : ?>
								<?php foreach( $query -> posts as $post ) : $query -> the_post(); ?>
									
									<?php /* left sidebar */ ?>
									<?php _core::method( 'layout' , 'singularSidebar' , $post -> ID , 'left' ); ?>

									<section id="primary" <?php _core::method( 'layout' , 'singularClasses' , $post -> ID ); ?>>
										<div id="content" role="main">

											<?php /* latest post title */ ?>
											<div class="content-title">
												<div class="title">
													<h1 class="entry-title"><?php echo cosmo_avatar( $post -> post_author , 50 ); ?>
														<?php echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'single' , 'post_title' , 'text' , get_the_title() , 'span' );?>    
														<span class="author">
															<a href="<?php echo get_author_posts_url( $post -> post_author ) ?>">
																<?php echo __( 'by' , _DEV_ ) . ' ' . get_the_author_meta( 'display_name' , $post -> post_author ); ?>
															</a>
														</span>
													</h1>
												</div>
											</div>
											
											<?php /* meta left */ ?>
											<?php _core::method( 'layout' , 'singularMeta' , $post -> ID , 'left' ); ?>
											
											<?php /* content */ ?>
											<div <?php _core::method( 'layout' , 'contentClasses' , $post -> ID ); ?>>
												<article id="post-<?php echo $post -> ID; ?>" <?php post_class(); ?>>
													<?php if( $type != 'selected-page' ) : ?>
													
														<?php /* for posts */ ?>
														<?php /* thumbnail ( map + video player ) */?>
														<?php get_template_part( '/templates/single/header' ); ?>
													
													<?php else: ?>
													
														<?php /* selected page */ ?>        
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
													
													<?php endif; ?>
																	<?php

													?>
													
													<div class="entry-content">
														<div class="b_text">
											
															<?php if( $type != 'selected-page' ) : ?>
															
																<?php /* post format */ ?>
																<?php get_template_part( '/templates/single/format' ); ?>
															
															<?php endif; ?>

															<?php /* post content */ ?>
															<?php echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'single' , 'post_text' , 'content' , $post , 'span' ); ?>

															<?php /* social sharing */ ?>
															<?php get_template_part( '/templates/social' ); ?>

														</div>
													</div>
												</article>
											</div>
											
											<?php /* meta right */ ?>
											<?php _core::method( 'layout' , 'singularMeta' , $post -> ID , 'right' ); ?>
											
										</div>
									</section>
					
									<?php /* secondary right */ ?>
									<?php _core::method( 'layout' , 'singularSidebar' , $post -> ID , 'right' ); ?>
					
								<?php endforeach; ?>
							<?php else : ?>
					
								<?php /* left sidebar */ ?>
								<?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'front_page' ); ?>
					
								<section id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'front_page' ); ?>>
									<div id="content" role="main">
										
										<?php /* 404 title error */ ?>
										<div class="content-title">
											<div class="title">
												<h1 class="entry-title">
													<span><?php _e( 'Error 404, page, post or resource can not be found' , _DEV_ ); ?></span>
												</h1>
											</div>
										</div>
										
										<div <?php _core::method( 'layout' , 'archiveClasses' , 'front_page' ); ?>>
											<?php get_template_part( 'loop' , '404' ); ?>
										</div>
										
									</div>
								</section>
					
								<?php /* right sidebar */ ?>
								<?php _core::method( 'layout' , 'archiveSidebar' , 'right' , 'front_page' ); ?>
					
							<?php endif; ?>

						<?php endif; ?>
                    <?php else : ?>
                        
                        <?php /* left sidebar */ ?>
                        <?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'front_page' ); ?>
                
                        <?php /* widgets type front-page ( mainpage content sidebars ) */ ?>
                        <section id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'front_page' ); ?>>
                            <div id="content" role="main">
                                <div>
                                    <?php get_sidebar( 'front-page' ); ?>
                                </div>    
                            </div>
                        </section>
                
                        <?php /* right sidebar */ ?>
                        <?php _core::method( 'layout' , 'archiveSidebar' , 'right' , 'front_page' ); ?>
                        
                    <?php endif; ?>
            </div>
        </section>

<?php get_footer(); ?>