<?php
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'Are you cheating:user Permission?' );
}
global $current_user; global $wpdb;	
$directory_url=get_option('_iv_property_url');					
if($directory_url==""){$directory_url='property';}
	$post_names = array('9615 Shore Rd Apt 3W','610 FIFTH AVENUE','200 E 94th St Apt 23012','1280 W 2nd St','4430 2nd St Sw','315 White Swan Dr', '302 Apartments Of Type A');
	$post_cat = array('Apartment','Apartment Building','Condominium','Family Home','Office','Shop','Villa');	
	$post_tag = array('BALCONY','Indoor Pool','Central Cooling','Private Garden','Swing Pool','Central Heating','Dishwasher','Driver’s room','Fire Place','Parking','Wheelchair Accessible');
	$post_city = array('New York ','new york ','dubai','Dubai','Bretagne','New South Wales','London');	
	$post_aear = array('Central Brooklyn','Chelsea','Midtown','Shoreditch' , 'Upper Manhattan');
$i=0;	
	foreach($post_names as $one_post){ 
	$my_post = array();
	$my_post['post_title'] = $one_post;
	$my_post['post_content'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, ';	
	$my_post['post_status'] = 'publish';	
	$my_post['post_type'] = $directory_url;	
	$newpost_id= wp_insert_post( $my_post );		
	update_post_meta($newpost_id, 'property_status', 'For Sale'); 
	$rand_keys = array_rand($post_cat, 2);	
	$new_post_arr=array();
	$new_post_arr[]=$post_cat[$rand_keys[0]];
	$new_post_arr[]=$post_cat[$rand_keys[1]];
	wp_set_object_terms( $newpost_id, $new_post_arr, $directory_url.'-category');	
	$default_fields = array();
	$field_set=get_option('iv_directories_fields' );
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
			update_post_meta($newpost_id, $field_key, 'lorem ipsum' );							
		}					
	}
	// For Tag Save tag_arr	
	$rand_keys = array_rand($post_tag, 6);	
	$new_post_arr=array();
	$new_post_arr[]=$post_tag[$rand_keys[0]];
	$new_post_arr[]=$post_tag[$rand_keys[1]];
	$new_post_arr[]=$post_tag[$rand_keys[2]];
	$new_post_arr[]=$post_tag[$rand_keys[3]];
	$new_post_arr[]=$post_tag[$rand_keys[4]];
	$new_post_arr[]=$post_tag[$rand_keys[5]];
	wp_set_object_terms( $newpost_id, $new_post_arr, $directory_url.'_tag');	
	update_post_meta($newpost_id, 'address', '129-133 West 22nd Street'); 
	$rand_keys = array_rand($post_aear, 1);	
	update_post_meta($newpost_id, 'local-area', $post_aear[$rand_keys]); 
	update_post_meta($newpost_id, 'latitude', '40.7427704'); 
	update_post_meta($newpost_id, 'longitude','-73.99455039999998');
	$rand_keys = array_rand($post_city, 1);		
	update_post_meta($newpost_id, 'city', $post_city[$rand_keys]); 
	update_post_meta($newpost_id, 'postcode', '10011'); 
	update_post_meta($newpost_id, 'country', 'USA'); 
	update_post_meta($newpost_id, 'phone', '212245-4606'); 
	update_post_meta($newpost_id, 'fax', '212245-4606'); 
	update_post_meta($newpost_id, 'contact-email', 'test@test.com'); 
	update_post_meta($newpost_id, 'contact_web', 'e-plugin.com'); 
	update_post_meta($newpost_id, 'listing_contact_source', 'new_value'); 	
	update_post_meta($newpost_id, 'youtube', '0y4rXoWrJlw'); 
	update_post_meta($newpost_id, 'facebook', 'test'); 
	update_post_meta($newpost_id, 'linkedin', 'test'); 
	update_post_meta($newpost_id, 'twitter', 'test');	
	update_post_meta($newpost_id, 'instagram', 'test');
	update_post_meta($newpost_id, 'youtube_social', 'test');
	update_post_meta($newpost_id, 'bedrooms', '4'); 
	update_post_meta($newpost_id, 'bathrooms', '3');
	update_post_meta($newpost_id, 'guest', '1'); 
	update_post_meta($newpost_id, 'garages', '2'); 
	update_post_meta($newpost_id, 'sale_or_rent_price', '5210641'); 
	update_post_meta($newpost_id, 'price_postfix_text','$'); 
	update_post_meta($newpost_id, 'area', '6000'); 
	update_post_meta($newpost_id, 'area_postfix_text', 'SFT'); 
	update_post_meta($newpost_id, 'rent_period', ''); 
 $i++; 
}
?>