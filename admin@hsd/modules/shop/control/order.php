<?php
/**
 * 交易管理g
 *
 *
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */



defined('ByShopKJYP') or exit('Access Invalid!');
class orderControl extends SystemControl{
    /**
     * 每次导出订单数量
     * @var int
     */
    const EXPORT_SIZE = 1000;

    public function __construct(){
        parent::__construct();
        Language::read('trade');
    }

    public function indexOp(){
        //显示支付接口列表(搜索)
        $payment_list = Model('payment')->getPaymentOpenList();
        $payment_list['wxpay'] = array(
            'payment_code' => 'wxpay',
            'payment_name' => '微信支付'
        );
        $store_list = Model("store")->getStoreList(array(),1000);
	
        Tpl::output('store_list',$store_list);
        Tpl::output('payment_list',$payment_list);
		Tpl::setDirquna('shop');
        Tpl::showpage('order.index');
    }

    public function get_xmlOp(){
        $model_order = Model('order');
        $condition  = array();

        $this->_get_condition($condition);

        $sort_fields = array('buyer_name','store_name','order_id','payment_code','order_state','order_amount','order_from','pay_sn','rcb_amount','pd_amount','payment_time','finnshed_time','evaluation_state','refund_amount','buyer_id','store_id');
        if ($_POST['sortorder'] != '' && in_array($_POST['sortname'],$sort_fields)) {
            $order = $_POST['sortname'].' '.$_POST['sortorder'];
        }

        $order_list = $model_order->getOrderList($condition,$_POST['rp'],'*',$order);
        $data = array();
        $data['now_page'] = $model_order->shownowpage();
        $data['total_num'] = $model_order->gettotalnum();
        foreach ($order_list as $order_id => $order_info) {
            $order_info['if_system_cancel'] = $model_order->getOrderOperateState('system_cancel',$order_info);
            $order_info['if_system_receive_pay'] = $model_order->getOrderOperateState('system_receive_pay',$order_info);           
            $order_info['state_desc'] = orderState($order_info);

            //取得订单其它扩展信息
            $model_order->getOrderExtendInfo($order_info);

            $list = array();$operation_detail = '';
            $list['operation'] = "<a class=\"btn green\" href=\"index.php?m=order&a=show_order&order_id={$order_info['order_id']}\"><i class=\"fa fa-list-alt\"></i>查看</a>";
            if ($order_info['if_system_cancel']) {
                $operation_detail .= "<li><a href=\"javascript:void(0);\" onclick=\"fg_cancel({$order_info['order_id']})\">取消订单</a></li>";
            }
            if ($order_info['if_system_receive_pay']) {
                $op_name = $order_info['system_receive_pay_op_name'] ? $order_info['system_receive_pay_op_name'] : '收到货款';
                $operation_detail .= "<li><a href=\"index.php?m=order&a=change_state&state_type=receive_pay&order_id={$order_info['order_id']}\">{$op_name}</a></li>";
            }
            if ($operation_detail) {
                $list['operation'] .= "<span class='btn'><em><i class='fa fa-cog'></i>设置 <i class='arrow'></i></em><ul>{$operation_detail}</ul>";
            }
            $list['order_sn'] = $order_info['order_sn'].str_replace(array(1,2,3), array(null,' [预定]','[门店自提]'), $order_info['order_type'])."(<a href='javascript:void(0)' onclick='pushShip({$order_info['order_id']});'>提交 </a> {$order_info['shipping_code']})";            
            $list['store_name'] = $order_info['store_name'];
            $list['buyer_name'] = $order_info['buyer_name'];
			//支付单
            if($order_info['pay_status']){
                $list['pay_status'] = "<font style='color:green'>是</font>";
            }else{
                $list['pay_status'] = "<a style='color:red' href='javascript:void(0)' onclick='pushDingPay({$order_info['order_id']});'>否</a>"; 
            }
            //推送淘宝仓  
            if($order_info['tao_status']){
                $list['is_posttao'] = "<font style='color:green'>是</font>";
            }else{
                if($order_info['store_storage_id']!=2){
                    $list['is_posttao'] = $order_info['tao_state']?"<a style='color:red' href='javascript:void(0)' onclick='pushTao({$order_info['order_id']});'>否</a>":"否"; 
                }else{
                    $list['is_posttao'] = "";
                }              
            }     

			//推送关贸
           	if($order_info['is_postmessage']){
           		$list['is_postmessage'] = "<font style='color:green'>是</font>";
           	}else{
           		$list['is_postmessage'] = "<a style='color:red' href='javascript:void(0)' onclick='pushCustoms({$order_info['order_id']});'>否</a>"; 
           	}     
           	
           	
            $list['order_from'] = str_replace(array(1,2), array('PC端','移动端'),$order_info['order_from']);
            $list['add_times'] = date('Y-m-d H:i:s',$order_info['add_time']);
			$list['order_amount'] = ncPriceFormat($order_info['order_amount']);
			if ($order_info['shipping_fee']) {
			    $list['order_amount'] .= '(含运费'.ncPriceFormat($order_info['shipping_fee']).')';
			}
			$list['order_state'] = $order_info['state_desc'];
            $list['pay_sn'] = empty($order_info['pay_sn']) ? '' : $order_info['pay_sn'];
			$list['payment_code'] = orderPaymentName($order_info['payment_code']);
			$list['payment_time'] = !empty($order_info['payment_time']) ? (intval(date('His',$order_info['payment_time'])) ? date('Y-m-d H:i:s',$order_info['payment_time']) : date('Y-m-d',$order_info['payment_time'])) : '';
            if($order_info['shipping_code']!=""){
                $list['shipping_code'] = "<a href='javascript:void(0)' onclick='getShip(\"{$order_info['order_sn']}\");'>".$order_info['shipping_code']."</a>";
            }else{
               $list['shipping_code'] = "<a href='javascript:void(0)' onclick='getShip(\"{$order_info['order_sn']}\");'>取单号</a>";
            }
            $list['messagememo'] = $order_info['messagememo'];
            //备注
            $order_remark = $order_info['order_remark']!=""?$order_info['order_remark']:"暂无";
            $list['order_remark'] =  "<a href='javascript:void(0)' onclick='add_order_remark(".$order_info['order_id'].")'>".$order_remark."</a>";
			
			$data['list'][$order_info['order_id']] = $list;
        }
        exit(Tpl::flexigridXML($data));
    }


	/**
	 * 推送订单至海关模版
	 */
	public function post_customsOp()
	{
		$id = $_GET['id'];
		if(empty($id))
		{
			showDialog(L('nc_common_op_fail'), 'reload');
		}		
		$ids = explode(',',$id);		
		$count = count($ids);
		Tpl::output('id',$id);
		Tpl::output('count',$count);
		Tpl::setDirquna('shop');
        Tpl::showpage('order.post_customs', 'null_layout');
	}


	/**
	 * 批量推送订单至海关
	 *
	 */
	public function ajax_customsOp()
	{
		$model_order = Model('order');
		$order_id = intval($_GET['order_id']);
		$res = $this->PostCustomsByID($order_id);
		//推送海关
	   
		$result['state'] = $res['state'];
		$result['order_id'] = $order_id;
		$result['msg'] = $res['msg'];
		if($result['state'])
		{
			$result['msg'] = "<font style='color:green'><i class='fa fa-check-circle'></i>推送海关成功！</font>";
		}
		else
		{
			$result['msg'] = "<font style='color:red'><i class='fa fa-times-circle'></i>推送海关失败,".$res['msg']."</font>";	
		}
        echo json_encode ($result);
		sleep(2);
	   
	}
	
	/**
	 * 根据ID推订单
	 */
	private function PostCustomsByID($order_id)
	{
		$model_order= Model('order');
		$model_datamessage= Model('datamessage');
		$res = array();
		$res['state'] = false;
		if($order_id<=0)
		{
			$res['msg'] = "参数有误！";
			return $res;
		}		
		$order= $model_order->getOrderInfo( $condition,array('order_goods','order_common'));
		if(empty($order))
		{
			$res['msg'] = "没有找到相关订单！";
			return $res;
		}
		if($order['order_sn']=="")
		{
			$res['msg'] = "订单编号不能为空!";
			return $res;			
		}
		if($order['store_name']=="")
		{
			$res['msg'] = "电商企业名称不能为空!";
			return $res;			
		}
		if($order['extend_order_common']['reciver_info']['member_idcard']=="")
		{
			$res['msg'] = "身份证号码不能为空!";
			return $res;				
		}
		if($order['extend_order_common']['reciver_name']=="")
		{
			$res['msg'] = "姓名不能为空!";
			return $res;			
		}
		if(preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$order['extend_order_common']['reciver_info']['address'])=="")
		{			
			$res['msg'] = "收货地址不能为空!";
			return $res;			
		}
		if($order['extend_order_common']['reciver_info']['phone']=="")
		{
			$res['msg'] = "手机号不能为空!";
			return $res;
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
		if($goods_amount + $goods_amount1>$list_setting['order_post_amount'] )	   	{					
			$res['msg'] = "今天提交订单总额超过".$list_setting['order_post_amount'];
			return $res;
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
			$res['msg'] = "同一身份证同一天只能提交".$list_setting['order_post_num']."单";
			return $res;			
		}
		$model_hgmessage = Model("hgmessage");
		$hgmessage = $model_hgmessage->getHgmessageInfo(array('order_sn'=>$order['order_sn'],'messagememo'=>"订单入库成功"));
		if(empty($hgmessage))
		{
			//订单
	   		$xml_data=$model_datamessage->arraytoxml($order);	
	   		$flag=$model_datamessage->datapost($xml_data);
		}
 		//判断是哪种验证方式 ，如果是收货人R就要提交支付单，如果是支付人P就不用提
 		if($list_setting['hg_type'] == 'R')
 		{
 			
 			//支付单
 			$xml_data1=$model_datamessage->arraytopayxml($order);
 			$flag=$model_datamessage->datapost($xml_data1);
 		}
 		else 
 		{
 			$hgmessage = $model_hgmessage->getHgmessageInfo(array('order_sn'=>$order['order_sn'],'messagememo'=>"支付单入库成功"));
 			//支付企业推支付单的报文
 			if(empty($hgmessage))
 			{ 			
 				$model_payment_message = Model("payment_message");
 				$model_payment_message->SendMessage($order);
 			}
 		}
		$res['state'] = $flag;
		return $res;
		
	}
    /**
     * 平台订单状态操作
     *
     */
    public function change_stateOp() {
        $order_id = intval($_GET['order_id']);
        if($order_id <= 0){
            showMessage(L('miss_order_number'),$_POST['ref_url'],'html','error');
        }
        $model_order = Model('order');

        //获取订单详细
        $condition = array();
        $condition['order_id'] = $order_id;
        $order_info = $model_order->getOrderInfo($condition);

        //取得其它订单类型的信息
        $model_order->getOrderExtendInfo($order_info);

        if ($_GET['state_type'] == 'cancel') {
            $result = $this->_order_cancel($order_info);
        } elseif ($_GET['state_type'] == 'receive_pay') {
            $result = $this->_order_receive_pay($order_info,$_POST);
        }
        if (!$result['state']) {
            showMessage($result['msg'],$_POST['ref_url'],'html','error');
        } else {
            showMessage($result['msg'],$_POST['ref_url']);
        }
    }

    /**
     * 系统取消订单
     */
    private function _order_cancel($order_info) {
        $order_id = $order_info['order_id'];
        $model_order = Model('order');
        $logic_order = Logic('order');
        $if_allow = $model_order->getOrderOperateState('system_cancel',$order_info);
        if (!$if_allow) {
            return callback(false,'无权操作');
        }
        if (TIMESTAMP - 86400 < $order_info['api_pay_time']) {
            $_hour = ceil(($order_info['api_pay_time']+86400-TIMESTAMP)/3600);
            exit(json_encode(array('state'=>false,'msg'=>'该订单曾尝试使用第三方支付平台支付，须在'.$_hour.'小时以后才可取消')));
        }
        if ($order_info['order_type'] == 2) {
            //预定订单
            $result = Logic('order_book')->changeOrderStateCancel($order_info, 'admin', $this->admin_info['name']);
        } else {
            $cancel_condition = array();
            if ($order_info['payment_code'] != 'offline') {
                $cancel_condition['order_state'] = ORDER_STATE_NEW;
            }
            $result =  $logic_order->changeOrderStateCancel($order_info,'admin', $this->admin_info['name'],'',true,$c);
        }
        if ($result['state']) {
            $this->log(L('order_log_cancel').','.L('order_number').':'.$order_info['order_sn'],1);
        }
        if ($result['state']) {
            exit(json_encode(array('state'=>true,'msg'=>'取消成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'取消失败')));
        }
    }

    /**
     * 系统收到货款
     * @throws Exception
     */
    private function _order_receive_pay($order_info, $post) {
        $order_id = $order_info['order_id'];
        $model_order = Model('order');
        $logic_order = Logic('order');
        $order_info['if_system_receive_pay'] = $model_order->getOrderOperateState('system_receive_pay',$order_info);

        if (!$order_info['if_system_receive_pay']) {
            return callback(false,'无权操作');
        }

        if (!chksubmit()) {
            Tpl::output('order_info',$order_info);
            //显示支付接口列表
            $payment_list = Model('payment')->getPaymentOpenList();
            //去掉预存款和货到付款
            foreach ($payment_list as $key => $value){
                if ($value['payment_code'] == 'predeposit' || $value['payment_code'] == 'offline') {
                   unset($payment_list[$key]);
                }
            }
            Tpl::output('payment_list',$payment_list);
			Tpl::setDirquna('shop');
            Tpl::showpage('order.receive_pay');
            exit();
        }
        //预定支付尾款时需要用到已经支付的状态
        $order_list = $model_order->getOrderList(array('pay_sn'=>$order_info['pay_sn'],'order_state'=>array('in',array(ORDER_STATE_NEW,ORDER_STATE_PAY))));

        //取订单其它扩展信息
        $result = Logic('payment')->getOrderExtendList($order_list,'admin');
        if (!$result['state']) {
            return $result;
        }
        $result = $logic_order->changeOrderReceivePay($order_list,'admin',$this->admin_info['name'],$post);
        if ($result['state']) {
            $this->log('将订单改为已收款状态,'.L('order_number').':'.$order_info['order_sn'],1);
            //记录消费日志
            $api_pay_amount = $order_info['order_amount'] - $order_info['pd_amount'] - $order_info['rcb_amount'];
            QueueClient::push('addConsume', array('member_id'=>$order_info['buyer_id'],'member_name'=>$order_info['buyer_name'],
            'consume_amount'=>$api_pay_amount,'consume_time'=>TIMESTAMP,'consume_remark'=>'管理员更改订单为已收款状态，订单号：'.$order_info['order_sn']));
        }
        return $result;
    }

    /**
     * 查看订单
     *
     */
    public function show_orderOp(){
        $order_id = intval($_GET['order_id']);
        if($order_id <= 0 ){
            showMessage(L('miss_order_number'));
        }
        $model_order    = Model('order');
        $order_info = $model_order->getOrderInfo(array('order_id'=>$order_id),array('order_goods','order_common','store'));
        $pay_md5 = Model('order_pay_md5')->where(array('pay_sn'=>$order_info['pay_sn']))->find();
        Tpl::output('pay_md5',$pay_md5['pay_md5']);
        foreach ($order_info['extend_order_goods'] as $value) {
            $value['image_60_url'] = cthumb($value['goods_image'], 60, $value['store_id']);
            $value['image_240_url'] = cthumb($value['goods_image'], 240, $value['store_id']);
            $value['goods_type_cn'] = orderGoodsType($value['goods_type']);
            $value['goods_url'] = urlShop('goods','index',array('goods_id'=>$value['goods_id']));
            if ($value['goods_type'] == 5) {
                $order_info['zengpin_list'][] = $value;
            } else {
                $order_info['goods_list'][] = $value;
            }
        }
        
        if (empty($order_info['zengpin_list'])) {
            $order_info['goods_count'] = count($order_info['goods_list']);
        } else {
            $order_info['goods_count'] = count($order_info['goods_list']) + 1;
        }

        //取得订单其它扩展信息
        $model_order->getOrderExtendInfo($order_info);

        //订单变更日志
        $log_list   = $model_order->getOrderLogList(array('order_id'=>$order_info['order_id']));
        Tpl::output('order_log',$log_list);

        //退款退货信息
        $model_refund = Model('refund_return');
        $condition = array();
        $condition['order_id'] = $order_info['order_id'];
        $condition['seller_state'] = 2;
        $condition['admin_time'] = array('gt',0);
        $return_list = $model_refund->getReturnList($condition);
        Tpl::output('return_list',$return_list);

        //退款信息
        $refund_list = $model_refund->getRefundList($condition);
        Tpl::output('refund_list',$refund_list);

        //商家信息
        $store_info = Model('store')->getStoreInfo(array('store_id'=>$order_info['store_id']));
        Tpl::output('store_info',$store_info);

        //商家发货信息
        if (!empty($order_info['extend_order_common']['daddress_id'])) {
            $daddress_info = Model('daddress')->getAddressInfo(array('address_id'=>$order_info['extend_order_common']['daddress_id']));
            Tpl::output('daddress_info',$daddress_info);
        }

        //显示快递信息
        if ($order_info['shipping_code'] != '') {
            $express = rkcache('express',true);
            $order_info['express_info']['e_code'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_code'];
            $order_info['express_info']['e_name'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_name'];
            $order_info['express_info']['e_url'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_url'];
        }

        //如果订单已取消，取得取消原因、时间，操作人
        if ($order_info['order_state'] == ORDER_STATE_CANCEL) {
            $order_info['close_info'] = $model_order->getOrderLogInfo(array('order_id'=>$order_info['order_id'],'log_orderstate'=>ORDER_STATE_CANCEL),'log_id desc');
        }

        //如果订单已支付，取支付日志信息(主要是第三方平台支付单号)
        if ($order_info['order_state'] == ORDER_STATE_PAY) {
            $order_info['pay_info'] = $model_order->getOrderLogInfo(array('order_id'=>$order_info['order_id'],'log_orderstate'=>ORDER_STATE_PAY),'log_id desc');
        }

        Tpl::output('order_info',$order_info);
		Tpl::setDirquna('shop');
        Tpl::showpage('order.view');
    }

	/**
	* 修改姓名或身份证
	*
	*/
	public function editOrderCommandOp(){
			   
	   $model_order = Model('order');
	   $order_id=$_POST['order_id'];
	   $reciver_name=trim($_POST['reciver_name']);
	   $member_idcard=trim($_POST['member_idcard']);
	   $member_address=trim($_POST['member_address']);
	   $member_phone=trim($_POST['member_phone']);
	   $condition	= array();
	   if(  $reciver_name!="")
	   {
			$condition['reciver_name']=$reciver_name;
		    $update=$model_order->editOrderCommon($condition,array('order_id'=>$order_id));  
		  		  		   
	   }else if($member_idcard!="")
	   {
		    $orderinfo = $model_order->getOrderInfo(array('order_id'=>$order_id), array('order_common'));		   
		    $reciver_info=$orderinfo['extend_order_common']['reciver_info'];
		    $reciver_info['member_idcard']=$member_idcard;
		    $condition['reciver_info']=serialize($reciver_info);
		    $update=$model_order->editOrderCommon($condition,array('order_id'=>$order_id));  
		    $model_order->editOrder(array('member_idcard'=>$member_idcard),array('order_id'=>$order_id));
	    }
		else if($member_address!="")
		{					  
		    $orderinfo = $model_order->getOrderInfo(array('order_id'=>$order_id), array('order_common'));		   
		    $reciver_info=$orderinfo['extend_order_common']['reciver_info'];
		    $reciver_info['address'] = $member_address;
            $arr = explode(" ",$member_address);
            $reciver_info['area'] = $arr[0]." ".$arr[1]." ".$arr[2];
		    $condition['reciver_info']=serialize($reciver_info);
		    $update=$model_order->editOrderCommon($condition,array('order_id'=>$order_id)); 
		}
		else if($member_phone!="")
		{				
			$orderinfo = $model_order->getOrderInfo(array('order_id'=>$order_id), array('order_common'));			 
			$reciver_info=$orderinfo['extend_order_common']['reciver_info'];
			$reciver_info['phone']=$member_phone;
			$condition['reciver_info']=serialize($reciver_info);
			$update=$model_order->editOrderCommon($condition,array('order_id'=>$order_id));		
		}		
	   if($update)
	   {  
       	   return "success";
	   }
	   else
	   {
		   return "error";		   
	   }

	
	}
    /**
     * 导出
     *
     */
    public function export_step1Op(){
        $lang   = Language::getLangContent();

        $model_order = Model('order');
        $condition  = array();
        if (preg_match('/^[\d,]+$/', $_GET['order_id'])) {
            $_GET['order_id'] = explode(',',trim($_GET['order_id'],','));
            $condition['order_id'] = array('in',$_GET['order_id']);
        }
        $this->_get_condition($condition);
        $sort_fields = array('buyer_name','store_name','order_id','payment_code','order_state','order_amount','order_from','pay_sn','rcb_amount','pd_amount','payment_time','finnshed_time','evaluation_state','refund_amount','buyer_id','store_id');
        if ($_POST['sortorder'] != '' && in_array($_POST['sortname'],$sort_fields)) {
            $order = $_POST['sortname'].' '.$_POST['sortorder'];
        } else {
            $order = 'order_id desc';
        }

        if (!is_numeric($_GET['curpage'])){
            $count = $model_order->getOrderCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?m=order&a=index');
                Tpl::showpage('export.excel');
            }else{  //如果数量小，直接下载
                $data = $model_order->getOrderList($condition,'','*',$order,self::EXPORT_SIZE);
                if($_GET['type'] == 1){
                    $this->createExcel1($data);
                }else{
                    $this->createExcel($data);
                }
                
            }
        }else{  //下载
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $model_order->getOrderList($condition,'','*',$order,"{$limit1},{$limit2}");
            if($_GET['type'] == 1){
                $this->createExcel1($data);
            }else{
                $this->createExcel($data);
            }
        }
    }

      /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()){
        $model_order = Model("order");
        $model_goods = Model("goods");
        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"通过时间");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"下单时间");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"发货时间");
        $excel_data[0][] = array('id'=>'s_title','data'=>'原始订单');
        $excel_data[0][] = array('id'=>'s_title','data'=>'订单ID');
        $excel_data[0][] = array('id'=>'s_title','data'=>'订单号');
        $excel_data[0][] = array('id'=>'s_title','data'=>'支付单号');
        $excel_data[0][] = array('id'=>'s_title','data'=>'订单来源');
        $excel_data[0][] = array('id'=>'s_title','data'=>'店铺');
        $excel_data[0][] = array('id'=>'s_title','data'=>'店铺ID');
        $excel_data[0][] = array('id'=>'s_title','data'=>"外部订单号");
        $excel_data[0][] = array('id'=>'s_title','data'=>"订单状态");
        $excel_data[0][] = array('id'=>'s_title','data'=>"用户名");
        $excel_data[0][] = array('id'=>'s_title','data'=>"身份证号");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"客户订单号");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"海关码");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"商品条码");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"编号");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"商品品名");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"销售数量");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"净重");
        $excel_data[0][] = array('id'=>'s_title','data'=>"商品价格");
        $excel_data[0][] = array('id'=>'s_title','data'=>"商品总价");
        $excel_data[0][] = array('id'=>'s_title','data'=>"商品税费");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"城市");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"地址");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"联系人");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"手机");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"运单号");
        $excel_data[0][] = array('styleid'=>'s_title','data'=>"备注");
        
        //data
        foreach ((array)$data as $k=>$order_info){
            $order_common_info=$model_order->getOrderCommonInfo(array('order_id'=>$order_info['order_id']));

            $order_info['state_desc'] = orderState($order_info);
            $list = array();
            $list['msg_time'] = $order_info['msg_time']>0?date('Y-m-d H:i:s',$order_info['msg_time']):"";
            $list['add_time'] = $order_info['add_time']>0?date('Y-m-d H:i:s',$order_info['add_time']):"";
            $list['shipping_time'] = $order_common_info['shipping_time']>0?date('Y-m-d H:i:s',$order_common_info['shipping_time']):"";
            $list['hg_order_sn'] = $order_info['hg_order_sn'];
            $list['order_id'] = $order_info['order_id'];
            $list['order_sn'] = $order_info['order_sn'];
            $list['pay_sn'] = empty($order_info['pay_sn']) ? '' : $order_info['pay_sn']; 
            $list['order_from'] = $order_info['order_from'];
            $list['store_name'] = $order_info['store_name'];
            $list['store_id'] = $order_info['store_id'];         
            $list['tao_sn'] = $order_info['tao_sn'];
            $list['order_state'] = $order_info['state_desc'];
            $list['buyer_name'] = $order_info['buyer_name'];
            $list['member_idcard'] = $order_info['member_idcard'];
            $list['order_sn'] = $order_info['order_sn'].str_replace(array(1,2,3), array(null,' [预定]','[门店自提]'), $order_info['order_type']);
            $list['code'] = $order_info['code'];
            
            $tmp = array();
            $tmp[] = array('data'=>$list['msg_time']);
            $tmp[] = array('data'=>$list['add_time']);
            $tmp[] = array('data'=>$list['shipping_time']);
            $tmp[] = array('data'=>$list['hg_order_sn']);
            $tmp[] = array('data'=>$list['order_id']);
            $tmp[] = array('data'=>$list['order_sn']);
            $tmp[] = array('data'=>$list['pay_sn']);
            $tmp[] = array('data'=>$list['order_from']);
            $tmp[] = array('data'=>$list['store_name']);
            $tmp[] = array('data'=>$list['store_id']);
            $tmp[] = array('data'=>$list['tao_sn']);
            $tmp[] = array('data'=>$list['order_state']);
            $tmp[] = array('data'=>$list['buyer_name']);
            $tmp[] = array('data'=>$list['member_idcard']);
            $tmp[] = array('data'=>$list['member_idcard']);
            $tmp[] = array('data'=>$list['code']);
            //取订单商品
            
            
            $order_common_info['reciver_info']=unserialize($order_common_info['reciver_info']);             
            $str=$order_common_info['reciver_info']['address'];
            $ctiys=preg_split("/[\s]+/",$str);
            $order_goods_list = $model_order->getOrderGoodsList(array('order_id'=>$order_info['order_id']));
            if(!empty($order_goods_list)){
                $i = 0 ;
                foreach ($order_goods_list as $goods_order){
                    $goods_info = $model_goods->getGoodsInfo(array('goods_id' => $goods_order['goods_id']));
                    if($i>0)
                    {
                        $tmp = array();                      
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");  
                        $tmp[] = array('data'=>"同上");
                        $tmp[] = array('data'=>"同上");
                        	
                    }                    
                    
                    $tmp[] = array('data'=>$goods_info['goods_serial']);
                    $tmp[] = array('data'=>$goods_info['goods_code']);
                    $tmp[] = array('data'=>$goods_order['goods_name']);
                    $tmp[] = array('data'=>$goods_order['goods_num']);
                    $tmp[] = array('data'=>"");
                    $tmp[] = array('data'=>$goods_order['goods_price']);
                    $tmp[] = array('data'=>$goods_order['goods_pay_price']);
                    $tmp[] = array('data'=>$goods_order['goods_tax']);
                    $tmp[] = array('data'=>$ctiys[0]!=""?$ctiys[0]:$ctiys[1]);
                    $tmp[] = array('data'=>preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$order_common_info['reciver_info']['address']));
                    $tmp[] = array('data'=>$order_common_info['reciver_name']);
                    $tmp[] = array('data'=>$order_common_info['reciver_info']['phone']);
                    $tmp[] = array('data'=>$order_info['shipping_code']);
                    $tmp[] = array('data'=>$order_info['order_remark']);
                    
                    $i++;
                    $excel_data[] = $tmp;
                    
                }
            }
           
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(L('exp_od_order'),CHARSET));
        $excel_obj->generateXML('order-'.$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel1($data = array()){
        $model_order = Model("order");
        $model_goods = Model("goods");
        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        
        $excel_data[0][] = array('id'=>'s_title','data'=>'商品总数');
        $excel_data[0][] = array('id'=>'s_title','data'=>'订单号');
        $excel_data[0][] = array('id'=>'s_title','data'=>'收货电话');
        $excel_data[0][] = array('id'=>'s_title','data'=>'收货地址');
        $excel_data[0][] = array('id'=>'s_title','data'=>'商品编号');
        $excel_data[0][] = array('id'=>'s_title','data'=>"顾客姓名");
        $excel_data[0][] = array('id'=>'s_title','data'=>"顾客身份证号");
        $excel_data[0][] = array('id'=>'s_title','data'=>"项号");

    
        //data
        foreach ((array)$data as $k=>$order_info){
           
    
            $order_common_info=$model_order->getOrderCommonInfo(array('order_id'=>$order_info['order_id']));
            $order_common_info['reciver_info']=unserialize($order_common_info['reciver_info']);
            $str=$order_common_info['reciver_info']['address'];
            $ctiys=preg_split("/[\s]+/",$str);
            $order_goods_list = $model_order->getOrderGoodsList(array('order_id'=>$order_info['order_id']));
            if(!empty($order_goods_list)){
                $i = 0 ;
                foreach ($order_goods_list as $goods_order){
                    $tmp = array();
                    $goods_info = $model_goods->getGoodsInfo(array('goods_id' => $goods_order['goods_id']));
                    $i++;
                    $tmp[] = array('data'=>$goods_order['goods_num']);
                    $tmp[] = array('data'=>$order_info['order_sn']);
                    $tmp[] = array('data'=>$order_common_info['reciver_info']['phone']);
                    $tmp[] = array('data'=>preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","，",$order_common_info['reciver_info']['address']));
                    $tmp[] = array('data'=>$goods_info['goods_serial']);
                    $tmp[] = array('data'=>$order_common_info['reciver_name']);
                    $tmp[] = array('data'=>$order_common_info['reciver_info']['member_idcard']);                    
                    $tmp[] = array('data'=>$i);
                   
    
                    $excel_data[] = $tmp;
    
                }
            }
             
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(L('exp_od_order'),CHARSET));
        $excel_obj->generateXML('order-'.$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }
    /**
     * 
     * 订单备注
     */
    public function add_order_remarkOp(){
        $model_order = Model("order");
        $order_id = $_GET['order_id'];
        
        if($_POST['form_submit']=="ok"){
            $order_id = $_POST['order_id'];
            $order_remark = $_POST['order_remark'];            
            $res = array();
            $update =  $model_order->editOrder(array('order_remark'=>$order_remark),array('order_id'=>$order_id));
            if($update){
                $res['status']=1;
                $res['msg']="操作成功";
            }else{
                $res['status']=0;
                $res['msg']="操作失败";
            }
            echo json_encode($res);
            exit();
        }else{
            
            $order_info = $model_order->getOrderInfo(array('order_id'=>$order_id));
            Tpl::output("order_info",$order_info);
            Tpl::setDirquna("shop");
            Tpl::showpage("order.remark");
        }
        
    }
    
    /**
     * 订单取消
     */
    public function order_cancelOp(){
        $model_order = Model("order");
        $order_id = $_GET['order_id'];
        if($_POST['form_submit']=="ok"){
            $order_id = $_POST['order_id'];
            $order_remark = $_POST['order_remark'];
            $res = array();
            //获取订单详细
            $condition = array();
            $condition['order_id'] = $order_id;
            $order_info = $model_order->getOrderInfo($condition);
            $logic_order = Logic('order');
            $result =  $logic_order->changeOrderStateCancel($order_info,'system', $this->admin_info['name']);       
            $order_remark=$_POST['order_remark'];       
            if($order_remark!="")
            {
                $update =  $model_order->editOrder(array('order_remark'=>$order_remark),array('order_id'=>$order_id));
            }
            if($result){
                $res['status']=1;
                $res['msg']="操作成功";
            }else{
                $res['status']=0;
                $res['msg']="操作失败";
            }
            echo json_encode($res);
            exit();
        }else{
        
            $order_info = $model_order->getOrderInfo(array('order_id'=>$order_id));
            Tpl::output("order_info",$order_info);
            Tpl::setDirquna("shop");
            Tpl::showpage("order.cancel");
        }
        
    }
    
    /**
     * 订单退款
     */
    public function order_refundOp(){
        $model_order = Model("order");
        $order_id = $_GET['order_id'];
        
        if($_POST['form_submit']=="ok"){
            $order_id = $_POST['order_id'];
            $order_remark = $_POST['order_remark'];
            $res = array();
            //获取订单详细
            $condition = array();
            $condition['order_id'] = $order_id;
            $order_info = $model_order->getOrderInfo($condition);
            $logic_order = Logic('order');
            $result =  $logic_order->changeOrderStateCancel($order_info,'system', $this->admin_info['name']);
            $model_order->editOrder(array('is_refund'=>1),array('order_id'=>$order_id));
            
            if($order_remark!="")
            {
                $update =  $model_order->editOrder(array('order_remark'=>$order_remark),array('order_id'=>$order_id));
            }
          
            if($result){
                $res['status']=1;
                $res['msg']="操作成功";
            }else{
                $res['status']=0;
                $res['msg']="操作失败";
            }
            echo json_encode($res);
            exit();
        }else{
        
            $order_info = $model_order->getOrderInfo(array('order_id'=>$order_id));
            Tpl::output("order_info",$order_info);
            Tpl::setDirquna("shop");
            Tpl::showpage("order.refund");
        }
        
    }
    
    /**
     * 恢复订单
     */
    public function order_recoverOp(){
        $model_order = Model("order");
        $order_id = $_POST['order_id'];
        $res = array();
        $result = $model_order->editOrder(array('is_refund'=>0,'order_state'=>20),array('order_id'=>$order_id));
        if($result){
            $res['status']=1;
            $res['msg']="操作成功";
        }else{
            $res['status']=0;
            $res['msg']="操作失败";
        }
        echo json_encode($res);
        exit();        
    }
    
    /**
     * 确认退款
     *
     */
    public function refundOp()
    {
        $res = array();
        $model_order = Model('order');
        $model_ci_contact = Model("ci_contact");
        $model_ci_order = Model("ci_order");
        $model_ci_order_info = Model("ci_order_info");
        $model_ci_invoice = Model("ci_invoice");
        $model_ci_invoice_info = Model("ci_invoice_info");
        $model_inventory_log = Model("inventory_log");
        $order_id = intval($_POST['order_id']);
        if($order_id <= 0){
            $res['status']=0;
            $res['msg']="参数有误";
            echo json_encode($res);
            exit();
        }    
        $update =  $model_order->editOrder(array('refund_state'=>1),array('order_id'=>$order_id));
   
        if($update)
        {
            $order_info = $model_order->getOrderInfo(array('order_id'=>$order_id), array("order_goods" ));
            //新增进销存用户
            //$ci_contact = $model_ci_contact->insertCiContact($order_info);
            //进销存退货单
            //$res = $model_ci_invoice->insertCiInvoice($order_info,'returned_order');
            $model_inventory_log ->insertInventoryLog($res,$order_info,'returned_sales_report');
            //插入退货单扩展
            //$model_ci_invoice_info->insertCiInvoiceInfo($res,'returned_order');
            
            $res['status']=1;
            $res['msg']="操作成功";
            echo json_encode($res);
            exit();
        }
        else
        {
            $res['status']=0;
            $res['msg']="操作失败";
            echo json_encode($res);
            exit();
        }
    }
    
     /**
     * 批量设置订单参数,如仓库 发货仓 快递 
     * 
     */
	public function set_optionOp(){
	    $model_order = Model("order");
	    if($_POST['form_submit']=='ok'){
	        $res = array();
	        $id = $_POST['id'];
	        $c_s_id = $_POST['c_s_id'];
	        $s_id = $_POST['s_id'];
	        $express_id = $_POST['express_id'];
	        $update = array();
	        $update_common = array();
	        if($c_s_id>0){
	        	if($c_s_id==6){
	        		$c_s_id = 1;
	        	}
	            $update['d_id'] = $c_s_id;
	        }
	        if($s_id>0){
	            $update['tao_state'] = $s_id;
	        }
	        if($express_id>0){
	            $update_common['shipping_express_id'] = $express_id;
	        }
	        if(empty($update) && empty($update_common)){
	            $res['status'] = 0;
	            $res['msg'] = "至少选择一个参数";
	            echo json_encode($res);
	            exit();
	        }	   
	        if(!empty($update)){
	            $result = $model_order->editOrder($update,array('order_id'=>array('in',$id)));
	        }     
	        if(!empty($update_common)){
	            //重置运单号为空
	            $model_order->editOrder(array('shipping_code'=>''),array('order_id'=>array('in',$id)));
	            $result1 = $model_order->editOrderCommon($update_common,array('order_id'=>array('in',$id)));
	        }
	        if($result || $result1){
	            $res['status'] = 1;
	            $res['msg'] = "操作成功";
	        }else{
	            $res['status'] = 0;
	            $res['msg'] = "操作失败";
	        }
	        echo json_encode($res);
	        exit();
	    }else{
	        $model_storage = Model("storage");
	        $model_ci_storage = Model("ci_storage");
	        $model_express = Model("express");
	        $express_list = $model_express->getExpressList();
	        $ci_storage_list = $model_ci_storage->getCiStroageList(array());
	        $storage_list = $model_storage->getStroageList(array());
	        Tpl::output("express_list",$express_list);
	        Tpl::output("ci_storage_list",$ci_storage_list);
	        Tpl::output("storage_list",$storage_list);
	        
	        Tpl::setDirquna("shop");
	        Tpl::showpage("order.setoption");
	    }
	}
	
	/**
	 * 设置快递
	 */
	public function kd_setOp(){
        $model_order = Model("order");
        $order_id = $_POST['order_id'];    
        if($_POST['form_submit']=="ok"){
            $data = array();
            $data['shipping_express_id'] = $_POST['express'];
            $condition = array();            
            $condition['order_id'] = $order_id;  
            $update = $model_order->editOrderCommon($data,$condition);
           
            $data = array();
            $data['shipping_code'] = $_POST['shipping_code'];
            $update = $model_order->editOrder($data,$condition);   
                	
            if (!$update) {
                $res['status']=0;
                $res['msg']="保存失败,请重试!";
                $model_order->rollback();
                echo json_encode($res);
                exit();
            }
           
            //$result = $logic_order->changeOrderSend($order_info,"admin");          
            $res['status']=1;
            $res['msg']="操作成功";
            $model_order->commit();
            echo json_encode($res);
            exit();
        }else{
            //快递企业
            $express_list = Model("express")->page(10000)->select();
            $order_info=Model('order')->getOrderInfo(array('order_id'=>$_GET['order_id']),array('order_common'));
            Tpl::output('storage_list', $storage_list);
            Tpl::output('express_list', $express_list);
            Tpl::output('order_id', $_GET['order_id']);
            Tpl::output('order_info', $order_info);
            Tpl::setDirquna("shop");
            Tpl::showpage("order.kd_set");
        }
	}
	
    /**
     * 处理搜索条件
     */
    private function _get_condition(& $condition) {
        if ($_REQUEST['query'] != '' && in_array($_REQUEST['qtype'],array('order_sn','store_name','buyer_name','pay_sn'))) {
            $condition[$_REQUEST['qtype']] = array('like',"%{$_REQUEST['query']}%");
        }
        if ($_GET['keyword'] != '' && in_array($_GET['keyword_type'],array('order_sn','store_name','buyer_name','pay_sn','shipping_code'))) {
            if ($_GET['jq_query']) {
                $condition[$_GET['keyword_type']] = $_GET['keyword'];
            } else {
                $condition[$_GET['keyword_type']] = array('like',"%{$_GET['keyword']}%");
            }
        }
        if (!in_array($_GET['qtype_time'],array('add_time','payment_time','finnshed_time'))) {
            $_GET['qtype_time'] = null;
        }
        //判断是否提交
        if($_GET['is_post']>0){
            if($_GET['is_post'] == 1){
                $condition['is_postkjyp'] = 0;
                $condition['is_postmessage'] = 0;
            }else if($_GET['is_post'] == 2){
                $condition['is_postkjyp|is_postmessage'] = 1;
            }          
            $condition['order_state'] = 20;
        }    
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_date']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_date']): null;
        if ($_GET['qtype_time'] && ($start_unixtime || $end_unixtime)) {
            $condition[$_GET['qtype_time']] = array('time',array($start_unixtime,$end_unixtime));
        }
        if($_GET['payment_code']) {
            if ($_GET['payment_code'] == 'wxpay') {
                $condition['payment_code'] = array('in',array('wxpay','wx_saoma','wx_jsapi'));
            } else {
                $condition['payment_code'] = $_GET['payment_code'];
            }
        }
        if(in_array($_GET['order_state'],array('0','10','20','30','40'))){
            $condition['order_state'] = $_GET['order_state'];
        }
        if (!in_array($_GET['query_amount'],array('order_amount','shipping_fee','refund_amount'))) {
            $_GET['query_amount'] = null;
        }
        if (floatval($_GET['query_start_amount']) > 0 && floatval($_GET['query_end_amount']) > 0 && $_GET['query_amount']) {
            $condition[$_GET['query_amount']] = array('between',floatval($_GET['query_start_amount']).','.floatval($_GET['query_end_amount']));
        }
        if(in_array($_GET['order_from'],array('1','2'))){
            $condition['order_from'] = $_GET['order_from'];
        }
    }

}
