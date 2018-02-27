$(function() {
	     $("img.imageLazyLoad").lazyload({
			    placeholder : "images/bg_white.jpg",
			    effect : "fadeIn"
			});

		//菜单
		var currMenu = null; //当前选中的一级菜单
		var iconClass = ""; //当前选中的一级菜单class
		$(".sec-categories").hover(function(){
			$(this).css("display","block");
			$(currMenu).addClass("cat_active "+iconClass+"-hover");
		},function(){
			$(this).hide();
			$(".cat_active").removeClass().addClass(iconClass);
		});
		
		
		$("#navCatsWarp li").hover(function(){
			iconClass = $(this).attr("class");
			$(this).addClass("cat_active "+iconClass+"-hover");
			//子菜单显示
			var subCategoryId =  $(this).attr("rel");
			var $subMenuWrap = $("#categories-subs");
			$("#"+subCategoryId).show();
			$subMenuWrap.css("top",0);
			if($subMenuWrap.height() < ($(this).offset().top-150+$(this).height())){ //如果子菜单底部的高度小于父菜单，则设置子菜单的底部与父菜单底部高度一致
				$subMenuWrap.css("top",($(this).offset().top-150+$(this).height())-$subMenuWrap.outerHeight()); //
			}
			currMenu = this;
		},function(){
			$(this).removeClass("cat_active "+iconClass+"-hover");
			//子菜单隐藏
			$(".sec-categories").hide();
		});
		
		
		//公告滚动
		if($.fn.RollTitle)
		$("#ul_article_lst").RollTitle({line:2,speed:100,timespan:2000});  
		
		//banner切换
		if($.fn.slides)
		$('#slides').slides({
			preload: true,
			preloadImage: '/images/front/loading.gif',
			play: 5000,
			pause: 2500,
			hoverPause: true
		});
		
		/*邮箱验证*/
		$('#a_email').bind('click',function(e){
            var leftpos = (getPosition(this).x - 260) + "px";//计算显示层的位置
            var toppos = (getPosition(this).y ) +"px";
            $('#div_sendEmail').css({ top: toppos ,left: leftpos,position:'absolute'  });//给显示层定义CSS--当前计算出的位置
            $('#div_sendEmail').show();
        }).bind('mouseout',function(){//给对象创建mouseout事件
        	$('#contentips').hide();
        });
		
		$("#btn_resendEmail").click(function(){
			$("#btn_resendEmail").attr("disabled","disabled");
			$.getJSON("reSendEmail.html?rnd="+Math.random(), function(json){
				  var result =  eval("("+json+")");
				  alert(result.message);
				  $("#btn_resendEmail").attr("disabled","");
				  $("#div_sendEmail").hide();
				});
		});
		
	});

function doCategoryOver( iPosition) {
		var iAbosulteTop = 0;
		if ( navigator.userAgent.toLowerCase().indexOf('msie 6') >= 0 )
			iAbosulteTop = 386;
		else
			iAbosulteTop = 387;
		if(iPosition == 1){
			iAbosulteTop = iAbosulteTop - 4;
		}
	
		var iLeft =0;
		var iCWidth = document.documentElement.clientWidth;
		if (iCWidth > 968 )
			iLeft = 180 + (iCWidth - 968)/2 ;
		else
			iLeft = 160;
		document.getElementById("mincatalog" + iPosition).style.top = (iAbosulteTop + 25 * parseInt(iPosition) ) + "px";
		document.getElementById("mincatalog" + iPosition).style.left = (iLeft) + "px";
	  
		document.getElementById("mincatalog" + iPosition).style.display = "block";
		var ua = navigator.userAgent.toLowerCase();   
		var isIE6 = ua.indexOf("msie 6") > -1;//判断是否为IE6 
		//IE6下默认不缓存背景图片，CSS里每次更改图片的位置时都会重新发起请求，用这个方法告诉IE6缓存背景图片   
		if(isIE6){   
		        try{   
		            document.execCommand("BackgroundImageCache", false, true);   
		        }catch(e){}   
		    }  
		document.getElementById("catalog" + iPosition).className = "m_t4_2";
	}
	
	function doCategoryOut( iPosition) {
		document.getElementById("catalog" + iPosition).className = "m_t4_l";
		document.getElementById("mincatalog"+iPosition).style.display ="none";
	}	
	
	function doRegular(iPosition) {
		try {
			for (var i = 4; i < 7 ; i++ ) {
				if (i == iPosition)
					document.getElementById("regular"+i).className = "pro_right2_" + i + "_1";
				else
					document.getElementById("regular"+i).className = "pro_right2_" + i;
			}
		} catch(err) {
			alert(err.msg);
		}
	}	
	function getPosition(el){ 
		for (var lx=0,ly=0;el!=null;lx+=el.offsetLeft,ly+=el.offsetTop,el=el.offsetParent); 
		return {x:lx,y:ly} 
	} 
	var indexgg = 0 ;
	var gzarray = new Array('guize','safeguard');
	function indexshowm(seq){
		if(seq != indexgg){
			document.getElementById("ggao"+indexgg).className="main5";
			document.getElementById(gzarray[indexgg]).style.display="none";
		
			document.getElementById("ggao"+seq).className="main4";
			document.getElementById(gzarray[seq]).style.display="block";
			indexgg = seq;
		}
	}
	
	var indexlocalweek = 0 ;
	function localweekmouse(dex){
		if(dex != indexlocalweek){
			document.getElementById("localweekb"+indexlocalweek).style.display="none";
			document.getElementById("localweeka"+indexlocalweek).style.display="block";
			document.getElementById("localweeka"+dex).style.display="none";
			document.getElementById("localweekb"+dex).style.display="block";
			indexlocalweek = dex;
		}
	}
	var hotitemlist1 = new Array();
	var hotitemlist2 = new Array();
	var hotitemr1 = 0;
	var hotitemr2 = 0;
	function hotmove1(dex,url,hrefurl){
		if(hotitemr1 != dex){
			document.getElementById("hotrp"+hotitemr1).className="products1_right1_3";
			hotitemr1 = dex;
			document.getElementById("hotrp"+hotitemr1).className="products1_right1_4";
		}
		
		document.getElementById("hotrpichref1").href=hrefurl;
		$("#hotrpic1").fadeOut("fast",function(){
			document.getElementById("hotrpic1").src=url;
		   	$("#hotrpic1").fadeIn("fast"); 
		}); 
		
	}
	function hotmove2(dex,url,hrefurl){
		if(hotitemr2 != dex){
			document.getElementById("hotrb"+hotitemr2).className="products1_right1_3";
			hotitemr2 = dex;
			document.getElementById("hotrb"+hotitemr2).className="products1_right1_4";
		}
		document.getElementById("hotrpichref2").href=hrefurl;
		
		$("#hotrpic2").fadeOut("fast",function(){
			document.getElementById("hotrpic2").src=url;
		   	$("#hotrpic2").fadeIn("fast"); 
		}); 
	}
	

	function getname(){
		var imagelist = document.getElementsByTagName("img");
		for(var i = 0; i < imagelist.length; i++){
			if( imagelist[i].attributes['lazy_src'] != null && imagelist[i].attributes['lazy_src'] != 'undefined'){
				imagelist[i].src = imagelist[i].attributes['lazy_src'].nodeValue;
			}
		}
	}
	
	
	var $$ = function (id) {
	return "string" == typeof id ? document.getElementById(id) : id;
};

var Extend = function(destination, source) {
	for (var property in source) {
		destination[property] = source[property];
	}
	return destination;
}

var CurrentStyle = function(element){
	return element.currentStyle || document.defaultView.getComputedStyle(element, null);
}

var Bind = function(object, fun) {
	var args = Array.prototype.slice.call(arguments).slice(2);
	return function() {
		return fun.apply(object, args.concat(Array.prototype.slice.call(arguments)));
	}
}

var Tween = {
	Quart: {
		easeOut: function(t,b,c,d){
			return -c * ((t=t/d-1)*t*t*t - 1) + b;
		}
	},
	Back: {
		easeOut: function(t,b,c,d,s){
			if (s == undefined) s = 1.70158;
			return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
		}
	},
	Bounce: {
		easeOut: function(t,b,c,d){
			if ((t/=d) < (1/2.75)) {
				return c*(7.5625*t*t) + b;
			} else if (t < (2/2.75)) {
				return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
			} else if (t < (2.5/2.75)) {
				return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
			} else {
				return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
			}
		}
	}
}


	//容器对象,滑动对象,切换数量
	var SlideTrans = function(container, slider, count, options) {
		this._slider = $$(slider);
		this._container = $$(container);//容器对象
		this._timer = null;//定时器
		this._count = Math.abs(count);//切换数量
		this._target = 0;//目标值
		this._t = this._b = this._c = 0;//tween参数
		
		this.Index = 0;//当前索引
		
		this.SetOptions(options);
		
		this.Auto = !!this.options.Auto;
		this.Duration = Math.abs(this.options.Duration);
		this.Time = Math.abs(this.options.Time);
		this.Pause = Math.abs(this.options.Pause);
		this.Tween = this.options.Tween;
		this.onStart = this.options.onStart;
		this.onFinish = this.options.onFinish;
		
		var bVertical = !!this.options.Vertical;
		this._css = bVertical ? "top" : "left";//方向
		
		//样式设置
		var p = CurrentStyle(this._container).position;
		p == "relative" || p == "absolute" || (this._container.style.position = "relative");
		this._container.style.overflow = "hidden";
		this._slider.style.position = "absolute";
		
		this.Change = this.options.Change ? this.options.Change :
		this._slider[bVertical ? "offsetHeight" : "offsetWidth"] / this._count;
	};
	SlideTrans.prototype = {
	  //设置默认属性
	  SetOptions: function(options) {
		this.options = {//默认值
			Vertical:	true,//是否垂直方向（方向不能改）
			Auto:		true,//是否自动
			Change:		0,//改变量
			Duration:	30,//滑动持续时间
			Time:		10,//滑动延时
			Pause:		3000,//停顿时间(Auto为true时有效)
			onStart:	function(){},//开始转换时执行
			onFinish:	function(){},//完成转换时执行
			Tween:		Tween.Quart.easeOut//tween算子
		};
		Extend(this.options, options || {});
	  },
	  //开始切换
	  Run: function(index) {
	    //document.getElementById("windw0"+index).className="main4";
		//修正index
		index == undefined && (index = this.Index);
		index < 0 && (index = this._count - 1) || index >= this._count && (index = 0);
		//设置参数
		this._target = -Math.abs(this.Change) * (this.Index = index);
		this._t = 0;
		this._b = parseInt(CurrentStyle(this._slider)[this.options.Vertical ? "top" : "left"]);
		this._c = this._target - this._b;
		
		this.onStart();
		this.Move();
		//this.Alter(index);
	  },
	  //div控制效果
	  Alter: function(index) {
			for(var i = 0; i < 3; i++){
				var test = document.getElementById("windw0"+i);
				if(index == i){
					test.className="main14";
				}else{
					test.className="main13";
				}
			}
	  },
	  //移动
	  Move: function() {
		clearTimeout(this._timer);
		//未到达目标继续移动否则进行下一次滑动
		if (this._c && this._t < this.Duration) {
			this.MoveTo(Math.round(this.Tween(this._t++, this._b, this._c, this.Duration)));
			this._timer = setTimeout(Bind(this, this.Move), this.Time);
		}else{
			this.MoveTo(this._target);
			this.Auto && (this._timer = setTimeout(Bind(this, this.Next), this.Pause));
		}
	  },
	  //移动到
	  MoveTo: function(i) {
		this._slider.style[this._css] = i + "px";
	  },
	  //下一个
	  Next: function() {
		this.Run(++this.Index);
	  },
	  //上一个
	  Previous: function() {
		this.Run(--this.Index);
	  },
	  //停止
	  Stop: function() {
		clearTimeout(this._timer); this.MoveTo(this._target);
	  }
	};
	function piconhover(num){
		for(var i = 0; i < 3; i++){
			var test = document.getElementById("windw0"+i);
			if(test != null && test != undefined){
				if(num == i){
					test.className="main14";
				}else{
					test.className="main13";
				}
			}
		}
		st.Auto = false; st.Run(num);
	}
	
	function piconhoverout(num){
		clearTimeout(timer);
		st.Auto = true; st.Run();
	}
	
	/**
	 * 切换TAB
	 * @param header 切换到的头部
	 * @param cName 需要显示的UL的 className
	 */
	function switchTab(header,cName){
		//切换TAB
		$(header).parent().find(".selected").removeClass("selected"); 
		$(header).addClass("selected");  
		
		//切换内容
		var $tabs = $(header).closest(".tab_container");
		$tabs.find(".tab_content ul").hide();
		$tabs.find("."+cName).show();
	}
