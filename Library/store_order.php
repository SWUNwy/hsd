<?php
/**
 * 卖家实物订单管理
 *
 *
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */



defined('ByShopKJYP') or exit('Access Invalid!');
class store_orderControl extends BaseSellerControl {
    const EXPORT_SIZE = 900;
    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }

    /**
     * 订单列表
     *
     */
    public function indexOp() {
        $model_order = Model('order');
        if (!$_GET['state_type']) {
            $_GET['state_type'] = 'store_order';
        }
        $order_list = $model_order->getStoreOrderList($_SESSION['store_id'], $_GET['order_sn'],$_GET['external_order'], $_GET['buyer_name'], $_GET['state_type'], $_GET['query_start_date'], $_GET['query_end_date'], $_GET['skip_off'], '*', array('order_goods','order_common','member'));
        //print_r($order_list);
        Tpl::output('order_list',$order_list);
        Tpl::output('show_page',$model_order->showpage());
        self::profile_menu('list',$_GET['state_type']);

        Tpl::showpage('store_order.index');
    }

    /**
     * 卖家订单详情
     *
     */
    public function show_orderOp() {
        Language::read('member_member_index');
        $order_id = intval($_GET['order_id']);
        if ($order_id <= 0) {
            showMessage(Language::get('wrong_argument'),'','html','error');
        }
        $model_order = Model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = $_SESSION['store_id'];
        $order_info = $model_order->getOrderInfo($condition,array('order_common','order_goods','member'));
        if (empty($order_info)) {
            showMessage(Language::get('store_order_none_exist'),'','html','error');
        }

        //取得订单其它扩展信息
        $model_order->getOrderExtendInfo($order_info);

        $model_refund_return = Model('refund_return');
        $order_list = array();
        $order_list[$order_id] = $order_info;
        $order_list = $model_refund_return->getGoodsRefundList($order_list,1);//订单商品的退款退货显示
        $order_info = $order_list[$order_id];
        $refund_all = $order_info['refund_list'][0];
        if (!empty($refund_all) && $refund_all['seller_state'] < 3) {//订单全部退款商家审核状态:1为待审核,2为同意,3为不同意
            Tpl::output('refund_all',$refund_all);
        }

        //显示锁定中
        $order_info['if_lock'] = $model_order->getOrderOperateState('lock',$order_info);

        //显示调整费用
        $order_info['if_modify_price'] = $model_order->getOrderOperateState('modify_price',$order_info);

        //显示取消订单
        $order_info['if_store_cancel'] = $model_order->getOrderOperateState('store_cancel',$order_info);

        //显示发货
        $order_info['if_store_send'] = $model_order->getOrderOperateState('store_send',$order_info);

        //显示物流跟踪
        $order_info['if_deliver'] = $model_order->getOrderOperateState('deliver',$order_info);

        //显示系统自动取消订单日期
        if ($order_info['order_state'] == ORDER_STATE_NEW) {
            $order_info['order_cancel_day'] = $order_info['add_time'] + ORDER_AUTO_CANCEL_TIME * 3600;
        }

        //显示快递信息
        if ($order_info['shipping_code'] != '') {
            $express = rkcache('express',true);
            $order_info['express_info']['e_code'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_code'];
            $order_info['express_info']['e_name'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_name'];
            $order_info['express_info']['e_url'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_url'];
        }

        //显示系统自动收获时间
        if ($order_info['order_state'] == ORDER_STATE_SEND) {
            $order_info['order_confirm_day'] = $order_info['delay_time'] + ORDER_AUTO_RECEIVE_DAY * 24 * 3600;
        }

        //取得订单操作日志
        $order_log_list = $model_order->getOrderLogList(array('order_id'=>$order_info['order_id']),'log_id asc');
        Tpl::output('order_log_list',$order_log_list);

        //如果订单已取消，取得取消原因、时间，操作人
        if ($order_info['order_state'] == ORDER_STATE_CANCEL) {
            $last_log = end($order_log_list);
            if ($last_log['log_orderstate'] == ORDER_STATE_CANCEL) {
                $order_info['close_info'] = $last_log;
            }
        }
        //查询消费者保障服务
        if (C('contract_allow') == 1) {
            $contract_item = Model('contract')->getContractItemByCache();
        }
        foreach ($order_info['extend_order_goods'] as $value) {
            $value['image_60_url'] = cthumb($value['goods_image'], 60, $value['store_id']);
            $value['image_240_url'] = cthumb($value['goods_image'], 240, $value['store_id']);
            $value['goods_type_cn'] = orderGoodsType($value['goods_type']);
            $value['goods_url'] = urlShop('goods','index',array('goods_id'=>$value['goods_id']));
            //处理消费者保障服务
            if (trim($value['goods_contractid']) && $contract_item) {
                $goods_contractid_arr = explode(',',$value['goods_contractid']);
                foreach ((array)$goods_contractid_arr as $gcti_v) {
                    $value['contractlist'][] = $contract_item[$gcti_v];
                }
            }
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

        Tpl::output('order_info',$order_info);

        //发货信息
        if (!empty($order_info['extend_order_common']['daddress_id'])) {
            $daddress_info = Model('daddress')->getAddressInfo(array('address_id'=>$order_info['extend_order_common']['daddress_id']));
            Tpl::output('daddress_info',$daddress_info);
        }

        Tpl::showpage('store_order.show');
    }

    /**
     * 卖家订单状态操作
     *
     */
    public function change_stateOp() {
        $state_type = $_GET['state_type'];
        $order_id   = intval($_GET['order_id']);

        $model_order = Model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = $_SESSION['store_id'];
        $order_info = $model_order->getOrderInfo($condition);

        //取得其它订单类型的信息
        $model_order->getOrderExtendInfo($order_info);

        if ($_GET['state_type'] == 'order_cancel') {
            $result = $this->_order_cancel($order_info,$_POST);
        } elseif ($_GET['state_type'] == 'modify_price') {
            $result = $this->_order_ship_price($order_info,$_POST);
        } elseif ($_GET['state_type'] == 'spay_price') {
			$result = $this->_order_spay_price($order_info,$_POST);
    		}
	
        if (!$result['state']) {
            showDialog($result['msg'],'','error',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();',5);
        } else {
            showDialog($result['msg'],'reload','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
        }
    }


    /**
     * 取消订单
     * @param unknown $order_info
     */
    private function _order_cancel($order_info, $post) {
        $model_order = Model('order');
        $logic_order = Logic('order');
        if(!chksubmit()) {
            Tpl::output('order_info',$order_info);
            Tpl::output('order_id',$order_info['order_id']);
            Tpl::showpage('store_order.cancel','null_layout');
            exit();
         } else {
             $if_allow = $model_order->getOrderOperateState('store_cancel',$order_info);
             if (!$if_allow) {
                 return callback(false,'无权操作');
             }
             if (TIMESTAMP - 86400 < $order_info['api_pay_time']) {
                 $_hour = ceil(($order_info['api_pay_time']+86400-TIMESTAMP)/3600);
                 return callback(false,'该订单曾尝试使用第三方支付平台支付，须在'.$_hour.'小时以后才可取消');

             }
             $msg = $post['state_info1'] != '' ? $post['state_info1'] : $post['state_info'];
             if ($order_info['order_type'] == 2) {
                 //预定订单
                 return Logic('order_book')->changeOrderStateCancel($order_info,'seller',$_SESSION['seller_name'], $msg);
             } else {
                 $cancel_condition = array();
                 if ($order_info['payment_code'] != 'offline') {
                     $cancel_condition['order_state'] = ORDER_STATE_NEW;
                 }
                 return $logic_order->changeOrderStateCancel($order_info,'seller',$_SESSION['seller_name'], $msg,true,$cancel_condition);
             }
         }
    }

    /**
     * 修改运费
     * @param unknown $order_info
     */
    private function _order_ship_price($order_info, $post) {
        $model_order = Model('order');
        $logic_order = Logic('order');
        if(!chksubmit()) {
            Tpl::output('order_info',$order_info);
            Tpl::output('order_id',$order_info['order_id']);
            Tpl::showpage('store_order.edit_price','null_layout');
            exit();
        } else {
            $if_allow = $model_order->getOrderOperateState('modify_price',$order_info);
            if (!$if_allow) {
                return callback(false,'无权操作');
            }
            return $logic_order->changeOrderShipPrice($order_info,'seller',$_SESSION['seller_name'],$post['shipping_fee']);
        }

    }
	/**
	 * 修改商品价格
	 * @param unknown $order_info
	 */
	private function _order_spay_price($order_info, $post) {
        $model_order = Model('order');
	    $logic_order = Logic('order');
	    if(!chksubmit()) {
	        Tpl::output('order_info',$order_info);
	        Tpl::output('order_id',$order_info['order_id']);
            Tpl::showpage('store_order.edit_spay_price','null_layout');
            exit();
        } else {
            $if_allow = $model_order->getOrderOperateState('spay_price',$order_info);
            if (!$if_allow) {
                return callback(false,'无权操作');
            }
            return $logic_order->changeOrderSpayPrice($order_info,'seller',$_SESSION['member_name'],$post['goods_amount']); 
	    }
	}

    /**
     * 打印发货单
     */
    public function order_printOp() {
        Language::read('member_printorder');

        $order_id   = intval($_GET['order_id']);
        if ($order_id <= 0){
            showMessage(Language::get('wrong_argument'),'','html','error');
        }
        $order_model = Model('order');
        $condition['order_id'] = $order_id;
        $condition['store_id'] = $_SESSION['store_id'];
        $order_info = $order_model->getOrderInfo($condition,array('order_common','order_goods'));
        if (empty($order_info)){
            showMessage(Language::get('member_printorder_ordererror'),'','html','error');
        }
        Tpl::output('order_info',$order_info);

        //卖家信息
        $model_store    = Model('store');
        $store_info     = $model_store->getStoreInfoByID($order_info['store_id']);
        if (!empty($store_info['store_label'])){
            if (file_exists(BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_info['store_label'])){
                $store_info['store_label'] = UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$store_info['store_label'];
            }else {
                $store_info['store_label'] = '';
            }
        }
        if (!empty($store_info['store_stamp'])){
            if (file_exists(BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_info['store_stamp'])){
                $store_info['store_stamp'] = UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$store_info['store_stamp'];
            }else {
                $store_info['store_stamp'] = '';
            }
        }
        Tpl::output('store_info',$store_info);

        //订单商品
        $model_order = Model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = $_SESSION['store_id'];
        $goods_new_list = array();
        $goods_all_num = 0;
        $goods_total_price = 0;
        if (!empty($order_info['extend_order_goods'])){
            $goods_count = count($order_goods_list);
            $i = 1;
            foreach ($order_info['extend_order_goods'] as $k => $v){
                $v['goods_name'] = str_cut($v['goods_name'],100);
                $goods_all_num += $v['goods_num'];
                $v['goods_all_price'] = ncPriceFormat($v['goods_num'] * $v['goods_price']);
                $goods_total_price += $v['goods_all_price'];
                $goods_new_list[ceil($i/4)][$i] = $v;
                $i++;
            }
        }
        //优惠金额
        $promotion_amount = $goods_total_price - $order_info['goods_amount'];
        //运费
        $order_info['shipping_fee'] = $order_info['shipping_fee'];
        Tpl::output('promotion_amount',$promotion_amount);
        Tpl::output('goods_all_num',$goods_all_num);
        Tpl::output('goods_total_price',ncPriceFormat($goods_total_price));
        Tpl::output('goods_list',$goods_new_list);
        Tpl::showpage('store_order.print',"null_layout");
    }

    //导入excel数据
    public function order_import_saveOp(){

        Language::read('export');
        import('libraries.reader');
        $result = array();
        $file= $_FILES['fileupload'];
        if(empty($file['name'])){    
            $result['success'] = false;
            $result['message'] = "文件不能为空！";
            echo json_encode($result);
            exit();
        }
        /**
         * 文件来源判定
         */
        if(!is_uploaded_file($file['tmp_name'])){            
            $result['success'] = false;
            $result['message'] = "上传文件失败!";
            echo json_encode($result);
            exit();
        }
        /**
         * 文件类型判定
         */
        $file_name_array    = explode('.',$file['name']);
        if($file_name_array[count($file_name_array)-1] != 'xls'){           
            $result['success'] = false;
            $result['message'] = "只能上传扩散名为.xls的文件!";
            echo json_encode($result);
            exit();
        }
        /**
         * 文件大小判定
         */
        if($file['size'] > intval(ini_get('upload_max_filesize'))*1024*1024){        
            $result['success'] = false;
            $result['message'] = "上传文件过大!";
            echo json_encode($result);
            exit();
        }

        $data = new Spreadsheet_Excel_Reader();
        //设置文本输出编码
        $data->setOutputEncoding('UTF-8');
        //读取Excel文件
        $data->read($file['tmp_name']);
        $data->dump(true,true);        
        $upexcel=$data->sheets;        
        $arr=$upexcel[0]['cells'];
        unset($arr[1]);

        if(count($arr)<=0){
            $result['success'] = false;
            $result['message'] = "excel文件无任何记录!";
            echo json_encode($result);
            exit();
        }
        $data = $this->data_format($arr);
        $res = $this->excel_save($data);       
        echo $res;
    }

    public function testOp()
    {
      
        $str = 'a:6:{s:5:"phone";s:23:"13648363357,13648363357";s:9:"mob_phone";s:11:"13648363357";s:9:"tel_phone";s:11:"13648363357";s:7:"address";s:36:"天津 天津市 和平区 sdfadfsaf";s:4:"area";s:26:"天津 天津市 和平区";s:6:"street";s:9:"sdfadfsaf";}';
        $arr =  unserialize($str);  
        print_r($arr); 

    }
    /**
     * 处理订单保存
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function excel_save($data){        
        $logic_buy_1 = Logic('buy_1');
        $model_order = Model('order');
        $model_goods = Model('goods');
        $member_id = $_SESSION['member_id'];
        $store_id = $_SESSION['store_id'];
        $successCount = 0;
        $failCount = 0;
        $fail_arr = array();    
        $result = array();   
        foreach ($data as $key => $value) {
            $external_order = $value['external_order'];           
            //判断身份证和姓名是否符合           
            if(preg_match("[^\x80-\xff]",trim($value['reciver_name'])) || strlen(trim($value['member_idcard']))!=18)
            {
                $value['error'] = '姓名或身份证有误';
                $fail_arr[]= $value;
                $failCount++;
                continue;
            }
            //判断是否有重否的订单号
            $order_info = $model_order->getOrderInfo(array('external_order'=>$external_order,'store_id'=>$store_id));
            if(!empty($order_info)){
              $value['error'] = '外部订单号已存在';
              $fail_arr[]= $value;
              $failCount++;
              continue;
            }
            //开始事务
            Model()->beginTransaction();
            $pay_sn = $logic_buy_1->makePaySn($member_id);
            $order_pay = array();
            $order_pay['pay_sn'] = $pay_sn;
            $order_pay['buyer_id'] = $member_id;
            $order_pay_id = $model_order->addOrderPay($order_pay);           
            if (!$order_pay_id) {                
                $value['error'] = '订单保存失败[未生成支付单]';
                $fail_arr[]= $value;
                $failCount++;
                continue;
            }

            $order = array();
            $order_common = array();
            $order_goods = array();
            $order['order_sn'] = $logic_buy_1->makeOrderSn($order_pay_id);
            $order['external_order'] = $external_order;
            $order['pay_sn'] = $pay_sn;
            $order['store_id'] = $_SESSION['store_id'];
            $order['store_name'] = $_SESSION['store_name'];
            $order['buyer_id'] = $_SESSION['member_id'];
            $order['buyer_name'] = $value['phone'];
            $order['buyer_email'] = $member_email;
            $order['buyer_phone'] = $value['phone'];
            $order['add_time'] = TIMESTAMP;
            $order['payment_code'] = "online";
            $order['order_state'] = "10";
            $order['order_amount'] = $value['allprice'];
            $order['shipping_fee'] = 0;
            $order['goods_amount'] = $value['allprice'];
            $order['order_from'] = 2;
            $order['member_idcard'] = $value['member_idcard'];
            $order_id = $model_order->addOrder($order);
            if (!$order_id) {                
                $value['error'] = '订单保存失败[未生成订单数据]';
                $fail_arr[]= $value;
                $failCount++;  
                Model()->rollback();//回滚事务               
                continue;
            }
            $order['order_id'] = $order_id;
            $order_list[$order_id] = $order;
            $address_arr = $addressarr = explode("，", $value['address']);
            $reciver_info = array();
            $reciver_info['phone'] = $value['phone'];
            $reciver_info['mob_phone'] = $value['phone'];
            $reciver_info['tel_phone'] = $value['phone'];
            $reciver_info['address'] = $address_arr[0]." ".$address_arr[1]." ".$address_arr[2]." ".$address_arr[3] ;
            $reciver_info['area'] =  $address_arr[0]." ".$address_arr[1]." ".$address_arr[2];
            $reciver_info['street'] = $address_arr[3] ;
            $reciver_info['member_idcard'] = $value['member_idcard'] ;

            $order_common['order_id'] = $order_id;
            $order_common['store_id'] = $store_id;
            $order_common['order_message'] = "";
            $order_common['reciver_info']= serialize($reciver_info);
            $order_common['reciver_name'] =$value['reciver_name'];
            $order_common['shipping_express_id'] = 0;
            $order_common['reciver_province_id'] = 0;      
            $order_id = $model_order->addOrderCommon($order_common);
            if (!$order_id) {
                $value['error'] = '订单保存失败';
                $fail_arr[]= $value;
                $failCount++;  
                Model()->rollback();//回滚事务               
                continue;               
            }
            $i = 0;
            $flag = ture;
            $goods_buy_quantity = array();
            foreach ($value['extends_goods'] as $key => $goods) {
                $goods_info = $model_goods->getGoodsInfo(array('goods_serial'=>$goods["goods_serial"]));
                if(empty($goods_info)){
                    $value['error'] = '没有找到相关商品';
                    $fail_arr[]= $value;
                    $failCount++;  
                    Model()->rollback();//回滚事务 
                    $flag = false;
                    break ;
                }
                if($goods_info['goods_state']!=1){
                    $value['error'] = '商品已下架';
                    $fail_arr[]= $value;
                    $failCount++;  
                    Model()->rollback();//回滚事务 
                    $flag = false;
                    break ;
                }
                if($goods['goods_num']>$goods_info['goods_storage']){
                    $value['error'] = '商品库存不足';
                    $fail_arr[]= $value;
                    $failCount++;  
                    Model()->rollback();//回滚事务 
                    $flag = false;
                    break ;
                }
                $order_goods[$i]['order_id'] = $order_id;
                $order_goods[$i]['goods_id'] = $goods_info['goods_id'];
                $order_goods[$i]['store_id'] = $store_id;
                $order_goods[$i]['goods_name'] = $goods_info['goods_name'];
                $order_goods[$i]['goods_price'] = $goods_info['goods_price'];
                $order_goods[$i]['goods_num'] = $goods['goods_num'];
                $order_goods[$i]['goods_image'] = $goods_info['goods_image'];
                $order_goods[$i]['goods_spec'] = $goods_info['goods_spec'];          
                $order_goods[$i]['buyer_id'] = $member_id;
                $order_goods[$i]['commis_rate'] = 200;
                $order_goods[$i]['invite_rates'] =0;
                $order_goods[$i]['gc_id'] = $goods_info['gc_id'];
                $goods_buy_quantity[$goods_info['goods_id']] = $goods['goods_num'];
                //计算商品金额
                $goods_total = $goods_info['goods_price'] * $goods['goods_num'];      
                $order_goods[$i]['goods_pay_price'] = $goods_total;
                $i++;
            }
            if(!$flag){
               continue;
            }

            $insert = $model_order->addOrderGoods($order_goods);               
            if (!insert) {               
                $value['error'] = '订单保存失败';
                $fail_arr[]= $value;
                $failCount++;  
                Model()->rollback();//回滚事务               
                continue;          
            }
            //减库存
            $result = Logic('queue')->createOrderUpdateStorage($goods_buy_quantity);
            if (!$result['state']) {
                $value['error'] = '订单保存失败[变更库存销量失败]';
                $fail_arr[]= $value;
                $failCount++;  
                Model()->rollback();//回滚事务               
                continue;   
            }

            //如果执行没问题
            $successCount++;
            Model()->commit();
            

        }

        $result['failCount'] = $failCount;
        if($failCount>0)
        {
            //print_r($fail_arr);
            $this->import_error($fail_arr);
            $filename=substr(md5($_SESSION['store_name']),8,16); // 16位MD5加密 ;
            $result['downUrl'] = "/download/".$filename.".xls";
        }
        $result['success'] = true;
        $result['successCount'] = $successCount;
        return json_encode($result);

    }

    /**
     * 格式化数组 判断里面是否有混单
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function data_format($data)
    {
        $model_goods = Model("goods");
        $result = array();
        $i = 0;
        $j = 0;
        $extends_goods = array();
        $allprice = 0;
        foreach ($data as $key => & $value) {
            $value[1]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[1]);   //商品总数
            $value[2]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[2]);   //订单号       
            $value[3]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[3]);   //收货电话
            $value[4]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[4]);   //收货地址
            $value[5]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[5]);   //商品编号
            $value[6]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[6]);   //顾客姓名
            $value[7]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[7]);   //顾客身份证号
            $value[8]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[8]);   //项号           
            $goods_info = $model_goods->getGoodsInfo(array('goods_serial'=>$value[5]));
            $extends_goods[$j]['goods_serial'] = $data[$key][5];
            $extends_goods[$j]['goods_num'] = $data[$key][1]; 
            $allprice = $allprice +  $data[$key][1]*$goods_info['goods_price']; //价格
            if($data[$key+1][8]>1){                 
                $j++;      
                continue;                
            }else {
                $result[$i]['external_order'] =  $value[2];            
                $result[$i]['phone'] = $value[3];
                $result[$i]['address'] =  str_replace ( "," ,"，" ,$value[4]);                 
                $result[$i]['reciver_name'] = $value[6]; 
                $result[$i]['member_idcard'] = $value[7]; 
                $result[$i]['allprice'] = $allprice;
                $result[$i]['goods_serial'] = $value[5];
                $result[$i]['goods_num'] = $value[1];
                $allprice = 0;
                $j = 0;                
            }
            $result[$i]['extends_goods'] = $extends_goods;
            $extends_goods = array(); 
            $i++;                             
        }
        return $result;
    }

    private function import_error($data){
        Language::read('export');
        import('libraries.excel');     
        $excel_obj = new Excel();
        $excel_data = array();
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //headercolor'=>'#FF0000',
        $excel_data[0][] = array('id'=>'s_title','data'=>"商品总数"); 
        $excel_data[0][] = array('id'=>'s_title','data'=>'订单号');
        $excel_data[0][] = array('id'=>'s_title','data'=>'收货电话');
        $excel_data[0][] = array('id'=>'s_title','data'=>"收货地址");
        $excel_data[0][] = array('id'=>'s_title','data'=>"商品编号");
        $excel_data[0][] = array('id'=>'s_title','data'=>"顾客姓名");
        $excel_data[0][] = array('id'=>'s_title','data'=>"顾客身份证号");
        $excel_data[0][] = array('id'=>'s_title','data'=>"失败原因");
        foreach ($data as $key => $value) {            
            $tmp = array();
            $tmp[] = array('data'=>$value['goods_num']);
            $tmp[] = array('data'=>$value['external_order']);
            $tmp[] = array('data'=>$value['phone']);
            $tmp[] = array('data'=>$value['address']);
            $tmp[] = array('data'=>$value['goods_serial']);
            $tmp[] = array('data'=>$value['reciver_name']);
            $tmp[] = array('data'=>$value['member_idcard']);
            $tmp[] = array('data'=>$value['error']);
            $excel_data[] = $tmp;
        }        

        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset("错误订单",CHARSET));
        ob_start();
        $excel_obj->generateXML($excel_obj->charset("1",CHARSET));
        $s = ob_get_flush();
        $filename=substr(md5($_SESSION['store_name']),8,16); // 16位MD5加密 ;
        file_put_contents("download/".$filename.".xls", $s);
        ob_clean();
       

    }
    /**
     * 取物流信息
     * @return [type] [description]
     */
    public function get_expressOp(){
        header('Content-type:text/json');  
        $type=$_GET['type'];
        $postid=$_GET['postid'];
        $EBusinessID="1255520";
        $AppKey="a6537619-b9a6-4e58-8014-ec32898c794c";
        $ReqURL="http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx";
        $requestData= "{'OrderCode':'','ShipperCode':'".$type."','LogisticCode':'".$postid."'}";         
        $datas = array(
                'EBusinessID' => $EBusinessID,
                'RequestType' => '1002',
                'RequestData' => urlencode($requestData) ,
                'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, $AppKey);
        $result= $this->sendPost($ReqURL, $datas);
        //print_r($result);
        
        $content = json_decode($result,true);
        if (!$content['Success']) exit(json_encode(false));
        $content['data'] = array_reverse($content['Traces']);
        $content['data']=$this->array_sort($content['data'],"AcceptTime","ASC");
        echo json_encode($content);
    }

    private function array_sort($array_name,$row_id,$order_type){
        $array_temp=array();
        foreach($array_name as $key=>$value){//循环一层；
            $array_temp[$key]=$value[$row_id];//新建一个一维的数组，索引值用二维数组的索引值；值为二维数组要比较的项目的值；
        }
        if($order_type==="ASC"){
            asort($array_temp);
        }else{
            arsort($array_temp);
        }
        $result_array=array();
        foreach($array_temp as $key=>$value){//对进行筛选过的数组遍历；
            $result_array[]=$array_name[$key];//新建一个结果数组，将原来传入的数组改变键值顺序后赋值给结果数组（原来数组不变）；
        }
        return $result_array;
    }
    /**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return url响应返回的html
     */
    private function sendPost($url, $datas) {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], 80);
        fwrite($fd, $httpheader);
    
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);
        return $gets;
    }

     /**
     * 导出
     *
     */
    public function export_step1Op(){
        $lang   = Language::getLangContent();

        $model_order = Model('order');
        $condition  = array();
        $condition['store_id'] = $_SESSION['store_id'];
       
        if($_GET['buyer_name']!=""){            
           $condition["buyer_name"] = array('like',"%{$_GET['buyer_name']}%");
        }
        if($_GET['order_sn']!=""){
            $condition["order_sn"] =  $_GET['order_sn'];
        }

        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_date']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_date']): null;
        if (($start_unixtime || $end_unixtime)) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }

        $order = "order_id desc";
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
                Tpl::output('murl','index.php?m=store_order&a=index');
                Tpl::showpage('export.excel');
            }else{  //如果数量小，直接下载
                $data = $model_order->getOrderList($condition,'','*',$order,self::EXPORT_SIZE);                      
                $this->createExcel($data);
            }
        }else{  //下载
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $model_order->getOrderList($condition,'','*',$order,"{$limit1},{$limit2}");
            $this->createExcel($data);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()){
        Language::read('export');
        $model_order = Model("order");
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单编号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'扩展编号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单来源');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单金额(元)');  
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单状态');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付方式');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付时间');        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'发货物流单号');  
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单完成时间');        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺名称');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'关贸回执状态');
        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品名');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品数量');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收件人');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收件人电话');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收件人地址');
   
        //data
        foreach ((array)$data as $k=>$order_info){
            $order_info['state_desc'] = orderState($order_info);
            $list = array();
            $list['order_sn'] = $order_info['order_sn'].str_replace(array(1,2,3), array(null,' [预定]','[门店自提]'), $order_info['order_type']);
            $list['external_order'] = $order_info['external_order'];
            $list['order_from'] = str_replace(array(1,2), array('PC端','订单导入'),$order_info['order_from']);
            $list['add_time'] = date('Y-m-d H:i:s',$order_info['add_time']);
            $list['order_amount'] = ncPriceFormat($order_info['order_amount']);
            if ($order_info['shipping_fee']) {
                $list['order_amount'] .= '(含运费'.ncPriceFormat($order_info['shipping_fee']).')';
            }
            $list['order_state'] = $order_info['state_desc'];
            $list['pay_sn'] = empty($order_info['pay_sn']) ? '' : $order_info['pay_sn'];
            $list['payment_code'] = orderPaymentName($order_info['payment_code']);
            $list['payment_time'] = !empty($order_info['payment_time']) ? (intval(date('His',$order_info['payment_time'])) ? date('Y-m-d H:i:s',$order_info['payment_time']) : date('Y-m-d',$order_info['payment_time'])) : '';
  
            $list['shipping_code'] = $order_info['shipping_code'];            
            $list['finnshed_time'] = !empty($order_info['finnshed_time']) ? date('Y-m-d H:i:s',$order_info['finnshed_time']) : '';
            
            $list['store_id'] = $order_info['store_id'];
            $list['store_name'] = $order_info['store_name'];
            $list['messagememo'] = $order_info['messagememo'];
           

            $tmp = array();
            $tmp[] = array('data'=>$list['order_sn']);
            $tmp[] = array('data'=>$list['external_order']);
            $tmp[] = array('data'=>$list['order_from']);
            $tmp[] = array('data'=>$list['add_time']);
            $tmp[] = array('data'=>$list['order_amount']);            
            $tmp[] = array('data'=>$list['order_state']);
            $tmp[] = array('data'=>$list['pay_sn']);
            $tmp[] = array('data'=>$list['payment_code']);
            $tmp[] = array('data'=>$list['payment_time']);     
            $tmp[] = array('data'=>$list['shipping_code']);          
            $tmp[] = array('data'=>$list['finnshed_time']);          
            $tmp[] = array('data'=>$list['store_id']);
            $tmp[] = array('data'=>$list['store_name']);
            $tmp[] = array('data'=>$list['messagememo']);
            
            
            
            $order_common_info=$model_order->getOrderCommonInfo(array('order_id'=>$order_info['order_id']));
            $order_common_info['reciver_info']=unserialize($order_common_info['reciver_info']);             
            $str=$order_common_info['reciver_info']['address'];
            $ctiys=preg_split("/[\s]+/",$str);
            $order_goods_list = $model_order->getOrderGoodsList(array('order_id'=>$order_info['order_id']));
            if(!empty($order_goods_list)){
                $i = 0 ;
                foreach ($order_goods_list as $goods_order){
                   
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
                        
                    }                    
                    
                  
           
                    $tmp[] = array('data'=>$goods_order['goods_name']);
                    $tmp[] = array('data'=>$goods_order['goods_num']);
                    $tmp[] = array('data'=>$order_common_info['reciver_name']);
                    $tmp[] = array('data'=>$order_common_info['reciver_info']['phone']);
                    $tmp[] = array('data'=>$str);
                   
                    $i++;
                    $excel_data[] = $tmp;
                    
                }
            }
           
        }
       

        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset("订单",CHARSET));
        $excel_obj->generateXML('order-'.$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }

    /**
     * 处理搜索条件
     */
    private function _get_condition(& $condition) {
        die();
        if ($_REQUEST['query'] != '' && in_array($_REQUEST['qtype'],array('order_sn','store_name','buyer_name','pay_sn','shipping_code'))) {
            $condition[$_REQUEST['qtype']] = array('like',"%{$_REQUEST['query']}%");
        }
        if ($_GET['keyword'] != '' && in_array($_GET['keyword_type'],array('order_sn','store_name','buyer_name','pay_sn','shipping_code'))) {
            if ($_GET['jq_query']) {
                $condition[$_GET['keyword_type']] = $_GET['keyword'];
            } else {
                $condition[$_GET['keyword_type']] = array('like',"%{$_GET['keyword']}%");
            }
        }
        if($_GET['shipping_code']) {
            echo $condition["shipping_code"] = $_GET['shipping_code'];    
            die();
        }
        if (!in_array($_GET['qtype_time'],array('add_time','payment_time','finnshed_time'))) {
            $_GET['qtype_time'] = null;
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

    /**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
    private function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_type='',$menu_key='') {
        Language::read('member_layout');
        switch ($menu_type) {
            case 'list':
            $menu_array = array(
            array('menu_key'=>'store_order',        'menu_name'=>Language::get('nc_member_path_all_order'), 'menu_url'=>'index.php?m=store_order'),
            array('menu_key'=>'state_new',          'menu_name'=>Language::get('nc_member_path_wait_pay'),  'menu_url'=>'index.php?m=store_order&a=index&state_type=state_new'),
            array('menu_key'=>'state_pay',          'menu_name'=>Language::get('nc_member_path_wait_send'), 'menu_url'=>'index.php?m=store_order&a=store_order&state_type=state_pay'),
            array('menu_key'=>'state_notakes',      'menu_name'=>'待自提', 'menu_url'=>'index.php?m=store_order&a=store_order&state_type=state_notakes'),
            array('menu_key'=>'state_send',         'menu_name'=>Language::get('nc_member_path_sent'),      'menu_url'=>'index.php?m=store_order&a=index&state_type=state_send'),
            array('menu_key'=>'state_success',      'menu_name'=>Language::get('nc_member_path_finished'),  'menu_url'=>'index.php?m=store_order&a=index&state_type=state_success'),
            array('menu_key'=>'state_cancel',       'menu_name'=>Language::get('nc_member_path_canceled'),  'menu_url'=>'index.php?m=store_order&a=index&state_type=state_cancel'),
            );
            break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}