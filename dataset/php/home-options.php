<?php
/** Necessary Variable **/
$swing_lite_bg_repeat = array(
  'no-repeat'  => esc_html__('No Repeat', 'swing-lite'),
  'repeat'     => esc_html__('Tile', 'swing-lite'),
  'repeat-x'   => esc_html__('Tile Horizontally', 'swing-lite'),
  'repeat-y'   => esc_html__('Tile Vertically', 'swing-lite'),
);

$swing_lite_bg_size = array(
  'auto' => esc_html__('Auto', 'swing-lite'),
  'cover' => esc_html__('Cover', 'swing-lite'),
  'contain' => esc_html__('Contain', 'swing-lite'),
);

$swing_lite_attachment = array(
    'fixed'      => esc_html__('Fixed', 'swing-lite'),
    'scroll'     => esc_html__('Scroll', 'swing-lite'),
);

$swing_lite_pages = array();
$swing_lite_pages[0] = esc_html__( '-- Select Page --', 'swing-lite' );
$swing_lite_pg_arr = get_pages();
foreach( $swing_lite_pg_arr as $swing_page ) {
  $swing_lite_pages[ $swing_page->ID ] = $swing_page->post_title;
}

// Room Search Form
$wp_customize->add_section( 'swing_lite_room_search_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Banner And Room Search Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

  /* Slider Category  */
  $wp_customize->add_setting( 'swing_lite_slider_category', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
  $wp_customize->add_control( new Swing_lite_Customize_Category_Control( $wp_customize, 'swing_lite_slider_category',  array(
    'label'     => esc_html__( 'Slider Category', 'swing-lite' ),
    'description'   => esc_html__( 'Select the slider category', 'swing-lite' ),
    'section'   => 'swing_lite_room_search_section'
  ) ) );

    $wp_customize->add_setting( 'swing_lite_room_search_option', array( 'sanitize_callback' => 'swing_lite_room_search_sanitize', 'default' => 'overslider' ) );
    $wp_customize->add_control( 'swing_lite_room_search_option', array(
      'type' => 'radio',
      'section' => 'swing_lite_room_search_section',
      'label' => esc_html__( 'Choose Room Search Option', 'swing-lite'  ),
      'description' => esc_html__('If you choose over slider option then the room search form will display on over the banner else it will display on below section', 'swing-lite'),
      'choices' => array(
        'overslider' => esc_html__( 'Over Slider', 'swing-lite'  ),
        'insectons' => esc_html__( 'In Sections', 'swing-lite'  ),
      ), 
    ) );

    /* Background color*/
       $wp_customize->add_setting( 'swing_lite_room_search_background_color', array( 'default' => '', 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 
        'swing_lite_room_search_background_color', 
        array(
            'label'      => esc_html__( 'Room Search Background Color', 'swing-lite' ),
            'section'    => 'swing_lite_room_search_section',
            'settings'   => 'swing_lite_room_search_background_color',
        ) ) );

       /* label color */
        $wp_customize->add_setting( 'swing_lite_room_search_label_color', array( 'default' => '', 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 
        'swing_lite_room_search_label_color', 
        array(
            'label'      => esc_html__( 'Room Search Label Color', 'swing-lite' ),
            'section'    => 'swing_lite_room_search_section',
            'settings'   => 'swing_lite_room_search_label_color',
        ) ) );

       /* margin / padding section */
      $wp_customize->add_setting( 'swing_lite_room_search_padding_top', array( 'default' => '', 'sanitize_callback' => 'swing_lite_sanitize_number' ) );
      $wp_customize->add_control( 'swing_lite_room_search_padding_top', array(
            'type' => 'number',
            'section' => 'swing_lite_room_search_section',
            'label' => esc_html__( 'Padding Top Option', 'swing-lite'  ),
            'description' => esc_html__( 'Enter padding top value in px' , 'swing-lite' )
      ) );

      $wp_customize->add_setting( 'swing_lite_room_search_padding_bottom', array( 'default' => '', 'sanitize_callback' => 'swing_lite_sanitize_number' ) );
      $wp_customize->add_control( 'swing_lite_room_search_padding_bottom', array(
            'type' => 'number',
            'section' => 'swing_lite_room_search_section',
            'label' => esc_html__( 'Padding Bottom Option', 'swing-lite'  ),
            'description' => esc_html__( 'Enter padding bottom value in px' , 'swing-lite' )
      ) );

//About US Section
$wp_customize->add_section( 'swing_lite_about_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'About Us Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

     /* About us section show/hide  */
    $wp_customize->add_setting( 'swing_lite_about_show_hide', array( 'default' => 'hide', 'sanitize_callback' => 'swing_lite_sanitize_switch_option', ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_about_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'About Us Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide About Us Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_about_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    $wp_customize->add_setting( 'swing_lite_home_services_tabs', array(
          'sanitize_callback' => 'swing_lite_sanitize_repeater',
          'transport'         => 'postMessage',
          'default' => json_encode(
              array(
                  array(
                      'services_text' => '',
                      'services_image'    => '',
                      'services_url'    => '',

                  )
              )
          )
      ));
      
  $wp_customize->add_control(  new swing_lite_Repeater_Controler( $wp_customize, 'swing_lite_home_services_tabs', 
          array(
            'label'   => esc_html__('Services Tabs','swing-lite'),
            'section' => 'swing_lite_about_section',
            'swing_lite_box_label' => esc_html__('Tabs','swing-lite'),
            'swing_lite_box_add_control' => esc_html__('Add Tabs','swing-lite'),
            'no_of_options' => 3,
          ),
          array(
            'services_text' => array(
            'type'        => 'text',
            'label'       => esc_html__( 'Title', 'swing-lite' ),
            'default'     => '',
            'class'       => 'un-bottom-block-cat1'
          ),
            'services_image' => array(
            'type'        => 'upload',
            'label'       => esc_html__( 'Image', 'swing-lite' ),
            'default'     => '',
            'class'       => 'un-bottom-block-cat1'
          ),
            'services_url' => array(
            'type'        => 'url',
            'label'       => esc_html__( 'Link', 'swing-lite' ),
            'default'     => '',
            'class'       => 'un-bottom-block-cat1'
          )
               
        )

      )); 
   
    $wp_customize->add_setting('swing_lite_home_about_theme_text_setting', array( 'default' => esc_html__( 'A serene oasis in the heart of your cities', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field', ) );
    $wp_customize->add_control('swing_lite_home_about_theme_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Subtitle', 'swing-lite'),
        'section' => 'swing_lite_about_section',
        'setting' => 'swing_lite_home_about_theme_text_setting',
    )); 

    $wp_customize->add_setting('swing_lite_home_about_caption_text_setting', array( 'default' => esc_html( 'Legendary style makes it one of the most prestigious Hotel in the worlde.', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
    $wp_customize->add_control('swing_lite_home_about_caption_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_about_section',
        'setting' => 'swing_lite_home_about_caption_text_setting',
    )); 

    $wp_customize->add_setting('swing_lite_home_about_main_text_setting', array( 'default' => esc_html__( 'Fantastic place and what makes it even better is that it is not part of some big international chain but locally owned and run. The rooms were great, if possible try to get a suite as it makes things easier with a young family, the hotel is in such a lovely position right on the beach, approximately 100 paces from sea to pool, a little longer via the bar for either a Piton beer or one of the fantastic cocktails!', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
 
    $wp_customize->add_control('swing_lite_home_about_main_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_about_section',
        'setting' => 'swing_lite_home_about_main_text_setting',
    )); 

    $wp_customize->add_setting('swing_lite_home_about_button_label_setting',array( 'default' => esc_html__( 'More About Us', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_about_button_label_setting',array(
        'type' => 'text',
        'label' => esc_html__('About Button Label', 'swing-lite'),
        'section' => 'swing_lite_about_section',
        'setting' => 'swing_lite_home_about_button_label_setting',
    ));


    $wp_customize->add_setting('swing_lite_home_about_button_link_setting',array( 'default' => '', 'sanitize_callback' => 'esc_url_raw',  ));
    $wp_customize->add_control('swing_lite_home_about_button_link_setting',array(
        'type' => 'url',
        'label' => esc_html__('About Button Link', 'swing-lite'),
        'section' => 'swing_lite_about_section',
        'setting' => 'swing_lite_home_about_button_link_setting',
    ));

/* Rooms lists sections */ 
$wp_customize->add_section( 'swing_lite_rooms_lists_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Rooms Lists Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );
   
    /* room lists section show/hide  */
    $wp_customize->add_setting( 'swing_lite_room_lists_show_hide', array(
        'default' => 'hide',
        'sanitize_callback' => 'swing_lite_sanitize_switch_option',
    ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_room_lists_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Room Lists Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Room Lists Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_rooms_lists_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

   	/* Note */
    $wp_customize->add_setting('swing_lite_room_lists_note_setting', array( 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control( new swing_lite_Customize_Info_Control( $wp_customize, 'swing_lite_room_lists_note_setting',array(
        'type' => 'input',
        'section' => 'swing_lite_rooms_lists_section',
        'info' => sprintf( '%1$s <a target="_blank" href="%2$s">%3$s</a> %4$s', esc_html__( 'You can add Rooms from the site Dashboard -', 'swing-lite' ), esc_url(admin_url('edit.php?post_type=hb_room')), esc_html__( 'Rooms', 'swing-lite' ) , esc_html__( 'Custom Post Type menu', 'swing-lite' ) ),
        'setting' => 'swing_lite_room_lists_note_setting',
    )));

    $wp_customize->add_setting('swing_lite_home_rooms_lists_title_setting',array( 'default' => esc_html__( 'Luxury Accomodations', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
    $wp_customize->add_control('swing_lite_home_rooms_lists_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_rooms_lists_section',
        'setting' => 'swing_lite_home_rooms_lists_title_setting',
    ));

     $wp_customize->add_setting('swing_lite_home_rooms_lists_text_setting',array( 'default' => esc_html__( 'Duis metus sem, aliquet vitae mi eget, vehicula vehicula enim. In consectetur velit lectus sollicitudin.', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
     $wp_customize->add_control('swing_lite_home_rooms_lists_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_rooms_lists_section',
        'setting' => 'swing_lite_home_rooms_lists_text_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_rooms_lists_bg_color',array( 'default' => '#ffffff', 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'swing_lite_home_rooms_lists_bg_color', array(
        'label'      => esc_html__( 'Room List Background Color', 'swing-lite' ),
        'description' => esc_html__( 'Set the Background Color for the Room Lists Section.' , 'swing-lite' ),
        'section'    => 'swing_lite_rooms_lists_section',
        'settings'   => 'swing_lite_home_rooms_lists_bg_color',
    ) ) );

/* Featured Page Section 1 */
$wp_customize->add_section( 'swing_featured_page1_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Featured Page 1', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );
  
    /* Featured Page 1 Section show/hide  */
    $wp_customize->add_setting( 'swing_lite_feat_page1_show_hide', array( 'default' => 'hide', 'sanitize_callback' => 'swing_lite_sanitize_switch_option' ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_feat_page1_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Featured Page1 Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Service Section Option', 'swing-lite' ),
        'section'   => 'swing_featured_page1_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    /* Featured Page 1 Section show/hide  */
    $wp_customize->add_setting( 'swing_lite_feat_page1', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control('swing_lite_feat_page1', array(
        'type' => 'select',
        'label' => esc_html__('Select Featured 1 Page', 'swing-lite'),
        'description' => esc_html__( 'Set the page for the Featured Page 1 Section.', 'swing-lite' ),
        'choices' => $swing_lite_pages,
        'section' => 'swing_featured_page1_section',
    ));

/* Hotel Service section */
$wp_customize->add_section( 'swing_hotel_service_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Hotel Services Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

  /* Hotel Service section show/hide  */
  $wp_customize->add_setting( 'swing_lite_hotel_service_show_hide', array(
      'default' => 'hide',
      'sanitize_callback' => 'swing_lite_sanitize_switch_option',
  ) );
  $wp_customize->add_control( new Swing_Lite_Customize_Switch_Control( $wp_customize, 'swing_lite_hotel_service_show_hide',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Hotel Service Section show/hide', 'swing-lite' ),
      'description'   => esc_html__( 'Show/Hide Hotel Service Section Option', 'swing-lite' ),
      'section'   => 'swing_hotel_service_section',
      'choices'   => array(
        'show'  => esc_html__( 'Show', 'swing-lite' ),
        'hide'  => esc_html__( 'Hide', 'swing-lite' )
      )
      
  ) ) );

  $wp_customize->add_setting('swing_lite_hotel_service_title_setting',array( 'default' => esc_html__( 'Hotel Services Price List', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
    $wp_customize->add_control('swing_lite_hotel_service_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_hotel_service_section',
        'setting' => 'swing_lite_hotel_service_title_setting',
    ));

     $wp_customize->add_setting('swing_lite_hotel_service_text_setting',array( 'default' => '', 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
     $wp_customize->add_control('swing_lite_hotel_service_text_setting',array(
        'type' => 'textarea',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_hotel_service_section',
        'setting' => 'swing_lite_hotel_service_text_setting',
    ));

   /** Service Lists Icons **/
    $wp_customize->add_setting( 'swing_lite_hotel_service_lists', array(
      'sanitize_callback' => 'swing_lite_sanitize_repeater',
      'transport'         => 'postMessage',
      'default' => json_encode(
          array(
              array(
                  'service_title' => '',
                  'service_text'    => '',
                  'service_price'    => '',

              )
          )
      )
    )); 
        
    $wp_customize->add_control(  new Swing_Lite_Repeater_Controler( $wp_customize, 'swing_lite_hotel_service_lists', 
      array(
          'label'   => esc_html__('Manage Hotel Services','swing-lite'),
          'section' => 'swing_hotel_service_section',
          'swing_lite_box_label' => esc_html__('Hotel Services','swing-lite'),
          'swing_lite_box_add_control' => esc_html__('Add Service','swing-lite'),
          'no_of_options' => 5,
      ),
          array(
              'service_title' => array(
              'type'        => 'text',
              'label'       => esc_html__( 'Service Ttitle', 'swing-lite' ),
              'default'     => '',
              'class'       => 'un-bottom-block-cat1'
          ),
              'service_text' => array(
              'type'        => 'text',
              'label'       => esc_html__( 'Service Text', 'swing-lite' ),
              'default'     => '',
              'class'       => 'un-bottom-block-cat1'
          ),
              'service_price' => array(
              'type'        => 'text',
              'label'       => esc_html__( 'Service Price', 'swing-lite' ),
              'default'     => '',
              'class'       => 'un-bottom-block-cat1'
          ), 
      )

    ));

    $wp_customize->add_setting('swing_lite_hotel_service_bg_color',array( 'default' => '#F7F7F7', 'sanitize_callback' => 'swing_lite_text_sanitize' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
        'label'      => esc_html__( 'Hotel Services Background Color', 'swing-lite' ),
        'description' => esc_html__( 'Set the Background Color for the Hotel Services Section.' , 'swing-lite' ),
        'section'    => 'swing_hotel_service_section',
        'settings'   => 'swing_lite_hotel_service_bg_color',
    ) ) );

/* Featured Page Section 2 */
$wp_customize->add_section( 'swing_featured_page2_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Featured Page 2', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );
  
    /* Featured Page 2 Section show/hide  */
    $wp_customize->add_setting( 'swing_lite_feat_page2_show_hide', array( 'default' => 'hide', 'sanitize_callback' => 'swing_lite_sanitize_switch_option' ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_feat_page2_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Featured Page2 Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Service Section Option', 'swing-lite' ),
        'section'   => 'swing_featured_page2_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    /* Featured Page 2 Section show/hide */
    $wp_customize->add_setting( 'swing_lite_feat_page2', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control('swing_lite_feat_page2', array(
        'type' => 'select',
        'label' => esc_html__('Select Featured 2 Page', 'swing-lite'),
        'description' => esc_html__( 'Set the page for the Featured Page 2 Section.', 'swing-lite' ),
        'choices' => $swing_lite_pages,
        'section' => 'swing_featured_page2_section',
    ));

/* service section */
$wp_customize->add_section( 'swing_lite_service_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Service Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

    /* service section show/hide  */
    $wp_customize->add_setting( 'swing_lite_service_show_hide', array( 'default' => 'hide', 'sanitize_callback' => 'swing_lite_sanitize_switch_option') );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_service_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Service Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Service Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_service_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );



    //  Image
    $wp_customize->add_setting( 'swing_lite_home_service_image_setting', array(
        'sanitize_callback' => 'esc_url_raw', 
        'capability' => 'edit_theme_options',
        
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'swing_lite_home_service_image_setting', array(
       'label'      => esc_html__( 'Service Section Background Image', 'swing-lite' ),
       'section'    => 'swing_lite_service_section',
       'settings'   => 'swing_lite_home_service_image_setting'         
    ) ) );

    $wp_customize->add_setting('swing_lite_home_service_text_setting', array( 'default' => esc_html__( 'With bespoke services and rejuvenate hospitality', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_service_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Subtitle', 'swing-lite'),
        'section' => 'swing_lite_service_section',
        'setting' => 'swing_lite_home_service_text_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_service_title_setting', array( 'default' => esc_html__( 'New  Dimensions of Luxury & caters to all needs of a modern traveler', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_service_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_service_section',
        'setting' => 'swing_lite_home_service_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_service_button_label_setting', array( esc_html__( 'Explore OUR HOTEL', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_service_button_label_setting',array(
        'type' => 'text',
        'label' => esc_html__('Service Button Label', 'swing-lite'),
        'section' => 'swing_lite_service_section',
        'setting' => 'swing_lite_home_service_button_label_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_service_button_link_setting',array(
        'sanitize_callback' => 'esc_url_raw', 
    ));
    $wp_customize->add_control('swing_lite_home_service_button_link_setting',array(
        'type' => 'url',
        'label' => esc_html__('Service Button Link', 'swing-lite'),
        'section' => 'swing_lite_service_section',
        'setting' => 'swing_lite_home_service_button_link_setting',
    ));

/* testimonial section */
$wp_customize->add_section( 'swing_lite_testimonial_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Testimonial Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

    /* testimonial section show/hide  */
    $wp_customize->add_setting( 'swing_lite_testimonial_show_hide', array( 'default' => 'hide', 'sanitize_callback' => 'swing_lite_sanitize_switch_option' ));
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_testimonial_show_hide',  array(
      'type'      => 'switch',                    
      'label'     => esc_html__( 'Testimonial Section show/hide', 'swing-lite' ),
      'description'   => esc_html__( 'Show/Hide Testimonial Section Option', 'swing-lite' ),
      'section'   => 'swing_lite_testimonial_section',
      'choices'   => array(
        'show'  => esc_html__( 'Show', 'swing-lite' ),
        'hide'  => esc_html__( 'Hide', 'swing-lite' )
      )
    ) ) );

    $wp_customize->add_setting('swing_lite_home_testimonial_title_setting',array( 'default' => esc_html__( 'Customers Word', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_testimonial_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_testimonial_section',
        'setting' => 'swing_lite_home_testimonial_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_testimonial_text_setting',array( 'default' => esc_html__( 'Proin quis turpis semper, onsectetur velit lectus, sit amet sollicitudin ipsum suscipit sed. Integer ut urna site', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_testimonial_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_testimonial_section',
        'setting' => 'swing_lite_home_testimonial_text_setting',
    ));

    /* Testimonial Category  */
    $wp_customize->add_setting( 'swing_lite_testimonial_category', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( new Swing_lite_Customize_Category_Control( $wp_customize, 'swing_lite_testimonial_category',  array(
      'label'     => esc_html__( 'Slider Category', 'swing-lite' ),
      'description'   => esc_html__( 'Select the slider category', 'swing-lite' ),
      'section'   => 'swing_lite_testimonial_section',
    ) ) );

/* team section */
$wp_customize->add_section( 'swing_lite_team_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Team Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

     /* team section show/hide  */
    $wp_customize->add_setting( 'swing_lite_team_show_hide', array(
        'default' => 'hide',
        'sanitize_callback' => 'swing_lite_sanitize_switch_option',
    ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_team_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Team Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Team Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_team_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    /* Team Category  */
    $wp_customize->add_setting( 'swing_lite_team_category', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( new Swing_lite_Customize_Category_Control( $wp_customize, 'swing_lite_team_category',  array(
      'label'     => esc_html__( 'Team Category', 'swing-lite' ),
      'description'   => esc_html__( 'Select the team category', 'swing-lite' ),
      'section'   => 'swing_lite_team_section'
    ) ) );  

    $wp_customize->add_setting('swing_lite_home_team_title_setting',array( 'default' => esc_html__( 'Our Dedicated Team', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_team_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_team_section',
        'setting' => 'swing_lite_home_team_title_setting',
    ));


    $wp_customize->add_setting('swing_lite_home_team_text_setting',array(
        'sanitize_callback' => 'swing_lite_text_sanitize', 
    ));
    $wp_customize->add_control('swing_lite_home_team_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_team_section',
        'setting' => 'swing_lite_home_team_text_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_best_in_team_title_setting',array( 'default' => esc_html__( '24/7 Feel truly at home', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_best_in_team_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Team Subtitle', 'swing-lite'),
        'section' => 'swing_lite_team_section',
        'setting' => 'swing_lite_home_best_in_team_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_best_in_team_sub_title_setting',array( 'default' => esc_html__( 'Get Best From Best', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_best_in_team_sub_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Best In Team Sub Title', 'swing-lite'),
        'section' => 'swing_lite_team_section',
        'setting' => 'swing_lite_home_best_in_team_sub_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_best_in_team_text_setting',array( 'default' => esc_html__( 'Duis metus sem, aliquet vitae mi eget, vehicula vehicula enim. In consectetur velit lectusr, Duis metus sem, aliquet vitae msi eget, vehicula vehicula enim.', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_best_in_team_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Best In Team Text', 'swing-lite'),
        'section' => 'swing_lite_team_section',
        'setting' => 'swing_lite_home_best_in_team_text_setting',
    ));

/* Features section */
$wp_customize->add_section( 'swing_lite_feature_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Features Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

     /* features section show/hide  */
    $wp_customize->add_setting( 'swing_lite_feature_show_hide', array(
        'default' => 'hide',
        'sanitize_callback' => 'swing_lite_sanitize_switch_option',
    ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_feature_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Feature Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Feature Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_feature_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    $wp_customize->add_setting('swing_lite_home_feature_title_setting',array( 'default' => esc_html__( 'Experience & Indulge in Activities', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_feature_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_feature_section',
        'setting' => 'swing_lite_home_feature_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_feature_text_setting',array( 'default' => esc_html__( 'Our blissful atmosphere, attentive service, facilities and the combination of tradition, hospitality and the elegance of simplicity is the answer to your dream holidas', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_feature_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_feature_section',
        'setting' => 'swing_lite_home_feature_text_setting',
    ));

    /** Feature Icons **/
    $wp_customize->add_setting( 'swing_lite_feature_icons', array(
            'sanitize_callback' => 'swing_lite_sanitize_repeater',
            'transport'         => 'postMessage',
            'default' => json_encode(
                array(
                    array(
                        'feature_page' => 0,
                        'feature_icon' => '',

                    )
                )
            )
        ));
        
      $wp_customize->add_control(  new swing_lite_Repeater_Controler( $wp_customize, 'swing_lite_feature_icons', 
        array(
          'label'   => esc_html__('Feature Tabs','swing-lite'),
          'section' => 'swing_lite_feature_section',
          'swing_lite_box_label' => esc_html__('Tabs','swing-lite'),
          'no_of_options' => 6,
        ),
        array(
          'feature_page' => array(
            'type'        => 'page',
            'label'       => esc_html__( 'Feature Page', 'swing-lite' ),
            'description'       => esc_html__( 'Select the Feature Page.', 'swing-lite' ),
            'default'     => '',
            'class'       => 'un-bottom-block-cat1'
          ),
          'feature_icon' => array(
            'type'        => 'all_icon',
            'label'       => esc_html__( 'Feature Icon', 'swing-lite' ),
            'description'       => esc_html__( 'Choose Feature image or icon option , priority will be image', 'swing-lite' ),
            'default'     => '',
            'class'       => 'un-bottom-block-cat1'
          )  
        )

      ));  

      /* Background Image */
      $wp_customize->add_setting('swing_lite_feature_bg_img',array( 'sanitize_callback' => 'esc_url_raw' ));
      $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'swing_lite_feature_bg_img', array(
             'label'      => esc_html__( 'Background Image', 'swing-lite' ),
             'description' => esc_html__('Set the Background Image for the section.', 'swing-lite'),
             'section'    => 'swing_lite_feature_section',
          )
      ) );        

/* Gallery section */
$wp_customize->add_section( 'swing_lite_gallery_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Gallery Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

     /* gallery section show/hide  */
    $wp_customize->add_setting( 'swing_lite_gallery_show_hide', array(
        'default' => 'hide',
        'sanitize_callback' => 'swing_lite_sanitize_switch_option',
    ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_gallery_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Gallery Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Gallery Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_gallery_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    $wp_customize->add_setting('swing_lite_home_gallery_title_setting',array( 'default' => esc_html__( 'Hotel Gallery', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_gallery_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_gallery_section',
        'setting' => 'swing_lite_home_gallery_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_gallery_text_setting',array( 'default' => '', 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_gallery_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_gallery_section',
        'setting' => 'swing_lite_home_gallery_text_setting',
    ));

    $wp_customize->add_setting( 'swing_lite_home_gallery_tabs', array(
            'sanitize_callback' => 'swing_lite_sanitize_repeater',
            'transport'         => 'postMessage',
            'default' => json_encode(
                array(
                    array(
                        'gallery_image' => ''   

                    )
                )
            )
        ));
        
    $wp_customize->add_control(  new swing_lite_Repeater_Controler( $wp_customize, 'swing_lite_home_gallery_tabs', 
            array(
                'label'   => esc_html__('Gallery Tabs','swing-lite'),
                'section' => 'swing_lite_gallery_section',
                'swing_lite_box_label' => esc_html__('Tabs','swing-lite'),
                'no_of_options' => 6,
            ),
                array(
                'gallery_image' => array(
                    'type'        => 'upload',
                    'label'       => esc_html__( 'Image', 'swing-lite' ),
                    'default'     => '',
                    'class'       => 'un-bottom-block-cat1'
                )
        
                 
            )

        ));  

/* Video section */
$wp_customize->add_section( 'swing_lite_video_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Video Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

     /* video section show/hide  */
    $wp_customize->add_setting( 'swing_lite_video_show_hide', array(
        'default' => 'hide',
        'sanitize_callback' => 'swing_lite_sanitize_switch_option',
    ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_video_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Video Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Video Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_video_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) ); 

    $wp_customize->add_setting('swing_lite_home_video_title_setting', array( 'default' => esc_html__( 'An Adrenalin Rush Lacesd with Luxury', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_video_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_video_section',
        'setting' => 'swing_lite_home_video_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_video_subtitle_setting',array( 'default' => '', 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_video_subtitle_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_video_section',
        'setting' => 'swing_lite_home_video_subtitle_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_video_link_setting',array(
        'sanitize_callback' => 'esc_url_raw', 
    ));
    $wp_customize->add_control('swing_lite_home_video_link_setting',array(
        'type' => 'text',
        'label' => esc_html__('Video Link', 'swing-lite'),
        'section' => 'swing_lite_video_section',
        'setting' => 'swing_lite_home_video_link_setting',
    ));

    /* Video Background Image */
    $wp_customize->add_setting('swing_lite_video_bg_img',array( 'sanitize_callback' => 'esc_url_raw' ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'swing_lite_video_bg_img', array(
           'label'      => esc_html__( 'Background Image', 'swing-lite' ),
           'description' => esc_html__('Set the Background Image for the section.', 'swing-lite'),
           'section'    => 'swing_lite_video_section',
        )
    ) );

/* News and Offers section */
$wp_customize->add_section( 'swing_lite_news_offers_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'News & Offers Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

     /* news and offers section show/hide  */
    $wp_customize->add_setting( 'swing_lite_news_offers_show_hide', array(
        'default' => 'hide',
        'sanitize_callback' => 'swing_lite_sanitize_switch_option',
    ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_news_offers_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'News & Offers Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide News & Offers Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_news_offers_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    $wp_customize->add_setting('swing_lite_home_news_offers_title_setting',array( 'default' => esc_html__( 'Latest News & Offers', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_news_offers_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_news_offers_section',
        'setting' => 'swing_lite_home_news_offers_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_news_offers_text_setting',array( 'default' => '', 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_news_offers_text_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_news_offers_section',
        'setting' => 'swing_lite_home_news_offers_text_setting',
    ));

    /* New Category  */
    $wp_customize->add_setting( 'swing_lite_home_news_offers_category_setting', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( new Swing_lite_Customize_Category_Control( $wp_customize, 'swing_lite_home_news_offers_category_setting',  array(
      'label'     => esc_html__( 'News Category', 'swing-lite' ),
      'description'   => esc_html__( 'Select the category for the news section.', 'swing-lite' ),
      'section'   => 'swing_lite_news_offers_section'
    ) ) );

/* Partners sections */ 
$wp_customize->add_section( 'swing_lite_partners_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Partners Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );
   
    /* Partners section show/hide  */
    $wp_customize->add_setting( 'swing_lite_partners_show_hide', array(
        'default' => 'hide',
        'sanitize_callback' => 'swing_lite_sanitize_switch_option',
    ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_partners_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Partners Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Partners Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_partners_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    $wp_customize->add_setting( 'swing_lite_home_partners_tabs', array(
            'sanitize_callback' => 'swing_lite_sanitize_repeater',
            'transport'         => 'postMessage',
            'default' => json_encode(
                array(
                    array(
                        'partners_image' => '',
                        'partners_url'    => '',

                    )
                )
            )
        ));
        
    $wp_customize->add_control(  new swing_lite_Repeater_Controler( $wp_customize, 'swing_lite_home_partners_tabs', 
            array(
                'label'   => esc_html__('Partners Tabs','swing-lite'),
                'section' => 'swing_lite_partners_section',
                'swing_lite_box_label' => esc_html__('Tabs','swing-lite'),
                'no_of_options' => 5,
            ),
                array(
                'partners_image' => array(
                    'type'        => 'upload',
                    'label'       => esc_html__( 'Image', 'swing-lite' ),
                    'default'     => '',
                    'class'       => 'un-bottom-block-cat1'
                ),
                'partners_url' => array(
                    'type'        => 'url',
                    'label'       => esc_html__( 'Link', 'swing-lite' ),
                    'default'     => '',
                    'class'       => 'un-bottom-block-cat1'
                )
                 
            )

        ));  

/* Contact us section */
$wp_customize->add_section( 'swing_lite_contact_section', array(
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Contact Us Section', 'swing-lite' ),
    'panel'          => 'swing_lite_home_panel'
) );

    /* contact us section show/hide  */
    $wp_customize->add_setting( 'swing_lite_contact_show_hide', array(
        'default' => 'hide',
        'sanitize_callback' => 'swing_lite_sanitize_switch_option',
    ) );
    $wp_customize->add_control( new swing_lite_Customize_Switch_Control( $wp_customize, 'swing_lite_contact_show_hide',  array(
        'type'      => 'switch',                    
        'label'     => esc_html__( 'Contact Us Section show/hide', 'swing-lite' ),
        'description'   => esc_html__( 'Show/Hide Contact Us Section Option', 'swing-lite' ),
        'section'   => 'swing_lite_contact_section',
        'choices'   => array(
            'show'  => esc_html__( 'Show', 'swing-lite' ),
            'hide'  => esc_html__( 'Hide', 'swing-lite' )
            )
        
    ) ) );

    $wp_customize->add_setting('swing_lite_home_contact_title_setting',array( 'default' => esc_html__( 'Contact Us', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_contact_title_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Title', 'swing-lite'),
        'section' => 'swing_lite_contact_section',
        'setting' => 'swing_lite_home_contact_title_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_contact_subtitle_setting',array( 'default' => esc_html__( 'Get In Touch With Us', 'swing-lite' ), 'sanitize_callback' => 'sanitize_text_field' ));
    $wp_customize->add_control('swing_lite_home_contact_subtitle_setting',array(
        'type' => 'text',
        'label' => esc_html__('Section Description Text', 'swing-lite'),
        'section' => 'swing_lite_contact_section',
        'setting' => 'swing_lite_home_contact_subtitle_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_contact_phone_setting',array( 'default' => esc_html__( 'Call Us Ate
9876-457-789', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_contact_phone_setting',array(
        'type' => 'textarea',
        'label' => esc_html__('Phone Details', 'swing-lite'),
        'section' => 'swing_lite_contact_section',
        'setting' => 'swing_lite_home_contact_phone_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_contact_address_setting',array( 'default' => esc_html__( 'Aquaria road citye
oppa-road, 245, centara', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_contact_address_setting',array(
        'type' => 'textarea',
        'label' => esc_html__('Address Details', 'swing-lite'),
        'section' => 'swing_lite_contact_section',
        'setting' => 'swing_lite_home_contact_address_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_contact_email_setting',array( 'default' => esc_html__( 'Email Us Ate
Support@support.com', 'swing-lite' ), 'sanitize_callback' => 'swing_lite_text_sanitize' ));
    $wp_customize->add_control('swing_lite_home_contact_email_setting',array(
        'type' => 'textarea',
        'label' => esc_html__('Email Details', 'swing-lite'),
        'section' => 'swing_lite_contact_section',
        'setting' => 'swing_lite_home_contact_email_setting',
    ));

    $wp_customize->add_setting('swing_lite_home_contact_form_setting',array(
        'sanitize_callback' => 'swing_lite_text_sanitize', 
    ));
    $wp_customize->add_control('swing_lite_home_contact_form_setting',array(
        'type' => 'text',
        'label' => esc_html__('Contact Form', 'swing-lite'),
        'section' => 'swing_lite_contact_section',
        'setting' => 'swing_lite_home_contact_form_setting',
    ));