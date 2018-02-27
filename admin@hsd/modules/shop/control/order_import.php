<?php
/**
 * 订单导入
 *
 * @copyright  Copyright (c) 2007-2013 
 * @since      File available since Release v1.1
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class order_importControl extends SystemControl {
	public function __construct() {
        $this->ispermission = 1;
		parent::__construct();	   
	}

    public function indexOp(){
        echo "index";
    }

    //导入excel数据
    public function order_import_saveOp(){

        $store_id = intval($_POST['store_id']);
		$_SESSION['fail_arr'] = null;
        Language::read('export');
        import('libraries.reader');
        $result = array();
        if($store_id<=0){
            $result['success'] = false;
            $result['message'] = "请选择店铺ID";
            echo json_encode($result);
            exit();
        }
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
        $res = $this->excel_save($data,$store_id);       
        echo $res;
    }
    
     /**
     * 处理订单保存
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function excel_save($data,$store_id){
    	//$logic_buy_1 = Logic('buy_1');
        $model_stock = Model('stock');
        $model_order = Model('order');
        $model_goods = Model('goods');        
        $model_in_goods = Model('in_goods');
        $model_setting = Model('setting');        
        $store_info = Model("store")->getStoreInfoByID($store_id);
        $member_id = $store_info['member_id'];
        $store_id = $store_info['store_id'];
	    $store_name = $store_info['store_name'];
        $successCount = 0;
        $failCount = 0;
        $fail_arr = array();    
        $result = array();  
        foreach ($data as $key => $value) {
            // $order_remark = $value['order_remark'];
            $external_order = $value['external_order'];         
            //判断身份证和姓名是否符合           
            if(preg_match("[^\x80-\xff]",trim($value['reciver_name'])) || strlen(trim($value['member_idcard']))!=18)
            {
                $value['error'] = '姓名或身份证有误';
                $fail_arr[]= $value;
                $failCount++;
                continue;
            }
			if($external_order!=""){
				//判断是否有重否的订单号
	            $order_info = $model_order->getOrderInfo(array('external_order'=>$external_order,'store_id'=>$store_id));
	            if(!empty($order_info)){
	              $value['error'] = '外部订单号已存在';
	              $fail_arr[]= $value;
	              $failCount++;
	              continue;
	            }
			}
			//判断是否有重否的支付单号
            $order_info = $model_order->getOrderInfo(array('pay_sn'=>trim($value['pay_sn'])));
            if(!empty($order_info)){
              $value['error'] = '支付交易号已存在';
              $fail_arr[]= $value;
              $failCount++;
              continue;
            }

            //地址不能包含一些特殊关键字
            $addressfun = loadfunc("address");
            $res = checkAddress($value['address']);   
            if($res['state']){
                $value['error'] = $res['message'];
                $fail_arr[]= $value;
                $failCount++;
                continue;
            }

            //开始事务
            Model()->beginTransaction();
			//全国版之前
            $pay_sn = $this->makePaySn($member_id);
            //$pay_sn = $value['pay_sn'];
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
            $address_arr = explode("，", $value['address']);

            $order = array(); 
            $order_common = array();
            $order_goods = array();
            $order['order_sn'] = $this->makeOrderSn($order_pay_id);
            $order['external_order'] = $external_order;
            $order['pay_sn'] = $pay_sn;
            $order['store_id'] = $store_id;
            $order['store_name'] = $store_name;
            $order['buyer_id'] = $member_id;
            $order['buyer_name'] = $value['phone'];
            $order['buyer_email'] = "admin@qq.com";            
            $order['add_time'] = TIMESTAMP;
            //$order['payment_code'] = "online";
            //$order['order_state'] = "10";
            //全国版之前
			//$order['payment_time'] = TIMESTAMP;
			$order['payment_code'] = "online";
			$order['order_state'] = "10";
            $order['order_amount'] = $value['allprice'];
            $order['shipping_fee'] = 0;
            $order['order_tax'] = $value['alltax'];
            $order['goods_amount'] = $value['allprice']-$value['alltax'];
            $order['order_from'] = 99;
            $order['member_idcard'] = $value['member_idcard'];
            $order['store_storage_id'] = $this->getStorage($value['extends_goods']);
            $order['fremark'] = $value['fremark'];
            $order['fstockinno'] = $value['fstockinno'];
            $order['order_remark'] = $value['order_remark'];
            //走圆通暂不生成单号
            //判断是否海外，海外是EMS          
            //$order['d_id'] = $in_goods_info['d_id']>0?$in_goods_info['d_id']:1;
            //$order['d_id']=  0;      
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

            $express_id = Model('jbwms')->getExpress('express');
            $order_common['shipping_express_id'] = $express_id;

            $order_common['reciver_province_id'] = 0;      
            $order_id = $model_order->addOrderCommon($order_common);
            if (!$order_id) {
                $value['error'] = '订单保存失败···';
                $fail_arr[]= $value;
                $failCount++;  
                Model()->rollback();//回滚事务               
                continue;               
            }
            $i = 0;
            $flag = ture;
            $goods_buy_quantity = array();
            foreach ($value['extends_goods'] as $key => $goods) {
                $where = array();
                $where['goods_id'] = $goods["goods_id"];
                $where['store_id'] = 1;
                //$where['goods_name'] = array('like',"%1罐装%");

                $goods_info = $model_goods->getGoodsInfo($where);
                if(empty($goods_info)){
                    $value['error'] = '没有找到相关商品';
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
                $order_goods[$i]['goods_tax'] = $goods['goods_tax'];
                $order_goods[$i]['goods_price'] = $goods_info['goods_price'];
                $order_goods[$i]['goods_num'] = $goods['goods_num'];
                $order_goods[$i]['goods_image'] = $goods_info['goods_image'];                  
                $order_goods[$i]['buyer_id'] = $member_id;
                $order_goods[$i]['goods_type'] = 3;
				$order_goods[$i]['promotions_id'] =2;
				$order_goods[$i]['commis_rate'] = 0;
                //计算商品金额
                $order_goods[$i]['goods_pay_price'] = $goods['goods_pay_price'];               
                $i++;
              
            }
            if(!$flag){
               continue;
            }

            $insert = $model_order->addOrderGoods($order_goods);               
            if (!insert) {               
                $value['error'] = '订单保存失败了啊';
                $fail_arr[]= $value;
                $failCount++;  
                Model()->rollback();//回滚事务               
                continue;          
            }           
         
            
            //如果执行没问题
            $successCount++;
            Model()->commit();
            //推送订单 跨境优品
            
        }
        $result['failCount'] = $failCount;
        if($failCount>0)
        {
            $this->import_error($fail_arr);
			$_SESSION['fail_arr'] = $fail_arr;
            $filename = "error"; // 16位MD5加密 ;
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
    	$model_newtaxrate = Model('newtaxrate');
        $model_goods = Model("goods");
        $result = array();
        $i = 0;
        $j = 0;
        $extends_goods = array();
        $allprice = 0;
        $alltax = 0;
        foreach ($data as $key => & $value) {
        	$value[1]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[1]);   //订单号       
        	$value[2]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[2]);   //商品编号
            $value[4]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[4]);   //商品总数
            $value[6]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[6]);   //商品总价
            $value[7]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[7]);   //顾客身份证号
            $value[8]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[8]);   //顾客姓名
            $value[9]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[9]);   //收货电话
            $value[10]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[10]);   //收货地址
            $value[11]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[11]); //支付交易号  
            $value[12]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[12]);   //项号
            $value[13]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[13]);    //仓库备注
            $value[14]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[14]);    //仓库备注
            $value[15]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$value[15]);    //海关备注
            
            $goods_info = $model_goods->getGoodsInfo(array('goods_id'=>$value[2]));
            $extends_goods[$j]['goods_id'] = $data[$key][2];
            $extends_goods[$j]['goods_num'] = $data[$key][4]; 
            $extends_goods[$j]['goods_pay_price'] = $data[$key][6];
            $extends_goods[$j]['goods_tax'] = $model_newtaxrate->getTaxByGoodsId($data[$key][2],$data[$key][6]); 
            $allprice = $allprice +  $data[$key][6]; //价格
            $alltax = $alltax +  $extends_goods[$j]['goods_tax']; //税金价格
            if($data[$key+1][12]>1){                 
                $j++;      
                continue;                
            }else {
                $result[$i]['external_order'] =  $value[1];            
                $result[$i]['phone'] = $value[9];
                $result[$i]['address'] =  str_replace ( "," ,"，" ,$value[10]);                 
                $result[$i]['reciver_name'] = $value[8]; 
                $result[$i]['member_idcard'] = $value[7]; 
                $result[$i]['allprice'] = $allprice;
                $result[$i]['alltax'] = $alltax;
                $result[$i]['goods_id'] = $value[2];
                $result[$i]['goods_num'] = $value[4];
                $result[$i]['pay_sn'] = $value[11];
                $result[$i]['fremark'] = $value[13];
                $result[$i]['fstockinno'] = $value[14];
                $result[$i]['order_remark'] = $value[15];
                $allprice = 0;
                $alltax = 0;
                $j = 0;                
            }
            $result[$i]['extends_goods'] = $extends_goods;
            $extends_goods = array(); 
            $i++;                             
        }
        return $result;
    }


	public function show_errorOp(){
		$arr = $_SESSION['fail_arr'];
		if(!empty($arr)){
			foreach($arr as $k=>$value){
				echo  "<div style='border-bottom:1px solid #ccc;font-size:14px;height:30px;line-height:30px;'>收货人:".$value['reciver_name']."&nbsp;&nbsp;货号:".$value['goods_serial']."&nbsp;&nbsp;失败原因:".$value['error']."</div>";
			}
		}
		
	}
    /**
     * 处理出错信息
     * 
     */
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
        $filename = "error"; // 16位MD5加密 ;
        file_put_contents("../../../download/".$filename.".xls", $s);
        ob_clean();
    }
    /**
     * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
     * 长度 =2位 + 10位 + 3位 + 3位  = 18位
     * 1000个会员同一微秒提订单，重复机率为1/100
     * @return string
     */
    public function makePaySn($member_id) {
        return mt_rand(10,99)
        . sprintf('%010d',time() - 946656000)
        . sprintf('%03d', (float) microtime() * 1000)
        . sprintf('%03d', (int) $member_id % 1000);
    }
    
    
    /**
     * 生成订单ID
     * @param  [type] $pay_id [description]
     * @return [type]         [description]
     */
    public function makeOrderSn($pay_id) {
        //记录生成子订单的个数，如果生成多个子订单，该值会累加
        static $num;
        if (empty($num)) {
            $num = 1;
        } else {
            $num ++;
        }
        return date("YmdHis",time()).rand(11111,99999);
        //return (date('y',time()) % 9+1) . sprintf('%013d', $pay_id) . sprintf('%02d', $num);
    }
    
     /**
     * 取商品的仓库ID
     * @param  [type] $goods_list [description]
     * @return [type]             [description]
     */
    private function getStorage($goods_list){
        $gModel = Model("goods");
        $storage_id = 0;
        foreach ($goods_list as $goods_info) {
            $goods = Model()->table("goods")->field("goods_storage_id")->where(array('goods_id'=>$goods_info['goods_id']))->find();
            if($storage_id == 0){
                $storage_id = $goods['goods_storage_id'];
            }else{
                if($storage_id!=$goods['goods_storage_id']){
                    $storage_id = 0;
                    break;
                }
            }    
        }
        return $storage_id;
    }
}
