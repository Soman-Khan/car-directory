<?php
	include( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );
	 $dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
?>	
<div class="bootstrap-wrapper">
	<div class="container">		
				<div class="row" >
			<div class="col-md-12">	
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><?php  esc_html_e('Report','ivproperty'); ?></h5>
						<button type="button" onclick="contact_close();" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="#" id="message-claim" name="message-claim"    method="POST" >
							<div class="form-group row">
								<label class="col-md-4"  for="Subject"><?php  esc_html_e( 'Name', 'ivproperty' ); ?></label>
								<input class="col-md-7"  id="subject" name ="subject" type="text">
							</div>
							<div class="form-group row">
								<label class="col-md-4"  for="eamil"><?php  esc_html_e( 'Email', 'ivproperty' ); ?></label>
								<input class="col-md-7"  name="email_address" id="email_address" type="email">
							</div>
							<div class="form-group row">
								<label class="col-md-4"  for="message"><?php  esc_html_e( 'Message', 'ivproperty' ); ?></label>
								<input type="hidden" name="dir_id" id="dir_id" value="<?php echo esc_html($dir_id); ?>">
								<textarea class="col-md-7"  name="message-content" id="message-content"  cols="20" rows="5"></textarea>
							</div>
						</form>
						<div id="update_message_claim"></div>
					</div>
					<div class="modal-footer">
						<button type="button" onclick="contact_close();"  class="btn btn-secondary" data-dismiss="modal"><?php  esc_html_e( 'Close', 'ivproperty' ); ?></button>
						<button type="button" onclick="send_message_claim();" class="btn btn-secondary"><?php  esc_html_e( 'Submit', 'ivproperty' ); ?></button>
					</div>		
	
		</div>
	</div>	
</div>
</div>		