<?php
	$dir_map_api=get_option('_dir_map_api');	
	if($dir_map_api==""){$dir_map_api='';}	
	$directory_url=get_option('_iv_property_url');					
	if($directory_url==""){$directory_url='property';}
	$map_api_have='no';
?>
<script type='text/javascript' src='<?php echo esc_url('https://maps.googleapis.com/maps/api/js?libraries=places&key');?>=<?php echo esc_html($dir_map_api);?>'></script>
<div class="profile-content">
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject"> <?php  esc_html_e('Add New Listing','ivproperty'); ?></span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1_1">
					<?php					
						global $wpdb;
						// Check Max\
						$package_id=get_user_meta($current_user->ID,'iv_property_package_id',true);						
						$max=get_post_meta($package_id, 'iv_property_package_max_post_no', true);
						if($max==""){
							$user_role= $current_user->roles[0];
							if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
								$max=999999;
							}	
						}
						$sql=$wpdb->prepare("SELECT count(*) as total FROM $wpdb->posts WHERE post_type ='%s'  and post_author='%d'",$directory_url, $current_user->ID);									
						$all_post = $wpdb->get_row($sql);
						$my_post_count=$all_post->total;
						if ( $my_post_count>=$max or !current_user_can('edit_posts') )  {
							$iv_redirect = get_option( '_iv_property_profile_page');							
							$reg_page= get_permalink( $iv_redirect); 							
						?>
						<?php  esc_html_e('Please Upgrade Your Account','ivproperty'); ?>
						<a href="<?php echo esc_url($reg_page).'?&profile=level'; ?>" title="Upgarde"><b><?php  esc_html_e('Here','ivproperty'); ?> </b></a> 
						<?php  esc_html_e('To Add More Post.','ivproperty'); ?>	
						<?php
							}else{
						?>					
						<div class="row">
							<div class="col-md-12">	 
								<form action="" id="new_post" name="new_post"  method="POST" role="form">
									<div class=" form-group">
										<label for="text" class=" control-label"><?php  esc_html_e('Title','ivproperty'); ?></label>
										<div class="  "> 
											<input type="text" class="form-control" name="title" id="title" value="" placeholder="<?php  esc_html_e('Enter Title Here','ivproperty'); ?>">
										</div>																		
									</div>								
									<div class="form-group">
										<div class=" ">
											<?php
												$settings_a = array(															
												'textarea_rows' =>8,
												'editor_class' => 'form-control'															 
												);
												$editor_id = 'new_post_content';
												wp_editor( '', $editor_id,$settings_a );										
											?>
										</div>
									</div>
									<div class=" row form-group ">
										<label for="text" class=" col-md-5 control-label"><?php  esc_html_e('Feature Image','ivproperty'); ?>  </label>
										<div class="col-md-4" id="post_image_div">
											<a  href="javascript:void(0);" onclick="edit_post_image('post_image_div');"  >									
												<?php  echo '<img width="100px" src="'. wp_iv_property_URLPATH.'assets/images/image-add-icon.png">'; ?>			
											</a>					
										</div> 
										<input type="hidden" name="feature_image_id" id="feature_image_id" value="">
										<div class="col-md-3" id="post_image_edit">	
											<button type="button" onclick="edit_post_image('post_image_div');"  class="btn btn-xs green-haze"><?php  esc_html_e('Add','ivproperty'); ?> </button>
										</div>									
									</div>
									<div class=" row form-group ">
										<label for="text" class=" col-md-5 control-label"><?php  esc_html_e('Image Gallery','ivproperty'); ?> 
											<button type="button" onclick="edit_gallery_image('gallery_image_div');"  class="btn btn-xs green-haze"><?php  esc_html_e('Add Images','ivproperty'); ?></button>
										</label>						
									</div>
									<div class=" row form-group ">	
										<input type="hidden" name="gallery_image_ids" id="gallery_image_ids" value="">
										<div class="col-md-12" id="gallery_image_div">
										</div>									
									</div>
									<div class="clearfix"></div>
									<div class=" row form-group ">
										<label for="text" class=" col-md-12 control-label"><?php  esc_html_e('Status','ivproperty'); ?>  </label>
										<div class="col-md-12" id="">										
											<select name="post_status" id="post_status"  class="form-control">
												<?php										
													if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){?>
													<option value="publish"><?php esc_html_e('Publish','ivproperty'); ?></option>
													<?php
													}	
												?>													
												<option value="pending"><?php esc_html_e('Pending Review','ivproperty'); ?></option>
												<option value="draft" ><?php esc_html_e('Draft','ivproperty'); ?></option>	
											</select>										
										</div>				
									</div>
									<div class="clearfix"></div>
									<div class=" row form-group">
										<label for="text" class=" col-md-12 control-label"><?php  esc_html_e('Property Status','ivproperty'); ?></label>									
										<div class=" col-md-12 "> 								
											<select name="property_type" class="form-control ">		
												<?php
													$property_status='';
													$property_status_all=get_option('property_status');					
													if($property_status_all==""){$property_status_all='For Rent, For Sale, Sold';}
													$property_status_all_arr= explode(',',$property_status_all);
													foreach($property_status_all_arr as $property_statusone){ 
														echo' <option '. ($property_status ==$property_statusone ? 'selected':'' ).' value="'.trim($property_statusone).'">'.esc_html__($property_statusone,'ivproperty').'</option>';
													}											
												?>	
											</select>									
										</div>																		
									</div>
									<div class="clearfix"></div>
									<div class=" row form-group">
										<label for="text" class=" col-md-12 control-label"><?php  esc_html_e('Property Type','ivproperty'); ?></label>									
										<div class=" col-md-12 "> 
											<?php
												echo '<select name="postcats[]" class="form-control "  multiple="multiple">';
												echo'	<option selected="'.$selected.'" value="">'.esc_html__('Choose a type','ivproperty').'</option>';
												$selected='';
												if( isset($_POST['submit'])){
													$selected = sanitize_text_field($_POST['postcats']);
												}
												//property
												$taxonomy = $directory_url.'-category';
												$args = array(
												'orderby'           => 'name', 
												'order'             => 'ASC',
												'hide_empty'        => false, 
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
												foreach ( $terms as $term_parent ) {  ?>												
												<?php  
													echo '<option  value="'.$term_parent->slug.'" '.($selected==$term_parent->slug?'selected':'' ).'><strong>'.$term_parent->name.'<strong></option>';
												?>	
												<?php
													$args2 = array(
													'type'                     => $directory_url,						
													'parent'                   => $term_parent->term_id,
													'orderby'                  => 'name',
													'order'                    => 'ASC',
													'hide_empty'               => 0,
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
														echo '<option  value="'.$term->slug.'" '.($selected==$term->slug?'selected':'' ).'>--'.$term->name.'</option>';
													} 	
													endif;		
												?>
												<?php
													$i++;
												} 								
												endif;	
												echo '</select>';	
											?>		
										</div>
									</div>
									<div class=" form-group row">
										<div class="col-md-6 "> 
											<label for="text" class=" control-label "><?php  esc_html_e('Address','ivproperty'); ?></label>							
											<input type="text" class="form-control " name="address" value="" placeholder="<?php  esc_html_e('Enter address Here','ivproperty'); ?>">
										</div>							
										<div class=" col-md-6"> 
											<label for="text" class=" control-label "><?php  esc_html_e('Area','ivproperty'); ?></label>	
											<input type="text" class="form-control " name="area" id="area" value="" placeholder="<?php  esc_html_e('Enter Area Here','ivproperty'); ?>">
										</div>														
									</div>
									<div class=" form-group ">
										<label for="text" class=" control-label"><?php  esc_html_e('Local Area','ivproperty'); ?></label>							
										<div class=" "> 
											<input type="text" class="form-control" name="local-area" id="local-area" value="" placeholder="<?php  esc_html_e('Enter area here','ivproperty'); ?>">
										</div>
									</div>
									<div class=" form-group row">
										<div class="col-md-6 "> 
											<label for="text" class=" control-label "><?php  esc_html_e('City','ivproperty'); ?></label>
											<input type="text" class="form-control " name="city" id="city" value="" placeholder="<?php  esc_html_e('Enter city ','ivproperty'); ?>">
										</div>
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('Zipcode','ivproperty'); ?></label>							
											<input type="text" class="form-control " name="postcode" id="postcode" value="" placeholder="<?php  esc_html_e('Enter Zipcode ','ivproperty'); ?>">
										</div>
									</div>
									<div class=" form-group row">
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('State','ivproperty'); ?></label>	
											<input type="text" class="form-control " name="state" id="state" value="" placeholder="<?php  esc_html_e('Enter State ','ivproperty'); ?>">
										</div>
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('Country','ivproperty'); ?></label>							
											<input type="text" class="form-control " name="country" id="country" value="" placeholder="<?php  esc_html_e('Enter Country ','ivproperty'); ?>">
										</div>
									</div>	
									<div class=" form-group row">
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('Latitude','ivproperty'); ?></label>
											<input type="text" class="form-control " name="latitude" id="latitude" value="" placeholder="<?php  esc_html_e('Enter latitude ','ivproperty'); ?>">
										</div>
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('Longitude','ivproperty'); ?></label>	
											<input type="text" class="form-control " name="longitude" id="longitude" value="" placeholder="<?php  esc_html_e('Enter longitude ','ivproperty'); ?>">
										</div>
									</div>
									<?php
										if($map_api_have=='yes'){
										?>	
										<div class=" form-group">
											<label for="text" class=" control-label"><?php  esc_html_e('Address Map','ivproperty'); ?></label>							
											<div class=" "> 
												<div  id="map-canvas"  ></div>											
											</div>																
											
										</div>
										<?php
										}
									?>
									<div class="clearfix"></div>	
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title col-lg-10">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour2">
													<?php  esc_html_e('Property Detail','ivproperty'); ?>
												</a>
											</h4>
											<h4 class="panel-title text-right" >
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour2">
													<?php  esc_html_e('[ Edit ]','ivproperty'); ?> 
												</a>
											</h4>
										</div>
										<div id="collapseFour2" class="panel-collapse collapse">
											<div class="panel-body">											
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Bedrooms','ivproperty'); ?></label>						
													<div class="  "> 
														<input type="text" class="form-control" name="bedrooms" id="bedrooms" value="" placeholder="<?php  esc_html_e('Enter # Bedrooms','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Bathrooms','ivproperty'); ?></label>
													<div class="  "> 
														<input type="text" class="form-control" name="bathrooms" id="bathrooms" value="" placeholder="<?php  esc_html_e('Enter # Bathrooms','ivproperty'); ?>">
													</div>																
												</div>	
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Guest Room','ivproperty'); ?></label>
													<div class="  "> 
														<input type="text" class="form-control" name="guest" id="guest" value="" placeholder="<?php  esc_html_e('Enter # guest room','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Garages','ivproperty'); ?></label>
													<div class="  "> 
														<input type="text" class="form-control" name="garages" id="garages" value="" placeholder="<?php  esc_html_e('Enter # Garages','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Sale OR Rent Price','ivproperty'); ?></label>
													<div class="  "> 
														<input type="text" class="form-control" name="sale_or_rent_price" id="sale_or_rent_price" value="" placeholder="<?php  esc_html_e('Enter Sale OR Rent Price','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Price Postfix Text','ivproperty'); ?></label>
													<div class="  "> 
														<input type="text" class="form-control" name="price_postfix_text" id="price_postfix_text" value="" placeholder="<?php  esc_html_e('Enter Price Postfix Text e.g. $','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Rent Period','ivproperty'); ?></label>
													<div class="  "> 
														<input type="text" class="form-control" name="rent_period" id="rent_period" value="" placeholder="<?php  esc_html_e('day, week, Month','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Area','ivproperty'); ?></label>
													<div class="  "> 
														<input type="text" class="form-control" name="area" id="area" value="" placeholder="<?php  esc_html_e('Enter Area e.g. 2000','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Area Postfix Text','ivproperty'); ?></label>
													<div class="  "> 
														<input type="text" class="form-control" name="area_postfix_text" id="area_postfix_text" value="" placeholder="<?php  esc_html_e('Enter Area Postfix Text e.g. ft','ivproperty'); ?>">
													</div>																
												</div>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>	
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title col-lg-10">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
													<?php  esc_html_e('Additional Info','ivproperty'); ?>
												</a>
											</h4>
											<h4 class="panel-title text-right" >
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
													<?php  esc_html_e('[ Edit ]','ivproperty'); ?> 
												</a>
											</h4>
										</div>
										<div id="collapseTwo" class="panel-collapse collapse">
											<div class="panel-body">											
												<?php							
													$default_fields = array();
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
													$i=1;							
													foreach ( $default_fields as $field_key => $field_value ) { ?>	
													<div class="form-group">
														<label class="control-label"><?php echo  esc_html($field_value); ?></label>
														<input type="text" placeholder="<?php   esc_html_e('Enter ', 'ivproperty');?><?php echo esc_html($field_value);?>" name="<?php echo esc_html($field_key);?>" id="<?php echo esc_html($field_key);?>"  class="form-control" value=""/>
													</div>
													<?php
													}
												?>			
											</div>
										</div>
									</div>
									<div class="clearfix"></div>	
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title col-lg-10">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapsethirty2">
													<?php  esc_html_e('Floor Plan Image','ivproperty'); ?>
												</a>
											</h4>
											<h4 class="panel-title text-right" >
												<a data-toggle="collapse" data-parent="#accordion" href="#collapsethirty2">
													<?php  esc_html_e('[ Edit ]','ivproperty'); ?> 
												</a>
											</h4>
										</div>
										<div id="collapsethirty2" class="panel-collapse collapse">
											<div class="panel-body">	
												<?php
													// video, event ,  plan
													if($this->check_write_access('plan')){												
													?>	
													<div id="plans">
														<div id="plan">	
															<div class=" form-group">
																<label for="text" class=" control-label"><?php  esc_html_e('Floor Plan Description','ivproperty'); ?></label>
																<div class="  "> 
																	<input type="text" class="form-control" name="plan_description[]" id="plan_description[]" value="" placeholder="<?php  esc_html_e('Enter Floor Plan Description','ivproperty'); ?>">
																</div>																
															</div>
															<div class=" form-group " >
																<label for="text" class=" col-md-5 control-label"><?php  esc_html_e('Floor Plan Image','ivproperty'); ?>  </label>
																<div class="col-md-4" id="plan_image_div">
																	<a  href="javascript:void(0);" onclick="plan_post_image(this);"  >									
																		<?php  echo '<img width="100px" src="'. wp_iv_property_URLPATH.'assets/images/image-add-icon.png">'; ?>			
																	</a>			
																</div>						
															</div>	
														</div>								
													</div>
													<div class=" row  form-group ">
														<div class="col-md-12" >	
															<button type="button" onclick="add_plan_field();"  class="btn btn-xs green-haze"><?php  esc_html_e('Add More','ivproperty'); ?></button>
														</div>
													</div>
													<?php
														}else{
														esc_html_e('Please upgrade your account to add plan ','ivproperty');
													}
												?>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>	
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title col-lg-10">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
													<?php  esc_html_e('Feature','ivproperty'); ?>
												</a>
											</h4>
											<h4 class="panel-title text-right" >
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
													<?php  esc_html_e('[ Edit ]','ivproperty'); ?> 
												</a>
											</h4>
										</div>
										<div id="collapseEight" class="panel-collapse collapse">
											<div class="panel-body">
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Select Amenities/Tag','ivproperty'); ?></label>
													<div class=" "> 
														<?php
															$dir_tags=get_option('_dir_tags');
															if($dir_tags==""){$dir_tags='yes';}	
															if($dir_tags=='yes'){
																$args2 = array(
																'type'                     => $directory_url,
																'orderby'                  => 'name',
																'order'                    => 'ASC',
																'hide_empty'               => 0,
																'hierarchical'             => 1,
																'exclude'                  => '',
																'include'                  => '',
																'number'                   => '',
																'taxonomy'                 => $directory_url.'_tag',
																'pad_counts'               => false
																);
																$main_tag = get_categories( $args2 );	
																$tags_all= '';													
																if ( $main_tag && !is_wp_error( $main_tag ) ) :
																foreach ( $main_tag as $term_m ) {
																?>
																<div class="col-md-4">
																	<label class="form-group"> <input type="checkbox" name="tag_arr[]" id="tag_arr[]"  value="<?php echo esc_html($term_m->slug); ?>"> <?php echo esc_html($term_m->name); ?> </label>  
																</div>
																<?php	
																}
																endif;	
																}else{
																$args['hide_empty']=false;
																$tags = get_tags($args );	
																$tags_post= '';											
																$dir_tags=get_option('_dir_tags');
																foreach ( $tags as $tag ) { 
																	$checked='';															
																?>
																<div class="col-md-4">
																	<label class="form-group"> 
																	<input type="checkbox" name="tag_arr[]" id="tag_arr[]" value="<?php echo esc_html($tag->name); ?>"  > <?php echo esc_html($tag->name); ?> </label>  
																</div>
																<?php
																}
															}
														?>
													</div>																
												</div>
												<div class="clearfix"></div>
												<div class=" form-group">
													<label for="text" class=" control-label"><?php  esc_html_e('Add New Amenities/Tags','ivproperty'); ?></label>						
													<div class="  "> 
														<input type="text" class="form-control" name="new_tag" id="new_tag" value="" placeholder="<?php  esc_html_e('Enter New Tags: Separate tags with commas','ivproperty'); ?>">
													</div>																
												</div>	
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title col-lg-10">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
													<?php  esc_html_e('Public Facilities','ivproperty'); ?> 
												</a>
											</h4>
											<h4 class="panel-title text-right" >
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
													<?php  esc_html_e('[ Edit ]','ivproperty'); ?> 
												</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse">
											<div class="panel-body">	
												<?php
													// video, event , coupon , vip_badge
													if($this->check_write_access('facilities')){
													?>	
													<div id="public_facilities_div">
														<div class=" row form-group " id="day-row1" >									
															<div class=" col-md-6"> 
																<select name="facilities_name[]" id="facilities_name[]" class="form-control">	
																	<?php
																		$public_facilities=get_option('public_facilities');					
																		if($public_facilities==""){$public_facilities='Shop, School, University, Airport, City center, Hospital, CPT stop';}
																		$public_facilities_arr= explode(',',$public_facilities);
																		foreach($public_facilities_arr as $public_facility){ ?>
																		<option value="<?php echo esc_html($public_facility);?>"> <?php  echo esc_html($public_facility); ?></option> 
																		<?php		
																		}
																	?>	
																</select>
															</div>		
															<div  class=" col-md-6">
																<input type="text" class="form-control"  name="facilities_value[]" id="facilities_value[]"  placeholder="<?php  esc_html_e('Enter KM or time','ivproperty'); ?>">
															</div>											
														</div>
													</div>	
													<div class=" row  form-group ">
														<div class="col-md-12" >	
															<button type="button" onclick="add_public_facilities();"  class="btn btn-xs green-haze"><?php  esc_html_e('Add More','ivproperty'); ?></button>
														</div>
													</div>
													<?php
														}else{
														esc_html_e('Please upgrade your account to add public facilities ','ivproperty');
													}
												?>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>	
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title col-lg-10">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
													<?php  esc_html_e('Contact Info','ivproperty'); ?>
												</a>
											</h4>
											<h4 class="panel-title text-right" >
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
													<?php  esc_html_e('[ Edit ]','ivproperty'); ?> 
												</a>
											</h4>
										</div>
										<div id="collapseFour" class="panel-collapse collapse">
											<div class="panel-body">	
												<?php											
													$dir_style5_call=get_option('dir_style5_call');	
													if($dir_style5_call==""){$dir_style5_call='yes';}
													if($dir_style5_call=="yes"){
														$dirpro_call_button='';
														if($dirpro_call_button==""){$dirpro_call_button='yes';}
													?>	
													<div class="form-group row ">
														<label  class="col-md-4 control-label"> <?php  esc_html_e('Call Button','ivproperty');  ?></label>
														<div class="col-md-3">
															<label>												
																<input type="radio" name="dirpro_call_button" id="dirpro_call_button" value='yes' <?php echo ($dirpro_call_button=='yes' ? 'checked':'' ); ?> ><?php  esc_html_e('Show Call Button','ivproperty');  ?>
															</label>	
														</div>
														<div class="col-md-5">	
															<label>											
																<input type="radio"  name="dirpro_call_button" id="dirpro_call_button" value='no' <?php echo ($dirpro_call_button=='no' ? 'checked':'' );  ?> > <?php  esc_html_e('Hide Call Button','ivproperty');  ?>
															</label>
														</div>	
													</div>
													<?php
													}
													$dir_style5_email=get_option('dir_style5_email');	
													if($dir_style5_email==""){$dir_style5_email='yes';}
													if($dir_style5_email=="yes"){
														$dirpro_email_button='';
														if($dirpro_email_button==""){$dirpro_email_button='yes';}
													?>	
													<div class="form-group row ">
														<label  class="col-md-4 control-label"> <?php  esc_html_e('Email Button','ivproperty');  ?></label>
														<div class="col-md-3">
															<label>												
																<input type="radio" name="dirpro_email_button" id="dirpro_email_button" value='yes' <?php echo ($dirpro_email_button=='yes' ? 'checked':'' ); ?> ><?php  esc_html_e('Show Email Button','ivproperty');  ?>
															</label>	
														</div>
														<div class="col-md-5">	
															<label>											
																<input type="radio"  name="dirpro_email_button" id="dirpro_email_button" value='no' <?php echo ($dirpro_email_button=='no' ? 'checked':'' );  ?> > <?php  esc_html_e('Hide Email Button','ivproperty');  ?>
															</label>
														</div>	
													</div>		
													<?php
													}	
													$dir_style5_sms=get_option('dir_style5_sms');	
													if($dir_style5_sms==""){$dir_style5_sms='yes';}
													if($dir_style5_email=="yes"){
														$dirpro_sms_button='';
														if($dirpro_sms_button==""){$dirpro_sms_button='yes';}
													?>	
													<div class="form-group row">
														<label  class="col-md-4 control-label"> <?php  esc_html_e('SMS Button','ivproperty');  ?></label>
														<div class="col-md-3">
															<label>												
																<input type="radio" name="dirpro_sms_button" id="dirpro_sms_button" value='yes' <?php echo ($dirpro_sms_button=='yes' ? 'checked':'' ); ?> ><?php  esc_html_e('Show SMS Button','ivproperty');  ?>
															</label>	
														</div>
														<div class="col-md-5">	
															<label>											
																<input type="radio"  name="dirpro_sms_button" id="dirpro_sms_button" value='no' <?php echo ($dirpro_sms_button=='no' ? 'checked':'' );  ?> > <?php  esc_html_e('Hide SMS Button','ivproperty');  ?>
															</label>
														</div>	
													</div>
													<?php
													}
												?>	
												<hr/>
												<?php
													$listing_contact_source='';
													if($listing_contact_source==''){$listing_contact_source='user_info';}
												?>
												<div class=" form-group">	
													<div class="radio">											
														<label><input type="radio" name="contact_source" value="user_info"  <?php echo ($listing_contact_source=='user_info'?'checked':''); ?> ><?php echo ucfirst($current_user->display_name); ?><?php  esc_html_e(' : Email, Phone, Website','ivproperty'); ?> </label>
													</div>
													<div class="radio">
														<label><input type="radio" name="contact_source" value="new_value" <?php echo ($listing_contact_source=='new_value'?'checked':''); ?>><?php  esc_html_e('New Info Input','ivproperty'); ?>  </label>
													</div>
												</div>
												<div id="new_contact_div" <?php echo ($listing_contact_source=='user_info'?'style="display:none"':''); ?> >
													<div class=" form-group">
														<label for="text" class=" control-label"><?php  esc_html_e('Name','ivproperty'); ?></label>						
														<div class="  "> 
															<input type="text" class="form-control" name="contact_name" id="contact_name" value="" placeholder="<?php  esc_html_e('Enter name','ivproperty'); ?>">
														</div>																
													</div>
													<div class=" form-group">
														<label for="text" class=" control-label"><?php  esc_html_e('Phone','ivproperty'); ?></label>						
														<div class="  "> 
															<input type="text" class="form-control" name="phone" id="phone" value="" placeholder="<?php  esc_html_e('Enter Phone Number','ivproperty'); ?>">
														</div>																
													</div>
													<div class=" form-group">
														<label for="text" class=" control-label"><?php  esc_html_e('Fax','ivproperty'); ?></label>
														<div class="  "> 
															<input type="text" class="form-control" name="fax" id="fax" value="" placeholder="<?php  esc_html_e('Enter Fax Number','ivproperty'); ?>">
														</div>																
													</div>	
													<div class=" form-group">
														<label for="text" class=" control-label"><?php  esc_html_e('Email Address','ivproperty'); ?></label>
														<div class="  "> 
															<input type="text" class="form-control" name="contact-email" id="contact-email" value="" placeholder="<?php  esc_html_e('Enter Email Address','ivproperty'); ?>">
														</div>																
													</div>
													<div class=" form-group">
														<label for="text" class=" control-label"><?php  esc_html_e('Web Site','ivproperty'); ?></label>
														<div class="  "> 
															<input type="text" class="form-control" name="contact_web" id="contact_web" value="" placeholder="<?php  esc_html_e('Enter Web Site','ivproperty'); ?>">
														</div>																
													</div>
												</div>	
											</div>
										</div>
									</div>
									<div class="clearfix"></div>	
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title col-lg-10">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
													<?php  esc_html_e('Videos','ivproperty'); ?>
												</a>
											</h4>
											<h4 class="panel-title text-right" >
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
													<?php  esc_html_e('[ Edit ]','ivproperty'); ?> 
												</a>
											</h4>
										</div>
										<div id="collapseThree" class="panel-collapse collapse">
											<div class="panel-body">	
												<?php
													// video, event , coupon , vip_badge
													if($this->check_write_access('video')){
													?>										
													<div class=" form-group">
														<label for="text" class=" control-label"><?php  esc_html_e('Youtube','ivproperty'); ?></label>
														<div class="  "> 
															<input type="text" class="form-control" name="youtube" id="youtube" value="" placeholder="<?php  esc_html_e('Enter Youtube video ID, e.g : bU1QPtOZQZU ','ivproperty'); ?>">
														</div>																
													</div>
													<div class=" form-group">
														<label for="text" class=" control-label"><?php  esc_html_e('vimeo','ivproperty'); ?></label>
														<div class="  "> 
															<input type="text" class="form-control" name="vimeo" id="vimeo" value="" placeholder="<?php  esc_html_e('Enter vimeo ID, e.g : 134173961','ivproperty'); ?>">
														</div>																
													</div>
													<?php
														}else{
														esc_html_e('Please upgrade your account to add video ','ivproperty');
													}
												?>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>	
									<div class="margiv-top-10">
								    <div class="" id="update_message"></div>
										<input type="hidden" name="user_post_id" id="user_post_id" value="<?php echo esc_html($curr_post_id); ?>">
								    <button type="button" onclick="iv_save_post();"  class="btn green-haze"><?php  esc_html_e('Save Post','ivproperty'); ?></button>
									</div>	
								</form>
							</div>
						</div>
						<?php
						} // for Role
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END PROFILE CONTENT -->
<?php
	$my_theme = wp_get_theme();
	$theme_name= strtolower($my_theme->get( 'Name' ));
	wp_enqueue_script('iv_property-ar-script-27', wp_iv_property_URLPATH . 'admin/files/js/add-edit-listing.js');
	wp_localize_script('iv_property-ar-script-27', 'realpro_data', array(
	'ajaxurl' 					=> admin_url( 'admin-ajax.php' ),
	'loading_image'			=> '<img src="'.wp_iv_property_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'		=>get_current_user_id(),
	'Set_Feature_Image'	=> esc_html__('Set Feature Image','ivproperty'),
	'Set_plan_Image'		=> esc_html__('Set plan Image','ivproperty'),
	'Set_Event_Image'		=> esc_html__('Set Event Image','ivproperty'),
	'Gallery Images'		=> esc_html__('Gallery Images','ivproperty'),
	'permalink'					=> get_permalink(),
	'dirwpnonce'				=> wp_create_nonce("addlisting"),
	'theme_name'				=> $theme_name,
	) );
	
?> 