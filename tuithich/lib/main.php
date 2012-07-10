<?php
    function cosmo__autoload( $class_name ){
	
        /* load widget class */
        if( substr( $class_name , 0 , 6 ) == 'widget'){
            /* widget_[ class-name ] > class-name > class_name */
            $class_name = str_replace( '-' , '_' , str_replace( 'widget_' , '' ,  $class_name ) );
			
            if( is_file( get_template_directory() . '/lib/widget/' . $class_name . '.php' ) ){
                include_once get_template_directory() . '/lib/widget/' . $class_name . '.php';
            }
        }
        /* load core class */
        if( substr( $class_name , 0 , 1 ) == '_'){
            /* core_[ class-name ] > class-name > class_name */
            $class_name = str_replace( '_' , '-' , substr(  $class_name , 1 , strlen( $class_name ) ) );
            if( is_file( get_template_directory() . '/lib/core/' . $class_name . '.php' ) ){

                include_once get_template_directory() . '/lib/core/' . $class_name . '.php';

                /* load additional functions */
                if( is_file( get_template_directory() . '/lib/load/' . $class_name . '.php' ) ){
                    include_once get_template_directory() . '/lib/load/' . $class_name . '.php';
                }

                if( is_file( get_template_directory() . '/lib/setup/' . $class_name . '.php' ) ){
                    include_once get_template_directory() . '/lib/setup/' . $class_name . '.php';
                }
            } 
        }
        
        /* load classes class */
        $class_name = str_replace( '_' , '-' , $class_name );
		if( is_file( get_template_directory() . '/lib/classes/' . $class_name . '.php' ) ){
			include_once get_template_directory() . '/lib/classes/' . $class_name . '.php';
            /* load setup */
            if( is_file( get_template_directory() . '/lib/setup/' . $class_name . '.php' ) ){
				include_once get_template_directory() . '/lib/setup/' . $class_name . '.php';
			}
		}
    }

    spl_autoload_register( "cosmo__autoload" ); 

	
	include_once get_template_directory() . '/lib/actions.php';
    include_once get_template_directory() . '/lib/setup/menu.php';

	include_once get_template_directory(). '/lib/core/audio-player.php';
	
	function menu( $id ,  $args = array() , $flag = false ){
        
        $menu = new _menu( $args );

        $vargs = array(
            'menu'            => '',
            'container'       => '',
            'container_class' => '',
            'container_id'    => '',
            'menu_class'      => isset( $args['class'] ) ? $args['class'] : '',
            'menu_id'         => '',
            'echo'            => false,
            'fallback_cb'     => '',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'depth'           => 0,
            'walker'          => $menu,
            'theme_location'  => $id ,
        );

        $result = wp_nav_menu( $vargs );
        
        if( $flag ){
            if( empty( $result ) ){
                return '';
            }
        }

        if(!$result){
            $result = $menu -> get_terms_menu();
        }

        if( $menu -> need_more ){
            $result .="</li></ul>".$menu -> aftersubm ;
        }

        return $result;
    }
	
	function de_excerpt( $excerpt , $content , $length = 0 ){

        if( strlen( $excerpt) ){
			$result  = $excerpt ;
            
        }else{
            $content = trim( strip_shortcodes( $content ) );

            if( strlen( $content ) > strlen( strip_shortcodes( $content ) ) ){
                $length = ( $length == 0 ) ? strlen( $content ) : $length;
                $content = de_excerpt('', $content , $length );
            }

            $content = strip_tags( $content );
            $length = ( $length == 0 ) ? strlen( $content ) : $length;
            
            if( strlen( $content ) > $length ){
                $result  = mb_substr( $content , 0 , $length , 'UTF-8');
                $result .= '[...]';
            }else{
                $result  = $content;
            }
        }

        return $result;
    }
	
	function get__pages( $first_label = 'Select item' ){
        $pages = get_pages();
        $result = array();
        if( is_array( $first_label ) ){
            $result = $first_label;
        }else{
            if( strlen( $first_label ) ){
                $result[] = $first_label;
            }
        }
        foreach($pages as $page){
            $result[ $page -> ID ] = $page -> post_title;
        }

        return $result;
    }
    
    function cosmo_avatar( $user_info, $size, $default = DEFAULT_AVATAR ) {
		
		$avatar = '';
        if( is_numeric( $user_info ) ){
            if( get_user_meta( $user_info , 'custom_avatar' , true ) == -1 ){
                $avatar = '<img src="' . $default . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
            }else{
                if(  get_user_meta( $user_info , 'custom_avatar' , true ) > 0 ){
                    $cusom_avatar = wp_get_attachment_image_src( get_user_meta( $user_info , 'custom_avatar' , true ) , array( $size , $size ) );
                    $avatar = '<img src="' . $cusom_avatar[0] . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
                }else{
                    $avatar = get_avatar( $user_info , $size , $default );
                }
            }
            
        }else{
            if( is_object( $user_info ) ){
                if( isset( $user_info -> user_id ) && is_numeric( $user_info -> user_id ) && $user_info -> user_id > 0 ){
                    if( get_user_meta( $user_info -> user_id , 'custom_avatar' , true ) == -1 ){
                        $avatar = '<img src="' . $default . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
                    }else{
                        if( get_user_meta( $user_info -> user_id , 'custom_avatar' , true ) > 0 ){
                            $cusom_avatar = wp_get_attachment_image_src( get_user_meta( $user_info -> user_id , 'custom_avatar' , true ) , array( $size , $size ) );
                            if( isset( $cusom_avatar[0] ) ){
                                $avatar = '<img src="' . $cusom_avatar[0] . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
                            }else{
                                $avatar = get_avatar( $user_info , $size , $default );
                            }
                        }else{
                            $avatar = get_avatar( $user_info , $size , $default );
                        }
                    }
                }else{
                    $avatar = get_avatar( $user_info , $size , $default );
                }
            }else{
                $avatar = get_avatar( $user_info , $size , $default );
            }
        }
		
        return $avatar;
	}
    
    function de_remove_wpautop( $content ) {
        $content = do_shortcode( shortcode_unautop( $content ) );
        $content = preg_replace('#^<\/p>|^<br \/>|^<br>|<p>$#', '', $content);
        return $content;
    }
	
	function de_post_gallery( $output, $attr) {
	    global $post, $wp_locale;

	    static $instance = 0;
	    $instance++;

	    if ( isset( $attr['orderby'] ) ) {
	        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
	        if ( !$attr['orderby'] )
	            unset( $attr['orderby'] );
	    }
		
		if ( isset( $attr['columns'] ) ) {
	        switch (intval($attr['columns'])) {
		    	case 1:
		    		$size='tmedium';
		    		$box_width = '620px';
		    	break;
		    	case 2:
		    		$size='tmedium_gallery';
		    		$box_width = '460px';
		    	break;
		    	case 4:
		    		$size='tgallery';
		    		$box_width = '220px';
		    	break;
		    	default:
		    		$size='tgrid';
		    		$box_width = '300px';
		    	break;
		    }
	    }else{
	    	$size='tgrid';
	    	$box_width = '300px';
	    }	
  
	    extract(shortcode_atts(array(
	        'order'      => 'ASC',
	        'orderby'    => 'menu_order ID',
	        'id'         => $post->ID,
	        'itemtag'    => 'dl',
	        'icontag'    => 'dt',
	        'captiontag' => 'dd',
	        'columns'    => 3,
	        'size'       => $size,
	        'include'    => '',
	        'exclude'    => ''
	    ), $attr));

	    $id = intval($id);
	    if ( 'RAND' == $order )
	        $orderby = 'none';

	    if ( !empty($include) ) {
	        $include = preg_replace( '/[^0-9,]+/', '', $include );
	        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

	        $attachments = array();
	        foreach ( $_attachments as $key => $val ) {
	            $attachments[$val->ID] = $_attachments[$key];
	        }
	    } elseif ( !empty($exclude) ) {
	        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
	        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	    } else {
	        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	    }

	    if ( empty($attachments) )
	        return '';

	    if ( is_feed() ) {
	        $output = "\n";
	        foreach ( $attachments as $att_id => $attachment )
	            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
	        return $output;
	    }

	    $itemtag = tag_escape($itemtag);
	    $captiontag = tag_escape($captiontag);
	    $columns = intval($columns);
	    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	    $float = is_rtl() ? 'right' : 'left';

	    $selector = "gallery-{$instance}";

	    $output = apply_filters('gallery_style', "
	        <style type='text/css'>
	            #{$selector} {
	                margin: auto;
	            }
	            #{$selector} .gallery-item {
	                float: {$float};
	                margin-top: 10px;
	                text-align: center;
	                         }
	            #{$selector} img {
	                /*border: 2px solid #cfcfcf;*/
	            }
	            #{$selector} .gallery-caption {
	                margin-left: 0;
	            }
	        </style>
	        <!-- see gallery_shortcode() in wp-includes/media.php -->
	        <div id='$selector' class='gallery galleryid-{$id} colls-{$columns}'>");

	    $i = 0;
		$rand_id = mt_rand(1,1000);
	    foreach ( $attachments as $id => $attachment ) {
			$image_attributes = wp_get_attachment_image_src( $id,'large' );

			$link = isset($attr['link']) && 'file' == $attr['link'] ? '<a href="'.$image_attributes[0].'"  rel="prettyPhoto[pp_'.$rand_id.']"><span class="mosaic-overlay"></span>'.wp_get_attachment_image($id, $size, false).'</a>' : '<a href="'.$image_attributes[0].'"  rel="prettyPhoto[pp_'.$rand_id.']"><span class="mosaic-overlay"></span>'.wp_get_attachment_image($id, $size, false).'</a>';
	        $output .= "<{$itemtag} class='gallery-item'>";
	        $output .= "
	            <{$icontag} class='gallery-icon'>
	                $link
	            </{$icontag}>";
	        if ( $captiontag && trim($attachment->post_title) ) {
	            $output .= "
	                <{$captiontag} class='gallery-caption'>
	                " .wp_get_attachment_link($id, $size, true, false, wptexturize($attachment->post_title))  . "
	                </{$captiontag}>";
	        }
	        $output .= "</{$itemtag}>";
	        /*if ( $columns > 0 && ++$i % $columns == 0 )
	            $output .= '<br style="clear: both" />';*/
	    }

	    $output .= "</div>\n";

	    return $output;
	}
?>