



function __(msg){
	if(translations[msg]){
		return translations[msg];
	}else{
		<?php if( class_exists( '_js_translator' ) ){?>
		<?php add_action( 'wp_ajax_generate_js_translation' , array( '_js_translator' , 'generate' ) );?>
			jQuery.ajax({
				url:ajaxurl,
				type:'POST',
				data:'&action=generate_js_translation&string='+msg,
				cache:false,
				success:function(response){
					if(!debug_window){
						var debug_window=window.open("about:blank");
					}

					if( response.indexOf("Warning")!=-1 ){
						debug_window.document.write(response);
					}else{
						debug_window.document.write("Added translation: "+msg);
					}
				}
			});
		<?php } ?>
		return msg;
	}
}

var translations=Array();

translations["Uploading"]="<?php echo __('Uploading',_DEV_);?>";
translations["file"]="<?php echo __('file',_DEV_);?>";
translations["This may take a while"]="<?php echo __('This may take a while',_DEV_);?>";
translations["Click to set as featured"]="<?php echo __('Click to set as featured',_DEV_);?>";
translations["Remove"]="<?php echo __('Remove',_DEV_);?>";
translations["Are you sure?"]="<?php echo __('Are you sure?',_DEV_);?>";
translations["Downloading. Please wait."]="<?php echo __('Downloading. Please wait.',_DEV_);?>";
translations["You sure you want to delete this item from group ?"]="<?php echo __('You sure you want to delete this item from group ?',_DEV_);?>";
translations["Unfollow"]="<?php echo __('Unfollow',_DEV_);?>";
translations["Follow"]="<?php echo __('Follow',_DEV_);?>";
translations["Registration successful"]="<?php echo __('Registration successful',_DEV_);?>";
translations["Login successful"]="<?php echo __('Login successful',_DEV_);?>";
translations["Delete"]="<?php echo __('Delete',_DEV_);?>";
translations["as featured image"]="<?php echo __('as featured image',_DEV_);?>";
translations["Use"]="<?php echo __('Use',_DEV_);?>";
translations["Add a title for your story"]="<?php echo __('Add a title for your story',_DEV_);?>";
translations["Title is required"]="<?php echo __('Title is required',_DEV_);?>";
translations["Success. Your post is awaiting moderation"]="<?php echo __('Success. Your post is awaiting moderation',_DEV_);?>";
translations["What's on your mind?"]="<?php echo __('What\'s on your mind?',_DEV_);?>";
