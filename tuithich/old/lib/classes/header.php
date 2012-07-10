<?php
    class header{
        public function main(){
				
				if ( defined('IS_FOR_DEMO' ) && !is_user_logged_in()  
					&& (!is_page() || (is_page() && get_the_ID() != _core::method( "_settings" , "get" , "settings" ,"general" , "theme" , "login-page" )) )
				){ ?>
					<div id="lightbox-shadow" onclick="javascript:close_dl();"></div>
					<div id="demo-container">
						<h2>Sign in to FacePress</h2>
						<?php wp_login_form(  ); ?> 
						
						<p class="hint">
							<?php _e( 'Use the following credentials: demo / demo' , _DEV_ ); ?>
						</p>
						
					</div>

				<?php } 
                
                    if( is_home() || is_front_page() ){
                        $h_classes = 'mb40';
                    }else{
                        if( !(_core::method("_settings","logic","settings","general","theme","show-breadcrumbs") && ( !is_front_page() || isset( $_GET[ 'fp_type' ] ) ) ) ) {
                            $h_classes = 'mb40';
                        }else{
                            $h_classes = '';
                        }
                    }   
                ?>
                    
                <section class="b_head clearfix <?php echo $h_classes; ?>" id="header">
                    <div class="header-wrapper">
                        <div class="b_page clearfix">
                            <div class="branding">
                            
                                <?php /* logo */ ?>
                                <?php _core::method( 'header' , 'logo' ); ?>
                            
                                <?php /* menu */ ?>
                                <?php _core::method( 'header' , 'menu' ); ?>
                            
                                <?php /* login menu */ ?>
                                <?php get_template_part( 'templates/login' ); ?>
                            </div>
                        </div>
                        
                        <div class="header-stripe"></div>
                    </div>
                    
                    <?php
						/*tooltips*/
						_core::method( 'header' , 'tooltips' );
                    ?>
                </section>
            <?php
            
                /* welcome message */
                if( is_front_page() || is_home() ){
                    _core::method( 'header' , 'welcome' );
                }
                
                /* breadcrumps */
                _core::method( 'header' , 'breadcrumps' );
                
                /* advertising zone */
                $ad = _core::method( '_settings' , 'get' , 'settings' , 'ads' , 'general' , 'first' );
                if( strlen( $ad ) > 0 ){
                    echo '<div class="b_page">';
                    echo '<div class="cosmo-ads zone-1">';
                    echo $ad;
                    echo '</div>';
                    echo '</div>';
                }
		}
        
		public function tooltips(){
			global $post;
			$tooltips = get_option( _TLTP_ );
			if( is_array( $tooltips ) && !empty( $tooltips ) ){
				$tools = array();
				foreach( $tooltips as $key => $tooltip ){
					if( is_front_page()  && $tooltip['res_type'] == 'front_page' ){
						if( defined('IS_FOR_DEMO') ){
							if( is_user_logged_in() ){
								if( $tooltip['title'] != 'Login form for members' ){
									$location = 'front_page';
									$id = 0;
									$tools[] = $tooltip;
								}
							}else{
								$location = 'front_page';
								$id = 0;
								$tools[] = $tooltip;
							}
						}else{
							$location = 'front_page';
							$id = 0;
							$tools[] = $tooltip;
						}
					}
					
					if( is_single() && isset( $tooltip['res_type'] ) && $tooltip['res_type'] == 'single' && isset( $tooltip['res_posts'] ) && $tooltip['res_posts'] == $post -> ID ){
						$location = 'single';
						$id = $post -> ID ;
						$tools[] = $tooltip;
					}
					
					if( is_page() && isset( $tooltip['res_type'] ) && $tooltip['res_type'] == 'page' && isset( $tooltip['res_page'] ) && $tooltip['res_page'] == $post -> ID ){
						$location = 'page';
						$id = $post -> ID ;
						$tools[] = $tooltip;
					}
				}
				
				if( isset( $location ) ){
					if( ( isset( $_COOKIE[ ZIP_NAME . '_tour_closed_' . $location . '_' . $id ] ) && $_COOKIE[ ZIP_NAME . '_tour_closed_' . $location . '_' . $id ] != 'true' ) || !isset( $_COOKIE[ ZIP_NAME . '_tour_closed_' . $location . '_' . $id ] ) ){
						foreach( $tools as $key => $tool ){
							if( $key + 1 == count( $tools ) ){
								_core::method( '_tools' , 'tour' , array( $tool['top'] , $tool['left'] ) , $location , $id , $tool['type'] , $tool['title'] , $tool['description'] , ( $key + 1 ) . '/' . count( $tools ) , false );
							}else{
								_core::method( '_tools' , 'tour' , array( $tool['top'] , $tool['left'] ) , $location , $id , $tool['type'] , $tool['title'] , $tool['description'] , ( $key + 1 ) . '/' . count( $tools ) );
							}
						}
					}
				}
			}
		}
        
        public function logo(){
            ?>  
                <div class="logo w_210"> 
                    <?php
                        if( _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'logo_type' ) == 'text' ){
                            echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'general' , 'logo_text' , 'link_text' , array( home_url() , get_option( 'blogname' ) ) , 'h1' );
                        }else{
                            $logo = _core::method( '_settings' , 'get' , 'settings' , 'style' , 'general' , 'logo_upload' );
                            if( strlen( $logo ) ){
                                ?><h1><a href="<?php echo home_url(); ?>" class="hover"><img src="<?php echo $logo; ?>" /></a></h1><?php    
                            }else{
								if(_core::method( 'layout' , 'style' ) == 'day'){
									?><h1><a href="<?php echo home_url(); ?>" class="hover"><img src="<?php echo get_template_directory_uri();?>/images/logo.png"/></a></h1><?php
								}else{
									?><h1><a href="<?php echo home_url(); ?>" class="hover"><img src="<?php echo get_template_directory_uri();?>/images/logo.white.png"/></a></h1><?php
								}
                            }
                        }
                    ?>
                </div>
            <?php
        }
        
        public function welcome(){
            if( _core::method( '_settings' , 'logic' , 'settings' , 'front_page' , 'resource' , 'welcome' ) ){
                
                $description = _core::method( '_settings' , 'get' , 'settings' , 'front_page' , 'resource' , 'welcome-description' );

                if( !empty( $description ) && ( !isset( $_COOKIE[ ZIP_NAME . "tooltip" ] ) || ( isset( $_COOKIE[ ZIP_NAME . "tooltip" ] ) && $_COOKIE[ ZIP_NAME . "tooltip" ] != 'closed' ) ) ){
                    ?>
                        <section class="b_page">
                            <div id="hide-this">
                                <div class="message">
                                    <a href="#hide-this" rel="nofollow" style="float:right;cursor:pointer" class="close" ><?php _e( 'close me' , _DEV_ ); ?></a>
                                    <p><?php echo $description; ?></p>
                                </div>
                            </div>
                            <p class="delimiter hidden">&nbsp;</p>
                        </section>
                    <?php
                }
            }
        }
        
        public function menu(){
            $header = _core::method( '_settings' , 'get' , 'settings' , 'menus' , 'menus' , 'header' );
            $menu = menu( 'header' , array( 'class' => 'sf-menu' , 'current-class' => 'active' , 'number-items' => $header ) );

            if( !empty( $menu ) ){
                ?>
                    <div class="text-menu w_530 p z-index">
                        <?php echo $menu; ?>
                    </div>
                <?php
            }
        }
        
        public function breadcrumps(){
            if( _core::method("_settings","logic","settings","general","theme","show-breadcrumbs") && ( !is_front_page() || isset( $_GET[ 'fp_type' ] ) ) ){
                echo '<div class="b_page breadcrumbs">';
				echo '<div class="breadcrumbs">';
                echo '<ul>';
                _core::method("post","dimox_breadcrumbs");
                echo '</ul>';
				echo '</div>';
                echo '</div>';
            }
        }
    }
?>