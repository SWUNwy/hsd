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
          <label><em></em>订单备注：</label>
        </dt>
        <dd class="opt">          
         <textarea rows="6" class="tarea" cols="60" name="order_remark" id="order_remark"><?php echo $output['order_info']['order_remark']?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>    
        
      <div class="bot"><a href="JavaScript:void(0);"  onclick="user_add(this)" class="ncap-btn-big ncap-btn-green"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>


<script>
function user_add(d){
	var form_submit=$("input[name='form_submit']");
	var order_id=$("input[name='order_id']");
	var order_remark=$("#order_remark");
   
	$.post("index.php?m=order&a=add_order_remark",{
    		form_submit:form_submit.val(),
    		order_id:order_id.val(),
    		order_remark:order_remark.val(),  		     		
    	},function(ret){
    		if(ret.status==1){
    			 parent.layer.msg(ret.msg, {
    				offset: 200,
    				shift: 2
    			});
    			parent.window.location.reload();
    			// setTimeout(parent.window.location.reload(),3000);
    			
    		}else{
    			layer.msg(ret.msg, {
    				offset: 200,
    				shift: 2
    			});
    		}
    	},'json'
    )			
}
</script> 
