var zDialog;
//弹出框对象
var ZD = {};
//系统功能对象
var System = {};
var Common = {};
function openDialogUrl(title, width, url,callback) {
	ZD.openDialogDivByUrl(title, width, url,callback);

}
ZD.open = function(title, width, url) {
	ZD.openDialogIframeByUrl(title, width, url);
};
ZD.openDialogDivByInnerHtml=function(htmlContent,title,width,buttons){
	zDialog = new $.Zebra_Dialog(
	htmlContent,		
	{'width' : width,
		'type' : false,
		'overlay_close' : false,
		'title' : title,
		'buttons':false,
		'animation_speed_show':150,
		'position' : [ 'center', 'top+200' ]
	});
	return zDialog;
}

/**
 * 通过url访问直接将内容放到div中，该弹出框内容和页面属于同级
 */
ZD.openDialogDivByUrl = function(title, width, url,callback) {

	zDialog = new $.Zebra_Dialog({
		'source' : {
			'ajax' : url
		},
		'width' : width,
		'type' : false,
		'overlay_close' : false,
		'overlay_opacity' : 0.75,
		'title' : title,
		'buttons' : [ {caption: '确  认', callback:callback },{
			caption : '关  闭', 
			claName : 'default',
			callback : function() {
			}
		} ],
		'position' : [ 'center', 'center' ]

	});
};
/**
 * 通过url将获取到的内容放到iframe中
 */
ZD.openDialogIframeByUrl = function(title, width, url) {
	zDialog = new $.Zebra_Dialog({
		'source' : {
			'iframe' : {
				'src' : url,
				'height' : 420
			}
		},
		'width' : width,
		'type' : false,
		'overlay_close' : false,
		'overlay_opacity' : 0.75,
		'title' : title,
		'buttons' : [ {
			caption : '关闭',
			claName : 'default',
			callback : function() {
			}
		} ],
		'position' : [ 'center', 'center' ]

	});
};
/**
 * 写入cookie
 * @param s_name  cookie名称key
 * @param s_value cookie的值
 * @param s_value cookie有效时间单位“秒”
 */
System.writeCookie = function(s_name,s_value,i_time){
  	var date = new Date();
   	date.setTime(date.getTime()+i_time*1000);
  	
  	var cookies = escape(s_name) + "=" + escape(s_value)+ "; expires=" + date.toGMTString(); 	
  	document.cookie = cookies;
};
/**
 * 获取cookie值
 *  @param name cookie的name值即key
 *  @return 返回一个cookie对应值，如果没有则空
 */	
System.getCookie = function(name) {	
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
/**
 * 删除cookie
 */
System.delCookie = function(name){
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=Sys.getCookie(name);
    
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
};
  
/**
 * 关闭弹出框
 */
ZD.close = function() {
	zDialog.close();
}
/**
 * 去往一个新的url页面
 * @param url
 */
function gotoUrl(url){
	window.location.href=url;
}
/**
 * 选择进出口类型的公共调用方法
 * @param callback 一个功能的回调方法，该方法包含一个参数，1、为进口  2、位出口
 */
Common.selectInOrOut=function(callback){
	  var $html=$("<div><button class='btn btn-warning  btn-lg' style='height:90px;'> <i class='glyphicon glyphicon-import'  ></i> 进口   </button>	<button  class='btn btn-warning  btn-lg' style='height:90px;'>	<i class='glyphicon glyphicon-export'  ></i> 出口     	</button>    </div>");
	  ZD.openDialogDivByInnerHtml($html.html(),"进出口类型确认",300);
	  $(".ZebraDialog_Body button").click(function(){
		  if($(this).find("i").hasClass("glyphicon-import")){
			  callback("I");
		  }else{
			  callback("E");
		  }
	  });

}
/**
 * 顯示box的loading
 */
Common.showBoxLoading=function(boxId){
	$("#"+boxId).append("<div class='overlay'></div><div class='loading-img'></div>");
}
/**
 * 隱藏box的loading
 */
Common.hideBoxLoading=function(BoxId){
	$("#"+BoxId).find(".overlay").remove();
	$("#"+BoxId).find(".loading-img").remove();
}
/**
 * 加载自动完成框
 */
Common.autocompleter=function(selector,data,callback){
	$(selector).autocompleter("destroy");
	$(selector).autocompleter({
        // marker for autocomplete matches
        highlightMatches: true,
        // object to local or url to remote search
        source: data,
        // custom template
        template: '{{ label }} <span>({{ value }})</span>',
        focusOpen:true,
        // show hint
        hint: true,
		defaultShowAll:true,
        // abort source if empty field
        empty: true,

        // max results
        limit: 20,

        callback: function (value, index, selected) {
        	if (selected) {
                callback(value, index, selected);
            }
        }
    });
}
Common.city=function(){
	$(".selcity").change(citychange);
}
function citychange(){
	var selClassStr=$(this).attr("class");
	var url=_CTX+"/common/ajaxregion.show";
	var selindex=parseInt(selClassStr.substring(selClassStr.length-1));
	if($(".city"+(selindex+1))[0]){
		$(".city"+(selindex+1)+" option").remove();
		$(".city"+(selindex+2)).remove();
		$(".city"+(selindex+3)).remove();
		$.getJSON(url+"?pid="+$(this).val(),function(data){
			$(".city"+(selindex+1)).append("<option>--请选择--</option>");
			for(var i in data){
				var $option=$("<option></option>");
				$option.val(data[i].id);
				$option.html(data[i].name);
				$(".city"+(selindex+1)).append($option);
			}
		});
	}else{
		$.getJSON(url+"?pid="+$(this).val(),function(data){
			if(data.length>0){
				var $select=$("<select class='selcity'></select>");
				$select.addClass("city"+(selindex+1));
				$select.append("<option>--请选择--</option>")
				for(var i in data){
					var $option=$("<option></option>");
					$option.val(data[i].id);
					$option.html(data[i].name);
					$select.append($option)
				}
				$select.change(citychange);
				$(".city"+(selindex)).after($select);
			}else{
				$(".city"+selindex).attr("name","region");
			}
		});
	}
	
}
$(function(){
	Common.city();
})
Common.addreddSelect=function(countryId){
	var url=_CTX+"/common/ajaxregion.do";
		$(".province").autocompleter("destroy");
		$(".address-select").val("");
		$(".address-select").attr("disabled","disabled");
		$(".province").removeAttr("disabled");
		var addressResult=new Array();
		//如果未空则默认为 中国142
		if(!countryId){
			ccontryId=142;
		}
		$.getJSON(url+"?pid="+countryId,function(data){
			Common.autocompleter(".province",data,function(value,index,obj){
				addressResult[0]=value;
				$(".city").removeAttr("disabled");
				$(".city").val("");
				$(".district").attr("disabled","disabled");
				$(".district").val("");
				$(".province").val(obj.label);
				$.getJSON(url+"?pid="+value,function(data){
					Common.autocompleter(".city",data,function(value,index,obj){
						addressResult[1]=value;
						$(".city").val(obj.label);
						$(".district").removeAttr("disabled");
						$(".district").val("");
						$.getJSON(url+"?pid="+value,function(data){
							Common.autocompleter(".district",data,function(value,index,obj){
								$(".district").val(obj.label);
								addressResult[2]=value;
								_regionIds=addressResult[0]+"|"+addressResult[1]+"|"+addressResult[2]
							});
						});
					});
				});
			});
		})
}
/**
 * 单个图片添加
 */
Common.uploadImg=function(button,url,callback){
		KindEditor.ready(function(K) {
			Common.editor = K.editor({
				uploadJson :url,
				fieldName : 'imgFile',
				allowFileManager : true
			});
			$("#"+button).click(
					function() {
						Common.editor.loadPlugin('image', function() {
							Common.editor.plugin.imageDialog({
								showRemote : false,
								clickFn:callback
							});
						});
					});
		});
	
}
