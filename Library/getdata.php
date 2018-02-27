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
class getdataControl extends BaseHomeControl{	
	public function  indexOp(){  
		$model_order= Model('order');
		$model_goods= Model('goods');
		$model_datamessage= Model('datamessage');
		$data = $_POST["data"];	
        if($data!=null){
			$xml_data=urldecode(base64_decode($data));			
			//$file = fopen("log/".date("YmdHis").".txt","w+");
			$file = fopen("log/test.txt","w+");
			fwrite($file,$xml_data);
			fclose($file);						
		}
		else{
			echo "error";
			exit();
		}	
		//报文转换为数组
		$result = $model_datamessage->xml_to_array($xml_data); 	
		//判断是否为空
		if(!empty($result)){
			$this->ProcessingRecord($result);
		}
	}

	/**
	 * 处理收到的报文
	 * @param [type] $result [description]
	 */
	private function ProcessingRecord($result)
	{
		//判断是入库回执还是 审核
		if($result['MSGTYPE']!=""){
			switch ($result['MSGTYPE'][0]){
			//订单回执
			case 'KJDD':
				$this->askInfo($result);
				//$this->orderSuccess($result);
				break;
			//分运单回执
			case 'KJDD_FYD':
				$this->askInfo($result);
				break;
			default:
				# code...
				break;
			}
		}elseif(!empty($result['ORDER_HEAD'])){
			//判断是否订单回抛
			$this->getGmOrder($result);
		}else{
			$this->OrderInfoFb($result);
		}			
	} 

	/**
	 * 入库回执处理
	 * @param [type] $result [description]
	 */
	private function askInfo($result){	
		$model_order= Model('order');
		$condition['order_sn'] =$result['BIZNO'][0];
		$model_order= Model('order');
		$order= $model_order->getOrderInfo($condition,array('order_goods','order_common'));	
		if(empty($order)) {
			 echo "success";
			 die();
		}
		$update_message['messagememo']= $result['MSGTYPE'][0].$result['MSG'][0];
	    $update = $model_order->editOrder($update_message,$condition);	

	    $update_hgmessage['order_sn']=  $result['BIZNO'][0];
	    $update_hgmessage['messagecode']= $result['RETN'][0];
	    $update_hgmessage['messagememo']= $result['MSGTYPE'][0].$result['MSG'][0];
	    $update_hgmessage['msg_time']=time();
	    $model_hgmessage= Model('hgmessage');
	    //$res = $model_hgmessage->getHgmessageInfo(array('order_sn'=>$update_hgmessage['order_sn'],'messagememo'=>$update_hgmessage['messagememo']));
		//if(empty($res))
		//{
		$model_hgmessage->addHgmessage($update_hgmessage);
		//}		
	    if (!$update) {
		   echo "Flase";
		   die();
	    }		
	    echo "True";

	}
	
	
	/**
	 * 审核成功回执
	 */
	private function OrderInfoFb($result){
		//操作结果（1电子口岸已暂存/2电子口岸申报中/3发送海关成功/4发送海关失败/100海关退单/120海关入库/300人工审核/399海关审结/800放行/899结关/500查验/501扣留移送通关/502扣留移送缉私/503扣留移送法规/599其它扣留/700退运）,若小于0数字表示处理异常回执
		$code=$result['InventoryReturn']['returnStatus'];
		switch ($code) {
			case '800':
				$this->postShip($result);
			case '899':
				$this->OrderClearance($result);
				break;
			case '1399':
				$this->OrderError($result);
				break;
			default:
				# code...
				break;
		}
		$this->UpdateOrder($result);
		echo "True";
	}
		
	/**
	 * 出错的时候修改关贸的推送
	 * @param [type] $result [description]
	 */
	private function OrderError($result){
		$condition['order_sn'] =$result['InventoryReturn']['copNo'];
		$data = array();
		$data['is_postmessage'] = 0;
		$update = $model_order->editOrder($data,$condition);	
	}
	/**
	 * 订单结关处理
	 * @param [type] $result [description]
	 */
	private function OrderClearance($result){
		$condition['order_sn'] =$result['InventoryReturn']['copNo'];
		$model_order= Model('order');		 
		//取订单
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));	
		if($order['messagecode'] == "60"){
			return ;
		}	 
		//设置发货
		try {

			$model_order->beginTransaction();
			$data = array();
			//$data['shipping_express_id'] = '8';
			$data['shipping_time'] = TIMESTAMP;
			$condition = array();
			$condition['order_id'] = $order['order_id'];
			$condition['store_id'] = $order['store_id'];
			$update = $model_order->editOrderCommon($data,$condition);
			if (!$update) {
			  	echo "Flase";
		   		die();
			}
			$data = array();			 
			$data['order_state'] = ORDER_STATE_SEND;
			$data['delay_time'] = TIMESTAMP;
			//更改订单状态
			$update = $model_order->editOrder($data,$condition);	
			//判断是否已发过货，有时结关信息会收到多次	
			if (!$update) {
			    echo "Flase";
		   		die();
			}
			$model_order->commit();
			//库存操作
			
			//		
		} catch (Exception $e) {
			  $model_order->rollback();
			  echo "Flase";
		  	  die();
	    }
		//添加订单日志
		$data = array();
		$data['order_id'] = intval($_GET['order_id']);
		$data['log_role'] = 'seller';
		$data['log_user'] = $_SESSION['member_name'];
		$data['log_msg'] = L('order_log_send');
		$model_order->addOrderLog($data);		 
		$jgtime['jgtime']=time();
		$update = $model_order->editOrder($jgtime,array('order_sn'=>$result['InventoryReturn']['copNo']));
	}
	
	/**
	 * 更新订单并写日志
	 * @param [type] $result [description]
	 */
	private function UpdateOrder($result){

		$model_order= Model('order');
		$condition['order_sn'] =$result['InventoryReturn']['copNo'];
		//取订单
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
		if($order['messagecode'] == "60"){
			return ;
		}
		$update_message = array();
		if( $result['InventoryReturn']['returnStatus'] == '800' ||  $result['InventoryReturn']['returnStatus'] =='899'){
			$result['InventoryReturn']['returnStatus'] = 60;
		}
		$update_message['messagecode'] = $result['InventoryReturn']['returnStatus'];
		$update_message['messagememo'] = $result['InventoryReturn']['returnInfo'];
		$update = $model_order->editOrder($update_message,array('order_sn'=>$result['InventoryReturn']['copNo']));
		//插入数据库
		$update_hgmessage['order_sn'] = $result['InventoryReturn']['copNo'];
		$update_hgmessage['messagecode'] = $result['InventoryReturn']['returnStatus'];
		$update_hgmessage['messagememo'] = $result['InventoryReturn']['returnInfo'];
		$update_hgmessage['msg_time'] = time();
		$model_hgmessage = Model('hgmessage');
		//$res = $model_hgmessage->getHgmessageInfo(array('order_sn'=>$update_hgmessage['order_sn'],'messagememo'=>$update_hgmessage['messagememo']));
		//if(empty($res))
		//{
			$model_hgmessage->addHgmessage($update_hgmessage);
		//}		
		if (!$update) {
	       echo "Flase";
		   die();
   		}
	}
	
	/**
	 * 推送清单到仓库
	 */
	private function postShip($result){
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$condition['order_sn'] =$result['InventoryReturn']['copNo'];
		$invtNo = $result['InventoryReturn']['invtNo'];
		//取订单
		$order= $model_order->getOrderInfo($condition);

		if($order['tao_state']==1 && $order['store_storage_id']==1 ){	
  			//推送清单到仓库
  			$ret = Model("jbwms")->sendHgcode($order['order_sn'],$invtNo);
		}
		//判断是否丝路仓库
		if($order['store_storage_id'] == 3){
			$model_slwms = Model("slwms");
			$order_info = $model_order->getOrderInfo(array('order_sn'=>$order_sn),array('order_goods','order_common'));
			//提交订单到丝路仓
			$order_info['code'] = $invtNo;
			$res = $model_slwms->outOrderAdd($order_info);
			//如果推送成功,改变推送状态
			if($res['RESULTCODE']==0){
				$model_order->editOrder(array('tao_status'=>1),array('order_sn'=>$order['order_sn']));
			}

		}
		$update = array();
		//插入审核成功时间
		if($order['msg_time']=="0" &&  $order['messagecode']=="60"){
		 	$update['msg_time']=time();
		}
		$update['code'] = $invtNo;
		$model_order->editOrder($update,array('order_sn'=>$order['order_sn']));
	}

	/**
	 * 关贸订单回抛
	 * @param  [type] $result [description]
	 * @return [type]         [description]
	 */
	private function getGmOrder($result){
		$model_order = Model("order");
		$model_slwms = Model("slwms");
		$shipping_code = $result['ORDER_HEAD']['LOGISTICS_NO'];
		$order_sn = $result['ORDER_HEAD']['ORIGINAL_ORDER_NO'];
		$order_info = $model_order->getOrderInfo(array('order_sn'=>$order_sn));
		//判断运单是否为空,为空就不提交到仓库
		if($shipping_code!="" && !empty($order_info)){
			$update = array();				
			$update['shipping_code'] = $shipping_code;
			//保存运单号
			$model_order->editOrder($update,array('order_sn'=>$order_sn));
		}

	}
}