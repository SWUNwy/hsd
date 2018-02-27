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

define('BASE_PATH',str_replace('\\','/',dirname(dirname(dirname(__FILE__)))));
define('MODULES_BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
require __DIR__ . '/../../../shop.php';

define('TPL_NAME',TPL_ADMIN_NAME);
define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.'/Tpl/'.TPL_NAME);
define('ADMIN_RESOURCE_URL',ADMIN_SITE_URL.'/Public');
define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/Tpl/'.TPL_NAME);
define('BASE_TPL_PATH',MODULES_BASE_PATH.'/Tpl/'.TPL_NAME);
define('MODULE_NAME', 'mobile');
if (!@include(BASE_PATH.'/Library/control.php')) exit('control.php isn\'t exists!');
$system='mobile';

Base::runadmin($system);
