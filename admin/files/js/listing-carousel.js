"use strict";
jQuery(document).ready(function(){
  jQuery('#multiple-items'+realpro_data10.rand_div).slick({
    arrows: true,
    dots: false,
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    nextArrow: '#next1'+realpro_data10.rand_div,
    prevArrow: '#previous1'+realpro_data10.rand_div,
    responsive: [{
        breakpoint: 1024,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: false
        }
    }, {
        breakpoint: 770,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2
        }
    }, {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }]
  });
});	