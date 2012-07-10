<?php 
    if( _core::method( '_likes' , 'useLikes' , $post -> ID ) ) {
        if( _core::method( '_likes' , 'isVoted' , $post -> ID ) ){
            $voted_class = 'voted';
        }else{
            $voted_class = '';
        }
        $likes = '<span class="love ' . $voted_class . '"><a href="javascript:void(0)" onclick="javascript:likes.vote( jQuery( this ) , ' . $post -> ID . ' );">' . (int)_meta::get( $post -> ID , 'nr_like' ) . '</a></span>';
    }else{
        $likes = '';
    }
?>
    <h2><a href="<?php echo get_permalink( $post -> ID ) ?>" title="<?php echo $post -> post_title; ?>"><?php echo $post -> post_title; ?></a><?php echo $likes; ?></h2>
    
    <div class="entry-meta">
        <ul>
            <li>
                <a href="<?php echo get_permalink( $post -> ID ); ?>">
                    <?php
                        if ( _core::method( '_settings' , 'logic' , 'settings' , 'general' , 'theme' , 'time' ) ) {
                            echo '// ' . human_time_diff( get_the_time( 'U' , $post -> ID ) , current_time( 'timestamp' ) ) . ' ' . __( 'ago' , _DEV_ );
                        } else {
                            echo '// ' . date_i18n( get_option( 'date_format' ) , get_the_time( 'U' , $post -> ID ) );
                        }
                    ?>
                </a>
            </li>
        </ul>
    </div>