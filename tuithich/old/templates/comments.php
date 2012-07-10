<?php if( comments_open() ) : ?>

    <p class="delimiter blank">&nbsp;</p>
    
    <?php if( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'fb-comments' ) ) : ?>

        <?php /* FaceBook comments */ ?>

        <div id="comments">
        <h3 id="reply-title"><?php _e( 'Leave a reply' , _DEV_ ); ?></h3>
        <p class="delimiter">&nbsp;</p>
        <fb:comments href="<?php echo get_permalink( $post -> ID ); ?>" num_posts="5" width="<?php echo _core::method( 'layout' , 'singularLn' , $post -> ID ); ?>" height="120" reverse="true"></fb:comments>
        </div>

    <?php else : ?>

        <?php /* WordPress comments */ ?>

        <?php comments_template( '', true ); ?>

    <?php endif; ?>

<?php endif; ?>
