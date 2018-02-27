<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<div class="ncc-main">
  <div class="ncc-title">
    <h3><?php echo $lang['cart_index_payment'];?></h3>    
  </div>
  <form action="index.php?m=payment&a=real_order" method="POST" id="buy_form">
    <input type="hidden" name="pay_sn" value="<?php echo $output['pay_info']['pay_sn'];?>">
    <input type="hidden" id="payment_code" name="payment_code" value="">
    <input type="hidden" value="" name="password_callback" id="password_callback">
    <div class="ncc-receipt-info">
      <div class="ncc-receipt-info-title">
        <h3>
        <?php echo $output['pay']['order_remind'];?>
        <?php echo $output['pay']['pay_amount_online'] > 0 ? "应付金额：<strong>".ncPriceFormat($output['pay']['pay_amount_online'])."</strong>元" : null;?>
        </h3>
      </div>
      <table class="ncc-table-style">
        <thead>
          <tr>
            <th class="w50"></th>
            <th class="w200 tl">订单号</th>
            <th class="tl w150">支付方式</th>
            <th class="tl">金额(元)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($output['order_list']) > 1) { ?>
          <tr>
            <th colspan="20">由于您的商品由不同商家发出，此单将分为<?php echo count($output['order_list']);?>个不同子订单配送！</th>
          </tr>
          <?php } ?>
          <?php foreach ($output['order_list'] as $key => $order_info) { ?>
          <tr>
            <td></td>
            <td class="tl"><?php echo $order_info['order_sn']; ?></td>
            <td class="tl"><?php echo $order_info['payment_type'];?></td>
            <td class="tl"><?php echo $order_info['order_amount'];?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
     
      <?php if ($output['pay']['pay_amount_online'] > 0) {?>
          <div class="ncc-receipt-info">
          <div class="ncc-receipt-info-title">
            <h3>选择在线支付</h3>
          </div>
          <ul class="ncc-payment-list">
            <?php foreach($output['payment_list'] as $val) { ?>
            <li payment_code="<?php echo $val['payment_code']; ?>">
              <label for="pay_<?php echo $val['payment_code']; ?>">
              <i></i>
              <div class="logo" for="pay_<?php echo $val['payment_id']; ?>"> <img src="<?php echo SHOP_TEMPLATES_URL?>/images/payment/<?php echo $val['payment_code']; ?>_logo.gif" /> </div>
              </label>
            </li>
            <?php } ?>
          </ul>
        </div>
    <?php } ?>
    <?php if ($output['pay']['pay_amount_online'] > 0) {?>
    <div class="ncc-bottom"><a href="javascript:void(0);" id="next_button" class="pay-btn"><i class="icon-shield"></i>确认支付</a></div>
    <?php }?>
  </form>
</div>
<script type="text/javascript">
var pay_amount_online = <?php echo $output['pay']['pay_amount_online'];?>;
var member_rcb = <?php echo $output['pay']['member_rcb'];?>;
var member_pd = <?php echo $output['pay']['member_pd'];?>;
var pay_diff_amount = <?php echo $output['pay']['pay_amount_online'] ? $output['pay']['pay_amount_online'] : $output['pay']['payd_diff_amount'];?>;
$(function(){
    $('.ncc-payment-list > li').on('click',function(){
    	$('.ncc-payment-list > li').removeClass('using');
    	if ($('#payment_code').val() != $(this).attr('payment_code')) {
    		$('#payment_code').val($(this).attr('payment_code'));
    		$(this).addClass('using');
        } else {
            $('#payment_code').val('');
        }
    });
    $('#next_button').on('click',function(){
    	if (($('input[name="pd_pay"]').attr('checked') || $('input[name="rcb_pay"]').attr('checked')) && $('#password_callback').val() != '1') {
    		showDialog('使用充值卡/预存款支付，需输入支付密码并确认  ', 'error','','','','','','','',2);
    		return;
    	}
        if ($('#payment_code').val() == '' && parseFloat($('#api_pay_amount').html()) > 0) {
        	showDialog('请选择一种在线支付方式', 'error','','','','','','','',2);
        	return;
        }
        $('#buy_form').submit();
    });

    <?php if ($output['pay']['if_show_pdrcb_select']) { ?>
        function showPaySubmit() {
            if ($('input[name="pd_pay"]').attr('checked') || $('input[name="rcb_pay"]').attr('checked')) {
            	$('#pay-password').val('');
            	$('#password_callback').val('');
            	$('#pd_password').show();
            } else {
            	$('#pd_password').hide();
            }
            var _diff_amount = pay_diff_amount;
            
        	if ($('input[name="rcb_pay"]').attr('checked')) {
        		_diff_amount -= member_rcb;
            }
        	if ($('input[name="pd_pay"]').attr('checked')) {
        		_diff_amount -= member_pd;
            }
            if (_diff_amount < 0) {
            	_diff_amount = 0;
            }
            $('#api_pay_amount').html(_diff_amount.toFixed(2));
        }
    
        $('#pd_pay_submit').on('click',function(){
            if ($('#pay-password').val() == '') {
            	showDialog('请输入支付密码', 'error','','','','','','','',2);return false;
            }
            $('#password_callback').val('');
    		$.get("index.php?m=buy&a=check_pd_pwd", {'password':$('#pay-password').val()}, function(data){
                if (data == '1') {
                	$('#password_callback').val('1');
                	$('#pd_password').hide();
                } else {
                	$('#pay-password').val('');
                	showDialog('支付密码错误', 'error','','','','','','','',2);
                }
            });
        });
    
        $('input[name="rcb_pay"]').on('change',function(){
        	showPaySubmit();
        	if ($(this).attr('checked') && !$('input[name="pd_pay"]').attr('checked')) {
            	if (member_rcb >= pay_amount_online) {
                	$('input[name="pd_pay"]').attr('checked',false).attr('disabled',true);
            	}
        	} else {
        		$('input[name="pd_pay"]').attr('disabled',false);
        	}
        });
    
        $('input[name="pd_pay"]').on('change',function(){
        	showPaySubmit();
        	if ($(this).attr('checked') && !$('input[name="rcb_pay"]').attr('checked')) {
            	if (member_pd >= pay_amount_online) {
                	$('input[name="rcb_pay"]').attr('checked',false).attr('disabled',true);
            	}
        	} else {
        		$('input[name="rcb_pay"]').attr('disabled',false);
        	}
        });
    <?php } ?>
});
</script>