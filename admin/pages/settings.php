<?php

	global $wpdb;
?>
<div class="bootstrap-wrapper">
	<div class="container-fluid">
		<br/>
		<div id="update_message"> </div>
		<div class="panel with-nav-tabs panel-info">
			<div class="panel-heading">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#dir-demo" data-toggle="tab"><?php  esc_html_e('Import Data','ivproperty'); ?> </a></li>
					<li ><a href="#dir-setting" data-toggle="tab"><?php  esc_html_e('Listing Settings','ivproperty'); ?> </a></li>
					<li ><a href="#listing-fields" data-toggle="tab"><?php  esc_html_e('Listing Fields','ivproperty'); ?> </a></li>
					<li ><a href="#my-account" data-toggle="tab"><?php  esc_html_e('My Account Menu','ivproperty'); ?> </a></li>
					<li ><a href="#dir-marker" data-toggle="tab"><?php  esc_html_e('Category Image/Marker','ivproperty'); ?></a></li>
					<li ><a href="#city-image" data-toggle="tab"><?php  esc_html_e('Cities Images','ivproperty'); ?></a></li>
					<li ><a href="#all-package" data-toggle="tab"><?php  esc_html_e('Package','ivproperty'); ?></a></li>
					<li ><a href="#page" data-toggle="tab"><?php  esc_html_e('Page','ivproperty'); ?></a></li>
					<li ><a href="#user-setting" data-toggle="tab"><?php  esc_html_e('User Setting','ivproperty'); ?></a></li>
					<li><a href="#payment" data-toggle="tab"><?php  esc_html_e('Terms CheckBox/Coupon','ivproperty'); ?></a></li>
					<li><a href="#email" data-toggle="tab"><?php  esc_html_e('Email','ivproperty'); ?> </a></li>								
					<li><a href="#mailchimp" data-toggle="tab"><?php  esc_html_e('MailChimp','ivproperty'); ?> </a></li>
					<li ><a href="#protected_content" data-toggle="tab"><?php  esc_html_e('Visibility Control','ivproperty'); ?></a></li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="tab-content">								
					<div class="tab-pane  " id="listing-fields">								
						<?php require (wp_iv_property_DIR .'/admin/pages/directory_fields.php');?>
					</div>
					<div class="tab-pane  " id="my-account">								
						<?php require (wp_iv_property_DIR .'/admin/pages/profile-fields.php');?>
					</div>
					<div class="tab-pane  in active " id="dir-demo">								
						<?php require (wp_iv_property_DIR .'/admin/pages/dir-demo.php');?>
					</div>
					<div class="tab-pane  " id="dir-marker">								
						<?php
							require (wp_iv_property_DIR .'/admin/pages/map_marker.php');
						?>
					</div>
					<div class="tab-pane  " id="city-image">								
						<?php
							require (wp_iv_property_DIR .'/admin/pages/city_image.php');
						?>
					</div>
					<div class="tab-pane  " id="all-package">								
						<?php
							require (wp_iv_property_DIR .'/admin/pages/package_all.php');
						?>
					</div>
					<div class="tab-pane  " id="payment-gateway">								
						<?php
							require (wp_iv_property_DIR .'/admin/pages/payment-settings.php');
						?>
					</div>
					<div class="tab-pane  " id="user-setting">								
						<?php
							require (wp_iv_property_DIR .'/admin/pages/user_directory_admin.php');
						?>
					</div>
					<div class="tab-pane  " id="dir-setting">								
						<?php
							require (wp_iv_property_DIR .'/admin/pages/dir_setting.php');
						?>
					</div>
					<div class="tab-pane  " id="protected_content">
						<form class="form-horizontal" role="form"  name='protected_settings' id='protected_settings'>										
							<div class="form-group">
								<h3  class="col-md-12   page-header"><?php esc_html_e( 'Visibility Control', 'ivproperty' );?> </h3>												
							</div>
							<?php
								$store_array=get_option('_iv_visibility_serialize_role');											
								$active_module=get_option('_iv_property_active_visibility'); 
								$active_check_y=''; $active_check_n='';
								if($active_module=='yes' )
								{	$active_check_n='';
									$active_check_y=' checked';												
									}else{ 
									$active_check_y='';
									$active_check_n=' checked';											
								}
							?>
							<div class="row">
								<label  class="col-md-3  pull-left"> <?php esc_html_e( 'Content Visibility Module', 'ivproperty' );?> :</label>
								<div class="col-md-3">
									<label>												
										<input type="radio" name="active_visibility" id="active_visibility" value='yes' <?php echo esc_html($active_check_y); ?> > <?php esc_html_e( 'Hide Content By Role Access', 'ivproperty' );?>
									</label>	
								</div>
								<div class="col-md-3">	
									<label>											
										<input type="radio"  name="active_visibility" id="active_visibility" value='no' <?php echo esc_html($active_check_n); ?> > <?php esc_html_e( 'Show All', 'ivproperty' );?>
									</label>
								</div>												
							</div>
							<div class=" row form-group"> <br/>
							</div>
							<div class="form-group">
								<h3  class="col-md-12   page-header"><?php esc_html_e( 'Content Show By Roles', 'ivproperty' );?></h3>												
							</div>
							<div class=" col-md-12  bs-callout bs-callout-info">							
								<?php esc_html_e( 'Select which contents are available for each user role.', 'ivproperty' );?>											
							</div>
							<div class="row ">
								<div class="col-md-12 ">
									<table class="table table-bordered table-responsive table-hover ">												  
										<thead>
											<tr>
												<th></th>
												<?php
													global $wp_roles;
													foreach ( $wp_roles->roles as $key=>$value ){
														if($value['name']!='Administrator'){
															echo '<th class="text-center">'.$value['name'].'</th>'; 
														}
													}
													echo '<th class="text-center">Visitor</th>'; 
												?>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th><?php esc_html_e( 'Check/Uncheck', 'ivproperty' );?></th>
												<?php
													global $wp_roles;
													foreach ( $wp_roles->roles as $key=>$value ){
														if($value['name']!='Administrator'){
															echo '<td class="text-center"><input onclick="return protect_select_all(\''.$key.'\');" type="checkbox" name="'.$key.'_all" id="'.$key.'_all" value="'.$key.'" class="'.$key.'"></td>'; 
														}
													}
													echo '<td class="text-center"><input type="checkbox"  onclick="return protect_select_all(\'visitor\');" name="visitor_all" id="visitor_all"  value="visitor_all"  class="visitor"></td>'; 
												?>
											</tr>
										</tfoot>
										<tbody>
											<?php 
												$dir_heads[0]='floor plan';													
												$dir_heads[1]='public facilities';
												$dir_heads[2]='video';
												$dir_heads[3]='contact info';
												$dir_heads[4]='Map';
												$dir_heads[5]='Description';
												$dir_heads[6]='Agent';
												foreach($dir_heads as $head) { 
													echo'<tr>';
													echo ' <th scope="row">'.$head.'</th> ';
													foreach ( $wp_roles->roles as $key=>$value ){
														if($key!='administrator'){
															if(isset($store_array[$key]))
															{	if(in_array($head , $store_array[$key])){
																echo '<td class="text-center"><input type="checkbox" name="'.$key.'[]" id="'.$key.'[]"  class="'.$key.'"  value="'.$head.'" checked></td>'; 
																}else{
																echo '<td class="text-center"><input type="checkbox" name="'.$key.'[]" id="'.$key.'[]"  class="'.$key.'"  value="'.$head.'"></td>'; 
															}
															}else{ 
															echo '<td class="text-center"><input type="checkbox" name="'.$key.'[]" id="'.$key.'[]"  class="'.$key.'"  value="'.$head.'"></td>'; 
															}
														}
													}
													if(isset($store_array['visitor'])){	
														if(in_array($head  , $store_array['visitor'])){
															echo '<td class="text-center"><input type="checkbox" class="visitor" name="visitor[]" id="visitor[]" value="'.$head.'"  checked ></td>';
															}else{
															echo '<td class="text-center"><input type="checkbox" name="visitor[]" id="visitor[]" value="'.$head.'" class="visitor" ></td>';
														}
														}else{
														echo '<td class="text-center"><input type="checkbox" name="visitor[]" id="visitor[]" value="'.$head.'" class="visitor" ></td>';
													}		
													echo'</tr>';
												}
											?> 													
										</tbody>
									</table>
								</div>			
							</div>	
							<div class="form-group">
								<label  class="col-md-3 control-label"><?php esc_html_e( 'Already logged In User Message', 'ivproperty' );?> </label>
								<div class="col-md-6">
									<?php
										$login_message=get_option('_iv_visibility_login_message');
										if($login_message=='' ){
											$login_message='Please Upgrade Your Account to View the Content.';
										}												
										$visitor_message=get_option('_iv_visibility_visitor_message');
										if($visitor_message=='' ){
											$visitor_message='Please Login to view the content.';
										}
									?>												
									<input type="text" class="form-control" name="login_message" id="login_message" value="<?php echo esc_html($login_message); ?>" placeholder="Enter Message">
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-3 control-label"> <?php esc_html_e( 'Visitor Message', 'ivproperty' );?></label>
								<div class="col-md-6">												
									<input type="text" class="form-control" name="visitor_message" id="visitor_message" value="<?php echo esc_html($visitor_message); ?>" placeholder="Enter Message">
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-3 control-label"> </label>
								<div class="col-md-8">
									<button type="button" onclick="return  iv_update_protected_settings();" class="btn btn-success"><?php esc_html_e( 'Update', 'ivproperty' );?></button>
								</div>
							</div>
						</form>
					</div>	
					<div class="tab-pane  " id="user_reg">
						<form class="form-horizontal" role="form"  name='account_settings' id='account_settings'>
							<br/>
							<?php
								$args = array(
								'child_of'     => 0,
								'sort_order'   => 'ASC',
								'sort_column'  => 'post_title',
								'hierarchical' => 1,															
								'post_type' => 'page'
								);
							?>
							<div class="form-group">
								<label  class="col-md-3   control-label"><?php esc_html_e( 'User Registration Page Redirect:', 'ivproperty' );?> </label>
								<div class="checkbox col-md-3 ">
									<?php
										$iv_redirect = get_option( 'iv_property_signup_redirect');
										if ( $pages = get_pages( $args ) ){
											echo "<select id='signup_redirect' name='signup_redirect' class='form-control'>";
											echo "<option value='defult' ".($iv_redirect=='defult' ? 'selected':'').">Default WP Action</option>";
											foreach ( $pages as $page ) {
												echo "<option value='{$page->ID}' ".($iv_redirect==$page->ID ? 'selected':'').">{$page->post_title}</option>";
											}
											echo "</select>";
										}
									?>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-3   control-label"><?php esc_html_e( 'User My Account Page Redirect:', 'ivproperty' );?> </label>
								<div class="checkbox col-md-3 ">
									<?php
										$iv_redirect = get_option( '_iv_property_profile_page');
										if ( $pages = get_pages( $args ) ){
											echo "<select id='pri_profile_redirect' name='pri_profile_redirect' class='form-control'>";
											echo "<option value='defult' ".($iv_redirect=='defult' ? 'selected':'').">Default WP Action</option>";
											foreach ( $pages as $page ) {
												echo "<option value='{$page->ID}' ".($iv_redirect==$page->ID ? 'selected':'').">{$page->post_title}</option>";
											}
											echo "</select>";
										}
									?>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-3   control-label"><?php esc_html_e( 'User Public Profile Page Redirect:', 'ivproperty' );?> </label>
								<div class="checkbox col-md-3 ">
									<?php
										$iv_redirect = get_option( '_iv_property_profile_public_page');
										if ( $pages = get_pages( $args ) ){
											echo "<select id='profile_redirect' name='profile_redirect' class='form-control'>";
											echo "<option value='defult' ".($iv_redirect=='defult' ? 'selected':'').">Default WP Action</option>";
											foreach ( $pages as $page ) {
												echo "<option value='{$page->ID}' ".($iv_redirect==$page->ID ? 'selected':'').">{$page->post_title}</option>";
											}
											echo "</select>";
										}
									?>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-3   control-label"><?php esc_html_e( 'Hide Admin Bar for All Users Except for Administrators:', 'ivproperty' );?> </label>																	
								<div class=" col-md-3 ">																			
									<?php
										$hide_admin_bar='';
										if( get_option( '_iv_property_hide_admin_bar' ) ) {
											$hide_admin_bar= get_option('_iv_property_hide_admin_bar'); 
										}	 
										?><label>
										<input  class="" type="checkbox" name="hide_admin_bar" id="hide_admin_bar" value="yes" <?php echo ($hide_admin_bar=='yes'? 'checked':'' ); ?> > 
										<?php esc_html_e( 'Hide', 'ivproperty' );?> 
									</label>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-3 control-label"> </label>
								<div class="col-md-8">
									<button type="button" onclick="return  iv_update_account_settings();" class="btn btn-success"><?php esc_html_e( 'Update', 'ivproperty' );?></button>
								</div>
							</div>
						</form>			
					</div>
					<div class="tab-pane  " id="payment">
						<!--Payment  -->
						<form class="form-horizontal" role="form"  name='payment_settings' id='payment_settings'>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'Terms CheckBox', 'ivproperty' );?> : </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-1 ">
										<label><?php
											$t_terms='';
											if( get_option( 'iv_property_payment_terms' ) ) {
												$t_terms= get_option('iv_property_payment_terms'); 
											}	 
										?>
										<input type="checkbox" name="iv_terms" id="iv_terms" value="yes" <?php echo ($t_terms=='yes'? 'checked':'' ); ?> ><?php esc_html_e( 'Dispaly', 'ivproperty' );?> 
										</label>
									</div>
									<div class=" col-md-6 col-xs-6 col-sm-6">	
										<?php
											$t_text='I have read & accept the Terms & Conditions';
											if( get_option( 'iv_property_payment_terms_text' ) ) {
												$t_text= get_option('iv_property_payment_terms_text'); 
											}	 
										?>																			
										<textarea class="form-control" rows="3" name='terms_detail' id='terms_detail' >  <?php echo esc_html($t_text); ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'Hide Coupon Buton', 'ivproperty' );?> : </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-1 ">
										<label><?php
											$t_coupon='';
											if( get_option( '_iv_property_payment_coupon' ) ) {
												$t_coupon= get_option('_iv_property_payment_coupon'); 
											}	 
										?>
										<input type="checkbox" name="iv_coupon" id="iv_coupon" value="yes" <?php echo ($t_coupon=='yes'? 'checked':'' ); ?> ><?php esc_html_e( 'Hide', 'ivproperty' );?> 
										</label>
									</div>
								</div>
							</div>
							<div class="form-group  row">
								<label  class="col-md-3  control-label"> </label>
								<div class="col-md-4">
									<button type="button" onclick="return  iv_update_payment_settings_terms();" class="btn btn-success"><?php esc_html_e( 'Update', 'ivproperty' );?></button>				
								</div>							
							</div>
						</form>
					</div>
					<div class="tab-pane  in " id="page">
						<form class="form-horizontal" role="form"  name='page_settings' id='page_settings'>
							<?php
								$price_table=get_option('_iv_property_price_table'); 
								$registration=get_option('_iv_property_registration'); 
								$profile_page=get_option('_iv_property_profile_page'); 	
								$profile_public=get_option('_iv_property_profile_public_page');
								$login_page=get_option('_iv_property_login_page');  										
								$thank_you=get_option('_iv_property_thank_you_page'); 	
								$args = array(
								'child_of'     => 0,
								'sort_order'   => 'ASC',
								'sort_column'  => 'post_title',
								'hierarchical' => 1,															
								'post_type' => 'page'
								);
							?>
							<div class="form-group">
								<label  class="col-md-2   control-label">Price Listing: </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-4 ">
										<?php
											if ( $pages = get_pages( $args ) ){
												echo "<select id='pricing_page' name='pricing_page' class='form-control'>";
												foreach ( $pages as $page ) {
													echo "<option value='{$page->ID}' ".($price_table==$page->ID ? 'selected':'').">{$page->post_title}</option>";
												}
												echo "</select>";
											}
										?>
									</div>
									<div class="checkbox col-md-1 ">
										<?php
											$reg_page= get_permalink( $price_table); 
										?>
										<a class="btn btn-info " href="<?php  echo esc_url($reg_page); ?>"><?php esc_html_e( 'View', 'ivproperty' );?> </a>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'User Sign Up:', 'ivproperty' );?> </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-4 ">
										<?php
											if ( $pages = get_pages( $args ) ){
												echo "<select id='signup_page' name='signup_page' class='form-control'>";
												foreach ( $pages as $page ) {
													echo "<option value='{$page->ID}' ".($registration==$page->ID ? 'selected':'').">{$page->post_title}</option>";
												}
												echo "</select>";
											}
										?>
									</div>
									<div class="checkbox col-md-1 ">
										<?php
											$reg_page= get_permalink( $registration); 
										?>
										<a class="btn btn-info " href="<?php  echo esc_url($reg_page); ?>"> <?php esc_html_e( 'View', 'ivproperty' );?></a>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'Signup Thanks', 'ivproperty' );?> : </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-4 ">
										<?php
											if ( $pages = get_pages( $args ) ){
												echo "<select id='thank_you_page'  name='thank_you_page'  class='form-control'>";
												foreach ( $pages as $page ) {
													echo "<option value='{$page->ID}' ".($thank_you==$page->ID ? 'selected':'').">{$page->post_title}</option>";
												}
												echo "</select>";
											}
										?>
									</div>
									<div class="checkbox col-md-1 ">
										<?php
											$reg_page= get_permalink( $thank_you); 
										?>
										<a class="btn btn-info " href="<?php  echo esc_url($reg_page); ?>"> <?php esc_html_e( 'View', 'ivproperty' );?></a>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'Login Page:', 'ivproperty' );?> </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-4 ">
										<?php
											if ( $pages = get_pages( $args ) ){
												echo "<select id='login_page'  name='login_page'  class='form-control'>";
												foreach ( $pages as $page ) {
													echo "<option value='{$page->ID}' ".($login_page==$page->ID ? 'selected':'').">{$page->post_title}</option>";
												}
												echo "</select>";
											}
										?>
									</div>
									<div class="checkbox col-md-1 ">
										<?php
											$reg_page= get_permalink( $login_page); 
										?>
										<a class="btn btn-info " href="<?php  echo esc_url($reg_page); ?>"><?php esc_html_e( 'View', 'ivproperty' );?> </a>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'User My Account', 'ivproperty' );?> : </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-4 ">
										<?php
											if ( $pages = get_pages( $args ) ){
												echo "<select id='profile_page'  name='profile_page'  class='form-control'>";
												foreach ( $pages as $page ) {
													echo "<option value='{$page->ID}' ".($profile_page==$page->ID ? 'selected':'').">{$page->post_title}</option>";
												}
												echo "</select>";
											}
										?>
									</div>
									<div class="checkbox col-md-1 ">
										<?php
											$reg_page= get_permalink( $profile_page); 
										?>
										<a class="btn btn-info " href="<?php  echo esc_url($reg_page); ?>"> <?php esc_html_e( 'View', 'ivproperty' );?></a>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'User Public Profile:', 'ivproperty' );?> </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-4 ">
										<?php																				
											if ( $pages = get_pages( $args ) ){
												echo "<select id='profile_public'  name='profile_public'  class='form-control'>";
												foreach ( $pages as $page ) {
													echo "<option value='{$page->ID}' ".($profile_public==$page->ID ? 'selected':'').">{$page->post_title}</option>";
												}
												echo "</select>";
											}
										?>
									</div>
									<div class="checkbox col-md-1 ">
										<?php																				
											$reg_page= get_permalink( $profile_public); 
										?>
										<a class="btn btn-info " href="<?php  echo esc_url($reg_page); ?>"><?php esc_html_e( 'View', 'ivproperty' );?> </a>
									</div>
								</div>	
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php  esc_html_e('Cron Job URL','ivproperty');  ?> </label>
								<div class="col-md-3 col-xs-10 col-sm-10">
									<b> <a href="<?php echo admin_url('admin-ajax.php'); ?>?action=iv_property_cron_job"><?php echo admin_url('admin-ajax.php'); ?>?action=iv_property_cron_job </a></b>
								</div>
								<div class="checkbox col-md-4 ">
									<?php esc_html_e( 'Cron JOB Detail : Auto Bidding Renew update, Hide Listing( Package setting),Subscription Remainder email.', 'ivproperty' );?>
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"> </label>
								<div class="col-md-10 col-xs-10 col-sm-10">
									<div class="checkbox col-md-4  ">
										<button type="button" onclick="return  iv_update_page_settings();" class="btn btn-success"><?php esc_html_e( 'Update', 'ivproperty' );?></button>
									</div>
									<div class="checkbox col-md-1 ">
									</div>
								</div>	
							</div>	
						</form>
					</div>
					<div class="tab-pane " id="email">
						<form class="form-horizontal" role="form"  name='email_settings' id='email_settings'>	
							<?php
								$form_id='';										
							?>
							<div class="form-group">
								<label  class="col-md-2  control-label"> <?php esc_html_e( 'Email Sender :', 'ivproperty' );?> </label>
								<div class="col-md-4 ">
									<?php
										$admin_email_setting='';
										if( get_option( 'admin_email_iv_property' )==FALSE ) {
											$admin_email_setting = get_option('admin_email');						 
											}else{
											$admin_email_setting = get_option('admin_email_iv_property');								
										}	
									?>
									<input type="text" class="form-control" id="iv_property_admin_email" name="iv_property_admin_email" value="<?php echo esc_html($admin_email_setting); ?>" placeholder="">
								</div>
							</div>	
							<div class="form-group">
								<h3  class="col-md-12   page-header"><?php esc_html_e( 'Signup / Forget password Email', 'ivproperty' );?> </h3>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'Email Subject', 'ivproperty' );?>  : </label>
								<div class="col-md-4 ">
									<?php
										$iv_property_signup_email_subject = get_option( 'iv_property_signup_email_subject');
									?>
									<input type="text" class="form-control" id="iv_property_signup_email_subject" name="iv_property_signup_email_subject" value="<?php echo esc_html($iv_property_signup_email_subject); ?>" placeholder="Enter signup email subject">
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"> <?php esc_html_e( 'Email Tempalte ', 'ivproperty' );?>: </label>
								<div class="col-md-10 ">
									<?php
										$settings_a = array(															
										'textarea_rows' =>20,															 
										);
										$content_client = get_option( 'iv_property_signup_email');
										$editor_id = 'signup_email_template';
									?>
									<textarea id="<?php echo esc_html($editor_id) ;?>" name="<?php echo esc_html($editor_id) ;?>" rows="20" class="col-md-12 ">
										<?php echo esc_html($content_client); ?>
									</textarea>		
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"> <?php esc_html_e( 'Forget Subject', 'ivproperty' );?> : </label>
								<div class="col-md-4 ">
									<?php
										$iv_property_forget_email_subject = get_option( 'iv_property_forget_email_subject');
									?>
									<input type="text" class="form-control" id="forget_email_subject" name="forget_email_subject" value="<?php echo esc_html($iv_property_forget_email_subject); ?>" placeholder="Enter forget email subject">
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'Forget Tempalte :', 'ivproperty' );?>  </label>
								<div class="col-md-10 ">
									<?php
										$settings_forget = array(															
										'textarea_rows' =>'20',	
										'editor_class'  => 'form-control',														 
										);
										$content_client = get_option( 'iv_property_forget_email');
										$editor_id = 'forget_email_template';																				
									?>
									<textarea id="<?php echo esc_html($editor_id );?>" name="<?php echo esc_html($editor_id) ;?>" rows="20" class="col-md-12 ">
										<?php echo esc_html($content_client); ?>
									</textarea>		
								</div>
							</div>
							<div class="form-group">
								<h3  class="col-md-12 col-xs-12 col-sm-12  page-header"><?php esc_html_e( 'Order Email', 'ivproperty' );?> </h3>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"><?php esc_html_e( 'User Email Subject :', 'ivproperty' );?>  </label>
								<div class="col-md-4 ">
									<?php
										$iv_property_order_email_subject = get_option( 'iv_property_order_client_email_sub');
									?>
									<input type="text" class="form-control" id="iv_property_order_email_subject" name="iv_property_order_email_subject" value="<?php echo esc_html($iv_property_order_email_subject); ?>" placeholder="Enter order email subject">
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"> <?php esc_html_e( 'User Email Tempalte :', 'ivproperty' );?> </label>
								<div class="col-md-10 ">
									<?php
										$settings_a = array(															
										'textarea_rows' =>20,															 
										);
										$content_client = get_option( 'iv_property_order_client_email');
										$editor_id = 'order_client_email_template';																			
									?>
									<textarea id="<?php echo esc_html($editor_id);?>" name="<?php echo esc_html($editor_id) ;?>" rows="20" class="col-md-12 ">
										<?php echo esc_html($content_client); ?>
									</textarea>			
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"> <?php esc_html_e( 'Admin Email Subject :', 'ivproperty' );?> </label>
								<div class="col-md-4 ">
									<?php
										$iv_property_order_admin_email_subject = get_option( 'iv_property_order_admin_email_sub');
									?>
									<input type="text" class="form-control" id="iv_property_order_admin_email_subject" name="iv_property_order_admin_email_subject" value="<?php echo esc_html($iv_property_order_admin_email_subject); ?>" placeholder="Enter order email subject">
								</div>
							</div>
							<div class="form-group">
								<label  class="col-md-2   control-label"> <?php esc_html_e( 'Admin Email Tempalte :', 'ivproperty' );?> </label>
								<div class="col-md-10 ">
									<?php
										$settings_a = array(															
										'textarea_rows' =>20,															 
										);
										$content_client = get_option( 'iv_property_order_admin_email');
										$editor_id = 'order_admin_email_template';																							
									?>
									<textarea id="<?php echo esc_html($editor_id) ;?>" name="<?php echo esc_html($editor_id );?>" rows="20" class="col-md-12 ">
										<?php echo esc_html($content_client); ?>
									</textarea>		
								</div>
							</div>
							<div class="form-group">
								<h3  class="col-md-12 col-xs-12 col-sm-12  page-header"><?php esc_html_e( 'Reminder Email', 'ivproperty' );?> </h3>
							</div>
							<?php
								include (wp_iv_property_DIR .'/admin/pages/reminder_email.php');
							?>
							<div class="form-group">
								<h3  class="col-md-12 col-xs-12 col-sm-12  page-header"><?php esc_html_e( 'New Message Email', 'ivproperty' );?> </h3>
							</div>
							<?php
								include (wp_iv_property_DIR .'/admin/pages/new-message.php');
							?>
						</form>
						<div id="email-success"></div>
						<div class="row pull-left">
							<div class="col-md-12 ">
								<button type="button" onclick="return  iv_update_email_settings();" class="btn btn-success"><?php  esc_html_e('Update Email Setting','ivproperty');?>  </button>					
							</div>							
						</div>	
					</div>
					<div class="tab-pane " id="mailchimp">
						<div class="form-group  row">
							<label  class="col-md-3  control-label"> </label>
							<div class="col-md-4">
								<button type="button" onclick="return  iv_update_mailchamp_settings();" class="btn btn-success"><?php esc_html_e( 'Update MailChimp Setting', 'ivproperty' );?></button>					
							</div>							
						</div>						
						<form class="form-horizontal" role="form"  name='mailchimp_settings' id='mailchimp_settings'>
							<div class="form-group row">
								<label  class="col-md-3 col-xs-6 col-sm-6 control-label"> <?php esc_html_e( 'MailChimp API Key :', 'ivproperty' );?> </label>
								<div class="col-md-4 col-xs-6 col-sm-6">
									<?php
										$iv_mailchimp_api_key='';
										if( get_option( 'iv_property_mailchimp_api_key' )==FALSE ) {
											$iv_mailchimp_api_key = get_option('iv_property_mailchimp_api_key');						 
											}else{
											$iv_mailchimp_api_key = get_option('iv_property_mailchimp_api_key');								
										}
									?>
									<input type="text" class="form-control" id="iv_property_mailchimp_api_key" name="iv_property_mailchimp_api_key" value="<?php echo esc_html($iv_mailchimp_api_key); ?>" placeholder="">
									<a href="//admin.mailchimp.com/account/api" target="_blank"><?php  esc_html_e('Get your API key here','ivproperty');?>.</a>
								</div>
							</div>
							<div class="form-group row">
								<label  class="col-md-3 col-xs-6 col-sm-6  control-label"> </label>
								<div class="col-md-4 col-xs-6 col-sm-6 ">														
								</div>
							</div>
							<div class="form-group row">	
								<label  class="col-md-3 col-xs-6 col-sm-6 control-label"><?php esc_html_e( 'Mailchimp List ', 'ivproperty' );?>: </label>
								<div class="col-md-4 col-xs-6 col-sm-6">
									<?php 
										if( ! class_exists('MailChimp' ) ) {
											include(wp_iv_property_DIR . '/inc/MailChimp.php');
										}
										$iv_mailchimp_api_key='';
										if( get_option( 'iv_property_mailchimp_api_key' )==FALSE ) {
											$iv_mailchimp_api_key = get_option('iv_property_mailchimp_api_key');						 
											}else{
											$iv_mailchimp_api_key = get_option('iv_property_mailchimp_api_key');								
										}	
										echo '<select class="form-control" id="iv_property_mailchimp_list" name="iv_property_mailchimp_list">';
										if($iv_mailchimp_api_key!=''){
											$iv_form_membership_mailchimp_list=get_option( 'iv_property_mailchimp_list'); 
											$api = new MailChimp($iv_mailchimp_api_key);
											$list_data = $api->get('lists');
											if($list_data){
												foreach($list_data['lists'] as $key => $list):
												$lists[$list['id']] = $list['name'];
												echo '<option value="'.$list['id'].'" '.($iv_form_membership_mailchimp_list==$list['id']? 'selected': '').'>'.$list['name'].' </option>';
												endforeach;
												}else{
												echo '<option value="" > Not Available</option>';
											}													
										}													
										echo'</select>';
									?>
								</div>
							</div>
							<div class=" col-md-7  bs-callout bs-callout-info">		
								<?php esc_html_e( 'Signup user email address will go to the mailchimp list.', 'ivproperty' );?>
							</div>
							<div class="clearfix"></div>
						</form>
						<div class="form-group  row">
							<label  class="col-md-3  control-label"> </label>
							<div class="col-md-4">
								<button type="button" onclick="return  iv_update_mailchamp_settings();" class="btn btn-success"><?php esc_html_e( 'Update MailChimp Setting', 'ivproperty' );?></button>					
							</div>							
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>