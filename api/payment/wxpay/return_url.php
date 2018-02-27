<?php
/**
 * 接收微信请求，接收productid和用户的openid等参数，执行（【统一下单API】返回prepay_id交易会话标识
 *
 * 
 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
error_reporting(7);
$_GET['m']	= 'payment';
$_GET['a']		= 'wxpay_return';
require_once(dirname(__FILE__).'/../../../index.php');
?>