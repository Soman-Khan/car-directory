<?php
	if (!defined('ABSPATH')) {
		exit;
	}
	/**
		* The Admin Panel and related tasks are handled in this file.
	*/
	if (!class_exists('wp_iv_property_Admin')) {
		class wp_iv_property_Admin {
			static $pages = array();
			public function __construct() {
				add_action('admin_menu', array($this, 'admin_menu'));
				add_action('admin_print_scripts', array($this, 'load_scripts'));
				add_action('admin_print_styles', array($this, 'load_styles'));							
				add_action('wp_ajax_iv_property_save_package', array($this, 'iv_property_save_package'));
				add_action('wp_ajax_iv_property_update_package', array($this, 'iv_property_update_package'));
				add_action('wp_ajax_iv_property_update_paypal_settings', array($this, 'iv_property_update_paypal_settings'));
				add_action('wp_ajax_iv_property_update_stripe_settings', array($this, 'iv_property_update_stripe_settings'));			
				add_action('wp_ajax_iv_property_create_coupon', array($this, 'iv_property_create_coupon'));
				add_action('wp_ajax_iv_property_update_coupon', array($this, 'iv_property_update_coupon'));	
				add_action('wp_ajax_iv_property_update_payment_setting', array($this, 'iv_property_update_payment_setting'));
				add_action('wp_ajax_iv_property_update_page_setting', array($this, 'iv_property_update_page_setting'));
				add_action('wp_ajax_iv_property_update_email_setting', array($this, 'iv_property_update_email_setting'));
				add_action('wp_ajax_iv_property_update_mailchamp_setting', array($this, 'iv_property_update_mailchamp_setting'));
				add_action('wp_ajax_iv_property_update_package_status', array($this, 'iv_property_update_package_status'));
				add_action('wp_ajax_iv_property_gateway_settings_update', array($this, 'iv_property_gateway_settings_update'));
				add_action('wp_ajax_iv_property_update_account_setting', array($this, 'iv_property_update_account_setting'));			
				add_action('wp_ajax_iv_property_update_protected_setting', array($this, 'iv_property_update_protected_setting'));
				add_action('wp_ajax_iv_directories_update_vip_image', array($this, 'iv_directories_update_vip_image'));	
				add_action('wp_ajax_iv_property_update_map_marker', array($this, 'iv_property_update_map_marker'));			
				add_action('wp_ajax_iv_property_update_cate_image', array($this, 'iv_property_update_cate_image'));	
				add_action('wp_ajax_iv_property_update_city_image', array($this, 'iv_property_update_city_image'));	
				add_action('wp_ajax_iv_directories_import_data', array($this, 'iv_directories_import_data'));
				add_action('wp_ajax_iv_property_update_user_settings', array($this, 'iv_property_update_user_settings'));			
				add_action('wp_ajax_iv_property_update_profile_fields', array($this, 'iv_property_update_profile_fields'));
				add_action('wp_ajax_iv_property_update_dir_fields', array($this, 'iv_property_update_dir_fields'));			
				add_action('wp_ajax_iv_update_dir_setting', array($this, 'iv_update_dir_setting'));	
				add_action( 'init', array($this, 'iv_property_payment_post_type') );
				add_filter( 'manage_edit-iv_payment_columns', array($this, 'set_custom_edit_iv_payment_columns')  );
				add_action( 'manage_iv_payment_posts_custom_column' ,  array($this, 'custom_iv_payment_column')  , 10, 2 );
				$this->action_hook();
				wp_admin_notifications::load();
			}
			// Hook into the 'init' action
			public function iv_property_payment_post_type() {
				$args = array(
				'description' => 'iv_property Payment Post Type',
				'show_ui' => true,   
				'exclude_from_search' => true,
				'labels' => array(
				'name'=> 'Payment History',
				'singular_name' => 'iv_payment',							 
				'edit' => 'Edit Payment History',
				'edit_item' => 'Edit Payment History',							
				'view' => 'View Payment History',
				'view_item' => 'View Payment History',
				'search_items' => 'Search ',
				'not_found' => 'No  Found',
				'not_found_in_trash' => 'No Found in Trash',
				),
				'public' => true,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => 'flase',
				'hiearchical' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => true,
				'supports' => array('title', 'editor', 'thumbnail','excerpt','custom-fields'),							
				);
				register_post_type( 'iv_payment', $args );
			}
			public function iv_property_update_map_marker(){					
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'cat-image' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				if(isset($_REQUEST['category_id'])){
					$category_id=sanitize_text_field($_REQUEST['category_id']);	
					$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
					update_option('_cat_map_marker_'.$category_id,$attachment_id);
				}
				echo json_encode('success');
				exit(0);
			}
			public function iv_property_update_city_image(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'city-image' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				if(isset($_REQUEST['city_id'])){
					$city_id=strtolower($_REQUEST['city_id']);	
					$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
					update_option('city_main_image_'.$city_id,$attachment_id);
				}
				echo json_encode('success');
				exit(0);
			}
			public function iv_property_update_cate_image(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'cat-image' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				if(isset($_REQUEST['category_id'])){
					$category_id=sanitize_text_field($_REQUEST['category_id']);	
					$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
					update_option('_cate_main_image_'.$category_id,$attachment_id);
				}								
				echo json_encode('success');
				exit(0);
			}
			public function set_custom_edit_iv_payment_columns($columns) {
				$columns['title']='Package Name'; 
				$columns['User'] = 'User Name';
				$columns['Member'] = 'User ID';				
				$columns['Amount'] ='Amount';
				return $columns;
			}
			public function custom_iv_payment_column( $column, $post_id ) {
				global $post;
				switch ( $column ) {
					case 'User' :							
					if(isset($post->post_author) ){
						$user_info = get_userdata( $post->post_author);
						if($user_info!='' ){
							echo  esc_html($user_info->user_login);
						}
					}
					break; 
					case 'Member' :
					echo esc_html($post->post_author); 
					break;
					case 'Amount' :
					echo esc_html($post->post_content); 
					break;
				}
			}
			/**
				* Menus in the wp-admin sidebar
			*/
			public function admin_menu() {
				add_menu_page('WP iv_property', 'Real Estate Pro', 'manage_options', 'wp-iv_property', array(&$this, 'menu_hook'));
				self::$pages['wp-iv_property-package-all'] = add_submenu_page('wp-iv_property', 'Package', 'Package', 'manage_options', 'wp-iv_property-package-all', array(&$this, 'menu_hook'));					
				self::$pages['wp-iv_property-coupons-form'] = add_submenu_page('wp-iv_property', 'WP iv_property Create', 'Coupons', 'manage_options', 'wp-iv_property-coupons-form', array(&$this, 'menu_hook'));
				self::$pages['wp-iv_property-payment-setting'] = add_submenu_page('wp-iv_property', 'WP iv_property Settings', 'Payment Gateways', 'manage_options', 'wp-iv_property-payment-settings', array(&$this, 'menu_hook'));
				add_submenu_page('wp-iv_property', 'WP iv_property', 'Payment  History', 'manage_options',  'edit.php?post_type=iv_payment');
				self::$pages['wp-iv_user-directory-admin'] = add_submenu_page('wp-iv_property', 'WP iv_property directory-admin', 'User Setting', 'manage_options', 'wp-iv_user-directory-admin', array(&$this, 'menu_hook'));
				self::$pages['wp-iv_property-settings'] = add_submenu_page('wp-iv_property', 'WP iv_property Settings', 'Settings', 'manage_options', 'wp-iv_property-settings', array(&$this, 'menu_hook'));
				self::$pages['wp-iv_property-profile-fields'] = add_submenu_page('', 'WP iv_property profile-fields', '', 'manage_options', 'wp-iv_property-profile-fields', array(&$this, 'profile_fields_setting'));
				self::$pages['wp-iv_property-package-create'] = add_submenu_page('', 'WP iv_property package', '', 'manage_options', 'wp-iv_property-package-create', array(&$this, 'package_create_page'));
				self::$pages['wp-iv_property-package-update'] = add_submenu_page('', 'WP iv_property package', '', 'manage_options', 'wp-iv_property-package-update', array(&$this, 'package_update_page'));
				self::$pages['wp-iv_property-coupon-create'] = add_submenu_page('', 'WP iv_property coupon', '', 'manage_options', 'wp-iv_property-coupon-create', array(&$this, 'coupon_create_page'));
				self::$pages['wp-iv_property-coupon-update'] = add_submenu_page('', 'WP iv_property coupon', '', 'manage_options', 'wp-iv_property-coupon-update', array(&$this, 'coupon_update_page'));
				self::$pages['wp-iv_property-payment-paypal'] = add_submenu_page('', 'WP iv_property Payment setting', '', 'manage_options', 'wp-iv_property-payment-paypal', array(&$this, 'paypal_update_page'));
				self::$pages['wp-iv_property-payment-stripe'] = add_submenu_page('', 'WP iv_property Payment setting', '', 'manage_options', 'wp-iv_property-payment-stripe', array(&$this, 'stripe_update_page'));
				self::$pages['wp-iv_property-user_update'] = add_submenu_page('', 'WP iv_property user_update', '', 'manage_options', 'wp-iv_property-user_update', array(&$this, 'user_update_page'));
			}
			/**
				* Menu Page Router
			*/
			public function menu_hook() {
				$screen = get_current_screen();
				switch ($screen->id) {
					default:
					include ('pages/package_all.php');
					break;
					case self::$pages['wp-iv_property-coupons-form']:
					include ('pages/all_coupons.php');
					break;
					case self::$pages['wp-iv_property-settings']:
					include ('pages/settings.php');
					break;
					case self::$pages['wp-iv_property-package-all']:
					include ('pages/package_all.php');
					break;
					case self::$pages['wp-iv_property-payment-setting']:							
					include ('pages/payment-settings.php');
					break;					
					case self::$pages['wp-iv_user-directory-admin']:							
					include ('pages/user_directory_admin.php');
					break;	
				}
			}
			public function  profile_fields_setting (){
				include ('pages/profile-fields.php');
			}
			public function coupon_create_page(){
				include ('pages/coupon_create.php');
			}
			public function coupon_update_page(){
				include ('pages/coupon_update.php');
			}
			public function package_create_page(){
				include ('pages/package_create.php');
			}
			public function package_update_page(){
				include ('pages/package_update.php');
			}
			public function paypal_update_page(){
				include ('pages/paypal_update.php');
			}
			public function stripe_update_page(){
				include ('pages/stripe_update.php');
			}
			public function user_update_page(){
				include ('pages/user_update.php');
			}
			/**
				* Page based Script Loader
			*/
			public function load_scripts() { 
				$screen = get_current_screen();
				$currencyCode= 'USD';
				if (in_array($screen->id, array_values(self::$pages))) {
					wp_enqueue_script('jquery-ui', wp_iv_property_URLPATH . 'admin/files/js/jquery-ui.min.js');					
					wp_enqueue_script('bootstrap', wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min.js');					
			
					wp_enqueue_script('iv_property-script-dashboardadmin', wp_iv_property_URLPATH . 'admin/files/js/dashboard-admin.js');
					wp_localize_script('iv_property-script-dashboardadmin', 'admindata', array(
					'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
					'loading_image'		=> '<img src="'.wp_iv_property_URLPATH.'admin/files/images/loader.gif">',
					'wp_iv_directories_URLPATH'		=> wp_iv_property_URLPATH,
					'wp_iv_property_ADMINPATH' => wp_iv_property_ADMINPATH,
					'current_user_id'	=>get_current_user_id(),	
					'SetImage'		=>esc_html__('Set Image','ivproperty'),
					'GalleryImages'=>esc_html__('Gallery Images','ivproperty'),	
					'cancel-message' => esc_html__('Are you sure to cancel this Membership','ivproperty'),
					'currencyCode'=>  $currencyCode,
					'dirwpnonce'=> wp_create_nonce("myaccount"),
					'settings'=> wp_create_nonce("settings"), 
					'cityimage'=> wp_create_nonce("city-image"),
					'packagenonce'=> wp_create_nonce("package"),
					'catimage'=> wp_create_nonce("cat-image"),							
					'signup'=> wp_create_nonce("signup"),
					'contact'=> wp_create_nonce("contact"),
					'coupon'=> wp_create_nonce("coupon"),
					'fields'=> wp_create_nonce("fields"),
					'dirsetting'=> wp_create_nonce("dir-setting"),
					'mymenu'=> wp_create_nonce("my-menu"),
					'paymentgateway'=> wp_create_nonce("payment-gateway"), 
					'permalink'=> get_permalink(),			
					) );
				}
			}
			/**
				* Page based Style Loader
			*/
			public function load_styles() {
				$screen = get_current_screen();
				if (in_array($screen->id, array_values(self::$pages))) {
					wp_enqueue_style('jquery-ui', wp_iv_property_URLPATH . 'admin/files/css/jquery-ui.css');	
				}
				wp_enqueue_style('bootstrap-wp-iv_property-style-2', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap.css');
				wp_enqueue_style('wp-iv_property-dashboard-style', wp_iv_property_URLPATH . 'admin/files/css/dashboard-admin.css');
			}
			/**
				* This functions validate the submitted user input.
				* @param array $var
				* @return array
			*/
			public function validate($var) {
				return $var;
			}
			/**
				* Use this function to execute actions
			*/
			public function action_hook() {
				if (!isset($_GET['action'])) {
					return;
				}
				switch ($_GET['action']) {
				}
			}
			public function iv_directories_import_data(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				include ('pages/import-demo.php');
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_property_save_package() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'package' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				global $wpdb;			
				$iv_property_pack='iv_property_pack';
				$last_post_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type = '%s' ORDER BY `ID` DESC ", $iv_property_pack));
				$form_number = $last_post_id + 1;
				$role_name='';
				if($form_data['package_name']==""){
					$post_name = 'Package' . $form_number;
					$role_name=$post_name;
					}else{
					$post_name = $form_data['package_name'] .'-'. $form_number;
					$role_name=$form_data['package_name'];
				}					
				$post_title=$form_data['package_name'];
				$post_content= $form_data['package_feature']; 
				$my_post_form = array('post_title' => wp_strip_all_tags($post_title), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => $post_content, 'post_type'=>'iv_property_pack', 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
				$newpost_id = wp_insert_post($my_post_form);					
				update_post_meta($newpost_id, 'iv_property_package_cost', sanitize_text_field($form_data['package_cost']));
				update_post_meta($newpost_id, 'iv_property_package_initial_expire_interval', sanitize_text_field($form_data['package_initial_expire_interval']));							
				update_post_meta($newpost_id, 'iv_property_package_initial_expire_type', sanitize_text_field($form_data['package_initial_expire_type']));
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'iv_property_package_recurring', sanitize_text_field($form_data['package_recurring']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_recurring', '');
				}
				if(isset($form_data['eplugins_stripe_plan'])){
					update_post_meta($newpost_id, 'eplugins_stripe_plan', sanitize_text_field($form_data['eplugins_stripe_plan']));
					}else{
					update_post_meta($newpost_id, 'eplugins_stripe_plan', '');
				}
				update_post_meta($newpost_id, 'iv_property_package_recurring_cost_initial', sanitize_text_field($form_data['package_recurring_cost_initial']));
				update_post_meta($newpost_id, 'iv_property_package_recurring_cycle_count', sanitize_text_field($form_data['package_recurring_cycle_count']));
				update_post_meta($newpost_id, 'iv_property_package_recurring_cycle_type', sanitize_text_field($form_data['package_recurring_cycle_type']));
				update_post_meta($newpost_id, 'iv_property_package_recurring_cycle_limit', sanitize_text_field($form_data['package_recurring_cycle_limit']));
				if(isset($form_data['package_enable_trial_period'])){
					update_post_meta($newpost_id, 'iv_property_package_enable_trial_period', sanitize_text_field($form_data['package_enable_trial_period']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_enable_trial_period', 'no');
				}
				update_post_meta($newpost_id, 'iv_property_package_trial_amount', sanitize_text_field($form_data['package_trial_amount']));
				update_post_meta($newpost_id, 'iv_property_package_trial_period_interval', sanitize_text_field($form_data['package_trial_period_interval']));
				update_post_meta($newpost_id, 'iv_property_package_recurring_trial_type', sanitize_text_field($form_data['package_recurring_trial_type']));
				//Woocommerce_products
						if(isset($form_data['Woocommerce_product'])){
							update_post_meta($newpost_id, 'iv_property_package_woocommerce_product', sanitize_text_field($form_data['Woocommerce_product']));
						
						}
				// Start User Role
				global $wp_roles;
				$contributor_roles = $wp_roles->get_role('contributor');							
				$role_name_new= str_replace(' ', '_', $role_name);
				$wp_roles->remove_role( $role_name_new );
				$role_display_name = $role_name;
				$wp_roles->add_role($role_name_new, $role_display_name, array(
				'read' => true, // True allows that capability, False specifically removes it.
				'edit_posts' => true,
				'delete_posts' => true,
				'upload_files' => true //last in array needs no comma!
				));
				update_post_meta($newpost_id, 'iv_property_package_user_role', $role_name_new);						
				update_post_meta($newpost_id, 'iv_property_package_max_post_no', sanitize_text_field($form_data['max_pst_no']));				
				if(isset($form_data['listing_hide'])){
					update_post_meta($newpost_id, 'iv_property_package_hide_exp', sanitize_text_field($form_data['listing_hide']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_hide_exp', 'no');
				}
				if(isset($form_data['listing_plan'])){
					update_post_meta($newpost_id, 'iv_property_package_plan', sanitize_text_field($form_data['listing_plan']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_plan', 'no');
				}
				if(isset($form_data['listing_deal'])){
					update_post_meta($newpost_id, 'iv_property_package_deal', sanitize_text_field($form_data['listing_deal']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_deal', 'no');
				}
				if(isset($form_data['listing_badge_vip'])){
					update_post_meta($newpost_id, 'iv_property_package_vip_badge', sanitize_text_field($form_data['listing_badge_vip']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_vip_badge', 'no');
				}						
				if(isset($form_data['listing_video'])){
					update_post_meta($newpost_id, 'iv_property_package_video', sanitize_text_field($form_data['listing_video']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_video', 'no');
				}
				if(isset($form_data['listing_facilities'])){
					update_post_meta($newpost_id, 'iv_property_package_facilities', sanitize_text_field($form_data['listing_facilities']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_facilities', 'no');
				}
				if(isset($form_data['listing_feature'])){
					update_post_meta($newpost_id, 'iv_property_package_feature', sanitize_text_field($form_data['listing_feature']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_feature', 'no');
				}
				$cat_ids= '';
				if(isset($form_data['membershipcategory'])){
					$cat_ids= implode("|", $form_data['membershipcategory']);
				}
				update_post_meta($newpost_id, 'iv_property_package_category_ids', $cat_ids);
				// End User Role
				// For Stripe Plan Create*****
				if(isset($form_data['package_recurring'])){
					$iv_gateway = get_option('iv_property_payment_gateway');
					if($iv_gateway=='stripe'){
						include(wp_iv_property_DIR . '/admin/init.php');
						$post_name2='iv_property_stripe_setting';
						$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2 ));
						if(isset($row->ID )){
							$stripe_id= $row->ID;
						}			
						$stripe_mode=get_post_meta( $stripe_id,'iv_property_stripe_mode',true);	
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'iv_property_stripe_secret_test',true);	
							}else{
							$stripe_api =get_post_meta($stripe_id, 'iv_property_stripe_live_secret_key',true);	
						}									
						$interval_count= ($form_data['package_recurring_cycle_count']=="" ? '1':$form_data['package_recurring_cycle_count']);
						$stripe_currency =get_post_meta($stripe_id, 'iv_property_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						$stripe_array=array();
						$post_package_one = get_post($newpost_id); 
						$p_name = $post_package_one->post_name;
						$stripe_array['id']= $p_name;						
						$stripe_array['amount']=$form_data['package_recurring_cost_initial'] * 100;
						$stripe_array['interval']=$form_data['package_recurring_cycle_type'];									
						$stripe_array['interval_count']=$interval_count;
						$stripe_array['currency']=$stripe_currency;
						$stripe_array['product']=array('name' => $p_name);
						$trial=get_post_meta($newpost_id, 'iv_property_package_enable_trial_period', true);
						if($trial=='yes'){
							$trial_type = get_post_meta( $newpost_id,'iv_property_package_recurring_trial_type',true);
							$trial_cycle_count =get_post_meta($newpost_id, 'iv_property_package_trial_period_interval', true);
							switch ($trial_type) {
								case 'year':
								$periodNum =  365 * 1;
								break;
								case 'month':
								$periodNum =  30 * $trial_cycle_count;
								break;
								case 'week':
								$periodNum = 7 * $trial_cycle_count;
								break;
								case 'day':
								$periodNum = 1 * $trial_cycle_count;
								break;
							}									
							$stripe_array['trial_period_days']=$periodNum;
						}																	
						\Stripe\Plan::create($stripe_array);
					}	
				}
				// End Stripe Plan Create*****	
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_directories_update_vip_image(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'dir-setting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
				update_option('vip_image_attachment_id',$attachment_id);					
				echo json_encode('success');
				exit(0);			
			}
			public function iv_update_dir_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'dir-setting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);	
				update_option('_dir_dir_claim',sanitize_text_field($form_data['dir_claim']));
				update_option('_dir_searchbar_show',sanitize_text_field($form_data['dir_searchbar_show']));
				update_option('_dir_agent_show',sanitize_text_field($form_data['dir_agent_show']));
				update_option('_dir_map_api',sanitize_text_field($form_data['dir_map_api']));
				update_option('_dir_search_keyword',sanitize_text_field($form_data['dir_search_keyword']));
				update_option('_dir_search_city',sanitize_text_field($form_data['dir_search_city']));
				update_option('_dir_search_tag',sanitize_text_field($form_data['dir_search_tag']));
				update_option('_dir_search_category',sanitize_text_field($form_data['dir_search_category']));
				update_option('_dir_search_zipcode',sanitize_text_field($form_data['dir_search_zipcode']));						
				update_option('_dir_search_area',sanitize_text_field($form_data['dir_search_area']));
				update_option('_dir_search_baths',sanitize_text_field($form_data['dir_search_baths']));
				update_option('_dir_search_beds',sanitize_text_field($form_data['dir_search_beds']));
				update_option('_dir_search_type',sanitize_text_field($form_data['dir_search_type']));
				update_option('_dir_search_price',sanitize_text_field($form_data['dir_search_price']));
				update_option('_dir_map_zoom',sanitize_text_field($form_data['dir_map_zoom']));						
				update_option('_similar_property',sanitize_text_field($form_data['similar_property']));
				update_option('_contact_form',sanitize_text_field($form_data['contact_form']));
				update_option('_contact_info',sanitize_text_field($form_data['contact_info']));
				update_option('_dir_features',sanitize_text_field($form_data['dir_features']));
				update_option('_dir_share',sanitize_text_field($form_data['dir_share']));
				update_option('_iv_property_url',sanitize_text_field($form_data['iv_property_url']));
				update_option('property_dir_map',sanitize_text_field($form_data['dir_map']));
				update_option('property_top_slider',sanitize_text_field($form_data['property_top_slider']));
				update_option('property_dir_video',sanitize_text_field($form_data['dir_video']));
				update_option('_contact_form_modal',sanitize_text_field($form_data['contact_form_modal']));						
				update_option('property_public_facilities',sanitize_text_field($form_data['property_public_facilities']));
				update_option('property_details',sanitize_text_field($form_data['property_details']));						
				update_option('property_top_4_icons',sanitize_text_field($form_data['property_top_4_icons']));
				update_option('property_right_top_price',sanitize_text_field($form_data['property_right_top_price']));
				update_option('_dir_tags',sanitize_text_field($form_data['dir_tags']));						
				update_option('_dir_search_tag',sanitize_text_field($form_data['dir_search_tag']));	
				update_option('dir_style5_perpage',sanitize_text_field($form_data['dir_style5_perpage']));						
				update_option('dir5_background_color',sanitize_text_field($form_data['dir5_background_color']));
				update_option('dir5_content_color',sanitize_text_field($form_data['dir5_content_color']));						
				update_option('dir_style5_call',sanitize_text_field($form_data['dir_style5_call']));
				update_option('dir_style5_email',sanitize_text_field($form_data['dir_style5_email']));
				update_option('dir_style5_sms',sanitize_text_field($form_data['dir_style5_sms']));
				update_option('dir5_review_show',sanitize_text_field($form_data['dir5_review_show']));
				update_option( 'dir_facet_cat_title' ,sanitize_text_field($form_data['dir_facet_cat_title']));
				update_option( 'dir_facet_type_title' ,sanitize_text_field($form_data['dir_facet_type_title']));				
				update_option( 'dir_contact_form' ,sanitize_text_field($form_data['dir_contact_form']));
				update_option( 'dir_form_shortcode' ,sanitize_text_field($form_data['dir_form_shortcode']));
				
				
				if(isset($form_data['dir_facet_type_show'])){
					update_option( 'dir_facet_type_show' ,sanitize_text_field($form_data['dir_facet_type_show']));
					}else{
					update_option( 'dir_facet_type_show' ,'no') ; 						
				}	
				
				if(isset($form_data['dir_facet_cat_show'])){
					update_option( 'dir_facet_cat_show' ,sanitize_text_field($form_data['dir_facet_cat_show']));
					}else{
					update_option( 'dir_facet_cat_show' ,'no') ; 						
				}					
				update_option( 'dir_facet_location_title' ,sanitize_text_field($form_data['dir_facet_location_title']));
				if(isset($form_data['dir_facet_location_show'])){
					update_option( 'dir_facet_location_show' ,sanitize_text_field($form_data['dir_facet_location_show']));
					}else{
					update_option( 'dir_facet_location_show' ,'no') ; 						
				}
				update_option( 'dir_facet_area_title' ,sanitize_text_field($form_data['dir_facet_area_title']));
				if(isset($form_data['dir_facet_area_show'])){
					update_option( 'dir_facet_area_show' ,sanitize_text_field($form_data['dir_facet_area_show']));
					}else{
					update_option( 'dir_facet_area_show' ,'no') ; 						
				}
				update_option( 'dir_facet_features_title' ,sanitize_text_field($form_data['dir_facet_features_title']));
				if(isset($form_data['dir_facet_features_show'])){
					update_option( 'dir_facet_features_show' ,sanitize_text_field($form_data['dir_facet_features_show']));
					}else{
					update_option( 'dir_facet_features_show' ,'no') ; 						
				}
				update_option( 'dir_facet_review_title' ,sanitize_text_field($form_data['dir_facet_review_title']));
				if(isset($form_data['dir_facet_review_show'])){
					update_option( 'dir_facet_review_show' ,sanitize_text_field($form_data['dir_facet_review_show']));
					}else{
					update_option( 'dir_facet_review_show' ,'no') ; 						
				}
				update_option( 'dir_facet_zipcode_title' ,sanitize_text_field($form_data['dir_facet_zipcode_title']));
				if(isset($form_data['dir_facet_zipcode_show'])){
					update_option( 'dir_facet_zipcode_show' ,sanitize_text_field($form_data['dir_facet_zipcode_show']));
					}else{
					update_option( 'dir_facet_zipcode_show' ,'no') ; 						
				}
				update_option( 'dir_facet_bed_title' ,sanitize_text_field($form_data['dir_facet_bed_title']));
				if(isset($form_data['dir_facet_bed_show'])){
					update_option( 'dir_facet_bed_show' ,sanitize_text_field($form_data['dir_facet_bed_show']));
					}else{
					update_option( 'dir_facet_bed_show' ,'no') ; 						
				}
				update_option( 'dir_facet_bath_title' ,sanitize_text_field($form_data['dir_facet_bath_title']));
				if(isset($form_data['dir_facet_bath_show'])){
					update_option( 'dir_facet_bath_show' ,sanitize_text_field($form_data['dir_facet_bath_show']));
					}else{
					update_option( 'dir_facet_bath_show' ,'no') ; 						
				}
				update_option( 'property_top_1_icon' ,sanitize_text_field($form_data['property_top_1_icon']));
				update_option( 'property_top_2_icon' ,sanitize_text_field($form_data['property_top_2_icon']));
				update_option( 'property_top_3_icon' ,sanitize_text_field($form_data['property_top_3_icon']));
				update_option( 'property_top_4_icon' ,sanitize_text_field($form_data['property_top_4_icon']));						
				update_option( 'grid_col1500' ,sanitize_text_field($form_data['grid_col1500'])) ; 
				update_option( 'grid_col1100' ,sanitize_text_field($form_data['grid_col1100'])) ; 
				update_option( 'grid_col768' ,sanitize_text_field($form_data['grid_col768'])) ; 
				update_option( 'grid_col480' ,sanitize_text_field($form_data['grid_col480'])) ; 
				update_option( 'grid_col375' ,sanitize_text_field($form_data['grid_col375'])) ; 
				update_option( '_archive_template' ,sanitize_text_field($form_data['option_archive'])) ;
				update_option( '_eploan_calculator' ,sanitize_text_field($form_data['loan_calculator'])) ;
				update_option('dir_style_font',sanitize_text_field($form_data['dir_style_font']));
				update_option( 'directories_layout_single' ,sanitize_text_field($form_data['directories_layout_single'])) ;
			
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_profile_fields(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'my-menu' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$opt_array2= array();
				if(isset($form_data['menu_title'])){
					$max = sizeof($form_data['menu_title']);
					for($i = 0; $i < $max;$i++)
					{	
						if($form_data['menu_title'][$i]!="" AND $form_data['menu_link'][$i]!=""){
							$opt_array2[$form_data['menu_title'][$i]]=$form_data['menu_link'][$i];
						}
					}			
					update_option('iv_property_profile_menu', $opt_array2 );
				}
				// remove menu******
				if(isset($form_data['listinghome'])){
					update_option( '_iv_property_menu_listinghome' ,sanitize_text_field($form_data['listinghome'])); 
					}else{
					update_option( '_iv_property_menu_listinghome' ,'no') ; 
				}
				if(isset($form_data['mylevel'])){
					update_option( '_iv_property_mylevel' ,sanitize_text_field($form_data['mylevel'])); 
					}else{
					update_option( '_iv_property_mylevel' ,'no') ; 
				}
				if(isset($form_data['menusetting'])){
					update_option( '_iv_property_menusetting' ,sanitize_text_field($form_data['menusetting'])); 
					}else{
					update_option( '_iv_property_menusetting' ,'no') ; 
				}
				if(isset($form_data['menuallpost'])){
					update_option( '_iv_property_menuallpost' ,sanitize_text_field($form_data['menuallpost'])); 
					}else{
					update_option( '_iv_property_menuallpost' ,'no') ; 
				}
				if(isset($form_data['menunewlisting'])){
					update_option( '_iv_property_menunewlisting' ,sanitize_text_field($form_data['menunewlisting'])); 
					}else{
					update_option( '_iv_property_menunewlisting' ,'no') ; 
				}
				if(isset($form_data['menufavorites'])){
					update_option( '_iv_property_menufavorites' ,sanitize_text_field($form_data['menufavorites'])); 
					}else{
					update_option( '_iv_property_menufavorites' ,'no') ; 
				}
				if(isset($form_data['menuinterested'])){
					update_option( '_iv_property_menuinterested' ,sanitize_text_field($form_data['menuinterested'])); 
					}else{
					update_option( '_iv_property_menuinterested' ,'no') ; 
				}
				echo json_encode(array('code' => esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_dir_fields(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'fields' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$opt_array= array();
				$max = sizeof($form_data['meta_name']);
				for($i = 0; $i < $max;$i++)
				{	
					if($form_data['meta_name'][$i]!="" AND $form_data['meta_label'][$i]!=""){
						$opt_array[$form_data['meta_name'][$i]]=$form_data['meta_label'][$i];
					}
				}													
				update_option('iv_property_fields', $opt_array );
				update_option('public_facilities', sanitize_textarea_field($form_data['public_facilities']));
				update_option('property_status', sanitize_textarea_field($form_data['property_status']));
				echo json_encode(array('code' => 'Update Successfully'));
				exit(0);
			}
			public function iv_property_update_package() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'package' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;			
				$post_title=sanitize_text_field($form_data['package_name']);
				$post_id=$form_data['package_id'];
				$newpost_id=$post_id;
				$post_content= $form_data['package_feature']; 
				$post_type = 'iv_property_pack';						
				$my_post = array(
				'ID'           => $post_id,
				'post_title'   => $post_title,
				'post_content'=>	$post_content,
				);
				wp_update_post( $my_post );
				update_post_meta($newpost_id, 'iv_property_package_cost', sanitize_text_field($form_data['package_cost']));
				update_post_meta($newpost_id, 'iv_property_package_initial_expire_interval', sanitize_text_field($form_data['package_initial_expire_interval']));							
				update_post_meta($newpost_id, 'iv_property_package_initial_expire_type', sanitize_text_field($form_data['package_initial_expire_type']));
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'iv_property_package_recurring', sanitize_text_field($form_data['package_recurring']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_recurring', '');
				}
				if(isset($form_data['eplugins_stripe_plan'])){
					update_post_meta($newpost_id, 'eplugins_stripe_plan', sanitize_text_field($form_data['eplugins_stripe_plan']));
					}else{
					update_post_meta($newpost_id, 'eplugins_stripe_plan', '');
				}
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'iv_property_package_recurring', sanitize_text_field($form_data['package_recurring']));
					update_post_meta($newpost_id, 'iv_property_package_recurring_cost_initial', sanitize_text_field($form_data['package_recurring_cost_initial']));
					update_post_meta($newpost_id, 'iv_property_package_recurring_cycle_count', sanitize_text_field($form_data['package_recurring_cycle_count']));
					update_post_meta($newpost_id, 'iv_property_package_recurring_cycle_type', sanitize_text_field($form_data['package_recurring_cycle_type']));
					update_post_meta($newpost_id, 'iv_property_package_recurring_cycle_limit', sanitize_text_field($form_data['package_recurring_cycle_limit']));
					if(isset($form_data['package_enable_trial_period'])){
						update_post_meta($newpost_id, 'iv_property_package_enable_trial_period', sanitize_text_field($form_data['package_enable_trial_period']));
						}else{
						update_post_meta($newpost_id, 'iv_property_package_enable_trial_period', 'no');
					}
					update_post_meta($newpost_id, 'iv_property_package_trial_amount', sanitize_text_field($form_data['package_trial_amount']));
					update_post_meta($newpost_id, 'iv_property_package_trial_period_interval', sanitize_text_field($form_data['package_trial_period_interval']));
					update_post_meta($newpost_id, 'iv_property_package_recurring_trial_type', sanitize_text_field($form_data['package_recurring_trial_type']));
				}
				//Woocommerce_products
				if(isset($form_data['Woocommerce_product'])){
					update_post_meta($newpost_id, 'iv_property_package_woocommerce_product', sanitize_text_field($form_data['Woocommerce_product']));				
				}
				update_post_meta($newpost_id, 'iv_property_package_max_post_no', $form_data['max_pst_no']);				
				if(isset($form_data['listing_hide'])){
					update_post_meta($newpost_id, 'iv_property_package_hide_exp', sanitize_text_field($form_data['listing_hide']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_hide_exp', 'no');
				}
				if(isset($form_data['listing_facilities'])){
					update_post_meta($newpost_id, 'iv_property_package_facilities', sanitize_text_field($form_data['listing_facilities']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_facilities', 'no');
				}
				if(isset($form_data['listing_deal'])){
					update_post_meta($newpost_id, 'iv_property_package_deal', sanitize_text_field($form_data['listing_deal']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_deal', 'no');
				}
				if(isset($form_data['listing_badge_vip'])){
					update_post_meta($newpost_id, 'iv_property_package_vip_badge', sanitize_text_field($form_data['listing_badge_vip']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_vip_badge', 'no');
				}						
				if(isset($form_data['listing_video'])){
					update_post_meta($newpost_id, 'iv_property_package_video', sanitize_text_field($form_data['listing_video']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_video', 'no');
				}
				if(isset($form_data['listing_plan'])){
					update_post_meta($newpost_id, 'iv_property_package_plan', sanitize_text_field($form_data['listing_plan']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_plan', 'no');
				}
				if(isset($form_data['listing_feature'])){
					update_post_meta($newpost_id, 'iv_property_package_feature', sanitize_text_field($form_data['listing_feature']));
					}else{
					update_post_meta($newpost_id, 'iv_property_package_feature', 'no');
				}
				// For Stripe*****
				// For Stripe Plan Edit*****
				if(isset($form_data['package_recurring'])){
					$iv_gateway = get_option('iv_property_payment_gateway');
					if($iv_gateway=='stripe'){
						include(wp_iv_property_DIR . '/admin/init.php');
						$post_name2='iv_property_stripe_setting';
						$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2));
						if(isset($row->ID )){
							$stripe_id= $row->ID;
						}			
						$stripe_mode=get_post_meta( $stripe_id,'iv_property_stripe_mode',true);	
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'iv_property_stripe_secret_test',true);	
							}else{
							$stripe_api =get_post_meta($stripe_id, 'iv_property_stripe_live_secret_key',true);	
						}									
						$interval_count= ($form_data['package_recurring_cycle_count']=="" ? '1':$form_data['package_recurring_cycle_count']);
						$stripe_currency =get_post_meta($stripe_id, 'iv_property_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						$stripe_array=array();
						$post_package_one = get_post($newpost_id); 
						$error=0;
						$p_name = $post_package_one->post_name;
						$stripe_array['id']= $p_name;						
						$stripe_array['amount']=$form_data['package_recurring_cost_initial'] * 100;
						$stripe_array['interval']=$form_data['package_recurring_cycle_type'];									
						$stripe_array['interval_count']=$interval_count;
						$stripe_array['currency']=$stripe_currency;
						$stripe_array['product']=array('name' => $p_name);
						$trial=get_post_meta($newpost_id, 'iv_property_package_enable_trial_period', true);
						if($trial=='yes'){
							$trial_type = get_post_meta( $newpost_id,'iv_property_package_recurring_trial_type',true);
							$trial_cycle_count =get_post_meta($newpost_id, 'iv_property_package_trial_period_interval', true);
							switch ($trial_type) {
								case 'year':
								$periodNum =  365 * 1;
								break;
								case 'month':
								$periodNum =  30 * $trial_cycle_count;
								break;
								case 'week':
								$periodNum = 7 * $trial_cycle_count;
								break;
								case 'day':
								$periodNum = 1 * $trial_cycle_count;
								break;
							}									
							$stripe_array['trial_period_days']=$periodNum;
						}																	
						try {
								$p = \Stripe\Plan::retrieve($p_name);
						
							} catch (Exception $e) {
								$error==1;
						}
						 if( $error==0){
               $p->delete();	
              }
							\Stripe\Plan::create($stripe_array);
						
							
							
					}	
				}
				// End Stripe Plan Create*****	
				echo json_encode(array('code' => 'success'));
				exit(0);
				}
			public function iv_property_update_paypal_settings() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'payment-gateway' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;		
				$post_name='iv_property_paypal_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				if(!isset($row->ID )){
					$my_post_form = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => 'Paypal Setting', 'post_type'=>'iv_payment_setting','post_status' => 'draft', 'post_author' => get_current_user_id(),);
					$newpost_id = wp_insert_post($my_post_form);
					}else{
					$newpost_id= $row->ID;
				}
				update_post_meta($newpost_id, 'iv_property_paypal_mode', sanitize_text_field($form_data['paypal_mode']));
				update_post_meta($newpost_id, 'iv_property_paypal_username', sanitize_text_field($form_data['paypal_username']));
				update_post_meta($newpost_id, 'iv_property_paypal_api_password', sanitize_text_field($form_data['paypal_api_password']));
				update_post_meta($newpost_id, 'iv_property_paypal_api_signature', sanitize_text_field($form_data['paypal_api_signature']));
				update_post_meta($newpost_id, 'iv_property_paypal_api_currency', sanitize_text_field($form_data['paypal_api_currency']));						
				update_option('_iv_property_api_currency', sanitize_text_field($form_data['paypal_api_currency'] ));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_property_update_stripe_settings() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'payment-gateway' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;			
				$post_name='iv_property_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name));
				if(!isset($row->ID )){
					$post_type = 'iv_payment_setting';
					$my_post_form = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => 'stripe Setting','post_type'=>$post_type, 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
					$newpost_id = wp_insert_post($my_post_form);								
					}else{
					$newpost_id= $row->ID;
				}
				update_post_meta($newpost_id, 'iv_property_stripe_mode', sanitize_text_field($form_data['stripe_mode']));
				update_post_meta($newpost_id, 'iv_property_stripe_live_secret_key', sanitize_text_field($form_data['secret_key']));update_post_meta($newpost_id, 'iv_property_stripe_live_publishable_key', sanitize_text_field($form_data['publishable_key']));
				update_post_meta($newpost_id, 'iv_property_stripe_secret_test', sanitize_text_field($form_data['secret_key_test']));						
				update_post_meta($newpost_id, 'iv_property_stripe_publishable_test', sanitize_text_field($form_data['stripe_publishable_test']));		
				update_post_meta($newpost_id, 'iv_property_stripe_api_currency', sanitize_text_field($form_data['stripe_api_currency']));
				update_option('_iv_property_api_currency', sanitize_text_field($form_data['stripe_api_currency'] ));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_property_create_coupon() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'coupon' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;			
				$post_name=$form_data['coupon_name'];
				$coupon_data = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => $post_name,'post_type'=>'iv_property_coupon', 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
				$newpost_id = wp_insert_post($coupon_data);
				if($form_data['coupon_count']==""){
					$coupon_limit='99999';
					}else{
					$coupon_limit=sanitize_text_field($form_data['coupon_count']);
				}
				$pac='';
				if(isset($_POST['form_pac_ids'])){$pac=$_POST['form_pac_ids'];}
				$pck_ids =implode(",",$pac);						
				update_post_meta($newpost_id, 'iv_property_coupon_pac_id', $pck_ids);
				update_post_meta($newpost_id, 'iv_property_coupon_limit',$coupon_limit);
				update_post_meta($newpost_id, 'iv_property_coupon_start_date', sanitize_text_field($form_data['start_date']));
				update_post_meta($newpost_id, 'iv_property_coupon_end_date', sanitize_text_field($form_data['end_date']));
				update_post_meta($newpost_id, 'iv_property_coupon_amount', sanitize_text_field($form_data['coupon_amount']));
				update_post_meta($newpost_id, 'iv_property_coupon_type', sanitize_text_field($form_data['coupon_type']));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}	
			public function iv_property_update_coupon() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'coupon' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);						
				$post_content="";
				global $wpdb;	
				$post_title=sanitize_text_field($form_data['coupon_name']);
				$post_id=sanitize_text_field($form_data['coupon_id']);
				$newpost_id=$post_id;
				$my_post = array(
				'ID'           => $post_id,
				'post_title'   => $post_title,								
				);
				wp_update_post( $my_post );
				$pck_ids =implode(",",$_POST['form_pac_ids']);						
				update_post_meta($newpost_id, 'iv_property_coupon_pac_id', $pck_ids);
				update_post_meta($newpost_id, 'iv_property_coupon_limit', sanitize_text_field($form_data['coupon_count']));
				update_post_meta($newpost_id, 'iv_property_coupon_start_date', sanitize_text_field($form_data['start_date']));
				update_post_meta($newpost_id, 'iv_property_coupon_end_date', sanitize_text_field($form_data['end_date']));
				update_post_meta($newpost_id, 'iv_property_coupon_amount', sanitize_text_field($form_data['coupon_amount']));	update_post_meta($newpost_id, 'iv_property_coupon_type', sanitize_text_field($form_data['coupon_type']));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}	
			public function  iv_property_update_payment_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$iv_terms='no';
				if(isset($form_data['iv_terms'])){
					$iv_terms=$form_data['iv_terms'];
				}
				$terms_detail=$form_data['terms_detail'];
				$iv_coupon='';
				if(isset($form_data['iv_coupon'])){
					$iv_coupon=sanitize_text_field($form_data['iv_coupon']);
				}
				update_option('iv_property_payment_terms_text', $terms_detail );
				update_option('iv_property_payment_terms', $iv_terms );
				update_option('_iv_property_payment_coupon', $iv_coupon );
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_account_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_approved='no';
				if(isset($form_data['post_approved'])){
					$post_approved=sanitize_text_field($form_data['post_approved']);
				}
				$signup_redirect=sanitize_text_field($form_data['signup_redirect']);
				$private_profile_page  = sanitize_text_field($form_data['pri_profile_redirect']); 
				$pub_profile_redirect=sanitize_text_field($form_data['profile_redirect']);
				if(isset($form_data['hide_admin_bar'])){
					$admin_bar=$form_data['hide_admin_bar'];
					}else{
					$admin_bar='no';
				}
				update_option('iv_property_post_approved', $post_approved );
				update_option('iv_property_signup_redirect', $signup_redirect );
				update_option('_iv_property_profile_page', $private_profile_page );
				update_option('_iv_property_profile_public_page', $pub_profile_redirect );
				update_option('_iv_property_hide_admin_bar', $admin_bar );
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_protected_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				if(isset($form_data['active_visibility'])){
					$active_visibility=$form_data['active_visibility'];
					}else{
					$active_visibility='no';
				}		
				update_option('_iv_property_active_visibility', $active_visibility );
				if(isset($form_data['login_message'])){
					update_option('_iv_visibility_login_message', sanitize_text_field($form_data['login_message'] ));
				}
				if(isset($form_data['visitor_message'])){
					update_option('_iv_visibility_visitor_message', sanitize_text_field($form_data['visitor_message'] ));
				}
				update_option('_iv_visibility_serialize_role', $form_data);
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function  iv_property_update_page_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$iv_terms='no';
				if(isset($form_data['iv_terms'])){
					$iv_terms=$form_data['iv_terms'];
				}
				$pricing_page=sanitize_text_field($form_data['pricing_page']);
				$signup_page=sanitize_text_field($form_data['signup_page']);
				$profile_page=sanitize_text_field($form_data['profile_page']);
				$profile_public=sanitize_text_field($form_data['profile_public']);
				$thank_you=sanitize_text_field($form_data['thank_you_page']);
				$login=sanitize_text_field($form_data['login_page']);
				update_option('_iv_property_price_table', $pricing_page); 
				update_option('_iv_property_registration', $signup_page); 
				update_option('_iv_property_profile_page', $profile_page);
				update_option('_iv_property_profile_public',$profile_public);
				update_option('_iv_property_thank_you_page',$thank_you); 
				update_option('_iv_property_login_page',$login); 
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_email_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				update_option( 'iv_property_signup_email_subject',sanitize_text_field($form_data['iv_property_signup_email_subject']));
				update_option( 'iv_property_signup_email',$form_data['signup_email_template']);
				update_option( 'iv_property_forget_email_subject',sanitize_text_field($form_data['forget_email_subject']));
				update_option( 'iv_property_forget_email',$form_data['forget_email_template']);
				update_option('admin_email_iv_property', sanitize_text_field($form_data['iv_property_admin_email'])); 
				update_option('iv_property_order_client_email_sub', sanitize_text_field($form_data['iv_property_order_email_subject'])); 
				update_option('iv_property_order_client_email', $form_data['order_client_email_template']); 
				update_option('iv_property_order_admin_email_sub', sanitize_text_field($form_data['iv_property_order_admin_email_subject']));
				update_option('iv_property_order_admin_email', $form_data['order_admin_email_template']); 			
				update_option( 'iv_property_reminder_email_subject',sanitize_text_field($form_data['iv_property_reminder_email_subject']));
				update_option( 'iv_property_reminder_email',$form_data['reminder_email_template']);		 
				update_option('iv_property_reminder_day', sanitize_text_field($form_data['iv_property_reminder_day'])); 
				update_option( 'iv_property_contact_email_subject',sanitize_text_field($form_data['contact_email_subject']));
				update_option( 'iv_property_contact_email',$form_data['message_email_template']);				
				$bcc_message=(isset($form_data['bcc_message'])? $form_data['bcc_message']:'' );		
				update_option( '_iv_property_bcc_message',$bcc_message);
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_mailchamp_setting (){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				update_option('iv_property_mailchimp_api_key', sanitize_text_field($form_data['iv_property_mailchimp_api_key'])); 
				update_option('iv_property_mailchimp_confirmation', sanitize_text_field($form_data['iv_property_mailchimp_confirmation'])); 
				if(isset($form_data['iv_property_mailchimp_list'])){
					update_option('iv_property_mailchimp_list', sanitize_text_field($form_data['iv_property_mailchimp_list'])); 
				}
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_package_status (){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'package' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				global $wpdb;
				$package_id_update=trim($_POST['status_id']);
				$package_current_status=trim(sanitize_text_field($_POST['status_current']));
				if($package_current_status=="pending"){
					$package_st='draft';
					$pac_msg='Active';
					}else{
					$package_st='pending';
					$pac_msg='Inactive';
				}
				$post_type = 'iv_property_pack';
				$query =$wpdb->prepare( "UPDATE {$wpdb->prefix}posts SET post_status='%s' WHERE ID='%s' LIMIT 1",$package_st,$package_id_update );
				$wpdb->query($query);
				echo json_encode(array("code" => "success","msg"=>$pac_msg,"current_st"=>$package_st));
				exit(0);
			}
			public function iv_property_gateway_settings_update(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'payment-gateway' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$payment_gateway = sanitize_text_field($_POST['payment_gateway']);
				global $wpdb;
				update_option('iv_property_payment_gateway', $payment_gateway);
				// For Stripe Plan Create*****
				$iv_gateway = get_option('iv_property_payment_gateway');
				if($iv_gateway=='stripe'){
					$stripe_id='';
					$post_name2='iv_property_stripe_setting';
					$row2 = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2 ));
					if(isset($row2->ID )){
						$stripe_id= $row2->ID;
					}
					$iv_property_pack='iv_property_pack';
					$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'",$iv_property_pack );
					$membership_pack = $wpdb->get_results($sql);
						
					if(count($membership_pack)>0){
						$i=0;
						include(wp_iv_property_DIR. '/admin/init.php');
						$stripe_mode=get_post_meta( $stripe_id,'iv_property_stripe_mode',true);	
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'iv_property_stripe_secret_test',true);	
							}else{
							$stripe_api =get_post_meta($stripe_id, 'iv_property_stripe_live_secret_key',true);	
						}	
						$stripe_currency =get_post_meta($stripe_id, 'iv_property_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						foreach ( $membership_pack as $row )
						{		$package_recurring=get_post_meta( $row->ID,'iv_property_package_recurring',true);	
							if($package_recurring=='on'){
								$interval_count= get_post_meta( $row->ID,'iv_property_package_recurring_cycle_count',true);
								$interval_count= ($interval_count=="" ? '1':$interval_count);
								$stripe_array=array();						
								$p_name = $row->post_name;
								$stripe_array['id']= $p_name;								
								$stripe_array['amount']=get_post_meta( $row->ID,'iv_property_package_recurring_cost_initial',true) * 100;
								$stripe_array['interval']=get_post_meta( $row->ID,'iv_property_package_recurring_cycle_type',true);
								$stripe_array['interval_count']=$interval_count;
								$stripe_array['currency']=$stripe_currency;
								$stripe_array['product']=array('name' => $p_name);
								$trial=get_post_meta($row->ID, 'iv_property_package_enable_trial_period', true);
								if($trial=='yes'){
									$trial_type = get_post_meta( $row->ID,'iv_property_package_recurring_trial_type',true);
									$trial_cycle_count =get_post_meta($row->ID, 'iv_property_package_trial_period_interval', true);
									switch ($trial_type) {
										case 'year':
										$periodNum =  365 * 1;
										break;
										case 'month':
										$periodNum =  30 * $trial_cycle_count;
										break;
										case 'week':
										$periodNum = 7 * $trial_cycle_count;
										break;
										case 'day':
										$periodNum = 1 * $trial_cycle_count;
										break;
									}									
									$stripe_array['trial_period_days']=$periodNum;
								}																	
								try {
									\Stripe\Plan::retrieve($p_name);
									} catch (Exception $e) {
											
										if($stripe_array['amount']>0){
											\Stripe\Plan::create($stripe_array);
										}
								}
							}	
						}
					}
					
				
				}	
				// End Stripe Plan Create*****	
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully: Your current gateway is ', 'ivproperty').$payment_gateway));
				exit(0);
			}
			public function iv_property_update_user_settings(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}		
				parse_str($_POST['form_data'], $form_data);
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}	
				$user_id=sanitize_text_field($form_data['user_id']);
				if($form_data['exp_date']!=''){
					$exp_d=date('Y-m-d', strtotime($form_data['exp_date']));	 
					update_user_meta($user_id, 'iv_property_exprie_date',$exp_d); 
				}		
				update_user_meta($user_id, 'iv_property_payment_status', sanitize_text_field($form_data['payment_status']));	
				update_user_meta($user_id, 'iv_property_package_id',sanitize_text_field($form_data['package_sel'])); 
				$user = new WP_User( $user_id );
				$user->set_role(sanitize_text_field($form_data['user_role']));
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
		}
	}
$wp_iv_property_admin = new wp_iv_property_Admin();