<?php

$csv = file_get_contents( wp_get_attachment_url($csv_file_id) );

$csv_rows = explode( "\n", $csv );
$total_rows = count( $csv_rows );

$title_row = $csv_rows[ 0 ];

 update_option( 'eppro_total_row',$total_rows-1);	
 update_option( 'eppro_current_row','1');	
 
$title_row_array= explode(",",$title_row);

	
$maping='';
$main_fields =array('id','post_title','post_content','category','tag','featured-image','image_gallery_urls','property_status', 'bedrooms','bathrooms','guest','garages','sale_or_rent_price','price_postfix_text','area','area_postfix_text', 'address','local-area','latitude','longitude','city','postcode','state','country','phone','contact-email','contact_web','youtube-video','facebook','linkedin','vimeo');

$default_fields = array();
$field_set=get_option('iv_property_fields' );
if($field_set!=""){ 
		$default_fields=get_option('iv_property_fields' );
}else{															
	$default_fields['Property_ID']=esc_html__('Property ID','ivproperty');
	$default_fields['Available_From']=esc_html__('Available From','ivproperty');
	$default_fields['Year_Built']=esc_html__('Year Built');
	$default_fields['Exterior_Material']=esc_html__('Exterior Material','ivproperty');
	$default_fields['Structure_Type']=esc_html__('Structure Type','ivproperty');
	$default_fields['AC']=esc_html__('AC','ivproperty');
	$default_fields['Acres']=esc_html__('Acres','ivproperty');
	$default_fields['Bedroom_Features']=esc_html__('Bedroom Features','ivproperty');
	$default_fields['Cross_Streets']=esc_html__('Cross Streets','ivproperty');
	$default_fields['Dining_Area']=esc_html__('Dining Area','ivproperty');
	$default_fields['Disability_Access']=esc_html__('Disability Access','ivproperty');
	$default_fields['Entry_Location']=esc_html__('Entry Location','ivproperty');
	$default_fields['Exterior_Cnstruction']=esc_html__('Exterior Cnstruction','ivproperty');
	$default_fields['Fireplace_Fuel']=esc_html__('Fireplace Fuel','ivproperty');
	$default_fields['Fireplace_Location']=esc_html__('Fireplace Location','ivproperty');
	$default_fields['Legal_Desc']=esc_html__('Legal Desc','ivproperty');
	$default_fields['Lot_Description']=esc_html__('Lot Description','ivproperty');
	$default_fields['Lot_Size_Source']=esc_html__('Lot Size Source','ivproperty');
	$default_fields['Misc_Interior']=esc_html__('Misc Interior','ivproperty');
	$default_fields['Sewer']=esc_html__('Sewer','ivproperty');
	$default_fields['Source_Of_Sqft']=esc_html__('Source Of Sqft','ivproperty');
	$default_fields['Terms']=esc_html__('Terms','ivproperty');
	$default_fields['View_Desc']=esc_html__('View Desc','ivproperty');
}
if(sizeof($default_fields )){			
	foreach( $default_fields as $field_key => $field_value ) { 
			array_push($main_fields, $field_key);
	}					
}
$i=0;

$maping=$maping.'<form id="csv_maping" name="csv_maping" ><table class="table  table-striped">
  <thead>
    <tr>    
      <th>'.esc_html__('Post Field/Map to field', 'ivproperty' ).'</th>
      <th>'.esc_html__('CSV Column Title/Name', 'ivproperty' ).'</th>      
    </tr>
  </thead>';
  
foreach($title_row_array as $one_col){
	$sel_name= str_replace (' ','-', $one_col);
	$maping=$maping.'<tr><td><select name="'.trim($sel_name).'">';
	$maping=$maping.'<option value="">'.esc_html__('Email', 'ivproperty' ).'</option>';
	$ii=0;
	foreach($main_fields as $main_one){		
		$maping=$maping.'<option value="'.$main_one.'" '.($i==$ii?' selected':"").'>'.$main_one.'</option>';		
		$ii++;
	}	
	$maping=$maping.'</select></td>';
	$maping=$maping.'<td>'.$one_col.'<input type="hidden" name="column'.$i.'" value="'.$one_col.'"></td>';
	$maping=$maping.'</tr>';	
	
 $i++;	
}

$maping=$maping.'</table></form>';

?>