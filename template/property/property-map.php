<?php
	global $post,$wpdb,$tag;
	wp_enqueue_style('iv_property-style-1109', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	wp_enqueue_script('iv_property-script-12', wp_iv_property_URLPATH . 'admin/files/js/markerclusterer.js');
	wp_enqueue_style('iv_property-style-map', wp_iv_property_URLPATH . 'admin/files/css/map.css');
	
	$dir_map_zoom=get_option('_dir_map_zoom');	
	if($dir_map_zoom==""){$dir_map_zoom='7';}	
?>
<div class="bootstrap-wrapper ">
	<div class="" id="directory-temp"> 	
		<?php
			$ins_lat='37.4419';
			$ins_lng='-122.1419';
			$directory_url=get_option('_iv_property_url');					
			if($directory_url==""){$directory_url='property';}
			$dirs_data =array();
			$tag_arr= array();
			$args = array(
			'post_type' => $directory_url, // enter your custom post type
			'paged' => -1, 
			'post_status' => 'publish',		
			'posts_per_page'=> '9999999',  // overrides posts per page in theme settings
			);
			$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
			$the_query = new WP_GeoQuery( $args ); 
		?>	
		<!-- Map**************-->
		<div class="row" style= "" >	
			<div class="col-md-12" >							
				<div id="map"  class="mapsetting"> </div>	
			</div>										 
		</div>		
		<?php	
			$i=1;
			if ( $the_query->have_posts() ) : 
			while ( $the_query->have_posts() ) : $the_query->the_post();
			$id = get_the_ID();
			$gallery_ids=get_post_meta($id ,'image_gallery_ids',true);
			$gallery_ids_array = array_filter(explode(",", $gallery_ids));
			$dir_data['link']=get_post_permalink();
			$dir_data['title']=$post->post_title; 				
			$dir_data['lat']=get_post_meta($id,'latitude',true);
			$dir_data['lng']=get_post_meta($id,'longitude',true);
			if(get_post_meta($id,'latitude',true)!=''){$ins_lat=str_replace("'",'', get_post_meta($id,'latitude',true));}
			if(get_post_meta($id,'longitude',true)!=''){$ins_lng=str_replace("'",'', get_post_meta($id,'longitude',true));}
			$dir_data['address']=get_post_meta($id,'address',true); 
			$dir_data['image']= '';
			$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'thumbnail' ); 
			if($feature_image[0]!=""){ 					
				$dir_data['image']=  $feature_image[0];
			}
			$dir_data['marker_icon']=wp_iv_property_URLPATH."/assets/images/map-marker/map-marker.png";				
			$currentCategoryId='';
			$terms =get_the_terms($id, $directory_url."-category");				
			if($terms!=""){
				foreach ($terms as $termid) {  
					if(isset($termid->term_id)){
						$currentCategoryId= $termid->term_id; 
					}					  
				} 
			}
			$marker = get_option('_cat_map_marker_'.$currentCategoryId,true);
			if($marker!=''){
				$image_attributes = wp_get_attachment_image_src( $marker ); // returns an array
				if( $image_attributes ) {
					$dir_data['marker_icon']= $image_attributes[0];
				}							
			}				
			array_push( $dirs_data, $dir_data );				
			$i++;	
			endwhile; 
			$dirs_json ='';
			if(!empty($dirs_data)){
				$dirs_json =json_encode($dirs_data);
			}
		?>	
		<?php else :
			$dirs_json='';
		?>
		<?php endif;  ?>
		<!-- Design loop -->
		<input type="hidden" id="latitude" name="latitude" placeholder="Latitude" value="<?php echo esc_html($ins_lat); ?>" >
		<input type="hidden" id="longitude" name="longitude" placeholder="Longitude"  value="<?php echo esc_html($ins_lng); ?>">	
		<input type="hidden" class="form-control " id="address" name="address"  placeholder="<?php  esc_html_e( 'Location', 'ivproperty' ); ?>" 
		value="<?php echo esc_html(trim($address)); ?>">	
		<?php 
			wp_reset_query();
		wp_reset_postdata(); ?>
	</div>	
</div>
<?php
	$dir_map_api=get_option('_dir_map_api');	
	if($dir_map_api==""){$dir_map_api='';}	
?>
<script type='text/javascript' src='<?php echo esc_url('//maps.googleapis.com/maps/api/js?libraries=places&key');?>=<?php echo esc_html($dir_map_api);?>'></script>		
<script type="text/javascript">						
	function initialize() {
		var center = new google.maps.LatLng('<?php echo esc_html($ins_lat); ?>', '<?php echo esc_html($ins_lng); ?>');
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: <?php echo esc_html($dir_map_zoom);?>,
			center: center,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var markers = [];
		var infowindow = new google.maps.InfoWindow();
		var dirs ='';
		var min = .999999;
		var max = 1.000002;
		<?php echo ($dirs_json!=''? 'var dirs ='.$dirs_json:''); ?>;
		if(dirs!=''){
			for (i = 0; i < dirs.length; i++) {
				var new_lat= dirs[i].lat  * (Math.random() * (max - min) + min);
				var new_lng= dirs[i].lng  * (Math.random() * (max - min) + min);
				var latLng = new google.maps.LatLng(new_lat,new_lng);	
				var marker = new google.maps.Marker({
					position: latLng,
					map: map,
					icon: dirs[i].marker_icon,
				});
				markers.push(marker);
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						infowindow.setContent('<div id="map-marker-info" style="overflow: auto; cursor: default; clear: both; position: relative; border-radius: 4px; padding: 15px; border-color: rgb(255, 255, 255); border-style: solid; background-color: rgb(255, 255, 255); border-width: 1px; width: 275px; height: 130px;"><div style="overflow: hidden;" class="map-marker-info"><a  style="text-decoration: none;" href="'+dirs[i].link +'">	<span style="background-image: url('+dirs[i].image+')" class="list-cover has-image"></span><span class="address"><strong>'+dirs[i].title +'</strong></span> <span class="address" style="margin-top:15px">'+dirs[i].address+'</span></a></div></div>');
						infowindow.open(map, marker);
					}
				})(marker, i));
			}
		}
		var markerCluster = new MarkerClusterer(map, markers);
	}	
	function cs_toggle_street_view(btn) {
		var toggle = panorama.getVisible();
		if (toggle == false) {
			if(btn == 'streetview'){
				panorama.setVisible(true);
			}
			} else {
			if(btn == 'mapview'){
				panorama.setVisible(false);
			}
		}
	}
	google.maps.event.addDomListener(window, 'load', initialize);					
	jQuery('a[href="#locationmap"]').on('click', function(e) {
		setTimeout(function(){
			initialize();	
			google.maps.event.trigger(map, 'resize');
		},500)
	});
	function initialize_address() {
		var input = document.getElementById('address');
		var autocomplete = new google.maps.places.Autocomplete(input);
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();
			document.getElementById('latitude').value = place.geometry.location.lat();
			document.getElementById('longitude').value = place.geometry.location.lng(); 
		});
	}
	google.maps.event.addDomListener(window, 'load', initialize_address); 
</script>