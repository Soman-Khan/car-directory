<?php
wp_enqueue_style('bootstrap-iv_property-110', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
wp_enqueue_style('iv_property-style-111', wp_iv_property_URLPATH . 'admin/files/css/styles.css');
wp_enqueue_script("jquery");
wp_enqueue_script('popper', wp_iv_property_URLPATH . 'admin/files/js/popper.min.js');
wp_enqueue_script('bootstrap-min-4-iv_property-script-24', wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min-4.js');
wp_enqueue_script('slick', wp_iv_property_URLPATH . 'admin/files/css/slick/slick.js');
$dir_style_font=get_option('dir_style_font');
if($dir_style_font==""){$dir_style_font='no';}
if($dir_style_font=='yes'){
	wp_enqueue_style('iv_property-font-110', wp_iv_property_URLPATH . 'admin/files/css/quicksand-font.css');
}
$dir_background_color='#EFEFEF';
if(isset($atts['bgcolor']) and $atts['bgcolor']!="" ){
	$dir_background_color=$atts['bgcolor'];
}
$directory_url=get_option('_iv_property_url');
if($directory_url==""){$directory_url='property';}
$property_top_1_icon=get_option('property_top_1_icon');
if($property_top_1_icon==""){$property_top_1_icon='fas fa-home';}
$property_top_2_icon=get_option('property_top_2_icon');
if($property_top_2_icon==""){$property_top_2_icon='fas fa-bed';}
$property_top_3_icon=get_option('property_top_3_icon');
if($property_top_3_icon==""){$property_top_3_icon='fas fa-shower';}
$property_top_4_icon=get_option('property_top_4_icon');
if($property_top_4_icon==""){$property_top_4_icon='fas fa-expand';}
$post_limit='10';
if(isset($atts['post_limit']) and $atts['post_limit']!="" ){
 $post_limit=$atts['post_limit'];
}
	$dirs_data =array();
	$tag_arr= array();
	$paged =1;
	$args = array(
		'post_type' => $directory_url, // enter your custom post type
		'paged' => $paged,
		'post_status' => 'publish',
		'orderby'	=> 'rand',
		'posts_per_page'=> $post_limit,  // overrides posts per page in theme settings
	);
	$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
	// Add new shortcode only category
	if(isset($atts['category']) and $atts['category']!="" ){
			$postcats = sanitize_text_field($atts['category']);
			$args[$directory_url.'-category']=$postcats;
	}
	// Meta Query***********************
$city_mq ='';
if(isset($atts['dir_city']) AND $atts['dir_city']!=''){
		$city_mq = array(
		'relation' => 'AND',
			array(
				'key'     => 'city',
				'value'   => sanitize_text_field($atts['dir_city']),
				'compare' => 'LIKE'
			),
		);
}
$zip_mq='';
if(isset($atts['zipcode']) AND $atts['zipcode']!=''){
	$zip_mq = array(
		'relation' => 'AND',
			array(
				'key'     => 'postcode',
				'value'   => sanitize_text_field($atts['zipcode']),
				'compare' => 'LIKE'
			),
		);
}
$beds='';
if( isset($atts['beds'])){
	if($atts['beds']!=""){
		$beds=$atts['beds'];
		$beds = array(
		'relation' => 'AND',
			array(
				'key'     => 'bedrooms',
				'value'   => sanitize_text_field($atts['beds']),
				'type'    => 'numeric',
				'compare' => '>='
			),
		);
	}
}
	$baths='';
	if( isset($atts['baths'])){
		if($atts['baths']!=""){
			$baths = array(
		'relation' => 'AND',
			array(
				'key'     => 'bathrooms',
				'value'   => (int)sanitize_text_field($atts['baths']),
				'type'    => 'numeric',
				'compare' => '>='
			),
		);
			$search_show=1;
			$args['posts_per_page']='999999';
		}
	}
	$min_price='';
	if( isset($atts['min_price'])){
		if($atts['min_price']!=""){
			$min_price=$atts['min_price'];
				$min_price = array(
				'relation' => 'AND',
					array(
						'key'     => 'sale_or_rent_price',
						'value'   => (int)sanitize_text_field($atts['min_price']),
						'type'    => 'numeric',
						'compare' => '>='
					),
				);
		}
	}
	$area='';
	if( isset($atts['area'])){
		if($atts['area']!=""){
			$area=$atts['area'];
			$area = array(
				'relation' => 'AND',
					array(
						'key'     => 'area',
						'value'   => (int)sanitize_text_field($atts['area']),
						'type'    => 'numeric',
						'compare' => '>='
					),
				);
		}
	}
	$property_status_re='';
	$property_status='';
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
$args['meta_query'] = array(
	$city_mq, $property_status, $zip_mq,$area,$min_price,$baths,$beds,
);
global $wpdb;
$rand_div=rand(10,100);
 $properties = new WP_Query( $args );
?>
<style>
.main-container{
    background:<?php echo esc_html($dir_background_color);?>;
}
</style>
<?php
wp_enqueue_style('all', wp_iv_property_URLPATH . 'admin/files/css/all.min.css');
wp_enqueue_style('slick', wp_iv_property_URLPATH . 'admin/files/css/slick/slick.css');
?>
<!-- slick slider -->
<section class="property-carousel" style="background:<?php echo esc_html($dir_background_color);?> !important;">
  <div class="bootstrap-wrapper background-transparent" >
    <div class="container main-container py-3 background-transparent" >
      <div class="slick-controls<?php echo esc_html($rand_div);?>">
          <p class="next1" id="next1<?php echo esc_html($rand_div);?>"><i class="fas fa-angle-right"></i></p>
          <p class="previous1" id="previous1<?php echo esc_html($rand_div);?>"><i class="fas fa-angle-left"></i></p>
      </div>
      <div class="row multiple-items mb-2" id="multiple-items<?php echo esc_html($rand_div);?>">
  			<?php
  				$i=0;
  				 if ( $properties->have_posts() ) :
  					while ( $properties->have_posts() ) : $properties->the_post();
  					$id = get_the_ID();
  			?>
  				   <div class="col-md-12">
  					     <div class="card border-0 rounded">
                     <a href="<?php echo get_the_permalink($id);?>">
         								<?php	if(has_post_thumbnail($id)){
         										$fsrc= wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
         												 if($fsrc[0]!=""){
         													$fsrc =$fsrc[0];
         												}
         											 ?>
         											<img src="<?php  echo esc_html($fsrc);?>" class="rounded-top card-img-top w-100 height200" >
         										<?php
         										}else{	?>
         											<img src="<?php  echo wp_iv_property_URLPATH."/assets/images/default-directory.jpg";?>" class="rounded-top w-100 card-img-top height200" >
         										<?php
         									}
         								?>
         						</a>
         					  <div class="card-body card-body-min-height pt-4 text-center">
         							<a href="<?php echo get_the_permalink($id);?>"><p class="realtitle"><?php echo get_the_title($id); ?></p></a>
         						 <p class="address"><?php echo get_post_meta($id,'address',true);?> <?php echo get_post_meta($id,'city',true);?> <?php echo get_post_meta($id,'zipcode',true);?> <?php echo get_post_meta($id,'country',true);?></p>
         						<p class="mt-2 short-desc"><?php
         							if(get_post_meta($id,'area',true)!=""){ ?>
         									<i class="<?php echo esc_html($property_top_4_icon);?> fa-xs ml-1"></i> <?php
         									echo get_post_meta($id,'area',true).' '.get_post_meta($id,'area_postfix_text',true).' ';
         									?>
         							<?php
         							}
         							?>
         							<?php
         							if(get_post_meta($id,'bedrooms',true)!=""){ ?>
         							<i class="<?php echo esc_html($property_top_2_icon);?> fa-xs ml-1"></i> <?php
         							echo esc_html(get_post_meta($id,'bedrooms',true));
         							?><?php  esc_html_e(' Bedrooms','ivproperty'); ?>
         							<?php
         								}
         							?>
         							<?php
         							if(get_post_meta($id,'bathrooms',true)!=""){ ?>
         							<i class="<?php echo esc_html($property_top_3_icon);?> fa-xs ml-1"></i> <?php
         							echo get_post_meta($id,'bathrooms',true);
         							?><?php  esc_html_e(' Baths ','ivproperty'); ?>
         							<?php
         								}
         							?>
         							<?php
         							if(trim(get_post_meta($id,'garages',true))!=""){ ?>
         							<i class="fas fa-car fa-xs ml-1"></i> <?php
         							echo get_post_meta($id,'garages',true);
         							?><?php  esc_html_e(' Garage ','ivproperty'); ?>
         							<?php
         								}
         							?>
         							<?php
         							if(get_post_meta($id,'guest',true)!=""){ ?>
         							<i class="fas fa-user fa-xs ml-1"></i> <?php
         							echo get_post_meta($id,'guest',true);
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
  			endwhile;
  		endif;
  			?>
       </div>
    </div>
  </div>
</section>
<?php
wp_enqueue_script('iv_property-listing-carousel', wp_iv_property_URLPATH . 'admin/files/js/listing-carousel.js');
wp_localize_script('iv_property-listing-carousel', 'realpro_data10', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'rand_div'		=>  $rand_div,
		) );
?>
