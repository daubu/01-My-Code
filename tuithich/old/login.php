<?php if(!is_user_logged_in()) { ?>
<iframe id="registration_iframe" name="registration_iframe" class="hidden"></iframe>
<?php if(_core::method("_settings","logic","settings","general","theme","enb-login")){
			$register_link=get_permalink();
			$recover_link=$register_link;
			if(strpos($register_link,"?")){
				$register_link.="&action=register";
				$recover_link.="&action=recover";
			}else{
				$register_link.="?action=register";
				$recover_link.="?action=recover";
			}

			if(isset($_GET['action']) && $_GET['action']=='register'){?>
			<div class="register">
				
				<form action="" method="post" class="form txt" id="register_form">
					<fieldset>
						<p>
							<label for="name"><?php echo __( 'Your name' , _DEV_ );?></label>
							<input type="text" id="user_login" name="login" value="">
						</p>
						<p>
							<label for="email"><?php echo __( 'Your email' , _DEV_ );?></label>
							<input type="text" id="user_email" name="email" value="">
						</p>
						<p>
							<span class="login-error" id="registration_error"></span>
						</p>
						<p class="button fl">
							<input type="submit" value="Register" class="button" id="register_button">
						</p>
						<input type="hidden" name="testcookie" value="1">
					</fieldset>
				</form>
			</div>
			<div class="login-box">
				<p class="box">
					<span><?php echo __( 'Already a member?' , _DEV_ ); ?> <a href="<?php the_permalink();?>" id="login" class="try"><?php echo __( 'Log in here' , _DEV_ ); ?></a></span>
				</p>
			</div>
		<?php }elseif( isset( $_GET['action'] ) && $_GET['action'] == "recover" ){ ?>
			<div class="login">
				<form name="lostpasswordform" id="lostpasswordform" action="<?php echo get_template_directory_uri();?>/wp-login.php?action=lostpassword" method="post" class="form txt" target="registration_iframe">
					<fieldset>
						<p>
							<label for="name"><?php echo __( 'Your username or email' , _DEV_ );?></label>
							<input type="text" id="user_login" name="user_login" value="">
						</p>
						<p>
							<span class="login-success" style="border:none" id="registration_error"></span>
						</p>
						<p class="button fl">
							<input type="submit" value="Recover" class="button">
						</p>
					</fieldset>
				</form>
			</div>
			<div class="login-box">
				<p class="box">
					<span><?php echo __( 'Already a member?' , _DEV_ ); ?> <a href="<?php the_permalink();?>" id="login" class="try"><?php echo __( 'Log in here' , _DEV_ ); ?></a></span>
				</p>
			</div>
		<?php }else{ ?>
			<div class="login">
				<form name="loginform" id="cosmo-loginform" action="<?php echo get_template_directory_uri();?>/wp-login.php" method="post" class="form txt">
					<fieldset>
						<p>
							<label for="username"><?php echo __( 'Username:' , _DEV_ );?></label>
							<input name="login" id="username" type="text" class="">
						</p>
						<p>
							<label for="password"><?php echo __( 'Password:' , _DEV_ );?></label>
							<input name="password" id="password" type="password" class="">
						</p>
						<p>
							<label class="remember"><input name="remember" type="checkbox" id="rememberme" value="forever" tabindex="90"><?php echo __( 'Remember Me' , _DEV_ );?></label>
						</p>
						<p>
							<span class="login-error" id="registration_error"></span>
						</p>
						<p class="button">
							<input type="submit" id="login_button" value="Login" class="button">
						</p>
                        <?php
                            if( !( _core::method( '_settings' , 'get' , 'settings' , 'social' , 'facebook' , 'secret' ) == '' || _core::method( '_settings' , 'get' , 'settings' , 'social' , 'facebook' , 'app_id' ) == '' ) ){
                                ?>
                                <div class="facebook">
                                    <?php _core::method( '_facebook' , 'login' ); ?>
                                </div>    
                                <?php
                            }
                        ?>
						<p class="pswd">
							<span><a href="<?php echo $recover_link;?>"><?php echo __( 'Lost your password?' , _DEV_ );?></a></span><?php if( _core::method( "_settings" , "logic" , "settings" , "general" , "theme" , "enb-login" ) ){?> | <span><a href="<?php echo $register_link;?>"><?php echo __( 'Register' , _DEV_ );?></a></span><?php } ?>
						</p>
					</fieldset>
					<input type="hidden" name="testcookie" value="1">
				</form>
			</div>
			<?php if(_core::method( "_settings" , "logic" , "settings" , "general" , "theme" , "enb-login" ) ){?>
			<div class="login-box">
				<p class="box">
					<span><?php echo __( 'No account?' , _DEV_ );?> <a href="<?php echo $register_link;?>" id="login" class="try"><?php echo __( 'Register here' , _DEV_ );?></a></span>
				</p>
			</div>
	<?php	}
		}?>
<?php } ?>
<?php }else{ 
	_e('You are already logged in.',_DEV_);

}?>