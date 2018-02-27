<?php
/**
 * 商城板块初始化文件
 *
 *
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 */
define('APP_ID','shop');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

require __DIR__ . '/shop.php';
define('APP_SITE_URL',SHOP_SITE_URL);
define('TPL_NAME',TPL_SHOP_NAME);
define('SHOP_RESOURCE_SITE_URL',SHOP_SITE_URL.DS.'Public');
define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/Tpl/'.TPL_NAME);
define('BASE_TPL_PATH',BASE_PATH.'/Tpl/'.TPL_NAME);
if (!@include(BASE_PATH.'/Library/control.php')) exit('control.php isn\'t exists!');
Base::run();
