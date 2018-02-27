<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<link href="<?php echo SHOP_TEMPLATES_URL?>/css/orderDetail.css"
	rel="stylesheet" type="text/css">

<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/doT.min.js" type="text/javascript"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/orderDetail.js"	type="text/javascript"></script>		
	<script src="<?php echo SHOP_TEMPLATES_URL;?>/seller_js/jquery.jqprint-0.3.js" 	type="text/javascript"></script>
<div class="order-detail" id="mainWrap">
	<!--小票打印object-->


	<div class="m-20 b-1">
		<div class="flow-step" style="margin-left: 60px">
			
  <div id="order-step" class="ncsc-order-step">
				<dl
					class="step-first <?php if ($output['order_info']['order_state'] != ORDER_STATE_CANCEL) echo 'current';?>">
					<dt>提交订单</dt>
					<dd class="bg"></dd>
					<dd class="date"
						title="<?php echo $lang['store_order_add_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?></dd>
				</dl>
    <?php if ($output['order_info']['payment_code'] != 'offline') { ?>
    <dl
					class="<?php if(intval($output['order_info']['payment_time'])) echo 'current'; ?>">
					<dt>支付订单</dt>
					<dd class="bg"></dd>
					<dd class="date"
						title="<?php echo $lang['store_show_order_pay_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']); ?></dd>
				</dl>
    <?php } ?>
    	<dl  style="display:none"
					class="<?php if($output['order_info']['msg_time'] >0 || $output['order_info']['extend_order_common']['shipping_time']) { ?>current<?php } ?>">
					<dt>海关审核</dt>
					<dd class="bg"></dd>
					<dd class="date"
					   title="<?php echo $lang['store_show_order_finish_time'];?>"><?php echo $output['order_info']['msg_time']>0?date("Y-m-d H:i:s",$output['order_info']['msg_time']):date('Y-m-d H:i:s',strtotime('-3 hour',$output['order_info']['extend_order_common']['shipping_time'])); ?></dd>
			     </dl>

				<dl
					class="<?php if($output['order_info']['extend_order_common']['shipping_time']) echo 'current'; ?>">
					<dt>商家发货</dt>
					<dd class="bg"></dd>
					<dd class="date"
						title="<?php echo $lang['store_show_order_send_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?></dd>
				</dl>
				<dl
					class="<?php if(intval($output['order_info']['finnshed_time'])) { ?>current<?php } ?>">
					<dt>确认收货</dt>
					<dd class="bg"></dd>
					<dd class="date"
						title="<?php echo $lang['store_show_order_finish_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['finnshed_time']); ?></dd>
				</dl>

			</div>

			
		</div>
		<div class="pos-r"
			style="background-color: #FAFAFA; border: 1px solid #EFEFEF;">

			<!--tabs:start-->
			<div class="tapbox" id="tapsBox" >
				<a class="tapItem active" data-content="logisticsContent"
					style="color: #666">物流信息</a> <a class="tapItem"
					data-content="baseInfoContent" style="color: #666">订单基本信息</a>
				<div id="cusfee" style="display:none">
					<input type="text" style="padding-top: 0px;" id="cusfees"
						placeholder="请输入实收金额后打印" class="">
				</div>
				<a id="printorder" style="display:none">打印小票</a>
			</div>
			<!--tabs:end-->
			<div>
				<!--Logistics:start-->

				<div class="tab-content-box pt-10" id="logisticsContent"
					style="display: block;">
					<div class="lineinfo">
						<div class="shuline"></div>

						<div class="lineinfo-item" id="flag">
							<input type="hidden" id="logisticsNum" value="<?php echo $output['order_info']['extend_order_common']['shipping_time']>0?$output['order_info']['shipping_code']:""; ?>"
								data-logisticstype="<?php echo $output['order_info']['express_info']['e_code'];?>">
							<div class="kdinfo" style="line-height: 26px">
								<b>订单产生</b> <br> 订单号：<?php echo $output['order_info']['order_sn']?> <br> 承运商： <?php echo $output['order_info']['express_info']['e_name'];?><br> 运单号：<?php echo $output['order_info']['shipping_code']; ?> <br>
								<div class="kdtime">发货时间：<?php echo $output['order_info']['extend_order_common']['shipping_time']>0?date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']):"未发货"; ?></div>
							</div>
							<div class="quan quanindex">
								<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/map.png">
							</div>
							<div id="logisticsDetail"></div>
						</div>
					</div>
				</div>
				<!--Logistics:End-->
				<!--info：end-->
				<div class="tab-content-box d-n" id="baseInfoContent"
					style="display: none;">
					<form class="aform" action="save.json" method="post">
						<input type="hidden" id="id"
							value="c798a319963a4ac2bed8f1aa8cacae01">
						<div id="orderinfo">
							<div class="ahead">订单信息</div>
							<div class="ainfo">
								<div class="atitle">
									<span class="alable">订单编号：</span> <span id="orderNum"><?php echo $output['order_info']['order_sn']?></span>
								</div>
								<div class="atitle">
									<span class="alable">订单状态：</span> 
									 <?php if ($output['order_info']['order_state'] == ORDER_STATE_CANCEL) { ?>
    
											<span>交易关闭</span>
			
   									 <?php } ?>
    								<?php if ($output['order_info']['order_state'] == ORDER_STATE_NEW) { ?>
   
										<span>订单已经提交，等待买家付款</span>
			
    								<?php } ?>
    								
    								<?php if ($output['order_info']['order_state'] == ORDER_STATE_PAY) { ?>
  									  <?php if ($output['order_info']['payment_code'] == 'offline') { ?>
        
        								<span> 订单已提交，等待发货</span>
         							<?php } else { ?>
        								<span> 已支付成功</span>
       								<?php } ?>
     
   									<?php } ?>
  								  <?php if ($output['order_info']['order_state'] == ORDER_STATE_SEND) { ?>

										<span>已发货</span>
		
    							 <?php } ?>
    							<?php if ($output['order_info']['order_state'] == ORDER_STATE_SUCCESS) { ?>
    							<?php if ($output['order_info']['evaluation_state'] == 1) { ?>
   
    							<?php } else { ?>

								<span>已经收货。</span>
		
    							<?php } ?>
    							<?php } ?>
									
									
								</div>
							</div>
							<div class="ahead">报关信息</div>
							<div class="ainfo">
								<div class="atitle">
									<span class="alable">消费者姓名：</span> <span><?php echo $output['order_info']['extend_order_common']['reciver_name'];?></span>
								</div>
								<div class="atitle">
									<span class="alable">消费者手机：</span> <span><?php echo @$output['order_info']['extend_order_common']['reciver_info']['phone'];?></span>
								</div>
								<div class="atitle">
									<span class="alable">身份证号码：</span> <span><?php echo @$output['order_info']['extend_order_common']['reciver_info']['member_idcard'];?></span>
								</div>
							</div>

							<div class="ahead">商品信息</div>
							<div class="ainfo">
								<div class="atitle">
									<span class="alable">下单日期：</span> <span> <?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?> </span>
								</div>
								<div class="atitle">
									<span class="alable">下单门店：</span> <span><?php echo $_SESSION['store_name']?>海外专营店</span>
								</div>
								<?php $i = 0;?>
       							<?php foreach($output['order_info']['goods_list'] as $k => $goods) { ?>
       							<?php $i++;?>
								<div class="atitle">
									<span class="alable">商品名称：</span> <span><?php echo $goods['goods_name']?></span>
								</div>
								<div class="atitle">
									<span class="alable">数量：</span> <span><?php echo $goods['goods_num']?></span>
								</div>
								<?php }?>
								
								<div class="atitle">
									<span class="alable">订单总价：</span> <span><?php echo $output['order_info']['order_amount']; ?></span>
								</div>
							</div>
							<div class="ahead">收货信息</div>
							<div class="ainfo">
								<div class="atitle">
									<span class="alable">收货电话：</span> <span><?php echo @$output['order_info']['extend_order_common']['reciver_info']['phone'];?></span>
								</div>
								<div class="atitle">
									<!-- 一些老数据没有收获人，就取消费者 -->
									<span class="alable">收货人：</span> <span><?php echo $output['order_info']['extend_order_common']['reciver_name'];?></span>
								</div>
								<div class="atitle">
									<span class="alable">收货地址：</span> <span><?php echo @$output['order_info']['extend_order_common']['reciver_info']['address'];?></span>
								</div>
								<div class="atitle">
									<span class="alable">备注：</span> <span></span>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!--info：end-->
			</div>
		</div>
	</div>
</div>

<script type="text/tpl" id="logisticsDetailTpl">
	{{?it.data && it.data.length > 0}}
	{{~it.data:item:index}}
		<div class="lineinfo-item">
			<div class="kdinfo">{{=item.AcceptStation || ''}}<div class="kdtime">{{=item.AcceptTime || ''}}</div></div>
			<div class="quan"></div>
		</div>
	{{~}}
	{{??}}
		<div class="lineinfo-item">
			<div class="kdinfo">亲，还没有物流信息哦！<div class="kdtime"></div></div>
			<div class="quan"></div>
		</div>
	{{?}}

</script>

<script type="text/javascript">
$(function(){
    $('#show_shipping').on('hover',function(){
        var_send = '<?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?>&nbsp;&nbsp;<?php echo $lang['member_show_seller_has_send'];?><br/>';
    	$.getJSON('index.php?m=store_deliver&a=get_express&e_code=<?php echo $output['order_info']['express_info']['e_code']?>&shipping_code=<?php echo $output['order_info']['shipping_code']?>&t=<?php echo random(7);?>',function(data){
    		if(data){
    			data = var_send+data;
    			$('#shipping_ul').html(data);
    			$('#show_shipping').unbind('hover');
    		}else{
    			$('#shipping_ul').html(var_send);
    			$('#show_shipping').unbind('hover');
    		}
    	});
    });
});
</script>
