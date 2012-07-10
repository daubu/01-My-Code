<?php if( _core::method( 'post_settings' , 'useSocial' , $post -> ID ) ) : ?>

    <div class="share-post">
    
        <div class="fb-like share-item" data-href="<?php echo urlencode( get_permalink( $post -> ID ) ); ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
        <div class="share-item"><g:plusone size="medium"  href="<?php echo get_permalink( $post -> ID ); ?>"></g:plusone></div>
        <div class="share-item">
        <a  href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink( $post -> ID ); ?>&media=<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>&description=<?php echo get_the_title($post -> ID); ?> " class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
        </div>
		
		<div class="share-item share-tumblr"><span id="tumblr_button_abc123"></span></div>
        <div class="share-item"><a href="http://linkhay.com/submit?link_url=<?php echo get_permalink( $post -> ID ); ?>&link_title=<?php echo get_the_title($post -> ID); ?>" target="_blank"><img src="http://linkhay.com/templates/images/guide/button4.jpg" alt="" /></a></div>     
            <!-- Set these variables wherever convenient -->
            <script type="text/javascript">
                var tumblr_photo_source = "<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>";
                var tumblr_photo_caption = "<a href='<?php echo get_permalink( $post -> ID ); ?>'><?php echo get_the_title($post -> ID); ?> | Tuithich.vn</a>";
                var tumblr_photo_click_thru = "<?php echo get_permalink( $post -> ID ); ?>";
            </script>
            
            <!-- Put this code at the bottom of your page -->
            <script type="text/javascript">
                var tumblr_button = document.createElement("a");
                tumblr_button.setAttribute("href", "http://www.tumblr.com/share/photo?source=" + encodeURIComponent(tumblr_photo_source) + "&caption=" + encodeURIComponent(tumblr_photo_caption) + "&clickthru=" + encodeURIComponent(tumblr_photo_click_thru));
				tumblr_button.setAttribute("target", "_blank");
                tumblr_button.setAttribute("title", "Share on Tumblr");
                tumblr_button.setAttribute("style", "display:inline-block; text-indent:-9999px; overflow:hidden; width:81px; height:20px; background:url('http://platform.tumblr.com/v1/share_1.png') top left no-repeat transparent;");
                tumblr_button.innerHTML = "Share on Tumblr";
                document.getElementById("tumblr_button_abc123").appendChild(tumblr_button);
            </script>
            
            
        <?php /* hook for additional social items */ ?>    
        <?php _core::hook( 'social' ); ?>
            
    </div>        

<?php endif; ?>