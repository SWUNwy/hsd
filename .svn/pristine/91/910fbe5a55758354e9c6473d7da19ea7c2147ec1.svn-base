$(function() {
	var e = {
		popDialog: null,
		editPassword: function() {
			this.popDialog.close().remove();
			var e = dialog({
				content: $("#editPasswordTpl").html(),
				title: "密码修改",
				width: 420,
				height: 140,
				fixed: !0,
				okValue: "确&nbsp;&nbsp;定",
				ok: function() {
					var e = "";
					$.trim($("#formerPwd").val()).length == 0 || $.trim($("#formerPwd").val()).length == 0 ? (e = "原密码不能为空！", $("#formerPwd").select()) : $.trim($("#pwd1").val()).length == 0 || $.trim($("#pwd1").val()).length == 0 ? (e = "密码不能为空！", $("#pwd1").select()) : $.trim($("#pwd1").val()).length < 6 || $.trim($("#pwd1").val()).length < 6 ? e = "密码需大于6位！" : $("#pwd1").val() != $("#pwd2").val() ? e = "两次输入的密码不一致！" : $.ajax({
						type: "post",
						url: $("#basePath").val() + "index.php?m=s_center&a=checkPwd",
						data: {
							userPass: $("#formerPwd").val(),
							userPwd2: $("#pwd2").val()
						},
						dataType: "json",
						success: function(t) {
							return t.success ? ($.ajax({
								type: "post",
								url: $("#basePath").val() + "index.php?m=s_center&a=editPwd",
								data: {
									userPass: $("#pwd2").val()
								},
								dataType: "json",
								success: function(e) {
									e.success && Yt.tips("密码修改成功！请重新登录", function() {
										window.location.href = $("#basePath").val() + "index.php?m=s_logout&a=logout"
									})
								}
							}), !0) : (t.message == "0" ? e = "新密码不能跟原密码相同！" : e = "原密码不正确！", Yt.tips(e), $("#pwd1").focus(), !1)
						}
					});
					if (e.length > 0) {
						var t = dialog({
							content: "<span style='color:red'>" + e + "</span>",
							quickClose: !0
						});
						t.show(document.getElementById("password2")), setTimeout(function() {
							t.close().remove()
						}, 2e3)
					}
					return !1
				},
				quickClose: !0
			});
			e.showModal()
		},
		change: function() {
			this.popDialog.close().remove();
			var e = dialog({
				content: $("#changeTpl").html(),
				title: "切换",
				width: 320,
				height: 60,
				fixed: !0,
				okValue: "确&nbsp;&nbsp;定",
				ok: function() {
					var e = "";
					$.trim($("#formerPwd").val()).length == 0 || $.trim($("#formerPwd").val()).length == 0 ? e = "密码不能为空！" : $.ajax({
						type: "post",
						url: $("#basePath").val() + "/shop/index.php?act=seller_center&op=setchange",
						data: {
							userPass: $("#formerPwd").val(),							
						},
						dataType: "json",
						success: function(t) {
							
							
							if(t.success)
							{
								window.location.href =  "/shop/index.php?act=store_quick_order&op=add";
							}
							else							
							{
								e="密码不正确,请重试";
							}
							if (e.length > 0) {
								var t = dialog({
									content: "<span style='color:red'>" + e + "</span>",
									quickClose: !0
								});
								t.show(document.getElementById("password2")), setTimeout(function() {
									t.close().remove()
								}, 2e3)
							}
						}
					});
					
					return !1
				},
				quickClose: !0
			});
			e.showModal()
		},
		configs: function() {
			var e = this,
				t = null;
			e.popDialog = dialog({
				align: "bottom right",
				quickClose: !0,
				padding: 2,
				width: 170,
				content: $("#sysConfigTpl").html()
			}), e.popDialog.show(document.getElementById("setupBtn")), t = $("#configWrap"), t.find("#change").click(function() {
				e.change()
			}),e.popDialog.show(document.getElementById("setupBtn")), t = $("#configWrap"), t.find("#editPasswordBtn").click(function() {
				e.editPassword()
			}), t.find("#setPriceCheckbox").click(function() {
				e.setPriceStutas($(this))
			}), t.find("#loginOutBtn").click(function() {
				Yt.confirm("您确定要退出系统吗？", function() {
					window.location.href = $("#basePath").val() + "index.php?m=s_logout&a=logout"
				})
			})
		},
		setPriceStutas: function(e) {
			var t = 0,
				n = e;
			n.hasClass("active") ? (t = 1, n.removeClass("active"), n.find("i").html("&#xe65e;")) : (t = 0, n.addClass("active"), n.find("i").html("&#xe65d;")), Yt.post($("#basePath").val() + "/admin/user/user/togglePriceInfo.json", {
				hidePriceInfo: t
			}, function(e) {
				window.location.reload()
			})
		}
	};
	$("#sysConfigBtn").click(function() {
		e.configs()
	}), $("#aboutClose").click(function() {
		$("#aboutWrap").hide()
	}), $("#aboutBtn").click(function() {
		$("#aboutWrap").show()
	}), $("#setupBtn").click(function() {
		e.configs()
	})
});