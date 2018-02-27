<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
            <h3>仓库接口</h3>
            <h5>仓库接口账号设置</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>成功设置后订单可取圆通运单号或者推送订单</li>
    </ul>
  </div>
  <form id="add_form" method="post" action="index.php?m=storehouse_api&a=wms_save">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="">API网址</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['wms_url'];?>" name="wms_url" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">帐套号</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['wms_user'];?>" name="wms_user" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">密钥</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['wms_code'];?>" name="wms_code" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl> 
      <dl class="row">
        <dt class="tit">
          <label for="">key</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['wms_key'];?>" name="wms_key" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl> 
      <dl class="row">
        <dt class="tit">
          <label for="">快递企业</label>
        </dt>
        <dd class="opt">
          <input type="radio" value="EMS" name="wms_express" <?php echo $output['setting']['wms_express']=="EMS"?"checked":"" ?>>EMS
          <input type="radio" value="YTO" name="wms_express" <?php echo $output['setting']['wms_express']=="YTO"?"checked":"" ?>>圆通
          <input type="radio" value="YD" name="wms_express" <?php echo $output['setting']['wms_express']=="YD"?"checked":"" ?>>韵达
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <div class="bot"><a id="submit" href="javascript:void(0)" class="ncap-btn-big ncap-btn-green"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#submit").click(function(){
        $("#add_form").submit();
    });
});
</script> 
