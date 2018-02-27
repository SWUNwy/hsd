<?php
// header("Location: http://www.baidu.com"); 
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
	
	if($flag){		
	
		echo"SUCCESS";
		
	}else{
		
		echo"Verification Error"; 
		
	}

file_put_contents("./log.txt",print_r($_POST,true),FILE_APPEND);

$_GET['m']	= 'payment';
$_GET['a']		= 'getNotify';
$_GET['extra_common_param'] = 'real_order';
$_GET['out_trade_no'] = $_POST["order_no"];
$_GET['trade_no'] = $_POST["trade_no"];
$_GET['payment_code'] = 'dingpay';

require_once(dirname(__FILE__).'/../../../index.php');