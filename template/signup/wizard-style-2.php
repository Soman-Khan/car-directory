<?php
	global $wpdb;
	wp_enqueue_style('bootstrap-wp-iv_property-style-signup-11', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_style('wp-iv_property-style-signup-css', wp_iv_property_URLPATH . 'admin/files/css/signup.css');
	wp_enqueue_script('bootstrap-iv_property-script-signup-12', wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min.js');
	$api_currency= 'USD';
	if( get_option('_iv_property_api_currency' )!=FALSE ) {
		$api_currency= get_option('_iv_property_api_currency' );
	}	
	if(isset($_REQUEST['payment_gateway'])){
		$payment_gateway=$_REQUEST['payment_gateway'];
	}
	$iv_gateway='paypal-express';
	if( get_option( 'iv_property_payment_gateway' )!=FALSE ) {
		$iv_gateway = get_option('iv_property_payment_gateway');	
		if($iv_gateway=='paypal-express'){
			$post_name='iv_property_paypal_setting';						
			$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ", $post_name));
			$paypal_id='0';
			if(isset($row->ID )){
				$paypal_id= $row->ID;
			}
			$api_currency=get_post_meta($paypal_id, 'iv_property_paypal_api_currency', true);	
		}				 
	}
	$package_id=''; 
	if(isset($_REQUEST['package_id'])){
		$package_id=$_REQUEST['package_id'];
		$recurring= get_post_meta($package_id, 'iv_property_package_recurring', true);	
		if($recurring == 'on'){
			$package_amount=get_post_meta($package_id, 'iv_property_package_recurring_cost_initial', true);
			}else{
			$package_amount=get_post_meta($package_id, 'iv_property_package_cost',true);
		}
		if($package_amount=='' || $package_amount=='0' ){$iv_gateway='paypal-express';}
	}
	$form_meta_data= get_post_meta( $package_id,'iv_property_content',true);			
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE id = '%s' ",$package_id ));
	$package_name='';
	$package_amount='';
	if(isset($row->post_title)){
		$package_name=$row->post_title;
		$count =get_post_meta($package_id, 'iv_property_package_recurring_cycle_count', true);
		$package_name=$package_name;
		$package_amount=get_post_meta($package_id, 'iv_property_package_cost',true);
	}
	$newpost_id='';
	$post_name='iv_property_stripe_setting';
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' " ,$post_name));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}
	$stripe_mode=get_post_meta( $newpost_id,'iv_property_stripe_mode',true);	
	if($stripe_mode=='test'){
		$stripe_publishable =get_post_meta($newpost_id, 'iv_property_stripe_publishable_test',true);	
		}else{
		$stripe_publishable =get_post_meta($newpost_id, 'iv_property_stripe_live_publishable_key',true);	
	}
		
?>
<div class="bootstrap-wrapper">
	<div id="iv-form3" class="col-md-12">
		<?php
				if($iv_gateway=='paypal-express'){	
				?>
				<form id="iv_property_registration" name="iv_property_registration" class="form-horizontal" action="<?php  the_permalink() ?>?package_id=<?php echo esc_html($package_id); ?>&payment_gateway=paypal&iv-submit-listing=register" method="post" role="form">
				<?php	
				}
				if($iv_gateway=='woocommerce'){
				?>
				<form id="iv_property_registration" name="iv_property_registration" class="form-horizontal" action="<?php  the_permalink() ?>?package_id=<?php echo esc_html($package_id); ?>&payment_gateway=woocommerce&iv-submit-listing=register" method="post" role="form">
				<?php
				}
				if($iv_gateway=='stripe'){?>
				<form id="iv_property_registration" name="iv_property_registration" class="form-horizontal" action="<?php  the_permalink() ?>?&package_id=<?php echo esc_html($package_id); ?>&payment_gateway=stripe&iv-submit-stripe=register" method="post" role="form">
					<input type="hidden" name="payment_gateway" id="payment_gateway" value="stripe">	
					<input type="hidden" name="iv-submit-stripe" id="iv-submit-stripe" value="register">	
					<?php	
					}
				?>	
				<div class="row">	
					<div class="col-md-1">
					</div>
					<div class="col-md-10"> 
						<h2 class="header-profile"><div><?php   esc_html_e('User Info','ivproperty');?></div></h2>
					</div>
				</div>
				<div class="row">	
				  <div class="col-md-1 ">
					</div>
					<div class="col-md-10 "> 
						<?php
							if(isset($_REQUEST['message-error'])){?>
						  <div class="row alert alert-info alert-dismissable" id='loading-2'><a class="panel-close close" data-dismiss="alert">x</a> <?php   esc_html_e('User_or_Email_Exists','ivproperty'); ?></div>
						  <?php
							}
						?>
						<!--  
							For Form Validation we used plugins http://formvalidator.net/index.html#reg-form  
							This is in line validation so you can add fields easily. 	
						-->
						<div>
							<div id="selected-column-1" class=" ">
								<div class="text-center" id="loading"> </div>
								<div class="form-group row"  >									
									<label for="text" class="col-md-4 control-label"><?php   esc_html_e('User Name','ivproperty');?><span class="chili"></span></label>
									<div class="col-md-8">
										<input type="text"  name="iv_member_user_name"  data-validation="length alphanumeric" 
										data-validation-length="4-12" data-validation-error-msg="<?php   esc_html_e(' The user name has to be an alphanumeric value between 4-12 characters','ivproperty');?>" class="form-control ctrl-textbox" placeholder="Enter User Name"  alt="required">
									</div>
								</div>
								<div class="form-group row">									
									<label for="email" class="col-md-4 control-label" ><?php   esc_html_e('Email Address','ivproperty');?><span class="chili"></span></label>
									<div class="col-md-8">
										<input type="email" name="iv_member_email" data-validation="email"  class="form-control ctrl-textbox" placeholder="Enter email address" data-validation-error-msg="<?php   esc_html_e('Please enter a valid email address','ivproperty');?> " >
									</div>
								</div>
								<?php wp_nonce_field( 'signup1' ); ?>
								<div class="form-group row ">									
									<label for="text" class="col-md-4 control-label"><?php   esc_html_e('Password','ivproperty');?><span class="chili"></span></label>
									<div class="col-md-8">
										<input type="password" name="iv_member_password"  class="form-control ctrl-textbox" placeholder="" data-validation="strength" 
										data-validation-strength="2" data-validation-error-msg="<?php   esc_html_e('The password is not strong enough','ivproperty');?>">
									</div>
								</div>
							</div>							
						</div>	
						<input type="hidden" name="hidden_form_name" id="hidden_form_name" value="iv_property_registration">
					</div>
				</div>
				<br/>
				<div class="row">	
					<div class="col-md-1 ">
					</div>
					<div class="col-md-10 "> 
						<h2 class="header-profile"><div><?php   esc_html_e('Payment Info','ivproperty');?></div></h2>
					</div>
				</div>
				<br/>		
				<div class="row">	
					<div class="col-md-1 ">
					</div>
					<div class="col-md-10 ">
						<?php 														
							if($iv_gateway=='paypal-express'){
								include(wp_iv_property_template.'signup/paypal_form_2.php');
							}
							if($iv_gateway=='stripe'){
								include(wp_iv_property_template.'signup/iv_stripe_form_2.php');					
							}	
							if($iv_gateway=='woocommerce'){
										include(wp_iv_property_template.'signup/woocommerce.php');
							}				
						?>			
					</div>		
				</div>	
			</form>
		</div>
	</div>
	<?php		
		wp_enqueue_script("jquery");
		wp_enqueue_script('jquery.form-validator', wp_iv_property_URLPATH . 'admin/files/js/jquery.form-validator.js');
		wp_enqueue_script('iv_directory-script-30', wp_iv_property_URLPATH . 'admin/files/js/signup.js');
		wp_localize_script('iv_directory-script-30', 'dirpro_data', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loader_image'=>'<img src="'.wp_iv_property_URLPATH. 'admin/files/images/loader.gif" />',
		'loader_image2'=>'<img src="'.wp_iv_property_URLPATH. 'admin/files/images/old-loader.gif" />',
		'right_icon'=>'<img src="'.wp_iv_property_URLPATH. 'admin/files/images/right_icon.png" />',
		'wrong_16x16'=>'<img src="'.wp_iv_property_URLPATH. 'admin/files/images/wrong_16x16.png" />',
		'stripe_publishable'=>$stripe_publishable,
		'package_amount'=>$package_amount,
		'api_currency'=>$api_currency,
		'iv_gateway'=>$iv_gateway,
		'HideCoupon'=>esc_html__("Hide Coupon",'ivproperty'),		
		'dirwpnonce'=> wp_create_nonce("signup"),
		'signup'=> wp_create_nonce("signup"),
		) );
	?>	