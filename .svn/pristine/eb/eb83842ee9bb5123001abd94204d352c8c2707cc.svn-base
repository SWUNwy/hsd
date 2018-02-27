<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<style>
	#footer1 {
	padding: 10px 0 30px 0;
	background-color:#FFF;
	}
	#footer1 .about-us p span {
    	padding: 0 10px;
	}
</style>
<div id="footer1">
        <div class="wrapper">
          <div class="screen clearfix" style="margin:0 auto;width:800px;text-align:center;">
            <div class="fl right-flag"><a href="javascript:void(0)" target="_blank" rel="nofollow"><img src="<?php echo SHOP_SITE_URL;?>/img/credit-flag3.png"></a><a href="javascript:void(0)" target="_blank" rel="nofollow"><img src="<?php echo SHOP_SITE_URL;?>/img/isc2.png"></a></div>
            <div class="fl about-us">
              <p><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=itemIndex">返回首页</a>
                <?php if(!empty($output['nav_list']) && is_array($output['nav_list'])){?>
                <?php foreach($output['nav_list'] as $nav){?>
                <?php if($nav['nav_location'] == '2'){?>
                    <span>|</span> 
                    <a  <?php if($nav['nav_new_open']){?>target="_blank" <?php }?>href="<?php 
                        switch($nav['nav_type']){
                            case '0':
                                echo $nav['nav_url'];
                                break; 
                            case '1':
                                echo urlShop('search', 'index', array('cate_id'=>$nav['item_id']));
                                break; 
                            case '2':
                                echo urlMember('article', 'article',array('ac_id'=>$nav['item_id']));
                                break; 
                            case '3':
                                echo urlShop('activity', 'index',array('activity_id'=>$nav['item_id']));
                                break;
                            }?>"><?php echo $nav['nav_title'];?></a>
                <?php }}}?>
                <span>|</span><a href="<?php echo urlshop('link');?>">友情链接</a></p>
              <p>CopyRight © 2007-2017 汇世达 <a href="http://www.miibeian.gov.cn/" target="_blank" mxf="sqde" style="color:#666"> 渝ICP备16010097号-1</a> NewPower Co. 版权所有<div style="width:300px;margin:0 auto; padding:20px 0;">
      <a target="_blank" href="" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="ban.png" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">渝公网安备 50011202501154</p></a>
    </div></p>
              <p><?php echo html_entity_decode($output['setting_config']['statistics_code'],ENT_QUOTES); ?></p>
            </div>
          </div>
          <?php if (C('debug') == 1){?>
          <div id="think_page_trace" class="trace">
            <fieldset id="querybox">
              <legend><?php echo $lang['nc_debug_trace_title'];?></legend>
              <div> <?php print_r(Tpl::showTrace());?> </div>
            </fieldset>
          </div>
          <?php }?>
        </div>
</div>
<?php require_once("kf.php"); ?>
<div style="display:none"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1261569164'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/stat.php%3Fid%3D1261569164' type='text/javascript'%3E%3C/script%3E"));</script></div>