<?php
	$profile_url=get_permalink(); 
	global $current_user;
	$user = $current_user->ID;
	$message='';
	if(isset($_GET['delete_id']))  {
		$post_id=sanitize_text_field($_GET['delete_id']);
		$post_edit = get_post($post_id); 
		if($post_edit){
			if($post_edit->post_author==$current_user->ID){
				wp_delete_post($post_id);
				delete_post_meta($post_id,true);
				$message=esc_html__("Deleted Successfully",'ivproperty');
			}
			if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
				wp_delete_post($post_id);
				delete_post_meta($post_id,true);
				$message=esc_html__("Deleted Successfully",'ivproperty');
			}	
		}
	}
	$directory_url=get_option('_iv_property_url');					
	if($directory_url==""){$directory_url='property';}
	wp_enqueue_style('jquery.dataTables', wp_iv_property_URLPATH . 'admin/files/css/jquery.dataTables.css');
	wp_enqueue_script('jquery.dataTables', wp_iv_property_URLPATH . 'admin/files/js/jquery.dataTables.js');
?>     
<div class="profile-content">            
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject"> 
					<?php
						$iv_post = 'property'; 
						esc_html_e('All Listing','ivproperty');	
					?>
				</span>							 
				<?php echo '<a class="btn btn-xs  green-haze" href="'.get_permalink() .'?&profile=new-post"> '.  esc_html__('Add New Listing','ivproperty')	.' </a>'; ?>
				<?php echo '<a class="btn btn-xs  green-haze" href="'.get_post_type_archive_link( $directory_url ) .'"> '.  esc_html__('Listing Home','ivproperty')	.' </a>'; ?>
			</div>					
		</div>
		<div class="portlet-body">  
			<?php
				if($message!=''){
					echo  '<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'.$message.'.</div>';
				}
			?>
			<div class="table-responsive">
				<table id="alllistingdata" class="display table" cellspacing="0" width="100%">
					<thead>
						
						<tr class="">
							<th><?php  esc_html_e('ID','ivproperty');?></th>	
							<th><?php  esc_html_e('Title','ivproperty');?></th>	
							<th><?php  esc_html_e('Status','ivproperty');?></th>		
							<th><?php  esc_html_e('Expire','ivproperty');?></th>																	
							<th><?php  esc_html_e('Actions','ivproperty');?></th>
						</tr>
					</thead>	 
					<?php
						global $wpdb;
						$per_page=10;$row_strat=0;$row_end=$per_page;
						$current_page=0 ;
						if(isset($_REQUEST['cpage']) and $_REQUEST['cpage']!=1 ){   
							$current_page=$_REQUEST['cpage']; $row_strat =($current_page-1)*$per_page; 
							$row_end=$per_page;
						}
						if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
							$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s' and post_status IN ('publish','pending','draft' )  ORDER BY `ID` DESC ", $directory_url);	
							}else{
							$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s' and post_author='".$current_user->ID."' and post_status IN ('publish','pending','draft' )  ORDER BY `ID` DESC  ",$directory_url);	
						}	
						$authpr_post = $wpdb->get_results($sql);
						$total_post=count($authpr_post);									
						if($total_post>0){
							$i=0;
							foreach ( $authpr_post as $row ) 								
							{							
							?>
							<tr>
								<td> <?php echo esc_html($row->ID); ?> </td>	
								<td width="50%"> 
									<a class="profile-desc-link" href="<?php echo get_permalink($row->ID); ?>">
										<?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $row->ID), 'thumbnail' ); 
											if($feature_image[0]!=""){ ?>												
											<img title="profile image" width:"45px;"  src="<?php  echo esc_html($feature_image[0]); ?>">
											<?php												
											}
										
										?>
									&nbsp; <?php echo esc_html($row->post_title); ?></a></td>
										<td width="15%" ><?php 
										if($row->post_status=='publish'){  esc_html_e('publish','ivproperty');} 
										if($row->post_status=='draft'){  esc_html_e('draft','ivproperty');}
										if($row->post_status=='pending'){  esc_html_e('pending','ivproperty');}
									?></td>
									<td width="15%" ><?php 
										$exp_date= get_user_meta($current_user->ID, 'iv_property_exprie_date', true);
										if($exp_date!=''){
											$package_id=get_user_meta($current_user->ID,'iv_property_package_id',true);
											$dir_hide= get_post_meta($package_id, 'iv_property_package_hide_exp', true);
											if($dir_hide=='yes'){
												echo date('d-M-Y',strtotime($exp_date));
											}
										}
									?>
									</td>
									<td width="20%" >
										<?php											
											$edit_post= $profile_url.'?&profile=post-edit&post-id='.$row->ID;										
										?>											
										<a href="<?php echo esc_url($edit_post); ?>" class="btn btn-xs green-haze" ><?php  esc_html_e('Edit','ivproperty');?></a> 										
										<a href="<?php echo esc_url($profile_url).'?&profile=all-post&delete_id='.$row->ID ;?>"  onclick="return confirm('<?php esc_html_e('Are you sure to delete this post?','ivproperty');?>');"  class="btn btn-xs btn-danger"><?php  esc_html_e('Delete','ivproperty');?>										
										</a></td>
							</tr>
							<?php 
							}
						}	
					?>	
				</table>
			</div>
		</div>
	</div>
</div>