<?php
/**
 * 默认展示页面
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class datamessageControl extends SystemControl{
	
	public function __construct(){
		parent::__construct();
		
	}
	//提交订单到海关平台
	public function  postdataOp()
	{
		
		
		 if($_GET['order_id']) {
            $condition['order_id'] =$_GET['order_id'];
        }
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
		
		
		
		if($order['order_sn']=="")
		{
			showMessage("订单编号不能为空","",'html','error');
			
		}
		if($order['store_name']=="")
		{
			showMessage("电商企业名称不能为空","",'html','error');
			
		}
		if($order['extend_order_common']['reciver_info']['member_idcard']=="")
		{
			showMessage("身份证号码不能为空","",'html','error');
			
		}
		if($order['extend_order_common']['reciver_name']=="")
		{
			showMessage("姓名不能为空","",'html','error');
			
		}
		if(preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$order['extend_order_common']['reciver_info']['address'])=="")
		{
			showMessage("收货地址不能为空","",'html','error');
			
		}
		if($order['extend_order_common']['reciver_info']['phone']=="")
		{
			showMessage("手机号不能为空","",'html','error');
		}
		

		//判断同一身份证一天是否超过2000
		$model=Model();
		$member_idcard=$order['member_idcard'];		
		$condition	= array();
			//当天时间
		$start_unixtime=$end_unixtime=strtotime(date("Y-m-d",time()));			
		$condition['postmessagetime'] = array('time',array($start_unixtime,$end_unixtime));
		$condition['member_idcard']=$member_idcard;
		$condition['order_id'] =  array('not in',$_GET['order_id']);
		$list=$model->table('order')->field('sum(goods_amount) as goods_amount')->where($condition)->select();
		$goods_amount = $list[0]['goods_amount'];
		
		$condition1 = array();
		$condition1['order_id'] = $_GET['order_id'];
		$list1=$model->table('order')->field('sum(goods_amount) as goods_amount')->where($condition1)->select();
		$goods_amount1 = $list1[0]['goods_amount'];
		//echo $list[0]['alltax'];		
		$model_setting = Model('setting');
        $list_setting = $model_setting->getListSetting();

		if($goods_amount + $goods_amount1>$list_setting['order_post_amount'] )
	   	{			 
			showMessage("今天提交订单总额超过".$list_setting['order_post_amount'].",请明天提交","",'html','error'); 
		}
		
		//身份证相同一天只能提交一单，一周2单，一月4单
		$where=array();
		//今天
		$start=$end=strtotime(date("Y-m-d",time()));			
		$where['postmessagetime'] = array('time',array($start,$end));
		$where['order_id']=array('not in',$order['order_id']);
		$where['member_idcard'] =$order['member_idcard'] ;
		$order_sum=$model_order->getOrderCount($where);
		if($order_sum>=$list_setting['order_post_num'])
		{
			showMessage("同一身份证同一天只能提交".$list_setting['order_post_num']."单","",'html','error');
		}
		/*
		//一周时间
		$start=strtotime(date("Y-m-d",time()));
		$end=strtotime(date("Y-m-d", strtotime(" +1 week")));
		$where['postmessagetime'] = array('time',array($start,$end));
		$order_sum=$model_order->getOrderCount($where);
		if($order_sum>1)
		{
			showMessage("同一身份证同一周只能提交2单","",'html','error');
		}
		//一月4单
		$start=strtotime(date("Y-m-d",time()));
		$end=strtotime(date("Y-m-d", strtotime(" +1 month")));
		$where['postmessagetime'] = array('time',array($start,$end));
		$order_sum=$model_order->getOrderCount($where);
		if($order_sum>3)
		{
			showMessage("同一身份证同一月只能提交4单","",'html','error');
		}
		*/
		//缺货商品
		//$model_nostock  = Model('nostock');	
		$model_goods  = Model('goods');	
		//$rule= $model_nostock->getnoStockList($where,0,'n_id desc','goods_serial');
		//$rule =$this->array_column($rule, 'goods_serial');
		/*
		foreach($order['extend_order_goods'] as $v){
	
	
		$goods_info = $model_goods->getGoodsInfo(array('goods_id' => $v['goods_id']));
		$goodscommon_info = $model_goods->getGoodeCommonInfo(array('goods_commonid' => $goods_info['goods_commonid']));
		if(in_array($goodscommon_info['goods_serial'],$rule))
	    {
			 
		        showMessage("此商品无货，无法提交","",'html','error'); 
		}
		
		}
		*/
		
		//if(in_array(,$rule))
	   	// {
			 
		//	showMessage("此商品无货，无法提交","",'html','error'); 
		 //}
		  
		$model_hgmessage = Model("hgmessage");
		$hgmessage = $model_hgmessage->getHgmessageInfo(array('order_sn'=>$order['order_sn'],'messagememo'=>"KJDD入库成功"));
		
 		//判断是哪种验证方式 ，如果是收货人R就要提交支付单，如果是支付人P就不用提
 		if($list_setting['hg_type'] == 'R')
 		{
 			if(empty($hgmessage))
			{
				//订单
		   		$xml_data=$model_datamessage->arraytoxml($order);	
		   		$flag=$model_datamessage->datapost($xml_data);
			}
 			//支付单
 			$xml_data1=$model_datamessage->arraytopayxml($order);
 			$flag=$model_datamessage->datapost($xml_data1);
 		}
 		else 
 		{

 			if($order['payment_code']=="alipay"){
		    	$order['order_sn'] = $order['pay_sn'];
		   	 	$model_order->editOrder(array('order_sn'=>$order['pay_sn']),array('order_id'=>$order['order_id']));
			}
 			if(empty($hgmessage))
			{
				//订单
		   		
			}
			$xml_data=$model_datamessage->arraytoxml($order);	
		   	$flag=$model_datamessage->datapost($xml_data);
		   	
			$hgmessage = $model_hgmessage->getHgmessageInfo(array('order_sn'=>$order['order_sn'],'messagememo'=>"支付单入库成功"));
 			//支付企业推支付单的报文
 			if(empty($hgmessage)){ 	
 				$model_payment_message = Model("payment_message");
 				$res = $model_payment_message->SendMessage($order);
 			}
 		}
 		
		//清单
		//$xml_data = $model_datamessage->arraytolistxml($order);
        //$flag=$model_datamessage->datapost($xml_data);
		
		//运单
		//$xml_data2=$model_datamessage->arraytoemsxml($order);
 		//$model_datamessage->datapost($xml_data2);
		
		 if($flag)
		 { 	
			//print_r($order_info1);
			 //判断提交时间是否为空，为空则修改
			 if($order['postmessagetime']==0)
			 {
				 $update_message['postmessagetime']=time();
			 }
			 
			 
			 $update_message['is_postmessage']="1";
			 $update_message['messagecode']="20";
			 $update = $model_order->editOrder($update_message,array('order_id'=>$_GET['order_id']));
	  	  	 if (!$update) {
		        throw new Exception(L('nc_common_save_fail'));
	   		 }

			showMessage("提交海关平台成功,请等待审核","",'html','error');
		 }
		 else
		 {
			showMessage("提交海关平台失败","",'html','error');
		 }
		//print_r($order_info1);
		//showMessage("提交成功","",'html','error');
		
	}
	
	
    function array_column($input, $columnKey, $indexKey=null){
        $columnKeyIsNumber      = (is_numeric($columnKey)) ? true : false;
        $indexKeyIsNull         = (is_null($indexKey)) ? true : false;
        $indexKeyIsNumber       = (is_numeric($indexKey)) ? true : false;
        $result                 = array();
        foreach((array)$input as $key=>$row){
            if($columnKeyIsNumber){
                $tmp            = array_slice($row, $columnKey, 1);
                $tmp            = (is_array($tmp) && !empty($tmp)) ? current($tmp) : null;
            }else{
                $tmp            = isset($row[$columnKey]) ? $row[$columnKey] : null;
            }
            if(!$indexKeyIsNull){
                if($indexKeyIsNumber){
                    $key        = array_slice($row, $indexKey, 1);
                    $key        = (is_array($key) && !empty($key)) ? current($key) : null;
                    $key        = is_null($key) ? 0 : $key;
                }else{
                    $key        = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }
            $result[$key]       = $tmp;
        }
        return $result;
    }

	 /**
	 * 批量提交
	 *
	 */
	public function list_postOp(){
		
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$condition = array();
		 //print_r($_POST['id']);
		 //exit();
		 if(!empty($_POST['id'])&& is_array($_POST['id'])){
				foreach ($_POST['id'] as $key => $value) {

						if($value) {
							   $condition['order_id'] =$value;
							  }
							 
							  $order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
							  
							  if($order['order_sn']=="")
							  {
								continue; 
								  
							  }
							  if($order['store_name']=="")
							  {
								continue; 
								  
							  }
							  if($order['extend_order_common']['reciver_info']['member_idcard']=="")
							  {
								  continue; 
								  
							  }
							  if($order['extend_order_common']['reciver_name']=="")
							  {
								 continue; 
								  
							  }
							  if(preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$order['extend_order_common']['reciver_info']['address'])=="")
							  {
								  continue; 
								  
							  }
							  if($order['extend_order_common']['reciver_info']['phone']=="")
							  {
								 continue; 
							  }
							  
							  if(true)
							  {

														  	//判断同一身份证一天是否超过2000
									$model=Model();
									$member_idcard=$order['member_idcard'];		
									$condition1	= array();
										//当天时间
									$start_unixtime=$end_unixtime=strtotime(date("Y-m-d",time()));			
									$condition1['postmessagetime'] = array('time',array($start_unixtime,$end_unixtime));
									$condition1['member_idcard']=$member_idcard;
									$condition1['order_id'] =  array('not in',$order['order_id']);
									$list=$model->table('order')->field('sum(goods_amount) as goods_amount')->where($condition)->select();
									$goods_amount = $list[0]['goods_amount'];
									
									$condition2 = array();
									$condition2['order_id'] = $order['order_id'];
									$list1=$model->table('order')->field('sum(goods_amount) as goods_amount')->where($condition1)->select();
									$goods_amount1 = $list1[0]['goods_amount'];
									//echo $list[0]['alltax'];		
									$model_setting = Model('setting');
							        $list_setting = $model_setting->getListSetting();

									if($goods_amount + $goods_amount1>$list_setting['order_post_amount'] )
								   	{			 
										continue; 
									}
									
									//身份证相同一天只能提交一单，一周2单，一月4单
									$where=array();
									//今天
									$start=$end=strtotime(date("Y-m-d",time()));			
									$where['postmessagetime'] = array('time',array($start,$end));
									$where['order_id']=array('not in',$order['order_id']);
									$where['member_idcard'] =$order['member_idcard'] ;
									$order_sum=$model_order->getOrderCount($where);
									if($order_sum>=$list_setting['order_post_num'])
									{
										continue; 
									}
									
									
									 
									 /*
									 //身份证相同一天只能提交一单，一周2单，一月4单
									 $where=array();
									 //今天
									 $start=$end=strtotime(date("Y-m-d",time()));
									 
									 $where['postmessagetime'] = array('time',array($start,$end));
									 $where['order_id']=array('not in',$order['order_id']);
									 $order_sum=$model_order->getOrderCount($where);
									 if($order_sum>0)
									 {
									 	continue;
									 	//showMessage("同一身份证同一天只能提交1单","",'html','error');
									 }
									 //一周时间
									 $start=strtotime(date("Y-m-d",time()));
									 $end=strtotime(date("Y-m-d", strtotime(" +1 week")));
									 $where['postmessagetime'] = array('time',array($start,$end));
									 $order_sum=$model_order->getOrderCount($where);
									 if($order_sum>1)
									 {
									 	continue;
									 	//showMessage("同一身份证同一周只能提交2单","",'html','error');
									 }
									 //一月4单
									 $start=strtotime(date("Y-m-d",time()));
									 $end=strtotime(date("Y-m-d", strtotime(" +1 month")));
									 $where['postmessagetime'] = array('time',array($start,$end));
									 $order_sum=$model_order->getOrderCount($where);
									 if($order_sum>3)
									 {
									 	continue;
									 	//showMessage("同一身份证同一月只能提交4单","",'html','error');
									 }
									 */	
									
		
		
							  }
							
							  
						
							  //支付单
												   
							  //判断是哪种验证方式 ，如果是收货人R就要提交支付单，如果是支付人P就不用提
						 	  if($list_setting['hg_type'] == 'R')
						 	  {

								  //订单
								  $xml_data=$model_datamessage->arraytoxml($order);							  
								  $flag=$model_datamessage->datapost($xml_data);
						 			//支付单
						 		 $xml_data1=$model_datamessage->arraytopayxml($order);
						 		 $model_datamessage->datapost($xml_data1);
						 	  }
						 	  else 
						 	  {
						 		if($order['payment_code']=="alipay"){
							    	$order['order_sn'] = $order['pay_sn'];
							   	 	$model_order->editOrder(array('order_sn'=>$order['pay_sn']),array('order_id'=>$order['order_id']));
								}
									  
							  //订单
							  $xml_data=$model_datamessage->arraytoxml($order);							  
							  $flag=$model_datamessage->datapost($xml_data);

							  $hgmessage = $model_hgmessage->getHgmessageInfo(array('order_sn'=>$order['order_sn'],'messagememo'=>"支付单入库成功"));
					 			//支付企业推支付单的报文
					 		  if(empty($hgmessage)){ 	
					 				$model_payment_message = Model("payment_message");
					 				$model_payment_message->SendMessage($order);
					 			}
						 	  }
							  //清单
							  //$xml_data = $model_datamessage->arraytolistxml($order);
       						  //$flag=$model_datamessage->datapost($xml_data);
							  //运单
							  //$xml_data2=$model_datamessage->arraytoemsxml($order);
							  //$model_datamessage->datapost($xml_data2);
							  
							   if($flag)
							   { 	
								  //print_r($order_info1);
								  if($order['postmessagetime']==0)
								  {
									 $update_message['postmessagetime']=time();
			 					   }	
								   $update_message['is_postmessage']="1";
								   $update_message['messagecode']="20";
								   $update = $model_order->editOrder($update_message,array('order_id'=>$value));
								   if (!$update) {
									  throw new Exception(L('nc_common_save_fail'));
								   }
					  
								
							   }
				}
			}
		
			showMessage('提交成功','','html','error');
		
	}
	
	public function paydataOp(){
		if($_GET['order_id']) {
            $condition['order_id'] =$_GET['order_id'];
        }
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
		$model_payment_message = Model("payment_message");
 		$res = $model_payment_message->SendPayMessage($order);
 		if($res['flag']){
 			showMessage("推送成功","",'html','error');
 		}else{
 			showMessage("推送失败:{$res['pay_msg']}","",'html','error');
 		}
	}
	
	//提交运单号
	public function  postemsOp()
	{
		
	
		
		if($_GET['order_id']) {
            $condition['order_id'] =$_GET['order_id'];
        }
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
		
        //运单
		if($order['shipping_code']=="")
 		 {
	  
	  
	            
	  			//$order['shipping_code']=$model_datamessage->emspost($order['extend_order_common']['reciver_info']['address']);
	   			//$update['shipping_code']=$order['shipping_code'];
	   			//$update = $model_order->editOrder($update,array('order_sn'=>$order['order_sn']));
  		}
  		$xml_data2=$model_datamessage->arraytoemsxml($order); 		
		$res = $model_datamessage->datapost($xml_data2);
		
		//$xml_data2=$model_datamessage->arraytoemsxml1($order); 		
		//$res = $model_datamessage->datapost($xml_data2);
     	
		if($res)
		{
			showMessage("提交海关平台成功,请等待审核","",'html','error');
		}
		else
		{
			showMessage("操作失败，请重试","",'html','error');
		}
		
		
		
		
	}
	//提交EA
	public function  posteaOp()
	{
		
	
		
		if($_GET['order_id']) {
            $condition['order_id'] =$_GET['order_id'];
        }
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
		
		$re= $model_datamessage->eapost($order);
		 
        if($re!=null)
		  {
			  
			  $file = fopen("test1.txt","w+");
			  fwrite($file,$re);
			  fclose($file);
			  
			  $re = $model_datamessage->xml_to_array($re);  
		
		    
			if($re['status'][0]!="")
			{
				 $ea_status['ea_status']=$re['status'][0];
			}
			if($re['pos']['po']['sts']!="")
			{
				 $ea_status['ea_status']=$re['pos']['po']['sts'];
			}
			
			
			

			  $update =  $model_order->editOrder($ea_status,array('order_sn'=>$order['order_sn']));
				 
			
				  
		   }
				  	
		
		showMessage("提交EA成功,请等待审核","",'html','error');
		
		
		
	}
	
	
	//提交B账册
	public function  postbOp()
	{
		
	
		
		if($_GET['order_id']) {
            $condition['order_id'] =$_GET['order_id'];
        }
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
	
		 $re= $model_datamessage->cqemsbusiness($order);
		 
         if($re!=null && $re==0)
		 {
			
		  	  $b_status['b_status']=1;
			  $update =  $model_order->editOrder($b_status,array('order_sn'=>$order['order_sn']));
				 
			  showMessage("提交B账册成功,请等待审核","",'html','error');
		
				  
		 }
		 else
		 {	
		 
		 	
			   showMessage("提交B账册失败,请等待审核","",'html','error');

			 
		 }
				  	
		
		
		
		
	}
	
	//海关退货提交 
	public function  postdatatuihuoOp()
	{
		 if($_GET['order_id']) {
            $condition['order_id'] =$_GET['order_id'];
        }
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
		if($order['order_sn']=="")
		{
			showMessage("订单编号不能为空","",'html','error');
			
		}
		if($order['store_name']=="")
		{
			showMessage("电商企业名称不能为空","",'html','error');
			
		}
		
		
		 $xml_data=$model_datamessage->arraytotuihuoxml($order);
	 	
	
		 $flag=$model_datamessage->datapost($xml_data);
 	
	
         if($flag)
		 { 	
			
            
			$update_message['messagecode']="85";
			$update = $model_order->editOrder($update_message,array('order_id'=>$order['order_id']));
			showMessage("退款提交成功,请等待审核","",'html','error');
		 }
		 else
		 {
			showMessage("提交失败","",'html','error');
		 }
		//print_r($order_info1);
		//showMessage("提交成功","",'html','error');
		
	}
	
	
	
	
	
	
	//提交商品到海关平台
	public function  postgoodsdataOp()
	{
		
		
		 if($_GET['goods_id']) {
            $condition['goods_commonid'] =$_GET['goods_id'];
        }
		$model_goods= Model('goods');
		$model_datamessage= Model('datamessage');
		$goods= $model_goods->getGoodeCommonInfo( $condition);
		
	
		
		//print_r($goods);
		
		
		 $xml_data=$model_datamessage->arraytogoodsxml($goods);
 		
		 $flag=$model_datamessage->datapost($xml_data);
	
		 if($flag)
		 { 	
			//print_r($order_info1);
			
			 $update_message['is_postmessage']="1";
			 $update = $model_goods->editGoodsCommon($update_message,array('goods_commonid'=>$_GET['goods_id']));
	  	  	 if (!$update) {
		        throw new Exception(L('nc_common_save_fail'));
	   		 }

			showMessage("提交海关平台成功,请等待审核","",'html','error');
		 }
		 else
		 {
			showMessage("提交海关平台失败","",'html','error');
		 }
		
		
	}
	
}