<?php
wp_enqueue_style('wp-iv_property-piblic-11', wp_iv_property_URLPATH . 'admin/files/css/iv-bootstrap.css');
wp_enqueue_style('wp-iv_property-piblic-13', wp_iv_property_URLPATH . 'admin/files/css/profile-public.css');
wp_enqueue_style('iv_property-style-64', wp_iv_property_URLPATH . 'assets/cube/css/cubeportfolio.min.css');
wp_enqueue_script('iv_property-script-public', wp_iv_property_URLPATH . 'admin/files/js/public-profile.js');
wp_enqueue_style('font-awesome-css', wp_iv_property_URLPATH . 'admin/files/css/all.min.css');

$display_name='';
$email='';
$user_id=1;
 if(isset($_REQUEST['id'])){	
	   $author_name= sanitize_text_field($_REQUEST['id']);
		$user = get_user_by( 'slug', $author_name );
	if(isset($user->ID)){
		$user_id=$user->ID;
		$display_name=$user->display_name;
		$email=$user->user_email;
	}
  }else{
	  global $current_user;
	  $user_id=$current_user->ID;
	  $display_name=$current_user->display_name;
	  $email=$current_user->user_email;
		$author_name= $current_user->ID;
	  if($user_id==0){
		$user_id=1;
	  }
  }	
  $iv_profile_pic_url=get_user_meta($user_id, 'iv_profile_pic_thum',true);
	 
	 wp_enqueue_script("jquery");
?>
 <div id="profile-template-5" class="bootstrap-wrapper around-separetor">
    <div class="wrapper">
      <div class="row margin-top-10">
        <div class="col-md-4 col-sm-4">
          <div class="profile-sidebar">
            <div class="portlet light profile-sidebar-portlet">
              <!-- SIDEBAR USERPIC -->
              <div class="profile-userpic text-center"> 
                  <?php			  	
				  	if($iv_profile_pic_url!=''){ ?>
					 <img src="<?php echo esc_url($iv_profile_pic_url); ?>">
					<?php
					}else{
					 echo'	 <img src="'. wp_iv_property_URLPATH.'assets/images/Blank-Profile.jpg" class="agent">';
					}
				  	?>  
                      </div>
              <!-- END SIDEBAR USERPIC -->
              <!-- SIDEBAR USER TITLE -->
              <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                   <?php 
				   $name_display=esc_html(get_user_meta($user_id,'first_name',true)).' '.esc_html(get_user_meta($user_id,'last_name',true));
				   echo (trim($name_display)!=""? $name_display : $display_name );?>
                </div>
                <div class="profile-usertitle-job">
                    <?php echo esc_html(get_user_meta($user_id,'occupation',true)); ?>
                </div>
              </div>
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
            <div class="portlet portlet0 light">
              <!-- STAT -->
              <!-- END STAT -->
              <div>
                <h4 class="profile-desc-title"><?php  esc_html_e('About','ivproperty'); ?>     <?php 
				   $name_display=esc_html(get_user_meta($user_id,'first_name',true)).' '.esc_html(get_user_meta($user_id,'last_name',true));
				   echo (trim($name_display)!=""? $name_display : $display_name );?>
</h4>
                <span class="profile-desc-text"> <?php echo esc_html(get_user_meta($user_id,'description',true)); ?> </span>         
					<?php
					if( get_user_meta($user_id,'hide_phone',true)==''){ ?>
						 <div class="margin-top-20 profile-desc-text">		                   
		                    <i class="fa fa-phone"></i>
					<?php echo 'Phone # :'. esc_html(get_user_meta($user_id,'phone',true)); ?>
						 </div>
					<?php
					}
					if( get_user_meta($user_id,'hide_mobile',true)==''){ ?>
						 <div class="margin-top-20 profile-desc-text">		                   
		                    <i class="fa fa-mobile"></i>
					<?php echo 'Mobile # :'. esc_html(get_user_meta($user_id,'mobile',true)); ?>
						 </div>
					<?php
					}
					if( get_user_meta($user_id,'hide_email',true)==''){ ?>
						 <div class="margin-top-20 profile-desc-link"
						 ><a href="mailto:<?php echo esc_html($email); ?>">		                   
		                    <i class="fa fa-envelope"></i>
							<?php echo esc_html($email); ?>
							</a>
						 </div>
					<?php
					}
            ?>
							<div class="margin-top-20 profile-desc-link"><a href="//<?php  echo esc_url(get_user_meta($user_id,'web_site',true)); ?>">		                   
							<i class="fa fa-globe"></i>
							<?php  echo esc_url(get_user_meta($user_id,'web_site',true));  ?>
							</a>
						 </div>
                <div class="margin-top-20 profile-desc-link">
                  <i class="fa fa-twitter"></i>
                  <a href=" <?php echo esc_url('//www.twitter.com/'); ?><?php  echo esc_html(get_user_meta($user_id,'twitter',true));  ?>/">@<?php  echo get_user_meta($user_id,'twitter',true);  ?></a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                  <i class="fa fa-facebook"></i>
                  <a href="<?php echo esc_url('//www.facebook.com/'); ?><?php  echo esc_html(get_user_meta($user_id,'facebook',true));  ?>/"><?php  echo get_user_meta($user_id,'facebook',true);  ?></a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                  <i class="fa fa-google-plus"></i>
                  <a href="<?php echo esc_url('//www.plus.google.com/');?><?php  echo esc_html(get_user_meta($user_id,'gplus',true));  ?>/"><?php  echo esc_html(get_user_meta($user_id,'gplus',true));  ?></a>
                </div>
              </div>
            </div>
            <!-- END PORTLET MAIN -->
          </div>
          </div>
            <div class="col-md-8 col-sm-8 border-blue">
              <div class="portlet light">
                  <div class="portlet-title tabbable-line clearfix">
                    <div class="caption caption-md pull-left">
                      <i class="icon-globe theme-font hide"></i>
                      <span class="caption-subject font-blue-madison bold uppercase"><?php  esc_html_e('Agent Properties','ivproperty'); ?> </span>
                    </div>
                  </div>
                  <div class="portlet-body">   
							<div id="js-grid-meet-the-team" class="cbp cbp-l-grid-team" >                             
                       <?php
					   $directory_url=get_option('_iv_property_url');					
						if($directory_url==""){$directory_url='property';}
							global $wpdb;
							$iv_post=$directory_url;
							$per_page=8;
							$row_strat=0;$row_end=$per_page;
							$current_page=0 ;
							if(isset($_REQUEST['cpage']) and $_REQUEST['cpage']!=1 ){   
								$current_page=$_REQUEST['cpage']; $row_strat =($current_page-1)*$per_page; 
								$row_end=$per_page;
							}
							$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s' and post_author='%d' and post_status IN ('publish') ORDER BY  ID DESC  limit %d, %d ",$directory_url, $user_id, $row_strat,$row_end);
							$authpr_post = $wpdb->get_results($sql);
							$total_post=count($authpr_post);
							if($total_post>0){
								$i=0;
								foreach ( $authpr_post as $row )								
								{
									$id=$row->ID;
									$feature_img='';
									if(has_post_thumbnail($id)){ 
										$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' ); 
										if($feature_image[0]!=""){ 							
											$feature_img =$feature_image[0];
										}					
									}else{
										$feature_img= wp_iv_property_URLPATH."/assets/images/default-directory.jpg";					
									}
									$currentCategory=wp_get_object_terms( $id, $directory_url.'-category');
									$cat_link='';$cat_name='';$cat_slug='';
									?>
                  <div class="cbp-item <?php echo esc_html($cat_slug); ?> ">
										<a href="<?php echo get_post_permalink($id);?>" class="cbp-caption " rel="nofollow">
											<div class="cbp-caption-defaultWrap">
												<figure>												
												<img src="<?php echo esc_url($feature_img);?>" alt="">
													<figcaption class="for-sale"><?php echo esc_html(get_post_meta($id,'property_status',true)); ?></figcaption>
												</figure>
											</div>
											<div class="cbp-caption-activeWrap">
												<div class="cbp-l-caption-alignCenter">
													<div class="cbp-l-caption-body">
														<div class="cbp-l-caption-text"><?php  esc_html_e('VIEW DETAIL', 'ivproperty' ); ?></div>
													</div>
												</div>
											</div>
										</a>
										<a href="<?php echo get_post_permalink($id); ?>" class="cbp-l-grid-team-name" ><?php echo esc_html($row->post_title); ?></a>										
										<div class="cbp-l-grid-team-position"><?php echo  esc_html(get_post_meta($id,'price_postfix_text',true)). get_post_meta($id,'sale_or_rent_price',true).'&nbsp;';?>
										- <?php echo esc_html($cat_name).'&nbsp;'; ?>
										</div>
									</div>
                                          <?php
                                   }
                               }                
                                          ?>
							</div>	
                      <!-- END PERSONAL INFO TAB -->
                      	<div class="center"><?php
								$sql2=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type =  '%s' and post_author='%d' and post_status IN ('publish') ",$directory_url,$user_id );
								$authpr_post2 = $wpdb->get_results($sql2);
								$total_post=count($authpr_post2);
								$total_page= $total_post/$per_page;								
								$total_page=ceil( $total_page);
								 if($total_page>1){
										$current_page =($current_page==''? '1': $current_page );
										echo ' <ul class="iv-pagination">';										
										for($i=1;$i<= $total_page;$i++){
												echo '<li class="'.($i==$current_page  ? 'active-li': '').' list-pagi"><a href="'.get_permalink().'?&id='.$author_name.'&cpage='.$i.'"> '.$i.'</a></li>';		
										}
										echo'</ul>';
								}		
							?>
						</div>  
                </div>
                </div>
                </div>
        </div>
        </div>
      </div>
<?php
$grid_col1500=get_option('grid_col1500');
if($grid_col1500==""){$grid_col1500='5';}
$grid_col1100=get_option('grid_col1100');
if($grid_col1100==""){$grid_col1100='3';}
$grid_col768=get_option('grid_col768');
if($grid_col768==""){$grid_col768='3';}
$grid_col480=get_option('grid_col480');
if($grid_col480==""){$grid_col480='2';}
$grid_col375=get_option('grid_col375');
if($grid_col375==""){$grid_col375='1';}
wp_enqueue_script('iv_property-ar-script-23', wp_iv_property_URLPATH . 'assets/cube/js/jquery.cubeportfolio.min.js');
wp_enqueue_script('iv_property-ar-script-26', wp_iv_property_URLPATH . 'assets/cube/js/meet-team.js');
	wp_localize_script('iv_property-ar-script-26', 'dirpro_data', array(
		'grid_col1500'=>$grid_col1500,
		'grid_col1100'=>$grid_col1100,
		'grid_col768'=>$grid_col768,
		'grid_col480'=>$grid_col480,
		'grid_col375'=>$grid_col375,
		) );
?>
