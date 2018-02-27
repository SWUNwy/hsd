<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
            <h3>海关接口</h3>
            <h5>海关接口账号设置</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>成功设置后订单可以通过接口提交到海关平台</li>
    </ul>
  </div>
  <form id="add_form" method="post" action="index.php?m=customs_api&a=customs_api_save">
    <div class="ncap-form-default">
      <!-- 海关接口开关 -->
      <dl class="row">
        <dt class="tit">
          <label>是否自动提交</label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="hg_enabled_1" class="cb-enable <?php if($output['setting']['hg_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><?php echo $lang['nc_open'];?></label>
            <label for="hg_enabled_0" class="cb-disable <?php if($output['setting']['hg_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><?php echo $lang['nc_close'];?></label>
            <input type="radio" id="hg_enabled_1" name="hg_isuse" value="1" <?php echo $output['setting']['hg_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="hg_enabled_0" name="hg_isuse" value="0" <?php echo $output['setting']['hg_isuse']==0?'checked=checked':''; ?>>
          </div>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">API网址</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['hg_url'];?>" name="hg_url" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">企业名称</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['hg_qyname'];?>" name="hg_qyname" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">海关10位编码</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['hg_user'];?>" name="hg_user" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">海关密码</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['hg_pwd'];?>" name="hg_pwd" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">dxpId</label>
        </dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['setting']['hg_dxpid'];?>" name="hg_dxpid" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="">验证类型</label>
        </dt>
        <dd class="opt">
          <input type=radio value="R" name="hg_type" <?php echo $output['setting']['hg_type']=="R"?"checked":"" ?> >收货人
          <input type=radio value="P" name="hg_type" <?php echo $output['setting']['hg_type']=="P"?"checked":"" ?> >支付人
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
