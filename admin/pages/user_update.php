<?php
	global $wpdb,$wp_roles;
	$user_id='';
	if(isset($_GET['id'])){ $user_id=sanitize_text_field($_GET['id']);}
	$user = new WP_User( $user_id );
?>
<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">				
		<div class="row">
			<div class="col-md-12"><h3 class=""><?php esc_html_e( 'User Settings: Edit', 'ivproperty' );?> </h3>
			</div>	
		</div> 
		<div class="col-md-7 panel panel-info">
			<div class="panel-body">				
				<form id="user_form_iv" name="user_form_iv" class="form-horizontal" role="form" onsubmit="return false;">				
					<div class="form-group">
						<label for="text" class="col-md-3 control-label"></label>
						<div id="iv-loading"></div>
					</div>	
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'User Name', 'ivproperty' );?></label>
						<div class="col-md-8">
							<label for="inputEmail3" class="control-label"><?php echo esc_html($user->user_login); ?></label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Email Address', 'ivproperty' );?></label>
						<div class="col-md-8">									
							<label for="inputEmail3" class="control-label"><?php echo esc_html($user->user_email); ?></label>
						</div>
					</div>								 
					<div class="form-group">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'User Role', 'ivproperty' );?></label>
						<div class="col-md-8">
							<?php
								$user_role= '';
								if(isset($user->roles[0])){
									$user_role= $user->roles[0];
									}else{
									if(isset($user->roles[1])){
										$user_role= $user->roles[1];
									}
								}
							?>
							<select name="user_role"  class="form-control">
								<?php											
									foreach ( $wp_roles->roles as $key=>$value ){															
										echo'<option value="'.$key.'"  '.($user_role==$key? " selected" : " ") .' >'.esc_html($key).'</option>';	
									}
								?>	
							</select>								
						</div>
					</div> 
					<div class="form-group">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'User Package', 'ivproperty' );?></label>
						<div class="col-md-8">									
							<?php
								$post_type='iv_property_pack';
								$membership_pack = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type = %s ", $post_type ));	
								$total_package=count($membership_pack);
								if($membership_pack>0){
									$i=0; $current_package_id=get_user_meta($user_id,'iv_property_package_id',true);
									echo'<select name="package_sel"  class=" form-control">';
									foreach ( $membership_pack as $row )
									{
										if($current_package_id==$row->ID){
											echo '<option value="'. esc_html($row->ID).'" selected>'. esc_html($row->post_title). esc_html__( '[User Current Package]', 'ivproperty' ).' </option>';
											}else{
											echo '<option value="'. esc_html($row->ID).'" >'. esc_html($row->post_title).'</option>';
										}
										$i++;
									}
									echo '</select>';
								}
							?>
						</div>
					</div> 							  
					<div class="form-group">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'Payment Status', 'ivproperty' );?></label>
						<div class="col-md-8">
							<?php
								$payment_status= get_user_meta($user_id, 'iv_property_payment_status', true);
							?>
							<select name="payment_status" id ="payment_status" class="form-control">
								<option value="success" <?php echo ($payment_status == 'success' ? 'selected' : '') ?>><?php esc_html_e( 'Success', 'ivproperty' );?></option>
								<option value="pending" <?php echo ($payment_status == 'pending' ? 'selected' : '') ?>><?php esc_html_e( 'Pendinge', 'ivproperty' );?></option>
							</select>	
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Expiry Date', 'ivproperty' );?></label>
						<div class="col-md-8">
							<?php
								$exp_date= get_user_meta($user_id, 'iv_property_exprie_date', true);
							?>
							<input type="text"  name="exp_date"  readonly   id="exp_date" class="form-control ctrl-textbox"  value="<?php echo esc_html($exp_date); ?>" placeholder="">
						</div>
					</div>							
					<input type="hidden"  name="user_id"     id="user_id"   value="<?php echo esc_html($user_id); ?>" >
					<div class="row">					
						<div class="col-md-12">	
							<label for="" class="col-md-4 control-label"></label>
							<div class="col-md-8">
							<button class="btn btn-info " onclick="return update_user_setting();"><?php esc_html_e( 'Update User', 'ivproperty' );?></button></div>
							<p>&nbsp;</p>
						</div>
					</div>
				</div>								
			</form>		
		</div>			
	</div>
</div>