<?php
/**
* Dynamic css file for the theme
*
*/
function vmagazine_lite_dynamic_css(){

    $custom_css = "";

/**
* Categories color
*
*
*/
 global $vmagazine_lite_cat_array;
 if( $vmagazine_lite_cat_array ):
     foreach ( $vmagazine_lite_cat_array as $key => $value ) {
        $cat_color = get_theme_mod('vmagazine_lite_cat_color_' . $key, '#e52d6d');

        $custom_css .="
        span.cat-links .cat-" . esc_attr($key) . "{
                background: " . sanitize_hex_color($cat_color) . ";
        }";
     }
endif;


/**
* Mobile Navigation options
*
*/
$vmagazine_lite_mobile_header_bg_color = get_theme_mod('vmagazine_lite_mobile_header_bg_color');
$vmagazine_lite_mobile_header_bg = get_theme_mod('vmagazine_lite_mobile_header_bg');
$vmagazine_lite_mobile_header_bg_repeat = get_theme_mod('vmagazine_lite_mobile_header_bg_repeat','no-repeat');

if( $vmagazine_lite_mobile_header_bg ){
    $custom_css .="
        .mob-search-form,.mobile-navigation{
            background-image: url(".esc_url($vmagazine_lite_mobile_header_bg).");
            background-repeat: " . esc_attr($vmagazine_lite_mobile_header_bg_repeat) . ";
        }"; 

    $custom_css .="
        .vmagazine-lite-mobile-search-wrapper .mob-search-form .img-overlay,.vmagazine-lite-mobile-navigation-wrapper .mobile-navigation .img-overlay{
            background-color: " . sanitize_hex_color($vmagazine_lite_mobile_header_bg_color) . ";
        }";    
     
}else{
    $custom_css .="
        .mob-search-form,.mobile-navigation{
            background-color: ". sanitize_hex_color($vmagazine_lite_mobile_header_bg_color) . ";
        }";   
}
    
/**
* Theme color
*
*/
$vmagazine_lite_theme_color = get_theme_mod('vmagazine_lite_theme_color','#e52d6d');
$rgba_theme_color = vmagazine_lite_hex2rgba( $vmagazine_lite_theme_color, 0.6 );
$clrgba_theme_color = vmagazine_lite_hex2rgba( $vmagazine_lite_theme_color, 0.3 );
$theme_title_color = vmagazine_lite_hex2rgba( $vmagazine_lite_theme_color, 0.6 );

if( $vmagazine_lite_theme_color != '#e52d6d' ){
    $custom_css .="
    .vmagazine-lite-ticker-wrapper .default-layout .vmagazine-lite-ticker-caption span, 
    .vmagazine-lite-ticker-wrapper .layout-two .vmagazine-lite-ticker-caption span,
    header.header-layout4 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item a:hover,
    a.scrollup,a.scrollup:hover,.widget .tagcloud a:hover,span.cat-links a,.entry-footer .edit-link a.post-edit-link,
    .template-three .widget-title:before, .template-three .block-title:before,.template-three .widget-title span, .template-three .block-title span,.widget-title:after, .block-title:after,
    .template-four .widget-title span, .template-four .block-title span, .template-four .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-related-wrapper h4.related-title span.title-bg, .template-four .comment-respond h4.comment-reply-title span, .template-four .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper h4.section-title span,.template-five .widget-title:before, .template-five .block-title:before,
    .template-five .widget-title span, .template-five .block-title span,.vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more, .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more, .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more,.vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-related-wrapper h4.related-title:after, .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper .section-title:after, .vmagazine-lite-container #primary.vmagazine-lite-content .comment-respond .comment-reply-title:after,
    .vmagazine-lite-container #primary.vmagazine-lite-content .comment-respond .comment-form .form-submit input.submit,.widget .custom-html-widget .tnp-field-button input.tnp-button,.woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_price_filter .ui-slider .ui-slider-range,.woocommerce-page .vmagazine-lite-container.sidebar-shop ul.products li.product .product-img-wrap a.button,.woocommerce-page .vmagazine-lite-container.sidebar-shop ul.products li.product .onsale, .sidebar-shop .sale span.onsale,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,header ul.site-header-cart li span.count,
    header ul.site-header-cart li.cart-items .widget_shopping_cart p.woocommerce-mini-cart__buttons a.button:hover,
    .widget .tagcloud a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_tag_cloud .tagcloud a:hover,
    header.header-layout3 .site-main-nav-wrapper .top-right .vmagazine-lite-search-form-primary form.search-form label:before,
    .vmagazine-lite-archive-layout1 .vmagazine-lite-container #primary article .archive-wrapper .entry-content a.vmagazine-lite-archive-more,
    .vmagazine-lite-container #primary.vmagazine-lite-content .entry-content nav.post-navigation .nav-links a:hover:before,
    .vmagazine-lite-archive-layout4 .vmagazine-lite-container #primary article .entry-content a.vmagazine-lite-archive-more,
    header.header-layout2 .logo-ad-wrapper .middle-search form.search-form:after,
    .ap_toggle .ap_toggle_title,.ap_tagline_box.ap-bg-box,.ap-team .member-social-group a, .horizontal .ap_tab_group .tab-title.active, .horizontal .ap_tab_group .tab-title.hover, .vertical .ap_tab_group .tab-title.active, .vertical .ap_tab_group .tab-title.hover,
    .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper h4.section-title span, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-related-wrapper h4.related-title span, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .comment-respond h4.comment-reply-title span, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper h4.section-title span.title-bg,
    .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper h4.section-title:before, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-related-wrapper h4.related-title:before, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .comment-respond h4.comment-reply-title:before, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper h4.section-title:before,
    .vmagazine-lite-container #primary.vmagazine-lite-content .post-password-form input[type='submit'],
    .woocommerce .cart .button, .woocommerce .cart input.button,
    .dot_1,.vmagazine-lite-grid-list.list #loading-grid .dot_1,
    span.view-all a:hover,.block-post-wrapper.block_layout_3 .view-all a:hover,
    .vmagazine-lite-post-col.block_layout_1 span.view-all a:hover,
    .vmagazine-lite-mul-cat.block-post-wrapper.layout-two .block-content-wrapper .right-posts-wrapper .view-all a:hover,
    .block-post-wrapper.list .gl-posts a.vm-ajax-load-more:hover, .block-post-wrapper.grid-two .gl-posts a.vm-ajax-load-more:hover,
    .vmagazine-lite-cat-slider.block-post-wrapper.block_layout_1 .content-wrapper-featured-slider .lSSlideWrapper li.single-post .post-caption p span.read-more a,.template-five .vmagazine-lite-container #primary.vmagazine-lite-content .comment-respond .comment-reply-title span.title-bg,
    .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-author-metabox h4.box-title span.title-bg,
    .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-author-metabox h4.box-title::before,
    .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-author-metabox .box-title::after,
    .template-five .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-related-wrapper h4.related-title span.title-bg,
    .template-five .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-author-metabox .box-title span.title-bg,
    .middle-search .block-loader .dot_1,.no-results.not-found form.search-form input.search-submit,
    .widget_vmagazine_lite_categories_tabbed .vmagazine-lite-tabbed-wrapper ul#vmagazine-lite-widget-tabbed li.active a, .widget_vmagazine_lite_categories_tabbed .vmagazine-lite-tabbed-wrapper ul#vmagazine-lite-widget-tabbed li a:hover,
    .vmagazine-lite-container #primary .entry-content .post-tag .tags-links a,
    .vmagazine-lite-cat-slider.block-post-wrapper.block_layout_1 .lSSlideWrapper .lSAction > a:hover,
    .related-content-wrapper a.vmagazine-lite-related-more,
    .vmagazine-lite-container #primary .post-review-wrapper .review-inner-wrap .percent-review-wrapper .percent-rating-bar-wrap div, .vmagazine-lite-container #primary .post-review-wrapper .review-inner-wrap .points-review-wrapper .percent-rating-bar-wrap div,
    .vmagazine-lite-fullwid-slider.block_layout_1 .slick-slider .post-content-wrapper h3.extra-large-font a:hover,
    .vmagazine-lite-post-carousel.block_layout_2 .block-carousel .single-post:hover .post-caption h3.large-font a,
    .vmagazine-lite-container #primary .comment-respond .comment-reply-title::after,.vmagazine-block-post-slider .block-content-wrapper .block-post-slider-wrapper button.slick-arrow:hover,.vmagazine-block-post-slider .block-content-wrapper .block-post-slider-wrapper .slick-dots li button::before, .vmagazine-block-post-slider .block-content-wrapper .block-post-slider-wrapper li.slick-active button::before,.lSSlideOuter .lSPager.lSpg > li:hover a, .lSSlideOuter .lSPager.lSpg > li a:hover, .lSSlideOuter .lSPager.lSpg > li.active a,.vmagazine-lite-slider-tab-carousel .block-content-wrapper-carousel button.slick-arrow:hover,.vmagazine-lite-timeline-post .timeline-post-wrapper .single-post .post-date .blog-date-inner span.posted-day
    {
        background: " . sanitize_hex_color($vmagazine_lite_theme_color) . ";
    }";

    $custom_css .="
    a:hover,.vmagazine-lite-ticker-wrapper .layout-two .ticker-tags ul li a:hover,
    header.header-layout2 nav.main-navigation .nav-wrapper .index-icon a:hover, header.header-layout1 nav.main-navigation .nav-wrapper .index-icon a:hover, header.header-layout3 nav.main-navigation .nav-wrapper .index-icon a:hover, header.header-layout4 nav.main-navigation .nav-wrapper .index-icon a:hover,
    .widget.widget_categories ul li,.widget.widget_categories ul li a:hover,footer .buttom-footer.footer_one .footer-credit .footer-social ul.social li a:hover,header.header-layout4 .logo-wrapper-section .vmagazine-lite-container .social-icons ul.social li a:hover,header.header-layout2 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li a:hover, header.header-layout1 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li a:hover, header.header-layout3 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li a:hover, header.header-layout4 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li a:hover,header.header-layout2 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu.mega-sub-menu .ap-mega-menu-con-wrap .cat-con-section .menu-post-block h3 a:hover, header.header-layout1 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu.mega-sub-menu .ap-mega-menu-con-wrap .cat-con-section .menu-post-block h3 a:hover, header.header-layout3 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu.mega-sub-menu .ap-mega-menu-con-wrap .cat-con-section .menu-post-block h3 a:hover, header.header-layout4 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu.mega-sub-menu .ap-mega-menu-con-wrap .cat-con-section .menu-post-block h3 a:hover,.vmagazine-lite-breadcrumb-wrapper .vmagazine-lite-bread-home span.current,.vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_archive ul li,.vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_archive ul li a:hover,
    .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_nav_menu .menu-main-menu-container ul li a:hover, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_rss ul li a:hover, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_recent_entries ul li a:hover, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_meta ul li a:hover, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_pages ul li a:hover,.site-footer .footer-widgets .widget_vmagazine_lite_info .footer_info_wrap .info_wrap div span:first-of-type,
    .vmagazine-lite-container #primary.vmagazine-lite-content .entry-content nav.post-navigation .nav-links a:hover p,
    .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper .review-inner-wrap .summary-wrapper .total-reivew-wrapper span.stars-count,.vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper .review-inner-wrap .stars-review-wrapper .review-featured-wrap span.stars-count span.star-value,header.header-layout1 .vmagazine-lite-top-header .top-menu ul li a:hover, header.header-layout3 .vmagazine-lite-top-header .top-menu ul li a:hover,header.header-layout1 .vmagazine-lite-top-header .top-left ul.social li a:hover, header.header-layout3 .vmagazine-lite-top-header .top-right ul.social li a:hover,header.header-layout1 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item a:hover, header.header-layout3 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item a:hover,header.header-layout2 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li.menu-item.menu-item-has-children:hover:after, header.header-layout1 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li.menu-item.menu-item-has-children:hover:after, header.header-layout3 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li.menu-item.menu-item-has-children:hover:after, header.header-layout4 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li.menu-item.menu-item-has-children:hover:after,header.header-layout2 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li .menu-post-block:hover a, header.header-layout1 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li .menu-post-block:hover a, header.header-layout3 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li .menu-post-block:hover a, header.header-layout4 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item .sub-menu li .menu-post-block:hover a,header.header-layout2 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item:hover a,.woocommerce-page .vmagazine-lite-container.sidebar-shop ul.products li.product:hover a.woocommerce-LoopProduct-link h2,.woocommerce-page .vmagazine-lite-container.sidebar-shop ul.products span.price,.woocommerce-page .vmagazine-lite-container.sidebar-shop .vmagazine-lite-sidebar .widget_product_categories .product-categories li,.woocommerce-page .vmagazine-lite-container.sidebar-shop .vmagazine-lite-sidebar .widget_product_categories .product-categories li a:hover,.woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_top_rated_products ul.product_list_widget li ins span.woocommerce-Price-amount, .woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_recent_reviews ul.product_list_widget li ins span.woocommerce-Price-amount,.woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_top_rated_products ul.product_list_widget li:hover a, .woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_recent_reviews ul.product_list_widget li:hover a,.woocommerce div.product p.price, .woocommerce div.product span.price,.comment-form-rating p.stars,header ul.site-header-cart li.cart-items .widget_shopping_cart p.woocommerce-mini-cart__buttons a.button,footer .buttom-footer.footer_one .footer-btm-wrap .vmagazine-lite-btm-ftr .footer-nav ul li a:hover,
    .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_nav_menu ul li, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_rss ul li, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_recent_entries ul li, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_recent_comments ul li, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_meta ul li, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_pages ul li, .top-footer-wrap .vmagazine-lite-container .widget.widget_meta ul li, .top-footer-wrap .vmagazine-lite-container .widget.widget_pages ul li, .top-footer-wrap .vmagazine-lite-container .widget.widget_recent_comments ul li, .top-footer-wrap .vmagazine-lite-container .widget.widget_recent_entries ul li, .top-footer-wrap .vmagazine-lite-container .widget.widget_rss ul li, .top-footer-wrap .vmagazine-lite-container .widget.widget_nav_menu ul li, .top-footer-wrap .vmagazine-lite-container .widget.widget_archive ul li,
    .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_nav_menu ul li a:hover, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_rss ul li a:hover, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_recent_entries ul li a:hover, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_meta ul li a:hover, .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_pages ul li a:hover, .top-footer-wrap .vmagazine-lite-container .widget_pages ul li a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_meta ul li a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_pages ul li a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_recent_comments ul li a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_recent_entries ul li a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_rss ul li a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_nav_menu ul li a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_archive ul li a:hover,
    .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more:hover, .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more:hover, .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more:hover,
    .vmagazine-lite-archive-layout1 .vmagazine-lite-container #primary article .archive-wrapper .entry-content a.vmagazine-lite-archive-more:hover,
    .vmagazine-lite-container #primary.vmagazine-lite-content .post-password-form input[type='submit']:hover,
    .vmagazine-lite-archive-layout4 .vmagazine-lite-container #primary article .entry-content a.vmagazine-lite-archive-more:hover,
    .vmagazine-lite-container #primary .entry-content .post-tag .tags-links a:hover,
    .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more:hover::after,
    .vmagazine-lite-slider-tab-carousel .block-content-wrapper-carousel .single-post:hover .post-caption h3,
    .woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_top_rated_products ul.product_list_widget li:hover a,
    .woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_recently_viewed_products ul.product_list_widget li:hover a,
    .woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_products ul.product_list_widget li:hover a,
    .woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_recent_reviews ul.product_list_widget li:hover a,
    .related-content-wrapper a.vmagazine-lite-related-more:hover,.vmagazine-block-post-slider .block-content-wrapper .block-post-slider-wrapper .slider-item-wrapper .slider-bigthumb:hover .post-captions h3.large-font a,.vmagazine-block-post-slider .block-content-wrapper .block-post-slider-wrapper .small-thumbs-wrapper .small-thumbs-inner .slider-smallthumb:hover .post-captions h3.large-font a,.vmagazine-lite-rec-posts.recent-post-widget .recent-posts-content .recent-post-content a:hover
    {
        color: " . sanitize_hex_color($vmagazine_lite_theme_color) . ";
    }";

    $custom_css .="
    .widget .tagcloud a:hover,.vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_search form.search-form input.search-field:focus,.site-footer .footer-widgets .widget .tagcloud a:hover,header ul.site-header-cart li.cart-items .widget_shopping_cart p.woocommerce-mini-cart__buttons a.button,.widget .tagcloud a:hover, .top-footer-wrap .vmagazine-lite-container .widget.widget_tag_cloud .tagcloud a:hover,
    .vmagazine-lite-container #primary.vmagazine-lite-content .entry-content nav.post-navigation .nav-links a:hover:before,
    .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more, .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more, .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article .archive-post .entry-content a.vmagazine-lite-archive-more,
    .ap_toggle,.ap_tagline_box.ap-all-border-box,.ap_tagline_box.ap-left-border-box,
    .vmagazine-lite-archive-layout4 .vmagazine-lite-container #primary article .entry-content a.vmagazine-lite-archive-more,
    .vmagazine-lite-archive-layout1 .vmagazine-lite-container #primary article .archive-wrapper .entry-content a.vmagazine-lite-archive-more,
    .vmagazine-lite-container #primary.vmagazine-lite-content .post-password-form input[type='submit'],
    .vmagazine-lite-container #primary.vmagazine-lite-content .post-password-form input[type='submit']:hover,
    .vmagazine-lite-archive-layout2 .vmagazine-lite-container main.site-main article.sticky .archive-post,
    .woocommerce-info,span.view-all a:hover,.vmagazine-lite-post-col.block_layout_1 span.view-all a:hover,
    header.header-layout4 .logo-wrapper-section .vmagazine-lite-container .vmagazine-lite-search-form-primary form.search-form input.search-field:focus,
    .block-post-wrapper.block_layout_3 .view-all a:hover,
    .vmagazine-lite-mul-cat.block-post-wrapper.layout-two .block-content-wrapper .right-posts-wrapper .view-all a:hover,
    .block-post-wrapper.list .gl-posts a.vm-ajax-load-more:hover, .block-post-wrapper.grid-two .gl-posts a.vm-ajax-load-more:hover,
    .vmagazine-lite-cat-slider.block-post-wrapper.block_layout_1 .content-wrapper-featured-slider .lSSlideWrapper li.single-post .post-caption p span.read-more a,
    .no-results.not-found form.search-form input.search-submit,
    .vmagazine-lite-container #primary .entry-content .post-tag .tags-links a,
    .related-content-wrapper a.vmagazine-lite-related-more
    {
        border-color: " . sanitize_hex_color($vmagazine_lite_theme_color) . ";
    }";

    $custom_css .="
    .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_recent_comments ul li span.comment-author-link,
    .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_rss ul li a,.woocommerce-page .vmagazine-lite-container.sidebar-shop .widget_recent_reviews ul.product_list_widget li .reviewer,
    .vmagazine-lite-breadcrumb-wrapper .vmagazine-lite-bread-home li.current
    {
        color: " . vmagazine_lite_sanitize_rgba($rgba_theme_color) . ";
    }";

    $custom_css .="
    .vmagazine-lite-container .vmagazine-lite-sidebar .widget.widget_search form.search-form input.search-field:hover
    {
        border-color: " . vmagazine_lite_sanitize_rgba($clrgba_theme_color) . ";
    }";

     $custom_css .="
    .lSSlideOuter .lSPager.lSpg > li a
    {
        background-color: " . vmagazine_lite_sanitize_rgba($clrgba_theme_color) . ";
    }";

    $custom_css .="
    .template-two .widget-title:before, .template-two .block-title:before,
    .template-two .vmagazine-lite-container #primary.vmagazine-lite-content .comment-respond h4.comment-reply-title:before, .template-two .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-related-wrapper h4.related-title:before, .template-two .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper .section-title:before,
    .template-two .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-author-metabox h4.box-title::before,.vmagazine-lite-slider-tab-carousel .block-content-wrapper-carousel .slick-dots li button::before, .vmagazine-lite-slider-tab-carousel .block-content-wrapper-carousel .slick-dots li.slick-active button::before{
        background: " . vmagazine_lite_sanitize_rgba($theme_title_color) . ";
    }";
    $custom_css .="
    .template-three .widget-title span:after, .template-three .block-title span:after,
    .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper h4.section-title span:after, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-related-wrapper h4.related-title span:after, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .comment-respond h4.comment-reply-title span:after, .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper h4.section-title span.title-bg:after,
    .template-three .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-author-metabox h4.box-title span.title-bg:after,
    .vmagazine-lite-ticker-wrapper .default-layout .vmagazine-lite-ticker-caption span::before, .vmagazine-lite-ticker-wrapper .layout-two .vmagazine-lite-ticker-caption span::before
    {
        border-color: transparent transparent transparent " . sanitize_hex_color($vmagazine_lite_theme_color) . ";
    }";
    $custom_css .="
    .vmagazine-lite-rec-posts.recent-post-widget .recent-posts-content .recent-post-content span a:hover{
        color: $rgba_theme_color;
    }";
    
    $custom_css .="
    header.header-layout3 .site-main-nav-wrapper .top-right .vmagazine-lite-search-form-primary{
        border-top: solid 2px " . sanitize_hex_color($vmagazine_lite_theme_color) . ";
    }";
    $custom_css .="
    .template-four .widget-title span:after, .template-four .block-title span:after, .template-four .vmagazine-lite-container #primary.vmagazine-lite-content .vmagazine-lite-related-wrapper h4.related-title span.title-bg:after, .template-four .comment-respond h4.comment-reply-title span:after, .template-four .vmagazine-lite-container #primary.vmagazine-lite-content .post-review-wrapper h4.section-title span:after
    {
        border-color: " . sanitize_hex_color($vmagazine_lite_theme_color) . " transparent transparent transparent;
    }";

}

//header navigation bg color
$vmagazine_lite_header_nav_bg_color = get_theme_mod('vmagazine_lite_header_nav_bg_color','#FFF');
if( $vmagazine_lite_header_nav_bg_color != '#FFF' ){
    $custom_css .="
   header.header-layout1 .vmagazine-lite-nav-wrapper    
     {
       background: " . sanitize_hex_color($vmagazine_lite_header_nav_bg_color) . "; 
    }";
}

//menu link color
$vmagazine_lite_header_nav_link_color = get_theme_mod('vmagazine_lite_header_nav_link_color','#000');
if( $vmagazine_lite_header_nav_link_color != '#000' ){
    $custom_css .="
    header.header-layout1 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item a,header.header-layout1 nav.main-navigation .nav-wrapper .index-icon a
    {
        color: " . sanitize_hex_color($vmagazine_lite_header_nav_link_color) . ";
    }";

    $custom_css .="
    .icon_bag_alt::before{
        color: " . sanitize_hex_color($vmagazine_lite_header_nav_link_color) . ";
    }";
   
}

//menu link color: hover
$vmagazine_lite_header_nav_link_color_hover = get_theme_mod('vmagazine_lite_header_nav_link_color_hover','#e52d6d');
if( $vmagazine_lite_header_nav_link_color_hover != '#e52d6d' ){
    $custom_css .="
    header.header-layout1 nav.main-navigation .nav-wrapper .menu-mmnu-container ul li.menu-item a:hover,header.header-layout1 nav.main-navigation .nav-wrapper .index-icon a:hover
    {
        color: " . sanitize_hex_color($vmagazine_lite_header_nav_link_color_hover) . ";
    }";

 }

   
   
    wp_add_inline_style( 'vmagazine-lite-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'vmagazine_lite_dynamic_css' );

if( !function_exists( 'vmagazine_lite_sanitize_rgba' ) ) {

    function vmagazine_lite_sanitize_rgba( $color ) {
        if ( empty( $color ) || is_array( $color ) )
            return 'rgba(0,0,0,0)';

        // If string does not start with 'rgba', then treat as hex
        // sanitize the hex color and finally convert hex to rgba
        if ( false === strpos( $color, 'rgba' ) ) {
            return sanitize_hex_color( $color );
        }

        // By now we know the string is formatted as an rgba color so we need to further sanitize it.
        $color = str_replace( ' ', '', $color );
        sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
        return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
    }

}