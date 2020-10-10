<?php
	global $post,$wpdb,$tag;
	$radius=get_option('_iv_radius');
	$keyword_post='';
	$directory_url=get_option('_iv_property_url');
	if($directory_url==""){$directory_url='property';}
?>
<div >
  <div class="search-border">
		<div class="" >
			<h5><strong><?php  esc_html_e( 'Find Your Listing ', 'ivproperty' ); ?> </strong></h5>
		</div>
		<form class="form" action="<?php echo get_post_type_archive_link( $directory_url) ; ?>" method="POST"  onkeypress="return event.keyCode != 13;">
			<div class="" >
				<?php  esc_html_e( 'Keyword', 'ivproperty' ); ?>
			</div>
			<div class="" >
				<input type="text" class="cbp-search-input" id="keyword" name="keyword"  placeholder="<?php  esc_html_e( 'Keyword', 'ivproperty' ); ?>" value="<?php echo esc_html($keyword_post); ?>">
			</div>
			<div class="" >
				<?php  esc_html_e( 'Property Type', 'ivproperty' ); ?>
			</div>
			<div class="">
				<?php
					echo '<select name="property-category" class="cbp-search-input">';
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
					?>
					<?php
						$i++;
					}
					endif;
					echo '</select>';
				?>
			</div>
		
			<div class="" >
				<?php  esc_html_e( 'Property Status', 'ivproperty' ); ?>
			</div>
			<div class="" >
				<select name="property-type" class="cbp-search-input">';
					<option  value=""><?php  esc_html_e('Any','ivproperty'); ?></option>
					<option  value="For Rent"><?php  esc_html_e('For Rent','ivproperty'); ?></option>
					<option  value="For Sale"><?php  esc_html_e('For Sale','ivproperty'); ?></option>
					<option  value="Sold" ><?php  esc_html_e('Sold','ivproperty'); ?></option>
				</select>
			</div>
			<div class="" >
				<?php  esc_html_e( 'Min Beds', 'ivproperty' ); ?>
			</div>
			<div class="" >
				<input type="text" class="cbp-search-input" id="beds" name="beds"  placeholder="<?php  esc_html_e( 'Min Beds', 'ivproperty' ); ?>" >
			</div>
			<div class="">
				<?php  esc_html_e( 'Min Baths', 'ivproperty' ); ?>
			</div>
			<div class="" >
				<input type="text" class="cbp-search-input" id="baths" name="baths"  placeholder="<?php  esc_html_e( 'Min Baths', 'ivproperty' ); ?>" >
			</div>
			<div class="" >
				<?php  esc_html_e( 'Min Price', 'ivproperty' ); ?>
			</div>
			<div class="" >
				<input type="text" class="cbp-search-input" id="min_price" name="min_price"  placeholder="<?php  esc_html_e( 'Min Price', 'ivproperty' ); ?>" >
			</div>
			<div class="" >
				<?php  esc_html_e( 'Min Area (Sq Ft)', 'ivproperty' ); ?>
			</div>
			<div class="" >
				<input type="text" class="cbp-search-input" id="area" name="area"  placeholder="<?php  esc_html_e( 'Min Area (Sq Ft)', 'ivproperty' ); ?>" >
			</div>
			<div class="" >
				<button type="submit" id="submit" name="submit"  class="btn btn-default "><?php  esc_html_e('Search','ivproperty'); ?> </button>
			</div>
		</form>
	</div>
</div>
<?php
	$dir_map_api=get_option('_dir_map_api');
	if($dir_map_api==""){$dir_map_api='';}
?>
