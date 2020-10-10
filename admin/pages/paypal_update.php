<?php
	global $wpdb;
	$newpost_id='';
	$post_name='iv_property_paypal_setting';			
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ", $post_name));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}	
	$paypal_mode=get_post_meta( $newpost_id,'iv_property_paypal_mode',true);	
?>
<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">
		<!-- /.modal -->
		<!-- Start Form 101 -->
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php  esc_html_e('Paypal Api Settings [Express Checkout]','ivproperty'); ?> </h3>
			</div>	
		</div> 
		<form id="paypal_form_iv" name="paypal_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
			<div class="form-group">
				<label for="text" class="col-md-3 control-label"></label>
				<div id="iv-loading"></div>
			</div>		
			<div class="form-group">
				<label for="text" class="col-md-3 control-label"><?php  esc_html_e('Gateway Mode','ivproperty'); ?></label>
				<div class="col-md-5">
					<select name="paypal_mode" id ="paypal_mode" class="form-control">
						<option value="test" <?php echo ($paypal_mode == 'test' ? 'selected' : '') ?>><?php  esc_html_e('Test Mode','ivproperty'); ?></option>
						<option value="live" <?php echo ($paypal_mode == 'live' ? 'selected' : '') ?>><?php  esc_html_e('Live Mode','ivproperty'); ?></option>
					</select>	
				</div>
			</div> 
			<div class="form-group">
				<label for="text" class="col-md-3 control-label"><?php  esc_html_e('PayPal API Username','ivproperty'); ?> <span class="chili"></span></label>
				<div class="col-md-5">
					<input type="text" class="form-control" name="paypal_username" id="paypal_username" value="<?php echo get_post_meta($newpost_id, 'iv_property_paypal_username', true); ?>" placeholder="<?php  esc_html_e('Enter Paypal Username','ivproperty'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-3 control-label"><?php  esc_html_e('PayPal API Password','ivproperty'); ?> <span class="chili"></span></label>
				<div class="col-md-5">
					<input type="text" class="form-control" id="paypal_api_password" name="paypal_api_password" value="<?php echo get_post_meta($newpost_id, 'iv_property_paypal_api_password', true); ?>"  placeholder="<?php  esc_html_e('Enter Paypal Api Password','ivproperty'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-3 control-label"><?php  esc_html_e('PayPal API Signature','ivproperty'); ?> <span class="chili"></span></label>
				<div class="col-md-5">
					<input type="text" class="form-control" id="paypal_api_signature" name="paypal_api_signature" value="<?php echo get_post_meta($newpost_id, 'iv_property_paypal_api_signature', true); ?>"  placeholder="<?php  esc_html_e('Enter Paypal Api Signature','ivproperty'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-3 control-label"><?php  esc_html_e('PayPal API Currency Code','ivproperty'); ?></label>
				<div class="col-md-5">
					<?php
						$currency_iv=get_post_meta($newpost_id, 'iv_property_paypal_api_currency', true);
					?>
					<select id="paypal_api_currency" name="paypal_api_currency" class="form-control">
						<option value="USD" <?php echo ($currency_iv=='USD' ? 'selected':'')  ?> ><?php  esc_html_e('US Dollars ($)','ivproperty'); ?></option>
						<option value="EUR" <?php echo ($currency_iv=='EUR' ? 'selected':'')  ?> ><?php  esc_html_e('Euros (€)','ivproperty'); ?></option>
						<option value="GBP" <?php echo ($currency_iv=='GBP' ? 'selected':'')  ?> ><?php  esc_html_e('Pounds Sterling (£)','ivproperty'); ?></option>
						<option value="AUD" <?php echo ($currency_iv=='AUD' ? 'selected':'')  ?> ><?php  esc_html_e('Australian Dollars ($)','ivproperty'); ?></option>
						<option value="BRL" <?php echo ($currency_iv=='BRL' ? 'selected':'')  ?> ><?php  esc_html_e('Brazilian Real (R$)','ivproperty'); ?></option>
						<option value="CAD" <?php echo ($currency_iv=='CAD' ? 'selected':'')  ?> ><?php  esc_html_e('Canadian Dollars ($)','ivproperty'); ?></option>
						<option value="CNY" <?php echo ($currency_iv=='CNY' ? 'selected':'')  ?> ><?php  esc_html_e('Chinese Yuan','ivproperty'); ?></option>
						<option value="CZK" <?php echo ($currency_iv=='CZK' ? 'selected':'')  ?> ><?php  esc_html_e('Czech Koruna','ivproperty'); ?></option>
						<option value="DKK" <?php echo ($currency_iv=='DKK' ? 'selected':'')  ?> ><?php  esc_html_e('Danish Krone','ivproperty'); ?></option>
						<option value="HKD" <?php echo ($currency_iv=='HKD' ? 'selected':'')  ?> ><?php  esc_html_e('Hong Kong Dollar ($)','ivproperty'); ?></option>
						<option value="HUF" <?php echo ($currency_iv=='HUF' ? 'selected':'')  ?> ><?php  esc_html_e('Hungarian Forint','ivproperty'); ?></option>
						<option value="INR" <?php echo ($currency_iv=='INR' ? 'selected':'')  ?> ><?php  esc_html_e('Indian Rupee','ivproperty'); ?></option>
						<option value="ILS" <?php echo ($currency_iv=='ILS' ? 'selected':'')  ?> ><?php  esc_html_e('Israeli Sheqel','ivproperty'); ?></option>
						<option value="JPY" <?php echo ($currency_iv=='JPY' ? 'selected':'')  ?> ><?php  esc_html_e('Japanese Yen (¥)','ivproperty'); ?></option>
						<option value="MYR" <?php echo ($currency_iv=='MYR' ? 'selected':'')  ?> ><?php  esc_html_e('Malaysian Ringgits','ivproperty'); ?></option>
						<option value="MXN" <?php echo ($currency_iv=='MXN' ? 'selected':'')  ?> ><?php  esc_html_e('Mexican Peso ($)','ivproperty'); ?></option>
						<option value="NZD" <?php echo ($currency_iv=='NZD' ? 'selected':'')  ?> ><?php  esc_html_e('New Zealand Dollar ($)','ivproperty'); ?></option>
						<option value="NOK" <?php echo ($currency_iv=='NOK' ? 'selected':'')  ?> ><?php  esc_html_e('Norwegian Krone','ivproperty'); ?></option>
						<option value="PHP" <?php echo ($currency_iv=='PHP' ? 'selected':'')  ?> ><?php  esc_html_e('Philippine Pesos','ivproperty'); ?></option>
						<option value="PLN" <?php echo ($currency_iv=='PLN' ? 'selected':'')  ?> ><?php  esc_html_e('Polish Zloty','ivproperty'); ?></option>
						<option value="SGD" <?php echo ($currency_iv=='SGD' ? 'selected':'')  ?> ><?php  esc_html_e('Singapore Dollar ($)','ivproperty'); ?></option>
						<option value="ZAR" <?php echo ($currency_iv=='ZAR' ? 'selected':'')  ?> ><?php  esc_html_e('South African Rand','ivproperty'); ?></option>
						<option value="KRW" <?php echo ($currency_iv=='KRW' ? 'selected':'')  ?> ><?php  esc_html_e('South Korean Won','ivproperty'); ?></option>
						<option value="SEK" <?php echo ($currency_iv=='SEK' ? 'selected':'')  ?> ><?php  esc_html_e('Swedish Krona','ivproperty'); ?></option>
						<option value="CHF" <?php echo ($currency_iv=='CHF' ? 'selected':'')  ?> ><?php  esc_html_e('Swiss Franc','ivproperty'); ?></option>
						<option value="RUB" <?php echo ($currency_iv=='RUB' ? 'selected':'')  ?> ><?php  esc_html_e('Russian Ruble','ivproperty'); ?></option> 
						<option value="TWD" <?php echo ($currency_iv=='TWD' ? 'selected':'')  ?> ><?php  esc_html_e('Taiwan New Dollars','ivproperty'); ?></option>
						<option value="THB" <?php echo ($currency_iv=='THB' ? 'selected':'')  ?> ><?php  esc_html_e('Thai Baht','ivproperty'); ?></option>
						<option value="TRY" <?php echo ($currency_iv=='TRY' ? 'selected':'')  ?> ><?php  esc_html_e('Turkish Lira','ivproperty'); ?></option>
					</select>										
				</div>
			</div>						  
		</form>
		<div class="row">	
			<label for="" class="col-md-3 control-label"></label>						
			<div class="col-md-5">					
				<div align="">
				<button class="btn btn-info " onclick="return update_paypal_setting();"><?php esc_html_e( 'Update Settings', 'ivproperty' );?></button></div>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>
</div>	