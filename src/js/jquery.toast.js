// jQuery toast plugin created by Kamran Ahmed copyright MIT license 2015
if (typeof Object.create !== 'function') Object.create = obj => {
	const F = () => {
	};
	F.prototype = obj;
	return new F();
};

(($, window, _, __) => {
	"use strict";
	let Toast = {
		"_defaultIcons": ['success', 'error', 'info', 'warning'],
		"_positionClasses": ['bottom-left', 'bottom-right', 'top-right', 'top-left', 'bottom-center', 'top-center', 'mid-center'],
		"addToDom"() {
			let _container = $('.jq-toast-wrap');
			if (_container.length === 0) {
				_container = $('<div></div>', {
					"class": "jq-toast-wrap toast-container", "role": "alert", "aria-live": "polite"
				});
				$('body').append(_container);
			} else if (!this.options.stack || isNaN(parseInt(this.options.stack, 10))) _container.empty();

			_container.find('.jq-toast-single:hidden').remove();
			_container.append(this._toastEl);

			if (this.options.stack && !isNaN(parseInt(this.options.stack), 10)) {
				let _prevToastCount = _container.find('.jq-toast-single').length,
					_extToastCount = _prevToastCount - this.options.stack;
				if (_extToastCount > 0) $('.jq-toast-wrap').find('.jq-toast-single').slice(0, _extToastCount).remove();
			}
			this._container = _container;
		},
		"animate"() {
			let that = this;

			this._toastEl.hide();
			this._toastEl.trigger('beforeShow');

			if (this.options.showHideTransition.toLowerCase() === 'fade') this._toastEl.fadeIn(() => {
				that._toastEl.trigger('afterShown');
			}); else if (this.options.showHideTransition.toLowerCase() === 'slide') this._toastEl.slideDown(() => {
				that._toastEl.trigger('afterShown');
			}); else this._toastEl.show(() => {
				that._toastEl.trigger('afterShown');
			});

			if (this.options.hideAfter !== false && !isNaN(parseInt(this.options.hideAfter, 10))) {
				that = this;
				window.setTimeout(() => {
					if (that.options.showHideTransition.toLowerCase() === 'fade') {
						that._toastEl.trigger('beforeHide');
						that._toastEl.fadeOut(() => {
							that._toastEl.trigger('afterHidden');
						});
					} else if (that.options.showHideTransition.toLowerCase() === 'slide') {
						that._toastEl.trigger('beforeHide');
						that._toastEl.slideUp(() => {
							that._toastEl.trigger('afterHidden');
						});
					} else {
						that._toastEl.trigger('beforeHide');
						that._toastEl.hide(() => {
							that._toastEl.trigger('afterHidden');
						});
					}

				}, this.options.hideAfter);
			}
		},
		"bindToast"() {
			let that = this;
			this._toastEl.on('afterShown', () => {
				that.processLoader();
			});
			this._toastEl.find('.close-jq-toast-single').on('click', e => {
				e.preventDefault();

				if (that.options.showHideTransition === 'fade') {
					that._toastEl.trigger('beforeHide');
					that._toastEl.fadeOut(() => {
						that._toastEl.trigger('afterHidden');
					});
				} else if (that.options.showHideTransition === 'slide') {
					that._toastEl.trigger('beforeHide');
					that._toastEl.slideUp(() => {
						that._toastEl.trigger('afterHidden');
					});
				} else {
					that._toastEl.trigger('beforeHide');
					that._toastEl.hide(() => {
						that._toastEl.trigger('afterHidden');
					});
				}
			});

			if (typeof this.options.beforeShow == 'function') this._toastEl.on('beforeShow', () => {
				that.options.beforeShow(that._toastEl);
			});
			if (typeof this.options.afterShown == 'function') this._toastEl.on('afterShown', () => {
				that.options.afterShown(that._toastEl);
			});
			if (typeof this.options.beforeHide == 'function') this._toastEl.on('beforeHide', () => {
				that.options.beforeHide(that._toastEl);
			});
			if (typeof this.options.afterHidden == 'function') this._toastEl.on('afterHidden', () => {
				that.options.afterHidden(that._toastEl);
			});
			if (typeof this.options.onClick == 'function') this._toastEl.on('click', () => {
				that.options.onClick(that._toastEl);
			});
		},
		"close"() {
			this._toastEl.find('.close-jq-toast-single').click();
		},
		"init"(options, _) {
			this.prepareOptions(options, $.toast.options);
			this.process();
		},
		"position"() {
			if ((typeof this.options.position === 'string') && ($.inArray(this.options.position, this._positionClasses) !== -1)) {
				if (this.options.position === 'bottom-center') this._container.css({
					"left": ($(window).outerWidth() / 2) - this._container.outerWidth() / 2, "bottom": 20
				}); else if (this.options.position === 'top-center') this._container.css({
					"left": ($(window).outerWidth() / 2) - this._container.outerWidth() / 2, "top": 20
				}); else if (this.options.position === 'mid-center') this._container.css({
					"left": ($(window).outerWidth() / 2) - this._container.outerWidth() / 2,
					"top": ($(window).outerHeight() / 2) - this._container.outerHeight() / 2
				}); else this._container.addClass(this.options.position);
			} else if (typeof this.options.position === 'object') this._container.css({
				"bottom": this.options.position.bottom ? this.options.position.bottom : 'auto',
				"left": this.options.position.left ? this.options.position.left : 'auto',
				"right": this.options.position.right ? this.options.position.right : 'auto',
				"top": this.options.position.top ? this.options.position.top : 'auto'
			}); else this._container.addClass('bottom-left');
		},
		"prepareOptions"(options, options_to_extend) {
			let _options = {};
			if ((typeof options === 'string') || (options instanceof Array)) _options.text = options; else _options = options;
			this.options = $.extend({}, options_to_extend, _options);
		},
		"process"() {
			this.setup();
			this.addToDom();
			this.position();
			this.bindToast();
			this.animate();
		},
		"processLoader"() {
			// Show the loader only, if auto-hide is on and loader is demanded
			if (!(this.options.hideAfter !== false && !isNaN(parseInt(this.options.hideAfter, 10))) || this.options.loader === false) return false;

			let loader = this._toastEl.find('.jq-toast-loader');
			let transitionTime = (this.options.hideAfter - 400) / 1000 + 's';
			let loaderBg = this.options.loaderBg;
			let style = loader.attr('style') || '';
			style = style.substring(0, style.indexOf('-webkit-transition')); // Remove the last transition definition
			style += '-webkit-transition: width ' + transitionTime + ' ease-in; \
                      -o-transition: width ' + transitionTime + ' ease-in; \
                      transition: width ' + transitionTime + ' ease-in; \
                      background-color: ' + loaderBg + ';';
			loader.attr('style', style).addClass('jq-toast-loaded');
		},
		"reset"(resetWhat) {
			if (resetWhat === 'all') $('.jq-toast-wrap').remove(); else this._toastEl.remove();
		},
		"setup"() {
			this._toastEl = this._toastEl || $('<div></div>', {
				"class": 'toast', "role": 'alert'
			});

			let _toastContent = '<span class="jq-toast-loader"></span>';
			if (this.options.allowToastClose) _toastContent += '<button type="button" class="btn-close me-2 close-jq-toast-single" style="margin: .6rem .5rem"></button>';
			if (this.options.heading) _toastContent += '<div class="toast-header" style="padding: .5rem .75rem"><strong class="me-auto">' + this.options.heading + '</strong>' + '<small style="padding-right: 1.75rem">' + new Date().toLocaleTimeString() + '</small></div>'

			_toastContent += '<div class="toast-body" style="padding: .75rem; word-wrap: break-word; text-justify: inter-word; text-align: justify">' + this.options.text + '</div>';

			this._toastEl.html(_toastContent);

			if (this.options.textAlign) this._toastEl.css('text-align', this.options.textAlign);
			if (this.options.class !== false) this._toastEl.addClass(this.options.class)
		},
		"update"(options) {
			this.prepareOptions(options, this.options);
			this.setup();
			this.bindToast();
		}
	};
	$.toast = function (options) {
		let toast = Object.create(Toast);
		toast.init(options, this);
		return {
			reset: function (what) {
				toast.reset(what);
			}, update: function (options) {
				toast.update(options);
			}, close: function () {
				toast.close();
			}
		}
	};
	$.toast.options = {
		"afterHidden"() {
		},
		"afterShown"() {
		},
		"allowToastClose": true,
		"beforeHide"() {
		},
		"beforeShow"() {
		},
		"bgColor": false,
		"heading": '',
		"hideAfter": 3000,
		"icon": false,
		"loader": true,
		"loaderBg": '#9EC600',
		"onClick"() {
		},
		"position": 'bottom-left',
		"showHideTransition": 'fade',
		"stack": 5,
		"text": '',
		"textAlign": 'left',
		"textColor": false
	};
})(jQuery, window, document);
