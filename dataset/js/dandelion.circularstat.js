/*
 * Dandelion Admin v2.0 - Circular Stat Widget JS
 *
 * This file is part of Dandelion Admin, an Admin template build for sale at ThemeForest.
 * For questions, suggestions or support request, please mail me at maimairel@yahoo.com
 *
 * Development Started:
 * March 25, 2012
 * Last Update:
 * December 07, 2012
 *
 * 'Highly configurable' mutable plugin boilerplate
 * Author: @markdalgleish
 * Further changes, comments: @addyosmani
 * Licensed under the MIT license
 *
 */

;(function( $, window, document, undefined ) {
	"use strict";

	// our plugin constructor
	var CircularStat = function( element, options ) {
		if( arguments.length ) {
			this.init( element, options );
		}
    };

    // Some Constants
    CircularStat.CANVAS_NAMES = [ 'back', 'fill', 'front' ];

    // Retrieve Pixel Ratio
    CircularStat.PIXEL_RATIO = (function() {
		var canvas = document.createElement('canvas');
		if( !canvas.getContext ) {
			return 1;
		}

		// http://www.html5rocks.com/en/tutorials/canvas/hidpi/
		var context = canvas.getContext('2d'), 
			devicePixelRatio = window.devicePixelRatio || 1, 
			backingStoreRatio = 
				context.webkitBackingStorePixelRatio ||
				context.mozBackingStorePixelRatio ||
				context.msBackingStorePixelRatio ||
				context.oBackingStorePixelRatio ||
				context.backingStorePixelRatio || 1;

		return devicePixelRatio / backingStoreRatio;
	})();

	// Initialize requestAnimationFrame
	// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
	(function() {
	    var vendors = ['ms', 'moz', 'webkit', 'o'], x;
	    for(x = 0; x < vendors.length && !window.requestAnimationFrame; x++) {
	        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
	        window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
	    }
	 
	    if (!window.requestAnimationFrame) {
	        window.requestAnimationFrame = function(callback) {
	        	return window.setTimeout(function() { callback() }, 16);
	        };
	    }
	 
	    if (!window.cancelAnimationFrame) {
	        window.cancelAnimationFrame = function(id) {
	            clearTimeout(id);
	        };
	    }
	}());

	var AnimationThread = function( options ) {
		if( arguments.length ) {
			this.init( options );
		}
	}

	AnimationThread.prototype = {
		attributes: {
			onLoop: null, 
			afterStop: null, 
			afterStopRequest: null, 
			params: {}, 
			owner: null
		}, 
		init: function( options ) {
			this.options = $.extend( {}, this.attributes, options );

			this.animationHandle = null;
			this.loops = 0;
			this.stopRequested = false;
		}, 
		start: function() {
			var that = this;
			this.animationHandle = window.requestAnimationFrame(function() {
				if( that.options.onLoop.apply( that.options.owner, [ that._getThreadInfo() ] ) ) {
					that._loop();
				}
			});
		}, 
		_getThreadInfo: function() {
			return {
				loops: ++this.loops, 
				params: this.options.params, 
				stopRequested: this.stopped
			};
		}, 
		_kill: function() {
			if( this.animationHandle ) {
				window.cancelAnimationFrame( this.animationHandle );
			}
			if( $.isFunction( this.options.afterStop ) ) {
				this.options.afterStop.call( this.options.owner );
			}
			if( $.isFunction( this.options.afterStopRequest ) ) {
				this.options.afterStopRequest.call( this.options.owner );
			}
		}, 
		_loop: function() {
			var that = this;
			this.animationHandle = window.requestAnimationFrame(function() {
				if( that.options.onLoop.apply( that.options.owner, [ that._getThreadInfo() ] ) ) {
					that._loop();
				} else {
					that._kill();
				}
			});
		}, 
		stop: function( afterStopRequest ) {
			this.stopped = true;
			this.options.afterStopRequest = afterStopRequest;
		}
	};

	// the plugin prototype
	CircularStat.prototype = {
		defaults: {
			initialValue: 0, 
			maxValue: 100, 

			label: '', 
			labelClassName: 'text-label', 

			percent: false, 
			decimals: 0, 
			digitClassName: 'digit-label', 
			format: null,  // function( percent, value, maxValue )

			duration: 1000, 
			fillColor: '#e15656', 

			wrapperClassName: 'circular-stat', 

			outerThickness: 8, 
			fillThickness: 10
		}, 
		init: function( element, options ) {
			// Introduce defaults that can be extended either
			// globally or using an object literal.
			this.element = $( element );
			this.options = $.extend( {}, this.defaults, options, this.element.data() );

			// Global Variables
			this.attributes = {};
			this.labels = {};
			this.canvases = {};
			this.activeAnimationThread = null;

			// Initial Calculations
			this._parseOptions();

			// Create Canvases and proceed if success
			if( ( this.canvases = this._build() ) ) {

				// Draw Backside
				this._drawBackside( this.canvases.back );

				// Draw Frontside
				this._drawFrontside( this.canvases.front );

				// Attach Labels
				this.labels = this._attachLabels();

				// Update Initial Value
				this._updateVal( 0 );

				this.animate( this.options.initialValue, false );
			}

			return this;
		}, 
		_parseOptions: function() {
			// Calculate radius based on element's width/height
			var outerRadius = Math.max( this.element.width(), this.element.height() ) / 2;
			var outerThickness = this.options.outerThickness;
			var fillThickness = this.options.fillThickness;

			this.attributes = $.extend({}, this.attributes, {
				currentValue: 0, 
				radius: {
					'back': outerRadius, 
					'fill': outerRadius - outerThickness, 
					'front': outerRadius - outerThickness - fillThickness
				}
			});
		}, 
		_createCanvas: function( width, height ) {
			if( width === 0 || height === 0 ) {
				console.log( 'Invalid canvas dimensions' );
				return false;
			}

			var canvas = document.createElement('canvas');
			canvas.width = width * CircularStat.PIXEL_RATIO;
			canvas.height = height * CircularStat.PIXEL_RATIO;

			if( CircularStat.PIXEL_RATIO > 1 ) {
				canvas.style.width = width + 'px';
				canvas.style.height = height + 'px';
			}

			if (!canvas.getContext) {
				if(typeof(G_vmlCanvasManager) !== 'undefined') {
					G_vmlCanvasManager.initElement(canvas);
				} else {
					console.log('Your browser does not support HTML5 Canvas, or excanvas is missing on IE');
					return false;
				}
			}

			return canvas;
		}, 

		_attachLabels: function() {
			var digitLabel = $('<span></span>').addClass( this.options.digitClassName );
			var textLabel = $('<span></span>').addClass( this.options.labelClassName ).text( this.options.label );

			this.element.append( [ digitLabel, textLabel ] );

			return {
				digit: digitLabel, 
				text: textLabel
			};
		}, 

		_build: function() {
			var canvases = {};
			var canvas;
			var diameter = this.attributes.radius.back * 2;

			for( var i = 0; i < CircularStat.CANVAS_NAMES.length; ++i) {
				if( !(canvas = this._createCanvas(diameter, diameter)) ) {
					return false;
				}

				canvas.style.position = 'absolute';
				canvas.style.top = 0;
				canvas.style.left = 0;
				canvas.className = CircularStat.CANVAS_NAMES[i];

				canvases[CircularStat.CANVAS_NAMES[i]] = canvas;
			}

			this.element
				.addClass( this.options.wrapperClassName )
				.append( $.map( canvases, function( v, k ) { return v; } ) );

			return canvases;
		}, 

		_drawBackside: function( canvas ) {
			var backRadius = this.attributes.radius.back;
			var frontRadius = this.attributes.radius.fill;

	    	var context = canvas.getContext("2d");
	    	var grd = context.createLinearGradient(0, 0, 0, backRadius * 2);

	    	grd.addColorStop(0, '#d5d5d5');
	    	grd.addColorStop(1, '#ffffff');

	    	if( CircularStat.PIXEL_RATIO > 1 ) {
				context.scale(CircularStat.PIXEL_RATIO, CircularStat.PIXEL_RATIO);
			}

	    	this._drawCircle( context, backRadius, backRadius, backRadius );
	    	context.fillStyle = grd;
	    	context.fill();

	    	this._drawCircle( context, backRadius, backRadius, frontRadius );
	    	context.fillStyle = '#686868';
	    	context.fill();
		}, 

		_drawFrontside: function( canvas ) {
			var backRadius = this.attributes.radius.back;
			var frontRadius = this.attributes.radius.front;
			var context = canvas.getContext("2d");

	    	if( CircularStat.PIXEL_RATIO > 1 ) {
				context.scale(CircularStat.PIXEL_RATIO, CircularStat.PIXEL_RATIO);
			}

    		this._drawCircle( context, backRadius, backRadius, frontRadius );
	    	context.shadowColor = 'rgba(0, 0, 0, 0.3)';
	    	context.shadowBlur = 3;
	    	context.shadowOffsetY = 1;
	    	context.fillStyle = '#ffffff';
	    	context.fill();
		}, 

		_drawCircle: function( context, centerX, centerY, radius ) {
			context.beginPath();
			context.arc(centerX, centerY, radius, 0, 2 * Math.PI, false);
			context.closePath();
		}, 

		_updateVal: function( progress, from, to ) {
			var percent, value;

			if( $.isNumeric( progress ) && $.isNumeric(from) && $.isNumeric(to) ) {
				var ft = (to - from) * progress;
				percent = Math.max(0, Math.min(from + 100 * ft / this.options.maxValue, 100));
				value = Math.max(0, Math.min(from + ft, this.options.maxValue));
			} else {
				percent = Math.min(this.attributes.currentValue / this.options.maxValue, 100);
				value = Math.min(this.attributes.currentValue, this.options.maxValue);
			}

			this.labels.digit[0].innerHTML = (
				$.isFunction( this.options.format )? 
					this.options.format : 
					function( percent, value, maxValue ) {
						if(this.options.percent) {
							return percent.toFixed(this.options.decimals) + '%';
						}
						return value.toFixed(this.options.decimals) + '/' + maxValue.toFixed(this.options.decimals);
					}
			).apply( this, [ percent, value, this.options.maxValue ] );
		}, 

		_redraw: function() {
			var canvas = this.canvases['fill'];
			var context = canvas.getContext('2d');

			var backRadius = this.attributes.radius.back;
			var fillRadius = this.attributes.radius.fill;

			var targetAngle = ( this.attributes.currentValue / this.options.maxValue ) * 2 * Math.PI;
			context.fillStyle = this.options.fillColor;
			context.clearRect(0, 0, canvas.width, canvas.height);
			
			if( 0 !== targetAngle ) {
				context.save();

		    	if( CircularStat.PIXEL_RATIO > 1 ) {
					context.scale(CircularStat.PIXEL_RATIO, CircularStat.PIXEL_RATIO);
				}

				context.translate( backRadius, backRadius );
				context.rotate(-Math.PI / 2);

				context.beginPath();
				context.arc(0, 0, fillRadius, 0, targetAngle, false);
				context.lineTo(0, 0);
				context.closePath();

				context.fill();

				context.restore();
			}

			this._updateVal();
		}, 

		// Public Methods

		animate: function( value, enqueue ) {
			if( !$.isNumeric(value) || value < 0 || value > this.options.maxValue ) {
				return;
			}

			var that = this;
			var canvas = this.canvases['fill'];
			var context = canvas.getContext('2d');

			var backRadius = this.attributes.radius.back;
			var fillRadius = this.attributes.radius.fill;

			var startTime, targetAngle, initialAngle;
			context.fillStyle = this.options.fillColor;

			function loop( threadinfo ) {
				
				if( threadinfo.loops === 1 ) {
					startTime = new Date().getTime();
					targetAngle = ( value / this.options.maxValue ) * 2 * Math.PI;
					initialAngle = (this.attributes.currentValue / this.options.maxValue) * 2 * Math.PI;
				}

				var progress = Math.min((new Date().getTime() - startTime) / this.options.duration, 1.0);
				var currentAngle = initialAngle + (( targetAngle - initialAngle ) * progress);

				context.clearRect(0, 0, canvas.width, canvas.height);
				
				if( 0 !== currentAngle ) {
					context.save();

			    	if( CircularStat.PIXEL_RATIO > 1 ) {
						context.scale(CircularStat.PIXEL_RATIO, CircularStat.PIXEL_RATIO);
					}

					context.translate( backRadius, backRadius );
					context.rotate(-Math.PI / 2);

					context.beginPath();
					context.arc(0, 0, fillRadius, 0, currentAngle, false);
					context.lineTo(0, 0);
					context.closePath();

					context.fill();

					context.restore();
				}

				that._updateVal( progress, that.attributes.currentValue, value );

				if( threadinfo.stopRequested || progress >= 1.0 ) {
					that.attributes.currentValue = (that.attributes.currentValue + ((value - that.attributes.currentValue) * progress));
					return false;
				}

				return true;
			}

			function queueAnimation( dequeue ) {
				$(this).queue( 'circular', function( next ) {
					(this.activeAnimationThread = new AnimationThread({
						'onLoop': function() {
							return loop.apply( this, arguments );
						}, 
						'afterStop': function() {
							next();
							if( $(this).queue( 'circular' ).length === 0 ) {
								this.activeAnimationThread = null;
							}
						}, 
						'owner': this
					})).start();
				});

				dequeue && $(this).dequeue( 'circular' );
			}

			if( !enqueue && this.activeAnimationThread ) {
				$(this).clearQueue( 'circular' );
				this.activeAnimationThread.stop(function() {
					queueAnimation.apply( this, [ true ] );
				});
			} else {
				queueAnimation.apply( this, [ !this.activeAnimationThread ] );
			}
		}, 

		option: function( key, value ) {
			
			if ( arguments.length === 0 ) {
				// don't return a reference to the internal hash
				return $.extend( {}, this.options );
			}

			if  (typeof key === "string" ) {
				if ( value === undefined ) {
					return this.options[ key ];
				}

				switch( key ) {
					case 'label':
						this.options[ key ] = value;
						this.labels.text.html( value );
						break;
					case 'maxValue':
						if( !this.options.percent ) {
							this.attributes.currentValue = Math.max(Math.min(this.attributes.currentValue, value), 0);
							this.options[ key ] = value;
							this._redraw();
						}
						break;
					case 'percent':
						if( !!value ) {
							this.options.maxValue = 100;
							this.attributes.currentValue = Math.max(Math.min(this.attributes.currentValue, 100), 0);
						}
					case 'format':
					case 'decimals':
					case 'fillColor':
					case 'duration':
						this.options[ key ] = value;
						this._redraw();
						break;
					default:
						break;
				}
			}

			return this;
		}
	}
	
	CircularStat.defaults = CircularStat.prototype.defaults;
	
	$.fn.CircularStat = function(options) {

		var isMethodCall = typeof options === "string",
			args = Array.prototype.slice.call( arguments, 1 ),
			returnValue = this;

		// prevent calls to internal methods
		if ( isMethodCall && options.charAt( 0 ) === "_" ) {
			return returnValue;
		}

		if ( isMethodCall ) {
			this.each(function() {
				var instance = $.data( this, 'circular-stat' ),
					methodValue = instance && $.isFunction( instance[options] ) ?
						instance[ options ].apply( instance, args ) :
						instance;

				if ( methodValue !== instance && methodValue !== undefined ) {
					returnValue = methodValue;
					return false;
				}
			});
		} else {
			this.each(function() {
				var instance = $.data( this, 'circular-stat' );
				if ( !instance ) {
					$.data( this, 'circular-stat', new CircularStat( this, options ) );
				}
			});
		}

		return returnValue;
	};

	/* DATA-API
	* ================== */

	$(function () {
		$('[data-provide="circular"]').each(function () {
			var $element = $(this);
			$element.CircularStat( $element.data() );
		});
	});

})( jQuery, window , document );
