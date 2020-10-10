<?php
$directory_url=get_option('_iv_property_url');
if($directory_url==""){$directory_url='property';}
	$features = array(
		'relation' => 'AND',
			array(
				'key'     => 'realpro_featured',
				'value'   => 'featured',
				'compare' => 'LIKE'
			),
		);
$feature_listing_all['posts_per_page']='-1';
$feature_listing_all['meta_query'] = array(
		$city_mq, $country_mq, $zip_mq,$features,$area_mq,
	);
$feature_listing = new WP_Query( $feature_listing_all ); 
$property_top_1_icon=get_option('property_top_1_icon');	
if($property_top_1_icon==""){$property_top_1_icon='fas fa-home';}
$property_top_2_icon=get_option('property_top_2_icon');	
if($property_top_2_icon==""){$property_top_2_icon='fas fa-bed';}
$property_top_3_icon=get_option('property_top_3_icon');	
if($property_top_3_icon==""){$property_top_3_icon='fas fa-shower';}	
$property_top_4_icon=get_option('property_top_4_icon');	
if($property_top_4_icon==""){$property_top_4_icon='fas fa-expand';}		
 if ( $feature_listing->have_posts() ) : 
	while ( $feature_listing->have_posts() ) : $feature_listing->the_post();
				$dir_data=array();
				$id = get_the_ID();
				$dir_data['featured']='Featured';
				$dir_data['id']=$id;
				$dir_data['link']=get_permalink($id);
				$dir_data['title']=$post->post_title;
				$feature_img='';
				if(has_post_thumbnail()){
					$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
					if($feature_image[0]!=""){
						$feature_img =$feature_image[0];
					}
				}else{
					$feature_img= wp_iv_property_URLPATH."/assets/images/default-directory.jpg";
				}
				$dir_data['imageURL']=  $feature_img;
				$cat_arr=array();
				$currentCategory=wp_get_object_terms( $id, $directory_url.'-category');
					$cat_name2='';
					if(isset($currentCategory[0]->slug)){
						$cat_name2 = $currentCategory[0]->name;
						$cc=0;
						foreach($currentCategory as $c){
							$cat_arr[]=ucfirst($c->name);
						}
					}
				$dir_data['category']=$cat_arr;
					$dir5_review_show=get_option('dir5_review_show');
					if($dir5_review_show==""){$dir5_review_show='yes';}
					if($dir5_review_show=='yes'){
						$dir_data['review_show']='yes';
						$total_reviews_point = $wpdb->get_col($wpdb->prepare("SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm
						 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
						 WHERE pm.meta_key = 'review_value'
						 AND p.post_status = 'publish'
						 AND p.post_type = 'realpro_review' AND p.post_author = '%s'", $id));
						$argsreviw = array( 'post_type' => 'realpro_review','author'=>$id,'post_status'=>'publish' );
						$ratings = new WP_Query( $argsreviw );						
						$total_review_post = $ratings->post_count;
						$avg_review=0;
						if(isset($total_reviews_point[0])){
							$avg_review= (float)$total_reviews_point[0]/(float)$total_review_post;
						}
						$dir_data['avg_review']=$avg_review;
						if($avg_review>=1){
							if($avg_review==1){
								$dir_data['review']=(int)$avg_review.esc_html__(' Star','ivproperty');
							}
							if($avg_review>1){
								$dir_data['review']=(int)$avg_review.esc_html__(' Stars','ivproperty');
							}
						}else{						
						}
					}else{
						$dir_data['review_show']='no';
					}
					$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
					if($listing_contact_source==''){$listing_contact_source='new_value';}
					$dir_data['phone']='';
					if($listing_contact_source=='new_value'){
						$dir_data['phone']=	get_post_meta($id,'phone',true);
						$dir_data['email']=get_post_meta($id,'email',true);	
					}else{
						$post_author_id= get_post_field( 'post_author', $id );
						$agent_info = get_userdata($post_author_id);
						if(get_user_meta($post_author_id,'phone',true)!=""){
							$dir_data['phone']=	get_user_meta($post_author_id,'phone',true);
						}						
						$dir_data['email']=$agent_info->user_email;	
					}
					$dir_style5_call=get_option('dir_style5_call');	
					if($dir_style5_call==""){$dir_style5_call='yes';}
					$dirpro_call_button=get_post_meta($id,'dirpro_call_button',true);
					if($dirpro_call_button==""){$dirpro_call_button='yes';}
					if($dir_style5_call=="yes" AND $dirpro_call_button=='yes'){
						$dir_data['call_button']='yes';	
						if($dir_data['phone']==''){$dir_data['call_button']='no';}		
					}else{
						$dir_data['call_button']='no';
					}	
					$dir_style5_email=get_option('dir_style5_email');	
					if($dir_style5_email==""){$dir_style5_email='yes';}
					$dirpro_email_button=get_post_meta($id,'dirpro_email_button',true);
					if($dirpro_email_button==""){$dirpro_email_button='yes';}
					if($dir_style5_email=="yes" AND $dirpro_email_button=='yes'){
						$dir_data['email_button']='yes';						
					}else{
						$dir_data['email_button']='no';
					}	
					$dir_style5_sms=get_option('dir_style5_sms');	
					if($dir_style5_sms==""){$dir_style5_sms='yes';}
					$dirpro_sms_button=get_post_meta($id,'dirpro_sms_button',true);
					if($dirpro_sms_button==""){$dirpro_sms_button='yes';}
					if($dir_style5_sms=="yes" AND $dirpro_sms_button=='yes'){
						$dir_data['sms_button']='yes';	
						if($dir_data['phone']==''){$dir_data['sms_button']='no';}	
					}else{
						$dir_data['sms_button']='no';
					}	
					$loc_arr=array();
						$dir_data['address']= get_post_meta($id,'address',true);
						if(get_post_meta($id,'area',true)!=""){							
							$dir_data['area']= get_post_meta($id,'area',true);								
						}	
						$dir_data['city']=ucfirst( get_post_meta($id,'city',true));
						if(trim(get_post_meta($id,'city',true))!=""){							
							array_push( $loc_arr, get_post_meta($id,'city',true) );
						}	
						$dir_data['state']= get_post_meta($id,'state',true);
					
						$dir_data['zipcode']= ucfirst(get_post_meta($id,'postcode',true));
					
						$dir_data['country']= get_post_meta($id,'country',true);
					
					if (!empty($loc_arr)) {
						$dir_data['location']=  $loc_arr;
					}
					// Tag***
					$tagg_arr=array();
					$dir_tags=get_option('_dir_tags');	
					if($dir_tags==""){$dir_tags='yes';}	
					if($dir_tags=="yes"){
						$tag_array= wp_get_object_terms( $id,  $directory_url.'_tag');	
						foreach($tag_array as $one_tag){							
							if(isset($one_tag->name)){$tagg_arr[]=ucfirst($one_tag->name); }
						}
					}else{
						$tag_array= wp_get_post_tags( $id );
						foreach($tag_array as $one_tag){							
							if(isset($one_tag->name)){$tagg_arr[]=ucfirst($one_tag->name); }
						}		
					}					
					if (!empty($tagg_arr)) { 
						$dir_data['feature']=  $tagg_arr;
					}	
					// End tag***
					// Price
					$current_property_status = get_post_meta($id,'property_status',true);
					$rent_text=get_post_meta($id,'price_postfix_text',true). number_format((int)get_post_meta($id,'sale_or_rent_price',true)).' '.get_post_meta($id,'rent_period',true) ;					
					$dir_data['price']= $rent_text;
					$dir_data['type']=$current_property_status;
					if(get_post_meta($id,'area',true)!=""){ 
						$dir_data['area']= get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).' ';
					}
					if(get_post_meta($id,'bedrooms',true)!=""){ 
						$dir_data['bedrooms']= get_post_meta($id,'bedrooms',true).esc_html__(' Bed','ivproperty');
					}
					if(get_post_meta($id,'bathrooms',true)!=""){
						$dir_data['bathrooms']=get_post_meta($id,'bathrooms',true). esc_html__(' Bath ','ivproperty');									
					}
					if(trim(get_post_meta($id,'garages',true))!=""){
						$dir_data['garages']= get_post_meta($id,'garages',true). esc_html__(' Garage ','ivproperty');
					}
					if(get_post_meta($id,'guest',true)!=""){
						$dir_data['guest']= get_post_meta($id,'guest',true).esc_html__(' Guest ','ivproperty'); 
					}
			array_push( $dirs_data, $dir_data );
	endwhile; 	
 endif; ?>