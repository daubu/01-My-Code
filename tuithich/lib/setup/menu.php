<?php
	if ( function_exists('register_nav_menu') ) {
		register_nav_menus(
			array(
				'header' => 'Main Menu',
                'footer' => 'Footer Menu'
            )
		);
	}
?>