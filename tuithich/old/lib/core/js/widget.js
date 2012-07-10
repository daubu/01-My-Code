
var widget = new Object();

widget.r = function( method , args , selector ){
    tools.init = function( result ){
        jQuery( selector ).html( result );
        field.vr.init();
    }
    
    tools.r( 'widget_load' , method , args );
}

jQuery(function(){
	if( jQuery( "#widget-list" ).length>0 ){
		jQuery( "#widget-list .widget-title h4" ).each(function(index,element){
			if(jQuery(element).html().indexOf("CosmoTheme")!=-1){
				var html=jQuery(element).parents( ".widget" ).find( ".widget-description" ).html();
				//JS .replace replaces only the first occurence, so we'll need a regular expression
				var openingTag=new RegExp( "&lt;" , 'g' ); // g means 'replace all occurences'
				var closingTag=new RegExp( "&gt;" , 'g' );
				html=html.replace( openingTag , "<" ).replace( closingTag , ">" );
				jQuery(element).parents( ".widget" ).find( ".widget-description" ).html(html);
			}
		});
	}
	
	if( jQuery( ".sidebar-cosmo-mainpage-content" ).length > 0 ){
		jQuery( ".sidebar-cosmo-mainpage-content" ).each( function( index , element ){
			var html=jQuery(element).find( ".description" ).html();
			//JS .replace replaces only the first occurence, so we'll need a regular expression
			var openingTag=new RegExp( "&lt;" , 'g' ); // g means 'replace all occurences'
			var closingTag=new RegExp( "&gt;" , 'g' );
			html=html.replace( openingTag , "<" ).replace( closingTag , ">" );
			jQuery(element).find( ".description" ).html(html);
		});
	}
});