<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>订单设置 </h3>
        <h5>订单设置</h5>
      </div>
      <ul class="tab-base nc-row">
        <li><a class="current" ><span>订单设置</span></a></li>
        <li><a href="index.php?m=storage" ><span>发货仓设置</span></a></li>
      </ul>
    </div>
  </div>
  <form id="order_set_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label><em></em>下单地址不得包含:</label>
        </dt>
        <dd class="opt">          
          <input type="text" value="<?php echo $output['list_setting']['address_rule'];?>" name="address_rule" id="address_rule" class="input-txt" style="width:60px">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
       <dl class="row">
        <dt class="tit">
          <label><em></em>提示信息:</label>
        </dt>
        <dd class="opt">          
          <textarea name="address_message" rows="6" class="tarea" id="address_message"><?php echo $output['list_setting']['address_message'];?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><em></em>相同身份证一月下单数:</label>
        </dt>
        <dd class="opt">          
          <input type="text" value="<?php echo $output['list_setting']['order_same_idcard'];?>" name="order_same_idcard" id="order_same_idcard" class="input-txt" style="width:60px">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
       <dl class="row">
        <dt class="tit">
          <label><em></em>提示信息:</label>
        </dt>
        <dd class="opt">          
          <textarea name="order_same_idcard_msg" rows="6" class="tarea" id="order_same_idcard_msg"><?php echo $output['list_setting']['order_same_idcard_msg'];?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><em></em>相同地址一月下单:</label>
        </dt>
        <dd class="opt">          
          <input type="text" value="<?php echo $output['list_setting']['order_same_address'];?>" name="order_same_address" id="order_same_address" class="input-txt" style="width:60px">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
       <dl class="row">
        <dt class="tit">
          <label><em></em>提示信息:</label>
        </dt>
        <dd class="opt">          
          <textarea name="order_same_address_msg" rows="6" class="tarea" id="order_same_address_msg"><?php echo $output['list_setting']['order_same_address_msg'];?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><em></em>相同电话一月下单数:</label>
        </dt>
        <dd class="opt">          
          <input type="text" value="<?php echo $output['list_setting']['order_same_phone'];?>" name="order_same_phone" id="order_same_phone" class="input-txt" style="width:60px">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
       <dl class="row">
        <dt class="tit">
          <label><em></em>提示信息:</label>
        </dt>
        <dd class="opt">          
          <textarea name="order_same_phone_msg" rows="6" class="tarea" id="order_same_phone_msg"><?php echo $output['list_setting']['order_same_phone_msg'];?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>      
      <dl class="row">
        <dt class="tit">
          <label><em></em>每天提交海关总额:</label>
        </dt>
        <dd class="opt">          
          <input type="text" value="<?php echo $output['list_setting']['order_post_amount'];?>" name="order_post_amount" id="order_post_amount" class="txt" style="width:60px">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>      
      <dl class="row">
        <dt class="tit">
          <label><em></em>海关平台提交单数:</label>
        </dt>
        <dd class="opt">          
         <input type="text" value="<?php echo $output['list_setting']['order_post_num'];?>" name="order_post_num" id="order_post_num" class="txt" style="width:60px">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      
      <dl class="row" style="display: none">
        <dt class="tit">
          <label><em></em>默认发货仓库:</label>
        </dt>
        <dd class="opt"> 
         <select name="order_storage_id" id="order_storage_id" style="width:100px;">
                  <option value="0" >请选择</option>
                  <?php foreach ($output['storage_list'] as $value) { ?>
                     <option value="<?php echo $value['s_id']?>" <?php if ($output['list_setting']['order_storage_id'] == $value['s_id']) echo 'selected';?> ><?php echo $value['s_name']?></option>
                  <?php }?>
           </select>         
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>

<script>
$(function(){
  $("#submitBtn").click(function(){     
       $("#order_set_form").submit();   
  });
});
</script> 
