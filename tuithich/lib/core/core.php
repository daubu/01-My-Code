<?php
    class _core{
        /* CosmoHooks */
        public static function hook( $name ){
            global ${ 'pl_' . str_replace( '-' , '_' , $name ) }  , $ { 'ch_' . str_replace( '-' , '_' , $name ) } ;
            do_action( 'pl_' . str_replace( '-' , '_' , $name ) , ${ 'pl_' . str_replace( '-' , '_' , $name ) } );
            do_action( 'ch_' . str_replace( '-' , '_' , $name ) , ${ 'ch_' . str_replace( '-' , '_' , $name ) } );
        }
        
        /* CosmoSubTemplate with echo call */
        public static function template( $template ){
            get_template_part( $template );
        }
        
        /* CosmoSubTemplate with return call */
        public static function getTemplate( $template ){
            ob_start(); ob_clean();
            get_template_part( $template );
            return ob_get_clean();
        }
        
        /* CosmoMethods */
        public static function method(){
            if( func_num_args() > 1 ){

                $class_name = func_get_arg( 0 );
                $method_name = func_get_arg( 1 );
                
                if( $class_name == 'self' ){
                    $class_name = get_class();
                }

                $ext_class_name = 'ext_' . $class_name;

                $args = array();
                for( $i = 0; $i < func_num_args(); $i++ ){
                    if( $i > 1 ){
                        $args[$i] = func_get_arg( $i );
                    }
                }

                                
                
                /* exists class */
                if( class_exists( $class_name ) ){
                    $object = new $class_name;
                    if( method_exists( $object , $method_name ) ){
                        return call_user_func_array( array( $class_name , $method_name ), $args );
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }
        
               
        public static function addFunction( $classes , $method , $function_name ){
            if( !is_dir( get_template_directory() . '/lib/load' ) ){
                mkdir(  get_template_directory() . '/lib/load' );
            }

            if( substr( $classes , 0 , 1 ) == '_' ){

                $load_file_name = substr( $classes , 1 , strlen( $classes ) );
            }else{
                $load_file_name = $classes;
            }

            if( !function_exists( $function_name ) ){
                $load_file_name = str_replace( '_' , '-' , $load_file_name );

                $file = fopen( get_template_directory() . '/lib/load/' . $load_file_name . '.php' , 'a+' );

                fputs( $file , "<?php" );
                fputs( $file , "\n\t/* for : class - " . $classes  . ", method - " . $method . ". autobuild on : " . date( 'j F, Y H:i:s' ) . " */" );
                fputs( $file , "\n\tfunction " . $function_name . "( ){" );
                fputs( $file , "\n\t\t" . $classes . "::" . $method ."( '" . $function_name . "' );" );
                fputs( $file , "\n\t}" );
                fputs( $file , "\n?>\n" );

                fclose( $file );
            }
        }
    }
?>