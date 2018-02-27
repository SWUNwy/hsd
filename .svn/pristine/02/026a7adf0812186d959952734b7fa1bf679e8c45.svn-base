$(function() {
	function t() {}
	var e = $("#orderListTable"),
		n = ($("#searchWrapTable"), $("#isHidePay").val(), $("#isHidePrice").val(), $("#hideOsdId").val()),
		i = $("#basePath").val(),
		a = ($(".upload-btn span"), $("#hasNoticeHide"), $(".totalPay"));
	t.prototype = {
		initPae: function() {
			this.eventBind()
		},
		
		orderImport: function() {
			$("#orderImportBtnsWrap").find(".fileupload").change(function() {
				var t = $(this).closest("form"),
					e = $(this).prev();
				t.ajaxSubmit({
					dataType: "json",
					beforeSend: function() {
						e.html("上传中...")
					},
					success: function(t) {
						return t.success === !1 ? (Yt.alert(t.message), void e.html("重新上传")) : ($("#successCount").html(t.successCount), $("#failCount").html(t.failCount), $("#downUrl").attr("href", $("#basePath").val() + t.downUrl), 0 === t.failCount && ($("#downUrl").addClass("d-n"), t.successCount > 0 && $("#import-info-icon").css("color", "#48b349")), $(".import-start-wrapper").addClass("d-n").siblings().removeClass("d-n"), void e.html("添加附件"))
					},
					error: function(t) {
						e.html("上传失败")
					}
				})
			})
		},
		
		eventBind: function() {
			{
				var t = this;				
			}
			
			$("#orderImportBtn").click(function(e) {
				var n = dialog({
					content: $("#orderImportPopTpl").html(),
					title: "订单导入",
					width: 360,
					height: 200,
					fixed: !0,
					okValue: "关&nbsp;&nbsp;闭",
					ok: function() {},
					quickClose: !1
				});
				n.showModal(), t.orderImport()
			})
		}
	};
	var o = new t;
	o.initPae()
});