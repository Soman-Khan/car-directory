<?php
	global $wpdb;					
?>
<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">
		<!-- /.modal -->
		<!-- Start Form 101 -->
		<div class="row">					
			<div class="col-xs-12" id="submit-button-holder">					
				<div class="pull-right"><button class="btn btn-info btn-lg" onclick="return save_the_package();"><?php  esc_html_e('Save Package','ivproperty'); ?></button></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php  esc_html_e('Create Package / Membership Level','ivproperty'); ?> <br /><small> &nbsp;</small> </h3>
			</div>							
		</div> 
		<form id="package_form_iv" name="package_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php  esc_html_e('Package Name','ivproperty'); ?></label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="package_name" id="package_name" placeholder="<?php esc_html_e('Enter Package Name','ivproperty');  ?> ">
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php  esc_html_e('Package Feature List','ivproperty'); ?></label>
				<div class="col-md-6">
					<textarea class="form-control" name="package_feature" id="package_feature" rows="5" placeholder="<?php esc_html_e('Enter Feature List','ivproperty');  ?> "></textarea>
					<?php  esc_html_e('It will display on price list table','ivproperty'); ?> 
				</div>
			</div>
			<h3 class="page-header"> <?php  esc_html_e('Billing Details','ivproperty'); ?></h3>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-2 control-label"><?php  esc_html_e('Initial Payment','ivproperty'); ?></label>
				<div class="col-md-6">
					<input type="text" class="form-control" id="package_cost" name="package_cost" placeholder="<?php esc_html_e('Enter Initial Payment','ivproperty');  ?>">
					<?php  esc_html_e('The initial amount collected at user registration.','ivproperty'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php  esc_html_e('Package Expire After','ivproperty'); ?></label>
				<div class="col-md-2">
					<select id="package_initial_expire_interval" name="package_initial_expire_interval" class="ctrl-combobox form-control">
						<?php 
							$package_id='0';
							$package_initial_period_interval= get_post_meta($package_id, 'iv_property_package_initial_expire_interval', true); 
							echo '<option value="">None</option>';
							for($ii=1;$ii<31;$ii++){
								echo '<option value="'.$ii.'" '.($package_initial_period_interval == $ii ? 'selected' : '').'>'.$ii.'</option>';
							}
						?>
					</select>	
				</div>	
				<div class="col-md-4">
					<?php
						$package_initial_expire_type= get_post_meta($package_id, 'iv_property_package_initial_expire_type', true); 
					?>
					<select name="package_initial_expire_type" id ="package_initial_expire_type" class=" form-control">		
						<option value=""><?php esc_html_e('None','ivproperty');  ?> </option>								
						<option value="day" <?php echo ($package_initial_expire_type == 'day' ? 'selected' : '') ?>><?php esc_html_e('Day(s)','ivproperty');  ?></option>
						<option value="week" <?php echo ($package_initial_expire_type == 'week' ? 'selected' : '') ?>><?php esc_html_e('Week(s)','ivproperty');  ?></option>
						<option value="month" <?php echo ($package_initial_expire_type == 'month' ? 'selected' : '') ?>><?php esc_html_e('Month(s','ivproperty');  ?>)</option>
						<option value="year" <?php echo ($package_initial_expire_type == 'year' ? 'selected' : '') ?>><?php esc_html_e('Year(s)','ivproperty');  ?></option>
					</select>		
				</div>
				<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
					<?php  esc_html_e('If select none then user package will expire after 19 years. Package Expire Option will not work on Recurring Subscription. "Billing Cycle Limit" will Work For Recurring Subscription.','ivproperty'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php  esc_html_e('Recurring Subscription','ivproperty'); ?></label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="package_recurring" id="package_recurring" value="on" > <?php  esc_html_e('Enable Recurring Payment','ivproperty'); ?>
					</label>
				</div>								
			</div>
			<div id="recurring_block" class="none" >
				<?php
					if(get_option('iv_property_payment_gateway')=='stripe55555'){
					?>	
					<div class="form-group">
						<label for="text" class="col-md-2 control-label"><?php esc_html_e('Stripe Plan Name(not ID)','ivproperty');?></label>
						<div class="col-md-2">
							<input type="text" class="form-control" value="" name ="eplugins_stripe_plan" id="eplugins_stripe_plan" >
						</div>
						<div class="col-md-7"><?php
							esc_html_e('The plugin will create the Plan on Stripe account automatically. If you get any payment error then you need to create a Plan on your stripe account/dashboard and add the name here.','ivproperty');
						?>
						</div>
					</div>	
					<?php							
					}
				?>
				<div class="form-group">
					<label for="text" class="col-md-2 control-label"><?php  esc_html_e('Billing Amount','ivproperty'); ?></label>
					<div class="col-md-2">
						<input type="text" class="form-control" name ="package_recurring_cost_initial" id="package_recurring_cost_initial" placeholder="<?php esc_html_e('Amount','ivproperty');?>">
					</div>
					<label for="text" class="col-md-1 control-label"><?php  esc_html_e('Per','ivproperty'); ?></label>
					<div class="col-md-1">									
						<input type="text" class="form-control" id="package_recurring_cycle_count" name="package_recurring_cycle_count" placeholder="<?php esc_html_e('Cycle #','ivproperty');?>">
					</div>
					<div class="col-md-2">
						<select name="package_recurring_cycle_type" id ="package_recurring_cycle_type" class="ctrl-combobox form-control">											
							<option value="day"><?php esc_html_e('Day(s)','ivproperty');?></option>
							<option value="week"><?php esc_html_e('Week(s)','ivproperty');?></option>
							<option value="month"><?php esc_html_e('Month(s)','ivproperty');?></option>
							<option value="year"><?php esc_html_e('Year(s)','ivproperty');?></option>
						</select>		
					</div>
					<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
						<?php  esc_html_e('The "Billing Amount" will Collect at User Registration.','ivproperty'); ?>
					</div>
				</div>
				 <?php
					 if(get_option('iv_property_payment_gateway')!='woocommerce'){
					?>
				<div class="form-group">
					<label for="text" class="col-md-2 control-label"><?php  esc_html_e('Billing Cycle Limit','ivproperty'); ?></label>
					<div class="col-md-2">
						<select name="package_recurring_cycle_limit" id ="package_recurring_cycle_limit" class="ctrl-combobox form-control">											
							<option value=""><?php esc_html_e('Never','ivproperty');?></option>										
							<?php
								$package_recurring_cycle_limit= ""; 
								for($ii=1;$ii<35;$ii++){
									echo '<option value="'.$ii.'" '.($package_recurring_cycle_limit == $ii ? 'selected' : '').'>'.$ii.'</option>';
								}
							?>
						</select>		
					</div>
				</div>
				<div class="form-group">
					<label for="text" class="col-md-2 control-label"> <?php  esc_html_e('Trial','ivproperty'); ?></label>
					<div class="col-md-6 ">
						<label>
							<input type="checkbox" name="package_enable_trial_period" id="package_enable_trial_period"  value='yes'> <?php  esc_html_e('Enable Trial Period','ivproperty'); ?>
						</label>
						<br/>
						<?php  esc_html_e('"Billing Amount" will Collect After Trial Period. ','ivproperty'); ?> 
					</div>																
				</div>
				<div id="trial_block" class="none" >
					<div class="form-group">
						<label for="inputEmail3" class="col-md-2 control-label"><?php  esc_html_e('Trial Amount','ivproperty'); ?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="package_trial_amount" name="package_trial_amount" placeholder="<?php esc_html_e('Enter Amount to Bill for The Trial Period','ivproperty');?>">
							<?php  esc_html_e('Amount to Bill for The Trial Period. Free is 0.[Stripe will not support this option ]','ivproperty'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="text" class="col-md-2 control-label"><?php  esc_html_e('Trial Period','ivproperty'); ?></label>
						<div class="col-md-2">
							<select id="package_trial_period_interval" name="package_trial_period_interval" class="ctrl-combobox form-control">
								<?php
									$package_trial_period_interval= '1'	; 
									for($ii=1;$ii<31;$ii++){
										echo '<option value="'.$ii.'" '.($package_trial_period_interval == $ii ? 'selected' : '').'>'.$ii.'</option>';
									}
								?>
							</select>
						</div>	
						<div class="col-md-4">
							<select name="package_recurring_trial_type" id ="package_recurring_trial_type" class="ctrl-combobox form-control">											
								<option value="day"><?php  esc_html_e('Day(s)','ivproperty'); ?></option>
								<option value="week"><?php  esc_html_e('Week(s)','ivproperty'); ?></option>
								<option value="month"><?php  esc_html_e('Month(s)','ivproperty'); ?></option>
								<option value="year"><?php  esc_html_e('Year(s)','ivproperty'); ?></option>
							</select>		
						</div>
						<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
							<?php  esc_html_e('After The Trial Period "Billing Amount"	Will Be Billed.','ivproperty'); ?>	
						</div>
					</div>
				</div> <!-- Trial Block -->	
				<?php
					} // for not woocommerce payment
				?>
			</div> <!-- Recurring Block -->
				<?php
							if(get_option('iv_property_payment_gateway')=='woocommerce'){
							if ( class_exists( 'WooCommerce' ) ) {
							
							?>  
							  <div class="form-group">
								<label for="text" class="col-md-2 control-label"><?php esc_html_e('Woocommerce Product','ivproperty'); ?></label>
								<div class="col-md-3">							
										<select  class="form-control" id="Woocommerce_product" name="Woocommerce_product">
											<?php 					
											$publish='publish';	
											$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts where post_type='product'  and post_status=%s",$publish);		
											$product_rows = $wpdb->get_results($sql);	
											if(sizeof($product_rows)>0){									
												foreach ( $product_rows as $row ) 
												{	$selected='';													
													echo '<option value="'.esc_html($row->ID).'"'.$selected.' >'.esc_html($row->post_title).' </option>';
												}
											}	
											?>											
										</select>                                     			
								</div>		
							</div>						
						<?php
							}
						}	
						?>				
							  
			<h3 class="page-header"> <?php  esc_html_e('Access Control/Options','ivproperty'); ?> </h3>
			<div class="form-group">
				<label for="text" class="col-md-2  control-label"><?php  esc_html_e('Maximum Post/Property','ivproperty'); ?> </label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="max_pst_no" id="max_pst_no" placeholder="<?php  esc_html_e('Enter Max Number','ivproperty'); ?>">
					<?php  esc_html_e('Maximum # of post by this package. Blank is none.','ivproperty'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php  esc_html_e('Property Visibility','ivproperty'); ?>  </label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="listing_hide" id="listing_hide"  value='yes'> <?php  esc_html_e('Property will hide after user subscription expire.','ivproperty'); ?>
					</label>																	
				</div>																
			</div> 
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php  esc_html_e('Property Deal/ Offer','ivproperty'); ?> </label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="listing_deal" id="listing_deal"  value='yes'> <?php  esc_html_e('Can Add Deal/ Offer.','ivproperty'); ?>
					</label>
				</div>																
			</div> 						
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php  esc_html_e('Floor Plan Image','ivproperty'); ?> </label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="listing_plan" id="listing_plan"  value='yes'> <?php  esc_html_e('Can Add Floor Plan Image.','ivproperty'); ?>
					</label>								 										
				</div>																
			</div> 
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php  esc_html_e('Property Videos','ivproperty'); ?> </label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="listing_video" id="listing_video"  value='yes'> <?php  esc_html_e('Can Add Videos.','ivproperty'); ?>
					</label>								 										
				</div>																
			</div> 
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php  esc_html_e('Property Public Facilities','ivproperty'); ?> </label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="listing_facilities" id="listing_facilities"  value='yes'> <?php  esc_html_e('Can Add Public Facilities.','ivproperty'); ?>
					</label>								 										
				</div>																
			</div> 
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php  esc_html_e('Feature Listing ','ivproperty'); ?> </label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="listing_feature" id="listing_feature"  value='yes'><?php  esc_html_e('Will Add On Featured List (show on top)','ivproperty'); ?>
					</label>								 										
				</div>																
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php  esc_html_e('Property VIP Badge','ivproperty'); ?> </label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="listing_badge_vip" id="listing_badge_vip"  value='yes'> <?php  esc_html_e('Will Add VIP Badge','ivproperty'); ?> <img width="30px" src="<?php echo  wp_iv_property_URLPATH."/assets/images/vipicon.png";?>">	
					</label>								 										
				</div>																
			</div> 
		</form>
		<div class="row">					
			<div class="col-xs-12">					
				<div align="center">
					<div id="loading"></div>
				<button class="btn btn-info btn-lg" onclick="return save_the_package();"><?php  esc_html_e('Save Package','ivproperty'); ?></button></div>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>
</div>		 