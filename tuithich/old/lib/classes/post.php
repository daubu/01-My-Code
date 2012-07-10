<?php
    class post{
		static $post_id = 0;
        public static function loop( $template , $view = false , $light_box = false ){
            global $wp_query; $i = 0;
            if( $wp_query -> post_count > 0 ){
                
                if( _core::method( 'layout' , 'is_grid' , $template ) || ( $view && $view == 'grid' ) ){
                    foreach( $wp_query -> posts as $post ){
                        $wp_query -> the_post();
                        self::grid_view( $post , $template , $light_box );
                    }
                }else{
                    foreach( $wp_query -> posts as $post ){
                        $wp_query -> the_post();

                        if( $i == 0 ){
                            $i = 1;
                        }else{
                            ?><p class="delimiter">&nbsp;</p><?php
                        }

                        self::list_view( $post , $template );
                    }
                }
                
            }
        }
        
        public static function grid_view( $post , $template , $light_box = false, $use_hat = false ){
			global $global_use_hat;
			$global_use_hat = $use_hat;
            
            $classes = '';
            $thumbnail = true;
            
            if( !has_post_thumbnail( $post -> ID ) ){
                $classes = 'no-img';
                $thumbnail = false;
            }
            
			if( $use_hat ):
				$classes .= ' following';
			endif;
			if( !has_post_thumbnail( $post -> ID ) ):
				$classes .= ' no-img';
			endif;
			?>
                <article <?php post_class( 'item ' . $classes ); ?>>
                   
                    <?php if( $thumbnail ) : ?>
                    
                        <div class="hovermore">
							<?php if( $use_hat ):?>
								<div class="userdiv">
									<div class="user">    
										<a href="<?php echo get_author_posts_url( $post-> post_author ); ?>">
											<?php echo cosmo_avatar( $post-> post_author , 24 , DEFAULT_AVATAR ); ?>
											<p><?php echo get_the_author_meta( 'display_name' , $post-> post_author ) ?></p>
										</a>
										<?php _core::method( '_follow' , 'get_follow_btn' , $post -> post_author ); ?>
									</div>
								</div>
							<?php endif;?>
                            <div class="details mosaic-overlay">
								<?php if( $use_hat ): ?>
									<p class="delimiter"></p>
								<?php endif; ?>
					<?php else: ?>
						<?php if( $use_hat ):?>
							<div class="userdiv">
								<div class="user">    
									<a href="<?php echo get_author_posts_url( $post-> post_author ); ?>">
										<?php echo cosmo_avatar( $post-> post_author , 24 , DEFAULT_AVATAR ); ?>
										<p><?php echo get_the_author_meta( 'display_name' , $post-> post_author ) ?></p>
									</a>
									<?php _core::method( '_follow' , 'get_follow_btn' , $post -> post_author ); ?>
								</div>
							</div>
						<?php endif;?>
						<div class="no-img-box">
                    <?php endif; ?>        
					
                    <footer class="entry-footer">
                        <h2>
                            <a href="<?php echo get_permalink( $post -> ID ); ?>" title="<?php echo $post -> post_title; ?>"><?php echo $post -> post_title; ?></a>
                        </h2>

                        <div class="entry-meta">
                            <?php get_template_part( '/templates/meta/category' ); ?>
                        </div>
						<?php if( !(has_post_thumbnail( $post -> ID ) ) ): ?>
							<div class="excerpt"> 
								<p><?php echo _core::method( '_tools' , 'excerpt' , $post -> ID , _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'archive' , 'grid-excerpt' ) ); ?></p>
							</div>
						<?php endif; ?>
                    </footer>
                            
                    <?php get_template_part( '/templates/meta/grid-hover' ); ?>
                                
                    <?php if( $thumbnail ) : ?>            
                                
                            </div>

                            <?php
                                $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , "grid" );
                                echo '<img src="' . $src[0] . '" class="size" alt="' . $post -> post_title . '"/>';
                            ?>

                            <div class="stripes">&nbsp;</div>
                            <div class="corner">&nbsp;</div>
                        </div>
                    <?php else: ?>
						</div>
                    <?php endif; ?>
                    
                    <?php get_template_part( '/templates/meta/grid' ); ?>
                    
                </article>
            <?php
        }
        
        public static function list_view( $post , $template , $use_hat = false ){
            
            if( get_post_format( $post -> ID ) == 'video' ){	
                $format = _core::method( '_meta' , 'get' , $post -> ID , 'format' );
                if( isset( $format[ 'feat_id' ] ) && !empty( $format[ 'feat_id' ] ) ){
                    $video_id = $format[ 'feat_id' ];
                    $video_type = 'self_hosted';

                    if( isset( $format[ 'feat_url' ] ) && post::isValidURL( $format[ 'feat_url' ] ) ){
                        $vimeo_id = post::get_vimeo_video_id( $format[ 'feat_url' ] );
                        $youtube_id = post::get_youtube_video_id( $format[ 'feat_url' ] );

                        if( $vimeo_id != '0' ){
                            $video_type = 'vimeo';
                            $video_id = $vimeo_id;
                        }

                        if( $youtube_id != '0' ){
                            $video_type = 'youtube';
                            $video_id = $youtube_id;
                        }
                    }

                    if(isset($video_type) && isset($video_id) ){
                        if( $video_type == 'self_hosted' ){
                            $onclick = 'playVideo(\'' . urlencode( wp_get_attachment_url( $video_id ) ) . '\',\'' . $video_type . '\',jQuery(this), 450 , 235 )';
                        }else{
                            $onclick = 'playVideo(\'' . $video_id . '\',\'' . $video_type . '\',jQuery(this), 450 , 235 )';
                        }
                    }
                }
            }
                            
            ?>
				<?php
					$classes = 'post';
					if( $use_hat ):
						$classes .= ' following';
					endif;
					if( !has_post_thumbnail( $post -> ID ) ):
						$classes .= ' no-img';
					endif;
				?>
                <article <?php post_class( $classes )?>>
					<?php if( !has_post_thumbnail( $post -> ID ) ):?>
						<?php if( $use_hat ):?>
							<div class="userdiv">
								<div class="user">    
									<a href="<?php echo get_author_posts_url( $post-> post_author ); ?>">
										<?php echo cosmo_avatar( $post-> post_author , 24 , DEFAULT_AVATAR ); ?>
										<p><?php echo get_the_author_meta( 'display_name' , $post-> post_author ) ?></p>
									</a>
									<?php _core::method( '_follow' , 'get_follow_btn' , $post -> post_author ); ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
                    <?php if( has_post_thumbnail( $post -> ID ) ) : ?>
                        <header class="entry-header">
                            <div class="hovermore">
								<?php if( $use_hat ):?>
									<div class="userdiv">
										<div class="user">    
											<a href="<?php echo get_author_posts_url( $post-> post_author ); ?>">
												<?php echo cosmo_avatar( $post-> post_author , 24 , DEFAULT_AVATAR ); ?>
												<p><?php echo get_the_author_meta( 'display_name' , $post-> post_author ) ?></p>
											</a>
											<?php _core::method( '_follow' , 'get_follow_btn' , $post -> post_author ); ?>
										</div>
									</div>
								<?php endif;?>
                                <div class="details mosaic-overlay">
									<?php if( !$use_hat ):?>
										<div class="user">    
											<a href="<?php echo get_author_posts_url( $post-> post_author ); ?>">
												<?php echo cosmo_avatar( $post-> post_author , 24 , DEFAULT_AVATAR ); ?>
												<p><?php echo get_the_author_meta( 'display_name' , $post-> post_author ) ?></p>
											</a>
											<?php _core::method( '_follow' , 'get_follow_btn' , $post -> post_author ); ?>
										</div>
									<?php endif; ?>
                                    <div class="new_meta">
                                        <ul>
                                            <?php 
                                                if ( function_exists( 'stats_get_csv' ) ){    
                                                    $views = stats_get_csv( 'postviews' , "&post_id=" . $post -> ID);
                                                    ?>
                                                        <li class="views">
                                                            <a href="<?php echo get_permalink( $post -> ID ) ?>">
                                                                <strong>
                                                                    <?php echo (int)$views[0]['views']; ?>
                                                                </strong>
                                                                <?php
                                                                    if( (int)$views[0]['views'] == 1) {
                                                                        echo '<span>' . __( 'view' , _DEV_ ) . '</span>';
                                                                    }else{
                                                                        echo '<span>' . __( 'views' , _DEV_ ) . '</span>';
                                                                    } 
                                                                ?>
                                                            </a>
                                                        </li>
                                                    <?php 
                                                }

                                                if ( comments_open( $post->ID ) ) {
													$comments_label = __( 'replies' , _DEV_ );
                                                    if ( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'fb_comments' ) ) {
                                                        $comments = '<fb:comments-count href="'.get_permalink( $post->ID ).'"></fb:comments-count>';
                                                    }else{
                                                        $comments = get_comments_number( $post->ID );
														if($comments == 1){
															$comments_label = __( 'reply' , _DEV_ );
														}
                                                    }
                                                    ?>
                                                        <li class="replies">
                                                            <a href="<?php echo get_comments_link( $post->ID ); ?>">
                                                                <strong><?php echo $comments; ?></strong>
                                                                <span><?php echo $comments_label; ?></span>
                                                            </a>
                                                        </li>
                                                    <?php
                                                }

                                                if( get_post_format( $post -> ID ) == 'video' ){
                                                    ?><li class="play"><a href="javascript:void(0);" onclick="<?php echo $onclick; ?>"><strong><?php _e( 'play video' , _DEV_ ); ?></strong></a></li><?php
                                                }else{
                                                    ?><li class="read-more"><a href="<?php echo get_permalink( $post -> ID ); ?>"><strong><?php _e( 'read more' , _DEV_ ); ?></strong></a></li><?php
                                                } 
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="featimg">
                                    <div class="img">
                                        
                                        <?php $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'list' ); ?>
                                        <img src="<?php echo $src[0]; ?>" alt="'<?php echo $post -> post_title; ?>" />
                                        
                                    </div>
                                    <div class="stripes"></div>
                                </div>
                            </div>
                        </header>
                    
                    <?php endif; ?>
                    
                    <footer class="entry-footer">
                        
                        <?php get_template_part( '/templates/meta/list' ); ?>
                        
						<div class="excerpt">
                            <p><?php echo _core::method( '_tools' , 'excerpt' , $post -> ID , _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'archive' , 'list-excerpt' ) ); ?></p>
						</div>
                    </footer>
                </article>
            <?php
        }
		
        public static function my_posts($author){
            
            if( (int) get_query_var('paged') > 0 ){
                $paged = get_query_var('paged');
            }else{
                if( (int) get_query_var('page') > 0 ){
                    $paged = get_query_var('page');
                }else{
                    $paged = 1;
                }
            }

            if( (int)$author > 0  ){
                $wp_query = new WP_Query(array('post_status' => 'any', 'post_type' => 'post', 'paged' => $paged, 'author' => $author  ));
				if( !$wp_query -> have_posts() ){
					echo __( 'You do not have any posts' , _DEV_ );
				}
                foreach( $wp_query -> posts as $key => $post ){
                    if( $post -> post_status == "pending" ){
                        $publish_or_draft_classes = "status-pending";
                    }else{
                        if( $post -> post_status == "draft" ){
                            $publish_or_draft_classes = "status-draft";
                        }else{
                            $publish_or_draft_classes = "";
                        }
                    }
                    
                    $wp_query -> the_post();
                    
                    if( $key > 0 ){
                        ?>
                            <p class="delimiter">&nbsp;</p>
                        <?php
                    }
                    
                    ?>
                        <article id="post-<?php echo $post->ID; ?>" <?php post_class('post');?>>
                            <footer class="entry-footer">
                                
                                <h2 class="entry-title" class="<?php echo $publish_or_draft_classes;?>">
                                 <?php
                                        if( $post -> post_status == 'publish' ){
                                            ?><a href="<?php echo get_permalink( $post -> ID )?> " title="<?php echo __( 'Permalink to ' , _DEV_ ) . $post -> post_title; ?>" rel="bookmark"><?php echo $post -> post_title; ?></a><?php
                                        }else{
                                            echo $post -> post_title;
                                        }
                                 ?>
                                </h2>
                                
                                <div class="entry-meta">
                                    <ul>
                                        <?php
                                            if( is_user_logged_in() && $post -> post_author == get_current_user_id() ){ 
                                                $edit_link=get_page_link( _core::method( '_settings' , 'get' , 'settings' , 'general' , 'upload' , 'post_item_page' ) );
                                                if( strpos( $edit_link , "?" ) ){
                                                    $edit_link .= "&post=". $post -> ID;
                                                }else{
                                                    $edit_link .= "?post=". $post -> ID;
                                                }
                                                ?>
                                                    <li class="edit_post" title="<?php _e('Edit post',_DEV_) ?>"><a href="<?php  echo $edit_link;  ?>"  ><?php echo _e( 'Edit' , _DEV_ ); ?></a></li>
                                                <?php
                                            }

                                            if(is_user_logged_in() && $post->post_author == get_current_user_id() ){  
                                                $confirm_delete = __('Confirm to delete this post.',_DEV_);
                                                ?>
                                                    <li class="delete_post" title="<?php _e('Remove post',_DEV_) ?>"><a href="javascript:void(0)" onclick="if(confirm('<?php echo $confirm_delete; ?> ')){ removePost('<?php echo $post->ID; ?>','<?php echo home_url() ?>');}" ><?php echo _e('Delete',_DEV_); ?></a></li>
                                                <?php
                                            }
                                        ?>  
                                  </ul>
                                </div>
                                
                                <div class="excerpt">
                                  <?php echo the_excerpt(); ?>
                                </div>
                            </footer>
                        </article>
                    <?php
                }
                get_template_part('templates/pagination');
            }else{
                get_template_part('loop', '404');
            }
        }
      
        function remove_post(){
            if( isset( $_POST[ 'post_id' ] ) && is_numeric( $_POST[ 'post_id' ] ) ){
                $post = get_post( $_POST[ 'post_id' ] );
                if( get_current_user_id() == $post -> post_author ){
                    wp_delete_post( $_POST[ 'post_id' ] );
                }
            }
            exit;
        }

        static function write_inheritance_menus( $author_id , $parent = -1 ){
            $return="";
            $found_something=false;
            $everything=_core::method('_resources','get');
            foreach( $everything as $index => $something ){
                if( $something[ 'parent' ] == $parent && $something[ 'stitle' ] != 'Slideshow' ){
                    $found_something=true;
                    $return.="<li id=\"post_type_selected$index\" class=\"post_type_selectors\"><a href=\"javascript:likes.my( $author_id , 0 , [] , $index );\" style=\"color:inherit !important\">".$something['stitle']."</a>";
                    $return.=self::write_inheritance_menus( $author_id , $index );
                    $return.="</li>";
				}
			}
            
            if( $found_something ){
                return $return;
			}else{
                return "";
            }
		}

        public static function my_likes(){
			$post_id = isset( $_POST['postID'] ) ? $_POST['postID'] : exit;
			$result  = isset( $_POST['data'] ) ? $_POST['data'] : array();
			$customID  = isset( $_POST['customID'] ) ? intval($_POST['customID']) : exit;
			$uid = isset( $_POST[ 'author_id' ] ) ? $_POST[ 'author_id' ] : get_current_user_id();
			$resources=_core::method( '_resources' , 'get' );

			self::$post_id = $post_id;
			add_filter( 'posts_where', array( 'post' , 'filter_where' ) );

			$wp_query = new WP_Query( array( 'post_type' => $resources[$customID]['slug'] , 'post_status' => 'publish' , 'posts_per_page' => 250 , 'orderby' => 'ID' ) );
			$break = false;
			foreach( $wp_query -> posts as $p ){
				$likes = _core::method('_meta','get', $p -> ID, 'like');
				$hates = _core::method('_meta','get', $p -> ID, 'hate');
				$post_id = $p -> ID;
				if( is_array( $likes ) ){
					foreach( $likes as $like ){
						if( $like[ 'user_id' ] == $uid ){
							array_push( $result , $p -> ID );
							break;
						}
					}
				}

				if( is_array( $hates ) ){
					foreach( $hates as $hate ){
						if( $hate['user_id'] == $uid ){
							array_push( $result, $p -> ID );
							break;
						}
					}
				}
			
				
				if( count( $result ) == POSTS_PER_AUTHOR_PAGE ){
					$break = true;
					break;
				}
			}
		
			if( count( $result ) < POSTS_PER_AUTHOR_PAGE && ( $wp_query -> max_num_pages > 1 || $break ) ){
				echo json_encode( array( 'postID' => $post_id , 'data' => $result ) );
			}else{
				/* content */
				if( !empty( $result ) ){
					remove_filter( 'posts_where' , array( 'post' , 'filter_where' ) );
					$wp_query = new WP_Query( array( 'post__in' => $result , 'fp_type' => 'like' , 'post_type' => $resources[$customID]['slug'] , 'post_status' => 'publish' , 'posts_per_page' => POSTS_PER_AUTHOR_PAGE ) );
					$_POST['hide_social'] = true;
                    ?>
                            <?php 
								foreach( $wp_query -> posts as $index => $post ){
									$wp_query -> the_post();
									if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ){
										_core::method( 'post' , 'grid_view' , $post , 'author' );
									}else{
										_core::method( 'post' , 'list_view' , $post , 'author' );
										echo '<p class="delimiter">&nbsp;</p>';
									}
								}
							?>
                    <?php
					if( $wp_query -> max_num_pages > 1 || $break ){?>
						<div class="clearfix author-get-more">
							<div>
								<p class="button newblue">		
									<a id="get-more-voted" href="javascript:void(0)" onclick="javascript:likes.my( <?php echo $uid;?> , <?php echo $post_id; ?> , [] , '<?php echo $customID;?>' , true )"><?php echo __( 'Get more' , _DEV_ );?></a>
								</p>
							</div>
						</div>
				<?php
					}
				}else{
                    ?>
                        <div class="did-not-find-voted-posts item">
                            <!-- content -->
                            <div class="entry-footer">
                                <div class="excerpt">
                                    <?php _e( 'Unfortunately we did not find any loved posts.' , _DEV_ ); wp_link_pages(); ?>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            }
		
            exit();
		}

        function filter_where( $where = '' ){
            global $wpdb;
            if( self::$post_id > 0 ){
                $where .= " AND  ".$wpdb->prefix."posts.ID < " . self::$post_id;
            }
            
            return $where;
		}

        function add_image_post(){
        	$response = array(  
                'image_error' => '',
        		'error_msg' => '',	
        		'title_error' => '',
        		'post_id' => 0,
        		'auth_error' => '',
        		'success_msg' => ''
            );
        	
        	$is_valid = true;
        	
        	if( !is_user_logged_in() ){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __( 'You must be logged in to submit a post! ' , _DEV_ );	
        	}
            
        	if( is_user_logged_in() && isset( $_POST[ 'post_id' ] ) ){
				$post_edit = get_post( $_POST[ 'post_id' ] );
				
				if(get_current_user_id() != $post_edit->post_author && !current_user_can('administrator')){
					$is_valid = false;	
					$response[ 'error_msg' ] = __( 'You are not the author of this post. ' , _DEV_ );
					$response[ 'title_error' ] = __( 'You are not the author of this post. ' , _DEV_ );
				}
			}
            
        	if( !isset( $_POST[ 'title' ] ) || trim( $_POST[ 'title' ] ) == '' ){
        		$is_valid = false;
        		$response[ 'error_msg' ] = __( 'Title is required. ' , _DEV_ );
        		$response[ 'title_error' ] = __( 'Title is required. ' , _DEV_ );
        	}
            
        	if( !isset( $_POST[ 'attachments' ] ) || !is_array( $_POST[ 'attachments' ] ) || !isset( $_POST[ 'featured' ] ) || !is_numeric( $_POST[ 'featured' ] ) ) {
        		$is_valid = false;	
        		$response[ 'error_msg' ] = 'error';
        		$response[ 'image_error' ] = __( 'An image post must have a featured image. ' , _DEV_ );
			}
        	
        	
        	if( $is_valid ){
        		/*create post*/
        		$post_categories = array( 1 );
        		if( isset( $_POST['category_id'] ) ){
        			$post_categories = array( $_POST[ 'category_id' ] );
        		}
        			
        		$post_content = '';
        		if( isset( $_POST[ 'image_content'] ) ){
        			$post_content = $_POST[ 'image_content' ];
        		}
        			
        		if( isset( $_POST[ 'post_id' ] ) ){
					$new_post = self::create_new_post( $_POST[ 'title' ] , $_POST[ 'tags' ] , $post_categories , $post_content , $_POST[ 'post_id' ] );  /*add image as content*/
				}else{
					$new_post = self::create_new_post( $_POST['title'] , $_POST['tags'] , $post_categories , $post_content );  /*add image as content*/
				}
        			
			    if( is_numeric( $new_post ) ){
		       		$attachments = get_children( array(
                        'post_parent' => $new_post,
                        'post_status' => 'inherit',
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'order' => 'ASC',
                        'orderby' => 'menu_order ID'
                    ));
                    
					foreach ($attachments as $index => $id) {
                        $attachment = $index;
					}
                    
					foreach( $_POST[ 'attachments' ] as $index => $imageid ){
						if( $imageid == $_POST[ 'featured' ] ){
                            set_post_thumbnail($new_post, $imageid);
							unset($_POST['attachments'][$index]);
                        }
                        
						$attachment_post = get_post( $imageid );
						$attachment_post -> post_parent = $new_post;
						wp_update_post( $attachment_post );
					}
					
					if( isset( $_POST[ 'nsfw' ] ) ){
						$settings_meta = array(	  "safe" => "yes" );
						_core::method( '_meta' , 'set' , $new_post , 'settings' , $settings_meta );
                    }
						
					/*add source meta data*/
					if( isset( $_POST[ 'source' ] ) && trim( $_POST[ 'source' ] ) != '' ){
						_core::method( '_meta' , 'edit2' , $new_post , 'posts-settings' , 'source' ,  $_POST['source'] );
					}
							
					/*add video url meta data*/
					$image_format_meta = array( "type" => 'image' , 'images' => $_POST[ 'attachments' ] );
					_core::method( '_meta' , 'set' , $new_post , 'format' , $image_format_meta );

					if( isset( $_POST[ 'post_format' ] ) && ( $_POST[ 'post_format' ] == 'video' || $_POST[ 'post_format' ] == 'image' || $_POST[ 'post_format' ] == 'audio' ) ){
						set_post_format( $new_post , $_POST[ 'post_format' ] );
					}
                    
					if( _core::method('_settings','get','settings','general','upload','default_posts_status' ) == 'publish'){
						/*if post was publihed imediatelly then we will show the prmalink to the user*/
						$response['success_msg'] = sprintf( __( 'You can check your post %s here%s.' , _DEV_ ) , '<a href="' . get_permalink( $new_post ) . '">' , '</a>' );
					}else{
                        $response['success_msg'] = __( 'Success. Your post is awaiting moderation' , _DEV_ );
					}
                    
                    $response['post_id'] = $new_post;
                }	        		
            }	
        	echo json_encode( $response );
        	exit;
        }

		function add_file_post(){

			$response = array(  'image_error' => '',
								'file_error' => '',
        						'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '',
        						'success_msg' => ''	);
        	
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post! ',_DEV_);	
        	}
            
            if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author && !current_user_can('administrator')){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ',_DEV_);
					$response['title_error'] = __('You are not the author of this post. ',_DEV_);
				}
			}
            
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'Title is required. ';
        		$response['title_error'] = __('Title is required. ',_DEV_);
        	}

			if(!isset($_POST['attachments'])){
        		$is_valid = false;	
        		$response['error_msg'] = 'File is required. ';
        		$response['file_error'] = __('File is required. ',_DEV_);
        	}
        	
        		if($is_valid){
        			/*create post*/
        			$post_categories = array(1);
        			if(isset($_POST['category_id'])){
        				$post_categories = array($_POST['category_id']);
        			}
        			
        			$post_content = '';
        			if(isset($_POST['file_content'])){
        				$post_content = $_POST['file_content'];
        			}
        			
        			
                    if(isset($_POST['post_id'])){
						$new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  
					}else{
						$new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  
					}
                    
				    if(is_numeric($new_post))
					  {
						set_post_thumbnail($new_post, null);
						foreach($_POST['attachments'] as $index=>$attachid)
						  {
							if($attachid==$_POST['featured'])
							  {
								set_post_thumbnail($new_post, $attachid);
								unset($_POST['attachments'][$index]);
							  }
							$attachment_post=get_post($attachid);
							$attachment_post->post_parent=$new_post;
							wp_update_post($attachment_post);
						  }
						$file_url_meta = array(	  "link"=> "", "type" => 'link', 'link_id' => $_POST['attachments']);
						_core::method('_meta','set', $new_post , 'format' , $file_url_meta );
						
						if(isset($_POST['nsfw'])){
							$settings_meta = array(	  "safe"=>  "yes");
							_core::method('_meta','set', $new_post , 'settings' , $settings_meta );
						}	
						
						/*add source meta data*/
						if(isset($_POST['source']) && trim($_POST['source']) != ''){
							_core::method('_meta', 'edit2', $new_post, 'posts-settings' , 'source' ,  $_POST['source'] );
						}
													
						/*add file url meta data*/

						

						if(isset($_POST['post_format']) && ($_POST['post_format'] == 'video' || $_POST['post_format'] == 'image' || $_POST['post_format'] == 'audio' || $_POST['post_format'] == 'link') ){
							set_post_format( $new_post , $_POST['post_format']);
						}
						
						if(_core::method('_settings','get','settings','general','upload','default_posts_status' ) == 'publish'){
							/*if post was publihed imediatelly then we will show the prmalink to the user*/
								
							$response['success_msg'] = sprintf(__('You can check your post %s here%s.',_DEV_),'<a href="'.get_permalink($new_post).'">','</a>');
							
						}else{
							$response['success_msg'] = __('Success. Your post is awaiting moderation',_DEV_);
						}	
						$response['post_id'] = $new_post;
				    }	
				    
	        		
        		}	
        	echo json_encode($response);
        	exit;
		}

		function add_audio_post(){
			$response = array(  'image_error' => '',
								'audio_error' => '',
        						'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '',
        						'success_msg' => ''	);
        	
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post! ',_DEV_);	
        	}
        	
            if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author && !current_user_can('administrator')){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ',_DEV_);
					$response['title_error'] = __('You are not the author of this post. ',_DEV_);
				}
			}
            
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'Title is required. ';
        		$response['title_error'] = __('Title is required. ',_DEV_);
        	}

			if(!isset($_POST['attachments'])){
        		$is_valid = false;	
        		$response['error_msg'] = 'Audio File is required. ';
        		$response['audio_error'] = __('Audio File is required. ',_DEV_);
        	}
   	        	
        		if($is_valid){
        			/*create post*/
        			$post_categories = array(1);
        			if(isset($_POST['category_id'])){
        				$post_categories = array($_POST['category_id']);
        			}
        			
        			$post_content = '';
        			if(isset($_POST['audio_content'])){
        				$post_content = $_POST['audio_content'];
        			}

					if(isset($_POST['post_id'])){
						$new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  
					}else{
						$new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  
					}
                    
				    if(is_numeric($new_post))
					  {
						set_post_thumbnail($new_post, null);
						foreach($_POST['attachments'] as $index=>$attachid)
						  {
							if( isset( $_POST[ 'featured' ] ) && $attachid==$_POST['featured'])
							  {
								set_post_thumbnail($new_post, $attachid);
								unset($_POST['attachments'][$index]);
							  }
							$attachment_post=get_post($attachid);
							$attachment_post->post_parent=$new_post;
							wp_update_post($attachment_post);
						  }
						$audio_url_meta = array( "audio"=>  $_POST['attachments'], "type" => 'audio');
						_core::method('_meta','set', $new_post , 'format' , $audio_url_meta );

						if(isset($_POST['nsfw'])){
							$settings_meta = array(	  "safe"=>  "yes");
							_core::method('_meta','set', $new_post , 'settings' , $settings_meta );
						}	
						
						/*add source meta data*/
						if(isset($_POST['source']) && trim($_POST['source']) != ''){
							_core::method('_meta', 'edit2', $new_post, 'posts-settings' , 'source' ,  $_POST['source'] );
						}
												
						if(isset($_POST['post_format']) && ($_POST['post_format'] == 'video' || $_POST['post_format'] == 'image' || $_POST['post_format'] == 'audio' || $_POST['post_format'] == 'link') ){
							set_post_format( $new_post , $_POST['post_format']);
						}
						
						

						if(_core::method('_settings','get','settings','general','upload','default_posts_status' ) == 'publish'){
							/*if post was publihed imediatelly then we will show the prmalink to the user*/
								
							$response['success_msg'] = sprintf(__('You can check your post %s here%s.',_DEV_),'<a href="'.get_permalink($new_post).'">','</a>');
							
						}else{
							$response['success_msg'] = __('Success. Your post is awaiting moderation',_DEV_);
						}	
						$response['post_id'] = $new_post;
				    }	
				    
	        		
        		}	
        	echo json_encode($response);
        	exit;
		}
        
        function add_text_post(){
        	$response = array(  'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '' );
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post!',_DEV_);	
        	}
        	
            if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author && !current_user_can('administrator') ){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ',_DEV_);
					$response['title_error'] = __('You are not the author of this post. ',_DEV_);
				}
			}
            
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['title_error'] = __('Title is required. ',_DEV_);
        	}
        	
        		if($is_valid){

	        			/*create post*/
        				/*$post_content = self::get_embeded_video($video_id,$video_type);*/
	        			$post_categories = array(1);
	        			//$response['video_error'] = $_POST['category_id'];
	        			if(isset($_POST['category_id'])){
	        				$post_categories = array($_POST['category_id']);
	        			}
	        			
	        			$post_content = '';
	        			if(isset($_POST['text_content'])){
	        				$post_content = $_POST['text_content'];
	        			}
	        			
                        if(isset($_POST['post_id'])){
                            $new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  
                        }else{
                            $new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  
                        }
                        
					    if(is_numeric($new_post)){	
						   
							
							if(isset($_POST['nsfw'])){
								$settings_meta = array(	  "safe"=>  "yes");
								_core::method('_meta','set', $new_post , 'settings' , $settings_meta );
							}	
							
							/*add source meta data*/
						    if(isset($_POST['source']) && trim($_POST['source']) != ''){
								_core::method('_meta', 'edit2', $new_post, 'posts-settings' , 'source' ,  $_POST['source'] );
							}
						
							

							if(_core::method('_settings','get','settings','general','upload','default_posts_status' ) == 'publish'){
								/*if post was publihed imediatelly then we will show the prmalink to the user*/
									
								$response['success_msg'] = sprintf(__('You can check your post %s here%s.',_DEV_),'<a href="'.get_permalink($new_post).'">','</a>');
								
							}else{
								$response['success_msg'] = __('Success. Your post is awaiting moderation',_DEV_);
							}	
							$response['post_id'] = $new_post;
					    }
				
        		}
        			
        	echo json_encode($response);
        	exit;
        	
        }
        
        function add_video_post(){
        	$response = array(  'video_error' => '',
        						'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '' );
        	
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post!',_DEV_);	
        	}
        	
            if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author && !current_user_can('administrator') ){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ',_DEV_);
					$response['title_error'] = __('You are not the author of this post. ',_DEV_);
				}
			}
            
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['title_error'] = __('Title is required. ',_DEV_);
        	}
        	
			if(!isset($_POST['attachments']) || !is_array($_POST['attachments']) || !isset($_POST['featured']) || !is_numeric($_POST['featured']))
			{
				$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['video_error'] = __('A video post must have a featured video.',_DEV_);
			}
        	
        	if($is_valid)
			  {
	        	/*create post*/
        		/*$post_content = self::get_embeded_video($video_id,$video_type);*/
	        	$post_categories = array(1);
	        	//$response['video_error'] = $_POST['category_id'];
	        	
	        	if(isset($_POST['category_id'])){
	        		$post_categories = array($_POST['category_id']);
	        	}
	        			
	        	$post_content = '';
	        	if(isset($_POST['video_content'])){
	        		$post_content = $_POST['video_content'];
	        	}
	        			
        				
                if(isset($_POST['post_id'])){
                  $new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  
                }else{
                  $new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  
                }
                    
				if(is_numeric($new_post))
				  {	
					if(isset($_POST['nsfw'])){
					  $settings_meta = array(	  "safe"=>  "yes");
					  _core::method('_meta','set', $new_post , 'settings' , $settings_meta );
					}	
							
					/*add source meta data*/
					if(isset($_POST['source']) && trim($_POST['source']) != ''){
					  _core::method('_meta', 'edit2', $new_post, 'posts-settings' , 'source' ,  $_POST['source'] );
					}

					$featured_video_url="";
					foreach($_POST['attachments'] as $index=>$videoid)
					  {
						if($videoid==$_POST['featured'])
						  {
							$featured_video_id=$videoid;
							unset($_POST['attachments'][$index]);
							if(isset($_POST['video_urls'][$videoid]) && post::isValidURL($_POST['video_urls'][$videoid]))
							  {
								set_post_thumbnail($new_post,$videoid);
								$featured_video_url=$_POST['video_urls'][$videoid];
								unset($_POST['video_urls'][$videoid]);
							  }
							else set_post_thumbnail($new_post, null);
							}
						 $attachment_post=get_post($videoid);
						 $attachment_post->post_parent=$new_post;
						 wp_update_post($attachment_post);
					  }
				
				  $video_format_meta=array("type"=>"video", "video_ids"=>$_POST['attachments'], "feat_id"=>$featured_video_id, "feat_url"=>$featured_video_url);
				  if(isset($_POST['video_urls']))
					$video_format_meta["video_urls"]=$_POST["video_urls"];
				  _core::method('_meta','set', $new_post , 'format' , $video_format_meta );

				  if(isset($_POST['post_format']) && ($_POST['post_format'] == 'video' || $_POST['post_format'] == 'image' || $_POST['post_format'] == 'audio') ){
					set_post_format( $new_post , $_POST['post_format']);
				  }
									
					

				  if(_core::method('_settings','get','settings','general','upload','default_posts_status' ) == 'publish'){
					/*if post was publihed imediatelly then we will show the prmalink to the user*/
									
					$response['success_msg'] = sprintf(__('You can check your post %s here%s.',_DEV_),'<a href="'.get_permalink($new_post).'">','</a>');
								
				  }else{
					  $response['success_msg'] = __('Success. Your post is awaiting moderation',_DEV_);
				  }	
					  $response['post_id'] = $new_post;
				}
        			
        	}
        	        			
        	echo json_encode($response);
        	exit;
        }

	  function create_new_post($post_title,$post_tags, $post_categories, $content = '', $post_id = 0 ){
        	$current_user = wp_get_current_user();

        	$post_status = _core::method('_settings','get','settings','general','upload','default_posts_status' );
        	if($post_id == 0){
				$post_args = array(
		            'post_title' => $post_title,
		            'post_content' => $content ,
		            'post_status' => $post_status,
		            'post_type' => 'post',
					'post_author' => $current_user -> ID,
					'tags_input' => $post_tags,
					'post_category' => $post_categories
		        );
                
                $new_post = wp_insert_post($post_args);
        	}else{
                $updated_post = get_post($post_id);
        		$post_args = array(
        			'ID' => $post_id,	
		            'post_title' => $post_title,
		            'post_content' => $content ,
		            'post_status' => $post_status,
                    'comment_status'=> $updated_post -> comment_status,
		            'post_type' => 'post',
					'post_author' => $current_user -> ID,
					'tags_input' => $post_tags,
        			'post_category' => $post_categories
		        );
                
                $new_post = wp_update_post($post_args);
        	}    
	
	        
	        
			if($post_status == 'pending'){ /*we will notify admin via email if a this option was activated*/
				if(is_email(_core::method('_settings','get','settings','general','upload','pending_email' ))){
					$tomail = _core::method('_settings','get','settings','general','upload','pending_email' );
					$subject = __('A new post is awaiting your moderation',_DEV_);
					$message = __('A new post is awaiting your moderation.',_DEV_);
					$message .= ' ';
					$message .= sprintf(__('To moderate the post go to  %s ',_DEV_), home_url('/wp-admin/post.php?post='.$new_post.'&action=edit')) ;

					wp_mail($tomail, $subject , $message);

				}	
			}

			$enb_meta=_core::method( '_settings' , 'logic' , 'settings' , 'blogging' , 'posts' , 'meta' ) ? 'yes' : 'no';
			$enb_likes=_core::method( '_settings' , 'logic' , 'settings' , 'blogging' , 'likes' , 'use' ) ? 'yes' : 'no';
			$enb_social=_core::method( '_settings' , 'logic' , 'settings' , 'blogging' , 'posts' , 'social' ) ? 'yes' : 'no';
			_core::method( '_meta' , 'edit2' , $new_post, 'posts-settings', 'meta', $enb_meta );
			_core::method( '_meta' , 'edit2' , $new_post, 'posts-settings', 'likes', $enb_likes );
			_core::method( '_meta' , 'edit2' , $new_post, 'posts-settings', 'social', $enb_social );
	        return $new_post;
        }

	  function get_youtube_video_id($url){
	        /*
	         *   @param  string  $url    URL to be parsed, eg:  
	 		*  http://youtu.be/zc0s358b3Ys,  
	 		*  http://www.youtube.com/embed/zc0s358b3Ys
	 		*  http://www.youtube.com/watch?v=zc0s358b3Ys 
	 		*  
	 		*  returns
	 		*  */	
        	$id=0;
        	
        	/*if there is a slash at the en we will remove it*/
        	$url = rtrim($url, " /");
        	if(strpos($url, 'youtu')){
	        	$urls = parse_url($url); 
	     
			    /*expect url is http://youtu.be/abcd, where abcd is video iD*/
			    if(isset($urls['host']) && $urls['host'] == 'youtu.be'){  
			        $id = ltrim($urls['path'],'/'); 
			    } 
			    /*expect  url is http://www.youtube.com/embed/abcd*/ 
			    else if(strpos($urls['path'],'embed') == 1){  
			        $id = end(explode('/',$urls['path'])); 
			    } 
			     
			    /*expect url is http://www.youtube.com/watch?v=abcd */
			    else if( isset($urls['query']) ){ 
			        parse_str($urls['query']); 
			        $id = $v; 
			    }else{
					$id=0;
				} 
        	}	
			
			return $id;
        }
        
        function  get_vimeo_video_id($url){
        	/*if there is a slash at the en we will remove it*/
        	$url = rtrim($url, " /");
        	$id = 0;
        	if(strpos($url, 'vimeo')){
				$urls = parse_url($url); 
				if(isset($urls['host']) && $urls['host'] == 'vimeo.com'){  
					$id = ltrim($urls['path'],'/'); 
					if(!is_numeric($id) || $id < 0){
						$id = 0;
					}
				}else{
					$id = 0;
				} 
        	}	
			return $id;
		}

	  function get_video_thumbnail($video_id,$video_type){
        	$thumbnail_url = '';
        	if($video_type == 'youtube'){
				$thumbnail_url = 'http://i1.ytimg.com/vi/'.$video_id.'/hqdefault.jpg';
        	}elseif($video_type == 'vimeo'){
        		
				$hash = wp_remote_get("http://vimeo.com/api/v2/video/$video_id.php");
				$hash = unserialize($hash['body']);
				
				$thumbnail_url = $hash[0]['thumbnail_large'];  
        	}
        	
        	return $thumbnail_url;
        }

	  function get_local_video($video_url, $width = 610, $height = 443, $autoplay = false ){
			
            $result = '';    
			
            if($autoplay){
                $auto_play = 'true';
            }else{
                $auto_play = 'false';
            }
            
            $result = '<embed src="' . get_template_directory_uri() . '/flv/gddflvplayer.swf" 
                flashvars="?&autoplay='.$auto_play.'&sound=70&buffer=2&vdo=' . $video_url . '" 
                width="'.$width.'" 
                height="'.$height.'" 
                allowFullScreen="true" 
                quality="best" 
                wmode="transparent" 
                allowScriptAccess="always"  
                pluginspage="http://www.macromedia.com/go/getflashplayer"  
                type="application/x-shockwave-flash"></embed>';
            

			return $result;	
		}

	 function get_embeded_video($video_id,$video_type,$autoplay = 0,$width = 610,$height = 443){
        	
        	$embeded_video = '';
        	if($video_type == 'youtube'){
        		$embeded_video	= '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video_id.'?wmode=transparent&autoplay='.$autoplay.'" wmode="opaque" frameborder="0" allowfullscreen></iframe>';
        	}elseif($video_type == 'vimeo'){
        		$embeded_video	= '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;autoplay='.$autoplay.'&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';
        	}
        	
        	return $embeded_video;
        }
	function play_video($width=610, $height=443){
		$result = '';	
		if(isset($_POST['width']) && isset($_POST['height']) && is_numeric($_POST['height'])){
			$width = $_POST['width'];
			$height = $_POST['height'];
		}
		
		if(isset($_POST['video_id']) && isset($_POST['video_type']) && $_POST['video_type'] != 'self_hosted'){	
			$result = self::get_embeded_video($_POST['video_id'],$_POST['video_type'],1,$width, $height);
		}else{
			$video_url = urldecode($_POST['video_id']);
			
			$result = self::get_local_video($video_url, $width, $height, true );
		}	
		
		echo $result;
		exit;
	}
	
	  function isValidURL($url)
		{
			return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
		}

	  function get_attached_files($post_id){
        	
        	$attached_file = '';
  			$attached_file_meta = _core::method('_meta','get', $post_id , 'format' );

  			
			if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['link_id']) && is_array($attached_file_meta['link_id'])){
				foreach($attached_file_meta['link_id'] as $file_id)
				  {
					$attachment_url = explode('/',wp_get_attachment_url($file_id));
					$file_name = '';
					if(sizeof($attachment_url)){
					  $file_name = $attachment_url[sizeof($attachment_url) - 1];
					}	
					$attached_file .= '<div class="attach">';
					$attached_file .= '	<a href="'.wp_get_attachment_url($file_id).'">'.$file_name.'</a>';
					$attached_file .= '</div>';
				  }
			}else if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['link_id']))
			  {
				$file_id=$attached_file_meta['link_id'];
				$attachment_url = explode('/',wp_get_attachment_url($file_id));
					$file_name = '';
					if(sizeof($attachment_url)){
					  $file_name = $attachment_url[sizeof($attachment_url) - 1];
					}	
					$attached_file .= '<div class="attach">';
					$attached_file .= '	<a href="'.wp_get_attachment_url($file_id).'">'.$file_name.'</a>';
					$attached_file .= '</div>';
			  }
  					
  			return $attached_file;      	
        }

	  function get_audio_files($post_id){
        	$attached_file = '';
  			$attached_file_meta = _core::method('_meta','get', $post_id , 'format' );
  			
			if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['audio']) && is_array($attached_file_meta['audio'])){

				foreach($attached_file_meta['audio'] as $audio_id)
				  {
					$attached_file .= '[audio:'.wp_get_attachment_url($audio_id).']';
				  }				
			}else if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['audio']) && $attached_file_meta['audio'] != '' ){
			  $attached_file .= '[audio:'.$attached_file_meta['audio'].']';
			}
  					
  			return $attached_file;      	
        }

	   function list_tags($post_id){
            $tag_list = '';
            $tags = wp_get_post_terms($post_id, 'post_tag');

            if (!empty($tags)) {
                    $i = 1;
                    foreach ($tags as $tag) { 
                        if($i==1){
                            $tag_list .= $tag->name;
                        }else{
                            $tag_list .= ', '.$tag->name;
                        }    
                        $i++;
                    }
            }
            
            return $tag_list;
        }

	function dimox_breadcrumbs() {
        
	  $delimiter = '';
	  $home = __( 'Home' ,  _DEV_ ); // text for the 'Home' link

	  $before = '<li>'; // tag before the current crumb
	  $after = '</li>'; // tag after the current crumb

	  if (  !is_front_page() || is_paged() ) {

	    /*echo '<div id="crumbs">';*/

	    global $post;
	    $homeLink = home_url();
	    echo '<li><a href="' . $homeLink . '">' . $home . '</a> </li>' . $delimiter . ' ';

	    if ( is_category() ) {
	      global $wp_query;
	      $cat_obj = $wp_query -> get_queried_object();
	      $thisCat = $cat_obj -> term_id;
	      $thisCat = get_category( $thisCat );
	      $parentCat = get_category( $thisCat -> parent );
	      if ($thisCat->parent != 0) echo($before .get_category_parents($parentCat, TRUE, ' ' . '</li><li>' . ' '). $after);
	      echo $before . __( 'Archive by category' , _DEV_ ).' "' . single_cat_title('', false) . '"' . $after;

	    } elseif ( is_day() ) {
	      echo $before.'<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> '. $after . $delimiter . ' ';
	      echo $before.'<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> '. $after . $delimiter . ' ';
	      echo $before . get_the_time('d') . $after;

	    } elseif ( is_month() ) {
	      echo $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> '. $after . $delimiter . ' ';
	      echo $before . get_the_time('F') . $after;

	    } elseif ( is_year() ) {
	      echo $before . get_the_time('Y') . $after;

	    } elseif ( is_single() && !is_attachment() ) {
	      if ( get_post_type() != 'post' ) {
	        $post_type = get_post_type_object(get_post_type());
	        $slug = $post_type->rewrite;
            
	        echo $before . '<a href="' . add_query_arg( array( 'fp_type' => get_post_type() ) , home_url() ) . '">' . $post_type -> labels -> singular_name . '</a> '. $after . $delimiter . ' ';
	        echo $before . get_the_title() . $after;
	      } else {
	        $cat = get_the_category(); $cat = $cat[0];
			$category_parents=get_category_parents($cat, TRUE, ' ' . $after.$before . ' ');
			echo $before.substr_replace($category_parents,"",-5);
	        echo $before . get_the_title() . $after;
	      }

	    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && get_post_type() !='page' && !is_404() ) {
	      $post_type = get_post_type_object( get_post_type() );
          if( $post_type ){
                if( !isset( $_GET[ 'fp_type' ] ) ){
                    echo $before . $post_type -> labels -> singular_name . $after;
                }
          }

	    } elseif ( is_attachment() ) {
	      $parent = get_post($post->post_parent);
	      /*$cat = get_the_category($parent->ID); $cat = $cat[0];*/
	      /*echo $before . get_category_parents($cat, TRUE, ' ' . $delimiter . ' ') . $after;*/
	      echo $before . '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> '. $after . $delimiter . ' ';
	      echo $before . get_the_title() . $after;

	    } elseif ( is_page() && !$post->post_parent ) {
	      echo $before . get_the_title() . $after;

	    } elseif ( is_page() && $post->post_parent ) {
	      $parent_id  = $post->post_parent;
	      $breadcrumbs = array();
	      while ($parent_id) {
	        $page = get_page($parent_id);
	        $breadcrumbs[] = $before .'<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>'.$after ;
	        $parent_id  = $page->post_parent;
	      }
	      $breadcrumbs = array_reverse($breadcrumbs);
	      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
	      echo $before . get_the_title() . $after;

	    } elseif ( is_search() ) {
	      echo $before . __('Search results for',_DEV_).' "' . get_search_query() . '"' . $after;

	    } elseif ( is_tag() ) {
	      echo $before . __('Posts tagged',_DEV_).' "' . single_tag_title('', false) . '"' . $after;

	    } elseif ( is_author() ) {
	       global $author;
	      $userdata = get_userdata($author);
	      echo $before . __('Articles posted by ',_DEV_) . $userdata->display_name . $after;

	    } elseif ( is_404() ) {
	      echo $before . __('Error 404',_DEV_) . $after;
	    }

		if( !isset( $_GET['fp_type'] ) ){
			if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ){
					echo ' ('.__('Page',_DEV_) . ' ' . get_query_var('paged').')';
				}else{
					echo $before.__('Page',_DEV_) . ' ' . get_query_var('paged').$after;
				}
			}
		}
        
        if( !is_single() && !is_page() && isset( $_GET[ 'fp_type' ] ) ){
            echo $before . $_GET[ 'fp_type' ] . $after;
        }

	  	if( is_home() ){
            if( !isset( $_GET['fp_type'] ) ){
                echo $before . __('Blog',_DEV_). $after;
            }
		}

	    /*echo '</div>';*/

	  }else{
        if( isset( $_GET[ 'fp_type' ] ) ){
            global $post;
            $homeLink = home_url();
            echo '<li><a href="' . $homeLink . '">' . $home . '</a> </li>' . $delimiter . ' ';
        }
        
        if( !is_single() && !is_page() && isset( $_GET[ 'fp_type' ] ) ){
            echo $before . $_GET[ 'fp_type' ] . $after;
        }
      }
	} /* end dimox_breadcrumbs()*/

	public static function get_author_posts( $user_id = false ){
		if( $user_id ){
			$ajax = false;
			$skip = 1;
		}else{
			$ajax = true;
			$user_id = isset( $_POST[ 'user_id' ] ) ? $_POST[ 'user_id' ] : exit;
			$skip = isset( $_POST[ 'skip' ] ) ? $_POST[ 'skip' ] : 1;
		}

		$wp_query = new WP_Query( array(
				'post_status' => 'publish',
				'posts_per_page' => POSTS_PER_AUTHOR_PAGE,
				'author' => $user_id,
				'paged' => $skip,
				'post_type' => self::exclude_post_types()
			)
		);

		if( $wp_query -> have_posts() ){
			foreach( $wp_query -> posts as $index => $post ){
				$wp_query -> the_post();
				if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ){
					_core::method( 'post' , 'grid_view' , $post , 'author' );
				}else{
					if( !( $skip == 1 && $index == 0 ) ){
						echo '<p class="delimiter">&nbsp;</p>';
					}
					_core::method( 'post' , 'list_view' , $post , 'author' );
				}
			}

			$wp_query = new WP_Query( array(
					'post_status' => 'publish',
					'posts_per_page' => POSTS_PER_AUTHOR_PAGE,
					'author' => $user_id,
					'paged' => ( $skip + 1 ),
					'post_type' => self::exclude_post_types()
				)
			);

			if( $wp_query -> have_posts() ){?>
				<div class="clearfix author-get-more">
					<div>
						<p class="button newblue">		
							<a href="javascript:void(0)" onclick="javascript:author.get_posts( <?php echo $user_id; ?> , <?php echo $skip+1; ?> )"><?php echo __( 'Get more' , _DEV_ );?></a>
						</p>
					</div>
				</div>
			<?php
			}
		}else if( $skip >= 1){
			if( $user_id == get_current_user_id() ){
				echo '<p class="item">'.__( 'You do not have any posts.' , _DEV_ ).'</p>';
			}else{
				echo '<p class="item">'.__( 'This user does not have any posts.' , _DEV_ ).'</p>';
			}
		}

		if( $ajax ) exit;
	}

	public static function get_new_posts( ){
		$ajax = ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'get_new_posts' );
		if( !$ajax ){
			$skip = 1;
		}else{
			$skip = isset( $_POST[ 'skip' ] ) ? $_POST[ 'skip' ] : 1;
		}

		$wp_query = new WP_Query( array(
				'post_status' => 'publish',
				'post_type' => _core::method( 'post' , 'exclude_post_types' ),
				'orderby' => 'date',
				'order' => 'DESC',
				'paged' => $skip,
				'posts_per_page' => POSTS_PER_AUTHOR_PAGE
			)
		);

		if( $wp_query -> have_posts() ){
			foreach( $wp_query -> posts as $index => $post ){
				$wp_query -> the_post();
				if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ){
					_core::method( 'post' , 'grid_view' , $post , 'author' );
				}else{
					if( !( $skip == 1 && $index == 0 ) ){
						echo '<p class="delimiter">&nbsp;</p>';
					}
					_core::method( 'post' , 'list_view' , $post , 'author' );
				}
			}

			$wp_query = new WP_Query( array(
					'post_status' => 'publish',
					'post_type' => _core::method( 'post' , 'exclude_post_types' ),
					'orderby' => 'date',
					'order' => 'DESC',
					'paged' => ( $skip + 1 ),
					'posts_per_page' => POSTS_PER_AUTHOR_PAGE
				)
			);

			if( $wp_query -> have_posts() ){?>
				<div class="clearfix author-get-more">
					<div>
						<p class="button newblue">		
							<a href="javascript:void(0)" onclick="javascript:author.get_new( <?php echo $skip+1; ?> )"><?php echo __( 'Get more' , _DEV_ );?></a>
						</p>
					</div>	
				</div>
			<?php
			}
		}else if( $skip == 1){
			echo '<p class="item">'.__( 'Nothing found' , _DEV_ ).'</p>';
		}

		if( $ajax ) exit;
	}

	public static function get_popular_posts( ){
		$ajax = ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'get_popular_posts' );
		if( !$ajax ){
			$skip = 1;
		}else{
			$skip = isset( $_POST[ 'skip' ] ) ? $_POST[ 'skip' ] : 1;
		}

		$wp_query = new WP_Query( array(
				'post_status' => 'publish',
				'post_type' => _core::method( 'post' , 'exclude_post_types' ),
				'meta_query' => array(
					array(
						'key' => 'nr_like',
						'value' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'likes' , 'limit' ),
						'compare' => '>=',
						'type' => 'numeric'
					)
				),
				'paged' => $skip,
				'posts_per_page' => POSTS_PER_AUTHOR_PAGE
			)
		);

		if( $wp_query -> have_posts() ){
			foreach( $wp_query -> posts as $index => $post ){
				$wp_query -> the_post();
				if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ){
					_core::method( 'post' , 'grid_view' , $post , 'author' );
				}else{
					if( !( $skip == 1 && $index == 0 ) ){
						echo '<p class="delimiter">&nbsp;</p>';
					}
					_core::method( 'post' , 'list_view' , $post , 'author' );
				}
			}

			$wp_query = new WP_Query( array(
					'post_status' => 'publish',
					'post_type' => _core::method( 'post' , 'exclude_post_types' ),
					'meta_query' => array(
						array(
							'key' => 'nr_like',
							'value' => _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'likes' , 'limit' ),
							'compare' => '>=',
							'type' => 'numeric'
						)
					),
					'paged' => ( $skip + 1 ),
					'posts_per_page' => POSTS_PER_AUTHOR_PAGE
				)
			);

			if( $wp_query -> have_posts() ){?>
				<div class="clearfix author-get-more">
					<div>
						<p class="button newblue">		
							<a href="javascript:void(0)" onclick="javascript:author.get_popular( <?php echo $skip+1; ?> )"><?php echo __( 'Get more' , _DEV_ );?></a>
						</p>
					</div>	
				</div>
			<?php
			}
		}else if( $skip == 1 ){
			echo '<p class="item">'. __( 'No posts are popular yet' , _DEV_ ).'</p>';
		}

		if( $ajax ) exit;
	}

	public static function exclude_post_types( $exclude = array( 'page' , 'slideshow' ) ){
		$resources = _core::method( '_resources' , 'get' );
		$result = array();
		foreach( $resources as $resource ){
			if( !in_array( $resource[ 'slug' ] , $exclude ) ){
				array_push( $result , $resource[ 'slug' ] );
			}
		}
		return array_values( $result );
	}
}
?>