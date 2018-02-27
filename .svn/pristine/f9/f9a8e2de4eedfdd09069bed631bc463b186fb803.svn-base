<?php
/**
 * 通知地址
 *
 * 
 * by 33hao 好商城V3  www.33hao.com 开发
 */
$_GET['m']	= 'payment';
$_GET['a']		= 'return';
$_GET['extra_common_param'] = 'real_order';
$_GET['out_trade_no'] = $_POST['ext1'];
$_GET['trade_no'] = $_POST['paymentOrderId'];
$_GET['payment_code'] = 'allinpay';

$fp = fopen("log.txt","w+");
fwrite($fp,print_r($_POST,true));
fclose();
require_once(dirname(__FILE__).'/../../../index.php');
?>