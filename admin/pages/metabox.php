 <div class="bootstrap-wrapper">
 	<div class="welcome-panel container-fluid">
 		<?php	
		global $wpdb, $post,$current_user;	
	
		//*************************	plugin file *********
 		 $iv_property_approve= get_post_meta( $post->ID,'iv_property_approve', true );
		 $iv_property_current_author= $post->post_author;
		 $userId=$current_user->ID;
		 if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
 		?>
 		<div class="row">
 			<div class="col-md-12">
				<?php esc_html_e( 'User ID :', 'ivproperty' )?>
 				<select class="form-control" id="iv_property_author_id" name="iv_property_author_id">
 					<?php	
 					$sql="SELECT * FROM $wpdb->users ";		
 					$products_rows = $wpdb->get_results($sql); 	
 					if(sizeof($products_rows)>0){									
 						foreach ( $products_rows as $row ) 
 						{	
 							echo '<option value="'.$row->ID.'"'. ($iv_property_current_author == $row->ID ? "selected" : "").' >'. $row->ID.' | '.$row->user_email.' </option>';
 						}
 					}	
 					?>
 				</select>
 			</div>  
 			<div class="col-md-12"> <label>
 				<input type="checkbox" name="iv_property_approve" id="iv_property_approve" value="yes" <?php echo ($iv_property_approve=="yes" ? 'checked': "" )  ; ?> />  <strong><?php esc_html_e( 'Approve', 'ivproperty' )?></strong>
				</label>
 			</div> 
 		</div>	  
 		<?php
			}
 		?>
 		<br/>
		<div class="row">
 			<div class="col-md-12">
				 <label>
				 <?php
				  $realpro_featured= get_post_meta( $post->ID,'realpro_featured', true );
				 ?>
 				<label><input type="radio" name="realpro_featured" id="realpro_featured" value="featured" <?php echo ($realpro_featured=="featured" ? 'checked': "" )  ; ?> />  <strong><?php esc_html_e( 'Featured (display on top)', 'ivproperty' )?></strong></label>
				<br/>
				<label><input type="radio" name="realpro_featured" id="realpro_featured" value="Not-featured" <?php echo ($realpro_featured=="Not-featured" ? 'checked': "" )  ; ?> />  <strong><?php esc_html_e( 'Not Featured', 'ivproperty' )?></strong></label>
				</label>
			</div>
		</div>		
 	</div>
 </div>		