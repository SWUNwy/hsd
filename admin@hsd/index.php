<?php
/**
 * 商城板块初始化文件
 *
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */

define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
if (!@include(dirname(dirname(__FILE__)).'/shop.php')) exit('shop.php isn\'t exists!');

define('TPL_NAME',TPL_ADMIN_NAME);
define('TPL_SHOP_NAME',TPL_SHOP_NAME);
define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.'/Tpl/'.TPL_NAME);
define('ADMIN_RESOURCE_URL',ADMIN_SITE_URL.'/Public');
define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/Tpl/'.TPL_SHOP_NAME);
define('BASE_TPL_PATH',BASE_PATH.'/Tpl/'.TPL_NAME);
if (!@include(BASE_PATH.'/Library/control.php')) exit('control.php isn\'t exists!');
Base::run();
