			<?php
	
			global $wpdb;
			global $current_user;
			$ii=1;
			$directory_url=get_option('_iv_property_url');					
			if($directory_url==""){$directory_url='property';}			
			?>
	<div class="row">
		<div class="col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class=""><?php esc_html_e('Demo Import','ivproperty');?></h3>                    
                </div>
                <div class="panel-body">
							<div class="progress">
							  <div id="dynamic" class=" progress-bar progress-bar-success progress-bar-striped active " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" >
								<span id="current-progress"></span>
							  </div>
							</div>
						<div class="row">
						<div class="col-md-4"></div>
						
							<div class="col-md-4 none " id="cptlink12" > <a  class="btn btn-info " href="<?php echo get_post_type_archive_link( $directory_url) ; ?>" target="_blank"><?php esc_html_e('View All Listing','ivproperty');?>  </a>
							</div>
						<div class="col-md-4"></div>	
						</div>	
						<div class="row" id="importbutton">						
							<div class="col-md-12 "> 
							<center>
							<button type="button" onclick="return  iv_import_medo();" class="btn btn-success"><?php esc_html_e('Import Demo Listing','ivproperty');?> </button>
							</center>
							</div>
						</div>					
                </div>
			</div>
        </div>
		<div class="col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3><?php esc_html_e('Importing CSV Data ','ivproperty');?></h3>                    
                </div>
                <div class="panel-body">
                    <div class="tab-content">
						  <?php
							 include('csv-import.php');
							?>					
                    </div>
                </div>
            </div>
        </div>
		<div class="col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3><?php esc_html_e('Home Page Content','ivproperty');?></h3>  
						<small><?php esc_html_e('Create a full width page and paste the code','ivproperty');?> </small>
						<p><a class="btn btn-info btn-xs" href="<?php echo  wp_iv_property_URLPATH; ?>assets/Real-estate-pro-slider.zip" download ><?php esc_html_e('Download & import the top Revolution Slider','ivproperty');?>  </a> </p>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                       <code>
														 [rev_slider alias="Real-estate-pro-slider"][/rev_slider]
														&nbsp;
														<h2 style="text-align: center;">Recent Houses for Rent</h2>
														&nbsp;
														<p style="text-align: center;">[listing_carousel bgcolor='#EFEFEF' post_limit="10"]</p>
														<h2 style="text-align: center;">New Houses for sale</h2>
														&nbsp;
														<p style="text-align: center;">[listing_filter property-type="For Sale" post_limit="3"]</p>
														<h2 style="text-align: center;">Find a Properties That Fits Your Comfort</h2>
														<p style="text-align: center;">[realestatepro_categories post_limit="3"]</p>
														<h2 style="text-align: center;">Browse Listings in these Cities</h2>
														<p style="text-align: center;">You can use the theme places shortcode to list specific cities or areas where you have properties ready to sale/rent.</p>
														<p style="text-align: center;">[realestatepro_cities cities="london,new york,FLORIDA,California"]</p>
                       </code>
                    </div>
                </div>
            </div>
        </div>
			<div class="col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 ><?php esc_html_e('Some Important shortcode','ivproperty');?>
					<a class="btn btn-info btn-xs" href="<?php echo esc_url('//help.eplug-ins.com/realdoc/' ); ?>" target="_blank"><?php esc_html_e('All Shortcodes','ivproperty');?>  </a>
					</h3> 
                </div>
                <div class="panel-body">
					<div class="tab-content">
							<div class="row">
									<div class="col-md-6">	
									Listing Filter ( you can use any parameter e.g. [listing_filter property-type="For Rent"] )
									</div>
										<div class="col-md-6">	
										[listing_filter property-type="For Rent" category="test" dir_city="test" zipcode="10001" beds="2" baths="2" min_price="10000" area="1500" post_limit="3"  background_color="#EFEFEF" post_limit="3"]
									</div>
								</div>	
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									 Slider Search bar(You can use without slider too)
									</div>
										<div class="col-md-6">	
										[slider_search]
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									 City Shortcode
									</div>
										<div class="col-md-6">	
										[realestatepro_cities cities="london,new york,FLORIDA,California"]
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									 Featured Listing only
									</div>
										<div class="col-md-6">	
										[realestatepro_featured]
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									 Listing Carousel
									</div>
										<div class="col-md-6">	
										[listing_carousel property-type="For Rent" category="test" dir_city="test" zipcode="10001" beds="2" baths="2" min_price="10000" area="1500" post_limit="10" bgcolor="#EFEFEF"]
									</div>
								</div>	
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									All Listings: Grid Viw
									</div>
										<div class="col-md-6">	
										[listing_layout_style_1]
									</div>
								</div>	
								<div class="row">
									<div class="col-md-6">	
									All Listings: List Viw
									</div>
										<div class="col-md-6">	
										[listing_layout_style_2]
									</div>
								</div>	
					</div>			
                </div>
            </div>
        </div>
	</div>