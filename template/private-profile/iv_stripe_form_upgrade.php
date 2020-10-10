<?php
	wp_enqueue_script('jquery.form-validator', wp_iv_property_URLPATH . 'admin/files/js/jquery.form-validator.js');
	$newpost_id='';
	$post_name='iv_property_stripe_setting';
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}
	$stripe_mode=get_post_meta( $newpost_id,'iv_property_stripe_mode',true);	
	if($stripe_mode=='test'){
		$stripe_publishable =get_post_meta($newpost_id, 'iv_property_stripe_publishable_test',true);	
		}else{
		$stripe_publishable =get_post_meta($newpost_id, 'iv_property_stripe_live_publishable_key',true);	
	}
	wp_enqueue_script('stripe', 'https://js.stripe.com/v2/');
?>
<div id="payment-errors"></div>
<div id="stripe_form">
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e( 'Package Name', 'ivproperty' );?></label>
		<div class="col-md-8 col-xs-8 col-sm-8 "> 																				
			<?php
				$iv_property_pack='iv_property_pack';
				$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' ",$iv_property_pack);
				$membership_pack = $wpdb->get_results($sql);
				$total_package=count($membership_pack);
				if(sizeof($membership_pack)>0){
					$i=0; $current_package_id=get_user_meta($current_user->ID,'iv_property_package_id',true);
					echo'<select name="package_sel" id ="package_sel" class=" form-control">';							
					foreach ( $membership_pack as $row )
					{	
						if($current_package_id==$row->ID){
							echo '<option value="'. $row->ID.'" >'. esc_html($row->post_title).' [Your Current Package]</option>';
							}else{
							echo '<option value="'. $row->ID.'" >'. esc_html($row->post_title).'</option>';
						}
						if($i==0){
							$package_id=$row->ID;
							if(get_post_meta($row->ID, 'iv_property_package_recurring',true)=='on'){
								$package_amount=get_post_meta($row->ID, 'iv_property_package_recurring_cost_initial', true);	
								}else{
								$package_amount=get_post_meta($row->ID, 'iv_property_package_cost',true);
							}
						}
						$i++;		
					}	
					echo '</select>';
				}
			?>
		</div>
	</div>
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e( 'Amount', 'ivproperty' );?></label>
		<div class="col-md-8 col-xs-8 col-sm-8 " id="p_amount"> <label class="control-label"> <?php  echo esc_html($package_amount).' '.esc_html($currencyCode); ?> </label>
		</div>										
	</div>				
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e( 'Card Number', 'ivproperty' );?></label> 
		<div class="col-md-8 col-xs-8 col-sm-8 " >  
			<input type="text" name="card_number" id="card_number"  data-validation="creditcard required"  class="form-control ctrl-textbox" placeholder="Enter card number" data-validation-error-msg="<?php esc_html_e( 'Card number is not correct', 'ivproperty' );?>" >
		</div>										
	</div>
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e( 'Card CVV', 'ivproperty' );?> </label>
		<div class="col-md-8 col-xs-8 col-sm-8 " >  
			<input type="text" name="card_cvc" id="card_cvc" class="form-control ctrl-textbox"   data-validation="number" 
			data-validation-length="2-6" data-validation-error-msg="<?php esc_html_e( 'CVV number is not correct', 'ivproperty' );?>" placeholder="<?php esc_html_e( 'Enter card CVC', 'ivproperty' );?>" >
		</div>
	</div>	
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e( 'Expiration (MM/YYYY)', 'ivproperty' );?></label>
		<div class="col-md-4 col-xs-4 col-sm4" >  
			<select name="card_month" id="card_month"  class="card-expiry-month stripe-sensitive required form-control">
				<option value="01" selected="selected"><?php esc_html_e( '01', 'ivproperty' );?></option>
				<option value="02"><?php esc_html_e( '02', 'ivproperty' );?></option>
				<option value="03"><?php esc_html_e( '03', 'ivproperty' );?></option>
				<option value="04"><?php esc_html_e( '04', 'ivproperty' );?></option>
				<option value="05"><?php esc_html_e( '05', 'ivproperty' );?></option>
				<option value="06"><?php esc_html_e( '06', 'ivproperty' );?></option>
				<option value="07"><?php esc_html_e( '07', 'ivproperty' );?></option>
				<option value="08"><?php esc_html_e( '08', 'ivproperty' );?></option>
				<option value="09"><?php esc_html_e( '09', 'ivproperty' );?></option>
				<option value="10"><?php esc_html_e( '10', 'ivproperty' );?></option>
				<option value="11"><?php esc_html_e( '11', 'ivproperty' );?></option>
				<option value="12" selected ><?php esc_html_e( '12', 'ivproperty' );?></option>
			</select>
		</div>
		<div class="col-md-4 col-xs-4 col-sm-4 " >  
			<select name="card_year"  id="card_year"  class="card-expiry-year stripe-sensitive  form-control">
			</select>
		</div>								
	</div>	
	<?php
		$iv_property_payment_terms=get_option('iv_property_payment_terms'); 
		$term_text='I have read & accept the <a href="#"> Terms & Conditions</a>';
		if( get_option( 'iv_property_payment_terms_text' ) ) { 
			$term_text= get_option('iv_property_payment_terms_text'); 
		}
		if($iv_property_payment_terms=='yes'){
		?>
		<div class="row">
			<div class="col-md-4 col-xs-4 col-sm-4 "> 
			</div>
			<div class="col-md-8 col-xs-8 col-sm-8 "> 
				<label>
					<input type="checkbox" data-validation="required" 
					data-validation-error-msg="<?php esc_html_e( 'You have to agree to our terms', 'ivproperty' );?> "  name="check_terms" id="check_terms"> 
					<?php echo esc_html($term_text); ?>
				</label>
				<div class="text-danger" id="error_message" > </div>
			</div>									
		</div>
		<?php
		}	 
	?>	
	<input type="hidden" name="package_id" id="package_id" value="<?php echo esc_html($package_id); ?>">	
	<input type="hidden" name="coupon_code" id="coupon_code" value="">	 		
	<input type="hidden" name="redirect" value="<?php echo get_permalink(); ?>"/>
	<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"></label>
		<div class="col-md-8 col-xs-8 col-sm-8 " > <div id="loading"> </div> 
			<button  id="submit_iv_property_payment"  type="submit" class="btn btn-info ctrl-btn"  > <?php esc_html_e( 'Submit', 'ivdirectories' );?> </button>
		</div>
	</div>	
</div>	
<?php
	$currencyCode = get_option('_iv_property_api_currency');
	wp_enqueue_script('my-account-stripe-upgrade', wp_iv_property_URLPATH . 'admin/files/js/my-account-stripe-upgrade.js');
	wp_localize_script('my-account-stripe-upgrade', 'realstripe', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_property_URLPATH.'admin/files/images/loader.gif">',	
	'myaccount'=> wp_create_nonce("myaccount"),
	'iv_gateway'=> $iv_gateway,	
	'stripe_publishable'=> $stripe_publishable,
	) );
?>		