function timeline_add_audio_post(){
	jQuery('#audio_content-html').click();
	jQuery('#audio_content-tmce').click();
	
	jQuery("#submit_audio_btn").attr("disabled", "disabled");
		
	jQuery("#ajax-indicator").show();
	jQuery('#not_logged_msg').hide();
	jQuery('#success_msg').hide();
	jQuery('#audio_img_post_title_warning').hide();
	jQuery('#audio_img_warning').hide();
	jQuery('#audio_warning').hide();
		
	jQuery('#audio_post_title').removeClass('invalid');
	jQuery('#audio_image_url').removeClass('invalid');
	jQuery('#audio_img_upload').removeClass('invalid');
	jQuery('#audio_upload').removeClass('invalid');
	
	if( jQuery( '#form_post_audio textarea.timeline_text' ).val() == __( "What's on your mind?" ) ){
		jQuery( '#form_post_audio textarea.timeline_text' ).val( '' );
	}
	
	var data = jQuery('#form_timeline_audio').serialize();
	
	if( jQuery( '#form_timeline_audio input.timeline_title' ).val() == __( 'Add a title for your story' ) ){
		jQuery('#audio_img_post_title_warning').html( __( 'Title is required' ) );
		jQuery('#audio_img_post_title_warning').show();
		jQuery('#audio_post_title').addClass('invalid');
		jQuery("#ajax-indicator").hide();
	}else jQuery.ajax({
		url: ajaxurl,
		data: data+'&action=add_audio_post'+window.audio_uploader.serialize(),
		type: 'POST',
		cache: false,
		success: function (data) {
			json = eval("(" + data + ")");
			if(json['error_msg'] && json['error_msg'] != ''){
				if(json['title_error'] != ''){ /*If title is not set*/
					jQuery('#audio_img_post_title_warning').html(json['title_error']);
					jQuery('#audio_img_post_title_warning').show();
					jQuery('#audio_post_title').addClass('invalid');
				}
			
				if( json['audio_error'] != ''){ 
					window.audio_uploader.show_error(json['audio_error']);
					jQuery('#audio_upload').addClass('invalid');
				}
			
				if(json['auth_error'] != ''){ /*is user is not logged in*/
					jQuery('#not_logged_msg').show();
				}
			
			}else{
				if( json[ 'success_msg' ] == __( 'Success. Your post is awaiting moderation' ) ){
					jQuery('#form_timeline_audio .success_msg').html(json['success_msg']);
					jQuery('#form_timeline_audio .success_msg').show();
				}else{
					var post_id = json[ 'post_id' ];
					jQuery.ajax({
						url:ajaxurl,
						data:'&action=get_new_timeline_post&post_id='+post_id,
						type: 'POST',
						cache: false,
						success: function( data ){
							jQuery( '.timeline div.timeline_is_empty' ).remove();
							jQuery( '.timeline .timeline_bg' ).show();
							jQuery( '.grid-view .seconddiv' ).prepend( data );
							jQuery( '.hovermore' ).mosaic();
						}
					});
				}
			
				/*clear inputs*/
				jQuery('.front_post_input').each(function(index) {
					jQuery(this).val('');
					jQuery(this).trigger( 'blur' );
				});
				window.audio_uploader.reset();
			
				jQuery('#audio_content').val('');
				jQuery('#audio_content_ifr').contents().find(".mceContentBody").html('');
			}
			jQuery("#ajax-indicator").hide();
			jQuery("#submit_audio_btn").removeAttr("disabled");
		},
		error: function (xhr) {
			jQuery("#ajax-indicator").hide();
			alert(xhr);
		}
	});
}

function timeline_add_video_post(){
	jQuery('#video_content-html').click();  
	jQuery('#video_content-tmce').click();

	jQuery("#submit_video_btn").attr("disabled", "disabled");
		
	jQuery("#ajax-indicator").show();
	jQuery('#not_logged_msg').hide();
	
	jQuery('#video_url_warning').hide();
	jQuery('#video_post_title_warning').hide();
		
	jQuery('#success_msg').hide();
	jQuery('#video_post_title').removeClass('invalid');
	jQuery('#video_url').removeClass('invalid');
	
	if( jQuery( '#form_timeline_video textarea.timeline_text' ).val() == __( "What's on your mind?" ) ){
		jQuery( '#form_timeline_video textarea.timeline_text' ).val( '' );
	}
	
	var data = jQuery('#form_timeline_video').serialize();
	
	if( jQuery( '#form_timeline_video input.timeline_title' ).val() == __( 'Add a title for your story' ) ){
		jQuery('#video_post_title').addClass('invalid');
		jQuery('#video_post_title_warning').html( __( 'Title is required' ) );
		jQuery('#video_post_title_warning').show();
		jQuery( '#ajax-indicator' ).hide();
	}else jQuery.ajax({
		url: ajaxurl,
		data: data+'&action=add_video_post'+window.video_uploader.serialize(),
		type: 'POST',
		cache: false,
		success: function (data) {
			json = eval("(" + data + ")");
			if(json['error_msg'] && json['error_msg'] != ''){
				if(json['video_error'] != ''){ /*if image OR image link is invalid*/
					jQuery('#video_url').addClass('invalid');
					window.video_uploader.show_error(json['video_error']);
				}
			
				if(json['title_error'] != ''){ /*If title is not set*/
					jQuery('#video_post_title').addClass('invalid');
					jQuery('#video_post_title_warning').html(json['title_error']);
					jQuery('#video_post_title_warning').show();
				}
			
				if(json['auth_error'] != ''){ /*is user is not logged in*/
					jQuery('#not_logged_msg').show();
				}
			}else{
				if( json[ 'success_msg' ] == __( 'Success. Your post is awaiting moderation' ) ){
					jQuery('#form_timeline_video .success_msg').html(json['success_msg']);
					jQuery('#form_timeline_video .success_msg').show();
				}else{
					var post_id = json[ 'post_id' ];
					jQuery.ajax({
						url:ajaxurl,
				 data:'&action=get_new_timeline_post&post_id='+post_id,
				 type: 'POST',
				 cache: false,
				 success: function( data ){
					 jQuery( '.timeline div.timeline_is_empty' ).remove();
					 jQuery( '.timeline .timeline_bg' ).show();
					 jQuery( '.grid-view .seconddiv' ).prepend( data );
					 jQuery( '.hovermore' ).mosaic();
				 }
					});
				}
			
				/*clear inputs*/
				jQuery('.front_post_input').each(function(index) {
					jQuery(this).val('');
					jQuery(this).trigger( 'blur' );
				});
				window.video_uploader.reset();
			
				jQuery('#video_content').val('');
				jQuery('#video_content_ifr').contents().find(".mceContentBody").html('');
			}
		
		jQuery("#ajax-indicator").hide();
		jQuery("#submit_video_btn").removeAttr("disabled");
		
		},
		error: function (xhr) {
			jQuery("#ajax-indicator").hide();
			alert(xhr);
		}
	});
}

function timeline_add_image_post(){
	//if(jQuery('#image_content-tmce').hasClass('active')){
		jQuery('#image_content-html').click();
		jQuery('#image_content-tmce').click();
		//}	
		/*disable the button to not submit the post twice*/
		
		jQuery("#submit_img_btn").attr("disabled", "disabled");
		
		jQuery("#ajax-indicator").show();
		jQuery('#not_logged_msg').hide();
		jQuery('#success_msg').hide();
		jQuery('#img_post_title_warning').hide();
		jQuery('#img_warning').hide();
		
		jQuery('#img_post_title').removeClass('invalid');
		jQuery('#image_url').removeClass('invalid');
		jQuery('#img_upload').removeClass('invalid');
		
		if( jQuery( '#form_timeline_photo textarea.timeline_text' ).val() == __( "What's on your mind?" ) ){
			jQuery( '#form_timeline_photo textarea.timeline_text' ).val( '' );
		}
		
		var data = jQuery('#form_timeline_photo').serialize();
		
		if( jQuery( '#form_timeline_photo input.timeline_title' ).val() == __( 'Add a title for your story' ) ){
			jQuery('#img_post_title_warning').html( __( 'Title is required' ) );
			jQuery('#img_post_title_warning').show();
			jQuery('#img_post_title').addClass('invalid');
			jQuery("#ajax-indicator").hide();
		}else jQuery.ajax({
			url: ajaxurl,
			data: data+'&action=add_image_post'+window.image_uploader.serialize(),
			type: 'POST',
			cache: false,
			success: function (data) {
				json = eval("(" + data + ")");
				if(json['error_msg'] && json['error_msg'] != ''){
					if(json['image_error'] != ''){ /*if image OR image link is invalid*/
						
						jQuery('#image_url').addClass('invalid');
						jQuery('#img_upload').addClass('invalid');
						
						window.image_uploader.show_error(json['image_error']);
			}
			
			if(json['title_error'] != ''){ /*If title is not set*/
				jQuery('#img_post_title_warning').html(json['title_error']);
				jQuery('#img_post_title_warning').show();
				jQuery('#img_post_title').addClass('invalid');
			}
			
			if(json['auth_error'] != ''){ /*is user is not logged in*/
				jQuery('#not_logged_msg').show();
			}
		}else{
			if( json[ 'success_msg' ] == __( 'Success. Your post is awaiting moderation' ) ){
				jQuery('#form_timeline_photo .success_msg').html(json['success_msg']);
				jQuery('#form_timeline_photo .success_msg').show();
			}else{
				var post_id = json[ 'post_id' ];
				jQuery.ajax({
					url:ajaxurl,
				data:'&action=get_new_timeline_post&post_id='+post_id,
				type: 'POST',
				cache: false,
				success: function( data ){
					jQuery( '.timeline div.timeline_is_empty' ).remove();
					jQuery( '.timeline .timeline_bg' ).show();
					jQuery( '.grid-view .seconddiv' ).prepend( data );
					jQuery( '.hovermore' ).mosaic();
				}
				});
			}
			
			/*clear inputs*/
			jQuery('.front_post_input').each(function(index) {
				jQuery(this).val('');
				jQuery(this).trigger( 'blur' );
			});
			window.image_uploader.reset();
			
			jQuery('#image_content').val('');
			jQuery('#image_content_ifr').contents().find(".mceContentBody").html('');
		}
		jQuery("#ajax-indicator").hide();
		jQuery("#submit_img_btn").removeAttr("disabled");
	},

		error: function (xhr) {
			jQuery("#ajax-indicator").hide();
			alert(xhr);
		}
	});	
}

function timeline_add_text_post(){
	jQuery('#text_content-html').click();
	jQuery('#text_content-tmce').click();
	
	jQuery("#submit_text_btn").attr("disabled", "disabled");
	
	jQuery("#ajax-indicator").show();
	jQuery('#not_logged_msg').hide();
	jQuery('#success_msg').hide();
	jQuery('#text_post_title_warning').hide();
	jQuery('#text_warning').hide();
	
	jQuery('#text_post_title').removeClass('invalid');
	
	if( jQuery( '#form_timeline_text textarea.timeline_text' ).val() == __( "What's on your mind?" ) ){
		jQuery( '#form_timeline_text textarea.timeline_text' ).val( '' );
	}
	
	var data = jQuery('#form_timeline_text').serialize();
	
	if( jQuery( '#form_timeline_text input.timeline_title' ).val() == __( 'Add a title for your story' ) ){
		jQuery('#text_post_title_warning').html( __( 'Title is required' ) );
		jQuery('#text_post_title_warning').show();
		jQuery('#form_timeline_text input.timeline_title').addClass('invalid');
		jQuery("#ajax-indicator").hide();
	}else jQuery.ajax({
		url: ajaxurl,
		data: data+'&action=add_text_post',
		type: 'POST',
		cache: false,
		success: function (data) {
			json = eval("(" + data + ")");
			if(json['error_msg'] && json['error_msg'] != ''){
				
				if(json['title_error'] != ''){ /*If title is not set*/
					jQuery('#text_post_title_warning').html(json['title_error']);
					jQuery('#text_post_title_warning').show();
					jQuery('#text_post_title').addClass('invalid');
				}
				
				if(json['auth_error'] != ''){ /*is user is not logged in*/
					jQuery('#not_logged_msg').show();
				}
			
			}else{
				if( json[ 'success_msg' ] == __( 'Success. Your post is awaiting moderation' ) ){
					jQuery('#form_timeline_text .success_msg').html(json['success_msg']);
					jQuery('#form_timeline_text .success_msg').show();
				}else{
					var post_id = json[ 'post_id' ];
					jQuery.ajax({
						url:ajaxurl,
						data:'&action=get_new_timeline_post&post_id='+post_id,
						type: 'POST',
						cache: false,
						success: function( data ){
							jQuery( '.timeline div.timeline_is_empty' ).remove();
							jQuery( '.timeline .timeline_bg' ).show();
							jQuery( '.grid-view .seconddiv' ).prepend( data );
							jQuery( '.hovermore' ).mosaic();
						}
					});
				}
				
				jQuery('.front_post_input').each(function(index) {
					jQuery(this).val( '' );
					jQuery(this).trigger( 'blur' );
				});
				
				jQuery('#text_content').val('');
				jQuery('#text_content_ifr').contents().find(".mceContentBody").html('');
			}
			jQuery("#ajax-indicator").hide();
			jQuery("#submit_text_btn").removeAttr("disabled");
		},
	
		error: function (xhr) {
			jQuery("#ajax-indicator").hide();
			alert(xhr);
		}
	});
}

var Cosmo_Uploader=
	{
		senders:new Array(),
		process_error:function(receiver,error)
			{
				this.senders[receiver].show_error(error);
			},
		upload_finished:function(receiver,params)
			{
				this.senders[receiver].upload_finished_with_success(params);
			},
		init:function()
		  {
			window.Cosmo_Uploader=this;
		  },
		Basic_Functionality:function(interface_id)
			{
				var object=new Object();
				object.interface_id=interface_id;
				object.attachments=new Array();
				object.thumbnail_ids=new Array();
				object.next_thumbnail_id=0;
				object.files_input_element=document.getElementById(object.interface_id).getElementsByTagName("input")[0];
				Cosmo_Uploader.senders[object.interface_id]=object;
				
				jQuery(object.files_input_element).change( function(){
					object.show_spinner();
					object.start_upload();
				});
				
				var multiple_files_upload=function()
					{
						var l=this.files_input_element.files.length;
						this.files_processed=0;
						this.files_total=l;
						jQuery("#"+this.interface_id+" .cui_spinner_container p").html(__("Uploading")+" "+l+" "+__("file")+(l==1?'':'s')+". "+__("This may take a while")+".");
						jQuery("#"+this.interface_id+" input[name*=\"method\"]").val("form");
						jQuery("#"+this.interface_id+" input[name*=\"action\"]").val("upload");
						jQuery("#"+this.interface_id+" input[name*=\"sender\"]").val(this.interface_id);
						jQuery("#"+this.interface_id+" form").submit();
						document.getElementById(this.interface_id).getElementsByTagName("form")[0].reset();
					}
				var single_file_upload=function()
					{
						jQuery("#"+this.interface_id+" .cui_spinner_container p").html(__("Uploading... Please wait."));
						jQuery("#"+this.interface_id+" input[name*=\"action\"]").val("upload");
						jQuery("#"+this.interface_id+" input[name*=\"sender\"]").val(this.interface_id);
						jQuery("#"+this.interface_id+" form").submit();
						document.getElementById(this.interface_id).getElementsByTagName("form")[0].reset();
					}
				if(object.files_input_element.files)
					object.start_upload=multiple_files_upload;
				else object.start_upload=single_file_upload;
				
				object.show_spinner=function()
					{
						jQuery( '#ajax-indicator' ).show();
						jQuery( object.files_input_element ).hide();
					}
				object.hide_spinner=function()
					{
						jQuery( '#ajax-indicator' ).hide();
						jQuery( object.files_input_element ).show();
					}
				object.show_error=function(error)
					{
						object.hide_spinner();
						jQuery("#"+object.interface_id+" .cui_error_container").append(error+"<br>");
					}
				object.remove=function(id)
					{
						if(!confirm(__("Are you sure?"))) return;
						var attach_id=this.thumbnail_ids[id];
						var thumbnail_id="thumbnail_"+id;
						var idx=jQuery.inArray(attach_id,this.attachments);
						if(idx!=-1)
						  {
							this.attachments.splice(idx,1);
						  }
						idx=jQuery.inArray(id,this.thumbnail_ids);
						if(idx!=-1)
						  {
							this.thumbnail_ids.splice(idx,1);
						  }
					  	var uri=Cosmo_Uploader.template_directory_uri;
						jQuery.ajax({
							url:uri+"/upload-server.php",
							type:"post",
							data:"action=delete&attach_id="+attach_id
						});
						jQuery("#"+this.interface_id+" #"+thumbnail_id).remove();
					}
				object.upload_finished_with_success=function(params)
					{
						this.hide_spinner();
						this.attachments.push(params["attach_id"]);
						var thumbnail_id_to_return=this.next_thumbnail_id;
						var thumbnail_id="thumbnail_"+this.next_thumbnail_id;
						this.thumbnail_ids[this.next_thumbnail_id]=params["attach_id"];
						this.next_thumbnail_id++;
					    var diff=50-params["h"];
						var append = "";
						append += '<div class="thumb-img" id="'+thumbnail_id+'">';
							append += '<div class="hovermore">';
								append += '<div class="details mosaic-overlay">';
									append += '<a href="javascript:void(0);" title="' + __( 'Use' ) + ' ' + params[ 'filename' ] + ' ' + __( 'as featured image' ) + '" class="feat_ref">';
										append += '<span class="feat"></span>';
									append += '</a>';
									append += '<a href="javascript:void(0);" title="'+ __( 'Delete' ) + ' ' + params[ 'filename' ] + '" class="remove_ref">';
										append += '<span class="del"></span>';
									append += '</a>';
								append += '</div>';
								append += '<img src="' + params[ 'url' ] + '" width="' + params[ 'w' ] + '" height="' + params[ 'h' ] + '" alt="' + params[ 'filename' ] + '" style="margin-top:' + diff + 'px">';
							append += '</div>';
						append += '</div>';
						jQuery("#"+this.interface_id+" .thumbnails").append(append);
						var jthis=this;
						
						jQuery("#"+this.interface_id+" #"+thumbnail_id+" .remove_ref").click(function()
							{
							  jthis.remove(thumbnail_id_to_return);
							});
						
						jQuery( '.hovermore' ).mosaic();
						return thumbnail_id_to_return;
					}
				object.serialize=function()
					{
						var querydata="";
						var id;
						for(id=0;id<this.attachments.length;id++)
							{
								querydata+="&attachments[]="+encodeURIComponent(this.attachments[id]);
							}
						 return querydata;
					}
				object.reset=function(){
					jQuery("#"+this.interface_id+" .thumb-img").remove();
					object.attachments=new Array();
					object.thumbnail_ids=new Array();
					object.next_thumbnail_id=0;
				}
				return object;
			},
		
		 Featured_Functionality:function(object)
			  {
				object.inherited_upload_finished_with_success=object.upload_finished_with_success;
				object.upload_finished_with_success=function(params)
					{
						var tid=this.inherited_upload_finished_with_success(params);
						var thumbnail_id="thumbnail_"+tid;
						var jthis=this;
						if(jQuery("#"+this.interface_id+" .thumb-img").length==1)
							{
							  jthis.set_featured(tid);
							}
						jQuery("#"+this.interface_id+" #"+thumbnail_id+" .feat_ref").click(function()
							{
							  jthis.set_featured(tid);
							});
					}
				object.set_featured=function(id)
					{
						this.featured=this.thumbnail_ids[id];
						var thumbnail_id="thumbnail_"+id;
					    jQuery("#"+this.interface_id+" .thumb-img").removeClass( 'feat' );
						jQuery("#"+this.interface_id+" #"+thumbnail_id).addClass( 'feat' );
						
					}
				object.inherited_remove=object.remove;
				object.remove=function(id)
				{
					this.inherited_remove(id);
					if(this.featured==this.thumbnail_ids[id])
						{
						  var i;
						  for(i=0;i<this.attachments.length;i++)
							{
							  if(this.attachments[i])
								{
								  var thumbnail_id=jQuery.inArray(this.attachments[i],this.thumbnail_ids);
								  this.set_featured(thumbnail_id);
								  break;
								}
							}
						}
				}
				object.inherited_serialize=object.serialize;
				object.serialize=function()
				  {
					return this.inherited_serialize()+"&featured="+(this.featured?this.featured:'');
				  }
				object.inherited_reset=object.reset;
				object.reset=function(){
					this.inherited_reset();
					this.featured=false;
				}
				return object;
			  },
		Video_Functionality:function(object)
		  {
			object.video_urls=new Array();
			object.inherited_serialize=function()
			{
			  var querydata="";
			  var id;
			  for(id=0;id<this.attachments.length;id++)
				{
					querydata+="&attachments[]="+encodeURIComponent(this.attachments[id]);
					if(this.video_urls[this.attachments[id]])
					  querydata+="&video_urls["+object.attachments[id]+"]="+encodeURIComponent(this.video_urls[this.attachments[id]]);
				}
			  return querydata;
			}
			object.inherited_inherited_upload_finished_with_success=object.upload_finished_with_success;
			object.upload_finished_with_success=function(params)
			{
			  this.inherited_inherited_upload_finished_with_success(params);
			  if(params["video_url"])
				object.video_urls[params["attach_id"]]=params["video_url"];
			}
			object.inherited_inherited_remove=object.remove;
			object.remove=function(id)
			{
			  this.inherited_inherited_remove(id);
			  var attach_id=this.thumbnail_ids[id];
			  var idx=jQuery.inArray(attach_id,this.video_urls);
			  if(idx!=-1)
				{
				  this.video_urls.splice(idx,1);
				}
			}
		  }
	}
	
jQuery( function(){
	if( jQuery( '#mini-form' ).length > 0 ){
		Cosmo_Uploader.init();
		
		if( jQuery( '#photo_upload' ).length > 0 ){
			window.image_uploader = Cosmo_Uploader.Basic_Functionality( 'photo_upload' );
			Cosmo_Uploader.Featured_Functionality( window.image_uploader );
		}
		
		if( jQuery( '#audio_upload' ).length > 0 ){
			window.audio_uploader = Cosmo_Uploader.Basic_Functionality( 'audio_upload' );
		}
		
		if( jQuery( '#video_upload' ).length > 0 ){
			window.video_uploader = Cosmo_Uploader.Basic_Functionality( 'video_upload' );
			Cosmo_Uploader.Featured_Functionality( window.video_uploader );
			Cosmo_Uploader.Video_Functionality( window.video_uploader );
		}
		
		// Textarea resize
		jQuery('textarea.timeline_text').autoResize({
			// On resize:
			onResize : function() {
				jQuery(this).css({opacity:1});
			},
			// After resize:
			animateCallback : function() {
				jQuery(this).css({opacity:1});
			},
			// Quite slow animation:
			animateDuration : 300,
			// More extra space:
			extraSpace : 40
		});
	}
	
	jQuery( '.miniform_to_hide' ).hide();
	
	jQuery( 'textarea.timeline_text' ).click( function(){
		jQuery( '.miniform_to_hide' ).show();
	});
	
	jQuery( 'textarea.timeline_text' ).focus( function(){
		jQuery( '.miniform_to_hide' ).show();
	});
});