<?php
/**
 * 支付企业发送报文
 *
 * 
 *
 *
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class payment_messageModel extends Model {
   
	private $list_setting=array();	
	public function __construct() {
		//取海关参数
      	$model_setting = Model('setting');      	
		$this->list_setting = $model_setting->getListSetting();
    } 
    
    /**
     * 发送报文
     */
    public function SendMessage($order,$type=null){
    	//判断是否发送成功  成功就做运单相关操作
        $order['payment_code'] = "allinpay";
       	$result = $this->PayMessage($order);
       	if($result['flag']){
            //写日志
            $insert = array();
            $insert['order_sn'] = $order['order_sn'];
            $insert['messagecode'] = 1;
            $insert['messagememo'] = '支付单入库成功';
            $insert['msg_time'] = time();
            Model('hgmessage')->insert($insert);
       		$this->PaymentInfoStorageSuccess($order);
       	}else{
            $model_order = Model('order');
            $update_message['messagememo']= "支付单入库失败";
            $model_order->editOrder($update_message,array('order_sn'=>$order['order_sn']));  
        }
        if($type=="return"){
            echo json_encode($result);
            exit();
        }
    	
    }

    public function SendPayMessage($order){
        $result = $this->PayMessage($order);
        return $result;
    }
    
    /**
     * 根据订单信息生成相关报文
     */
    private function PayMessage($order){
    	switch($order['payment_code'])
    	{
    		case 'alipay' :
    			 $res = $this->AlipayMessage($order);
    			 break;
            case 'allinpay' :
                 $model_allinpay_customs = Model("allinpay_customs");
                 $res = $model_allinpay_customs->getCustomsUrl($order);
                 break;
            case 'wx_saoma':
            case 'wx_jsapi':
    		case 'wxpay' :    		 
    		     $res = $this->WxMessage($order);
    		     break;
    	}        	
    	$model_order = Model("order_id");
    	//判断是否推送成功
    	$update = array();
    	$update['pay_status'] = 0;
    	if($res['flag']){
    	    $update['pay_status'] = 1;
    	}
    	$update['pay_msg'] = $res['msg'];
    	$model_order = Model('order');
    	$model_order->editOrder($update,array('order_id'=>$order['order_id']));
    	return $res;
    }
	
    /**
     * 生成支付宝报文
     */
    private function AlipayMessage($order){
    	$inc_file = __DIR__.("/../api/alipay/alipayapi.php");
    	require_once($inc_file);
    	$param = array();
    	$param['WIDout_request_no'] = $order['order_sn'];
    	$param['WIDtrade_no'] = $order['trade_no'];
    	$param['WIDmerchant_customs_code'] = "50069607AW";
    	$param['WIDmerchant_customs_name'] = "重庆千牛国际贸易有限公司";
    	$param['WIDamount'] = $order['order_amount'];
    	$param['WIDcustoms_place'] = "ZONGSHU";
    	$alipayapi = new alipayapi();
    	$res =  $alipayapi->submit($param); 
    	return 	$res;
    }
    
    /**
     * 支付宝报文成功操作 没运单就取运单推单，有运单就只推运单
     * @param [type] $message_type [description]
     *
     */
    private function PaymentInfoStorageSuccess($order)
    {
    	$model_datamessage= Model('datamessage');
    	$model_order = Model('order');
    	if($order['extend_order_common']['shipping_express_id']==8 && $order['shipping_code']=="")
    	{
    		$order['shipping_code']=$model_datamessage->GetEmsBill($order['extend_order_common']['reciver_info']['address']);
    		$model_order->editOrder(array('shipping_code'=>$order['shipping_code']),array('order_sn'=>$order['order_sn']));
    	}
    	else if($order['extend_order_common']['shipping_express_id']==40 && $order['shipping_code']=="")
    	{
    		$order['shipping_code']=$model_datamessage->GetYtoBill($order);
    		$model_order->editOrder(array('shipping_code'=>$order['shipping_code']),array('order_sn'=>$order['order_sn']));
    	}
    	$xml_data2=$model_datamessage->arraytoemsxml($order);
    	$model_datamessage->datapost($xml_data2);        
        /*
    	$xml_data2=$model_datamessage->arraytoemsxml1($order);
    	$res = $model_datamessage->datapost($xml_data2);
        */    
    }
    
    
     /**
     * 报关操作
     */
    private function WxMessage($order){
    	//获取报关参数
    	$xml = $this->get_wx_customs($order); 
    	
    	//微信报关
    	$url = "https://api.mch.weixin.qq.com/cgi-bin/mch/customs/customdeclareorder";
    	//$wx_result = $this->send_to_wx_customs($xml);
    	$response = $this->postXmlCurl($xml, $url, 30);
        $wx_result = json_decode(json_encode(simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA)), true);  
    	//处理微信报文
        $file = fopen("wxlog/wx.txt","w+");
        fwrite($file,$response);
        fclose($file);  
        $res = $this->treat_wx_result($wx_result);
		return $res;    	
    }
    
    /**
     * 获取微信报关订单参数
     * @param string $order_sn 订单编号
     * @return array 订单参数
     */
    function get_wx_customs($order){
        $order_common =  $order['extend_order_common'];        
        //取微信相关参数
        $condition = array();
        $condition['payment_code'] = "wxpay";
        $model_mb_payment = Model('mb_payment');
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
      
        //参数
        $wx_data = array();
        $wxpay_key = "215caa49849303677cb28d3a2791e158";
        //商户号
        $wx_data['mch_id'] = "1232049002";
        //公众号id
        $wx_data['appid'] = "wx7799c0b32b7d9b95";
        //应付金额
        //$wx_data['order_fee'] = (($order_info['money_paid'] - $order_info['shuilv']) * 100);
        $wx_data['order_fee'] = ($order['order_amount'] * 100);
    
        $wx_data['sign_type'] = 'MD5';//签名方式
         
        //商户订单号
        $wx_data['out_trade_no'] = $order['pay_sn'];
        //财付通订单号
        $wx_data['transaction_id'] = $order['trade_no'];
        //商户子订单号
        $wx_data['sub_order_no'] = $order['order_sn'];
        //币种
        $wx_data['fee_type'] = 'CNY';
        //物流费
        $wx_data['transport_fee'] = ($order['shipping_fee'] * 100);
        $wx_data['transport_fee'] = empty($wx_data['transport_fee'])?0:$wx_data['transport_fee'];
        //商品价格
        $wx_data['product_fee'] = ($order['order_amount'] * 100);//($order_info['goods_amount'] * 100);
        //关税
        $wx_data['duty'] = 0;//($beian_info['TAX_FEE'] * 100);
        //海关(0 无需上报海关;1广州;2杭州;3宁波;4深圳;5郑州(保税物流中心);6重庆;7西安;8上海;9 郑州（综保区）)
        $wx_data['customs'] = 'CHONGQING';
        //商户海关备案号
        $wx_data['mch_customs_no'] = "50069607AW";
        //证件类型(1身份证)
        $wx_data['cert_type'] = 'IDCARD';
        //证件号码
        $wx_data['cert_id'] = $order_common['reciver_info']['member_idcard'];
        //姓名
        $wx_data['name'] = $order_common['reciver_name'];
       
        //签名步骤一：按字典序排序参数
        ksort($wx_data);
    
        $buff = "";
        foreach ($wx_data as $k => $v)
        {
            if (is_numeric($v))
            {
                $buff .= $k . "=" . $v . "&";
            }
            else
            {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $String = '';
        if (strlen($buff) > 0)
        {
            $String = substr($buff, 0, strlen($buff)-1);
        }
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String."&key=".$wxpay_key;
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
    
        $wx_data['sign'] = $result_;//签名
    
        $xml = "<xml>";
        foreach ($wx_data as $key=>$val)
        {
            if (is_numeric($val))
            {
                $xml.="<".$key.">".$val."</".$key.">";
            }
            else
            {
                //$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
  
        return $xml;
    }
    
    /*
    * 处理微信实时响应报文
    * @param string $wx_result 响应报文
    */
    function treat_wx_result($wx_result){
        $res = array();
        if($wx_result['return_code'] == 'SUCCESS'){//调用接口成功
     		if($wx_result['result_code'] == 'FAIL'){
     		    $res['flag'] = false;
     		    $res['msg'] = $wx_result['err_code_des'] ;
     			//修改备案信息，支付单备注
    	      }elseif($wx_result['result_code'] == 'SUCCESS'){
     			//修改备案信息，支付单备注
    	        $res['msg'] = "操作成功";
    	        $res['flag'] = true;
    	      }
     	}else{//调用接口失败
     		//修改备案信息，支付单备注
     	     $res['flag'] = false;
     		 $res['msg'] = $wx_result['err_code_des'] ;
     	}
     	
     	return  $res;
    }
    /**
     *  作用：以post方式提交xml到对应的接口url
     */
    public function postXmlCurl($xml,$url,$second=30){ 
    	//echo $xml,'-',$url,'-',$second;die;
	    //初始化curl    
	    $ch = curl_init();
	    //设置超时
	    curl_setopt($ch, CURLOPT_TIMEOUT, $second);
	    //这里设置代理，如果有的话
	    //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
	    //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
	    curl_setopt($ch,CURLOPT_URL, $url);
	    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
	    //设置header
	    curl_setopt($ch, CURLOPT_HEADER, FALSE);
	    //要求结果为字符串且输出到屏幕上
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    //post提交方式
	    curl_setopt($ch, CURLOPT_POST, TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	    //运行curl
	    $data = curl_exec($ch);
	    curl_close($ch);
	    //返回结果     
	    if($data){   //var_dump($data);die('||');
	    	//curl_close($ch);
	   		return $data;
	    }
	    else{
	        //$error = curl_errno($ch);
	        //echo "curl出错，错误码:$error"."<br>";
	        //echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
	        //curl_close($ch);
	        //var_dump($error);die;
	        return false;
	    }
	}
}
