<?php
	include( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );	
	wp_enqueue_style('bootstrap-iv_property-110', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	$dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
	$id=$dir_id;
	$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
	if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}	
?>
<div class="bootstrap-wrapper popup0margin "id="popup-contact" >		
	<div class="container" >
		<div class="row" >
			<div class="col-md-12">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo esc_html($dir_addedit_contactustitle);?></h5>	
						<div class="ml-2" id="update_message_popup"></div> 
						<button type="button" onclick="contact_close();" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body">
					<?php
						include( wp_iv_property_template. 'property/contact-form.php');						
						?>
				</div>
				
						<div class="modal-footer">					
							<button type="button" class="btn btn-dark col-md-6 " onclick="contact_close();" ><?php  esc_html_e( 'Close', 'ivproperty' ); ?></button>				
							<button type="button" class="btn btn-secondary col-md-6 ml-2"  onclick="contact_send_message_iv();" ><?php  esc_html_e( 'Send', 'ivproperty' ); ?></button>							
						</div>					
			</div>				
		</div>	
	</div>	
</div>		