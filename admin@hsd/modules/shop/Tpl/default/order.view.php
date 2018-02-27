<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/layer/layer.js"></script>
<style>
.ncm-goods-gift {
	text-align: left;
}
.ncm-goods-gift ul {
    display: inline-block;
    font-size: 0;
    vertical-align: middle;
}
.ncm-goods-gift li {
    display: inline-block;
    letter-spacing: normal;
    margin-right: 4px;
    vertical-align: top;
    word-spacing: normal;
}
.ncm-goods-gift li a {
    background-color: #fff;
    display: table-cell;
    height: 30px;
    line-height: 0;
    overflow: hidden;
    text-align: center;
    vertical-align: middle;
    width: 30px;
}
.ncm-goods-gift li a img {
    max-height: 30px;
    max-width: 30px;
}
input.disable{border:1px solid #fff;background:#fff;}
input.enable{border:1px solid #369;background:#fff;}
</style>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="javascript:history.back(-1)" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3><?php echo $lang['order_manage'];?></h3>
        <h5><?php echo $lang['order_manage_subhead'];?></h5>
      </div>
    </div>
  </div>
  <div class="ncap-order-style">
    <div class="titile">
      <h3></h3>
    </div>
<div class="ncap-order-flow">

    <?php if ($output['order_info']['order_type'] != 3) { ?>
      <ol class="num5">
        <li class="current">
          <h5>生成订单</h5>
          <i class="fa fa-arrow-circle-right"></i>
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['add_time']);?></time>
        </li>
        <?php if ($output['order_info']['order_state'] == ORDER_STATE_CANCEL) { ?>
        <li class="current">
          <h5>取消订单</h5>
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['close_info']['log_time']);?></time>
        </li>
        <?php } else { ?>
        <li class="<?php if(intval($output['order_info']['payment_time']) && $output['order_info']['order_pay_state'] !== false) echo 'current'; ?>">
          <h5>完成付款</h5>
          <i class="fa fa-arrow-circle-right"></i>
          <time><?php echo intval(date('His',$output['order_info']['payment_time'])) ? date('Y-m-d H:i:s',$output['order_info']['payment_time']) : date('Y-m-d',$output['order_info']['payment_time']);?></time>
        </li>
        <li class="<?php if($output['order_info']['extend_order_common']['shipping_time']) echo 'current'; ?>">
          <h5>商家发货</h5>
          <i class="fa fa-arrow-circle-right"></i>
          <time><?php echo $output['order_info']['extend_order_common']['shipping_time'] ? date('Y-m-d H:i:s',$output['order_info']['extend_order_common']['shipping_time']) : null; ?></time>
        </li>
        <li class="<?php if(intval($output['order_info']['finnshed_time'])) { ?>current<?php } ?>">
          <h5>收货确认</h5>
          <i class="fa fa-arrow-circle-right"></i>
          <time><?php echo $output['order_info']['finnshed_time'] ? date('Y-m-d H:i:s',$output['order_info']['finnshed_time']) : null;?></time>
        </li>
        <li class="<?php if($output['order_info']['evaluation_state'] == 1) { ?>current<?php } ?>">
          <h5>完成评价</h5>
          <time><?php echo $output['order_info']['extend_order_common']['evaluation_time'] ? date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['evaluation_time']) : null; ?></time>
        </li>
        <?php } ?>
    </ol>
    <?php } else { ?>
      <ol class="num5">
        <li class="current">
          <h5>生成订单</h5>
          <i class="fa fa-arrow-circle-right"></i>
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['add_time']);?></time>
        </li>
        <?php if ($output['order_info']['order_state'] == ORDER_STATE_CANCEL) { ?>
        <li class="current">
          <h5>取消订单</h5>
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['close_info']['log_time']);?></time>
        </li>
        <?php } ?>
        <?php if($output['order_info']['payment_code'] != 'chain') { ?>
        <li class="<?php if(intval($output['order_info']['payment_time']) && $output['order_info']['order_pay_state'] !== false) echo 'current';?>">
          <h5>完成付款</h5>
          <i class="fa fa-arrow-circle-right"></i>
          <time>
          <?php if ($output['order_info']['payment_time']) { ?>
          <?php echo intval(date('His',$output['order_info']['payment_time'])) ? date('Y-m-d H:i:s',$output['order_info']['payment_time']) : date('Y-m-d',$output['order_info']['payment_time']);?>
          <?php } ?>
          </time>
        </li>
        <li class="<?php if(intval($output['order_info']['finnshed_time'])) { ?>current<?php } ?>">
          <h5>买家取货</h5>
          <i class="fa fa-arrow-circle-right"></i>
          <time><?php echo $output['order_info']['finnshed_time'] ? date('Y-m-d H:i:s',$output['order_info']['finnshed_time']) : null;?></time>
        </li>
        <?php } else { ?>
        <li class="<?php if(intval($output['order_info']['finnshed_time'])) { ?>current<?php } ?>">
          <h5>买家到门店付款取货</h5>
          <i class="fa fa-arrow-circle-right"></i>
          <time><?php echo $output['order_info']['finnshed_time'] ? date('Y-m-d H:i:s',$output['order_info']['finnshed_time']) : null;?></time>
        </li>
        <?php } ?>
        <li class="<?php if($output['order_info']['evaluation_state'] == 1) { ?>current<?php } ?>">
          <h5>完成评价</h5>
          <time><?php echo $output['order_info']['extend_order_common']['evaluation_time'] ? date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['evaluation_time']) : null; ?></time>
        </li>
        
    </ol>
    <?php }?>
    </div>

    <div class="ncap-order-details">
      <ul class="tabs-nav">
        <li class="current"><a href="javascript:void(0);"><?php echo $lang['order_detail'];?></a></li>
        <?php if(is_array($output['refund_list']) and !empty($output['refund_list'])) { ?>
        <li><a href="javascript:void(0);">退款记录</a></li>
        <?php } ?>
        <?php if(is_array($output['return_list']) and !empty($output['return_list'])) { ?>
        <li><a href="javascript:void(0);">退货记录</a></li>
        <?php } ?>
      </ul>
      <div class="tabs-panels">
        <div class="misc-info">
          <h4>下单/支付</h4>
          <dl>
            <dt><?php echo $lang['order_number'];?><?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $output['order_info']['order_sn'];?><?php if ($output['order_info']['order_type'] == 2) echo '[预定]';?><?php if ($output['order_info']['order_type'] == 3) echo '[门店自提]';?></dd>
            <dt>订单来源<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo str_replace(array(1,2), array('PC端','移动端'), $output['order_info']['order_from']);?></dd>
            <dt><?php echo $lang['order_time'];?><?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo date('Y-m-d H:i:s',$output['order_info']['add_time']);?></dd>
          </dl>
          <?php if(intval($output['order_info']['payment_time'])){?>
          <dl>
            <dt>支付单号<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $output['order_info']['pay_sn'];?><br/><?php echo $output['pay_md5'];?></dd>
            <dt><?php echo $lang['payment'];?><?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo orderPaymentName($output['order_info']['payment_code']);?></dd>
            <dt><?php echo $lang['payment_time'];?><?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo intval(date('His',$output['order_info']['payment_time'])) ? date('Y-m-d H:i:s',$output['order_info']['payment_time']) : date('Y-m-d',$output['order_info']['payment_time']);?></dd>
          </dl>
          <?php } else if ($output['order_info']['payment_code'] == 'offline') { ?>
          <dl>
            <dt><?php echo $lang['payment'];?><?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo orderPaymentName($output['order_info']['payment_code']);?></dd>
          </dl>          
          <?php } ?>
          <?php if ($output['order_info']['order_state'] == ORDER_STATE_CANCEL) { ?>
          <dl>
            <dt>订单取消原因：</dt>
            <dd><?php echo $output['order_info']['close_info']['log_role'];?>(<?php echo $output['order_info']['close_info']['log_user'];?>) <?php echo $output['order_info']['close_info']['log_msg'];?></dd>
          </dl>
          <?php }?>
          <?php if ($output['order_info']['order_state'] == ORDER_STATE_PAY) { ?>
          <dl>
            <dt>支付日志：</dt>
            <dd><?php echo $output['order_info']['pay_info']['log_role'];?> <?php echo $output['order_info']['pay_info']['log_msg'];?></dd>
          </dl>
          <?php }?>
        </div>
        <div class="addr-note">
          <h4>购买/收货方信息</h4>
          <dl>
            <dt><?php echo $lang['buyer_name'];?><?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $output['order_info']['buyer_name'];?></dd>
            <dt>联系方式<?php echo $lang['nc_colon'];?></dt>
            <dd><input class="disable edit_input" id="member_phone" readonly value="<?php echo @$output['order_info']['extend_order_common']['reciver_info']['phone'];?>"  type="text"  /></dd>
          </dl>
          <dl>
          	<dt>姓名<?php echo $lang['nc_colon'];?></dt>
            <dd><input class="disable edit_input" id="reciver_name" readonly value="<?php echo $output['order_info']['extend_order_common']['reciver_name'];?>"  type="text"  /></dd>
            <dt>收货地址<?php echo $lang['nc_colon'];?></dt>
            <dd><input style="width:350px;" class="disable edit_input" id="member_address" readonly value="<?php echo @$output['order_info']['extend_order_common']['reciver_info']['address'];?>"  type="text"  /></dd>
          </dl>
          <dl>          	
            <dt>身份证<?php echo $lang['nc_colon'];?></dt>
            <dd><input  class="disable edit_input" id="member_idcard" readonly value="<?php echo @$output['order_info']['extend_order_common']['reciver_info']['member_idcard'];?>"  type="text"  /></dd>
          </dl>
          <dl>
            <dt>发票信息<?php echo $lang['nc_colon'];?></dt>
            <dd>
              <?php if (!empty($output['order_info']['extend_order_common']['invoice_info'])) {?>
              <ul>
                <?php foreach ((array)$output['order_info']['extend_order_common']['invoice_info'] as $key => $value){?>
                <li><strong><?php echo $key.$lang['nc_colon'];?></strong><?php echo $value;?></li>
                <?php } ?>
              </ul>
              <?php } ?>
            </dd>
          </dl>
          <dl>
            <dt>买家留言<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $output['order_info']['extend_order_common']['order_message']; ?></dd>
          </dl>
        </div>

        <div class="contact-info">
          <h4>销售/发货方信息</h4>
          <dl>
            <dt><?php echo $lang['store_name'];?><?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $output['order_info']['store_name'];?></dd><dt>店主名称<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $output['store_info']['seller_name'];?></dd>
            <dt>联系电话<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $output['store_info']['store_phone'];?></dd>
          </dl>
          <dl>
            <dt>发货地址<?php echo $lang['nc_colon'];?></dt>
            <?php if (!empty($output['daddress_info'])) {?>
            <dd><?php echo $output['daddress_info']['seller_name']; ?>&nbsp;,&nbsp;<?php echo $output['daddress_info']['telphone'];?>&nbsp;,&nbsp;<?php echo $output['daddress_info']['area_info'];?>&nbsp;<?php echo $output['daddress_info']['address'];?>&nbsp;,&nbsp;<?php echo $output['daddress_info']['company'];?></dd>
            <?php } ?>
          </dl>
          <dl>
            <dt>发货时间<?php echo $lang['nc_colon'];?></dt>
            <?php echo $output['order_info']['extend_order_common']['shipping_time'] ?>
            <dd><?php echo $output['order_info']['extend_order_common']['shipping_time'] ? date('Y-m-d H:i:s',$output['order_info']['extend_order_common']['shipping_time']) : null; ?></dd>
            <dt>快递公司<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $output['order_info']['express_info']['e_name'];?> <a href="javascript:void(0)" onclick="setKd(<?php echo $output['order_info']['order_id'];?>)">设置</a></dd>
            <dt>物流单号<?php echo $lang['nc_colon'];?></dt>
            <dd>
              <?php if($output['order_info']['shipping_code'] != ''){?>
              <?php echo $output['order_info']['shipping_code'];?>
              <?php }?>
            </dd>
          </dl>
        </div>

        <?php if ($output['order_info']['order_type'] == 2) { ?>
        <div>
        <h4>预定信息</h4>
          <table>
            <tbody>
              <tr>
                <td>阶段</td>
                <td>应付金额</td>
                <td>支付方式</td>
                <td>支付交易号</td>
                <td>支付时间</td>
                <td>备注</td>
              </tr>
              <?php foreach ($output['order_info']['book_list'] as $k => $book_info) { ?>
              <tr>
                <td><?php echo $book_info['book_step'];?></td>
                <td><?php echo $book_info['book_amount'].$book_info['book_amount_ext'];?></td>
                <td><?php echo $book_info['book_pay_name'];?></td>
                <td><?php echo $book_info['book_trade_no'];?></td>
                <td>
                <?php if (!empty($book_info['book_pay_time'])) { ?>
                <?php echo !date('His',$book_info['book_pay_time']) ? date('Y-m-d',$book_info['book_pay_time']) : date('Y-m-d H:i:s',$book_info['book_pay_time']);?>
                <?php } ?>
                </td>
                <td><?php echo $book_info['book_state'];?><?php echo $k == 1 ? '（通知手机号'.$book_info['book_buyer_phone'].'）' : null;?></td>
                </dd>
              </tr>
              <?php } ?>
          </tbody>
          </table>
        </div>
        <?php } ?>

        <div class="goods-info">
          <h4><?php echo $lang['product_info'];?></h4>
          <table>
            <thead>
              <tr>
                <th colspan="2">商品</th>
                <th>单价</th>
                <th><?php echo $lang['product_num'];?></th>
                <th>优惠活动</th>
                <th>佣金比例</th>
                <th>收取佣金</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 0;?>
              <?php foreach($output['order_info']['goods_list'] as $goods){ ?>
              <?php $i++;?>
              <tr>
                <td class="w30"><div class="goods-thumb"><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><img alt="<?php echo $lang['product_pic'];?>" src="<?php echo thumb($goods, 60);?>" /> </a></div></td>
                <td style="text-align: left;"><a href="<?php echo SHOP_SITE_URL;?>/index.php?m=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $goods['goods_name'];?></a><span class="rec"><a target="_blank" href="<?php echo urlShop('snapshot', 'index', array('rec_id' => $goods['rec_id']));?>">[交易快照]</a></span><br/><?php echo $goods['goods_spec'];?></td>
                <td class="w80"><?php echo $lang['currency'].ncPriceFormat($goods['goods_price']);?></td>
                <td class="w60"><?php echo $goods['goods_num'];?></td>
                <td class="w100"><?php echo orderGoodsType($goods['goods_type']); ?></td>
                <td class="w60"><?php echo $goods['commis_rate'] == 200 ? '' : $goods['commis_rate'].'%';?></td>
                <td class="w80"><?php echo $goods['commis_rate'] == 200 ? '' : ncPriceFormat($goods['goods_pay_price']*$goods['commis_rate']/100);?></td>
              </tr>
                <!-- S 赠品列表 -->
                <?php if (!empty($output['order_info']['zengpin_list']) && $i == count($output['order_info']['goods_list'])) { ?>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="6"><div class="ncm-goods-gift">赠品：
                  <ul><?php foreach($output['order_info']['zengpin_list'] as $zengpin_info) {?>
                  <li><a title="赠品：<?php echo $zengpin_info['goods_name'];?> * <?php echo $zengpin_info['goods_num'];?>" target="_blank" href="<?php echo $zengpin_info['goods_url'];?>"><img src="<?php echo $zengpin_info['image_60_url']; ?>" /></a></li>
                  <?php } ?></ul></div>
                  </td>
                </tr>
                <?php } ?>
                <!-- E 赠品列表 -->
              <?php } ?>
            </tbody>
            <!-- S 促销信息 -->
            <?php $pinfo = $output['order_info']['extend_order_common']['promotion_info'];?>
            <?php if(!empty($pinfo)){ ?>
            <?php $pinfo = unserialize($pinfo);?>
            <tfoot>
              <tr>
                <th colspan="10">其它信息</th>
              </tr>
              <tr>
                <td colspan="10">
              <?php if($pinfo == false){ ?>
              <?php echo $output['order_info']['extend_order_common']['promotion_info'];?>
              <?php }elseif (is_array($pinfo)){ ?>
              <?php foreach ($pinfo as $v) {?>
              <dl class="nc-store-sales"><dt><?php echo $v[0];?></dt><dd><?php echo $v[1];?></dd></dl>
              <?php }?>
              <?php }?>
                </td>
              </tr>
            </tfoot>
            <?php } ?>
            <!-- E 促销信息 -->
          </table>
        </div>
        <div class="total-amount">
          <h3><?php echo $lang['order_total_price'];?><?php echo $lang['nc_colon'];?><strong class="red_common"><?php echo $lang['currency'].ncPriceFormat($output['order_info']['order_amount']);?></strong></h3>
          <h4>(<?php echo $lang['order_total_transport'];?><?php echo $lang['nc_colon'];?><?php echo $lang['currency'].ncPriceFormat($output['order_info']['shipping_fee']);?>)</h4>
          <?php if($output['order_info']['refund_amount'] > 0) { ?>
          (<?php echo $lang['order_refund'];?><?php echo $lang['nc_colon'];?><?php echo $lang['currency'].ncPriceFormat($output['order_info']['refund_amount']);?>)
          <?php } ?>
        </div>
      </div>
      <?php if(is_array($output['refund_list']) and !empty($output['refund_list'])) { ?>
      <div class="tabs-panels tabs-hide">
        <div>
          <h4>退款信息</h4>
          <?php foreach($output['refund_list'] as $val) { ?>
          <dl>
            <dt>退款单号<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $val['refund_sn'];?></dd>
            <dt>退款金额<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $lang['currency'];?><?php echo ncPriceFormat($val['refund_amount']); ?></dd>
            <dt>发生时间<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo date("Y-m-d H:i:s",$val['admin_time']); ?></dd>
            <dt>备注<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $val['goods_name'];?></dd>
          </dl>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <?php if(is_array($output['return_list']) and !empty($output['return_list'])) { ?>
      <div class="tabs-panels tabs-hide">
        <div>
          <h4>退货信息</h4>
          <?php foreach($output['return_list'] as $val) { ?>
          <dl>
            <dt>退货单号<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $val['refund_sn'];?></dd>
            <dt>退款金额<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $lang['currency'];?><?php echo ncPriceFormat($val['refund_amount']); ?></dd>
            <dt>发生时间<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo date("Y-m-d H:i:s",$val['admin_time']); ?></dd>
            <dt>备注<?php echo $lang['nc_colon'];?></dt>
            <dd><?php echo $val['goods_name'];?></dd>
          </dl>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <div class = "bottom">
            <a href="index.php?m=order" class="ncap-btn-big ncap-btn-green" >返回</a>
            <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="add_order_remark(<?php echo $output['order_info']['order_id'];?>)">备注</a>
            <?php if($output['order_info']['order_state']==20){?>
            <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="order_cancel(<?php echo $output['order_info']['order_id'];?>)">取消</a>
            <?php }?>
            <?php if($output['order_info']['order_state']>=20 && $output['order_info']['refund_state']==0 && $output['order_info']['is_refund']==0){?>
            <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-red" onclick="order_refund(<?php echo $output['order_info']['order_id'];?>)">申请退款</a>
            <?php }?>
            <?php if($output['order_info']['refund_state']==0 && $output['order_info']['is_refund']==1){?>
            <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-red" onclick="order_recover(<?php echo $output['order_info']['order_id'];?>)">恢复订单</a>
            <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-red" onclick="diag(<?php echo $output['order_info']['order_id'];?>)">确认退款</a>
            <?php }?>
            <?php if($output['order_info']['tao_status']==0 && $output['order_info']['tao_state']){?>
            <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="send_tao(<?php echo $output['order_info']['order_id'];?>)">提交淘宝仓</a>
            <?php }?>
         </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(function() {
        $(".tabs-nav > li > a").mousemove(function(e) {
            if (e.target == this) {
                var tabs = $(this).parent().parent().children("li");
                var panels = $(this).parents('.ncap-order-details:first').children(".tabs-panels");
                var index = $.inArray(this, $(this).parents('ul').find("a"));
                if (panels.eq(index)[0]) {
                   tabs.removeClass("current").eq(index).addClass("current");
                   panels.addClass("tabs-hide").eq(index).removeClass("tabs-hide");
                }
            }
        });
        
        $(".edit_input").dblclick(function(){
        	$(this).removeAttr("readonly");
        	$(this).attr("class","enable edit_input");
        }); 
        //修改姓名、地址、身份证等
        $(".edit_input").blur(function(){
        	var id = $(this).attr('id');
        	var vla = $(this).val();
        	$(this).readOnly = true;
        	$(this).attr("readonly","readonly");
        	$(this).attr("class","disable edit_input");     
      
        	$.ajax({		
				type:'POST',
				url:'index.php',
				data:'m=order&a=editOrderCommand&order_id='+getUrlParam('order_id')+"&"+id+"="+vla,
				error:function(){
						alert('修改失败！');
					},
				success:function(html){
					   //alert('修改成功！');
				},
				dataType:'json'
			});
        });        
    });
    //取参数值
    function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
            if (r != null) return unescape(r[2]); return null; //返回参数值
    }

     //增加订单备注
    function add_order_remark(order_id){
      layer.open({
        type: 2,
        title:'订单备注',
        area: ['600px', '250px'],
        fix: true, //不固定
        maxmin: true,
        content: 'index.php?m=order&a=add_order_remark&order_id='+order_id
      });
    }
    //订单取消
    function order_cancel(order_id){
      layer.open({
        type: 2,
        title:'订单取消',
        area: ['600px', '250px'],
        fix: true, //不固定
        maxmin: true,
        content: 'index.php?m=order&a=order_cancel&order_id='+order_id
      });
    }

    //订单退款
    function order_refund(order_id){
      layer.open({
        type: 2,
        title:'订单退款',
        area: ['600px', '250px'],
        fix: true, //不固定
        maxmin: true,
        content: 'index.php?m=order&a=order_refund&order_id='+order_id
      });
    }

    //订单恢复
    function order_recover(order_id){
      $.ajax({
         type: "POST",
         url: "index.php?m=order&a=order_recover",
         data: "order_id="+order_id,
         success: function(data){
          layer.msg(data.msg);
          window.location.reload();
         }
     });
    }
    //设置快递企业
    function setKd(order_id){
    	layer.open({
    		type: 2,
    		title:'快递设置',
    		area: ['600px', '290px'],
    		fix: true, //不固定
    		maxmin: true,
    		content: 'index.php?m=order&a=kd_set&order_id='+order_id
    	});

    }
    
    //确认退款
    function diag(order_id)
    {
      layer.prompt({
        title: '请输入密码'
      }, function(value, index, elem){        
        if(value=="xyq123456"){
          $.ajax({
                 type: "POST",
                 url: "index.php?m=order&a=refund",
                 data: "order_id="+order_id,
                 success: function(data){
                  layer.msg(data.msg);
                  window.location.reload();
                 }
              });
        }
        else{
            layer.msg("密码有误 ,请重试");
        }
        
      });
    }
</script>
