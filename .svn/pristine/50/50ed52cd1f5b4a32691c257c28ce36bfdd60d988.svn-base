<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<style>
html, body{
	 overflow:hidden;
}
</style>
  <form id="add_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />  
    <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']?>" />   
    <div class="ncap-form-default">
     <dl class="row">
        <dt class="tit">
          <label><em></em>快递公司：</label>
        </dt>
        <dd class="opt">   
          <select name="express" id="express" class="w100">       
            <option value="">请选择</option>
            <?php if(!empty($output['express_list'])) {?>
            <?php foreach ($output['express_list'] as $express) {?>            
                 <option value="<?php echo $express['id']?>" <?php echo $output['order_info']['extend_order_common']['shipping_express_id']==$express['id']?'selected="selected"':''?> ><?php echo $express['e_name']?></option>
            <?php }?>
            <?php }?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl> 
      
      <dl class="row">
        <dt class="tit">
          <label><em></em>快递单号：</label>
        </dt>
        <dd class="opt">   
          <input class="txt2" type="text" id="shipping_code" name="shipping_code" value="<?php echo $output['order_info']['shipping_code']?>">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>       
      <div class="bot"><a href="JavaScript:void(0);"  onclick="user_add(this)" class="ncap-btn-big ncap-btn-green">确认</a></div>
    </div>
  </form>


<script>
function user_add(d){
	var form_submit=$("input[name='form_submit']");
	var order_id=$("input[name='order_id']");
	var express=$("#express");
	var shipping_code=$("#shipping_code");

	$.post("index.php?m=order&a=kd_set",{
    		form_submit:form_submit.val(),
    		order_id:order_id.val(),
    		express:express.val(),    
    		shipping_code:shipping_code.val(),  		     		
    	},function(ret){
    		if(ret.status==1){
    			 /*
    			 parent.layer.msg(ret.msg, {
    				offset: 200,
    				shift: 2
    			});
    			*/
    			parent.window.location.reload();
    			// setTimeout(parent.window.location.reload(),3000);    			
    		}else{
    			alert(ret.msg);
    			/*layer.msg(ret.msg, {
    				offset: 200,
    				shift: 2
    			});*/
    		}
    	},'json'
    )			
}
</script> 
