var Yt = Yt || {};
Yt = {
	ajax: function(e) {
		var t = this,
			n = $.extend({
				url: "",
				data: "",
				type: "GET",
				async: !0,
				complete: null,
				success: null,
				fail: null,
				isLayer: !0,
				contentType: "application/x-www-form-urlencoded"
			}, e),
			r = null;
		n.isLayer && (r = setTimeout(function() {
			t.createOLayer()
		}, 600)), typeof n.data != "string" ? n.data = $.extend({
			t: (new Date).getTime()
		}, n.data) : n.data += "&t=" + (new Date).getTime();
		var i = $.ajax({
			type: n.type,
			url: n.url,
			data: n.data,
			async: n.async,
			dataType: "json",
			timeout: 3e4,
			contentType: n.contentType,
			complete: function(e, s) {
				s == "timeout" && (i.abort(), t.alert("网络超时")), n.isLayer && (clearTimeout(r), $("#ajaxLoadingLayer").remove()), n.complete && n.complete()
			},
			success: function(e, r, i) {
				if (!e) return !1;
				e.success ? n.success(e) : n.fail ? n.fail(e) : t.tips('<span class="cor-red">' + e.message + "</span>")
			},
			error: function(e, n, r) {
				if (e.status == "404") return t.tips('<span class="cor-red">网络连接不通或访问地址不存在！</span>'), !1;
				e.status == "401" || e.responseText != null && e.responseText == "_INVALID_POST" ? t.tips("很抱歉,您没有权限访问该页面...") : e.responseText != null && e.responseText == "_NO_LOGIN_SESSION" ? t.tips("很抱歉,登录已经超时,即将跳转到登录页面...", function() {
					window.location.href = "/pub/login/login.do"
				}) : t.tips("很抱歉,提交数据发生了错误,请联系系统管理员...")
			}
		})
	},
	createOLayer: function() {
		if ($("#ajaxLoadingLayer").length == 0) {
			var e = '<div id="ajaxLoadingLayer"><div class="o-layer" ></div><div class="wait-layer" >请稍等,处理中...</div></div>';
			$("body").append($(e))
		}
	},
	get: function(e, t, n) {
		this.ajax({
			url: e,
			data: t,
			type: "GET",
			success: n
		})
	},
	post: function(e, t, n, r, i) {
		this.ajax({
			url: e,
			data: t,
			type: "POST",
			success: n,
			complete: r,
			isLayer: i
		})
	},
	alert: function(e, t, n) {
		n = n || 40;
		var r = dialog({
			title: "温馨提示",
			content: e,
			width: 350,
			height: n,
			fixed: !0,
			okValue: "确定",
			ok: function() {
				t ? t() : r.close().remove()
			}
		});
		r.showModal();
		var i = setTimeout(function() {
			t && t(), r.close().remove(), i = null
		}, 3e3)
	},
	confirm: function(e, t, n) {
		n = n || 40;
		var r = dialog({
			title: "温馨提示",
			content: e,
			width: 350,
			height: n,
			fixed: !0,
			okValue: "确&nbsp;&nbsp;定",
			cancelValue: "取&nbsp;&nbsp;消",
			cancel: function() {
				r.close().remove()
			},
			ok: function() {
				t && t()
			}
		});
		r.showModal()
	},
	confirm1: function(e, t, n) {
		n = n || 40;
		
		var r = dialog({
			title: "温馨提示",
			content: e,
			width: 350,
			height: 100,
			fixed: !0,
			backdropOpacity:1,
			close:false,
			
		});
		r.showModal()
	},
	tips: function(e, t, n) {
		n = n || 2e3;
		var r = dialog({
			content: e
		});
		r.show(), setTimeout(function() {
			t && t(), r.close().remove()
		}, n)
	},
	getBrandCateList: function(e) {
		var t = $.extend({
			wrap: null,
			brandUrl: "",
			cateUrl: "",
			cateData: null,
			goodsUrl: "",
			brandDef: "",
			cateDef: "",
			goodsDef: "",
			isHasGoodsSel: !0,
			dataCallback: function() {}
		}, e || {}),
			n = this,
			r = t.wrap,
			i = r.find("select:eq(0)"),
			s = r.find("select:eq(1)"),
			o = r.find("select:eq(2)"),
			u = "";
		n.generateSelect({
			target: i,
			url: t.cateUrl,
			data: t.cateData,
			defVal: t.cateDef,
			defText: "--请选择类目--",
			chageCallback: function() {
				s.html('<option value="">--请选择品牌--</option>'), o.html('<option value="">--请选择商品--</option>'), n.resetPrice(), n.generateSelect({
					target: s,
					url: t.brandUrl,
					data: {
						cateId: i.val()
					},
					defVal: t.brandDef,
					defText: "--请选择品牌--",
					chageCallback: function() {
						o.html('<option value="">--请选择商品--</option>'), n.resetPrice(), t.isHasGoodsSel && n.generateSelect({
							target: o,
							url: t.goodsUrl,
							data: {
								cateId: i.val(),
								brandId: s.val()
							},
							field: "stock",
							defVal: t.goodsDef,
							defText: "--请选择商品--",
							chageCallback: function(e, n) {
								t.dataCallback.call(o, n), t.brandDef = "", t.goodsDef = "", t.cateDef = ""
							}
						})
					}
				})
			}
		})
	},
	resetPrice: function() {
		$("#specWrap").html('<a class="b-disable-btn">请先选择商品信息</a>'), $("#totalPrice").text("0.00"), $("#singlePrice").text("0.00"), $("#goodsPicUl").html('<li><div class="b-1 w-100px h-100px lh-100px ta-c cor-c">请选择商品信息</div></li>')
	},
	generateSelect: function(e) {
		var t = $.extend({
			target: null,
			url: "",
			data: "",
			displayField: "name",
			field: "",
			defVal: "",
			defText: null,
			isHasChange: !0,
			chageCallback: function() {},
			callback: function() {}
		}, e || {}),
			n = t.target,
			r = null,
			i = "",
			s = "",
			o = this;
		if (!t.target) return !1;
		this.post(t.url, t.data, function(e) {
			i = "", r = e.data, i += '<option value="">' + t.defText + "</option>";
			for (var o = 0; o < r.length; o++) t.field && (s = "data-" + t.field + "=" + r[o][t.field]), i += '<option value="' + r[o].id + '" ' + s + ">" + r[o][t.displayField] + "</option>";
			n.html(i), n.off("change").on("change", function() {
				t.chageCallback(n, r)
			}), t.defVal && setTimeout(function() {
				n.val(t.defVal), t.isHasChange && n.change()
			}, 1), t.callback(n, r)
		})
	},
	formatDate: function(e, t) {
		var n = {
			"M+": e.getMonth() + 1,
			"d+": e.getDate(),
			"h+": e.getHours(),
			"m+": e.getMinutes(),
			"s+": e.getSeconds(),
			"q+": Math.floor((e.getMonth() + 3) / 3),
			S: e.getMilliseconds()
		};
		/(y+)/.test(t) && (t = t.replace(RegExp.$1, (e.getFullYear() + "").substr(4 - RegExp.$1.length)));
		for (var r in n)(new RegExp("(" + r + ")")).test(t) && (t = t.replace(RegExp.$1, RegExp.$1.length == 1 ? n[r] : ("00" + n[r]).substr(("" + n[r]).length)));
		return t
	},
	getDate: function(e) {
		var t = new Date,
			n = t.getTime() + 864e5,
			r = this.formatDate(new Date(n - e * 24 * 60 * 60 * 1e3), "yyyy-MM-dd");
		return r
	},
	checkboxSelectAll: function(e) {
		var t = $(".selectAll");
		e.on("click", ".jt-checkbox", function() {
			e.find(".jt-checkbox").length == e.find(".jt-checkbox:checked").length ? t.prop("checked", !0) : t.prop("checked", !1)
		}), t.on("click", function() {
			e.find(".jt-checkbox").prop("checked", $(this).prop("checked")), t.prop("checked", $(this).prop("checked"))
		})
	}
}, $(function() {
	var e = $("#aboutWrap");
	e.find(".item").hover(function() {
		$(this).find(".item-box").show()
	}, function() {
		$(this).find(".item-box").hide()
	})

	$(".right_cart").click(function() {		
		window.location = "index.php?m=store_cart";
	});
	
});


/* 加入购物车 */
function store_addcart(goods_id,quantity,callbackfunc) {
    if (!quantity) return false;
    var url = 'index.php?m=store_cart&a=add';
    quantity = parseInt(quantity);
    $.getJSON(url, {'goods_id':goods_id, 'quantity':quantity}, function(data) {
        if (data != null) {
            if (data.state) {
            	//showDialog('加入购物车成功',"succ","","1","","去购物车结算","继续购买");
            	showDialog('加入购物车成功 ', 'confirm','',function(){
		              window.location = "index.php?m=store_cart";
	},'','','','<font style="color:#ff0066">查看购物车</font>','继续购物','');

                // 头部加载购物车信息mff="sqde"
                load_cart_info();                
            } else {
                alert(data.msg);
            }
        }
    });
}


//加载购物车信息
function load_cart_info(){
	$.getJSON('index.php?m=cart&a=ajax_load&callback=?', function(result){	   
	    if(result){	 
	       	if(result.cart_goods_num >0){
		        $('.cart_num').html(result.cart_goods_num);		      
	      } else {
	      		 $('.cart_num').html(0);		      
	      }
	   }
	});
}