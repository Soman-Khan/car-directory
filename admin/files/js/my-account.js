"use strict";
jQuery(document).ready(function($) {
	if (jQuery("#alllistingdata")[0]){	
		jQuery('#alllistingdata').show();				
		var oTable2 = jQuery('#alllistingdata').dataTable({
			 "language": {		
					"sProcessing": 		realpro.sProcessing ,  
					"sSearch": 				realpro.sSearch ,   
					"lengthMenu":			realpro.lengthMenu ,
					"zeroRecords": 		realpro.zeroRecords,
					"info": 					realpro.info,
					"infoEmpty": 			realpro.infoEmpty,
					"infoFiltered":		realpro.infoFiltered ,
					"oPaginate": {
							"sFirst":   	realpro.sFirst,
							"sLast":    	realpro.sLast,
							"sNext":   		realpro.sNext ,
							"sPrevious":	realpro.sPrevious,
							},
					}
		});
		oTable2.fnSort( [ [1,'DESC'] ] );
		
	}
});

jQuery(document).ready(function($) {
	if (jQuery("#interest-user-data")[0]){
			jQuery(window).on('load',function(){
				jQuery('#interest-user-data').show();				
				var oTable = jQuery('#interest-user-data').dataTable();
				oTable.fnSort( [ [1,'DESC'] ] );
			});	
	}		
	if (jQuery(".popup-contact")[0]){
		jQuery(".popup-contact").colorbox({transition:"None", width:"50%", height:"50%" ,opacity:"0.70"});
	}
});	
jQuery(document).ready(function($) {
		jQuery('[href^=#tab]').on("click", function (e) {
		  e.preventDefault()
		 jQuery(this).tab('show')
		});
})	
	
		  
	function edit_profile_image(profile_image_id){	
	var image_gallery_frame;
		
				
					image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
							// Set the title of the modal.
							title: realpro.SetImage	,
							button: {
									text: realpro.SetImage,
							},
							multiple: false,
							displayUserSettings: true,
					});                
					image_gallery_frame.on( 'select', function() {
							var selection = image_gallery_frame.state().get('selection');
							selection.map( function( attachment ) {
									attachment = attachment.toJSON();
									if ( attachment.id ) {
				console.log(attachment.url);
				var ajaxurl = realpro.ajaxurl;	
				var search_params = {
					"action": 	"iv_property_update_profile_pic",
					"attachment_thum": attachment.url,
					"profile_pic_url_1": attachment.url,
					"_wpnonce":  	realpro.dirwpnonce,
				};
											 jQuery.ajax({
							url: ajaxurl,
							dataType: "json",
							type: "post",
							data: search_params,
							success: function(response) {   
								if(response=='success'){					
									
									jQuery('#'+profile_image_id).html('<img  class="img-circle img-responsive"  src="'+attachment.sizes.thumbnail.url+'">');                              
			

								}
								
							}
						});									
												
			}
		});
						 
					});               
	image_gallery_frame.open(); 
	
}
				
function update_profile_setting (){

var ajaxurl =realpro.ajaxurl;
var loader_image = realpro.loading_image;
		jQuery('#update_message').html(loader_image); 
		var search_params={
			"action"  : 	"iv_property_update_profile_setting",	
			"form_data":	jQuery("#profile_setting_form").serialize(), 
			"_wpnonce":  	realpro.dirwpnonce,
		};
		jQuery.ajax({					
			url : ajaxurl,					 
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				jQuery('#update_message').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
				
			}
		});

}	
function iv_update_hide_setting (){
	
var ajaxurl =realpro.ajaxurl;
var loader_image = realpro.loading_image;
				jQuery('#update_message_hide').html(loader_image);
				var search_params={
					"action"  : 	"iv_property_update_setting_hide",	
					"form_data":	jQuery("#setting_hide_form").serialize(), 
					"_wpnonce":  	realpro.dirwpnonce,
				};
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						
						jQuery('#update_message_hide').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
						
					}
				});
	
	} 
function iv_update_fb (){
	
var ajaxurl =realpro.ajaxurl;
var loader_image = realpro.loading_image;
				jQuery('#update_message_fb').html(loader_image);
				var search_params={
					"action"  : 	"iv_property_update_setting_fb",	
					"form_data":	jQuery("#setting_fb").serialize(),
					"_wpnonce":  	realpro.dirwpnonce,	
				};
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						
						jQuery('#update_message_fb').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
						
					}
				});
	
	}	
function iv_update_password (){
	
var ajaxurl =realpro.ajaxurl;
var loader_image = realpro.loading_image;
				jQuery('#update_message_pass').html(loader_image);
				var search_params={
					"action"  : 	"iv_property_update_setting_password",	
					"form_data":	jQuery("#pass_word").serialize(), 
					"_wpnonce":  	realpro.dirwpnonce,
				};
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						
						jQuery('#update_message_pass').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
						
					}
				});
	
	}	

			  
jQuery(".nav-tabs a").on("click", function(){
     jQuery(this).tab('show');
 });		  
function send_message_iv(){	
	if (jQuery.trim(jQuery("#message-content").val()) == "") {
								alert("Please put your message");
			} else {    
		var ajaxurl =realpro.ajaxurl;
		var loader_image = realpro.loading_image;
			jQuery('#update_message_popup').html(loader_image); 
			var search_params={
				"action"  : 	"iv_property_message_send",	
				"form_data":	jQuery("#message-pop").serialize(), 
				"_wpnonce":  	realpro.contact,
			};
			
			jQuery.ajax({					
				url : ajaxurl,					 
				dataType : "json",
				type : "post",
				data : search_params,
				success : function(response){ 
										
					jQuery('#update_message_popup').html(response.msg );
					jQuery("#message-pop").trigger('reset');
					
				}
			});
	}	
	
}
var ajaxurl =realpro.ajaxurl;
	function load_note_dir(h_id, note){
		
		jQuery("#dir_"+h_id).attr("class", "addnote row");
		
		jQuery("#dir_"+h_id).html('<div class="col-md-10 col-lg-10 col-sm-10 col-xs-12"><textarea cols="" class="form-control" id="note_'+h_id+'" rows="3">'+note+'</textarea></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><div><input type="button" value="Cancel" onclick="cancel_note('+h_id+');" class="btn btn-default btn-sm"/></div><div style="margin-top:5px"><input type="button" value=" &nbsp;&nbsp;Save&nbsp;&nbsp; " onclick="save_note('+h_id+');return false;" class="btn btn-primary btn-sm"/> </div></div>');
	}	
	
	function save_note(h_id){
			
			var ajaxurl =realpro.ajaxurl;
			var loader_image = realpro.loading_image;
			
			if (jQuery.trim(jQuery("#note_"+h_id).val()) == "") {
                        alert("Please Put some comments");
              } else {                        
                        jQuery('#update_message').html(loader_image); 
						var search_params={
								"action"  : 	"iv_property_save_note",	
								"data": "id="+h_id+"&note="+jQuery("#note_"+h_id).val(),
								"_wpnonce":  	realpro.dirwpnonce,
						};						
						jQuery.ajax({					
							url : ajaxurl,					 
							dataType : "json",
							type : "post",
							data : search_params,
							success : function(response){ 
								jQuery('#update_message').html('');
								if (response.msg=="success") {                                  
                                    var note_save='<div class="col-lg-12 col-sm-12 col-xs-12"> Note : '+jQuery("#note_"+h_id).val() +'</div>';
                                    jQuery("#dir_"+h_id).html(note_save);                                                                
                                } else {
                                    alert('Try later');
                                }
								
							}
						});
                        
                        
                        
             }
	
	
	}
	
	function cancel_note(h_id){
		
		var note_cancel='Note : '+$("#note_"+h_id).val();
		jQuery("#dir_"+h_id).attr("class", " row");		
		jQuery("#dir_"+h_id).html(note_cancel);
	}
	function close_his(h_id){								
				var search_params={
						"action"  : 	"iv_property_delete_favorite",	
						"data": "id="+h_id,
						"_wpnonce":  	realpro.dirwpnonce,
				};						
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){ 
						jQuery('#update_message').html('');
						if (response.msg=="success") {                                  
															 jQuery("#main_"+h_id).fadeOut(800, function(){ jQuery(this).remove();});                        
														} else {
																alert('Try later');
														}
						
					}
				});
	}

function iv_cancel_membership_paypal (){
	
	 if (confirm('Are you sure to cancel this Membership?')) {
			var ajaxurl =realpro.ajaxurl;
			var loader_image = realpro.loading_image;
					jQuery('#update_message_paypal').html(loader_image);
					var search_params={
						"action"  : 	"iv_property_cancel_paypal",	
						"form_data":	jQuery("#paypal_cancel_form").serialize(), 
						"_wpnonce":  	realpro.dirwpnonce,
					};
					jQuery.ajax({					
						url : ajaxurl,					 
						dataType : "json",
						type : "post",
						data : search_params,
						success : function(response){
							if(response.code=='success'){
								jQuery('#paypal_cancel_div').hide(); 
								jQuery('#update_message_paypal').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
							
							}else{
								jQuery('#update_message_paypal').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
							
							}
							
						}
						
					});
		}			
	
	}  

  function iv_cancel_membership_stripe (){
	
	 if (confirm('Are you sure to cancel this Membership?')) {
			var ajaxurl =realpro.ajaxurl;
			var loader_image = realpro.loading_image;
					jQuery('#update_message_stripe').html(loader_image);
					var search_params={
						"action"  : 	"iv_property_cancel_stripe",	
						"form_data":	jQuery("#profile_cancel_form").serialize(),
						"_wpnonce":  	realpro.dirwpnonce,
					};
					jQuery.ajax({					
						url : ajaxurl,					 
						dataType : "json",
						type : "post",
						data : search_params,
						success : function(response){
							jQuery('#stripe_cancel_div').hide(); 
							jQuery('#update_message_stripe').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
							
						}
					});
		}			
	
	}

jQuery(function(){	
jQuery('#package_sel').on('change', function (e) {
	
	var optionSelected = jQuery("option:selected", this);
	var pack_id = this.value;
	
	jQuery("#package_id").val(pack_id);
							
	var ajaxurl =realpro.ajaxurl;
	var loader_image = realpro.loading_image;
	var search_params={
	"action"  			: "iv_property_check_package_amount",	
	"coupon_code" 		:jQuery("#coupon_name").val(),
	"package_id" 		: pack_id,
	"package_amount" 	:'',
	"api_currency" 		:realpro.currencyCode,
	 "_wpnonce":  	 realpro.signup,
	};
	jQuery.ajax({					
		url : ajaxurl,					 
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){			
			jQuery('#p_amount').html(response.p_amount);							
			
		}
		});
	});	
});	
						  