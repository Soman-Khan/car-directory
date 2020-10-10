<?php
	global $wpdb;
	$id='';	$title='';
	if(isset($_REQUEST['id'])){
	$id=sanitize_text_field($_REQUEST['id']);
	}
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE Id = '%s' ",$id));
	if(isset($row->post_title )){
		$title= $row->post_title;
	}	
	?>
<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">
		<div class="row">					
			<div class="col-md-12" id="submit-button-holder">					
				<div class="pull-right"><button class="btn btn-info btn-lg" onclick="return iv_update_coupon();"><?php esc_html_e( 'Update Coupon', 'ivproperty' );?></button></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php esc_html_e( 'Update Coupon', 'ivproperty' );?> </h3>
			</div>	
		</div> 
			<form id="coupon_form_iv" name="coupon_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
				<div class="form-group">
					<label for="text" class="col-md-2 control-label"></label>
					<div id="iv-loading"></div>
				 </div>	
				<div class="form-group">
					<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Coupon Name', 'ivproperty' );?></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="coupon_name" id="coupon_name" value="<?php echo esc_html($title); ?>" placeholder="<?php esc_html_e( 'Enter Coupon Name Or Coupon Code', 'ivproperty' );?>">
					</div>
					</div>	
					 <div class="form-group">
					<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Discount Type', 'ivproperty' );?></label>
					<div class="col-md-5">
						<?php
							$dis_type= get_post_meta($id, 'iv_property_coupon_type', true); 
						?>
						<select  name="coupon_type" id ="coupon_type" class="form-control">
							<option value="amount" 		<?php echo ($dis_type=='amount' ? 'selected' : '' ); ?> ><?php esc_html_e( 'Fixed Amount', 'ivproperty' );?></option>
							<option value="percentage"  <?php echo ($dis_type=='percentage' ? 'selected' : '' ); ?> ><?php esc_html_e( 'Percentage', 'ivproperty' );?></option>
						</select>
					</div>
				 </div> 
				 <div class="form-group">
					<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Package Only', 'ivproperty' );?></label>
					<div class="col-md-5">
						<?php
						global $wpdb, $post;
				$iv_property_pack='iv_property_pack';		
				$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type =%s",$iv_property_pack );
				$membership_pack = $wpdb->get_results($sql);
				$current_pac=get_post_meta($id, 'iv_property_coupon_pac_id', true);
				$current_pac_arr=explode(",",$current_pac);
				if(sizeof($membership_pack)>0){
					$i=0;
					echo'<select multiple name="package_id" id ="package_id" class="form-control">';
					foreach ( $membership_pack as $row )
					{
						$recurring= get_post_meta( $row->ID,'iv_property_package_recurring',true);
						$pac_cost= get_post_meta( $row->ID,'iv_property_package_cost',true);
						if($recurring!='on' and $pac_cost!="" ){ ?>
								<option value="<?php echo esc_html($row->ID); ?>" <?php echo (in_array( $row->ID, $current_pac_arr) ? 'selected' : '') ?>><?php echo esc_html($row->post_title); ?></option>
						<?php
						}
					}	
					echo '</select>';	
				}	
					?>
					</div>
					</div> 
					<div class="form-group">
					<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e( 'Usage Limit', 'ivproperty' );?></label>
					<div class="col-md-5">
						<input type="text" class="form-control" id="coupon_count" name="coupon_count" value="<?php echo get_post_meta($id, 'iv_property_coupon_limit', true); ?>"  placeholder="<?php esc_html_e( 'Enter Usage Limit Number', 'ivproperty' );?>">
					</div>
					</div>
				<div class="form-group" >									
							<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Start Date', 'ivproperty' );?></label>
							<div class="col-md-5">
								<input type="text"  readonly name="start_date"   id="start_date" class="form-control ctrl-textbox"  placeholder="<?php esc_html_e( 'Select Date', 'ivproperty' );?>" value="<?php echo get_post_meta($id, 'iv_property_coupon_start_date', true); ?>">
							</div>
						</div>							  
						<div class="form-group">
					<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e( 'Expire Date', 'ivproperty' );?></label>
					<div class="col-md-5">
						<input type="text" class="form-control" readonly id="end_date" name="end_date" value="<?php echo get_post_meta($id, 'iv_property_coupon_end_date', true); ?>"  placeholder="<?php esc_html_e( 'Select Date', 'ivproperty' );?>">
					</div>
					</div>
					<div class="form-group">
					<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e( 'Amount', 'ivproperty' );?></label>
					<div class="col-md-5">
						<input type="text" class="form-control" id="coupon_amount" name="coupon_amount" value="<?php echo get_post_meta($id, 'iv_property_coupon_amount', true); ?>"  placeholder="<?php esc_html_e( 'Coupon Amount [ Only Amount no Currency ]', 'ivproperty' );?>">
					</div>
					</div>
				<input type="hidden"  id="coupon_id" name="coupon_id" value="<?php echo esc_html($id); ?>"  >
			</form>
			<div class=" col-md-7  bs-callout bs-callout-info">		
		<?php esc_html_e( 'Note : Coupon will work on "One Time Payment" only. Coupon will not work on recurring payment and it will not support 100% discount.		', 'ivproperty' );?>
			</div>
			<div class="row">					
				<div class="col-xs-12">					
					<div align="center">
						<button class="btn btn-info btn-lg" onclick="return iv_update_coupon();"><?php esc_html_e( 'Update Coupon', 'ivproperty' );?></button></div>
						<p>&nbsp;</p>
					</div>
				</div>
			</div>						
	</div>	