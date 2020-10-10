<?php
	/**
		*
		*
		* @version 1.8.4
		* @package Main
		* @author e-plugin.com
	*/
	/*
		Plugin Name: Real Estate Pro
		Plugin URI: http://e-plugin.com/
		Description: Build Paid Property Listing using Wordpress.No programming knowledge required.
		Author: e-plugin
		Author URI: http://e-plugin.com/
		Version: 1.8.4
		Text Domain: ivproperty
		License: GPLv3
	*/
	// Exit if accessed directly
  if (!defined('ABSPATH')) {
  	exit;
	}
  if (!class_exists('wp_iv_property')) {  	
		final class wp_iv_property {
			private static $instance;
			/**
				* The Plug-in version.
				*
				* @var string
			*/
			public $version = "1.8.4";
			/**
				* The minimal required version of WordPress for this plug-in to function correctly.
				*
				* @var string
			*/
			public $wp_version = "3.5";
			public static function instance() {
				if (!isset(self::$instance) && !(self::$instance instanceof wp_iv_property)) {
					self::$instance = new wp_iv_property;
				}
				return self::$instance;
			}
			/**
				* Construct and start the other plug-in functionality
			*/
			public function __construct() {
				//
				// 1. Plug-in requirements
				//
				if (!$this->check_requirements()) {
					return;
				}
				//
				// 2. Declare constants and load dependencies
				//
				$this->define_constants();
				$this->load_dependencies();
				//
				// 3. Activation Hooks
				//
				register_activation_hook(__FILE__, array(&$this, 'activate'));
				register_deactivation_hook(__FILE__, array(&$this, 'deactivate'));
				register_uninstall_hook(__FILE__, 'wp_iv_property::uninstall');
				//
				// 4. Load Widget
				//
				add_action('widgets_init', array(&$this, 'register_widget'));
				//
				// 5. i18n
				//
				add_action('init', array(&$this, 'i18n'));
				//
				// 6. Actions
				//	
				add_action('wp_ajax_iv_property_check_coupon', array($this, 'iv_property_check_coupon'));
				add_action('wp_ajax_nopriv_iv_property_check_coupon', array($this, 'iv_property_check_coupon'));					
				add_action('wp_ajax_iv_property_check_package_amount', array($this, 'iv_property_check_package_amount'));
				add_action('wp_ajax_nopriv_iv_property_check_package_amount', array($this, 'iv_property_check_package_amount'));
				add_action('wp_ajax_iv_property_update_profile_pic', array($this, 'iv_property_update_profile_pic'));					
				add_action('wp_ajax_iv_property_update_profile_setting', array($this, 'iv_property_update_profile_setting'));
				add_action('wp_ajax_iv_property_update_wp_post', array($this, 'iv_property_update_wp_post'));					
				add_action('wp_ajax_iv_property_save_wp_post', array($this, 'iv_property_save_wp_post'));									
				add_action('wp_ajax_iv_property_update_setting_fb', array($this, 'iv_property_update_setting_fb'));				
				add_action('wp_ajax_iv_property_update_setting_hide', array($this, 'iv_property_update_setting_hide'));				
				add_action('wp_ajax_iv_property_update_setting_password', array($this, 'iv_property_update_setting_password'));add_action('wp_ajax_iv_property_check_login', array($this, 'iv_property_check_login'));
				add_action('wp_ajax_nopriv_iv_property_check_login', array($this, 'iv_property_check_login'));
				add_action('wp_ajax_iv_property_forget_password', array($this, 'iv_property_forget_password'));
				add_action('wp_ajax_nopriv_iv_property_forget_password', array($this, 'iv_property_forget_password'));					
				add_action('wp_ajax_iv_property_cancel_stripe', array($this, 'iv_property_cancel_stripe'));								
				add_action('wp_ajax_iv_property_cancel_paypal', array($this, 'iv_property_cancel_paypal'));					
				add_action('wp_ajax_iv_property_profile_stripe_upgrade', array($this, 'iv_property_profile_stripe_upgrade'));add_action('wp_ajax_iv_property_save_favorite', array($this, 'iv_property_save_favorite'));						
				add_action('wp_ajax_iv_property_save_un_favorite', array($this, 'iv_property_save_un_favorite'));								
				add_action('wp_ajax_iv_property_save_note', array($this, 'iv_property_save_note'));						
				add_action('wp_ajax_iv_property_delete_favorite', array($this, 'iv_property_delete_favorite'));
				add_action('wp_ajax_iv_property_message_send', array($this, 'iv_property_message_send'));
				add_action('wp_ajax_nopriv_iv_property_message_send', array($this, 'iv_property_message_send'));
				add_action('wp_ajax_iv_property_claim_send', array($this, 'iv_property_claim_send'));
				add_action('wp_ajax_nopriv_iv_property_claim_send', array($this, 'iv_property_claim_send'));					
				add_action('wp_ajax_iv_property_cron_job', array($this, 'iv_property_cron_job'));
				add_action('wp_ajax_nopriv_iv_property_cron_job', array($this, 'iv_property_cron_job'));	
				
				add_action('wp_ajax_iv_property_loadmore', array($this, 'iv_property_loadmore'));
				add_action('wp_ajax_nopriv_iv_property_loadmore', array($this, 'iv_property_loadmore'));					
				add_action('wp_ajax_iv_directories_save_user_review', array($this, 'iv_directories_save_user_review'));
				add_action('wp_ajax_finalerp_csv_product_upload', array($this, 'finalerp_csv_product_upload'));
				add_action('wp_ajax_save_csv_file_to_database', array($this, 'save_csv_file_to_database'));
				add_action('wp_ajax_eppro_get_import_status', array($this, 'eppro_get_import_status'));		
				add_action('wp_ajax_iv_property_contact_popup', array($this, 'iv_property_contact_popup'));		
				add_action('plugins_loaded', array($this, 'start'));
				add_action('add_meta_boxes', array($this, 'prfx_custom_meta_iv_property'));
				add_action('save_post', array($this, 'iv_property_meta_save'));	
				add_action('wp_login', array($this, 'check_expiry_date'));					
				add_action('pre_get_posts',array($this, 'iv_restrict_media_library') );				
				// 7. Shortcode
				add_shortcode('iv_property_price_table', array($this, 'iv_property_price_table_func'));				
				add_shortcode('iv_property_form_wizard', array($this, 'iv_property_form_wizard_func'));
				add_shortcode('iv_property_profile_template', array($this, 'iv_property_profile_template_func'));
				add_shortcode('iv_property_profile_public', array($this, 'iv_property_profile_public_func'));				
				add_shortcode('iv_property_login', array($this, 'iv_property_login_func'));
				add_shortcode('iv_property_user_directory', array($this, 'iv_property_user_directory_func'));					
				add_shortcode('realestatepro_categories', array($this, 'realestatepro_categories_func'));
				add_shortcode('realestatepro_featured', array($this, 'realestatepro_featured_func'));					
				add_shortcode('realestatepro_map', array($this, 'realestatepro_map_func'));
				add_shortcode('realestatepro_search', array($this, 'realestatepro_search_func'));									
				add_shortcode('listing_layout_style_1', array($this, 'listing_layout_style_1_func'));
				add_shortcode('listing_layout_style_2', array($this, 'listing_layout_style_2_func'));
				add_shortcode('slider_search', array($this, 'slider_search_func'));
				add_shortcode('listing_filter', array($this, 'listing_filter_func'));					
				add_shortcode('listing_carousel', array($this, 'listing_carousel_func'));
				add_shortcode('realestatepro_cities', array($this, 'realestatepro_cities_func'));						
				add_shortcode('iv_property_reminder_email_cron', array($this, 'iv_property_reminder_email_cron_func'));
				// 8. Filter						
				add_filter( 'template_include', array($this, 'include_template_function'), 9, 2  );
				add_filter('request', array($this, 'post_type_tags_fix'));						
				add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'realpro_plugin_action_links' ) );
				//---- COMMENT FILTERS ----//	
				add_action( 'init', array(&$this, 'eplisting_elementor_file') );
				add_action( 'elementor/elements/categories_registered', array(&$this, 'add_elementor_widget_categories' ));
				add_action('init', array($this, 'remove_admin_bar') );	
				add_action( 'init', array($this, 'iv_property_paypal_form_submit') );
				add_action( 'init', array($this, 'iv_property_stripe_form_submit') );
				add_action( 'init', array($this, 'iv_dir_post_type') );
				add_action( 'init', array($this, 'tr_create_my_taxonomy'));
				add_action( 'init', array($this, 'ep_create_my_taxonomy_tags'));
				add_action( 'wp_loaded', array(&$this, 'iv_property_woocommerce_form_submit') );
			}
			/**
				* Define constants needed across the plug-in.
			*/
			
			private function define_constants() {
				if (!defined('wp_iv_property_BASENAME')) define('wp_iv_property_BASENAME', plugin_basename(__FILE__));
				if (!defined('wp_iv_property_DIR')) define('wp_iv_property_DIR', dirname(__FILE__));
				if (!defined('wp_iv_property_FOLDER'))define('wp_iv_property_FOLDER', plugin_basename(dirname(__FILE__)));
				if (!defined('wp_iv_property_ABSPATH'))define('wp_iv_property_ABSPATH', trailingslashit(str_replace("\\", "/", WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)))));
				if (!defined('wp_iv_property_URLPATH'))define('wp_iv_property_URLPATH', trailingslashit(WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__))));
				if (!defined('wp_iv_property_ADMINPATH'))define('wp_iv_property_ADMINPATH', get_admin_url());
				$filename = get_stylesheet_directory()."/realestatepro/";
				if (!file_exists($filename)) {					
					if (!defined('wp_iv_property_template'))define( 'wp_iv_property_template', wp_iv_property_ABSPATH.'template/' );
					}else{
					if (!defined('wp_iv_property_template'))define( 'wp_iv_property_template', $filename);
				}	
			}				
			/**
				* Loads PHP files that required by the plug-in
			*/			
			public function remove_admin_bar() {
				$iv_hide = get_option( '_iv_property_hide_admin_bar');
				if (!current_user_can('administrator') && !is_admin()) {
					if($iv_hide=='yes'){							
						show_admin_bar(false);
					}
				}	
			}
			public function include_template_function( $template_path ) { 
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				if ( get_post_type() ==$directory_url ) { 
					if ( is_single() ) {
						$template_path =  wp_iv_property_template. 'property/single-property.php';	
					}							
					if( is_tag() || is_category() || is_archive() ){	
						$template_path =  wp_iv_property_template. 'property/listing-layout.php';
					}
				}
				return $template_path;
			}
			public function tr_create_my_taxonomy() {
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				register_taxonomy(
				$directory_url.'-category',
				$directory_url,
				array(
				'label' => esc_html__( 'Categories','ivproperty' ),
				'rewrite' => array( 'slug' => $directory_url.'-category' ),
				'hierarchical' => true,
				'show_in_rest' =>	true,
				)
				);
			}
			public function iv_dir_post_type() {
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				$directory_url_name=ucfirst($directory_url);
				$labels = array(
				'name'                => _x( $directory_url_name, 'Post Type General Name', 'ivproperty' ),
				'singular_name'       => _x( $directory_url_name, 'Post Type Singular Name', 'ivproperty' ),
				'menu_name'           => esc_html__( $directory_url_name, 'ivproperty' ),
				'name_admin_bar'      => esc_html__( $directory_url_name, 'ivproperty' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'ivproperty' ),
				'all_items'           => esc_html__( 'All Items', 'ivproperty' ),
				'add_new_item'        => esc_html__( 'Add New Item', 'ivproperty' ),
				'add_new'             => esc_html__( 'Add New', 'ivproperty' ),
				'new_item'            => esc_html__( 'New Item', 'ivproperty' ),
				'edit_item'           => esc_html__( 'Edit Item', 'ivproperty' ),
				'update_item'         => esc_html__( 'Update Item', 'ivproperty' ),
				'view_item'           => esc_html__( 'View Item', 'ivproperty' ),
				'search_items'        => esc_html__( 'Search Item', 'ivproperty' ),
				'not_found'           => esc_html__( 'Not found', 'ivproperty' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'ivproperty' ),
				);
				$args = array(
				'label'               => esc_html__( $directory_url_name, 'ivproperty' ),
				'description'         => esc_html__( $directory_url_name, 'ivproperty' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),					
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'show_in_rest' =>	true,	
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( $directory_url, $args );
				///******Review**********
				$labels2 = array(
				'name'                => _x( 'Reviews', 'Post Type General Name', 'ivproperty' ),
				'singular_name'       => _x( 'Reviews', 'Post Type Singular Name', 'ivproperty' ),
				'menu_name'           => esc_html__( 'Reviews', 'ivproperty' ),
				'name_admin_bar'      => esc_html__( 'Reviews', 'ivproperty' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'ivproperty' ),
				'all_items'           => esc_html__( 'All Items', 'ivproperty' ),
				'add_new_item'        => esc_html__( 'Add New Item', 'ivproperty' ),
				'add_new'             => esc_html__( 'Add New', 'ivproperty' ),
				'new_item'            => esc_html__( 'New Item', 'ivproperty' ),
				'edit_item'           => esc_html__( 'Edit Item', 'ivproperty' ),
				'update_item'         => esc_html__( 'Update Item', 'ivproperty' ),
				'view_item'           => esc_html__( 'View Item', 'ivproperty' ),
				'search_items'        => esc_html__( 'Search Item', 'ivproperty' ),
				'not_found'           => esc_html__( 'Not found', 'ivproperty' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'ivproperty' ),
				);
				$args2 = array(
				'label'               => esc_html__( 'Reviews', 'ivproperty' ),
				'description'         => esc_html__( 'Reviews: Directory Pro', 'ivproperty' ),
				'labels'              => $labels2,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),					
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest' =>true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( 'realpro_review', $args2 );
			}
			public function post_type_tags_fix($request) {
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				if ( isset($request['tag']) && !isset($request['post_type']) ){
					$request['post_type'] = $directory_url;
				}
				return $request;
			} 
			public function realpro_plugin_action_links( $links ) {
				$plugin_links = array(
				'<a href="'.esc_url('admin.php?page=wp-iv_property-settings').'">' . esc_html__( 'Settings', 'ivproperty' ) . '</a>',
				'<a href="'.esc_url('//help.eplug-ins.com/realdoc/').'">' . esc_html__( 'Docs', 'ivproperty' ) . '</a>',						
				'<a href="'.esc_url('//codecanyon.net/item/real-estate-pro-wordpress-plugin/13245602/comments').'">' . esc_html__( 'Support', 'ivproperty' ) . '</a>',
				);
				return array_merge( $plugin_links, $links );
			}	
			public function author_public_profile() {
				$author = get_the_author();	
				$iv_redirect = get_option( '_iv_property_profile_public_page');
				if($iv_redirect!='defult'){ 
					$reg_page= get_permalink( $iv_redirect) ; 
					return    $reg_page.'?&id='.$author; 
					exit;
				}
			}
			public function iv_registration_redirect(){
				$iv_redirect = get_option( 'iv_property_signup_redirect');
				if($iv_redirect!='defult'){
					$reg_page= get_permalink( $iv_redirect); 
					wp_redirect( $reg_page );
					exit;
				}	
			}
			public function iv_property_login_func($atts = ''){
				global $current_user;
				ob_start();	
				global $current_user;
				ob_start();
				if($current_user->ID==0){
					include(wp_iv_property_template. 'private-profile/profile-login.php');
					}else{	
					include( wp_iv_property_template. 'private-profile/profile-template-1.php');
				}	
				$content = ob_get_clean();	
				return $content;
			}
			public function iv_property_forget_password(){
				parse_str($_POST['form_data'], $data_a);
				if( ! email_exists($data_a['forget_email']) ) {
					echo json_encode(array("code" => "not-success","msg"=>"There is no user registered with that email address."));
					exit(0);
					} else {
					include( wp_iv_property_ABSPATH. 'inc/forget-mail.php');
					echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
					exit(0);
				}
			}
			
			public function iv_property_check_login(){
				parse_str($_POST['form_data'], $form_data);
				global $user;
				$creds = array();
				$creds['user_login'] =$form_data['username'];
				$creds['user_password'] =  $form_data['password'];
				$creds['remember'] =  (isset($form_data['remember']) ?'true' : 'false');
				$secure_cookie = is_ssl() ? true : false;
				$user = wp_signon( $creds, $secure_cookie );
				if ( is_wp_error($user) ) {
					echo json_encode(array("code" => "not-success","msg"=>$user->get_error_message()));
					exit(0);
				}
				if ( !is_wp_error($user) ) {
					$iv_redirect = get_option( '_iv_property_profile_page');
					if($iv_redirect!='defult'){
						$reg_page= get_permalink( $iv_redirect); 
						echo json_encode(array("code" => "success","msg"=>$reg_page));
						exit(0);
					}
				}		
			}
			public function get_unique_keyword_values( $key = 'keyword', $post_type ){
				global $wpdb;
				if( empty( $key ) ){
					return;
				}	
				$res=array();
				$args = array(
				'post_type' => $post_type, // enter your custom post type						
				'post_status' => 'publish',						
				'posts_per_page'=> -1,  // overrides posts per page in theme settings
				);
				$query_auto = new WP_Query( $args );
				$posts_auto = $query_auto->posts;						
				foreach($posts_auto as $post_a) {
					$res[]=$post_a->post_title;
				}	
				return $res;
			}
			public function get_unique_post_meta_values( $key = 'postcode', $post_type ){
				global $wpdb;
				$directory_url=get_option('_iv_property_url');
				if($directory_url==""){$directory_url='property';}
				if( empty( $key ) ){
					return;
				}	
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'						
				", $key) );
				return $res;
			}  
			public function add_elementor_widget_categories() {

					\Elementor\Plugin::$instance->elements_manager->add_category(
						'real-estate-pro',
						[
							'title' => __( 'Real Estate Pro', 'ivproperty' ),
							'icon'  => 'fa fa-plug',
						]
					);

			}
			public function eplisting_elementor_file(  ) {
				if ( in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					
					include(wp_iv_property_template . 'elementor/elementor-single-meta.php');			

				}
			}
			public function iv_property_update_wp_post(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'addlisting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'edit_posts' ) ) {
					wp_die( 'Are you cheating:user Permission?' );								
				}
				global $current_user;global $wpdb;	
				$allowed_html = wp_kses_allowed_html( 'post' );
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				parse_str($_POST['form_data'], $form_data);
				$newpost_id= sanitize_text_field($form_data['user_post_id']);
				$my_post = array();
				$my_post['ID'] = $newpost_id;
				$my_post['post_title'] = sanitize_text_field($form_data['title']);
				$my_post['post_content'] = wp_kses( $form_data['edit_post_content'], $allowed_html) ; 
				$my_post['post_type'] 	= $directory_url;					
				if($form_data['post_status']=='publish'){
					$form_data['post_status']='pending';							
					if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						$form_data['post_status']='publish';
						}else{	
						$form_data['post_status']='pending';									
					}
				}
				wp_update_post( $my_post );
				if(isset($form_data['feature_image_id'] ) AND $form_data['feature_image_id']!='' ){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( sanitize_text_field($form_data['user_post_id']), $attach_id );
					}else{
					$attach_id='0';
					delete_post_thumbnail( sanitize_text_field($form_data['user_post_id']));
				}
				
				if(isset($form_data['postcats'] )){
					$category_ids = array($form_data['postcats']);
					$post_cats= array();
					foreach($category_ids AS $cid) {
						$post_cats=$cid;
					}
					wp_set_object_terms( $newpost_id, $post_cats, $directory_url.'-category');
				}
				// Set sales or rent
				update_post_meta($newpost_id, 'property_status', sanitize_text_field(trim($form_data['property_type']))); 
				// Check Feature*************	
				$post_author_id= $current_user->ID;
				$author_package_id=get_user_meta($post_author_id, 'iv_property_package_id', true);
				$have_package_feature= get_post_meta($author_package_id,'iv_property_package_feature',true);
				$exprie_date= strtotime (get_user_meta($post_author_id, 'iv_property_exprie_date', true));
				$current_date=time();						
				if($have_package_feature=='yes'){
					if($exprie_date >= $current_date){ 
						update_post_meta($newpost_id, 'realpro_featured', 'featured' );	
					}	
					}else{
					update_post_meta($newpost_id, 'realpro_featured', 'no' );	
				}
				$default_fields = array();
				$field_set=get_option('iv_property_fields' );
				if($field_set!=""){ 
					$default_fields=get_option('iv_property_fields' );
					}else{															
					$default_fields['Property_ID']=esc_html__('Property ID','ivproperty');
					$default_fields['Available_From']=esc_html__('Available From','ivproperty');
					$default_fields['Year_Built']=esc_html__('Year Built');
					$default_fields['Exterior_Material']=esc_html__('Exterior Material','ivproperty');
					$default_fields['Structure_Type']=esc_html__('Structure Type','ivproperty');
					$default_fields['AC']=esc_html__('AC','ivproperty');
					$default_fields['Acres']=esc_html__('Acres','ivproperty');
					$default_fields['Bedroom_Features']=esc_html__('Bedroom Features','ivproperty');
					$default_fields['Cross_Streets']=esc_html__('Cross Streets','ivproperty');
					$default_fields['Dining_Area']=esc_html__('Dining Area','ivproperty');
					$default_fields['Disability_Access']=esc_html__('Disability Access','ivproperty');
					$default_fields['Entry_Location']=esc_html__('Entry Location','ivproperty');
					$default_fields['Exterior_Cnstruction']=esc_html__('Exterior Cnstruction','ivproperty');
					$default_fields['Fireplace_Fuel']=esc_html__('Fireplace Fuel','ivproperty');
					$default_fields['Fireplace_Location']=esc_html__('Fireplace Location','ivproperty');
					$default_fields['Legal_Desc']=esc_html__('Legal Desc','ivproperty');
					$default_fields['Lot_Description']=esc_html__('Lot Description','ivproperty');
					$default_fields['Lot_Size_Source']=esc_html__('Lot Size Source','ivproperty');
					$default_fields['Misc_Interior']=esc_html__('Misc Interior','ivproperty');
					$default_fields['Sewer']=esc_html__('Sewer','ivproperty');
					$default_fields['Source_Of_Sqft']=esc_html__('Source Of Sqft','ivproperty');
					$default_fields['Terms']=esc_html__('Terms','ivproperty');
					$default_fields['View_Desc']=esc_html__('View Desc','ivproperty');
				}
				if(sizeof($default_fields )){			
					foreach( $default_fields as $field_key => $field_value ) { 
						update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_text_field($form_data[$field_key]) );							
					}					
				}
				// property detail*****
				update_post_meta($newpost_id, 'bedrooms', sanitize_text_field($form_data['bedrooms'])); 
				update_post_meta($newpost_id, 'bathrooms', sanitize_text_field($form_data['bathrooms']));					 
				update_post_meta($newpost_id, 'guest', sanitize_text_field($form_data['guest']));
				update_post_meta($newpost_id, 'garages', sanitize_text_field($form_data['garages'])); 
				update_post_meta($newpost_id, 'sale_or_rent_price', sanitize_text_field($form_data['sale_or_rent_price'])); 
				update_post_meta($newpost_id, 'price_postfix_text', sanitize_text_field($form_data['price_postfix_text'])); 
				update_post_meta($newpost_id, 'area', sanitize_text_field($form_data['area'])); 
				update_post_meta($newpost_id, 'area_postfix_text', sanitize_text_field($form_data['area_postfix_text'])); 
				update_post_meta($newpost_id, 'rent_period', sanitize_text_field($form_data['rent_period'])); 
				if(isset($form_data['dirpro_call_button'] )){						
					update_post_meta($newpost_id, 'dirpro_call_button', sanitize_text_field($form_data['dirpro_call_button'])); 
				}
				if(isset($form_data['dirpro_email_button'] )){						
					update_post_meta($newpost_id, 'dirpro_email_button', sanitize_text_field($form_data['dirpro_email_button'])); 
				}
				if(isset($form_data['dirpro_sms_button'] )){						
					update_post_meta($newpost_id, 'dirpro_sms_button', sanitize_text_field($form_data['dirpro_sms_button'])); 
				}
				update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($form_data['contact_source']));  
				//Public Facilities
				$facilities=array();
				if(isset($form_data['facilities_name'] )){
					$facilities_name= $form_data['facilities_name'] ;
					$facilities_value = $form_data['facilities_value'] ;
					$i=0;
					foreach($facilities_name  as $one_facility){
						if(isset($facilities_name[$i]) and isset($facilities_value[$i]) ){
							if($facilities_name[$i] !=''){
								$facilities[$facilities_name[$i]] = sanitize_text_field($facilities_value[$i]);
							}
						}							
						$i++;	
					}
					update_post_meta($newpost_id, '_public_facilities', $facilities); 	
				}
				// Delete Plan
				$i=0;
				for($i=0;$i<20;$i++){
					delete_post_meta($newpost_id, '_plan_description_'.$i); 							
					delete_post_meta($newpost_id, '_plan_image_id_'.$i);
				}		
				// Delete End
				// For Plan Save 
				if(isset($form_data['plan_description']) || isset($form_data['plan_image_id']) ){						
					$plan_description= $form_data['plan_description'];						
					$plan_image_id= (isset($form_data['plan_image_id']) ? $form_data['plan_image_id']:'');
					for($i=0;$i<20;$i++){		
						if(isset($plan_description[$i])){
							update_post_meta($newpost_id, '_plan_description_'.$i, sanitize_text_field($plan_description[$i])); 
						}							
						if(isset($plan_image_id[$i])){
							update_post_meta($newpost_id, '_plan_image_id_'.$i, sanitize_text_field($plan_image_id[$i])); 
						}						
					}						 	
				}
				// For Tag Save tag_arr
				$dir_tags=get_option('_dir_tags');
				if($dir_tags==""){$dir_tags='yes';}	
				if($dir_tags=='yes'){
					$tag_all='';
					if(isset($form_data['tag_arr'] )){
						$tag_name= $form_data['tag_arr'] ;							
						$i=0;$tag_all='';						
						wp_set_object_terms( $newpost_id, $tag_name, $directory_url.'_tag');							
					}
					$tag_all='';
					if(isset($form_data['new_tag'] )){						
						$tag_new= explode(",", $form_data['new_tag']); 			
						foreach($tag_new  as $one_tag){	
							wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $directory_url.'_tag');											
							$i++;	
						}
					}	
					}else{
					$tag_all='';
					$tag_array= wp_get_post_tags( $newpost_id );
					foreach($tag_array as $one_tag){	
						wp_remove_object_terms( $newpost_id, $one_tag->name, 'post_tag' );							
					}
					if(isset($form_data['tag_arr'] )){
						$tag_name= $form_data['tag_arr'] ;							
						$i=0;$tag_all='';
						foreach($tag_name  as $one_tag){							
							$tag_all= $tag_all.",".sanitize_text_field($one_tag);												
							$i++;	
						}
						wp_set_post_tags($newpost_id, $tag_all, true); 	
					}
					if(isset($form_data['new_tag'] )){
						$tag_all=$tag_all.','.sanitize_text_field($form_data['new_tag']);
						wp_set_post_tags($newpost_id, $tag_all, true); 	
					}	
				}	
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address'])); 
				update_post_meta($newpost_id, 'latitude', sanitize_text_field($form_data['latitude'])); 
				update_post_meta($newpost_id, 'longitude', sanitize_text_field($form_data['longitude']));					
				update_post_meta($newpost_id, 'city', sanitize_text_field($form_data['city'])); 
				update_post_meta($newpost_id, 'postcode', sanitize_text_field($form_data['postcode'])); 
				update_post_meta($newpost_id, 'country', sanitize_text_field($form_data['country']));
				update_post_meta($newpost_id, 'local-area', sanitize_text_field($form_data['local-area'])); 	
				// Get latlng from address* START********
				$dir_lat=sanitize_text_field($form_data['latitude']);
				$dir_lng=sanitize_text_field($form_data['longitude']);
				$address = sanitize_text_field($form_data['address']);
				// Get latlng from address* END********	
				update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($form_data['gallery_image_ids'])); 
				update_post_meta($newpost_id, 'phone', sanitize_text_field($form_data['phone'])); 
				update_post_meta($newpost_id, 'fax', sanitize_text_field($form_data['fax'])); 
				update_post_meta($newpost_id, 'contact-email', sanitize_text_field($form_data['contact-email'])); 
				update_post_meta($newpost_id, 'contact_web', sanitize_text_field($form_data['contact_web']));
				update_post_meta($newpost_id, 'contact_name', sanitize_text_field($form_data['contact_name'])); 					
				if(isset($form_data['vimeo'] )){
					update_post_meta($newpost_id, 'vimeo', sanitize_text_field($form_data['vimeo'])); 
					update_post_meta($newpost_id, 'youtube', sanitize_text_field($form_data['youtube'])); 
				}
				update_post_meta($newpost_id, 'facebook', sanitize_text_field($form_data['facebook'])); 
				update_post_meta($newpost_id, 'linkedin', sanitize_text_field($form_data['linkedin'])); 
				update_post_meta($newpost_id, 'twitter', sanitize_text_field($form_data['twitter'])); 
			
				if(isset($form_data['deal-title'])){
					update_post_meta($newpost_id, 'deal_title', sanitize_text_field($form_data['deal-title']));
				}
				if(isset($form_data['deal_image_id'])){
					update_post_meta($newpost_id, '_deal_image_id', sanitize_text_field($form_data['deal_image_id']));
				}
				if(isset($form_data['deal-detail'])){
					update_post_meta($newpost_id, 'deal_detail', sanitize_text_field($form_data['deal-detail']));
				}	
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);				
			}
			public function iv_property_save_wp_post(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'addlisting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'edit_posts' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				global $current_user; global $wpdb;	
				parse_str($_POST['form_data'], $form_data);				
				$my_post = array();
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				$post_type = $directory_url;
				if($form_data['post_status']=='publish'){
					$form_data['post_status']='pending';							
					if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						$form_data['post_status']='publish';
						}else{	
						$form_data['post_status']='pending';									
					}
				}
				$allowed_html = wp_kses_allowed_html( 'post' );
				
				$my_post['post_title'] = sanitize_text_field($form_data['title']);
				$my_post['post_content'] = wp_kses( $form_data['new_post_content'], $allowed_html);
				$my_post['post_type'] = $post_type;
				$my_post['post_status'] = sanitize_text_field($form_data['post_status']);										
				$newpost_id= wp_insert_post( $my_post );
				update_post_meta($newpost_id, 'property_status', sanitize_text_field(trim($form_data['property_type']))); 
				// WPML Start******
				if ( function_exists('icl_object_id') ) {
					include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
					$_POST['icl_post_language'] = $language_code = ICL_LANGUAGE_CODE;
					$query =$wpdb->prepare( "UPDATE {$wpdb->prefix}icl_translations SET element_type='post_%s' WHERE element_id='%s' LIMIT 1",$post_type,$newpost_id );
					$wpdb->query($query);					
				}
				// End WPML**********	
				if(isset($form_data['feature_image_id'] )){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( $newpost_id, $attach_id );					
				}						
				
				if(isset($form_data['postcats'] )){
					$category_ids = array($form_data['postcats']);
					$post_cats= array();
					foreach($category_ids AS $cid) {
						$post_cats=$cid;
					}
					wp_set_object_terms( $newpost_id, $post_cats, $directory_url.'-category');
				}
				$default_fields = array();
				$field_set=get_option('iv_property_fields' );
				if($field_set!=""){ 
					$default_fields=get_option('iv_property_fields' );
					}else{															
					$default_fields['Property_ID']=esc_html__('Property ID','ivproperty');
					$default_fields['Available_From']=esc_html__('Available From','ivproperty');
					$default_fields['Year_Built']=esc_html__('Year Built');
					$default_fields['Exterior_Material']=esc_html__('Exterior Material','ivproperty');
					$default_fields['Structure_Type']=esc_html__('Structure Type','ivproperty');
					$default_fields['AC']=esc_html__('AC','ivproperty');
					$default_fields['Acres']=esc_html__('Acres','ivproperty');
					$default_fields['Bedroom_Features']=esc_html__('Bedroom Features','ivproperty');
					$default_fields['Cross_Streets']=esc_html__('Cross Streets','ivproperty');
					$default_fields['Dining_Area']=esc_html__('Dining Area','ivproperty');
					$default_fields['Disability_Access']=esc_html__('Disability Access','ivproperty');
					$default_fields['Entry_Location']=esc_html__('Entry Location','ivproperty');
					$default_fields['Exterior_Cnstruction']=esc_html__('Exterior Cnstruction','ivproperty');
					$default_fields['Fireplace_Fuel']=esc_html__('Fireplace Fuel','ivproperty');
					$default_fields['Fireplace_Location']=esc_html__('Fireplace Location','ivproperty');
					$default_fields['Legal_Desc']=esc_html__('Legal Desc','ivproperty');
					$default_fields['Lot_Description']=esc_html__('Lot Description','ivproperty');
					$default_fields['Lot_Size_Source']=esc_html__('Lot Size Source','ivproperty');
					$default_fields['Misc_Interior']=esc_html__('Misc Interior','ivproperty');
					$default_fields['Sewer']=esc_html__('Sewer','ivproperty');
					$default_fields['Source_Of_Sqft']=esc_html__('Source Of Sqft','ivproperty');
					$default_fields['Terms']=esc_html__('Terms','ivproperty');
					$default_fields['View_Desc']=esc_html__('View Desc','ivproperty');
				}
				if(sizeof($default_fields )){			
					foreach( $default_fields as $field_key => $field_value ) { 
						update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_text_field($form_data[$field_key]) );							
					}					
				}
				// Check Feature*************	
				$post_author_id= $current_user->ID;
				$author_package_id=get_user_meta($post_author_id, 'iv_property_package_id', true);
				$have_package_feature= get_post_meta($author_package_id,'iv_property_package_feature',true);
				$exprie_date= strtotime (get_user_meta($post_author_id, 'iv_property_exprie_date', true));
				$current_date=time();						
				if($have_package_feature=='yes'){
					if($exprie_date >= $current_date){
						update_post_meta($newpost_id, 'realpro_featured', 'featured' );	
					}	
					}else{
					update_post_meta($newpost_id, 'realpro_featured', 'no' );	
				}
				// For Plan Save 
				if(isset($form_data['plan_description']) || isset($form_data['plan_image_id']) ){						
					$plan_description= $form_data['plan_description'];						
					$plan_image_id= (isset($form_data['plan_image_id']) ? $form_data['plan_image_id']:'');							
					$i=0;
					for($i=0;$i<20;$i++){		
						if(isset($plan_description[$i])){
							update_post_meta($newpost_id, '_plan_description_'.$i, sanitize_text_field($plan_description[$i])); 
						}							
						if(isset($plan_image_id[$i])){
							update_post_meta($newpost_id, '_plan_image_id_'.$i, sanitize_text_field($plan_image_id[$i])); 
						}
					}						 	
				}
				// For Tag Save tag_arr
				$dir_tags=get_option('_dir_tags');
				if($dir_tags==""){$dir_tags='yes';}	
				if($dir_tags=='yes'){
					$tag_all='';
					if(isset($form_data['tag_arr'] )){
						$tag_name= $form_data['tag_arr'] ;							
						$i=0;$tag_all='';						
						wp_set_object_terms( $newpost_id, $tag_name, $directory_url.'_tag');							
					}
					$tag_all='';
					if(isset($form_data['new_tag'] )){						
						$tag_new= explode(",", $form_data['new_tag']); 			
						foreach($tag_new  as $one_tag){	
							wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $directory_url.'_tag');											
							$i++;	
						}
					}	
					}else{
					$tag_all='';
					$tag_array= wp_get_post_tags( $newpost_id );
					foreach($tag_array as $one_tag){	
						wp_remove_object_terms( $newpost_id, $one_tag->name, 'post_tag' );							
					}
					if(isset($form_data['tag_arr'] )){
						$tag_name= $form_data['tag_arr'] ;							
						$i=0;$tag_all='';
						foreach($tag_name  as $one_tag){							
							$tag_all= $tag_all.",".sanitize_text_field($one_tag);												
							$i++;	
						}
						wp_set_post_tags($newpost_id, $tag_all, true); 	
					}
					if(isset($form_data['new_tag'] )){
						$tag_all=$tag_all.','.sanitize_text_field($form_data['new_tag']);
						wp_set_post_tags($newpost_id, $tag_all, true); 	
					}	
				}	
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address'])); 
				update_post_meta($newpost_id, 'latitude', sanitize_text_field($form_data['latitude'])); 
				update_post_meta($newpost_id, 'longitude', sanitize_text_field($form_data['longitude']));					
				update_post_meta($newpost_id, 'city', sanitize_text_field($form_data['city'])); 
				update_post_meta($newpost_id, 'postcode', sanitize_text_field($form_data['postcode'])); 
				update_post_meta($newpost_id, 'country', sanitize_text_field($form_data['country'])); 
				update_post_meta($newpost_id, 'local-area', sanitize_text_field($form_data['local-area'])); 
				// Get latlng from address* START********
				$dir_lat=sanitize_text_field($form_data['latitude']);
				$dir_lng=sanitize_text_field($form_data['longitude']);
				$address = sanitize_text_field($form_data['address']);
				// Get latlng from address* ENDDDDDD********	
				// property detail*****
				update_post_meta($newpost_id, 'bedrooms', sanitize_text_field($form_data['bedrooms'])); 
				update_post_meta($newpost_id, 'bathrooms', sanitize_text_field($form_data['bathrooms']));
				update_post_meta($newpost_id, 'guest', sanitize_text_field($form_data['guest'])); 
				update_post_meta($newpost_id, 'garages', sanitize_text_field($form_data['garages'])); 
				update_post_meta($newpost_id, 'sale_or_rent_price', sanitize_text_field($form_data['sale_or_rent_price'])); 
				update_post_meta($newpost_id, 'price_postfix_text', sanitize_text_field($form_data['price_postfix_text'])); 
				update_post_meta($newpost_id, 'area', sanitize_text_field($form_data['area'])); 
				update_post_meta($newpost_id, 'area_postfix_text', sanitize_text_field($form_data['area_postfix_text'])); 
				update_post_meta($newpost_id, 'rent_period', sanitize_text_field($form_data['rent_period'])); 
				if(isset($form_data['dirpro_call_button'] )){						
					update_post_meta($newpost_id, 'dirpro_call_button', sanitize_text_field($form_data['dirpro_call_button'])); 
				}
				if(isset($form_data['dirpro_email_button'] )){						
					update_post_meta($newpost_id, 'dirpro_email_button', sanitize_text_field($form_data['dirpro_email_button'])); 
				}
				if(isset($form_data['dirpro_sms_button'] )){						
					update_post_meta($newpost_id, 'dirpro_sms_button', sanitize_text_field($form_data['dirpro_sms_button'])); 
				}
				update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($form_data['contact_source']));  
				//Public Facilities
				$facilities=array();
				if(isset($form_data['facilities_name'] )){
					$facilities_name= $form_data['facilities_name'] ;
					$facilities_value = $form_data['facilities_value'] ;
					$i=0;
					foreach($facilities_name  as $one_facility){
						if(isset($facilities_name[$i]) and isset($facilities_value[$i]) ){
							if($facilities_name[$i] !=''){
								$facilities[sanitize_text_field($facilities_name[$i])] = sanitize_text_field($facilities_value[$i]);
							}
						}							
						$i++;	
					}
					update_post_meta($newpost_id, '_public_facilities', $facilities); 	
				}
				update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($form_data['gallery_image_ids'])); 
				update_post_meta($newpost_id, 'phone', sanitize_text_field($form_data['phone'])); 
				update_post_meta($newpost_id, 'fax', sanitize_text_field($form_data['fax'])); 
				update_post_meta($newpost_id, 'contact-email', sanitize_text_field($form_data['contact-email'])); 
				update_post_meta($newpost_id, 'contact_web', sanitize_text_field($form_data['contact_web'])); 
				update_post_meta($newpost_id, 'contact_name', sanitize_text_field($form_data['contact_name'])); 
				if(isset($form_data['vimeo'] )){
					update_post_meta($newpost_id, 'vimeo', sanitize_text_field($form_data['vimeo'])); 
					update_post_meta($newpost_id, 'youtube', sanitize_text_field($form_data['youtube'])); 
				}
				update_post_meta($newpost_id, 'facebook', sanitize_text_field($form_data['facebook'])); 
				update_post_meta($newpost_id, 'linkedin', sanitize_text_field($form_data['linkedin'])); 
				update_post_meta($newpost_id, 'twitter', sanitize_text_field($form_data['twitter'])); 
				update_post_meta($newpost_id, 'gplus', sanitize_text_field($form_data['gplus']));
				if(isset($form_data['deal-title'])){						
					update_post_meta($newpost_id, 'deal_title', sanitize_text_field($form_data['deal-title']));
				}
				if(isset($form_data['deal_image_id'])){
					update_post_meta($newpost_id, '_deal_image_id', sanitize_text_field($form_data['deal_image_id']));				
				}
				if(isset($form_data['deal-detail'])){						
					update_post_meta($newpost_id, 'deal_detail', sanitize_text_field($form_data['deal-detail']));
				}
				include( wp_iv_property_ABSPATH. 'inc/notification.php');
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_directories_save_user_review(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);						
				$post_type = 'realpro_review';
				$args = array(
				'post_type' => $post_type, // enter your custom post type	
				'author' => sanitize_text_field($form_data['listingid']),					
				);
				$the_query_review = new WP_Query( $args );
				$deleteid ='';
				if ( $the_query_review->have_posts() ) :
				while ( $the_query_review->have_posts() ) : $the_query_review->the_post();
				$deleteid = get_the_ID();	
				if(get_post_meta($deleteid,'review_submitter',true)==$current_user->ID){
					wp_delete_post($deleteid );
				}
				endwhile;
				endif;
				$allowed_html = wp_kses_allowed_html( 'post' );
				
				$my_post= array();						
				$my_post['post_author'] = sanitize_text_field($form_data['listingid']);	
				$my_post['post_title'] = sanitize_text_field($form_data['review_subject']);
				$my_post['post_content'] = wp_kses( $form_data[''], $allowed_html) ;
				$my_post['post_status'] = 'publish';
				$my_post['post_type'] = 'realpro_review';	
				$newpost_id= wp_insert_post( $my_post );						
				$review_value=1;					
				if(isset($form_data['star']) ){$review_value=$form_data['star'];}
				update_post_meta($newpost_id, 'review_submitter', $current_user->ID); 	
				update_post_meta($newpost_id, 'review_value', $review_value); 	
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function eppro_upload_featured_image($thumb_url, $post_id ) { 
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/media.php');
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				// Download file to temp location
				$i=0;$product_image_gallery='';									
				$tmp = download_url( $thumb_url );						
				// Set variables for storage
				// fix file name for query strings
				preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
				$file_array['name'] = basename($matches[0]);
				$file_array['tmp_name'] = $tmp;
				// If error storing temporarily, unlink
				if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';						
				}
				//use media_handle_sideload to upload img:
				$thumbid = media_handle_sideload( $file_array, $post_id, 'gallery desc' );
				// If error storing permanently, unlink
				if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);										
				}						
				set_post_thumbnail($post_id, $thumbid);	
			}
			public function iv_property_loadmore(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				parse_str($_POST['form_data'], $form_data);	
				$post_data='';
				$dirs_data =array();
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				$dir_style5_perpage='20';
				$dir_style5_perpage=get_option('dir_style5_perpage');
				if($dir_style5_perpage==""){$dir_style5_perpage=20;}
				$dirs_data =array();$post_data='';$loadmorebutton='show';							
				$args = array(
				'post_type' => $directory_url, // enter your custom post type
				'paged' => sanitize_text_field($_POST['paged']), 
				'post_status' => 'publish',
				'posts_per_page' => $dir_style5_perpage,
				);
				$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
				if( isset($form_data['property-category'])){
					if($form_data['property-category']!=''){
						$postcats = sanitize_text_field($form_data['property-category']);
						$args[$directory_url.'-category']=$postcats;							
					}		
				}
				$radius=get_option('_iv_radius');					
				if($radius==''){$radius='50';}
				if( isset($form_data['keyword'])){
					if($form_data['keyword']!=""){
						$args['s']= sanitize_text_field($form_data['keyword']);							
					}
				}	
				// Meta Query***********************
				$city_mq ='';
				if(isset($form_data['dir_city']) AND $form_data['dir_city']!=''){							
					$city_mq = array(
					'relation' => 'AND',
					array(
					'key'     => 'city',
					'value'   => sanitize_text_field($form_data['dir_city']),
					'compare' => 'LIKE'
					),
					);
				}
				// Meta Query***********************
				$city_mq ='';
				if(isset($form_data['dir_city']) AND $form_data['dir_city']!=''){							
					$city_mq = array(
					'relation' => 'AND',
					array(
					'key'     => 'city',
					'value'   => sanitize_text_field($form_data['dir_city']),
					'compare' => 'LIKE'
					),
					);
				}
				$zip_mq='';
				if(isset($form_data['zipcode']) AND $form_data['zipcode']!=''){	
					$zip_mq = array(
					'relation' => 'AND',
					array(
					'key'     => 'postcode',
					'value'   => sanitize_text_field($form_data['zipcode']),
					'compare' => 'LIKE'
					),
					);
				}
				$beds='';
				if( isset($form_data['beds'])){
					if($form_data['beds']!=""){			
						$beds=sanitize_text_field($form_data['beds']);	
						$beds = array(
						'relation' => 'AND',
						array(
						'key'     => 'bedrooms',
						'value'   => sanitize_text_field($form_data['beds']),
						'type'    => 'NUMERIC',
						'compare' => '>='
						),
						);
					}
				}
				$baths='';
				if( isset($form_data['baths'])){
					if($form_data['baths']!=""){			
						$baths = array(
						'relation' => 'AND',
						array(
						'key'     => 'bathrooms',
						'value'   => (int)sanitize_text_field($form_data['baths']),
						'type'    => 'NUMERIC',
						'compare' => '>='
						),
						);									
					}
				}
				$min_price='';
				if( isset($form_data['min_price'])){
					if($form_data['min_price']!=""){			
						$min_price=$form_data['min_price'];	
						$min_price = array(
						'relation' => 'AND',
						array(
						'key'     => 'sale_or_rent_price',
						'value'   => (int)sanitize_text_field($form_data['min_price']),
						'type'    => 'NUMERIC',
						'compare' => '>='
						),
						);							
					}
				}
				$max_price='';
				if( isset($form_data['max_price'])){
					if($form_data['max_price']!=""){
						$min_price=$form_data['max_price'];
						$min_price = array(
						'relation' => 'AND',
						array(
						'key'     => 'sale_or_rent_price',
						'value'   => (int)sanitize_text_field($form_data['max_price']),
						'type'    => 'NUMERIC',
						'compare' => '<='
						),
						);
					}
				}
				$area='';
				if( isset($form_data['area'])){
					if($form_data['area']!=""){			
						$area=$form_data['area'];	
						$area = array(
						'relation' => 'AND',
						array(
						'key'     => 'area',
						'value'   => (int)sanitize_text_field($form_data['area']),
						'type'    => 'NUMERIC',
						'compare' => '>='
						),
						);
						$search_show=1;
						$args['posts_per_page']='999999';
					}
				}
				$property_status_re='';
				$property_status='';
				if( isset($form_data['property-type'])){
					$property_status_re=$form_data['property-type'];
					if($form_data['property-type']!=""){	
						$property_status = array(
						'relation' => 'AND',
						array(
						'key'     => 'property_status',
						'value'   => trim(sanitize_text_field($form_data['property-type'])),
						'compare' => 'LIKE'
						),
						);
					}
				}	
				$args['meta_query'] = array(
				$city_mq, $property_status, $zip_mq,$area,$min_price,$baths,$beds,$max_price,
				);
				if( isset($tag)){
					if($tag!=""){
						if(!isset($form_data['keyword'])){
							$args['tag']= $tag;						
						}
					}
				}	
				if( isset($form_data['tag_arr'])){  
					if($form_data['tag_arr']!=""){  			
						$tag_arr= $form_data['tag_arr'];	
						$tags_string= implode("+", $tag_arr);
						$args['tag']= $tags_string;			
					}
				}	
				$active_filter=get_option('active_filter');
				if($active_filter==""){$active_filter='category';}
				
				$moreload_query = new WP_Query( $args ); 
				if ( $moreload_query->have_posts() ) : 
				while ( $moreload_query->have_posts() ) : $moreload_query->the_post();
				$id = get_the_ID();	
				if(get_post_meta($id, 'realpro_featured', true)!='featured'){		
					$gallery_ids=get_post_meta($id ,'image_gallery_ids',true);
					$gallery_ids_array = array_filter(explode(",", $gallery_ids));
					$feature_img='';
					if(has_post_thumbnail()){ 
						$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' ); 
						if($feature_image[0]!=""){ 							
							$feature_img =$feature_image[0];
						}					
						}else{
						$feature_img= wp_iv_property_URLPATH."/assets/images/default-directory.jpg";					
					}
					if($active_filter=="tag"){
						$currentCategory=wp_get_object_terms( $id, $directory_url.'_tag');
						}else{
						$currentCategory=wp_get_object_terms( $id, $directory_url.'-category');
					}
					$cat_link='';$cat_name='';$cat_slug='';
					if(isset($currentCategory[0]->slug)){										
						$cat_slug = $currentCategory[0]->slug;
						$cat_name = $currentCategory[0]->name;
						$cc=0;
						foreach($currentCategory as $c){		
							if($cc==0){
								$cat_name =$c->name;
								$cat_slug =$c->slug;
								}else{
								$cat_name = $cat_name .', '.$c->name;
								$cat_slug = $cat_slug .' '.$c->slug;
							}															
							$cc++;
						}					
					}
					$currentCategory=wp_get_object_terms( $id, $directory_url.'-category');
					$cat_name2='';
					if(isset($currentCategory[0]->slug)){
						$cat_name2 = $currentCategory[0]->name;
						$cc=0;
						foreach($currentCategory as $c){		
							if($cc==0){
								$cat_name2 =$c->name;								
								}else{
								$cat_name2 = $cat_name2 .', '.$c->name;									
							}															
							$cc++;
						}					
					}
					// VIP
					$post_author_id= $post_author_id= get_post_field( 'post_author', $id );;
					$author_package_id=get_user_meta($post_author_id, 'iv_property_package_id', true); 
					$have_vip_badge= get_post_meta($author_package_id,'iv_property_package_vip_badge',true);
					$exprie_date= strtotime (get_user_meta($post_author_id, 'iv_property_exprie_date', true));	
					$current_date=time();	
					$vip_image='';
					if($have_vip_badge=='yes'){
						if($exprie_date >= $current_date){ 	
							if(get_option('vip_image_attachment_id')!=""){
								$vip_img= wp_get_attachment_image_src(get_option('vip_image_attachment_id'));
								if(isset($vip_img[0])){									
									$vip_image='<img src="'.$vip_img[0] .'">';
								}							
								}else{
								$vip_image='<img   src="'. wp_iv_property_URLPATH."/assets/images/vipicon.png".'">';
							}
						}	
					}		
					$current_property_status = get_post_meta($id,'property_status',true);
					$rent_text='';
					if($current_property_status =='For Rent'){$rent_text='' ;
						$rent_text=get_post_meta($id,'price_postfix_text',true). get_post_meta($id,'sale_or_rent_price',true).' '.get_post_meta($id,'rent_period',true) ;	
					}	
					if($current_property_status =='For Sale'){
						$rent_text=get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).'|'. get_post_meta($id,'price_postfix_text',true).get_post_meta($id,'sale_or_rent_price',true);
					}
					if($current_property_status =='Sold'){
						$rent_text= get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).'|'. get_post_meta($id,'price_postfix_text',true).get_post_meta($id,'sale_or_rent_price',true) ;
					}
					$review_text='';
					$dir_single_review_show=get_option('_dir_single_review_show');	
					if($dir_single_review_show==""){$dir_single_review_show='yes';}
					if($dir_single_review_show=='yes'){
						$total_reviews_point = $wpdb->get_col("SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm
						INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
						WHERE pm.meta_key = 'review_value' 
						AND p.post_status = 'publish' 
						AND p.post_type = 'realpro_review' AND p.post_author = '".$id."'");						 
						$argsreviw = array( 'post_type' => 'realpro_review','author'=>$id,'post_status'=>'publish' );
						$ratings = new WP_Query( $argsreviw );
						$total_review_post = $ratings->post_count;
						$avg_review=0;
						if(isset($total_reviews_point[0])){
							$avg_review= (int)$total_reviews_point[0]/(int)$total_review_post;
						}		
						$review_text='';
						$review_text=$review_text.'
						<i class="far fa-star fa-xs '.($avg_review>0?'black-star': 'white-star ').'>"></i>
						<i class="far fa-star fa-xs '. ($avg_review>=2?'black-star': 'white-star').'"></i>
						<i class="far fa-star fa-xs '. ($avg_review>=3?'black-star': 'white-star').'"></i>
						<i class="far fa-star fa-xs '. ($avg_review>=4?'black-star': 'white-star').'"></i>
						<i class="far fa-star fa-xs '. ($avg_review>=5?'black-star': 'white-star').'"></i>									
						<div class="cbp-l-grid-projects-review none" >'. $avg_review.'</div>									
						';
					}	
					$post_data=$post_data.'<div class="cbp-item '. esc_attr($cat_slug).'"><div class="card card-border-round bg-white">
					<div class="card-img-container">
					<a href="'.get_the_permalink($id).'"><img src="'.esc_url($feature_img).'" class="card-img-top"></a>
					</div>
					<div class="card-img-overlay text-white font-weight-bold">';                              
					$current_property_status = get_post_meta($id,'property_status',true);
					$rent_text=get_post_meta($id,'price_postfix_text',true). get_post_meta($id,'sale_or_rent_price',true) ;
					if($current_property_status =='For Rent'){	$rent_text_m=esc_html__('/Month','ivproperty') ;
						$rent_text= get_post_meta($id,'price_postfix_text',true). get_post_meta($id,'sale_or_rent_price',true).$rent_text_m;
					}
					if($current_property_status =='For Sale'){
						$rent_text= get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).'|'. get_post_meta($id,'price_postfix_text',true).get_post_meta($id,'sale_or_rent_price',true);
					}
					if($current_property_status =='Sold'){
						$rent_text= get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).'|'. get_post_meta($id,'price_postfix_text',true).get_post_meta($id,'sale_or_rent_price',true) ;
					}
					$post_data=$post_data.$rent_text.'
					</div>
					<div class="card-img-overlay card-img-overlay__img text-white">
					'.$vip_image.'
					</div>';
					if(get_post_meta($id,'realpro_featured',true)=="featured"){ 
						$post_data=$post_data.'<div class="overlay_content1">
						<p>'. esc_html__("Featured", "ivproperty" ).'</p>
						</div>';
					}
					$post_data=$post_data.'
					<div class="card-body px-4 mt-0 card-body-min-height">
					<a href="'. get_permalink($id).'" class="cbp-caption cbp-l-grid-projects-title mt-0"><p class="realtitle m-0 p-0">'.get_the_title($id).'</p></a>
					<p class="card-text p-0 m-0 address">'. get_post_meta($id,'address',true).' '. get_post_meta($id,'city',true).' '. get_post_meta($id,'zipcode',true).' '.get_post_meta($id,'country',true).'</p>
					<p class="mt-2 short-desc">';
					if(get_post_meta($id,'area',true)!=""){
						$post_data=$post_data.' <i class="fas fa-expand fa-xs ml-1"></i><span class="ml-1"> '. get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).' '.'</span>';
					}
					if(get_post_meta($id,'bedrooms',true)!=""){
						$post_data=$post_data.'<i class="fas fa-bed fa-xs ml-1"></i> <span class="ml-1"> '. get_post_meta($id,'bedrooms',true).
						esc_html__(" Bedrooms","ivproperty").'</span>';
					}
					if(get_post_meta($id,'bathrooms',true)!=""){ 
						$post_data=$post_data.'<i class="fas fa-shower fa-xs ml-1"></i><span class="ml-1">'. get_post_meta($id,'bathrooms',true). esc_html__(' Baths ','ivproperty').'</span>';
					}									
					if(trim(get_post_meta($id,'garages',true))!=""){
						$post_data=$post_data.'<i class="fas fa-car fa-xs ml-1"></i> <span class="ml-1"> '. get_post_meta($id,'garages',true). esc_html__(' Garage ','ivproperty').'</span>';
					}									
					if(get_post_meta($id,'guest',true)!=""){ 
						$post_data=$post_data.'	<i class="fas fa-user fa-xs ml-1"></i> <span class="ml-1"> '. get_post_meta($id,'guest',true). esc_html__(' Guest ','ivproperty').'</span>';
					}
					$post_data=$post_data.'</p>
					<p class="mt-0">'.ucfirst($cat_name2).' '. esc_html__($current_property_status,'ivproperty').'</p>';
					$dir_single_review_show=get_option('dir5_review_show');
					if($dir_single_review_show==""){$dir_single_review_show='yes';}
					if($dir_single_review_show=='yes'){
						$post_data=$post_data.'<p class="d-flex mt-2"><span class="review">'.$review_text.'</span></p>';
					}
					$post_data=$post_data.'</div>
					<div class="cbp-l-grid-projects-date none" >'. strtotime(get_the_date('Ymd',$id)).'</div>
					<div class="cbp-l-grid-projects-price none" >'. get_post_meta($id,'area',true).'</div>
					<div class="cbp-l-grid-projects-size none" >'. get_post_meta($id,'sale_or_rent_price',true).'</div>
					</div>
					</div>';
				}		
				endwhile; 
				else:
				$loadmorebutton='hide';
				endif;		
				echo json_encode(array("code" => "success","data"=>$post_data,"loadmore"=>$loadmorebutton,"dirs_json"=>$dirs_data));
				exit(0);
			}
			public function finalerp_csv_product_upload(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'csv' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$csv_file_id=0;$maping='';
				if(isset($_POST['csv_file_id'])){
					$csv_file_id= sanitize_text_field($_POST['csv_file_id']);
				}
				require(wp_iv_property_DIR .'/admin/pages/importer/upload_main_big_csv.php');
				$total_files = get_option( 'finalerp-number-of-files');
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty'), "maping"=>$maping));
				exit(0);
			}
			public function save_csv_file_to_database(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'csv' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$csv_file_id=0;
				if(isset($_POST['csv_file_id'])){
					$csv_file_id= sanitize_text_field($_POST['csv_file_id']);
				}	
				$row_start=0;
				if(isset($_POST['row_start'])){
					$row_start= sanitize_text_field($_POST['row_start']);
				}
				require (wp_iv_property_DIR .'/admin/pages/importer/csv_save_database.php');
				echo json_encode(array("code" => $done_status,"msg"=>esc_html__( 'Updated Successfully', 'ivproperty'), "row_done"=>$row_done ));
				exit(0);
			}
			public function eppro_get_import_status(){
				$eppro_total_row = floatval( get_option( 'eppro_total_row' ));	
				$eppro_current_row = floatval( get_option( 'eppro_current_row' ));		
				$progress =  ((int)$eppro_current_row / (int)$eppro_total_row)*100;
				if($eppro_total_row<=$eppro_current_row){$progress='100';}
				if($progress=='100'){
					echo json_encode(array("code" => "-1","progress"=>(int)$progress, "eppro_total_row"=>$eppro_total_row,"eppro_current_row"=>$eppro_current_row));	
					}else{
					echo json_encode(array("code" => "0","progress"=>(int)$progress, "eppro_total_row"=>$eppro_total_row ,"eppro_current_row"=>$eppro_current_row));
				}		  
				exit(0);
			}
			public function iv_property_cancel_paypal(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				if( ! class_exists('Paypal' ) ) {
					include(wp_iv_property_DIR . '/inc/class-paypal.php');
				}
				$post_name='iv_property_paypal_setting';						
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name));
				$paypal_id='0';
				if(isset($row->ID )){
					$paypal_id= $row->ID;
				}
				$paypal_api_currency=get_post_meta($paypal_id, 'iv_property_paypal_api_currency', true);
				$paypal_username=get_post_meta($paypal_id, 'iv_property_paypal_username',true);
				$paypal_api_password=get_post_meta($paypal_id, 'iv_property_paypal_api_password', true);
				$paypal_api_signature=get_post_meta($paypal_id, 'iv_property_paypal_api_signature', true);
				$credentials = array();
				$credentials['USER'] = (isset($paypal_username)) ? $paypal_username : '';
				$credentials['PWD'] = (isset($paypal_api_password)) ? $paypal_api_password : '';
				$credentials['SIGNATURE'] = (isset($paypal_api_signature)) ? $paypal_api_signature : '';
				$paypal_mode=get_post_meta($paypal_id, 'iv_property_paypal_mode', true);
				$currencyCode = $paypal_api_currency;
				$sandbox = ($paypal_mode == 'live') ? '' : 'sandbox.';
				$sandboxBool = (!empty($sandbox)) ? true : false;
				$paypal = new Paypal($credentials,$sandboxBool);
				$oldProfile = get_user_meta($current_user->ID,'iv_paypal_recurring_profile_id',true);
				if (!empty($oldProfile)) {
					$cancelParams = array(
					'PROFILEID' => $oldProfile,
					'ACTION' => 'Cancel'
					);
					$paypal -> request('ManageRecurringPaymentsProfileStatus',$cancelParams);
					update_user_meta($current_user->ID,'iv_paypal_recurring_profile_id','');
					update_user_meta($current_user->ID,'iv_cancel_reason', sanitize_text_field($form_data['cancel_text'])); 
					update_user_meta($current_user->ID,'iv_property_payment_status', 'cancel'); 
					echo json_encode(array("code" => "success","msg"=>"Cancel Successfully"));
					exit(0);							
					}else{
					echo json_encode(array("code" => "not","msg"=>esc_html__( 'Unable to Cancel', 'ivproperty')));
					exit(0);	
				}
			}
			public function iv_property_woocommerce_form_submit(  ) {
				$iv_gateway = get_option('iv_property_payment_gateway');
				if($iv_gateway=='woocommerce'){ 
					include(wp_iv_property_ABSPATH . '/admin/pages/payment-inc/woo-submit.php');
				}	
			}
			public function  iv_property_profile_stripe_upgrade(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				include(wp_iv_property_DIR . '/admin/init.php');
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);	
				$newpost_id='';
				$post_name='iv_property_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				if(isset($row->ID )){
					$newpost_id= $row->ID;
				}
				$stripe_mode=get_post_meta( $newpost_id,'iv_property_stripe_mode',true);	
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($newpost_id, 'iv_property_stripe_secret_test',true);	
					}else{
					$stripe_api =get_post_meta($newpost_id, 'iv_property_stripe_live_secret_key',true);	
				}
				\Stripe\Stripe::setApiKey($stripe_api);				
				// For  cancel ----
				$arb_status =	get_user_meta($current_user->ID, 'iv_property_payment_status', true);
				$cust_id = get_user_meta($current_user->ID,'iv_property_stripe_cust_id',true);
				$sub_id = get_user_meta($current_user->ID,'iv_property_stripe_subscrip_id',true);
				if($sub_id!=''){	
					try{
						$iv_cancel_stripe = Stripe_Customer::retrieve(sanitize_text_field($form_data['cust_id']));
						$iv_cancel_stripe->subscriptions->retrieve(sanitize_text_field($form_data['sub_id']))->cancel();
						} catch (Exception $e) {
					}
					update_user_meta($current_user->ID,'iv_property_payment_status', 'cancel'); 
					update_user_meta($current_user->ID,'iv_property_stripe_subscrip_id','');
				}			
				include(wp_iv_property_DIR . '/admin/pages/payment-inc/stripe-upgrade.php');
				echo json_encode(array("code" => "success","msg"=>$response));
				exit(0);
			}
			public function iv_property_contact_popup(){
				include( wp_iv_property_template. 'private-profile/contact_popup.php');
				exit(0);
			}
			public function eplisting_contact(){
				include( wp_iv_property_template. 'property/contact_popup.php');
				exit(0);
			}
			
			
			public function iv_property_cancel_stripe(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				include(wp_iv_property_DIR . '/admin/files/lib/Stripe.php');
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);	
				$newpost_id='';
				$post_name='iv_property_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				if(isset($row->ID )){
					$newpost_id= $row->ID;
				}
				$stripe_mode=get_post_meta( $newpost_id,'iv_property_stripe_mode',true);	
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($newpost_id, 'iv_property_stripe_secret_test',true);	
					}else{
					$stripe_api =get_post_meta($newpost_id, 'iv_property_stripe_live_secret_key',true);	
				}
				Stripe::setApiKey($stripe_api);
				try{
					$iv_cancel_stripe = Stripe_Customer::retrieve(sanitize_text_field($form_data['cust_id']));
					$iv_cancel_stripe->subscriptions->retrieve($form_data['sub_id'])->cancel();
					} catch (Exception $e) {
				}
				update_user_meta($current_user->ID,'iv_cancel_reason', sanitize_text_field($form_data['cancel_text'])); 
				update_user_meta($current_user->ID,'iv_property_payment_status', 'cancel'); 
				update_user_meta($current_user->ID,'iv_property_stripe_subscrip_id','');
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Cancel Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_setting_hide(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);		
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );		
				}		
				global $current_user;
				$mobile_hide=(isset($form_data['mobile_hide'])? $form_data['mobile_hide']:'');	
				$email_hide=(isset($form_data['email_hide'])? $form_data['email_hide']:'');	
				$phone_hide=(isset($form_data['phone_hide'])? $form_data['phone_hide']:'');	
				update_user_meta($current_user->ID,'hide_email', sanitize_text_field($email_hide)); 
				update_user_meta($current_user->ID,'hide_phone', sanitize_text_field($phone_hide));					
				update_user_meta($current_user->ID,'hide_mobile',sanitize_text_field($mobile_hide)); 
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_setting_fb(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);		
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );		
				}		
				global $current_user;
				update_user_meta($current_user->ID,'twitter', sanitize_text_field($form_data['twitter'])); 
				update_user_meta($current_user->ID,'facebook', sanitize_text_field($form_data['facebook'])); 
				update_user_meta($current_user->ID,'gplus', sanitize_text_field($form_data['gplus'])); 
				update_user_meta($current_user->ID,'linkedin', sanitize_text_field($form_data['linkedin'])); 
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_property_update_setting_password(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);		
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );		
				}
				global $current_user;										
				if ( wp_check_password( sanitize_text_field($form_data['c_pass']), $current_user->user_pass, $current_user->ID) ){
					if($form_data['r_pass']!=$form_data['n_pass']){
						echo json_encode(array("code" => "not", "msg"=>"New Password & Re Password are not same. "));
						exit(0);
						}else{
						wp_set_password( sanitize_text_field($form_data['n_pass']), $current_user->ID);
						echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
						exit(0);
					}
					}else{
					echo json_encode(array("code" => "not", "msg"=>esc_html__( 'Current password is wrong.', 'ivproperty')));
					exit(0);
				}
			}
			public function iv_property_update_profile_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);		
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );		
				}		
				global $current_user;					
				update_user_meta($current_user->ID,'first_name', sanitize_text_field($form_data['first_name'])); 
				update_user_meta($current_user->ID,'last_name', sanitize_text_field($form_data['last_name'])); 
				update_user_meta($current_user->ID,'phone', sanitize_text_field($form_data['phone'])); 					
				update_user_meta($current_user->ID,'mobile', sanitize_text_field($form_data['mobile'])); 
				update_user_meta($current_user->ID,'address', sanitize_text_field($form_data['address'])); 
				update_user_meta($current_user->ID,'occupation', sanitize_text_field($form_data['occupation']));
				update_user_meta($current_user->ID,'description', sanitize_text_field($form_data['about']));	
				update_user_meta($current_user->ID,'web_site', sanitize_text_field($form_data['web_site']));
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'ivproperty')));
				exit(0);
			}
			public function iv_restrict_media_library( $wp_query ) {
				global $current_user, $pagenow;
				if( is_admin() && !current_user_can('edit_others_posts') ) {
					$wp_query->set( 'author', $current_user->ID );
					add_filter('views_edit-post', 'fix_post_counts');
					add_filter('views_upload', 'fix_media_counts');
				}
			}
			public function check_expiry_date($user) {
				include(wp_iv_property_DIR . '/inc/check_expire_date.php');
			}
			public function iv_property_update_profile_pic(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				if(isset($_REQUEST['profile_pic_url_1'])){
					$iv_profile_pic_url=$_REQUEST['profile_pic_url_1'];
					$attachment_thum=$_REQUEST['attachment_thum'];
					}else{
					$iv_profile_pic_url='';
					$attachment_thum='';
				}
				update_user_meta($current_user->ID, 'iv_profile_pic_thum', $attachment_thum);					
				update_user_meta($current_user->ID, 'iv_profile_pic_url', $iv_profile_pic_url);
				echo json_encode('success');
				exit(0);
			}
			public function iv_property_paypal_form_submit(  ) {
				include(wp_iv_property_DIR . '/admin/pages/payment-inc/paypal-submit.php');
			}	
			public function iv_property_stripe_form_submit(  ) {
				include(wp_iv_property_DIR . '/admin/pages/payment-inc/stripe-submit.php');
			}
			public function plugin_mce_css_iv_property( $mce_css ) {
				if ( ! empty( $mce_css ) )
				$mce_css .= ',';
				$mce_css .= plugins_url( 'admin/files/css/iv-bootstrap.css', __FILE__ );
				return $mce_css;
			}
			/***********************************
				* Adds a meta box to the post editing screen
			*/
			public function prfx_custom_meta_iv_property() {
				$directory_url=get_option('_iv_property_url');
				if($directory_url==""){$directory_url='property';}
				add_meta_box('prfx_meta', esc_html__('Claim Approve ', 'ivproperty'), array(&$this, 'iv_property_meta_callback'),$directory_url,'side');
				add_meta_box('prfx_meta2', esc_html__('Listing Data  ', 'ivproperty'), array(&$this, 'iv_property_meta_callback_full_data'),$directory_url,'advanced');
			}
			public function iv_property_check_coupon(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'signup' ) ) {
					echo json_encode(array("msg"=>"Are you cheating:wpnonce?"));						
					exit(0);
				}
				global $wpdb;
				$coupon_code=sanitize_text_field($_REQUEST['coupon_code']);
				$package_id=sanitize_text_field($_REQUEST['package_id']);					
				$package_amount=get_post_meta($package_id, 'iv_property_package_cost',true);
				$api_currency =sanitize_text_field($_REQUEST['api_currency']);
				$post_cont = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = '%s' and  post_type='iv_property_coupon'",$coupon_code ));	
				if(sizeof($post_cont)>0 && $package_amount>0){
					$coupon_name = $post_cont->post_title;
					$current_date=$today = date("m/d/Y");
					$start_date=get_post_meta($post_cont->ID, 'iv_property_coupon_start_date', true);
					$end_date=get_post_meta($post_cont->ID, 'iv_property_coupon_end_date', true);
					$coupon_used=get_post_meta($post_cont->ID, 'iv_property_coupon_used', true);
					$coupon_limit=get_post_meta($post_cont->ID, 'iv_property_coupon_limit', true);
					$dis_amount=get_post_meta($post_cont->ID, 'iv_property_coupon_amount', true);							 
					$package_ids =get_post_meta($post_cont->ID, 'iv_property_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);
					if(in_array('0', $all_pac_arr)){
						$pac_found=1;
						}else{
						if(in_array($package_id, $all_pac_arr)){
							$pac_found=1;
							}else{
							$pac_found=0;
						}
					}
					$recurring = get_post_meta( $package_id,'iv_property_package_recurring',true); 
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found == '1' && $recurring!='on' ){
						$total = $package_amount -$dis_amount;
						$coupon_type= get_post_meta($post_cont->ID, 'iv_property_coupon_type', true);
						if($coupon_type=='percentage'){
							$dis_amount= $dis_amount * $package_amount/100;
							$total = $package_amount -$dis_amount ;
						}
						echo json_encode(array('code' => 'success',
						'dis_amount' => $dis_amount.' '.$api_currency,
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
						}else{
						$dis_amount='';
						$total=$package_amount;
						echo json_encode(array('code' => 'not-success-2',
						'dis_amount' => '',
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
					}
					}else{
					if($package_amount=="" or $package_amount=="0"){$package_amount='0';}
					$dis_amount='';
					$total=$package_amount;
					echo json_encode(array('code' => 'not-success-1',
					'dis_amount' => '',
					'gtotal' => $total.' '.$api_currency,
					'p_amount' => $package_amount.' '.$api_currency,
					));
					exit(0);
				}
			}
			public function iv_property_check_package_amount(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'signup' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				$coupon_code=(isset($_REQUEST['coupon_code'])? sanitize_text_field($_REQUEST['coupon_code']):'');
				$package_id=sanitize_text_field($_REQUEST['package_id']);
				if( get_post_meta( $package_id,'iv_property_package_recurring',true) =='on'  ){
					$package_amount=get_post_meta($package_id, 'iv_property_package_recurring_cost_initial', true);			
					}else{					
					$package_amount=get_post_meta($package_id, 'iv_property_package_cost',true);
				}
				$api_currency =sanitize_text_field($_REQUEST['api_currency']);			
				$iv_gateway = get_option('iv_property_payment_gateway');
				if($iv_gateway=='woocommerce'){
					if ( class_exists( 'WooCommerce' ) ) {	
						$api_currency= get_option( 'woocommerce_currency' );
						$api_currency= get_woocommerce_currency_symbol( $api_currency );
					}
				}		
				$post_cont = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = '%s' and  post_type='iv_property_coupon'", $coupon_code));	
				if(isset($post_cont->ID)){
					$coupon_name = $post_cont->post_title;
					$current_date=$today = date("m/d/Y");
					$start_date=get_post_meta($post_cont->ID, 'iv_property_coupon_start_date', true);
					$end_date=get_post_meta($post_cont->ID, 'iv_property_coupon_end_date', true);
					$coupon_used=get_post_meta($post_cont->ID, 'iv_property_coupon_used', true);
					$coupon_limit=get_post_meta($post_cont->ID, 'iv_property_coupon_limit', true);
					$dis_amount=get_post_meta($post_cont->ID, 'iv_property_coupon_amount', true);							 
					$package_ids =get_post_meta($post_cont->ID, 'iv_property_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);
					$pac_found= in_array($package_id, $all_pac_arr);							
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found=="1"){
						$total = $package_amount -$dis_amount;
						echo json_encode(array('code' => 'success',
						'dis_amount' => $api_currency.' '.$dis_amount,
						'gtotal' => $api_currency.' '.$total,
						'p_amount' => $api_currency.' '.$package_amount,
						));
						exit(0);
						}else{
						$dis_amount='--';
						$total=$package_amount;
						echo json_encode(array('code' => 'not-success',
						'dis_amount' => $api_currency.' '.$dis_amount,
						'gtotal' => $api_currency.' '.$total,
						'p_amount' => $api_currency.' '.$package_amount,
						));
						exit(0);
					}
					}else{
					$dis_amount='--';
					$total=$package_amount;
					echo json_encode(array('code' => 'not-success',
					'dis_amount' => $api_currency.' '.$dis_amount,
					'gtotal' => $api_currency.' '.$total,
					'p_amount' => $api_currency.' '.$package_amount,
					));
					exit(0);
				}
			}
			/**
				* Outputs the content of the meta box
			*/
			public function iv_property_meta_callback($post) {
				wp_nonce_field(basename(__FILE__), 'prfx_nonce');
				include ('admin/pages/metabox.php');
			}
			public function iv_property_meta_callback_full_data(){
				include ('admin/pages/metabox_full_data.php');
			}
			public function iv_property_meta_save($post_id) {
				
				global $wpdb;
				$is_autosave = wp_is_post_autosave($post_id);
				if (isset($_REQUEST['iv_property_approve'])) {
					if($_REQUEST['iv_property_approve']=='yes'){ 
						update_post_meta($post_id, 'iv_property_approve', sanitize_text_field($_REQUEST['iv_property_approve']));
						// Set new user for post							
						$iv_property_author_id= sanitize_text_field($_REQUEST['iv_property_author_id']);
						$sql=$wpdb->prepare("UPDATE  $wpdb->posts SET post_author=%d  WHERE ID=$d",$iv_property_author_id,$post_id );		
						$wpdb->query($sql); 					
					}
				} 
				if (isset($_REQUEST['realpro_featured'])) {							
					update_post_meta($post_id, 'realpro_featured', sanitize_text_field($_REQUEST['realpro_featured']));
				}
				if (isset($_REQUEST['listing_data_submit'])) { 
					$newpost_id=$post_id;
					update_post_meta($newpost_id, 'property_status', sanitize_text_field(trim($_REQUEST['property_type']))); 
					$default_fields = array();
					$field_set=get_option('iv_property_fields' );
					if($field_set!=""){ 
						$default_fields=get_option('iv_property_fields' );
						}else{															
						$default_fields['Property_ID']=esc_html__('Property ID','ivproperty');
						$default_fields['Available_From']=esc_html__('Available From','ivproperty');
						$default_fields['Year_Built']=esc_html__('Year Built');
						$default_fields['Exterior_Material']=esc_html__('Exterior Material','ivproperty');
						$default_fields['Structure_Type']=esc_html__('Structure Type','ivproperty');
						$default_fields['AC']=esc_html__('AC','ivproperty');
						$default_fields['Acres']=esc_html__('Acres','ivproperty');
						$default_fields['Bedroom_Features']=esc_html__('Bedroom Features','ivproperty');
						$default_fields['Cross_Streets']=esc_html__('Cross Streets','ivproperty');
						$default_fields['Dining_Area']=esc_html__('Dining Area','ivproperty');
						$default_fields['Disability_Access']=esc_html__('Disability Access','ivproperty');
						$default_fields['Entry_Location']=esc_html__('Entry Location','ivproperty');
						$default_fields['Exterior_Cnstruction']=esc_html__('Exterior Cnstruction','ivproperty');
						$default_fields['Fireplace_Fuel']=esc_html__('Fireplace Fuel','ivproperty');
						$default_fields['Fireplace_Location']=esc_html__('Fireplace Location','ivproperty');
						$default_fields['Legal_Desc']=esc_html__('Legal Desc','ivproperty');
						$default_fields['Lot_Description']=esc_html__('Lot Description','ivproperty');
						$default_fields['Lot_Size_Source']=esc_html__('Lot Size Source','ivproperty');
						$default_fields['Misc_Interior']=esc_html__('Misc Interior','ivproperty');
						$default_fields['Sewer']=esc_html__('Sewer','ivproperty');
						$default_fields['Source_Of_Sqft']=esc_html__('Source Of Sqft','ivproperty');
						$default_fields['Terms']=esc_html__('Terms','ivproperty');
						$default_fields['View_Desc']=esc_html__('View Desc','ivproperty');
					}
					if(sizeof($default_fields )){			
						foreach( $default_fields as $field_key => $field_value ) { 
							update_post_meta($newpost_id, $field_key, $_REQUEST[$field_key] );							
						}					
					}
					// property detail*****
					update_post_meta($newpost_id, 'bedrooms', sanitize_text_field($_REQUEST['bedrooms'])); 
					update_post_meta($newpost_id, 'bathrooms', sanitize_text_field($_REQUEST['bathrooms']));					
					update_post_meta($newpost_id, 'guest', sanitize_text_field($_REQUEST['guest'])); 
					update_post_meta($newpost_id, 'garages', sanitize_text_field($_REQUEST['garages'])); 
					update_post_meta($newpost_id, 'sale_or_rent_price', sanitize_text_field($_REQUEST['sale_or_rent_price'])); 
					update_post_meta($newpost_id, 'price_postfix_text', sanitize_text_field($_REQUEST['price_postfix_text'])); 
					update_post_meta($newpost_id, 'area', sanitize_text_field($_REQUEST['area'])); 
					update_post_meta($newpost_id, 'area_postfix_text', sanitize_text_field($_REQUEST['area_postfix_text']));
					update_post_meta($newpost_id, 'rent_period', sanitize_text_field($_REQUEST['rent_period'])); 					
					update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($_REQUEST['contact_source']));  
					//Public Facilities
					$facilities=array();
					if(isset($_REQUEST['facilities_name'] )){
						$facilities_name= 	$_REQUEST['facilities_name'] ;
						$facilities_value = $_REQUEST['facilities_value'];
						$i=0;
						foreach($facilities_name  as $one_facility){
							if(isset($facilities_name[$i]) and isset($facilities_value[$i]) ){
								if($facilities_name[$i] !=''){
									$facilities[sanitize_text_field($facilities_name[$i])] = sanitize_text_field($facilities_value[$i]);
								}
							}							
							$i++;	
						}
						update_post_meta($newpost_id, '_public_facilities', $facilities); 	
					}
					// Delete Plan
					$i=0;
					for($i=0;$i<20;$i++){
						delete_post_meta($newpost_id, '_plan_description_'.$i); 							
						delete_post_meta($newpost_id, '_plan_image_id_'.$i);
					}		
					// Delete End
					// For Plan Save 
					if(isset($_REQUEST['plan_description']) || isset($_REQUEST['plan_image_id']) ){						
						$plan_description= $_REQUEST['plan_description'];						
						$plan_image_id= (isset($_REQUEST['plan_image_id']) ? $_REQUEST['plan_image_id']:'');
						for($i=0;$i<20;$i++){		
							if(isset($plan_description[$i])){
								update_post_meta($newpost_id, '_plan_description_'.$i, sanitize_text_field($plan_description[$i])); 
							}							
							if(isset($plan_image_id[$i])){
								update_post_meta($newpost_id, '_plan_image_id_'.$i, sanitize_text_field($plan_image_id[$i])); 
							}						
						}						 	
					}
					update_post_meta($newpost_id, 'address', sanitize_text_field($_REQUEST['address'])); 
					update_post_meta($newpost_id, 'latitude', sanitize_text_field($_REQUEST['latitude'])); 
					update_post_meta($newpost_id, 'longitude', sanitize_text_field($_REQUEST['longitude']));					
					update_post_meta($newpost_id, 'city', sanitize_text_field($_REQUEST['city'])); 
					update_post_meta($newpost_id, 'state', sanitize_text_field($_REQUEST['state'])); 
					update_post_meta($newpost_id, 'postcode', sanitize_text_field($_REQUEST['postcode'])); 
					update_post_meta($newpost_id, 'country', sanitize_text_field($_REQUEST['country'])); 
					update_post_meta($newpost_id, 'local-area', sanitize_text_field($_REQUEST['local-area'])); 
					// Get latlng from address* START********
					$dir_lat=sanitize_text_field($_REQUEST['latitude']);
					$dir_lng=sanitize_text_field($_REQUEST['longitude']);
					$address = sanitize_text_field($_REQUEST['address']);					
					update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($_REQUEST['gallery_image_ids'])); 
					update_post_meta($newpost_id, 'phone', sanitize_text_field($_REQUEST['phone'])); 
					update_post_meta($newpost_id, 'fax', sanitize_text_field($_REQUEST['fax'])); 
					update_post_meta($newpost_id, 'contact-email', sanitize_text_field($_REQUEST['contact-email'])); 
					update_post_meta($newpost_id, 'contact_web', sanitize_text_field($_REQUEST['contact_web'])); 					
					update_post_meta($newpost_id, 'contact_name', sanitize_text_field($_REQUEST['contact_name'])); 
					if(isset($_REQUEST['vimeo'] )){
						update_post_meta($newpost_id, 'vimeo', sanitize_text_field($_REQUEST['vimeo'])); 
						update_post_meta($newpost_id, 'youtube', sanitize_text_field($_REQUEST['youtube'])); 
					}
					if(isset($_REQUEST['facebook'])){
						update_post_meta($newpost_id, 'facebook', sanitize_text_field($_REQUEST['facebook']));
					}
					if(isset($_REQUEST['linkedin'])){
						update_post_meta($newpost_id, 'linkedin', sanitize_text_field($_REQUEST['linkedin']));
					}
					if(isset($_REQUEST['twitter'])){
						update_post_meta($newpost_id, 'twitter', sanitize_text_field($_REQUEST['twitter']));
					}
					if(isset($_REQUEST['gplus'])){
						update_post_meta($newpost_id, 'gplus', sanitize_text_field($_REQUEST['gplus']));
					}
					if(isset($_REQUEST['deal-title'])){
						update_post_meta($newpost_id, 'deal_title', sanitize_text_field($_REQUEST['deal-title']));
					}
					if(isset($_REQUEST['deal_image_id'])){
						update_post_meta($newpost_id, '_deal_image_id', sanitize_text_field($_REQUEST['deal_image_id']));
					}
					if(isset($_REQUEST['deal-detail'])){
						update_post_meta($newpost_id, 'deal_detail', sanitize_text_field($_REQUEST['deal-detail']));
					}	
				}
			}
			/**
				* Checks that the WordPress setup meets the plugin requirements
				* @global string $wp_version
				* @return boolean
			*/
			private function check_requirements() {
				global $wp_version;
				if (!version_compare($wp_version, $this->wp_version, '>=')) {
					add_action('admin_notices', 'wp_iv_property::display_req_notice');
					return false;
				}
				return true;
			}
			/**
				* Display the requirement notice
				* @static
			*/
			static function display_req_notice() {
				global $wp_iv_property;
				echo '<div id="message" class="error"><p><strong>';
				echo esc_html__('Sorry, BootstrapPress re requires WordPress ' . $wp_iv_property->wp_version . ' or higher.
				Please upgrade your WordPress setup', 'wp-pb');
				echo '</strong></p></div>';
			}
			private function load_dependencies() {
				// Admin Panel
				if (is_admin()) {						
					include ('admin/notifications.php');					
				include ('admin/admin.php');					}
				// Front-End Site
				if (!is_admin()) {
				}
				// Global
			}
			/**
				* Called every time the plug-in is activated.
			*/
			public function activate() {
				include ('install/install.php');
			}
			/**
				* Called when the plug-in is deactivated.
			*/
			public function deactivate() {
				global $wpdb;			
				$page_name='price-table';						
				$query = "delete from {$wpdb->prefix}posts where  post_name='".$page_name."'";
				$wpdb->query($query);
				$page_name='registration';						
				$query = "delete from {$wpdb->prefix}posts where  post_name='".$page_name."'";
				$wpdb->query($query);
				$page_name='my-account';						
				$query = "delete from {$wpdb->prefix}posts where  post_name='".$page_name."' ";
				$wpdb->query($query);
				$page_name='agent-public';						
				$query = "delete from {$wpdb->prefix}posts where  post_name='".$page_name."' ";
				$wpdb->query($query);
				$page_name='thank-you';						
				$query = "delete from {$wpdb->prefix}posts where  post_name='".$page_name."' ";
				$wpdb->query($query);
				$page_name='login';						
				$query = "delete from {$wpdb->prefix}posts where  post_name='".$page_name."'";
				$wpdb->query($query);
				$page_name='agent-directory';						
				$query = "delete from {$wpdb->prefix}posts where  post_name='".$page_name."' ";
				$wpdb->query($query);
				$page_name='iv-reminder-email-cron-job';						
				$query = "delete from {$wpdb->prefix}posts where  post_name='".$page_name."' ";
				$wpdb->query($query);
			}
			/**
				* Called when the plug-in is uninstalled
			*/
			static function uninstall() {
			}
			/**
				* Register the widgets
			*/
			public function register_widget() {
			}
			/**
				* Internationalization
			*/
			public function i18n() {
				load_plugin_textdomain('ivproperty', false, basename(dirname(__FILE__)) . '/languages/' );
			}
			/**
				* Starts the plug-in main functionality
			*/
			public function start() {
			}
			public function iv_property_price_table_func($atts = '', $content = '') {									
				ob_start();					  //include the specified file
				include( wp_iv_property_ABSPATH. 'admin/pages/price-table/price-table-1.php');
				$content = ob_get_clean();	
				return $content;
			}
			public function iv_property_form_wizard_func($atts = '') {
			
				global $current_user;
				$template_path=wp_iv_property_template.'signup/';
				ob_start();	 //include the specified file
				if($current_user->ID==0){
					$signup_access= get_option('users_can_register');	
					if($signup_access=='0'){
						esc_html_e( 'Sorry! You are not allowed for signup.', 'ivproperty' );
						}else{
						include( $template_path. 'wizard-style-2.php');
					}						
					}else{						  
					include( wp_iv_property_template. 'private-profile/profile-template-1.php');
				}
				$content = ob_get_clean();	
				return $content;
			}
			public function iv_property_profile_template_func($atts = '') {
				
				global $current_user;
				ob_start();
				if($current_user->ID==0){
					include(wp_iv_property_template. 'private-profile/profile-login.php');
					}else{					  
					include( wp_iv_property_template. 'private-profile/profile-template-1.php');
				}
				$content = ob_get_clean();	
				return $content;
			}
			public function iv_property_reminder_email_cron_func ($atts = ''){
				include( wp_iv_property_ABSPATH. 'inc/reminder-email-cron.php');
			}
			public function iv_property_cron_job(){
				include( wp_iv_property_ABSPATH. 'inc/all_cron_job.php');
				exit(0);
			}
			public function realestatepro_categories_func($atts = ''){
				ob_start();	
				if(isset($atts['style']) and $atts['style']!="" ){
					$tempale=$atts['style']; 
					}else{
					$tempale=get_option('realestatepro_categories'); 
				}
				if($tempale==''){
					$tempale='style-1';
				}						
				//include the specified file
				if($tempale=='style-1'){
					include( wp_iv_property_template. 'property/realestatepro_categories.php');
				}
				$content = ob_get_clean();
				return $content;	
			}
			public function realestatepro_cities_func($atts = ''){
				ob_start();	
				include( wp_iv_property_template. 'property/listing-cities.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listing_carousel_func($atts = ''){
				ob_start();	
				include( wp_iv_property_template. 'property/listing-carousel.php');
				$content = ob_get_clean();
				return $content;
			}	
			public function realestatepro_search_func($atts = ''){
				ob_start();	
				include( wp_iv_property_template. 'property/property-search.php');
				$content = ob_get_clean();
				return $content;
			}
			public function slider_search_func($atts = ''){
				ob_start();	
				include( wp_iv_property_template. 'property/slider-search.php');
				$content = ob_get_clean();
				return $content;
			}
			public function realestatepro_map_func($atts = ''){
				ob_start();	
				include( wp_iv_property_template. 'property/property-map.php');
				$content = ob_get_clean();
				return $content;
			}				
			public function realestatepro_featured_func($atts = ''){
				ob_start();	
				if(isset($atts['style']) and $atts['style']!="" ){
					$tempale=$atts['style']; 
					}else{
					$tempale=get_option('realestatepro_featured'); 
				}
				if($tempale==''){
					$tempale='style-1';
				}						
				//include the specified file
				if($tempale=='style-1'){
					include( wp_iv_property_template. 'property/realestatepro_featured.php');
				}
				$content = ob_get_clean();
				return $content;	
			}		
			public function listing_layout_style_1_func($atts=''){
				ob_start();	
				include( wp_iv_property_template. 'property/archive-property-style-1.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listing_layout_style_2_func($atts=''){
				ob_start();	
				include( wp_iv_property_template. 'property/archive-property-style-2.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listing_filter_func($atts=''){
				ob_start();	
				include( wp_iv_property_template. 'property/property-filter.php');
				$content = ob_get_clean();
				return $content;				
			}
			public function iv_property_user_directory_func($atts = ''){
				global $current_user;	
				ob_start(); //include the specified file					
				include( wp_iv_property_template. 'user-directory/directory-template-2.php');
				$content = ob_get_clean();
				return $content;	
			}
			public function get_unique_location_values( $key = 'keyword', $post_type ){
				global $wpdb;
				$post_type=get_option('_iv_property_url');
				if($post_type==""){$post_type='property';}
				$all_data=array();
				// Area**
				$dir_facet_title=get_option('dir_facet_area_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','ivproperty');}
				$res=array();
				$key = 'area';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'						
				", $key) );						
				foreach($res as $row1){							
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}
				}
				// City ***
				$dir_facet_title=get_option('dir_facet_location_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('City','ivproperty');}
				$res=array();
				$key = 'city';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'						
				", $key) );						
				foreach($res as $row1){							
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}	
				}
				// Zipcode ***
				$dir_facet_title=get_option('dir_facet_zipcode_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','ivproperty');}
				$res=array();
				$key = 'postcode';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'						
				", $key) );						
				foreach($res as $row1){							
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}	
				}
				$all_data_json= json_encode($all_data);		
				return $all_data_json;
			}
			public function get_unique_search_values(){						
				global $wpdb;
				$post_type=get_option('_iv_property_url');
				if($post_type==""){$post_type='property';}
				$res=array();
				$all_data=array();						
				$partners = array();
				$partners_obj =  get_terms( $post_type.'-category', array('hide_empty' => true) );
				$dir_facet_title=get_option('dir_facet_cat_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','ivproperty');}
				foreach ($partners_obj as $partner) {
					$row_data=array();
					$row_data['label']=$partner->name.'['.$partner->count.']';
					$row_data['value']=$partner->name;
					$row_data['category']= $dir_facet_title;
					array_push( $all_data, $row_data );
				}
				// For tags
				$dir_facet_title=get_option('dir_facet_features_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivproperty');}
				$dir_tags=get_option('_dir_tags');	
				if($dir_tags==""){$dir_tags='yes';}	
				if($dir_tags=="yes"){
					$partners = array();
					$partners_obj =  get_terms( $post_type.'_tag', array('hide_empty' => true) );
					foreach ($partners_obj as $partner) {
						$row_data=array();
						$row_data['label']=$partner->name.'['.$partner->count.']';
						$row_data['value']=$partner->name;
						$row_data['category']=$dir_facet_title;
						array_push( $all_data, $row_data );
					}
					}else{
					$args =array();
					$args['hide_empty']=true;
					$tags = get_tags($args );
					foreach ( $tags as $tag ) { 
						$row_data=array();
						$row_data['label']=$tag->name.'['.$tag->count.']';
						$row_data['value']=$tag->name;
						$row_data['category']=$dir_facet_title;
						array_push( $all_data, $row_data );
					}							
				}
				// End Tags	****					
				$args3 = array(
				'post_type' => $post_type, // enter your custom post type						
				'post_status' => 'publish',						
				'posts_per_page'=> -1,  // overrides posts per page in theme settings
				'orderby' => 'title',
				'order' => 'ASC',
				);
				$all_data_json=array();
				$query_auto = new WP_Query( $args3 );
				$posts_auto = $query_auto->posts;						
				foreach($posts_auto as $post_a) {
					$row_data=array();  
					$row_data['label']=$post_a->post_title;
					$row_data['value']=$post_a->post_title;
					$row_data['category']= esc_html__('Title','ivproperty');
					array_push( $all_data, $row_data );
				}						
				$all_data_json= json_encode($all_data);	
				return $all_data_json;
			}
			public function iv_property_profile_public_func($atts = '') {	
				ob_start();						  //include the specified file
				include( wp_iv_property_template. 'profile-public/profile-template.php');							
				$content = ob_get_clean();	
				return $content;
			}
			public function get_search_listing($lat=0,$lng=0,$radius=3,$postcats){
				global $wpdb;
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}	
				if($radius==""){$radius='50';}	
				if($lat==""){$lat='0';}	
				if($lng==""){$lng='0';}	
				$results = $wpdb->get_results($wpdb->prepare("SELECT p.ID, 
				ACOS(SIN(RADIANS($lat))*SIN(RADIANS(pm1.meta_value))+COS(RADIANS($lat  ))*COS(RADIANS(pm1.meta_value))*COS(RADIANS(pm2.meta_value)-RADIANS($lng))) * 6387.7 AS distance 
				FROM $wpdb->posts p													
				LEFT JOIN wp_postmeta AS pm1 ON ( p.ID = pm1.post_id AND pm1.meta_key = 'latitude' )
				LEFT JOIN wp_postmeta AS pm2 ON ( p.ID = pm2.post_id AND pm2.meta_key = 'longitude' )
				WHERE post_type = '%s' AND post_status = 'publish'								
				HAVING distance <= $radius
				ORDER BY distance ASC;", $directory_url));
				$ids='';
				foreach($results as $row){
					$ids=$row->ID.',';
				}
				return $ids;
			}
			public function ep_create_my_taxonomy_tags(){
				$directory_url=get_option('_iv_property_url');
				if($directory_url==""){$directory_url='property';}
				$dir_tags=get_option('_dir_tags');	
				if($dir_tags==""){$dir_tags='yes';}	
				if($dir_tags=='yes'){
					register_taxonomy(
					$directory_url.'_tag',
					$directory_url,
					array(
					'label' => esc_html__( 'Tags', 'ivproperty'),
					'rewrite' => array( 'slug' => $directory_url.'_tag' ),
					'description'         => esc_html__( 'Tags', 'ivproperty' ),
					'hierarchical' => true,
					'show_in_rest' =>	true,
					)
					);						
				}
			}		
			public function get_nearest_listing($lat=0,$lng=0,$radius=3){
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				global $wpdb;	
				if($radius==""){$radius='50';}	
				if($lat==""){$lat='0';}	
				if($lng==""){$lng='0';}	
				$dir_search_redius=get_option('_dir_search_redius');
				$for_option_redius='6387.7';	
				if($dir_search_redius=="Miles"){$for_option_redius='3959';}else{$for_option_redius='6387.7'; }
				$results = $wpdb->get_results("SELECT p.*, pm1.meta_value as lat, pm2.meta_value as lon, 
				ACOS(SIN(RADIANS($lat))*SIN(RADIANS(pm1.meta_value))+COS(RADIANS($lat  ))*COS(RADIANS(pm1.meta_value))*COS(RADIANS(pm2.meta_value)-RADIANS($lng))) * ".$for_option_redius." AS distance 
				FROM $wpdb->posts p													
				LEFT JOIN wp_postmeta AS pm1 ON ( p.ID = pm1.post_id AND pm1.meta_key = 'latitude' )
				LEFT JOIN wp_postmeta AS pm2 ON ( p.ID = pm2.post_id AND pm2.meta_key = 'longitude' )								
				WHERE post_type = '".$directory_url."' AND post_status = 'publish'
				HAVING distance <= $radius
				ORDER BY distance ASC;");
				return $results;
			}
			public function iv_property_save_favorite(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);					
				$dir_id=sanitize_text_field($form_data['id']);
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites.', '.get_current_user_id();
				update_post_meta($dir_id,'_favorites',$new_favorites);
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);						
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);
				$new_favorites2=$old_favorites2.', '.$dir_id;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo json_encode(array("msg" => 'success'));
				exit(0);	
			}
			public function iv_property_save_un_favorite(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);					
				$dir_id=sanitize_text_field($form_data['id']);
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites;
				update_post_meta($dir_id,'_favorites',$new_favorites);
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);						
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);
				$new_favorites2=$old_favorites2;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo json_encode(array("msg" => 'success'));
				exit(0);	
			}
			public function iv_property_save_note(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);					
				$dir_id=sanitize_text_field($form_data['id']);
				$note=sanitize_textarea_field($form_data['note']);
				update_post_meta($dir_id,'_note_'.get_current_user_id(),$note);
				echo json_encode(array("msg" => 'success'));
				exit(0);	
			}
			public function iv_property_delete_favorite(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);					
				$dir_id=sanitize_text_field($form_data['id']);						
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites;
				update_post_meta($dir_id,'_favorites',$new_favorites);						
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);						
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);						
				$new_favorites2=$old_favorites2;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo json_encode(array("msg" => 'success'));
				exit(0);
			}
			public function iv_property_message_send(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);					
				include( wp_iv_property_ABSPATH. 'inc/message-mail.php');	
				echo json_encode(array("msg" => 'Message Sent'));
				exit(0);
			}
			public function iv_property_claim_send(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);					
				include( wp_iv_property_ABSPATH. 'inc/claim-mail.php');	
				echo json_encode(array("msg" => 'Message Sent'));
				exit(0);
			}
			public function paging() {
				global $wp_query;
			} 
			public function check_write_access($arg=''){
				global $current_user;
				$userId=$current_user->ID;
				if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
					return true;
				}		
				$package_id=get_user_meta($userId,'iv_property_package_id',true);
				$access=get_post_meta($package_id, 'iv_property_package_'.$arg, true);
				if($access=='yes'){
					return true;
					}else{
					return false;
				}
			} 
			public function check_reading_access($arg='',$id=0){
				global $post;
				global $current_user;
				$userId=$current_user->ID;
				if($id>0){
					$post = get_post($id);
				}	
				if($post->post_author==$userId){
					return true;
				}
				$package_id=get_user_meta($userId,'iv_property_package_id',true);					 
				$access=get_post_meta($package_id, 'iv_property_package_'.$arg, true);
				$active_module=get_option('_iv_property_active_visibility'); 
				if($active_module=='yes' ){		
					if(isset($current_user->ID) AND $current_user->ID!=''){
						$user_role= $current_user->roles[0];
						if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
							return true;
						}																
						}else{							
						$user_role= 'visitor';
					}	
					$store_array=get_option('_iv_visibility_serialize_role');	
					if(isset($store_array[$user_role]))
					{	
						if(in_array($arg, $store_array[$user_role])){
							return true;
							}else{
							return false;
						}
						}else{ 
						return false;
					}
					}else{
					return true;
				}
			}
		}
	}
	if(!class_exists('WP_GeoQuery'))
	{
		/**
			* Extends WP_Query to do geographic searches
		*/
		class WP_GeoQuery extends WP_Query
		{
			private $_search_latitude = NULL;
			private $_search_longitude = NULL;
			private $_search_distance = NULL;
			private $_search_postcats = NULL;
			/**
				* Constructor - adds necessary filters to extend Query hooks
			*/
			public function __construct($args = array())
			{
				// Extract Latitude
				$directory_url=get_option('_iv_property_url');					
				if($directory_url==""){$directory_url='property';}
				if(!empty($args['lat']))
				{
					$this->_search_latitude = $args['lat'];
				}
				// Extract Longitude
				if(!empty($args['lng']))
				{
					$this->_search_longitude = $args['lng'];
				}
				if(!empty($args['distance']))
				{
					$this->_search_distance = $args['distance'];
				}
				if(!empty($args[$directory_url.'-category']))
				{
					$this->_search_postcats= $args[$directory_url.'-category'];
				}
				// unset lat/lng
				unset($args['lat'], $args['lng'],$args['distance']);
				add_filter('posts_fields', array(&$this, 'posts_fields'), 10, 2);
				add_filter('posts_join', array(&$this, 'posts_join'), 10, 2);
				add_filter('posts_where', array(&$this, 'posts_where'), 10, 2);
				add_filter('posts_groupby', array($this, 'posts_groupby'), 10, 2);
				add_filter('posts_orderby', array(&$this, 'posts_orderby'), 10, 2);
				parent::query($args);
				remove_filter('posts_fields', array($this, 'posts_fields'));
				remove_filter('posts_join', array($this, 'posts_join'));
				remove_filter('posts_where', array($this, 'posts_where'));
				remove_filter('posts_groupby', array($this, 'posts_groupby'));
				remove_filter('posts_orderby', array($this, 'posts_orderby'));
			} // END public function __construct($args = array())
			/**
				* Selects the distance from a haversine formula
			*/	
			public function posts_groupby($where) {
				global $wpdb;
				if($this->_search_longitude!=""){
					if($this->_search_postcats!=""){					
						$where .= $wpdb->prepare(" HAVING distance < %d ", $this->_search_distance); 
						}else{									
						$where = $wpdb->prepare("{$wpdb->posts}.ID  HAVING distance < %d ", $this->_search_distance);
					}
				}
				if($this->_search_postcats!=""){
				}	
				return $where;
			}		 
			public function posts_fields($fields)
			{
				global $wpdb;
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude))
				{
					$dir_search_redius=get_option('_dir_search_redius');
					$for_option_redius='6387.7';	
					if($dir_search_redius=="Miles"){$for_option_redius='3959';}else{$for_option_redius='6387.7'; }
					$fields .= sprintf(", ( ".$for_option_redius."* acos( 
					cos( radians(%s) ) * 
					cos( radians( latitude.meta_value ) ) * 
					cos( radians( longitude.meta_value ) - radians(%s) ) + 
					sin( radians(%s) ) * 
					sin( radians( latitude.meta_value ) ) 
					) ) AS distance ", $this->_search_latitude, $this->_search_longitude, $this->_search_latitude);	
					$fields .= ", latitude.meta_value AS latitude ";
					$fields .= ", longitude.meta_value AS longitude ";
				}
				return $fields;
			} // END public function posts_join($join, $query)
			/**
				* Makes joins as necessary in order to select lat/long metadata
			*/		
			public function posts_join($join, $query)
			{
				global $wpdb;
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude)){
					$join .= " INNER JOIN {$wpdb->postmeta} AS latitude ON {$wpdb->posts}.ID = latitude.post_id ";
					$join .= " INNER JOIN {$wpdb->postmeta} AS longitude ON {$wpdb->posts}.ID = longitude.post_id ";
				}
				return $join;
			} // END public function posts_join($join, $query)
			/**
				* Adds where clauses to compliment joins
			*/		
			public function posts_where($where)
			{	
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude)){
					$where .= ' AND latitude.meta_key="latitude" ';
					$where .= ' AND longitude.meta_key="longitude" ';
				}
				return $where;
			} // END public function posts_where($where)
			/**
				* Adds where clauses to compliment joins
			*/	
			public function posts_orderby($orderby)
			{
				if(!empty($this->_search_latitude) && !empty($this->_search_distance))
				{ 
					$orderby = " distance ASC, " . $orderby;
				}			
				return $orderby;
			} // END public function posts_orderby($orderby)
		}
	}
	/*
		* Creates a new instance of the BoilerPlate Class
	*/
	function iv_propertyBootstrap() {
		return wp_iv_property::instance();
	}
iv_propertyBootstrap(); ?>