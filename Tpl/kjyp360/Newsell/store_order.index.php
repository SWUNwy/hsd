<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/orderList.js"	type="text/javascript"></script>
<link href="<?php echo SHOP_TEMPLATES_URL?>/seller_css/orderList.css" rel="stylesheet" type="text/css">
<div class="order-list-wrap">
 <input type="hidden" value="0" id="isHidePay"> <input type="hidden"
		value="0" id="isHidePrice">
	<div class="search-wrap">
		<form method="get" action="index.php" target="_self" id="form_search">
		   <input type="hidden" name="m" value="store_order" />
    		<input type="hidden" name="a" value="index" />
    		<?php if ($_GET['state_type']) { ?>
    			<input type="hidden" name="state_type" value="<?php echo $_GET['state_type']; ?>" />
    		<?php } ?>
			<table class="w-100" id="searchWrapTable">
				<tbody>
					<tr>
					<td class="pt-10 pb-10 pl-10 ta-l w-25"><label
							class="d-ib height-30 pl-10 search-label">订单编号:</label><input
							type="text" class="ipt w-55" name="order_sn" value="<?php echo $_GET['order_sn']; ?>"></td>
						<td class="pt-10 pb-10 pl-10 ta-l w-25"><label
							class="d-ib height-30 pl-10 search-label">扩展编号:</label><input
							type="text" class="ipt w-55" name="external_order" value="<?php echo $_GET['external_order']; ?>"></td>
						
						<td class="pt-10 pb-10 pl-10 ta-l w-25"><label
							class="d-ib height-30 pl-10 search-label">运单号:</label><input
							type="text" class="ipt w-55" name="shipping_code" value="<?php echo $_GET['shipping_code']; ?>"></td>

						<td class="pt-10 pb-10 pl-10 ta-l w-25"><label
							class="d-ib height-30 pl-10 search-label">买家用户名:</label> <input
							type="text" class="ipt w-55" name="buyer_name" value="<?php echo $_GET['buyer_name']; ?>" maxlength="11"
							id="custPhone"></td>
						<td class="pt-10 pb-10 pl-10 ta-l w-50" colspan="2"><label
							class="d-ib height-30 pl-10 search-label">下单时间:</label> <input
							type="text" style="width: 24%" class="ipt maxw-200" name="query_start_date"
							id="query_start_date" readonly=""
							value="<?php echo $_GET['query_start_date']?>">- <input type="text" style="width: 24%"
							class="ipt maxw-200" 					
							readonly="" id="query_end_date" value="<?php echo $_GET['query_end_date']?>" name="query_end_date"></td>

					</tr>
					<tr>
						
						<td class="pt-10 pb-10 pl-10 ta-l w-25"><label
							class="d-ib height-30 pl-10 search-label">订单状态:</label> <select
							class="select w-55 d-ib" name="state_type" id="state_type">
								<option value="">全部</option>								
								<option value="state_new">待支付</option>
						     	<option value="state_send">已发货</option>
								<option value="state_cancel">已关闭</option>
								<option value="state_success">已完成</option>
							
						</select></td>
							
						<td class="pt-10 pb-10 pl-10 ta-l w-25"><label
							class="d-ib height-30 pl-10 search-label">海关状态:</label> 
							<select name="messagecode" class="w100">
                                <option value=""><?php echo $lang['nc_please_choose'];?></option>
                                <option value="1" <?php echo $_GET['messagecode']==1?"selected":"" ?>>待提交</option>
                                <option value="20" <?php echo $_GET['messagecode']==20?"selected":"" ?>>待审核</option>
                                <option value="30" <?php echo $_GET['messagecode']==30?"selected":"" ?>>审核通过</option>
                                <option value="40" <?php echo $_GET['messagecode']==40?"selected":"" ?>>审核失败</option>
                                <option value="60" <?php echo $_GET['messagecode']==60?"selected":"" ?>>放行未结关</option>
                                <option value="70" <?php echo $_GET['messagecode']==70?"selected":"" ?>>结关</option>
                                <option value="770" <?php echo $_GET['messagecode']==770?"selected":"" ?>>转H220</option>
                                <option value="780" <?php echo $_GET['messagecode']==780?"selected":"" ?>>转快件</option>
                                <option value="790" <?php echo $_GET['messagecode']==790?"selected":"" ?>>转缉私</option>
                                <option value="810" <?php echo $_GET['messagecode']==810?"selected":"" ?>>退去货物</option>
                                <option value="830" <?php echo $_GET['messagecode']==830?"selected":"" ?>>其它处理</option>
                                <option value="840" <?php echo $_GET['messagecode']==840?"selected":"" ?>>已挂起</option>
                                <option value="850" <?php echo $_GET['messagecode']==850?"selected":"" ?>>没收</option>
                                <option value="80" <?php echo $_GET['messagecode']==80?"selected":"" ?>>退货</option>
                                <option value="860" <?php echo $_GET['messagecode']==860?"selected":"" ?>>强制退回</option>
                                <option value="90" <?php echo $_GET['messagecode']==90?"selected":"" ?>>审单挂起</option>
                                <option value="85" <?php echo $_GET['messagecode']==85?"selected":"" ?>>退货待审批</option>
                                <option value="510" <?php echo $_GET['messagecode']==510?"selected":"" ?>>退货待审批 </option>
                                <option value="520" <?php echo $_GET['messagecode']==520?"selected":"" ?>>退货自审批退回</option>
                                <option value="530" <?php echo $_GET['messagecode']==530?"selected":"" ?>>退货自动审批通过</option>
                                <option value="550" <?php echo $_GET['messagecode']==550?"selected":"" ?>>退货人工审批退回</option>
                                <option value="560" <?php echo $_GET['messagecode']==560?"selected":"" ?>>退货人工审批通过</option>
                                <option value="570" <?php echo $_GET['messagecode']==570?"selected":"" ?>>退货强制退回</option>
                                <option value="720" <?php echo $_GET['messagecode']==720?"selected":"" ?>>退货放行</option>
            
                            </select>
                            </td>
                             <?php if(!empty($output['store_list'])) {?>					
        						<td class="pt-10 pb-10 pl-10 ta-l w-25"><label
        							class="d-ib height-30 pl-10 search-label">店铺:</label> <select
        							class="select w-55 d-ib" name="store_id" id="store_id">
        								<option value="">全部</option>		
        								<?php foreach ($output['store_list'] as $store_info){?>
        								<option value="<?php echo $store_info['store_id'] ?>"  ><?php echo $store_info['store_name']?></option>
        								<?php }?>						
        							
        						</select></td>        			 				
					         </tr>
            			     <?php }?>	
            			      <?php if(!empty($output['seller_list'])) {?>
            					<tr>            						
            						<td class="pt-10 pb-10 pl-10 ta-l w-25"><label
            							class="d-ib height-30 pl-10 search-label">店员:</label>            							
            							<select
            							class="select w-55 d-ib" name="member_parent_id" id="member_parent_id">
            								<option value="">请选择</option>		
                          					<?php foreach($output['seller_list'] as $val) {?>
                        		  			  <option value="<?php echo $val['member_id'];?>"  ><?php echo $val['seller_name'];?></option>
                          					<?php }?>                        
            						 </select>
            						</td>            						
            				</tr>
 					      <?php }?>		
					
				</tbody>
			</table>
			<div class="ta-r mr-50">
				<span class="btn search-btn mr-5 ml-30"><i class="icon iconfont"></i>查询</span>
				<span style="display: none" class="btn mr-5" id="orderImportBtn">订单导入</span><a href="index.php?<?php echo $_SERVER['QUERY_STRING'];?>&a=export_step1">
				<span class="btn" style='margin-right:5px' id="exportExcel">订单导出</span></a>
				<span style="" class="btn mr-5" id="pay_all" data-rpno="0.2">批量支付</span>		
			</div>
		</form>
	</div>
	<div class="tags-wrap clearfix" id="statusSearch">
		<a class="first-tag <?php echo $_GET['state_type']=="store_order"?"active":"" ?>" href="index.php?m=store_order&a=index">全部订单</a>
		<a class="<?php echo $_GET['state_type']=="state_new"?"active":"" ?>" href="index.php?m=store_order&a=index&state_type=state_new">待买家支付</a>
		<a class="<?php echo $_GET['state_type']=="state_pay"?"active":"" ?>" href="index.php?m=store_order&a=index&state_type=state_pay">待发货</a>
		<a class="<?php echo $_GET['state_type']=="state_send"?"active":"" ?>" href="index.php?m=store_order&a=index&state_type=state_send">已发货</a>
		<a class="<?php echo $_GET['state_type']=="state_success"?"active":"" ?>" href="index.php?m=store_order&a=index&state_type=state_success">已完成</a>
		<a class="last-tag <?php echo $_GET['state_type']=="state_cancel"?"active":"" ?>" href="index.php?m=store_order&a=index&state_type=state_cancel" >已关闭</a>
	</div>

	<!--<div class="oprs-wrap of-h">
            <div class="oprs f-l">
				            </div>

        </div>-->

	<div class="pl-10 pr-10">
		<table class="ncsc-default-table order">
	<thead>
		<tr>
			<th class="w50"><input type="checkbox" id="checkall">全选</th>
			<th colspan="2"><?php echo $lang['store_order_goods_detail'];?></th>			
			<th class="w100"><?php echo $lang['store_order_goods_single_price'];?></th>
			<th class="w40"><?php echo $lang['store_show_order_amount'];?></th>			
			<th class="w110"><?php echo $lang['store_order_buyer'];?></th>
			<th class="w120">姓名</th>
			<th class="w120">手机号</th>
			<th class="w120">运单号</th>
			<th class="w120"><?php echo $lang['store_order_sum'];?></th>			
			<th class="w100">交易状态</th>
			<th class="w150">交易操作</th>
		</tr>
	</thead>
  <?php if (is_array($output['order_list']) and !empty($output['order_list'])) { ?>
  <?php foreach($output['order_list'] as $order_id => $order) { ?>
  <tbody>
		<tr>
			<td colspan="20" class="sep-row"></td>
		</tr>
		<tr>
			<th colspan="20"><span class="ml10">
			<?php if (empty($order['payment_time']) && $order['order_state']==10 ):?>
				<input type="checkbox" class='' value='<?php echo $order['pay_sn']?>' name='pay_sn[]'>
			<?php endif;?>
			<?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?><em><?php echo $order['order_sn']; ?></em>
        <?php if ($order['order_from'] == 2){?>
        <i class="icon-mobile-phone"></i>
        <?php }?>
        
</span> <span><?php "店铺名".$lang['nc_colon'];?><em class="goods-time"><?php echo $order['store_name']; ?></em></span>
				<span><?php echo $lang['store_order_add_time'].$lang['nc_colon'];?><em
					class="goods-time"><?php echo date("Y-m-d H:i:s",$order['add_time']); ?></em></span>
				<span class="fr mr5"> </span></th>
		</tr>
    <?php $i = 0;?>
    <?php foreach($order['goods_list'] as $k => $goods) { ?>
    <?php $i++;?>
    <tr>
			<td class="bdl"></td>
			<td class="w70"><div class="ncsc-goods-thumb">
					<a href="javascript:void(0)" target="_blank"><img
						src="<?php echo $goods['image_60_url'];?>"
						onMouseOver="toolTip('<img 
						
						src=<?php echo $goods['image_240_url'];?>>')"
						onMouseOut="toolTip()"/></a>
				</div></td>
			<td class="tl"><dl class="goods-name">
					<dt>
						<a target="_blank" href="javascript:void(0)"><?php echo $goods['goods_name']; ?></a>
					</dt>
					<dd>
            <?php if (!empty($goods['goods_type_cn'])){ ?>
            <span class="sale-type"><?php echo $goods['goods_type_cn'];?></span>
            <?php } ?>
          </dd>
				</dl></td>
				
			
			<td><?php echo $goods['goods_price']; ?></td>

			<td><?php echo $goods['goods_num']; ?></td>
			
			<!-- S 合并TD -->
      <?php if (($order['goods_count'] > 1 && $k ==0) || ($order['goods_count']) == 1){ ?>
      <td class="bdl" rowspan="<?php echo $order['goods_count'];?>"><div
					class="buyer"><?php echo $order['buyer_name'];?>
					
          <p member_id="<?php echo $order['buyer_id'];?>">
            <?php if(!empty($order['extend_member']['member_qq'])){?>
            <a target="_blank"
							href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $order['extend_member']['member_qq'];?>&site=qq&menu=yes"
							title="QQ: <?php echo $order['extend_member']['member_qq'];?>"><img
							border="0"
							src="http://wpa.qq.com/pa?p=2:<?php echo $order['extend_member']['member_qq'];?>:52"
							style="vertical-align: middle;" /></a>
            <?php }?>
            <?php if(!empty($order['extend_member']['member_ww'])){?>
            <a target="_blank"
							href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $order['extend_member']['member_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"><img
							border="0"
							src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $order['extend_member']['member_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"
							alt="Wang Wang" style="vertical-align: middle;" /></a>
            <?php }?>
          </p>
					<div class="buyer-info">
						<em></em>
						<div class="con">
							<h3>
								<i></i><span><?php echo $lang['store_order_buyer_info'];?></span>
							</h3>
							<dl>
								<dt><?php echo $lang['store_order_receiver'].$lang['nc_colon'];?></dt>
								<dd><?php echo $order['extend_order_common']['reciver_name'];?></dd>
							</dl>
							<dl>
								<dt><?php echo $lang['store_order_phone'].$lang['nc_colon'];?></dt>
								<dd><?php echo $order['extend_order_common']['reciver_info']['phone'];?></dd>
							</dl>
							<dl>
								<dt>地址<?php echo $lang['nc_colon'];?></dt>
								<dd><?php echo $order['extend_order_common']['reciver_info']['address'];?></dd>
							</dl>
						</div>
					</div>
				</div></td>
				
				<td class="bdl" ><?php echo $order['extend_order_common']['reciver_name'];?></td>
                <td class="bdl" ><?php echo $order['extend_order_common']['reciver_info']['phone'];?></td>
                <td class="bdl" >
				<?php if($order['order_state'] == 30):?>
                <a target="_blank" href="https://www.baidu.com/s?wd=<?php echo $order['shipping_code'];?>&ie=UTF-8"><?php echo $order['shipping_code'];?></a>
				<?php endif;?>
                </td>
			<td class="bdl" rowspan="<?php echo $order['goods_count'];?>"><p
					class="ncsc-order-amount"><?php echo $order['order_amount']; ?></p>
       <?php $allprice=0; ?>
	   <?php foreach($order['goods_list'] as $k => $goods) { ?>
    
   
       	  <?php $allprice=$allprice+$goods['commision']; ?>
       
       <?php }?>
  
      
        <p class="goods-freight">
          <?php if ($order['shipping_fee'] > 0){?>
          (<?php echo $lang['store_show_order_shipping_han']?>运费<?php echo $order['shipping_fee'];?>)
          <?php }else{?>
          <?php echo $lang['nc_common_shipping_free'];?>
          <?php }?>
        </p>
				<p class="goods-pay"
					title="<?php echo $lang['store_order_pay_method'].$lang['nc_colon'];?><?php echo $order['payment_name']; ?>"><?php echo $order['payment_name']; ?></p></td>
			<td class="bdl bdr" rowspan="<?php echo $order['goods_count'];?>"><p><?php echo $order['state_desc']; ?>
          <?php if($order['evaluation_time']) { ?>
          <br />
          <?php echo $lang['store_order_evaluated'];?>
          <?php } ?>
        </p> <!-- 订单查看 -->
				<p>
					<a
						href="index.php?m=store_order&a=show_order&order_id=<?php echo $order_id;?>"
						><?php echo $lang['store_order_view_order'];?></a>
				</p> <!-- 物流跟踪 -->
				</td>

			<!-- 取消订单 -->
			<td class="bdl bdr" rowspan="<?php echo $order['goods_count'];?>">
        <?php if($order['if_store_cancel']) { ?>
        <p>
					<a href="javascript:void(0)" class="ncsc-btn ncsc-btn-red mt5"
						nc_type="dialog"
						uri="index.php?m=store_order&a=change_state&state_type=order_cancel&order_sn=<?php echo $order['order_sn']; ?>&order_id=<?php echo $order['order_id']; ?>"
						dialog_title="<?php echo $lang['store_order_cancel_order'];?>"
						dialog_id="seller_order_cancel_order" dialog_width="400"
						id="order<?php echo $order['order_id']; ?>_action_cancel" /><i
						class="icon-remove-circle"></i><?php echo $lang['store_order_cancel_order'];?></a>
				</p>
        <?php } ?>
        
        <!-- 修改运费 -->
        <?php if ($order['if_modify_price']) { ?>
        <p style="display:none">
					<a href="javascript:void(0)"
						class="ncsc-btn-mini ncsc-btn-orange mt10"
						uri="index.php?m=store_order&a=change_state&state_type=modify_price&order_sn=<?php echo $order['order_sn']; ?>&order_id=<?php echo $order['order_id']; ?>"
						dialog_width="480"
						dialog_title="<?php echo $lang['store_order_modify_price'];?>"
						nc_type="dialog" dialog_id="seller_order_adjust_fee"
						id="order<?php echo $order['order_id']; ?>_action_adjust_fee" /><i
						class="icon-pencil"></i>修改运费</a>
				</p>
        <?php }?>
        <!-- 修改价格 -->
		<?php if ($order['if_spay_price']) { ?>
        <p  style="display:none">
					<a href="javascript:void(0)"
						class="ncsc-btn-mini ncsc-btn-green mt10"
						uri="index.php?m=store_order&a=change_state&state_type=spay_price&order_sn=<?php echo $order['order_sn']; ?>&order_id=<?php echo $order['order_id']; ?>"
						dialog_width="480"
						dialog_title="<?php echo $lang['store_order_modify_price'];?>"
						nc_type="dialog" dialog_id="seller_order_adjust_fee"
						id="order<?php echo $order['order_id']; ?>_action_adjust_fee" /><i
						class="icon-pencil"></i>修改价格</a>
				</p>
		<?php }?>
        
          <?php if (empty($order['payment_time']) && $order['order_state']==10 ) {?>
     
          <a class="ncsc-btn-mini ncsc-btn-orange mt10" href="index.php?m=store_buy&a=pay&pay_sn=<?php echo $order['pay_sn']; ?>"><i class="icon-shield"></i>订单支付</a></td>
     
           <?php }?>
        
       
        <?php if ($order['if_send']>50) { ?>
       
        <p>
					<a class="ncsc-btn ncsc-btn-green mt10"
						href="index.php?m=store_deliver&a=send&order_id=<?php echo $order['order_id']; ?>" /><i
						class="icon-truck"></i><?php echo $lang['store_order_send'];?></a>
				</p>
        <?php } ?>
        
        <!-- 锁定 -->
        <?php if ($order['if_lock']) {?>
        <p><?php echo '退款退货中';?></p>
        <?php }?></td>

      <?php } ?>
      <!-- E 合并TD -->
		</tr>

		<!-- S 赠品列表 -->
    <?php if (!empty($order['zengpin_list']) && $i == count($order['goods_list'])) { ?>
    <tr>
			<td class="bdl"></td>
			<td colspan="4" class="tl"><div class="ncsc-goods-gift">
					赠品：
					<ul><?php foreach ($order['zengpin_list'] as $zengpin_info) { ?><li>
							<a
							title="赠品：<?php echo $zengpin_info['goods_name'];?> * <?php echo $zengpin_info['goods_num'];?>"
							href="<?php echo $zengpin_info['goods_url'];?>" target="_blank"><img
								src="<?php echo $zengpin_info['image_60_url'];?>"
								onMouseOver="toolTip('<img 
								
								src=<?php echo $zengpin_info['image_240_url'];?>>')"
								onMouseOut="toolTip()"/></a>
						</li>
					</ul>
      <?php } ?>
      </div></td>
		</tr>
    <?php } ?>
    <!-- E 赠品列表 -->

    <?php }?>
    <?php } } else { ?>
    <tr>
			<td colspan="20" class="norecord"><div class="warning-option">
					<i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span>
				</div></td>
		</tr>
    <?php } ?>
  </tbody>
	<tfoot>
    <?php if (is_array($output['order_list']) and !empty($output['order_list'])) { ?>
    <tr>
			<td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
		</tr>
    <?php } ?>
  </tfoot>
</table>
		
		
	</div>


</div>


<!--订单导入-->
<script id="orderImportPopTpl" type="text/tpl">

    <div id="orderImportPop">
        <div class="import-status ta-c br-5">
            <div class="import-start-wrapper" id="orderImportBtnsWrap">
                <form id='myupload' action='index.php?m=store_order&a=order_import_save' method='post' enctype='multipart/form-data'>
                    <div class="upload-btn mt-20">
                        <span>保税区/海外直邮商品</span>
                        <input id="fileupload"  class="fileupload" type="file" name="fileupload">
                    </div>
                </form>
            </div>

            <div class="import-info-wrapper fs-14 d-n">
                <div class="d-ib mt-10 iconfont" id="import-info-icon" style="font-size: 72px;">&#xe62c;</div>
                <div class="d-ib mt-30">
                    <p class="cor-grey mt-5">成功导入<span class="cor-3"><span id="successCount">0</span>条</span>订单</p>
                    <p class="cor-grey">失败<span class="cor-rede"><span id="failCount">0</span>条</span>订单</p>
                    <a id="downUrl" href="#" target="_blank">查看失败订单</a>
                </div>
            </div>

        </div>

        <div class="example-link ta-l mt-5 lh-18">
            <div>
            <span class="iconfont" style="font-size: 14px;">&#xe686;下载</span>
            <a href="/download/order.xls" target="_blank">《保税区/海外直邮商品订单导入模板》</a>
            </div>
            <div>
            <span class="iconfont" style="font-size: 14px;">&#xe686;下载</span>
            <a href="javascript:void(0)" target="_blank">《商品编号》</a>
            </div>
             <div>
            
            </div>
        </div>

    </div>

</script>


<script charset="utf-8" type="text/javascript"
	src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/jquery.form.js"	type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	//全选
	$("#checkall").click(function(){
		if($(this).is(":checked")){
			$("input[name='pay_sn[]']").attr('checked','checked');
		}else{
			$("input[name='pay_sn[]']").removeAttr('checked');
		}
	});
	//批量支付
	$("#pay_all").click(function(){
		var itemlist = new Array();
		if($("input[name='pay_sn[]']:checked").length == 0){
			alert('请先选择要支付的订单');
			return false;
		}
		$("input[name='pay_sn[]']:checked").each(function(){
        	itemlist.push($(this).val());
        });
		var pay_sn = itemlist.join(',');
		window.location.href = 'index.php?m=store_buy&a=pay&pay_sn='+pay_sn;
	});

	$(".search-btn").click(function(){
		$("#form_search").submit();

	});
	
    $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('.checkall_s').click(function(){
        var if_check = $(this).attr('checked');
        $('.checkitem').each(function(){
            if(!this.disabled)
            {
                $(this).attr('checked', if_check);
            }
        });
        $('.checkall_s').attr('checked', if_check);
    });
    $('#skip_off').click(function(){
        url = location.href.replace(/&skip_off=\d*/g,'');
        window.location.href = url + '&skip_off=' + ($('#skip_off').attr('checked') ? '1' : '0');
    });
});



</script>
