<?php
	include( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );
	 $dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
	 $id=$dir_id;
?>
<div class="bootstrap-wrapper">
	<div class="container">		
				<div class="row" >
			<div class="col-md-12">	
	
		
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><?php  esc_html_e('Agent Info','ivproperty'); ?></h5>
						<button onclick="contact_close();" type="button" class="close" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?php
							$post_author_id= get_post_field( 'post_author', $id );
							$agent_info = get_userdata($post_author_id);
							$iv_profile_pic_url=get_user_meta($post_author_id, 'iv_profile_pic_thum',true);
							if($iv_profile_pic_url!=''){ ?>
							<div class="row">
								<div class="col-md-3"><p></p></div><div class="col-md-9"><p>
									<img width="80px"  src="<?php echo esc_html($iv_profile_pic_url); ?>">
								</p>
								</div>
							</div>
							<?php
							}
						?>
						<?php
							if(get_user_meta($post_author_id,'first_name',true)!=""){
							?>
							<div class="row">
								<div class="col-md-3"><p><?php  esc_html_e('Name','ivproperty'); ?></p></div><div class="col-md-9"><p><?php echo get_user_meta($post_author_id,'first_name',true).' '.get_user_meta($post_author_id,'last_name',true) ;?></p>
								</div>
							</div>
							<?php
							}
							if(get_user_meta($post_author_id,'phone',true)!=""){
							?>
							<div class="row">
								<div class="col-md-3"><p><?php  esc_html_e('Phone','ivproperty'); ?></p></div><div class="col-md-9"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="tel:'.get_user_meta($post_author_id,'phone',true).'">'.get_user_meta($post_author_id,'phone',true).'</a>' ;?></p>
								</div>
							</div>
							<?php
							}
						?>
						<div class="row">
							<div class="col-md-3"><p><?php  esc_html_e('Email','ivproperty'); ?></p></div><div class="col-md-9"><p><?php echo '<a class="icon-blue link-text-decoration-none"  href="mailto:'.$agent_info->user_email.'">'.$agent_info->user_email.'</a>' ;?></p>
							</div>
						</div>
						<?php
							if(get_user_meta($post_author_id,'web_site',true)!=""){
							?>
							<div class="row">
								<div class="col-md-3"><p><?php  esc_html_e('Web Site','ivproperty'); ?></p></div><div class="col-md-9"><p><?php echo '<a class="link-text-decoration-none"  href="'. esc_url(get_user_meta($post_author_id,'web_site',true)).'" target="_blank"">'. get_user_meta($post_author_id,'web_site',true).'&nbsp; </a>';?></p>
								</div>
							</div>
							<?php
							}
						?>
					</div>
					<div class="modal-footer">
						<button onclick="contact_close();" type="button" class="btn btn-secondary" data-dismiss="modal"><?php  esc_html_e( 'Close', 'ivproperty' ); ?></button>
					</div>
		
		</div>
</div>
	</div>
</div>