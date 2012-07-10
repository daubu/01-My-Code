<?php
    class footer{
        public function main(){
            ?>
                <section id="colophon" role="contentinfo" class="b_body_f clearfix">
                    <section class="b_f_c">
                        <div class="footer-area">
                            
                            <?php
                                ob_start(); ob_clean();
                                get_sidebar( 'footer-main' );
                                $sidebar = ob_get_clean();
                                if( strlen( $sidebar ) ){
                                    ?>
                                        <div class="b_page clearfix ">
											<p class="delimiter"></p>
                                            <?php echo $sidebar ?>
                                        </div>
                                    <?php
                                }
                            ?>
                            
                            <?php /* copyright */ ?>
                            <div class="b_page clearfix">
								<p class="delimiter"></p>
                                <div class="footer-menu">
									<?php
                                        $footer = _core::method( '_settings' , 'get' , 'settings' , 'menus' , 'menus' , 'footer' );
                                        echo menu( 'footer' , array( 'class' => 'footer-menu' , 'current-class' => 'active' , 'more-label' => '' , 'more-class' => 'no_bg' , 'number-items' => $footer + 1 ) );
                                    ?>
                                </div>
								<div class="copyright">
                                    <?php
                                        $footer_logo = _core::method( '_settings' , 'get' , 'settings' , 'general' , 'theme' , 'footer-logo' );
                                        if( !empty( $footer_logo ) ){
                                            ?><img src="<?php echo $footer_logo; ?>" class="copyright" alt=""><?php
                                        }
                                    ?>
                                    <p class="copyright"><?php echo str_replace( '%year%' , date('Y') , _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "copyright" ) );?></p>        
                                </div>
                                <div class="widget">
                                <div class="social-media blue"><ul><li class="fb"><a class="hover" href="http://facebook.com/people/@/tuithichvn">Facebook</a></li><li class="flickr"><a class="hover" href="http://www.flickr.com/groups/tuithichvn/">Flickr</a></li><li class="linked"><a class="hover" href="http://blog.tuithich.vn">blog.tuithich.vn</a></li><li class="twitter"><a class="hover" href="http://twitter.com/#!/tuithichvn">twitter</a></li><li class="email"><a class="hover" href="mailto:info@tuithich.vn">Email</a></li><li class="rss"><a class="hover" href="http://www.tuithich.vn/feed">RSS</a></li></ul></div>
                                </div>
                            </div>
                        </div>
                        
                    </section>
                </section>

                <?php
                    wp_footer();
                    echo _core::method( "_settings" , "get" , "settings" , "general" , "theme" , "code" );
                ?>
                
                <div id="toTop">
                    <div class="inner">
                        <p><span><?php _e( 'Back' , _DEV_ ); ?></span><span><?php _e( 'to top' , _DEV_ ); ?></span></p>
                    </div>
                </div>
                
                <?php if( _core::method( '_settings' , 'logic' , 'settings' , 'style' , 'general' , 'switcher' ) ) : ?>

                    <?php if( _core::method( 'layout' , 'style' )  == 'night' ) : ?>

                        <?php $classes = 'night'; ?>
                        <?php $label = __( 'Night mode' , _DEV_ ); ?>                        

                    <?php else : ?>

                        <?php $classes = 'day'; ?>
                        <?php $label = __( 'Day mode' , _DEV_ ); ?>

                    <?php endif; ?>

                    <?php /* switcher */ ?>
                    <div class="style_switcher">
                        <div class="show_colors fr"></div>
                        <div>
							
                            <p class="day_night"><?php _e('Use day/night mode:',_DEV_); ?><span class="<?php echo $classes; ?>"><?php echo $label; ?></span> </p>
							<br />
							<p></p>
							<form>
							<label>
								<input name="darkheader" type="checkbox" value="darkheader" tabindex="90">
								<?php _e('dark header',_DEV_); ?>
							</label>
							</form>
                        </div>
                    </div>

                <?php endif; ?>
            <?php
        }
    }
?>