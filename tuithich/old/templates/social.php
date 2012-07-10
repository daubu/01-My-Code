<?php if( _core::method( 'post_settings' , 'useSocial' , $post -> ID ) ) : ?>

    <div class="share">
   
        <a  href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink( $post -> ID ); ?>&media=<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>&description=<?php echo get_the_title($post -> ID); ?> " class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
        
        
        <g:plusone size="medium"  href="<?php echo get_permalink( $post -> ID ); ?>"></g:plusone>
        <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode( get_permalink( $post -> ID ) ); ?>&amp;layout=button_count&amp;show_faces=false&amp;&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" height="20" width="109"></iframe>
        
        <span id="tumblr_button_abc123"></span>
                    
            <!-- Set these variables wherever convenient -->
            <script type="text/javascript">
                var tumblr_photo_source = "<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>";
                var tumblr_photo_caption = "<a href='<?php echo get_permalink( $post -> ID ); ?>'><?php echo get_the_title($post -> ID); ?></a>      ";
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