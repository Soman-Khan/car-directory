<?php
wp_enqueue_style('bootstrap-iv_property-110', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
wp_enqueue_style('iv_property-style-111', wp_iv_property_URLPATH . 'admin/files/css/styles.css');
wp_enqueue_style('cubeportfolio-css-64', wp_iv_property_URLPATH . 'assets/cube/css/cubeportfolio.css');
wp_enqueue_style('font-awesome-ep', wp_iv_property_URLPATH . 'admin/files/css/all.min.css');
global $post,$wpdb,$tag;
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
  $form_action='action="'.get_post_type_archive_link($current_post_type).'"';
}
$search_button_show=get_option('_search_button_show');
if($search_button_show==""){$search_button_show='yes';}
$post_limit='999999';
if(isset($atts['post_limit']) and $atts['post_limit']!="" ){
 $post_limit=$atts['post_limit'];
}	
	$dirs_data =array();
	$tag_arr= array();
	$args = array(
		'post_type' => $directory_url, // enter your custom post type		
		'post_status' => 'publish',		
		'posts_per_page'=> $post_limit,  // overrides posts per page in theme settings
	);
	// Meta Query***********************
		$features = array(
		'relation' => 'AND',
			array(
				'key'     => 'realpro_featured',
				'value'   => 'featured',
				'compare' => 'LIKE'
			),
		);
	$args['meta_query'] = array(
		$features,
	);
$the_query = new WP_Query( $args );
$property_top_1_icon=get_option('property_top_1_icon');	
if($property_top_1_icon==""){$property_top_1_icon='fas fa-home';}
$property_top_2_icon=get_option('property_top_2_icon');	
if($property_top_2_icon==""){$property_top_2_icon='fas fa-bed';}
$property_top_3_icon=get_option('property_top_3_icon');	
if($property_top_3_icon==""){$property_top_3_icon='fas fa-shower';}	
$property_top_4_icon=get_option('property_top_4_icon');	
if($property_top_4_icon==""){$property_top_4_icon='fas fa-expand';}		
$main_class = new wp_iv_property;
$dir_background_color=get_option('dir_background_color');
if($dir_background_color==""){$dir_background_color='#EFEFEF';}
if(isset($atts['background_color']) and $atts['background_color']!="" ){
 $dir_background_color=$atts['background_color'];
}	
$rand_div=rand(10,100);
$active_filter='';
$rent_text='';
?>
<style>
.archieve-page{   
    background:<?php echo esc_html($dir_background_color);?>;
}
</style>
<!-- add font-awesome for using icon -->
<!-- wrap everything for our isolated bootstrap -->
<div class="bootstrap-wrapper">
<!-- archieve page own design font and others -->
<section class="archieve-page py-5">
<!-- sction for sort by catagory -->
<div class="container archieve-page "  >
	  <div class="direc-item">
		<div id="js-grid-featured-<?php echo esc_html($rand_div);?>" class="cbp cbp-l-grid-team" >
		  <?php
		$i=1;
		$dir_popup=get_option('_dir_popup');
		if($dir_popup==""){$dir_popup='yes';}
		 if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
					$id = get_the_ID();
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
						$post_author_id= $post->post_author;
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
											$vip_image= $vip_img[0];
										}
								}else{
									$vip_image= wp_iv_property_URLPATH."/assets/images/vipicon.png";
								}
								}
						}
						?>
					<div class="cbp-item  <?php echo esc_attr($cat_slug); ?>" >
						<div class="card card-border-round bg-white">
							<div class="card-img-container">
							<a href="<?php echo get_the_permalink($id);?>"><img src="<?php echo esc_url($feature_img);?>" class="card-img-top"></a>
							</div>
							<div class="card-img-overlay text-white font-weight-bold">                               
								<?php
									$current_property_status = get_post_meta($id,'property_status',true);
									$rent_text=get_post_meta($id,'price_postfix_text',true). get_post_meta($id,'sale_or_rent_price',true) ;
									if($current_property_status =='For Rent'){
										$rent_text= get_post_meta($id,'price_postfix_text',true). get_post_meta($id,'sale_or_rent_price',true).'/'.get_post_meta($id,'rent_period',true);
									}
									if($current_property_status =='For Sale'){
										$rent_text= get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).'|'. get_post_meta($id,'price_postfix_text',true).get_post_meta($id,'sale_or_rent_price',true);
									}
									if($current_property_status =='Sold'){
										$rent_text= get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).'|'. get_post_meta($id,'price_postfix_text',true).get_post_meta($id,'sale_or_rent_price',true) ;
									}
									echo esc_html($rent_text);
								?>
							</div>
								<?php
								if($vip_image!=''){
								?>
									<div class="card-img-overlay card-img-overlay__img text-white">									
											<img  src="<?php echo esc_url($vip_image); ?>">
									</div>
									<?php
								}
								if(get_post_meta($id,'realpro_featured',true)=="featured"){ ?>
									<div class="overlay_content1">
										<p><?php  esc_html_e('Featured', 'ivproperty' ); ?></p>
									</div>
								<?php
								}
								?>
							<div class="card-body px-4 mt-0 card-body-min-height">
								<a href="<?php echo get_permalink($id); ?>" class="cbp-caption cbp-l-grid-projects-title mt-0" ><p class="realtitle m-0 p-0"><?php echo esc_html($post->post_title);?></p></a>
								<p class="card-text p-0 m-0 address"><?php echo get_post_meta($id,'address',true);?> <?php echo get_post_meta($id,'city',true);?> <?php echo get_post_meta($id,'zipcode',true);?> <?php echo get_post_meta($id,'country',true);?></p>
								<p class="mt-2 short-desc">
									<?php
									if(get_post_meta($id,'area',true)!=""){ ?>
											<i class="<?php echo esc_html($property_top_4_icon);?> fa-xs ml-1"></i><span class="ml-1"> <?php
											echo get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).' ';
											?></span>
									<?php
									}
									?>
									<?php
									if(get_post_meta($id,'bedrooms',true)!=""){ ?>
									<i class="<?php echo esc_html($property_top_2_icon);?> fa-xs ml-1"></i> <span class="ml-1"> <?php
									echo get_post_meta($id,'bedrooms',true);
									?><?php  esc_html_e(' Bedrooms','ivproperty'); ?></span>
									<?php
										}
									?>
									<?php
									if(get_post_meta($id,'bathrooms',true)!=""){ ?>
									<i class="<?php echo esc_html($property_top_3_icon);?> fa-xs ml-1"></i><span class="ml-1"><?php
									echo get_post_meta($id,'bathrooms',true);
									?><?php  esc_html_e(' Baths ','ivproperty'); ?></span>
									<?php
										}
									?>
									<?php
									if(trim(get_post_meta($id,'garages',true))!=""){ ?>
									<i class="fas fa-car fa-xs ml-1"></i> <span class="ml-1"> <?php
									echo get_post_meta($id,'garages',true);
									?><?php  esc_html_e(' Garage ','ivproperty'); ?></span>
									<?php
										}
									?>
									<?php
									if(get_post_meta($id,'guest',true)!=""){ ?>
									<i class="fas fa-user fa-xs ml-1"></i> <span class="ml-1"> <?php
									echo get_post_meta($id,'guest',true);
									?><?php  esc_html_e(' Guest ','ivproperty'); ?></span>
									<?php
										}
									?>
								</p>
								<p class="mt-0"><?php echo ucfirst($cat_name2).' '.$current_property_status; ?></p>
								<p class="d-flex mt-2">
									<span class="review">
									 <?php
								$dir_single_review_show=get_option('_dir_single_review_show');
								if($dir_single_review_show==""){$dir_single_review_show='yes';}
								if($dir_single_review_show=='yes'){
								$total_reviews_point = $wpdb->get_col($wpdb->prepare("SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm
								 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
								 WHERE pm.meta_key = 'review_value'
								 AND p.post_status = 'publish'
								 AND p.post_type = 'realpro_review' AND p.post_author = '%d'",$id ));
									$argsreviw = array( 'post_type' => 'realpro_review','author'=>$id,'post_status'=>'publish' );
									$ratings = new WP_Query( $argsreviw );
									$total_review_post = $ratings->post_count;
									$avg_review=0;
									if(isset($total_reviews_point[0])){
										$avg_review= (int)$total_reviews_point[0]/(int)$total_review_post;
									}
									?>
										<i class="far fa-star fa-xs <?php echo ($avg_review>0?'black-star': 'white-star');?>"></i>
										<i class="far fa-star fa-xs <?php echo ($avg_review>=2?'black-star': 'white-star');?>"></i>
										<i class="far fa-star fa-xs <?php echo ($avg_review>=3?'black-star': 'white-star');?>"></i>
										<i class="far fa-star fa-xs <?php echo ($avg_review>=4?'black-star': 'white-star');?>"></i>
										<i class="far fa-star fa-xs <?php echo ($avg_review>=5?'black-star': 'white-star');?>"></i>
									 <div class="cbp-l-grid-projects-review none" ><?php echo esc_html($avg_review);?></div>
									<?php
								}
							 ?>
									</span>
								</p>
							</div>
								<div class="cbp-l-grid-projects-date none" ><?php echo strtotime($post->post_date);?></div>
								<div class="cbp-l-grid-projects-price none" ><?php echo get_post_meta($id,'area',true);?></div>
								<div class="cbp-l-grid-projects-size none" ><?php echo get_post_meta($id,'sale_or_rent_price',true);?></div>
						</div>
					</div>
				<?php
				$i++;
		endwhile;
			?>
		  <?php endif; ?>
		</div>
	  </div>
 </div>
</section>
<!-- end of arhiece page -->
</div>
<!-- end of bootstrap wrapper -->
<?php
wp_enqueue_script("jquery");
$grid_col1500=get_option('grid_col1500');
if($grid_col1500==""){$grid_col1500='5';}
$grid_col1100=get_option('grid_col1100');
if($grid_col1100==""){$grid_col1100='3';}
$grid_col768=get_option('grid_col768');
if($grid_col768==""){$grid_col768='3';}
$grid_col480=get_option('grid_col480');
if($grid_col480==""){$grid_col480='2';}
$grid_col375=get_option('grid_col375');

	wp_enqueue_script('iv_property-ar-script-23', wp_iv_property_URLPATH . 'assets/cube/js/jquery.cubeportfolio.min.js');	
	wp_enqueue_script('iv_property-ar-script-featured'.$rand_div, wp_iv_property_URLPATH . 'admin/files/js/featured.js');
	wp_localize_script('iv_property-ar-script-featured'.$rand_div, 'realpro_featured', array(
		'ajaxurl' 				=> 	admin_url( 'admin-ajax.php' ),
		'loading_image'		=> 	'<img src="'.wp_iv_property_URLPATH.'admin/files/images/loader.gif">',
		'current_user_id'	=>	get_current_user_id(),
		'script_src'			=>	wp_iv_property_URLPATH . 'assets/cube/js/jquery.cubeportfolio.min.js',
		'rand_div'				=> 	$rand_div,
		'grid_col1500'		=>	$grid_col1500,
		'grid_col1100'		=>	$grid_col1100,
		'grid_col768'			=>	$grid_col768,
		'grid_col480'			=>	$grid_col480,
		'grid_col375'			=>	$grid_col375,
		
		) );
	?>	