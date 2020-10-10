<div class="container mt-5">
	<form class="advance_search my-5" method="POST" id="dirprosearch" <?php echo esc_html($form_action);?>>
		<div class="form-row top-search-form-top-row">
			<?php
				$dir_search_keyword=get_option('_dir_search_keyword');
				if($dir_search_keyword==""){$dir_search_keyword='yes';}
				if($dir_search_keyword=='yes'){
					$keyword_post= (isset($_REQUEST['keyword'])?sanitize_text_field($_REQUEST['keyword']):'' );
				?>
				<div class="form-group col-md-4">
					<input type="text" class="form-control rounded-0 border-0"  id="keyword" name="keyword"  placeholder="<?php  esc_html_e( 'Keyword', 'ivproperty' ); ?>" value="<?php echo esc_html($keyword_post); ?>" >
					<?php $pos = $main_class->get_unique_keyword_values('keyword',$current_post_type);
					?>	
					<script>
						jQuery(function() {
							var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
							jQuery( "#keyword" ).autocomplete({source: availableTags});
						});
					</script>
				</div>
				<?php
				}
			?>
			<?php
				$dir_search_type=get_option('_dir_search_type');
				if($dir_search_type==""){$dir_search_type='no';}
				if($dir_search_type=='yes'){
				?>
				<div class="form-group col-md-2" >
					<select name="property-type" id="inputState" class="form-control rounded-0 border-0">
						<option  value=""><?php  esc_html_e('Type','ivproperty'); ?></option>
						<?php
							$property_status_all=get_option('property_status');
							if($property_status_all==""){$property_status_all='For Rent, For Sale, Sold';}
							$property_status_request= (isset($_REQUEST['property-type'])?sanitize_text_field($_REQUEST['property-type']):'' );
							$property_status_all_arr= explode(',',$property_status_all);
							foreach($property_status_all_arr as $property_statusone){
								echo' <option '.(trim($property_status_request)==trim($property_statusone)? 'selected="selected"':'' ).' value="'.trim($property_statusone).'">'.esc_html__($property_statusone,'ivproperty').'</option>';
							}
						?>
					</select>
				</div>
				<?php
				}
			?>
			<?php
				$dir_search_city=get_option('_dir_search_city');
				if($dir_search_city==""){$dir_search_city='yes';}
				if($dir_search_city=='yes'){
					// City
					$args_citys = array(
					'post_type'  => $current_post_type,
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
						$new_city=trim(ucfirst(get_post_meta($term->ID,'city',true)));
						if($new_city!=''){
							if (!in_array($new_city, $get_cityies)) {
								$get_cityies[]=$new_city;
							}
						}	
					}
					$get_cityies=array_map('trim',$get_cityies);
					// City
				?>
			  <div class="form-group col-md-2">
					<select name="dir_city"  id="inputState" class="form-control rounded-0 border-0">
						<option   value=""><?php esc_html_e('Choose a City','ivproperty'); ?></option>
						<?php
							$selected_city= (isset($_REQUEST['dir_city'])?$_REQUEST['dir_city']:'' );
							if(count($get_cityies)) {
								asort($get_cityies);
								foreach($get_cityies as $row1) {
									if($row1!=''){
									?>
									<option   value="<?php echo esc_html($row1); ?>" <?php echo (strtolower($selected_city)==strtolower($row1)?'selected':''); ?>><?php echo esc_html($row1); ?></option>
									<?php
									}
								}
							}
						?>
					</select>
				</div>
				<?php
				}
			?>
			<div class="form-group col-md-2 d-flex align-items-center justify-content-center mx-1 mx-md-0 font-weight-bold" id="advance">
				<i class="fas fa-cog mr-2"></i> <?php esc_html_e('Advance','ivproperty'); ?>
			</div>
			<div class="form-group col-md-2">
				<button type="submit" class="btn btn-primary btn-block flat-border rounded-0 border-0 search-button-font" ><?php  esc_html_e( 'Search', 'ivproperty' ); ?></button>
			</div>
		</div>
		<div class="form-row" id="top-search-form-advance-row">
		  <?php
				$_dir_search_zipcode=get_option('_dir_search_zipcode');
				if($_dir_search_zipcode==""){$dir_search_location='yes';}
				if($_dir_search_zipcode=='yes'){
					$zipcode=(isset($_REQUEST['zipcode'])?$_REQUEST['zipcode']:'' );
				?>
				<div class="form-group col-md-3" >
					<input type="text"  id="zipcode" name="zipcode"  class="form-control rounded-0 border-0" placeholder="<?php  esc_html_e( 'Zipcode', 'ivproperty' ); ?>"
					value="<?php echo trim($zipcode); ?>">
					<?php $pos = $main_class->get_unique_post_meta_values('postcode',$directory_url);
					?>	
					<script>
					  jQuery(function() {
							var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
							jQuery( "#zipcode" ).autocomplete({source: availableTags});
						});
					</script>
				</div>
				<?php
				}
			?>
			<?php
				$dir_search_category=get_option('_dir_search_category');
				if($dir_search_category==""){$dir_search_category='yes';}
				if($dir_search_category=='yes'){
				?>
				<div class="form-group col-md-3" >
					<?php
						echo '<select name="property-category" id="inputState" class="form-control rounded-0 border-0">';
						echo'	<option selected="'.$selected.'" value="">'.esc_html__('Any Category','ivproperty').'</option>';
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
							echo '<option  value="'.$term_parent->slug.'" '.($selected==$term_parent->slug?'selected':'' ).'><strong>'.$term_parent->name.'<strong></option>';
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
								echo '<option  value="'.$term->slug.'" '.($selected==$term->slug?'selected':'' ).'>-'.$term->name.'</option>';
							}
							endif;
							$i++;
						}
						endif;
						echo '</select>';
					?>
				</div>
				<?php
				}
			?>
		  <?php
				$dir_search_price=get_option('_dir_search_price');
				if($dir_search_price==""){$dir_search_location='no';}
				if($dir_search_price=='yes'){
				?>
				<div class="form-group col-md-3" >
					<input type="text"  id="min_price" name="min_price"  class="form-control rounded-0 border-0" value="<?php echo (isset($_REQUEST['min_price'])? sanitize_text_field($_REQUEST['min_price']):'' ); ?>"  placeholder="<?php  esc_html_e( 'Min Price[only number]', 'ivproperty' ); ?>" >
				</div>
				<?php
				}
			?>
			<?php
				$dir_search_price=get_option('_dir_search_price');
				if($dir_search_price==""){$dir_search_location='no';}
				if($dir_search_price=='yes'){
				?>
				<div class="form-group col-md-3" >
					<input type="text"  id="max_price" name="max_price"  class="form-control rounded-0 border-0" value="<?php echo (isset($_REQUEST['max_price'])? sanitize_text_field($_REQUEST['max_price']):'' ); ?>"  placeholder="<?php  esc_html_e( 'Max Price', 'ivproperty' ); ?>" >
				</div>
				<?php
				}
			?>
			<?php
				$dir_search_area=get_option('_dir_search_area');
				if($dir_search_area==""){$dir_search_area='no';}
				if($dir_search_area=='yes'){
				?>
				<div class="form-group col-md-3" >
					<input type="text"  id="area" name="area" class="form-control rounded-0 border-0" value="<?php echo (isset($_REQUEST['area'])?sanitize_text_field($_REQUEST['area']):'' );  ?>"   placeholder="<?php  esc_html_e( 'Min Area (Only number)', 'ivproperty' ); ?>" >
				</div>
				<?php
				}
			?>
			<?php
				$dir_search_beds=get_option('_dir_search_beds');
				if($dir_search_beds==""){$dir_search_redius='no';}
				if($dir_search_beds=='yes'){
				?>
				<div class="form-group col-md-3" >
					<input type="text" id="beds" name="beds"  class="form-control rounded-0 border-0" value="<?php echo (isset($_REQUEST['beds'])?sanitize_text_field($_REQUEST['beds']):'' ); ?>" placeholder="<?php  esc_html_e( 'Min Beds', 'ivproperty' ); ?>" >
				</div>
				<?php
				}
			?>
			<?php
				$dir_search_baths=get_option('_dir_search_baths');
				if($dir_search_baths==""){$dir_search_baths='no';}
				if($dir_search_baths=='yes'){
				?>
				<div class="form-group col-md-3 border-0" >
					<input type="text"  id="baths" name="baths"  class="form-control rounded-0 border-0" value="<?php echo (isset($_REQUEST['baths'])?sanitize_text_field($_REQUEST['baths']):'' ); ?>"   placeholder="<?php  esc_html_e( 'Min Baths', 'ivproperty' ); ?>">
				</div>
				<?php
				}
			?>				
		</div>
	</form>
</div>
