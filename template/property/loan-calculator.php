<?php
  $max_price=str_replace(",", "", get_post_meta($id,'sale_or_rent_price',true)); 
  $max_price=(int)$max_price + 3000000;
  wp_enqueue_style('iv_property-loan-calculator-c', wp_iv_property_URLPATH . 'admin/files/css/loan-calculator.css');
  wp_enqueue_script('iv_property-loan-calculator-js', wp_iv_property_URLPATH . 'admin/files/js/loan-calculator.js');
  wp_localize_script('iv_property-loan-calculator-js', 'realpro_data_loan', array(
  'listingprice' => (int) str_replace(",", "", get_post_meta($id,'sale_or_rent_price',true)),
  'maxprice'		  => (int)$max_price,
  ) );
?>
<div class="col-md-12 border rounded">
  <div class="row">
    <div class="col-md-9  py-3">
      <div class="totalPrice">
        <label class="p-0 m-0"><?php  esc_html_e('Total Price','ivproperty'); ?></label>
        <div class="d-flex justify-content-between p-0 m-0">
          <div id="slider-total-amount"></div>                 
          <div id="total-price" class="p-0 m-0 d-flex">
            <input id="total-amount" type="text" value="<?php echo number_format((int)get_post_meta($id,'sale_or_rent_price',true));?>">
            <span class="tprice"><?php echo get_post_meta($id,'price_postfix_text',true);?></span>
          </div>
        </div>
      </div>
      <div class="loanPeriod mt-3">
        <label class="p-0 m-0"><?php  esc_html_e('Loan Period','ivproperty'); ?></label>
        <div class="d-flex justify-content-between p-0 m-0">
          <div id="slider-range-min-3"></div>                 
          <div id="loan-period" class="p-0 m-0 d-flex">
            <input id="input-year" type="text" value="10">
            <span class="years"><?php  esc_html_e('Years','ivproperty'); ?></span>
          </div>
        </div>
      </div>
      <div class="downPayment mt-3">
        <label class="p-0 m-0"><?php  esc_html_e('Down Payment','ivproperty'); ?></label>
        <div class="d-flex justify-content-between  p-0 m-0">
          <div id="slider-down-payment"></div>                  
          <div id="down-payment" class="p-0 m-0 d-flex">
            <span class="percentage"><?php  esc_html_e('30%','ivproperty'); ?></span>
						<?php
              $downpayment= (int)get_post_meta($id,'sale_or_rent_price',true)*30/100;
            ?>
            <input id="input-down-payment" type="text" value="<?php echo esc_html($downpayment); ?>">
            <span class="dprice"><?php echo get_post_meta($id,'price_postfix_text',true);?></span>
          </div>
        </div>
      </div>
      <div class="interestRate mt-3">
        <label class="p-0 m-0"><?php  esc_html_e('Interest Rate','ivproperty'); ?></label>
        <div class="d-flex justify-content-between p-0 m-0">
          <div id="slider-range-min-5"></div>                    
          <div id="interest-rate-input">
            <input type="text" name="" value="15%" id="interest-rate">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 border-left">
      <div class="monthlyPayment border-bottom py-3">
        <p class="text-center text-bold"><?php  esc_html_e('Monthly Payment','ivproperty'); ?></p>
        <p class="text-center text-bold p-o m-0"><?php echo get_post_meta($id,'price_postfix_text',true);?></p>
        <h2 class="text-center text-bold" id="Monthly-Payment"></h2>
      </div>
      <div class="totalPayable border-bottom py-3">
        <p class="text-center text-bold"><?php  esc_html_e('Total Payable in ','ivproperty'); ?> <span class="text-center text-bold" id="yearstitle"><?php  esc_html_e('24','ivproperty'); ?> </span><?php  esc_html_e(' Years','ivproperty'); ?></p>
        <p class="text-center text-bold p-o m-0"><?php echo get_post_meta($id,'price_postfix_text',true);?></p>
        <h2 class="text-center text-bold bdt" id="total-payable"><?php echo number_format((int)get_post_meta($id,'sale_or_rent_price',true));?></h2>
      </div>
      <div class="paymentBreakDown py-3">
        <p class="text-center text-bold"><?php  esc_html_e('Payment Break Down','ivproperty'); ?></p>
        <div class="d-flex justify-content-center">
          <div class="dp-percentage">
            <p class="text-center text-white text-bold p-2 m-0 Interestper-background" id="Interestper" ><?php  esc_html_e('60%','ivproperty'); ?></p>
            <small class="text-bold"><?php  esc_html_e('Interest','ivproperty'); ?></small>
          </div>
          <div class="dp-percentage-2">
            <p class="text-center text-white text-bold p-2 m-0 Principleper-background" id="Principleper"  ><?php  esc_html_e('40%','ivproperty'); ?></p>
            <small class="text-bold"><?php  esc_html_e('Principle','ivproperty'); ?></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>