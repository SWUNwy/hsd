// -----------------------------------------------------------------------
// Eros Fratini - eros@recoding.it
// jqprint 0.3
//
// - 19/06/2009 - some new implementations, added Opera support
// - 11/05/2009 - first sketch
//
// Printing plug-in for jQuery, evolution of jPrintArea: http://plugins.jquery.com/project/jPrintArea
// requires jQuery 1.3.x
//
// Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
//------------------------------------------------------------------------

(function(e){var t;e.fn.jqprint=function(n){t=e.extend({},e.fn.jqprint.defaults,n);var r=this instanceof jQuery?this:e(this);if(t.operaSupport&&e.browser.opera){var i=window.open("","jqPrint-preview");i.document.open();var s=i.document}else{var o=e("<iframe  />");t.debug||o.css({position:"absolute",width:"0px",height:"0px",left:"-600px",top:"-600px"}),o.appendTo("body");var s=o[0].contentWindow.document}t.importCSS&&(e("link[media=print]").length>0?e("link[media=print]").each(function(){s.write("<link type='text/css' rel='stylesheet' href='"+e(this).attr("href")+"' media='print' />")}):e("link").each(function(){s.write("<link type='text/css' rel='stylesheet' href='"+e(this).attr("href")+"' />")})),t.printContainer?s.write(r.outer()):r.each(function(){s.write(e(this).html())}),s.close(),(t.operaSupport&&e.browser.opera?i:o[0].contentWindow).focus(),setTimeout(function(){(t.operaSupport&&e.browser.opera?i:o[0].contentWindow).print(),i&&i.close()},1e3)},e.fn.jqprint.defaults={debug:!1,importCSS:!0,printContainer:!0,operaSupport:!0},jQuery.fn.outer=function(){return e(e("<div></div>").html(this.clone())).html()}})(jQuery);