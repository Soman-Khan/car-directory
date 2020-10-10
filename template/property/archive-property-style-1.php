<?php
wp_enqueue_style('bootstrap-iv_property-110', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
wp_enqueue_style('iv_property-style-111', wp_iv_property_URLPATH . 'admin/files/css/styles.css');
wp_enqueue_style('cubeportfolio', wp_iv_property_URLPATH . 'assets/cube/css/cubeportfolio.css');
wp_enqueue_style('jquery-ui', wp_iv_property_URLPATH . 'admin/files/css/jquery-ui.css');
wp_enqueue_style('all', wp_iv_property_URLPATH . 'admin/files/css/all.min.css');
$dir_style_font=get_option('dir_style_font');
if($dir_style_font==""){$dir_style_font='no';}
if($dir_style_font=='yes'){
	wp_enqueue_style('iv_property-font-110', wp_iv_property_URLPATH . 'admin/files/css/quicksand-font.css');
}
global $post,$wpdb,$tag;
$ins_lat='37.4419';
$ins_lng='-122.1419';
$search_show=0;
$search_show=0;
$map_show=0;
$search_button_show='no';
$dir_searchbar_show=get_option('_dir_searchbar_show');
if($dir_searchbar_show=="yes"){$search_show=1;}
$dir_map_show=get_option('_dir_map_show');
if($dir_map_show=="yes"){$map_show=1;}
$directory_url=get_option('_iv_property_url');
if($directory_url==""){$directory_url='property';}
$current_post_type=$directory_url;
$form_action='';
if ( is_front_page() ) {
  $form_action='action='.get_post_type_archive_link($current_post_type).'';
}
$search_button_show=get_option('_search_button_show');
if($search_button_show==""){$search_button_show='yes';}
$dir_style5_perpage='20';
$dir_style5_perpage=get_option('dir_style5_perpage');
if($dir_style5_perpage==""){$dir_style5_perpage=20;}
	$dirs_data =array();
	$tag_arr= array();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
		'post_type' => $directory_url, // enter your custom post type
		'paged' => $paged,
		'post_status' => 'publish',	
		'posts_per_page'=> $dir_style5_perpage,  // overrides posts per page in theme settings
	);
	$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
	// Add new shortcode only category
	if(isset($atts['category']) and $atts['category']!="" ){
			$postcats = $atts['category'];
			$args[$directory_url.'-category']=$postcats;
			$map_show=0;
			$search_show=0;
			$search_button_show='no';
	}
	if(get_query_var($directory_url.'-category')!=''){
			$postcats = get_query_var($directory_url.'-category');
			$args[$directory_url.'-category']=$postcats;
			$selected=$postcats;
	}
	if( isset($_POST['property-category'])){
		if($_POST['property-category']!=''){
			$postcats = sanitize_text_field($_POST['property-category']);
			$args[$directory_url.'-category']=$postcats;
			$selected=$postcats;
		}
	}
	if(get_query_var($directory_url.'_tag')!=''){
			$postcats = get_query_var($directory_url.'_tag');
			$args[$directory_url.'_tag']=$postcats;			
			$search_show=1;
	}	
	if( isset($_POST['keyword'])){
		if($_POST['keyword']!=""){
			$args['s']= sanitize_text_field($_REQUEST['keyword']);
			$keyword_post=sanitize_text_field($_POST['keyword']);
		}
	}
	// Meta Query***********************
$city_mq ='';
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
$zip_mq='';
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
$beds='';
if( isset($_POST['beds'])){
	if($_POST['beds']!=""){
		$beds=sanitize_text_field($_POST['beds']);
		$beds = array(
		'relation' => 'AND',
			array(
				'key'     => 'bedrooms',
				'value'   => sanitize_text_field($_REQUEST['beds']),
				'type'    => 'NUMERIC',
				'compare' => '>='
			),
		);
	}
}
	$baths='';
	if( isset($_POST['baths'])){
		if($_POST['baths']!=""){
			$baths = array(
		'relation' => 'AND',
			array(
				'key'     => 'bathrooms',
				'value'   => (int)sanitize_text_field($_REQUEST['baths']),
				'type'    => 'NUMERIC',
				'compare' => '>='
			),
		);
		}
	}
	$min_price='';
	if( isset($_POST['min_price'])){
		if($_POST['min_price']!=""){
			$min_price=$_POST['min_price'];
				$min_price = array(
				'relation' => 'AND',
					array(
						'key'     => 'sale_or_rent_price',
						'value'   => (int)sanitize_text_field($_REQUEST['min_price']),
						'type'    => 'NUMERIC',
						'compare' => '>=',
					),
				);
		}
	}
	$max_price='';
	if( isset($_REQUEST['max_price'])){
		if($_REQUEST['max_price']!=""){
			$min_price=$_REQUEST['max_price'];
				$min_price = array(
				'relation' => 'AND',
					array(
						'key'     => 'sale_or_rent_price',
						'value'   => (int)sanitize_text_field($_REQUEST['max_price']),
						'type'    => 'NUMERIC',
						'compare' => '<=',
					),
				);
		}
	}
	$area='';
	if( isset($_POST['area'])){
		if($_POST['area']!=""){
			$area=$_POST['area'];
			$area = array(
				'relation' => 'AND',
					array(
						'key'     => 'area',
						'value'   => (int)sanitize_text_field($_REQUEST['area']),
						'type'    => 'NUMERIC',
						'compare' => '>='
					),
				);
		}
	}
	$property_status_re='';
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
	$city_mq, $property_status, $zip_mq,$area,$min_price,$baths,$beds,$max_price,
);
$active_filter=get_option('active_filter');
if($active_filter==""){$active_filter='category';}
if($active_filter=="tag"){
	if( isset($_POST['tag_arr'])){
		if($_POST['tag_arr']!=""){
			$tag_arr= $_POST['tag_arr'];		
			$tags_string= implode("+", $tag_arr);
			$args['tag']= $tags_string;
		}
	}
}

$the_query = new WP_Query( $args );
$main_class = new wp_iv_property;
$dir_background_color=get_option('dir5_background_color');
if($dir_background_color==""){$dir_background_color='#EFEFEF';}
$active_filter='';
?>
<style>
.archieve-page{
    background:<?php echo esc_html($dir_background_color);?>;
}
</style>
<div class="bootstrap-wrapper">
<!-- archieve page own design font and others -->
<section class="archieve-page py-5">
<!-- Search Form -->
<?php
if($search_show==1){
	include(wp_iv_property_template.'property/archive-top-search.php');
}
?>
<!-- end of search form -->
<!-- sction for sort by catagory -->
<div class="container archieve-page "  >
  <div class="clearfix" >
   <div id="js-sort-juicy-projects" class="cbp-l-sort cbp-l-filters-right">
		<div class="cbp-l-dropdown">
			<div class="cbp-l-dropdown-wrap">
				<div class="cbp-l-dropdown-header"><?php  esc_html_e( 'Date', 'ivproperty' ); ?></div>
				<div class="cbp-l-dropdown-list">
					<div class="cbp-l-dropdown-item cbp-sort-item cbp-l-dropdown-item--active" data-sort=".cbp-l-grid-projects-date" data-sortBy="int:desc"   ><?php  esc_html_e( 'Date', 'ivproperty' ); ?></div>
					<div class="cbp-l-dropdown-item cbp-sort-item" data-sort=".cbp-l-grid-projects-title" data-sortBy="string:asc" ><?php  esc_html_e( 'Title', 'ivproperty' ); ?></div>
					<div class="cbp-l-dropdown-item cbp-sort-item" data-sort=".cbp-l-grid-projects-price" data-sortBy="int:asc" ><?php  esc_html_e( 'Price', 'ivproperty' ); ?></div>
					<div class="cbp-l-dropdown-item cbp-sort-item" data-sort=".cbp-l-grid-projects-size" data-sortBy="int:asc" ><?php  esc_html_e( 'Size', 'ivproperty' ); ?></div>
					 <?php
					$dir5_review_show=get_option('dir5_review_show');
					if($dir5_review_show==""){$dir5_review_show='yes';}
					if($dir5_review_show=='yes'){
					?>
					<div class="cbp-l-dropdown-item cbp-sort-item" data-sort=".cbp-l-grid-projects-review" data-sortBy="int:desc"><?php  esc_html_e( 'Review', 'ivproperty' ); ?></div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="cbp-l-direction cbp-l-direction--second">
			<div class="cbp-l-direction-item cbp-sort-item" data-sortBy="string:asc"></div>
			<div class="cbp-l-direction-item cbp-sort-item" data-sortBy="string:desc"></div>
		</div>
	</div>
    <div id="js-filters-meet-the-team" class="cbp-l-filters-button cbp-l-filters-alignLeft" >
    <?php
	$active_filter=get_option('active_filter');
	if($active_filter==""){$active_filter='category';}
	if($active_filter=="category"){
		if($postcats==''){	?>
      <div data-filter="*" class="cbp-filter-item">
        <?php  esc_html_e('Show All', 'ivproperty' ); ?>
      </div>
      <?php
					$argscat = array(
						'type'                     => $directory_url,
						'orderby'                  => 'name',
						'order'                    => 'ASC',
						'hide_empty'               => true,
						'hierarchical'             => 1,
						'exclude'                  => '',
						'include'                  => '',
						'number'                   => '',
						'taxonomy'                 => $directory_url.'-category',
						'pad_counts'               => false
					);
					$categories = get_categories( $argscat );
					if ( $categories && !is_wp_error( $categories ) ) :
						foreach ( $categories as $term ) {
							if(trim($term->name)!=''){
								echo '<div data-filter=".'.$term->slug.'" class="cbp-filter-item"> '.esc_html(ucfirst($term->name)).' <div class="cbp-filter-counter"></div></div>';
							}
						}
					endif;
					?>
			<?php
			}
			if($postcats!=''){ ?>
      <div data-filter="" class="cbp-filter-item"><a href="<?php echo get_post_type_archive_link( $directory_url) ; ?>">
        <?php  esc_html_e('Show All', 'ivproperty' ); ?>
        </a> </div>
      <?php
				 $term = get_term_by('slug', $postcats, $directory_url.'-category');
				 $name = (isset($term->name)? $term->name: $postcats);
				echo '<div data-filter=".'.$postcats.'"  class="cbp-filter-item-active cbp-filter-item"> '.esc_html($name).' <div class="cbp-filter-counter"></div></div>';
			}
	}
if($active_filter=="tag"){
	?>
	<div data-filter="*" class="cbp-filter-item">
	<?php  esc_html_e('Show All', 'ivproperty' ); ?>
	</div>
	<?php
	$args2 = array(
		'type'                     => $directory_url,		
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => true,
		'hierarchical'             => 1,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => $directory_url.'_tag',
		'pad_counts'               => false
	);
	$main_tag = get_categories( $args2 );
	if ( $main_tag && !is_wp_error( $main_tag ) ) :
		foreach ( $main_tag as $term_m ) {
			$checked='';
			echo '<div data-filter=".'.$term_m->slug.'" class="cbp-filter-item"> '.$term_m->name.' <div class="cbp-filter-counter"></div></div>';
	}
	endif;
}
$property_top_1_icon=get_option('property_top_1_icon');	
if($property_top_1_icon==""){$property_top_1_icon='fas fa-home';}
$property_top_2_icon=get_option('property_top_2_icon');	
if($property_top_2_icon==""){$property_top_2_icon='fas fa-bed';}
$property_top_3_icon=get_option('property_top_3_icon');	
if($property_top_3_icon==""){$property_top_3_icon='fas fa-shower';}	
$property_top_4_icon=get_option('property_top_4_icon');	
if($property_top_4_icon==""){$property_top_4_icon='fas fa-expand';}		
			?>
    </div>
  </div>
  </div>
    <!-- Item Filter Section -->
<div class="container archieve-page "  >
	  <div class="direc-item">
		<div id="js-grid-meet-the-team" class="cbp cbp-l-grid-team" >
		  <?php
			include( wp_iv_property_template. 'property/archive_feature_listing.php');
		$i=1;
		$dir_popup=get_option('_dir_popup');
		if($dir_popup==""){$dir_popup='yes';}
		 if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
					$id = get_the_ID();
			if(get_post_meta($id, 'realpro_featured', true)!='featured'){
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
						$post_author_id= get_post_field( 'post_author', $id );;
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
											$vip_image=$vip_img[0];
										}
								}else{
									$vip_image=wp_iv_property_URLPATH."/assets/images/vipicon.png";
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
									if($current_property_status =='For Rent'){$rent_text_m='' ;
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
											<img src="<?php echo esc_url($vip_image); ?>">
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
							 ?>
									</span>
								</p>
							</div>
								<div class="cbp-l-grid-projects-date none" ><?php echo strtotime(get_the_date('Ymd',$id));?></div>
								<div class="cbp-l-grid-projects-price none" ><?php echo get_post_meta($id,'sale_or_rent_price',true);?></div>
								<div class="cbp-l-grid-projects-size none" ><?php echo get_post_meta($id,'area',true);?></div>
						</div>
					</div>
				<?php
				$i++;
			}
		endwhile;
			?>
		  <?php else :
				$dirs_json=''; ?>
		  <?php  esc_html_e( 'Sorry, no posts matched your criteria.','ivproperty' ); ?>
		  <?php endif; ?>
		</div>
	  </div>
 </div>
	<?php
    if ( !$the_query->have_posts() ){
		?>
		<div class="container archieve-page "  >
		<?php
	  esc_html_e('Sorry, no posts matched your criteria.','ivproperty' );
	?>
		</div>
	<?php
	} ?>
<div class="container my-5 archieve-page">
    <div class="row">
        <div class="col d-flex justify-content-center align-item-center"  id="loadmore_button" >
			<div id="dirpro_loadmore" class="none"><img src="<?php echo wp_iv_property_URLPATH.'admin/files/images/loader.gif';?>"></div>
            <button id="load-more" class="px-5 loadmore-btn" type="button" name="button" onclick="wpdirp_loadmore();" ><?php  esc_html_e('Load More','ivproperty'); ?></button>
        </div>
    </div>
</div>
</section>
<!-- end of arhiece page -->
</div>
<!-- end of bootstrap wrapper -->
<!-- add js resources for bootstrap -->
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
if($grid_col375==""){$grid_col375='1';}
	wp_enqueue_script('jquery-ui', wp_iv_property_URLPATH . 'admin/files/js/jquery-ui.min.js');
	wp_enqueue_script('jquery.cubeportfolio', wp_iv_property_URLPATH . 'assets/cube/js/jquery.cubeportfolio.min.js');
	wp_enqueue_script('bootstrap', wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min.js');
	wp_enqueue_script('popper', wp_iv_property_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('iv_property-ar-script-26', wp_iv_property_URLPATH . 'assets/cube/js/meet-team.js');
	wp_localize_script('iv_property-ar-script-26', 'dirpro_data', array(
		'grid_col1500'=>$grid_col1500,
		'grid_col1100'=>$grid_col1100,
		'grid_col768'=>$grid_col768,
		'grid_col480'=>$grid_col480,
		'grid_col375'=>$grid_col375,
		) );
	wp_enqueue_script('iv_property-ar-script-27', wp_iv_property_URLPATH . 'admin/files/js/archive-listing.js');
	wp_localize_script('iv_property-ar-script-27', 'realpro_data', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.wp_iv_property_URLPATH.'admin/files/images/loader.gif">',
		'current_user_id'	=>get_current_user_id(),
		'dirwpnonce'=> wp_create_nonce("listing"),
		) );
?>