/* ---------------------------------------------------------------------- */
/*	Preload Images
 /* ---------------------------------------------------------------------- */

//	jQuery.fn.autoload = function() {
//
//		var attachment = jQuery('.add-border');
//			attachment.each(function(index) {
//			var t = attachment.length;
//			if (t > 0) { // if there is image length, we fade in
//				jQuery(this).find('img').delay(400 * index).css({opacity: 1});
//			}
//		})
//	}
//
//	jQuery(window).on("load", function() {
//		jQuery.fn.autoload();
//	})


jQuery(document).ready(function($) {
	
	jQuery.fn.live = function (types, data, fn) {
		jQuery(this.context).on(types,this.selector,data,fn);
		return this;
	};

	/* ---------------------------------------------------- */
	/*	Main Navigation
    /* ---------------------------------------------------- */

	(function() {

		var arrowimages = {
			down: 'downarrowclass',
			right: 'rightarrowclass'
		};
		var $mainNav = $('#navigation').find('ul'),
		optionsList = '<option value="" selected>'+lang_server_navigation+'</option>';

		var $submenu = $mainNav.find("ul").parent();
		$submenu.each(function(i) {
			var $curobj = $(this);
			this.istopheader = $curobj.parents("ul").length == 1 ? true : false;
			$curobj.children("a").append('<span class="' + (this.istopheader ? arrowimages.down : arrowimages.right) + '"></span>');
		});

		$mainNav.on('mouseenter', 'li', function() {
			var $this = $(this),
			$subMenu = $this.children('ul');
			if ($subMenu.length)
				$this.addClass('hover');
			$subMenu.hide().stop(true, true).fadeIn(200);
		}).on('mouseleave', 'li', function() {
			$(this).removeClass('hover').children('ul').stop(true, true).fadeOut(50);
		});

		// Navigation Responsive

		$mainNav.find('li').each(function() {
			var $this = $(this),
			$anchor = $this.children('a'),
			depth = $this.parents('ul').length - 1,
			dash = '';

			if (depth) {
				while (depth > 0) {
					dash += '--';
					depth--;
				}
			}

			optionsList += '<option value="' + $anchor.attr('href') + '">' + dash + ' ' + $anchor.text() + '</option>';

		}).end()
		.after('<select class="nav-responsive">' + optionsList + '</select>');

		$('.nav-responsive').on('change', function() {
			window.location = $(this).val();
		});

	})();

	/* end Main Navigation */

	/* ---------------------------------------------------------------------- */
	/*	Canvas
     /* ---------------------------------------------------------------------- */

	var CANVAS_COLORIZER = function() {

		var self = {
			size: null,
			widthParse: null,
			set: function() {
				var width = $(window).width();
				self.size = parseInt(width / 6, 10);
				self.size = self.size - self.size % 6;
				self.widthParse = parseInt(width);
			},
			init: function() {
				try {
					self.set();
					try {
						var type = parseInt(drawPattern);
					} catch (e) {
					//console.log(e);
					}
					self.get_draw_header(type);
					self.get_draw_footer(type);
				} catch (e) {
				//console.log(e);
				}
			},
			get_draw_header: function(type) {
				try {

					var canvasHeader = "<canvas id='myHeaderCanvas' width='" + self.widthParse + "' height='7'></canvas>", ctx;
					if ($('#header').length) {
						$("#header").append(canvasHeader);
					}
					canvasHeader = jQuery("#myHeaderCanvas")[0];

					if (canvasHeader.getContext) {
						ctx = canvasHeader.getContext('2d');
						switch (type) {
							case 1:
								self.draw_header_pattern_type_1(ctx);
								break;
							case 2:
								self.draw_header_pattern_type_2(ctx);
								break;
							case 3:
								return false;
								break;
						}
					}

				} catch (e) {
				//console.log(e);
				}

			},
			draw_header_pattern_type_1: function(ctx) {

				if (!drawHeaderColor.length) {
					drawHeaderColor = "#373533"
				}
				;

				ctx.fillStyle = drawHeaderColor;
				ctx.moveTo(0, 0);

				var step_y = 7;
				var step_x = 0;

				for (i = 0; i < self.size + 4; i++) {
					ctx.lineTo(step_x, step_y);
					step_x += 7;
					step_y = (step_y == 0 ? 7 : 0);
				}
				ctx.fill();
			},
			draw_header_pattern_type_2: function(ctx) {

				if (!drawHeaderColor.length) {
					drawHeaderColor = "#373533"
				}
				;

				ctx.fillStyle = drawHeaderColor;
				ctx.moveTo(0, 0);

				var controlX = 8;
				var controlY = 12;
				var endX = 16;
				var endY = 0;

				for (i = 0; i < self.size + 4; i++) {
					ctx.quadraticCurveTo(controlX, controlY, endX, endY);
					controlX += 16;
					endX += 16;
				}
				ctx.fill();
			},
			get_draw_footer: function(type) {
				switch (type) {
					case 1:
						var canvasFooter = "<canvas id='myFooterCanvas' width='" + self.widthParse + "' height='7'></canvas>", ctx;
						if ($('#footer').length) {
							$("#footer").append(canvasFooter);
							canvasFooter = jQuery("#myFooterCanvas")[0];
						}
						break;
					case 2:
						var canvasFooter = "<canvas id='myFooterCanvas2' width='" + self.widthParse + "' height='10'></canvas>", ctx;
						if ($('#footer').length) {
							$("#footer").append(canvasFooter);
							canvasFooter = jQuery("#myFooterCanvas2")[0];
						}
						break;
					case 3:
						return false;
						break;
					default:
						var canvasFooter = "<canvas id='myFooterCanvas' width='" + self.widthParse + "' height='7'></canvas>", ctx;
						if ($('#footer').length) {
							$("#footer").append(canvasFooter);
							canvasFooter = jQuery("#myFooterCanvas")[0];
						}

						break;
				}

				if (canvasFooter.getContext) {
					ctx = canvasFooter.getContext('2d');
					switch (type) {
						case 1:
							self.draw_footer_pattern_type_1(ctx);
							break;
						case 2:
							self.draw_footer_pattern_type_2(ctx);
							break;
						case 3:
							return false;
							break;
					}
				}

			},
			draw_footer_pattern_type_1: function(ctx) {

				if (!drawFooterColor.length) {
					drawFooterColor = "#e6e3d8"
				}
				;

				ctx.fillStyle = drawFooterColor;
				ctx.strokeStyle = "#bbb7ae";
				ctx.moveTo(0, 7);
				var step_y = 7;
				var step_x = 0;

				for (i = 0; i < self.size + 3; i++) {
					ctx.lineTo(step_x, step_y);
					step_x += 7;
					step_y = (step_y == 0 ? 7 : 0);
				}
				ctx.stroke();
				ctx.fill();
			},
			draw_footer_pattern_type_2: function(ctx) {

				if (!drawFooterColor.length) {
					drawFooterColor = "#e6e3d8"
				}
				;

				ctx.fillStyle = drawFooterColor;
				ctx.strokeStyle = "#bbb7ae";
				ctx.moveTo(0, 10);

				var controlX = 8;
				var controlY = 0;
				var endX = 16;
				var endY = 10;

				for (i = 0; i < self.size + 4; i++) {
					ctx.quadraticCurveTo(controlX, controlY, endX, endY);
					controlX += 16;
					endX += 16;
				}
				ctx.stroke();
				ctx.fill();
			}
		}

		return self;

	}

	var canvas = new CANVAS_COLORIZER();

	try {
		var type = parseInt(drawPattern);
		canvas.init();
	} catch (e) {
	//console.log(e);
	}



	/* end Canvas */

	/* ---------------------------------------------------------------------- */
	/*	Media
     /* ---------------------------------------------------------------------- */

	var $player = jQuery('audio');
	if ($player.length) {
		$player.mediaelementplayer({
			audioWidth: '100%',
			audioHeight: '34px',
			videoWidth: '100%',
			videoHeight: '100%'
		});
	}

	/* end Media */


	/* ---------------------------------------------------------------------- */
	/*	FitVids
	/* ---------------------------------------------------------------------- */

	(function() {

		// jQuery Actual Plugin (http://dreamerslab.com/)
		;
		(function(a){
			a.fn.extend({
				actual:function(b,k){
					var c,d,h,g,f,j,e,i;
					if(!this[b]){
						throw'$.actual => The jQuery method "'+b+'" you called does not exist';
					}
					h=a.extend({
						absolute:false,
						clone:false,
						includeMargin:undefined
					},k);
					d=this;
					if(h.clone===true){
						e=function(){
							d=d.filter(":first").clone().css({
								position:"absolute",
								top:-1000
							}).appendTo("body");
						};

						i=function(){
							d.remove();
						};

					}else{
						e=function(){
							c=d.parents().andSelf().filter(":hidden");
							g=h.absolute===true?{
								position:"absolute",
								visibility:"hidden",
								display:"block"
							}:{
								visibility:"hidden",
								display:"block"
							};

							f=[];
							c.each(function(){
								var m={},l;
								for(l in g){
									m[l]=this.style[l];
									this.style[l]=g[l];
								}
								f.push(m);
							});
						};

						i=function(){
							c.each(function(m){
								var n=f[m],l;
								for(l in g){
									this.style[l]=n[l];
								}
							});
						};

					}
					e();
					j=/(outer)/g.test(b)?d[b](h.includeMargin):d[b]();
					i();
					return j;
				}
			});
		})(jQuery);

		function adjustVideos() {

			var $videos = $('.fluid-width-video-wrapper');

			$videos.each(function() {

				var $this        = $(this),
				playerWidth  = $this.parent().actual('width'),
				playerHeight = playerWidth / $this.data('aspectRatio');

				$this.css({
					'height' : playerHeight,
					'width'  : playerWidth
				})

			});

		}

		$('.container').each(function(){

			var selectors  = [
			"iframe[src^='http://player.vimeo.com']",
			"iframe[src^='http://www.youtube.com']",
			"iframe[src^='http://blip.tv']",
			"iframe[src^='http://www.kickstarter.com']",
			"object",
			"embed"
			],
			$allVideos = $(this).find(selectors.join(','));

			$allVideos.each(function(){

				var $this = $(this);

				if ( $this.hasClass('vjs-tech') || this.tagName.toLowerCase() == 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length )
					return;

				var videoHeight = $this.attr('height') || $this.actual('width'),
				videoWidth  = $this.attr('width') || $this.actual('width');

				$this.css({
					'height' : '100%',
					'width'  : '100%'
				}).removeAttr('height').removeAttr('width')
				.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css({
					'height' : videoHeight,
					'width'  : videoWidth
				}).data( 'aspectRatio', videoWidth / videoHeight );

				adjustVideos();

			});

		});

		$(window).on('resize', function() {

			var timer = window.setTimeout( function() {
				window.clearTimeout( timer );
				adjustVideos();
			}, 30 );

		});

	})();

	/* end FitVids */

	/* ---------------------------------------------------------------------- */
	/*	Placeholder
     /* ---------------------------------------------------------------------- */

	$.fn.placeholder = function() {

		if (typeof document.createElement("input").placeholder == 'undefined') {
			$('[placeholder]').focus(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
					input.removeClass('placeholder');
				}
			}).blur(function() {
				var input = $(this);
				if (input.val() == '' || input.val() == input.attr('placeholder')) {
					input.addClass('placeholder');
					input.val(input.attr('placeholder'));
				}
			}).blur().parents('form').submit(function() {
				$(this).find('[placeholder]').each(function() {
					var input = $(this);
					if (input.val() == input.attr('placeholder')) {
						input.val('');
					}
				})
			});
		}
	}

	$.fn.placeholder();

	/* end Placeholder */

	/* ---------------------------------------------------------------------- */
	/*	Sudo Slider
     /* ---------------------------------------------------------------------- */

	(function() {

		var $sudo = jQuery('.sudo-slider');

		if ($sudo.length) {

			$sudo.sudoSlider({
				continuous: false,
				responsive: true,
				prevhtml: '<a href="#" class="prev"> '+lang_prev+' </a>',
				nexthtml: '<a href="#" class="next"> '+lang_next+' </a>',
				controlsattr: 'class="image-gallery-slider-nav"',
				afterAniFunc: function() {
					var self = $(this), size;
					size = self.siblings("li").size();
					if (size < 1) {
						self.closest(".image-gallery-slider").find(".image-gallery-slider-nav").fadeOut();
					}
				}
			});

		}

	})();

	/* end Sudo Slider */


	/* ---------------------------------------------------------------------- */
	/*	Image Post Slider
     /* ---------------------------------------------------------------------- */

	(function() {

		// Fixed scrollHorz effect
		$.fn.cycle.transitions.fixedScrollHorz = function($cont, $slides, opts) {

			$('.image-gallery-slider-nav a').on('click', function(e) {
				$cont.data('dir', '')
				if (e.target.className.indexOf('prev') > -1)
					$cont.data('dir', 'prev');
			});

			$cont.css('overflow', 'hidden');
			opts.before.push($.fn.cycle.commonReset);
			var w = $cont.width();
			opts.cssFirst.left = 0;
			opts.cssBefore.left = w;
			opts.cssBefore.top = 0;
			opts.animIn.left = 0;
			opts.animOut.left = 0 - w;

			if ($cont.data('dir') === 'prev') {
				opts.cssBefore.left = -w;
				opts.animOut.left = w;
			}

		};

		var $slider = $('.image-post-slider ul');

		if ($slider.length) {

			// Run slider when all images are fully loaded
			$(window).load(function() {

				$slider.each(function() {
					var $this = $(this);

					$this.css('height', $this.find('li:first img').height())
					.after('<div class="image-gallery-slider-nav"> <a class="prev">'+lang_prev+'</a> <a class="next">'+lang_next+'</a> </div>')
					.cycle({
						before: function(curr, next, opts) {
							var $this = $(this);
							$this.parent().stop().animate({
								height: $this.height()
							}, opts.speed);
						},
						containerResize: false,
						easing: 'easeInOutExpo',
						fx: 'fixedScrollHorz',
						fit: true,
						next: '.next',
						pause: true,
						prev: '.prev',
						slideExpr: 'li',
						slideResize: true,
						speed: 600,
						timeout: 5000,
						width: '100%'
					});
				});

				// Pause on nav hover
				$('.image-gallery-slider-nav a').on('mouseenter', function() {
					$(this).parent().prev().cycle('pause');
				}).on('mouseleave', function() {
					$(this).parent().prev().cycle('resume');
				})

			});

			// Resize
			$(window).on('resize', function() {
				$slider.css('height', $slider.find('li:visible img').height());
			});

			// Include swipe touch
			if (Modernizr.touch) {

				function swipe(e, dir) {

					var $slider = $(e.currentTarget);

					$slider.data('dir', '')

					if (dir === 'left') {
						$slider.cycle('next');
					}

					if (dir === 'right') {
						$slider.data('dir', 'prev')
						$slider.cycle('prev');
					}

				}

				$slider.swipe({
					swipeLeft: swipe,
					swipeRight: swipe,
					allowPageScroll: 'auto'
				});

			}
		}

	})();

	/* ---------------------------------------------------------------------- */
	/*	Tabs
     /* ---------------------------------------------------------------------- */

	(function() {

		jQuery('ul.tabs-nav').delegate('li:not(.active)', 'click', function(e) {
			jQuery(this).addClass('active').siblings().removeClass('active')
			.parent().next('.tabs-container').find(".tab-content").hide().eq(jQuery(this).index()).fadeIn(150);
			e.preventDefault();
		});

		jQuery('ul.tabs-nav').delegate('li.active', 'click', function(e) {
			e.preventDefault();
		});

		jQuery('ul.tabs-nav').find("li:first").addClass("active");
		jQuery('.tabs-container').find("> div:first").show();

	})();

	/* ---------------------------------------------------------------------- */
	/*	Toggle
    /* ---------------------------------------------------------------------- */

	(function() {

		if ($('.toggle-container').length) {
			$(".toggle-container").hide(); //Hide (Collapse) the toggle containers on load
			$(".box-toggle").on("click",".trigger", function(e) {
				var self = $(e.target);
				self.toggleClass("active").next().stop(true,true).slideToggle("slow");
				//                $.fn.autoload();
				e.preventDefault();
			});
		}

	})();

	/* end Toggle */

	/* ---------------------------------------------------------------------- */
	/*	WorkPanel
     /* ---------------------------------------------------------------------- */

	(function() {

		jQuery('.js_gallery_album_cover').live('click', function() {
			var panel = jQuery('#workPanel');
			var data = {
				action: "render_gall",
				template_sidebar_position: template_sidebar_position,
				id: jQuery(this).attr('album_id')
			};

			jQuery.post(ajaxurl, data, function(response) {
				panel.show();
				jQuery('.responsed_content').html("").addClass('loader').fadeOut(300, function() {
					$(this).fadeIn(800).html(response).queue(function() {
						$(this).removeClass('loader').dequeue();
					});
				//                    $.fn.autoload();
				});

				var panelHeight = panel.attr('data-height');

				panel.stop().animate({
					opacity: 1,
					minHeight: panelHeight
				}, 500, function() {

					var $slider = jQuery('.sudo-slider');

					if ($slider.length) {

						$slider.sudoSlider({
							continuous: false,
							responsive: true,
							fade: true,
							prevhtml: '<a href="#" class="prev"> previous </a>',
							nexthtml: '<a href="#" class="next"> next </a>',
							controlsattr: 'class="image-gallery-slider-nav"',
							afterAniFunc: function() {
								var self = $(this), size;
								size = self.siblings("li").size();
								if (size < 1) {
									self.closest(".image-gallery-slider").find(".image-gallery-slider-nav").fadeOut();
								}
							}
						});

					}
					jQuery('body, html').animate({
						scrollTop: panel.offset().top - 50
					}, 1000);
				});
			});
			return false;


		});

		jQuery(".close").live("click", function() {
			jQuery("#workPanel").animate({
				opacity: 0,
				minHeight: 0
			}, 700, function() {
				jQuery("#workPanel").hide(700);
			});
			return false;
		});

	})();


	/* ---------------------------------------------------------------------- */
	/*	Recent Projects
     /* ---------------------------------------------------------------------- */

	(function() {

		var $slider = jQuery('ul.recent-projects');

		if (jQuery($slider.length)) {

			$slider.each(function() {

				var $this = $(this);

				$this.css({
					height: $this.children('li:first').height()
				}).after('<div class="recent-projects-nav clearfix"><a class="prevBtn">'+lang_prev+'</a><a class="nextBtn">'+lang_next+'</a></div>')
				.cycle({
					before: function(curr, next, opts) {
						var $this = $(this);
						// set the container's height to that of the current slide
						$this.parent().stop().animate({
							height: $this.height()
						}, opts.speed);
					},
					after: function() {
					//                        $.fn.autoload();
					},
					fx: 'fade',
					timeout: 0,
					next: '.nextBtn',
					prev: '.prevBtn',
					easing: 'easeOutQuint',
					width: '100%'
				});

			})

		}

	})();

	/* Recent Projects --> End */

	/* ---------------------------------------------------------------------- */
	/*	Back to Top
     /* ---------------------------------------------------------------------- */

	var extend = {
		button: '#back-top',
		backToTop: '.divider-top a',
		text: 'Back to Top',
		min: 200,
		fadeIn: 400,
		fadeOut: 400,
		speed: 800,
		easing: 'easeOutQuint'
	}

	$('body').append('<a href="#" id="' + extend.button.substring(1) + '" title="' + extend.text + '">' + extend.text + '</a>');

	$(window).scroll(function() {
		var pos = $(window).scrollTop();

		if (pos > extend.min) {
			$(extend.button).fadeIn(extend.fadeIn);
		}
		else {
			$(extend.button).fadeOut(extend.fadeOut);
		}

	});

	$(extend.button).add(extend.backToTop).click(function(e) {
		$('html, body').animate({
			scrollTop: 0
		}, extend.speed, extend.easing);
		e.preventDefault();
	});

	/* end Back to Top */

	/* ---------------------------------------------------------------------- */
	/*	Fancybox
     /* ---------------------------------------------------------------------- */

	(function() {

		if ($('.single-image').length || $('.video').length || $('.picture-icon')) {

			$('.single-image.picture-icon, .single-image.video').fancybox({
				'titlePosition': 'over',
				'transitionIn': 'fade',
				'transitionOut': 'fade'
			});

			$('.single-image').each(function() {
				$(this).append('<span class="curtain">&nbsp;</span>');
			});

		}

		if ($('a.video').length) {

			$('a.video').on('click', function() {
				$.fancybox({
					'type': 'iframe',
					'href': this.href.replace(new RegExp('watch\\?v=', 'i'), 'embed/') + '&autoplay=1',
					'overlayShow': true,
					'centerOnScroll': true,
					'speedIn': 100,
					'speedOut': 50,
					'width': 640,
					'height': 480
				});
				return false;
			});
		}

	})();

	/* end fancybox --> End */

	/* ---------------------------------------------------------------------- */
	/*	Portfolio
     /* ---------------------------------------------------------------------- */

	(function() {

		var $cont = $('#portfolio-items, #gallery');

		if ($cont.length) {

			var $itemsFilter = $('#portfolio-filter'),
			mouseOver;

			// Copy categories to item classes
			$('article', $cont).each(function(i) {
				var $this = $(this);
				$this.addClass($this.attr('data-categories'));
			});

			// Run Isotope when all images are fully loaded
			$(window).on('load', function() {

				$cont.isotope({
					itemSelector: 'article',
					layoutMode: 'fitRows'
				});

			});

			// Filter projects
			$itemsFilter.on('click', 'a', function(e) {
				var $this = $(this),
				currentOption = $this.attr('data-categories');

				$itemsFilter.find('a').removeClass('active');
				$this.addClass('active');

				if (currentOption) {
					if (currentOption !== '*')
						currentOption = currentOption.replace(currentOption, '.' + currentOption)

					$cont.isotope({
						filter: currentOption
					});
				}

				e.preventDefault();
			});

			$itemsFilter.find('a').first().addClass('active');
		}

	})();

	/* end Portfolio  */

	/* ---------------------------------------------------------------------- */
	/*	Comments
     /* ---------------------------------------------------------------------- */

	if (parseInt(jQuery("[name=is_user_logged_in]").val(), 10)) {

		var comments = jQuery(".comment-reply-link");

		jQuery.each(comments, function(index, value) {
			jQuery(value).removeAttr("onclick");
			jQuery(value).live('click', function() {

				if (jQuery(value).parents("article").find(".js-add-comment").length > 0) {
					return false;
				}

				var comment_id = jQuery(value).closest("li").attr("comment-id");
				var html = jQuery("#addcomments_template").html();
				html = html.replace(/__INDEX__/gi, comment_id);
				jQuery("#commentform .js-add-comment").hide(300);
				jQuery(value).parent().after(html);
				return false;
			});

		});

		jQuery(".reset").live('click', function() {
			var add = jQuery(this).closest(".js-add-comment");
			add.hide(300, function() {
				add.remove();
			});
		});

		jQuery(".reply").live('click', function() {
			var add = jQuery(this).closest('.js-add-comment');
			var comment_parent = add.attr("id-reply");
			var comment_content = add.find("textarea").val();

			if (!comment_content.length) {
				return false;
			}

			var data = {
				action: "add_comment",
				comment_parent: comment_parent,
				comment_post_ID: jQuery("[name=current_post_id]").val(),
				comment_content: comment_content
			};
			//send data to server
			jQuery.post(ajaxurl, data, function(response) {
				window.location.href = jQuery("[name=current_post_url]").val() + "?new_comment=" + response;
			});

		});
	}

	/* end Comments  */

	/* ---------------------------------------------------------------------- */
	/*	Form
     /* ---------------------------------------------------------------------- */

	var $form = jQuery('.contact-form');

	$form.submit(function() {

		$response = jQuery(this).next(jQuery(".contact_form_responce"));
		$response.find("ul").html("");
		$response.find("ul").removeClass();

		var data = {
			action: "contact_form_request",
			values: jQuery(this).serialize()
		};

		var form_self=this;
		//send data to server
		jQuery.post(ajaxurl, data, function(response) {

			response = jQuery.parseJSON(response);
			jQuery(form_self).find(".wrong-data").removeClass("wrong-data");

			if (response.is_errors) {

				jQuery($response).find("ul").addClass("error type-2");
				jQuery.each(response.info, function(input_name, input_label) {
					jQuery(form_self).find("[name=" + input_name + "]").addClass("wrong-data");
					jQuery($response).find("ul").append('<li>' + lang_enter_correctly + ' "' + input_label + '"!</li>');
				});

				$response.show(450);

			} else {

				jQuery($response).find("ul").addClass("success type-2");

				if (response.info == 'succsess') {
					jQuery($response).find("ul").append('<li>' + lang_sended_succsessfully + '!</li>');
					$response.show(450).delay(1800).hide(400);
				}

				if (response.info == 'server_fail') {
					jQuery($response).find("ul").append('<li>' + lang_server_failed + '!</li>');
				}

				jQuery(form_self).find("[type=text],textarea").val("");

			}

			// Scroll to bottom of the form to show respond message
			var bottomPosition = jQuery(form_self).offset().top + jQuery(form_self).outerHeight() - jQuery(window).height();

			if (jQuery(document).scrollTop() < bottomPosition) {
				jQuery('html, body').animate({
					scrollTop: bottomPosition
				});
			}

			update_capcha(form_self,response.hash);
		});
		return false;
	});


}); // END DOM READY

//*******************************************************

function update_capcha(form_object,hash) {
	jQuery(form_object).find("[name=verify]").val("");
	jQuery(form_object).find("[name=verify_code]").val(hash);
	jQuery(form_object).find(".contact_form_capcha").attr('src',capcha_image_url+'?hash='+hash);
}

function getElementsByClass(searchClass, node, tag) {
	var classElements = new Array();
	if (node == null)
		node = document;
	if (tag == null)
		tag = '*';
	var els = node.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp("(^|\\s)" + searchClass + "(\\s|$)");
	for (i = 0, j = 0; i < elsLen; i++) {
		if (pattern.test(els[i].className)) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

function gmt_init_map(Lat, Lng, map_canvas_id, zoom, maptype, info, show_marker, show_popup, scrollwheel, custom_controls) {
	var latLng = new google.maps.LatLng(Lat, Lng);
	var homeLatLng = new google.maps.LatLng(Lat, Lng);

	switch (maptype) {
		case "SATELLITE":
			maptype = google.maps.MapTypeId.SATELLITE;
			break;

		case "HYBRID":
			maptype = google.maps.MapTypeId.HYBRID;
			break;

		case "TERRAIN":
			maptype = google.maps.MapTypeId.TERRAIN;
			break;

		default:
			maptype = google.maps.MapTypeId.ROADMAP;
			break;

	}

	scrollwheel = parseInt(scrollwheel, 10);
	var map;
	if (custom_controls.length > 0) {

		var options = merge_objects_options({
			zoom: zoom,
			center: latLng,
			mapTypeId: maptype,
			scrollwheel: scrollwheel,
			disableDefaultUI: true
		}, custom_controls);

		map = new google.maps.Map(document.getElementById(map_canvas_id), options);
	} else {
		map = new google.maps.Map(document.getElementById(map_canvas_id), {
			zoom: zoom,
			center: latLng,
			mapTypeId: maptype,
			scrollwheel: scrollwheel
		});
	}


	show_marker = parseInt(show_marker, 10);
	if (show_marker) {
		var marker = new MarkerWithLabel({
			position: homeLatLng,
			draggable: false,
			map: map
		});


		if (show_popup && info != "") {
			google.maps.event.addListener(marker, "click", function(e) {
				iw.open(map, marker);
			});
			var iw = new google.maps.InfoWindow({
				content: '<span>' + info + '</span>'
			});
		}
	}

}

function merge_objects_options(obj1, obj2) {
	var obj3 = {};
	for (var attrname in obj1) {
		obj3[attrname] = obj1[attrname];
	}
	for (var attrname in obj2) {
		obj3[attrname] = obj2[attrname];
	}
	return obj3;
}

/* end Comments  */