<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">		
		<div class="row">					
			<div class="col-md-12" id="submit-button-holder">					
				<div class="pull-right"><button class="btn btn-info btn-lg" onclick="return iv_create_coupon();"><?php esc_html_e( 'Save Coupon', 'ivproperty' );?></button></div>
			</div>
		</div>	
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php esc_html_e( 'Create New Coupon ', 'ivproperty' );?></h3>						
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
					<input type="text" class="form-control" name="coupon_name" id="coupon_name" value="">
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Discount Type', 'ivproperty' );?></label>
				<div class="col-md-5">
					<select  name="coupon_type" id ="coupon_type" class="form-control">
						<option value="amount" ><?php esc_html_e( 'Fixed Amount', 'ivproperty' );?></option>
						<option value="percentage" ><?php esc_html_e( 'Percentage', 'ivproperty' );?></option>
					</select>
				</div>
			</div> 			
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Package Only', 'ivproperty' );?></label>
				<div class="col-md-5">
					<?php
						global $wpdb, $post;
						$iv_property_pack='iv_property_pack';		
						$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'",$iv_property_pack);
						$membership_pack = $wpdb->get_results($sql);
						$total_package=count($membership_pack);
						if(sizeof($membership_pack)>0){
							$i=0;
							echo'<select multiple name="package_id" id ="package_id" class="form-control">';
							foreach ( $membership_pack as $row )
							{	
								$recurring= get_post_meta( $row->ID,'iv_property_package_recurring',true);
								$pac_cost= get_post_meta( $row->ID,'iv_property_package_cost',true);
								if($recurring!='on' and $pac_cost!="" ){										
									echo '<option value="'. $row->ID.'" selected >'. $row->post_title.'</option>';
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
					<input type="text" class="form-control" id="coupon_count" name="coupon_count" value=""  value="999999">
				</div>
			</div>
			<div class="form-group" >									
				<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Start Date', 'ivproperty' );?></label>
				<div class="col-md-5">
					<input type="text"  name="start_date"  readonly   id="start_date" class="form-control ctrl-textbox"  placeholder="<?php esc_html_e( 'Select Date', 'ivproperty' );?>">
				</div>
			</div>							  
			<div class="form-group">
				<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e( 'Expire Date', 'ivproperty' );?></label>
				<div class="col-md-5">
					<input type="text" class="form-control" readonly id="end_date" name="end_date" value=""  placeholder="<?php esc_html_e( 'Select Date', 'ivproperty' );?>">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e( 'Amount', 'ivproperty' );?></label>
				<div class="col-md-5">
					<input type="text" class="form-control" id="coupon_amount" name="coupon_amount" value=""  placeholder=" <?php esc_html_e( 'Coupon number [ no currency or comma ]', 'ivproperty' );?>">
				</div>
			</div>	
		</form>
		<div class="row">					
			<div class="col-xs-12">					
				<div align="center">
					<button class="btn btn-info btn-lg" onclick="return iv_create_coupon();"><?php esc_html_e( 'Save Coupon', 'ivproperty' );?></button>
				</div>
				<p>&nbsp;</p>
			</div>
		</div>
		<div class=" col-md-7  bs-callout bs-callout-info">		
			<?php esc_html_e( 'Note : Coupon will work on "One Time Payment" only. Coupon will not work on recurring payment and it will not support 100% discount.		', 'ivproperty' );?>
		</div>
	</div>						
</div>	 