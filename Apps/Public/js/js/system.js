var Sys = {};

//document.oncontextmenu=new Function("event.returnValue=false");
//
//document.onselectstart=selected;
//function selected(){
//	if (window.event.srcElement.tagName != "INPUT" && window.event.srcElement.tagName != "TEXTAREA"){
//		event.returnValue=false;
//	}
//} 
//
//document.onmousedown=forbidRightButton;
function forbidRightButton(){
  if (event.button==2) {
    //alert('�Բ���,�Ҽ��ֹʹ�ã�');
  }  
}

document.onkeypress = checkKey;
  function checkKey(){
  	//if(event.keyCode == 39){
     	//event.returnValue = false;
    //}
  }
  
  function onlyNumber(){
	//alert(event.keyCode);
  	if(event.keyCode < 48 || event.keyCode>59){
     	event.returnValue = false;
    }
  }

Sys.writeCookie = function(s_name,s_value,i_time){
  	var date = new Date();
   	date.setTime(date.getTime()+i_time*1000);
  	
  	var cookies = escape(s_name) + "=" + escape(s_value)+ "; expires=" + date.toGMTString(); 	
  	document.cookie = cookies;
};
	
Sys.getCookie = function(name) {	
  	var prefix = name + "=";
  	var start = document.cookie.indexOf(prefix);	
  	if (start==-1) {
  		return null;
  	}
  	
  	var end = document.cookie.indexOf(";", start+prefix.length);
  	if (end==-1) {
  		end=document.cookie.length;
  	}
  
  	var value=document.cookie.substring(start+prefix.length, end);
  	return unescape(value);
};

Sys.delCookie = function(name){
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
};
  
  
  var ua = navigator.userAgent.toLowerCase();

  if(!window.ActiveXObject){	
  	Sys.chrome = ua.match(/chrome\/([\d.]+)/);	
  	Sys.firefox = ua.match(/firefox\/([\d.]+)/);
  }

  if (window.ActiveXObject){
      Sys.ie = ua.match(/msie ([\d.]+)/);
  }else if (document.getBoxObjectFor){
      Sys.firefox = ua.match(/firefox\/([\d.]+)/);
  }else if (window.MessageEvent && !document.getBoxObjectFor){
      Sys.chrome = ua.match(/chrome\/([\d.]+)/);
  }else if (window.opera){
      Sys.opera = ua.match(/opera.([\d.]+)/);
  }else if (window.openDatabase){
      Sys.safari = ua.match(/version\/([\d.]+)/);
  }
  
  var isIE8 = false;
  if(navigator.appName == "Microsoft Internet Explorer" 
  	&& navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE8.0"){ 
  	isIE8 = true;
  }  
  
  
  Sys.gotoPage = function(pageNum) {
		var displayLink = $(".pagelinks a:eq(0)");
		if (displayLink) {
			displayLink = displayLink.attr("href");
			var tab=displayLink.replace(/-p=\d+/,"-p="+pageNum);
			var url = displayLink.substring(0, displayLink.length - 1) + pageNum;
			window.location.href=tab;
		}
	}; 
	
