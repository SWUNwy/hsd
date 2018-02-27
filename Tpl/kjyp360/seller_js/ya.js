
var Ya = function(e) {
		return {
			globalVar: function() {
				this.GID = 0, this.pageCode = "", this.rpUrl = "", this.globalParams = null, this.yaConfigs = _yaConfigs, /*this.gifPath = "http://ya.hipac.cn/_ut.gif",*/ this.pageRpNo = document.body.getAttribute("data-page-rp") || "0", this.prefixNo = (this.yaConfigs.domainNo || 0) + "." + (this.yaConfigs.projectId || 0), this.doc = document, this.extendFields = this.yaConfigs.extendFields || {}, this.extendFields.open_id = this.getCookie("USER_OPENID") || "", this.hasAttachEvent = !! this.doc.attachEvent, this.listener = this.hasAttachEvent ? "attachEvent" : "addEventListener", this.isHandlerCookie = !1
			},
			isTouch: function() {
				var e = !1;
				return "ontouchend" in document.body && (e = /UCWEB|IEMobile|SymbianOS|BlackBerry|Android|iPhone|iPad|iPod|TouchPad|Windows Phone/i.test(navigator.userAgent)), this.isTouch = function() {
					return e
				}, e
			},
			on: function(e, t, o) {
				e[this.listener]((this.hasAttachEvent ? "on" : "") + t, function(e) {
					e = e || _e.event;
					var t = e.target || e.srcElement;
					o(t, e)
				}, !1)
			},
			getAttribute: function(e, t) {
				return e && e.getAttribute ? e.getAttribute(t) || "" : ""
			},
			getQueryString: function(t) {
				var o = new RegExp("(^|&)" + t + "=([^&]*)(&|$)"),
					i = e.location.search.substr(1).match(o);
				return null != i ? decodeURI(i[2]) : ""
			},
			serialize: function(e) {
				var t, o = [],
					i = function(e, t) {
						return encodeURIComponent(e) + "=" + encodeURIComponent(t)
					};
				for (t in e) o.push(i(t, e[t]));
				return o.join("&").replace(/\%20/g, "+")
			},
			setCookie: function(e, t, o) {
				var i = new Date;
				i.setTime(i.getTime() + 24 * o * 60 * 60 * 1e3);
				var a = "expires=" + i.toUTCString();
				document.cookie = e + "=" + t + "; " + a + "; path=/"
			},
			getCookie: function(e) {
				return (e = document.cookie.match(new RegExp("(?:^|;\\s)" + e + "=(.*?)(?:;\\s|$)"))) ? e[1] : ""
			},
			clearCookie: function(e) {
				this.setCookie(e, "", -1)
			},
			getLocalStorage: function(t) {
				return (e.localStorage ? e.localStorage.getItem(t) : this.getCookie(t)) || ""
			},
			setLocalStorage: function(t, o) {
				o ? e.localStorage ? e.localStorage.setItem(t, o) : this.setCookie(t, o) : e.localStorage ? e.localStorage.removeItem(t) : this.clearCookie(t)
			},
			getWindowParams: function() {
				var t = this;
				try {
					var o, i, a, n, r = e.navigator,
						s = e.screen,
						l = document,
						c = s.width + "x" + s.height,
						u = s.colorDepth + "-bit",
						g = (r.language || r.userLanguage).toLowerCase(),
						h = t.getCookie("JSESSIONID"),
						d = t.getCookie("hipac.cn_USERID") || t.getCookie("USER_USERID") || t.getCookie("_USERID") || t.getCookie("admin.hipac.cn_ADMIN_USERID"),
						p = d && '""' != d ? d : "",
						f = r.javaEnabled() ? 1 : 0,
						m = (new Date).getTimezoneOffset() / 60,
						C = t.getCookie("ya_role_name") || "",
						v = t.getCookie("ya_channel_type") || "",
						R = JSON.stringify(t.extendFields),
						S = {
							uthn: l.domain || "",
							uturl: l.URL || "",
							uttl: l.title || "",
							utfl: "",
							utsr: c,
							utsc: u,
							utcs: g,
							sid: h,
							utuid: p,
							jv: f,
							utp: 0,
							vt: C,
							vs: v,
							tz: m,
							extendFields: R
						};
					if ((o = r.plugins) && (i = o.length)) for (var k = 0; i > k; k++)(a = o[k].description.match(/Shockwave Flash ([\d\.]+) \w*/)) && (S.utfl = a[1]);
					else if (e.ActiveXObject) {
						var b = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
						b && (n = b.GetVariable("$version"), S.utfl = n.replace(/^.*\s+(\d+)\,(\d+).*$/, "$1.$2"))
					}
				} catch (P) {
					return {}
				}
				return this.getWindowParams = function() {
					return S
				}, S
			},
			getRandomString: function() {
				return (new Date).getTime().toString(36) + ++this.GID
			},
			sendRequest: function(e) {
				this.globalParams.utrp = e;
				var t = this.serialize(this.globalParams),
					o = new Image(1, 1);
				o.src = this.gifPath + "?" + t, o.onload = o.onerror = function() {
					o = null
				}
			},
			unloadCount: 0,
			handlerGoPage: function(e, t) {
				if (1 == ++this.unloadCount) {
					var o = this.rpUrl;
					this.queryUrlRp || this.isHandlerCookie || !o || this.setCookie("PREVRPNO", o)
				}
			},
			handlerClickRpNo: function(e, t) {
				var o = this,
					i = o.prefixNo + "." + o.pageRpNo + "." + t + "." + o.pageCode;
				if (o.getAttribute(e, "data-rpgo")) o.isHandlerCookie = !0, o.setCookie("PREVRPNO", i), o.setLocalStorage("ya_pre", o.rpUrl);
				else if (o.isHandlerCookie = !1, "A" == e.tagName.toUpperCase() && o.getAttribute(e, "href")) {
					var a = e.search; - 1 === a.indexOf("rp=") && (-1 === a.indexOf("?") ? e.search += "?rp=" + i : e.search += "&rp=" + i), o.setLocalStorage("ya_pre", o.rpUrl)
				} else o.globalParams.utp = 1, o.globalParams.t = (new Date).getTime(), o.sendRequest(i)
			},
			eventBind: function() {
				var t = this,
					o = t.isTouch() ? "touchstart" : "mousedown";
				t.on(t.doc.body, o, function(e) {
					for (var o; e && "HTML" != e.tagName;) {
						if (o = t.getAttribute(e, "data-rpno")) {
							t.handlerClickRpNo(e, o);
							break
						}
						e = e.parentNode
					}
				}), t.on(e, "beforeunload", function(e, o) {
					t.handlerGoPage(e, o)
				})
			},
			init: function(t) {
				var o = this;
				o.globalVar(), o.globalParams = o.getWindowParams(), o.queryUrlRp = o.getQueryString("rp"), o.rpUrl = o.queryUrlRp || "", o.rpUrl || (document.referrer ? o.rpUrl = o.getCookie("PREVRPNO") || "" : e.localStorage.removeItem("ya_pre")), o.clearCookie("PREVRPNO"), o.globalParams.utrp_url = o.rpUrl, o.globalParams.utrp_pre = o.getLocalStorage("ya_pre"), o.pageCode = o.getRandomString();
				var i = this.prefixNo + "." + this.pageRpNo + ".0.0." + this.pageCode;
				o.sendRequest(i), t || o.eventBind()
			}
		}
	}(window);
_yaConfigs.isNotInit || Ya.init();