<?php
	class _follow{
        
        //private $currentuser;
        
        function currentuser() {
            global $current_user;
            get_currentuserinfo();    
            
            return $current_user;
        }
        
        
        /*returns the array of users that are following the current user*/
        public static function get_followers($user_id){
            $followers = array();            
            
                $followers = get_user_meta($user_id , ZIP_NAME.'followers', true);
                if(!is_array($followers)){
                   $followers = array();  
                }
                
            return $followers;
        }
        
        /*returns the array of users that  the current user is following */
        public static function get_following($user_id){
            
            $following = array();            
                $following = get_user_meta($user_id , ZIP_NAME.'following', true);
                if(!is_array($following)){
                   $following = array();  
                }
            return $following;
        }
        
        /*check if the curent user is following a given author*/
        public static function is_following($author_id){
            $following = self::get_following(self::currentuser()->ID);
            if(is_array($following) && sizeof($following)){
                if(in_array($author_id,$following) ) {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        
        }
        
        /*autput follow button*/
        public static function follow_btn($author_id){
            
            $onclick = 'follow('.$author_id.')';
            $res = '<a href="javascript:void(0)" onclick="'.$onclick.'" title="'.__('Follow',_DEV_).'" class="follow user'.$author_id.'"></a>';
            echo $res;
        }
        
        /*autput unfollow button*/
        public static function unfollow_btn($author_id){
            
            $onclick = 'unfollow('.$author_id.')';
            $res = '<a href="javascript:void(0)" onclick="'.$onclick.'" title="'.__('Unfollow',_DEV_).'" class="follow-no user'.$author_id.'"></a>';
            echo $res;
        }
        
        /*show follow or unfollow button depending on the condittions */
        public static function get_follow_btn($author_id){ 
            if( is_user_logged_in() && _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'enb_follow' ) ){
                if(self::currentuser()->ID != $author_id){
                    
                    if(self::is_following($author_id)){/*if current user is foolowing this author*/
                        self::unfollow_btn($author_id);
                    }else{
                        self::follow_btn($author_id);
                    }
                }
            }elseif( _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "login-page" ) != '' ){
                $log_in_link = get_permalink(_core::method( "_settings" , "get" , "settings" , "general" , "theme" , "login-page" ));
                $log_in_link = add_query_arg( 'a', 'follow', $log_in_link );
                echo '<a href="'.$log_in_link.'"  title="'.__('Follow',_DEV_).'" class="follow user'.$author_id.'"></a>';
            }
        }

		public static function get_big_follow_btn($author_id){
            if(is_user_logged_in() && _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'enb_follow' ) ){
                if(self::currentuser()->ID != $author_id){
                    
                    if(self::is_following($author_id)){/*if current user is foolowing this author*/
                        self::big_unfollow_btn($author_id);
                    }else{
                        self::big_follow_btn($author_id);
                    }
                }
            }elseif( _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "login-page" ) != '' ){
                $log_in_link = get_permalink(_core::method( "_settings" , "get" , "settings" , "general" , "theme" , "login-page" ));
                $log_in_link = add_query_arg( 'a', 'follow', $log_in_link );
                self::big_follow_btn($log_in_link);
            }
        }

		public static function big_follow_btn($author_id){  
            if(is_numeric($author_id)){
                $onclick = 'big_follow('.$author_id.' , this )';
                $res  = '<li class="btn_follow">';
                    $res.= '<a href="#tabber_posts" onclick="'.$onclick.'" title="'.__('Follow',_DEV_).'">';
                        $res.= '<span>';
                            $res.= '<span>';
                                $res.='<strong>' . __( 'Follow' , _DEV_ ) . '</strong>';
                            $res.= '</span>';
                        $res.= '</span>';
                    $res.= '</a>';
                $res.= '</li>';
            }else{
                $res  = '<li class="btn_follow">';
                    $res.= '<a href="'.$author_id.'"  title="'.__('Follow',_DEV_).'">';
                        $res.= '<span>';
                            $res.= '<span>';
                                $res.='<strong>' . __( 'Follow' , _DEV_ ) . '</strong>';
                            $res.= '</span>';
                        $res.= '</span>';
                    $res.= '</a>';
                $res.= '</li>';
            }    
            echo $res;
        }
        
        /*autput unfollow button*/
        public static function big_unfollow_btn($author_id){
            $onclick = 'big_unfollow('.$author_id.', this )';
			$res  = '<li class="btn_followed">';
				$res.= '<a href="#tabber_posts" onclick="'.$onclick.'" title="'.__('Follow',_DEV_).'">';
					$res.= '<span>';
						$res.= '<span>';
							$res.='<strong>' . __( 'Unfollow' , _DEV_ ) . '</strong>';
						$res.= '</span>';
					$res.= '</span>';
				$res.= '</a>';
			$res.= '</li>';
            echo $res;
        }
        
        public static function follow(){
            if(isset($_POST['author_id'])){
                $author_id = $_POST['author_id'];
                $following = self::get_following( self::currentuser()->ID ); /*get the users that current user is following*/
                if(!in_array($author_id,$following) ) {
                    $following[] = $author_id;
                    update_user_meta( self::currentuser()->ID, ZIP_NAME.'following', $following );
                    
                }

                $followers = self::get_followers( $author_id ); /*get the users that are following the current author*/
                if(!in_array(self::currentuser()->ID,$followers) ) {
                    $followers[] = self::currentuser()->ID;
                    update_user_meta( $author_id, ZIP_NAME.'followers', $followers);
                }
            }
            exit();
        }
        public static function unfollow($author_id){
            if(isset($_POST['author_id'])){
                $author_id = $_POST['author_id'];
                $following = self::get_following( self::currentuser()->ID ); /*get the users that current user is following*/
                if(in_array($author_id,$following) ) {
                    $following = self::unsetArray($author_id, $following);
                    
                    update_user_meta( self::currentuser()->ID, ZIP_NAME.'following', $following );
                }

                $followers = self::get_followers( $author_id ); /*get the users that are following the current author*/
                if(in_array(self::currentuser()->ID,$followers) ) {
                    $followers = self::unsetArray(self::currentuser()->ID, $followers); 
                    update_user_meta( $author_id, ZIP_NAME.'followers', $followers);
                }
            }
            exit();    
        }
        
        public static function unsetArray($value, $arr){
            $key = array_search($value, $arr);
            if(is_numeric($key) && $key >= 0 ){ 
                unset($arr[$key]);
            }
            return $arr;
        }

		public static function get_timeline( $user_id = false ){
			if( $user_id ){
				$ajax = false;
				$skip = 1;
			}else{
				$ajax = true;
				$user_id = isset( $_POST[ 'user_id' ] ) ? $_POST[ 'user_id' ] : exit;
				if( $user_id == -1 ){
					$user_id = get_current_user_id();
				}
				$skip = isset( $_POST[ 'skip' ] ) ? $_POST[ 'skip' ] : 1;
			}

			$following = _core::method( '_follow' , 'get_following' , $user_id );

			if( !in_array( $user_id , $following ) ):
				array_push( $following , $user_id );
			endif;

			$authors = implode( ',' , $following );
			$wp_query = new WP_Query( array(
					'post_status' => 'publish',
					'posts_per_page' => POSTS_PER_AUTHOR_PAGE,
					'author' => $authors,
					'paged' => $skip,
					'post_type' => _core::method( 'post' , 'exclude_post_types' ),
					'orderby' => 'date',
					'order' => 'DESC'
				)
			);

			if( $wp_query -> have_posts() ){
					foreach( $wp_query -> posts as $index => $post ){
						$wp_query -> the_post();
						self::timeline_grid_view( $post );
					}

				$wp_query = new WP_Query( array(
						'post_status' => 'publish',
						'posts_per_page' => POSTS_PER_AUTHOR_PAGE,
						'author' => $authors,
						'paged' => ( $skip + 1 ),
						'post_type' => _core::method( 'post' , 'exclude_post_types' ),
						'orderby' => 'date',
						'order' => 'DESC'
					)
				);

				if( $wp_query -> have_posts() ){?>
					<div class="clearfix author-get-more">
						<div>
							<p class="button newblue">		
								<a href="javascript:void(0)" onclick="javascript:author.get_timeline( <?php echo $user_id; ?> , <?php echo $skip+1; ?> )"><?php echo __( 'Get more' , _DEV_ );?></a>
							</p>
						</div>	
					</div>
				<?php
				}
			}else{	?>
				<div class="timeline_is_empty">
					<p><?php echo __( 'There are no posts in this timeline yet' , _DEV_ );?></p>
				</div>
			<?php
			}

			if( $ajax ) exit;
		}

		public static function get_author_following( $user_id = false ){
			if( $user_id ){
				$ajax = false;
				$skip = 0;
			}else{
				$ajax = true;
				$user_id = isset( $_POST[ 'user_id' ] ) ? $_POST[ 'user_id' ] : exit;
				$skip = isset( $_POST[ 'skip' ] ) ? $_POST[ 'skip' ] : 0;
			}

			$following = array_values( _core::method( '_follow' , 'get_following' , $user_id ) );
			if( count( $following ) == 0 ){
				if( $user_id == get_current_user_id() ){
					echo '<p class="item">'.__( 'You do not follow anyone.' , _DEV_ ).'</p>';
				}else{
					echo '<p class="item">'.__( 'This author does not follow anyone.' , _DEV_ ).'</p>';
				}
				if( $ajax ){
					exit;
				}else{
					return;
				}
			}

			$processed_posts = 0;
			$posts_to_skip = $skip * AUTHORS_PER_FOLLOWING_AND_FOLLOWERS;
			$show_get_more = false;
			foreach( $following as $index => $author){
				if( $posts_to_skip > 0 ){
					$posts_to_skip --;
				}else if( $processed_posts < AUTHORS_PER_FOLLOWING_AND_FOLLOWERS ){
					_core::method( '_follow' , 'author_grid_view' , $author );
					$processed_posts++;
				}else{
					$show_get_more = true;
					break;
				}
			}

			if( $show_get_more ){?>
				<div class="clearfix author-get-more">
					<div>
						<p class="button newblue">		
							<a href="javascript:void(0)" onclick="javascript:author.get_following( <?php echo $user_id; ?> , <?php echo $skip+1; ?> )"><?php echo __( 'Get more' , _DEV_ );?></a>
						</p>
					</div>	
				</div>
			<?php
			}
			if( $ajax ) exit;
		}

		public static function get_author_followers( $user_id = false ){
			if( $user_id ){
				$ajax = false;
				$skip = 0;
			}else{
				$ajax = true;
				$user_id = isset( $_POST[ 'user_id' ] ) ? $_POST[ 'user_id' ] : exit;
				$skip = isset( $_POST[ 'skip' ] ) ? $_POST[ 'skip' ] : 0;
			}

			$following = array_values( _core::method( '_follow' , 'get_followers' , $user_id ) );
			if( count( $following ) == 0 ){
				if( $user_id == get_current_user_id() ){
					echo '<p class="item">'.__( 'You do not have any followers' , _DEV_ ).'</p>';
				}else{
					echo '<p class="item">'.__( 'This author does not have any followers' , _DEV_ ).'</p>';
				}
				if( $ajax ){
					exit;
				}else{
					return;
				}
			}

			$processed_posts = 0;
			$posts_to_skip = $skip * AUTHORS_PER_FOLLOWING_AND_FOLLOWERS;
			$show_get_more = false;
			foreach( $following as $index => $author){
				if( $posts_to_skip > 0 ){
					$posts_to_skip --;
				}else if( $processed_posts < AUTHORS_PER_FOLLOWING_AND_FOLLOWERS ){
					_core::method( '_follow' , 'author_grid_view' , $author );
					$processed_posts++;
				}else{
					$show_get_more = true;
					break;
				}
			}

			if( $show_get_more ){?>
				<div class="clearfix author-get-more">
					<div>
						<p class="button newblue">		
							<a href="javascript:void(0)" onclick="javascript:author.get_followers( <?php echo $user_id; ?> , <?php echo $skip+1; ?> )"><?php echo __( 'Get more' , _DEV_ );?></a>
						</p>
					</div>
				</div>
			<?php
			}

			if( $ajax ) exit;
		}

		public static function timeline_grid_view( $p = false ){
			if( $p ):
				$ajax = false;
				$post = $p;
			else:
				$ajax = true;
				$post_id = isset( $_POST[ 'post_id' ] ) ? $_POST[ 'post_id' ] : exit;
				$query = new WP_Query( array( 'p' =>  $post_id ) );
				$query -> the_post();
				$post = array_pop( $query -> posts );
			endif;       
            ?>
				<article>
					<div class="arrow"><span></span></div>
					<div class="point"><span></span></div>
					<?php if( has_post_thumbnail( $post -> ID ) ) : ?>
						<div class="hovermore">
							<div class="details mosaic-overlay">
								<div class="user">
									<a href="<?php echo get_author_posts_url( $post-> post_author ); ?>">
										<?php echo cosmo_avatar( $post-> post_author , 30 , DEFAULT_AVATAR ); ?>
										<?php echo get_the_author_meta( 'display_name' , $post-> post_author ) ?>
									</a>
									<?php _core::method( '_follow' , 'get_follow_btn' , $post -> post_author ); ?>
									<a href="<?php echo get_permalink( $post -> ID ); ?>">
										<span>
											<?php
												if ( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'time' ) ) {
													$time = human_time_diff( strtotime( $post -> post_date ) , current_time( 'timestamp' ) ) . ' ' . __( 'ago' , _DEV_ );
												}else{
													$time = date_i18n( get_option( 'date_format' ) , strtotime( $post -> post_date ) ); 
												}
												echo $time;
											?>
										</span>
									</a>
								</div>
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
															$onclick = 'playTimelineVideo(\'' . urlencode( wp_get_attachment_url( $video_id ) ) . '\',\'' . $video_type . '\',jQuery(this), 450 , 235 )';
														}else{
															$onclick = 'playTimelineVideo(\'' . $video_id . '\',\'' . $video_type . '\',jQuery(this), 450 , 235 )';
														}
													}
												}
                                                ?><li class="play"><a href="javascript:void(0);" onclick="<?php echo $onclick; ?>"><strong><?php _e( 'play video' , _DEV_ ); ?></strong></a></li><?php
                                            }else{
                                                ?><li class="read-more"><a href="<?php echo get_permalink( $post -> ID ); ?>"><strong><?php _e( 'read more' , _DEV_ ); ?></strong></a></li><?php
                                            }
                                        ?>
									</ul>
								</div>
							</div>
							<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'grid' ); ?>
							<?php $src = $src[ 0 ]; ?>
							<img class="size" src="<?php echo $src;?>">
							<div class="stripes">&nbsp;</div>
							<div class="corner">&nbsp;</div>
						</div>
					<?php
						elseif( get_post_format( $post -> ID ) == 'video' ) : 
							$video_format = _core::method( '_meta' , 'get' , $post -> ID , 'format' );
							if( isset( $video_format[ 'feat_id' ] ) && is_numeric( $video_format[ "feat_id" ] ) ){
								echo '<div class="hovermore h_video">';
								echo _core::method( 'post' , 'get_local_video' , urlencode( wp_get_attachment_url( $video_format[ "feat_id" ] ) ) , '100%' ,'300' );
								echo '</div>';
                            }
						endif;
					?>
                    <footer class="entry-footer">
						<h2>
							<?php echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'archive' , 'post-title' , 'link_post_title' , $post , 'a' ); ?>
							<?php 
								if( _core::method( '_likes' , 'isVoted' , $post -> ID ) ){
									$classes = 'voted';
								}else{
									$classes = '';
								}
							?>
							<span class="love <?php echo $classes;?>">
								<?php
									if(_core::method( "_settings" , "logic" , "settings" , "blogging" , "likes" , "use" ) ){
										$resources = _core::method( '_resources' , 'get' );
										$customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $post -> ID );
										if( ( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] == 'yes' ) ){
											$nr_like = (int)_meta::get( $post -> ID , 'nr_like' );
								?>	
									<a href="javascript:void(0);" onclick="javascript:likes.vote( jQuery( this ) , <?php echo $post -> ID; ?> );"><?php echo $nr_like;?></a>
								<?php 	}
									} 
								?>
							</span>
						</h2>
                        <div class="excerpt">
                            <p><?php echo _core::method( '_tools' , 'excerpt' , $post -> ID , _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'archive' , 'timeline-excerpt' ) ); ?></p>
                        </div>
					</footer>
				</article>
            <?php
			if( $ajax ) exit;
        }


		public static function author_grid_view( $author_id ){
		?>
			<article class="item">           
				<div class="userdiv">
					<div class="user">    
						<a href="<?php echo get_author_posts_url( $author_id ); ?>">
							<?php echo cosmo_avatar( $author_id , 24 , DEFAULT_AVATAR ); ?>
							<p><?php echo get_the_author_meta( 'display_name' , $author_id ) ?></p>
						</a>
						<?php _core::method( '_follow' , 'get_follow_btn' , $author_id ); ?>
					</div>
				</div>                 
			</article>
		<?php
		}
	}
?>