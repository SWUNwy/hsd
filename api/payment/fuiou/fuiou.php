<?php
/**
 * 通联支付接口类
 *
 * 
 * by 33hao 好商城V3  www.33hao.com 开发
 */
defined('ByShopKJYP') or exit('Access Invalid!');

class fuiou{
    /**
     *富友网关地址（新）
     */
    
    //测试环境地址v http://www-1.fuiou.com:8888/wg1_run/smpGate.do
    private $fuiou_gateway_new = 'http://www-1.fuiou.com:8888/wg1_run/PayBCGate.do';
    
    //生产环境地址
    //private $fuiou_gateway_new = 'https://pay.fuiou.com/PayBCGate.do';
    
    /**
     * 消息验证地址
     *
     * @var string
     */
    //private $fuiou_verify_url = 'https://mapi.fuiou.com/gateway.do?service=notify_verify&';
    private $mchnt_cd = "0001000F0040992";
    /**
     * 支付接口标识
     *
     * @var string
     */
    private $mchnt_key = "vau6p7ldawpezyaugc0kopdrrwm4gkpu";
    /**
     * 支付接口标识
     *
     * @var string
     */
    private $code = 'fuiou';
    /**
     * 支付接口配置信息
     *
     * @var array
     */
    private $payment;
    /**
     * 订单信息
     *
     * @var array
     */
    private $order;
    /**
     * 发送至富友的参数
     *
     * @var array
     */
    private $parameter;
    /**
     * 订单类型 product_buy商品购买,predeposit预存款充值
     * @var unknown
     */
    private $order_type;

    public function __construct($payment_info = array(),$order_info = array()){    
    	if(!empty($payment_info) and !empty($order_info)){
    		$this->payment	= $payment_info;
    		$this->order	= $order_info;
    	}
    }
    
    
    /**
     * 获取支付接口的请求地址
     *
     * @return string
     */
    public function get_payurl(){
        
        $model_order = Model('order');
        $model_hgdata = Model('hgdata');
        $order= $model_order->getOrderInfo( array('order_id'=>$this->order['order_list'][0]['order_id']),array('order_common'));
        $biz = $model_hgdata->GetBiz($order);
      
        $this->parameter = array(
            //生产环境
            'mchnt_cd'       => $this->mchnt_cd, //富友分配给各合作商户的唯一识别码
            'order_id'       => $this->order['pay_sn'],
            'order_amt'      => $this->order['api_pay_amount']*100,//订单总价(将元换成分)
            'order_pay_type' => 'B2C',
            'page_notify_url'=> SHOP_SITE_URL."/api/payment/fuiou/return_url.php",  //通知URL
            'back_notify_url'=> SHOP_SITE_URL."/api/payment/fuiou/notify_url.php",  //返回URL
            'iss_ins_cd'      => '0000000000',
            'customs_flag'    => '1', //改成不报关
            'customs_code'    => '05', //‘05’ – 重庆海关
            'ic_name' => $order['extend_order_common']['reciver_name'],//真实姓名
            'ic_number' => $order['extend_order_common']['reciver_info']['member_idcard'],//身份证号
            'payer_ecommerce_id' => 'ID007',//付款人电商平台id,广州海关和杭州海关必填付款人在电商平台上注册的账号ID
            'payer_tel' => $order['extend_order_common']['reciver_info']['phone'],//电话
            //'order_type' => $biz['code'],//业务类型
            'order_type' => "I20",//业务类型
            'rem'    => 'kjyp',
            'reserved1'    => 'kjyp',
            'reserved2'    => 'kjyp',
            'ver' => '1.0.0',
            'mchnt_key' => $this->mchnt_key,
        );
        
        
        $this->parameter['md5']    = $this->sign($this->parameter);
      
        echo $this->do_post();
    }
    
    /**
     * 通知地址验证
     *
     * @return bool
     */
    public function notify_verify() {
        
        $model_order = Model("order");
        $order = $model_order->getOrderInfo( array('pay_sn'=>$_POST['order_id']));
        
        $sign = $_POST['md5'];
        $mchnt_cd = $_POST['mchnt_cd'];
        $order_id = $_POST['order_id'];
        $order_date = $_POST['order_date'];
        $order_amt = $order['order_amount']*100;
        $order_st = $_POST['order_st'];
        $order_pay_code = $_POST['order_pay_code'];
        $order_pay_error = $_POST['order_pay_error'];
        $resv1 = $_POST['resv1'];
        $fy_ssn = $_POST['fy_ssn'];
        $mchnt_key = $this->mchnt_key;
        $mysign = $mchnt_cd."|".$order_id."|".$order_date."|".$order_amt."|".$order_st."|".$order_pay_code."|".$order_pay_error."|".$resv1."|".$fy_ssn."|".$mchnt_key;
        $mysign = md5($mysign);
        if($mysign == $sign)  {           
            return true;
        } else {
            return false;
        }
    }
    
    public function getPayResult(){
        if($_POST['order_st']== 11){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 返回地址验证
     *
     * @return bool
     */
    public function return_verify() {
        $model_order = Model("order");
        $order = $model_order->getOrderInfo( array('pay_sn'=>$_POST['order_id']));
        
        $sign = $_POST['md5'];
        $mchnt_cd = $_POST['mchnt_cd'];
        $order_id = $_POST['order_id'];
        $order_date = $_POST['order_date'];
        $order_amt = $order['order_amount']*100;
        $order_st = $_POST['order_st'];
        $order_pay_code = $_POST['order_pay_code'];
        $order_pay_error = $_POST['order_pay_error'];
        $resv1 = $_POST['resv1'];
        $fy_ssn = $_POST['fy_ssn'];
        $mchnt_key = $this->mchnt_key;
        $mysign = $mchnt_cd."|".$order_id."|".$order_date."|".$order_amt."|".$order_st."|".$order_pay_code."|".$order_pay_error."|".$resv1."|".$fy_ssn."|".$mchnt_key;
        $mysign = md5($mysign);
        if($mysign == $sign)  {           
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * 远程获取数据
     * $url 指定URL完整路径地址
     * @param $time_out 超时时间。默认值：60
     * return 远程输出的数据
     */
    private function getHttpResponse($url,$time_out = "60") {
        $urlarr     = parse_url($url);
        $errno      = "";
        $errstr     = "";
        $transports = "";
        $responseText = "";
        if($urlarr["scheme"] == "https") {
            $transports = "ssl://";
            $urlarr["port"] = "443";
        } else {
            $transports = "tcp://";
            $urlarr["port"] = "80";
        }
        $fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
        if(!$fp) {
            die("ERROR: $errno - $errstr<br />\n");
        } else {
            if (trim(CHARSET) == '') {
                fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
            } else {
                fputs($fp, "POST ".$urlarr["path"].'?_input_charset='.CHARSET." HTTP/1.1\r\n");
            }
            fputs($fp, "Host: ".$urlarr["host"]."\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $urlarr["query"] . "\r\n\r\n");
            while(!feof($fp)) {
                $responseText .= @fgets($fp, 1024);
            }
            fclose($fp);
            $responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");
            return $responseText;
        }
    }
    
    
    /**
     * 取得签名
     *
     * @return string
     */
    private function sign($parameter) {
        $mysign = "";
        $sort_array = $filtered_array = $this->para_filter($parameter);
        $arg = "";
        while (list ($key, $val) = each ($sort_array)) {
            $arg .= $val."|";
        }
        $prestr = substr($arg,0,-1);  //去掉最后一个&号          
        if($parameter['sign_type'] == 'MD5') {
            $mysign = md5($prestr);
        }elseif($parameter['sign_type'] =='DSA') {
            //DSA 签名方法待后续开发
            die("DSA 签名方法待后续开发，请先使用MD5签名方式");
        }else {
            $mysign = md5($prestr);
            //die("富友暂不支持".$parameter['sign_type']."类型的签名方式");
        }
        return $mysign;
    }
    
    /**
     * 除去数组中的空值和签名模式
     *
     * @param array $parameter
     * @return array
     */
    private function para_filter($parameter) {
        $para = array();
        while (list ($key, $val) = each ($parameter)) {
            if($key == "md5" || $key == "sign" || $key == "sign_type" || $key == "key" || $val == "")continue;
            else    $para[$key] = $parameter[$key];
        }
        return $para;
    }
    /**
     * 模拟表单推送数据
     *
     */
    public function do_post()
    {
        header('Content-type:text/html;charset=utf-8');
        echo "<form name=\"pay\" method=\"post\" action=\"".$this->fuiou_gateway_new."\" id = \"form\">\n";
        foreach($this->parameter as $kk =>$kv){
            if($kk != 'mchnt_key') {
                echo "<input type=\"hidden\" value = \"{$kv}\"  name=\"{$kk}\" />\n";
            }
            }
            echo "</form>";
            echo "<script>document.getElementById(\"form\").submit();</script>";
    }
    
    
}