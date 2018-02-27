!
function e(t, i, n) {
	function o(r, s) {
		if (!i[r]) {
			if (!t[r]) {
				var d = "function" == typeof require && require;
				if (!s && d) return d(r, !0);
				if (a) return a(r, !0);
				var c = new Error("Cannot find module '" + r + "'");
				throw c.code = "MODULE_NOT_FOUND", c
			}
			var f = i[r] = {
				exports: {}
			};
			t[r][0].call(f.exports, function(e) {
				var i = t[r][1][e];
				return o(i ? i : e)
			}, f, f.exports, e, t, i, n)
		}
		return i[r].exports
	}
	for (var a = "function" == typeof require && require, r = 0; r < n.length; r++) o(n[r]);
	return o
}({
	1: [function(e, t, i) {
		e("../../../lib/jquery.xslider/xslider.js"), e("../../../lib/jquery.cookie.js"), $(function() {
			var e = function() {
					this.basePath = $("#basePath").val(), this.isLoad = !1
				};
				
			e.prototype = {
				initPage: function() {
					$("#channelWrap").find("#firstItem").addClass("checked"), this.initLayer(), this.fGetBottomImg(), this.fGetCheapAndNew(), this.eventBind(), this.fGetDataFromSession()
				},
				initLayer: function() {
					var e = this,
						t = $.cookie("layerId");
//					Yt.post(e.basePath + "/admin/item/floatLayer.json", {}, function(i) {
//						if (1 === i.data.isShow) {
//							if (!i.data.id || !i.data.imgUrl) return !1;
//							if (i.data.id + "" === t) return !1;
//							var n = e.formatURL(i.data),
//								o = '<div class="pos-r"><i id="layerCloseBtn" data-rpno="24.2" style="font-size: 40px;" class="iconfont cor-w close-icon pos-a">&#xe6e7;</i><div class="w-650 of-h h-400"><a href="' + n + '" data-rpno="24.1" target="_blank"><img class="w-100" height="400px" src="' + i.data.imgUrl + '"/></a></div></div>';
//							if (null == n) {
//								var n = "javascript:void(0)";
//								o = '<div class="pos-r"><i id="layerCloseBtn" data-rpno="24.2" style="font-size: 40px;" class="iconfont cor-w close-icon pos-a">&#xe6e7;</i><div class="w-650 of-h h-400"><img class="w-100" height="400px" src="' + i.data.imgUrl + '"/></div></div>'
//							}
//							console.log(o), $.cookie("layerId", i.data.id, {
//								path: "/",
//								expires: 10
//							});
//							var a = dialog({
//								fixed: !0,
//								id: "popLayer",
//								content: o
//							});
//							a.showModal(), $("#layerCloseBtn").one("click", function() {
//								a.close().remove()
//							}), setTimeout(function() {
//								a.close().remove()
//							}, 1e4)
//						}
//					}, function() {}, !1)
				},
				eventBind: function() {
					var e = this,
						t = $("#moduleLiftList");
					t.on("mouseover", ".lift-item", function() {
						$(this).css("background-color", "#FF5C5C"), $(this).find(".lift-checked").show(), $(this).find("div").removeClass("cor-6").addClass("cor-w")
					}), t.on("mouseout", ".lift-item", function() {
						$(this).css("background-color", "#fff"), $(this).find(".lift-checked").hide(), $(this).find("div").removeClass("cor-w").addClass("cor-6")
					}), t.on("click", ".lift-item", function() {
						var e = $(this).attr("data-id"),
							t = $("#" + e).offset().top;
						window.pageYOffset = t - 60, document.documentElement.scrollTop = t - 60, document.body.scrollTop = t - 60
					}), $("#SliderContent").Xslider({
						affect: "fade",
						conbox: ".slider-box",
						ctag: ".slider-unit",
						space: 3e3,
						speed: 2e3,
						switcher: "#SliderTriggle"
					}), $(window).on("scroll", function() {
						e.handleLiftScroll()
					}), $("#appDown").on("click", function() {
						$(".down-app").hide()
					})
				},
				formatURL: function(e) {
					var t = e.linkType - 0;
					switch (t) {
					case 1:
						return e.linkId ? "/admin/sp/" + e.linkId + "/tpActivity.do" : null;
					case 2:
						return e.linkId ? "/admin/item/item/itemList.do?searchSource=key&searchkey=" + e.linkId : null;
					case 3:
						return e.linkId ? "/admin/item/item.do?itemId=" + e.linkId : null;
					case 4:
						return "/admin/benefitVolume/getUnBenefitVolume.do";
					case 5:
						return null
					}
				},
				handleLiftScroll: function() {
					var e = $(window).height(),
						t = $("#moduleLiftList");
					if (!t.find("li").length) return !1;
					var i = $(window).scrollTop();
					e > i ? t.is(":hidden") || t.hide() : t.show()
				},
				hideTypeList: function() {
					var e = $("#typeList"),
						t = $("#allType");
					e.removeClass("d-n"), t.find(".arrow-bottom").hide(), t.find(".arrow-top").show(), t.off("mouseover"), t.off("mouseout"), e.off("mouseover"), e.off("mouseout")
				},
				fGetDataFromSession: function() {
					var e = this;
					if (window.sessionStorage) {
						var t = sessionStorage.getItem("IndexData");
						if (t) {
							t = JSON.parse(t);
							var i = Yt.render($("#goodsListTpl").html(), t);
							e.putListItem(t), $("#noItem2").remove(), $("#goodsModuleBox").append(i)
						} else $(window).one("scroll", function() {
							e.fGetData()
						});
						setTimeout(function() {
							sessionStorage.removeItem("IndexData")
						}, 3e4)
					} else $(window).one("scroll", function() {
						e.fGetData()
					})
				},
				fGetCheapAndNew: function() {
					var e = this;
					if (window.sessionStorage) {
						var t = sessionStorage.getItem("DiscountData");
						t ? (t = JSON.parse(t), $("#newItemListWrap").html(Yt.render($("#newItemListTpl").html(), t)), $("#discountItemListWrap").html(Yt.render($("#discountItemListTpl").html(), t)), $("#profitListWrap").html(Yt.render($("#profitListTpl").html(), t)), $("#noItem1").remove(), $("#slidesWrap").blockSlides({
							autoPlay: !0,
							wrapWidth: 1188,
							wrapHeight: 309,
							isHideBtn: !1
						}), setTimeout(function() {
							sessionStorage.removeItem("DiscountData")
						}, 3e4)) : e.fGetDiscountList()
					} else e.fGetDiscountList()
				},
				fGetBottomImg: function() {
					var e = this;
					
//					Yt.post(e.basePath + "/admin/item/itemIndexButtomAD.json", {}, function(e) {
//						e.data && e.data.imgUrl && 1 === e.data.isShow && ($("#downImg").attr("src", e.data.imgUrl), $(".down-app").show())
//					}, function() {}, !1)
				},
				fGetDiscountList: function() {
					var e = this;
//					Yt.post(e.basePath + "/admin/item/newDiscountItem.json", {}, function(e) {
//						window.sessionStorage && sessionStorage.setItem("DiscountData", JSON.stringify(e.data)), $("#newItemListWrap").html(Yt.render($("#newItemListTpl").html(), e.data)), $("#discountItemListWrap").html(Yt.render($("#discountItemListTpl").html(), e.data)), $("#profitListWrap").html(Yt.render($("#profitListTpl").html(), e.data)), $("#noItem1").remove()
//					}, function() {
//						$("#slidesWrap").blockSlides({
//							autoPlay: !0,
//							wrapWidth: 1188,
//							wrapHeight: 309,
//							isHideBtn: !1
//						})
//					}, !1)
				},
				fGetData: function() {
					var e = this;
//					Yt.post(e.basePath + "/admin/item/itemIndex.json", {}, function(t) {
//						var i = e.formatData(t),
//							n = Yt.render($("#goodsListTpl").html(), i);
//						e.putListItem(i), $("#noItem2").remove(), $("#goodsModuleBox").append(n), window.sessionStorage && sessionStorage.setItem("IndexData", JSON.stringify(i))
//					}, function() {}, !1)
				},
				formatData: function(e) {
					for (var t = e, i = [], n = "", o = 0; o < e.data.length; o++) {
						n = e.data[o].categoryId.replace(/,/g, ""), e.data[o].identify = n;
						var a = {};
						a.identify = n, a.id = e.data[o].categoryId, a.pic1 = e.data[o].picture1, a.name = e.data[o].categoryName, i.push(a)
					}
					return t.liftList = i, t
				},
				putListItem: function(e) {
					var t = Yt.render($("#liftListTpl").html(), e);
					$("#moduleLiftList").append(t)
				}
			};
			var t = new e;
			t.initPage()
		})
	}, {
		"../../../lib/jquery.cookie.js": 2,
		"../../../lib/jquery.xslider/xslider.js": 3
	}],
	2: [function(e, t, i) {
		(function(e) {
			!
			function(t) {
				"function" == typeof define && define.amd ? define(["jquery"], t) : t("object" == typeof i ? "undefined" != typeof window ? window.$ : "undefined" != typeof e ? e.$ : null : jQuery)
			}(function(e) {
				function t(e) {
					return s.raw ? e : encodeURIComponent(e)
				}
				function i(e) {
					return s.raw ? e : decodeURIComponent(e)
				}
				function n(e) {
					return t(s.json ? JSON.stringify(e) : String(e))
				}
				function o(e) {
					0 === e.indexOf('"') && (e = e.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
					try {
						return e = decodeURIComponent(e.replace(r, " ")), s.json ? JSON.parse(e) : e
					} catch (t) {}
				}
				function a(t, i) {
					var n = s.raw ? t : o(t);
					return e.isFunction(i) ? i(n) : n
				}
				var r = /\+/g,
					s = e.cookie = function(o, r, d) {
						if (void 0 !== r && !e.isFunction(r)) {
							if (d = e.extend({}, s.defaults, d), "number" == typeof d.expires) {
								var c = d.expires,
									f = d.expires = new Date;
								f.setTime(+f + 864e5 * c)
							}
							return document.cookie = [t(o), "=", n(r), d.expires ? "; expires=" + d.expires.toUTCString() : "", d.path ? "; path=" + d.path : "", d.domain ? "; domain=" + d.domain : "", d.secure ? "; secure" : ""].join("")
						}
						for (var l = o ? void 0 : {}, u = document.cookie ? document.cookie.split("; ") : [], p = 0, m = u.length; m > p; p++) {
							var h = u[p].split("="),
								g = i(h.shift()),
								v = h.join("=");
							if (o && o === g) {
								l = a(v, r);
								break
							}
							o || void 0 === (v = a(v)) || (l[g] = v)
						}
						return l
					};
				s.defaults = {}, e.removeCookie = function(t, i) {
					return void 0 === e.cookie(t) ? !1 : (e.cookie(t, "", e.extend({}, i, {
						expires: -1
					})), !e.cookie(t))
				}
			})
		}).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
	}, {}],
	3: [function(e, t, i) {
		!
		function(e) {
			e.fn.Xslider = function(t) {
				function i(e) {
					switch (e = e || "next", r >= c.length && (r = 0), 0 > r && (r = c.length - 1), a.affect) {
					case "scrollx":
						d.width(c.length * c.width());
						var t, i = parseInt(d.find(a.ctag + ":first").attr("data-index"));
						if ("prev" == e) t = -1;
						else if ("next" == e) t = 1;
						else if ("trigger" == e) {
							var i = parseInt(d.find(a.ctag + ":first").attr("data-index"));
							t = r - i
						}
						if (t > 0) d.stop().animate({
							left: -c.width() * t
						}, a.speed, "swing", function() {
							var e = d.find(a.ctag + ":lt(" + t + ")");
							d.append(e), d.css("left", "0");
							var i = d.find(a.ctag + ":first").attr("data-index");
							l.removeClass(a.current).eq(i).addClass(a.current)
						});
						else if (0 > t) {
							var n = d.find(a.ctag + ":gt(" + (c.length - 1 + t) + ")");
							d.prepend(n), d.css("left", c.width() * t), d.stop().animate({
								left: 0
							}, a.speed, "swing", function() {
								var e = d.find(a.ctag + ":first").attr("data-index");
								l.removeClass(a.current).eq(e).addClass(a.current)
							})
						}
						break;
					case "scrolly":
						c.css({
							display: "block"
						});
						var t;
						if ("prev" == e) t = -1;
						else if ("next" == e) t = 1;
						else if ("trigger" == e) {
							var i = parseInt(d.find(a.ctag + ":first").attr("data-index"));
							t = r - i
						}
						if (t >= 0) d.stop().animate({
							top: -c.height() * t
						}, a.speed, "swing", function() {
							var e = d.find(a.ctag + ":lt(" + t + ")");
							d.append(e), d.css("top", "0");
							var i = d.find(a.ctag + ":first").attr("data-index");
							l.removeClass(a.current).eq(i).addClass(a.current)
						});
						else if (0 > t) {
							var n = d.find(a.ctag + ":gt(" + (c.length - 1 + t) + ")");
							d.prepend(n), d.css("top", c.height() * t), d.stop().animate({
								top: 0
							}, a.speed, "swing", function() {
								var e = d.find(a.ctag + ":first").attr("data-index");
								l.removeClass(a.current).eq(e).addClass(a.current)
							})
						}
						break;
					case "fade":
						c.eq(s).stop().animate({
							opacity: 0
						}, a.speed / 2).css("z-index", 1).end().eq(r).css("z-index", 9).stop().animate({
							opacity: 1
						}, a.speed / 2), l.removeClass(a.current).eq(r).addClass(a.current);
						break;
					case "none":
						c.hide().eq(r).show(), l.removeClass(a.current).eq(r).addClass(a.current)
					}
					s = r, r++
				}
				function n() {
					clearInterval(u)
				}
				function o() {
					a.auto && (u = setInterval(i, a.space))
				}
				var a = {
					affect: "scrollx",
					speed: 1200,
					space: 6e3,
					auto: !0,
					trigger: "mouseover",
					conbox: ".conbox",
					ctag: "a",
					switcher: ".switcher",
					stag: "a",
					current: "cur",
					rand: !1
				};
				a = e.extend({}, a, t);
				var r = 1,
					s = 0,
					d = e(this).find(a.conbox),
					c = d.find(a.ctag);
				if (!(c.length < 2)) {
					c.each(function(t, i) {
						e(i).attr("data-index", t)
					});
					var f = e(this).find(a.switcher);
					0 == f.length && (f = e(a.switcher));
					var l = f.find(a.stag);
					if (a.rand && (r = Math.floor(Math.random() * c.length), i()), "fade" == a.affect && e.each(c, function(t, i) {
						e(this).css(0 === t ? {
							position: "absolute",
							"z-index": 9
						} : {
							position: "absolute",
							"z-index": 1,
							opacity: 0
						})
					}), a.auto) var u = setInterval(i, a.space);
					l.bind(a.trigger, function() {
						n(), r = e(this).prevAll(a.stag).length, i("trigger"), o()
					}), f.find(".prev").bind("click", function() {
						n(), r -= 2, i("prev"), o()
					}), f.find(".next").bind("click", function() {
						n(), i("next"), o()
					}), d.hover(n, o)
				}
			}
		}(jQuery)
	}, {}]
}, {}, [1]);