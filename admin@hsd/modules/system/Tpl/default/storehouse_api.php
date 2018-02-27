<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
            <h3>淘宝仓接口</h3>
            <h5>淘宝仓接口账号设置</h5>
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
  <form id="add_form" method="post" action="index.php?m=storehouse_api&a=storehouse_api_save">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="">API网址</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['tao_url'];?>" name="tao_url" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">dhfcode</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['tao_dhfcode'];?>" name="tao_dhfcode" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">secretcode</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['tao_secretcode'];?>" name="tao_secretcode" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl> 
      <dl class="row">
        <dt class="tit">
          <label for="">快递企业</label>
        </dt>
        <dd class="opt">
          <input type="radio" value="ems" name="tao_express" <?php echo $output['setting']['tao_express']=="ems"?"checked":"" ?>>EMS邮政
          <input type="radio" value="yto" name="tao_express" <?php echo $output['setting']['tao_express']=="yto"?"checked":"" ?>>圆通
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
