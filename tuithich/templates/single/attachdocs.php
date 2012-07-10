<?php if( _core::method( 'post_settings' , 'useAttachdocs' , $post -> ID ) ) : $attachdocs = _core::method( '_meta' , 'get' , $post -> ID , 'attachdocs' ); ?>

    <table class="demo-download">
        <tbody>

            <?php foreach( $attachdocs as $key => $value ) : ?>
                <?php if( isset( $value[ 'demo' ] ) && !empty( $value[ 'demo' ] ) && ( empty( $value[ 'url' ] ) || !isset( $value[ 'url' ] ) ) ) : ?>

                    <tr>
                        <td colspan="2" class="demo-link">
                            <p class="demo-link-title"><a href="<?php echo $value[ 'demo' ]; ?>"><?php _e( 'Demo' , _DEV_ ); ?></a></p>
                        </td>
                    </tr>

                <?php else : ?>

                    <?php if( isset( $value[ 'url' ] ) && !empty( $value[ 'url' ] ) && ( empty( $value[ 'demo' ] ) || !isset( $value[ 'demo' ] ) ) ) : ?>

                        <tr>
                            <td colspan="2" class="attach">
                                <p class="attach-title"><a href="<?php echo $value[ 'url' ]; ?>"><?php _e( 'Download' , _DEV_ ); ?></a></p>
                            </td>
                        </tr>

                    <?php else : ?>

                        <?php if( !empty( $value ) && is_array( $value ) && isset( $value[ 'url' ] ) && isset( $value[ 'demo' ] ) ) : ?>

                            <tr>
                                <td class="demo-link">
                                    <p class="demo-link-title"><a href="<?php echo $value[ 'demo' ]; ?>"><?php _e( 'Demo' , _DEV_ ); ?></a></p>
                                </td>
                                <td class="attach">
                                    <p class="attach-title"><a href="<?php echo $value[ 'url' ]; ?>"><?php _e( 'Download' , _DEV_ ); ?></a></p>
                                </td>
                            </tr>

                        <?php endif; ?>

                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>

        </tbody>
    </table>

<?php endif; ?>