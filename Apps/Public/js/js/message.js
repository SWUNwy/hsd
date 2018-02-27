/**
 * 系统的提示的组件
 * _Message.showMessage:type=1-消息，type=2-错误
 */
var _Message={};
_Message.showMessage=function(type,content,delay){
	Message.showMessage(content);
};
_Message.showError=function(type,content,delay){
	Message.showError(content);
}
var Message={}
Message.showError=function(string){
	$.Zebra_Dialog(string, {
		'width': 450,
		    'type':     'error',
		    'title':    '&#x9519;&#x8BEF;',//utf-8下的编码内容是 ：错误 
		    'custom_class':  'dg_error',
		    'overlay_opacity':0.5,
		    'auto_close': 5000,
		    'position':['center', 'top + 40'],
		    'buttons':  false,
		}); 
}
Message.showMessage=function(string){
	$.Zebra_Dialog(string, {
			'width': 450,
		    'type':     'confirmation',
		    'title':    '&#x63D0;&#x793A;',//utf-8下的编码内容是 ：提示
		    'custom_class':  'dg_error',
		    'overlay_opacity':0.5,
		    'auto_close': 2000,
		    'position':['center', 'top + 40'],
		    'buttons':  false,
		});
}


