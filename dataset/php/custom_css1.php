<?php
$links_color = get_option(TMM_THEME_PREFIX . 'links_color');
$links_hover_color = get_option(TMM_THEME_PREFIX . 'links_hover_color');
$heading_font = get_option(TMM_THEME_PREFIX . 'heading_font');
$content_fonts = get_option(TMM_THEME_PREFIX . 'content_fonts');
//colors
//main navigation

$main_nav_bg_color_top = get_option(TMM_THEME_PREFIX . 'main_nav_bg_color_top');
$main_nav_bg_color_bottom = get_option(TMM_THEME_PREFIX . 'main_nav_bg_color_bottom');

$main_nav_def_text_color = get_option(TMM_THEME_PREFIX . 'main_nav_def_text_color');
$main_nav_curr_text_color = get_option(TMM_THEME_PREFIX . 'main_nav_curr_text_color');
$main_nav_hover_text_color = get_option(TMM_THEME_PREFIX . 'main_nav_hover_text_color');

$main_nav_curr_item_bg_color = get_option(TMM_THEME_PREFIX . 'main_nav_curr_item_bg_color');

$main_nav_font = get_option(TMM_THEME_PREFIX . 'main_nav_font');

//content
$content_text_color = get_option(TMM_THEME_PREFIX . 'content_text_color');
$content_link_color = get_option(TMM_THEME_PREFIX . 'content_link_color');

$content_font_family = get_option(TMM_THEME_PREFIX . 'content_font_family');
$content_font_size = get_option(TMM_THEME_PREFIX . 'content_font_size');

//buttons
$buttons_font_family = get_option(TMM_THEME_PREFIX . 'buttons_font_family');
$buttons_font_size = get_option(TMM_THEME_PREFIX . 'buttons_font_size');
$buttons_text_color = get_option(TMM_THEME_PREFIX . 'buttons_text_color');


//widgets
$widget_def_title_color = get_option(TMM_THEME_PREFIX . 'widget_def_title_color');
$widget_def_text_color = get_option(TMM_THEME_PREFIX . 'widget_def_text_color');


$widget_colored_testimonials_text_color = get_option(TMM_THEME_PREFIX . 'widget_colored_testimonials_text_color');
$widget_colored_testimonials_author_text_color = get_option(TMM_THEME_PREFIX . 'widget_colored_testimonials_author_text_color');

//images
$image_frame_bg_color = get_option(TMM_THEME_PREFIX . 'image_frame_bg_color');
$image_frame_hover_bg_color = get_option(TMM_THEME_PREFIX . 'image_frame_hover_bg_color');
//heding
$h1_font_family = get_option(TMM_THEME_PREFIX . 'h1_font_family');
$h1_font_size = get_option(TMM_THEME_PREFIX . 'h1_font_size');

$h2_font_family = get_option(TMM_THEME_PREFIX . 'h2_font_family');
$h2_font_size = get_option(TMM_THEME_PREFIX . 'h2_font_size');

$h3_font_family = get_option(TMM_THEME_PREFIX . 'h3_font_family');
$h3_font_size = get_option(TMM_THEME_PREFIX . 'h3_font_size');

$h4_font_family = get_option(TMM_THEME_PREFIX . 'h4_font_family');
$h4_font_size = get_option(TMM_THEME_PREFIX . 'h4_font_size');

$h5_font_family = get_option(TMM_THEME_PREFIX . 'h5_font_family');
$h5_font_size = get_option(TMM_THEME_PREFIX . 'h5_font_size');

$h6_font_family = get_option(TMM_THEME_PREFIX . 'h6_font_family');
$h6_font_size = get_option(TMM_THEME_PREFIX . 'h6_font_size');

$header_bg_color = get_option(TMM_THEME_PREFIX . 'header_bg_color');
$header_color = get_option(TMM_THEME_PREFIX . 'header_color');

$logo_text_color = "";
$logo_text_color = get_option(TMM_THEME_PREFIX . 'logo_text_color');

$footer_bg_color = get_option(TMM_THEME_PREFIX . 'footer_bg_color');
$footer_color = get_option(TMM_THEME_PREFIX . 'footer_color');
$footer_widget_title_color = get_option(TMM_THEME_PREFIX . 'footer_widget_title_color');
$footer_widget_link_color = get_option(TMM_THEME_PREFIX . 'footer_widget_link_color');
$footer_widget_link_hover_color = get_option(TMM_THEME_PREFIX . 'footer_widget_link_hover_color');
?>


/***************************** Header ***********************************/


<?php if (!empty($header_bg_color)): ?>
    #header {background-color: <?php echo $header_bg_color; ?>}
<?php endif; ?>


/****************************** Footer **********************************/


<?php if (!empty($footer_bg_color)) : ?>
    footer#footer {background-color: <?php echo $footer_bg_color ?>;}
<?php endif; ?>

<?php if (!empty($footer_widget_title_color)): ?>
    #footer .widget-title {color: <?php echo $footer_widget_title_color ?>;}
<?php endif; ?>		

<?php if (!empty($footer_color)): ?>
    #footer, #footer p {color: <?php echo $footer_color ?>;}
<?php endif; ?>

<?php if (!empty($footer_widget_link_color)): ?>
    #footer a {color: <?php echo $footer_widget_link_color ?>;}
<?php endif; ?>		

<?php if (!empty($footer_widget_link_hover_color)): ?>		
    #footer a:hover {color: <?php echo $footer_widget_link_hover_color ?>;}
<?php endif; ?>		


/***************************** Other ************************************/


<?php if ($links_color) echo 'a, a > * {color:' . $links_color . ';}'; ?>
<?php if ($links_hover_color) echo 'a:hover:not(.button, .fc-event), a:hover > * {color:' . $links_hover_color . '!important;}'; ?>
<?php if ($heading_font) echo "h1, h2, h3, h4, h5, h6 { font-family: " . $heading_font . "; }"; ?>
<?php if ($content_fonts) echo 'body, p { font-family:' . $content_fonts . ', sans-serif;}'; ?>




/************************* Main Navigation *******************************/

<?php if (!empty($main_nav_bg_color_top) || !empty($main_nav_bg_color_bottom)): ?>
    .navigation {
		background: <?php echo $main_nav_bg_color_top ?>; /* Old browsers */
		background: -moz-linear-gradient(top,  <?php echo $main_nav_bg_color_top ?> 0%, <?php echo $main_nav_bg_color_bottom ?> 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $main_nav_bg_color_top ?>), color-stop(100%,<?php echo $main_nav_bg_color_bottom ?>)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  <?php echo $main_nav_bg_color_top ?> 0%,<?php echo $main_nav_bg_color_bottom ?> 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  <?php echo $main_nav_bg_color_top ?> 0%,<?php echo $main_nav_bg_color_bottom ?> 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  <?php echo $main_nav_bg_color_top ?> 0%,<?php echo $main_nav_bg_color_bottom ?> 100%); /* IE10+ */
		background: linear-gradient(to bottom,  <?php echo $main_nav_bg_color_top ?> 0%,<?php echo $main_nav_bg_color_bottom ?> 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $main_nav_bg_color_top ?>', endColorstr='<?php echo $main_nav_bg_color_bottom ?>',GradientType=0 ); /* IE6-9 */
	}
<?php endif; ?>

<?php if (!empty($main_nav_font)): ?>
    .navigation > div > ul > li > a,
    .navigation ul ul a {font-family: <?php echo $main_nav_font ?>;}
<?php endif; ?>


<?php if (!empty($main_nav_def_text_color)): ?>
    .navigation > div > ul > li > a {color:<?php echo $main_nav_def_text_color ?>;}
<?php endif; ?>


<?php if (!empty($main_nav_hover_text_color)): ?>
    .navigation > div > ul > li:hover > a {color:<?php echo $main_nav_hover_text_color ?> !important;}
<?php endif; ?>


<?php if (!empty($main_nav_curr_text_color)): ?>
    .navigation > div > ul > li.current-menu-item > a,
    .navigation > div > ul > li.current-menu-parent > a,
    .navigation > div > ul > li.current-menu-ancestor > a,
    .navigation > div > ul > li.current_page_item > a,
    .navigation > div > ul > li.current_page_parent > a,
    .navigation > div > ul > li.current_page_ancestor > a {
    color: <?php echo $main_nav_curr_text_color ?> !important; 
    }
<?php endif; ?>


<?php if (!empty($main_nav_curr_item_bg_color)): ?>
    .navigation ul ul li:hover > a,
    .navigation ul ul li.current-menu-item > a,
    .navigation ul ul li.current-menu-parent > a,
    .navigation ul ul li.current-menu-ancestor > a,
    .navigation ul ul li.current_page_item > a,
    .navigation ul ul li.current_page_parent > a,
    .navigation ul ul li.current_page_ancestor > a {
    background: <?php echo $main_nav_curr_item_bg_color ?>;
    }
<?php endif; ?>


/************************** Content ******************************/


<?php if (!empty($content_font_family)): ?>
    #content, #content p {font-family:<?php echo $content_font_family ?>;}
<?php endif; ?>

<?php if (!empty($content_font_size)): ?>
    #content, #content p{font-size:<?php echo $content_font_size ?>px;}
<?php endif; ?>

<?php if (!empty($content_text_color)): ?>
    #content, #content p {color:<?php echo $content_text_color ?>;}
<?php endif; ?>


/*************************** Buttons *****************************/	


<?php if (!empty($buttons_font_family)): ?>
    .button {font-family:<?php echo $buttons_font_family ?>;}
<?php endif; ?>

<?php if (!empty($buttons_font_size)): ?>
    .button {font-size:<?php echo $buttons_font_size ?>px;}
<?php endif; ?>

<?php if (!empty($buttons_text_color)): ?>
    .button:not(.default) {color:<?php echo $buttons_text_color ?>;}
<?php endif; ?>


/************************** Sidebar ******************************/


<?php if (!empty($widget_def_title_color)): ?>
    #sidebar .widget-title {color:<?php echo $widget_def_title_color ?>;}
<?php endif; ?>
<?php if (!empty($widget_def_text_color)): ?>
    #sidebar .textwidget,
    #sidebar .jta-tweet-text,
    #sidebar .widget p {color:<?php echo $widget_def_text_color ?>;}
<?php endif; ?>


/************************ Testimonials ***************************/


<?php if (!empty($widget_colored_testimonials_text_color)): ?>
    #sidebar .quoteBox .quote-text {color:<?php echo $widget_colored_testimonials_text_color ?>;}
<?php endif; ?>

<?php if (!empty($widget_colored_testimonials_author_text_color)): ?>
    #sidebar .quoteBox .quote-author {color:<?php echo $widget_colored_testimonials_author_text_color ?>;}
<?php endif; ?>


/************************** Picture *****************************/


<?php if (!empty($image_frame_bg_color)): ?>        
    .bordered {background-color:<?php echo $image_frame_bg_color ?>;}
<?php endif; ?>

<?php if (!empty($image_frame_hover_bg_color)): ?>        
    .bordered:hover {background-color:<?php echo $image_frame_hover_bg_color ?>;}
<?php endif; ?>


/************************ Headings *****************************/	


<?php if (!empty($h1_font_family)): ?>
    h1 {font-family:<?php echo $h1_font_family ?>;}
<?php endif; ?>
<?php if (!empty($h1_font_size)): ?>
    h1 {font-size:<?php echo $h1_font_size ?>px;}
<?php endif; ?>

<?php if (!empty($h2_font_family)): ?>
    h2 {font-family:<?php echo $h2_font_family ?>;}
<?php endif; ?>
<?php if (!empty($h2_font_size)): ?>
    h2{font-size:<?php echo $h2_font_size ?>px;}
<?php endif; ?>

<?php if (!empty($h3_font_family)): ?>
    h3 {font-family:<?php echo $h3_font_family ?>;}
<?php endif; ?>
<?php if (!empty($h3_font_size)): ?>
    h3 {font-size:<?php echo $h3_font_size ?>px;}
<?php endif; ?>

<?php if (!empty($h4_font_family)): ?>
    h4 {font-family:<?php echo $h4_font_family ?>;}
<?php endif; ?>
<?php if (!empty($h4_font_size)): ?>
    h4 {font-size:<?php echo $h4_font_size ?>px;}
<?php endif; ?>

<?php if (!empty($h5_font_family)): ?>
    h5 {font-family:<?php echo $h5_font_family ?>;}
<?php endif; ?>
<?php if (!empty($h5_font_size)): ?>
    h5 {font-size:<?php echo $h5_font_size ?>px;}
<?php endif; ?>

<?php if (!empty($h6_font_family)): ?>
    h6 {font-family:<?php echo $h6_font_family ?>;}
<?php endif; ?>
<?php if (!empty($h6_font_size)): ?>
    h6 {font-size:<?php echo $h6_font_size ?>px;}
<?php endif; ?>
	

