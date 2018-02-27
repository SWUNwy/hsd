<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/wwi-main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home_index.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/js/waypoints.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/lrtk.js"></script>


<style type="text/css">
.category {
	display: block !important;
}
</style>
<div class="clear"></div>
<!-- HomeFocusLayout Begin-->
<div class="home-focus-layout">
  <div class="content">
  	 <div class="content1">
		<div class="col_main">
		   <div style="width:1200px;float:left">
		      <div id="playBox">
				 <div class="pre"></div>
				 <div class="next"></div>
				 <div class="smalltitle">
				 	<ul>
                        <li class=""></li>
                        <li class="thistitle"></li>
                        <li class=""></li>
				 	</ul>
				 </div>
				 <ul class="oUlplay" style="left: -1200px;">
					<li><a href="javascript:void(0)" target="_blank"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/1.jpg" width="1200" height="357" title="跨境优品"></a>
                    </li>
					<li><a href="javascript:void(0)" target="_blank"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/1.jpg" width="1200" height="357" title="跨境优品"></a>
                    </li>
					<li><a href="javascript:void(0)" target="_blank"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/1.jpg" width="1200" height="357" title="跨境优品"></a>
                    </li>
				 </ul>
			  </div>
		   </div>
	    </div>
	 </div>
  </div>
</div>
<div class="clear"></div>
<!--HomeFocusLayout End--><!--网店运维切换栏组合 stat-->
<div class="wrapper">
	<div id="pro_div">
        <!-- 第1楼 -->
        <div class="pro_list">
            <div class="pro_list1">
                <div class="pro_floor">
                    <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/floor1_44.png">
                </div>
                <div class="profloor1">
                    <div class="profloor2_1">
                        <ul>
                            <li style="float:left"><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/1438911067901.1438911065896.jpeg" width="215px" height="277px" title="跨境优品"></a></li>
                            <li>
                                <div class="pro">
                                    <ul>
                                        <?php if (is_array($output['goods_common']) && !empty($output['goods_common'])){ ?>
                                        <?php foreach($output['goods_common'] as $key=>$v){?>
                                        <li class="pro1">
                                            <div class="pro_tu">
                                                
                                                <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img title="<?php echo $v['goods_name']?>" width="170px" height="170px" src="<?php echo cthumb($v['goods_image'],240) ?>"></a>
                                            </div>
                                            <dl>
                                                <dt class="pro_name" style="padding:0px 20px;text-overflow:ellipsis; white-space:nowrap; overflow:hidden;">
                                                    <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>" target="_self"><?php echo $v['goods_name']?></a>
                                                </dt>
                                                <dd class="pro_pri">￥<?php echo $v['goods_price']?></dd>
                                            </dl>
                                        </li>
                                        <?php }} ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!-- 第2楼 -->
        <div class="pro_list">
            <div class="pro_list1">
                <div class="pro_floor">
                    <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/floor2_44.png">
                </div>
                <div class="profloor1">
                    <div class="profloor2_5">
                        <ul>
                            <li style="float:left"><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/1450062154913.1450062151376.jpeg" width="215px" height="277px" title="跨境优品"></a></li>
                            <li>
                                <div class="pro">
                                    <ul>
                                        <?php if (is_array($output['goods_common1']) && !empty($output['goods_common1'])){ ?>
                                        <?php foreach($output['goods_common1'] as $key=>$v){?>
                                        <li class="pro1">
                                            <div class="pro_tu">
                                                
                                                <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img title="<?php echo $v['goods_name']?>" width="170px" height="170px" src="<?php echo cthumb($v['goods_image'],240) ?>"></a>
                                            </div>
                                            <dl>
                                                <dt class="pro_name" style="padding:0px 20px;text-overflow:ellipsis; white-space:nowrap; overflow:hidden;">
                                                    <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>" target="_self"><?php echo $v['goods_name']?></a>
                                                </dt>
                                                <dd class="pro_pri">￥<?php echo $v['goods_price']?></dd>
                                            </dl>
                                        </li>
                                        <?php }} ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!-- 第3楼 -->
        <div class="pro_list">
            <div class="pro_list1">
                <div class="pro_floor">
                    <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/floor3_44.png">
                </div>
                <div class="profloor1">
                    <div class="profloor2_4">
                        <ul>
                            <li style="float:left"><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/1438911284723.1438911283494.jpeg" width="215px" height="277px" title="跨境优品"></a></li>
                            <li>
                                <div class="pro">
                                    <ul>
                                        <?php if (is_array($output['goods_common2']) && !empty($output['goods_common2'])){ ?>
                                        <?php foreach($output['goods_common2'] as $key=>$v){?>
                                        <li class="pro1">
                                            <div class="pro_tu">
                                                
                                                <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img title="<?php echo $v['goods_name']?>" width="170px" height="170px" src="<?php echo cthumb($v['goods_image'],240) ?>"></a>
                                            </div>
                                            <dl>
                                                <dt class="pro_name" style="padding:0px 20px;text-overflow:ellipsis; white-space:nowrap; overflow:hidden;">
                                                    <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>" target="_self"><?php echo $v['goods_name']?></a>
                                                </dt>
                                                <dd class="pro_pri">￥<?php echo $v['goods_price']?></dd>
                                            </dl>
                                        </li>
                                        <?php }} ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!-- 第4楼 -->
        <div class="pro_list">
            <div class="pro_list1">
                <div class="pro_floor">
                    <img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/floor4_44.png">
                </div>
                <div class="profloor1">
                    <div class="profloor2_3">
                        <ul>
                            <li style="float:left"><a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/shop/1439532283345.1439532281455.jpeg" width="215px" height="277px" title="跨境优品"></a></li>
                            <li>
                                <div class="pro">
                                    <ul>
                                        <?php if (is_array($output['goods_common3']) && !empty($output['goods_common3'])){ ?>
                                        <?php foreach($output['goods_common3'] as $key=>$v){?>
                                        <li class="pro1">
                                            <div class="pro_tu">
                                                
                                                <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>"><img title="<?php echo $v['goods_name']?>" width="170px" height="170px" src="<?php echo cthumb($v['goods_image'],240) ?>"></a>
                                            </div>
                                            <dl>
                                                <dt class="pro_name" style="padding:0px 20px;text-overflow:ellipsis; white-space:nowrap; overflow:hidden;">
                                                    <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name']?>" target="_self"><?php echo $v['goods_name']?></a>
                                                </dt>
                                                <dd class="pro_pri">￥<?php echo $v['goods_price']?></dd>
                                            </dl>
                                        </li>
                                        <?php }} ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
	</div>
</div>