<?php
	global $wpdb;
	global $current_user;
	$ii=1;
?>
<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">
		<div class="row">					
			<div class="col-xs-12" id="submit-button-holder">					
				<div class="pull-right"><button class="btn btn-info btn-lg" onclick="return update_profile_fields();"><?php  esc_html_e('Update','ivproperty');?> </button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php  esc_html_e('Update Profile Setting','ivproperty');?> <br /><small> &nbsp;</small> </h3>
			</div>
		</div> 
		<form id="profile_fields" name="profile_fields" class="form-horizontal" role="form" onsubmit="return false;">
			<div id="success_message">	</div>	
			<div class="panel panel-success">
				<div class="panel-heading"><h4> <?php  esc_html_e('My Account Menu','ivproperty');?> </h4></div>
				<div class="panel-body">
					<div class="row ">
						<div class="col-sm-3 ">										
							<h4><strong><?php  esc_html_e('Menu Title / Label','ivproperty');?> </strong> </h4>
						</div>
						<div class="col-sm-7">
							<h4><strong><?php  esc_html_e('Link','ivproperty');?> </strong></h4>									
						</div>
						<div class="col-sm-2">
							<h4><strong><?php  esc_html_e('Action','ivproperty');?></strong> </h4>
						</div>		
					</div>
					<?php
						$profile_page=get_option('_iv_property_profile_page'); 	
						$page_link= get_permalink( $profile_page); 
					?>
					<div class="row ">
						<div class="col-sm-3 ">										
							<?php  esc_html_e('Listing Home','ivproperty');?>  
						</div>
						<div class="col-sm-7">
							<a href="<?php echo get_post_type_archive_link( 'property' ) ; ?>">
								<?php echo get_post_type_archive_link( 'property' ) ; ?>
							</a>									
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_iv_property_menu_listinghome' ) ) {
										$account_menu_check= get_option('_iv_property_menu_listinghome'); 
									}	 
								?>
								<input type="checkbox" name="listinghome" id="listinghome" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> > <?php  esc_html_e('Hide','ivproperty');?>  
								</label>
							</div>											
						</div>					  
					</div>
					<div class="row ">
						<div class="col-sm-3 ">										
							<?php  esc_html_e('Membership Level','ivproperty');	 ?> 
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=level">
								<?php echo esc_url($page_link); ?>?&profile=level
							</a>									
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_iv_property_mylevel' ) ) {
										$account_menu_check= get_option('_iv_property_mylevel'); 
									}	 
								?>
								<input type="checkbox" name="mylevel" id="mylevel" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide','ivproperty');?>  
								</label>
							</div>											
						</div>					  
					</div>
					<div class="row ">
						<div class="col-sm-3 ">										
							<?php  esc_html_e('Account Settings','ivproperty');?>  
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=setting">
								<?php echo esc_url($page_link); ?>?&profile=setting
							</a>									
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_iv_property_menusetting' ) ) {
										$account_menu_check= get_option('_iv_property_menusetting'); 
									}	 
								?>
								<input type="checkbox" name="menusetting" id="menusetting" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide','ivproperty');?> 
								</label>
							</div>											
						</div>					  
					</div>										
					<div class="row ">
						<div class="col-sm-3 ">										
							<?php  esc_html_e('All Listing','ivproperty');?>  
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=all-post">
								<?php echo esc_url($page_link); ?>?&profile=all-post
							</a>										
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_iv_property_menuallpost' ) ) {
										$account_menu_check= get_option('_iv_property_menuallpost'); 
									}	 
								?>
								<input type="checkbox" name="menuallpost" id="menuallpost" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide','ivproperty');?> 
								</label>
							</div>											
						</div>					  
					</div>										
					<div class="row ">
						<div class="col-sm-3 ">										
							<?php  esc_html_e('New Listing','ivproperty');?>  
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=new-post">
								<?php echo esc_url($page_link); ?>?&profile=new-post
							</a>										
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_iv_property_menunewlisting' ) ) {
										$account_menu_check= get_option('_iv_property_menunewlisting'); 
									}	 
								?>
								<input type="checkbox" name="menunewlisting" id="menunewlisting" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide','ivproperty');?> 
								</label>
							</div>											
						</div>					  
					</div>										
					<div class="row ">
						<div class="col-sm-3 ">										
							<?php  esc_html_e('My Favorites','ivproperty');?>  
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=favorites">
								<?php echo esc_url($page_link); ?>?&profile=favorites
							</a>									
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_iv_property_menufavorites' ) ) {
										$account_menu_check= get_option('_iv_property_menufavorites'); 
									}	 
								?>
								<input type="checkbox" name="menufavorites" id="menufavorites" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide','ivproperty');?> 
								</label>
							</div>											
						</div>					  
					</div>										
					<div class="row ">
						<div class="col-sm-3 ">										
							<?php  esc_html_e('Who is Interested','ivproperty');?>  
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=who-is-interested">
								<?php echo esc_url($page_link); ?>?&profile=who-is-interested
							</a>										
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_iv_property_menuinterested' ) ) {
										$account_menu_check= get_option('_iv_property_menuinterested'); 
									}	 
								?>
								<input type="checkbox" name="menuinterested" id="menuinterested" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide','ivproperty');?> 
								</label>
							</div>											
						</div>					  
					</div>										
					<div id="custom_menu_div">	
						<?php
							$old_custom_menu = array();
							if(get_option('iv_property_profile_menu')){
								$old_custom_menu=get_option('iv_property_profile_menu' );
							}													
							$ii=1;		
							if($old_custom_menu!=''){			
								foreach ( $old_custom_menu as $field_key => $field_value ) {	
								?>
								<div class="row form-group " id="menu_<?php echo esc_html($ii); ?>">
									<div class=" col-sm-3"> 
										<input type="text" class="form-control" name="menu_title[]" id="menu_title[]"  value="<?php echo esc_html($field_key); ?>" placeholder="Enter Menu Title "> 
									</div>		
									<div  class=" col-sm-7">
										<input type="text" class="form-control" name="menu_link[]" id="menu_link[]"  value="<?php echo esc_html($field_value); ?>" placeholder="Enter Menu Link">
									</div>
									<div  class=" col-sm-2">												
										<button class="btn btn-danger btn-xs" onclick="return iv_remove_menu('<?php echo esc_html($ii); ?>');"><?php  esc_html_e('Delete','ivproperty');?></button>
									</div>													
								</div>
								<?php
									$ii++;
								}
							}else{?>
							<div class="row form-group " id="menu_<?php echo esc_html($ii); ?>">
								<div class=" col-sm-3"> 
									<input type="text" class="form-control" name="menu_title[]" id="menu_title[]"   placeholder="Enter Menu Title "> 
								</div>		
								<div  class=" col-sm-7">
									<input type="text" class="form-control" name="menu_link[]" id="menu_link[]"  placeholder="Enter Menu Link.">
								</div>
								<div  class=" col-sm-2">												
									<button class="btn btn-danger btn-xs" onclick="return iv_remove_menu('<?php echo esc_html($ii); ?>');"><?php  esc_html_e('Delete','ivproperty');?></button>
								</div>													
							</div>
							<?php
								$ii++;
							}
						?>	
					</div>	
					<div class="col-xs-12">	
						<button class="btn btn-warning btn-xs" onclick="return iv_add_menu();"><?php  esc_html_e('Add More','ivproperty');?> </button>
					</div>			
				</div>
			</div>				
		</form>
		<div class="row">					
			<div class="col-xs-12">					
				<div align="center">
					<div id="loading"></div>
					<div id="messageprofile"></div>
					
					<button class="btn btn-info btn-lg" onclick="return update_profile_fields();"><?php  esc_html_e('Update','ivproperty');?>  </button>
				</div>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>
</div>		 
		