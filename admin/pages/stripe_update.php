<?php
	global $wpdb;
	$newpost_id='';
	$post_name='iv_property_stripe_setting';
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ", $post_name));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}	
	$stripe_mode=get_post_meta( $newpost_id,'iv_property_stripe_mode',true);	
?>
<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">					
		<div class="row">
			<div class="col-md-12"><h3 class=""><?php esc_html_e( 'Stripe Api Settings', 'ivproperty' );?> </h3>						
			</div>
		</div> 
		<div class="col-md-7 panel panel-info">
			<div class="panel-body">
				<form id="stripe_form_iv" name="stripe_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
					<div class="form-group">
						<label for="text" class="col-md-3 control-label"></label>
						<div id="iv-loading"></div>
					</div>		
					<div class="form-group">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'Gateway Mode', 'ivproperty' );?></label>
						<div class="col-md-8">
							<select name="stripe_mode" id ="stripe_mode" class="form-control">
								<option value="test" <?php echo ($stripe_mode == 'test' ? 'selected' : '') ?>><?php esc_html_e( 'Test Mode', 'ivproperty' );?></option>
								<option value="live" <?php echo ($stripe_mode == 'live' ? 'selected' : '') ?>><?php esc_html_e( 'Live Mode', 'ivproperty' );?></option>
							</select>	
						</div>
					</div> 
					<div class="form-group">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'Live Secret', 'ivproperty' );?></label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="secret_key" id="secret_key" value="<?php echo get_post_meta($newpost_id, 'iv_property_stripe_live_secret_key', true); ?>" placeholder="<?php esc_html_e( 'Enter stripe secret key', 'ivproperty' );?>">
						</div>
					</div>						
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Live Publishable', 'ivproperty' );?></label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="publishable_key" name="publishable_key" value="<?php echo get_post_meta($newpost_id, 'iv_property_stripe_live_publishable_key', true); ?>"  placeholder="<?php esc_html_e( 'Enter stripe Api publishable key', 'ivproperty' );?>">
						</div>
					</div>
					<div class="col-md-12">
						<hr>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Test Secret', 'ivproperty' );?></label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="secret_key_test" name="secret_key_test" value="<?php echo get_post_meta($newpost_id, 'iv_property_stripe_secret_test', true); ?>"  placeholder="<?php esc_html_e( 'Enter stripe Api Secret Key', 'ivproperty' );?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Test Publishable', 'ivproperty' );?></label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="stripe_publishable_test" name="stripe_publishable_test" value="<?php echo get_post_meta($newpost_id, 'iv_property_stripe_publishable_test', true); ?>"  placeholder="<?php esc_html_e( 'Enter stripe Api publishable Key', 'ivproperty' );?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Stripe API Currency Code', 'ivproperty' );?></label>
						<div class="col-md-8">
							<?php
								$currency_iv=get_post_meta($newpost_id, 'iv_property_stripe_api_currency', true);
							?>
							<select id="stripe_api_currency" name="stripe_api_currency" class="form-control">
								<option value="USD" <?php echo ($currency_iv=='USD' ? 'selected':'')  ?> ><?php esc_html_e( 'US Dollars ($)', 'ivproperty' );?></option>
								<option value="EUR" <?php echo ($currency_iv=='EUR' ? 'selected':'')  ?> ><?php esc_html_e( 'Euros (&euro;)', 'ivproperty' );?></option>
								<option value="GBP" <?php echo ($currency_iv=='GBP' ? 'selected':'')  ?> ><?php esc_html_e( 'Pounds Sterling (£)', 'ivproperty' );?></option>
								<option value="AUD" <?php echo ($currency_iv=='AUD' ? 'selected':'')  ?> ><?php esc_html_e( 'Australian Dollars ($)', 'ivproperty' );?></option>
								<option value="BRL" <?php echo ($currency_iv=='BRL' ? 'selected':'')  ?> ><?php esc_html_e( 'Brazilian Real (R$)', 'ivproperty' );?></option>
								<option value="CAD" <?php echo ($currency_iv=='CAD' ? 'selected':'')  ?> ><?php esc_html_e( 'Canadian Dollars ($)', 'ivproperty' );?></option>
								<option value="CNY" <?php echo ($currency_iv=='CNY' ? 'selected':'')  ?> ><?php esc_html_e( 'Chinese Yuan', 'ivproperty' );?></option>
								<option value="CZK" <?php echo ($currency_iv=='CZK' ? 'selected':'')  ?> ><?php esc_html_e( 'Czech Koruna', 'ivproperty' );?></option>
								<option value="DKK" <?php echo ($currency_iv=='DKK' ? 'selected':'')  ?> ><?php esc_html_e( 'Danish Krone', 'ivproperty' );?></option>
								<option value="HKD" <?php echo ($currency_iv=='HKD' ? 'selected':'')  ?> ><?php esc_html_e( 'Hong Kong Dollar ($)', 'ivproperty' );?></option>
								<option value="HUF" <?php echo ($currency_iv=='HUF' ? 'selected':'')  ?> ><?php esc_html_e( 'Hungarian Forint', 'ivproperty' );?></option>
								<option value="INR" <?php echo ($currency_iv=='INR' ? 'selected':'')  ?> ><?php esc_html_e( 'Indian Rupee', 'ivproperty' );?></option>
								<option value="ILS" <?php echo ($currency_iv=='ILS' ? 'selected':'')  ?> ><?php esc_html_e( 'Israeli Sheqel', 'ivproperty' );?></option>
								<option value="JPY" <?php echo ($currency_iv=='JPY' ? 'selected':'')  ?> ><?php esc_html_e( 'Japanese Yen (¥)', 'ivproperty' );?></option>
								<option value="MYR" <?php echo ($currency_iv=='MYR' ? 'selected':'')  ?> ><?php esc_html_e( 'Malaysian Ringgits', 'ivproperty' );?></option>
								<option value="MXN" <?php echo ($currency_iv=='MXN' ? 'selected':'')  ?> ><?php esc_html_e( 'Mexican Peso ($)', 'ivproperty' );?></option>
								<option value="NZD" <?php echo ($currency_iv=='NZD' ? 'selected':'')  ?> ><?php esc_html_e( 'New Zealand Dollar ($)', 'ivproperty' );?></option>
								<option value="NOK" <?php echo ($currency_iv=='NOK' ? 'selected':'')  ?> ><?php esc_html_e( 'Norwegian Krone', 'ivproperty' );?></option>
								<option value="PHP" <?php echo ($currency_iv=='PHP' ? 'selected':'')  ?> ><?php esc_html_e( 'Philippine Pesos', 'ivproperty' );?></option>
								<option value="PLN" <?php echo ($currency_iv=='PLN' ? 'selected':'')  ?> ><?php esc_html_e( 'Polish Zloty', 'ivproperty' );?></option>
								<option value="SGD" <?php echo ($currency_iv=='SGD' ? 'selected':'')  ?> ><?php esc_html_e( 'Singapore Dollar ($', 'ivproperty' );?>)</option>
								<option value="ZAR" <?php echo ($currency_iv=='ZAR' ? 'selected':'')  ?> ><?php esc_html_e( 'South African Rand', 'ivproperty' );?></option>
								<option value="KRW" <?php echo ($currency_iv=='KRW' ? 'selected':'')  ?> ><?php esc_html_e( 'South Korean Won', 'ivproperty' );?></option>
								<option value="SEK" <?php echo ($currency_iv=='SEK' ? 'selected':'')  ?> ><?php esc_html_e( 'Swedish Krona', 'ivproperty' );?></option>
								<option value="CHF" <?php echo ($currency_iv=='CHF' ? 'selected':'')  ?> ><?php esc_html_e( 'Swiss Franc', 'ivproperty' );?></option>
								<option value="RUB" <?php echo ($currency_iv=='RUB' ? 'selected':'')  ?> ><?php esc_html_e( 'Russian Ruble', 'ivproperty' );?></option> 
								<option value="TWD" <?php echo ($currency_iv=='TWD' ? 'selected':'')  ?> ><?php esc_html_e( 'Taiwan New Dollars', 'ivproperty' );?></option>
								<option value="THB" <?php echo ($currency_iv=='THB' ? 'selected':'')  ?> ><?php esc_html_e( 'Thai Baht', 'ivproperty' );?></option>
								<option value="TRY" <?php echo ($currency_iv=='TRY' ? 'selected':'')  ?> ><?php esc_html_e( 'Turkish Lira', 'ivproperty' );?></option>
							</select>											
						</div>
					</div>							
				</form>					
				<div class="row">					
					<div class="col-md-12">	
						<label for="" class="col-md-4 control-label"></label>
						<div class="col-md-8">
						<button class="btn btn-info " onclick="return update_stripe_setting();"><?php esc_html_e( 'Update Settings', 'ivproperty' );?></button></div>
						<p>&nbsp;</p>
					</div>
				</div>
				<div class=" col-md-12  bs-callout bs-callout-info">
					<b>
						<?php esc_html_e( 'Stripe Test to Live mode: When turned from Test to Live did not have any of the plans you have created on Stripe.
						When you will switch from Stripe to Paypal and PayPal to Stripe again, the connection between  the plugin and Stripe was corrected and thus the plans were re-created in the Stripe account.', 'ivproperty' );?>
					</b><br/>
				</div>	
			</div>
		</div>			
	</div>
</div>	