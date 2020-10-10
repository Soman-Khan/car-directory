<?php
get_header(); 
$opt_style=get_option('_archive_template');
if($opt_style==''){$opt_style='style-2';}

	if($opt_style=='style-1'){
		echo do_shortcode('[listing_layout_style_1]');
	}elseif($opt_style=='style-2'){
		echo do_shortcode('[listing_layout_style_2]');
	}else{
		echo do_shortcode('[listing_layout_style_2]');
	}	
get_footer();
 ?>
