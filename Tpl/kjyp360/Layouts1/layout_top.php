<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<!--ByShopKJYP网店运维-->
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>

<?php if ($output['setting_config']['shopwwi_top_banner_status']>0){ ?>
<div style=" background:<?php echo $output['setting_config']['shopwwi_top_banner_color']; ?>;">
<div class="wrapper" id="t-sp" style="display: none;">
<a href="javascript:void(0);" class="close" title="关闭"></a>
<a href="<?php echo $output['setting_config']['shopwwi_top_banner_url']; ?>" title="<?php echo $output['setting_config']['shopwwi_top_banner_name']; ?>"><img border="0" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.$output['setting_config']['shopwwi_top_banner_pic']; ?>" alt=""></a></div>
<script type="text/javascript">
$(function(){
	//search
	var skey = getCookie('top_s');
		if(skey){
		$("#t-sp").hide();
		} else {
			$("#t-sp").slideDown(800);
			}
		$("#t-sp .close").click(function(){
			setCookie('top_s','yes',1);
			$("#t-sp").hide();
	});	
});
</script></div><?php } ?>
<div class="public-top-layout w">
  <div class="topbar wrapper">
    <div class="user-entry">
      <?php if($_SESSION['is_login'] == '1'){?>
      <?php echo $lang['nc_hello'];?> <span> <a href="<?php echo urlShop('member','home');?>"><?php echo $_SESSION['member_name'];?></a>
      <?php if ($output['member_info']['level_name']){ ?>
      <div class="nc-grade-mini" style="cursor:pointer;" onclick="javascript:go('<?php echo urlShop('pointgrade','index');?>');"><?php echo $output['member_info']['level_name'];?></div>
      <?php } ?>
      </span> <?php echo $lang['nc_comma'],$lang['welcome_to_site'];?> <a href="<?php echo SHOP_SITE_URL;?>"  title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><span><?php echo $output['setting_config']['site_name']; ?></span></a> <span>[<a href="<?php echo urlLogin('login','logout');?>"><?php echo $lang['nc_logout'];?></a>] </span>
      <?php }else{?>
      <?php echo $lang['nc_hello'].$lang['nc_comma'].$lang['welcome_to_site'];?> <a href="<?php echo SHOP_SITE_URL;?>" title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><?php echo $output['setting_config']['site_name']; ?></a><?php if (C('qq_isuse') == 1 || C('sina_isuse')  == 1 || C('weixin_isuse') == 1){?>
      <span class="other">
      <?php if (C('qq_isuse') == 1){?>
      <a href="<?php echo MEMBER_SITE_URL;?>/api.php?m=toqq" title="QQ账号登录" class="qq"><i></i></a>
      <?php } ?>
      <?php if (C('sina_isuse') == 1){?>
      <a href="<?php echo MEMBER_SITE_URL;?>/api.php?m=tosina" title="<?php echo $lang['nc_otherlogintip_sina']; ?>" class="sina"><i></i></a>
      <?php } ?>
         <?php if (C('weixin_isuse') == 1){?>
      <a href="javascript:void(0);" onclick="ajax_form('weixin_form', '微信账号登录', '<?php echo urlLogin('connect_wx', 'index');?>', 360);" title="微信账号登录" class="wx"><i></i></a><?php } ?>
      </span>
      <?php } ?> <span>[<a href="<?php echo urlMember('login');?>"><?php echo $lang['nc_login'];?></a>]</span> <span>[<a href="<?php echo urlLogin('login','register');?>"><?php echo $lang['nc_register'];?></a>]</span>
      <?php }?>
    </div>
    <div class="quick-menu">
	<?php if (C('mobile_isuse') && C('mobile_app')){?>
	<dl class="down_app">
        <dt><em class="ico_tel"></em><a href="<?php echo BASE_SITE_URL;?>/wap">移动端</a><i></i></dt>
                <dd>
       <div class="qrcode"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.C('mobile_app');?>"></div>
        <div class="hint">
          <h4>扫描二维码</h4>
          下载手机客户端</div>
        <div class="addurl">
          <?php if (C('mobile_apk')){?>
          <a href="<?php echo C('mobile_apk');?>" target="_blank"><i class="icon-android"></i>Android</a>
          <?php } ?>
          <?php if (C('mobile_ios')){?>
          <a href="<?php echo C('mobile_ios');?>" target="_blank"><i class="icon-apple"></i>iPhone</a>
          <?php } ?>
                        </div>
    </dd>      </dl>
    <?php } ?>
	<dl>
        <dt><em class="ico_shop"></em><a href="<?php echo urlShop('show_joinin','index');?>" title="商家管理">商家管理</a><i></i></dt>
        <dd>
          <ul>
            <li><a href="<?php echo urlShop('show_joinin','index');?>" title="招商入驻">招商入驻</a></li>
            <li><a href="<?php echo urlShop('s_login','show_login');?>" target="_blank" title="登录商家管理中心">商家登录</a></li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt><em class="ico_order"></em><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=m_order">我的订单</a><i></i></dt>
        <dd>
          <ul>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=m_order&state_type=state_new">待付款订单</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=m_order&state_type=state_send">待确认收货</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=m_order&state_type=state_noeval">待评价交易</a></li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt><em class="ico_store"></em><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=m_favorite_goods&a=fglist"><?php echo $lang['nc_favorites'];?></a><i></i></dt>
        <dd>
          <ul>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=m_favorite_goods&a=fglist">商品收藏</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=m_favorite_store&a=fslist">店铺收藏</a></li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt><em class="ico_service"></em>客户服务<i></i></dt>
        <dd>
          <ul>
            <li><a href="<?php echo urlMember('article', 'article', array('ac_id' => 2));?>">帮助中心</a></li>
            <li><a href="<?php echo urlMember('article', 'article', array('ac_id' => 5));?>">售后服务</a></li>
            <li><a href="<?php echo urlMember('article', 'article', array('ac_id' => 6));?>">客服中心</a></li>
          </ul>
        </dd>
      </dl>
      <?php
      if(!empty($output['nav_list']) && is_array($output['nav_list'])){
	      foreach($output['nav_list'] as $nav){
	      if($nav['nav_location']<1){
	      	$output['nav_list_top'][] = $nav;
	      }
	      }
      }
      if(!empty($output['nav_list_top']) && is_array($output['nav_list_top'])){
      	?>
      <dl>
        <dt>站点导航<i></i></dt>
        <dd>
          <ul>
            <?php foreach($output['nav_list_top'] as $nav){?>
            <li><a
        <?php
        if($nav['nav_new_open']) {
            echo ' target="_blank"';
        }
        echo ' href="';
        switch($nav['nav_type']) {
        	case '0':echo $nav['nav_url'];break;
        	case '1':echo urlShop('search', 'index', array('cate_id'=>$nav['item_id']));break;
        	case '2':echo urlMember('article', 'article', array('ac_id'=>$nav['item_id']));break;
        	case '3':echo urlShop('activity', 'index', array('activity_id'=>$nav['item_id']));break;
        }
        echo '"';
        ?>><?php echo $nav['nav_title'];?></a></li>
            <?php }?>
          </ul>
        </dd>
      </dl>
      <?php } ?>
      <?php if (C('mobile_wx')) { ?>
      <dl class="weixin">
        <dt>关注我们<i></i></dt>
        <dd>
          <h4>扫描二维码<br/>
            关注商城微信号</h4>
          <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MOBILE.DS.C('mobile_wx');?>" > </dd>
      </dl>
      <?php } ?>
    </div>
  </div>
</div>
