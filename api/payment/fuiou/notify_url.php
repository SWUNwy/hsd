<?php
/**
 * 支付宝通知地址
 *
 * 
 * by 33hao 好商城V3  www.33hao.com 开发
 */

$_GET['m']	= 'payment';
$_GET['a']		= 'notify';
$_GET['payment_code'] = 'fuiou';
$_GET['extra_common_param'] = "real_order";
$_GET['out_trade_no'] = $_POST['order_id'];
$_GET['trade_no'] = $_POST['fy_ssn'];
require_once(dirname(__FILE__).'/../../../index.php');
?>