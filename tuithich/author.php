<?php wp_enqueue_script( 'author' , get_template_directory_uri().'/js/author.js' ); ?>
<?php get_header(); ?>
<section class="b_content clearfix" id="main">
    <div class="b_page">
        <?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'enb_follow' ) ){ ?>

				
				<?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'author' ); wp_reset_query(); ?>
				
				<section id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'author' ); ?>>
					<div id="content" role="main">
                        
						<div class="content-title  fl">
							<div class="title author">
								<h1 class="entry-title">
									<?php 
											$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
											$author_id = $curauth -> ID;
									?>
									<?php echo cosmo_avatar( $author_id , 75 , DEFAULT_AVATAR ); ?>
									<span class="author"><?php echo get_the_author_meta( 'display_name' , $author_id ) ?></span>
								</h1>
								<div class="entry-meta">
									<ul>
										<?php 
											$aclass = 'no_btn';
											if( have_posts() && $author_id != get_current_user_id() ){
											_core::method( '_follow' , 'get_big_follow_btn' , $author_id );
											$aclass = '';
										}?>
										<li class="followes <?php echo $aclass; ?>">
											<a href="#tabber_followers" onclick="javascript:jQuery( '#followers_menu_item' ).click();">
												<strong><?php echo count( _core::method( '_follow' , 'get_followers' , $author_id ) ); ?></strong>
												<span><?php if( count( _core::method( '_follow' , 'get_followers' , $author_id ) ) == 1){
																_e( 'follower' , _DEV_ );
															}else{
																_e( 'followers' , _DEV_ );
															} 
													?>
												</span>
											</a>
										</li>
										<li class="following">
											<a href="#tabber_following" onclick="javascript:jQuery( '#following_menu_item' ).click();">
												<strong><?php echo count( _core::method( '_follow' , 'get_following' , $author_id ) ); ?></strong>
												<span><?php echo __( 'following' , _DEV_ ); ?></span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
                        
						<div class="content_tabber">
							<ul class="content_tabber sf-menu sf-js-enabled sf-shadow">
								<li class="active">
									<a id="timeline_menu_item" href="#tabber_timeline">
									
										<?php
											if( $author_id == get_current_user_id() ){
												echo __( 'Timeline' , _DEV_ );
											}else{
												echo __( "Author's Timeline" , _DEV_ );
											}
										?>	
									</a>
								</li>
								<li>
									<a id="posts_menu_item" href="#tabber_posts"><?php _e("Posts",_DEV_); ?></a>
								</li>
								<li class="signin dropdown">
									<a id="voted_menu_item" href="#tabber_voted">
										<?php
											if( $author_id == get_current_user_id() ){
												echo __( 'My favorites' , _DEV_ );
											}else{
												echo __( "Favorites" , _DEV_ );
											}
										?>
									</a>
									<!--<ul style="display:none">-->
										<?php //echo _core::method( 'post' , 'write_inheritance_menus' , $author_id );?>
									<!--</ul>-->
								</li>
								<li>
									<a id="followers_menu_item" href="#tabber_followers"><?php _e( "Followers" , _DEV_ ); ?></a>
								</li>
								<li>
									<a id="following_menu_item" href="#tabber_following"><?php _e( "Following" , _DEV_ ); ?> </a>
								</li>
							</ul>
							
								<div id="tabber_timeline_panel" class="loop-container-view tab_content tabs-container">
									<div class="timeline">
										<div class="grid-view">
											<div class="firstdiv"></div>
											<div class="timeline_bg"><div></div></div>
											<div class="seconddiv"></div>
										</div>
										<div class="purgatory" style="visibility:hidden">
										</div>
									</div>
								</div>
							<div id="tabber_posts_panel" class="loop-container-view tab_content tabs-container" style="display:none">
							<?php if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ) : ?>
							
								<div class="masonry-container">
									<div class="grid-view author-posts-container">
								
							<?php else : ?>
										
								<div class="element last">
									<div class="list-view author-posts-container">
							
							<?php endif;
									if( isset( $_POST[ 'action' ] ) ){
										unset( $_POST[ 'action' ] );
									}
							?>
									</div>
								</div>
							</div>
							<div id="tabber_voted_panel" class="loop-container-view tab_content tabs-container" style="display:none">
								<?php if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ) : ?>
								
									<div class="masonry-container">
										<div class="grid-view author-posts-container">
									
								<?php else : ?>
											
									<div class="element last">
										<div class="list-view author-posts-container">
								
								<?php endif;
									if( isset( $_POST[ 'action' ] ) ){
										unset( $_POST[ 'action' ] );
									}
									$resources = _core::method( '_resources' , 'get' );
									foreach($resources as $index=>$resource){
										if($resource['stitle']=='Post'){
											$stdPostsCustomID=$index;
										}
									}
									?>
									</div>
								</div>
							</div>
							<div id="tabber_followers_panel" class="loop-container-view tab_content tabs-container" style="display:none">
								<?php if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ) : ?>
								
									<div class="masonry-container">
										<div class="grid-view author-posts-container">
									
								<?php else : ?>
											
									<div class="element last">
										<div class="list-view author-posts-container">
								
								<?php endif;
									$_POST[ 'action' ] = 'get_author_followers';
									?>
									</div>
								</div>
							</div>
							<div id="tabber_following_panel" class="loop-container-view tab_content tabs-container" style="display:none">
							<?php if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ) : ?>
							
								<div class="masonry-container">
									<div class="grid-view author-posts-container">
								
							<?php else : ?>
										
								<div class="element last">
									<div class="list-view author-posts-container">
							
							<?php endif;
									$_POST[ 'action' ] = 'get_author_following';
									
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>    
        <?php }else{ ?>
				<div class="content-title">
					<div class="title author">
						<h1 class="entry-title">
							<?php 
									$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
									$author_id = $curauth -> ID;
							?>
							<?php echo cosmo_avatar( $author_id , 75 , DEFAULT_AVATAR ); ?>
							<span class="author"><?php echo get_the_author_meta( 'display_name' , $author_id ) ?></span>
						</h1>
					</div>
				</div>
				
				 <?php _core::method( 'layout' , 'archiveSidebar' , 'left' , 'author' ); wp_reset_query(); ?>
				
				<div id="primary" <?php _core::method( 'layout' , 'archiveClasses' , 'author' ); ?>>
					<div id="content" role="main">
						<?php
							if( _core::method( 'post_settings' , 'useGrid' , 'author' ) ){
								?><div id="container"><div class="grid-view"><?php
							}else{
								?><div id="element last"><div class="list-view"><?php
							}
							
							_core::method( 'post' , 'loop' , 'author' );
							
							?></div></div><?php
							
							get_template_part( 'templates/pagination' );
						?>
					</div>
				</div>   
		<?php } ?>
       <?php _core::method( 'layout' , 'archiveSidebar' , 'right' , 'author' ); wp_reset_query(); ?>
        
    </div>
</section>
<script>
	jQuery( function(){
	if( !( document.location.hash.length && document.location.hash.length > 5 ) ){
		author.get_timeline( <?php echo $author_id; ?> , 1 );
	}
		jQuery( '#posts_menu_item' ).click(function(){
			if( jQuery( '#tabber_posts_panel article' ).length == 0 ){
				author.get_posts( <?php echo $author_id;?> , 1 );
			}
		});

		jQuery( '#voted_menu_item' ).click(function(){
			if( jQuery( '#tabber_voted_panel article' ).length == 0 ){
				likes.my( <?php echo $author_id;?> ,  0 , [] , '<?php echo $stdPostsCustomID;?>' , false, true ); 
			}
		});

		jQuery( '#followers_menu_item' ).click(function(){
			if( jQuery( '#tabber_followers_panel article' ).length == 0 ){
				author.get_followers( <?php echo $author_id;?> );
			}
		});

		jQuery( '#following_menu_item' ).click(function(){
			if( jQuery( '#tabber_following_panel article' ).length == 0 ){
				author.get_following( <?php echo $author_id;?> );
			}
		});
	});
</script>
<?php get_footer(); ?>