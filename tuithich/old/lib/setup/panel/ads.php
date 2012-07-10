<?php
    _panel::$fields[ 'settings' ][ 'ads' ][ 'general' ][ 'first' ] = array(
        'type' => 'st--textarea',
        'label' => __( 'First advertising zone' , _DEV_ ),
        'hint' => __( '' , _DEV_ )
    );
    
    _panel::$fields[ 'settings' ][ 'ads' ][ 'general' ][ 'comments' ] = array(
        'type' => 'st--textarea',
        'label' => __( 'Advertising zone for comments' , _DEV_ ),
        'hint' => __( 'This area will be displayed on single post, inner article and comments.' , _DEV_ )
    );
?>