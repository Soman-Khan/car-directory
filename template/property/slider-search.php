<?php
wp_enqueue_style('bootstrap-iv_property-110', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
wp_enqueue_style('iv_property-style-111', wp_iv_property_URLPATH . 'admin/files/css/styles.css');
wp_enqueue_script('bootstrap-iv_property-ar', wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min-4.js');
wp_enqueue_script('popper', wp_iv_property_URLPATH . 'admin/files/js/popper.min.js');
global $post,$wpdb;
$directory_url=get_option('_iv_property_url');
if($directory_url==""){$directory_url='property';}
?>
<section id="slider-search background-transparent-slider" >
  <div class="bootstrap-wrapper background-transparent" >
    <div class="container background-transparent-slider" >
      <div class="row my-0 py-0">
        <div class="col-md-12 my-0 py-0">
          <form class="p-0 m-0" action="<?php echo get_post_type_archive_link( $directory_url ) ; ?>" >
            <div class="form-row slider-line-height" >
              <div class="form-group col-md-3 slider-line-height">
			  <?php
			  // City
						$args_citys = array(
							'post_type'  => $directory_url,
							'posts_per_page' => -1,
							'meta_query' => array(
								array(
									'key'     => 'city',
									'orderby' => 'meta_value',
									'order' => 'ASC',
								),
							),
						);
						$citys = new WP_Query( $args_citys );
						$citys_all = $citys->posts;
						$get_cityies =array();
						foreach ( $citys_all as $term ) {
							$new_city="";
							$new_city=get_post_meta($term->ID,'city',true);
							if (!in_array($new_city, $get_cityies)) {
								$get_cityies[]=$new_city;
							}
						}
					// City
			  ?>
					<select class="form-control form-control-sm slider-line-height40" name="dir_city" >
						 <option   value="" class="slider-line-height" ><?php esc_html_e('Choose a City','ivproperty'); ?></option>
				   <?php
					if(count($get_cityies)) {
						asort($get_cityies);
					  foreach($get_cityies as $row1) {
						  if($row1!=''){
						  ?>
						<option   value="<?php echo esc_html($row1); ?>"><?php echo esc_html($row1); ?></option>
						<?php
						}
						}
					}
					?>
					</select>
              </div>
              <div class="form-group col-md-3 my-0 py-0 slider-line-height" >
                <select  name="property-type" class="form-control form-control-sm slider-line-height40" >
                   <option   value=""><?php  esc_html_e('Any Type','ivproperty'); ?></option>
					<?php
					$property_status_all=get_option('property_status');
					if($property_status_all==""){$property_status_all='For Rent,For Sale,Sold';}
					$property_status_all_arr= explode(',',$property_status_all);
					foreach($property_status_all_arr as $property_statusone){
						echo' <option value="'.trim($property_statusone).'">'.esc_html__($property_statusone,'ivproperty').'</option>';
					}
					?>
					</select>
                </select>
              </div>
              <div class="form-group col-md-3 my-0 py-0 slider-line-height" >
                <select name="property-category" class="form-control form-control-sm slider-line-height40" >
                  <option value=""><?php  esc_html_e('Any Category','ivproperty');?></option>
				  <?php
										$taxonomy = $directory_url.'-category';
										$args = array(
											'orderby'           => 'name',
											'order'             => 'ASC',
											'hide_empty'        => true,
											'exclude'           => array(),
											'exclude_tree'      => array(),
											'include'           => array(),
											'number'            => '',
											'fields'            => 'all',
											'slug'              => '',
											'parent'            => '0',
											'hierarchical'      => true,
											'child_of'          => 0,
											'childless'         => false,
											'get'               => '',
										);
							$terms = get_terms($taxonomy,$args); // Get all terms of a taxonomy
							if ( $terms && !is_wp_error( $terms ) ) :
								$i=0;
								foreach ( $terms as $term_parent ) {
										echo '<option  value="'.$term_parent->slug.'" ><strong>'.$term_parent->name.'<strong></option>';
										?>
											<?php
											$args2 = array(
												'type'                     => $directory_url,
												'parent'                   => $term_parent->term_id,
												'orderby'                  => 'name',
												'order'                    => 'ASC',
												'hide_empty'               => 1,
												'hierarchical'             => 1,
												'exclude'                  => '',
												'include'                  => '',
												'number'                   => '',
												'taxonomy'                 => $directory_url.'-category',
												'pad_counts'               => false
											);
											$categories = get_categories( $args2 );
											if ( $categories && !is_wp_error( $categories ) ) :
												foreach ( $categories as $term ) {
													echo '<option  value="'.$term->slug.'">-'.$term->name.'</option>';
												}
											endif;
									$i++;
								}
							endif;
						?>
                </select>
              </div>
              <div class="form-group col-md-3 my-0 py-0 slider-line-height" >
                <button type="submit" class="btn btn-sm btn-block btn-secondary text-center slider-line-height40"><?php  esc_html_e('Search','ivproperty');?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>