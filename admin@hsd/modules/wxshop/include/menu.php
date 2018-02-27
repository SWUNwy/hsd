<?php
/**
 * 菜单
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */
defined('ByShopKJYP') or exit('Access Invalid!');
$_menu['wxshop'] = array (
        'name' => '微信通',
        'child' => array(
                array(
                        'name' => "设置", 
                        'child' => array(
                                'wxconfig' => "微信接口",
                                'menu' => "菜单设置",
                                'config' => "微信设置",
                                'oauth' => "微信OAuth",
                        )
                ),
              
        )
);