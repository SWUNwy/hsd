<?php
/**
 * 接收扫码支付异步通知回调地址
 *
 * 
 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
error_reporting(7);
$_GET['m']	= 'payment';
$_GET['a']		= 'allinpay_notify';
require_once(dirname(__FILE__).'/../../../index.php');
