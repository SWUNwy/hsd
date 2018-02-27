<?php
/**
 * 队列
 *
 *
 *
 *
 */
$_SERVER['argv'][1] = $_GET['m'];
@$_SERVER['argv'][2] = $_GET['a'];

if (empty($_SERVER['argv'][1])) exit('Access Invalid!');

define('APP_ID','crontab');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
define('TRANS_MASTER',true);
require __DIR__ . '/../shop.php';

if (PHP_SAPI == 'cli') {
     $_GET['m'] = $_SERVER['argv'][1];
     $_GET['a'] = empty($_SERVER['argv'][2]) ? 'index' : $_SERVER['argv'][2];
}
if (!@include(BASE_PATH.'/Library/control.php')) exit('control.php isn\'t exists!');
Base::run();
