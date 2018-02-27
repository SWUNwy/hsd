!
function t(e, a, i) {
	function o(c, n) {
		if (!a[c]) {
			if (!e[c]) {
				var r = "function" == typeof require && require;
				if (!n && r) return r(c, !0);
				if (s) return s(c, !0);
				var d = new Error("Cannot find module '" + c + "'");
				throw d.code = "MODULE_NOT_FOUND", d
			}
			var l = a[c] = {
				exports: {}
			};
			e[c][0].call(l.exports, function(t) {
				var a = e[c][1][t];
				return o(a ? a : t)
			}, l, l.exports, t, e, a, i)
		}
		return a[c].exports
	}
	for (var s = "function" == typeof require && require, c = 0; c < i.length; c++) o(i[c]);
	return o
}({
	1: [function(t, e, a) {
		var i = {
			init: function(t, e) {
				var a = this;
				t.on("click", ".reduce-btn", function() {
					a.reduceFunc($(this), t, e)
				}), t.on("click", ".add-btn", function() {
					a.addFunc($(this), t, e)
				}), t.on("change", ".num-input", function() {
					a.changeFunc($(this), t, e)
				})
			},
			reduceFunc: function(t, e, a) {
				if (t.hasClass("cor-9")) return !1;
				var i = t.next(".num-input"),
					o = t.parent().find(".add-btn"),
					s = i.val(),
					c = (e.attr("data-min") || 0) - 0;
				return s = Number(s), c >= s ? !1 : (s--, s === c && t.addClass("cor-9"), o.hasClass("cor-9") && o.removeClass("cor-9"), i.val(s), void a(s))
			},
			addFunc: function(t, e, a) {
				if (t.hasClass("cor-9")) return !1;
				var i = t.prev(".num-input"),
					o = t.parent().find(".reduce-btn"),
					s = i.val(),
					c = (e.attr("data-max") || 0) - 0;
				return s = Number(s), s >= c ? !1 : (s++, s === c && t.addClass("cor-9"), o.hasClass("cor-9") && o.removeClass("cor-9"), i.val(s), void a(s))
			},
			changeFunc: function(t, e, a) {
				var i = t.val(),
					o = e.attr("data-min") - 0,
					s = e.attr("data-max") - 0,
					c = t.parent().find(".add-btn"),
					n = t.parent().find(".reduce-btn");
				c.hasClass("cor-9") && c.removeClass("cor-9"), n.hasClass("cor-9") && n.removeClass("cor-9"), i = Number(i), o >= i && (i = o, t.val(i), n.addClass("cor-9")), i >= s && (i = s, t.val(i), c.addClass("cor-9")), a(i)
			}
		};
		e.exports = i
	}, {}],
	2: [function(t, e, a) {
		e.exports = {
			onAddCart: function(t) {
				var e = this;
				e.dateSelect = $("#dateSelect"), e.itemId = t, e.basePath = $("#basePath").val(), $("#addCartBtn").on("click", function(t) {
					e.addToCart(t)
				})
			},
			addToCart: function(t) {
				var e = this;
				e.specificationsBox = e.specificationsBox || $("#specificationsBox");
				var a = e.specificationsBox.find(".checked-item");
				if (a.length < 1) return void Yt.tips("请选择规格!");
				var i = $("#goodsNum").val();
				if (i > e.stock) return Yt.tips("选择数量不能大于库存总量"), !1;
				var o = a.attr("data-specnum"),
					s = $("#deliveryId").children(".checked-item").attr("data-deliveryType") - 0;
				if (!s) return Yt.tips("请选择配送方式"), !1;
				var c = {
					itemId: e.itemId,
					specNum: o,
					itemCount: i,
					logisticType: s,
					productionDate: e.dateSelect.children(".checked-item").attr("data-date") || ""
				};
				Yt.post(e.basePath + "/admin/cart/putItem2Cart.json", c, function(a) {
					e.bindFly(t)
				})
			},
			userAngent: function() {
				var t = navigator.userAgent,
					e = t.indexOf("Opera") > -1,
					a = t.indexOf("compatible") > -1 && t.indexOf("MSIE") > -1 && !e,
					i = !0;
				if (a) {
					var o, s, c, n, r, d;
					o = s = c = n = r = d = !1;
					var l = new RegExp("MSIE (\\d+\\.\\d+);");
					l.test(t);
					var p = parseFloat(RegExp.$1);
					s = 5.5 === p, c = 6 === p, n = 7 === p, r = 8 === p, d = 9 === p, (s || c || n || r || d) && (i = !1)
				}
				return this.userAngent = function() {
					return i
				}, i
			},
			bindFly: function(t) {
				var e = this,
					a = $("#cartIcon"),
					i = a.offset(),
					o = $("#addCartBtn").offset(),
					s = $(window).scrollTop(),
					c = $("#goodsImgBox .goods-img-small").eq(0).find("img").attr("src"),
					n = $('<img class="flyer-img" src="' + c + '"/>');
				e.userAngent() ? n.fly({
					start: {
						left: o.left + 80,
						top: Number(o.top - s),
						width: 40,
						height: 40
					},
					end: {
						left: i.left,
						top: Number(i.top - s),
						width: 10,
						height: 10
					},
					onEnd: function() {
						this.destroy(), e.addCartSuccess(!0, a)
					}
				}) : e.addCartSuccess(!1, a)
			},
			addCartSuccess: function(t, e) {
				t ? (this.fGetCartNum(e), e.find(".lift-checked").show(), setTimeout(function() {
					e.find(".lift-checked").hide()
				}, 300)) : (this.fGetCartNum(e), e.find(".lift-checked").show(), setTimeout(function() {
					e.find(".lift-checked").hide()
				}, 300))
			},
			fGetCartNum: function(t) {
				var e = this;
				/*
				Yt.post(e.basePath + "/admin/cart/countCartItemNums.json", {}, function(e) {
					$("#cartNumPop").text(e.data), t.find(".lift-checked span").text(e.data), $("#cartAddTip").text(e.data)
				}, null, !1)
				*/
			}
		}
	}, {}],
	3: [function(t, e, a) {
		"use strict";
		e.exports = {
			checkAddress: function(t) {
				var e = $("#selectWrap").find(".areaSelect").val();
				return e ? !0 : (t && Yt.tips("请选择收货地址"), $("#deliveryBoxId").addClass("d-n"), !1)
			},
			checkExpDate: function(t) {
				var e = $("#expiryDateWrap").find(".checked-item");
				return e.length ? !0 : (t && Yt.tips("请选择效期"), !1)
			},
			checkCount: function(t) {
				var e = $("#goodsNum").val();
				return 1 > e ? (t && Yt.tips("选择数量不能小于0"), !1) : !0
			},
			checkSpec: function(t) {
				var e = $("#specificationsBox").find(".checked-item");
				return e.length ? !0 : (t && Yt.tips("请选择规格"), $("#deliveryBoxId").addClass("d-n"), !1)
			},
			checkDelivery: function(t) {
				var e = $("#deliveryId").find(".checked-item");
				return e.length ? !0 : (t && Yt.tips("请选择配送方式"), $("#deliveryBoxId").addClass("d-n"), !1)
			}
		}
	}, {}],
	4: [function(t, e, a) {
		"use strict";
		var i = {
			initVar: function() {
				this.scrollTitleTop = $("#scrollTitle").offset().top, this.goodsInfoTag = $("#goodsInfoTag"), this.goodsDetailTag = $("#goodsDetailTag"), this.goodsFaqTag = $("#goodsFaqTag"), this.goodsInfo = $("#goodsInfo"), this.goodsDetail = $("#goodsDetail"), this.goodsFaq = $("#goodsFaq")
			},
			init: function() {
				var t = this;
				t.initVar(), $(window).on("scroll", function(e) {
					t.scrollChangeTab(e)
				}), t.goodsInfoTag.on("click", function() {
					var e = t.goodsInfo.offset().top;
					$("html, body").animate({
						scrollTop: e - 138
					}, 200)
				}), t.goodsDetailTag.on("click", function() {
					if (t.goodsDetail.length < 1) return !1;
					var e = t.goodsDetail.offset().top;
					$("html, body").animate({
						scrollTop: e - 138
					}, 200)
				}), t.goodsFaqTag.on("click", function() {
					if (t.goodsFaq.length < 1) return !1;
					var e = t.goodsFaq.offset().top;
					$("html, body").animate({
						scrollTop: e - 138
					}, 200)
				}), $(".faq-title").on("click", function() {
					t.onToggleFAQ($(this))
				})
			},
			onToggleFAQ: function(t) {
				t.toggleClass("cor-red"), t.hasClass("cor-red") ? (t.find(".faq-arrow-bottom").hide(), t.find(".faq-arrow-top").show()) : (t.find(".faq-arrow-bottom").show(), t.find(".faq-arrow-top").hide()), t.parent("div").find(".faq-content").slideToggle()
			},
			scrollChangeTab: function(t) {
				t.stopPropagation();
				var e = this,
					a = $("#scrollTitle"),
					i = $("#infoBoxId"),
					o = $(window).scrollTop();
				o > e.scrollTitleTop - 60 ? a.hasClass("scrollFix") || (a.addClass("scrollFix"), i.css("margin-top", "74px")) : a.hasClass("scrollFix") && (a.removeClass("scrollFix"), i.css("margin-top", "0px")), e.goodsDetail.length > 0 && o > e.goodsDetail.offset().top - 500 && o < e.goodsDetail.offset().top + e.goodsDetail.height() - 500 && e.goodsDetailTag.addClass("info-checked").siblings("div").removeClass("info-checked"), e.goodsFaq.length > 0 && o > e.goodsFaq.offset().top - 500 && o < e.goodsFaq.offset().top + e.goodsFaq.height() - 500 && e.goodsFaqTag.addClass("info-checked").siblings("div").removeClass("info-checked"), o > e.goodsInfo.offset().top - 300 && o < e.goodsInfo.offset().top + e.goodsInfo.height() - 300 && e.goodsInfoTag.addClass("info-checked").siblings("div").removeClass("info-checked")
			}
		};
		e.exports = i.init()
	}, {}],
	5: [function(t, e, a) {
		e.exports = {
			goodsImgBig: $("#goodsImgBig"),
			goodsImgBox: $("#goodsImgBox"),
			onImgSwitch: function() {
				var t = this,
					e = t.goodsImgPrev = $("#goodsImgPrev"),
					a = t.goodsImgNext = $("#goodsImgNext"),
					i = t.goodsImgBox.find(".goods-img-small"),
					o = i.length;
				2 > o && a.find(".iconfont").addClass("cor-9"), t.goodsImgBox.on("click", ".goods-img-small", function() {
					var i = $(this),
						s = i.attr("data-id") - 0;
					if (i.hasClass("img-checked")) return !1;
					0 === s ? e.find(".iconfont").addClass("cor-9") : e.find(".iconfont").removeClass("cor-9"), s === o - 1 ? a.find(".iconfont").addClass("cor-9") : a.find(".iconfont").removeClass("cor-9"), i.addClass("img-checked").siblings(".goods-img-small").removeClass("img-checked");
					var c = i.find("img").attr("src");
					t.goodsImgBig.attr("src", c)
				}), e.on("click", function() {
					t.changeImg("prev")
				}), a.on("click", function() {
					t.changeImg("next")
				})
			},
			changeImg: function(t) {
				var e, a, i = this,
					o = $(".img-checked"),
					s = o.attr("data-id") - 0,
					c = $(".goods-img-small").length;
				if ("prev" === t) {
					if (0 === s) return !1;
					1 === s && i.goodsImgPrev.find(".iconfont").addClass("cor-9"), i.goodsImgNext.find(".iconfont").removeClass("cor-9"), c - 1 > s && i.goodsImgBox.animate({
						"margin-left": 90 * -(s - 1) + "px"
					}, 300), o.removeClass("img-checked"), a = o.prev(".goods-img-small"), e = a.find("img").attr("src"), a.addClass("img-checked")
				} else if ("next" === t) {
					if (s === c - 1) return !1;
					s === c - 2 && i.goodsImgNext.find(".iconfont").addClass("cor-9"), i.goodsImgPrev.find(".iconfont").removeClass("cor-9"), s > 1 && i.goodsImgBox.animate({
						"margin-left": 90 * -(s - 1) + "px"
					}, 300), o.removeClass("img-checked"), a = o.next(".goods-img-small"), e = a.find("img").attr("src"), a.addClass("img-checked")
				}
				i.goodsImgBig.attr("src", e)
			}
		}
	}, {}],
	6: [function(t, e, a) {
		var i = t("./_viewImg.js"),
			o = t("./_addCart.js"),
			s = (t("./_imgScroll.js"), t("./_checkData.js")),
			c = t("../../common/numchange/_numChange.js");
		$(function() {
			var t = function() {
					this.basePath = $("#basePath").val(), this.itemId = $("#itemId").val(), this.logisticFee = 0, this.itemType = $("#itemType").val(), this.weight = 0, this.specId = void 0, this.stock = 1e5, this.shopId = $("#shopId").val(), this.flashBuyList = $("#flashBuyList"), this.couponList = $("#couponList"), this.goodsNumIpt = $("#goodsNum"), this.numWrap = $("#numWrap"), this.selectWrap = $("#selectWrap"), this.deliveryFeeCalculateId = "", this.dateSelect = $("#dateSelect"), this.deliveryBox = $("#deliveryBoxId"), this.expiryDateWrap = $("#expiryDateWrap"), this.specificationsBox = $("#specificationsBox"), this.isShowProductionDate = $("#isShowProductionDate").val(), this.isShowProductionDate = "true" === this.isShowProductionDate ? !0 : !1, this.num = 0
				};
			t.prototype = {
				initPage: function() {
					i.onImgSwitch(), this.eventBind(), this.initIsCanBuy()
				},
				eventBind: function() {
					{
						var t = this,
							e = $("#couponList");
						$("#couponListDetail")
					}
					o.onAddCart(t.itemId), e.on("click", "#hides", function() {
						$("#couponListDetail").hide()
					}), e.on("click", "#couponDetail", function() {
						$("#couponListDetail").show()
					}), e.on("click", ".coupon-btn", function() {
						t.getBenefitVolume($(this))
					}), t.numWrap.attr("data-max", t.stock), c.init(t.numWrap, function(e) {
						t.fGetScreenOptions()
					}), $("#buyBtn").on("click", function() {
						t.doBuyAction($(this))
					}), t.deliveryWrap = $("#deliveryId"), t.deliveryWrap.on("click", ".delivery-item", function() {
						t.onClickItem($(this), "delivery")
					}), t.dateSelect.on("click", ".date-item", function() {
						t.onClickItem($(this), "productDate")
					}), $("#expiryDateWrap").on("click", ".expiry-item", function() {
						t.onClickItem($(this), "expDate")
					}), t.specificationsBox.on("click", ".spec-item", function() {
						t.onClickItem($(this), "spec")
					})
				},
				onClickItem: function(t, e) {
					var a = this;
					return t.hasClass("able-item") ? (t.siblings().removeClass("checked-item"), t.hasClass("checked-item") ? t.removeClass("checked-item") : ("2" === a.itemType && t.hasClass("spec-item") && (a.goodsNumIpt.val(1), $("#numAdd").removeClass("cor-9")), t.addClass("checked-item")), void a.fGetScreenOptions(e)) : !1
				},
				initIsCanBuy: function() {
					var t = this,
						e = "true" === $("#isCanBuy").val();
					e ? t.initGeneralData() : ($("#dataWrap").hide(), $("#expiryDateWrap").hide(), $("#deliveryWrap").hide())
				},
				initGeneralData: function() {
					var t = this;
					t.getcouponList(), "2" === t.itemType && t.getFlashBuyList();
					var e = t.selectWrap.attr("data-provId"),
						a = t.selectWrap.attr("data-cityId"),
						i = t.selectWrap.attr("data-areaId");
					t.selectWrap.citySelect({
						url: t.basePath + "/admin/core/area/getchildren.json",
						provDef: e,
						cityDef: a,
						districtDef: i,
						changeCallback: function() {
							this.hasClass("areaSelect") && this.val() ? t.fGetItemProps() : t.onCancelProps()
						}
					}), "2" != t.itemType && t.num++
				},
				fGetItemProps: function() {
					var t = this;
					if (!s.checkAddress(!1)) return !1;
					var e = {
						provinceId: t.selectWrap.find(".provSelect").val(),
						cityId: t.selectWrap.find(".citySelect").val(),
						countryId: t.selectWrap.find(".areaSelect").val(),
						itemId: t.itemId
					};
					Yt.post(t.basePath + "/admin/item/getItemDefault.json", e, function(e) {
						t.formateItemPropsData(e, {
							isGetDelivery: !1
						}), "2" === t.itemType ? s.checkCount(!1) && s.checkSpec(!1) && s.checkDelivery(!1) && t.fGetScreenOptions() : $("#expirySelect div").length ? s.checkSpec(!1) && s.checkExpDate(!1) && t.fGetScreenOptions() : s.checkSpec(!1) && t.fGetScreenOptions()
					})
				},
				formateItemPropsData: function(t, e) {
					var a = this,
						i = {},
						o = void 0,
						s = void 0,
						c = void 0,
						n = void 0;
					if (!t.data.all) return $("#dataWrap").hide(), $("#expiryDateWrap").hide(), $("#specWrap").hide(), $("#countWrap").hide(), $("#deliveryWrap").hide(), a.dealNoSupply(!1), !1;
					t.data.could ? (t.data.could.productionDateVOList && t.data.all.productionDateVOList && (o = a.formartPropsList(e.productionDate || "", t.data.all.productionDateVOList, t.data.could.productionDateVOList, "tranDate")), t.data.could.expDateVOList && t.data.all.expDateVOList && (c = a.formartPropsList(e.showExpDate || "", t.data.all.expDateVOList, t.data.could.expDateVOList, "showExpDate")), t.data.could.logisticTypeList && t.data.all.logisticTypeList && (s = a.formartPropsList(e.deliveryType || "", t.data.all.logisticTypeList, t.data.could.logisticTypeList, "deliveryType")), t.data.could.itemSepcVOList && t.data.all.itemSepcVOList && (n = a.formartPropsList(e.specNum || "", t.data.all.itemSepcVOList, t.data.could.itemSepcVOList, "specNum"))) : (t.data.all.productionDateVOList && t.data.all.productionDateVOList.length && (o = a.formatAllPropsList(t.data.all.productionDateVOList, !1)), t.data.all.expDateVOList && t.data.all.expDateVOList.length && (c = a.formatAllPropsList(t.data.all.expDateVOList, !0)), t.data.all.logisticTypeList && t.data.all.logisticTypeList.length && (s = a.formatAllPropsList(t.data.all.logisticTypeList, !0)), t.data.all.itemSepcVOList && t.data.all.itemSepcVOList.length && (n = a.formatAllPropsList(t.data.all.itemSepcVOList, !0)));
					if (o) {
						i.productDataList = o;
						var r = Yt.render($("#productDateTlp").html(), i);
						$("#dateSelect").html(r)
					}
					if (c) {
						i.expiryDateList = c;
						var d = Yt.render($("#expiryDateListTlp").html(), i);
						$("#expirySelect").html(d)
					}
					if (s) {
						i.deliveryTypeList = s;
						var l = Yt.render($("#deliveryTypeListTpl").html(), i);
						$("#deliveryId").html(l)
					}
					if (n) {
						i.specNumList = n;
						var p = Yt.render($("#specListTpl").html(), i);
						$("#specificationsBox").html(p)
					}
					a.checkIsCanBuy(t)
				},
				formatAllPropsList: function(t, e) {
					if (e && 1 === t.length) {
						var a = t[0];
						a.isChecked = !0, a.isAbled = !0
					} else for (var i = 0; i < t.length; i++) {
						var a = t[i];
						a.isAbled = !0
					}
					return t
				},
				doBuyAction: function(t) {
					var e = this;
					if (!t.hasClass("buy-disable")) {
						if ("1" === e.itemType || "3" === e.itemType) {
							if ($("#expirySelect div").length) {
								if (!s.checkExpDate(!0) || !s.checkSpec(!0)) return !1
							} else if (!s.checkSpec(!0)) return !1
						} else if ("2" === e.itemType && !(s.checkAddress(!0) && s.checkCount(!0) && s.checkSpec(!0) && s.checkDelivery(!0))) return !1;
						return $("#deliveryBoxId").is(":hidden") ? !1 : void e.buyFunction()
					}
				},
				checkIsCanBuy: function(t) {
					var e = this,
						a = $("#dataWrap"),
						i = $("#expiryDateWrap"),
						o = $("#deliveryWrap"),
						s = $("#countWrap"),
						c = $("#specWrap");
					return t.data.all.productionDateVOList && t.data.all.productionDateVOList.length ? a.show() : a.hide(), t.data.all.expDateVOList && t.data.all.expDateVOList.length ? i.show() : i.hide(), t.data.all.itemSepcVOList && t.data.all.itemSepcVOList.length ? (c.show(), s.show(), t.data.all.logisticTypeList && t.data.all.logisticTypeList.length || "2" !== e.itemType ? (o.show(), void e.dealNoSupply(!0)) : (o.hide(), e.dealNoSupply(!1), !1)) : (c.hide(), i.hide(), s.hide(), o.hide(), e.dealNoSupply(!1), !1)
				},
				formartPropsList: function(t, e, a, i) {
					for (var o = [], s = 0; s < e.length; s++) {
						var c = e[s];
						t == c[i] && (c.isChecked = !0);
						for (var n = 0; n < a.length; n++) {
							var r = a[n];
							c[i] == r[i] && (c.isAbled = !0)
						}
						o.push(c)
					}
					return o
				},
				fGetScreenOptions: function(t) {
					var e = this,
						a = e.specificationsBox.find(".checked-item"),
						i = e.goodsNumIpt.val() - 0,
						o = e.selectWrap.find(".areaSelect").val(),
						c = e.deliveryWrap.children(".checked-item").attr("data-deliveryType") || "",
						n = e.dateSelect.children(".checked-item").attr("data-date") || "",
						r = a.attr("data-specnum") || "";
					if (!s.checkAddress(!1)) return !1;
					var d = {
						provinceId: e.selectWrap.find(".provSelect").val(),
						cityId: e.selectWrap.find(".citySelect").val(),
						countryId: o,
						lastSelectOption: t || "",
						itemId: e.itemId,
						specNum: r
					};
					if ("2" === e.itemType) d.productionDateStr = n, d.count = i, d.deliveryType = c;
					else {
						var l = e.expiryDateWrap.find(".checked-item").attr("data-expStartDate"),
							p = e.expiryDateWrap.find(".checked-item").attr("data-expEndDate");
						l && p && (d.startExpDateStr = l, d.endExpDateStr = p), d.count = 1
					}
					Yt.post(e.basePath + "/admin/item/screenOptions.json", d, function(t) {
						var a = e.expiryDateWrap.find(".checked-item").attr("data-showExpDate") || "",
							i = {
								showExpDate: a,
								productionDate: n,
								specNum: r,
								deliveryType: c,
								isGetDelivery: !0
							};
						e.formateItemPropsData(t, i), e.handlePrice(t.data)
					})
				},
				handlePrice: function(t) {
					var e = this,
						a = $("#stockBox"),
						i = e.goodsNumIpt.val() - 0,
						o = (e.deliveryWrap.children(".checked-item").attr("data-deliveryType") || "", e.selectWrap.find(".areaSelect").val(), e.specificationsBox.find(".checked-item")),
						c = o.attr("data-specnum") || 1;
					if ("2" === e.itemType) {
						var n = s.checkAddress() && s.checkCount() && s.checkSpec() && s.checkDelivery();
						if (n) {
							if (t.currentStock < (c - 0) * i) return e.dealNoSupply(!1), !1;
							if (!(t.actualPrice && t.batchSpecId && t.currentStock)) return e.dealNoSupply(!1), !1;
							e.specId = t.batchSpecId, e.logisticFee = t.logisticFee, e.deliveryFeeCalculateId = t.logisticCarryId, e.stock = t.currentStock;
							var r = Math.floor((t.currentStock - 0) / (c - 0));
							a.find("span").text(r), a.show(), e.numWrap.attr("data-max", r), e.fillPriceToPage(t)
						} else $("#stockBox").hide(), e.onCancelProps()
					} else {
						var n = !1;
						if (n = $("#expirySelect div").length ? s.checkAddress() && s.checkSpec() && s.checkExpDate() : s.checkAddress() && s.checkSpec(), n && t.actualPrice) {
							if (t.currentStock < (c - 0) * i) return e.dealNoSupply(!1), !1;
							e.fillPriceToPage(t)
						} else e.onCancelProps()
					}
				},
				fillPriceToPage: function(t) {
					var e = this,
						a = e.specificationsBox.find(".checked-item"),
						i = a.attr("data-specnum") || 1,
						o = e.goodsNumIpt.val() - 0,
						s = $("#totalPraceWrap"),
						c = $("#actualPrice"),
						n = $("#deliveryBoxId");
					if (t.guidePrice && $("#guidePriceWrap").text(((t.guidePrice - 0) / 100).toFixed(2)), "2" === e.itemType) {
						var r = 0;
						t.logisticFee && (r = ((t.logisticFee - 0) / 100).toFixed(2)), c.html(((t.actualPrice - 0) / 100).toFixed(2));
						var d = (t.actualPrice - 0) * o + (t.logisticFee - 0);
						s.find(".J-total-price").text((d / 100).toFixed(2)), $("#deliveryFeeId").html(r);
						var l = (d / o / (i - 0) / 100).toFixed(2);
						s.find(".J-goods-single").text(l)
					} else {
						c.html(((t.actualPrice - 0) / 100).toFixed(2)), s.find(".J-total-price").text(((t.actualPrice - 0) / 100).toFixed(2)), $("#deliveryFeeId").html(0);
						var l = ((t.actualPrice - 0) / (i - 0) / 100).toFixed(2);
						s.find(".J-goods-single").text(l)
					}
					n.removeClass("d-n")
				},
				onCancelProps: function() {
					var t = $("#minActualUnitPrice").val() - 0,
						e = $("#isShowActualPrice").val(),
						a = $("#maxActualUnitPrice").val() - 0,
						i = ($("#actualUnitPriceId"), $("#deliveryBoxId")),
						o = $("#actualPrice");
					i.addClass("d-n"), $("#stockBox").hide(), e && (t && a ? o.text(t === a ? t.toFixed(2) : t.toFixed(2) + "-" + a.toFixed(2)) : $("#noPriceId").text("--"))
				},
				conShow: function() {
					if ($("#couponList .couponWs span").length < 3) {
						var t = $("#couponList .couponWs span:last"),
							e = t.html().replace(/，/, "");
						t.html(e)
					}
					$("#couponList .couponWs span").each(function(t) {
						if (t >= 3 && $(this).hide(), 2 == t) {
							var e = $(this).html().replace(/，/, "");
							$(this).html(e)
						}
					})
				},
				cxShow: function() {
					var t = this;
					"2" === t.itemType && ("0" != t.flashBuyList.attr("data-flag") || "0" != t.couponList.attr("data-flag")) && $("#flashBuyWrap").show(), "2" != t.itemType && "0" != t.couponList.attr("data-flag") && $("#flashBuyWrap").show()
				},
				buyFunction: function() {
					var t, e = this,
						a = $("#goodsNum").val();
					e.deliveryWrap = e.deliveryWrap || $("#deliveryId");
					var i = e.deliveryWrap.children(".checked-item"),
						o = e.expiryDateWrap.find(".checked-item").attr("data-expStartDate"),
						s = e.specificationsBox.find(".checked-item"),
						c = s.attr("data-specnum") || 1;
					if (endExpDateStr = e.expiryDateWrap.find(".checked-item").attr("data-expEndDate"), "2" === e.itemType) {
						var n = {
							url: e.basePath + "/admin/order/generalTradeAddOrder",
							itemId: e.itemId,
							productionDate: e.dateSelect.children(".checked-item").attr("data-date") || "",
							itemSpecId: e.specId,
							specNum: c,
							nums: a,
							logisticType: i.attr("data-deliveryType"),
							logisticFee: e.logisticFee || 0,
							weight: e.weight,
							provAreaId: e.selectWrap.find(".provSelect").val(),
							cityAreaId: e.selectWrap.find(".citySelect").val(),
							areaId: e.selectWrap.find(".areaSelect").val(),
							deliveryFeeCalculateId: e.deliveryFeeCalculateId
						};
						t = Yt.render($("#generalGoodsPost").html(), n)
					} else {
						var n = {
							url: e.basePath + "/admin/order/addOrder.do",
							itemId: e.itemId,
							specNum: c,
							provAreaId: e.selectWrap.find(".provSelect").val(),
							cityAreaId: e.selectWrap.find(".citySelect").val(),
							areaId: e.selectWrap.find(".areaSelect").val(),
							startExpDateStr: o,
							endExpDateStr: endExpDateStr
						};
						t = Yt.render($("#goodsPost").html(), n)
					}
					$(".fixed-container").append(t), $("#goodsForm").submit()
				},
				dealNoSupply: function(t) {
					var e = this,
						a = $("#buyBtn"),
						i = $("#hasSupplyId");
					t ? (i.text("有货"), i.removeClass("cor-red"), a.removeClass("buy-disable"), a.text("立即抢购"), $("#addCartBtn").show(), $(".specifications-checked").length && $("#deliveryId .checked-item").length && e.deliveryBox.removeClass("d-n")) : (e.stock = 0, a.addClass("buy-disable"), a.text("已抢完"), i.text("缺货"), i.addClass("cor-red"), e.deliveryBox.addClass("d-n"), $("#addCartBtn").hide())
				},
				getFlashBuyList: function() {
					var t = this;
					Yt.get(t.basePath + "/admin/item/activityList.json", {
						itemId: t.itemId
					}, function(e) {
						return !e.data || e.data.length < 1 ? (t.flashBuyList.attr("data-flag", "0"), t.num++, 2 == t.num && t.cxShow(), !1) : (t.flashBuyList.html(Yt.render($("#flashBuyTpl").html(), e.data)), t.num++, void(2 == t.num && t.cxShow()))
					})
				},
				getcouponList: function() {
					var t = this;
					Yt.post(t.basePath + "/admin/benefitVolume/couponsForDetail.json", {
						itemId: t.itemId,
						count: 10
					}, function(e) {
						return !e.data || e.data.length < 1 ? (t.couponList.attr("data-flag", "0"), t.num++, 2 == t.num && t.cxShow(), !1) : (t.couponList.html(Yt.render($("#couponListTpl").html(), e.data)), t.num++, 2 == t.num && t.cxShow(), void t.conShow())
					}, function() {}, !1)
				},
				getBenefitVolume: function(t) {
					var e = this,
						a = t.attr("data-id");
					Yt.post(e.basePath + "/admin/benefitVolume/receiveCoupon.json", {
						id: a
					}, function(t) {
						var a = dialog({
							title: "温馨提示",
							content: '<div><p class="ta-c"><i class="iconfont mr-10 cor-green" style="font-size: 18px;">&#xe667;</i>恭喜您！领取成功！</p><p class="mt-20 ta-c"><a href="' + e.basePath + '/admin/benefitVolume/benefitVolumeIndex.do" class="link">查看我的优惠券</a></p></div>',
							width: 350,
							fixed: !0,
							okValue: "确定",
							ok: function() {
								a.close().remove(), e.getcouponList(), $("#couponListDetail").hide()
							}
						});
						a.showModal()
					})
				}
			};
			var e = new t;
			e.initPage()
		})
	}, {
		"../../common/numchange/_numChange.js": 1,
		"./_addCart.js": 2,
		"./_checkData.js": 3,
		"./_imgScroll.js": 4,
		"./_viewImg.js": 5
	}]
}, {}, [6]);