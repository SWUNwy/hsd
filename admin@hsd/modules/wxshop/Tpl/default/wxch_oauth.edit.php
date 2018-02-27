<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<style>
html, body{
	 overflow:hidden;
}
</style>
  <form id="add_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="oid" value="<?php echo $_GET['oid']?>" />
    <div class="ncap-form-default">
     
     <dl class="row">
        <dt class="tit">
          <label><em>*</em>规则名称：</label>
        </dt>
        <dd class="opt">
          <input type="text" id="name" name="name" value="<?php echo $output['wxch_oauth']['name']?>" class="input-txt">      
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
       <dl class="row">
        <dt class="tit">
          <label><em>*</em>网址：</label>
        </dt>
        <dd class="opt">          
          <input type="text" id="contents" name="contents"  value="<?php echo $output['wxch_oauth']['contents']?>" class="input-txt">      
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
	var oid=$("input[name='oid']");
	var name=$("input[name='name']");
	var contents=$("input[name='contents']");
	if(name.val()==''){		
		layer.tips('规则名称不能为空', s_name);
		name.focus();
		return false
	}
	if(contents.val()==''){		
		layer.tips('网址不能为空', s_name);
		contents.focus();
		return false
	}

	$.post("index.php?m=oauth&a=oauthedit",{
    		form_submit:form_submit.val(),
    		oid:oid.val(),
    		name:name.val(),
    		contents:contents.val(),
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
