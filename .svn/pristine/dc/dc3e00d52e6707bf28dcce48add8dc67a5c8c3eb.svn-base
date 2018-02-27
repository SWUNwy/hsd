<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit" />
<meta charset="utf-8">
<meta name="keywords" content="迦美国际，迦美国际首页，迦美国际官网，55haigou">
<meta name="description" content="迦美国际致力于服务中小母婴实体店，是实体店提供0库存、0资金占用的母婴供应平台，国外优质商品进入中国市场的新通道。">
<title>商品首页</title>
<!--<link rel="stylesheet" href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/global.css?t=201612051122">-->
</head>
<input type="hidden" id="basePath" value="" />

<body class="has-goods-header" data-page-rp="131">
<div class="content cf" id="con-container">
  <link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/jquery.blockslides.css?v=20161213125405" rel="stylesheet" type="text/css"/>
  <link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/itemIndex.css?v=20161213125405" rel="stylesheet" type="text/css">
  <div class="down-app d-n">
    <div class="down-app-wrap">
      <div class="bg"></div>
      <div class="down-img"> <img id="downImg" src="" alt=""/> <a href="javascript:void(0)" id="appDown"><i class="iconfont">&#xe6e5;</i></a> </div>
    </div>
  </div>
  <div class="pageMain bg-e">
    <style>
    .h-45px{height: 45px;line-height: 45px;}
</style>
    <div class="inner-header pt-30 bg-w clearfix bb-1" id="navBox">
      <div class="fixed-container">
        <div class="clearfix" id="searchInputHeader">
          <div class="f-l"> <img src="<?php echo SHOP_TEMPLATES_URL?>/images/seller/shouyetoubu.png?v=20161213125405"> </div>
          <div class="f-r clearfix searchBox">
            <div class="clearfix">
              <div class="searchInputBox f-l">
                <input type="hidden" id="defaultKey" value="每日必抢">
                <input class="pl-10 pr-10" id="searchkeyIpt" placeholder="每日必抢" />
                <div class="autocomplete-suggestions history-list d-n" id="historyList">
                  <div class="autocomplete-suggestion clearfix">最近搜索
                    <div class="w-10 f-r ta-r d-ib" id="historyDelBtn"><i class="iconfont">&#xe646;</i></div>
                  </div>
                  <!--<div id="historyItemList"> </div>--> 
                </div>
              </div>
              <a class="searchBtn f-l" id="headerSearchBtn" data-rpno="20.1" data-rpgo="true">搜索</a> 
              <a class="cart-head-btn f-l ml-10" target="_blank" href="index.php?m=store_cart" data-rpno="20.2"><i class="iconfont mr-10" style="font-size: 16px">&#xe643;</i>购物车
              	<p class="pos-r ml-5 d-ib fs-12 num-pop" id="cartNum"><?php echo $output['cart_goods_num'];?></p>
              </a> 
            </div>
            <div class="w-100 mt-10 cor-9">
              <?php if (is_array($output['rec_search_list']) && !empty($output['rec_search_list'])) { ?>
              <?php foreach($output['rec_search_list'] as $v) { ?>
              <p class="d-ib pr-10 cor-red"><a href="<?php echo urlShop('itemindex_search', 'index', array('keyword' => $v['value']));?>"  data-rpno="20.11"><?php echo $v['value']?></a></p>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div>
        <ul class="w-100 mt-35 clearfix navBox pos-r" id="channelWrap">
          <li class="navItem bg-red1 allType" id="allType">
            <p class="pl-20 ta-l"><i class="iconfont mr-10">&#xe64e;</i>全部分类</p>
          </li>
          <li class="navItem pos-r" id="firstItem"><a href="/index.php?m=itemindex" data-rpno="20.3">首页</a></li>
          <?php if(!empty($output['nav_list']) && is_array($output['nav_list'])){?>
      	  	<?php foreach($output['nav_list'] as $nav){?>
      	 		<?php if($nav['nav_location'] == '1'){?>
          <li class="navItem pos-r"><a
        		<?php
        			if($nav['nav_new_open']) {
            			echo ' target="_blank"';
        			}
					switch($nav['nav_type']) {
            			case '0':
                			echo ' href="' . $nav['nav_url'] . '"';
               				break;
           				case '1':
                			echo ' href="' . urlShop('search', 'index',array('cate_id'=>$nav['item_id'])) . '"';
                			if (isset($_GET['cate_id']) && $_GET['cate_id'] == $nav['item_id']) {
                    		echo ' class="current"';
                			}
               				break;
            			case '2':
                			echo ' href="' . urlMember('article', 'article',array('ac_id'=>$nav['item_id'])) . '"';
                			if (isset($_GET['ac_id']) && $_GET['ac_id'] == $nav['item_id']) {
                    		echo ' class="current"';
                			}
                			break;
            			case '3':
                			echo ' href="' . urlShop('activity', 'index', array('activity_id'=>$nav['item_id'])) . '"';
                			if (isset($_GET['activity_id']) && $_GET['activity_id'] == $nav['item_id']) {
                    		echo ' class="current"';
                			}
                			break;
        			}
        		?>><?php echo $nav['nav_title'];?></a>
          </li>
          <?php }}}?>
          <ul class="pos-a bg-w d-n typeList" id="typeList"></ul>
        </ul>
      </div>
    </div>
    <ul class="about-us-wrap" id="aboutUsWrap">
      <li class="cur-p w-100 contact-item pos-r" id="cartIcon"> <a href="index.php?m=store_cart" data-rpno="20.8">
        <p class="mt-1 h-35px bg-9 w-70px cor-w pl-10 pr-10 lift-checked d-n fs-14 fw-b">购物车<span class="ml-5"><?php echo $output['cart_goods_num'];?></span></p>
        <div class="d-ib ta-c h-35px w-35px cor-w pos-r"><i class="iconfont" style="font-size: 22px">&#xe6f8;</i>
          <p class="cart-add-pop ta-c fs-12 bg-red cor-w d-ib pos-a" id="cartAddTip"><?php echo $output['cart_goods_num'];?></p>
        </div>
        </a> </li>
      <li class="cur-p w-100 contact-item pos-r " id="backToTop"> <a>
        <p class="mt-1 h-35px bg-9 w-60px cor-w pl-10 pr-10 lift-checked d-n fs-14 fw-b">回到顶部</p>
        <div class="d-ib ta-c h-35px w-35px cor-w"><i class="iconfont" style="font-size: 22px">&#xe6fe;</i></div>
        </a> </li>
      <li class="cur-p w-100 contact-item pos-r"> <a target="_blank" href="tencent://message/?uin=3452299387">
        <p class="mt-1 h-35px bg-9 w-90px cor-w pl-10 pr-10 lift-checked d-n fs-14 fw-b">在线客服咨询</p>
        <div class="d-ib ta-c h-35px w-35px cor-w"><i class="iconfont" style="font-size: 22px">&#xe6f9;</i></div>
        </a> </li>
      <input type="hidden" value="0"/>
      <!--<li class="cur-p w-100 contact-item pos-r">
        <p class="mt-1 h-35px bg-9 w-120px cor-w pl-10 pr-10 lift-checked d-n fs-14 fw-b">400-757-8666</p>
        <div class="d-ib ta-c h-35px w-35px cor-w"><i class="iconfont" style="font-size: 22px">&#xe6f7;</i></div>
      </li>
      <li class="cur-p w-100 contact-item pos-r"> <a href="javascript:void(0)" target="_blank" data-rpno="20.17" >
        <p class="mt-1 h-35px bg-9 w-60px cor-w pl-10 pr-10 lift-checked d-n fs-14 fw-b">帮助中心</p>
        <div class="d-ib ta-c h-35px w-35px cor-w"><i class="iconfont" style="font-size: 22px">&#xe681;</i></div>
        </a> </li>-->
    </ul>
    <script type="text/tpl" id="typeListTpl">
    {{~it.data:item:index}}
        <li>
            <a href="/index.php?m=itemindex_search&a=index&gc_id={{=item.categoryId}}" target="_blank" data-rpno="20.9">
                <p class='w-120px d-ib h-45px of-h cor-333'><i class="pl-5 va-m pr-10 cor-888 iconfont fs-20" style="font-size:20px;">{{=item.iconFont}}</i>{{=item.categoryName}}</p><i class="iconfont f-r cor-888 va-m  h-45px">&#xe63e;</i>
            </a>
        </li>
    {{~}}
</script>
    <!--幻灯开始-->
    <?php echo $output['web_html']['index_pic'];?>
    <!--幻灯结束-->
    <div class="fixed-container clearfix pb-55">
      <div class="clearfix mb-20">
        <div class="f-l mt-25 w-382px"> 
          <?php echo loadadv(39);?>
       </div>
        <div class="f-l mt-25 w-382px ml-22">
         <?php echo loadadv(41);?>
        </div>
        <div class="f-l mt-25 w-382px ml-22"> 
          <?php echo loadadv(43);?>
        </div>
      </div>
      

      <!--每日上新开始-->
      <div id="newItemListWrap1">
        <div class="pro-title mt-35 mb-5 clearfix">
          <div class="f-l"> <span class="fs-21 cor-3">每日上新</span>
            <p class="d-ib fs-14 cor-9 lh-32 ml-20">全网好货 精选热卖</p>
          </div>
          <a class="f-r lh-32 hov-deline" href="javascript:void(0)" data-rpno="2.1">更多上新 &gt;</a> </div>
        <div class="wrap mt-10 bg-w w-1188px b-1">
          <ul>
            <li class="clearfix">
              <?php if (is_array($output['goods_store_rand_list']) && !empty($output['goods_store_rand_list'])){ ?>
              <?php foreach($output['goods_store_rand_list'] as $key=>$v){?>
              <div class="new-item f-l pt-10 cor-3 cur-p  br-1 "> <a href="<?php echo urlShop('goods_itemIndex','index',array('goods_id'=>$v['goods_id']));?>" target="_blank" data-rpno="2.2">
                <div class="w-250px h-250px of-h m-auto pos-r"> <img src="<?php echo cthumb($v['goods_image'],240) ?>" class="d-ib w-100 va-m"> </div>
                <div class="new-name w-250px m-auto ta-c fs-14 pt-5"><?php echo $v['goods_name']?></div>
                <?php if($_SESSION['store_id']>0){ ?>
                <div class="cor-red w-250px m-auto ta-c pt-10 pb-30 fs-14"> ¥<span class="fs-21 fw-b" title="市场价"><?php echo $v['goods_price']?></span> </div>
                <?php }else{ ?>
                <div class="cor-red w-250px m-auto ta-c pt-10 pb-30 fs-14"> ¥<span class="fs-21 fw-b" title="市场价" style="text-decoration: line-through;"><?php echo ncPriceFormat($v['goods_marketprice']);?></span> </div>
                <?php } ?>
                </a> </div>
              <?php }} ?>
            </li>
          </ul>
        </div>
      </div>
      <!--每日上新结束--> 
      
      <!--分类开始--> 
      <!--奶粉-->
      <div id="goodsModuleBox1">
        <?php echo $output['web_html']['index'];?>
      </div>
      <!--分类结束-->
      
      <div class="pos-f w-35px t-210px r-50 mr-640 z-100" id="liftBox">
        <ul class="ta-c bg-w w-35px d-n" id="moduleLiftList">
        </ul>
      </div>
    </div>
  </div>
  <script type="text/tpl" id="liftListTpl">
    {{~it.liftList:item:index}}
        <li class="cur-p w-100 h-35px lift-item pos-r" data-id= "module{{=item.identify}}" data-rpno="0.8"><p class="h-35px w-60px cor-w pl-10 pr-10 lift-checked lift-right d-n fs-14 fw-b">{{=item.name}}</p><div class="cor-6"><i class="iconfont" style="font-size: 22px;">{{=item.pic1}}</i></div></li>
    {{~}}

</script> 
</div>
<div class="footer"></div>
<input type="hidden"  id="userNickName" name="userNickName" value="18623448938">
<input type="hidden"  id="userId" name="userId" value="c1a27a4f28444463a5e7ee9a82380ee1">
<input type="hidden"  id="shopName" name="shopName" value="天猫-时差七小时">
<input type="hidden"  id="crmShopLevelName" name="crmShopLevelName" value="普通门店">
<input type="hidden"  id="userName" name="userName" value="tony">
<input type="hidden"  id="shopPhone" name="shopPhone" value="18623448938">
<input type="hidden"  id="orderAmountRefundRate" name="orderAmountRefundRate" value="0.00%">
</body>
<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/global.js?t=201610131408"></script>
<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/441b93a43541bf6927981133b31d5089.js" charset="utf-8"></script>
<script type="text/javascript">
    var _yaConfigs = _yaConfigs || {};
    _yaConfigs.projectId = '4';
    _yaConfigs.domainNo = '2';
    ysf.on({
        'onload': function(){
            ysf.config({
                uid:$("#userId").val(),
                name:$("#userNickName").val(),
                mobile:$("#shopPhone").val(),
                email:"test@163.com",
                data:JSON.stringify([
                    {"key":"1", "label":"金额退款率","value":$("#orderAmountRefundRate").val()},
                    {"key":"2", "label":"门店等级","value":$("#crmShopLevelName").val()},
                    {"key":"3", "label":"服务销售","value":$("#userName").val()},
                    {"key":"4", "label":"门店名称","value":$("#shopName").val()}
                ])

            });
        }
    });
    window.openSDK = function(){
        ysf.open();
    };
</script>
<!--<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/ya.js?v=20161213125405" type="text/javascript"></script>-->
<style></style>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/goodsGlobal.js?t=201611091108"></script>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/jquery.blockslides.js?v=20161213125405"></script>
<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/itemIndex.js?v=20161213125405"></script>
