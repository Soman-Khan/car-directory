<form action="#" id="message-pop" name="message-pop"   method="POST" >
	 <div class="form-group row ">
			<label class="col-md-12"  for="Name"><?php  esc_html_e( 'Name', 'ivproperty' ); ?></label>
			<input  class="col-md-12" id="name" name ="name" type="text">
	 </div>
		<div class="form-group row">
				<label for="eamil" class="col-md-12"><?php  esc_html_e( 'Email', 'ivproperty' ); ?></label>
			 <input class="col-md-12"  name="email_address" id="email_address" type="text">
	 </div>
		<div class="form-group row">
					<label for="message" class="col-md-12"><?php  esc_html_e( 'Message', 'ivproperty' ); ?></label>
				 <input type="hidden" name="dir_id" id="dir_id" value="<?php echo esc_html($id);?>">
			 
				<?php
				 $message=esc_html__('I would like to inquire about your listing. Please contact me at your earliest convenience.','ivproperty' );
				 ?>
				<textarea  class="col-md-12" name="message-content" id="message-content"  cols="20" rows="3"><?php echo esc_html($message);?></textarea>
	 </div>
</form>
