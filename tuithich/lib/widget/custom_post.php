<?php
    class widget_custom_post extends WP_Widget {

        function widget_custom_post() {
            $widget_ops = array( 'classname' => 'widget_custom_post' , 'description' => __( " Posts' list" , _DEV_ ) . ' <span class="cosmo-widget-red">( ' . __( 'recommend to use "Front Page Area" sidebar' , _DEV_ ) . ' )</span>' );
            $this -> WP_Widget( 'widget_custom_post' , _CT_ . ': ' . __( " Posts' list" , _DEV_ ) , $widget_ops );
        }

        function widget( $args , $instance ) {

            /* prints the widget*/
            extract($args, EXTR_SKIP);

            if( isset( $instance['title'] ) ){
                $title = $instance['title'];
            }else{
                $title = '';
            }

			if( isset( $instance['nr_posts'] ) && is_numeric($instance['nr_posts']) ){
                $nr_posts = $instance['nr_posts'];
            }else{
                $nr_posts = 3;
            }
			
			if( isset( $instance['post_view'] ) ){
                $post_view = $instance['post_view'];
            }else{
                $post_view = 'list';
            }
			
			/*if( isset( $instance['light_box'] ) ){
                $light_box = $instance['light_box'];
            }else{
                $light_box = 1;
            }
			if($light_box == ''){ $light_box = 0;}
			*/
			if(isset($instance['customPost']) ){
				$custompost		= $instance['customPost'];
			}else{
				$custompost		= array();
			}
			
			if(isset($instance['label']) ){
				$label		= $instance['label'];
			}else{
				$label		= array();
			}
			
			if(isset($instance['taxonomy']) ){
				$taxonomy		= $instance['taxonomy'];
			}else{
				$taxonomy		= array();
			}
			
			if(isset($instance['taxonomies']) ){
				$taxonomies		= $instance['taxonomies'];
			}else{
				$taxonomies		= array();
			}
			
            echo $before_widget;
		?>
			
			
		<?php
            if( !empty( $title ) ){
				echo $before_title . $title .'&nbsp;'. $after_title;
			}	
			
			/*generate a random ID for the container*/
			$container_id = mt_rand(0,999999);
			echo '<div class="cp_title content_tabber" id="cp_posts_'.$container_id.'" ></div>';
			
        ?>
				<!-- panel tags -->
				
				<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.mosaic.1.0.1.min.js" type="text/javascript" ></script>
				<script src="http://maps.googleapis.com/maps/api/js?sensor=true" type="text/javascript"></script>
				<script src="<?php echo get_template_directory_uri();?>/lib/core/js/map.js"></script>
			<div class="content_tabber">
				<div class="www loop-container-view <?php echo $instance[ 'post_view' ]; ?>-view tabs-container" id="posts_<?php echo $container_id; ?>">
					
                    <?php if(sizeof($custompost)) : $i = 0; ?>	

                        <script type="text/javascript">
                            jQuery(document).ready(function () {
                                var custom_posts = new Array();	
                                var taxonomies = new Array();
                                var terms = new Array();
                                var labels = new Array();

                                <?php foreach($custompost as $c_p): ?> 
                                    <?php if( post_type_exists( $c_p ) ) : ?>

                                        custom_posts[<?php echo $i; ?>] = '<?php echo $c_p; ?>';

                                        <?php 
                                            $tax = isset( $taxonomy[ $i ] ) ? $taxonomy[ $i ] : -1;
                                            $term = isset( $taxonomies[ $i ] ) ? $taxonomies[ $i ] : -1;
                                            $lab = isset( $label[ $i ] ) ? $label [ $i ] : -1;
                                            echo "taxonomies[ $i ] = '$tax';";
                                            echo "terms[ $i ] = '$term';";
                                            echo "labels[ $i ] = '$lab';";
                                            $i++; 
                                        ?>
                                    <?php endif?>        
                                <?php endforeach; ?>

                                get_c_post( custom_posts , custom_posts[0] , <?php echo $nr_posts; ?> , '<?php echo $post_view; ?>' , <?php echo 0; /*$light_box;*/ ?> , 'posts_<?php echo $container_id; ?>' , taxonomies , terms , labels );
                            });
                        </script>

                    <?php else : ?>

                            <?php _e('Please select at least one post type',_DEV_); ?>

                    <?php endif; ?>
				</div>
			</div>
        <?php
            echo $after_widget;
			$widgets = wp_get_sidebars_widgets();
			if(sizeof($widgets) && sizeof($widgets['front-page'])){
				/*if it is not the last widget in the front sidebar, we output the delimiter*/
				if($this->id != $widgets['front-page'][sizeof($widgets['front-page'])-1]){
					echo '<div class="delimiter blank">&nbsp;</div>';
				}
			}
		}
		
		
        function update( $new_instance, $old_instance) {

            /*save the widget*/
            $instance = $old_instance;
// 			print_r($old_instance);
			
            $instance['title']              = strip_tags( $new_instance['title'] );
			$instance['nr_posts']        	= strip_tags( $new_instance['nr_posts'] );
			$instance['post_view']        	= strip_tags( $new_instance['post_view'] );
			/*$instance['light_box']        	= strip_tags( $new_instance['light_box'] );*/
			
			
			$instance['customPost'] = array();
			foreach($new_instance['customPost'] as $cust_post){
				if($cust_post != ''){
					$instance['customPost'][] = $cust_post;
				}	
			}
			
			$instance['label'] = array();
			foreach($new_instance['label'] as $label){
				if( $label != '' ){
					$instance['label'][] = $label;
				}else{
					$instance['label'][] = '';
				}
			}
			
			$instance['taxonomy'] = array(); 
			foreach($new_instance['taxonomy'] as $taxonomy){
				if($taxonomy != ''){
					$instance['taxonomy'][] = $taxonomy;
				}else{
					$instance['taxonomy'][] = '';
				}
			}
			
			$instance['taxonomies'] = array(); 
			foreach($new_instance['taxonomies'] as $taxonomies){
				if($taxonomies != ''){
					$instance['taxonomies'][] = $taxonomies;
				}else{
					$instance['taxonomies'][] = '';
				}
			}

			return $instance;
        }

        function form($instance) {

            /* widget form in backend */
            $instance       = wp_parse_args( (array) $instance, array( 'title' => '' , 'nr_posts' => '', 'post_view' => 'list', 'light_box' => 1, 'customPost' => array(),'taxonomy' => array(), 'label'=>array(), 'taxonomies' => array() ) );
            $title          = strip_tags( $instance['title'] );
			$nr_posts    	= strip_tags( $instance['nr_posts'] );
			$post_view		= strip_tags( $instance['post_view'] );
			
			if(isset($instance['customPost']) ){
				$custompost		= $instance['customPost'];
			}else{
				$custompost		= array();
			}
			//var_dump($instance );
			if(isset($instance['taxonomy']) ){
				$taxonomy		= $instance['taxonomy'];
			}else{
				$taxonomy		= array();
			}
			
			if(isset($instance['taxonomies']) ){
				$taxonomies		= $instance['taxonomies'];
			}else{
				$taxonomies		= array();
			}
			
			
			if(isset($instance['label']) ){
				$label		= $instance['label'];
			}else{
				$label		= array();
			}
			
			/*if( isset($instance['light_box']) ){
                $light_box = esc_attr( $instance['light_box'] );
            }else{
                $light_box = '';
            }*/
			
			$args = array('exclude_from_search' => false);
			$post_types = get_post_types($args);
			
    ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title',_DEV_) ?>:
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
			
			<div class="c_post">
			<?php if(sizeof($custompost)){ 
				$counter = 0;
				foreach($custompost as $c_p){ 
			?>
			<div>
				<p>
					<label ><?php _e('Select post type',_DEV_) ?>: 
						<a href="javascript:void(0)" onclick="jQuery(this).parent().parent().parent().remove();" style="float:right"><?php _e("remove",_DEV_); ?></a>
						<select class="widefat post_type" onchange="get_taxonomy(jQuery(this))" name="<?php echo $this->get_field_name( 'customPost'  ); ?>[]" >
							<option value=''  ><?php _e('Select item',_DEV_); ?></option>	
						<?php foreach($post_types as $key => $custom_post) {  
							if('attachment' != $key && "slideshow"!= $key){ 
						?>
							<option value='<?php echo $key; ?>' <?php if($c_p == $key ){ echo 'selected="selected"'; } ?> ><?php echo $custom_post; ?></option>	
						<?php 
							} /*EOF if*/
						} /*EOF foreach*/ ?>
						</select>
						
					</label>
				</p>
				<div class="taxonomy"> 
				<?php 
					if($c_p == 'page'){
				?>	
					<p style="display:none"> 
						<label ><?php _e('Select post taxonomy',_DEV_) ?>: 
							<select class="widefat " style="display:none" name="<?php  echo $this->get_field_name( 'taxonomy'  ); ?>[]" >
								<option value="__"><?php _e('Select taxonomy',_DEV_) ?></option>
							</select>
						</label>	
					</p>
						
				<?php		
					}elseif($c_p == 'post'){
				?>
					<p> 
						<label ><?php _e('Select post taxonomy',_DEV_) ?>: 
							<select class="widefat " name="<?php  echo $this->get_field_name( 'taxonomy'  ); ?>[]" onchange="javascript:get_terms(jQuery(this))">
								<option value="__"><?php _e('Select taxonomy',_DEV_) ?></option>
								<option value="category" <?php if ( isset($taxonomy[$counter]) && 'category' == $taxonomy[$counter]){echo 'selected="selected" '; } ?> ><?php _e('Category',_DEV_) ?></option>
								<option value="post_tag" <?php if ( isset($taxonomy[$counter]) && 'post_tag' == $taxonomy[$counter]){echo 'selected="selected" '; } ?> ><?php _e('Post tag',_DEV_) ?></option>
							</select>	
						</label>
					</p>	
				<?php		
					
					}else{
						$resources = _core::method( '_resources' , 'get' );
						
						foreach($resources as $resource){ 
							if($resource['slug'] == $c_p){ 
								
								if(isset($resource['taxonomy']) && sizeof($resource['taxonomy']) ){
				?>				
									<p> 
										<label ><?php _e('Select post taxonomy',_DEV_) ?>: 
											<select class="widefat " name="<?php  echo $this->get_field_name( 'taxonomy'  ); ?>[]" onchange="javascript:get_terms(jQuery(this))">
												<option value="__"><?php _e('Select taxonomy',_DEV_) ?></option>
											<?php foreach($resource['taxonomy'] as $txnm) { ?>
												<option value="<?php echo $txnm['slug']; ?>" <?php if ( isset($taxonomy[$counter]) && $txnm['slug'] == $taxonomy[$counter]){echo 'selected="selected" '; } ?> > <?php echo $txnm['stitle']; ?> </option>
											<?php } ?>
											
											</select>
										</label>
									</p>
				<?php					
								}else{
?>
								<p style="display:none"> 
									<label ><?php _e('Select post taxonomy',_DEV_) ?>: 
										<select class="widefat " style="display:none" name="<?php  echo $this->get_field_name( 'taxonomy'  ) ?>[]" >
											<option value="__"><?php _e('Select taxonomy',_DEV_) ?></option>
										</select>
									</label>	
								</p>
						<?php    }
							}
						}
					}	
				
				?>
					
				</div>
				<div class="taxonomies">
					<?php
						if( count( $taxonomy ) > 0 && isset( $taxonomy[ $counter ] ) && $taxonomy[ $counter ] != '__' && $taxonomy[ $counter ] != -1 ){
							$terms = get_terms( $taxonomy[ $counter ] , array( 'hide_empty' => false ) );
						?>
						<p> 
							<label ><?php _e('Select post terms',_DEV_) ?>: 
								<select class="widefat " name="<?php  echo $this->get_field_name( 'taxonomies'  ); ?>[]">
									<?php foreach( $terms as $term ) { ?>
										<option value="<?php echo $term -> slug; ?>" <?php if( isset( $taxonomies[$counter] ) && $term -> slug == $taxonomies[$counter] ) { echo 'selected="selected"'; }?> > <?php echo $term -> name; ?> </option>
									<?php } ?>
								</select>
							</label>
						</p>
					<?php }else{ ?>
						<input class="hidden" name="<?php echo $this -> get_field_name( 'taxonomies' ); ?>[]" value="-1">
					<?php } ?>
				</div>
				<p>
					<label ><?php _e('Label',_DEV_) ?>:
						<input class="widefat"  name="<?php echo $this->get_field_name( 'label'  ); ?>[]" type="text" value="<?php if(isset($label[$counter]) ) { echo $label[$counter]; } ?>" />
					</label>
				</p>
			</div>
			<?php 
					$counter++;
				} /*EOF foreach*/
			
			}else{ ?>
				<div>
					<p>
						<label ><?php _e("Select post type",_DEV_) ?>:
							<a href="javascript:void(0)" onclick="jQuery(this).parent().parent().parent().remove();" style="float:right"><?php _e("remove",_DEV_); ?></a>
							<select class="widefat post_type" onchange="get_taxonomy(jQuery(this))" name="<?php echo $this->get_field_name( "customPost"  ); ?>[]" >
								<option value=''  ><?php _e("Select item",_DEV_); ?></option>
							<?php foreach($post_types as $key => $custom_post) {  
								if("attachment" != $key && "slideshow"!= $key){ 
							?>
								<option value="<?php echo $key; ?>"  ><?php echo $custom_post; ?></option>	
							<?php 
								} /*EOF if*/
							} /*EOF foreach*/ ?>
							</select>
							
						</label>
					</p>
					<div class="taxonomy">
					</div>
					<div class="taxonomies">
					</div>
					<p>
						<label ><?php _e('Label',_DEV_) ?>:
							<input class="widefat"  name="<?php echo $this->get_field_name( 'label'  ); ?>[]" type="text" value="" />
						</label>
					</p>
				</div>
			<?php } /*EOF if*/ ?>
			</div>
			<p><a href="javascript:void(0)" onclick="add_more(jQuery(this));" ><?php _e('Add more',_DEV_); ?></a></p>
			<p>
                <label for="<?php echo $this->get_field_id('nr_posts'); ?>"><?php _e( 'Number of posts' , _DEV_ ) ?>:
                    <input class="widefat digit" id="<?php echo $this->get_field_id('nr_posts'); ?>" name="<?php echo $this->get_field_name('nr_posts'); ?>" type="text" value="<?php echo esc_attr( $nr_posts ); ?>" />
				</label>
            </p>
			
			<p>
                <label for="<?php echo $this->get_field_id('post_view'); ?>"><?php _e( 'Posts view' , _DEV_ ) ?>:
                    List <input type="radio" <?php if($post_view == 'list') echo 'checked="checked"'; ?> onclick="sh_lightbox(jQuery(this))" value="list" name="<?php echo $this->get_field_name('post_view'); ?>" />
					Grid <input type="radio" <?php if($post_view == 'grid') echo 'checked="checked"'; ?> onclick="sh_lightbox(jQuery(this))" value="grid" name="<?php echo $this->get_field_name('post_view'); ?>" />
				</label>
			</p>
			
						
			<script type="text/javascript">
				function fix__i__( obj ){
					var n = jQuery( obj ).parents( '.widget' ).find( 'input.multi_number' ).val();
					if( n.length && n!='' && n.length > 0 ){
						jQuery( obj ).parents( '.widget-content' ).find( 'select, input, textarea' ).each( function( index, element ) {
							var id = jQuery( element ).attr( 'id' );
							var name = jQuery( element ).attr( 'name' );
							if( id && id.length && id.length > 0 ){
								jQuery( element ).attr( 'id' , id.replace( '__i__' , n ) );
							}
							if( name && name.length && name.length > 0 ){
								jQuery( element ).attr( 'name' , name.replace( '__i__' , n ) );
							}
						});
					}
				}

				function get_taxonomy( obj ) { 
						var  this_widget = '<?php  echo $this->get_field_name( 'taxonomy'  ); ?>[]';
						jQuery.ajax({
							url: ajaxurl,
							data: '&action=get_taxonomies&custom_post_type='+obj.val()+'&this_widget='+this_widget,
							type: 'POST',
							cache: false,
							success: function (data) { 
								obj.parent().parent().parent().find('div.taxonomy').html(data);
								obj.parent().parent().parent().find('div.taxonomies').html('<input class="hidden" name="<?php echo $this -> get_field_name( 'taxonomies' ); ?>[]" value="-1">');
								fix__i__( obj );
							},
							error: function (xhr) {
							}
						});
				}

				function get_terms( obj ) {
					var this_widget = '<?php echo $this -> get_field_name( 'taxonomies' ); ?>[]';
					jQuery.ajax({
							url: ajaxurl,
							data: '&action=get_terms&taxonomy='+obj.val()+'&this_widget='+this_widget,
							type: 'POST',
							cache: false,
							success: function (data) { 
								obj.parent().parent().parent().parent().find('div.taxonomies').html(data);
								fix__i__( obj );
							},
							error: function (xhr) {
								
							}
						});
				}
				
				/*function sh_lightbox(obj){
					if(obj.val() == 'list'){
						obj.parent().parent().parent().find('p.light_box').hide();
					}
					
					if(obj.val() == 'grid'){
						obj.parent().parent().parent().find('p.light_box').show();
					}
				}*/
				
				function add_more(obj){
					var select = '<div><p>';
					select += '		<label ><?php _e("Select post type",_DEV_) ?>: ';
					select += '			<a href="javascript:void(0)" onclick="jQuery(this).parent().parent().parent().remove();" style="float:right"><?php _e("remove",_DEV_); ?></a>';
					select += '			<select class="widefat post_type" onchange="get_taxonomy(jQuery(this))" name="<?php echo $this->get_field_name( "customPost"  ); ?>[]" > ';
					select += '				<option value=""  ><?php _e("Select item",_DEV_); ?></option> ';
										<?php foreach($post_types as $key => $custom_post) {
												if("attachment" != $key && "slideshow"!= $key){  
										?> 
					select += '				<option value="<?php echo $key; ?>"  ><?php echo $custom_post; ?></option>	';
										<?php  
												} /*EOF if*/ 
											} /*EOF foreach*/ ?> 
					select += '			</select>';
					select += '		</label>';
					select += '	</p>';
					select += '	<div class="taxonomy">';
					select += ' <input class="hidden" name="<?php echo $this -> get_field_name( 'taxonomy' ); ?>[]" value="-1">';
					select += '	</div>';
					select += '	<div class="taxonomies">';
					select += ' <input class="hidden" name="<?php echo $this -> get_field_name( 'taxonomies' ); ?>[]" value="-1">';
					select += '	</div>';
					select += '<p>';
					select += '	<label ><?php _e('Label',_DEV_) ?>:';
					select += '		<input class="widefat"  name="<?php echo $this->get_field_name( 'label'  ); ?>[]" type="text" value="" />';
					select += '	</label>';
					select += '</p>';
					select += '</div>';
					
					jQuery(obj.parent().parent().find('div.c_post')).append(select);
					fix__i__( obj );
				}
			</script>
    <?php
        }
		
		function get_terms(){
			if( isset( $_POST[ 'taxonomy'] ) && isset( $_POST[ 'this_widget' ] ) && $_POST[ 'taxonomy' ] != '__' && $_POST[ 'taxonomy' ] != -1 ){
				$terms = get_terms( $_POST[ 'taxonomy' ] , array( 'hide_empty' => false ) );
				?>
				<p> 
					<label ><?php _e('Select post terms',_DEV_) ?>: 
						<select class="widefat " name="<?php  echo $_POST[ 'this_widget' ]; ?>">
							<?php foreach( $terms as $term ) { ?>
								<option value="<?php echo $term -> slug; ?>" > <?php echo $term -> name; ?> </option>
							<?php } ?>
						</select>
					</label>
				</p>
			<?php
			}else{
			?>
				<input class="hidden" name="<?php echo $_POST[ 'this_widget' ]; ?>" value="-1">
		<?php
			}
			exit();
		}

		function get_taxonomies(){
			if(isset($_POST['custom_post_type']) && $_POST['custom_post_type'] != ''){

				if($_POST['custom_post_type'] == 'post'){
			?> 
					<p> 
						<label ><?php _e('Select post taxonomy',_DEV_) ?>: 
							<select class="widefat " name="<?php  echo $_POST['this_widget']; ?>" onchange="javascript:get_terms(jQuery(this));">
								<option value="__"><?php _e('Select taxonomy',_DEV_) ?></option>
								<option value="category"><?php _e('Category',_DEV_) ?></option>
								<option value="post_tag"><?php _e('Post tag',_DEV_) ?></option>
							</select>	
						</label>
					</p>
			<?php	
			
				}elseif($_POST['custom_post_type'] == 'page'){
			?>
					<p style="display:none"> 
						<label ><?php _e('Select post taxonomy',_DEV_) ?>: 
							<select class="widefat " style="display:none" name="<?php  echo $_POST['this_widget']; ?>" >
								<option value="__"><?php _e('Select taxonomy',_DEV_) ?></option>
							</select>
						</label>	
					</p>
			<?php	
				}else{
					$resources = _core::method( '_resources' , 'get' );
							
					foreach($resources as $resource){ 
						if($resource['slug'] == $_POST['custom_post_type']){ 
							
							if(isset($resource['taxonomy']) && sizeof($resource['taxonomy']) ){
			?>				
								<p> 
									<label ><?php _e('Select post taxonomy',_DEV_) ?>: 
										<select class="widefat " name="<?php  echo $_POST['this_widget']; ?>" onchange="javascript:get_terms(jQuery(this));">
											<option value="__"><?php _e('Select taxonomy',_DEV_) ?></option>
										<?php foreach($resource['taxonomy'] as $txnm) { ?>
											<option value="<?php echo $txnm['slug']; ?>" > <?php echo $txnm['stitle']; ?> </option>
										<?php } ?>
										
										</select>
									</label>
								</p>
			<?php					
							}else{
							?>
								<p style="display:none"> 
									<label ><?php _e('Select post taxonomy',_DEV_) ?>: 
										<select class="widefat " style="display:none" name="<?php  echo $_POST['this_widget']; ?>" >
											<option value="__"><?php _e('Select taxonomy',_DEV_) ?></option>
										</select>
									</label>	
								</p>
							<?php
							}
						}
					}	
				}
			}

			exit();		
		}
		
		function list_posts(){
				
			// '&action=list_posts&custom_posts='+custom_posts+'&nr_posts='+nr_posts+'&post_view='+post_view+'&light_box='+light_box,
			// '&action=list_posts&active_post_type='+active_post_type+'&custom_posts='+custom_posts+'&nr_posts='+nr_posts+'&post_view='+post_view+'&light_box='+light_box+'&container_id='+container_id,
				$args = array(
					'numberposts'     => $_POST['nr_posts'],
					'post_type'       => $_POST['active_post_type'],
				);
				$taxonomies = isset( $_POST[ 'taxonomies' ] ) ? explode( ',' , $_POST[ 'taxonomies' ] ) : array();
				$terms = isset( $_POST[ 'terms' ] ) ? explode( ',' , $_POST[ 'terms' ] ) : array();
				$labels = isset( $_POST[ 'labels' ] ) ? explode( ',', $_POST[ 'labels' ] ) : array();
				$custom_posts = explode(',',$_POST['custom_posts']);
				$current_index = isset( $_POST[ 'index' ] ) ? $_POST[ 'index' ] : 0;
				
				if( isset( $taxonomies[ $current_index ] ) && $taxonomies[ $current_index ] != '-1' && $taxonomies[ $current_index ] != '__' && isset( $terms[ $current_index ] ) && $terms[ $current_index ] != -1 ){
					if( $taxonomies[ $current_index ] == 'post_tag' ){
						$tax = 'tag';
					}else if( $taxonomies[ $current_index ] == 'category' ){
						$tax = 'category_name';
					}else{
						$tax = $taxonomies[ $current_index ];
					}
					$args[ $tax ] = $terms[ $current_index ];
				}
				$cust_posts = get_posts( $args );
	
				$cps = '<ul class="content_tabber">';
				foreach($custom_posts as $index => $c_p){
					if( $current_index == $index ){
						$class = 'active';
						$onclick = "javascript:void(0);";
					}else{
						$class = '';
						$onclick="get_c_post(\'".$_POST['custom_posts']."\',\'".$c_p."\',". $_POST['nr_posts'].",\'". $_POST['post_view']."\',".$_POST['light_box'].",\'". $_POST['container_id']."\'";
						$tax_arg = isset( $_POST[ 'taxonomies' ] ) ? $_POST [ 'taxonomies' ] : '';
						$terms_arg = isset( $_POST[ 'terms' ] ) ? $_POST[ 'terms' ] : '';
						$labels_arg = isset( $_POST[ 'labels' ] ) ? $_POST [ 'labels' ] : '';
						$onclick.= ",\'" . $tax_arg . "\' , \'" . $terms_arg . "\'";
						$onclick.= ",\'" . $labels_arg . "\'";
						$onclick.=",\'$index\');";
					}
					
					if( isset( $labels[ $index ] ) && strlen( $labels[ $index ] ) > 0 ){
						$c_p_name = $labels[ $index ];
					}else{
						$c_p_name = $c_p;
					}
					$cps .= '<li class="'.$class.'"><a onclick="'.$onclick.'"> '.$c_p_name.' </a></li>';
				}
				$cps .= "</ul>";
			
?>
				<script type="text/javascript"> 
					jQuery('<?php echo '#cp_' . $_POST['container_id']; ?>').html('<?php echo $cps; ?>');
				</script>
<?php				
			//echo '<div class="'.$_POST['post_view'].'">';
			global $wp_query;
			$backup = $wp_query;
			$args[ 'posts_per_page' ] = $_POST[ 'nr_posts' ];
			$wp_query = new WP_Query( $args );
			if( $_POST[ 'post_view' ] == 'list' ):
				echo '<div>';
					_core::method( 'post' , 'loop' , 'archive' , $_POST[ 'post_view' ] , 0 );
				echo '</div>';
			else:
				echo '<div class="masonry-container">';
					_core::method( 'post' , 'loop' , 'archive' , $_POST[ 'post_view' ] , 0 );
				echo '</div>';
			endif;
			
			?>
			<?php
			$wp_query = $backup;
			exit;
		}
		
		function get_single_posts(){
			$index = isset( $_POST[ 'index' ] ) ? $_POST[ 'index' ] : exit;
			$widget_posts_ids = isset( $_POST[ 'widget_posts_ids' ] ) ? explode( ',' , $_POST [ 'widget_posts_ids' ] ) : exit;
			$last_index = count( $widget_posts_ids ) - 1;
			$wp_query = new WP_Query( array( 'p' =>  $widget_posts_ids[ $index ] , 'post_type' => 'any') );

			if( count( $wp_query -> posts ) > 0 ){ 
				foreach( $wp_query -> posts as $post ){
					$wp_query -> the_post();
					$postID = $post -> ID;
					?>
					<div class="contents fix <?php if( _core::method( '_settings' , 'logic' , 'settings' , 'style' , 'general' , 'fixed-layout' ) ){ echo 'b_page';} ?>">
						<div class="content-title w_930"> 
							<div class="title"> 
							<h1 class="entry-title"> 
								<?php echo cosmo_avatar( $post -> post_author , 50 ); ?>
								<?php echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'single' , 'post_title' , 'text' , get_the_title() , 'span' );?>
								<span class="author"> 
									<a href="<?php echo get_author_posts_url( $post -> post_author ) ?>">
										<?php echo __( 'by' , _DEV_ ) . ' ' . get_the_author_meta( 'display_name' , $post -> post_author ); ?>
									</a> 
									<?php _core::method('_follow','get_follow_btn',$post -> post_author ); ?>
								</span> 
							</h1> 
							<nav class="hotkeys-meta"> 
								<?php if( $index != 0 ){ ?>
									<span class="nav-previous "> 
										<a href="javascript:get_post_box( [ <?php echo $_POST[ 'widget_posts_ids' ];?> ] , <?php echo $index - 1; ?> , '.hide_post' );" rel="prev">Previous</a> 
									</span> 
								<?php } ?>
								<?php if( $index != $last_index ){ ?>
									<span class="nav-next"> 
										<a href="javascript:get_post_box( [ <?php echo $_POST[ 'widget_posts_ids' ];?> ] ,<?php echo $index + 1; ?> , '.hide_post' );" rel="next">Next</a> 
									</span> 
								<?php } ?>
								<span class="nav-close"> 
								<a href="javascript:close_post();" title="Close">Close</a> 
								</span> 
							</nav> 
							</div> 
						</div> 
						<div class="w_930 single"> 
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php
									if( _core::method( '_map' , 'markerExists' , $post -> ID  ) || ( _core::method( '_settings' , 'logic' , 'settings' , 'blogging' , 'posts' , 'enb-featured' ) && ( has_post_thumbnail( $post -> ID ) || ( get_post_format( $post -> ID ) == 'video' ) ) ) ){
								?>
								<header class="entry-header"> 
									<div class="featimg">
										<?php $border = _core::method( "_settings" , "logic" , "settings" , "blogging" , "posts" , "enb-featured-border" ); ?>
										<?php
											$map = _meta::get( $postID , 'map' );
											
											$map_id = '';

											if( _core::method( '_map' , 'markerExists' , $post -> ID  ) ){
												$map_id = 'id="map_canvas"';
												_core::method( '_box' , 'mapFrontEnd' , $post -> ID );
											}
										?>
										<div class="img <?php if( !$border ) echo "noborder"; ?>" <?php echo $map_id; ?>> 
											<?php 
												if( strlen( $map_id ) == 0 ){
													if( get_post_format( $post -> ID ) == 'video' ){
														$video_format = _core::method( '_meta' , 'get' , $post -> ID , 'format' );
														if( strlen( $video_format[ "feat_url" ] ) > 1 ){
															$video_url = $video_format[ "feat_url" ];
															$youtube_id = _core::method( 'post' , 'get_youtube_video_id' , $video_url );
															$vimeo_id= _core::method( 'post' , 'get_vimeo_video_id' , $video_url );
															if( $youtube_id != '0'  ){
																echo _core::method( 'post' , 'get_embeded_video' , $youtube_id , "youtube" );
															}else if( $vimeo_id != '0' ){
																echo _core::method( 'post' , 'get_embeded_video' , $vimeo_id , "vimeo" );
															}
														}else if( is_numeric( $video_format[ "feat_id" ] ) ){
															echo _core::method( 'post' , 'get_local_video' , urlencode( wp_get_attachment_url( $video_format[ "feat_id" ] ) ) );
														}
													}else if( has_post_thumbnail( $post -> ID ) ){
														if( $border ){
															$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ) , 'single' );
															echo '<img src="' . $src[0] . '" style="width:910px" />';
														}else{
															echo wp_get_attachment_image( get_post_thumbnail_id( $post -> ID ) , 'single' );            
														}
													}
												}
											?>
										</div> 
									</div> 
								</header>
								<?php
									}
									/* ferify if is need class vertical */
									$vertical = false;
									$additional = false;
									$likes_use  = false;
									$smeta = false;

									$resources = _core::method( '_resources' , 'get' );
									$customID = _core::method( '_attachment' , 'getCustomIDByPostID' , $post -> ID );

									/* check if is used likes */
									if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'likes-use' ] == 'yes' ){
										$likes_use = true;
									}

									$meta = _core::method( '_meta' , 'get' , $post -> ID , 'posts-settings' );

									/* check if display meta | meta horizontal */
									if( isset( $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'meta-use' ] ) && $resources[ $customID ][ 'boxes' ][ 'posts-settings' ][ 'meta-use' ] == 'yes' ){
										if( isset( $meta[ 'meta' ] ) && $meta[ 'meta' ] == 'yes' ){
											$smeta = true;
											if( isset( $meta[ 'meta-type' ] ) && $meta[ 'meta-type' ] == 'yes' ){
												$vertical = false;
											}else{
												$vertical = true;
											}
										}
									}

									/* check if not empty additional info */
									$data = _core::method( '_meta' , 'get' , $post -> ID , 'additional' );

									if( is_array( $data ) && !empty( $data ) ){
										foreach( $data as $key => $value ){
											if( !empty( $value ) ){
												$additional = true;
												break;
											}
										}
									}

									if( $smeta || $additional || $likes_use ){
										if( $vertical ){
											$econtent = 'vertical';
										}else{
											$econtent = 'horizontal';
										}
									}else{
										$econtent = '';
									}
								?>
							<div class="entry-content <?php echo $econtent; ?>"> 
								<?php 
									if( $smeta || $additional || $likes_use ){
										if( $vertical ){
											get_template_part( 'templates/meta/single/vertical' );
										}else{
											get_template_part( 'templates/meta/single/horizontal' );
										}
									}
								?>
								
								<div class="b_text">
								<?php
									if( get_post_format( $post -> ID ) == 'link' ){
										echo _core::method( 'post' , 'get_attached_files' , $post -> ID );
									}else if( get_post_format( $post -> ID ) == 'audio' ){
										$audio = new AudioPlayer();	
										echo $audio -> processContent( _core::method( 'post' , 'get_audio_files' , $post -> ID ) );
									}else if( get_post_format( $post -> ID ) == 'video' ){
										if(isset( $video_format[ 'video_ids' ] ) && !empty( $video_format[ 'video_ids' ] ) ){
											foreach( $video_format[ "video_ids" ] as $videoid ){
											if( isset( $video_format[ "video_urls" ] ) && is_array( $video_format[ "video_urls" ] ) && isset( $video_format[ "video_urls" ][ $videoid ] ) ){
													$video_url = $video_format[ "video_urls" ][ $videoid ];
													$youtube_id = _core::method( 'post' , 'get_youtube_video_id' , $video_url );
													$vimeo_id= _core::method( 'post' , 'get_vimeo_video_id' , $video_url );
													if(  strlen( $youtube_id ) ){
														echo _core::method( 'post' , 'get_embeded_video' , $youtube_id , "youtube" );
													}else if( strlen($vimeo_id) ){
														echo _core::method( 'post' , 'get_embeded_video' , $vimeo_id , "vimeo" );
													}
												}else{
													echo _core::method( 'post' , 'get_local_video' , urlencode( wp_get_attachment_url( $videoid ) ) );
												}
											}
										}
									}else if( get_post_format( $post->ID ) == "image" ){
										$image_format = _core::method( '_meta' , 'get' , $post -> ID , 'format' );
										echo '<div class="attached_imgs_gallery">';
										if( isset( $image_format[ 'images' ] ) && is_array( $image_format[ 'images' ] ) ){
											foreach( $image_format['images'] as $index => $img_id ){
												$thumbnail = wp_get_attachment_image_src( $img_id, 'thumbnail');
												$full_image = wp_get_attachment_url( $img_id );
												$url = $thumbnail[ 0 ];
												$width = $thumbnail[ 1 ];
												$height = $thumbnail[ 2 ];
												echo '<div class="attached_imgs_gallery-element">';
												echo '<a title="" rel="prettyPhoto[' . get_the_ID() . ']" href="' . $full_image . '">';

												if( $height < 150 ){
													$vertical_align_style = 'style="margin-top:'.((150-$height)/2) . 'px;"';
												}else{
													$vertical_align_style = '';
												}

												echo '<img alt="" src="' . $url . '" width="' . $width . '" height="' . $height . '" ' . $vertical_align_style . '>';
												echo '</a>';
												echo '</div>';
											}
											echo '</div>';
										}
									}
									
									/* content */
									echo _core::method( '_text' , 'content' , 'settings' , 'style' , 'single' , 'post_text' , 'content' , $post , 'span' );
									
									$events = _core::method( '_meta' , 'get' , $postID , 'program' );
							
									if( count( $events ) && !empty( $events ) ){
										echo _core::method( '_program' , 'getPrgramm' , $post -> ID );
									}
								?>
								</div>
							</div> 
							<?php
								$resources = _core::method( '_resources' , 'get' );
								$customID = _resources::getCustomIdByPostType( $post -> post_type );
								if( isset( $resources[ $customID ][ 'boxes' ][ 'attachdocs' ] ) ) {
									$attachdocs = _core::method( '_meta' , 'get' , $post -> ID , 'attachdocs' );
								}
								
								$pterms = array();
								
								if( isset( $resources[ $customID ][ 'taxonomy' ] ) && !empty( $resources[ $customID ][ 'taxonomy' ] ) ){
									foreach(  $resources[ $customID ][ 'taxonomy' ] as $taxonomy ){

										if(  $resources[ $customID ][ 'slug' ] == 'post' ){
											$resources[ $customID ][ 'taxonomy' ] = array(
												array(
													'hierarchical' => 'hierarchical',
													'slug' => 'category'
												),
												array(
													'hierarchical' => '',
													'slug' => 'post_tag'
												)
											);
										}

										if( $taxonomy[ 'hierarchical' ] == 'hierarchical' ){
											continue;
										}

										$terms = wp_get_post_terms( $post -> ID , $taxonomy[ 'slug' ] , array("fields" => "all") );
										
										if( !empty( $terms ) ){
											$pterms[] = array( 'data' => $terms , 'ptitle' => $taxonomy[ 'ptitle' ] , 'slug' => $taxonomy[ 'slug' ] );
										}
									}
									
									

									if( !empty( $pterms ) || !empty( $attachdocs ) ){
										?>
											<footer class="entry-footer">    
										<?php
									}

									if( !empty( $pterms ) ){
										foreach( $pterms as $terms ){
											
											echo '<p class="title_tags">' . $terms[ 'ptitle' ] . ': </p>';
											
											foreach( $terms['data'] as $term ){
												?>
													<p class="tags">
														<a href="<?php echo get_term_link( $term -> slug , $terms[ 'slug' ] ) ?>">
															<?php echo $term -> name; ?>
														</a>
													</p>
												<?php
											}
										}
									}

									if( !empty( $attachdocs ) ){
										get_template_part( 'templates/attachdocs' );
									}

									if( !empty( $terms ) || !empty( $attachdocs ) ){
										?>
											</footer>
										<?php
									}
								}
								
							?>
							</article> 
						</div>
					</div>
					<?php
				}
			}
			
			exit;
		}
    }
	

?>