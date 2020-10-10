<?php
	wp_enqueue_style('bootstrap-css-iv_property-ep7', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap.css');	
	wp_enqueue_style('all', wp_iv_property_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_style('wp_iv_property-my-account-css', wp_iv_property_URLPATH . 'admin/files/css/my-account.css');
	wp_enqueue_script("jquery");
	wp_enqueue_style('jquery-ui', wp_iv_property_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_script('jquery-ui', wp_iv_property_URLPATH . 'admin/files/js/jquery-ui.min.js');	
	wp_enqueue_script("jquery");
	wp_enqueue_script('bootstrap', wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min.js');
	wp_enqueue_media(); 
	global $current_user;
	global $wpdb;
	
	$user = new WP_User( $current_user->ID );									
if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
	foreach ( $user->roles as $role ){
		$crole= ucfirst($role); 
		break;
	}	
}	
if(strtoupper($crole)!=strtoupper('administrator')){ 
	include(wp_iv_property_template.'/private-profile/check_status.php');
}
	
	$currencies = array();
	$currencies['AUD'] ='$';$currencies['CAD'] ='$';
	$currencies['EUR'] ='€';$currencies['GBP'] ='£';
	$currencies['JPY'] ='¥';$currencies['USD'] ='$';
	$currencies['NZD'] ='$';$currencies['CHF'] ='Fr';
	$currencies['HKD'] ='$';$currencies['SGD'] ='$';
	$currencies['SEK'] ='kr';$currencies['DKK'] ='kr';
	$currencies['PLN'] ='zł';$currencies['NOK'] ='kr';
	$currencies['HUF'] ='Ft';$currencies['CZK'] ='Kč';
	$currencies['ILS'] ='₪';$currencies['MXN'] ='$';
	$currencies['BRL'] ='R$';$currencies['PHP'] ='₱';
	$currencies['MYR'] ='RM';$currencies['AUD'] ='$';
	$currencies['TWD'] ='NT$';$currencies['THB'] ='฿';	
	$currencies['TRY'] ='TRY';	$currencies['CNY'] ='¥';	
	$currency= get_option('_iv_property_api_currency');
	$currency_symbol=(isset($currencies[$currency]) ? $currencies[$currency] :$currency );
?>
<div id="profile-account2" class="bootstrap-wrapper around-separetor">
	<div class="row margin-top-10">
		<div class="col-md-4 col-sm-4 col-xs-12">
			<!-- BEGIN PROFILE SIDEBAR -->
			<div class="profile-sidebar">
				<!-- PORTLET MAIN -->
				<div class="portlet portlet0 light profile-sidebar-portlet">
					<!-- SIDEBAR USERPIC -->
					<div class="profile-userpic text-center" id="profile_image_main">
						<?php
							$iv_profile_pic_url=get_user_meta($current_user->ID, 'iv_profile_pic_thum',true);
							if($iv_profile_pic_url!=''){ ?>
							<img src="<?php echo esc_url($iv_profile_pic_url); ?>">
							<?php
								}else{
								echo'	 <img src="'. wp_iv_property_URLPATH.'assets/images/Blank-Profile.jpg">';
							}
						?>
					</div>
					<!-- END SIDEBAR USERPIC -->
					<!-- SIDEBAR USER TITLE -->
					<div class="profile-usertitle">
						<div class="profile-usertitle-name">
							<?php 
								$name_display=get_user_meta($current_user->ID,'first_name',true).' '.get_user_meta($current_user->ID,'last_name',true);
							echo (trim($name_display)!=""? $name_display : $current_user->display_name );?>
						</div>
						<div class="profile-usertitle-job">
							<?php echo esc_html(get_user_meta($current_user->ID,'occupation',true)); ?>
						</div>
					</div>
					<!-- END SIDEBAR USER TITLE -->
					<!-- SIDEBAR BUTTONS -->
					<div class="profile-userbuttons">
						<button type="button" onclick="edit_profile_image('profile_image_main');"  class="btn green-haze btn-circle"><?php  esc_html_e('Change Image','ivproperty'); ?> </button>
					</div>
					<!-- END SIDEBAR BUTTONS -->
					<!-- SIDEBAR MENU -->
					<div class="profile-usermenu">
						<?php
							$active='all-post';
							if(isset($_GET['profile']) AND $_GET['profile']=='setting' ){
								$active='setting';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='level' ){
								$active='level';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='all-post' ){
								$active='all-post';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='new-post' ){
								$active='new-post';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='new-post' ){
								$active='new-post';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='bidding' ){
								$active='bidding';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='favorites' ){
								$active='favorites';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='who-is-interested' ){
								$active='who-is-interested';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='balance' ){
								$active='balance';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='post-edit' ){
								$active='all-post';
							}
							$post_type=  'property';
						?>
						<ul class="nav">
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_property_menu_listinghome' ) ) {
									$account_menu_check= get_option('_iv_property_menu_listinghome');
								}
								if($account_menu_check!='yes'){					
								?>
								<li class="">
									<a href="<?php echo get_post_type_archive_link( 'property' ) ; ?>">
                    <i class="fa fa-cog"></i>
									<?php  esc_html_e('Listing Home','ivproperty');	 ?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_property_mylevel' ) ) {
									$account_menu_check= get_option('_iv_property_mylevel');
								}
								if($account_menu_check!='yes'){					
								?>
								<li class="<?php echo ($active=='level'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=level">
										<i class="fa fa-cog"></i>
									<?php  esc_html_e('Membership Level','ivproperty');	 ?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_property_menusetting' ) ) {
									$account_menu_check= get_option('_iv_property_menusetting');
								}
								if($account_menu_check!='yes'){					
								?>
								<li class="<?php echo ($active=='setting'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=setting">
                    <i class="fa fa-cog"></i>
									<?php  esc_html_e('Account Settings','ivproperty');?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_property_menuallpost' ) ) {
									$account_menu_check= get_option('_iv_property_menuallpost');
								}
								if($account_menu_check!='yes'){					
								?>
								<li class="<?php echo ($active=='all-post'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=all-post">
                    <i class="fa fa-cog"></i>
									<?php  esc_html_e('All Listing','ivproperty');?>  </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_property_menunewlisting' ) ) {
									$account_menu_check= get_option('_iv_property_menunewlisting');
								}
								if($account_menu_check!='yes'){					
								?>
								<li class="<?php echo ($active=='new-post'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=new-post">
                    <i class="fa fa-cog"></i>
									<?php   esc_html_e('New Listing','ivproperty');?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_property_menufavorites' ) ) {
									$account_menu_check= get_option('_iv_property_menufavorites');
								}
								if($account_menu_check!='yes'){					
								?>
								<li class="<?php echo ($active=='favorites'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=favorites">
                    <i class="fa fa-cog"></i>
									<?php   esc_html_e('My Favorites','ivproperty');?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_property_menuinterested' ) ) {
									$account_menu_check= get_option('_iv_property_menuinterested');
								}
								if($account_menu_check!='yes'){					
								?>
								<li class="<?php echo ($active=='who-is-interested'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=who-is-interested">
                    <i class="fa fa-cog"></i>
									<?php   esc_html_e('Who is Interested','ivproperty');?> </a>
								</li>
								<?php
								}
							?>
							<?php     $old_custom_menu = array();
								if(get_option('iv_property_profile_menu')){
									$old_custom_menu=get_option('iv_property_profile_menu' );
								}
								$ii=1;		
								if($old_custom_menu!=''){
									foreach ( $old_custom_menu as $field_key => $field_value ) { ?>
									<li class="<?php echo ($active=='new-post'? 'active':''); ?> ">
										<a href="<?php echo esc_url($field_value); ?>">
											<i class="fa fa-cog"></i>
										<?php echo esc_html($field_key);?> </a>
									</li>
									<?php
									}
								}	
							?>                  
							<li class="<?php echo ($active=='log-out'? 'active':''); ?> ">
								<a href="<?php echo wp_logout_url( home_url() ); ?>" >
									<i class="fa fa-sign-out"></i>
									<?php  esc_html_e('Sign out','ivproperty');?> 
								</a>
							</li>
						</ul>
					</div>
					<!-- END MENU -->
				</div>
				<!-- END PORTLET MAIN -->
				<!-- PORTLET MAIN -->
				<!-- END PORTLET MAIN -->
			</div>
		</div>
		<!-- END BEGIN PROFILE SIDEBAR -->
		<!-- BEGIN PROFILE CONTENT -->
		<?php ?>
		<div class="col-md-8 col-sm-8 col-xs-12">
		  <?php
				if(isset($_GET['profile']) AND $_GET['profile']=='all-post' ){
					include(  wp_iv_property_template. 'private-profile/profile-all-post-1.php');
					} elseif(isset($_GET['profile']) AND $_GET['profile']=='bidding' ){
					include( wp_iv_property_template. 'private-profile/bidding-1.php');
					} elseif(isset($_GET['profile']) AND $_GET['profile']=='new-post' ){
					include( wp_iv_property_template. 'private-profile/profile-new-post-1.php');
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='new-post' ){
					include( wp_iv_property_template. 'private-profile/profile-new-post-1.php');
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='level' ){
					include(  wp_iv_property_template. 'private-profile/profile-level-1.php');
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='post-edit' ){ 		    
					include(  wp_iv_property_template. 'private-profile/profile-edit-post-1.php');
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='favorites' ){ 		    
					include(  wp_iv_property_template. 'private-profile/my-favorites-1.php');
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='who-is-interested' ){ 		    
					include(  wp_iv_property_template. 'private-profile/interested-1.php');
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='setting' ){ 		    
					include(  wp_iv_property_template. 'private-profile/profile-setting-1.php');
				}
				else{ 
					include(  wp_iv_property_template. 'private-profile/profile-all-post-1.php');
				}
			?>
		</div>
	</div>
</div>

<?php

	$currencyCode = get_option('_iv_property_api_currency');
	wp_enqueue_script('epmyaccount-script-27', wp_iv_property_URLPATH . 'admin/files/js/my-account.js');
	wp_localize_script('epmyaccount-script-27', 'realpro', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_property_URLPATH.'admin/files/images/loader.gif">',
	'wp_iv_directories_URLPATH'		=> wp_iv_property_URLPATH,
	'current_user_id'	=>get_current_user_id(),	
	'SetImage'		=>esc_html__('Set Image','ivproperty'),
	'GalleryImages'=>esc_html__('Gallery Images','ivproperty'),	
	'cancel-message' => esc_html__('Are you sure to cancel this Membership','ivproperty'),
	'currencyCode'=>  $currencyCode,
	'dirwpnonce'=> wp_create_nonce("myaccount"),
	'dirwpnonce2'=> wp_create_nonce("signup2"),
	'signup'=> wp_create_nonce("signup"),
	'contact'=> wp_create_nonce("contact"),
	'permalink'=> get_permalink(),
	"sProcessing"=>  esc_html__('Processing','ivproperty'),  
	"sSearch"=>   esc_html__('Search','ivproperty'),   
	"lengthMenu"=>   esc_html__('Display _MENU_ records per page','ivproperty'),
	"zeroRecords"=>  esc_html__('Nothing found - sorry','ivproperty'),
	"info"=>  esc_html__('Showing page _PAGE_ of _PAGES_','ivproperty'),
	"infoEmpty"=>   esc_html__('No records available','ivproperty'),
	"infoFiltered"=>  esc_html__('(filtered from _MAX_ total records)','ivproperty'),		
	"sFirst"=> esc_html__('First','ivproperty'),
	"sLast"=>  esc_html__('Last','ivproperty'),
	"sNext"=>     esc_html__('Next','ivproperty'),
	"sPrevious"=>  esc_html__('Previous','ivproperty'),
	) );
?>