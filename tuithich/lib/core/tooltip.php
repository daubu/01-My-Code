<?php
    class _tooltip {
		protected static $type;
		protected static $res_type;
		protected static $res_pages;
		protected static $res_action;
		protected static function init_fields(){
			if( !( isset( self::$type ) && isset( self::$res_type  ) && isset( self::$res_pages ) && isset( self::$res_action ) ) ){
				self::$type = array( 'left' => __( 'Left' , _DEV_ ) , 'right' => __( 'Right' , _DEV_ ) , 'top' => __( 'Top' , _DEV_ ) );
				self::$res_type = array( 'front_page' => __( 'On front page' , _DEV_ ) , 'single' => __( 'On single post' , _DEV_ ) , 'page' => __( 'On simple page' , _DEV_ ) );
				self::$res_pages = get__pages( __( 'Select Page' , _DEV_ ) );
				self::$res_action = "tools.sh.select( this , { 'single' : '.res_posts' , 'page': '.res_pages'  } )";
			}
		}
        public static function load(){
            $method = isset( $_POST['method'] ) ? $_POST['method'] : exit;
            $args   = isset( $_POST['args'] ) ? $_POST['args'] : exit;

            $object = new _tooltip();
            if( is_array( $method ) ){
                foreach( $method as $m ){
                    if( method_exists( $object , $m ) ){
                        echo call_user_func_array( array( '_tooltip' , $m ), $args );
                    }
                }
            }else{
                if( method_exists( $object , $method ) ){
                    echo call_user_func_array( array( '_tooltip' , $method ), $args );
                }
            }
            exit;
        }
        
        public static function addForm(){
			self::init_fields();
            $add = array(
                'type' => 'box--addtooltip',
                'classes' => 'tooltip-addbox hidden',
                'title' => __( 'Add new tooltip ' , _DEV_ ),
                'content' => array(
                    __('Add' , _DEV_ ) => array(
						array(
							'type' => 'st--text' ,
							'label' => __( 'Set title for new tooltip',_DEV_ ) ,
							'id' => 'tooltip_title' ,
							'single' => true
						),
						array(
							'type' => 'st--textarea' , 
							'label' => __( 'Set description for new tooltip',_DEV_ ) ,
							'id' => 'tooltip_description' ,
							'single' => true 
						),
						array(
							'type' => 'st--select' ,
							'label' => __( 'Select tooltip location' , _DEV_ ) ,
							'values' =>  self::$res_type ,
							'action' => self::$res_action ,
							'id' => 'tooltip_res_type' ,
							'single' => true 
						),
						array(
							'type' => 'st--search' , 
							'label' => __( 'Select post' , _DEV_ ) ,
							'hint' => 'Start typing the post tile' ,
							'classes' => 'res_posts hidden' , 
							'id' => 'tooltip_res_posts' ,
							'single' => true , 
							'query' => array( 
								'post_type' => 'post' ,
								'post_status' => 'publish'
							)
						),
						array(
							'type' => 'st--select' ,
							'label' => __( 'Select page' , _DEV_ ) ,
							'values' => self::$res_pages ,
							'classes' => 'res_pages hidden' ,
							'id' => 'tooltip_res_pages' ,
							'single' => true 
						),
						array(
							'type' => 'st--text' ,
							'label' => __( 'Set top position for new tooltip',_DEV_ )  , 
							'hint' => __( 'In pixels. E.g.: 450' , _DEV_ ) ,
							'id' => 'tooltip_top' , 'single' => true 
						),
						array(
							'type' => 'st--text' , 
							'label' => __( 'Set left position for new tooltip',_DEV_ )  ,
							'hint' => __( 'In pixels. E.g.: 200' , _DEV_ )  ,
							'id' => 'tooltip_left' ,
							'single' => true 
						),
						array(
							'type' => 'st--select' ,
							'label' => __( 'Set arrow position for new tooltip',_DEV_ ) ,
							'id' => 'tooltip_type' , 
							'values' => self::$type , 
							'single' => true 
						),
						array( 'type' => 'cd--submit' , 'content' => '<div class="addbox-submit-action">' ),
						array( 
							'type' => 'ln--button' ,  'value' => __( 'Ok' , _DEV_ ) , 
							'action' => "tooltip.r( 'add' , [ tools.v( '#tooltip_title' ) , tools.v( '#tooltip_description' ) ,tools.v( '#tooltip_res_type' ) ,tools.v( '#tooltip_res_posts' ) ,tools.v( '#tooltip_res_pages' ) ,tools.v( '#tooltip_top' ) ,tools.v( '#tooltip_left' ) ,tools.v( '#tooltip_type' ) ] );field.h('.tooltip-addbox');" 
						),
						array( 'type' => 'ln--button' , 'value' => __( 'Cancel' , _DEV_ ) , 'action' => "field.h('.tooltip-addbox');" , 'btnType' => 'secondary' ),
						array( 'type' => 'ln--mssg' , 'value' => __( 'Successfully added' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'success hidden' ),
						array( 'type' => 'ln--mssg' , 'value' => __( 'Error, try again' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'error hidden' ),
						array( 'type' => 'cd--submit' , 'content' => '<div class="clear"></div></div>' )
                    ),
                )
            );
            
            return _fields::layout( $add );
        }
        
        public static function editForm( $id ){
            $tooltips = get_option( _TLTP_ );
            if( isset( $tooltips[ $id ] ) ){
				extract( $tooltips[ $id ] );
				if( $res_type == 'single' ){
					$res_posts_classes = 'res_posts';
				}else{
					$res_posts_classes = 'res_posts hidden';
				}

				if( $res_type == 'page' ){
					$res_pages_classes = 'res_pages';
				}else{
					$res_pages_classes = 'res_pages hidden';
				}

				self::init_fields();
                $edit = array(
                    'type' => 'box--edittooltip',
                    'classes' => 'tooltip-editbox' . $id ,
                    'title' => __( 'Edit tooltip ' , _DEV_ ),
                    'content' => array(
                        __('Edit' , _DEV_ ) => array(
							array( 'type' => 'stbox--hidden' , 'id' => 'tooltip_id' . $id , 'value' => $id ),
							array(
								'type' => 'st--text' ,
								'label' => __( 'Set title for tooltip',_DEV_ ) ,
								'id' => 'tooltip_title' . $id ,
								'single' => true,
								'value' => $title
							),
							array(
								'type' => 'st--textarea' , 
								'label' => __( 'Set description for new tooltip',_DEV_ ) ,
								'id' => 'tooltip_description' . $id ,
								'single' => true,
								'value'	=> $description
							),
							array(
								'type' => 'st--select' ,
								'label' => __( 'Select tooltip location' , _DEV_ ) ,
								'values' =>  self::$res_type ,
								'action' => self::$res_action ,
								'id' => 'tooltip_res_type' . $id ,
								'single' => true,
								'value'	=> $res_type
							),
							array(
								'type' => 'st--search' , 
								'label' => __( 'Select post' , _DEV_ ) ,
								'hint' => 'Start typing the post tile' ,
								'classes' => $res_posts_classes , 
								'id' => 'tooltip_res_posts' . $id ,
								'single' => true , 
								'query' => array( 
									'post_type' => 'post' ,
									'post_status' => 'publish'
								),
								'value'	=> isset( $res_posts ) ? $res_posts : 0
							),
							array(
								'type' => 'st--select' ,
								'label' => __( 'Select page' , _DEV_ ) ,
								'values' => self::$res_pages ,
								'classes' => $res_pages_classes,
								'id' => 'tooltip_res_pages' . $id ,
								'single' => true,
								'value'	=> isset( $res_page ) ? $res_page : 0
							),
							array(
								'type' => 'st--text' ,
								'label' => __( 'Set top position for new tooltip',_DEV_ )  , 
								'hint' => __( 'In pixels. E.g.: 450' , _DEV_ ) ,
								'id' => 'tooltip_top' . $id ,
								'single' => true,
								'value'	=> $top
							),
							array(
								'type' => 'st--text' , 
								'label' => __( 'Set left position for new tooltip',_DEV_ )  ,
								'hint' => __( 'In pixels. E.g.: 200' , _DEV_ )  ,
								'id' => 'tooltip_left' . $id ,
								'single' => true,
								'value'	=> $left
							),
							array(
								'type' => 'st--select' ,
								'label' => __( 'Set arrow position for new tooltip',_DEV_ ) ,
								'id' => 'tooltip_type' . $id , 
								'values' => self::$type , 
								'single' => true,
								'value'	=> $type
							),
							array( 'type' => 'cd--submit' , 'content' => '<div class="addbox-submit-action">' ),
                            array( 
                                'type' => 'ln--button' ,  'value' => __( 'Ok' , _DEV_ ) , 
                                'action' => "tooltip.r( 'edit' , [ tools.v( '#tooltip_id" . $id . "' ) ,  tools.v( '#tooltip_title" . $id . "' ) , tools.v( '#tooltip_description" . $id . "' ) ,tools.v( '#tooltip_res_type" . $id . "' ) ,tools.v( '#tooltip_res_posts" . $id . "' ) ,tools.v( '#tooltip_res_pages" . $id . "' ) ,tools.v( '#tooltip_top" . $id . "' ) ,tools.v( '#tooltip_left" . $id . "' ) ,tools.v( '#tooltip_type" . $id . "' ) ] );field.h('.tooltip-editbox" . $id . "');" 
                            ),
                            array( 'type' => 'ln--button' , 'value' => __( 'Cancel' , _DEV_ ) , 'action' => "field.h('.tooltip-editbox" . $id . "');" , 'btnType' => 'secondary' ),
                            array( 'type' => 'ln--mssg' , 'value' => __( 'Successfully added' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'success hidden' ),
                            array( 'type' => 'ln--mssg' , 'value' => __( 'Error, try again' , _DEV_ ) , 'classes' => 'result-mssg' , 'iclasses' => 'error hidden' ),
                            array( 'type' => 'cd--submit' , 'content' => '<div class="clear"></div></div>' )
                        ),
                    )
                );

                return _fields::layout( $edit );
            }
        }
        
        public static function get( ){
            $tooltips = get_option( _TLTP_ );
            
            if( !is_array( $tooltips ) || empty( $tooltips ) ){
                return array();
            }else{
                return $tooltips;
            }
        }
        
        public static function getList(){
            $sidebars[ 'main' ] = __( 'main' , _DEV_ );
            
            $sb = self::get();
            if( !empty( $sb ) ){
                foreach( $sb as $index => $s ){
                    $sidebars[ $index ] = $s;
                }
            }
            
            return $sidebars;
        }

        public static function add( $title , $description , $res_type , $res_posts , $res_page , $top , $left , $type ){
            $tooltips = self::get();
            if( empty( $title ) ){
                return 'error';
            }
            
            if( isset( $tooltips[str_replace( array( '  ' , '   ' , ' ' , '_' ) , '-' , $title )] ) ){
                return 'error';
            }            
            $tooltip			= array();
			$tooltip[ 'title' ] = $title;
			$tooltip[ 'description' ] = $description;
			$tooltip[ 'res_type' ] = $res_type;
			$tooltip[ 'res_posts' ] = $res_posts;
			$tooltip[ 'res_page' ] = $res_page;
			$tooltip[ 'top' ] = $top;
			$tooltip[ 'left' ] = $left;
			$tooltip[ 'type' ] = $type;

			array_push( $tooltips , $tooltip );

            update_option( _TLTP_ ,  $tooltips );
            return self::items();
        }
        
        public static function edit( $id , $title , $description , $res_type , $res_posts , $res_page , $top , $left , $type ){
            $tooltips = self::get();
            
            if( isset( $tooltips[ $id ] ) ){
                unset( $tooltips[ $id ] );
				$tooltip			= array();
				$tooltip[ 'title' ] = $title;
				$tooltip[ 'description' ] = $description;
				$tooltip[ 'res_type' ] = $res_type;
				$tooltip[ 'res_posts' ] = $res_posts;
				$tooltip[ 'res_page' ] = $res_page;
				$tooltip[ 'top' ] = $top;
				$tooltip[ 'left' ] = $left;
				$tooltip[ 'type' ] = $type;
				array_push( $tooltips , $tooltip );
                update_option( _TLTP_ ,  $tooltips );
            }else{
                return 'error';
            }
            
            return self::items();
        }
        
        public static function delete( $id ){
            $tooltip = self::get();
            if( isset( $tooltip[ $id ] ) ){
                unset( $tooltip[ $id ] );
                update_option( _TLTP_ ,  $tooltip );
            }else{
                return 'error';
            }
            
            return self::items();
        }

		public static function sort( $args ){
			$tooltips = self::get();
			$new_tooltips = array();
			$pairs = explode( ';' , $args );
			foreach( $pairs as $pair ){
				$pair_array = explode( '=>' , $pair );
				$from = $pair_array[0];
				$to = $pair_array[1];
				$new_tooltips[ $to ] = $tooltips[ $from ];
			}
			update_option( _TLTP_ ,  $new_tooltips );
			return self::items();
		}

        public static function panel(){
            
            $result  = '<h3>' . __( 'Tooltips' , _DEV_ ) . '</h3>';
            $result .= '<div class="tooltips-container">';
            $result .= self::items();
            $result .= '</div>';
            $result .= self::action();
            return $result;
        }
        
        public static function items(){
            $tooltips = self::get();
            $result = '';
			$result  = '<script>';
			$result .= 'jQuery(document).ready(function(){';
			$result .= 'jQuery(".tooltips-container").sortable({ stop : function(){';
			$result .= "tooltip.sort();";
			$result .= '}});';
			$result .= '});';
			$result .= '</script>';
            foreach( $tooltips as $id => $tooltip ){
                $result .= self::item( $id );
            }
            return $result;
        }
        
        public static function item( $id ){

            $tooltips = self::get();
			$tooltip = $tooltips[ $id ];
			$title   = isset( $tooltip[ 'title' ] ) ? $tooltip[ 'title' ] : '&nbsp;';
			$description = isset( $tooltip[ 'description' ] ) ? $tooltip[ 'description' ] : '&nbsp';
			$result  =   '';
            $result  = '<div class="tooltip">';
            $result .= self::actionbox( $id );
            $result .= '<p>'  . $title . '</p>';
			$result .= '<input type="hidden" class="tooltip-id" value="'.$id.'">';
            $result .= '</div>';
            
            return $result;
        }
        
        public static function action(){
            $result  = '<div class="tooltip-action">';
            $result .= self::addForm();
            $result .= '<a class="add" href="javascript:field.s(\'.tooltip-addbox\');">' . __( 'Add new tooltip' , _DEV_ ) . '</a>';
            $result .= '</div>';
            
            return $result;
        }
        
        public static function actionbox( $id ){
            
            $result  = '';
            $result .= '<div class="tooltip-actionbox">';
            $result .= '<ul>';
            $result .= '<li><a href="javascript:tooltip.load( tooltip , \'editForm\' , [  \'' . $id . '\' ] , \'.tooltip-action\' , \'.tooltip-editbox' . $id .  '\' );">' . __( 'Edit' , _DEV_ ) .  '</a></li>';
            $result .= '<li><a href="javascript:tooltip.r( \'delete\' , [  \'' . $id . '\' ]);">'. __( 'Delete' , _DEV_ ) . '</a></li>';
            $result .= '</ul>';
            $result .= '</div>';
            
            return $result;
        }
    }
?>