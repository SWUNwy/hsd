<?php
/**
 * 智付支付接口
 * by:yu
 * @email:paul.wang@hotstaro2o.com
 */
defined('ByShopKJYP') or exit('Access Invalid!');

class dingpay{

	private $serverUrl = "https://pay.dinpay.com/gateway?input_charset=UTF-8";	//服务请求地址

	private $merchant_code = "2020141350";		//商家号2020141350

	private $notify_url = "/api/payment/dingpay/notify_url.php";		//服务器异步通知地址

	private $payment_type = "batch_pay";	//批量支付标识,固定值:batch_pay

	private $sign_type = "RSA-S";		//签名方式，取值为：RSA或RSA-S；该字段不参与签名

	private $input_charset = "UTF-8";	//参数编码字符集

	private $service_type = "direct_pay";	//服务类型

	private $order = "";		//订单信息
	
	private $payment = "";		//订单信息

	private $interface_version = "V3.0";	//接口版本

	private $dinpay_public_key = "";		//智付公钥，每个商家对应一个固定的智付公钥

	private $redo_flag = "0";				//参数名称：是否允许重复订单

	public function __construct($payment_info = array(),$order_info = array()) {
    	if(!empty($payment_info) && !empty($order_info)){
    		$this->payment	= $payment_info;
    		$this->order	= $order_info;
    		// var_dump($this->order);
    		// die();
    	}
	}

	public function getForm() {
		$batch_num = "bz".date('YmdHis');
		$serverUrl = $this->serverUrl;
		$merchant_code = $this->merchant_code;
		$service_type = $this->service_type;
		$input_charset = $this->input_charset;
		$interface_version = $this->interface_version;
		$notify_url = $this->notify_url;
		$notify_url = SHOP_SITE_URL.$notify_url;
		$sign_type = $this->sign_type;
		$redo_flag = $this->redo_flag;
		$payment_type = $this->payment_type;
		$batch_product_name = "母婴产品";
		$order = $this->order['order_list'];
		$total_num = count($this->order['order_list']);
		$total_amount = $this->order['api_pay_amount'];
		$extra_return_param = $this->order['pay_sn'];
		$orders_info = array();
		foreach ($order as $key => $order_detail) {
			$order_id = $order_detail['order_id'];
			$order_no = $order_detail['order_sn'];
			$orderAmount = $order_detail['order_amount'];
			$model = Model('order_goods');
			$goods_info = $model->where('order_id='.$order_id)->find();
			$arr = array(
				'order_no' => $order_no,
				'order_time' => date('Y-m-d H:i:s'),
				'order_amount' => $orderAmount,
				'product_name' => $goods_info['goods_name'],
				);
			$orders_info[] = $arr;
		}
		$orders_info = str_replace("\"","'",json_encode($orders_info,JSON_UNESCAPED_UNICODE));
		/**
		 * 参数组装
		 * 除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
		 */

		$signStr= "";			
		$signStr = $signStr."batch_num=".$batch_num."&";	
		if($batch_product_name != ""){	
			$signStr = $signStr."batch_product_name=".$batch_product_name."&";
		}
		$signStr = $signStr."extra_return_param=".$extra_return_param."&";
		$signStr = $signStr."input_charset=".$input_charset."&";
		$signStr = $signStr."interface_version=".$interface_version."&";
		$signStr = $signStr."merchant_code=".$merchant_code."&";
		$signStr = $signStr."notify_url=".$notify_url."&";
		$signStr = $signStr."orders_info=".$orders_info."&";
		$signStr = $signStr."payment_type=".$payment_type."&";
		if($redo_flag != ""){
			$signStr = $signStr."redo_flag=".$redo_flag."&";
		}
		$signStr = $signStr."service_type=".$service_type."&";
		$signStr = $signStr."total_amount=".$total_amount."&";
		$signStr = $signStr."total_num=".$total_num;

		// var_dump($signStr);
		// die();
		/**
		1）merchant_private_key，商户私钥;merchant_public_key,商户公钥；商户需要按照《密钥对获取工具说明》操作并获取商户私钥，商户公钥。
		2）demo提供的merchant_private_key、merchant_public_key是测试商户号1111110166的商户私钥和商户公钥，请商家自行获取并且替换；
		3）使用商户私钥加密时需要调用到openssl_sign函数,需要在php_ini文件里打开php_openssl插件
		*/
		$merchant_private_key='MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBANkS5cFK/K8hncZm
	wsm852BTzHIK0wC8MnXxRjfVU5i7GOe5cWuXGWDw1/Ndy0/IrwPkAh2hOzzJAwJ4
	qoveOVwTge79y3RqQDaW4MPA1vab7VDPXsqCyHx4Gmfaowmb62dxFAGt2YobAOwU
	xRzsah7pX6c4ZSfqboGhuuTkAyKdAgMBAAECgYEAgQLwNe8BOny6Ln5IammxAdkL
	+wNf4GH5g4s/9lL8+hrIdIAMXqtQ1AKP9f3apbJaAe/zKfT3Jes5tLBOfA44+94G
	b/J68viYPKhYj496nQrEH0XVAMBl3pismoiSrZoAfeeVw+iWcwYT6+qhFSGxwWAL
	gPYRXI3sxvJFkHhipQECQQDvXVwiw/EE69ix+mN2QCBlY3N3aqY53jCqfQsPMe1H
	KmyKbZ+K5I2fMh40BIhW1QLfhzFZavKuazWuAXOwgtMhAkEA6CjzffTZ09vArOg3
	kVWzF/E8srfu/E0+3Wg8QMDmZ9OiLznZEhpIBlm7/z4DGlQdAzOWqFgqK8UdZgRu
	C/Qb/QJBAMHjn+RRT4Qq/qZ8KeD5ZMR74GYUr30ka8tN6o1uZcNFrBIdZiR9qfIQ
	CMMeAMpFVUR3IBRMOzPph9vhNTL/ZcECQHZ8sAkQ9juSZHva6MFcI9OMY5YzGd3a
	7sLBeD70NKO494Vy2L7MewYCtlhGpf7B/yyrH7E7jgpYx/BRQnkHVWECQQDQmXNG
	/VilvGGy5j8feOHD5PP/Hz4mkcFY+GCQTdxSu3KXBcR1tzsEhWj1mwUmn6Bn+lCR
	SVbLvIP25TIgrf0i';	
	    $merchant_private_key = "-----BEGIN PRIVATE KEY-----"."\r\n".wordwrap(trim($merchant_private_key),64,"\r\n",true)."\r\n"."-----END PRIVATE KEY-----";	
		$merchant_private_key= openssl_get_privatekey($merchant_private_key);	
		openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);	
		$sign = base64_encode($sign_info);

		// var_dump($sign);
		// die();

		$html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>';
		$html .= '<body onLoad="document.dinpayForm.submit();">';
		$html .= '<form name="dinpayForm" method="post" action="'.$serverUrl.'" target="_self" />';
		$html .= '<input type="hidden" name="sign"                value="'.$sign.'" />';
		$html .= '<input type="hidden" name="merchant_code"       value="'.$merchant_code.'" />';
		$html .= '<input type="hidden" name="service_type"        value="'.$service_type.'" />';	
		$html .= '<input type="hidden" name="input_charset"       value="'.$input_charset.'" />';
		$html .= '<input type="hidden" name="interface_version"	  value="'.$interface_version.'" />';
		$html .= '<input type="hidden" name="notify_url"     	  value="'.$notify_url.'" />';
		$html .= '<input type="hidden" name="sign_type"        	  value="'.$sign_type.'" />';		
		$html .= '<input type="hidden" name="redo_flag"      	  value="'.$redo_flag.'" />';		
		$html .= '<input type="hidden" name="payment_type"        value="'.$payment_type.'" />';		
		$html .= '<input type="hidden" name="batch_num"    		  value="'.$batch_num.'" />';		
		$html .= '<input type="hidden" name="batch_product_name"  value="'.$batch_product_name.'" />';
		$html .= '<input Type="hidden" Name="total_amount"        value="'.$total_amount.'" />';
		$html .= '<input type="hidden" name="total_num"      	  value="'.$total_num.'" />';
		$html .= '<input type="hidden" name="orders_info"         value="'.$orders_info.'" />';
		$html .= '<input type="hidden" name="extra_return_param"  value="'.$extra_return_param.'" />';
	    $html .= '</form></body></html>';

	    echo $html;
		exit;

	}

	public function notify_verify(){
	    return $this->return_verify();
	}

	public function return_verify() {

        $merchant_code  = $_POST["merchant_code"];      //参数名称：商家号,商户签约时，智付分配给商家的唯一身份标识。例如1111110166或者1118004517。

        $interface_version = $_POST["interface_version"];   //参数名称：接口版本,固定值：V3.0(大写)

        $sign_type = $_POST["sign_type"];       //参数名称：签名方式,1.取值为：RSA或RSA-S,2.该字段不参与签名

        $dinpaySign = base64_decode($_POST["sign"]);        //参数名称：智付返回签名数据,该参数用于验签，值如何使用，请参考智付提供的示例代码

        $notify_type = $_POST["notify_type"];       //参数名：通知方式,固定值：offline_notify或者page_notify

        $notify_id = $_POST["notify_id"];       //参数名：通知校验ID,此版本不需要校验，但是参数依然保留

        $order_no = $_POST["order_no"];     //参数名称：商家订单号,商家网站生成的订单号，由商户保证其唯一性，由字母、数字、下划线组成。

        $order_time = $_POST["order_time"];     //参数名称：商家订单时间,时间格式：yyyy-MM-dd HH:mm:ss

        $order_amount = $_POST["order_amount"];     //参数名称：商家订单金额,以元为单位，精确到小数点后两位.例如：12.01

        $trade_status = $_POST["trade_status"];     //参数名：订单状态,取值为“SUCCESS”，代表订单交易成功

        $trade_time = $_POST["trade_time"];     //参数名：智付订单时间,格式：yyyy-MM-dd HH:mm:ss

        $trade_no = $_POST["trade_no"];         //参数名：智付订单号

        $bank_seq_no = $_POST["bank_seq_no"];   //参数名：银行交易流水号,如果此参数不为空，则必须参与签名

        $extra_return_param = $_POST["extra_return_param"];		//参数名称：回传参数,商户如果支付请求是传递了该参数，则通知商户支付成功时会回传该参数

	/**	
	除了sign_type dinpaySign参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母	
	*/
		
		$signStr = "";
		
		if($bank_seq_no != ""){
			$signStr = $signStr."bank_seq_no=".$bank_seq_no."&";
		}

		if($extra_return_param != ""){
			$signStr = $signStr."extra_return_param=".$extra_return_param."&";
		}	

		$signStr = $signStr."interface_version=".$interface_version."&";	

		$signStr = $signStr."merchant_code=".$merchant_code."&";

		$signStr = $signStr."notify_id=".$notify_id."&";

		$signStr = $signStr."notify_type=".$notify_type."&";

	    $signStr = $signStr."order_amount=".$order_amount."&";	

	    $signStr = $signStr."order_no=".$order_no."&";	

	    $signStr = $signStr."order_time=".$order_time."&";	

	    $signStr = $signStr."trade_no=".$trade_no."&";	

	    $signStr = $signStr."trade_status=".$trade_status."&";

		$signStr = $signStr."trade_time=".$trade_time;
		
	/**
	1)dinpay_public_key，智付公钥，每个商家对应一个固定的智付公钥（不是使用工具生成的密钥merchant_public_key，不要混淆）
	2)demo提供的dinpay_public_key是测试商户号1111110166的智付公钥，请自行复制对应商户号的智付公钥进行调整和替换。
	3）使用智付公钥验证时需要调用openssl_verify函数进行验证,需要在php_ini文件里打开php_openssl插件
	*/
		/**
		 * 智付公钥
		 * [$dinpay_public_key description]
		 * @var string
		 */
		$dinpay_public_key ='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCaDpG/od+RfBLglwsLEMGj/vkmvscZ9r2EAvKJAwLk8qhhHn29jKQHqm2HOC53gJOLGIeaMJeWb5cUZ2QURaf/B2sat9ARl3ls67Ytlj/68j9s1e89XblGVHIFG62zOzWTjGVVtas/4zzcOUvDlMdUO0oX0jD8bXeELQyMTpmyJQIDAQAB'; 	
	    $dinpay_public_key = "-----BEGIN PUBLIC KEY-----"."\r\n".wordwrap(trim($dinpay_public_key),62,"\r\n",true)."\r\n"."-----END PUBLIC KEY-----";	
		$dinpay_public_key = openssl_get_publickey($dinpay_public_key);	
		$flag = openssl_verify($signStr,$dinpaySign,$dinpay_public_key,OPENSSL_ALGO_MD5);	
			
	///////////////////////////   响应“SUCCESS” /////////////////////////////
		
		if($_POST['trade_status'] == "SUCCESS"){		
		
			return true;
			
		}else{
			
			return flase; 
			
		}		
	}
}