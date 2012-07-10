<?php
    /* MENUS */
    _panel::$fields[ 'settings' ][ 'menus' ][ 'menus' ][ 'home' ] = array(
        'type' => 'st--logic-radio',
        'label' => __( 'Show "Home" label in custom menu' , _DEV_ ),
        'action' => "tools.sh.check( this , { 'yes' : '.home-label' } );" 
    );
    
    if(  _core::method( '_settings' , 'logic' , 'settings' , 'menus' , 'menus' , 'home' ) ){
        $lclasses = 'home-label';
    }else{
        $lclasses = 'home-label hidden';
    }
    
    _panel::$fields[ 'settings' ][ 'menus' ][ 'menus' ][ 'home-label' ] = array(
        'type' => 'st--text',
        'label' => __( 'Set "Home" label for custom menu' , _DEV_ ),
        'classes' => $lclasses
    );

	_panel::$fields[ 'settings' ][ 'menus' ][ 'menus' ][ 'header' ] = array(
        'type' => 'st--select',
		'values' => _tools::digit( 20 ),
        'label' => __( 'Set limit for main menu' , _DEV_ ),
        'hint' => __( 'Set the number of visible menu items. Remaining menu<br />items will be shown in the drop down menu item "More"' , _DEV_ )
    );

	_panel::$fields[ 'settings' ][ 'menus' ][ 'menus' ][ 'footer' ] = array(
        'type' => 'st--select',
		'values' => _tools::digit( 20 ),
        'label' => __( 'Set limit for footer menu' , _DEV_ ),
        'hint' => __( 'Set the number of visible menu items. Remaining menu<br />items will be hidden' , _DEV_ )
    );  
?>