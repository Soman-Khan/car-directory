<?php
if(isset($_REQUEST['delete_id']))  { 
if (current_user_can( 'manage_options' ) ) {
	$post_id=$_REQUEST['delete_id'];
	wp_delete_post($post_id);
	delete_post_meta($post_id,true);
	$message=esc_html__( 'Deleted Successfully', 'ivproperty' ) ;
}	
}
?>
<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">
		<?php
		if(!isset($_REQUEST['id']))  {
			?>
			<div class="row ">					
				<div class="col-md-12" id="submit-button-holder">					
					<div class="pull-right ">								
						<a class="btn btn-info "  href="<?php echo wp_iv_property_ADMINPATH; ?>admin.php?page=wp-iv_property-coupon-create"><?php esc_html_e( 'Create A New Coupon', 'ivproperty' );?></a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 table-responsive">
					<h3  class="page-header"><?php esc_html_e( 'Coupon List', 'ivproperty' );?>
						<small >
							<?php
							if (isset($_REQUEST['form_submit']) AND $_REQUEST['form_submit'] <> "") {
								echo  '<span>['.esc_html__( ' The Coupon Create Successfully ','ivproperty').']</span>';
							}
							if (isset($message) AND $message <> "") {
								echo  '<span> [ '.$message.' ]</span>';
							}
							?>
						</small>
					</h3>
					<table class="table table-striped col-md-12">
						<thead >
							<tr>
								<th><?php esc_html_e( 'Coupon Code/ Name', 'ivproperty' );?></th>
								<th><?php esc_html_e( 'Start Date', 'ivproperty' );?></th>
								<th><?php esc_html_e( 'End Date', 'ivproperty' );?></th>
								<th><?php esc_html_e( 'Uses Limit', 'ivproperty' );?></th>
								<th><?php esc_html_e( 'Amount', 'ivproperty' );?> </th>
								<th ><?php esc_html_e( 'Action', 'ivproperty' );?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							global $wpdb, $post;
							$iv_property_coupon='iv_property_coupon';
							$sql=$wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type = '%s'", $iv_property_coupon );
							$products_rows = $wpdb->get_results($sql);
							if(sizeof($products_rows)>0){
								$i=0;
								foreach ( $products_rows as $row )
								{	
									echo'<tr>';
									echo '<td>'. $row->post_title.'</td>';
									echo '<td>'. get_post_meta($row->ID, 'iv_property_coupon_start_date', true).'</td>';
									echo '<td>'. get_post_meta($row->ID, 'iv_property_coupon_end_date', true).'</td>';
									echo '<td>'. get_post_meta($row->ID, 'iv_property_coupon_limit', true).' / '.get_post_meta($row->ID, 'iv_property_coupon_used', true).' </td>';
									echo '<td>'. get_post_meta($row->ID, 'iv_property_coupon_amount', true).'</td>';
										echo '<td>  <a class="btn btn-primary btn-xs" href="?page=wp-iv_property-coupon-update&id='.$row->ID.'"> '.esc_html__( 'Edit', 'ivproperty') .'</a> ';
										echo '  <a href="?page=wp-iv_property-coupons-form&delete_id='.$row->ID.'" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete this form?\');">'.esc_html__( 'Delete', 'ivproperty').'</a></td>';
										echo'</tr>';
										$i++;
									}
								}
								?>
							</tbody>
						</table>
						<div class=" col-md-12  bs-callout bs-callout-info">		
							<?php esc_html_e( 'Note : Coupon will work on "One Time Payment" only. Coupon will not work on recurring payment and it will not support 100% discount.	', 'ivproperty' );?>					
						</div>
					</div>
				</div>
				<div class="row">					
					<div class="col-md-12">					
						<div class="">								
							<a class="btn btn-info "  href="<?php echo wp_iv_property_ADMINPATH; ?>admin.php?page=wp-iv_property-coupon-create"><?php esc_html_e( 'Create A New Coupon', 'ivproperty' );?></a>
						</div>
					</div>
				</div>
				<div class="row">
					<br/>	
				</div>
				<?php
			} //End for if(!isset($_REQUEST['id']))  {
				?>
			</div>
		</div>