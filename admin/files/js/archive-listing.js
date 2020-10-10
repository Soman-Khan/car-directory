"use strict";
var ajaxurl = realpro_data.ajaxurl;
var loader_image = realpro_data.loading_image;
var paged =1;
function wpdirp_loadmore(){ 
	paged = paged+1;
	var ajaxurl = realpro_data.ajaxurl;
	jQuery('#load-more').hide();
	jQuery('#dirpro_loadmore').show();		
	var search_params={
		"action"  : 	"iv_property_loadmore",	
		"form_data":	jQuery("#dirprosearch").serialize(), 	
		"paged": paged,	
		"_wpnonce":  	 realpro_data.dirwpnonce,
	};
	jQuery.ajax({					
		url : ajaxurl,					 
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){ 	
			jQuery("#js-grid-meet-the-team").cubeportfolio('append', response.data);	
			jQuery('#dirpro_loadmore').hide();		
			if(response.loadmore=='hide'){ 
				jQuery('#loadmore_button').html('<h3></h3>'); 
				}else{
				jQuery('#load-more').show();
			}	
		}
	});			
}		
var isOpen = 0;
var advance = document.getElementById('advance');
var advanceRow = document.querySelector('#top-search-form-advance-row');
advance.addEventListener('click', function(){
	if(isOpen === 0){
		advanceRow.style.visibility = "visible";
		advanceRow.style.height = "auto";
		advanceRow.style.width = "auto";
		isOpen = 1;
	}
	else{
		advanceRow.style.visibility = "hidden";
		advanceRow.style.height = "0";
		advanceRow.style.width = "0";
		isOpen = 0;
	}
});