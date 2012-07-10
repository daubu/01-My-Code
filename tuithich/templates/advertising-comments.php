<?php $advertising = _core::method( '_settings' , 'get' , 'settings' , 'ads' , 'general' , 'comments' ); ?>

<?php if( strlen( $advertising ) > 0 ) : ?>

        <div class="cosmo-ads zone-2">
            
            <?php echo $advertising; ?>
            
        </div>

<?php endif; ?>
