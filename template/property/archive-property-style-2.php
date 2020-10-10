<?php
	global $post,$wpdb,$tag;
	wp_enqueue_script("jquery");
	wp_enqueue_style('bootstrap-iv_property-110', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	wp_enqueue_style('iv_directories-style-listing_style_5', wp_iv_property_URLPATH . 'admin/files/css/listing_style_5.css');
	wp_enqueue_style('bootstrap-tagsinput', wp_iv_property_URLPATH . 'admin/files/css/bootstrap-tagsinput.css');
	wp_enqueue_style('all', wp_iv_property_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_style('jquery-ui', wp_iv_property_URLPATH . 'admin/files/css/jquery-ui.css');
	
	wp_enqueue_style('colorbox', wp_iv_property_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_script('colorbox', wp_iv_property_URLPATH . 'admin/files/js/jquery.colorbox-min.js');	
	
	$dir_style_font=get_option('dir_style_font');
	if($dir_style_font==""){$dir_style_font='no';}
	if($dir_style_font=='yes'){
		wp_enqueue_style('iv_property-font-110', wp_iv_property_URLPATH . 'admin/files/css/quicksand-font.css');	
	}
	$directory_url=get_option('_iv_property_url');
	if($directory_url==""){$directory_url='property';}
	$current_post_type=$directory_url;
	$form_action='';
	if ( is_front_page() ) {
		$form_action='action='.get_post_type_archive_link($current_post_type).'';
		}
	$locations='';
	$pos='';
	$dirsearch='';
	$dirsearchtype='';
	$locationtype='';
	$location='';
	if(isset($_REQUEST['dirsearchtype'])){
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
		$dirsearchtype=sanitize_text_field($_REQUEST['dirsearchtype']);
		$locationtype=sanitize_text_field($_REQUEST['locationtype']);
		$location=sanitize_text_field($_REQUEST['location']);
	}
	$main_class = new wp_iv_property;
	$dir5_background_color=get_option('dir5_background_color');
	if($dir5_background_color==""){$dir5_background_color='#EBEBEB';}
	$dir5_content_color=get_option('dir5_content_color');
	if($dir5_content_color==""){$dir5_content_color='#fff';}
	if(isset($atts['main_background_color'])){
		$dir5_background_color=$atts['main_background_color'];
		if($dir5_background_color==""){$dir5_background_color='#EBEBEB';}
	}
	if(isset($atts['text_background_color'])){
		$dir5_content_color=$atts['text_background_color'];
		if($dir5_content_color==""){$dir5_content_color='#fff';}
	}
?>
<style>
	.fa{ 
    font: normal normal normal 14px/1 FontAwesome !important;   
	}
	.item{
	background:<?php echo esc_html($dir5_content_color);?>!important;
	}
	.facet-parent {
	background:<?php echo esc_html($dir5_content_color);?>!important;
	}
	.bootstrap-wrapper, .bg{
	background:<?php echo esc_html($dir5_background_color);?> !important;
	}
</style>
  
<div class="bootstrap-wrapper">
	<div class="container">
		<section class="whole-container">
			<div class="row bottomline-parent">
				<div class="col-lg-4 facet-parent h-50 mh-auto">
					<form method="POST" role="form" <?php echo esc_html($form_action);?> >
						<div class="row px-0 m-0">
							<div class="form-group col-sm-12 mt-4 mt-md-5 px-0">
								<div class="inner-addon left-addon mx-0 d-flex align-items-center">
									<span class="glyphicon"><i class="fas fa-search"></i></span>
									<input type="text"  value="<?php echo esc_html($dirsearch);?>" class="" id="dirsearch" name="dirsearch" placeholder="<?php  esc_html_e('Search','ivproperty');?>"/>
									<input type="hidden"  value="<?php echo esc_html($dirsearchtype);?>"  id="dirsearchtype" name="dirsearchtype"/>					
								</div>                            
							</div>
							<div class="form-group col-sm-12  px-0">
								<div class="inner-addon right-addon d-flex align-items-center">
									<span class="glyphicon"><i class="fas fa-map-marker-alt"></i></span>
									<input type="text" class="" value="<?php echo esc_html($location);?>" placeholder="<?php   esc_html_e('Location','ivproperty');?>" id="location" name="location"  />
									<input type="hidden"  value="<?php echo esc_html($locationtype);?>"  id="locationtype" name="locationtype"/>
								</div>
							</div>
						</div>
						<input id="submitbtn" type="submit" name="top-search" value="<?php   esc_html_e('Search','ivproperty');?>" class="btn btn-block">
					</form>
					<div class="filter">
						<?php    esc_html_e('Filter Search','ivproperty');?> <i class="fas fa-align-left"></i>
					</div>
					<div id=facets></div>
				</div>
				<div class="col-lg-8 result-parent">
					<div id=results></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
	$dirs_data=array();
	$tag_arr= array();
	$args = array(
	'post_type' => $directory_url, // enter your custom post type
	'post_status' => 'publish',
	'posts_per_page'=> '-1',
	'orderby' => 'title',
	'order' => 'ASC',
	);
	$dirsearch='';
	$dirsearchtype='';
	$locationtype='';
	$location='';
	if(isset($_REQUEST['dirsearchtype'])){
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
		$dirsearchtype=sanitize_text_field($_REQUEST['dirsearchtype']);
		$locationtype=sanitize_text_field($_REQUEST['locationtype']);
		$location=sanitize_text_field($_REQUEST['location']);
	}
		
	$dir_facet_title=get_option('dir_facet_cat_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','ivproperty');}
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		$args[$directory_url.'-category']=$dirsearch;
	}
	$dir_facet_title=get_option('dir_facet_features_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivproperty');}
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		$args[$directory_url.'_tag']=$dirsearch;
	}
	$dir_facet_title= esc_html__('Title','ivproperty');
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		$args['s']= $dirsearch;
	}
	$dir_facet_title=get_option('dir_facet_location_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('City','ivproperty');}
	$city_mq ='';
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$city_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'city',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	$area_mq='';
	$dir_facet_title=get_option('dir_facet_area_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','ivproperty');}
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$area_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'area',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	$country_mq='';
	$zip_mq='';
	$dir_facet_title=get_option('dir_facet_zipcode_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','ivproperty');}
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$zip_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'postcode',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	if(isset($atts['category']) and $atts['category']!="" ){
		$postcats = $atts['category'];
		$args[$directory_url.'-category']=$postcats;
	}
	if(get_query_var($directory_url.'-category')!=''){
		$postcats = get_query_var($directory_url.'-category');
		$args[$directory_url.'-category']=$postcats;
		$selected=$postcats;
		$search_show=1;
	}
	if( isset($_POST[$directory_url.'-category'])){
		if($_POST[$directory_url.'-category']!=''){
			$postcats = sanitize_text_field($_POST[$directory_url.'-category']);
			$args[$directory_url.'-category']=$postcats;
			$selected=$postcats;
		}
	}
	if(get_query_var($directory_url.'_tag')!=''){
		$postcats = get_query_var($directory_url.'_tag');
		$args[$directory_url.'_tag']=$postcats;			
		$search_show=1;
	}	
	if( isset($_REQUEST['keyword'])){
		if($_REQUEST['keyword']!=""){
			$args['s']= sanitize_text_field($_REQUEST['keyword']);
			$keyword_post=sanitize_text_field($_REQUEST['keyword']);
			$search_show=1;
		}
	}
	if( isset($_REQUEST['tag_arr'])){
		if($_REQUEST['tag_arr']!=""){
			$tag_arr= sanitize_text_field($_REQUEST['tag_arr']);		
			$tags_string= implode("+", $tag_arr);
			$args['tag']= $tags_string;
		}
	}
	// Meta Query***********************
	$city_mq2 ='';
	if(isset($_REQUEST['dir_city']) AND $_REQUEST['dir_city']!=''){
		$city_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'city',
		'value'   => sanitize_text_field($_REQUEST['dir_city']),
		'compare' => 'LIKE'
		),
		);
	}
	$country_mq2='';
	if(isset($_REQUEST['dir_country']) AND $_REQUEST['dir_country']!=''){
		$country_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'country',
		'value'   => sanitize_text_field($_REQUEST['dir_country']),
		'compare' => 'LIKE'
		),
		);
	}
	$zip_mq2='';
	if(isset($_REQUEST['zipcode']) AND $_REQUEST['zipcode']!=''){
		$zip_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'postcode',
		'value'   => sanitize_text_field($_REQUEST['zipcode']),
		'compare' => 'LIKE'
		),
		);
	}
	$property_status='';
	if( isset($_REQUEST['property-type'])){
		$property_status_re=sanitize_text_field($_REQUEST['property-type']);
		if($_REQUEST['property-type']!=""){
				$property_status = array(
				'relation' => 'AND',
					array(
						'key'     => 'property_status',
						'value'   => sanitize_text_field($_REQUEST['property-type']),
						'compare' => 'LIKE'
					),
				);
		}
	}
	if( isset($atts['property-type'])){
		$property_status_re=$atts['property-type'];
		if($atts['property-type']!=""){
				$property_status = array(
				'relation' => 'AND',
					array(
						'key'     => 'property_status',
						'value'   => sanitize_text_field($atts['property-type']),
						'compare' => 'LIKE'
					),
				);
		}
	}
	// For featrue listing***********
	$feature_listing_all =array();
	$feature_listing_all =$args;
	$args['meta_query'] = array(
	$city_mq,$property_status, $country_mq, $zip_mq,$area_mq,$city_mq2, $country_mq2, $zip_mq2,
	);
	include( wp_iv_property_template. 'property/archive_feature_listing2.php');
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();
	$dir_data=array();
	$id = get_the_ID();
	if(get_post_meta($id, 'realpro_featured', true)!='featured'){
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
			$feature_img= wp_iv_property_URLPATH."assets/images/default-directory.jpg";
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
		$phone='';
		$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
		if($listing_contact_source==''){$listing_contact_source='new_value';}
		$dir_data['phone']='';
		if($listing_contact_source=='new_value'){
			$dir_data['phone']=	get_post_meta($id,'phone',true);
			$phone=get_post_meta($id,'phone',true);
			$dir_data['email']=get_post_meta($id,'email',true);
			$contact_web=get_post_meta($id,'contact_web',true);
			$contact_web=str_replace('https://','',$contact_web);
			$contact_web=str_replace('http://','',$contact_web);
			$dir_data['web']=	esc_url($contact_web);
			}else{
			$post_author_id= get_post_field( 'post_author', $id );
			$agent_info = get_userdata($post_author_id);
			if(get_user_meta($post_author_id,'phone',true)!=""){
				$dir_data['phone']=	get_user_meta($post_author_id,'phone',true);
				$phone=get_user_meta($post_author_id,'phone',true);
			}
			$contact_web=get_user_meta($post_author_id,'web_site',true);
			$contact_web=str_replace('https://','',$contact_web);
			$contact_web=str_replace('http://','',$contact_web);
			$dir_data['web']=	esc_url($contact_web);
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
			if($phone==''){$dir_data['sms_button']='no';}
			}else{
			$dir_data['sms_button']='no';
		}
		$loc_arr=array();
		$dir_data['address']= get_post_meta($id,'address',true);
		$dir_data['city']=ucfirst( get_post_meta($id,'city',true));
		if(trim(get_post_meta($id,'city',true))!=""){
			array_push( $loc_arr, get_post_meta($id,'city',true) );
			$dir_data['location']=ucwords(strtolower(trim(get_post_meta($id,'city',true))));
		}
		$dir_data['state']= get_post_meta($id,'state',true);
		if(get_post_meta($id,'postcode',true)!=''){
			$dir_data['zipcode']= ucwords(strtolower(trim(get_post_meta($id,'postcode',true))));
		}
		if(get_post_meta($id,'local-area',true)!=''){
			$dir_data['local-area']= ucwords(strtolower(trim(get_post_meta($id,'local-area',true))));
		}
		$dir_data['country']= get_post_meta($id,'country',true);
		if (!empty($loc_arr)) {
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
		// Price
		$current_property_status = get_post_meta($id,'property_status',true);
		$rent_text=get_post_meta($id,'price_postfix_text',true).  number_format((int)str_replace(",", "", get_post_meta($id,'sale_or_rent_price',true))) ;					
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
	}
	endwhile;
	endif;
	$dirs_data_json= json_encode($dirs_data);
	$facets = array();
	
	$dir_facet_show=get_option('dir_facet_type_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_type_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Type','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['type']=$dir_facet_title;
	}

	$dir_facet_show=get_option('dir_facet_cat_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_cat_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['category']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_location_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_location_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('City','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['location']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_area_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_area_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['local-area']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_zipcode_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_zipcode_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['zipcode']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_features_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_features_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['feature']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_bed_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_bed_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Beds','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['bedrooms']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_bath_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_bath_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Baths','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['bathrooms']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_review_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_review_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Reviews','ivproperty');}
	if($dir_facet_show=="yes"){
		$facets['review']=$dir_facet_title;
	}
?>
<?php
	
	$facets_json= json_encode($facets);
	$property_top_1_icon=get_option('property_top_1_icon');	
	if($property_top_1_icon==""){$property_top_1_icon='fas fa-home';}
	$property_top_2_icon=get_option('property_top_2_icon');	
	if($property_top_2_icon==""){$property_top_2_icon='fas fa-bed';}
	$property_top_3_icon=get_option('property_top_3_icon');	
	if($property_top_3_icon==""){$property_top_3_icon='fas fa-shower';}	
	$property_top_4_icon=get_option('property_top_4_icon');	
	if($property_top_4_icon==""){$property_top_4_icon='fas fa-expand';}		
	$dir_style5_perpage=get_option('dir_style5_perpage');
	if($dir_style5_perpage==""){$dir_style5_perpage=20;}
	wp_enqueue_script('jquery-ui', wp_iv_property_URLPATH . 'admin/files/js/jquery-ui.min.js');
	wp_enqueue_script('underscore-1.1.7', wp_iv_property_URLPATH . 'admin/files/js/underscore-1.1.7.js');
	wp_enqueue_script('popper', wp_iv_property_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('bootstrap.min-4-script-24', wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_script('iv_directory-ar-script-30', wp_iv_property_URLPATH . 'admin/files/js/facetedsearch.js');
	wp_localize_script('iv_directory-ar-script-30', 'dirpro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loadmore'=>esc_html__('Load More','ivproperty'),
	'featured'=>esc_html__('featured','ivproperty'),
	'featured'=>esc_html__('featured','ivproperty'),
	'email'=>esc_html__('Email','ivproperty'),
	'SMS'=>esc_html__('SMS','ivproperty'),
	'message'=>esc_html__('Please put your name,email & content','ivproperty'),
	'detail'=>esc_html__('Detail','ivproperty'),
	'web'=>esc_html__('Web','ivproperty'),
	'title'=>esc_html__('Title','ivproperty'),
	'category'=>esc_html__('Category','ivproperty'),
	'random'=>esc_html__('Random','ivproperty'),	
	'nolisting'=>esc_html__("Sorry, but no items match these criteria",'ivproperty'),
	'Sortby'=>esc_html__("Sort by",'ivproperty'),
	'Results'=>esc_html__("Results",'ivproperty'),
	'Deselect'=>esc_html__("Deselect all filters",'ivproperty'),
	'perpage'=>$dir_style5_perpage,
	) );
	wp_enqueue_script('iv_directory-ar-script-27', wp_iv_property_URLPATH . 'admin/files/js/archive-listing5.js');
	wp_localize_script('iv_directory-ar-script-27', 'dirpro_data2', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_property_URLPATH.'admin/files/images/loader.gif">',
	'wp_iv_property_URLPATH'		=> wp_iv_property_URLPATH,
	'current_user_id'	=>get_current_user_id(),
	'facets_json'		=>$facets_json,
	'dirpro_items'		=>$dirs_data_json,
	'call'		=>esc_html__('Call','ivproperty'),
	'featured'=>esc_html__('featured','ivproperty'),
	'email'=>esc_html__('Email','ivproperty'),
	'SMS'=>esc_html__('SMS','ivproperty'),
	'message'=>esc_html__('Please put your name,email & content','ivproperty'),
	'detail'=>esc_html__('Detail','ivproperty'),
	'web'=>esc_html__('Web','ivproperty'),
	'title'=>esc_html__('Title','ivproperty'),
	'category'=>esc_html__('Category','ivproperty'),
	'random'=>esc_html__('Random','ivproperty'),	
	'perpage'=>$dir_style5_perpage,
	'property_top_2_icon'=>$property_top_2_icon,
	'property_top_3_icon'=>$property_top_3_icon,
	'property_top_4_icon'=>$property_top_4_icon,	
	'pos'=>$pos,
	'locations'=>$locations,
	'SMSbody'=>esc_html__('I would like to inquire about the listing. The listing can be found on the site :','ivproperty').site_url(),
	'contact'=> wp_create_nonce("contact"),
	) );
	$pos = $main_class->get_unique_search_values('all',$current_post_type);
	$locations = $main_class->get_unique_location_values('all',$current_post_type);
?>
<script>
	jQuery( function() {
		jQuery.widget( "custom.catcomplete", jQuery.ui.autocomplete, {
			_create: function() {
				this._super();
				this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
			},
			_renderMenu: function( ul, items ) {
				var that = this,
				currentCategory = "";
				jQuery.each( items, function( index, item ) {
					var li;
					if ( item.category != currentCategory ) {
						ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
						currentCategory = item.category;
					}
					li = that._renderItemData( ul, item );
					if ( item.category ) {
						li.attr( "aria-label", item.category + " : " + item.label );
					}
				});
			}
		});
		var data =<?php echo $pos;?>;
		jQuery( "#dirsearch" ).catcomplete({
			delay: 0,
			minLength: 0,
			source: data,
			select: function(e, ui) {
				jQuery( "#dirsearchtype" ).val(ui.item.category);
			}
		});
		var data =<?php echo $locations;?>;
		jQuery( "#location" ).catcomplete({
			delay: 0,
			minLength: 0,
			source: data,
			select: function(e, ui) {
				jQuery( "#locationtype" ).val(ui.item.category);
			}
		});
	} );
</script>