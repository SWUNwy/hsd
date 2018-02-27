<div class="shop-notice-list-wrap" id="mainWrap">
		<div>
		
		<form method="get" action="index.php" target="_self" id="form_search">
		   <input type="hidden" name="m" value="store_article">
    		<input type="hidden" name="a" value="index">
    		    	
    					<table class="w-100" id="searchWrapTable">
				<tbody>
					<tr>
						<td class="pt-10 pb-10 pl-10 ta-l w-25"><label class="d-ib height-30 pl-10 search-label">标题:</label><input type="text" class="ipt w-55" name="article_title" value="<?php echo $_GET['article_title']?>" style="width: 310px"> <span class="btn search-btn mr-5 ml-30"><i class="icon iconfont"></i>查询</span></td>

					</tr>
					<?php if(!empty($output['article_class'])) {?>
					<tr style="">
						<td class="pb-10 pl-10 ta-l pos-r"><label
							class="w-100px ta-r d-ib height-30">分类：</label>
							<div class="d-ib  w-80 bc-wrap" id="cateBox">
								<div id="cateWrap" class="clearfix J-cb-inner">
									<a href="index.php?act=store_article&op=index" data-id="" class="cate-link <?php echo $_GET['c_id']==""?"active":"" ?>">全部</a> 
									
									      <?php foreach ($output['article_class'] as $gc) {?>
									  <a href="index.php?act=store_article&op=index&c_id=<?php echo $gc['ac_id']; ?>"	data-id="406b45d8fa4b42989e6be72ed6c9b664" class="cate-link <?php echo $_GET['c_id']== $gc['ac_id']?"active":"" ?>"><?php echo $gc['ac_name']; ?></a>	
									      <?php }?>
									
									
									
									
									
								</div>
							</div> <a class="pos-a w-40px height-30 cur-p d-n J-more-link"
							style="display: none;">更多<i class="icon iconfont"></i></a></td>
					 </tr>
					<?php }?>
					

				</tbody>
			</table>
			
		</form>
		
			<table class="w-100 jq-table article" id="shopNoticeList">
				<thead>
					<tr>
						<th width="30%" class="" data-field="title">标题</th>
						<th width="20%" class="" data-field="publishTimeStr">发布时间</th>
					</tr>
					
				</thead>
				<tbody>
				<?php if(!empty($output['article'])) {?>
					<?php foreach ($output['article'] as $v){?>				
					<tr class="odd">
						<td class="ta-l pl-20"><a style="color:<?php echo $v['article_title_color']?>"
							href="<?php echo urlShop('store_article', 'article', array('article_id'=>$v['article_id']));?>"><?php echo $v['article_title']?></a></td>
						<td class=""><?php echo date("Y-m-d", $v['article_time'])?></td>
					</tr>
					<?php }?>
				<?php }else{?>
				<tr class="odd">
						<td class="ta-l pl-20" colspan='2'>
						<center>没有相关记录</center>
						</td>
					</tr>
				
				<?php }?>	
					
				</tbody>
			</table>
			<div class="oprs-wrap of-h">
				<div class="page f-r clearfix" id="pageWrap">
					<div id="Pagination">
						<div class="pagination">
							<?php echo $output['show_page'];?> 
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<script type="text/javascript">
$(function(){

	$(".search-btn").click(function(){
		$("#form_search").submit();

	});
	

	
});
</script>

	