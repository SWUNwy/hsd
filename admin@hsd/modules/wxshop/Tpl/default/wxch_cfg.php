<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>微信通设置</h3>
        <h5>微信通相关设置</h5>
      </div>
    </div>
  </div>
  <form method="post" name="settingForm" id="settingForm">
    <input type="hidden" name="form_submit" value="ok">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">微信端路径</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][0]['cfg_value'];?>" name="murl" id="murl" class="txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
     <dl class="row">
        <dt class="tit">网址</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][1]['cfg_value'];?>" name="baseurl" id="baseurl" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
     <dl class="row">
        <dt class="tit">图片路径</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][2]['cfg_value'];?>" name="imgpath" id="imgpath" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
       <dl class="row">
        <dt class="tit">搜索推荐</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][3]['cfg_value'];?>" name="plustj" id="plustj" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
      
       <dl class="row">
        <dt class="tit">默认密码</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][4]['cfg_value'];?>" name="userpwd" id="userpwd" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
       <dl class="row">
        <dt class="tit">重新绑定</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][5]['cfg_value'];?>" name="cxbd" id="cxbd" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
       <dl class="row">
        <dt class="tit">微信OAuth</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][6]['cfg_value'];?>" name="oauth" id="oauth" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
       <dl class="row">
        <dt class="tit">会员模式</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][7]['cfg_value'];?>" name="bd" id="bd" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
       <dl class="row">
        <dt class="tit">显示下架商品</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][8]['cfg_value'];?>" name="goods" id="goods" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
       <dl class="row">
        <dt class="tit">文章路径</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][9]['cfg_value'];?>" name="article" id="article" class="input-txt">
          
          <p class="notic"></p>
        </dd>
      </dl>
      
       <dl class="row">
        <dt class="tit">会员名前缀</dt>
        <dd class="opt">
          <input type="text" value="<?php echo $output['wxch_cfg'][10]['cfg_value'];?>" name="q_name" id="q_name" class="input-txt">
          
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



