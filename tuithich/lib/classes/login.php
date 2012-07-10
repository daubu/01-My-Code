<?php 
	class _login{
		public static function login(){
			if( is_user_logged_in() ){
				echo "'".get_author_posts_url( get_current_user_id() )."'//success";
				exit;
			}

			if( isset( $_POST[ 'login' ] ) && strlen( $_POST[ 'login' ] ) ){
				$login = $_POST[ 'login' ];
			}else{
				echo __( 'Please enter a username' , _DEV_ );
				exit;
			}

			if( isset( $_POST[ 'password' ] ) && strlen( $_POST[ 'password' ] ) ){
				$password = $_POST[ 'password' ];
			}else{
				echo __( 'Please enter a password' , _DEV_ );
				exit;
			}

			$remember = isset( $_POST[ 'remember' ] );

			$credentials = array( 'user_login' => $login , 'user_password' => $password , 'remember' => $remember);
			$result = @wp_signon( $credentials );
			if( is_wp_error( $result ) ){
				echo $result -> get_error_message();
			}else{
				echo "'".get_author_posts_url( $result->ID )."'//success";
			}
			exit;
		}
		public static function register(){
			if( is_user_logged_in() ){
				echo __( 'You are logged in' , _DEV_ );
				exit;
			}
			if( isset( $_POST[ 'login' ] ) && strlen( $_POST[ 'login' ] ) ){
				$login = $_POST[ 'login' ];
			}else{
				echo __( 'Please enter a username' , _DEV_ );
				exit;
			}

			if( isset( $_POST[ 'email' ] ) && is_email( $_POST[ 'email' ] ) ){
				$email = $_POST[ 'email' ];
			}else{
				echo __( 'Please enter a valid e-mail' , _DEV_ );
				exit;
			}

			$random_password = wp_generate_password( 12, false );


			$subject = _core::method( '_settings' , 'get' , 'settings' , 'general' , 'user_registration' , 'email_subject' );
			$subject = str_replace( '%sitename%' , get_bloginfo( 'name' ) , $subject );

			$message = _core::method( '_settings' , 'get' , 'settings' , 'general' , 'user_registration' , 'message' );
			$message = str_replace( '%sitename%' , get_bloginfo( 'name' ) , $message );
			$message = str_replace( '%username%' , $login , $message );
			$message = str_replace( '%password%' , $random_password , $message );
			$message = str_replace( '%loginurl%' , get_permalink( _core::method("_settings","get","settings","general","theme","settings-page") ) , $message );

			$result = wp_create_user( $login , $random_password , $email );
			if( is_wp_error( $result ) ){
				echo $result -> get_error_message();
			}else{
				wp_mail( $email , $subject , $message );
				echo "'".get_author_posts_url( $result->ID )."'//success";
			}
			exit;
		}
	}
?>
