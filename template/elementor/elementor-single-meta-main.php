<?php
namespace Elementor;
 class ListingProSingleMeta extends Widget_Base
 {
     public function get_name()
     {
         return "realest_pro_single_meta";
     }

     public function get_title()
     {
         return "Listing Meta";
     }

     public function get_icon()
     {
         return "fas fa-home";
     }

     public function get_categories()
     {
 		return [ 'real-estate-pro' ];
 	 }

/******************** CONTENT PROCESSING ***********************/
     protected function _register_controls() {
         //Top Section Right Side Image
        $this->start_controls_section(
           'directory_pro_meta_data',
           [
               'label' => __( 'Property Listing Data', 'ivproperty' ),
               'tab' => Controls_Manager::TAB_CONTENT,

           ]
        );

		$this->add_control(
			'directory_pro_meta',
			[
				'label' => esc_html__( 'Select Meta', 'ivproperty' ),
				'type' => Controls_Manager::SELECT,
        'block' => true,
				'default' => 'address',
				'options' => [
					'property_type'  => esc_html__( 'Property type(For Rent, For Sales)', 'ivproperty' ),
					'bedrooms'  => esc_html__( '# Bed Rooms', 'ivproperty' ),
					'bathrooms'  => esc_html__( '# Bath Rooms', 'ivproperty' ),
					'guest'  => esc_html__( '# Guest Rooms', 'ivproperty' ),
					'garages'  => esc_html__( '# Garages', 'ivproperty' ),
					'sale_or_rent_price'  => esc_html__( 'Propert Price', 'ivproperty' ),
					'area'  => esc_html__( 'Property Area', 'ivproperty' ),
					'rent_period'  => esc_html__( 'Rent Period', 'ivproperty' ),
					'address'  => esc_html__( 'Address', 'ivproperty' ),
					'city' => esc_html__( 'City', 'ivproperty' ),
					'state' => esc_html__( 'State', 'ivproperty' ),
					'country' => esc_html__( 'Country', 'ivproperty' ),
					'postcode' => esc_html__( 'Post Code', 'ivproperty' ),
					'zipcode' => esc_html__( 'Zip Code', 'ivproperty' ),
					'phone' => esc_html__( 'Conatct Phone #', 'ivproperty' ),
					'contact_email' => esc_html__( 'Contact Email', 'ivproperty' ),
					'contact_web' => esc_html__( 'Contact Web Address', 'ivproperty' ),
					'booking' => esc_html__( 'Booking', 'ivproperty' ),
					'vimeo' => esc_html__('Vimeo video ID', 'ivproperty'),
					'youtube' => esc_html__('Youtube video ID', 'ivproperty'),
					'facebook' => esc_html__('Facebook Profile', 'ivproperty'),
					'twitter' => esc_html__('twitter Profile', 'ivproperty'),
					'instagram' => esc_html__('Instagram Profile', 'ivproperty'),
					'contact_name' => esc_html__('Contact Name', 'ivproperty'),
				],
			]
		);

    $this->end_controls_section();

    $this->start_controls_section(
			'section-style',
			[
				'label' => __( 'Style', 'ivproperty' ),
				'tab' => Controls_Manager::TAB_STYLE ,
			]
		);
    $this->add_control(
			'directory_pro_meta_font_size',
			[
				'label' => __( 'Font Size', 'ivproperty' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter font size', 'ivproperty' ),
				'default' => __( 'inherit', 'ivproperty' ),
			]
		);

    $this->add_control(
			'directory_pro_meta_html_tag',
			[
				'label' => esc_html__( 'Select Tag', 'ivproperty' ),
				'type' => Controls_Manager::SELECT,
        'block' => true,
				'default' => 'h1',
				'options' => [
					'h1'  => esc_html__( 'Heading 1', 'ivproperty' ),
					'h2'  => esc_html__( 'Heading 2', 'ivproperty' ),
					'h3'  => esc_html__( 'Heading 3', 'ivproperty' ),
					'h4'  => esc_html__( 'Heading 4', 'ivproperty' ),
					'h5'  => esc_html__( 'Heading 5', 'ivproperty' ),
					'h6'  => esc_html__( 'Heading 6', 'ivproperty' ),
				],
			]
		);
		$this->end_controls_section();


    }

    /********************* RENDERING ****************************/
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
		<!-- start of card section -->
		 <?php
     if($settings['directory_pro_meta_html_tag']=='h1'){
       $openTag = '<h1 style="font-size:'.$settings['directory_pro_meta_font_size'].' ;"> ';
       $closeTag = '</h1>';
     }
     else if($settings['directory_pro_meta_html_tag']=='h2'){
       $openTag = '<h2 style="font-size:'.$settings['directory_pro_meta_font_size'].' ;"> ';
       $closeTag = '</h2>';
     }
     else if($settings['directory_pro_meta_html_tag']=='h3'){
       $openTag = '<h3 style="font-size:'.$settings['directory_pro_meta_font_size'].' ;"> ';
       $closeTag = '</h3>';
     }
     else if($settings['directory_pro_meta_html_tag']=='h4'){
       $openTag = '<h4 style="font-size:'.$settings['directory_pro_meta_font_size'].' ;"> ';
       $closeTag = '</h4>';
     }
     else if($settings['directory_pro_meta_html_tag']=='h5'){
       $openTag = '<h5 style="font-size:'.$settings['directory_pro_meta_font_size'].' ;"> ';
       $closeTag = '</h5>';
     }
     else{
       $openTag = '<h6 style="font-size:'.$settings['directory_pro_meta_font_size'].' ;"> ';
       $closeTag = '</h6>';
     }


     global $post;

     echo $openTag;
     echo get_post_meta($post->ID,$settings['directory_pro_meta'],true) ;
     echo $closeTag;


		 ?>
		<!-- end of card section -->
        <?php
    }

    protected function _content_template() {
        ?>
<!-- start of card section -->
        <?php echo $openTag; ?>
          {{{ settings.directory_pro_meta }}}
        <?php echo $closeTag; ?>
<!-- end of card section -->
        <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new ListingProSingleMeta );
