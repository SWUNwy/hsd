<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/wwi-main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home_index.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<style type="text/css">
.category {
	display: block !important;
}
</style>
<div class="clear"></div>
<!-- HomeFocusLayout Begin-->
<div class="home-focus-layout">
	<?php echo $output['web_html']['index_pic'];?>
</div>
<div class="left-slide">
  <div class="title"> <a class="wwisp" href="javascript:void(0)"  title="猜您喜欢">猜您喜欢<i></i></a></div>
  <ul class="links">
    <?php if (is_array($output['rc_list']) && !empty($output['rc_list'])) {$i=0 ?>
    <?php foreach($output['rc_list'] as $v) { $i++?>
    <li><a href="<?php echo $v['value']?>" target="_blank" <?php echo $v['is_blod']==1? 'class="on"':''?>><?php echo $v['name']?></a></li>
    <?php } } ?>
  </ul>
</div>
</div>
<div class="main-r">
  <div class="mainR_inr">
    <div class="topTtl">公告</div>
    <ul class="clearfix noticeList">
      <?php if(!empty($output['show_article']['notice']['list']) && is_array($output['show_article']['notice']['list'])) { ?>
      <?php foreach($output['show_article']['notice']['list'] as $val) { ?>
      <li><a rel="nofollow" href="<?php echo empty($val['article_url']) ? urlMember('article', 'show',array('article_id'=> $val['article_id'])):$val['article_url'] ;?>" target="_blank">【公告】<?php echo $val['article_title']; ?></a></li>
      <?php }} ?>
    </ul>
    <div class="topTtl">服务特色</div>
    <ul class="featuresList clearfix">
      <li><a rel="nofollow" href="<?php echo urlShop('show_joinin', 'index');?>" target="_self"><i class="i_ico01"></i>招商入驻</a></li>
      <li><a rel="nofollow" href="<?php echo urlShop('s_login','show_login');?>" target="_self"><i class="i_ico02"></i>商家管理</a></li>
      <li><a rel="nofollow" href="<?php echo urlshop('special','special_detail', array('special_id'=>'1'));?>" target="_self"><i class="i_ico03"></i>消费保障</a></li>
      <li><a rel="nofollow" href="<?php echo urlShop('invite', 'index');?>" target="_self"><i class="i_ico04"></i>推广返利</a></li>
      <li><a rel="nofollow" href="<?php echo DELIVERY_SITE_URL;?>" target="_self"><i class="i_ico05"></i>物流自提</a></li>
      <li><a rel="nofollow" href="<?php echo WAP_SITE_URL;?>" target="_self"><i class="i_ico06"></i>手机专享</a></li>
    </ul>
  </div>
</div>
</div>
</div>
<!--HomeFocusLayout End--><!--网店运维切换栏组合 stat-->
<div class="wrapper">
  <div class="home-sale-suiji"><?php echo $output['web_html']['index_sale'];?></div>
  <article class="m-brands" id="j-brands">
    <h2 class="w-tit1 w-tit1-1"><span class="big">热门品牌</span> / BRAND</h2>
    <ul class="clearfix">
      <?php if(!empty($output['brand_r'])){?>
      <?php foreach($output['brand_r'] as $key=>$brand_r){?>
      <li class="itm1"><a class="pic" href="<?php echo urlShop('brand', 'list',array('brand'=>$brand_r['brand_id']));?>"  target="_blank" title="<?php echo $brand_r['brand_name'];?>">
        <div class="imgs"><img class="brandbg img-lazyload" shopwwi-url="<?php echo $brand_r['brand_xbgpic'];?>"  rel='lazy' src="<?php echo SHOP_SITE_URL;?>/img/loading.gif"  alt="<?php echo $brand_r['brand_name'];?>" title="<?php echo $brand_r['brand_name'];?>" width="239px" height="239px"><img class="logo opacity1" shopwwi-url="<?php echo brandImage($brand_r['brand_pic']);?>"  rel='lazy' src="<?php echo SHOP_SITE_URL;?>/img/loading.gif" alt="<?php echo $brand_r['brand_name'];?>" title="<?php echo $brand_r['brand_name'];?>"></div>
        <div class="txt">
          <h3 class="tit"><?php echo $brand_r['brand_name'];?></h3>
          <p class="desc s-fc2"><?php echo $brand_r['brand_tjstore'];?></p>
        </div>
        </a></li>
      <?php } }?>
      <li class="itm5"><a class="pic" href="<?php echo urlshop('brand');?>" target="_blank" title="大牌街"><img class="img-lazyload" shopwwi-url="<?php echo SHOP_SITE_URL;?>/img/shopwwi-brand-in.jpg"  rel='lazy' src="<?php echo SHOP_SITE_URL;?>/img/loading.gif"  alt="大牌街" title="大牌街" width="237px" height="360px"></a></li>
    </ul>
  </article>
  <!--网店运维切换栏组合 end-->
  <div class="mt10"><?php echo loadadv(38,'html');?> </div>
  <!--StandardLayout Begin--> <?php echo $output['web_html']['index'];?> <!--StandardLayout End-->
  <div class="mt10"><?php echo loadadv(9,'html');?></div>
</div>
<div class="wwi-main-footr">
  <div class="wrapper">
    <div class="sale_lum clearfix">
      <div class="m" id="sale_cx">
        <div class="mt">
          <div class="title-line"></div>
          <h2><span>特卖TeMai</span></h2>
        </div>
        <div class="sale_cx">
          <?php if(!empty($output['group_list']) && is_array($output['group_list'])) { ?>
          <div class="groupbuy">
            <ul>
              <?php foreach($output['group_list'] as $val) { ?>
              <li>
                <dl style=" background-image:url(<?php echo gthumb($val['groupbuy_image1'], 'small');?>)">
                  <dt><?php echo $val['groupbuy_name']; ?></dt>
                  <dd class="price"><span class="groupbuy-price"><?php echo ncPriceFormatForList($val['groupbuy_price']); ?></span><span class="buy-button"><a href="<?php echo urlShop('show_groupbuy','groupbuy_detail',array('group_id'=> $val['groupbuy_id']));?>">立即抢</a></span></dd>
                  <dd class="time"><span class="sell">已售<em><?php echo $val['buy_quantity']+$val['virtual_quantity'];?></em></span> <span class="time-remain" count_down="<?php echo $val['end_time']-TIMESTAMP; ?>"> <em time_id="d">0</em><?php echo $lang['text_tian'];?><em time_id="h">0</em><?php echo $lang['text_hour'];?> <em time_id="m">0</em><?php echo $lang['text_minute'];?><em time_id="s">0</em><?php echo $lang['text_second'];?> </span></dd>
                </dl>
              </li>
              <?php } ?>
            </ul>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="m" id="sale_xs">
        <div class="mt">
          <div class="title-line"></div>
          <h2><span>疯抢FengQiang</span></h2>
        </div>
        <div class="sale_xs">
          <div class="home-sale-layout">
            <div class="left-sidebar">
              <?php if(!empty($output['special_list']) && is_array($output['special_list'])) {?>
              <?php foreach($output['special_list'] as $value) {?>
              <a href="<?php echo $value['special_link'];?>" title="<?php echo $value['special_title'];?>" target="_blank"><img width="275" title="<?php echo $value['special_title'];?>" height="135" shopwwi-url="<?php echo getCMSSpecialImageUrl($value['special_image']);?>" rel='lazy' src="<?php echo SHOP_SITE_URL;?>/img/loading.gif" class="" alt="<?php echo $value['special_title'];?>"></a>
              <?php }} ?>
            </div>
            <?php if(!empty($output['xianshi_item']) && is_array($output['xianshi_item'])) { ?>
            <div class="right-sidebar">
              <div id="saleDiscount" class="sale-discount">
                <ul>
                  <?php foreach($output['xianshi_item'] as $val) { ?>
                  <li>
                    <dl>
                      <dt class="goods-name"><?php echo $val['goods_name']; ?></dt>
                      <dd class="goods-thumb"><a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>"> <img shopwwi-url="<?php echo thumb($val, 240);?>"   rel='lazy' src="<?php echo SHOP_SITE_URL;?>/img/loading.gif"></a></dd>
                      <dd class="goods-price"><?php echo ncPriceFormatForList($val['xianshi_price']); ?> <span class="original"><?php echo ncPriceFormatForList($val['goods_price']);?></span></dd>
                      <dd class="goods-price-discount"><em><?php echo $val['xianshi_discount']; ?></em></dd>
                      <dd class="time-remain" count_down="<?php echo $val['end_time']-TIMESTAMP;?>"><i></i><em time_id="d">0</em><?php echo $lang['text_tian'];?><em time_id="h">0</em><?php echo $lang['text_hour'];?> <em time_id="m">0</em><?php echo $lang['text_minute'];?><em time_id="s">0</em><?php echo $lang['text_second'];?> </dd>
                      <dd class="goods-buy-btn"></dd>
                    </dl>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="m" id="share">
        <div class="mt">
          <div class="title-line"></div>
          <h2><span>晒单ShaiDan</span></h2>
        </div>
        <div class="share" id="sl">
          <ul class="show_share">
            <?php if(!empty($output['goods_evaluate_info']) && is_array($output['goods_evaluate_info'])){?>
            <?php foreach($output['goods_evaluate_info'] as $k=>$v){?>
            <li>
              <div class="p-img"><a href="<?php echo urlShop('goods','comments_list',array('goods_id'=> $v['geval_goodsid']));?>" target="_blank"><img src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".ATTACH_GOODS."/".$v['geval_storeid']."/".$v['geval_goodsimage'];?>" alt="<?php echo $v['geval_goodsname'];?>" width="100" height="100"></a></div>
              <div class="p-info">
                <div class="author-info"><img title="<?php echo str_cut($v['geval_frommembername'],2).'***';?>"  shopwwi-url="<?php echo getMemberAvatarForID($v['geval_frommemberid']);?>"   rel='lazy' src="<?php echo SHOP_SITE_URL;?>/img/loading.gif" alt="<?php echo str_cut($v['geval_frommembername'],2).'***';?>" width="28" height="28"><span><?php echo str_cut($v['geval_frommembername'],2).'***';?></span></div>
                <div class="p-detail"><a target="_blank" title="<?php echo $v['geval_content'];?>" href="<?php echo urlShop('goods','comments_list',array('goods_id'=> $v['geval_goodsid']));?>"><?php echo $v['geval_content'];?><span class="icon-r">”</span></a><span class="icon-l">“</span></div>
              </div>
            </li>
            <?php }}?>
          </ul>
          <script type="text/javascript">$(document).ready(function() {function statusRunner() {setTimeout(function() {var sl = $('#sl li'), f = $('#sl li:last');f.hide().insertBefore(sl.eq(0)).css('opacity','0.1');f.slideDown(500, function() {	f.animate({	opacity: 1 });});statusRunner();}, 7000);}statusRunner();});$(".home-standard-layout .left-sidebar .title a ").hover(function() {$(".home-standard-layout .tabs-nav").addClass("wwi-hover");});$(".home-standard-layout .tabs-nav .close").click(function(){$(".home-standard-layout .tabs-nav").removeClass("wwi-hover");});	</script></div>
      </div>
    </div>
  </div>
</div>
<div id="nav_box" style="display: none;">
  <ul>
    <div class="m-logo"></div>
    <?php if (is_array($output['lc_list']) && !empty($output['lc_list'])) {$i=0 ?>
    <?php foreach($output['lc_list'] as $v) { $i++?>
    <li class="nav_Sd_<?php echo $i;?> <?php if($i==1) echo 'hover'?>"> <a class="word" href="javascript:;"><em class="em"><?php echo $v['value']?></em><?php echo $v['name']?></a></li>
    <?php }} ?>
  </ul>
</div>
</div>
