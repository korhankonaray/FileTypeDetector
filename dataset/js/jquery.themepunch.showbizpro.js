/**************************************************************************
 * jQuery.themepunch.ShoBiz Pro.js - jQuery Plugin for ShowBiz Pro Teaser Rotator
 * @version: 1.2.9 (12.07.2012)
 * @requires jQuery v1.7 or later
 * @author ThemePunch
**************************************************************************/



(function($,undefined){


	////////////////////////////////////////
	// THE REVOLUTION PLUGIN STARTS HERE //
	///////////////////////////////////////

	jQuery.fn.extend({

		///////////////////////////
		// MAIN PLUGIN  FUNCTION //
		///////////////////////////
		showbizpro: function(options) {

				jQuery.fn.showbizpro.defaults = {
					entrySizeOffset:0,
					containerOffsetRight:0,
					heightOffsetBottom:0,
					carousel:"off",
					visibleElementsArray:[4,3,2,1],
					mediaMaxHeight:[0,0,0,0],
					ytMarkup:"<iframe src='http://www.youtube.com/embed/%%videoid%%?hd=1&amp;wmode=opaque&amp;autohide=1&amp;showinfo=0&amp;autoplay=1'></iframe>",
					vimeoMarkup:"<iframe src='http://player.vimeo.com/video/%%videoid%%?title=0&amp;byline=0&amp;portrait=0;api=1&amp;autoplay=1'></iframe>",
					closeOtherOverlays:"off",
					allEntryAtOnce:"off",
					dragAndScroll:"off",
					autoPlay:"off",
					delay:3000,
					speed:300,
					rewindFromEnd:"off"

				};

				options = jQuery.extend({}, jQuery.fn.showbizpro.defaults, options);


				return this.each(function() {

					var container=jQuery(this);

					// SAVE THE DEFAULT OPTIONS
					container.data('eoffset',options.entrySizeOffset);
					container.data('croffset',options.containerOffsetRight);
					container.data('hboffset',options.heightOffsetBottom);
					if (options.carousel=="on")
						container.data('carousel',1)
					else
						container.data('carousel',0);

					container.data('ytmarkup',options.ytMarkup);
					container.data('vimeomarkup',options.vimeoMarkup);
					container.data('vea',options.visibleElementsArray);
					container.data('coo',options.closeOtherOverlays);
					container.data('allentry',options.allEntryAtOnce);
					container.data('mediaMaxHeight',options.mediaMaxHeight);
					container.data('das',options.dragAndScroll);
					container.data('rewindfromend',options.rewindFromEnd);

					options.speed = parseInt(options.speed,0);
					options.delay = parseInt(options.delay,0);

					container.data('speedy',options.speed);
					container.data('ie',!jQuery.support.opacity);
					container.data('ie9',(document.documentMode == 9));

					// CHECK THE jQUERY VERSION
					var version = jQuery.fn.jquery.split('.'),
						versionTop = parseFloat(version[0]),
						versionMinor = parseFloat(version[1]),
						versionIncrement = parseFloat(version[2] || '0');

					if (versionTop>1) container.data('ie',false);


					// CLONE IF CAROUSEL IS SELECTED, AND ITEM AMOUNT IS NOT ENOUGH
					if (options.carousel=="on") {
						if (container.find('ul').first().find('>li').length<17) {
							container.find('ul').first().find('li').each(function(i) {
								jQuery(this).clone(true).appendTo(container.find('ul').first())
							});
						}
					}

					// Delegate .transition() calls to .animate()
					// if the browser can't do CSS transitions.
					if (!jQuery.support.transition)
						jQuery.fn.transition = jQuery.fn.animate;


					var tr = container.find('.showbiz');
					tr.attr('id',"sbiz"+Math.round(Math.random()*10000));

					/*tr.css({'height':'200px'});
					tr.find('ul').css({'height':'200px'});
					tr.find('.overflowholder').css({'height':'200px'});
					container.css({'height':'200px'});*/

					var driftTimer;


					// IF DRAG AND SCROLL FUNCTION IS ACTIVATED....
					if (options.dragAndScroll=="on") {
						// CALL THE SWIPE FUNCTION TO THE ITEM
						tr.find('.overflowholder').overscroll({
								driftTimeout:0,
								direction:'horizontal',
								wheelDirection:'horizontal',
								captureWheel:false
						}).on('overscroll:dragstart',function() {

								container.find('.overflowholder').stop(true);
						}).on('overscroll:driftend',function() {
								container.find('.overflowholder').data('drifting',0);
								scrollOver(container,0)
						}).on('overscroll:driftstart',function() {
								clearTimeout(driftTimer);
								container.find('.overflowholder').data('drifting',1);
						}).on('overscroll:dragend',function() {
								 if (!is_mobile()) {
									  clearTimeout(driftTimer);
									  driftTimer=setTimeout(function() {
											if (container.find('.overflowholder').data('drifting') !=1)
												scrollOver(container,0);
										},50);
								}

						});
					}

					initTeaserRotator(container,tr);

					// TURN ON / OFF AUTO PLAY
					if (options.autoPlay!="on")  {
						jQuery(container.find('.showbiz').data('play')).remove();
					} else {

						// STart THE AUTOPLAY
						goInterval();

						// COLLECT THE PLAYBUTTON
						var pb = jQuery(container.find('.showbiz').data('play'));

						// HIDE THE PLAY BUTTON NOW
						pb.find('.sb-playbutton').addClass("sb-hidden");

						container.hover(function() {
								container.addClass("hovered")
							},
							function() {
								container.removeClass("hovered")
							});
						pb.click(function() {
							if (pb.hasClass("paused")) {
								goInterval();
								pb.removeClass("paused");
								pb.find('.sb-pausebutton').removeClass("sb-hidden");
								pb.find('.sb-playbutton').addClass("sb-hidden");
							} else {
								stopInterval();
								pb.addClass("paused");
								pb.find('.sb-pausebutton').addClass("sb-hidden");
								pb.find('.sb-playbutton').removeClass("sb-hidden");
							}
						});

					}

					function goInterval() {
						container.data('timer',setInterval(function() {
							var rb = jQuery(container.find('.showbiz').data('right'));

							if (!container.hasClass("hovered")) rbclick(container,rb);
						},options.delay));
					}

					function stopInterval() {
					    clearInterval(container.data('timer'));
					}

					// INIT THE REVEAL FUNCTIONS
					initRevealContainer(container,tr);

					// FIT VIDEO SIZES IN DIFFERENT COTAINERS
					try {
						container.find('.mediaholder_innerwrap').each(function() {
							jQuery(this).fitVids();
						});
					} catch(e) {}

					// SOME HOVER EFFECTS
					initHoverAnimations(container);

					/****************************************************
						-	APPLE IPAD AND IPHONE WORKAROUNDS HERE	-
					******************************************************/

					if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
					    jQuery(".reveal_opener, .sb-navigation-left, .sb-navigation-right").click(function(){
					        //we just need to attach a click event listener to provoke iPhone/iPod/iPad's hover event
					        //strange
					    });
					}
				})

			},

		///////////////////////
		// METHODE RESUME    //
		//////////////////////
		showbizredraw: function(option) {
				return this.each(function() {
					// CATCH THE CONTAINER
					var container=jQuery(this);
					var tr = container.find('.showbiz');
					rebuildTeasers(200,container,tr);
				})
		}


	})


		//////////////////
		// IS MOBILE ?? //
		//////////////////
		function is_mobile() {
		    var agents = ['android', 'webos', 'iphone', 'ipad', 'blackberry','Android', 'webos', ,'iPod', 'iPhone', 'iPad', 'Blackberry', 'BlackBerry'];
			var ismobile=false;
		    for(i in agents) {

			    if (navigator.userAgent.split(agents[i]).length>1)
		            ismobile = true;

		    }
		    return ismobile;
		}

		////////////////////////////
		// INIT HOVER ANINATIONS //
		////////////////////////////
		function initHoverAnimations(container) {

			container.find('.show_on_hover, .hovercover').each(function() {

				var li=jQuery(this).closest('li');

				if (container.data('ie9') || container.data('ie'))
							jQuery(this).animate({'opacity':0},{duration:200,queue:false});
						 else
						 	jQuery(this).transit({'opacity':0},{duration:200,queue:false});

				li.hover(function() {

					jQuery(this).find('.show_on_hover, .hovercover').each(function() {
						var maxop=1;
						if (jQuery(this).data('maxopacity')!=undefined) maxop=jQuery(this).data('maxopacity');

						if (container.data('ie9') || container.data('ie'))
							jQuery(this).animate({'opacity':maxop},{duration:200,queue:false});
						 else
						 	jQuery(this).transit({'opacity':maxop},{duration:200,queue:false});
					})
				},
				function() {
					jQuery(this).find('.show_on_hover, .hovercover').each(function() {
						if (container.data('ie9') || container.data('ie'))
							jQuery(this).animate({'opacity':0},{duration:200,queue:false});
						 else
						 	jQuery(this).transit({'opacity':0},{duration:200,queue:false});
					})

				});
			})
		}



		////////////////////////////
		// INIT REVEAL ITEMS HERE //
		////////////////////////////
		function initRevealContainer(container,tr) {

		    container.find('.excerpt').each(function() {
			    var ex=jQuery(this);
			    ex.closest('li').hover(function() {

				    ex.slideDown(300);
			    },
			    function() {
			    	ex.stop(true);
				    ex.slideUp(300);
			    })
		    })
			container.find('.reveal_opener').each(function() {
				var ro=jQuery(this);
				ro.click(function() {

					// IDENTIFICATE WHERE THE REVEAL CONTAINER IS
					if (ro.parent().hasClass('reveal_container'))
						var rop = ro.parent();
					else
						var rop = ro.parent().find('.reveal_container');

					// CHECK IF OVERLAY OPEN OR CLOSED
					if (rop.hasClass("revactive")) {

						// IF OPENED THEN LET IT CLOSE
						//setTimeout(function() {
							rop.removeClass("revactive");
							ro.removeClass("revactive");
						//},310);



						rop.closest('li').removeClass("revactive");
						if (container.data('ie9') || container.data('ie')) {
							rop.find('.reveal_wrapper').css({'visibility':'visible'}).animate({height:'0px', 'opacity':0},{duration:500});
						} else {
							rop.find('.reveal_wrapper').css({'visibility':'visible'}).transit({height:'0px', 'opacity':0},{duration:500});
						}


						// REMOVE THE VIDEO CONTAINER CONTENTS
						rop.find('.sb-vimeo-markup, .sb-yt-markup').html("");

						if (rop.hasClass('tofullwidth')) {
							rebuildTeasers(200,container,tr);
							setTimeout(function() {
								rop.appendTo(rop.data('comefrom'));
							},300);
						}
					} else {

						// IF IT IS CLOSED, THEN WE NEED TO OPEN IT
						if (rop.hasClass('tofullwidth')) {
							rop.data('comefrom',rop.parent());
							rop.data('indexli',rop.closest('li').index());
							rop.appendTo(rop.closest('.showbiz'));
							ro.addClass("revactive");
													}
						setTimeout(function() {
							// CLOSE ALL OTHER OPENED OVERLAYS
							if (container.data('coo') == "on")
								rop.closest('ul').find('.reveal_opener').each(function(i) {
									if (jQuery(this).hasClass("revactive")) jQuery(this).click();
								})

							rop.addClass("revactive");
							ro.addClass("revactive");
							rop.closest('li').addClass("revactive");
							if (container.data('ie9') || container.data('ie')) {
								rop.find('.reveal_wrapper').css({'visibility':'visible'}).animate({height:'100%', 'opacity':1},{duration:300});
							} else {
								rop.find('.reveal_wrapper').css({'visibility':'visible'}).transit({height:'100%', 'opacity':1},{duration:300});
							}


							// AUTO EMBED VIMEO AND YOUTUBE VIDEOS ON DEMAND
							rop.find('.sb-vimeo-markup, .sb-yt-markup').each(function(i) {
								var video = jQuery(this);

								if (video.hasClass("sb-vimeo-markup"))
									var basic = container.data('vimeomarkup');
								else
									var basic = container.data('ytmarkup');


								var vbe=basic.split('%%videoid%%')[0];
								var vaf=basic.split('%%videoid%%')[1];

								var basic= vbe+video.data('videoid')+vaf;


								video.append(basic);

								try{ video.fitVids(); } catch(e) { }
							});


							setTimeout(function() {setRevContHeight(container,tr);},500);
						},100);
					}
				});
			});
		}


		//////////////////////////////////////////////////
		// CALCULATE THE HEIGHT OF THE REVEAL CONTAINER //
		//////////////////////////////////////////////////
		function setRevContHeight(container,tr) {
			var revc=container.find('.tofullwidth.revactive .heightadjuster');

			var ul = tr.find('ul').first();
			var dif = parseInt(revc.parent().css('paddingTop'),0) + parseInt(revc.parent().css('paddingBottom'),0);

			var hbo=0;
			if (container.data('hboffset')!=undefined) hbo=container.data('hboffset');

			var nh = hbo + dif +revc.outerHeight(true);

			if (container.data('ie9') || container.data('ie')) {
				ul.animate({height:nh+"px"},{duration:300,queue:false});
				ul.parent().animate({height:nh+"px"},{duration:300,queue:false});

			} else {
				ul.transit({height:nh+"px",duration:300,queue:false});
				ul.parent().transit({height:nh+"px",duration:300,queue:false});
			}

		}



		////////////////////////
		// LEFT BUTTON CLICK //
		///////////////////////
		function lbclick(container, lb) {

				var car= container.data('carousel');
				var speedy = container.data('speedy');
				// IF FULLWIDTH REVACTIVE IS ALREADY ON
				if (container.find('.tofullwidth.revactive .heightadjuster').length>0) {
					var activerev_index=container.find('.tofullwidth.revactive').data('indexli');
					var newindex=activerev_index;
					if (newindex<=0) newindex=container.find('ul:first-child li').length;
					container.find('.tofullwidth.revactive').addClass("sb-removemesoon");
					setTimeout(function() {
						container.find('.tofullwidth.revactive.sb-removemesoon .reveal_opener').click();
						container.find('.sb-removemesoon').each(function() {jQuery(this).removeClass('sb-removemesoon');});
					},350);

					container.find('ul:first-child li:nth-child('+newindex+')').find('.reveal_opener').click();

				}  else {

						if (lb.data('inmove')!=1) {
							var tr=lb.data('teaser');
							var ul = tr.find('ul').first();

							if (container.data('das') == "on") {
								scrollOver(container,-1);
							} else {
									var off=ul.find('>li:first-child').offset().left;

									if (car==1 && off>=0) {
											lb.data('inmove',1);
											tr.data('offset',tr.data('offset')+1);
											rebuildTeasers(0,container,tr);
											ul.find('>li:last-child').prependTo(ul);
											tr.data('offset',tr.data('offset')-1);
											rebuildTeasers(speedy,container,tr);
											setTimeout(function() { lb.data('inmove',0);},350);
									} else {
										lb.data('inmove',1);
										var moveit=1;

										var di=container.width();

										if (container.data('allentry')=="on") {
											if (di>980)  { moveit=container.data('vea')[0]; }
											if (di<981 && di>768)  { moveit=container.data('vea')[1];}
											if (di<769 && di>420)  { moveit=container.data('vea')[2]; }
											if (di<421)  { moveit=container.data('vea')[3]; }
										}

										tr.data('offset',tr.data('offset')-moveit);
										rebuildTeasers(speedy,container,tr);
										setTimeout(function() { lb.data('inmove',0);},350);
									}
							}
						}
					}

		}

		////////////////////////
		// RIGHT BUTTON CLICK //
		///////////////////////
		function rbclick(container,rb) {

				var car= container.data('carousel');
				var speedy = container.data('speedy');

				// IF FULLWIDTH REVACTIVE IS ALREADY ON
				if (container.find('.tofullwidth.revactive .heightadjuster').length>0) {

					var activerev_index=container.find('.tofullwidth.revactive').data('indexli');
					var newindex=activerev_index+2;
					if (newindex>container.find('ul:first-child li').length) newindex=1;
					container.find('.tofullwidth.revactive').addClass("sb-removemesoon");
					setTimeout(function() {
						container.find('.tofullwidth.revactive.sb-removemesoon .reveal_opener').click();
						container.find('.sb-removemesoon').each(function() {jQuery(this).removeClass('sb-removemesoon');});
					},350);

					container.find('ul:first-child li:nth-child('+newindex+')').find('.reveal_opener').click();


				} else {


						if (rb.data('inmove')!=1) {

							var tr=jQuery(rb.data('teaser'));

							var ul = tr.find('ul').first();

							var maxitem=ul.find('>li').length;

							if (container.data('das') == "on") {
								scrollOver(container,1);
							} else {

									var off=ul.find('>li:first-child').offset().left;

									if (car==1 && off<0) {

											rb.data('inmove',1);
											tr.data('offset',tr.data('offset')-1);
											rebuildTeasers(0,container,tr);
											ul.find('>li:first-child').appendTo(ul);
											tr.data('offset',tr.data('offset')+1);
											rebuildTeasers(speedy,container,tr);
											setTimeout(function() { rb.data('inmove',0);},350);
									} else {
										rb.data('inmove',1);
										var moveit=1;

										var di=container.width();
										if (container.data('allentry')=="on") {
											if (di>980)  { moveit=container.data('vea')[0]; }
											if (di<981 && di>768)  { moveit=container.data('vea')[1];}
											if (di<769 && di>420)  { moveit=container.data('vea')[2]; }
											if (di<421)  { moveit=container.data('vea')[3]; }
										}

										tr.data('offset',tr.data('offset')+moveit);
										rebuildTeasers(speedy,container,tr);
										setTimeout(function() { rb.data('inmove',0);},350);
									}
							}
						 }
				 }
		}

		///////////////////////////////////////
		// FUNCTION HOVER ON SQUARE ELEMENTS //
		///////////////////////////////////////
		function initTeaserRotator(container,tr) {

			var car= container.data('carousel');

			/** THE RATING STARS SHOULD BE SHOWN AS STARTS **/
			container.find('.rating-star').each(function() {
				var wcr=jQuery(this);
				if (wcr.data('rates')!=undefined) {
					var rated=wcr.data('rates');
					wcr.append('<div class="sb-rateholder"></div>');
					for (var i=1;i<6;i++) {
						var wwi=100;
					 if (rated==0) {
						 wwi=0;
					 } else {
						if (rated>=i)
						    wwi=100;
						else {
						   wwi = (rated - Math.floor(rated)) * 100;
						   if ((i-rated)>1) wwi=0;

						 }
					}
						wcr.find('.sb-rateholder').append('<div class="sb-rateholder-single"><div style="width:'+wwi+'%;overflow:hidden"><i class="sb-icon-star"></i></div><i class="sb-icon-star-empty"></i></div>');
					}
					wcr.find('.sb-rateholder').append('<div class="sb-clear"></div>');
				}
			});


			var lb = jQuery(tr.data('left'));
			var rb = jQuery(tr.data('right'));

			var di = container.width();

			//container.css({"overflow":"hidden"});
			lb.data('teaser',tr);
			rb.data('teaser',tr);


			tr.data('offset',0);

			rebuildTeasers(0,container,tr);

			container.find('img').each(function() {
				jQuery(this).parent().waitForImages(function() {
					rebuildTeasers(200,container,tr);

				});
			})


			// THE RIGHT CLICK EVENT ON TEASER ROTATOR
			// THE LEFT CLICK EVENT ON TEASER ROTATOR
			rb.click(function() {
				rbclick(container,rb);
				 return false;
			});

			// THE LEFT CLICK EVENT ON TEASER ROTATOR
			lb.click(function() {
				lbclick(container,lb);
				return false;
			});


			if (container.data('das')!="on")
				container.swipe( {data:container,
											swipeRight:function()
													{

														lb.click();
													},
											swipeLeft:function()
													{

														rb.click();
													},
											excludedElements:".reveal_opener, a,  .linkicon, .notalone, .lupeicon, .hovercover, .showbiz-navigation, .sb-navigation-left, .sb-navigation-right",
										allowPageScroll:"auto"} );



			var timeouts;



			// IF WINDOW IS RESIZED, TEASER SHOUL REPOSITION ITSELF
			jQuery(window).resize(function() {
				clearTimeout(timeouts);
				container.addClass("hovered")
				timeouts= setTimeout(function() {
						tr.data('offset',0);
					   rebuildTeasers(0,container,tr);
					   if (container.data('das')=="on") {
							setTimeout(function() { scrollOver(container,0); },300);
						}
						container.removeClass("hovered")
				},150);
			});





			if (car==1) {
				rb.data('inmove',1);
				lb.data('inmove',1);
			}


			for (var j=0;j<3;j++) {
				jQuery(window).data('teaserreset',setTimeout(function() {
					rebuildTeasers(200,container,tr);
				},j*500));

				if (j==2)
					setTimeout(function() {
						rb.data('inmove',0);
						lb.data('inmove',0);
					},(j*500)+200);

			}



		}


		///////////////////////////////////////////////////
		//	FUNCTION TO SCROLL DRAG & SCROLL IN POSITION //
		//////////////////////////////////////////////////
		function scrollOver(container,offset) {

				var tr=container;					// THE CONTAINER VARIABLE
				var di = container.width();			// WIDTH OF THE CONTAINER

				var ul = tr.find('ul').first();				// THE SCROLLED LIST

				var maxitem=ul.find('>li').length;	// THE AMOUNT OF THE LI ITEMS
				var visibleamount =4;				// CURRENT VISIBLE AMOUNTS

				// LETS CHECK HOW MANY ITEMS WE CAN SEE IN THE SAME TIME
				if (di>980)  visibleamount=container.data('vea')[0];
				if (di<981 && di>768) visibleamount=container.data('vea')[1];
				if (di<769 && di>420) visibleamount=container.data('vea')[2];
				if (di<421)  visibleamount=container.data('vea')[3];

				// WHICH IS THE LAST ITEM ON THE LEFT SITE AFTER THE SCROLL
				var lastlefitem = maxitem-visibleamount;

				// THE WIDTH OF THE LI'S
				var wid = ul.find('>li:first-child').outerWidth(true);


				var ofh = tr.find('.overflowholder')		//THE OVERFLOW HOLDER, THE CONTAINER PARENT FOR SCROLL
				var csp = ofh.scrollLeft();					// THE CURRENT SCROLL POSITION OF THIS CONTAINER
				var cip = Math.round(csp/wid);				// AT WHICH ITEM WE STAY ??

				var rb=jQuery(ofh.parent().data('right'));
				var lb=jQuery(ofh.parent().data('left'));


				var scrollto = (cip+offset)*wid;			// WHERE TO SCROLL
				if (scrollto>=(lastlefitem*wid)) {
					scrollto = (lastlefitem*wid);			// IF TO FAR WE NEED TO SCROLL BACK
					try{ rb.addClass('notclickable'); } catch(e) {}
				} else {
					try{ rb.removeClass('notclickable'); } catch(e) {}
				}

				if (scrollto<=0) {
					scrollto = 0;							// IF TO FAR WE NEED TO SCROLL BACK
					try{ lb.addClass('notclickable'); } catch(e) {}
				} else {
					try{ lb.removeClass('notclickable'); } catch(e) {}
				}

				//if (!ofh.hasClass("inmove")) {
//					console.log("inmove"+scrollto);
					//ofh.addClass("inmove");
					ofh.animate({scrollLeft:scrollto+'px'},{duration:300,queue:false, complete:function() {ofh.removeClass("inmove")}});
				/*} else {
					setTimeout(function() {
						console.log("wait first"+scrollto);
						scrollOver(container,offset);
					},300);
				}*/

		};



		/////////////////////////////////////////////////////
		// FUNCTION TO REPOSITION AND REBUILD THE TEASERS //
		////////////////////////////////////////////////////

		function rebuildTeasers(speed,container,tr) {

					var car= container.data('carousel');
					var ul = tr.find('ul');
					var offset=tr.data('offset');
					var di = container.width();
					var padds = parseInt(tr.css('paddingLeft'),0) + parseInt(tr.css('paddingRight'),0);
					di=di-padds;



					var ul = tr.find('ul:first');
					maxitem=ul.find('>li').length;
					var rb=jQuery(tr.data('right'));
					if (container.data('das')!="on") rb.removeClass('notclickable');

					var lb=jQuery(tr.data('left'));
					if (container.data('das')!="on")  lb.removeClass('notclickable');

					var visibleamount=container.data('vea')[0];
					var marray=container.data('mediaMaxHeight');

					if (di>980)  {
						visibleamount=container.data('vea')[0];

						try{
								if (marray[0] !=0)
								container.find('.mediaholder_innerwrap').each(function() {
											jQuery(this).css({'maxHeight':marray[0]+"px"});
								});
							} catch(e) {  }
					}
					if (di<981 && di>768)  {
						visibleamount=container.data('vea')[1];
						try{
								if (marray[1] !=0)
								container.find('.mediaholder_innerwrap').each(function() {
											jQuery(this).css({'maxHeight':marray[1]+"px"});
								});
							} catch(e) {  }
					}
					if (di<769 && di>420)  {
						visibleamount=container.data('vea')[2];
						try{
								if (marray[2] !=0)
								container.find('.mediaholder_innerwrap').each(function() {
											jQuery(this).css({'maxHeight':marray[2]+"px"});
								});
							} catch(e) {  }

					}
					if (di<421)  {
						visibleamount=container.data('vea')[3];
						try{
								if (marray[3] !=0)
								container.find('.mediaholder_innerwrap').each(function() {
											jQuery(this).css({'maxHeight':marray[3]+"px"});
								});
							} catch(e) {  }
					}





					if (car!=1) {
							if (offset>=maxitem-visibleamount+1) {
										offset=maxitem-visibleamount;
										if (container.data('rewindfromend')=="on") offset=0;

										if (container.data('das')!="on" && container.data('rewindfromend')!="on") rb.addClass("notclickable");
							} else {

								if (offset<0) {
									offset=0;
									if (container.data('rewindfromend')=="on") offset=maxitem-visibleamount;
									if (container.data('das')!="on" && container.data('rewindfromend')!="on")  lb.addClass("notclickable");
								}
							}
					}

					var space = ul.find('>li:first-child').outerWidth(true) - ul.find('>li:first-child').width();

					var eo=0;
					if (container.data('eoffset')!=undefined) eo=container.data('eoffset') * (visibleamount-1);

					var cro=0;
					if (container.data('croffset')!=undefined) cro=container.data('croffset');



					step=(di-((visibleamount-1)*space)) / visibleamount;
					step=Math.round(step-eo);



					tr.data('offset',offset);


					ul.find('>li').each(function() { jQuery(this).width(step) });
					step=ul.find('li:first').outerWidth(true);
					tr.data('step',step);

					ul.css({'width':'40000px'});


					var stepxoff=(step*offset);
					if (stepxoff<0) stepxoff =0;

					if (speed==0)
						ul.css({'left':(0 - (stepxoff))+"px"});
					else {
						//if (container.data('ie9') || container.data('ie')) {
							ul.animate({'left':(0 - (stepxoff))+"px"},{duration:speed,queue:false});
						//} else {
						//	ul.transit({'left':(0 - (step*offset))+"px",duration:speed,queue:false});
						//}
					}


					// SET THE HEIGHTS OF THE OUTTER CONTIANER

					var hbo=0;
					if (container.data('hboffset')!=undefined) hbo=container.data('hboffset');
					setTimeout(function() {
							var aktheight=0;
							ul.find('li').each(function(){

									if (jQuery(this).outerHeight(true)>aktheight) aktheight=jQuery(this).outerHeight(true);


							});
							setTimeout(function() {

								if (step>100) {

									var last=ul.find('>li:last-child');
									var secnd= ul.find('>li:nth(2)');						
									var w=(last.index()+1)*last.outerWidth(true)+space;
									ul.css({'width':w+"px"});

								}
							},200);

							if (container.find('.tofullwidth.revactive .heightadjuster').length>0) {

								setRevContHeight(container,tr)
							} else {
								if (container.data('ie9') || container.data('ie')) {
									ul.animate({height:(aktheight+hbo)+"px"},{duration:300, queue:false});
									ul.parent().animate({height:(aktheight+hbo)+"px"},{duration:300,queue:false});
								} else {
									ul.transit({height:(aktheight+hbo)+"px",duration:300, queue:false});
									ul.parent().transit({height:(aktheight+hbo)+"px",duration:300,queue:false});
								}
							}


					 },speed+210)


		}




}(jQuery));


