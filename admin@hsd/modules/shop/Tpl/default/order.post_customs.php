<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<style>
.loading{ 
		margin: 0 auto;
    width: 120px;
    padding: 80px;
}
</style>
<div class="ncap-form-default">
	<div class="ncap-form-default-box">
		  <div class="loading">
		  	<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/checking.gif"  />操作中，请等待.....
			</div>
  </div>
    <div class="bot"><a href="javascript:void(0);" id="close" class="ncap-btn-big ncap-btn-green" nctype="" style="display: none;">关闭</a></div>
  </div>
<style>
	.dialog_close_button{display: none;}
	.ncap-form-default-box{ height:200px; overflow-y: auto;}	
</style>
<script>
$(function(){
		$("#close").click(function(){
					 location.reload() ;
  				$(".dialog_close_button").click();
		});
		<?php if($output['count']>0) {?>
		var id ="<?php echo $output['id'] ?>";		
		var ids =id.split(',');	
		function doSomething(i){
	    $.getJSON("index.php?m=order&a=ajax_customs&order_id=" + ids[i-1], function(data) {	      
	        $(".loading").hide();
	        var str = '<dl class="row"><dt class="tit">订单ID:'+data.order_id+'</dt><dd class="opt">'+data.msg+'</dd></dl>'	;
	        $(".ncap-form-default-box").append(str);	       
	        if(i<<?php echo $output['count'] ?>){
	            //递归
	            doSomething(i+1);
	        }
	        else
	        {
	        	 $("#close").show();
	        }
	       
	    })
		}
		<?php } ?>
	
	//递归入口调用	
	doSomething(1);


});
</script>