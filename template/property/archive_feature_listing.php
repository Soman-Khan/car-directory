<?php
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
		$city_mq, $property_status, $zip_mq,$area,$min_price,$baths,$beds,$features,$max_price,
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
			$id = get_the_ID();
			if(get_post_meta($id, 'realpro_featured', true)=='featured'){
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
						$post_author_id= get_post_field( 'post_author', $id );
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
								<a href="<?php echo get_the_permalink($id);?>"><img src="<?php echo esc_html($feature_img);?>" class="card-img-top"></a>
							</div>
							<div class="card-img-overlay text-white font-weight-bold">                               
								<?php
									$current_property_status = get_post_meta($id,'property_status',true);
									$rent_text=get_post_meta($id,'price_postfix_text',true). get_post_meta($id,'sale_or_rent_price',true) ;
									if($current_property_status =='For Rent'){
										$rent_text= get_post_meta($id,'price_postfix_text',true). get_post_meta($id,'sale_or_rent_price',true).'/'.get_post_meta($id,'rent_period',true) ;
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
								<a href="<?php echo get_permalink($id); ?>" class="cbp-caption cbp-l-grid-projects-title mt-0"><p class="realtitle m-0 p-0"><?php echo esc_html($post->post_title);?></p></a>
								<p class="card-text p-0 m-0 address"><?php echo get_post_meta($id,'address',true);?> <?php echo esc_html(get_post_meta($id,'city',true));?> <?php echo esc_html(get_post_meta($id,'zipcode',true));?> <?php echo esc_html(get_post_meta($id,'country',true));?></p>
								<p class="mt-2 short-desc">
									<?php
									if(get_post_meta($id,'area',true)!=""){ ?>
											<i class="<?php echo esc_html($property_top_4_icon);?> fa-xs ml-1"></i><span class="ml-1"> <?php
											echo esc_html(get_post_meta($id,'area',true)).' '.esc_html(get_post_meta($id,'area_postfix_text',true)).' ';
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
								<p class="mt-0"><?php echo ucfirst($cat_name2).' '; ?><?php  esc_html_e($current_property_status, 'ivproperty' ); ?></p>
								<p class="d-flex mt-2">
									<span class="review">
									 <?php
								$dir_single_review_show=get_option('dir5_review_show');
								if($dir_single_review_show==""){$dir_single_review_show='yes';}
								if($dir_single_review_show=='yes'){
										$total_reviews_point = $wpdb->get_col($wpdb->prepare("SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm
										 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
										 WHERE pm.meta_key = 'review_value'
										 AND p.post_status = 'publish'
										 AND p.post_type = 'realpro_review' AND p.post_author = '%s'",$id ));
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
							 ?></span>
								</p>
							</div>
								<div class="cbp-l-grid-projects-date none" ><?php echo strtotime(get_the_date('Ymd',$id));?></div>
								<div class="cbp-l-grid-projects-price none" ><?php echo get_post_meta($id,'area',true);?></div>
								<div class="cbp-l-grid-projects-size none" ><?php echo get_post_meta($id,'sale_or_rent_price',true);?></div>
						</div>
					</div>
      <?php
			
		}
	endwhile;
 endif; ?>