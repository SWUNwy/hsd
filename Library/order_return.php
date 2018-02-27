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
class order_returnControl extends BaseHomeControl{	
	public function  indexOp(){  
		$order_sn = $_GET['order_sn'];
		$shipping_code = $_GET['invoice_no'];
		if($order_sn == "" || $shipping_code == ""){
			echo "fail";
			die();
		}
		$ret = Model("orders")->where(array("order_sn"=>$order_sn))->update(array("shipping_code"=>$shipping_code));		
		if($ret){
			//推送运单到关贸
			$model_order= Model('order');
			$model_datamessage= Model('datamessage');
			$order= $model_order->getOrderInfo(array("order_sn"=>$order_sn),array('order_goods','order_common'));
			if($order['is_postmessage'] != 0){
				$xml_data = $model_datamessage->arraytoemsxml($order); 		
		    	$model_datamessage->datapost($xml_data);	
			}
			echo "ok";
			die();
		}else{
			echo "fail";
			die();
		}
	}

}