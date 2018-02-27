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
			
            //推送淘宝仓  
            if($order_info['tao_status']){
                $list['is_posttao'] = "<font style='color:green'>是</font>";
            }else{
                $list['is_posttao'] = $order_info['tao_state']?"<a style='color:red' href='javascript:void(0)' onclick='pushTao({$order_info['order_id']});'>否</a>":"否"; 
            }     

			//推送关贸
           	if($order_info['is_postmessage']){
           		$list['is_postmessage'] = "<font style='color:green'>是</font>";
           	}else{
           		$list['is_postmessage'] = "<a style='color:red' href='javascript:void(0)' onclick='pushCustoms({$order_info['order_id']});'>否</a>"; 
           	}     
           	
           	//支付单
           	if($order_info['pay_status']){
           		//$list['pay_status'] = "<font style='color:green'>是</font>";
           	}else{
           		//$list['pay_status'] = "<a style='color:red' href='javascript:void(0)' onclick='pushPay({$order_info['order_id']});'>否</a>"; 
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
        if($order_id 