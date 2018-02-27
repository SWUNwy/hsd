var _item=null;
var _itemAttrs={};
var _skuId=null;
var _warehouseNum=0;
var _initSkuId=null;
_itemAttrs.attrs=new Array();
_itemAttrs.push=function(id,name){
	for(index in _itemAttrs.attrs){
		if(_itemAttrs.attrs[index].id==id){
			return index;
		}
	}
	var itemAttr=new ItemAttr(id,name);
	var t =_itemAttrs.attrs.push(itemAttr);
	return t-1;
};
function ItemSetCookie(id,name,defaultImg){
	this.id=id;
	this.name=name;
	this.defaultImg=defaultImg;
}
var _itemUtil={};
$(function(){
	$("#attr li").hover(function(){
		$(this).addClass("tip-li");
	},function(){
		$(this).removeClass("tip-li");
	});
	$("#attr li").bind("click",clickEven);
});
function clickEven(){
	if(!$(this).hasClass("disable")){
		$(this).parent().prevAll().find("li").removeClass("selected");
		$(this).parent().nextAll().find("li").removeClass("selected");
		$(this).toggleClass("selected");
		var aid=$(this).data("attr-id");
		var sku=_itemUtil.showSku();
		if(sku!=null){
			$("#warn").removeAttr("style");
			$("#attr").removeAttr("style");
			$("#show_price").html("￥ "+number_format(sku.price));
			$("#show_warehouseNum").html(sku.warehouseNum);
			_skuId = sku.skuId;
			_warehouseNum = sku.warehouseNum;
			$("#num_").val(1);
		}else{
			_skuId=null;
			$("#show_warehouseNum").html(_item.warehouseNumCount);
			if(number_format(_item.minPrice) == number_format(_item.maxPrice)){
				$("#show_price").html("￥ "+number_format(_item.maxPrice));
			}else{
				$("#show_price").html("￥ "+number_format(_item.minPrice)+"~"+number_format(_item.maxPrice));
			}
		}
	}
}
/**
 * 查询拥有指定属性的sku列表
 */
_itemUtil.findSkuByAttrs=function(attrValIds){
	var skus=new Array();
	for(skuIndex in _item.sellerItemSku){ 
		var matchlength=0;
		for(skuAttrindex in _item.sellerItemSku[skuIndex].sellerItemSkuAttr){
			for(attrvalIndex in attrValIds){
				if(_item.sellerItemSku[skuIndex].sellerItemSkuAttr[skuAttrindex].attrId==attrValIds[attrvalIndex].attrId&&_item.sellerItemSku[skuIndex].sellerItemSkuAttr[skuAttrindex].arrtOptionId==attrValIds[attrvalIndex].id){
					matchlength++;
				}
			}
		}
		if(matchlength==attrValIds.length){
			skus.push(_item.sellerItemSku[skuIndex]);
		}
	}
	return skus;
};
_itemUtil.showSku=function(){
	var currentAttrs=_itemUtil.getCurrentAttrs();
	var cruuentSelectedAttrIds=_itemUtil.getCurrentSelectedAttrIds();
	var skus=_itemUtil.findSkuByAttrs(cruuentSelectedAttrIds);
	if(skus.length>20){
		skus=skus.slice(0,20)
	}
	$(".sku-attr li:not(.selected)").addClass("disable");
	for(index in skus){
		for(ai in skus[index].sellerItemSkuAttr){
			_itemUtil.showAttrValLi(skus[index].sellerItemSkuAttr[ai]);
		}
		_itemUtil.showOtherSku(skus[index]);
	}
	if(skus.length==1&&cruuentSelectedAttrIds.length==currentAttrs.length){
		return skus[0];
	}else{
		return null;
	}
}
/**
 * 显示其它有库存属性的sku属性
 */
_itemUtil.showOtherSku=function(sku){
	for(ai in sku.sellerItemSkuAttr){
		var attr=new Array();
		for(ai1 in sku.sellerItemSkuAttr){
			if(ai!=ai1){
				attr.push(new ItemAttrVal(sku.sellerItemSkuAttr[ai1].arrtOptionId,sku.sellerItemSkuAttr[ai1].name,sku.sellerItemSkuAttr[ai1].attrId));
			}
		}
		var skus=_itemUtil.findSkuByAttrs(attr);
		for(index in skus){
			for(ai in skus[index].sellerItemSkuAttr){
				_itemUtil.showAttrValLi(skus[index].sellerItemSkuAttr[ai]);
			}
			//_itemUtil.showOtherSku(skus[index]);
		}
	}
}
/**
 * 对指定的属性值id元素进行显示操作
 */
_itemUtil.disableAttrValLi=function(attrvalid){
	$("#attr_"+attrvalid.attrId+"_"+attrvalid.arrtOptionId).addClass("disable");
}
_itemUtil.showAttrValLi=function(attrvalid){
	var $liobj=$("#attr_"+attrvalid.attrId+"_"+attrvalid.arrtOptionId);
	if($liobj.hasClass("disable")){
		$liobj.removeClass("disable");
	}
}
/**
 * 获取当前item的所有销售属性
 * @returns {Array}
 */
_itemUtil.getCurrentAttrs=function(){
	var attrs=new Array();
	$("#attr .sku-attr").each(function(){
		attrs.push($(this).data("attr-id"));
	})
	return attrs;
}
_itemUtil.getCurrentSelectedAttrIds=function(){
	var attrs=new Array();
	$("#attr .sku-attr .selected").each(function(){
		attrs.push(new ItemAttrVal($(this).data("attr-property-id"),"",$(this).data("attr-id")));
	});
	return attrs;
}


/**
 * 初始化左侧菜单栏
 * @param CategoryList
 */
function initcate(CategoryList){
	var cates = null;
	eval('cates='+CategoryList);
	for(var cate in cates){
		$(".nav_cats").append("<li class='icon_CES' rel='categories-sub_"+(parseInt(cate)+1)+"'><a href='finditemcategorybyid.show?categoryid="+cates[cate].id+"&parentId="+cates[cate].id+"'>"+cates[cate].name+"</a></li>");
		var $catesub = null;
		if(cates[cate].child.length>=1){
			$catesub=$("<div id='categories-sub_"+(parseInt(cate)+1)+"' rel='消费电子' class='sec-categories'></div>");
			$catesub.append("<dl class='sub-categories-title'><dl class='sub-categories-title'><dt><a rel='nofollow' href='finditemcategorybyid.show?categoryid="+cates[cate].id+"&parentId="+cates[cate].id+"' class='new-cate-title'>所有&nbsp;"+cates[cate].name+"&nbsp;的子类</dt></dl></div>");
		}
		for(var cate1 in cates[cate].child){
			var $dl=$("<dl></dl>");
			$dl.append("<dt><a href='finditemcategorybyid.show?categoryid="+cates[cate].child[cate1].id+"&parentId="+cates[cate].id+"'>"+cates[cate].child[cate1].name+"</a></dt>");
			var $dd=$("<dd></dd>");
			for(var cate2 in cates[cate].child[cate1].child){
				$dd.append("<a href='finditemcategorybyid.show?categoryid="+cates[cate].child[cate1].child[cate2].id+"&parentId="+cates[cate].id+"' >"+cates[cate].child[cate1].child[cate2].name+"</a>");
			}
			$dl.append($dd);
			$catesub.append($dl);
		}
		$("#categories-subs").append($catesub);
	}
}

function inititem(ItemList){
	var items = null;
	eval('items='+ItemList);
	var temIndex=1;
	for(var item in items){
		if(items[item].sllist!=null && items[item].sllist.length>0){
			var $prolist=$("<div class='pro_list'></div>");
			var $prolist1=$("<div class='pro_list1'></div>");
			var $profloor=$("<div class='pro_floor'></div>");
			$profloor.append("<img src='templates/portal/temp_images/floor"+temIndex+"_44.png' />");
			var $profloor1=$("<div class='profloor1'></div>");
			var $profloor2=$("<div class='profloor2_"+temIndex+"'></div>");
			var $ul=$("<ul></ul>");
			$ul.append("<li style='float:left'><a href='"+_CTX+"/finditemcategorybyid.show?categoryid="+items[item].id+"&parentId="+items[item].id+"'><img src='"+items[item].showImg+"' width='215px' height='277px' title='跨境优品'/></a></li>");
			var $li =$("<li></li>");
			var $pro=$("<div class='pro'></div>");
			var $ul1=$("<ul></ul>");
			
			temIndex++;
		}
		
		for(var item1 in items[item].sllist){
			var $li1=null;
			if(item1>1){
				$li1=$("<li class='pro2'></li>");
			}else{
				$li1=$("<li class='pro1'></li>");
			}
			
			var $protu=$("<div class='pro_tu'></div>");
			//<img title='"+items[item].sllist[item1].countryZhName+"' src='"+items[item].sllist[item1].countryImg+"' />
			$protu.append("<div class='pro_guojia'><img title='"+items[item].sllist[item1].countryZhName+"' width='30' height='22' src='"+_CTX+"/images/country/"+items[item].sllist[item1].countryImg+".jpg'/></div>");
			$protu.append("<a href='finditem.show?iid="+items[item].sllist[item1].id+"'><img title='"+items[item].sllist[item1].name+"-跨境优品' width='170px' height='170px' src='"+items[item].sllist[item1].defaultImg+"' /></a>");
			var $dl=$("<dl></dl>");
			$dl.append("<dt class='pro_name' style='padding:0px 20px;text-overflow:ellipsis; white-space:nowrap; overflow:hidden;'><a href='finditem.show?iid="+items[item].sllist[item1].id+"' title='"+items[item].sllist[item1].name+"' target='_self'>"+items[item].sllist[item1].name+"</a></dt>");
			$dl.append("<dd class='pro_pri'>￥"+number_format(items[item].sllist[item1].marketPrice)+"</dd>");
			$li1.append($protu);
			$li1.append($dl);
			$ul1.append($li1);
		}
		$pro.append($ul1);
		$li.append($pro);
		$ul.append($li);
		$profloor2.append($ul);
		$profloor1.append($profloor2);
		$prolist1.append($profloor);
		$prolist1.append($profloor1);
		$prolist.append($prolist1);
		$("#pro_div").append("<!-- 第"+(parseInt(item)+1)+"楼 -->");
		$("#pro_div").append($prolist);
		
	}
}
/**
 * 初始化整个商品信息
 * @param item
 */
function initOneItem(item){
	eval('_item='+item);
	setOneItemCookie();
	_warehouseNum=_item.warehouseNumCount;
	if(_item.sellerItemSku.length==1){
		_skuId=_item.sellerItemSku[0].skuId;
	}
	for(sku in _item.sellerItemSku){
		_initSkuId = _item.sellerItemSku[sku].skuId;
		for(attr in _item.sellerItemSku[sku].sellerItemSkuAttr){
			var itemAttr_index=_itemAttrs.push(_item.sellerItemSku[sku].sellerItemSkuAttr[attr].attr.id,_item.sellerItemSku[sku].sellerItemSkuAttr[attr].attr.name);
			_itemAttrs.attrs[itemAttr_index].addAttr(new ItemAttrVal(_item.sellerItemSku[sku].sellerItemSkuAttr[attr].arrtOptionId,_item.sellerItemSku[sku].sellerItemSkuAttr[attr].attrValue));
		}
	}
	for(itemAttrs in _itemAttrs.attrs){
		var $attrDiv = $("<div class='sku-attr' ></div>");
		$attrDiv.append(_itemAttrs.attrs[itemAttrs].name+"：");
		var $dl = $("<dl style='float:right;width:480px'></div>");
		for(itemAttrs1 in _itemAttrs.attrs[itemAttrs].attrs){
			var $ul = $("<ul></ul>");
			var $li=$("<li class='se' id='attr_"+_itemAttrs.attrs[itemAttrs].id+"_"+_itemAttrs.attrs[itemAttrs].attrs[itemAttrs1].id+"'>"+_itemAttrs.attrs[itemAttrs].attrs[itemAttrs1].name+"</li>");
			$ul.append($li);
			$li.data("attr-property-id",_itemAttrs.attrs[itemAttrs].attrs[itemAttrs1].id);
			$li.data("attr-id",_itemAttrs.attrs[itemAttrs].id);
			//$li.data("attr-id",);
			$dl.append($ul);
			
		}
		$attrDiv.append($dl);
		$("#attr").append($attrDiv);
		$attrDiv.data("attr-id",_itemAttrs.attrs[itemAttrs].id);
	
	}
}
/**
 * 商品属性实体
 * @param id
 * @param name
 * @returns
 */
function ItemAttr(id,name){
	this.id=id;
	this.name=name;
	this.attrs=new Array();
	this.addAttr=function(attr){
		for(index in this.attrs){
			if(this.attrs[index].id===attr.id){
				return;
			} 
		}
		this.attrs.push(attr);
		
	};
}
function ItemAttrVal(id,name,attrId){
	this.id=id;
	this.name=name;
	this.attrId=attrId;
}
/**
 * 
 * @param selectedVal 代表一个选择的属性值数组
 */
function findSku(selectedVal){
	
}

/**
 * 数量计算是否大于库存数量
 * @param type 1,减号  2,加号  3,数量输入框
 */
function subtotal(type){
	var sumcount=$("#num_").val();
	if(type==1){
		if(sumcount>1){
			$("#num_").val($("#num_").val()-1);
		}
	}else if(type==2){
		if(sumcount>=_warehouseNum){
			return;
		}
		$("#num_").val(parseInt($("#num_").val())+1);
	}else if(type==3){
		if(!/^\+?[1-9][0-9]*$/.test(sumcount)){
			$("#num_").val($("#num_h").val());
			return;
		}
		if(sumcount>_warehouseNum){
			$("#num_").val($("#num_h").val());
			return;
		}
	}
	$("#num_h").val($("#num_").val());
}

/**
 * 商品详情页加入购物车判断
 * @param isnot 立即购买或加入购物车
 */
function toCart(isnot){
	if(_skuId==null){
		$("#warn").attr("style","border:1px solid #00cc99;padding-bottom:25px;margin:10px 0px;margin-left:-15px;float:left");
		$("#attr").attr("style","margin-left:15px");
		return;
	}
	$.ajax({
        type:"POST",
        url:_CTX+"/itemStatus.show",
        data:"skuId="+_skuId,
        success:function(msg){
        	if(msg=="0"){
        		Message.showError("商品已被删除！");
        	}else if(msg=="2"){
        		Message.showError("商品已被下架！");
        	}else if(msg=="1"){
        		 var num = $("#num_h").val();
     			$.ajax({
     	            type:"POST",
     	            url:_CTX+"/itemtocookie.show",
     	            data:"num="+num+"&skuId="+_skuId,
     	            success:function(msg){
     	            	if(msg=="false"){
     	            		Message.showError("加入购物车失败！");
     	            	}else{
     	            		if(isnot==1){
     	            			window.location.href=_CTX+"/cartlist.show";
     	            		}else if(isnot==2){
     	            			var $img=$("<img id='defaultImg' width='30' height='30' src='"+_item.defaultImg+"' />");
     	            			$("#div_defaultImg").append($img);
     	            			var divTop = $img.offset().top;
     	            			var divLeft = $img.offset().left-100;
     	            			$img.css({ "position": "absolute", "z-index": "500", "left": divLeft + "px", "top": divTop + "px" });
     	            			$img.animate({ "left": ($("#collectBox").offset().left - $("#collectBox").width()) + "px", "top": ($(document).scrollTop() + 30) + "px", "width": "30px", "height": "30px" }, 500, function () {
     	            				$img.animate({ "left": $("#collectBox").offset().left + "px", "top": $("#collectBox").offset().top + "px" }, 500).fadeTo(0, 0.1).hide(0);
     	            				$("#cartSpan").html(msg);
     	            			});
     	            			//Message.showError("加入购物车成功！");
     	            		}
     	            	}
     	            }
     		 	});
        	}else if(msg=="3"){
        		Message.showError("预售商品！");
        	}
        }
 	});
}

function number_format(num){
	  num = parseFloat(num); 
	var SUM="";
	var sumFol = num.toFixed(2);
	var sumtotalStr = sumFol;
	var sumEndStr = sumtotalStr.slice(sumtotalStr.indexOf("."));
	var sumStr = sumtotalStr.slice(0,sumtotalStr.indexOf("."));
	if(num.toString().length <= 3) return sumFol;
	if(sumStr.toString().length > 3){
		var count=0;
		if (sumStr.toString().length % 3 == 0) {
	        count = sumStr.toString().length/3;
	    }else{
	        count = (sumStr.toString().length-sumStr.toString().length%3)/3;
	    }
	    var text = "";
	    for(i=0;i<count;i++) {
	        if((count-i-1)*3+sumStr.toString().length%3!=0) {
	            text=","+sumStr.slice((count-i-1)*3+sumStr.toString().length%3,(count-i-1)*3+sumStr.toString().length%3+3)+text;
	        }else {
	            text=sumStr.slice((count-i-1)*3+sumStr.toString().length%3,(count-i-1)*3+sumStr.toString().length%3+3)+text;
	        }
	    }
	    SUM = sumStr.slice(0,sumStr.toString().length % 3)+text+sumEndStr;
	    return SUM;	
	}
	return sumFol ;
}

/**
 * 详情页中的最近浏览
 */
function setOneItemCookie(){
	var history = Sys.getCookie("history");
	var historylist;
	if(history!=null&&history!=""&&history!="undefined"){
		historylist = $.parseJSON(history);
	}
	if(!historylist){
		historylist=new Array();
	}
	
	for(hist in historylist){
		var $histImg = $("<a href='finditem.show?iid="+historylist[hist].id+"'><div style='text-align:center;float:left;width:183px'><img src='"+historylist[hist].defaultImg+"' width='100px' height='100px' id='"+historylist[hist].id+"' title='"+historylist[hist].name+"'/></div></a>");
		$("#history").append($histImg);
	}
	var count=0;
	if(historylist.length>0){
		for(hist in historylist){
			if(historylist[hist].id==_item.id){
				count+=1;
				break;
			}
		}
		if(count==0){
			var item_Object = new ItemSetCookie(_item.id,_item.name,_item.defaultImg);
			historylist.push(item_Object);
		}
	}else{
		var item_Object = new ItemSetCookie(_item.id,_item.name,_item.defaultImg);
		historylist.push(item_Object);
	}
	
	if(historylist.length>3){
		historylist.splice(0,1);
	}
	System.writeCookie("history",$.toJSON(historylist),60*60*24*7);
	
	
}