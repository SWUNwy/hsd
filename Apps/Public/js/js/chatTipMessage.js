/* *
* 描述： 消息提醒显示
* 备注： 
* 
* */
if(!LIVE){var LIVE = {};};
LIVE.chatTipMessage = function(config){
	this.preferences = {
		companyID: live800_companyID,
		protocol: live800_protocol,
		baseUrl: live800_baseUrl,
		baseWebapp: live800_baseWebApp,
		baseChatHtmlDir: live800_baseChatHtmlDir,
		isMobile: live800_isMobile
	};
	if(typeof config == "object"){
		for(var name in config){
			this.preferences[name] = config[name];
		}
	}
	this.time            = 10000;//对话消息拉取，将会以每10秒钟拉一次对话消息。
	this.companyID       = this.preferences["companyID"];//公司Id
	this.chatTipMsgTimer = null;//消息获取timer
	this.pluginsId = new Date().getTime();//初始化一个插件Id
	this.lastMsgTime = -1;
	this.msgNum = 0;
	this.isMobile = ("1" == this.preferences["isMobile"]);//公司Id
	this.trustInfo = "";
	if(typeof trustfulInfo != "undefined" && trustfulInfo.length > 0
		&& trustfulInfo != null && trustfulInfo != "null"){
		this.trustInfo =  trustfulInfo;
	}
	this.messenger = null;
//	this.init();//初始化入口
};
LIVE.chatTipMessage.prototype = {
	//初始化
	init: function(){
		this.baseUrl         = this.preferences["protocol"] + "//" + this.preferences["baseUrl"];
		this.baseWebapp      = this.baseUrl + this.preferences["baseWebapp"];
		if (this.companyID) {
			this.getUserMsg =  this.baseWebapp + 
				"/ChaterServer?cmd=2013" + 
				"&visitorIDInSession=" + this.companyID + "chater&companyID=" + this.companyID + "&info=" +this.trustInfo;
		}
		this.handleChatTipCookie("0", "0");
		this.chatTipMsgThread(true);
		this.checkChatTipThread();
		if(this.isCurrentPlugins()){
			this.initMessenger();
		}
	},
	initMessenger: function(){
		var that = this;
		var iframeId = "Live800_chatTip_iframe";
		var iframe = document.getElementById(iframeId);
		if(!iframe){
			var iframeURL = this.baseWebapp + "/chatClient/chatTipMsg.jsp?k=1";
			var initChat = LIVE.createNode("iframe",{
				id:iframeId,style:"display:none",src:iframeURL + "&tm=" + new Date().getTime(),name:iframeId,
				allowtransparency:"true",width:"100%",height:"100%",scrolling:"no",marginwidth:"0",
				framespacing:"0",marginheight:"0",frameborder:"0",ondragstart:"return false",onselectstart:"return false",
				onselect:"if(document.selection)document.selection.empty()",oncopy:"document.selection.empty()",
				onbeforecopy:"return false"},"iframe");
			var body = document.getElementsByTagName("body")[0];
			body.appendChild(initChat);
			iframe = document.getElementById(iframeId);
			if(iframe){
				this.messenger = new Messenger('parent',"chatTipMsg");
				this.messenger.addTarget(iframe.contentWindow, 'iframe1');
				this.messenger.listen(function (msg) {
					if(msg&&"close" == msg){
						that.removeTipBox();
					}
				});
			}
		}
	},
	//消息请求线程
	chatTipMsgThread: function(needThread){
		var that = this;
		//没有请求地址，直接返回,即不在进行请求
		if(!this.getUserMsg){
			return;
		}
		var needGetTipMsg = false;
		//如果已经有数据在请求那么久不用请求了,主要是通过检测cookie来决定是否需要走
		if(this.checkCookieForChatTip()){
			needGetTipMsg = true;
		}
		if(needGetTipMsg){
			this.getChatTipMsg();
		}
		if(needThread){
			window.setTimeout(function(){that.chatTipMsgThread(true);} ,that.time);
		}
	},
	//检测cookie信息
	checkChatTipThread: function(){
		var that = this;
		//消息已经查看移除消息框
		var live800_c_s = LIVE.getCookie("live800_c_s");
		if(live800_c_s&&live800_c_s.length>0){
			if(live800_c_s == "-1"){
				this.removeTipBox();
			}else if(live800_c_s == "0"){
				this.closeMessageBox();
			}
		}
		//以下是为了唤醒获取消息的线程
		var chatTipObj = this.getChatTipObj();
		var msgType = "0";
		if(chatTipObj){
			msgType = chatTipObj.msgType;
		}
		this.wakeupChatTipMsgThred();
		this.handleChatTipCookie(msgType);//
		this.needRequestMsg();
		window.setTimeout(function(){that.checkChatTipThread();} ,1000);
	},
	//唤醒消息请求线程
	wakeupChatTipMsgThred: function(){
		var chatTipObj = this.getChatTipObj();
		if(chatTipObj){
			if(chatTipObj.id != this.pluginsId){
				var currentTime = new Date().getTime();
				if((currentTime - chatTipObj.actTime)>5 * 1000){//没有超过5秒就直接返回
					//先将cookie设置为当前线程管理的cookie
					this.setChatTipCookie(chatTipObj.msgType, this.msgNum);
					// 初始化消息接收器
					this.initMessenger();
				}
			}
		}else{
			this.setChatTipCookie("0", this.msgNum);
			// 初始化消息接收器
			this.initMessenger();
		}
	},
	// 处理主要是写cookie： 初始化使用和循环检测使用
	handleChatTipCookie: function(msgType, msgNum){
		var chatTipObj = this.getChatTipObj();
		if(chatTipObj){
			//当Id不一致时 需要判断活动时间，如果活动时间超过5秒钟就修改成当前页面Id
			if(!msgNum){
				msgNum = chatTipObj.msgNum;
			}
			if(chatTipObj.id == this.pluginsId){
				this.setChatTipCookie(msgType, msgNum);
			}
			return;
		}
		if(!msgNum){
			msgNum = 0;
		}
		this.setChatTipCookie(msgType, msgNum);
	},
	// 有新消息时设置cookie
	handleChatTipCookieForNewMsg: function(msgNum){
		var chatTipObj = this.getChatTipObj();
		if(chatTipObj){
			//当Id不一致时 直接返回。 
			if(chatTipObj.id != this.pluginsId){
				return;
			}
		}
		this.setChatTipCookie("1", msgNum);
	},
	//设置cookie信息: msgType:0 没有消息， 1 新消息
	setChatTipCookie: function(msgType, msgNum){
		var chatTipObj = this.getChatTipObj();
		var actTime = new Date().getTime();
		if(!msgType){
			msgType = "0";
		}
		var msgTime = 0;
		if(chatTipObj){
			msgTime = chatTipObj.msgTime;
			if(msgType == "1"){
				msgTime = actTime;
			}
			if(!msgNum){
				msgNum = chatTipObj.msgNum;
			}
		}else{
			if(!msgNum){
				msgNum = 0;
			}
		}
		var value = this.pluginsId + "_" + actTime + "_" + msgType + "_" + msgTime+"_"+msgNum;
		LIVE.setSessionCookie("live800_c_r",value);
	},
	isCurrentPlugins: function(){
		var chatTipObj = this.getChatTipObj();
		if(chatTipObj){
			return this.pluginsId == chatTipObj.id;	
		}
		return true;
	},
	// 获取cookie中对话提示对象
	getChatTipObj: function(){
		var chatTipRecord = LIVE.getCookie("live800_c_r");
		if(chatTipRecord){
			var id = "";//生成当前object id
			var actTime = "";//活动时间
			var msgType = "";//消息类型 0 没有消息， 1 新消息
			var msgTime = "";//消息时间
			var msgNum = 0;//消息条数
			var records = chatTipRecord.split("_");
			if(records){
				if(records.length>0){
					id = records[0];
				}
				if(records.length>1){
					actTime = records[1];
				}
				if(records.length>2){
					msgType = records[2];
				}
				if(records.length>3){
					msgTime = records[3];
				}
				if(records.length>4){
					msgNum = records[4];
				}
			}
			var chatTipObj = {
				id:id,
				actTime:actTime,
				msgType:msgType,
				msgTime:msgTime,
				msgNum:msgNum
			};
			return chatTipObj;
		}
		return null;
	},
	//检测是否需要进行消息获取
	checkCookieForChatTip: function(){
		var chatTipObj = this.getChatTipObj();
		if(chatTipObj){
			// cookie中断Id与当前Id一致则说明当前作为主程序在请求，需要一直访问下去
			if(chatTipObj.id == this.pluginsId){
				return true;
			}
			//不是同一个id, 需要判断当前状态，如果当前状态都是关闭状态，则发送直接返回false 表示不能请求
			var live800_c_s = LIVE.getCookie("live800_c_s");
			if(live800_c_s&&live800_c_s.length>0){
				if(live800_c_s == "-1" || live800_c_s == "0"){
					return false;
				}
			}
			//具有消息 
			if(chatTipObj.msgType == "1"){
				//如果cookie消息数大于当前消息数，则需要进行获取
				if(chatTipObj.msgNum > this.msgNum){
					return true;
				}
			}
		}
		return true;
	},
	//是否需要进行消息请求
	needRequestMsg: function(){
		var chatTipObj = this.getChatTipObj();
		if(chatTipObj){
			// cookie中断Id与当前Id一致就按chatTip的定时请求获取
			if(chatTipObj.id == this.pluginsId){
				return;
			}
			//不是同一个id, 需要判断当前状态，如果当前状态都是关闭状态，则发送直接返回 表示不能请求
			var live800_c_s = LIVE.getCookie("live800_c_s");
			if(live800_c_s&&live800_c_s.length>0){
				if(live800_c_s == "-1" || live800_c_s == "0"){
					return;
				}
			}
			// 具有消息 且非一致，正常的更新了，马上这面就进行更新。 
			if(chatTipObj.msgType == "1"){
				//如果cookie消息数大于当前消息数，则需要进行获取
				if(chatTipObj.msgNum > this.msgNum){
					this.chatTipMsgThread(false);
				}
			}
		}
	},
	//进行消息请求获取消息
	getChatTipMsg: function(){
		var that = this;
		// 请求成功之后的处理
		function completeHandle(pra) {
			if (pra) {
				that.createChatTipMess(pra);
			}
		}
		var offMsgScript = document.getElementById("live800ChatTipScript"); 
		if (offMsgScript) {
			if(offMsgScript.parentNode){
				offMsgScript.parentNode.removeChild(offMsgScript);
			}
		}
		var url = this.getUserMsg + "&t="+new Date().getTime();
		new live800Request(url, function() {
			this.script.setAttribute("id", "live800ChatTipScript");
			var messStr = window.live800ChatTipMsgs;
			completeHandle(messStr);
		}, null, null);
	},
	// 创建离线消息框
	createChatTipMess:function(messJson){
		if(!this.needShow(messJson)){//不需要显示时直接返回
			return;
		}
		var json = messJson;
		if(this.msgNum == json.totalMsgNum){
			return;
		}
		this.removeTipBox();
		this.msgNum = json.totalMsgNum;
		if(this.isMobile){
			this.handleChatTipCookieForNewMsg(this.msgNum);
			this.createMobileMessageBox(json);
		}else{
			this.handleChatTipCookieForNewMsg(this.msgNum);
			this.createPcMessageBox(json);
		}
		LIVE.setSessionCookie("live800_c_s","1");
		
	},
	//创建pc端消息框
	createPcMessageBox: function(messJson){
		var that = this;
		var head = document.getElementsByTagName("head")[0];
		var body = document.getElementsByTagName("body")[0];
		/**
		* 消息框体
		*/
		var messBox = document.getElementById("live800_msg_box");
		var needBodyAppend = false;
		if(!messBox){
			messBox = document.createElement("div");
			messBox.className = "live800_msg_box";
			messBox.setAttribute("id","live800_msg_box");
			
			//设置框体的公共信息
			messBox.innerHTML = "<div class='live800_msg_close'><a href='javascript:void(0);' onClick='LIVE.messageTip.closeMessageBox()'></a></div>"
				+"<div class='live800_msg_jiao'><em></em></div>";
			needBodyAppend = true;
		}
		var listNum = messJson.listNum;
		for(var i=0;i<listNum;i++){
			var tipjson = messJson.list[i];
			var opId = tipjson.operatorId;
			var opName = tipjson.operatorNickName;
			var msgNum = tipjson.msgNum;
			var msgContent = tipjson.lastMsgContent;
			msgContent = msgContent.replace(/<\/p>/ig,"<br/>");// 将所有</p>换成<br/>
			msgContent = msgContent.replace(/<(?!(img)|(a)|(\/a)|(br))[^<>]*>/ig,"");// 去掉除img,a,br之外的所有标签
			msgContent = msgContent.replace(/(<br.{0,2}>)$/ig,"");// 去掉结尾的br{
			var msgTime = tipjson.lastMsgTime;
			var skillId = tipjson.skillId;
			var tipBox = document.getElementById("live800_msg_cont_"+opId);
			if(tipBox){//存在比对一下消息条数是否一致，一致就不处理
				var live800ContentBoxt = document.getElementById("live800_msg_content_"+opId);
				if(live800ContentBoxt){
					var attrMsgNum = live800ContentBoxt.getAttribute("msgNum");
					if(Number(attrMsgNum) == msgNum){
						continue;
					}
				}
			}else{//不存在创建
				tipBox = document.createElement("div");
				tipBox.className = "live800_msg_cont";
				tipBox.setAttribute("id","live800_msg_cont_"+opId);
				tipBox.innerHTML = "<div><span class='live800_msg_name'>"+opName+"</span>"
					+"<span class='live800_msg_time' id='live800_msg_time_"+opId+"'>"+this.timeFormat(msgTime)+"</span></div>"
					+"<div class='live800_msg_content' id='live800_msg_content_"+opId+"' msgNum='"+msgNum+"'>"
					+msgContent
					+"<em>"+msgNum+"</em></div>";
				messBox.appendChild(tipBox);
				this.bind(tipBox,"click",function() {
					var param = that.getParam();
					if (param != "") {
						param = "&" + param;
					}
					if(typeof(jid)=="undefined" || jid=="" || jid==null){
						jid = GetQueryString("jid");
					}
					var openWinURL = that.baseWebapp + that.preferences["baseChatHtmlDir"] 
									+ "/chatbox.jsp?companyID=" +that.companyID +"&jid="+jid +"&sendOperatorId=" + opId;
					if(skillId){
						openWinURL += "&sendSkillId=" + skillId
					}
					openWinURL += param;
					if(that.trustInfo){
						openWinURL += "&info=" + that.trustInfo;
					}
					window.open(openWinURL,"_blank","toolbar=0,scrollbars=0,location=0,menubar=0,resizable=1,width=920,height=620",false);
					that.removeTipBox();
				});
				continue;
			}
			var live800TimeBox = document.getElementById("live800_msg_time_"+opId);
			live800TimeBox.innerHTML = this.timeFormat(msgTime);
			var live800ContentBoxt = document.getElementById("live800_msg_content_"+opId);
			live800ContentBoxt.innerHTML = msgContent+"<em>"+msgNum+"</em></div>";
			live800ContentBoxt.setAttribute("msgNum",msgNum);
		}
		if(needBodyAppend){
			body.appendChild(messBox);
		}
		if(!document.getElementById("live800_tipcss")){
			topCss = document.createElement("link"); // 顶层添加样式表
			topCss.setAttribute("rel", "stylesheet");
			topCss.setAttribute("type", "text/css");
			var cssSrc = this.baseWebapp + "/chatClient/style/off_line.css?2017719";
			topCss.setAttribute("href", cssSrc);
			topCss.setAttribute("id","live800_tipcss");
			head.appendChild(topCss);
		}
	},
	//创建手机的消息框
	createMobileMessageBox:function(messJson){
		var that = this;
		var head = document.getElementsByTagName("head")[0];
		var body = document.getElementsByTagName("body")[0];
		/**
		* 消息框体
		*/
		var messBox = document.getElementById("live800_msg_box");
		var needBodyAppend = false;
		var totalMsgNum = messJson.totalMsgNum;
		if(!messBox){
			messBox = document.createElement("div");
			messBox.className = "live800_mobile_message_box";
			messBox.setAttribute("id","live800_msg_box");
			needBodyAppend = true;
		}
		var tipjson = messJson.list[0];
		var opId = tipjson.operatorId;
		var skillId = tipjson.skillId;
		var param = that.getParam();
		if (param != "") {
			param = "&" + param;
		}
		if(typeof(jid)=="undefined" || jid=="" || jid==null){
			jid = GetQueryString("jid");
		}
		var openWinURL = that.baseWebapp + that.preferences["baseChatHtmlDir"] + "/chatbox.jsp?companyID=" +that.companyID + "&jid="+jid +"&sendOperatorId=" + opId;
		if(skillId){
			openWinURL += "&sendSkillId=" + skillId
		}
		openWinURL += param;
		if(that.trustInfo){
			openWinURL += "&info=" + that.trustInfo;
		}
		//设置框体的公共信息
		messBox.innerHTML = "<a target='_black' href='"+openWinURL+"'><em class='live800_message_num'>"+totalMsgNum+"</em></a>";
		this.bind(messBox,"click",function(){
			that.removeTipBox();
		});
		if(needBodyAppend){
			body.appendChild(messBox);
		}
		if(!document.getElementById("live800_tipcss")){
			topCss = document.createElement("link"); // 顶层添加样式表
			topCss.setAttribute("rel", "stylesheet");
			topCss.setAttribute("type", "text/css");
			var cssSrc = this.baseWebapp + "/chatClient/style/off_line.css?2017719";
			topCss.setAttribute("href", cssSrc);
			topCss.setAttribute("id","live800_tipcss");
			head.appendChild(topCss);
		}
	},
	//移除消息框
	removeTipBox: function(){
		this.closeMessageBox();
		LIVE.setSessionCookie("live800_c_s","-1");
		this.msgNum = 0;
	},
	closeMessageBox: function(){
		var messBox = document.getElementById("live800_msg_box");
		if(messBox){
			if(messBox.parentNode){
				messBox.parentNode.removeChild(messBox);
			}
		}
		this.handleChatTipCookie("0","0");
		LIVE.setSessionCookie("live800_c_s","0");
	},
	// 是否需要显示消息
	needShow: function(messJson){
		if(!messJson){
			return false;
		}
		var needShow = false;
		var json = messJson;
		if(json.code == "0"){//窗口已经关闭
			needShow = true;
			this.time = 5 * 1000;
		}else if(json.code == "5"){//正在对话中
			needShow = false;
			this.time = 5 * 1000;
			this.removeTipBox();
		}else {//还未建立对话
			needShow = false;
			this.time = 30 * 1000;
			this.removeTipBox();
		}
		return needShow;
	},
	//删除HTML标签， 该方法本次未用
	delHtmlTag: function(str){
		if(!str){
			return "";
		}
		str = str.replace(/<[^>]+>/g,"");//去掉所有的html标记
		if(!str){
			str = "";
		}
		return str;
	},
	//绑定事件
	bind: function (el, name, func) {
		if (window.attachEvent) {
			el.attachEvent("on" + name, func);
		} else {
			el.addEventListener(name, func, false);
		}
	},
	//时间格式处理
	timeFormat: function(time){
		var timestamp = parseInt(time);
  		timestamp = isNaN(timestamp) ? 0 : timestamp;
		var today = new Date();
		var curT = today.getTime();// 当前时间戳
		today.setHours(0);
		today.setMinutes(0);
		today.setSeconds(0);
		today.setMilliseconds(0);
		var today0HT = today.getTime();//今天 0点的时间戳
		var timeStr = "";
		if((curT-timestamp)>(curT-today0HT)){
			timeStr = (new Date(timestamp)).format('MM-dd HH:mm:ss');
		}else{
			var date = new Date(timestamp);
			timeStr = date.format('HH:mm:ss');
		}
		return timeStr;
	},
	//获取参数
	getParam: function(){
		var paramUrl = "p=1";
	    var operatorOrSkill = "";
	    var getCookie = LIVE.getCookie;
	    if(typeof live800_policy != "undefined"){
	    	policyId = live800_policy;
	    	paramUrl = paramUrl+"&policyId=" + live800_policy;
	    }
	    var pagereferrinsession = getCookie("pageReferrInSession");
		if (pagereferrinsession == null || pagereferrinsession == " ") {
			pagereferrinsession = "";
		}
		var pagereferrinsession = LIVE.URLEncode(pagereferrinsession);
		if (pagereferrinsession.length >= 1600) {
			pagereferrinsession = pagereferrinsession.substring(0, 1600);
		}
		if(pagereferrinsession!=""){
			paramUrl = paramUrl + "&pagereferrer=" +pagereferrinsession;
		}
		if (typeof live800_defined_params != "undefined"
				&& live800_defined_params.length > 0) {
			paramUrl =paramUrl+ "&" + live800_defined_params;
		}
		if (typeof enterurl == "undefined" || enterurl == "null"){
			enterurl = document.URL;
		}	
		paramUrl = paramUrl + "&enterurl=" + LIVE.URLEncode(enterurl);
		if (typeof plugins != "undefined") {
			paramUrl = paramUrl + "&plugins=" + plugins;
		}
		if (typeof plugins != "undefined") {
			paramUrl = paramUrl + "&plugins=" + plugins;
		}
	    return paramUrl + operatorOrSkill;
	}
};

function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}

window.Messenger=(function(){var prefix="[PROJECT_NAME]",supportPostMessage='postMessage'in window;function Target(target,name,prefix){var errMsg='';if(arguments.length<2){errMsg='target error - target and name are both required'}else if(typeof target!='object'){errMsg='target error - target itself must be window object'}else if(typeof name!='string'){errMsg='target error - target name must be string type'}if(errMsg){throw new Error(errMsg);}this.target=target;this.name=name;this.prefix=prefix}if(supportPostMessage){Target.prototype.send=function(msg){this.target.postMessage(this.prefix+'|'+this.name+'__Messenger__'+msg,'*')}}else{Target.prototype.send=function(msg){var targetFunc=window.navigator[this.prefix+this.name];if(typeof targetFunc=='function'){targetFunc(this.prefix+msg,window)}else{throw new Error("target callback function is not defined");}}}function Messenger(messengerName,projectName){this.targets={};this.name=messengerName;this.listenFunc=[];this.prefix=projectName||prefix;this.initListen()}Messenger.prototype.addTarget=function(target,name){var targetObj=new Target(target,name,this.prefix);this.targets[name]=targetObj};Messenger.prototype.initListen=function(){var self=this;var generalCallback=function(msg){if(typeof msg=='object'&&msg.data){msg=msg.data}var msgPairs=msg.split('__Messenger__');var msg=msgPairs[1];var pairs=msgPairs[0].split('|');var prefix=pairs[0];var name=pairs[1];for(var i=0;i<self.listenFunc.length;i++){if(prefix+name===self.prefix+self.name){self.listenFunc[i](msg)}}};if(supportPostMessage){if('addEventListener'in document){window.addEventListener('message',generalCallback,false)}else if('attachEvent'in document){window.attachEvent('onmessage',generalCallback)}}else{window.navigator[this.prefix+this.name]=generalCallback}};Messenger.prototype.listen=function(callback){var i=0;var len=this.listenFunc.length;var cbIsExist=false;for(;i<len;i++){if(this.listenFunc[i]==callback){cbIsExist=true;break}}if(!cbIsExist){this.listenFunc.push(callback)}};Messenger.prototype.clear=function(){this.listenFunc=[]};Messenger.prototype.send=function(msg){var targets=this.targets,target;for(target in targets){if(targets.hasOwnProperty(target)){targets[target].send(msg)}}};return Messenger})();

/* *
* 设置cookie
* */
LIVE.setSessionCookie=function(name,value){
	document.cookie = name + "="+ escape (value);
};
/* *
* 获取cookie
* */
LIVE.getCookie = function(name){
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    arr = document.cookie.match(reg);
    if (arr) {
        return unescape(arr[2]);
    } else {
        return null;
    }
};

LIVE.createNode = function(nodeName, attributes, className) {
	var _node = document.createElement(nodeName);
	if (className) {
		_node.className = className;
	}
	dd = document.documentElement;
    db = document.body;
    dom = dd || db;
	for ( var name in attributes) { 
		_node.setAttribute(name, attributes[name]);
	}
	return _node;
};

/*
 * 描述：URL编码
 * 备注：
 * @return {string}
 * */
LIVE.URLEncode = function (Str) {
    if (Str == null || Str == "")
        return "";
    var newStr = "";

    function toCase(sStr) {
        return sStr.toString(16).toUpperCase();
    };
    for (var i = 0, icode, len = Str.length; i < len; i++) {
        icode = Str.charCodeAt(i);
        if (icode < 0x10) {
            newStr += "%0" + icode.toString(16).toUpperCase();
        } else if (icode < 0x80) {
            if (icode == 0x20)
                newStr += "+";
            else if ((icode >= 0x30 && icode <= 0x39) || (icode >= 0x41 && icode <= 0x5A) || (icode >= 0x61 && icode <=
                0x7A))
                newStr += Str.charAt(i);
            else
                newStr += "%" + toCase(icode);
        } else if (icode < 0x800) {
            newStr += "%" + toCase(0xC0 + (icode >> 6));
            newStr += "%" + toCase(0x80 + icode % 0x40);
        } else {
            newStr += "%" + toCase(0xE0 + (icode >> 12));
            newStr += "%" + toCase(0x80 + (icode >> 6) % 0x40);
            newStr += "%" + toCase(0x80 + icode % 0x40);
        }
    }
    return newStr;
};
//重写时间格式
Date.prototype.format = function (format) {
	if (format == null) format = "yyyy/MM/dd HH:mm:ss.SSS";
	var year = this.getFullYear();
	var month = this.getMonth();
	var sMonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"][month];
	var date = this.getDate();
	var day = this.getDay();
	var hr = this.getHours();
	var min = this.getMinutes();
	var sec = this.getSeconds();
	var daysInYear = Math.ceil((this - new Date(year, 0, 0)) / 86400000);
	var weekInYear = Math.ceil((daysInYear + new Date(year, 0, 1).getDay()) / 7);
	var weekInMonth = Math.ceil((date + new Date(year, month, 1).getDay()) / 7);
	return format.replace("yyyy", year).replace("yy", year.toString().substr(2)).replace("dd", (date < 10 ? "0" : "") + date).replace("HH", (hr < 10 ? "0" : "") + hr).replace("KK", (hr % 12 < 10 ? "0" : "") + hr % 12).replace("kk", (hr > 0 && hr < 10 ? "0" : "") + (((hr + 23) % 24) + 1)).replace("hh", (hr > 0 && hr < 10 || hr > 12 && hr < 22 ? "0" : "") + (((hr + 11) % 12) + 1)).replace("mm", (min < 10 ? "0" : "") + min).replace("ss", (sec < 10 ? "0" : "") + sec).replace("SSS", this % 1000).replace("a", (hr < 12 ? "AM" : "PM")).replace("w", weekInYear).replace("W", weekInMonth).replace("E", ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][day]).replace("D", daysInYear).replace(/MMMM+/, sMonth).replace("MMM", sMonth.substring(0, 3)).replace("MM", (month < 9 ? "0" : "") + (month + 1)).replace("F", Math.ceil(date / 7));
};

//live800  跨域请求
function live800Request(url, onload, onerror, data) {
	this.url = url;
	this.onload = onload;
	this.onerror = onerror ? onerror : this.defaultError;
	this.data = data;
	if(url){
		this.init(url);
	}
};
live800Request.prototype = {
	init : function(url) {
		this.script = document.createElement("script");
		this.script.setAttribute("type", "text/javascript");
		this.script.setAttribute("src", url);
		document.getElementsByTagName("head")[0].appendChild(this.script); // this.script
		var request = this;
		if (this.script) {
			if (document.all) {
				var script = this.script;
				this.script.onreadystatechange = function() {
					var state = script.readyState;
					if (state == "loaded" || state == "interactive" || state == "complete") {
						request.onload.call(request);
					}
				};
			} else {
				this.script.onload = function() {
					request.onload.call(request);
				};
			}
		} else {
			request.onerror.call(this);
		}
	},
	defaultError : function() {
		alert("create script node fail!");
	}
};
//end
LIVE.messageTip = new LIVE.chatTipMessage();