<?php
	/** Dynamic Styles **/
	function swing_lite_dynamic_styles() {

		$custom_css = "";


		// Countdown background image
		 $ctdwn_background_image = esc_url( get_theme_mod('swing_lite_ctdown_background_image') );
       	if(!empty($ctdwn_background_image) ) {
	        	$custom_css .= ".body-countdown {
        			background-image: url($ctdwn_background_image);
	        	}";
    	}

    	/* General header image */
		$header_image = esc_url(get_header_image());  
		
			if(!empty($header_image) ) {
	        	$custom_css .= ".breadcrumb {
        			background-image: url($header_image);
	        	}";
    	}

    	/* room search section*/
    	$room_search_background_color = esc_attr( get_theme_mod('swing_lite_room_search_background_color') );
    	$room_search_bg_color_arr = swing_lite_hex2rgb($room_search_background_color);
    	$swing_lite_room_search_label_color = esc_attr( get_theme_mod('swing_lite_room_search_label_color') );
    	$section_padding_top_h = esc_attr( get_theme_mod('swing_lite_room_search_padding_top') );
    	$section_padding_bottom_h = esc_attr( get_theme_mod('swing_lite_room_search_padding_bottom') );
    	

       	if(!empty($room_search_background_color) ) {
        	$custom_css .= ".s-search-room {
    			background-color: rgba({$room_search_bg_color_arr[0]}, {$room_search_bg_color_arr[1]}, {$room_search_bg_color_arr[2]}, 0.8);
        	}";
    	}

    	if(!empty($swing_lite_room_search_label_color) ) {
        	$custom_css .= "
        	.banner_class .s-search-room .hotel-booking-search ul li label,
    		.banner_class .s-search-room .widget h3 {
    			color: $swing_lite_room_search_label_color;
        	}";
    	}

    	if($section_padding_top_h) {
	        $custom_css .= ".s-search-room {
	    		padding-top: {$section_padding_top_h}px;
	        }";
        }

        if($section_padding_bottom_h) {
	        $custom_css .= ".s-search-room{
	    		padding-bottom: {$section_padding_bottom_h}px;
	        }";
        }

			

		/* Template Color Color */
		$tpl_color = get_theme_mod( 'swing_lite_theme_color', '#d46e4e' );
		$tpl_color_rgb = swing_lite_hex2rgb( $tpl_color );
		$tpl_color_darker = swing_lite_pro_colour_brightness( $tpl_color, -0.8 );

		// Background Color
			$custom_css .= "
				.header-top-content .right-content > div a:hover,
				.about-class .button-links a:hover,
				.rooms-lists-wrapper .view-all-roms a:hover,
				.service-wrapper .button-links a:hover,
				.testimonial-wrapper .owl-dots .owl-dot span,
				.teams:hover .team-title,
				.special-offer-content .read-more a,
				.gallery-wrapper .grid-item a .button-plus,
				.scrollup,
				.s-rooms-price a:hover,
				.woocommerce.woocommerce-page .content-area ul.products li.product .add_to_cart_button,
				.woocommerce.woocommerce-page .content-area ul.products li.product .product_type_simple,
				.woocommerce .cart .coupon input.button[type=\"submit\"],
				.woocommerce .place-order .button.alt,
				.widget_shopping_cart_content a.button,
				.widget_price_filter .price_slider_amount button[type=submit],
				.woocommerce .cart button[type=submit].single_add_to_cart_button,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
				.woocommerce span.onsale,
				.widget_search.widget input[type=\"submit\"],
				.price_slider_wrapper button[type=\"submit\"],
				.woocommerce a.button,
				.woocommerce input[type=\"submit\"],
				.woocommerce #review_form #respond .form-submit input,
				#hotel-booking-results form .hb_button.hb_checkout,
				#hotel-booking-results form button.hb_add_to_cart,
				#hotel-booking-results form button[type=\"submit\"],
				.widget .hotel_booking_mini_cart .hb_mini_cart_footer .hb_button,
				#hotel-booking-cart .hb_button.hb_checkout,
				#hotel-booking-payment .hb_button.hb_checkout,
				#hotel-booking-cart button[type=\"submit\"],
				#hotel-booking-payment button[type=\"submit\"],
				#hotel-booking-cart button[type=\"button\"],
				#hotel-booking-payment button[type=\"button\"],
				.hb_single_room #reviews #review_form_wrapper form .form-submit input[type=\"submit\"],
				.error404 input[type=\"submit\"],
				.special-offer-template-default.single .wpcf7-form p input[type=\"submit\"],
				.contact-page .panel-layout form input[type=submit],
				.comments-area form input[type=submit],
				.navigation .nav-links a,
				article footer .comments-link a,
				.no-results.not-found input[type=\"submit\"],
				.widget .hb-submit button[type=\"submit\"],
				.hotel-booking-search .hb-submit button[type=\"submit\"],
				.woocommerce .wc-proceed-to-checkout a.button.alt,
				.sk-rotating-plane,
				.sk-double-bounce .sk-child,
				.sk-wave .sk-rect,
				.sk-wandering-cubes .sk-cube,
				.sk-spinner-pulse,
				.sk-chasing-dots .sk-child,
				.sk-three-bounce .sk-child,
				.sk-circle .sk-child:before,
				.sk-cube-grid .sk-cube,
				.sk-fading-circle .sk-circle:before,
				.sk-folding-cube .sk-cube:before,
				button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"],
				[id=\"primary\"] .title:after,
				.hb_single_room .hb_single_room_details .hb_single_room_tabs > li a.active:after,
				.pagination span, .pagination a,
				.hb_button,
                .special-offer-content .read-more a:hover,
                .woocommerce .cart .actions .button:hover,
                .comment-respond .form-submit input[type=submit]#submit:hover,
                .woocommerce .woocommerce-MyAccount-navigation ul li a:after,
                .woocommerce-account .entry-content .woocommerce form button:hover,
                .ui-datepicker.ui-widget .ui-datepicker-calendar .ui-state-default:hover {
					background: {$tpl_color};
				}";

		// Background Color (0.6)
			$custom_css .= "
				.news-offers-wrapper .news-offers:hover .overlay {
					background: rgba( $tpl_color_rgb[0], $tpl_color_rgb[1], $tpl_color_rgb[2], 0.6 );
				}";

		// Background Color (Darker)
			$custom_css .= "
				.pagination .page-numbers.current {
					background: {$tpl_color_darker};
				}";

		// Color
			$custom_css .= "
				.swing-nav .nav ul li.current-menu-item > a,
				.swing-nav .nav ul li > a:hover,
				.testimonials-title .testi-label,
				.team-title .s-team-label,
				.team-image .team-social-links a,
				.contact-wrapper .content-title,
				.rooms .hb_room .summary .sc-wrapper .rooms-features-wrapper .price .price_value,
				.rooms .hb_room .summary .sc-wrapper .rooms-features-wrapper .price .unit,
				.rooms-lists-wrapper .summary .title h4 a:hover,
				.s-rooms-price a,
				.s-rooms-price a span,
				.s-feature-title a,
				.features-content a,
				.features-icon,
				.list-layout .rooms-features-wrapper .rooms-title h3 a:hover,
				.grid-layout .rooms-title h3 a:hover,
				.hb_related_other_room.has_slider .rooms-title h3 a:hover,
				.woocommerce.woocommerce-page .content-area ul.products li.product .add_to_cart_button:hover,
				.woocommerce.woocommerce-page .content-area ul.products li.product .product_type_simple:hover,
				.woocommerce .cart .coupon input.button[type=\"submit\"]:hover,
				.woocommerce .place-order .button.alt:hover,
				.widget_shopping_cart_content a.button:hover,
				.widget_price_filter .price_slider_amount button[type=submit]:hover,
				.woocommerce .cart button[type=submit].single_add_to_cart_button:hover,
				.woocommerce .star-rating span,
				.woocommerce-pagination .page-numbers a,
				.widget_search.widget input[type=\"submit\"]:hover,
				.price_slider_wrapper button[type=\"submit\"]:hover,
				.woocommerce input[type=\"submit\"]:hover,
				#hotel-booking-results form .hb_button.hb_checkout:hover,
				#hotel-booking-results form button[type=\"submit\"]:hover,
				#hotel-booking-payment .hb_button.hb_checkout:hover,
				#hotel-booking-cart button[type=\"submit\"]:hover,
				#hotel-booking-cart button[type=\"button\"]:hover,
				#hotel-booking-payment button[type=\"button\"]:hover,
				.hb_single_room #reviews #review_form_wrapper form .form-submit input[type=\"submit\"]:hover,
				.error404 input[type=\"submit\"]:hover,
				.widget .hb-submit button[type=\"submit\"]:hover,
				.special-offer-template-default.single .wpcf7-form p input[type=\"submit\"]:hover,
				.contact-page .panel-layout form input[type=submit]:hover,
				.comments-area form input[type=submit]:hover,
				article footer .comments-link a:hover,
				.hotel-booking-search .hb-submit button[type=\"submit\"]:hover,
				.no-results.not-found input[type=\"submit\"]:hover,
				.widget.widget_categories ul li a:hover,
				.widget.widget_archive ul li a:hover,
				.widget.widget_pages ul li a:hover,
				.widget.widget_meta ul li a:hover,
				.widget_recent_entries ul li a:hover,
				.widget_nav_menu ul li a:hover,
				.widget_calendar tfoot a:hover,
				.widget_recent_comments ul li a:hover,
				.widget_rss ul li a:hover,
				.widget_swing_lite_ourrooms_simple .post-title a:hover,
				.added_to_cart,
				.woocommerce-cart-form__contents a,
				.woocommerce-info a,
				.payment_method_paypal a,
				.woocommerce-message a,
				.edit-link a,
				.sigle-room-details-wrapper [id=\"primary\"] .price,
				[id=\"primary\"] .hb_single_room .price,
				.hb_single_room .hb_single_room_details .hb_single_room_tabs > li a.active,
				.rating-input:before,
                .banner_class .hb_input_field:after,
                .rooms-title a,
                .wc-layered-nav-rating a,
                .woocommerce a.remove:hover,
                .logged-in-as a, .logged-in-as a:hover,
                .comment-respond .form-submit input[type=submit]#submit,
                .comment-metadata a,
                .comments-area .comment-body .reply a,
                .hb_mini_cart_top .hb_title a, .hb_package_title > a,
                .widget .hotel_booking_mini_cart .hb_mini_cart_item .hb_mini_cart_price span,
                #hotel-booking-results .hb-search-results > .hb-room .hb-room-name a:hover,
                .hb_checkout_item .hb_room_type a,
                #hotel-booking-cart .hb_remove_cart_item:hover, #hotel-booking-payment .hb_remove_cart_item:hover,
                #hotel-booking-payment a,
                .woocommerce .woocommerce-MyAccount-navigation ul li a,
                .woocommerce .woocommerce-MyAccount-navigation ul li.is-active a,
                .woocommerce .woocommerce-MyAccount-navigation ul li a:focus,
                .woocommerce .woocommerce-MyAccount-navigation ul li a:active,
                .woocommerce .woocommerce-MyAccount-navigation ul li:hover a,
                .woocommerce-MyAccount-content a,
                .woocommerce-account .entry-content .woocommerce form button,
                .woocommerce-LostPassword a,
                .woocommerce-message::before,
                .woocommerce-info::before,
                .woocommerce-cart table.cart a.remove:hover:after,
                .tags-links a,
                .comments-area .comment-body .comment-author b.fn a,
                .comment-content a,
                .entry-content a,
                .pingback a {
					color: {$tpl_color};
				}";

		// Border Color
			$custom_css .= "
				.header-top-content .right-content > div a:hover,
				.about-class .button-links a:hover,
				.rooms-lists-wrapper .view-all-roms a:hover,
				.service-wrapper .button-links a:hover,
				.team-title,
				.s-rooms-price a,
				.s-rooms-price a span,
				.price_slider_wrapper button[type=\"submit\"]:hover,
				.woocommerce input[type=\"submit\"]:hover,
				#hotel-booking-results form .hb_button.hb_checkout:hover,
				#hotel-booking-results form button[type=\"submit\"]:hover,
				#hotel-booking-payment .hb_button.hb_checkout:hover,
				#hotel-booking-cart button[type=\"submit\"]:hover,
				#hotel-booking-cart button[type=\"button\"]:hover,
				#hotel-booking-payment button[type=\"button\"]:hover,
				.hb_single_room #reviews #review_form_wrapper form .form-submit input[type=\"submit\"]:hover,
				.error404 input[type=\"submit\"]:hover,
				.widget .hb-submit button[type=\"submit\"]:hover,
				.special-offer-template-default.single .wpcf7-form p input[type=\"submit\"]:hover,
				.contact-page .panel-layout form input[type=submit]:hover,
				.comments-area form input[type=submit]:hover,
				article footer .comments-link a:hover,
				.hotel-booking-search .hb-submit button[type=\"submit\"]:hover,
				.no-results.not-found input[type=\"submit\"]:hover,
				.widget_search.widget input[type=\"submit\"]:hover,
				.price_slider_wrapper button[type=\"submit\"]:hover,
				.woocommerce input[type=\"submit\"]:hover,
				#hotel-booking-results form .hb_button.hb_checkout:hover,
				#hotel-booking-results form button[type=\"submit\"]:hover,
				#hotel-booking-payment .hb_button.hb_checkout:hover,
				#hotel-booking-cart button[type=\"submit\"]:hover,
				#hotel-booking-cart button[type=\"button\"]:hover,
				#hotel-booking-payment button[type=\"button\"]:hover,
				.hb_single_room #reviews #review_form_wrapper form .form-submit input[type=\"submit\"]:hover,
				.error404 input[type=\"submit\"]:hover,
				.widget .hb-submit button[type=\"submit\"]:hover,
				.special-offer-template-default.single .wpcf7-form p input[type=\"submit\"]:hover,
				.contact-page .panel-layout form input[type=submit]:hover,
				.comments-area form input[type=submit]:hover,
				article footer .comments-link a:hover,
				.hotel-booking-search .hb-submit button[type=\"submit\"]:hover,
				.no-results.not-found input[type=\"submit\"]:hover,
				.woocommerce.woocommerce-page .content-area ul.products li.product .add_to_cart_button:hover,
				.woocommerce.woocommerce-page .content-area ul.products li.product .product_type_simple:hover,
				.woocommerce .cart .coupon input.button[type=\"submit\"]:hover,
				.woocommerce .place-order .button.alt:hover,
				.widget_shopping_cart_content a.button:hover,
				.widget_price_filter .price_slider_amount button[type=submit]:hover,
				.woocommerce .cart button[type=submit].single_add_to_cart_button:hover,
				.hb_single_room .hb_room_gallery .camera_thumbs .camera_thumbs_cont ul li.cameracurrent:before,
                .comment-respond .form-submit input[type=submit]#submit,
                .woocommerce-account .entry-content .woocommerce form button,
                .woocommerce-message,
                .woocommerce-info {
					border-color: {$tpl_color};
				}";
                
        // Responsive Css
            $custom_css .= "
                @media only screen and (max-width:992px) {
                    [id=\"toggle\"] > div{
                        background: {$tpl_color};                        
                    }
                }";

		// Border Bottom Color
				$custom_css .= "
					.rooms-lists-wrapper .rooms .hb_room .media a:before {
						border-bottom-color: {$tpl_color};
					}";
                    
        // Defaults
            $custom_css .= "
                .hotel-booking-search .hb-submit button[type=\"submit\"]:hover {
                    border: none;
                    color: #fff;
                }";
               
	$service_bg = get_theme_mod( 'swing_lite_home_service_image_setting', '' );
	if($service_bg) {
		$custom_css .= "
			.section-service {
				background-image: url({$service_bg});
		}";
	}

	$feature_bg = get_theme_mod( 'swing_lite_feature_bg_img', '' );
	if( $feature_bg ) {
		$custom_css .= "
			.section-feature {
				background: url({$feature_bg});
		}";

	}

	$video_bg = get_theme_mod( 'swing_lite_video_bg_img', '' );
	if( $video_bg ) {
		$custom_css .= "
			.section-video {
				background-image: url({$video_bg});
		}";
	}

	/** Room Lists Background Color **/
	$room_list_bg = get_theme_mod( 'swing_lite_home_rooms_lists_bg_color', '#ffffff' );
	if( $room_list_bg ) {
		$custom_css .= ".rooms-lists-wrapper{
			background: {$room_list_bg};
		}";
	}

	/* Hotel Services Background Color **/
	$hservice_bg_color = get_theme_mod( 'swing_lite_hotel_service_bg_color', '#F7F7F7' );
	if( $hservice_bg_color ) {
		$custom_css .= ".hotel-service-wrapper{
			background: {$hservice_bg_color};
		}";
	}
	
	wp_add_inline_style( 'swing-lite-dynamic-style', $custom_css );
				
}
add_action( 'wp_enqueue_scripts', 'swing_lite_dynamic_styles' );

function swing_lite_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    return $rgb; // returns an array with the rgb values
}

function swing_lite_pro_colour_brightness($hex, $percent) {
    // Work out if hash given
    $hash = '';
    if (stristr($hex, '#')) {
        $hex = str_replace('#', '', $hex);
        $hash = '#';
    }
    /// HEX TO RGB
    $rgb = array(hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
    //// CALCULATE 
    for ($i = 0; $i < 3; $i++) {
        // See if brighter or darker
        if ($percent > 0) {
            // Lighter
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
        } else {
            // Darker
            $positivePercent = $percent - ($percent * 2);
            $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1 - $positivePercent));
        }
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    //// RBG to Hex
    $hex = '';
    for ($i = 0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if (strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
    }
    return $hash . $hex;
}