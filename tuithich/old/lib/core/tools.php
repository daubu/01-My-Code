<?php
    class _tools{
        public static function excerpt( $postID , $length = 150 ){
            $post = get_post( $postID );
            $result = '';
            
            if( !empty( $post ) && !is_wp_error( $post ) ){
                
                $excerpt = strip_shortcodes( strip_tags( $post ->  post_excerpt ) );
                $content = strip_shortcodes( strip_tags( $post ->  post_content ) );
                
                if( !empty( $excerpt ) ){
                    if( strlen( $excerpt ) > $length ){
                        $result = mb_substr( $excerpt , 0 , $length ) . ' ..';
                    }else{
                        $result = $excerpt;
                    }
                }else{
                    if( strlen( $content ) > $length ){
                        $result = mb_substr( $content , 0 , $length ) . ' ..';
                    }else{
                        $result = $content;
                    }
                }
            }
            
            return $result;
        }
        
        public static function digit( $to , $from = 0 , $twodigit = false ){
            $result = array();
            for( $i = $from; $i < $to + 1; $i ++ ){
                if( $twodigit ){
                    $i = (string)$i;
                    if( strlen( $i ) == 1 ){
                        $i = '0' . $i;
                    }
                    $result[$i] = $i;
                }else{
                    $result[$i] = $i;
                }
            }

            return $result;
        }


        public static function months( ){
            $result = array(
                '01' =>  __( 'January' , _DEV_ ),
                '02' =>  __( 'February', _DEV_ ),
                '03' =>  __( 'March' , _DEV_ ),
                '04' =>  __( 'April', _DEV_ ),
                '05' =>  __( 'May', _DEV_ ),
                '06' =>  __( 'June', _DEV_ ),
                '07' =>  __( 'July', _DEV_ ),
                '08' =>  __( 'August', _DEV_ ),
                '09' =>  __( 'September', _DEV_ ),
                '10' =>  __( 'October', _DEV_ ),
                '11' =>  __( 'November', _DEV_ ),
                '12' =>  __( 'December', _DEV_ )
            );

            return $result;
        }

        public static function months_days( $month , $year  ){
            $days = date( 't' , mktime( 0 , 0 , 0 , $month, 0 , $year, 0 ) );
            return self::digit( $days , 1 , true );
        }

        public static function item_label( $item ){
            $item = basename( $item );
            $item = str_replace( '-' , ' ' , $item );
            return $item;
        }
        
        public static function exists_posts( $args ){
            $posts = get_posts( $args );
            if( count( $posts ) > 0 ){
                return true;
            }else{
                return false;
            }
        }
        
        public static function clean_array( array $array ){
            $result = array();
            if( !empty( $array ) ){
                foreach( (array) $array as $index => $value ){
                    array_push( $result , $value );
                }
            }
            
            return $result;
        }
        
        public static function currencies(){
            $result = array(
                'AUD' => __( 'Australian Dollar' , _DEV_ ) . ' (A $)',
                'CAD' => __( 'Canadian Dollar' , _DEV_ ) . ' (C $)',
                'EUR' => __( 'Euro' , _DEV_ ) . ' (€)',
                'GBP' => __( 'British Pound' , _DEV_ ) . ' (£)',
                'JPY' => __( 'Japanese' , _DEV_ ) . ' Yen (¥)',
                'USD' => __( 'U.S. Dollar' , _DEV_ ) . '  ($)',
                'NZD' => __( 'New Zealand Dollar' , _DEV_ ) . ' ($)',
                'CHF' => __( 'Swiss Franc' , _DEV_ ),
                'HKD' => __( 'Hong Kong Dollar' , _DEV_ ) . ' ($)',
                'SGD' => __( 'Singapore Dollar' , _DEV_ ) . ' ($)',
                'SEK' => __( 'Swedish Krona' , _DEV_ ),
                'DKK' => __( 'Danish Krone' , _DEV_ ),
                'PLN' => __( 'Polish Zloty' , _DEV_ ),
                'NOK' => __( 'Norwegian Krone' , _DEV_ ),
                'HUF' => __( 'Hungarian Forint' , _DEV_ ),
                'CZK' => __( 'Czech Koruna' , _DEV_ ),
                'ILS' => __( 'Israeli New Shekel' , _DEV_ ),
                'MXN' => __( 'Mexican Peso' , _DEV_ ),
                'BRL' => __( 'Brazilian Real (only for Brazilian members)' , _DEV_ ),
                'MYR' => __( 'Malaysian Ringgit (only for Malaysian members)' , _DEV_ ) ,
                'PHP' => __( 'Philippine Peso' , _DEV_ ),
                'TWD' => __( 'New Taiwan Dollar' , _DEV_ ),
                'THB' => __( 'Thai Baht' , _DEV_ ),
                'TRY' => __( 'Turkish Lira (only for Turkish members)' , _DEV_)
            );
        		
			return $result;
        }
        
        public static function role(){
            return array(
                10 => __( 'Administrator' , _DEV_ ) ,
                7 => __( 'Editor' , _DEV_ ) , 
                2 => __( 'Author' , _DEV_ ) , 
                1 => __( 'Contributor' , _DEV_  ) , 
                0 => __( 'Subscriber' , _DEV_ ), 
                '' => __( 'Subscriber' , _DEV_ )
            );
        }

		public static function tour( $pos ,  $location , $id , $type , $title , $body , $nr ,  $next = true ){
            
            $nrs = explode('/' , $nr );
            
            /* stap */
            if( isset( $_COOKIE[ ZIP_NAME.'_tour_stap_' . $location . '_' . $id ] ) && (int)$_COOKIE[ ZIP_NAME.'_tour_stap_' . $location . '_' . $id ] > 0  ){
                $k = $_COOKIE[ ZIP_NAME.'_tour_stap_' . $location . '_' . $id ] + 1;
            }else{
                $k = 1;
            }
            
            if( $nrs[0] == $k ){
                $classes = '';
            }else{
                $classes = 'hidden';
            }
        ?>
            <div class="demo-tooltip <?php echo $classes; ?>" index="<?php echo $nrs[0] - 1; ?>" rel="<?php echo $location . '_' . $id; ?>" style="top: <?php echo $pos[0]; ?>px; left: <?php echo $pos[1]; ?>px; "><!--Virtual guide starts here. Set coordinates top and left-->
                <span class="arrow <?php echo $type; ?>">&nbsp;</span><!--Available arrow position: left, right, top -->
                <header class="demo-steps">
                    <strong class="fl"><?php echo $title; ?></strong>
                    <span class="fr"><?php echo $nr; ?></span><!--Step number from-->
                </header>
                <div class="demo-content">
                    <?php echo stripslashes( $body ); ?>
                    <?php
                        if( $next ){
                    ?>
                            <p class="fr close"><a href="#" class="tooltip-close"><?php _e( 'Do not show hints anymore' , _DEV_ ); ?></a></p>
                    <?php
                        }
                    ?>
                </div>
                <footer class="demo-buttons">
                    <?php
                        if( $next ){
                    ?>
                            <p class="fl button-small"><a href="#" class="next"><?php _e( 'Next feature' , _DEV_ ); ?></a></p>
                            <p class="fr button-small gray"><a href="#" class="skip"><?php _e( 'Skip' , _DEV_ ); ?></a></p>
                    <?php
                        }else{
                            ?><p class="fr button-small gray"><a href="#" class="tooltip-close"><?php _e( 'Close' , _DEV_ ); ?></a></p><?php
                        }
                    ?>
                            
                    
                </footer>
            </div>
        <?php
        }
    }
?>