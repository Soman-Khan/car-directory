<div class="profile-content">
	<div class="portlet row light">
			<div class="portlet-title tabbable-line clearfix">
				<div class="caption caption-md">
					<span class="caption-subject"><?php   esc_html_e('Profile','ivproperty');?> </span>
				</div>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_1_1" data-toggle="tab"><?php   esc_html_e('Personal Info','ivproperty');?> </a>
					</li>
					<li>
						<a href="#tab_1_3" data-toggle="tab"><?php   esc_html_e('Change Password','ivproperty');?> </a>
					</li>
					<li>
						<a href="#tab_1_5" data-toggle="tab"><?php   esc_html_e('Social','ivproperty');?> </a>
					</li>
					<li>
						<a href="#tab_1_4" data-toggle="tab"><?php   esc_html_e('Privacy Settings','ivproperty');?> </a>
					</li>
				</ul>
			</div>                  
			<div class="portlet-body">
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1_1">
						<form role="form" name="profile_setting_form" id="profile_setting_form" action="#">
							<div class="form-group">
								<label class="control-label"><?php esc_html_e( 'First Name', 'ivproperty' );?></label>
								<input type="text" placeholder="John" name="first_name" id="first_name"  class="form-control" value="<?php echo get_user_meta($current_user->ID,'first_name',true); ?>"/>
							</div>                         
							<div class="form-group">
								<label class="control-label"><?php esc_html_e( 'Last Name', 'ivproperty' );?></label>
								<input type="text" placeholder="Doe"  name="last_name" id="last_name" class="form-control"  value="<?php echo get_user_meta($current_user->ID,'last_name',true); ?>" />
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e( 'Phone Number', 'ivproperty' );?></label>
								<input type="text" placeholder="+1 646 580 232" name="phone" id="phone" class="form-control"  value="<?php echo get_user_meta($current_user->ID,'phone',true); ?>"/>
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e( 'Mobile Number', 'ivproperty' );?></label>
								<input type="text" placeholder="+1 646 580 DEMO (6284)" name="mobile" id="mobile"class="form-control"  value="<?php echo get_user_meta($current_user->ID,'mobile',true); ?>"/>
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e( 'Address', 'ivproperty' );?></label>
								<input type="text" placeholder="" name="address" id="address" value="<?php echo get_user_meta($current_user->ID,'address',true); ?>" class="form-control"/>
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e( 'Occupation', 'ivproperty' );?></label>
								<input type="text" placeholder="Web Developer" class="form-control"  name="occupation" id="occupation" value="<?php echo get_user_meta($current_user->ID,'occupation',true); ?>" />
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e( 'About', 'ivproperty' );?></label>
								<textarea class="form-control" name="about" id="about" rows="3" placeholder="About!!!"  ><?php echo get_user_meta($current_user->ID,'description',true); ?></textarea>
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e( 'Website Url', 'ivproperty' );?></label>
								<input type="text"id="web_site" name="web_site" placeholder="www.mywebsite.com" class="form-control" value ="<?php echo get_user_meta($current_user->ID,'web_site',true);?>"/>
							</div>
							<div class="margiv-top-10">
		<div class="" id="update_message"></div>
		<button type="button" onclick="update_profile_setting();"  class="btn green-haze"><?php   esc_html_e('Save Changes','ivproperty');?></button>
							</div>
						</form>
					</div>
<div class="tab-pane" id="tab_1_3">
						<form action="" name="pass_word" id="pass_word">
							<div class="form-group">
								<label class="control-label"><?php   esc_html_e('Current Password','ivproperty');?> </label>
								<input type="password" id="c_pass" name="c_pass" class="form-control"/>
							</div>
							<div class="form-group">
								<label class="control-label"><?php   esc_html_e('New Password','ivproperty');?> </label>
								<input type="password" id="n_pass" name="n_pass" class="form-control"/>
							</div>
							<div class="form-group">
								<label class="control-label"><?php   esc_html_e('Re-type New Password','ivproperty');?> </label>
								<input type="password" id="r_pass" name="r_pass" class="form-control"/>
							</div>
							<div class="margin-top-10">
								<div class="" id="update_message_pass"></div>
							<button type="button" onclick="iv_update_password();"  class="btn green-haze"><?php   esc_html_e('Change Password','ivproperty');?> </button>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="tab_1_5">
						<form action="#" name="setting_fb" id="setting_fb">
							<div class="form-group">
								<label class="control-label"><?php esc_html_e('FaceBook','ivproperty');?></label>
								<input type="text" name="facebook" id="facebook" value="<?php echo esc_html(get_user_meta($current_user->ID,'facebook',true)); ?>" class="form-control"/>
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e('Linkedin','ivproperty');?></label>
								<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_html(get_user_meta($current_user->ID,'linkedin',true)); ?>" class="form-control"/>
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e('Twitter','ivproperty');?></label>
								<input type="text" name="twitter" id="twitter" value="<?php echo esc_html(get_user_meta($current_user->ID,'twitter',true)); ?>" class="form-control"/>
							</div>
							<div class="form-group">
								<label class="control-label"><?php esc_html_e('Google+','ivproperty');?> </label>
								<input type="text" name="gplus" id="gplus" value="<?php echo esc_html(get_user_meta($current_user->ID,'gplus',true)); ?>"  class="form-control"/>
							</div>
							<div class="margin-top-10">
							<div class="" id="update_message_fb"></div>
								<button type="button" onclick="iv_update_fb();"  class="btn green-haze"><?php esc_html_e('Save Changes','ivproperty');?> </button>                           
							</div>
						</form>
					</div>
					<div class="tab-pane" id="tab_1_4">
						<form action="#" name="setting_hide_form" id="setting_hide_form">
						<div class="table-responsive">
							<table class="table table-light table-hover">
							<tr>
								<td >
									<?php   esc_html_e('Hide Email Address ','ivproperty');?> 
								</td>
								<td>
									<label class="uniform-inline">
									<input type="checkbox" id="email_hide" name="email_hide"  value="yes" <?php echo( get_user_meta($current_user->ID,'hide_email',true)=='yes'? 'checked':''); ?>/> <?php   esc_html_e('Yes','ivproperty');?>  </label>
								</td>
							</tr>
							<tr>
								<td >
									 <?php   esc_html_e('Hide Phone Number','ivproperty');?> 
								</td>
								<td>
									<label class="uniform-inline">
									<input type="checkbox" id="phone_hide" name="phone_hide" value="yes" <?php echo( get_user_meta($current_user->ID,'hide_phone',true)=='yes'? 'checked':''); ?>  /> <?php   esc_html_e('Yes','ivproperty');?>  </label>
								</td>
							</tr>
							<tr>
								<td >
									<?php   esc_html_e('Hide Mobile Number','ivproperty');?> 
								</td>
								<td>
									<label class="uniform-inline">
									<input type="checkbox" id="mobile_hide" name="mobile_hide" value="yes"  <?php echo( get_user_meta($current_user->ID,'hide_mobile',true)=='yes'? 'checked':''); ?> /> <?php   esc_html_e('Yes','ivproperty');?>  </label>
								</td>
							</tr>
							</table>
							</div>
							<!--end profile-settings-->
							<div class="margin-top-10">
							<div class="" id="update_message_hide"></div>
							<button type="button" onclick="iv_update_hide_setting();"  class="btn green-haze"><?php   esc_html_e('Save Changes','ivproperty');?> </button>                           
							</div>
						</form>
					</div>
			</div>
		</div>
	</div>
</div>
          <!-- END PROFILE CONTENT -->