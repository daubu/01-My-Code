<?php
    _panel::$fields[ 'settings' ][ 'blogging' ][ 'seo' ][ 'keywords' ] = array(
        'type' => 'st--textarea',
        'label' => __( 'General blog keywords' , _DEV_ ),
        'hint' => __( 'Separate with commas, is recommended to use not more than 10 keywords' , _DEV_ )
    );
    
    _panel::$fields[ 'settings' ][ 'blogging' ][ 'seo' ][ 'description' ] = array(
        'type' => 'st--textarea',
        'label' => __( 'General blog description' , _DEV_ ),
        'hint' => __( 'Is recommended to use not more than 160 chars' , _DEV_ )
    )
    
?>