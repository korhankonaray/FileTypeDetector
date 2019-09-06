var menuStatus;
var App = new Object();

App = {
    splashScreenDuration: 1000,
    init: function() {
        
        //this should run only once
        $("#menu li a").click(function(){
            $("#menu").hide();
            $(".ui-page-active").animate({marginLeft: 0});
	    $("body").scrollTop(0);
            menuStatus = false;
            var p = $(this).parent();
            if($(p).hasClass('active')){
                $("#menu li").removeClass('active');
            } else {
                $("#menu li").removeClass('active');
                $(p).addClass('active');
            }
        });
        
        setTimeout(function() {
		$("#splash").fadeOut(800);
	}, App.splashScreenDuration);
        
        App.pageInit();
	$(document).bind("pagebeforechange", function() {
		//remove anim-done from previous page's slider
		$(".cherry-slider.anim-done").removeClass("anim-done");
	});
        $(document).bind("pageinit", App.pageInit);
	$(document).bind("pageshow", function() {
		$("body").scrollTop(0);
		$("body").scrollTop(0);
		setTimeout(App.windowLoaded, 1000);
	})
    },
    pageInit: function() {
	
	App.navInit();
        
	setTimeout(function() {
		$('.flexslider:not(.flexslidered)').addClass("flexslidered").flexslider({
			animation: "slide",
			controlNav: false
		});
	}, 1000)
      
      
      //custom checkboxes
      $('.on-off:not(.iphoneStyled)').addClass("iphoneStyled").iphoneStyle();
      
      //initialize photoswipe for portfolio page
      if ($(".photoswipe a:not(.photoSwiped)").length) //dont run if already ran before
         $(".photoswipe a:not(.photoSwiped)").addClass("photoSwiped").click(function(e) {
	}).photoSwipe({});
	
	
        $("#menu").hide();
        $(".ui-page-active").css({
            marginLeft: 0
        });
            
	$(".scroll-to-top").click(function() {
		$("body").animate({scrollTop: 0}, 1000);
	});
	
        $("body").scrollTop(0);
        $("body").scrollTop(0);
        setTimeout(App.windowLoaded, 1000);
	
	//maps
	App.refreshMaps();
	App.Forms.bind();
	App.afterPageInit();
    },
    afterPageInit: function() {
      //tap event effects for links
      $("a:not(.tapInEffected)").addClass("tapInEffected").bind("touchstart mousedown", function() {
         $(this).addClass("hover");
      });
      $("a:not(.tapOutEffected)").addClass("tapOutEffected").bind("touchmove touchend mouseup", function() {
         $(this).removeClass("hover");
      });
      
      
   },

    navInit: function() {
        
        //$.event.special.swipe.horizontalDistanceThreshold = 100;
        
	$(".slider-component, .prevent-swipe-menu").bind("swiperight", function(e) {
		e.stopPropagation();
	});
	
        $('.pages').bind("swipeleft", function(){
                $(".ui-page-active").css({
                    marginLeft: "0px",
                }, 300,
                function(){
                    menuStatus = false;
                    $("#menu").hide();
                });
        });
        $('.pages').bind("swiperight", function(){
				if ($(".pages").width() < 1010)
					return;
                $("#menu").show();

                $(".ui-page-active").css({
                    marginLeft: "165px",
                }, 300, function(){
                    menuStatus = true
                });
				$("body").animate({scrollLeft: 0, scrollTop: 0});
        });
        $("a.back-button").click(function(e) {
            e.preventDefault();
            history.back();
        });
        $("a.showMenu").click(function(){
            if(menuStatus != true){
                $("#menu").show();
                $(".ui-page-active").css({
                    marginLeft: "165px",
                });
		menuStatus = true;
                return false;
            } else {
                $(".ui-page-active").css({
                    marginLeft: "0px",
                });
		menuStatus = false;
                return false;
            }
        });
        
        
        
    },
    windowLoaded: function() {
        //cherry slider
        if ($(".cherry-slider:not(.anim-done)").length) {
            $.each($(".cherry-slider"), function(i, elem) {
                App.cherrySliderInit(elem)
            });
        }
    },
    refreshMaps: function(){
	if (!$(".map").length)
	   return;
	$('.map').each(function(){
	     var me = $(this);
	     var locationTitle = $(this).attr('data-location');
	     var myId = $(me).attr('id');
	     var geocoder = new google.maps.Geocoder();
	     geocoder.geocode({
		  address: locationTitle
	      }, function(locResult) {
		  var latVal = locResult[0].geometry.location.lat();
		  var longVal = locResult[0].geometry.location.lng();
		  App.initializeMap(myId, locationTitle, latVal, longVal);
	      });
	});
     },
     initializeMap: function(locationVal, titleVal, latVal, longVal) {
	var latlng = new google.maps.LatLng(latVal, longVal);
	var settings = {
		zoom: 13,
		center: latlng,
		mapTypeControl: false,
		mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
		navigationControl: false,
		navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
		streetViewControl: false,
		zoomControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP 
	};
	var map = new google.maps.Map(document.getElementById(locationVal), settings);
	
	
	var nibrasPos= new google.maps.LatLng(latVal, longVal);
	var nibrasMarker = new google.maps.Marker({
		  position: nibrasPos,
		  map: map,
		  title:titleVal
	});
     },
    cherrySliderInit: function(elem) {
        var sliderHelper = {
            myParseInt: function(val) {
                if (val == undefined)
                    return undefined;
                if (val.indexOf("%") >= 0)
                    return val;
                else
                    return parseInt(val)
            },
            animate: function(item) {
		if (!$(elem).is(":visible")) {
			return;
		}
                //decide anim
                var anim = item.attr("anim");
                var direction = item.attr("anim-direction");
                var left = sliderHelper.myParseInt(item.attr("anim-position-left"));
                var right = sliderHelper.myParseInt(item.attr("anim-position-right"));
                var top = sliderHelper.myParseInt(item.attr("anim-position-top"));
                var animSpeed = sliderHelper.myParseInt(item.attr("anim-speed"));
		var times = sliderHelper.myParseInt(item.attr("anim-times"));
                var action = item.attr("anim-action");
                if (action == "restart") {
                    setTimeout(function() {
                        sliderHelper.animate(item.parent().find(".anim-item:first"));
                    }, animSpeed);
                } else if (action == "break") {
                    if (anim == "fade") {
                        item.prevAll(".anim-item").fadeOut(animSpeed);
                    } else {
                        item.prevAll(".anim-item").effect(anim, {mode: "hide", direction: direction}, animSpeed);
                    }
                    setTimeout(function() {
                        if (item.next().hasClass("anim-item"))
                            sliderHelper.animate(item.next())
                    }, animSpeed);

                } else if (anim == "slide") {
                    if (direction == "right" && left)
                        item.css({left: $(item).parents(".cherry-slider").width()});
                    if (direction == "left" && right)
                        item.css({right: $(item).parents(".cherry-slider").width()});
                    if (direction == "down")
                        item.css({top: $(item).parents(".cherry-slider").height()});
                    item.css({opacity: 0}).show();
                    item.animate({opacity: 1, right: right, left: left, top: top}, parseInt(animSpeed), function() {
                        if (item.next().hasClass("anim-item"))
                            sliderHelper.animate(item.next())
                    });
                } else if (anim == "fade") {
                    
                    item.css({opacity: 0, right: right, left: left, top: top});
                    item.show();
                    item.animate({opacity: 1}, parseInt(animSpeed), function() {
                        if (item.next().hasClass("anim-item"))
                            sliderHelper.animate(item.next())
                    });
                } else if (anim == "drop") {
                    if (right != undefined)
                        left = $(item).parents(".cherry-slider").width() - right - item.width();
                    item.css({opacity: 1, left: left, top: top});
                    //item.hide();
                    item.effect("drop", {mode: "show", distance: 8, direction: direction}, animSpeed, function() {
                        if (item.next().hasClass("anim-item"))
                            sliderHelper.animate(item.next())
                    });
                } else if (anim == "bounce") {
                    if (right != undefined)
                        left = $(item).parents(".cherry-slider").width() - right - item.width();
                    item.css({opacity: 1, left: left, top: top});
                    item.hide();
                    item.effect("bounce", {times: (times == undefined ? 1 : times), distance: 10, mode: "show", direction: direction}, animSpeed, function() {
                        if (item.next().hasClass("anim-item"))
                            sliderHelper.animate(item.next())
                    });
                    
                } else if (anim == "puff") {
                    if (right != undefined)
                        left = $(item).parents(".cherry-slider").width() - right - item.width();
                    item.css({opacity: 1, left: left, top: top});
                    item.hide();
                    item.effect("puff", {mode: "show", direction: direction}, animSpeed, function() {
                        if (item.next().hasClass("anim-item"))
                            sliderHelper.animate(item.next())
                    });
                } else if (anim == "blind") {
                    if (right != undefined)
                        left = $(item).parents(".cherry-slider").width() - right - item.width();
                    item.css({opacity: 1, left: left, top: top});
                    item.hide();
                    item.effect("blind", {mode: "show", direction: direction}, animSpeed, function() {
                        if (item.next().hasClass("anim-item"))
                            sliderHelper.animate(item.next())
                    });
                }
            }
        }
	if ($(elem).hasClass("anim-done")) {
            //restart anim
	    $(".anim-item").effect("fade", {mode: "hide"}, 100, function() {
		sliderHelper.animate($(".anim-item:first", $(elem)));
	    });
	    return;
        }
        else
            $(elem).addClass("anim-done");
        
        $(".anim-item", elem).css({opacity: 0}).show();
        var currentItem = $(".anim-item:first", elem);
        sliderHelper.animate(currentItem);
    },
    Util: {
	mobile: {
         detect:function(){
            var uagent = navigator.userAgent.toLowerCase(); 
            var list = this.mobiles;
            var ismobile = false;
            for(var d=0;d<list.length;d+=1){
                    if(uagent.indexOf(list[d])!=-1){
                            ismobile = list[d];
                    }
            }
            return ismobile;
         },
         mobiles:[
            "midp","240x320","blackberry","netfront","nokia","panasonic",
            "portalmmm","sharp","sie-","sonyericsson","symbian",
            "windows ce","benq","mda","mot-","opera mini",
            "philips","pocket pc","sagem","samsung","sda",
            "sgh-","vodafone","xda","palm","iphone",
            "ipod","android"
         ]
       }
    },
    Forms: {
      bind: function() {
         // Add required class to inputs
         $(':input[required]').addClass('required');
         
         // Block submit if there are invalid classes found
         $('form.ajax-form:not(.html5enhanced)').addClass("html5enhanced").submit(function() {
               var formEl = this;
                 $('input,textarea').each(function() {
                         App.Forms.validate(this);
                 });
                 
                 if(($(this).find(".invalid").length) == 0){
                         // Delete all placeholder text
                         $('input,textarea').each(function() {
                                 if($(this).val() == $(this).attr('placeholder')) $(this).val('');
                         });
                         

						//submit without ajax
						if ($(formEl).hasClass("no-ajax")) {
							return true;
						}
						
                         //if it reached here, submit form via ajax
                         $.ajax({
                           url: $(formEl).attr("action"),
                           type: $(formEl).attr("method"),
                           data: $(formEl).serialize(),
                           success: function(r) {
                              if (r) {
                                 $(".success-message").slideDown().removeClass("hidden");
                              }
                           }
                         })
                         return false;
                 }else{
                         return false;
                 }
         });

      },
      is_email: function(value){
	return (/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/).test(value);
      },
      is_url: function(value){
              return (/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i).test(value);
      },
      is_number: function(value){
              return (typeof(value) === 'number' || typeof(value) === 'string') && value !== '' && !isNaN(value);
      },
      validate: function(element) {
         var $$ = $(element);
         var validator = element.getAttribute('type'); // Using pure javascript because jQuery always returns text in none HTML5 browsers
         var valid = true;
         var apply_class_to = $$;
         
         var required = element.getAttribute('required') == null ? false : true;
         switch(validator){
                 case 'email': valid = App.Forms.is_email($$.val()); break;
                 case 'url': valid = App.Forms.is_url($$.val()); break;
                 case 'number': valid = App.Forms.is_number($$.val()); break;
         }
         
         // Extra required validation
         if(valid && required && $$.val().replace($$.attr('placeholder'), '') == ''){
                 valid = false;
         }
         
         // Set input to valid of invalid
         if(valid || (!required && $$.val() == '')){
                 apply_class_to.removeClass('invalid');
                 apply_class_to.addClass('valid');
                 return true;
         }else{
                 apply_class_to.removeClass('valid');
                 apply_class_to.addClass('invalid');
                 return false;
         }
      }

   }

}


$(App.init);