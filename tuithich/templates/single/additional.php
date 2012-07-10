<?php
    $additional = _core::method( '_meta' , 'get' , $post -> ID , 'additional' );
    $resources  = _core::method( '_resources' , 'get' );
    $customID = _attachment::getCustomIDByPostID( $post -> ID );
?>

<?php if( isset( $resources[ $customID ] ) ) : ?>
    <?php 
        $resource = $resources[ $customID ];

        $is_empty = true;

        if( is_array( $additional ) && !empty( $additional ) ){
            foreach( $additional as $key => $value ){
                if( !empty( $value ) ){
                    $is_empty = false;
                }
            }
        }
    ?>


    <?php if(  !$is_empty && !empty( $additional ) && is_array( $additional ) && !empty( $resource[ 'boxes' ][ 'additional' ] ) ) : $i = 0; ?>

        <table class="additional-info">
        <tbody>

        <?php foreach( $resource[ 'boxes' ][ 'additional' ] as $set => $field ) : ?>

            <?php if( !empty( $additional[ $set ] ) ) : $i++; ?>

                <tr class="row_<?php echo $i; ?>">
                    <td class="td_1_<?php echo $i; ?>"><?php echo $field[ 'label' ]; ?></td>
                    <td class="td_2_<?php echo $i; ?>"><?php echo $additional[ $set ]; ?></td>
                </tr>

            <?php endif; ?>

        <?php endforeach; ?>

        </tbody>
        </table>

    <?php endif; ?>

<?php endif; ?>