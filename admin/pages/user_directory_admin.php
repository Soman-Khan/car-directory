<?php
	wp_enqueue_style('bootstrap-wp-iv_property-style-11', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap.css');
?>
<div class="bootstrap-wrapper">
	<div class="welcome-panel container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-header" ><?php   esc_html_e('User Setting','ivproperty')	;?>  <small>  </small> </h3>
			</div>
		</div>
		<div class="form-group col-md-12 row">
			<?php
				global $wpdb,$wp_roles;
				$package ='';
				$currencyCode= get_option('_iv_property_api_currency');
				if(isset($_REQUEST['package_sel'])){
					$package = sanitize_text_field($_REQUEST['package_sel']);
				}
				if($package==''){			
					if(isset($_REQUEST['package'])){
						$package=sanitize_text_field($_REQUEST['package']);
					}			
				}	
				$search_user='';
				if(isset($_POST['search_user'])){
					$search_user = sanitize_text_field($_POST['search_user']);
				}
			?>
			<div class="row">
				<div class="main clearfix underline form-group col-md-12">
					<form class=" dd col-md-6"   action="<?php echo the_permalink(); ?>" method="post"  >
						<div class="row pull-left">
							<input type="text" name="search_user" id="search_user" class="search" placeholder="<?php esc_html_e( 'Search by user name', 'ivproperty' );?>" value="<?php echo esc_html($search_user); ?>">
							<button class="submit"><i class="fa fa-search"></i></button>
							<input type="hidden" name="package_hidden" id="package_hidden" value="<?php echo esc_html($package); ?>">
						</div>
					</form>
					<form class=" dd col-md-6"   action="<?php echo the_permalink(); ?>" method="post"  >     
						<div class="row pull-right">	 		  
							<select id="package_sel" name="package_sel" class="btn-infu form-group" >  
								<?php		
									echo'<option value="">'.esc_html__( 'All Roles', 'ivproperty' ).'</option>';									
									foreach ( $wp_roles->roles as $key=>$value ){
										echo'<option value="'.$key.'"  '.($package==$key? " selected" : " ") .' >'.$key.'</option>';	
									}
								?>	
							</select>	
						</div>	  
					</form>
				</div>
			</div>
			<?php
				$no=20;	
				$paged = (isset($_REQUEST['paged'])) ? $_REQUEST['paged'] : 1;
				if($paged==1){
					$offset=0;  
					}else {
					$offset= ($paged-1)*$no;
				}
				$args = array();
				$args['number']=$no;
				$args['offset']=$offset;
				$args['orderby']='registered';
				$args['order']='DESC'; 
				if($package!=''){	
					$role_package= $package; 	
					$args['role']=$role_package;
				}
				if($search_user!=''){							
					$args['search']='*'.$search_user.'*';
				}										
				$user_query = new WP_User_Query( $args );
			?>	
			<table class="table">						 
				<thead>
					<tr>	
						<th> <?php   esc_html_e('Create Date','ivproperty')	;?> </th>						 
						<th> <?php   esc_html_e('User Name','ivproperty')	;?></th>
						<th> <?php   esc_html_e('Email','ivproperty')	;?> </th>
						<th> <?php   esc_html_e('Expiry Date','ivproperty')	;?> </th>
						<th> <?php   esc_html_e('Payment Status','ivproperty')	;?> </th>							  
						<th> <?php   esc_html_e('Role','ivproperty')	;?> </th>							  
						<th><?php    esc_html_e('Action','ivproperty')	;?></th>
					</tr>
				</thead>
				<tbody>
					<?php	
						// User Loop
						if ( ! empty( $user_query->results ) ) {
							foreach ( $user_query->results as $user ) {								
							?>
								<tr>
									<td><?php echo date("d-M-Y h:m:s A" ,strtotime($user->user_registered) ); ?></td>							 
									<td><?php echo esc_html($user->display_name); ?></td>
									<td><?php echo esc_html($user->user_email); ?></td>
									<td><?php
										$exp_date= get_user_meta($user->ID, 'iv_property_exprie_date', true);
										if($exp_date!=''){
											echo date('d-M-Y',strtotime($exp_date));
										}	
									?></td>
									<td>
										<?php 
											echo get_user_meta($user->ID, 'iv_property_payment_status', true);
										?>
									</td>	
									<td><?php
										if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
											foreach ( $user->roles as $role )
											echo ucfirst($role);
										}
									?>
									</td>
									<td>		<a class="btn btn-primary btn-xs" href="?page=wp-iv_property-user_update&id=<?php echo esc_html($user->ID); ?>"> <?php   esc_html_e('Edit','ivproperty')	;?></a> 
										<a class="btn btn-danger btn-xs" href="<?php echo admin_url().'/users.php'?>"><?php   esc_html_e('Delete','ivproperty')	;?> </a>
									</td>
								</tr>
								<?php  	
								}
						} else { 
							?>
							<tr><td><?php esc_html_e( 'No users found', 'ivproperty' );?></td></tr>
					
					<?php
						}
					?>
				</tbody>
			</table>
			<div class="text-center">
				<?php
					$total_user = $user_query->total_users;  
					$total_pages=ceil($total_user/$no);						
					echo '<div id="iv-pagination" class="iv-pagination">';  
					echo paginate_links( array(
					'base'     => add_query_arg('paged','%#%?&package='.$package),
					'format'   => '',
					'prev_text' => esc_html__('&laquo; Previous','ivproperty'), // text for previous page
					'next_text' => esc_html__('Next &raquo;','ivproperty'), // text for next page
					'total' => $total_pages, // the total number of pages we have
					'current' => $paged, // the current page
					'end_size' => 1,
					'mid_size' => 5,	
					));	
					echo '</div></div>';  	
				?>
			</div>
		</div>
	</div>	