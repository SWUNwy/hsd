<?php
/**
 * 接收微信支付异步通知回调地址
 *
 * 
 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
error_reporting(7);
$_GET['m']	= 'payment';
$_GET['a']		= 'wxpay_notify';
require_once(dirname(__FILE__).'/../../../index.php');
