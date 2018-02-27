<?php
/**
 * 通知地址
 *
 * 
 * by 33hao 好商城V3  www.33hao.com 开发
 */
$_GET['m']	= 'payment';
$_GET['a']		= 'notify';
$_POST['extra_common_param'] = 'real_order';
$_POST['out_trade_no'] = $_POST['ext1'];
$_POST['trade_no'] = $_POST['paymentOrderId'];
$_GET['payment_code'] = 'allinpay';
require_once(dirname(__FILE__).'/../../../index.php');
?>