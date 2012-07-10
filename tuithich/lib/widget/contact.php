<?php
    class widget_contact extends WP_Widget {
        function widget_contact() {
            $widget_ops = array( 'classname' => 'quick-contact', 'description' => __('Display Contact form' , _DEV_ ) );
            parent::WP_Widget( false , _CT_ . ': ' . __( 'Quick contact form' , _DEV_ )  , $widget_ops );

        }

        function form($instance) {
            if( isset($instance['title']) ){
                $title = esc_attr($instance['title']);
            }else{
                $title = __( 'Contact us' , _DEV_ );
            }

            if( isset($instance['email']) ){
                $email = esc_attr($instance['email']);
            }else{
                $email = get_the_author_meta( 'user_email' , get_current_user_id());
            }
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title' , _DEV_ ); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e( 'Your email' , _DEV_ ); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" />
            </p>
        <?php
        }

        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title']      = strip_tags($new_instance['title']);
            $instance['email']      = strip_tags($new_instance['email']);
            return $instance;
        }

        function widget($args, $instance) {
            extract( $args );
            if( !empty( $instance['title'] ) ){
               $title = apply_filters('widget_title', $instance['title']);
            }else{
               $title = '';
            }

            if( isset($instance['email'])){
                $email = $instance['email'];
            }


            echo $before_widget;

            if ( strlen( $title ) > 0 ) {
                    echo $before_title . $title . $after_title;
            }

            if( strlen( $email ) ){
                _contact::form( $email );
            }

            echo $after_widget;
        }
    }
?>
