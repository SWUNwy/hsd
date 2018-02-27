<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<!-- <?php echo $output['web_name'];?>begin -->
<br/>
<!--头部热搜-->
<div class="pro-title"> <span class="fs-21 cor-3"><?php echo $output['web_name'];?></span></div>
<!--商品展示-->
<div class="pro-box bg-w b-1 pos-r of-h mt-5">
  <div class="w-199px of-h f-l br-1 pos-a bg-wating"> 
  <?php if (is_array($output['code_adv']['code_info']) && !empty($output['code_adv']['code_info'])): ?>
  	<?php foreach ($output['code_adv']['code_info'] as $key => $val) : ?>
        <?php if (is_array($val) && !empty($val)) :?>
  		<a class="f-r lh-32 hov-deline" href="<?php echo $val['pic_url'];?>" target="_blank" data-rpno="0.5"> <img alt="<?php echo $val['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_img'];?>"  class="h-470px"> </a> 
		<?php endif;?>
	<?php endforeach;?>
  <?php endif;?>
  </div>
  <div class="f-l of-h w-990px ml-198px">
    <?php if (!empty($output['code_recommend_list']['code_info'][1]['goods_list']) && is_array($output['code_recommend_list']['code_info'][1]['goods_list'])) : ?>
    	<?php foreach ($output['code_recommend_list']['code_info'][1]['goods_list'] as $k=> $v) :?>
	    <div class="pro-item br-1 bb-1 f-l"> <a href="<?php echo urlShop('goods_itemIndex','index',array('goods_id'=>$v['goods_id']));?>" target="_blank" data-rpno="0.6">
	      <div class="pro-img pos-r bg-wating"> <img  src="<?php echo strpos($v['goods_pic'],'x2_')>0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>"  class="w-100 va-m"> </div>
	      <div class="pl-10 pr-10 mt-10">
	        <p class="fs-12 mt-5 pro-name"><?php echo $v['goods_name']?></p>
	        <?php if($_SESSION['store_id']>0): ?>
	        <p class="cor-red fs-12 mt-5">¥<span class="fw-b fs-14" title="商城价"><?php echo $v['goods_price']?></span></p>
	        <?php else: ?>
	        <p class="cor-red fs-12 mt-5">¥<span class="fw-b fs-14" title="市场价" ><?php echo ncPriceFormat($v['market_price']);?></span></p>
	        <?php endif; ?>
	      </div>
	      </a> </div>
 		<?php endforeach;?>
    <?php else: ?>
    <div class="pro-item br-1 bb-1 f-l" style="font-size:16px;color:#F00;text-align:center;width:990px;height:472px;font-style:inherit;padding-top:210px;">商品筹备中！敬请期待...</div>
    <?php endif;?>
  </div>
</div>
<!-- <?php echo $output['web_name'];?>end -->