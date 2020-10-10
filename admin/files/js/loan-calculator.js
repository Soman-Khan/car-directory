"use strict";
jQuery( function() {
	// Rate****
  jQuery( "#slider-range-min" ).slider({
    range: "min",
    value: 10,
    min: 1,
    max: 30,
    slide: function( event, ui ) {
      jQuery( "#total-amount" ).html(ui.value + "%" );
		var interestrate = parseInt(jQuery( "#interest-rate" ).val());
		var years = parseInt(jQuery( "#input-year" ).val());
		var amount_main = parseInt(jQuery( "#total-amount" ).val()) -parseInt(jQuery( "#input-down-payment" ).val());
		mortgage_calculator(interestrate, years,amount_main);
    }
  });
  jQuery( "#total-amount" ).html( jQuery( "#slider-range-min" ).slider( "value" ) + "%" );
//for total price
  jQuery( "#slider-total-amount" ).slider({
    range: "min",
    value: realpro_data_loan.listingprice,
    min: 1000,
    max: realpro_data_loan.maxprice ,
    slide: function( event, ui ) {
      jQuery( "#total-amount" ).val(ui.value + "" );
		var interestrate = parseInt(jQuery( "#interest-rate" ).val());
		var years = parseInt(jQuery( "#input-year" ).val());
		var amount_main = parseInt(jQuery( "#total-amount" ).val()) -parseInt(jQuery( "#input-down-payment" ).val());
		mortgage_calculator(interestrate, years,amount_main);
    }
  });
  jQuery( "#total-amount" ).val( jQuery( "#slider-total-amount" ).slider( "value" ) + "" );
//for loan period
  jQuery( "#slider-range-min-3" ).slider({
    range: "min",
    value: 10,
    min: 1,
    max: 30,
    slide: function( event, ui ) {
      jQuery( "#input-year" ).val(ui.value + "" );
		var interestrate = parseInt(jQuery( "#interest-rate" ).val());
		var years = parseInt(jQuery( "#input-year" ).val());
		var amount_main = parseInt(jQuery( "#total-amount" ).val()) -parseInt(jQuery( "#input-down-payment" ).val());
		mortgage_calculator(interestrate, years,amount_main);
    }
  });
  jQuery( "#input-year" ).val( jQuery( "#slider-range-min-3" ).slider( "value" ) + "" );
  //for down payment
    jQuery( "#slider-down-payment" ).slider({
      range: "min",
      value: 30,
      min: 1,
      max: 99,
      slide: function( event, ui ) {
		jQuery( ".percentage" ).html(ui.value + " %" );
		var downpayment= jQuery( "#total-amount" ).val() * ui.value/100;
        jQuery( "#input-down-payment" ).val(Math.round(downpayment));
		var interestrate = parseInt(jQuery( "#interest-rate" ).val());
		var years = parseInt(jQuery( "#input-year" ).val());
		var amount_main = parseInt(jQuery( "#total-amount" ).val()) -parseInt(jQuery( "#input-down-payment" ).val());
		mortgage_calculator(interestrate, years,amount_main);
      }
    });
	 var downpayment= jQuery( "#total-amount" ).val()* jQuery( "#slider-down-payment" ).slider( "value" )/100;
    jQuery( "#input-down-payment" ).val(downpayment);
//interest rate
    jQuery( "#slider-range-min-5" ).slider({
      range: "min",
      value: 10,
      min: 1,
      max: 30,
      slide: function( event, ui ) {
        jQuery( "#interest-rate" ).val(ui.value + "%" );
			var interestrate = parseInt(jQuery( "#interest-rate" ).val());
			var years = parseInt(jQuery( "#input-year" ).val());
			var amount_main = parseInt(jQuery( "#total-amount" ).val()) -parseInt(jQuery( "#input-down-payment" ).val());
			mortgage_calculator(interestrate, years,amount_main);
      }
    });
    jQuery( "#interest-rate" ).val( jQuery( "#slider-range-min-5" ).slider( "value" ) + "%" );
	// mortgage_calculator******************
	var interestrate = parseInt(jQuery( "#interest-rate" ).val());
	var years = parseInt(jQuery( "#input-year" ).val());
	var amount_main = parseInt(jQuery( "#total-amount" ).val()) -parseInt(jQuery( "#input-down-payment" ).val());
	mortgage_calculator(interestrate, years,amount_main);
});
function mortgage_calculator(rate, time_main,amount_main){
	var time= time_main *12;
	rate= rate/1200
	var per_monthamount_main = rate * -amount_main * Math.pow((1 + rate), time) / (1 - Math.pow((1 + rate), time));
	var per_monthamount =per_monthamount_main.format();
  jQuery("#Monthly-Payment" ).html(per_monthamount);
  jQuery("#yearstitle" ).html(time_main);
  var total_pay =per_monthamount_main *time;
  total_pay= total_pay.format(); 
  jQuery("#total-payable" ).html( total_pay );
  var principle_amount= amount_main;
  var interest_total= (per_monthamount_main *time) - parseInt(amount_main);
  var interestper =(interest_total /(per_monthamount_main *time))*100 ;
  var principleper =(amount_main /(per_monthamount_main *time) )*100;
  jQuery("#Interestper" ).html(Math.round(interestper)+'%');
  jQuery("#Principleper" ).html(Math.round(principleper)+'%');
}
jQuery(function() {
	jQuery('#total-amount , #input-year, #input-down-payment, #interest-rate').keyup(function(){
			// mortgage_calculator******************
			var interestrate = parseInt(jQuery( "#interest-rate" ).val());
			var years = parseInt(jQuery( "#input-year" ).val());
			var amount_main = parseInt(jQuery( "#total-amount" ).val()) -parseInt(jQuery( "#input-down-payment" ).val());
			mortgage_calculator(interestrate, years,amount_main);
	});
});
Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};