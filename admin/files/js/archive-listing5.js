"use strict";
var count = 0;
document.querySelector(".filter").addEventListener("click", function(){
	if(count===0){
		document.querySelector("#facets").style.display="block";
		count=1;
	}
	else{
		document.querySelector("#facets").style.display="none";
		count=0;
	}
});
  jQuery(function(){
					var settings='';
          var item_template =
           '<div class="item">' +
            '<div class="dirpro-list-img">'+'<% if (obj.featured) {  %> <span class="feature-text">'+dirpro_data.featured+'</span><% } %>' +'<a href="<%= obj.link %>">' +
                '<img class="img img-fluid w-100" src="<%= obj.imageURL %>">' +
             '</a>'+
			 '</div>' +
             '<div class="list-content">' +
				'<a href="<%= obj.link %>"><h4 class="name"><%= obj.price %> <small><%= obj.type %></small></h4></a>' +
                 '<a href="<%= obj.link %>"><h4 class="name">BMW M4</h4></a>' +
                 '<p class="tags">' +
                    '<span class="mr-2">'+
    				     '<i class="fas fa-tachometer-alt"></i> 1800HP' +
                     '</span>'+
                     '<span class="mr-2">'+
     				     '<i class="fas fa-gas-pump"></i> Hybrid' +
                      '</span>'+
                      '<span class="mr-2">'+
      				     '<i class="fas fa-cogs"></i> Automatic' +
                      '</span>'+
                     '<span>'+
       				     '<i class="fas fa-road"></i> 13kmpl' +
                     '</span>'+
                 '</p>' +
                 '<p class="category">' +
                 '<span class="mr-2">'+
                      '<i class="fas fa-car-side"></i> Sedan' +
                  '</span>'+
                  '<span class="mr-2">'+
                      '<i class="fas fa-car-crash"></i> Antilock Brakes' +
                   '</span>'+
                   '<span class="mr-2">'+
                      '<i class="fas fa-chair"></i> Heated Seats' +
                   '</span>'+
                  '<span>'+
                      '<i class="fas fa-oil-can"></i> 20L' +
                  '</span>'+
                 '</p>' +
                 '<% if(obj.review_show >="yes" ){%>  <p class="author-star">' +
                    '<span class="star-icons">' +
						'<% if(obj.avg_review >=.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +
						'<% if(obj.avg_review >=1.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=1.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +
						'<% if(obj.avg_review >=2.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=2.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +
						'<% if(obj.avg_review >=3.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=3.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +
						'<% if(obj.avg_review >=4.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=4.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +

                    '</span>' +
                 '</p><%}else{ %><p class="blankp"> </p> <%} %>' +
                 '<p class="client-contact">' +
                  '<% if (obj.call_button=="yes") {  %> <span class="number"><span onclick="show_phonenumber(\''+'<%= obj.phone %>'+'\',<%= obj.id %>)" class="call" id="<%= obj.id %>">'+dirpro_data2.call+'</span></span><span class="mcall"><a href="tel:<%= obj.phone %>">'+dirpro_data2.call+'</a></span> <% } %>' +
                   '<% if (obj.email_button=="yes") {  %><span class="email" onclick="call_popup(<%= obj.id %>)">'+dirpro_data2.email+'</span><% } %>' +
                   '<% if (obj.sms_button=="yes") {  %> <span class="sms"><a href="sms:<%= obj.phone %>?&body='+dirpro_data2.SMSbody+'">'+dirpro_data2.SMS+'</a></span><% } %>' +
                 '</p>' +
             '</div>' +
             '<div class="clearboth"></div>' +
           '</div>';
        settings = {
          items            : jQuery.parseJSON(dirpro_data2.dirpro_items),
          facets           : jQuery.parseJSON(dirpro_data2.facets_json),
          resultSelector   : '#results',
          facetSelector    : '#facets',
          resultTemplate   : item_template,
          paginationCount  : dirpro_data2.perpage,
          orderByOptions   :  {'title':dirpro_data2.title , 'category': dirpro_data2.category, 'RANDOM': dirpro_data2.random},
          facetSortOption  : {'continent': ["North America", "South America"]}
        }


        jQuery.facetelize(settings);

      });
function show_phonenumber(phone,id){
	jQuery("#"+id).replaceWith(phone);
}
function contact_close(){
	jQuery.colorbox.close();
}
function call_popup(dir_id){
			var contactform = dirpro_data2.wp_iv_property_URLPATH+'/template/property/contact_popup.php?&dir_id='+dir_id;
			jQuery.colorbox({href: contactform,opacity:"0.70",closeButton:false,})

}
function contact_send_message_iv(){

		var formc = jQuery("#message-pop");
		if (jQuery.trim(jQuery("#email_address",formc).val()) == "" || jQuery.trim(jQuery("#name",formc).val()) == "" || jQuery.trim(jQuery("#message-content",formc).val()) == "") {
						alert(dirpro_data2.message);
        } else {
			var ajaxurl = dirpro_data2.ajaxurl;
			var loader_image =  dirpro_data2.loading_image;
				jQuery('#update_message_popup').html(loader_image);
				var search_params={
					"action"  : 	"iv_property_message_send",
					"form_data":	jQuery("#message-pop").serialize(),
					"_wpnonce":  	 dirpro_data2.contact,
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
