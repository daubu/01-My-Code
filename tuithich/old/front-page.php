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
		wp_enqueue_script( 'timeline_upload' , get_template_directory_uri().'/js/timeline_uploader.js' );
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
												if( is_user_logged_in() ) :
													$post_tab_classes = '';
											?>
													<li class="active">
														<a id="timeline_menu_item" href="#tabber_timeline">Timeline</a>
													</li>
											<?php
												else :
													$post_tab_classes = 'active';
												endif;
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
										
										<?php if( is_user_logged_in() ): ?>
											<div id="tabber_timeline_panel" class="loop-container-view tab_content tabs-container ">
												<div class="timeline">
													<div class="grid-view">
														<div class="firstdiv">
															<?php 
																$post_item_page = _core::method( "_settings" , "get" , "settings" , "general" , "upload" , "post_item_page" );
																if( is_numeric( $post_item_page ) &&
																	(   _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_text' ) ||
																		_core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_image' ) ||
																		_core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_audio' ) ||
																		_core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_video' )
																	)
																):
															?>
																<?php $post_item_page = _core::method( "_settings" , "get" , "settings" , "general" , "upload" , "post_item_page" ); ?>
																<article class="cosmo-tabs default" id="mini-form">
																	<ul class="tabs-nav">
																		<?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_text' ) ) : ?>
																			<li class="first tabs-selected"><a href="#text"><span class="text"><?php echo __( 'Text' , _DEV_ );?></span></a></li>
																		<?php endif; ?>
																		<?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_image' ) ) : ?>
																			<li class=""><a href="#photo"><span class="photo"><?php echo __( 'Photo' , _DEV_ );?></span></a></li>
																		<?php endif; ?>
																		<?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_audio' ) ) : ?>
																			<li class=""><a href="#audio"><span class="audio"><?php echo __( 'Audio' , _DEV_ );?></span></a></li>
																		<?php endif; ?>
																		<?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_video' ) ) : ?>
																			<li class=""><a href="#video"><span class="video"><?php echo __( 'Video' , _DEV_ );?></span></a></li>
																		<?php endif; ?>
																	</ul>
																	<p class="blue_line"></p>
																	<iframe name="hidden_upload_iframe" class="hidden"></iframe>
																	<?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_text' ) ) : ?>
																		<div class="tabs-container" id="text">
																			<form method="post" action="/post-item?phase=post" id="form_timeline_text">
																				<div class="timeline_text">
																					<textarea class="timeline_text front_post_input" name="text_content" rows="10"><?php echo __( "What's on your mind?" , _DEV_ );?></textarea>
																				</div>
																				<div class="timeline_title miniform_to_hide">
																					<input class="timeline_title front_post_input " title="<?php echo __( 'Add a title for your story' , _DEV_ );?>" name="title" value="<?php echo __( 'Add a title for your story' , _DEV_ );?>" onfocus="if (this.value == '<?php echo __( 'Add a title for your story' , _DEV_ );?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo __( 'Add a title for your story' , _DEV_ );?>';}" autocomplete="off">
																					<p class="info"  id="text_post_title_info">
																						<span class="warning" style="display:none; " id="text_post_title_warning"></span>
																						<div class="success_msg" style="display:none"></div>
																					</p>
																				</div>
																				<div class="form_btn_submit miniform_to_hide">
																					<p class="button newblue">
																						<input type="button" id="submit_img_btn" value="<?php echo __( 'Submit' , _DEV_ );?>" onclick="timeline_add_text_post()">
																					</p>
																					<?php if( is_numeric( $post_item_page ) ) : ?>
																						<a href="<?php echo get_permalink( $post_item_page ); ?>">
																							<span><?php echo __( 'Rich text editting' , _DEV_ );?></span>
																						</a>
																					<?php endif; ?>
																				</div>
																				<input type="hidden" name="tags" value="">
																				<input type="hidden" name="category_id" value="<?php echo _core::method( '_settings' , 'get' , 'settings' , 'general' , 'upload' , 'timeline_default_category' ); ?>">
																			</form>
																		</div>
																	<?php endif; ?>
																	<?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_image' ) ) : ?>
																		<div class="tabs-container tabs-hide" id="photo">
																			<div class="upload miniform_to_hide" id="photo_upload">
																				<form method="post" action="<?php echo get_template_directory_uri()?>/upload-server.php" target="hidden_upload_iframe" enctype="multipart/form-data">
																					<p class="info">
																						<span class="warning" style="display:none; " id="img_warning"></span>
																						<span><?php echo __( 'Select an image file on your computer' , _DEV_ );?></span>
																						<a class="upload upload-button" href="javascript:void(0)" id="swithcher_upload_img">
																							<strong><?php echo __( 'Add photos' , _DEV_ );?></strong>
																						</a>
																						<span class="cui_error_container warning"></span>
																					</p>
																					<input type="file" name="files_to_upload[]" class="files_to_upload" multiple="true" tabindex="-1">
																					<input type="hidden" name="type" value="image">
																					<input type="hidden" name="action" value="upload">
																					<input type="hidden" name="sender">
																				</form>
																				<div class="thumbnails"></div>
																			</div>
																			<form method="post" action="/post-item?phase=post" id="form_timeline_photo">
																				<div class="timeline_text">
																					<textarea class="timeline_text front_post_input" name="image_content" onfocus="" rows="10"><?php echo __( "What's on your mind?" , _DEV_ );?></textarea>
																				</div>
																				<div class="timeline_title miniform_to_hide">
																					<input class="timeline_title front_post_input" title="<?php echo __( 'Add a title for your story' , _DEV_ );?>" name="title" value="<?php echo __( 'Add a title for your story' , _DEV_ );?>" onfocus="if (this.value == '<?php echo __( 'Add a title for your story' , _DEV_ );?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo __( 'Add a title for your story' , _DEV_ );?>';}" autocomplete="off">
																					<p class="info">
																						<span class="warning" style="display:none; " id="img_post_title_warning"></span>
																						<div class="success_msg" style="display:none"></div>
																					</p>
																				</div>
																				<div class="form_btn_submit miniform_to_hide">
																					<p class="button newblue">
																						<input type="button" id="submit_img_btn" value="<?php echo __( 'Submit' , _DEV_ );?>" onclick="timeline_add_image_post()">
																					</p>
																					<?php if( is_numeric( $post_item_page ) ) : ?>
																						<a href="<?php echo get_permalink( $post_item_page ); ?>">
																							<span><?php echo __( 'Rich text editting' , _DEV_ );?></span>
																						</a>
																					<?php endif; ?>
																				</div>
																				<input type="hidden" name="tags" value="">
																				<input type="hidden" name="category_id" value="<?php echo _core::method( '_settings' , 'get' , 'settings' , 'general' , 'upload' , 'timeline_default_category' ); ?>">
																			</form>
																		</div>
																	<?php endif; ?>
																	<?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_audio' ) ) : ?>
																		<div class="tabs-container tabs-hide" id="audio">
																			<div class="upload miniform_to_hide" id="audio_upload">
																				<form method="post" action="<?php echo get_template_directory_uri()?>/upload-server.php" target="hidden_upload_iframe" enctype="multipart/form-data">
																					<p class="info">
																						<span class="warning" style="display:none; " id="img_warning"></span>
																						<span><?php echo __( 'Select an audio file on your computer' , _DEV_ );?></span>
																						<a class="upload upload-button" href="javascript:void(0)" id="swithcher_upload_img">
																							<strong><?php echo __( 'Add audio' , _DEV_ );?></strong>
																						</a>
																						<span class="cui_error_container warning"></span>
																					</p>
																					<input type="file" name="files_to_upload[]" class="files_to_upload" multiple="true" tabindex="-1">
																					<input type="hidden" name="type" value="audio">
																					<input type="hidden" name="action" value="upload">
																					<input type="hidden" name="sender">
																				</form>
																				<div class="thumbnails"></div>
																			</div>
																			<form method="post" action="/post-item?phase=post" id="form_timeline_audio">
																				<div class="timeline_text">
																					<textarea class="timeline_text front_post_input" title="<?php echo __( "What's on your mind?" , _DEV_ );?>" name="text" onfocus="" rows="10"><?php echo __( "What's on your mind?" , _DEV_ );?></textarea>
																				</div>
																				<div class="timeline_title miniform_to_hide">
																					<input class="timeline_title front_post_input" title="<?php echo __( 'Add a title for your story' , _DEV_ );?>" name="title" value="<?php echo __( 'Add a title for your story' , _DEV_ );?>" onfocus="if (this.value == '<?php echo __( 'Add a title for your story' , _DEV_ );?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo __( 'Add a title for your story' , _DEV_ );?>';}" autocomplete="off">
																					<p class="info">
																						<span class="warning" style="display:none; " id="audio_img_post_title_warning"></span>
																						<div class="success_msg" style="display:none"></div>
																					</p>
																				</div>
																				<div class="form_btn_submit miniform_to_hide">
																					<p class="button newblue">
																						<input type="button" id="submit_img_btn" value="<?php echo __( 'Submit' , _DEV_ );?>" onclick="javascript:timeline_add_audio_post();">
																					</p>
																					<?php if( is_numeric( $post_item_page ) ) : ?>
																						<a href="<?php echo get_permalink( $post_item_page ); ?>">
																							<span><?php echo __( 'Rich text editting' , _DEV_ );?></span>
																						</a>
																					<?php endif; ?>
																				</div>
																				<input type="hidden" name="tags" value="">
																				<input type="hidden" name="category_id" value="<?php echo _core::method( '_settings' , 'get' , 'settings' , 'general' , 'upload' , 'timeline_default_category' ); ?>">
																				<input type="hidden" name="post_format" value="audio">
																			</form>
																		</div>
																	<?php endif; ?>
																	<?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'upload' , 'enb_video' ) ) : ?>
																		<div class="tabs-container tabs-hide" id="video">
																			<div class="upload miniform_to_hide" id="video_upload">
																				<form method="post" action="<?php echo get_template_directory_uri()?>/upload-server.php" target="hidden_upload_iframe" enctype="multipart/form-data">
																					<p class="info">
																						<span class="warning" style="display:none; " id="img_warning"></span>
																						<span><?php echo __( 'Select a video file on your computer' , _DEV_ );?></span>
																						<a class="upload upload-button" href="javascript:void(0)" id="swithcher_upload_img">
																						<strong><?php echo __( 'Add video' , _DEV_ );?></strong></a>
																						<span class="cui_error_container warning"></span>
																					</p>
																					<input type="file" name="files_to_upload[]" class="files_to_upload" multiple="true" tabindex="-1">
																					<input type="hidden" name="type" value="video">
																					<input type="hidden" name="action" value="upload">
																					<input type="hidden" name="sender">
																				</form>
																				<div class="thumbnails"></div>
																			</div>
																			<form method="post" action="/post-item?phase=post" id="form_timeline_video">
																				<div class="timeline_text">
																					<textarea class="timeline_text front_post_input" title="<?php echo __( "What's on your mind?" , _DEV_ );?>" name="text" onfocus="" rows="10"><?php echo __( "What's on your mind?" , _DEV_ );?></textarea>
																				</div>
																				<div class="timeline_title miniform_to_hide">
																					<input class="timeline_title miniform_to_hide front_post_input" title="<?php echo __( 'Add a title for your story' , _DEV_ );?>" name="title" value="<?php echo __( 'Add a title for your story' , _DEV_ );?>" onfocus="if (this.value == '<?php echo __( 'Add a title for your story' , _DEV_ );?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo __( 'Add a title for your story' , _DEV_ );?>';}" autocomplete="off">
																					<p class="info">
																						<span class="warning" style="display:none; " id="video_post_title_warning"></span>
																						<div class="success_msg" style="display:none"></div>
																					</p>
																				</div>
																				<div class="form_btn_submit miniform_to_hide">
																					<p class="button newblue">
																						<input type="button" id="submit_img_btn" value="Submit" onclick="javascript:timeline_add_video_post()">
																					</p>
																					<?php if( is_numeric( $post_item_page ) ) : ?>
																						<a href="<?php echo get_permalink( $post_item_page ); ?>">
																							<span><?php echo __( 'Rich text editting' , _DEV_ );?></span>
																						</a>
																					<?php endif; ?>
																				</div>
																				<input type="hidden" name="tags" value="">
																				<input type="hidden" name="category_id" value="<?php echo _core::method( '_settings' , 'get' , 'settings' , 'general' , 'upload' , 'timeline_default_category' ); ?>">
																				<input type="hidden" name="post_format" value="video">
																			</form>
																		</div>
																	<?php endif; ?>
																</article>
															<?php endif; ?>
														</div>
														<div class="timeline_bg"><div></div></div>
														<div class="seconddiv"></div>
													</div>
													<div class="purgatory" style="visibility:hidden">
														<script>
															if( !( document.location.hash.length && document.location.hash.length > 5 ) ){
																author.get_timeline( <?php echo get_current_user_id(); ?> , 1 );
															}
														</script>
													</div>
											
												</div>
											</div>
											<?php endif; ?>
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