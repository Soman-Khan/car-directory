<div class="form-group">
	<label  class="col-md-2   control-label"> 
	<?php esc_html_e( 'Reminder Email Subject :', 'ivproperty' );?> </label>
	<div class="col-md-4 ">
		<?php
			$iv_property_reminder_email_subject = get_option( 'iv_property_reminder_email_subject');
		?>
		<input type="text" class="form-control" id="iv_property_reminder_email_subject" name="iv_property_reminder_email_subject" value="<?php echo esc_html($iv_property_reminder_email_subject); ?>" placeholder="Enter reminder email subject">
	</div>
</div>
<div class="form-group">
	<label  class="col-md-2   control-label">
	<?php esc_html_e( 'Reminder Email Tempalte :', 'ivproperty' );?> </label>
	<div class="col-md-10 ">
		<?php
			$settings_a = array(															
			'textarea_rows' =>20,															 
			);
			$content_reminder = get_option( 'iv_property_reminder_email');
			$editor_id = 'reminder_email_template';
		?>
		<textarea id="reminder_email_template" name="reminder_email_template" rows="20" class="col-md-12 ">
			<?php echo esc_html($content_reminder); ?>
		</textarea>
	</div>
</div>
<div class="form-group">
	<label  class="col-md-2   control-label"> 
	<?php esc_html_e( 'Send Email Before # Days :', 'ivproperty' );?> </label>
	<div class="col-md-4 ">
		<?php
			$iv_property_reminder_day = get_option( 'iv_property_reminder_day');
		?>
		<input type="text" class="form-control" id="iv_property_reminder_day" name="iv_property_reminder_day" value="<?php echo esc_html($iv_property_reminder_day); ?>" placeholder="Enter number of day">
	</div>
</div>
<div class="row form-group">
	<label  class="col-md-2   control-label"> <?php  esc_html_e('Short Code:','ivproperty');?>  </label>
	<div class="col-md-4 ">			
		<h4>  <span class="label label-info">[iv_property_reminder_email_cron] </span></h4>
	</div>
</div>