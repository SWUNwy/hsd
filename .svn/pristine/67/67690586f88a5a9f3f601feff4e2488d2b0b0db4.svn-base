<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<style>
.log{
	color:#FFF;
}
.log:hover{
	color: #F00;
}
</style>
<input type="hidden" id="basePath" value="">
<div class="header clearfix bg-red pos-r">
  <div class=" f-l w-200px pl-20" style="width: 255px"> <a href="<?php echo SHOP_SITE_URL;?>"> <img src="<?php echo UPLOAD_SITE_URL.'/seller_center_logo1.jpg'?>" width="255" height="60" class="d-b"> </a> </div>
  <div class=" f-r pt-15 cor-w ta-r ov-f" style="width:300px;height: 45px;">
    <div class="d-ib pl-10 height-30 cor-cs w-120px of-h" title="<?php echo $_SESSION['seller_name'];?>"><?php echo $_SESSION['seller_name'];?>
    	<?php if($_SESSION['store_id']>0){ ?>
        <span style="color:#FFF;padding-right:10px;padding-left:10px;">|</span>
        <?php }else{ ?>
        <span style="color:#000;padding-right:10px;padding-left:10px;">|</span>
        <?php } ?>
    </div>
    <!--<div class="d-ib pr-10 height-30 pl-10"> <a href="javascript:void(0)"><i class="iconfont mr-10 cur-p cor-grey5" style="font-size: 18px"></i></a><span>|</span> </div>-->
    <?php if($_SESSION['store_id']>0){ ?>
    <div class="d-ib height-30 cur-p cor-grey5 mr-20" id="setupBtn"> 设置<i class="icon iconfont ml-5"></i> </div>
    <?php }else{ ?>
    <div style="line-height: 0;display: inline-block;vertical-align: -7px;margin-right:40px;">
    	<a href="/member/index.php?m=login&a=index" style="color:#F00">
			<i class="icon iconfont mr-10 cor-green" style="font-size:18px;">&#xe650;</i>
            <span class="log" style="vertical-align: top;font-size: 16px;">登录</span>
		</a>
    </div>
    <?php } ?>
  </div>
  <div class="pl-20 pr-10 height-30 pt-15 fs-16 first-menu">
    <?php if(!empty($output['menu']) && is_array($output['menu'])) {?>
    <?php foreach($output['menu'] as $key => $menu_value) {?>
    <span class="mr-40 pos-r d-ib"> <a href="index.php?m=<?php echo $menu_value['child'][key($menu_value['child'])]['m'];?>&a=<?php echo $menu_value['child'][key($menu_value['child'])]['a'];?>" class="cor-w cur-p <?php echo $output['current_menu']['model'] == $key?'active':'';?>"><?php echo $menu_value['name'];?><span>■</span></a> </span>
    <?php } ?>
    <?php } ?>
    <input type="hidden" id="xxoo" name="xoxo" value="dt:4 zd:0 bd:false bmd:false">
  </div>
  
  <!--<iframe style="position:absolute;top:0;left:0;z-index:-1;width:100%; height:60px;background:none;" scrolling="no" frameborder="0"></iframe>--> 
</div>
<script id="sysConfigTpl" type="text/tpl">
    <ul id="configWrap">
    <?php if($_SESSION['store_type']==1|| $_SESSION['store_type']==3){ ?>      
        <li id="change" class="height-30 pt-5 pb-5 pl-10 bb-1 cur-p cor-grey6 password-modify " >
            <i class="icon iconfont mr-10 cor-green" style="font-size:18px;">  &#xe65e; </i><?php echo $_SESSION['is_quick']==1?"商家中心":"快速代下单"?>
        </li>
        <?php }?>
		<?php if($_SESSION['store_id']>0){ ?>
        <li id="editPasswordBtn" class="height-30 pt-5 pb-5 pl-10 bb-1 cur-p cor-grey6 password-modify"><i class="icon iconfont mr-10 cor-green" style="font-size:18px;">&#xe650;</i>修改密码</li>
		<li id="loginOutBtn" class="height-30 pt-5 pb-5 pl-10 cur-p cor-grey6 login-out"><i class="icon iconfont mr-10 cor-cs" style="font-size:18px;">&#xe6d8;</i>退出</li>
		<?php } ?>
    </ul>
</script> 

<!--切换商家--> 
<script id="changeTpl" type="text/tpl">
    <div id="editPasswordWrap">
        <table>
            <tr>
                <td class="pb-10">密码：</td>
                <td class="pb-10">
                    <input class="ipt" type="password" id="formerPwd" name="formerPwd" />
                </td>
            </tr>
            
        </table>
    <div>
</script> 
<!--<script id="sysConfigTpl" type="text/tpl">
    <ul id="configWrap" class="of-h">
                <li id="setPriceCheckbox" class="height-30 pt-5 pb-5 pl-10 bb-1 cur-p cor-grey6 password-modify active">
                    <i class="icon iconfont mr-10 cor-green" style="font-size:18px;"> &#xe65d; </i>价格可见
                </li>
        <li id="editPasswordBtn" class="height-30 pt-5 pb-5 pl-10 bb-1 cur-p cor-grey6 password-modify"><i class="icon iconfont mr-10 cor-green" style="font-size:18px;">&#xe650;</i>修改密码</li>
        <li class="height-30 pt-5 pb-5 pl-10 cor-grey6">
			<i class="icon iconfont mr-10 cor-green" style="font-size:18px;">&#xe6b3;</i>管理员
        </li>
        <li  class="height-30 pt-5 pb-5 pl-40 cor-grey6 ">18623448938</li>
        <li class="height-30 pt-5 pb-5 pl-10 bb-1 cor-grey6"><a href="/admin/help/faq"><i class="icon iconfont mr-10 cor-green" style="font-size:18px;">&#xe634;</i>帮助中心</a></li>
        <li id="loginOutBtn" class="height-30 pt-5 pb-5 pl-10 cur-p cor-grey6 login-out bt-1"><i class="icon iconfont mr-10 cor-cs" style="font-size:18px;">&#xe6d8;</i>退出</li>
    </ul>
</script> -->

<!--修改密码--> 
<script id="editPasswordTpl" type="text/tpl">
    <div id="editPasswordWrap">
        <table>
            <tr>
                <td class="pb-10">原密码：</td>
                <td class="pb-10">
                    <input class="ipt" type="password" id="formerPwd" name="formerPwd" />
                </td>
            </tr>
            <tr>
                <td class="pb-10">新密码：</td>
                <td class="pb-10"><input class="ipt" type="password" id="pwd1"/></td>
            </tr>
            <tr>
                <td id="password2" class="pb-10">重复密码：</td>
                <td class="pb-10"><input class="ipt" type="password" id="pwd2" /></td>
            </tr>
        </table>
    <div>
</script>