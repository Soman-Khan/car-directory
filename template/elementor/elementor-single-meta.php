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
               'label' => __( 'Listing Data', 'ivproperty' ),
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

  
	  $this->add_control(
				'size',
				[
					'label' => __( 'Size', 'ivproperty' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => __( 'Default', 'ivproperty' ),
						'small' => __( 'Small', 'ivproperty' ),
						'medium' => __( 'Medium', 'ivproperty' ),
						'large' => __( 'Large', 'ivproperty' ),
						'xl' => __( 'XL', 'ivproperty' ),
						'xxl' => __( 'XXL', 'ivproperty' ),
					],
				]
			);

		$this->add_control(
			'header_size',
			[
				'label' => __( 'HTML Tag', 'ivproperty' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'ivproperty' ),
					'h2' => __( 'H2', 'ivproperty' ),
					'h3' => __( 'H3', 'ivproperty' ),
					'h4' => __( 'H4', 'ivproperty' ),
					'h5' => __( 'H5', 'ivproperty' ),
					'h6' => __( 'H6', 'ivproperty' ),
					'div' => __( 'div', 'ivproperty' ),
					'span' => __( 'span', 'ivproperty' ),
					'p' => __( 'p', 'ivproperty' ),
				],
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'ivproperty' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'ivproperty' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ivproperty' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'ivproperty' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'ivproperty' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->end_controls_section();


    }

   /**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings_for_display();       
		global $post;
    
		if ( empty( $settings['directory_pro_meta'] ) ) {
			return;
			}

		$this->add_render_attribute( 'directory_pro_meta', 'class', 'elementor-heading-title' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'directory_pro_meta', 'class', 'elementor-size-' . $settings['size'] );
		}

		$this->add_inline_editing_attributes( 'directory_pro_meta' );
		$title = get_post_meta($post->ID,$settings['directory_pro_meta'],true) ;
		$title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'directory_pro_meta' ), $title );
		
		echo $title_html;
		
    }
	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function _content_template() {
        ?>
		 <#
		var title = settings.directory_pro_meta;

		view.addRenderAttribute( 'directory_pro_meta', 'class', [ 'elementor-heading-title', 'elementor-size-' + settings.size ] );

		view.addInlineEditingAttributes( 'directory_pro_meta' );
		
		var title_html = '<' + settings.header_size  + ' ' + view.getRenderAttributeString( 'directory_pro_meta' ) + '>' + title + '</' + settings.header_size + '>';

		print( title_html );
		#>
        <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new ListingProSingleMeta );
