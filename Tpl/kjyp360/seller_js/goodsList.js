$(function() {
	function e() {
		var e = $(".bc-wrap");
		e.each(function() {
			var e = $(this),
				i = e.find(".J-cb-inner").height();
			e.height() < i ? e.next().show() : e.next().hide()
		})
	}
	$("#labelsSelect");
	e(), $(window).on("resize", function() {
		e()
	}), $("#searchWrap").on("click", ".J-more-link", function() {
		var e = $(this),
			i = e.prev();
		e.hasClass("d-n") ? (e.removeClass("d-n"), i.css("height", i.find(".J-cb-inner").height() - 1 + "px"), e.html('收起<i class="icon iconfont" >&#xe666;</i>')) : (e.addClass("d-n"), i.css("height", "30px"), e.html('更多<i class="icon iconfont" >&#xe615;</i>'))
	}), $(".labelTag").click(function() {
		var e = $(this).attr("value");
		$("#instantActualPrice").html("成本价：" + e)
	});
	var i = $("#goodsListTable"),
		t = $("#hidePrice"),
		a = $("#authHidePrice"),
		n = {
			
			
			
		};
	
	
	
    i.on("click", ".goodsSpec", function() {
    	
		var e = $(this),
			t = e.find(".open-bg");
		if (tr = e.closest("tr"), 0 == t.length) return !1;
		t.hasClass("active") ? (t.removeClass("active"), t.parent().nextAll().hide(), tr.find(".actualPriceTd>div:gt(0)").hide(), tr.find(".vipPriceTd>div:gt(0)").hide(), tr.find(".guidePriceTd>div:gt(0)").hide()) : (t.addClass("active"), t.parent().nextAll().show(), tr.find(".actualPriceTd>div:gt(0)").show(),tr.find(".vipPriceTd>div:gt(0)").show(), tr.find(".guidePriceTd>div:gt(0)").show());
		var a = i.find(".open-icon");
		i.find(".open-bg:not(.no-bg)").length == i.find(".open-bg.active").length && (a.data("open", !0), a.html("&#xe666;")), 0 == i.find(".open-bg.active").length && (a.data("open", !1), a.html("&#xe615;"))
	}), i.on("click", "#openSpec", function() {
		i.find(".open-bg").addClass("active"), i.find(".goodsSpec .hide-row").show(),i.find(".vipPriceTd .hide-row-r").show(), i.find(".actualPriceTd .hide-row-r").show(), i.find(".guidePriceTd .hide-row-r").show(), $(this).addClass("cor-red"), $("#closeSpec").removeClass("cor-red")
	}), i.on("click", "#closeSpec", function() {
	
		i.find(".open-bg").removeClass("active"), i.find(".goodsSpec .hide-row").hide(), i.find(".vipPriceTd .hide-row-r").hide(), i.find(".actualPriceTd .hide-row-r").hide(), i.find(".guidePriceTd .hide-row-r").hide(), $(this).addClass("cor-red"), $("#openSpec").removeClass("cor-red")
	})
});