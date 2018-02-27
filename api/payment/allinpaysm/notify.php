<?php
	require_once 'AppConfig.php';
	require_once 'AppUtil.php';
	$fp = fopen('./1.txt', "w+");
	fwrite($fp,print_r($_POST,true));
	fclose($fp);
	$params = array();
	foreach($_POST as $key=>$val) {//动态遍历获取所有收到的参数,此步非常关键,因为收银宝以后可能会加字段,动态获取可以兼容由于收银宝加字段而引起的签名异常
		$params[$key] = $val;
	}
	if(count($params)<1){//如果参数为空,则不进行处理
		echo "error";
		exit();
	}
	if(AppUtil::ValidSign($params, AppConfig::APPKEY)){//验签成功
	//if(true){//验签成功
		if(strlen($params['cusorderid'])==32){
            $md5_info = Model('order_pay_md5')->where(array('pay_md5'=>$params['cusorderid']))->find();
            $params['cusorderid'] = $md5_info['pay_sn'];
        }
		if (in_array($params['trxreserved'],array('v','r'))) {
		    $order_type = $params['trxreserved'];
		} else {
		    $order_pay_info = Model('order')->getOrderPayList(array('pay_sn'=> $params['cusorderid']));
		    if(empty($order_pay_info)){
		        $order_type = 'v';
		    } else {
		        $order_type = 'r';
		    }
		}
		$logic_payment = Logic('payment');
		if ($order_type == 'r') {
		    $result = $logic_payment->getRealOrderInfo($params['cusorderid']);
		    print_r($params['cusorderid']);
		    if(!$result['state']) {
		        return false;
		    }
		    if ($result['data']['api_pay_state']) {
		        return true;
		    }
		    $order_list = $result['data']['order_list'];
		    echo "daf";
		    $result = $logic_payment->updateRealOrder($params['cusorderid'], 'allinpay_saoma', $order_list, $data["transaction_id"]);
		    if (!$result['state']) {
		        return false;
		    }
		    $api_pay_amount = 0;
		    if (!empty($order_list)) {
		        foreach ($order_list as $order_info) {
		            $api_pay_amount += $order_info['order_amount'] - $order_info['pd_amount'] - $order_info['rcb_amount'];
		        }
		    }

		} else {
		    $result = $logic_payment->getVrOrderInfo($params['cusorderid']);
		    if (!in_array($result['data']['order_state'],array(ORDER_STATE_NEW,ORDER_STATE_CANCEL))) {
		        return true;
		    }
		    $order_info = $result['data'];
		    $result = $logic_payment->updateVrOrder($params['cusorderid'], 'allinpay_saoma', $order_info, $data["transaction_id"]);
		    if (!$result['state']) {
		        return false;
		    }
		    $api_pay_amount = $order_info['order_amount'] - $order_info['pd_amount'] - $order_info['rcb_amount'];
		}
		//记录消费日志
		if ($order_type == 'r') {
		    $log_buyer_id = $order_list[0]['buyer_id'];
		    $log_buyer_name = $order_list[0]['buyer_name'];
		    $log_desc = '实物订单使用扫码成功支付，支付单号：'.$data['out_trade_no'];
		} else {
		    $log_buyer_id = $order_info['buyer_id'];
		    $log_buyer_name = $order_info['buyer_name'];
		    $log_desc = '虚拟订单使用扫码成功支付，支付单号：'.$data['out_trade_no'];
		}
		QueueClient::push('addConsume', array('member_id'=>$log_buyer_id,'member_name'=>$log_buyer_name,
		'consume_amount'=>ncPriceFormat($api_pay_amount),'consume_time'=>TIMESTAMP,'consume_remark'=>$log_desc));
		echo "success";
	}
	else{
		echo "erro";
	}

?>  
