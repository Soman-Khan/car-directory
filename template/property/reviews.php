<?php
	$listingid=$id;
?>
<div class="container" >
	<div class="row mx-0">
		<div class="col-md-6">
			<div class="" >
				<?php
					$user_id=$id;
					$total_review_point=0;
					$one_review_total=0;
					$two_review_total=0;
					$three_review_total=0;
					$four_review_total=0;
					$five_review_total=0;
					$post_type='realpro_review';
					$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type ='%s'  and post_author='%d' 	and post_status='publish' ORDER BY ID DESC", $post_type,$user_id);
					$reg_page_user='';
					$iv_redirect_user = get_option( '_ep_ivproperty_profile_public_page');
					if($iv_redirect_user!='defult'){
						$reg_page_user= get_permalink( $iv_redirect_user) ;
					}
					$listing_author_link=get_option('listing_author_link');
					if($listing_author_link==""){$listing_author_link='author';}
					$author_reviews = $wpdb->get_results($sql);
					$total_reviews=count($author_reviews);
					if($total_reviews>0){
						foreach ( $author_reviews as $review )
						{
							$review_val=(int)get_post_meta($review->ID,'review_value',true);
							$total_review_point=$total_review_point+ $review_val;
							if($review_val=='1'){
								$one_review_total=$one_review_total+1;
							}
							if($review_val=='2'){
								$two_review_total=$two_review_total+1;
							}
							if($review_val=='3'){
								$three_review_total=$three_review_total+1;
							}
							if($review_val=='4'){
								$four_review_total=$four_review_total+1;
							}
							if($review_val=='5'){
								$five_review_total=$five_review_total+1;
							}
						}
					}
					$avg_review=0;
					if($total_review_point>0){
						$avg_review= $total_review_point/$total_reviews;
					}
				?>
				<h3 class="m-0 py-2"><?php   esc_html_e('Average rating', 'ivproperty'); ?></h3>
				<h3 class="bold padding-bottom-7"><?php echo number_format($avg_review,1,'.',''); ?> / <?php   esc_html_e('5', 'ivproperty'); ?></h3>
				<i class="far fa-star fa-sm <?php echo ($avg_review>0?'black-star': 'white-star');?>"></i>
				<i class="far fa-star fa-sm <?php echo ($avg_review>=2?'black-star': 'white-star');?>"></i>
				<i class="far fa-star fa-sm <?php echo ($avg_review>=3?'black-star': 'white-star');?>"></i>
				<i class="far fa-star fa-sm <?php echo ($avg_review>=4?'black-star': 'white-star');?>"></i>
				<i class="far fa-star fa-sm <?php echo ($avg_review>=5?'black-star': 'white-star');?>"></i>
			</div>
		</div>
		<div class="col-md-6">
			<h3 class="m-0 py-2"><?php   esc_html_e('Rating breakdown', 'ivproperty'); ?> </h3>
			<div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php   esc_html_e('5', 'ivproperty'); ?> <i class="far fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0; if($total_reviews>0){
						$bar_value=($five_review_total/$total_reviews)*100;
					} ?>
					<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo esc_html($bar_value);?>%">
					</div>
				</div>
				<div class="ml-1" ><?php echo esc_html($five_review_total);?></div>
			</div>
			<div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php   esc_html_e('4', 'ivproperty'); ?> <i class="far fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0;
						if($total_reviews>0){
							$bar_value=($four_review_total/$total_reviews)*100;
						}
					?>
					<div class="progress-bar bg-success" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo esc_html($bar_value);?>%"></div>
				</div>
				<div class="ml-1"><?php echo esc_html($four_review_total);?></div>
			</div>
			<div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php   esc_html_e('3', 'ivproperty'); ?> <i class="far fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0;
						if($total_reviews>0){
							$bar_value=($three_review_total/$total_reviews)*100;
						}
					?>
					<div class="progress-bar bg-info" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo esc_html($bar_value);?>%"></div>
				</div>
				<div class="ml-1"><?php echo esc_html($three_review_total);?></div>
			</div>
			<div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php   esc_html_e('2', 'ivproperty'); ?> <i class="far fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0;
						if($total_reviews>0){
							$bar_value=($two_review_total/$total_reviews)*100;
						}
					?>
					<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo esc_html($bar_value);?>%"></div>
				</div>
				<div class="ml-1"><?php echo esc_html($two_review_total);?></div>
			</div>
			<div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php   esc_html_e('1', 'ivproperty'); ?> <i class="far fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0;
						if($total_reviews>0){
							$bar_value=($one_review_total/$total_reviews)*100;
						}
					?>
					<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo esc_html($bar_value);?>%"></div>
				</div>
				<div class="ml-1"><?php echo esc_html($one_review_total);?></div>
			</div>
		</div>
	</div>
	<div class="agent-info__separator my-5 mx-0"></div>
	<?php
		foreach ( $author_reviews as $review )
		{
			$user_review_val=0;
			$review_submitter=get_post_meta($review->ID, 'review_submitter', true);
			$user_review_val=get_post_meta($review->ID, 'review_value', true);
		?>
		<div class="row my-5" >
			<div class="col-md-3">
				<?php
					$user_image_path=get_user_meta($review_submitter, 'iv_profile_pic_url',true);
					if($user_image_path==''){
						$user_image_path=wp_iv_property_URLPATH.'assets/images/Blank-Profile.jpg';
					}
				?>
				<?php
					$userreview = get_user_by( 'id', $review_submitter );
					$name_display=get_user_meta($review_submitter,'first_name',true).' '.get_user_meta($review_submitter,'last_name',true);
					$profile_public=get_option('_iv_directories_profile_public_page');
					$reg_page_u= get_permalink( $profile_public);
					$reg_page_u= $reg_page_u.'?&id='.$review_submitter;
				?>
				<img src="<?php echo esc_url($user_image_path);?>" class="rounded-circle" width="60px;">
				<div class="review-block-name">										
					<?php
						echo (trim($name_display)!=""? $name_display : $userreview->display_name );
					?>
				</div>
				<div class="review-block-date"><?php echo date('M d, Y',strtotime($review->post_date)); ?></div>
			</div>
			<div class="col-md-9">
				<div class="">
					<i class="far fa-star fa-sm  <?php echo ($user_review_val>0?'black-star': 'white-star');?>"></i>
					<i class="far fa-star fa-sm <?php echo ($user_review_val>1?'black-star': 'white-star');?>"></i>
					<i class="far fa-star fa-sm <?php echo ($user_review_val>2?'black-star': 'white-star');?>"></i>
					<i class="far fa-star fa-sm <?php echo ($user_review_val>3?'black-star': 'white-star');?>"></i>
					<i class="far fa-star fa-sm <?php echo ($user_review_val>4?'black-star': 'white-star');?>"></i>
				</div>
				<div class=""><?php echo esc_html($review->post_title); ?></div>
				<div class=" "><?php echo esc_html($review->post_content); ?></div>
			</div>
		</div>
		<center class="mx-auto" ><hr></center>
		<?php
		}
	?>
	<div class="row mt-5" >
		<div class="col-md-12">
			<form id="iv_review_form" name="iv_review_form" class="" role="form" onsubmit="return false;">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="mb-2"><?php   esc_html_e('Submit your review', 'ivproperty'); ?></h3>
					</div>
				</div>
				<div class="agent-info__separator my-1"></div>
				<div class="row form-group mt-5">
					<div class="col-sm-3">
						<?php   esc_html_e('Subject', 'ivproperty'); ?>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control-xs review_sub" name="review_subject"   value="" placeholder="<?php   esc_html_e('Enter review title', 'ivproperty'); ?>">
					</div>
				</div>
				<div class="row form-group my-0">
					<div class="col-sm-3">
						<?php   esc_html_e('Rating', 'ivproperty'); ?>
					</div>
				
					<div class="col-sm-9">
						<div class="stars">
						
							<input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
							<label class="far fa-star star-5 star-label" for="star-5"></label>
							<input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
						<label class="far fa-star star-4 star-label" for="star-4"></label>
							<input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
							<label class="far fa-star star-3 star-label" for="star-3"></label>
							<input class="star star-2" id="star-2" type="radio" name="star" value="2" />
						<label class="far fa-star star-2 star-label" for="star-2"></label>
							<input class="star star-1" id="star-1" type="radio" name="star" value="1" />
							<label class="far fa-star star-1 star-label" for="star-1"></label>
						</div>
					</div>
				</div>
				<div class="row form-group my-0">
					<div class="col-sm-3">
						<?php   esc_html_e('Comments', 'ivproperty'); ?>
					</div>
					<div class="col-sm-9">
						<textarea class="form-control" cols="50"  name="review_comment" id="review_comment" placeholder="<?php   esc_html_e('Enter review comments', 'ivproperty'); ?>" rows="4" ></textarea>
					</div>
				</div>
				<div class="row form-group mt-2">
					<div class="col-md-8">
					<div id="rmessage"></div>
					</div>
				<div class="col-md-4 text-right">
						<button type="button" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2  " onclick="return iv_submit_review();" >
							<?php   esc_html_e('Submit', 'ivproperty'); ?>
						</button>
						<input type="hidden" name="listingid" id="listingid" value="<?php echo esc_html($listingid); ?>">
						
					</div>
				</div>
			</form>
		</div>
	</div>
</div>