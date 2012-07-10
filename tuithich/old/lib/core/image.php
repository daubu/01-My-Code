<?php
    class _image{
	
		/*sizes for resized thumbnails*/
		static $size = array(
			
			'sidebar'               => array( 150  , 150  , true ),
			//'widget'                => array( 290 , 145 , true ),
			
            //'small-single'          => array( 610 , 9999 , true ), /* single | page - fix width with sidebar */
            'large-single'          => array( 930 , 9999 , true ), /* single | page - other case */
			
			/* sponsor widget */
			//'sponsor' 				=> array( 9999 , 40  ), 
            
			'grid'                  => array( 320 , 9999 ),
            //'list'                  => array( 450 , 225 , true ),
            
			'tmedium,tsingle,tlist' => array( 600 , 9999 , 300  ), /* for gallery short code   */
			'tgrid,trelated'        => array( 280 , 140  , true ), /* for gallery short code   */
			'tmedium_gallery'       => array( 440 , 220  , true ), /* for gallery short code   */ 
			'tgallery'              => array( 200 , 100  , true ), /* for gallery short code   */
		);	
		
        
        static function add_size(){
            $size =array();
            if( function_exists( 'add_image_size' ) ){
                foreach( self::$size as $label => $args ){
                    $labels = explode( ',' , $label );
					if( _core::method( "_settings" , "logic" , "settings" , 'general' , 'theme' , 'custom_gallery' ) ){
						if( sizeof($args) == 2 ){
							add_image_size( $labels[0]  , $args[0] , $args[1] );
						}else{
							add_image_size( $labels[0]  , $args[0] , $args[1] , $args[2] );
						}
					}elseif($label != 'tmedium,tsingle,tlist' && $label != 'tgrid,trelated' && $label != 'tmedium_gallery'  && $label != 'tgallery' ){
						if( sizeof($args) == 2 ){
							add_image_size( $labels[0]  , $args[0] , $args[1] );
						}else{
							add_image_size( $labels[0]  , $args[0] , $args[1] , $args[2] );
						}
					}
					
                }
            }
        }
    }
?>