<h3  class=""><?php esc_html_e('Listing Setting','ivproperty');  ?><small></small>	
</h3>
<br/>
<div id="update_message"> </div>		 
<form class="form-horizontal" role="form"  name='directory_settings' id='directory_settings'>											
	<?php											
		$opt_style=	get_option('_archive_template');
		if($opt_style==''){$opt_style='style-2';}
		$directory_url=get_option('_iv_property_url');
		if($directory_url==""){$directory_url='property';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Default listing View','ivproperty');  ?> <a class="btn btn-info btn-xs " href="<?php echo get_post_type_archive_link( $directory_url ) ; ?>" target="blank"><?php esc_html_e('View Page','ivproperty');  ?></a>
		</label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="option_archive"  value='style-2' <?php echo ($opt_style=='style-2' ? 'checked':'' ); ?> ><?php esc_html_e('List View','ivproperty');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="option_archive" value='style-1' <?php echo ($opt_style=='style-1' ? 'checked':'' );  ?> > <?php esc_html_e('Grid View','ivproperty');  ?>
			</label>
		</div>	
	</div>	
	<?php											
		$dir5_review_show=get_option('dir5_review_show');	
		if($dir5_review_show==""){$dir5_review_show='yes';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Review','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir5_review_show" id="dir5_review_show" value='yes' <?php echo ($dir5_review_show=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Review','ivproperty');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir5_review_show" id="dir5_review_show" value='no' <?php echo ($dir5_review_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Review','ivproperty');  ?>
			</label>
		</div>	
	</div>	
	<?php
		$dir_style5_call=get_option('dir_style5_call');	
		if($dir_style5_call==""){$dir_style5_call='yes';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Call Button','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_style5_call" id="dir_style5_call" value='yes' <?php echo ($dir_style5_call=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Call Button','ivproperty');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_style5_call" id="dir_style5_call" value='no' <?php echo ($dir_style5_call=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Call Button','ivproperty');  ?>
			</label>
		</div>	
	</div>	
	<?php
		$dir_style5_email=get_option('dir_style5_email');	
		if($dir_style5_email==""){$dir_style5_email='yes';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Email Button','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_style5_email" id="dir_style5_email" value='yes' <?php echo ($dir_style5_email=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Email Button','ivproperty');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_style5_email" id="dir_style5_email" value='no' <?php echo ($dir_style5_email=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Email Button','ivproperty');  ?>
			</label>
		</div>	
	</div>		
	<?php
		$dir_style5_sms=get_option('dir_style5_sms');	
		if($dir_style5_sms==""){$dir_style5_sms='yes';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('SMS Button','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_style5_sms" id="dir_style5_sms" value='yes' <?php echo ($dir_style5_sms=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show SMS Button','ivproperty');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_style5_sms" id="dir_style5_sms" value='no' <?php echo ($dir_style5_sms=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide SMS Button','ivproperty');  ?>
			</label>
		</div>	
	</div>		
	<div class="form-group row">
		<?php
			$dir_style5_perpage='20';						
			$dir_style5_perpage=get_option('dir_style5_perpage');	
			if($dir_style5_perpage==""){$dir_style5_perpage=20;}
		?>	
		<label  class="col-md-3 control-label">	<?php esc_html_e('Load Per Page','ivproperty');  ?> </label>					
		<div class="col-md-2">																	
			<input  type="input" name="dir_style5_perpage" id="dir_style5_perpage" value='<?php echo esc_html($dir_style5_perpage); ?>'>
		</div>						
	</div>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Page Background color','ivproperty');  ?></label>
		<?php
			$dir5_background_color=get_option('dir5_background_color');	
			if($dir5_background_color==""){$dir5_background_color='#EBEBEB';}	
		?>
		<div class="col-md-2">																		
			<input  type="input" name="dir5_background_color"  value='<?php echo esc_html($dir5_background_color); ?>' >
		</div>
	</div>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Content Background color [List View]','ivproperty');  ?></label>
		<?php
			$dir5_content_color=get_option('dir5_content_color');	
			if($dir5_content_color==""){$dir5_content_color='#fff';}	
		?>
		<div class="col-md-2">																	
			<input  type="input" name="dir5_content_color" id="dir5_content_color" value='<?php echo esc_html($dir5_content_color); ?>' >							
		</div>
	</div>
	<?php
		$iv_property_url=get_option('_iv_property_url');					
		if($iv_property_url==""){$iv_property_url='property';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Property Custom Post Type','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input  type="input" name="iv_property_url" id="iv_property_url" value='<?php echo esc_html($iv_property_url); ?>' >
			</label>
		</div>
		<div class="col-md-2">
			<?php esc_html_e('No special characters, no upper case, no space','ivproperty');  ?>
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('VIP image','ivproperty');  ?></label>
		<div class="col-md-1">
			<div id="current_vip">	
				<?php
					if(get_option('vip_image_attachment_id')!=''){
						$vip_img= wp_get_attachment_image_src(get_option('vip_image_attachment_id'));
						if(isset($vip_img[0])){									
							$vip_image= $vip_img[0];
						}
						}else{
						$vip_image= wp_iv_property_URLPATH."/assets/images/vipicon.png";
					}								
				?>
				<img  src="<?php echo esc_url($vip_image); ?>">
			</div>	
		</div>
		<div class="col-md-3">	
			<label>											
				<button type="button" onclick="change_vip_image();"  class="btn btn-success btn-xs"><?php esc_html_e('Change Image','ivproperty');  ?></button>
			</label>
		</div>	
	</div>		
	<?php
		$dir_style_font=get_option('dir_style_font');	
		if($dir_style_font==""){$dir_style_font='no';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Font: Listing archive & detail page','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_style_font" id="dir_style_font" value='yes' <?php echo ($dir_style_font=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Quicksand font','ivproperty');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_style_font" id="dir_style_font" value='no' <?php echo ($dir_style_font=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Use Theme Font','ivproperty');  ?>
			</label>
		</div>	
	</div>		
	
	<hr>
	<h4>
	<?php esc_html_e('List View','ivproperty');  ?> </h4>
	Shortcode: [listing_layout_style_2]
	<hr>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_type_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Type';						
			$dir_facet_title=get_option('dir_facet_type_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__( 'Type','ivproperty');}	
		?>	
		<label  class="col-md-3 control-label"> <?php esc_html_e('Left Faceted Search','ivproperty');  ?></label>
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_type_show" id="dir_facet_type_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_type_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_cat_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Categories';						
			$dir_facet_title=get_option('dir_facet_cat_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__( 'Categories','ivproperty');}	
		?>	
		<label  class="col-md-3 control-label"> </label>	
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_cat_show" id="dir_facet_cat_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_cat_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_location_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='City';						
			$dir_facet_title=get_option('dir_facet_location_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('City','ivproperty'); }	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_location_show"  value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_location_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_area_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Area';						
			$dir_facet_title=get_option('dir_facet_area_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Area','ivproperty'); }	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_area_show"  value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_area_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_features_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Features';						
			$dir_facet_title=get_option('dir_facet_features_title');	
			if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivproperty');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_features_show"  value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_features_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_zipcode_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Zipcode';						
			$dir_facet_title=get_option('dir_facet_zipcode_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Zipcode','ivproperty');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_zipcode_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_zipcode_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_review_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Reviews';						
			$dir_facet_title=get_option('dir_facet_review_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Reviews','ivproperty');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_review_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_review_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_bed_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Reviews';						
			$dir_facet_title=get_option('dir_facet_bed_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Beds','ivproperty');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_bed_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_bed_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_bath_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Reviews';						
			$dir_facet_title=get_option('dir_facet_bath_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Baths','ivproperty');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_bath_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivproperty');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_bath_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	<?php				
		$new_badge_day=get_option('_iv_new_badge_day');
		$dir_approve_publish =get_option('_dir_approve_publish');
		$dir_archive=get_option('_dir_archive_page');	
		if($dir_approve_publish==""){$dir_approve_publish='no';}	
		$dir_claim=get_option('_dir_dir_claim');
		if($dir_claim==""){$dir_claim='yes';}	
		$search_button_show=get_option('_search_button_show');	
		if($search_button_show==""){$search_button_show='yes';}
		$dir_searchbar_show=get_option('_dir_searchbar_show');	
		if($dir_searchbar_show==""){$dir_searchbar_show='no';}
		$dir_map_show=get_option('_dir_map_show');	
		if($dir_map_show==""){$dir_map_show='no';}
		$dir_agent=get_option('_dir_agent_show');	
		if($dir_agent==""){$dir_agent='yes';}
		$dir_load_listing_all=get_option('_dir_load_listing_all');	
		if($dir_load_listing_all==""){$dir_load_listing_all='yes';}
		$dir_load_popup=get_option('_dir_load_popup');	
		if($dir_load_popup==""){$dir_load_popup='yes';}
	?>
	<hr>
	<h4><?php esc_html_e('Grid View','ivproperty');  ?> </h4>
	<hr>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Listing Page Search Bar','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_searchbar_show" id="dir_searchbar_show" value='yes' <?php echo ($dir_searchbar_show=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show  Search Bar','ivproperty');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_searchbar_show" id="dir_searchbar_show" value='no' <?php echo ($dir_searchbar_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Search Bar','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<div class="form-group row">
		<label  class="col-md-2 control-label"> <?php esc_html_e('Grid columns','ivproperty');?></label>	
		<label class="col-md-1 control-label"><?php esc_html_e('Width 1500','ivproperty');?></label>
		<?php
			$col1500=get_option('grid_col1500');	
			if($col1500==""){$col1500='5';}
		?>
		<input class="col-md-1"type="input" name="grid_col1500"  value="<?php echo esc_html($col1500); ?>" >
		<label class="col-md-1 control-label"><?php esc_html_e('Width 1100','ivproperty');?></label>
		<?php
			$grid_col1100=get_option('grid_col1100');	
			if($grid_col1100==""){$grid_col1100='3';}
		?>
		<input class="col-md-1"type="input" name="grid_col1100"  value="<?php echo esc_html($grid_col1100); ?>" >
		<label class="col-md-1 control-label"><?php esc_html_e('Width 768','ivproperty');?></label>
		<?php
			$grid_col768=get_option('grid_col768');	
			if($grid_col768==""){$grid_col768='3';}
		?>
		<input class="col-md-1"type="input" name="grid_col768"  value="<?php echo esc_html($grid_col768); ?>" >
		<label class="col-md-1 control-label"><?php esc_html_e('Width 1100','ivproperty');?></label>
		<?php
			$grid_col480=get_option('grid_col480');	
			if($grid_col480==""){$grid_col480='2';}
		?>
		<input class="col-md-1"type="input" name="grid_col480" value="<?php echo esc_html($grid_col480); ?>" >
		<label class="col-md-1 control-label"><?php esc_html_e('Width 375','ivproperty');?></label>
		<?php
			$grid_col375=get_option('grid_col375');	
			if($grid_col375==""){$grid_col375='1';}
		?>
		<input class="col-md-1"type="input" name="grid_col375"  value="<?php echo esc_html($grid_col375); ?>" >
	</div>
	<h4><?php esc_html_e('Single Page','ivproperty');  ?> </h4>
	<hr>	
	<?php
		$property_top_slider=get_option('property_top_slider');	
		if($property_top_slider==""){$property_top_slider='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Top Slider','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="property_top_slider" id="property_top_slider" value='yes' <?php echo ($property_top_slider=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Top slider','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="property_top_slider" id="property_top_slider" value='no' <?php echo ($property_top_slider=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Top Slider','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$directories_layout_single=get_option('directories_layout_single');	
		if($directories_layout_single==""){$directories_layout_single='two';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Page layout','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>									
				<img class="image40px"  src="<?php echo wp_iv_property_URLPATH."/admin/files/images/two-col.png";?>">
				<input type="radio" name="directories_layout_single"  value='two' <?php echo ($directories_layout_single=='two' ? 'checked':'' ); ?> ><?php esc_html_e('Two Columns','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-2">	
			<label>	
				<img class="image40px"   src="<?php echo wp_iv_property_URLPATH."/admin/files/images/one-col.png";?>">							
				<input type="radio"  name="directories_layout_single" value='one' <?php echo ($directories_layout_single=='one' ? 'checked':'' );  ?> > <?php esc_html_e('One Column','ivproperty');  ?>
			</label>
		</div>
		<div class="col-md-3">	
			<label>	
				<img class="image40px"   src="<?php echo wp_iv_property_URLPATH."/admin/files/images/no-slider.png";?>">							
				<input type="radio"  name="directories_layout_single" value='right_feature_image' <?php echo ($directories_layout_single=='right_feature_image' ? 'checked':'' );  ?> > <?php esc_html_e('Feature Image-Top Right','ivproperty');  ?>
			</label>
		</div>
	</div>
	<?php
		$property_top_4_icons=get_option('property_top_4_icons');	
		if($property_top_4_icons==""){$property_top_4_icons='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Top 4 Icons Show/hide','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="property_top_4_icons" id="property_top_4_icons" value='yes' <?php echo ($property_top_4_icons=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Top Icons','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="property_top_4_icons" id="property_top_4_icons" value='no' <?php echo ($property_top_4_icons=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Top Icons','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Top 4 Icons','ivproperty');  ?><br/> <a href="<?php echo esc_url('//fontawesome.com/icons?d=gallery&m=free'); ?>" target="_blank">Show Icons[Font Awesome Icon]  </a></label>						
		<div class="col-md-2">
			<?php
				$property_top_1_icon=get_option('property_top_1_icon');	
				if($property_top_1_icon==""){$property_top_1_icon='fas fa-home';}								
			?>										
			<?php esc_html_e('Type','ivproperty');  ?><input type="text" name="property_top_1_icon"  value='<?php echo esc_html($property_top_1_icon); ?>'> 
		</div>	
		<div class="col-md-2">
			<?php
				$property_top_2_icon=get_option('property_top_2_icon');	
				if($property_top_2_icon==""){$property_top_2_icon='fas fa-bed';}								
			?>										
			<?php esc_html_e('Bedroom','ivproperty');  ?><input type="text" name="property_top_2_icon"  value='<?php echo esc_html($property_top_2_icon); ?>'> 
		</div>
		<div class="col-md-2">
			<?php
				$property_top_3_icon=get_option('property_top_3_icon');	
				if($property_top_3_icon==""){$property_top_3_icon='fas fa-shower';}								
			?>										
			<?php esc_html_e('Bathroom','ivproperty');  ?>
			<input type="text" name="property_top_3_icon"  value='<?php echo esc_html($property_top_3_icon); ?>'> 
		</div>
		<div class="col-md-2">
			<?php
				$property_top_4_icon=get_option('property_top_4_icon');	
				if($property_top_4_icon==""){$property_top_4_icon='fas fa-expand';}								
			?>										
			<?php esc_html_e('Area','ivproperty');  ?><input type="text" name="property_top_4_icon"  value='<?php echo esc_html($property_top_4_icon); ?>'> 
		</div>
	</div>
	<?php
		$property_right_top_price=get_option('property_right_top_price');	
		if($property_right_top_price==""){$property_right_top_price='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Top Right Price Header','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="property_right_top_price" id="property_right_top_price" value='yes' <?php echo ($property_right_top_price=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Top Right Price header','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="property_right_top_price" id="property_right_top_price" value='no' <?php echo ($property_right_top_price=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Top Right Price header','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$property_public_facilities=get_option('property_public_facilities');	
		if($property_public_facilities==""){$property_public_facilities='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Public Facilities','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="property_public_facilities" id="property_public_facilities" value='yes' <?php echo ($property_public_facilities=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Public Facilities','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="property_public_facilities" id="property_public_facilities" value='no' <?php echo ($property_public_facilities=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Public Facilities','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$property_details=get_option('property_details');	
		if($property_details==""){$property_details='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Details','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="property_details" id="property_details" value='yes' <?php echo ($property_details=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Details','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="property_details" id="property_details" value='no' <?php echo ($property_details=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Details','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$dir_map=get_option('property_dir_map');	
		if($dir_map==""){$dir_map='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Map','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_map" id="dir_map" value='yes' <?php echo ($dir_map=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Listing Map','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_map" id="dir_map" value='no' <?php echo ($dir_map=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Listing Map','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$dir_video=get_option('property_dir_video');	
		if($dir_video==""){$dir_video='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Video','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_video" id="dir_video" value='yes' <?php echo ($dir_video=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Listing Video','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_video" id="dir_video" value='no' <?php echo ($dir_video=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Listing Video','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Listing Claim','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_claim" id="dir_claim" value='yes' <?php echo ($dir_claim=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Listing Claim','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_claim" id="dir_claim" value='no' <?php echo ($dir_claim=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Listing Claim','ivproperty');  ?>
			</label>
		</div>	
	</div>			
	<?php
		$dir_features=get_option('_dir_features');	
		if($dir_features==""){$dir_features='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Features','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_features" id="dir_features" value='yes' <?php echo ($dir_features=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Features','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_features" id="dir_features" value='no' <?php echo ($dir_features=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Features','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$contact_info=get_option('_contact_info');	
		if($contact_info==""){$contact_info='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Contact Info','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="contact_info" id="contact_info" value='yes' <?php echo ($contact_info=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show contact info','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="contact_info" id="contact_info" value='no' <?php echo ($contact_info=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide contact info','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$contact_form=get_option('_contact_form');	
		if($contact_form==""){$contact_form='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Contact Form','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="contact_form" id="contact_form" value='yes' <?php echo ($contact_form=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show contact Form','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="contact_form" id="contact_form" value='no' <?php echo ($contact_form=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide contact Form','ivproperty');  ?>
			</label>
		</div>	
	</div>
		<?php
		$dir_contact_form=get_option('dir_contact_form');	
					if($dir_contact_form==""){$dir_contact_form='yes';}
					
					?>
					
					<div class="form-group">
						<label  class="col-md-3 control-label"> <?php esc_html_e('Contact Form','ivproperty');  ?></label>
					
					<div class="col-md-2">
							<label>												
							<input type="radio" name="dir_contact_form" id="dir_contact_form" value='yes' <?php echo ($dir_contact_form=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Default Form','ivproperty');  ?>
							</label>	
						</div>
						
						<div class="col-md-7">
						<label>											
							<input type="radio"  name="dir_contact_form" id="dir_contact_form" value='no' <?php echo ($dir_contact_form=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Other "Form Plugin" e.g. Contact Form7','ivproperty');  ?>
						</label>
						<?php
								$dir_form_shortcode=get_option('dir_form_shortcode');	
					
					
					?>
						<input type="text" name="dir_form_shortcode" id="dir_form_shortcode" placeholder="shortcode" value='<?php echo esc_html($dir_form_shortcode);?>' >
													
							
						</div>	
					</div>
	<?php
		$contact_form=get_option('_contact_form_modal');	
		if($contact_form==""){$contact_form='popup';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Contact Form Type','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="contact_form_modal" id="contact_form_modal" value='form' <?php echo ($contact_form=='form' ? 'checked':'' ); ?> ><?php esc_html_e('Show Form','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="contact_form_modal" id="contact_form_modal" value='popup' <?php echo ($contact_form=='popup' ? 'checked':'' );  ?> > <?php esc_html_e('Popup','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$dir_agent_show=get_option('_dir_agent_show');	
		if($dir_agent_show==""){$dir_agent_show='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Agent Info','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_agent_show" id="dir_agent_show" value='yes' <?php echo ($dir_agent_show=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Agent info','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_agent_show" id="dir_agent_show" value='no' <?php echo ($dir_agent_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Agent info','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$dir_share=get_option('_dir_share');	
		if($dir_share==""){$dir_share='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Share Listing','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_share" id="dir_share" value='yes' <?php echo ($dir_share=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Share listing','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_share" id="dir_share" value='no' <?php echo ($dir_share=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Share Listing','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$similar_property=get_option('_similar_property');	
		if($similar_property==""){$similar_property='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Similar Properties','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="similar_property" id="similar_property" value='yes' <?php echo ($similar_property=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show similar properties','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="similar_property" id="similar_property" value='no' <?php echo ($similar_property=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide similar properties','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<?php
		$eploan_calculator=get_option('_eploan_calculator');	
		if($eploan_calculator==""){$eploan_calculator='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Loan Calculator','ivproperty');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="loan_calculator" value='yes' <?php echo ($eploan_calculator=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Loan Calculator','ivproperty');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="loan_calculator"  value='no' <?php echo ($eploan_calculator=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Loan Calculator','ivproperty');  ?>
			</label>
		</div>	
	</div>
	<hr>
	<h4><?php esc_html_e('Search Bar [Grid View]','ivproperty');  ?> </h4>
	<hr>
	<?php
		$dir_search_keyword=get_option('_dir_search_keyword');	
		if($dir_search_keyword==""){$dir_search_keyword='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Keyword','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_keyword" id="dir_search_keyword" value='yes' <?php echo ($dir_search_keyword=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Keyword ', 'ivproperty' );?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_keyword" id="dir_search_keyword" value='no' <?php echo ($dir_search_keyword=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Keyword ', 'ivproperty' );?> 
			</label>
		</div>	
	</div>
	<?php
		$dir_search_city=get_option('_dir_search_city');	
		if($dir_search_city==""){$dir_search_city='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('City','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_city" id="dir_search_city" value='yes' <?php echo ($dir_search_city=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show City ', 'ivproperty' );?>   
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_city" id="dir_search_city" value='no' <?php echo ($dir_search_city=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide City ', 'ivproperty' );?>    
			</label>
		</div>	
	</div>
	<?php
		$dir_search_country=get_option('_dir_search_country');	
		if($dir_search_country==""){$dir_search_country='yes';}	
	?>				
	<?php
		$dir_search_tag=get_option('_dir_search_tag');	
		if($dir_search_tag==""){$dir_search_tag='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Tags','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_tag" id="dir_search_tag" value='yes' <?php echo ($dir_search_tag=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Tags ', 'ivproperty' );?>   
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_tag" id="dir_search_tag" value='no' <?php echo ($dir_search_tag=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Tags', 'ivproperty' );?>    
			</label>
		</div>	
	</div>

	<?php
		$dir_search_category=get_option('_dir_search_category');	
		if($dir_search_category==""){$dir_search_category='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Category','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_category" id="dir_search_category" value='yes' <?php echo ($dir_search_category=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Category', 'ivproperty' );?>   
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_category" id="dir_search_category" value='no' <?php echo ($dir_search_category=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Category  ', 'ivproperty' );?>    
			</label>
		</div>	
	</div>
	<?php
		$dir_search_zipcode=get_option('_dir_search_zipcode');	
		if($dir_search_zipcode==""){$dir_search_zipcode='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Zipcode','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_zipcode" id="dir_search_zipcode" value='yes' <?php echo ($dir_search_zipcode=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Zipcode ', 'ivproperty' );?>   
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_zipcode" id="dir_search_zipcode" value='no' <?php echo ($dir_search_zipcode=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Zipcode ', 'ivproperty' );?>    
			</label>
		</div>	
	</div>
	<?php
		$dir_search_price=get_option('_dir_search_price');	
		if($dir_search_price==""){$dir_search_price='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Min Price','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_price" id="dir_search_price" value='yes' <?php echo ($dir_search_price=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Price ', 'ivproperty' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_price" id="dir_search_price" value='no' <?php echo ($dir_search_price=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Price ', 'ivproperty' );?>   
			</label>
		</div>	
	</div>
	<?php
		$dir_search_type=get_option('_dir_search_type');	
		if($dir_search_type==""){$dir_search_type='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Type','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_type" id="dir_search_type" value='yes' <?php echo ($dir_search_type=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Type ', 'ivproperty' );?>   
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_type" id="dir_search_type" value='no' <?php echo ($dir_search_type=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Type  ', 'ivproperty' );?>   
			</label>
		</div>	
	</div>
	<?php
		$dir_search_beds=get_option('_dir_search_beds');	
		if($dir_search_beds==""){$dir_search_beds='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Min Beds','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_beds" id="dir_search_beds" value='yes' <?php echo ($dir_search_beds=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Price ', 'ivproperty' );?>  Show Min Beds  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_beds" id="dir_search_beds" value='no' <?php echo ($dir_search_beds=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Min Beds', 'ivproperty' );?>   
			</label>
		</div>	
	</div>
	<?php
		$dir_search_baths=get_option('_dir_search_baths');	
		if($dir_search_baths==""){$dir_search_baths='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Min Baths','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_baths" id="dir_search_baths" value='yes' <?php echo ($dir_search_baths=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Min Baths', 'ivproperty' );?>    
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_baths" id="dir_search_baths" value='no' <?php echo ($dir_search_baths=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Min Baths  ', 'ivproperty' );?>    
			</label>
		</div>	
	</div>
	<?php
		$dir_search_area=get_option('_dir_search_area');	
		if($dir_search_area==""){$dir_search_area='yes';}	
	?>				
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Min Area','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_area" id="dir_search_area" value='yes' <?php echo ($dir_search_area=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show Min Area', 'ivproperty' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_search_area" id="dir_search_area" value='no' <?php echo ($dir_search_area=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide Min Area', 'ivproperty' );?> 
			</label>
		</div>	
	</div>
	<h4><?php esc_html_e('Other Settings','ivproperty');  ?> </h4>
	<hr>	
	<?php
		$dir_tags=get_option('_dir_tags');	
		if($dir_tags==""){$dir_tags='yes';}						
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Tags','ivproperty');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_tags" id="dir_tags" value='yes' <?php echo ($dir_tags=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Listing Tags', 'ivproperty' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_tags" id="dir_tags" value='no' <?php echo ($dir_tags=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Post Tags', 'ivproperty' );?>      
			</label>
		</div>	
	</div>
	<?php
		$dir_map_api=get_option('_dir_map_api');	
		if($dir_map_api==""){$dir_map_api='';}	
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Google Map API Key','ivproperty');  ?></label>
		<div class="col-md-5">																		
			<input class="col-md-12" type="text" name="dir_map_api" id="dir_map_api" value='<?php echo esc_html($dir_map_api); ?>' >						
		</div>
		<div class="col-md-4">
			<label>												
				<b> <a href="<?php echo esc_url('https://developers.google.com/maps/documentation/geocoding/get-api-key');?>"> <?php esc_html_e( 'Get your API key here', 'ivproperty' );?>     </a></b>
			</label>	
		</div>					
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Map Zoom','ivproperty');  ?></label>
		<?php
			$dir_map_zoom=get_option('_dir_map_zoom');	
			if($dir_map_zoom==""){$dir_map_zoom='7';}	
		?>
		<div class="col-md-2">
			<label>												
				<input  type="input" name="dir_map_zoom" id="dir_map_zoom" value='<?php echo esc_html($dir_map_zoom); ?>' >
			</label>	
		</div>
		<div class="col-md-2">
			<label>												
				<?php esc_html_e('20 is more Zoom, 1 is less zoom','ivproperty');  ?> 
			</label>	
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Cron Job URL','ivproperty');  ?>						 
		</label>
		<div class="col-md-6">
			<label>												
				<b> <a href="<?php echo admin_url('admin-ajax.php'); ?>?action=iv_property_cron_job"><?php echo admin_url('admin-ajax.php'); ?>?action=iv_property_cron_job </a></b>
			</label>	
		</div>
		<div class="col-md-3">
		<?php esc_html_e( 'Cron JOB Detail : Auto Bidding Renew update, Hide Listing( Package setting),Subscription Remainder email.', 'ivproperty' );?>  
			
		</div>		
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> </label>
		<div class="col-md-8">
			<div id="update_message49"> </div>	
			<button type="button" onclick="return  iv_update_dir_setting();" class="btn btn-success"><?php esc_html_e('Update','ivproperty');  ?></button>
		</div>
	</div>
</form>