<div class="goods-gallery add-step2"><a class='sample_demo' id="select_submit" href="index.php?m=store_album&a=pic_list_1&item=goods" style="display:none;"><?php echo $lang['nc_submit'];?></a>
  <div class="nav"><span class="l"><?php echo $lang['store_goods_album_users'];?>
    <?php if(isset($output['class_name']) && $output['class_name'] != ''){echo $output['class_name'];}else{?>
    <?php echo $lang['store_goods_album_all_photo'];?>
    <?php }?>
    </span><span class="r">
    <select name="jumpMenu" id="jumpMenu" style="width:100px;">
      <option value="0" style="width:80px;"><?php echo $lang['nc_please_choose'];?></option>
      <?php foreach($output['class_list'] as $val) { ?>
         <option style="width:80px;" value="<?php echo $val['id']; ?>" <?php if($val['id']==$_GET['id']){echo 'selected';}?>><?php echo $val['layer'].$val['name']; ?></option>
 
      <?php } ?>
    </select>
       <input id="condition" style="height:22px" >
     <input type="button" id="search" value="搜索"  style="height:22px">
    </span></div>
  <?php if(!empty($output['pic_list'])){?>
  <ul class="list">
    <?php foreach ($output['pic_list'] as $v){?>
         <li onclick="insert_img('<?php echo $v['pic_path']?>','/picture/uploadfile/<?php echo $v['pic_path_240']?>', 0);"><a href="JavaScript:void(0);"><img src="/picture/uploadfile/<?php echo $v['pic_path_240']?>" title='<?php echo $v['pic_name']?>'/></a></li>
   
    <?php }?>
  </ul>
  <?php }else{?>
  <div class="warning-option"><i class="icon-warning-sign"></i><span>相册中暂无图片</span></div>
  <?php }?>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
</div>
<script>
$(document).ready(function(){
	$('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:'img',
		loadingMsg:SHOP_TEMPLATES_URL+'/images/loading.gif',
		target:'#demo'
	});
	$('#jumpMenu').change(function(){
		$('#select_submit').attr('href',$('#select_submit').attr('href')+"&id="+$('#jumpMenu').val());
		$('.sample_demo').ajaxContent({
			event:'click', //mouseover
			loaderType:'img',
			loadingMsg:SHOP_TEMPLATES_URL+'/images/loading.gif',
			target:'#demo'
		});
		$('#select_submit').click();
	});

$("#search").click(function(){
		
		if($("#condition").val() && $("#condition").val()!=''){
			var allOptions = $("#jumpMenu").children();
			
			$(allOptions).each(function(i){
				if($(allOptions[i]).html().indexOf($("#condition").val()) <= -1){
					$("#jumpMenu").append(allOptions[i]);
					$("#jumpMenu option").eq(0).attr('selected', 'true');
					
				
				}
			});
			
		}
		$('#select_submit').attr('href',$('#select_submit').attr('href')+"&id="+$('#jumpMenu').val());
		$('.sample_demo').ajaxContent({
			event:'click', //mouseover
			loaderType:'img',
			loadingMsg:SHOP_TEMPLATES_URL+'/images/loading.gif',
			target:'#demo'
		});
		$('#select_submit').click();
	});
	
});
</script>