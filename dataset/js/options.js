var reset_array = [
    "favicon_img",
    "logo_img",
    "logo_text",
    "links_color",
    "links_hover_color",
	"page_header_custom_color",
	"page_header_custom_image",
    "custom_css",
    "body_bg_color",
    "color_scheme",
    "sidebar_position",
    "body_pattern",
    "option_checkbox",
    "bg_hex_color",
    "header_bg_color",
    "body_pattern_selected",
    "heading_font",
    "main_nav_font",
    "main_nav_font_size",
    "h1_font_family",
    "h1_font_size",
    "h2_font_family",
    "h2_font_size",
    "h3_font_family",
    "h3_font_size",
    "h4_font_family",
    "h4_font_size",
    "h5_font_family",
    "h5_font_size",
    "h6_font_family",
    "h6_font_size",
    "widgets_heading_font_family",
    "widgets_heading_font_size",
	"main_nav_bg_color_top",
	"main_nav_bg_color_bottom",
    "main_nav_def_text_color",
    "main_nav_curr_text_color",
    "main_nav_hover_text_color",
    "main_nav_def_item_bg_color",
    "main_nav_curr_item_bg_color",
    "main_nav_hover_item_bg_color",
    "widget_colored_testimonials_text_color",
    "widget_colored_testimonials_author_text_color",
    "widget_colored_testimonials_bg_color",
    "content_text_color",
    "content_link_color",
    "content_font_family",
    "content_font_size",
    "buttons_text_color",
    "buttons_font_family",
    "buttons_font_size",
    "widget_def_bg_color",
    "widget_def_title_color",
    "widget_def_text_color",
    "widget_colored_bg_color",
    "widget_colored_title_color",
    "widget_colored_text_color",
    "widget_colored_link_color",
    "widget_colored_link_hover_color",
    "image_frame_bg_color",
    "image_frame_hover_bg_color",
    "google_font_select",
    "footer_color",
    "footer_bg_color",
    "logo_text_color",
    "footer_widget_title_color",
    "footer_widget_link_color",
    "footer_widget_link_hover_color",
    "content_fonts"
];


function save_options(type) {
    var data = {
        type: type,
        action: "change_options",
        values: jQuery("#theme_options").serialize()
    };
    //send data to server
    jQuery.post(ajaxurl, data, function(response) {
        show_info_popup(response);
    });
}


function color_scheme() {

    var scheme = jQuery('.control_panel li');

    scheme.on("click", "a", function(e) {

        var self = jQuery(this);
        scheme.find("a").removeClass();
        self.addClass('active');

        var className = jQuery(this).attr('href');
        var hidden = self.parents(".control_panel").find('[name = color_scheme]');
        hidden.val(className);

        e.preventDefault();
    });

}


function init_tabs() {

    var slideSpeed = 500; // 'slow', 'normal', 'fast', or miliseconds
    var $nav = jQuery('#tm ul.admin-nav');
    var $sub = $nav.find('ul');
    var $navLi = $nav.children('li');
    var $navliFirst = $nav.find('li:first');

    if ($navliFirst.length) {
        $navliFirst.addClass('current-shortcut');
        if ($navliFirst.find('ul')) {
            $navliFirst.find('ul').css('display', 'block');
            $navliFirst.find('ul li:first').addClass('sub-current');
        }
    }

    $nav.on('click', 'a', function(e) {

        var $cont = jQuery('#admin-content');
        $cont.attr('style', '');

        window_height = jQuery(window).outerHeight(true),
                admin_height = $cont.outerHeight(true);

        if (admin_height <= window_height) {
            jQuery('#admin-aside, #admin-content').css('min-height', window_height
                    - jQuery('#title-bar').outerHeight(true)
                    - jQuery('.set-holder').outerHeight(true) - 200);
        }
        e.preventDefault();
    });

    $sub.find('a').on('click', function(e) {

        $target = jQuery(e.target);
        $sub.children('li').removeClass();
        $target.parent('li').addClass('sub-current');

        e.preventDefault();
    })

    $navLi.children('a').on('click', function(e) {

        $target = jQuery(e.target);
        jQuery(this).parent('li').children('ul').slideUp(slideSpeed);

        if (jQuery(this).parent('li').children('ul').css('display') == "block") {
            jQuery(this).parent('li').children('ul').slideUp(slideSpeed);
            $target.parent('li').removeClass();

        } else {
            $sub.slideUp(slideSpeed);
            $sub.find('li').removeClass();
            jQuery(this).parent('li').children('ul').slideDown(slideSpeed).find('li:first').addClass('sub-current');
        }

        $navLi.removeClass();
        $target.parent('li').addClass('current-shortcut');

        e.preventDefault();

    });

    var $contentTabs = jQuery('.admin-container');

    jQuery.fn.tabs = function($obj) {
        $tabsNavLis = $obj.find('ul.admin-nav').children('li'),
                $tabContent = $obj.find('#admin-content').children('.tab-content');

        $tabContent.hide();
        $tabsNavLis.first().addClass('active').show();
        $tabContent.first().show();

        $obj.find('ul.admin-nav li > a').on('click', function(e) {

            var $this = jQuery(this);

            $obj.find('ul.admin-nav li').removeClass('active');
            $this.addClass('active');
            $obj.find('.tab-content').hide();
            jQuery($this.attr('href')).fadeIn();

            e.preventDefault();
        });
    }

    $contentTabs.tabs($contentTabs);
}




function deinit_tabs() {
    var $nav = jQuery('#tm ul.admin-nav');
    var $sub = $nav.find('ul');
    var $navLi = $nav.children('li');
    $sub.find('a').unbind('click');
    $navLi.children('a').unbind('click');


    jQuery.fn.tabs = function($obj) {
        $obj.find('ul.admin-nav li > a').unbind('click');
    }
}



function draw_ui_slider_items() {

    var items = jQuery(".ui_slider_item");
    var template = jQuery("#ui_slider_item").html();

    jQuery.each(items, function(key, item) {
        var max_value = parseInt(jQuery(item).attr('max-value'), 10);
        var min_value = parseInt(jQuery(item).attr('min-value'), 10);
        var name = jQuery(item).attr('name');
        var value = parseFloat(jQuery(item).attr('value'), 10);
        if (!value) {
            value = 0;
        }

        var html = template;
        //*****
        html = html.replace(/__UI_SLIDER_NAME__/gi, name);
        html = html.replace(/__UI_SLIDER_VALUE__/gi, value);
        jQuery(item).replaceWith(html);

        jQuery("#" + name + " .range-amount-value").val(value);
        jQuery("#" + name + " .range-amount-value-hidden").val(value);

        var slider = jQuery("." + name).slider({
            range: "max",
            animate: true,
            value: parseFloat(value, 10),
            step: 1,
            min: parseInt(min_value, 10),
            max: parseInt(max_value, 10),
            slide: function(event, ui) {
                jQuery("#" + name + " .range-amount-value").val(ui.value);
                jQuery("#" + name + " .range-amount-value-hidden").val(ui.value);
            }
        });



        jQuery("#" + name + " .range-amount-value").live('change', function() {
            var value = parseFloat(jQuery(this).val(), 10);
            slider.slider("value", value);
            jQuery("#" + name + " .range-amount-value-hidden").val(value);
        });



    });


}



//for dynamic html
function items_colorizator(in_container) {
    var pickers = jQuery(in_container).find('.bgpicker');
    jQuery.each(pickers, function(key, picker) {

        var bg_hex_color = jQuery(picker).prev('.bg_hex_color');

        if (!jQuery(bg_hex_color).val()) {
            jQuery(bg_hex_color).val();
        }

        jQuery(picker).css('background-color', jQuery(bg_hex_color).val()).ColorPicker({
            color: jQuery(bg_hex_color).val(),
            onChange: function(hsb, hex, rgb) {
                jQuery(picker).css('backgroundColor', '#' + hex);
                jQuery(bg_hex_color).val('#' + hex);
                jQuery(bg_hex_color).trigger('change');
            }
        });

    });
}


jQuery(document).ready(function($) {

    color_scheme();

    show_loader();

    init_tabs();
    jQuery("#theme_options").find("input, select").not(".exclude_uniform_on_load").uniform();
    jQuery(".sliders_library").find("input, select").not(".exclude_uniform_on_load").uniform();
    try {
        jQuery("#sortable-drag-holder").sortable();
    }
    catch(e){
        console.log(e);
    }
    draw_ui_slider_items();
    colorizator();


    //option_checkbox
    jQuery(".option_checkbox").live('click', function() {
        if (jQuery(this).is(":checked")) {
            jQuery(this).parents(".checker").next("input[type=hidden]").val(1);
        } else {
            jQuery(this).parents(".checker").next("input[type=hidden]").val(0);
        }
    });

    jQuery('.button_upload').live('click', function()
    {
        get_tb_editor_image_link(jQuery(this).prev('input, textarea'));
        return false;
    });

    jQuery('.button_save_options').live('click', function()
    {
        save_options("save");
        return false;
    });


    jQuery('.button_reset_options').live('click', function()
    {
        if (confirm("Sure?")) {
            jQuery.each(reset_array, function(key, value) {
                jQuery("[name=" + value + "]").val("");
            });

            save_options("reset");
        }

        return false;
    });


    //*** logo block ***

    jQuery("[name=logo_type]").click(function() {
        switch (parseInt(jQuery(this).val(), 10)) {
            case 0:
                jQuery(".logo_img").hide(hide_delay);
                jQuery(".logo_text").show(show_delay);
                break;
            case 1:
                jQuery(".logo_img").show(show_delay);
                jQuery(".logo_text").hide(hide_delay);
                break;
        }
    });
    //***
    //Pattern Selector
    jQuery('.thumb_pattern a').click(function() {
        jQuery('.thumb_pattern a').removeClass('current');
        jQuery(this).addClass('current');
        jQuery('[name=body_pattern]').val(jQuery(this).attr('href'));
        return false;
    });

    jQuery('.body_pattern').live('click', function()
    {
        get_tb_editor_image_link(jQuery('[name=body_pattern]'), jQuery('#body_pattern_upload'));
        return false;
    });

    //insert background by hands
    jQuery('#body_pattern_upload').live('blur', function() {
        jQuery("#body_pattern_custom_image_preview").show();
        jQuery(".body_pattern_custom_image img").attr("src", jQuery(this).val());
        jQuery('[name=body_pattern]').val(jQuery(this).val());
        return false;
    });

    jQuery('[name=body_pattern]').live('change', function() {
        jQuery("#body_pattern_custom_image_preview").show();
        jQuery(".body_pattern_custom_image img").attr("src", jQuery(this).val());
        return false;
    });


    jQuery('[name=body_pattern_selected]').change(function() {
        jQuery(".options_custom_body_pattern ul li").hide();

        switch (parseInt(jQuery(this).val(), 10)) {
            case 0:
                jQuery(".body_pattern_default_image").show(show_delay);
                break;
            case 1:
                jQuery(".body_pattern_custom_image").show(show_delay);
                break;
            case 2:
                jQuery(".body_pattern_custom_color").show(show_delay);
                break;
        }


    });
	
    //insert background by hands
    jQuery('#page_header_upload').live('blur', function() {
        jQuery("#page_header_custom_image_preview").show();
        jQuery(".page_header_custom_image img").attr("src", jQuery(this).val());
        jQuery('[name=page_header_custom_image]').val(jQuery(this).val());
        return false;
    });
	
    jQuery('[name=page_header_custom_image]').live('change', function() {
        jQuery("#page_header_custom_image_preview").show();
        jQuery(".page_header_custom_image img").attr("src", jQuery(this).val());
        return false;
    });

    jQuery('[name=page_header_selected]').change(function() {
        jQuery(".options_custom_page_header_pattern ul li").hide();

        switch (parseInt(jQuery(this).val(), 10)) {
            case 1:
                jQuery(".page_header_custom_image").show(show_delay);
                break;
            case 2:
                jQuery(".page_header_custom_color").show(show_delay);
                break;
        }

    });
	
	
	
    //*****************************
    //Blog settings************
    jQuery("#enable_related_posts").click(function() {
        var value = 0;
        if (jQuery(this).is(":checked")) {
            value = 1;
        }
        jQuery("[name=enable_related_posts]").val(value);
    });

    jQuery("#show_author_info").click(function() {
        var value = 0;
        if (jQuery(this).is(":checked")) {
            value = 1;
        }
        jQuery("[name=show_author_info]").val(value);
    });

    //*************************
    jQuery("[name=export_settings]").focus(function() {
        jQuery(this).select();
    });


    //*****
    jQuery("[name=favicon_img]").change(function() {
        jQuery("#favicon_preview_image").show();
        jQuery("#favicon_preview_image").attr("src", jQuery(this).val());
    });
    jQuery("[name=logo_img]").change(function() {
        jQuery("#logo_preview_image").show();
        jQuery("#logo_preview_image").attr("src", jQuery(this).val());
    });

    //*****

    jQuery(".get_export_code").click(function() {
        var data = {
            action: "get_export_code"
        };
        jQuery.post(ajaxurl, data, function(response) {
            jQuery("[name=export_settings]").val(response);
        });

        return false;
    });


    //*****

    jQuery(".delegate_click").live('click', function() {
        var id_data = jQuery(this).attr('id-data');
        jQuery("[href=#" + id_data + "]").trigger('click');
        return false;
    });


    //*****
    hide_loader();

});
