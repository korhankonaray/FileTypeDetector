<?php
  $swing_lite_about_show_hide = get_theme_mod('swing_lite_about_show_hide', 'hide');
    if($swing_lite_about_show_hide == 'show') {
      ?>
      <div class="about-class about-wrapper sclass section-about">
        <div class="s-container ">
          <div class="s-about-wrapper clear">
            <?php 
            global $post;
            $swing_lite_services_tabs = get_theme_mod('swing_lite_home_services_tabs');
            $services_tabs  = json_decode($swing_lite_services_tabs);
            if($services_tabs != '') {
              foreach($services_tabs as  $datas) {
                ?>
                <div class="home-about-features-images">
                  <?php 
                  $swing_lite_img_url = $datas->services_image;
                  if ($swing_lite_img_url != '') {
                    $alt = '';
                    $image_id = attachment_url_to_postid($swing_lite_img_url);
                    if($image_id) {
                      $swing_lite_img = wp_get_attachment_image_src($image_id, 'swing-lite-about-image');
                      $swing_lite_img_src = $swing_lite_img[0];
                      $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    }
                    else {
                      $swing_lite_img_src = $swing_lite_img_url;
                    }
                    
                    ?>
                    <div class="overlay"></div>
                    <img src="<?php echo esc_url($swing_lite_img_src); ?>" alt="<?php echo esc_attr($alt); ?>"/>
                    <?php 
                  }
                  ?>

                  <?php if( $datas->services_url && $datas->services_text ) : ?>
                    <div class="about-feature-service-title">
                      <a href="<?php echo esc_url($datas->services_url); ?>">
                        <?php echo pll__($datas->services_text); ?>
                      </a>
                    </div>
                  <?php endif; ?>
                </div>
                <?php  } } ?>
              </div>
              <div class="about-services-main-content">
                <div class="theme-text sec-subtitle">
                  <?php 
                    $about_theme_text = get_theme_mod( 'swing_lite_home_about_theme_text_setting', esc_html__( 'A serene oasis in the heart of your cities', 'swing-lite' ) );
                    echo esc_html($about_theme_text);
                  ?>
                </div>
                <div class="caption-text sec-title">
                  <?php 
                    $about_caption_text = get_theme_mod('swing_lite_home_about_caption_text_setting', esc_html__( 'Legendary style makes it one of the most prestigious Hotel in the worlde.', 'swing-lite' ) );
                    echo esc_html($about_caption_text);
                  ?>
                </div>
                <div class="main-text sec-description">
                  <?php 
                    $about_main_text = get_theme_mod( 'swing_lite_home_about_main_text_setting', esc_html__( 'Fantastic place and what makes it even better is that it is not part of some big international chain but locally owned and run.
  The rooms were great, if possible try to get a suite as it makes things easier with a young family, the hotel is in such a lovely position right on the beach, approximately 100 paces from sea to pool, a little longer via the bar for either a Piton beer or one of the fantastic cocktails!', 'swing-lite' ) );
                    echo esc_html($about_main_text);
                  ?>
                </div>
              </div>
              <div class="button-links">
                <?php 
                $button_label = get_theme_mod( 'swing_lite_home_about_button_label_setting', esc_html__( 'More About Us', 'swing-lite' ) );
                $button_url = get_theme_mod('swing_lite_home_about_button_link_setting');
                if($button_url && $button_label ) {
                  ?>
                  <a href="<?php echo esc_url($button_url);?>"> 
                    <?php echo esc_html($button_label); ?> 
                  </a>
                  <?php } ?>
                </div>
              </div>
            </div>
            <?php  
          }