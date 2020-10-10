	<?php
	global $wpdb;
	global $current_user;
	$ii=1;
	 $main_category='';
	if(isset($_POST['main_category'])){$main_category=sanitize_text_field($_POST['main_category']);}	
	?>
	<div class="bootstrap-wrapper">
		<div class="welcome-panel container-fluid">
		<form id="dir_fields" name="dir_fields" class="form-horizontal" role="form" onsubmit="return false;">
			<div class="row">					
				<div class="col-xs-12" id="submit-button-holder">					
						<div class="pull-right">
						<?php
							 if($main_category!=''){	
							?>	
						<button class="btn btn-info btn-lg" onclick="return update_dir_fields();"><?php esc_html_e( 'Update', 'ivproperty' );?> </button>
							<?php
								}
							?>
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12"><h3 class="page-header"><?php esc_html_e('Listing Fields','ivproperty'); ?>  <br /><small> &nbsp;</small> </h3>
				</div>
			</div> 
					<div id="success_message">	</div>	
			<div class="panel panel-info">
				<div class="panel-heading"><h4><?php $main_category_h = 'Details Fields '; 
						esc_html_e($main_category_h,'ivproperty'); ?> </h4></div>
				<div class="panel-body">	
								<div class="row ">
										<div class="col-sm-5 ">										
											<h4><?php esc_html_e( 'Post Meta Name[no space]', 'ivproperty' );?></h4>
										</div>
										<div class="col-sm-5">
											<h4><?php esc_html_e( 'Display Label', 'ivproperty' );?></h4>									
										</div>
										<div class="col-sm-2">
											<h4><?php esc_html_e( 'Action', 'ivproperty' );?></h4>
										</div>		
								</div>
									<div id="custom_field_div">			
												<?php
												$default_fields = array();
													$field_set=get_option('iv_property_fields' );
												if($field_set!=""){ 
														$default_fields=get_option('iv_property_fields');
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
												foreach ( $default_fields as $field_key => $field_value ) {												
														echo '<div class="row form-group " id="field_'.$i.'"><div class=" col-sm-5"> <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="'.$field_key . '" placeholder="Enter Post Meta Name "> </div>		
														<div  class=" col-sm-5">
														<input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="'.$field_value . '" placeholder="'.esc_html__('Enter Post Meta Label','ivproperty').'">													
														</div>
														<div  class=" col-sm-2">';
														?>
														<button class="btn btn-danger btn-xs" onclick="return iv_remove_field('<?php echo esc_html($i); ?>');"><?php esc_html_e( 'Delete', 'ivproperty' );?></button>
														</div>
														</div>
													<?php	
													$i++;	
												}						
												?>
									</div>				  
								<div class="col-xs-12">
									<button class="btn btn-warning btn-xs" onclick="return iv_add_field();"><?php esc_html_e( 'Add More', 'ivproperty' );?></button>
							 </div>	
						<input type="hidden" name="dir_name" id="dir_name" value="<?php echo esc_html($main_category); ?>">	 
				</div>		 
			</div>			 	
			<div class="panel panel-info">
				<div class="panel-heading"><h4><?php $main_category_h = 'Public Facilities Fields '; 
						esc_html_e($main_category_h,'ivproperty'); ?> </h4></div>
				<div class="panel-body">
					<div class="row ">
							<div class="col-md-8 ">	
								<?php
								$public_facilities=get_option('public_facilities');					
								if($public_facilities==""){$public_facilities='Shop, School, University, Airport, City center, Hospital, CPT stop';}
								?>
								 <textarea class="form-control"  id="public_facilities" name="public_facilities" rows="3"><?php echo esc_html($public_facilities); ?></textarea>
							</div>
					</div>
				</div>		 
			</div>
			<div class="panel panel-info">
				<div class="panel-heading"><h4><?php $main_category_h = 'Property Status '; 
						esc_html_e($main_category_h,'ivproperty'); ?> </h4></div>
				<div class="panel-body">
					<div class="row ">
							<div class="col-md-8 ">	
								<?php
								$property_status=get_option('property_status');					
								if($property_status==""){$property_status='For Rent, For Sale, Sold';}
								?>
								 <textarea class="form-control"  id="property_status" name="property_status" rows="3"><?php echo esc_html($property_status); ?></textarea>
							</div>
					</div>
				</div>		 
			</div>
						<div class="row">					
								<div class="col-xs-12">					
										<div align="center">
											<div id="success_message-fields"></div>														
											<button class="btn btn-info btn-lg" onclick="return update_dir_fields();"><?php esc_html_e( 'Update', 'ivproperty' );?> </button>
										</div>
										<p>&nbsp;</p>
									</div>
							</div>
			</form>					
		</div>
</div>	
<?php
	
		wp_enqueue_script('iv_directory-ar-prifile-fields', wp_iv_property_URLPATH . 'admin/files/js/listing_profile_fields.js');
		wp_localize_script('iv_directory-ar-prifile-fields', 'dirpro', array(		
		'i'=> 	esc_html($i),		
		'ii'=> esc_html($ii),
		) );
		
	?>
