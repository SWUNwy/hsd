<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>商家管理中心登录</title>
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/common.css" rel="Stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/iconfont.css" rel="Stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/ui-dialog.css" rel="Stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/login.css" rel="Stylesheet" type="text/css">
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/dialog-minv6.js" type="text/javascript"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
</head>
<body>
<div class="login-container">
  <div class="va-m w-100" style="display: table-cell">
    <div class="login-box">
      <div id="logobox" class="bg-w pos-a w-100 of-h"> <img class="ml-50" src="<?php echo SHOP_TEMPLATES_URL?>/images/logo_02.png" alt=""> </div>
      <div class="login-outer">
        <div class="login-ipts">
          <form id="form_login" action="index.php?m=s_login&a=login" method="post" >
            <?php Security::getToken();?>
            <input name="nchash" type="hidden" value="<?php echo $output['nchash'];?>" />
            <input type="hidden" name="form_submit" value="ok" />
            <input type="hidden" name="ref_url" value="<?php echo $_GET['ref_url']?>" />
            <div class="ipt-wrap">
              <div class="ipt-icon"><i class="iconfont" style="font-size: 24px;"></i></div>
              <label class="placeholder d-n">请输入您的用户名</label>
              <span class="repuired"></span>
              <input name="seller_name" placeholder="请输入您的用户名" value="" id="seller_name" type="text" class="login-ipt" autocomplete="off">
              <span class="ico"><i class="icon-user"></i></span> </div>
            <div class="ipt-wrap">
              <div class="ipt-icon"><i class="iconfont" style="font-size: 24px;"></i></div>
              <label class="placeholder d-n">请输入您的密码</label>
              <input name="password" id="password" placeholder="请输入您的密码" type="password" class="login-ipt">
            </div>
            <div class="clearfix">
              <div class="ipt-wrap f-l w-50">
                <label class="placeholder d-n">请输入验证码</label>
                <input name="captcha" id="captcha" placeholder="请输入验证码" type="text" class="login-ipt" style="width:100%">
              </div>
              <div class="w-40 f-r" style="margin-top: 30px;"> <a href="javascript:void(0)" nctype="btn_change_seccode"><img src="index.php?m=seccode&a=makecode&nchash=<?php echo $output['nchash'];?>" name="codeimage" border="0" id="codeimage"></a> </div>
            </div>            
            <div onClick="login()" class="login-btn"> 登录 </div>
          </form>
        </div>
      </div>
    </div>
    <div class="link-wrap mt-40" style="margin-top: 60px">
      <div class="link-inner clearfix"  style="display:none">
        <ul>
          <li> <a class="cor-w" target="_blank" href="javascript:void(0)">
            <div class="col-wrap">
              <div class="link-icon" style=""> <i class="iconfont"></i> </div>
              申请加盟 </div>
            </a> </li>
          <li> <a class="cor-w" target="_blank" href="javascript:void(0)">
            <div class="col-wrap">
              <div class="link-icon"><i class="iconfont"></i></div>
              常见问题 </div>
            </a> </li>
          <li> <a class="cor-w" target="_blank" href="javascript:void(0)">
            <div class="col-wrap">
              <div class="link-icon"><i class="iconfont"></i></div>
              行业新闻 </div>
            </a> </li>
          <li> <a class="cor-w" target="_blank" href="javascript:void(0)">
            <div class="col-wrap">
              <div class="link-icon"><i class="iconfont"></i></div>
              备案查询 </div>
            </a> </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="w-100 mb-10 ta-c pos-a" style="top: 96%; left: 0; min-width: 1000px;">
    <p style="color: #999;">渝ICP备15011191号</p>
  </div>
</div>
<div class="footer"></div>
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
    enterKeyCheck(login);
    //更换验证码
    function change_seccode() {
        $('#codeimage').attr('src', 'index.php?m=seccode&a=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random());
        $('#captcha').select();
    }

    $('[nctype="btn_change_seccode"]').on('click', function() {
        change_seccode();
    });

   
  //Hide Show verification code
    $("#hide").click(function(){
        $(".code").fadeOut("slow");
    });
    $("#captcha").focus(function(){
        $(".code").fadeIn("fast");
    });

});
function enterKeyCheck(submitFun){
  $(document).keydown(function(event){
    if(event.keyCode==13){
      submitFun();
      return false;
    }
  });
}
// 验证码是否正确
function login(){  
  //表单验证
  if(loginValidate()){
    $('#form_login').submit();
  }
}
function req(tipText){
     var d = dialog({
      content: '<span style="color:red">'+tipText+'</span>',
       height:20
    });
    d.show();
    setTimeout(function () {
      d.close().remove();
    }, 2000);

}

function tips(s){
  var d = dialog({
      content:s
  });
  d.show();
  setTimeout(function () {
    d.close().remove();
  }, 2000);
}
function loginValidate(){
  //  reg= /^[A-Za-z,0-9,@,_,$,\u4E00-\u9FA5]+$/;
  var userName = $('#seller_name');
  if(!userName.val()){
    req("请输入用户名!");
    userName.focus();
    return false;
  }
   var reg= /^[A-Za-z,0-9,@,_,.,+,$,\u4E00-\u9FA5]+$/;

  if(!reg.test(userName.val())){
    req("不能有特殊字符!");
    userName.focus();
    return false;
  }

  var password = $("#password");
  if(!password.val()){
    req("请输入密码!");
    password.focus();
    return false;
  }

  var kaptcha = $("#captcha");
  if(!kaptcha.val()){
    req("请输入验证码!");
    kaptcha.focus();
    return false;
  }
  //验证码是否正确
  if(!checkkaptcha())
  {
    req("验证码错误!");
    $('#codeimage').attr('src', 'index.php?m=seccode&a=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random());
    $('#captcha').select();
    kaptcha.focus();
    return false;
  }
  return true;
}
function checkkaptcha()
{   
    var kaptcha = $("#captcha").val();
    var tag;
    $.ajax({
      url:"index.php?m=seccode&a=check&nchash=<?php echo $output['nchash'];?>",
      type:"get",
      async:false,
      data:{captcha:kaptcha},
    })
    .done(function(data) {
        if(data=="true"){          
          tag = true;
        }else{          
          tag = false;
        }        
    });
    return tag;    
}
</script>
</body>
</html>
