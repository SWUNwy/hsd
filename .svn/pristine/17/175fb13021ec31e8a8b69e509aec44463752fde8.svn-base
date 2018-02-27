<?php
/**
 * 海关回执页面
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class xjorder_returnControl extends BaseHomeControl{	
	public function  indexOp(){  
		$model_datamessage= Model('datamessage');
		$data = $_POST["data"];	
        if($data !=null){
			$xml_data = urldecode(base64_decode($data));	
			$result = $model_datamessage->xml_to_array($xml_data);
			$order_sn = $result['ORIGINAL_ORDER_NO'][0];		
			$shipping_code = $result['TRANSPORT_BILL_NO'][0];	
			$ret = Model("orders")->where(array("order_sn"=>$order_sn))->update(array("shipping_code"=>$shipping_code));	
			echo "true";
			die();
		}else{
			echo "false";
			die();
		}
	}
}