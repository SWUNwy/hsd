<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit" />
<meta charset="utf-8">
<meta name="keywords" content="迦美国际，迦美国际首页，迦美国际官网，55haigou">
<meta name="description" content="迦美国际致力于服务中小母婴实体店，是实体店提供0库存、0资金占用的母婴供应平台，国外优质商品进入中国市场的新通道。">
<title>商品列表</title>
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/jquery.table.css?v=20161213125405" rel="Stylesheet" type="text/css"/>
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/goodsList.css" rel="Stylesheet" type="text/css">
<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
</head>

<body class="has-goods-header" data-page-rp="130">
<input type="hidden" id="basePath" value="" />
<div class="content cf" id="con-container">
  <style>
	.h-45px{height: 45px;line-height: 45px;}
	.icon_soldOut {
		position: absolute;
		display: block;
		width: 125px;
		height: 125px;
		left:50px;
		top: 50px;
		background-image: url(/Tpl/kjyp360/images/icon_sold_out.png);
		background-repeat: no-repeat;
	}
	.nch-breadcrumb {
		font-size: 12;
		text-align: left;
		height: 15px;
		padding: 10px 0;
		margin: 0 auto;
	}
	.cate-a {
		padding: 0 18px 0 8px;
		cursor: pointer;
		height: 31px;
		line-height: 31px;
	}
	.goods-count{
		font-size:18px;
		color:#F00;
	}
	.market-price {
		font-size: 10px;
		color: #999;
		text-decoration: line-through;
		text-overflow: ellipsis;
		white-space: nowrap;
		max-width: 80px;
		float: right;
		margin-left: 10px;
		overflow: hidden;
	}
	p#cartNumPop {
		text-align: center;
		line-height: 28px;
		color: #fff;
	}
</style>
  <div class="inner-header pt-30 bg-w clearfix bb-1" id="navBox">
    <div class="fixed-container">
      <div class="clearfix" id="searchInputHeader">
        <div class="f-l"> <img src="<?php echo SHOP_TEMPLATES_URL?>/images/seller/shouyetoubu.png?v=20161213125405"> </div>
        <div class="f-r clearfix searchBox">
          <div class="clearfix">
            <div class="searchInputBox f-l">
              <input type="hidden" id="defaultKey" value="每日必抢">
              <input class="pl-10 pr-10" id="searchkeyIpt" name=""keyword" placeholder="每日必抢" />
              <div class="autocomplete-suggestions history-list d-n" id="historyList">
                <div class="autocomplete-suggestion clearfix">最近搜索
                  <div class="w-10 f-r ta-r d-ib" id="historyDelBtn"> <i class="iconfont">&#xe646;</i> </div>
                </div>
                <div id="historyItemList"></div>
              </div>
            </div>
            <a class="searchBtn f-l" id="headerSearchBtn" data-rpno="20.1" data-rpgo="true">搜索</a> 
            <a class="cart-head-btn f-l ml-10" target="_blank" href="index.php?m=store_cart" data-rpno="20.2"> <i class="iconfont mr-10" style="font-size: 16px">&#xe643;</i>购物车
            	<p class="pos-r ml-5 d-ib fs-12 num-pop" id="cartNumPop"><?php echo $output['cart_goods_num'];?></p>
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
        <li class="navItem pos-r" id="firstItem"><a href="/index.php?m=itemIndex" data-rpno="20.3">首页</a></li>
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
        <ul class="pos-a bg-w d-n typeList" id="typeList">
        </ul>
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
                    <p class='w-120px d-ib h-45px of-h cor-333'><i class="pl-5 va-m pr-10 cor-888 iconfont fs-20" style="font-size:20px;">{{=item.iconFont}}</i>{{=item.categoryName}}</p>
                    <i class="iconfont f-r cor-888 va-m  h-45px">&#xe63e;</i>
                </a>
            </li>
        {{~}}
    </script>
  <div class="fixed-container">
    <div class="nch-breadcrumb-layout">
      <div class="nch-breadcrumb wrapper">
        <?php if (is_array($output['nav_link_list']) && !empty($output['nav_link_list'])){ ?>
        <i class="icon-home"></i> 
        <span><?php echo $output['nav_link_list'][1]['title']?></span>
        <span class="arrow">&gt;</span> 
        <span><?php echo $output['nav_link_list'][0]['title']?> 共<i class="goods-count"> <?php echo $output['goods_num1']?> </i>样商品</span>
        <?php } ?>
      </div>
    </div>
    <div class="mt-10 bg-w cate-wrap cor-grey bt-1 bl-1 br-1" id="searchWrap">
      <ul>
        <li id="cateLi" class="d-n" style="display: list-item;">
          <label class="cate-label">类目：</label>
          <div class="inner-cate" data-rpno="0.1">
            <?php if (is_array($output['typeList']) && !empty($output['typeList'])){ ?>
            <?php foreach($output['typeList'] as $value){?>
            <a href="/index.php?m=itemindex_search&a=index&gc_id=<?php echo $value['gc_id'];?>" class="d-ib cate-a"><?php echo $value['gc_name'];?></a>
            <?php }}else{?>
            <a href="javascript:void()" class="d-ib cate-a">无分类资料</a>
            <?php } ?>
          </div>
        </li>
        <!--
                <li id="brandLi" class="d-n last" style="display: list-item;">
                    <label class="cate-label">品牌：</label>
                    <span class="cate-more" style="display: none;">更多<i class="iconfont"></i></span>
					<div class="cate-block" style="height: 31px;">
                        <div class="inner-cate fs-12" data-rpno="0.3">
                        	<a class="d-ib brand-a" data-type="brand" data-id="611" id="brand611">美素佳儿Frisolac</a>
                            <a class="d-ib brand-a" data-type="brand" data-id="815" id="brand815">雀巢Nestle</a>
                            <a class="d-ib brand-a" data-type="brand" data-id="817" id="brand817">澳洲安满ANMUM</a>
                            <a class="d-ib brand-a" data-type="brand" data-id="1175" id="brand1175">澳洲SOULFUL</a>
                        </div>
                    </div>
                </li>
                -->
      </ul>
    </div>
    <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
    <ul class="goods-list mt-15 clearfix" id="goodsListUl">
      <?php foreach($output['goods_list'] as $value){?>
      <li class="b-1 f-l bg-w pos-r ">
        <div class="bb-1 clearfix"> <a target="_blank" href="<?php echo urlShop('goods_itemIndex','index',array('goods_id'=>$value['goods_id']));?>" data-rpno="0.4"> <img src="<?php echo cthumb($value['goods_image'], 240,$value['store_id']);?>" width="100%" class="f-l goods-img" title="<?php echo $value['goods_jingle'];?>">
          <?php if($value['goods_storage']==0) {?>
          <i class="icon_soldOut"></i>
          <?php }?>
          </a> </div>
        <div class="pt-20 pb-10 pl-10 pr-10">
          <div class="title"> <a target="_blank" href="<?php echo urlShop('goods_itemIndex','index',array('goods_id'=>$value['goods_id']));?>" data-rpno="22.1"> <?php echo $value['goods_name_highlight'];?> </a> </div>
          <div class="clearfix mt-10"> 
          	<span class="cor-red fs-18 f-l">
            	<?php if($_SESSION['store_id']>0){ ?> 
            	<em title="<?php echo $lang['goods_class_index_store_goods_price'].$lang['nc_colon'].$lang['currency'].ncPriceFormat($value['goods_promotion_price']);?>"> 
                	<i><?php echo '¥';?> </i><?php echo ncPriceFormat($value['goods_promotion_price']);?> 
                </em> 
                <em class="market-price" title="市场价：<?php echo $lang['currency'].$value['goods_marketprice'];?>"> <?php echo ncPriceFormatForList($value['goods_marketprice']);?> 
                </em>
                <?php }else{ ?> 
                <em title="<?php echo $lang['goods_class_index_store_goods_price'].$lang['nc_colon'].$lang['currency'].'???';?>"> 
                	<i><?php echo '¥';?> </i>???</em> 
                <em class="market-price" title="市场价：<?php echo $lang['currency'].$value['goods_marketprice'];?>"> <?php echo ncPriceFormatForList($value['goods_marketprice']);?> 
                </em>
                <?php } ?> 
            </span> 
          </div>
        </div>
      </li>
      <?php } ?>
    </ul>
    <?php }else{?>
  <div id="no_results" style="color:#AAA;padding: 200px 0;text-align: center;"><i></i>没有找到符合<em style="font-size: 17px;color: #f62121;font-weight:700;"><?php echo $output['show_keyword'];?></em>条件的商品</div>
  <?php }?>
    <div id="pagination" class="mb-40 clearfix">
      <div class="pagination"> <?php echo $output['show_page']; ?>
        <div class="page-info"></div>
      </div>
    </div>
  </div>
</div>
</body>
<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/global.js?t=201610131408"></script>
<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/441b93a43541bf6927981133b31d5089.js" charset="utf-8"></script>
<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/ya.js?v=20161213125405" type="text/javascript"></script>
<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/goodsGlobal.js?t=201611091108"></script>
<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/jquery.pagination.js?v=20161213125405" type="text/javascript"></script>
<script src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/goodsList.js?v=20161213125405" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL?>/seller_js/jquery.cookie.js"></script>