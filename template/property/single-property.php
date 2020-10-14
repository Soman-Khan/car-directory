<?php
	get_header();
		wp_enqueue_script('jquery');
	wp_enqueue_style('bootstrap-iv_property-110', 			wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	wp_enqueue_style('iv_property-style-111', 			wp_iv_property_URLPATH . 'admin/files/css/styles.css');
	wp_enqueue_style('jquery-ui', 	wp_iv_property_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_style('all', 			wp_iv_property_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_style('slick', 		wp_iv_property_URLPATH . 'admin/files/css/slick/slick.css');
	wp_enqueue_style('jquery.fancybox', wp_iv_property_URLPATH . 'admin/files/css/jquery.fancybox.css');
	wp_enqueue_style('colorbox', wp_iv_property_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_script('colorbox', wp_iv_property_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
	wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui', 	wp_iv_property_URLPATH . 'admin/files/js/jquery-ui.min.js');
	wp_enqueue_script('bootstrapjs-iv_property-ep7', 		wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_script('popper', 		wp_iv_property_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('slick', wp_iv_property_URLPATH . 'admin/files/css/slick/slick.js');
	wp_enqueue_script('jquery.fancybox',wp_iv_property_URLPATH . 'admin/files/js/jquery.fancybox.js');
	$dir_style_font=get_option('dir_style_font');
	if($dir_style_font==""){$dir_style_font='no';}
	if($dir_style_font=='yes'){
		wp_enqueue_style('quicksand_property-font-110', wp_iv_property_URLPATH . 'admin/files/css/quicksand-font.css');
	}
	$dir_background_color=get_option('dir5_background_color');
	if($dir_background_color==""){$dir_background_color='#EFEFEF';}
	$directory_url=get_option('_iv_property_url');
	if($directory_url==""){$directory_url='property';}
	global $post,$wpdb, $current_user;
	$id = get_the_ID();
	$post_id_1 = get_post($id);
	$post_id_1->post_title;
	$wp_directory= new wp_iv_property();
	$property_top_1_icon=get_option('property_top_1_icon');
	if($property_top_1_icon==""){$property_top_1_icon='fas fa-tachometer-alt';}
	$property_top_2_icon=get_option('property_top_2_icon');
	if($property_top_2_icon==""){$property_top_2_icon='fas fa-gas-pump';}
	$property_top_3_icon=get_option('property_top_3_icon');
	if($property_top_3_icon==""){$property_top_3_icon='fas fa-shower';}
	$property_top_4_icon=get_option('property_top_4_icon');
	if($property_top_4_icon==""){$property_top_4_icon='fas fa-road';}
?>
<?php
	$current_property_status = get_post_meta($id,'property_status',true);
	$rent_text=get_post_meta($id,'price_postfix_text',true).  number_format((int)get_post_meta($id,'sale_or_rent_price',true));
	if(trim(ucfirst($current_property_status)) ==ucfirst('For Rent')){
	  $rent_text= ''.get_post_meta($id,'price_postfix_text',true).''. number_format((int)str_replace(",", "", get_post_meta($id,'sale_or_rent_price',true))).''  ;
	  if(get_post_meta($id,'rent_period',true)!=''){
			$rent_text=$rent_text.'/'.get_post_meta($id,'rent_period',true);
		}
	}
	if(trim(ucfirst($current_property_status)) ==ucfirst('For Sale')){
		$rent_text= get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true) .' '.' '.' '. get_post_meta($id,'price_postfix_text',true).''. number_format((int)str_replace(",", "", get_post_meta($id,'sale_or_rent_price',true)));
		}
	if(trim(ucfirst($current_property_status)) ==ucfirst('Sold')){
		$rent_text= get_post_meta($id,'area',true). ' '.get_post_meta($id,'area_postfix_text',true).' '.' '.' '. get_post_meta($id,'price_postfix_text',true).''. number_format((int)str_replace(",", "", get_post_meta($id,'sale_or_rent_price',true))) ;
	}
 ?>
<style>
	.fa{
    font: normal normal normal 14px/1 FontAwesome !important;
	}
	.agent-info{
	background:<?php echo esc_html($dir_background_color);?>!important;
	}
</style>
<?php
	while ( have_posts() ) : the_post();
	if(has_post_thumbnail()){
		$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
		if($feature_image[0]!=""){
			$feature_img =$feature_image[0];
		}
		}else{
		$feature_img= wp_iv_property_URLPATH."/assets/images/default-directory.jpg";
	}
	$currentCategory=wp_get_object_terms( $id, $directory_url.'-category');
	$cat_name2='';
	if(isset($currentCategory[0]->name)){
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
?>
<!-- SLIDER SECTION -->
<?php
	$property_top_slider=get_option('property_top_slider');
	if($property_top_slider==""){$property_top_slider='yes';}
	if($property_top_slider=='yes'){
	?>
	<div class="bootstrap-wrapper" id="slider-wrapper">
		<section class=" container-fluid m-0 p-0">
			<div class="slider-section">
				<div class="slick-controls">
					<p class="next"><i class="fas fa-angle-right"></i></p>
					<p class="previous"><i class="fas fa-angle-left"></i></p>
				</div>
				<div class="slider variable-width">
					<?php
						$gallery_ids=get_post_meta($id ,'image_gallery_ids',true);
						$gallery_ids_array = array_filter(explode(",", $gallery_ids));
						$i=1;
						foreach($gallery_ids_array as $slide){
							if($slide!=''){ ?>
							<div class="item border">
								<img src="<?php echo wp_get_attachment_url( $slide ); ?> " >
							</div>
							<?php
								$i++;
							}
						}
						//image_gallery_urls
						$gallery_urls=get_post_meta($id ,'image_gallery_urls',true);
						$gallery_urls_array = array_filter(explode(",", $gallery_urls));
						foreach($gallery_urls_array as $slide){
							if($slide!=''){ ?>
							<div class="item border">
								<img src="<?php echo esc_url($slide); ?>" >
							</div>
							<?php
								$i++;
							}
						}
						if($i<3){
							for($iii=0;$iii<3;$iii++){
								if(has_post_thumbnail($id)){?>
								<div class="item border">
									<?php echo get_the_post_thumbnail($id, 'large');?>
								</div>
								<?php
									}else{
								?>
								<div class="item border">
									<img   src="<?php echo  wp_iv_property_URLPATH."/assets/images/default-directory.jpg";?>">
								</div>
								<?php
								}
							}
						}
					?>
				</div>
			</div>
		</section>
	</div>
	<?php
	}
?>
<!-- END OF SLIDER SECTION -->
<?php
	$directories_layout_single=get_option('directories_layout_single');
	if($directories_layout_single==""){$directories_layout_single='two';}
?>
<!-- ********** Agent Info Section ************** -->
<section class="bootstrap-wrapper">
	<section class="agent-info py-5 mt-0">
		<div class="container">
			<div class="row mb-5">
				<div class="<?php echo($directories_layout_single=='one'?'col-md-12':'col-md-8') ?> agent-info__content">
					<div class="row my-5 px-5 d-flex">
						<div class="col-md-10 d-flex flex-column">
							<h2><?php //echo esc_html($post_id_1->post_title); ?>THE BMW M4 <?php
								if(get_post_meta($id,'realpro_featured',true)=="featured"){ ?>
								<span class="text-white agent-info__feature"><?php  esc_html_e('Featured', 'ivproperty' ); ?></span>
								<?php
								}
							?>
							</h2>
							<br>
							<p class="agent-info__address m-0 p-0">
								<i class="fas fa-map-marker-alt"></i>
                                Wild at Art: Art on Wheels
								<?php //echo get_post_meta($id,'address',true);?> <?php //echo get_post_meta($id,'city',true);?> <?php //echo get_post_meta($id,'zipcode',true);?> <?php //echo get_post_meta($id,'country',true);?>
								<?php
									$dir5_review_show=get_option('dir5_review_show');
									if($dir5_review_show==""){$dir5_review_show='yes';}
									if($dir5_review_show=='yes'){
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
											$avg_review= (int)$total_reviews_point[0]/(int)$total_review_post;
										}
									?>
                  <br>
									<i class="far fa-star fa-sm <?php echo ($avg_review>0 ?'black-star':'white-star');?>"></i>
									<i class="far fa-star fa-sm <?php echo ($avg_review>=2 ?'black-star':'white-star');?>"></i>
									<i class="far fa-star fa-sm <?php echo ($avg_review>=3 ?'black-star': 'white-star');?>"></i>
									<i class="far fa-star fa-sm <?php echo ($avg_review>=4 ?'black-star': 'white-star');?>"></i>
									<i class="far fa-star fa-sm <?php echo ($avg_review>=5 ?'black-star': 'white-star');?>"></i>
									<?php
									}
								?>
							</p>
						</div>
						<div class="col-md-1 ml-auto" >
							<span class="ml-4" id="fav_dir<?php echo esc_html($id); ?>">
								<?php
									$user_ID = get_current_user_id();
									if($user_ID>0){
										$my_favorite = get_post_meta($id,'_favorites',true);
										$all_users = explode(",", $my_favorite);
										if (in_array($user_ID, $all_users)) { ?>
										<a  class="link-text-decoration-none added-favorite-color" data-toggle="tooltip"  title="<?php  esc_html_e('Added to Favorites','ivproperty'); ?>" href="javascript:;" onclick="save_unfavorite('<?php echo esc_html($id); ?>')" >
										<i class="fas fa-heart fa-3x "></i></a>
										<?php
										}else{ ?>
										<a class="link-text-decoration-none add-favorite-color" data-toggle="tooltip"  title="<?php  esc_html_e('Add to Favorites','ivproperty'); ?>" href="javascript:;" onclick="save_favorite('<?php echo esc_html($id); ?>')" >
											<i class="fas fa-heart fa-3x"></i>
										</a>
										<?php
										}
									}else{ ?>
									<a class=" link-text-decoration-none add-favorite-color" data-toggle="tooltip"  title="<?php  esc_html_e('Add to Favorites','ivproperty'); ?>" href="javascript:;" onclick="save_favorite('<?php echo esc_html($id); ?>')" >
										<i class="fas fa-heart fa-3x "></i>
									</a>
									<?php
									}
								?>
							</span>
						</div>
					</div>
					<!-- card section -->
					<?php
						$property_top_4_icons=get_option('property_top_4_icons');
						if($property_top_4_icons==""){$property_top_4_icons='yes';}
						if($property_top_4_icons=="yes"){
						?>
						<div class="row d-flex">
							<div class="col-lg-3 m-0 p-0">
								<div class="card text-center agent-info__card agent-info__card--no-border agent-info__card--no-border-left">
									<div class="card-body">
										<?php
											$property_top_1_icon=get_option('property_top_1_icon');
											if($property_top_1_icon==""){$property_top_1_icon='fas fa-tachometer-alt';}
										?>
										<i class="<?php echo esc_html($property_top_1_icon);?>"></i>
										<h5 class="card-title text-muted mt-3 text-center"> <?php  esc_html_e('Engine Power', 'ivproperty' ); ?> </h5>
										<h6 class=""><?php //echo ucfirst($cat_name2); ?>300</h6>
										<h6 class=""><?php //$property_status=get_post_meta($id , 'property_status',true); $property_status= ucfirst($property_status); ?><?php  esc_html_e($property_status, 'ivproperty' ); ?></h6>
									</div>
								</div>
							</div>
							<div class="col-lg-3 m-0 p-0">
								<div class="card agent-info__card agent-info__card--no-border">
									<div class="card-body p-0 m-0">
										<?php
											$property_top_2_icon=get_option('property_top_2_icon');
											if($property_top_2_icon==""){$property_top_2_icon='fas fa-gas-pump';}
										?>
										<i class="<?php echo esc_html($property_top_2_icon);?>"></i>
										<h5 class="card-title text-muted mt-3"> <?php  esc_html_e('Fuel Type', 'ivproperty' ); ?> </h5>
										<?php
											if(get_post_meta($id,'bedrooms',true)!=""){
											?>
											<h6 class=""><?php //echo get_post_meta($id,'bedrooms',true) ;?> <?php  //esc_html_e(' Bedrooms','ivproperty'); ?>Hybrid</h6>
											<?php
											}
											if(get_post_meta($id,'guest',true)!=""){
											?>
											<h6 class=""><?php //echo get_post_meta($id,'guest',true) ;?> <?php  //esc_html_e(' Guest','ivproperty'); ?></h6>
											<?php
											}
										?>
									</div>
								</div>
							</div>
							<div class="col-lg-3 ml-0 p-0">
								<div class="card text-center agent-info__card agent-info__card--no-border">
									<div class="card-body p-0 m-0">
										<?php
											$property_top_3_icon=get_option('property_top_3_icon');
											if($property_top_3_icon==""){$property_top_3_icon='fas fa-cogs';}
										?>
										<i class="<?php echo esc_html($property_top_3_icon);?>"></i>
										<h5 class="card-title text-muted mt-3"> <?php  esc_html_e('Transmission', 'ivproperty' ); ?> </h5>
										<?php
											if(get_post_meta($id,'bathrooms',true)!=""){
											?>
											<h6 class=""><?php //echo get_post_meta($id,'bathrooms',true) ;?> <?php  //esc_html_e(' Baths','ivproperty'); ?>Automatic</h6>
											<?php
											}
										?>
									</div>
								</div>
							</div>
							<div class="col-lg-3 m-0 p-0">
								<div class="card text-center agent-info__card agent-info__card--no-border">
									<div class="card-body">
										<i class="<?php echo esc_html($property_top_4_icon);?>"></i>
										<h5 class="card-title text-muted mt-3"> <?php  esc_html_e('Mileage', 'ivproperty' ); ?> </h5>
										<?php
											if(get_post_meta($id,'area',true)!=""){
											?>
											<h6 class=""><?php //echo get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true); ?></h6>
											<?php
											}
											if(get_post_meta($id,'garages',true)!=""){
											?>
											<h6 class=""><?php //echo get_post_meta($id,'garages',true);?><?php  //esc_html_e(' Garage','ivproperty'); ?>15kmpl</h6>
											<?php
											}
										?>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
					?>
					<!-- end of card section -->
					<!-- about listing section -->
					<div class="row mb-0 mb-md-5 px-5">
						<div class="col mt-5">
							<h2 class="mb-3"><?php  esc_html_e('About','ivproperty'); ?></h2>
							<p class="text-justify">
								<?php
									if($wp_directory->check_reading_access('Description',$id)){
										$my_postid = $id;//This is page id or post id
										$content_post = get_post($my_postid);
										$content = $content_post->post_content;
										$content = apply_filters('the_content', $content);
										$content = str_replace(']]>', ']]&gt;', $content);
										echo do_shortcode($content);
									}
								?>
							</p>
						</div>
					</div>
					<?php
						$property_details=get_option('property_details');
						if($property_details==""){$property_details='yes';}
						if($property_details=="yes"){
						?>
						<!-- details section -->
						<?php
							if($wp_directory->check_reading_access('Description',$id)){
							?>
							<div class="row px-5">
								<div class="col">
									<h3 class="font-weight-bold m-0 py-2"><?php  esc_html_e('Details','ivproperty'); ?></h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<div class="row mt-5 px-5">
								<?php
									$i=1;
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
								?>
								<div class="row col">
									<?php
										$currentCategory=wp_get_object_terms( $id, $directory_url.'-category');
										$selected='';
										if(isset($currentCategory[0]->name)){
											$selected = $currentCategory[0]->name;
										}
									?>
									<div class="col-md-6">
										<p><i class="fas fa-angle-right"></i> <?php echo  esc_html_e('Engine Power', 'ivproperty'); ?>: <strong>1800
										<?php //echo esc_html($selected).' '.esc_html(get_post_meta($id,'property_status',true)); ?></strong></p>
									</div>
									<div class="col-md-6">
										<p><i class="fas fa-angle-right"></i> <?php echo  esc_html_e('Mileage', 'ivproperty'); ?>: <strong>
										<?php //echo esc_html($rent_text); ?>15kmpl</strong></p>
									</div>
									<?php
										if(get_post_meta($id,'bedrooms',true)!='' ){
										?>
										<div class="col-md-6">
											<p><i class="fas fa-angle-right"></i> <?php echo  esc_html_e('Fuel Type', 'ivproperty'); ?>: <strong>
											<?php //echo esc_html(get_post_meta($id,'bedrooms',true)); ?>Hybrid</strong></p>
										</div>
										<?php
										}
									?>
									<?php
										if(get_post_meta($id,'area',true)!='' ){
										?>
										<div class="col-md-6">
											<p><i class="fas fa-angle-right"></i> <?php echo  esc_html_e('Year of Manufucture', 'ivproperty'); ?>: <strong>
											<?php echo esc_html(get_post_meta($id,'area',true)).' '.esc_html(get_post_meta($id,'area_postfix_text',true)); ?></strong></p>
										</div>
										<?php
										}
									?>
									<?php
										if(get_post_meta($id,'bathrooms',true)!='' ){
										?>
										<div class="col-md-6">
											<p><i class="fas fa-angle-right"></i> <?php echo  esc_html_e('Total Drive', 'ivproperty'); ?>: <strong>
											<?php echo esc_html(get_post_meta($id,'bathrooms',true)); ?></strong></p>
										</div>
										<?php
										}
									?>
									<?php
										if(get_post_meta($id,'guest',true)!='' ){
										?>
										<div class="col-md-6">
											<p><i class="fas fa-angle-right"></i> <?php echo  esc_html_e('Transmission', 'ivproperty'); ?>: <strong>
											<?php echo esc_html(get_post_meta($id,'guest',true)); ?></strong></p>
										</div>
										<?php
										}
									?>
									<?php
										if(get_post_meta($id,'garages',true)!='' ){
										?>
										<div class="col-md-6">
											<p><i class="fas fa-angle-right"></i> <?php echo  esc_html_e('Body', 'ivproperty'); ?>: <strong>
											<?php echo esc_html(get_post_meta($id,'garages',true)); ?></strong></p>
										</div>
										<?php
										}
									?>
									<?php
										if(sizeof($default_fields)>0){
											foreach ( $default_fields as $field_key => $field_value ) {
												$field_value_trim=trim($field_value);
												if(get_post_meta($id,$field_key,true)!=""){
												?>
												<div class="col-md-6">
													<p><i class="fas fa-angle-right"></i> <?php echo  esc_html_e($field_value_trim, 'ivproperty'); ?>:<strong><?php echo esc_html(get_post_meta($id,$field_key,true)); ?></strong></p>
												</div>
												<?php
												}
											}
										}
									?>
								</div>
							</div>
							<?php
							}
						}
					?>
					<?php
					if($directories_layout_single=="one"){
						$contact_info=get_option('_contact_info');
						if($contact_info==""){$contact_info='yes';}
						if($contact_info=="yes"){
						?>
						<div class="row px-5 mt-5">
							<div class="col">
								<h3 class="font-weight-bold" id="overView">
									<?php
										$dir_addedit_contactinfotitle=get_option('dir_addedit_contactinfotitle');
										if($dir_addedit_contactinfotitle==""){$dir_addedit_contactinfotitle=esc_html__('Contact Info' ,'ivproperty');}
										echo esc_html($dir_addedit_contactinfotitle);
									?>
								</h3>
							</div>
						</div>
						<div class="agent-info__separator mx-5"></div>
						<div class="row my-3 px-5">
							<div class="row col">
								<?php
									if($wp_directory->check_reading_access('contact info',$id)){
										$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
										if($listing_contact_source==''){$listing_contact_source='new_value';}
										if($listing_contact_source=='new_value'){
										?>
										<?php
											if(get_post_meta($id,'contact_name',true)!=""){
											?>
											<div class="col-md-4"><p><?php  esc_html_e('Name','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo esc_html(get_post_meta($id,'contact_name',true));?></p>
											</div>
											<?php
											}
										?>
										<?php
											if(get_post_meta($id,'phone',true)!=""){
											?>
											<div class="col-md-4"><p><?php  esc_html_e('Phone','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="tel:'.esc_html(get_post_meta($id,'phone',true)).'">'.esc_html(get_post_meta($id,'phone',true)).'</a>' ;?></p>
											</div>
											<?php
											}
										?>
										<?php
											if(get_post_meta($id,'contact-email',true)!=""){
											?>
											<div class="col-md-4"><p><?php  esc_html_e('Email','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="mailto:'.esc_html(get_post_meta($id,'contact-email',true)).'">'.esc_html(get_post_meta($id,'contact-email',true)).'</a>' ;?></p>
											</div>
											<?php
											}
										?>
										<?php
											if(trim(get_post_meta($id,'contact_web',true))!=""){
												$contact_web=get_post_meta($id,'contact_web',true);
												$contact_web=str_replace('https://','',$contact_web);
												$contact_web=str_replace('http://','',$contact_web);
											?>
											<div class="col-md-4"><p><?php  esc_html_e('Web Site','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="link-text-decoration-none" href="'. esc_url($contact_web).'" target="_blank"">'. esc_url($contact_web).'&nbsp; </a>';?></p>
											</div>
											<?php
											}
										?>
										<?php
										}else{ ?>
										<?php
											$post_author_id= get_post_field( 'post_author', $id );
											$agent_info = get_userdata($post_author_id);
											if(get_user_meta($post_author_id,'phone',true)!=""){
											?>
											<div class="col-md-4"><p><?php  esc_html_e('Phone','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue link-text-decoration-none" href="tel:'.esc_html(get_user_meta($post_author_id,'phone',true)).'">'.esc_html(get_user_meta($post_author_id,'phone',true)).'</a>' ;?></p>
											</div>
											<?php
											}
										?>
										<div class="col-md-4"><p><?php  esc_html_e('Email','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="mailto:'.$agent_info->user_email.'">'.esc_html($agent_info->user_email).'</a>' ;?></p>
										</div>
										<?php
											if(trim(get_user_meta($post_author_id,'web_site',true))!=""){
												$contact_web=get_user_meta($post_author_id,'web_site',true);
												$contact_web=str_replace('https://','',$contact_web);
												$contact_web=str_replace('http://','',$contact_web);
											?>
											<div class="col-md-4"><p><?php  esc_html_e('Web Site','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="link-text-decoration-none"  href="'. esc_url($contact_web).'" target="_blank"">'. esc_url($contact_web).'&nbsp; </a>';?></p>
											</div>
											<?php
											}
										?>
										<?php
										}
									}
								?>
								<div class="my-4 px-2 ">
									<?php
										$contact_form=get_option('_contact_form');
										if($contact_form==""){$contact_form='yes';}
										$dir_contact_form=get_option('dir_contact_form');

										if($contact_form=='yes'){
											$contact_form=get_option('_contact_form_modal');
											if($contact_form==""){$contact_form='popup';}
											if($contact_form=='popup'){
													if($dir_contact_form=='yes'){
													?>
													<button onclick="call_popup(<?php echo esc_html($id); ?>)" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2" type="button" name="button"><i class="far fa-envelope"></i> <?php  esc_html_e('Contact the agent','ivproperty'); ?></button>

														<?php
														}else{
																$dir_form_shortcode=get_option('dir_form_shortcode');
																echo do_shortcode($dir_form_shortcode);
														}
												}else{
												?>
													<h3 class="m-0 py-3"><?php  esc_html_e( 'Contact the agent', 'ivproperty' ); ?></h3>
												<?php

													if($dir_contact_form==""){$dir_contact_form='yes';}
													if($dir_contact_form=='yes'){
															include( wp_iv_property_template. 'property/contact-form.php');
														?>
															<div class="form-group ">
																<button type="button" onclick="contact_send_message_iv();" class="btn btn-secondary sm pull-left"><?php esc_html_e( 'Send Message', 'ivproperty' ); ?></button>
															</div>

														<?php
													}else{
																$dir_form_shortcode=get_option('dir_form_shortcode');
																echo do_shortcode($dir_form_shortcode);
													}
												}
										}
									?>
								</div>
							</div>
						</div>
						<?php
						}
					}
					?>
					<!-- pic gallery section -->
					<div class="row agent-info__gallery-pics mt-5">
						<?php
							$gallery_ids=get_post_meta($id ,'image_gallery_ids',true);
							$gallery_ids_array = array_filter(explode(",", $gallery_ids));
							$i=1;
							foreach($gallery_ids_array as $slide){
								if($slide!=''){ ?>
								<div class=" p-0 m-0 col-md-3">
									<a data-fancybox="gallery" href="<?php echo wp_get_attachment_url( $slide ); ?>">
										<img class="img-fluid" src="<?php echo wp_get_attachment_url( $slide ); ?>" >
									</a>
								</div>
								<?php
									$i++;
								}
							}
							//image_gallery_urls
							$gallery_urls=get_post_meta($id ,'image_gallery_urls',true);
							$gallery_urls_array = array_filter(explode(",", $gallery_urls));
							foreach($gallery_urls_array as $slide){
								if($slide!=''){ ?>
								<div class=" p-0 m-0 col-md-3">
									<a data-fancybox="gallery" href="<?php echo esc_html($slide); ?>">
										<img class="img-fluid" src="<?php echo esc_html($slide); ?>">
									</a>
								</div>
								<?php
									$i++;
								}
							}
							if($wp_directory->check_reading_access('floor plan',$id)){
							?>
							<?php
								for($i=0;$i<20;$i++){
									if(get_post_meta($id,'_plan_image_id_'.$i,true)!=''){?>
									<div class=" p-0 m-0 col-md-3">
										<a data-fancybox="gallery" href="<?php echo wp_get_attachment_url( get_post_meta($id,'_plan_image_id_'.$i,true) ); ?>">
											<img  src="<?php echo wp_get_attachment_url( get_post_meta($id,'_plan_image_id_'.$i,true) ); ?>" class="img-fluid">
										</a>
									</div>
									<?php
									}
								}
							?>
							<?php
							}
						?>
					</div>
					<!-- end of pic gallery -->
					<!-- Public section -->
					<?php
						$property_public_facilities=get_option('property_public_facilities');
						if($property_public_facilities==""){$property_public_facilities='yes';}
						if($property_public_facilities=="yes"){
						?>
						<?php
							$public_facilities =get_post_meta($id ,'_public_facilities',true);
							if($public_facilities!=''){
								if(sizeof($public_facilities)>0){?>
								<div class="row px-5">
									<div class="col">
										<h3 class=" m-0 py-4"><?php  esc_html_e('Public Facilities','ivproperty'); ?></h3>
									</div>
								</div>
								<?php
									if($wp_directory->check_reading_access('public facilities',$id)){
									?>
									<div class="agent-info__separator mx-5"></div>
									<div class="row my-5 px-5">
										<div class="row col text-left">
											<?php
												foreach($public_facilities as $key => $item){
													$facility = explode("|", $item);
													if(!empty($facility[0])){
													?>
													<div class="col-md-6">
														<p><i class="fas fa-angle-right"></i> <?php  esc_html_e($key,'ivproperty' ); ?>: <strong><?php echo esc_html($facility[0]);?></strong></p>
													</div>
													<?php
													}
												}
											?>
										</div>
									</div>
									<?php
									}
								}
							}
						}
					?>
					<!-- end of price section -->
					<!-- features secton -->
					<?php
						$dir_features=get_option('_dir_features');
						if($dir_features==""){$dir_features='yes';}
						if($dir_features=="yes"){
						?>
						<div class="row px-5">
							<div class="col">
								<h3 class="m-0 py-2"><?php  esc_html_e( 'Features', 'ivproperty' ); ?></h3>
							</div>
						</div>
						<div class="agent-info__separator mx-5"></div>
						<div class="row my-5 px-5">
							<div class="row col">
								<?php
									$dir_tags=get_option('_dir_tags');
									if($dir_tags==""){$dir_tags='yes';}
									if($dir_tags=='yes'){
										$tag_array= wp_get_object_terms( $id,  $directory_url.'_tag');
										}else{
										$tag_array= wp_get_post_tags( $id );
									}
									foreach($tag_array as $one_tag){
										echo'<div class="col-md-6"><p><i class="fas fa-angle-right"></i> <a class="link-text-decoration-none"  href="'.get_tag_link($one_tag->term_id) .'">'.$one_tag->name.'</a></p></div>';
									}
									$currentCategory=wp_get_object_terms( $id, $directory_url.'-category');
									if(isset($currentCategory[0]->slug)){
										$cat_slug = $currentCategory[0]->slug;
										$cat_name = $currentCategory[0]->name;
										$cc=0;
										foreach($currentCategory as $c){
											echo'<div class="col-md-6"><p><i class="fas fa-angle-right"></i> <a class="link-text-decoration-none"  href="'.get_tag_link($c->term_id) .'">'.$c->name.'</a></p></div>';
										}
									}
								?>
							</div>
						</div>
						<!-- end of feature section -->
						<?php
						}
					?>
					<!-- map section -->
					<?php
						$dir_map=get_option('property_dir_map');
						if($dir_map==""){$dir_map='yes';}
						if($dir_map=='yes'){
							$address=get_post_meta($id,'address',true).'+'.get_post_meta($id,'city',true).'+'.get_post_meta($id,'postcode',true).'+'.get_post_meta($id,'country',true);
						?>
						<div class="agent-info__separator"></div>
						<div class="row mb-5">
							<div class="col">
								<iframe width="100%" height="325" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo esc_html($address); ?>&amp;ie=UTF8&amp;&amp;output=embed"></iframe>
							</div>
						</div>
						<?php
						}
					?>
					<!-- end of map section -->
					<!-- video section -->
					<?php
						$dir_video=get_option('property_dir_video');
						if($dir_video==""){$dir_video='yes';}
						if($dir_video=='yes'){
							$video_vimeo_id= get_post_meta($id,'vimeo',true);
							$video_youtube_id=get_post_meta($id,'youtube',true);
							if($video_vimeo_id!='' || $video_youtube_id!=''){
							?>
							<div class="row px-5">
								<div class="col">
									<h3 class="m-0 py-2"><?php  esc_html_e('Video','ivproperty'); ?></h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<div class="row my-0 my-sm-2 px-5">
								<div class="col video">
									<?php
										if($wp_directory->check_reading_access('video',$id)){
										?>
										<?php
											$v=0;
											$video_vimeo_id= get_post_meta($id,'vimeo',true);
											if($video_vimeo_id!=""){ $v=$v+1; ?>
											<iframe src="<?php echo esc_url('//player.vimeo.com/video/');?><?php echo esc_html($video_vimeo_id); ?>" width="100%" height="415px" class="w-100" frameborder="0"></iframe>
											<?php
											}
										?>
										<br/>
										<?php
											$video_youtube_id=get_post_meta($id,'youtube',true);
											if($video_youtube_id!=""){
												echo($v==1?'<hr>':'');
											?>
											<iframe width="100%" height="415px" src="<?php echo esc_url('//www.youtube.com/embed/');?><?php echo esc_html($video_youtube_id); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-100"></iframe>
											<?php
											}
										}
									?>
								</div>
							</div>
							<?php
							}
						}
					?>
					<!-- end of video section -->
					<!-- review section -->
					<?php
						$dir5_review_show=get_option('dir5_review_show');
						if($dir5_review_show==""){$dir5_review_show='yes';}
						if($dir5_review_show=='yes'){
						?>
						<div class="row mt-0 mt-md-5 px-5">
							<div class="col">
								<h3 class="m-0 py-2"><?php  esc_html_e('Review','ivproperty'); ?> </h3>
							</div>
						</div>
						<div class="agent-info__separator mx-5"></div>
						<div class="row mt-5 px-5">
							<?php
								include(wp_iv_property_template.'property/reviews.php');
							?>
						</div>
						<?php
						}
					?>
					<!-- end of review section -->
					<!-- loan calculator section -->
					<?php
						$eploan_calculator=get_option('_eploan_calculator');
						if($eploan_calculator==""){$eploan_calculator='yes';}
						if($eploan_calculator=='yes'){
						?>
						<div class="row mt-0 px-5">
							<div class="col">
								<h3 class="m-0 py-2"><?php  esc_html_e('Loan Calculator','ivproperty'); ?></h3>
							</div>
						</div>
						<div class="agent-info__separator mx-5"></div>
						<div class="row mt-5 px-5">
							<?php
								include(wp_iv_property_template.'property/loan-calculator.php');
							?>
						</div>
						<!-- end of loan calculator -->
						<?php
						}
					?>
					<!-- similar property -->
					<?php
						$similar_property=get_option('_similar_property');
						if($similar_property==""){$similar_property='yes';}
						if($similar_property=="yes"){
							$current_property_status = get_post_meta($id,'property_status',true);
							$properties = get_posts(array(
							'numberposts'	=> '4',
							'post_type'		=> $directory_url,
							'post__not_in' => array($id),
							'post_status'	=> 'publish',
							'orderby'		=> 'rand',
							));
							if($current_property_status==''){
								$properties = get_posts(array(
								'numberposts'	=> '4',
								'post_type'		=> $directory_url,
								'post__not_in' => array($id),
								'post_status'	=> 'publish',
								'orderby'		=> 'rand',
								));
							}
							if ( ! empty( $properties ) ) {
							?>
							<div class="row">
								<div class="col-md-12 py-3 bg-separator"></div>
							</div>
							<div class="row mt-0 px-5">
								<div class="col">
									<h3 class="m-0 py-2"><?php  esc_html_e('Similar Properties','ivproperty'); ?></h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<!-- property slider -->
							<div id="similarPrppertycarousel" class="carousel slide px-5" data-ride="carousel">
								<ol class="carousel-indicators">
									<li data-target="#similarPrppertycarousel" data-slide-to="0" class="active"></li>
									<li data-target="#similarPrppertycarousel" data-slide-to="1"></li>
								</ol>
								<div class="carousel-inner">
									<?php
										$i=0;
										foreach( $properties as $property ) :
									?>
									<div class="carousel-item <?php echo($i==0?'active':'');?>">
										<div class="row bg-white agent-info__similar-property p-3 mt-3">
											<div class="col-md-4 p-0 m-0 agent-info__similar-property-img">
												<a href="<?php echo get_the_permalink($property->ID);?>">
													<?php	if(has_post_thumbnail($property->ID)){
														$fsrc= wp_get_attachment_image_src( get_post_thumbnail_id( $property->ID ), 'large' );
														if($fsrc[0]!=""){
															$fsrc =$fsrc[0];
														}
													?>
													<img src="<?php  echo esc_html($fsrc);?>" class="realest_img">
													<?php
													}else{	?>
													<img src="<?php  echo wp_iv_property_URLPATH."/assets/images/default-directory.jpg";?>" class="realest_img">
													<?php
													}
													?>
												</a>
											</div>
											<div class="col-md-8 mt-3 mt-md-0 px-5 pl-md-5">
												<a href="<?php echo get_the_permalink($property->ID);?>"><h6><?php echo get_the_title($property->ID); ?></h6></a>
												<p><?php echo get_post_meta($property->ID,'address',true);?> <?php echo get_post_meta($property->ID,'city',true);?> <?php echo get_post_meta($property->ID,'zipcode',true);?> <?php echo esc_html(get_post_meta($property->ID,'country',true));?></p>
												<p>
													<?php
														if(get_post_meta($property->ID,'area',true)!=""){ ?>
														<i class="<?php echo esc_html($property_top_4_icon);?> fa-xs ml-1"></i> <?php
															echo get_post_meta($property->ID,'area',true).' '.get_post_meta($property->ID,'area_postfix_text',true).' ';
														?>
														<?php
														}
													?>
													<?php
														if(get_post_meta($property->ID,'bedrooms',true)!=""){ ?>
														<i class="<?php echo esc_html($property_top_2_icon);?> fa-xs ml-1"></i>  <?php
															echo get_post_meta($property->ID,'bedrooms',true);
														?><?php  esc_html_e(' Bedrooms','ivproperty'); ?>
														<?php
														}
													?>
													<?php
														if(get_post_meta($property->ID,'bathrooms',true)!=""){ ?>
														<i class="<?php echo esc_html($property_top_3_icon);?> fa-xs ml-1"></i> <?php
															echo get_post_meta($property->ID,'bathrooms',true);
														?><?php  esc_html_e(' Baths ','ivproperty'); ?>
														<?php
														}
													?>
													<?php
														if(trim(get_post_meta($property->ID,'garages',true))!=""){ ?>
														<i class="fas fa-car fa-xs ml-1"></i>  <?php
															echo get_post_meta($property->ID,'garages',true);
														?><?php  esc_html_e(' Garage ','ivproperty'); ?>
														<?php
														}
													?>
													<?php
														if(get_post_meta($property->ID,'guest',true)!=""){ ?>
														<i class="fas fa-user fa-xs ml-1"></i>  <?php
															echo get_post_meta($property->ID,'guest',true);
														?><?php  esc_html_e(' Guest ','ivproperty'); ?>
														<?php
														}
													?>
												</p>
											</div>
										</div>
									</div>
									<?php
										$i++;
										endforeach;
									?>
								</div>
								<a class="carousel-control-prev" href="#similarPrppertycarousel" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only"><?php  esc_html_e('Previous','ivproperty'); ?></span>
								</a>
								<a class="carousel-control-next" href="#similarPrppertycarousel" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="sr-only"><?php  esc_html_e('Next','ivproperty'); ?></span>
								</a>
							</div>
							<!-- end of similar property -->
							<?php
							}
						}
					?>
				</div>
				<?php
					if($directories_layout_single!='one'){
					?>
					<div class="col-md-4 ml-auto agent-info__booking-section-container">
						<?php
							if($directories_layout_single=='right_feature_image'){
								$feature_img='';
								$img_url= wp_get_attachment_url( get_post_thumbnail_id($id ,'large') );
								echo '<img src="'.esc_url( $img_url).'" class="image100" >';
							}
						?>
						<div class="agent-info__booking-section">
							<?php
								$property_right_top_price=get_option('property_right_top_price');
								if($property_right_top_price==""){$property_right_top_price='yes';}
								if($property_right_top_price=="yes"){ ?>
								<h2 class="text-center py-3 mx-0 h2bg">
									<?php echo esc_html($rent_text); ?>
								</h2>
								<?php
								}
							?>
							<?php
								$contact_info=get_option('_contact_info');
								if($contact_info==""){$contact_info='yes';}
								if($contact_info=="yes"){
								?>
								<div class="row m-1 px-5">
									<div class="">
										<h3 class="m-0 py-3"><?php  esc_html_e( 'Contact Info', 'ivproperty' ); ?></h3>
									</div>
								</div>
                <div class="agent-info__separator mx-5"></div>
                <div class="row my-3 px-5">
									<?php
										if($wp_directory->check_reading_access('contact info',$id)){
											$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
											if($listing_contact_source==''){$listing_contact_source='new_value';}
											if($listing_contact_source=='new_value'){
											?>
											<?php
												if(get_post_meta($id,'contact_name',true)!=""){
												?>
												<div class="col-md-4"><p><?php  esc_html_e('Name','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo get_post_meta($id,'contact_name',true);?></p>
												</div>
												<?php
												}
											?>
											<?php
												if(get_post_meta($id,'phone',true)!=""){
												?>
												<div class="col-md-4"><p><?php  esc_html_e('Phone','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="tel:'.get_post_meta($id,'phone',true).'">'.get_post_meta($id,'phone',true).'</a>' ;?></p>
												</div>
												<?php
												}
											?>
											<?php
												if(get_post_meta($id,'contact-email',true)!=""){
												?>
												<div class="col-md-4"><p><?php  esc_html_e('Email','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="mailto:'.get_post_meta($id,'contact-email',true).'">'.get_post_meta($id,'contact-email',true).'</a>' ;?></p>
												</div>
												<?php
												}
											?>
											<?php
												if(trim(get_post_meta($id,'contact_web',true))!=""){
													$contact_web=get_post_meta($id,'contact_web',true);
													$contact_web=str_replace('https://','',$contact_web);
													$contact_web=str_replace('http://','',$contact_web);
													$contact_web_s=substr($contact_web, 0, 20);

												?>
												<div class="col-md-4"><p><?php  esc_html_e('Web Site','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="link-text-decoration-none" href="'.esc_url($contact_web).'" target="_blank"">'. esc_url($contact_web_s).'&nbsp; </a>';?></p>
												</div>
												<?php
												}
											?>
											<?php
											}else{ ?>
											<?php
												$post_author_id= get_post_field( 'post_author', $id );
												$agent_info = get_userdata($post_author_id);
												if(get_user_meta($post_author_id,'phone',true)!=""){
												?>
												<div class="col-md-4"><p><?php  esc_html_e('Phone','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="tel:'.get_user_meta($post_author_id,'phone',true).'">'.get_user_meta($post_author_id,'phone',true).'</a>' ;?></p>
												</div>
												<?php
												}
											?>
											<div class="col-md-4"><p><?php  esc_html_e('Email','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="mailto:'.$agent_info->user_email.'">'.$agent_info->user_email.'</a>' ;?></p>
											</div>
											<?php
												if(trim(get_user_meta($post_author_id,'web_site',true))!=""){
													$contact_web=get_user_meta($post_author_id,'web_site',true);
													$contact_web=str_replace('https://','',$contact_web);
													$contact_web=str_replace('http://','',$contact_web);
													$contact_web_s=substr($contact_web, 0, 20);

												?>
												<div class="col-md-4"><p><?php  esc_html_e('Web Site','ivproperty'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="link-text-decoration-none"  href="'. esc_url($contact_web).'" target="_blank"">'. esc_url($contact_web_s).'&nbsp; </a>';?></p>
												</div>
												<?php
												}
											?>
											<?php
											}
										}
									?>
								</div>
								<?php
								}
							?>
							<div class="my-4 px-5 ">
								<div class="agent-info__form-separator mb-3"></div>
								<?php
									$contact_form=get_option('_contact_form');
									$dir_contact_form=get_option('dir_contact_form');
									if($contact_form==""){$contact_form='yes';}
									if($contact_form=='yes'){
										$contact_form=get_option('_contact_form_modal');
										if($contact_form==""){$contact_form='popup';}
											if($contact_form=='popup'){
												if($dir_contact_form=='yes'){
												?>
												<button onclick="call_popup(<?php echo esc_html($id); ?>)" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2" type="button" name="button"><i class="far fa-envelope"></i> <?php  esc_html_e('Contact the agent','ivproperty'); ?></button>

										<?php
												}else{
														$dir_form_shortcode=get_option('dir_form_shortcode');
														echo do_shortcode($dir_form_shortcode);

												}
										}else{
													$dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
													$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
													if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}
											?>
											<h3 class="m-0 py-3"><?php echo esc_html($dir_addedit_contactustitle);?></h3>

											<?php
													if($dir_contact_form==""){$dir_contact_form='yes';}
													if($dir_contact_form=='yes'){
															include( wp_iv_property_template. 'property/contact-form.php');
															?>
															<div id="update_message_popup" ></div>
															<button type="button" onclick="contact_send_message_iv();" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2 float-right"><?php  esc_html_e( 'Send Message', 'ivproperty' ); ?></button>
													<?php

													}else{
																$dir_form_shortcode=get_option('dir_form_shortcode');
																echo do_shortcode($dir_form_shortcode);
													}

												?>


										<?php
										}
									?>
									<?php
									}
									$dir_claim=get_option('_dir_dir_claim');
									if($dir_claim==""){$dir_claim='yes';}
									if($dir_claim=='yes'){
									?>
									<button onclick="call_popup_claim(<?php echo esc_html($id); ?>)" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2" type="button" name="button" id="no-border-radius"><i class="far fa-flag"></i> <?php  esc_html_e('Report','ivproperty'); ?></button>
									<?php
									}
									$dir_agent_info=get_option('_dir_agent_show');
									if($dir_agent_info==""){$dir_agent_info='yes';}
									if($dir_agent_info=='yes'){
									?>
									<button onclick="call_popup_agent_info(<?php echo esc_html($id); ?>)" data-toggle="modal" data-target="#myModalagentinfo" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2" type="button" name="button" id="no-border-radius"><i class="far fa-user"></i> <?php  esc_html_e('Agent Info','ivproperty'); ?></button>
									<?php
									}
								?>
							</div>
							<div class="d-flex justify-content-between align-items-center py-2 agent-info__form-footer">
								<?php
									$dir_share=get_option('_dir_share');
									if($dir_share==""){$dir_share='yes';}
									if($dir_share=="yes"){
									?>
									<a href="<?php echo esc_url('//www.facebook.com/sharer/sharer.php?u');?>=<?php the_permalink();  ?>"><i class="fab fa-facebook-f"></i></a>
									<a  href="<?php echo esc_url('//twitter.com/home?status');?>=<?php the_permalink(); ?>"><i class="fab fa-twitter"></i></a>
									<a href="<?php echo esc_url('//pinterest.com/pin/create/button/?url');?>=<?php the_permalink();?>&media=<?php echo esc_html($feature_img); ?>&description=<?php the_title(); ?>"><i class="fab fa-pinterest "></i></a>
									<a href="<?php echo esc_url('//www.linkedin.com/shareArticle?mini=true&url=test&title');?>=<?php the_title(); ?>&summary=&source="><i class="fab fa-linkedin"></i></a>
									<?php
									}
								?>
							</div>
						</div>
					</div>
					<?php
					}
				?>
			</div>
		</div>
	</section>
</section>

<!-- end of bootstrap-wrapper -->

<?php
	endwhile;

	wp_enqueue_script('iv_property-ar-script-38', wp_iv_property_URLPATH . 'admin/files/js/single-listing.js');
	wp_localize_script('iv_property-ar-script-38', 'realpro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_property_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'Please_login'=>esc_html__('Please login', 'ivproperty' ),
	'Add_to_Favorites'=>esc_html__('Add to Favorites', 'ivproperty' ),
	'Added_to_Favorites'=>esc_html__('Added to Favorites', 'ivproperty' ),
	'Please_put_your_message'=>esc_html__('Please put your name,email & message', 'ivproperty' ),
	'contact'=> wp_create_nonce("contact"),
	'listing'=> wp_create_nonce("listing"),
	'wp_iv_property_URLPATH'=>wp_iv_property_URLPATH,
	) );
?>
<?php
	get_footer();
?>
