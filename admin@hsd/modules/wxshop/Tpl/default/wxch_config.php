<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>微信接口</h3>
        <h5>微信接口相关设置</h5>
      </div>
    </div>
  </div>
  <form method="post" name="settingForm" id="settingForm">
    <input type="hidden" name="form_submit" value="ok">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">Token</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_config']['token'];?>" name="token" id="token" class="txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
     <dl class="row">
        <dt class="tit">AppId</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_config']['appid'];?>" name="appid" id="appid" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
     <dl class="row">
        <dt class="tit">AppSecret</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_config']['appsecret'];?>" name="appsecret" id="appsecret" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
    
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
    </div>
  </form>
</div>
<script>
$(function(){
	$("#submitBtn").click(function(){
        if($("#settingForm").valid()){
           $("#settingForm").submit();
    	}
	});
});
</script>



