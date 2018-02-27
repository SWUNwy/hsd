$(function() {
	var a = null;
	var b = null;

	function c() {
		this.tapsBox = $("#tapsBox");
		this.basePath = $("#basePath").val()
	}
	c.prototype = {
		initPage: function() {
			this.getLogisticsDetail();
			this.bindEvent()
		},
		bindEvent: function() {
			var e = this;
			e.tapsBox.on("click", ".tapItem", function() {
				e.tapsBox.find(".tapItem").removeClass("active");
				$(this).addClass("active");
				var f = $(this).attr("data-content");
				$("#" + f).siblings(".tab-content-box").hide();
				$("#" + f).show()
			});
			$("#printorder").click(function() {
				e.checkprint(e.printNow, "打印")
			});
			$("#cusfee input").blur(function() {
				var g = $(this).val();
				if (!g) {
					$(this).removeClass("inputfocus")
				} else {
					if (isNaN(g)) {
						$(this).removeClass("inputfocus");
						$(this).val("");
						var f = dialog({
							content: "请输入正确的金额!",
							align: "left",
							quickClose: true
						});
						f.show(document.getElementById("cusfee"));
						$(this).focus()
					}
				}
			});
			$("#cusfee input").focus(function() {
				$(this).addClass("inputfocus")
			})
		},
		checkprint: function(f, i) {
			var j = this;
			var e = $("#cusfees").val();
			var g = $("#orderPriceCount").val();
			if (!e) {
				var k = dialog({
					content: "请输入实收金额后打印!",
					align: "left",
					quickClose: true
				});
				k.show(document.getElementById("cusfee"));
				return false
			} else {
				var h = parseInt(e);
				$("#realPrice").html(e);
				if (h <= g) {
					this.printTips(f, i);
					return false
				} else {
					j.printTicket()
				}
			}
		},
		printTicket: function() {
			var e = $("#receipt");
			e.find("#realPrice").val($("#cusfees").val());
			e.jqprint()
		},
		printTips: function(e, f) {
			var g = this;
			a = dialog({
				title: "小票打印",
				content: '您输入的实收金额<span style="color:red">小于或等于</span>订单金额,您确认要继续' + f + "吗？",
				okValue: "确定",
				ok: function() {
					g.printTicket()
				},
				cancelValue: "取消",
				cancel: function() {}
			});
			a.showModal();
			$("#cusfees").focus()
		},
		printNow: function() {
			var e = doT.template($("#receiptTpl").html());
			b = getLodop();
			Yt.tips("请稍候,正在打印小票");
			b.SET_PRINT_PAGESIZE(1, 75, 0, "");
			b.ADD_PRINT_HTM("0", "0", "100%", "100%", e({
				realPrice: $("#cusfees").val()
			}));
			b.PRINT();
			a.close()
		},
		printviewNow: function() {
			var e = doT.template($("#receiptTpl").html());
			var f = this;
			b = getLodop();
			Yt.tips("请稍候,正在预览小票");
			b.SET_PRINT_PAGESIZE(1, 75, 0, "");
			b.ADD_PRINT_HTM("0", "0", "100%", "100%", e({
				realPrice: $("#cusfees").val()
			}));
			b.PREVIEW();
			a.close()
		},
		getLogisticsDetail: function() {
			var e = $("#logisticsNum");
			if (!e.val()) {
				return false
			}
	
			var interText = doT.template($("#logisticsDetailTpl").html());
			
			
			$.ajax({
				type: "get",
				url: "index.php?m=store_order&a=get_express",
				data: {
					type: e.attr("data-logisticsType"),
					postid: e.val()
				},
				dataType: "json",
				
				error: function() {
					
					$("#logisticsDetail").html(interText({
						data: [{
							context: "亲，还没有物流信息哦！",
							time: ""
						}]
					}))
				},
				success: function(g) {
					
					var f = doT.template($("#logisticsDetailTpl").html());
					
					$("#logisticsDetail").html(f(g))
				}
			})
		
		}
	};
	var d = new c();
	d.initPage()
});