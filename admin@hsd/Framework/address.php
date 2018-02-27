<?php
defined('ByShopKJYP') or exit('Access Invalid!');

/**
 * 检查地址是否包含相关的词语,如附近,母婴等
 * @param  [type] $rule    [description]
 * @param  [type] $address [description]
 * @return [type]          [description]
 */
function checkAddress($address){
    $model_setting = Model('setting');
    $list_setting = $model_setting->getListSetting();
    $rule = $list_setting['address_rule'];
    $result = array();
    if(!empty($rule)){
        $rule = str_replace(',','|',$rule);    
        $regex = "/{$rule}/";
        $num_matches = preg_match($regex, $address);
        $result['state'] = $num_matches;
        $result['message'] = $num_matches?$list_setting['address_message']:"";
    }
    return $result;
}
