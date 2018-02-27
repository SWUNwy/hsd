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
class getkjypControl extends BaseHomeControl{	
	private $error = "";
	public function  indexOp(){   
		$order_sn = $_POST["order_sn"];	
		$shipping_code = $_POST["shipping_code"];	
		$shipping_express_id = $_POST["shipping_express_id"];	
        if($order_sn!="" && $shipping_code!=""){
			$data=json_decode(htmlspecialchars_decode($data),true);
			$file = fopen("kjyp/test.txt","w+");
			fwrite($file,print_r($data,true));
			fclose($file);	
		}
		else{
			echo "error";
			exit();
		}
		$this->orderSend($order_sn,$shipping_code,$shipping_express_id);
	}
	
	/**
	 * 发货
	 */
	private function orderSend($order_sn,$shipping_code,$shipping_express_id){
		$model_order = Model('order');
      	$order_info = $model_order->getOrderInfo(array('order_sn'=>$order_sn));
      	if(!empty($order_info) && $order_info['order_state']==20){
      		$update['order_state'] = 30;
            $update_common['shipping_time'] = time();  
            $update['shipping_code'] = $shipping_code;
            $update_common['shipping_express_id'] = $shipping_express_id;
            $model_order->editOrder($update,array('order_id'=>$order_info['order_id']));
            $model_order->editOrderCommon($update_common,array('order_id'=>$order_info['order_id']));   
      	}
      	
	}
}