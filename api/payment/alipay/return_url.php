<?php
/**
 * 支付宝返回地址
 *
 * 
 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
error_reporting(7);
$_GET['m']	= 'payment';
$_GET['a']		= 'return';
$_GET['payment_code'] = 'alipay';
require_once(dirname(__FILE__).'/../../../index.php');
?>