<?php
	$dir_map_api=get_option('_dir_map_api');	
	if($dir_map_api==""){$dir_map_api='';}	
	$directory_url=get_option('_iv_property_url');					
	if($directory_url==""){$directory_url='property';}
?>
<?php
	$map_api_have='no';
?>
<script type='text/javascript' src='<?php echo esc_url('https://maps.googleapis.com/maps/api/js?libraries=places&key'); ?>=<?php echo esc_html($dir_map_api);?>'></script>
<div class="profile-content">            
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject"> <?php  esc_html_e('Edit Listing','ivproperty'); ?></span>
			</div>					
		</div>
		<div class="portlet-body">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1_1">
					<?php					
						// Check Max\
						$package_id=get_user_meta($current_user->ID,'iv_property_package_id',true);						
						$max=get_post_meta($package_id, 'iv_property_package_max_post_no', true);
						$curr_post_id=$_REQUEST['post-id'];
						$current_post = $curr_post_id;
						$post_edit = get_post($curr_post_id); 
						$have_edit_access='yes';
						$exp_date= get_user_meta($current_user->ID, 'iv_property_exprie_date', true);
						if($exp_date!=''){
							$package_id=get_user_meta($current_user->ID,'iv_property_package_id',true);
							$dir_hide= get_post_meta($package_id, 'iv_property_package_hide_exp', true);
							if($dir_hide=='yes'){								
								if(strtotime($exp_date) < time()){	
									$have_edit_access='no';		
								}
							}
						}
						if($post_edit->post_author != $current_user->ID ){
							$have_edit_access='no';	
						}
						if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
							$have_edit_access='yes';					
						}	
						if ( $have_edit_access=='no') { 
							$iv_redirect = get_option( '_iv_property_login_page');
							$reg_page= get_permalink( $iv_redirect); 
						?>
						<?php  esc_html_e('Please ','ivproperty'); ?>
						<a href="<?php echo esc_url($reg_page).'?&profile=level'; ?>" title="Upgarde"><b><?php  esc_html_e('Login or upgrade ','ivproperty'); ?> </b></a> 
						<?php  esc_html_e('To Edit The Post.','ivproperty'); ?>	
						<?php
							}else{
							$title = esc_html($post_edit->post_title);
							$content = esc_html($post_edit->post_content);
						?>					
						<div class="row">
							<div class="col-md-12">	 
								<form action="" id="edit_post" name="edit_post"  method="POST" role="form">
									<div class=" form-group">
										<label for="text" class=" control-label"><?php  esc_html_e('Title','ivproperty'); ?></label>
										<div class="  "> 
											<input type="text" class="form-control" name="title" id="title"  placeholder="<?php  esc_html_e('Enter Title Here','ivproperty'); ?>" value="<?php echo esc_html($title);?>">
										</div>																		
									</div>
									<div class="form-group">
										<div class=" ">
											<?php
												$settings_a = array(															
												'textarea_rows' =>8,
												'editor_class' => 'form-control',
												);
												$content_client =$content;
												$editor_id = 'edit_post_content';
												wp_editor($content_client, $editor_id,$settings_a );										
											?>
										</div>
									</div>
									<div class=" row form-group ">
										<label for="text" class=" col-md-5 control-label"><?php  esc_html_e('Feature Image','ivproperty'); ?>  </label>
										<div class="col-md-4" id="post_image_div">
											<?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $curr_post_id ), 'thumbnail' ); 
												if($feature_image[0]!=""){ ?>
												<img title="profile image" class=" img-responsive" src="<?php  echo esc_url($feature_image[0]); ?>">
												<?php												
												}else{ ?>
												<a href="javascript:void(0);" onclick="edit_post_image('post_image_div');"  >									
													<?php  echo '<img src="'. wp_iv_property_URLPATH.'assets/images/image-add-icon.png">'; ?>			
												</a>	
												<?php
												}
												$feature_image_id=get_post_thumbnail_id( $curr_post_id );
											?>
										</div>
										<input type="hidden" name="feature_image_id" id="feature_image_id" value="<?php echo esc_html($feature_image_id); ?>">
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
										<?php
											$gallery_ids=get_post_meta($curr_post_id ,'image_gallery_ids',true);
											$gallery_ids_array = array_filter(explode(",", $gallery_ids));
										?>
										<input type="hidden" name="gallery_image_ids" id="gallery_image_ids" value="<?php echo esc_html($gallery_ids); ?>">
										<div class="col-md-12" id="gallery_image_div">
											<?php
												if(sizeof($gallery_ids_array)>0){ 
													foreach($gallery_ids_array as $slide){	
													?>
													<div id="gallery_image_div<?php echo esc_html($slide);?>" class="col-md-3"><img  class="img-responsive"  src="<?php echo wp_get_attachment_url( $slide ); ?>"><button type="button" onclick="remove_gallery_image('gallery_image_div<?php echo esc_html($slide);?>', <?php echo esc_html($slide);?>);"  class="btn btn-xs btn-danger"><?php esc_html_e( 'Remove', 'ivproperty' );?></button> </div>
													<?php
													}
												}
											?>
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
												<option value="pending" <?php echo (get_post_status( $post_edit->ID )=='pending'?'selected="selected"':'' ) ; ?>><?php esc_html_e('Pending Review','ivproperty'); ?></option>
												<option value="draft" <?php echo (get_post_status( $post_edit->ID )=='draft'?'selected="selected"':'' ) ; ?> >Draft</option>	
											</select>										
										</div>				
									</div>
									<div class="clearfix"></div>
									<div class=" row form-group">
										<label for="text" class=" col-md-12 control-label"><?php  esc_html_e('Property Status','ivproperty'); ?></label>									
										<div class=" col-md-12 "> 	
											<select name="property_type" class="form-control ">		
												<?php
													$property_status=trim(get_post_meta($post_edit->ID , 'property_status',true));
													$property_status_all=get_option('property_status');					
													if($property_status_all==""){$property_status_all='For Rent,For Sale,Sold';}
													$property_status_all_arr= explode(',',$property_status_all);
													foreach($property_status_all_arr as $property_statusone){ 
														$property_statusone =trim($property_statusone);
														echo' <option '. ($property_status ==$property_statusone ? 'selected':'' ).' value="'.trim($property_statusone).'">'.esc_html($property_statusone).'</option>';
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
												
												$currentCategory=wp_get_object_terms( $post_edit->ID, $directory_url.'-category');
												
												$post_cats=array();
												foreach($currentCategory as $c)
												{
													
													array_push($post_cats,$c->slug);
												}
												$selected='';							
												
												echo '<select name="postcats[]" class="form-control " multiple="multiple">';
												
												
												//directories
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
												foreach ( $terms as $term_parent ) { 
													if(in_array($term_parent->slug,$post_cats)){														  
														$selected=$term_parent->slug;
													}
													
												?>												
												
												
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
														
														if(in_array($term->slug,$post_cats)){														  
															$selected=$term->slug;
															
														}
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
											<input type="text" class="form-control " name="address" value="<?php echo get_post_meta($post_edit->ID,'address',true); ?>" placeholder="<?php  esc_html_e('Enter address Here','ivproperty'); ?>">
										</div>							
										<div class=" col-md-6"> 
											<label for="text" class=" control-label "><?php  esc_html_e('Area','ivproperty'); ?></label>	
											<input type="text" class="form-control " name="area" id="area" value="<?php echo get_post_meta($post_edit->ID,'area',true); ?>" placeholder="<?php  esc_html_e('Enter Area Here','ivproperty'); ?>">
										</div>														
									</div>
									<div class=" form-group ">
										<label for="text" class=" control-label"><?php  esc_html_e('Local Area','ivproperty'); ?></label>							
										<div class=" "> 
											<input type="text" class="form-control" name="local-area" id="local-area" value="<?php echo get_post_meta($post_edit->ID,'local-area',true); ?>" placeholder="<?php  esc_html_e('Enter area here','ivproperty'); ?>">
										</div>
									</div>
									<div class=" form-group row">
										<div class="col-md-6 "> 
											<label for="text" class=" control-label "><?php  esc_html_e('City','ivproperty'); ?></label>
											<input type="text" class="form-control " name="city" id="city" value="<?php echo get_post_meta($post_edit->ID,'city',true); ?>" placeholder="<?php  esc_html_e('Enter city ','ivproperty'); ?>">
										</div>
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('Zipcode','ivproperty'); ?></label>							
											<input type="text" class="form-control " name="postcode" id="postcode" value="<?php echo get_post_meta($post_edit->ID,'postcode',true); ?>" placeholder="<?php  esc_html_e('Enter Zipcode ','ivproperty'); ?>">
										</div>
									</div>
									<div class=" form-group row">
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('State','ivproperty'); ?></label>	
											<input type="text" class="form-control " name="state" id="state" value="<?php echo get_post_meta($post_edit->ID,'state',true); ?>" placeholder="<?php  esc_html_e('Enter State ','ivproperty'); ?>">
										</div>
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('Country','ivproperty'); ?></label>							
											<input type="text" class="form-control " name="country" id="country" value="<?php echo get_post_meta($post_edit->ID,'country',true); ?>" placeholder="<?php  esc_html_e('Enter Country ','ivproperty'); ?>">
										</div>
									</div>	
									<div class=" form-group row">
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('Latitude','ivproperty'); ?></label>
											<input type="text" class="form-control " name="latitude" id="latitude" value="<?php echo get_post_meta($post_edit->ID,'latitude',true); ?>" placeholder="<?php  esc_html_e('Enter latitude ','ivproperty'); ?>">
										</div>
										<div class=" col-md-6">
											<label for="text" class=" control-label "><?php  esc_html_e('Longitude','ivproperty'); ?></label>	
											<input type="text" class="form-control " name="longitude" id="longitude" value="<?php echo get_post_meta($post_edit->ID,'longitude',true); ?>" placeholder="<?php  esc_html_e('Enter longitude ','ivproperty'); ?>">
										</div>
									</div>
									<div class="clearfix">&nbsp;</div>
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
											<h4 class="panel-title ">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour2">
													<?php  esc_html_e('Property Detail','ivproperty'); ?>
												</a>
											</h4>
											<h4 class="panel-title  text-right" >
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour2">
													<?php  esc_html_e('[ Edit ]','ivproperty'); ?> 
												</a>
											</h4>
										</div>
										<div id="collapseFour2" class="panel-collapse collapse">
											<div class="panel-body">											
												<div class=" form-group row">
													<div class="col-md-6"> 
														<label for="text" class=" control-label"><?php  esc_html_e('Bedrooms','ivproperty'); ?></label>	
														<input type="text" class="form-control" name="bedrooms" id="bedrooms" value="<?php echo get_post_meta($post_edit->ID,'bedrooms',true);?>" placeholder="<?php  esc_html_e('Enter number','ivproperty'); ?>">
													</div>																
													<div class="col-md-6">
														<label for="text" class=" control-label"><?php  esc_html_e('Bathrooms','ivproperty'); ?></label>
														<input type="text" class="form-control" name="bathrooms" id="bathrooms" value="<?php echo get_post_meta($post_edit->ID,'bathrooms',true); ?>" placeholder="<?php  esc_html_e('Enter number','ivproperty'); ?>">
													</div>																
												</div>	
												<div class=" form-group row">
													<div class="col-md-6">
														<label for="text" class=" control-label"><?php  esc_html_e('Guest Room','ivproperty'); ?></label>
														<input type="text" class="form-control" name="guest" id="guest" value="<?php echo get_post_meta($post_edit->ID,'guest',true); ?>" placeholder="<?php  esc_html_e('Enter number ','ivproperty'); ?>">
													</div>																
													<div class="col-md-6">
														<label for="text" class=" control-label"><?php  esc_html_e('Garages','ivproperty'); ?></label>
														<input type="text" class="form-control" name="garages" id="garages" value="<?php echo get_post_meta($post_edit->ID,'garages',true); ?>" placeholder="<?php  esc_html_e('Enter number','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group row">
													<div class="col-md-6">
														<label for="text" class=" control-label"><?php  esc_html_e('Sale OR Rent Price','ivproperty'); ?></label>
														<input type="text" class="form-control" name="sale_or_rent_price" id="sale_or_rent_price" value="<?php echo get_post_meta($post_edit->ID,'sale_or_rent_price',true); ?>" placeholder="<?php  esc_html_e('Sale OR Rent Price','ivproperty'); ?>">
													</div>																
													<div class="col-md-6">
														<label for="text" class=" control-label"><?php  esc_html_e('Price Postfix Text','ivproperty'); ?></label>
														<input type="text" class="form-control" name="price_postfix_text" id="price_postfix_text" value="<?php echo get_post_meta($post_edit->ID,'price_postfix_text',true); ?>" placeholder="<?php  esc_html_e('e.g. $','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group row">
													<div class="col-md-6">
														<label for="text" class=" control-label"><?php  esc_html_e('Rent Period','ivproperty'); ?></label>
														<input type="text" class="form-control" name="rent_period" id="rent_period" value="<?php echo get_post_meta($post_edit->ID,'rent_period',true); ?>" placeholder="<?php  esc_html_e('day, week, Month','ivproperty'); ?>">
													</div>																
													<div class="col-md-6">
														<label for="text" class=" control-label"><?php  esc_html_e('Area','ivproperty'); ?></label>
														<input type="text" class="form-control" name="area" id="area" value="<?php echo get_post_meta($post_edit->ID,'area',true); ?>" placeholder="<?php  esc_html_e('e.g. 2000','ivproperty'); ?>">
													</div>																
												</div>
												<div class=" form-group row">
													<div class="col-md-6">
														<label for="text" class=" control-label"><?php  esc_html_e('Area Postfix Text','ivproperty'); ?></label>
														<input type="text" class="form-control" name="area_postfix_text" id="area_postfix_text" value="<?php echo get_post_meta($post_edit->ID,'area_postfix_text',true); ?>" placeholder="<?php  esc_html_e('e.g. ft','ivproperty'); ?>">
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
												?>
												<div class="form-group row">
													<?php	
														foreach ( $default_fields as $field_key => $field_value ) { ?>	
														<div class="col-md-6">
															<label class="control-label"><?php echo  esc_html($field_value); ?></label>
															<input type="text" placeholder="<?php   esc_html_e('', 'ivproperty');?>" name="<?php echo esc_html($field_key);?>" id="<?php echo esc_html($field_key);?>"  class="form-control" value="<?php echo get_post_meta($post_edit->ID,$field_key,true); ?>"/>
														</div>
														<?php
														}
													?>			
												</div>
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
													// video, event ,  Plan
													if($this->check_write_access('plan')){												
													?>		
													<div id="plans">
														<?php	$aw=0;	 
															for($i=0;$i<20;$i++){
																if(get_post_meta($post_edit->ID,'_plan_description_'.$i,true) ||  get_post_meta($post_edit->ID,'_plan_image_id_'.$i,true) ){?>
																<div id="plan">
																	<div id="plan_delete_<?php echo esc_html($i); ?>">
																		<div class=" form-group">
																			<span class="pull-right"  > 
																				<button type="button" onclick="plan_delete_(<?php echo esc_html($i); ?>);"  class="btn btn-xs btn-danger">X</button>
																			</span>
																			<label for="text" class=" control-label"><?php  esc_html_e('Floor Plan','ivproperty'); ?>
																			</label>
																		</div>		
																		<div class=" form-group">
																			<label for="text" class=" control-label"><?php  esc_html_e('Floor Plan Description','ivproperty'); ?></label>
																			<div class="  "> 
																				<input type="text" class="form-control" name="plan_description[]" id="plan_description[]" value="<?php echo get_post_meta($post_edit->ID,'_plan_description_'.$i,true); ?>" placeholder="<?php  esc_html_e('Enter Plan Description','ivproperty'); ?>">
																			</div>																
																		</div>
																		<div class=" form-group " >
																			<label for="text" class=" col-md-5 control-label"><?php  esc_html_e('Floor Plan Image','ivproperty'); ?>  </label>
																			<div class="col-md-4" id="plan_image_div">
																				<?php 
																					if(get_post_meta($post_edit->ID,'_plan_image_id_'.$i,true)!=''){?>
																					<a  href="javascript:void(0);" onclick="plan_post_image(this);"  >		
																						<img src="<?php echo wp_get_attachment_url( get_post_meta($post_edit->ID,'_plan_image_id_'.$i,true) ); ?> " >
																						<input type="hidden" name="plan_image_id[]" id="plan_image_id[]" value="<?php echo get_post_meta($post_edit->ID,'_plan_image_id_'.$i,true); ?>">
																					</a>
																					<?php
																					}else{?>
																					<a  href="javascript:void(0);" onclick="plan_post_image(this);"  >									
																						<?php  echo '<img width="100px" src="'. wp_iv_directories_URLPATH.'assets/images/image-add-icon.png">'; ?>			
																					</a>																					
																					<?php		
																					}																		
																				?>
																			</div>						
																		</div>
																	</div>		
																</div>	
																<div class="clearfix"></div>	 
																<hr>
																<?php
																	$aw++;	
																}				 
															}
															if($aw==0){ ?>
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
															<?php
															}			  
														?>																			
													</div>
													<div class=" row  form-group ">
														<div class="col-md-12" >	
															<button type="button" onclick="add_plan_field();"  class="btn btn-xs green-haze"><?php  esc_html_e('Add More','ivproperty'); ?></button>
														</div>
													</div>
													<?php
														}else{
														esc_html_e('Please upgrade your account to add Plan ','ivproperty');
													}
												?>
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
													<?php					
														$facilities = get_post_meta($post_edit->ID ,'_public_facilities',true);
														if($facilities!=''){?>						
														<?php	
															$i=1;
															if(sizeof($facilities)>0){
																foreach($facilities as $key => $item){
																	$facilities_one = explode("|", $item);	
																	echo '<div id="old_facilities'. $i .'">
																	<div class="col-md-6"><h5>'.$key.'</h5></div> <div class="col-md-5"> <h5>: '.$facilities_one[0].'</h5></div><div class="col-md-1"> <button type="button" onclick="remove_facilities('.$i.');"  class="btn btn-xs btn-danger">X</button> 												
																	</div>
																	<input type="hidden" name="facilities_name[]" id="facilities_name[]" value="'.$key.'">
																	<input type="hidden" name="facilities_value[]" id="facilities_value[]" value="'.$facilities_one[0].'"></div>';
																	$i++;
																}	
															}										
														}
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
																		<option value="<?php echo esc_html($public_facility);?>"> <?php  esc_html_e($public_facility,'ivproperty'); ?></option> 
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
																$tags_all= wp_get_object_terms( $post_edit->ID,  $post_type.'_tag');													
																if ( $main_tag && !is_wp_error( $main_tag ) ) :
																foreach ( $main_tag as $term_m ) {		
																	$checked='';
																	foreach ( $tags_all as $term ) {														
																		if( $term->term_id==$term_m->term_id){
																			$checked=' checked';
																		}
																	}	
																?>
																<div class="col-md-4">
																	<label class="form-group"> <input type="checkbox" name="tag_arr[]" id="tag_arr[]" <?php echo esc_html($checked);?> value="<?php echo esc_html($term_m->slug); ?>"> <?php echo esc_html($term_m->name); ?> </label>  
																</div>
																<?php	
																}
																endif;	
																}else{
																$args['hide_empty']=false;
																$tags = get_tags($args );	
																$tags_post= wp_get_post_tags($post_edit->ID, array( 'fields' => 'ids' ));											
																$dir_tags=get_option('_dir_tags');
																foreach ( $tags as $tag ) { 
																	$checked='';
																	if(in_array( $tag->term_id,$tags_post)){
																		$checked=' checked';
																	}
																?>
																<div class="col-md-4">
																	<label class="form-group"> 
																	<input type="checkbox" name="tag_arr[]" id="tag_arr[]" value="<?php echo esc_html($tag->name); ?>" <?php echo esc_html($checked);?> > <?php echo esc_html($tag->name); ?> </label>  
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
														$dirpro_call_button=get_post_meta($post_edit->ID,'dirpro_call_button',true);
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
														$dirpro_email_button=get_post_meta($post_edit->ID,'dirpro_email_button',true);
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
														$dirpro_sms_button=get_post_meta($post_edit->ID,'dirpro_sms_button',true);
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
												<div class=" form-group">
													<?php
														$listing_contact_source=get_post_meta($post_edit->ID,'listing_contact_source',true);
														if($listing_contact_source==''){$listing_contact_source='user_info';}
													?>
													<div class="radio">											
														<label><input type="radio" name="contact_source" value="user_info"  <?php echo ($listing_contact_source=='user_info'?'checked':''); ?> ><?php echo ucfirst($current_user->display_name); ?><?php  esc_html_e(' : Email, Phone, Website','ivproperty'); ?> </label>
													</div>
													<div class="radio">
														<label><input type="radio" name="contact_source" value="new_value" <?php echo ($listing_contact_source=='new_value'?'checked':''); ?>><?php  esc_html_e('New Info Input','ivproperty'); ?>  </label>
													</div>
												</div>
												<div id="new_contact_div" <?php echo ($listing_contact_source=='user_info'?'style="display:none"':''); ?> >
													<div class=" form-group row">
														<div class="col-md-6">
															<label for="text" class=" control-label"><?php  esc_html_e('Name','ivproperty'); ?></label>
															<input type="text" class="form-control" name="contact_name" id="contact_name" value="<?php echo get_post_meta($post_edit->ID,'contact_name',true); ?>" placeholder="<?php  esc_html_e('Enter name','ivproperty'); ?>">
														</div>																
														<div class="col-md-6">													
															<label for="text" class=" control-label"><?php  esc_html_e('Phone','ivproperty'); ?></label>	
															<input type="text" class="form-control" name="phone" id="phone" value="<?php echo get_post_meta($post_edit->ID,'phone',true); ?>" placeholder="<?php  esc_html_e('Enter Phone Number','ivproperty'); ?>">
														</div>																
													</div>
													<div class=" form-group row">
														<div class="col-md-6">
															<label for="text" class=" control-label"><?php  esc_html_e('Fax','ivproperty'); ?></label>
															<input type="text" class="form-control" name="fax" id="fax" value="<?php echo get_post_meta($post_edit->ID,'fax',true); ?>" placeholder="<?php  esc_html_e('Enter Fax Number','ivproperty'); ?>">
														</div>																
														<div class="col-md-6">
															<label for="text" class=" control-label"><?php  esc_html_e('Email Address','ivproperty'); ?></label>
															<input type="text" class="form-control" name="contact-email" id="contact-email" value="<?php echo get_post_meta($post_edit->ID,'contact-email',true); ?>" placeholder="<?php  esc_html_e('Enter Email Address','ivproperty'); ?>">
														</div>																
													</div>
													<div class=" form-group row">
														<div class="col-md-6">
															<label for="text" class=" control-label"><?php  esc_html_e('Web Site','ivproperty'); ?></label>
															<input type="text" class="form-control" name="contact_web" id="contact_web" value="<?php echo get_post_meta($post_edit->ID,'contact_web',true); ?>" placeholder="<?php  esc_html_e('Enter Web Site','ivproperty'); ?>">
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
															<input type="text" class="form-control" name="youtube" id="youtube" value="<?php echo get_post_meta($post_edit->ID,'youtube',true); ?>" placeholder="<?php  esc_html_e('Enter Youtube video ID, e.g : bU1QPtOZQZU ','ivproperty'); ?>">
														</div>																
													</div>
													<div class=" form-group">
														<label for="text" class=" control-label"><?php  esc_html_e('Vimeo','ivproperty'); ?></label>
														<div class="  "> 
															<input type="text" class="form-control" name="vimeo" id="vimeo" value="<?php echo get_post_meta($post_edit->ID,'vimeo',true); ?>" placeholder="<?php  esc_html_e('Enter vimeo ID, e.g : 134173961','ivproperty'); ?>">
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
										<button type="button" onclick="iv_update_post();"  class="btn green-haze"><?php  esc_html_e('Save Post','ivproperty'); ?></button>
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
	if($map_api_have=='yes'){
		wp_enqueue_script('iv_directory-ar-script-28', wp_iv_property_URLPATH . 'admin/files/js/google_map.js');
		wp_localize_script('iv_directory-ar-script-28', 'dirpro', array(		
		'lat'=> get_post_meta($curr_post_id,'latitude',true),		
		'lng'=> get_post_meta($curr_post_id,'longitude',true),
		) );
	}			
	
?> 