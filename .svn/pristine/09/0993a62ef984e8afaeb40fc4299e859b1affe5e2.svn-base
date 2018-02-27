<?php defined('ByShopKJYP') or exit('Access Invalid!');?>


<div class="add-order-wrap" style="magin-top: 50px;" id="mainWrap">
	<div class="m-20 b-1">
		<h4 class="bg-fa pt-10 pb-10 bb-1 fw-b pl-20 bt-1">商品列表</h4>
		<form id="form_search" method="get" action="index.php">
		<input type="hidden" name="m" value="store_goods_online" />
		<input type="hidden" name="a" value="index" />
		<div class="search-wrap ">
			<table class="w-100" id="searchWrap">
				<tbody>
					<tr>
						<td class="pt-10 pb-10 pl-10 ta-l"><label
							class="w-100px ta-r d-ib height-30">商品名称：</label> <input
							type="text" name="keyword" value="<?php echo $_GET['keyword']; ?>" class="w-200px ipt d-ib">							
							<span
							class="btn search-btn"><i class="icon iconfont"></i>查询</span>
							
							<span
							class="btn cart_btn" style="background: #1a182e; padding-right:0"><i class="icon iconfont">&#xe643</i>购物车						<p class="pos-r ml-5 d-ib fs-12 num-pop cart_num" id="cartNum"><?php echo $output['cart_goods_num'];?></p>
							</span>
								
							</td>
					</tr>
				
				
					<tr style="">
						<td class="pb-10 pl-10 ta-l pos-r"><label
							class="w-100px ta-r d-ib height-30">类目：</label>
							<div class="d-ib  w-80 bc-wrap" id="cateBox">
								<div id="cateWrap" class="clearfix J-cb-inner">
									<a href="index.php?m=store_goods_online&a=index" data-id="" class="cate-link <?php echo $_GET['gc_id_1']==""?"active":"" ?>">全部</a> 
									<?php if(!empty($output['goods_class'])) {?>
									      <?php foreach ($output['goods_class'] as $gc) {?>
									  <a href="index.php?m=store_goods_online&a=index&gc_id_1=<?php echo $gc['gc_id']; ?>&gc_id_2=<?php echo $_GET['gc_id_2']; ?>"	data-id="406b45d8fa4b42989e6be72ed6c9b664" class="cate-link <?php echo $_GET['gc_id_1']== $gc['gc_id']?"active":"" ?>"><?php echo $gc['gc_name']; ?></a>	
									      <?php }?>
									<?php }?>
									
									
									
									
								</div>
							</div> <a class="pos-a w-40px height-30 cur-p d-n J-more-link"
							style="display: none;">更多<i class="icon iconfont"></i></a></td>
					 </tr>
					
				
					<?php if(!empty($output['goods_class_two'])) {?>
					<tr style="">
						<td class="pb-10 pl-10 ta-l pos-r"><label
							class="w-100px ta-r d-ib height-30">类目：</label>
							<div class="d-ib  w-80 bc-wrap" id="cateBox">
								<div id="cateWrap" class="clearfix J-cb-inner">
									<a href="index.php?m=store_goods_online&a=index" data-id="" class="cate-link <?php echo $_GET['gc_id_2']==""?"active":"" ?>">全部</a> 
									<?php if(!empty($output['goods_class_two'])) {?>
									      <?php foreach ($output['goods_class_two'] as $gc) {?>
									  <a href="index.php?m=store_goods_online&a=index&gc_id_1=<?php echo $_GET['gc_id_1']; ?>&gc_id_2=<?php echo $gc['gc_id']; ?>"	data-id="406b45d8fa4b42989e6be72ed6c9b664" class="cate-link <?php echo $_GET['gc_id_2']== $gc['gc_id']?"active":"" ?>"><?php echo $gc['gc_name']; ?></a>	
									      <?php }?>
									<?php }?>
									
									
								</div>
							</div> <a class="pos-a w-40px height-30 cur-p d-n J-more-link"
							style="display: none;">更多<i class="icon iconfont"></i></a></td>
					 </tr>
					
					
					
					
					<?php }?>
					
					
					<tr style="display: none">
						<td class="pb-10 pl-10 ta-l pos-r"><label
							class="w-100px ta-r d-ib height-30">品牌：</label>
							<div class="d-ib w-80 bc-wrap" id="brandBox"
								style="height: 30px;">
								<div class="clearfix J-cb-inner" id="brandWrap">
									<a data-id="" class="cate-link active">全部</a> 
									
								</div>

							</div> <a class="pos-a w-40px height-30 cur-p d-n J-more-link"
							style="display: inline;">更多<i class="icon iconfont"></i></a></td>
					</tr>

				</tbody>
			</table>
			</div>
			
			
		</form>
		<table class="ncsc-default-table goods-list-wrap" id="goodsListTable">
			<thead>
				<tr nc_type="table_header">
					<th class="w30">&nbsp;</th>
					<th class="w50">&nbsp;</th>
					<th class="w180" coltype="editable" column="goods_name" checker="check_required"
						inputwidth="230px"><?php echo $lang['store_goods_index_goods_name'];?></th>
					<th class="w180"></th>
					<th width="20%" class="" data-field="spec">规格&nbsp;</th>
                	<th class="w180"><?php echo $lang['store_goods_index_price'];?></th>
					<th class="w180"><?php echo $lang['store_goods_index_stock'];?></th>
					
					<th class="w180"><?php echo $lang['nc_handle'];?></th>
				</tr>
    <?php if (!empty($output['goods_list'])) { ?>
    
    <?php } ?>
  </thead>
			<tbody>
    <?php if (!empty($output['goods_list'])) { ?>
    <?php foreach ($output['goods_list'] as $val) { ?>
    <tr <?php $val['num_ss']==0?"":""?> >
					<th class="tc"></th>
					<th colspan="20">平台货号：<?php echo $val['goods_commonid'];?></th>
				</tr>
				<tr>
					<td class="trigger" style="height:85px"></td>
					<td class="transparent_class"><div class="pic-thumb">
							<a
								href="javascript:void(0)"
								target="_blank"><img src="<?php echo thumb($val, 60);?>" /></a>
						</div></td>
					<td class="tl"><dl class="goods-name">
							<dt style="max-width: 450px !important;">
            <?php if ($val['is_virtual'] ==1) {?>
            <span class="type-virtual" title="虚拟兑换商品">虚拟</span>
            <?php }?>
            <?php if ($val['is_fcode'] ==1) {?>
            <span class="type-fcode" title="F码优先购买商品">F码</span>
            <?php }?>
            <?php if ($val['is_presell'] ==1) {?>
            <span class="type-presell" title="预先发售商品">预售</span>
            <?php }?>
            <?php if ($val['is_appoint'] ==1) {?>
            <span class="type-appoint" title="预约销售提示商品">预约</span>
            <?php }?>
            <a
									href="javascript:void(0)"
									target="_blank"><?php echo $val['goods_name_highlight']; ?></a>
							</dt>

						</dl>
						
						
						</td>
					
						<td>
					
						<?php if($val['goods_storage']==0){?>
						 <p class="yiqiangg"><span class="yiqianggbg">&nbsp;</span><img src="<?php echo SHOP_TEMPLATES_URL?>/images/yqiangguang2.png" class="yqiangguang2"></p>
						<?php }?>
						
						</td>
						
						
					<td width="20%">
						1件
					</td>	
					
					<td class="guidePriceTd">
				
					<div class="lh-18"><?php echo  $lang['currency']."110"?></div>
					</td>
					
					
				
      
      <?php if($val['goods_storage']>=10){?>
	  <td><span>充足</span></td>
	  <?php }else if($val['goods_storage']<10 && $val['goods_storage']>0){ ?>
	  <td><span style="color:red">紧张</span></td>
		<?php }else if($val['goods_storage']==0) { ?>
		<td><span>售完</span></td>
	 	<?php }?>
					
		<td class="nscs-table-handle">
		<span><a href="javascript:void(0)" 	class="btn-blue  addcart" goods_id="<?php echo $val['goods_id'] ?>">
								<p>加入购物车</p>
							</a>
							</span>
		<span><a href="javascript:void(0)" class="btn-blue  buynow" goods_id="<?php echo $val['goods_id'] ?>">
								<p>立即购买</p>
							</a></span>
        </td>
        
       			</tr>
				<tr style="display: none;">
					<td colspan="20"><div class="ncsc-goods-sku ps-container"></div></td>
				</tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
					<td colspan="20" class="norecord"><div class="warning-option">
							<i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span>
						</div></td>
				</tr>
    <?php } ?>
  </tbody>
			<tfoot>
    <?php  if (!empty($output['goods_list'])) { ?>
   
    <tr>
					<td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
				</tr>
    <?php } ?>
  </tfoot>
		</table>
	</div>
</div>
<form id="buynow_form" method="post" action="<?php echo SHOP_SITE_URL;?>/index.php">
  <input id="m" name="m" type="hidden" value="store_buy" />
  <input id="a" name="a" type="hidden" value="buy_step1" />
  <input id="cart_id" name="cart_id[]" type="hidden"/>
</form>
<script>

$(function(){
	//购物车
	$(".addcart").click(function(event) {
		var goods_id = $(this).attr('goods_id');
		store_addcart(goods_id,1,'addcart_callback');
	});
	//立即购买
	$(".buynow").click(function(event) {
		var goods_id = $(this).attr('goods_id');
		quantity = 1;
        $("#cart_id").val(goods_id+'|'+quantity);		
 		$("#buynow_form").submit();


	});

	if($("#cateWrap").height()>30)
	{
		$('.J-more-link').css({"display":"inline" });
	}
	$(".search-btn").click(function(){
			
		$("#form_search").submit();
	});

	$(".item-cart").mouseover(function() {		
		load_cart_info();
	});

	$(".cart_btn").click(function() {		
		window.location = "index.php?m=store_cart";
	});
	
	
 
});


</script>