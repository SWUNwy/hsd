<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="renderer" content="webkit">
<meta charset="utf-8">
<title>商家中心</title>
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/common.css" rel="Stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/iconfont.css" rel="Stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/ui-dialog.css" rel="Stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/jquery.ui1.css" rel="Stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/seller_center1.css" rel="stylesheet" type="text/css">
<script>
var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_RESOURCE_SITE_URL = '<?php echo SHOP_RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/dialog-minv6.js" type="text/javascript"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/common.js" type="text/javascript"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/top.js" type="text/javascript"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/yanue.pop.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>

<!--[if lt IE 7]> <script src="<?php echo RESOURCE_SITE_URL;?>/js/correctPNG.js" type="text/javascript"></script> <![endif]-->
<!--[if lt IE 8]>
<script type="text/javascript">
    $("#menu").height($(window).height()-60);
</script>
<![endif]-->



</head>

<body>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ToolTip.js"></script>

<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<!--联系客服-->
<div style="" class="pos-f about-wrap" id="aboutWrap">
  <div class="item por-r">
    <div class="pos-a item-box"> <a target="_blank" href="tencent://message/?uin=3452299387"> <i class="iconfont mr-5"></i> 企业QQ咨询 </a></div>
    <i class="iconfont"></i> </div>
  <div class="item por-r">
    <div class="pos-a item-box item-phone"><i class="iconfont mr-5"></i>400-6727-123</div>
    <i class="iconfont"></i> </div>
  <div class="item por-r right_cart">
    <div class="pos-a item-box item-cart"><i class="iconfont mr-5">&#xe643</i>购物车</div>
    <i class="iconfont">&#xe643</i> </div>
    <p class="cart-add-pop ta-c fs-12 bg-red cor-w d-ib pos-a cart_num" id="cartAddTip"><?php echo $output['cart_goods_num'];?></p>
</div>
<input type="hidden" id="basePath" value="">
<div class="header clearfix bg-red pos-r">
  <div class=" f-l w-200px pl-20" style="width: 255px"> <a href="<?php echo SHOP_SITE_URL;?>"> <img src="<?php echo UPLOAD_SITE_URL.'/seller_center_logo1.jpg'?>" width="255" height="60" class="d-b"> </a> </div>
  <div class=" f-r pt-15 cor-w ta-r ov-f" style="width:300px;height: 45px;">
    <div class="d-ib pl-10 height-30 cor-cs w-120px of-h" title="<?php echo $_SESSION['seller_name'];?>"><?php echo $_SESSION['seller_name'];?></div>
    <div class="d-ib pr-10 height-30 pl-10"> <a href="javascript:void(0)"><i class="iconfont mr-10 cur-p cor-grey5" style="font-size: 18px"></i></a><span>|</span> </div>
    <div class="d-ib height-30 cur-p cor-grey5 mr-20" id="setupBtn"> 设置<i class="icon iconfont ml-5"></i> </div>
  </div>
  <div class="pl-20 pr-10 height-30 pt-15 fs-16 first-menu">
  
    <?php if(!empty($output['menu']) && is_array($output['menu'])) {?>
      <?php foreach($output['menu'] as $key => $menu_value) {?>   
      <span class="mr-40 pos-r d-ib"> <a href="index.php?m=<?php echo $menu_value['child'][key($menu_value['child'])]['m'];?>&a=<?php echo $menu_value['child'][key($menu_value['child'])]['a'];?>" class="cor-w cur-p <?php echo $output['current_menu']['model'] == $key?'active':'';?>"><?php echo $menu_value['name'];?><span>■</span></a> </span>       
      <?php } ?>
      <?php } ?>  
    <input type="hidden" id="xxoo" name="xoxo" value="dt:4 zd:0 bd:false bmd:false">
  </div>
  
  <!--<iframe style="position:absolute;top:0;left:0;z-index:-1;width:100%; height:60px;background:none;" scrolling="no" frameborder="0"></iframe>--> 
</div>
<script id="sysConfigTpl" type="text/tpl">
    <ul id="configWrap">
    <?php if($_SESSION['store_type']==1|| $_SESSION['store_type']==3){ ?>      
        <li id="change" class="height-30 pt-5 pb-5 pl-10 bb-1 cur-p cor-grey6 password-modify " >
            <i class="icon iconfont mr-10 cor-green" style="font-size:18px;">  &#xe65e; </i><?php echo $_SESSION['is_quick']==1?"商家中心":"快速代下单"?>
        </li>
        <?php }?>
        <li id="editPasswordBtn" class="height-30 pt-5 pb-5 pl-10 bb-1 cur-p cor-grey6 password-modify"><i class="icon iconfont mr-10 cor-green" style="font-size:18px;">&#xe650;</i>修改密码</li>
      
        <li id="loginOutBtn" class="height-30 pt-5 pb-5 pl-10 cur-p cor-grey6 login-out"><i class="icon iconfont mr-10 cor-cs" style="font-size:18px;">&#xe6d8;</i>退出</li>
    </ul>
</script> 

<!--切换商家-->
<script id="changeTpl" type="text/tpl">
    <div id="editPasswordWrap">
        <table>
            <tr>
                <td class="pb-10">密码：</td>
                <td class="pb-10">
                    <input class="ipt" type="password" id="formerPwd" name="formerPwd" />
                </td>
            </tr>
            
        </table>
    <div>
</script>



<!--修改密码--> 
<script id="editPasswordTpl" type="text/tpl">
    <div id="editPasswordWrap">
        <table>
            <tr>
                <td class="pb-10">原密码：</td>
                <td class="pb-10">
                    <input class="ipt" type="password" id="formerPwd" name="formerPwd" />
                </td>
            </tr>
            <tr>
                <td class="pb-10">新密码：</td>
                <td class="pb-10"><input class="ipt" type="password" id="pwd1"/></td>
            </tr>
            <tr>
                <td id="password2" class="pb-10">重复密码：</td>
                <td class="pb-10"><input class="ipt" type="password" id="pwd2" /></td>
            </tr>
        </table>
    <div>
</script>
<div class="content cf" id="con-container">
  <div class="side h-100 br-1" id="menu">
  
  
  <?php if(!$output['seller_layout_no_menu']) { ?>
    <?php if($output['current_menu']['model_name']=="店铺")  {?>
    <h4 class="bt-1"><i class="icon iconfont">&#xe627;</i><?php echo $output['current_menu']['model_name'];?>相关</h4>
   <?php }else if($output['current_menu']['model_name']=="订单"){?>
    <h4 class="bt-1"><i class="icon iconfont">&#xe684;</i><?php echo $output['current_menu']['model_name'];?></h4>
   <?php }else if($output['current_menu']['model_name']=="商品"){?>
    <h4 class="bt-1"><i class="icon iconfont">&#xe659;</i><?php echo $output['current_menu']['model_name'];?></h4>
    <?php }else if($output['current_menu']['model_name']=="数据"){?>
    <h4 class="bt-1"><i class="icon iconfont">&#xe6a1;</i><?php echo $output['current_menu']['model_name'];?></h4>
   <?php }else{ ?>
   <h4 class="bt-1"><i class="icon iconfont">&#xe659;</i><?php echo $output['current_menu']['model_name'];?></h4>
   <?php } ?>
    <ul>   
          <?php if(!empty($output['left_menu']) && is_array($output['left_menu'])) {?>
          <?php foreach($output['left_menu'] as $submenu_value) {?>
            
           <?php if($_GET['m']=="store_member"  || $_GET['m']=="store_commision" || $_GET['m']=="store_order") {?>             
              
               <?php if( $_GET['m']=="store_order" ) {?>                  
                  <?php if( $submenu_value['state_type']!="" ) {?>                  
                   <li > <a href="index.php?m=<?php echo $submenu_value['m'];?>&a=<?php echo $submenu_value['a'];?>&state_type=<?php echo $submenu_value['state_type'];?>" class="<?php echo $submenu_value['state_type'] == $_GET['state_type']?'active':'';?>"> <?php echo $submenu_value['name'];?> </a> </li>
              <?php }else {?>
              
               <li  > <a href="index.php?m=<?php echo $submenu_value['m'];?>&op=<?php echo $submenu_value['a'];?>" class="<?php echo $submenu_value['a'] == $_GET['a']&& $_GET['state_type']!="state_new"?'active':'';?>"> <?php echo $submenu_value['name'];?> </a> </li>
              <?php }?>
              
                 
               <?php }else{ ?>

                
               <li <?php echo $_GET['act'] == 'seller_center'?"id='quicklink_".$submenu_value['m']."'":'';?> > <a href="index.php?m=<?php echo $submenu_value['m'];?>&a=<?php echo $submenu_value['a'];?>" class="<?php echo $submenu_value['a'] == $_GET['a']?'active':'';?>"> <?php echo $submenu_value['name'];?> </a> </li>
               <?php }?>
              
           <?php }else{ ?>
             <li  > <a href="index.php?m=<?php echo $submenu_value['m'];?>&op=<?php echo $submenu_value['a'];?>" class="<?php echo $submenu_value['a'] == $_GET['a']&& $_GET['state_type']!="state_new"?'active':'';?>"> <?php echo $submenu_value['name'];?> </a> </li>
           <?php } ?>          
      <?php } ?>
    <?php } ?>
    
    </ul>
  <?php } ?>

  </div>
  <link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/index.css" rel="Stylesheet" type="text/css">
  <link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/jquery.table.css" rel="Stylesheet" type="text/css">
<div class="main">
  <input type="hidden" value="addOrder" id="pageName">
  <div class="bg-e p-10">
    <a class="mr-10"><?php echo $output['current_menu']['model_name'];?></a> <i class="icon iconfont cor-grey mr-10 fs-12"></i> <a class="mr-10" ><?php echo $output['current_menu']['name'];?></a>
  </div>
   <?php require_once($tpl_file); ?>
</div>

</div>
<div class="footer"></div>

</body>
</html>
