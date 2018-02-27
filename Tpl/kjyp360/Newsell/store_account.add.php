<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="add-order-wrap" style="magin-top:50px;" id="mainWrap">
   <div class="m-20 b-1">
     <h4 class="bg-fa pt-10 pb-10 bb-1 fw-b pl-20 bt-1">新增账号</h4>
<div class="ncsc-form-default">
  <form id="add_form" action="<?php echo urlShop('store_account', 'account_save');?>" method="post">
    <dl>
      <dt><i class="required">*</i>用户名<?php echo $lang['nc_colon'];?></dt>
      <dd><input class="w120 text" name="member_name" type="text" id="member_name" value="" />
          <span></span>
        <p class="hint"></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>用户密码<?php echo $lang['nc_colon'];?></dt>
      <dd><input class="w120 text" name="password" type="password" id="password" value="" />
          <span></span>
        <p class="hint"></p>
      </dd>
    </dl>
   <dl id="function_list">
      <dt><i class="required">*</i>权限<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-account-all">
          <input id="btn_select_all" name="btn_select_all" class="checkbox" type="checkbox" />
          <label for="btn_select_all">全选</label>
          <span></span>
          <?php if(!empty($output['menu']) && is_array($output['menu'])) {?>
          <?php foreach($output['menu'] as $key => $value) {?>
        </div>
        <div class="ncsc-account-container">
          <h4>
            <input id="<?php echo $key;?>" class="checkbox" nctype="btn_select_module" type="checkbox" />
            <label for="<?php echo $key;?>"><?php echo $value['name'];?></label>
          </h4>
          <?php $submenu = $value['child'];?>
          <?php if(!empty($submenu) && is_array($submenu)) {?>
          <ul class="ncsc-account-container-list">
            <?php foreach($submenu as $submenu_value) {?>           
            <li>
              <?php if($submenu_value['m']!="store_multiple" && $submenu_value['m']!="store_account" && $submenu_value['name']!="待支付订单") {?>
              <input id="<?php echo $submenu_value['m'];?>" class="checkbox" name="limits[]" value="<?php echo $submenu_value['m'];?>" <?php if(!empty($output['group_limits'])) {if(in_array($submenu_value['m'], $output['group_limits'])) { echo 'checked'; }}?> type="checkbox" />
              <label for="<?php echo $submenu_value['m'];?>"><?php echo $submenu_value['name'];?></label>
              <?php } ?>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <p class="hint"></p>
      </dd>
    </dl>    
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>">
      </label>
    </div>
  </form>
</div>
</div>
</div>
<script>
$(document).ready(function(){

	$('#btn_select_all').on('click', function() {
        if($(this).prop('checked')) {
            $(this).parents('dd').find('input:checkbox').prop('checked', true);
        } else {
            $(this).parents('dd').find('input:checkbox').prop('checked', false);
        }
     });
	 $('[nctype="btn_select_module"]').on('click', function() {
	        if($(this).prop('checked')) {
	            $(this).parents('.ncsc-account-container').find('input:checkbox').prop('checked', true);
	        } else {
	            $(this).parents('.ncsc-account-container').find('input:checkbox').prop('checked', false);
	        }
	    });
	
	  jQuery.validator.addMethod("function_check", function(value, element) {       
	        var count = $('#function_list').find('input:checkbox:checked').length;
	        return count > 0;
	    });    

   
    $('#add_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
    	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},
        rules: {
            member_name: {
                required: true
            },
            password: {
                required: true,
               
            },
            btn_select_all: {
                function_check: true 
            }
            
        },
        messages: {
            member_name: {
                required: '<i class="icon-exclamation-sign"></i>用户名不能为空'
            },
            password: {
                required: '<i class="icon-exclamation-sign"></i>用户密码不能为空',
              
            },
            btn_select_all: {
                function_check: '请选择权限'
            }
        }
    });
});
</script> 
