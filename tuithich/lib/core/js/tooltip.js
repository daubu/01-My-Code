
var tooltip = new Object();

tooltip.vr = {
    'action' : 'tooltip_load',
    'cnt' : '.tooltips-container',
    'init': function(){
        jQuery(function(){
            /* custom post action box */
            jQuery('div.tooltips-container div.tooltip').each(function(){
                jQuery( this ).hover(function(){
                    jQuery( this ).children( 'div.tooltip-actionbox' ).show();
                    jQuery( this ).find('div.tooltip-actionbox ul li a').click(function(){
                        jQuery( this ).parent().parent().parent().hide( 'fast' );
                    });
                });
                jQuery( this ).mouseleave( "hover" , function(){
                    jQuery( this ).children( 'div.tooltip-actionbox' ).hide( 'fast' );
                });
            });
        });
    }
};

tooltip.r = function( method , args ){
    tools.init = function( result ){
        if( jQuery.trim( result ) == 'error' ){
            field.vr.mssg = false;
            field.mssg( 'span.result-mssg' );
            return 0;
        }else{
            field.vr.mssg = true;
            field.mssg('span.result-mssg');
            
            if( method == 'add' ){
                field.clean( 'div.tooltip-addbox' );
            }
        }
        jQuery( tooltip.vr.cnt ).html( result );
        field.vr.init();
        tooltip.vr.init();
        
    };
    tools.r( tooltip.vr.action , method , args );
}

tooltip.sort = function(){
	var data='';
	jQuery( document ).ready(function(){
		jQuery( tooltip.vr.cnt ).children( 'div.tooltip' ).each(function( new_id, element ){
			var old_id = jQuery( element ).find( '.tooltip-id' ).val();
			if( new_id > 0 ){
				data+=';';
			}
			data+=old_id+'=>'+new_id;
		});
		tools.init = function( result ){
			jQuery( tooltip.vr.cnt ).html( result );
			field.vr.init();
			tooltip.vr.init();
		};
		tools.r( tooltip.vr.action , 'sort' , new Array( data ) );
	});
}

tooltip.load = function( resources , method , args , selector1 , selector2  ){
	jQuery(function(){
		jQuery.post( ajaxurl , {
			"action" : resources.vr.action,
			"method" : method,
			"args" : args
		} ,
		function( result ){
			if( jQuery( selector2 ).length ){
				jQuery( selector2 ).remove();
			}
			jQuery( selector1 ).append( result );
			field.s( selector2 );
			resources.vr.init();
			field.vr.init();
		});
	});
}