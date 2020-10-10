<?php
	wp_enqueue_style('font-awesome-css', wp_iv_property_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_style('wp-iv_property-user-directory', wp_iv_property_URLPATH . 'admin/files/css/user-directory.css');
	wp_enqueue_style('bootstrap-style-11', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_script('iv_property-script-12', wp_iv_property_URLPATH . 'admin/files/js/bootstrap.min.js');
	wp_enqueue_script('iv_property-script-user-directory', wp_iv_property_URLPATH . 'admin/files/js/user-directory.js');
	global $wpdb; 
?>	
<?php
	$package ='';
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
<div id="directory-temp" class="bootstrap-wrapper">
	<div class="main clearfix underline row">
		<form class="pull-right dd col-md-6"   action="<?php echo the_permalink(); ?>" method="post"  >
			<div class="row">
				<input type="text" name="search_user" id="search_user" class="search" placeholder="Agent Name" value="<?php echo esc_html($search_user); ?>">
				<button class="submit"><i class="fa fa-search"></i></button>
				<input type="hidden" name="package_hidden" id="package_hidden" value="<?php echo esc_html($package); ?>">
			</div>
		</form>        	 	
		<form class="pull-right dd col-md-6"   action="<?php echo the_permalink(); ?>" method="post"  >     
			<div class="row">	 		  
				<select id="package_sel" name="package_sel" class="btn-infu" >  
					<?php
						$iv_property_pack='iv_property_pack';
						$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' ",$iv_property_pack);
						$membership_pack = $wpdb->get_results($sql);
						echo'<option value="">All</option>';
						foreach ( $membership_pack as $row ){
							echo'<option value="'.$row->ID.'"  '.($package==$row->ID ? " selected" : " ") .' >'.$row->post_title.'</option>';	
						}
					?>
				</select >
				<div class="arrow-user">
					<i class="fa fa-angle-down"></i>
				</div>        	 	
			</div>
		</form>
	</div>
	<section class="main">
		<ul class="ch-grid">
			<?php
				if(isset($atts['per_page'])){
					$no=$atts['per_page'];
					}else{
					$no=12;
				}
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
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
					$role_package= get_post_meta( $package,'iv_property_package_user_role',true); 	
					$args['role']=$role_package;
				}
				if($search_user!=''){							
					$args['search']='*'.$search_user.'*';
				}
				$iv_redirect_user = get_option( '_iv_property_profile_public_page');
				$reg_page_user='';
				if($iv_redirect_user!='defult'){ 
					$reg_page_user= get_permalink( $iv_redirect_user) ; 										 
				}
				if(isset($atts['role'])){
					$args['role']=$atts['role'];
				}
				$user_query = new WP_User_Query( $args );
				// User Loop
				if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {
						if (isset($user->wp_capabilities['administrator'])!=1 ){ 
							$iv_profile_pic_url=get_user_meta($user->ID, 'iv_profile_pic_thum',true);
							$reg_page_u=$reg_page_user.'?&id='.$user->user_login; 
						?>
						<li>
							<div class="ch-item">
								<a href="<?php echo esc_url($reg_page_u); ?>">		 
									<?php
										if($iv_profile_pic_url!=''){ ?>
										<img src="<?php echo esc_url($iv_profile_pic_url); ?>" class="home-img wide tall">
										<?php
											}else{
											echo'	 <img src="'. wp_iv_property_URLPATH.'assets/images/Blank-Profile.jpg" class="home-img wide tall">';
										} ?>
										<div class="ch-info">				         
										</div>
								</a>
							</div>	
							<p class="para text-center">
								<?php  
									if(get_user_meta($user->ID,'twitter',true)!=''){
									?>
									<a href="<?php echo esc_url('//www.twitter.com/');?><?php  echo get_user_meta($user->ID,'twitter',true);  ?>/">
										<i class="fa fa-twitter"></i>
									</a>
									<?php
									}						 
									if(get_user_meta($user->ID,'linkedin',true)!=''){
									?>
				          <a href="<?php echo esc_url('//www.linkedin.com/');?><?php  echo get_user_meta($user->ID,'linkedin',true);  ?>/">             
										<i class="fa fa-linkedin"></i>
									</a>
									<?php
									}
									if(get_user_meta($user->ID,'facebook',true)!=''){
									?>
				          <a href="<?php echo esc_url('//www.facebook.com/');?><?php  echo get_user_meta($user->ID,'facebook',true);  ?>/">
										<i class="fa fa-facebook"></i>
									</a>
									<?php
									}
									if(get_user_meta($user->ID,'gplus',true)!=''){
									?>
				          <a href="<?php echo esc_url('//www.plus.google.com/');?><?php  echo get_user_meta($user->ID,'gplus',true);  ?>/">            
										<i class="fa fa-google-plus"></i>
									</a>
									<?php
									}
								?>
							</p>
							<a href="<?php echo esc_url($reg_page_u); ?>">
								<h5 class="text-center"><?php echo esc_html($user->display_name); ?></h5>
							</a>	
							<p class="para1 text-center">
								<?php  	if(get_user_meta($user->ID,'occupation',true)==!""){ 
									echo get_user_meta($user->ID,'occupation',true);
								}
								}					
							}
							} else {
							esc_html_e('No users found','ivproperty' ); 
						}
					?>
				</ul>	
			</section>
			<div class="text-center">
				<?php
					$total_user = $user_query->total_users;  
					$total_pages=ceil($total_user/$no);						
					echo '<div id="iv-pagination" class="iv-pagination">';  
					echo paginate_links( array(
					'base' =>  '%_%'.'?&package='.esc_html($package), // the base URL, including query arg						
					'format' => '?&paged=%#%', // this defines the query parameter that will be used, in this case "p"
					'prev_text' => esc_html__('&laquo; Previous','ivproperty'), // text for previous page
					'next_text' => esc_html__('Next &raquo;','ivproperty'), // text for next page
					'total' => esc_html($total_pages), // the total number of pages we have
					'current' =>esc_html( $paged), // the current page
					'end_size' => 1,
					'mid_size' => 5,	
					));					
					echo '</div></div>';  	
				?>
			</div>			