!
function(e) {
	"use strict";
	"function" == typeof define && define.amd ? define(["jquery"], e) : e("object" == typeof exports && "function" == typeof require ? require("jquery") : jQuery)
}(function(e) {
	"use strict";

	function t(n, o) {
		var i = function() {},
			s = this,
			a = {
				ajaxSettings: {},
				autoSelectFirst: !1,
				appendTo: document.body,
				serviceUrl: null,
				lookup: null,
				onSelect: null,
				width: "auto",
				minChars: 1,
				maxHeight: 300,
				deferRequestBy: 0,
				params: {},
				formatResult: t.formatResult,
				delimiter: null,
				zIndex: 9999,
				type: "GET",
				noCache: !1,
				onSearchStart: i,
				onSearchComplete: i,
				onSearchError: i,
				preserveInput: !1,
				containerClass: "autocomplete-suggestions",
				tabDisabled: !1,
				dataType: "text",
				currentRequest: null,
				triggerSelectOnValidInput: !0,
				preventBadQueries: !0,
				lookupFilter: function(e, t, n) {
					return -1 !== e.value.toLowerCase().indexOf(n)
				},
				paramName: "query",
				transformResult: function(t) {
					return "string" == typeof t ? e.parseJSON(t) : t
				},
				showNoSuggestionNotice: !1,
				noSuggestionNotice: "No results",
				orientation: "bottom",
				forceFixPosition: !1
			};
		s.element = n, s.el = e(n), s.suggestions = [], s.badQueries = [], s.selectedIndex = -1, s.currentValue = s.element.value, s.intervalId = 0, s.cachedResponse = {}, s.onChangeInterval = null, s.onChange = null, s.isLocal = !1, s.suggestionsContainer = null, s.noSuggestionsContainer = null, s.options = e.extend({}, a, o), s.classes = {
			selected: "autocomplete-selected",
			suggestion: "autocomplete-suggestion"
		}, s.hint = null, s.hintValue = "", s.selection = null, s.initialize(), s.setOptions(o)
	}
	var n = function() {
			return {
				escapeRegExChars: function(e) {
					return e.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")
				},
				createNode: function(e) {
					var t = document.createElement("div");
					return t.className = e, t.style.position = "absolute", t.style.display = "none", t
				}
			}
		}(),
		o = {
			ESC: 27,
			TAB: 9,
			RETURN: 13,
			LEFT: 37,
			UP: 38,
			RIGHT: 39,
			DOWN: 40
		};
	t.utils = n, e.Autocomplete = t, t.formatResult = function(e, t) {
		var o = "(" + n.escapeRegExChars(t) + ")";
		return e.value.replace(new RegExp(o, "gi"), "<strong>$1</strong>").replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/&lt;(\/?strong)&gt;/g, "<$1>")
	}, t.prototype = {
		killerFn: null,
		initialize: function() {
			var n, o = this,
				i = "." + o.classes.suggestion,
				s = o.classes.selected,
				a = o.options;
			o.element.setAttribute("autocomplete", "off"), o.killerFn = function(t) {
				0 === e(t.target).closest("." + o.options.containerClass).length && (o.killSuggestions(), o.disableKillerFn())
			}, o.noSuggestionsContainer = e('<div class="autocomplete-no-suggestion"></div>').html(this.options.noSuggestionNotice).get(0), o.suggestionsContainer = t.utils.createNode(a.containerClass), n = e(o.suggestionsContainer), n.appendTo(a.appendTo), "auto" !== a.width && n.width(a.width), n.on("mouseover.autocomplete", i, function() {
				o.activate(e(this).data("index"))
			}), n.on("mouseout.autocomplete", function() {
				o.selectedIndex = -1, n.children("." + s).removeClass(s)
			}), n.on("click.autocomplete", i, function() {
				o.select(e(this).data("index"))
			}), o.fixPositionCapture = function() {
				o.visible && o.fixPosition()
			}, e(window).on("resize.autocomplete", o.fixPositionCapture), o.el.on("keydown.autocomplete", function(e) {
				o.onKeyPress(e)
			}), o.el.on("keyup.autocomplete", function(e) {
				o.onKeyUp(e)
			}), o.el.on("blur.autocomplete", function() {
				o.onBlur()
			}), o.el.on("focus.autocomplete", function() {
				o.onFocus()
			}), o.el.on("change.autocomplete", function(e) {
				o.onKeyUp(e)
			}), o.el.on("input.autocomplete", function(e) {
				o.onKeyUp(e)
			})
		},
		onFocus: function() {
			var e = this;
			e.fixPosition(), 0 === e.options.minChars && 0 === e.el.val().length && e.onValueChange()
		},
		onBlur: function() {
			this.enableKillerFn()
		},
		abortAjax: function() {
			var e = this;
			e.currentRequest && (e.currentRequest.abort(), e.currentRequest = null)
		},
		setOptions: function(t) {
			var n = this,
				o = n.options;
			e.extend(o, t), n.isLocal = e.isArray(o.lookup), n.isLocal && (o.lookup = n.verifySuggestionsFormat(o.lookup)), o.orientation = n.validateOrientation(o.orientation, "bottom"), e(n.suggestionsContainer).css({
				"max-height": o.maxHeight + "px",
				width: o.width + "px",
				"z-index": o.zIndex
			})
		},
		clearCache: function() {
			this.cachedResponse = {}, this.badQueries = []
		},
		clear: function() {
			this.clearCache(), this.currentValue = "", this.suggestions = []
		},
		disable: function() {
			var e = this;
			e.disabled = !0, clearInterval(e.onChangeInterval), e.abortAjax()
		},
		enable: function() {
			this.disabled = !1
		},
		fixPosition: function() {
			var t = this,
				n = e(t.suggestionsContainer),
				o = n.parent().get(0);
			if (o === document.body || t.options.forceFixPosition) {
				var i = t.options.orientation,
					s = n.outerHeight(),
					a = t.el.outerHeight(),
					r = t.el.offset(),
					l = {
						top: r.top,
						left: r.left
					};
				if ("auto" === i) {
					var u = e(window).height(),
						c = e(window).scrollTop(),
						d = -c + r.top - s,
						g = c + u - (r.top + a + s);
					i = Math.max(d, g) === d ? "top" : "bottom"
				}
				if (l.top += "top" === i ? -s : a, o !== document.body) {
					var h, p = n.css("opacity");
					t.visible || n.css("opacity", 0).show(), h = n.offsetParent().offset(), l.top -= h.top, l.left -= h.left, t.visible || n.css("opacity", p).hide()
				}
				"auto" === t.options.width && (l.width = t.el.outerWidth() - 2 + "px"), n.css(l)
			}
		},
		enableKillerFn: function() {
			var t = this;
			e(document).on("click.autocomplete", t.killerFn)
		},
		disableKillerFn: function() {
			var t = this;
			e(document).off("click.autocomplete", t.killerFn)
		},
		killSuggestions: function() {
			var e = this;
			e.stopKillSuggestions(), e.intervalId = window.setInterval(function() {
				e.visible && (e.el.val(e.currentValue), e.hide()), e.stopKillSuggestions()
			}, 50)
		},
		stopKillSuggestions: function() {
			window.clearInterval(this.intervalId)
		},
		isCursorAtEnd: function() {
			var e, t = this,
				n = t.el.val().length,
				o = t.element.selectionStart;
			return "number" == typeof o ? o === n : document.selection ? (e = document.selection.createRange(), e.moveStart("character", -n), n === e.text.length) : !0
		},
		onKeyPress: function(e) {
			var t = this;
			if (!t.disabled && !t.visible && e.which === o.DOWN && t.currentValue) return void t.suggest();
			if (!t.disabled && t.visible) {
				switch (e.which) {
				case o.ESC:
					t.el.val(t.currentValue), t.hide();
					break;
				case o.RIGHT:
					if (t.hint && t.options.onHint && t.isCursorAtEnd()) {
						t.selectHint();
						break
					}
					return;
				case o.TAB:
					if (t.hint && t.options.onHint) return void t.selectHint();
					if (-1 === t.selectedIndex) return void t.hide();
					if (t.select(t.selectedIndex), t.options.tabDisabled === !1) return;
					break;
				case o.RETURN:
					if (-1 === t.selectedIndex) return void t.hide();
					t.select(t.selectedIndex);
					break;
				case o.UP:
					t.moveUp();
					break;
				case o.DOWN:
					t.moveDown();
					break;
				default:
					return
				}
				e.stopImmediatePropagation(), e.preventDefault()
			}
		},
		onKeyUp: function(e) {
			var t = this;
			if (!t.disabled) {
				switch (e.which) {
				case o.UP:
				case o.DOWN:
					return
				}
				clearInterval(t.onChangeInterval), t.currentValue !== t.el.val() && (t.findBestHint(), t.options.deferRequestBy > 0 ? t.onChangeInterval = setInterval(function() {
					t.onValueChange()
				}, t.options.deferRequestBy) : t.onValueChange())
			}
		},
		onValueChange: function() {
			var t = this,
				n = t.options,
				o = t.el.val(),
				i = t.getQuery(o);
			return t.selection && t.currentValue !== i && (t.selection = null, (n.onInvalidateSelection || e.noop).call(t.element)), clearInterval(t.onChangeInterval), t.currentValue = o, t.selectedIndex = -1, n.triggerSelectOnValidInput && t.isExactMatch(i) ? void t.select(0) : void(i.length < n.minChars ? t.hide() : t.getSuggestions(i))
		},
		isExactMatch: function(e) {
			var t = this.suggestions;
			return 1 === t.length && t[0].value.toLowerCase() === e.toLowerCase()
		},
		getQuery: function(t) {
			var n, o = this.options.delimiter;
			return o ? (n = t.split(o), e.trim(n[n.length - 1])) : t
		},
		getSuggestionsLocal: function(t) {
			var n, o = this,
				i = o.options,
				s = t.toLowerCase(),
				a = i.lookupFilter,
				r = parseInt(i.lookupLimit, 10);
			return n = {
				suggestions: e.grep(i.lookup, function(e) {
					return a(e, t, s)
				})
			}, r && n.suggestions.length > r && (n.suggestions = n.suggestions.slice(0, r)), n
		},
		getSuggestions: function(t) {
			var n, o, i, s, a = this,
				r = a.options,
				l = r.serviceUrl;
			if (r.params[r.paramName] = t, o = r.ignoreParams ? null : r.params, r.onSearchStart.call(a.element, r.params) !== !1) {
				if (e.isFunction(r.lookup)) return void r.lookup(t, function(e) {
					a.suggestions = e.suggestions, a.suggest(), r.onSearchComplete.call(a.element, t, e.suggestions)
				});
				a.isLocal ? n = a.getSuggestionsLocal(t) : (e.isFunction(l) && (l = l.call(a.element, t)), i = l + "?" + e.param(o || {}), n = a.cachedResponse[i]), n && e.isArray(n.suggestions) ? (a.suggestions = n.suggestions, a.suggest(), r.onSearchComplete.call(a.element, t, n.suggestions)) : a.isBadQuery(t) ? r.onSearchComplete.call(a.element, t, []) : (a.abortAjax(), s = {
					url: l,
					data: o,
					type: r.type,
					dataType: r.dataType
				}, e.extend(s, r.ajaxSettings), a.currentRequest = e.ajax(s).done(function(e) {
					var n;
					a.currentRequest = null, n = r.transformResult(e, t), a.processResponse(n, t, i), r.onSearchComplete.call(a.element, t, n.suggestions)
				}).fail(function(e, n, o) {
					r.onSearchError.call(a.element, t, e, n, o)
				}))
			}
		},
		isBadQuery: function(e) {
			if (!this.options.preventBadQueries) return !1;
			for (var t = this.badQueries, n = t.length; n--;) if (0 === e.indexOf(t[n])) return !0;
			return !1
		},
		hide: function() {
			var t = this,
				n = e(t.suggestionsContainer);
			e.isFunction(t.options.onHide) && t.visible && t.options.onHide.call(t.element, n), t.visible = !1, t.selectedIndex = -1, clearInterval(t.onChangeInterval), e(t.suggestionsContainer).hide(), t.signalHint(null)
		},
		suggest: function() {
			if (0 === this.suggestions.length) return void(this.options.showNoSuggestionNotice ? this.noSuggestions() : this.hide());
			var t, n = this,
				o = n.options,
				i = o.groupBy,
				s = o.formatResult,
				a = n.getQuery(n.currentValue),
				r = n.classes.suggestion,
				l = n.classes.selected,
				u = e(n.suggestionsContainer),
				c = e(n.noSuggestionsContainer),
				d = o.beforeRender,
				g = "",
				h = function(e, n) {
					var o = e.data[i];
					return t === o ? "" : (t = o, '<div class="autocomplete-group"><strong>' + t + "</strong></div>")
				};
			return o.triggerSelectOnValidInput && n.isExactMatch(a) ? void n.select(0) : (e.each(n.suggestions, function(e, t) {
				i && (g += h(t, a, e)), g += '<div class="' + r + '" data-index="' + e + '">' + s(t, a) + "</div>"
			}), this.adjustContainerWidth(), c.detach(), u.html(g), e.isFunction(d) && d.call(n.element, u), n.fixPosition(), u.show(), o.autoSelectFirst && (n.selectedIndex = 0, u.scrollTop(0), u.children("." + r).first().addClass(l)), n.visible = !0, void n.findBestHint())
		},
		noSuggestions: function() {
			var t = this,
				n = e(t.suggestionsContainer),
				o = e(t.noSuggestionsContainer);
			this.adjustContainerWidth(), o.detach(), n.empty(), n.append(o), t.fixPosition(), n.show(), t.visible = !0
		},
		adjustContainerWidth: function() {
			var t, n = this,
				o = n.options,
				i = e(n.suggestionsContainer);
			"auto" === o.width && (t = n.el.outerWidth() - 2, i.width(t > 0 ? t : 300))
		},
		findBestHint: function() {
			var t = this,
				n = t.el.val().toLowerCase(),
				o = null;
			n && (e.each(t.suggestions, function(e, t) {
				var i = 0 === t.value.toLowerCase().indexOf(n);
				return i && (o = t), !i
			}), t.signalHint(o))
		},
		signalHint: function(t) {
			var n = "",
				o = this;
			t && (n = o.currentValue + t.value.substr(o.currentValue.length)), o.hintValue !== n && (o.hintValue = n, o.hint = t, (this.options.onHint || e.noop)(n))
		},
		verifySuggestionsFormat: function(t) {
			return t.length && "string" == typeof t[0] ? e.map(t, function(e) {
				return {
					value: e,
					data: null
				}
			}) : t
		},
		validateOrientation: function(t, n) {
			return t = e.trim(t || "").toLowerCase(), -1 === e.inArray(t, ["auto", "bottom", "top"]) && (t = n), t
		},
		processResponse: function(e, t, n) {
			var o = this,
				i = o.options;
			e.suggestions = o.verifySuggestionsFormat(e.suggestions), i.noCache || (o.cachedResponse[n] = e, i.preventBadQueries && 0 === e.suggestions.length && o.badQueries.push(t)), t === o.getQuery(o.currentValue) && (o.suggestions = e.suggestions, o.suggest())
		},
		activate: function(t) {
			var n, o = this,
				i = o.classes.selected,
				s = e(o.suggestionsContainer),
				a = s.find("." + o.classes.suggestion);
			return s.find("." + i).removeClass(i), o.selectedIndex = t, -1 !== o.selectedIndex && a.length > o.selectedIndex ? (n = a.get(o.selectedIndex), e(n).addClass(i), n) : null
		},
		selectHint: function() {
			var t = this,
				n = e.inArray(t.hint, t.suggestions);
			t.select(n)
		},
		select: function(e) {
			var t = this;
			t.hide(), t.onSelect(e)
		},
		moveUp: function() {
			var t = this;
			if (-1 !== t.selectedIndex) return 0 === t.selectedIndex ? (e(t.suggestionsContainer).children().first().removeClass(t.classes.selected), t.selectedIndex = -1, t.el.val(t.currentValue), void t.findBestHint()) : void t.adjustScroll(t.selectedIndex - 1)
		},
		moveDown: function() {
			var e = this;
			e.selectedIndex !== e.suggestions.length - 1 && e.adjustScroll(e.selectedIndex + 1)
		},
		adjustScroll: function(t) {
			var n = this,
				o = n.activate(t);
			if (o) {
				var i, s, a, r = e(o).outerHeight();
				i = o.offsetTop, s = e(n.suggestionsContainer).scrollTop(), a = s + n.options.maxHeight - r, s > i ? e(n.suggestionsContainer).scrollTop(i) : i > a && e(n.suggestionsContainer).scrollTop(i - n.options.maxHeight + r), n.options.preserveInput || n.el.val(n.getValue(n.suggestions[t].value)), n.signalHint(null)
			}
		},
		onSelect: function(t) {
			var n = this,
				o = n.options.onSelect,
				i = n.suggestions[t];
			n.currentValue = n.getValue(i.value), n.currentValue === n.el.val() || n.options.preserveInput || n.el.val(n.currentValue), n.signalHint(null), n.suggestions = [], n.selection = i, e.isFunction(o) && o.call(n.element, i)
		},
		getValue: function(e) {
			var t, n, o = this,
				i = o.options.delimiter;
			return i ? (t = o.currentValue, n = t.split(i), 1 === n.length ? e : t.substr(0, t.length - n[n.length - 1].length) + e) : e
		},
		dispose: function() {
			var t = this;
			t.el.off(".autocomplete").removeData("autocomplete"), t.disableKillerFn(), e(window).off("resize.autocomplete", t.fixPositionCapture), e(t.suggestionsContainer).remove()
		}
	}, e.fn.autocomplete = e.fn.devbridgeAutocomplete = function(n, o) {
		var i = "autocomplete";
		return 0 === arguments.length ? this.first().data(i) : this.each(function() {
			var s = e(this),
				a = s.data(i);
			"string" == typeof n ? a && "function" == typeof a[n] && a[n](o) : (a && a.dispose && a.dispose(), a = new t(this, n), s.data(i, a))
		})
	}
}), $(function() {
	var e = $("#basePath").val(),
		t = $("#searchkeyIpt"),
		n = $("#historyList");
	$(".all-orders").click(function() {
		$.cookie("orderListPage", 1, {
			expires: 1,
			path: "/"
		})
	});
	var o = $("#allType"),
		i = $("#typeList");
	o.on("mouseover", function() {
		i.show()
	}), o.on("mouseout", function() {
		i.hide()
	}), i.on("mouseover", function() {
		i.show()
	}), i.on("mouseout", function() {
		i.hide()
	}), window.sessionStorage && JSON ? Yt.post(e + "index.php?m=itemIndex&a=getIndexCategoryList", {}, function(e) {
		i.html(Yt.render($("#typeListTpl").html(), e)), sessionStorage.setItem("categoryList", JSON.stringify(e))
	}, function() {}, !1) : Yt.post(e + "index.php?m=itemIndex&a=getIndexCategoryList", {}, function(e) {
		i.html(Yt.render($("#typeListTpl").html(), e))
	}, function() {}, !1), $("#headerSearchBtn").on("click", function() {
		var e = $("#searchkeyIpt").val() || $("#defaultKey").val() || "";
		window.location.href = "/index.php?m=itemIndex_search&a=index&keyword=" + encodeURI(e)
	}), $(".senior-store").on("click", function() {
		var e = $(this).find("a").attr("href");
		e || Yt.alert("该频道为高级门店专享，请联系本店服务销售开通")
	}), $("#searchInputHeader").bind("keydown", function(e) {
		13 === e.keyCode && $("#headerSearchBtn").click()
	}), $("#aboutUsWrap").find(".contact-item").hover(function() {
		$(this).find(".lift-checked").show()
	}, function() {
		$(this).find(".lift-checked").hide()
	}), $("#backToTop").click(function() {
		return $("html, body").animate({
			scrollTop: 0
		}, 200), !1
	}), /*Yt.post(e + "/admin/cart/countCartItemNums.json", {}, function(e) {
		$("#cartNumPop").text(e.data), $("#cartIcon").find(".lift-checked span").text(e.data), $("#cartAddTip").text(e.data)
	}, function() {}, !1), */t.on("click", function() {
		$(this).val() ? n.hide() : a()
	}), $("#historyItemList").on("click", "div.history-item", function(e) {
		e.preventDefault(), e.stopPropagation(), console.log(document.activeElement.id);
		var n = $(this).text();
		t.val(n), $("#headerSearchBtn").trigger("click")
	}), t.on("keyup", function() {
		$(this).val() ? n.hide() : a()
	}), $("body").on("click", function() {
		n.is(":hidden") || n.hide()
	}), $("#historyDelBtn").on("click", function() {
		Yt.confirm("确认清空历史记录?", function() {
			s()
		})
	}), $("#searchkeyIpt").autocomplete({
		serviceUrl: "/index.php?m=itemIndex_search&a=wordtip",
		dataType: "json",
		paramName: "word",
		deferRequestBy: 500,
		width: 371,
		left: 686,
		transformResult: function(e) {
			return {
				suggestions: $.map(e.data, function(e) {
					return {
						value: e,
						data: e
					}
				})
			}
		},
		onSelect: function(e) {
			console.log(e), $("#headerSearchBtn").trigger("click")
		}
	});
	/*var s = function() {
			Yt.post(e + "/admin/item/itemQueryHistoryClear.json", {}, function(e) {
				$("#historyItemList").html(""), n.hide()
			})
		},
		a = function() {
			Yt.post(e + "/admin/item/itemQueryHistory.json", {}, function(e) {
				if (e.data.length) {
					for (var t = "", o = 0; o < e.data.length; o++) 10 > o && (t += '<div class="autocomplete-suggestion history-item" data-rpno="25.' + (o - 0 + 1) + '" data-rpgo="true">' + e.data[o] + "</div>");
					$("#historyItemList").html(t), n.show()
				} else n.hide()
			}, function() {}, !1)
		}*/
});