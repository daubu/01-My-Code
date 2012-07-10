<?php
    global  $post;
?>
<script>
    function ifVal( id ){
        var value = '';
        var $ival = jQuery('#contact_container').contents().find( id );
        value = $ival.val();
        if( $ival.attr('type') == 'checkbox' ){
            if( $ival.is(':checked') ){

            }else{
                value = '';
            }
        }

        return value;
    }

    function addContactForm( ){
	
		var contact = '';
		if(ifVal( '#hidde_map' ) != 'yes'){
			contact = contact + '[contact lat="'+ ifVal('#map_lat') +'" lng="'+ ifVal('#map_lng') +'" clat="'+ ifVal('#map_clat') +'" clng="'+ ifVal('#map_clng') +'" zoom="'+ ifVal('#map_zoom') +'"';
		}else{
			contact = contact + '[contact ';
		}	
        contact = contact + ' title="'+ ifVal('#map_title') +'"  description="'+ ifVal('#map_description') +'" phone1="'+ ifVal('#map_phone1') +'"  phone2="'+ ifVal('#map_phone2') +'"';
        contact = contact + ' fax="'+ ifVal('#map_fax') +'" email="'+ ifVal('#map_email') +'" hidde_contact="' + ifVal('#hidde_contact') + '"]';
        var mssg = ifVal('#message');
        if( mssg.toString().length > 0 ){
            contact = contact + mssg + '[/contact]';
        }

        Editor.AddText( "content" , "\n"+ contact +"\n");
        showNotify();
    }
</script>

<div class="contact_form">
    <p><?php _e( 'Drag and drop the marker location. To use google map, set the key in panel management' , _DEV_ )?> <a href="admin.php?page=cosmothemes__social"><?php _e('here' , _DEV_ ); ?></a></p>
    <iframe src="admin-ajax.php?action=get_contact_map&amp;id=<?php echo $post -> ID; ?>&amp;type=<?php echo $post -> post_type; ?>" id="contact_container" style="width:960px; height:470px;" scrolling="no"  >
        <p><?php _e('Your browser does not support iframes.' , _DEV_ ); ?></p>
    </iframe>
    <p>
        <input type="button" class="button-primary" value="<?php _e( 'Insert Contact Form' , _DEV_ ); ?>"  id='insert_quote_btn' onclick='javascript:addContactForm();' style="margin-left:18px;"/>
    </p>
</div>