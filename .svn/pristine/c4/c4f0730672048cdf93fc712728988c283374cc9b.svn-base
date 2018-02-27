<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<style>
html, body{
	 overflow:hidden;
}
</style>
  <form id="add_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />  
    <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />   
    <div class="ncap-form-default">
     <dl class="row">
        <dt class="tit">
          <label><em>*</em>仓库：</label>
        </dt>
        <dd class="opt">          
            <select name="c_s_id" id="c_s_id" style="width:100px;">
                  <option value="0" >请选择</option>
                  <?php foreach ($output['ci_storage_list'] as $value) { ?>
                     <option value="<?php echo $value['id']?>" ><?php echo $value['name']?></option>
                  <?php }?>
           </select>
          <span class="err"></span>
          <p class="notic">不选择则不修改</p>
        </dd>
      </dl>    
     <dl class="row">
        <dt class="tit">
          <label><em>*</em>发货仓：</label>
        </dt>
        <dd class="opt">
          <select name="s_id" id="s_id" style="width:100px;">
                  <option value="0" >请选择</option>
                  <?php foreach ($output['storage_list'] as $value) { ?>
                     <option value="<?php echo $value['s_id']?>" ><?php echo $value['s_name']?></option>
                  <?php }?>
           </select>
          <span class="err"></span>
          <p class="notic">不选择则不修改</p>
        </dd>
      </dl>
       <dl class="row">
        <dt class="tit">
          <label><em>*</em>快递：</label>
        </dt>
        <dd class="opt">          
            <select name="express_id" id="express_id" style="width:100px;">
                  <option value="0" >请选择</option>
                  <?php foreach ($output['express_list'] as $value) { ?>
                     <option value="<?php echo $value['id']?>" ><?php echo $value['e_name']?></option>
                  <?php }?>
           </select>
          <span class="err"></span>
          <p class="notic">不选择则不修改</p>
        </dd>
      </dl>        
      <div class="bot"><a href="JavaScript:void(0);"  onclick="user_add(this)" class="ncap-btn-big ncap-btn-green"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>


<script>
function user_add(d){
	var form_submit=$("input[name='form_submit']");
	var id=$("input[name='id']");
	var c_s_id=$("select[name='c_s_id']").val();		
	var s_id=$("select[name='s_id']").val();
	var express_id=$("select[name='express_id']").val();	

	$.post("index.php?m=order&a=set_option",{
    		form_submit:form_submit.val(),
    		id:id.val(),
    		c_s_id:c_s_id,
  		    s_id:s_id,
    		express_id:express_id,    		
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
