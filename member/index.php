<?php
/**
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */
define('APP_ID','member');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

require __DIR__ . '/../shop.php';

define('APP_SITE_URL', MEMBER_SITE_URL);
define('TPL_NAME',TPL_MEMBER_NAME);
define('MEMBER_TEMPLATES_URL', MEMBER_SITE_URL.'/Tpl/'.TPL_MEMBER_NAME);
define('BASE_MEMBER_TEMPLATES_URL', dirname(__FILE__).'/Tpl/'.TPL_MEMBER_NAME);
define('MEMBER_RESOURCE_SITE_URL',MEMBER_SITE_URL.'/Public');
define('LOGIN_RESOURCE_SITE_URL',LOGIN_SITE_URL.'/Public');
define('LOGIN_TEMPLATES_URL', LOGIN_SITE_URL.'/Tpl/'.TPL_MEMBER_NAME);
if (!@include(BASE_PATH.'/Library/control.php')) exit('control.php isn\'t exists!');
Base::run();
