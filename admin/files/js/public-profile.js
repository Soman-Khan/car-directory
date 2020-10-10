 "use strict";
(function($){
    jQuery(window).load(function() {
				"use strict";	
        jQuery('.home-img').find('img').each(function() {
            var imgClass = (this.width / this.height > 1) ? 'wide' : 'tall';
            jQuery(this).addClass(imgClass);
        })    
    })
   }); 