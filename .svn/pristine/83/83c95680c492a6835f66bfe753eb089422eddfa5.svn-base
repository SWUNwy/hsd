<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<meta name="keywords" content="<?php echo $output['setting_config']['site_keywords']; ?>" />
<meta name="description" content="<?php echo $output['setting_config']['site_description']; ?>" />
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_header.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->
<style type="text/css">
body, .header-wrap { background-color: #FAFAFA;}
.wrapper { width: 1000px;}
#faq { display: none;}
.msg { f color: #555; background-color: #FFF; text-align: left; width: 100%;  margin-bottom: 10px; padding: 40px 0;}
.msg i { font-size: 48px; vertical-align: middle; margin-right: 10px;}
.e_box{width:990px; margin:0 auto;}
.e_box .error{width:345px;background:url(<?php echo SHOP_TEMPLATES_URL;?>/images/tip.png) #fff no-repeat;height:170px;padding:55px 0 15px 460px;font-size:12px;overflow:hidden;color:#777;font-family:\5b8b\4f53;margin:20px 0 35px;margin:0 auto;}
.e_box .error h2{font-size:20px;margin-bottom:10px;color:#555;font-family:\5fae\8f6f\96c5\9ed1;font-weight:normal;}
.e_box .error img{display:inline;}
.e_box .error strong{margin:0 2px;font-size:18px;font-family:Verdana, Geneva, sans-serif;}
.e_box .error  a{color:#E4393C;}

</style>
<script>var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var MEMBER_SITE_URL = '<?php echo MEMBER_SITE_URL;?>';var SHOP_RESOURCE_SITE_URL = '<?php echo SHOP_RESOURCE_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js"></script>
<script type="text/javascript">
$(function(){
	$("#details").children('ul').children('li').click(function(){
		$(this).parent().children('li').removeClass("current");
		$(this).addClass("current");
		$('#search_act').attr("value",$(this).attr("m"));
	});
	var search_act = $("#details").find("li[class='current']").attr("m");
	$('#search_act').attr("value",search_act);
	$("#keyword").blur();
});
</script>
</head>
<body>

<div class="header-wrap"><header class="public-head-layout wrapper">
  <h1 class="site-logo"><a href="<?php echo SHOP_SITE_URL;?>"><img  class="pngFix"></a></h1></header></div>
<div class="msg">
      <?php if($output['msg_type'] == 'error'){ ?>
      <i class="icon-info-sign1" style="color: #39C;"></i>
        <?php }else { ?>
      <i class="icon-ok-sign1" style=" color: #099;"></i>
        <?php } ?>
      <div class="e_box">
        <div class="error">
        <h2> <?php require_once($tpl_file);?></h2>
        <div class="error_child">您可以：直接<a href="http://www.kjyp360.com">返回首页</a> 或 等待推荐跳转。</div>
        <div id="ShowDiv">将在<strong><font color="red"> 1 </font></strong>秒后自动返回，请稍候...</div>
				</div>
			</div>        
</div>

<script language="javascript" type="text/javascript">
        var secs =<?php echo $time>0?$time/1000:0;?>; //倒计时的秒数
        var URL ;
        function Load(url){
            URL =url;
            for(var i=secs;i>=0;i--)
            {
                window.setTimeout('doUpdate(' + i + ')', (secs-i) * 1000);
            }
        }
    
        function doUpdate(num)
        {
            document.getElementById("ShowDiv").innerHTML = '将在<strong><font color=red> '+num+' </font></strong>秒后自动返回，请稍候...' ;
            if(num == 0) {
									<?php if (!empty($output['url'])){
									?>
										location.href='<?php echo $output['url'];?>';
									<?php
									}else{
									?>
										history.back();
									<?php
									}?>
							 }
        }
        $(function(){
    		   Load('http://www.kjyp360.com');
        })
  </script>


</body>
</html>
