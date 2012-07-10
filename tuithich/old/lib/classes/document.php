<?php
    class document{
        public static $dlimit = 160;
        public static $klimit = 10;
        
        public function head( $type = 'browser', $btype = 'Mozilla' ){
            _core::method( 'document' , 'type' , $type );
            
            echo '<head>' . "\n";
            ?><meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?> charset=<?php  bloginfo('charset'); ?>"/><?php echo "\n";
            _core::method( 'document' , 'title' , $type );
			
			if ( is_search() ) {
            	echo '<meta name="robots"  content="noindex, follow"/>' . "\n";
			}
			else
			{
				echo '<meta name="robots"  content="index, follow"/>' . "\n";
			}
            if( is_singular() ){
                global $post;
                $src  = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , array( 50 , 50 ) );
                
                echo "\n";
                
                ?><meta property="og:title" content="<?php the_title() ?>"/><?php echo "\n";
                ?><meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>"/><?php echo "\n";
                ?><meta property="og:url" content="<?php the_permalink() ?>"/><?php echo "\n";
                ?><meta property="og:type" content="article"/><?php echo "\n";
                ?><meta property="og:locale" content="en_US"/><?php echo "\n";
                ?><meta property="og:image" content="<?php echo $src[0]; ?>"/><?php echo "\n";
                ?><meta property="og:description" content="<?php echo _core::method( 'document' , 'description' ); ?>"/><?php echo "\n";
                
                $app_id = _core::method( '_settings' , 'get' , 'settings' , 'social' , 'facebook' , 'app_id' );
                
                if( !empty( $app_id) ){
                    ?><meta property="fb:app_id" content="<?php echo $app_id; ?>"/><?php echo "\n";
                }
                
                ?><link rel="image_src" href="<?php echo $src[0]; ?>"/><?php echo "\n\n";
                wp_reset_query();
            }else{
                
                echo "\n";
                
                ?><meta property="og:title" content="<?php echo get_bloginfo('name'); ?>"/><?php echo "\n"; 
                ?><meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>"/><?php echo "\n"; 
                ?><meta property="og:url" content="<?php echo home_url() ?>/"/><?php echo "\n";
                ?><meta property="og:type" content="blog"/><?php echo "\n";
                ?><meta property="og:locale" content="en_US"/><?php echo "\n";
                ?><meta property="og:image" content="<?php echo get_template_directory_uri()?>/screenshot.fb.png"/><?php echo "\n";
                ?><meta property="og:description" content="<?php echo _core::method( 'document' , 'description' ); ?>"/><?php echo "\n";
            }
            
            _core::method( 'document' , 'favicon' ); echo "\n";
            
            //echo '<meta name="description" content="' . _core::method( 'document' , 'description' ) . '">' . "\n";
            //echo '<meta name="keywords" content="' . _core::method( 'document' , 'keywords' ) . '" />' . "\n";
            
            _core::method( 'document' , 'style' );
            _core::method( 'document' , 'script' );
            
            echo '</head>' . "\n";
			flush();
        }
        
        public function type( $type , $btype = 'Mozilla' ){
            switch( $type ){
                case 'browser' : {
                    ?><!DOCTYPE HTML><?php echo "\n";
                    ?><html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> xmlns:fb="http://ogp.me/ns/fb#"><?php echo "\n";
                    break;
                }
                
                /* for mobile device */
                case 'device' : {
                    break;
                }
                
                /* for robots */
                default : {
                    
                    break;
                }
            }
        }
        
        public function title( $type ){
            switch( $type ){
                case 'browser' : {
                    echo '<title>';
                    if( is_home() || is_front_page() ){
                        bloginfo( 'name' );  echo ' - ';  bloginfo( 'description' ) ;
                    }else{
                        wp_title( null );
                        echo ' | ';
                        bloginfo( 'name' );
                    }
                    echo '</title>' . "\n";
                    break;
                }
                
                case 'device' : {
                    echo '<title>';
                    if( is_home() || is_front_page() ){
                        bloginfo( 'name' );  echo ' - ';  bloginfo( 'description' ) ;
                    }else{
                        wp_title( null );
                        echo ' | ';
                        bloginfo( 'name' );
                    }
                    echo '</title>' . "\n";
                    break;
                }
                
                default : {
                    echo '<title>';
                    if( is_home() || is_front_page() ){
                        echo  bloginfo( 'name' ) . ' - ' .  bloginfo( 'description' ) ;
                    }else{
                        wp_title( null );
                        echo ' ' . __( 'from' , _DEV_ ) . ' ' . bloginfo( 'name' );
                    }
                    echo '</title>' . "\n";
                    break;
                }
            }
        }
        
        public function description(){
            global $post;
            if( is_singular() ){
                if( !empty( $post -> post_excerpt ) ){
                    return mb_substr( strip_tags( strip_shortcodes( $post -> post_excerpt ) ) , 0 , self::$dlimit );
                }else{
                    return mb_substr( strip_tags( strip_shortcodes( $post -> post_excerpt ) ) , 0 , self::$dlimit );
                }
            }else{
                return _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'seo' , 'description' );
            }
        }
        
        public function keywords(){
            global $post;
            $result = array();
            
            if( is_singular() ){
                if( $post -> post_type == 'post' ){
                    return 'category and tags';
                }
                
                if( $post -> post_type == 'page' ){
                    return _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'seo' , 'keywords' );
                }else{
                    $customID = _resources::getCustomIdByPostType( $post -> post_type );
                    $resources = _core::method( '_resources' , '_get' );
                    if( isset( $resources[ $customID ][ 'taxonomy' ] ) && !empty( $resources[ $customID ][ 'taxonomy' ] ) ){
                        foreach(  $resources[ $customID ][ 'taxonomy' ] as $taxonomy ){
                            $terms = wp_get_post_terms( $post -> ID , $taxonomy[ 'slug' ] , array( "fields" => "all" ) );
                            foreach( $terms as $term ){
                                if( count( $result ) == 10 ){
                                    break;
                                }
                                $result[] = $term -> name;
                            }
                            
                            if( count( $result ) == 10 ){
                                break;
                            }
                        }
                        
                        if( !empty( $result ) ){
                            return implode( ',' , $result );
                        }else{
                            return _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'seo' , 'keywords' );
                        }
                    }else{
                        return _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'seo' , 'keywords' );
                    }
                }
            }else{
                return _core::method( '_settings' , 'get' , 'settings' , 'blogging' , 'seo' , 'keywords' );
            }
        }
        
        public function style( ){
            echo "\n";
            ?><link rel="profile" href="http://gmpg.org/xfn/11"/><?php echo "\n";
            ?><link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="all"/><?php echo "\n";
            
            ?>
            <?php
            if( is_singular() ){
                global $post;
                ?><link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/all.css.php?post=<?php echo $post -> ID; ?>" type="text/css" media="all"/><?php echo "\n\n";
            }else{
                ?><link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/all.css.php" type="text/css" media="all"/><?php echo "\n\n";
            }
            ?><!--[if IE 7]><?php echo "\n";
            ?><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/iehacks7.css" /><?php echo "\n";
            ?><![endif]--><?php echo "\n";
            
            ?><!--[if IE]><?php echo "\n";
            ?><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/iehacks.css" /><?php
            ?><![endif]--><?php echo "\n\n";
        }
        
        public function script(){
            echo "\n";
            wp_enqueue_script( "jquery" );
            wp_head();
            
            $type = _core::method( '_settings' , 'get' , 'settings' , 'front_page' , 'resource' , 'type' );
            
            if( is_singular() || $type == 'latest-post' || $type == 'selected-post' ){
                
                if( $type == 'selected-post' ){  
                    $postID = _core::method( '_settings' , 'get' , 'settings' , 'front_page' , 'resource' , 'post' );
                }
                
                if( $type == 'latest-post' ){
                    $query = new WP_Query( 
                        array(
                            'posts_per_page' => 1,
                            'orderby' => 'post_date',
                            'post_type' => 'post',
                            'post_status' => 'publish'
                        )
                    );

                    $postID = $query -> posts[0] -> ID;
                }
                
                if( is_singular() && !( is_home() || is_front_page() ) ){
                    global $post;
                    $postID = $post -> ID;
                }
                
                /* for reply comments */
                wp_enqueue_script( "comment-reply" );
                
                /* for google maps */
                if( _core::method( '_map' , 'markerExists' , $postID  ) ){
                    ?><script src="http://maps.googleapis.com/maps/api/js?sensor=true" type="text/javascript"></script><?php echo "\n";
                }
                ?><script src="<?php echo get_template_directory_uri() ?>/js/all.js.php?post=<?php echo $postID; ?>" type="text/javascript"></script><?php echo "\n";
            }else{
                ?><script src="<?php echo get_template_directory_uri() ?>/js/all.js.php" type="text/javascript"></script><?php echo "\n";
            }
            
            
            ?>
			<?php if(is_user_logged_in() || is_singular() ) { ?>
			<script src="http://connect.facebook.net/en_US/all.js#xfbml=1" type="text/javascript" id="fb_script"></script>
			<?php } ?>
			<?php echo "\n";
            
            ?><!--[if lt IE 9]><?php echo "\n";
            ?><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><?php echo "\n";
            ?><![endif]--><?php echo "\n\n";
        }
        
        public function favicon(){
            $favicon = _core::method( "_settings" , "get" , "settings" , "style" , "general" , "favicon" );
            if( strlen( $favicon ) ){
                ?><link rel="shortcut icon" href="<?php echo $favicon ?>" /><?php echo "\n";
            }else{
                ?><link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico"/><?php echo "\n";
            }
        }
        
        public function close(){
            ?>
                <script type="text/javascript">
                    (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })();
                </script>
                
                </body>
                </html>
            <?php
        }
    }
?>