<?php
wp_enqueue_style('bootstrap-iv_property-110', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
wp_enqueue_style('iv_property-style-111', wp_iv_property_URLPATH . 'admin/files/css/styles.css');
$dir_style_font=get_option('dir_style_font');
if($dir_style_font==""){$dir_style_font='no';}
if($dir_style_font=='yes'){
	wp_enqueue_style('iv_property-font-110', wp_iv_property_URLPATH . 'admin/files/css/quicksand-font.css');
}
global $post,$wpdb,$tag;
$directory_url=get_option('_iv_property_url');
if($directory_url==""){$directory_url='property';}
$post_limit='9999';
if(isset($atts['post_limit']) and $atts['post_limit']!="" ){
 $post_limit=$atts['post_limit'];
}
$postcats_arr=array();
if(isset($atts['slugs'])){
		$postcats = $atts['slugs'];
		$postcats_arr=explode(',',$postcats);
}
?>
<section id="destination" class="background-transparent">
	<section class="bootstrap-wrapper background-transparent">
		<div class="container dynamic-bg">
			<div class="row mt-5 cities-sec-row">
			<?php
						if( isset($_POST['submit'])){
							$selected = sanitize_text_field($_POST['property-category']);
						}
							//property
							$taxonomy = $directory_url.'-category';
							$args = array(
								'orderby'           => 'name',
								'order'             => 'ASC',
								'hide_empty'        => true,
								'exclude'           => array(),
								'exclude_tree'      => array(),
								'include'           => array(),
								'number'            => $post_limit,
								'fields'            => 'all',
								'slug'              => $postcats_arr,							
								'hierarchical'      => true,
								'child_of'          => 0,
								'childless'         => false,
								'show_count'        => '1',
							);
				$terms = get_terms($taxonomy,$args); // Get all terms of a taxonomy
				if ( $terms && !is_wp_error( $terms ) ) :
						$i=0;
						foreach ( $terms as $term_parent ) {
							if($term_parent->count>0){
								$feature_img_id = get_option('_cate_main_image_'.$term_parent->term_id);
								$feature_img='';
								$feature_image = wp_get_attachment_image_src( $feature_img_id, 'large' );
								if($feature_image[0]!=""){
									$feature_img=$feature_image[0];
									$feature_img_width=$feature_image[1];
									$feature_img_height=$feature_image[2];
								}
								if($feature_img==""){
									$feature_img=wp_iv_property_URLPATH."/assets/images/default-directory.jpg";
								}
								 $cat_link= get_term_link($term_parent , $directory_url.'-category');
							?>
									<div class="col-md-6 col-lg-4 mb-5">
										<div class="img_overlay_container">
                      <div class="img_overlay rounded "></div>
										<a href="<?php echo esc_url($cat_link); ?>">
											<img   src="<?php echo esc_url($feature_img);?>" class="rounded w-100 img-fluid cities_img">
										</a>
											<h6 class="cities_title text-center text-white"><?php echo esc_html($term_parent->name); ?> <small class="text-white text-break">( <?php echo esc_html($term_parent->count); ?> )</small></h6>
										</div>
									</div>
						<?php
							}
						}
				endif;
				?>
			</div>
		</div>
	</section>
</section>