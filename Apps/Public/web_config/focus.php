<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<?php if (is_array($output['code_screen_list']['code_info']) && !empty($output['code_screen_list']['code_info'])) : ?>
<div class="w-slider clearfix">
  <div id="SliderContent" class="sliderContent clearfix">
    <div class="slider-box clearfix">
     <?php foreach ($output['code_screen_list']['code_info'] as $key => $val) :?>
  		<?php if (is_array($val) && $val['ap_id'] > 0) : ?>

  		<?php else: ?>
      <div class="slider-unit bg-wating-big"> <a href="<?php echo $val['pic_url']!=""?$val['pic_url']:"javascript:void(0)";?>" data-rpno="22.1"> <img src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_img'];?>"> </a> </div>
      <?php endif;?>
 	  <?php endforeach;?>
    </div>
  </div>

  <div id="SliderTriggle" class="sliderTriggle"> <span class="prev"></span> <span class="next"></span>
    <div class="sliderCircle">
    	<?php $i = 0?>
		<?php foreach ($output['code_screen_list']['code_info'] as $key => $val) :?>
  		<?php if (is_array($val) && $val['ap_id'] > 0) : ?>

  		<?php else: ?>

    	<a class="<?php echo $i == 0?"cur":""; ?> pos-r d-ib" href="javascript:void(0);"><i class="iconfont" style="font-size: 38px;">&#xe6dd;</i><span class="pos-a a-num cor-w"><?php echo ++$i?></span></a>
    	<?php endif;?>
 	    <?php endforeach;?>
     </div>
  </div>
</div>
<?php endif;?>
