<?php
/**
 * 推送订单到智付
 * 通知其支付单报关
 */

defined('ByShopKJYP') or exit('Access Invalid!');

class dingpayModel extends Model {

	public function __construct() {
		//取海关参数
      	$model_setting = Model('setting');      	
		$this->list_setting = $model_setting->getListSetting();
    } 

	public function SendPayInfo($order) {

		$sign_type = "RSA-S";					//签名类型，二选一： RSA、RSA-S（此参数不参与签名）
		$service_version = "3.0";				//版本号，固定值3.0
		$input_charset = "UTF-8";				//字符编码：UTF-8、GBK。默认UTF-8。
		
		$merchant_id = "2020141350";			//商户号,由智付统一分配的10位正整数号
		$out_trade_no = $order['order_sn'];			//商户系统内部的订单号
		$sub_trade_no = $order['order_sn'];			//商户子订单号(若为空则用out_trade_no代替)
		$transaction_id = $order['trade_no'];		//支付订单号，如果通过智付支付则对应智付订单号 即交易流水号
		$currency_id = "CNY";	

		$transport_amount = "0";		//物流费用，以分为单位
		$product_amount = sprintf("%.2f",$order['order_amount']/1.119)*100;			//商品费用，以分为单位sprintf("%.2f",$num)
		$duty = sprintf("%.0f",$product_amount*0.119)*1;				//关税，以分为单位
		$insured_amount = "0";			//运输保险费用
		$order_amount = $order['order_amount']*100;				//消费者付款金额，以分为单位

		$customs = "26";						//26 重庆海关统一版
		$ebpent_no = "ebpent_no";					//国检备案编号不是必填项 
		$customs_code = "customs_code";				//主管海关代码（海关类型为18，则此字段必填）
		$mch_ciq_no = "mch_ciq_no";					//电商在国检总局备案号（海关类型为20，则此字段必填）
		$ciq_code = "ciq_code";						//主管国检关区代码（海关类型为20，则此字段必填）
		$mch_customs_no = "5012260547";				//商户在海关登记的备案号

		$mch_customs_name = "重庆倍赞电子商务有限公司";		//商户在海关备案的企业名称(特别说明：若此前对接的是1.0版本，且此后需要申报除杭州和广州之外的海关，则此参数必填)
		$name = $order['extend_order_common']['reciver_name'];								//姓名
		$cert_type = "1";					//暂只支持1身份证
		$cert_id = $order['member_idcard'];						//证件号码
		$business_type = "1";			//1 保税进口	2 直邮进口
		$return_url = SHOP_SITE_URL.'/api/payment/dingpay/get_return.php';

	/** 数据签名
	签名规则定义如下：
	（1）参数列表中，除去sign_type、sign两个参数外，其它所有非空的参数都要参与签名，值为空的参数不用参与签名；
	（2）签名参数排序按照参数名a到z的顺序排序，若遇到相同首字母，则看第二个字母，以此类推，组成规则如下：
	参数名1=参数值1&参数名2=参数值2&……&参数名n=参数值n		*/
		
		$signStr= "";			
		$signStr = $signStr."business_type=".$business_type."&";	
		$signStr = $signStr."cert_id=".$cert_id."&";		
		$signStr = $signStr."cert_type=".$cert_type."&";
		$signStr = $signStr."currency_id=".$currency_id."&";		
		$signStr = $signStr."customs=".$customs."&";
		
		$signStr = $signStr."duty=".$duty."&";
		$signStr = $signStr."input_charset=".$input_charset."&";		
		$signStr = $signStr."insured_amount=".$insured_amount."&";
		$signStr = $signStr."mch_customs_name=".$mch_customs_name."&";
		$signStr = $signStr."mch_customs_no=".$mch_customs_no."&";
			
		$signStr = $signStr."merchant_id=".$merchant_id."&";
		$signStr = $signStr."name=".$name."&";	
		$signStr = $signStr."order_amount=".$order_amount."&";	
		$signStr = $signStr."out_trade_no=".$out_trade_no."&";
		$signStr = $signStr."product_amount=".$product_amount."&";
		
		$signStr = $signStr."return_url=".$return_url."&";
		$signStr = $signStr."service_version=".$service_version."&";		
		if($sub_trade_no != ""){	
			$signStr = $signStr."sub_trade_no=".$sub_trade_no."&";
		}		
		$signStr = $signStr."transaction_id=".$transaction_id."&";	
		$signStr = $signStr."transport_amount=".$transport_amount;
		// var_dump($signStr);


				
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

        // 请求地址
        $reqUrl = "https://customs.dinpay.com/customDeclare?input_charset=UTF-8";
        
    	// 组装post数据；
        $postData = array(
	        'sign_type'=>'RSA-S',
	        'service_version'=>'3.0',
	        'input_charset'=>'UTF-8',
	        'merchant_id'=>'2020141350',
	        'out_trade_no'=>$out_trade_no,
	        'sub_trade_no'=>$out_trade_no,
	        'transaction_id'=>$transaction_id,  
	        'currency_id'=>'CNY',    
	        'transport_amount'=>$transport_amount,
	        'product_amount'=>$product_amount,  
	        'duty'=>$duty,
	        'insured_amount'=>$insured_amount,  
	        'order_amount'=>$order_amount,
	        'customs'=>$customs, 
	        'mch_customs_no'=>$mch_customs_no,
	        'mch_customs_name'=>$mch_customs_name,  
	        'name'=>$name,
	        'cert_type'=>$cert_type,    
	        'cert_id'=>$cert_id,    
	        'business_type'=>$business_type,        
	        'return_url'=>$return_url,
	        'sign'=>$sign
        );
        // print_r($postData);
        //  Post提交参数到智付网关并返回数据
        $returnData = $this->HttpPost($reqUrl, $postData);
        // print_r($returnData);
        $update['pay_status'] = 1;
    	$model_order = Model('order');
    	$model_order->editOrder($update,array('order_id'=>$order['order_id']));
		return true;

	}

	public function HttpPost($url,$param) {
		$ch = curl_init(); 													//初始化curl
		curl_setopt($ch, CURLOPT_URL, $url);								//设置链接
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, true);								//设置为POST方式
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));		//POST数据		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);						//设置是否返回信息				
		$response = curl_exec($ch);											//接收返回信息
		curl_close($ch); 													//关闭curl链接
		return $response;													//显示返回信息		
	}


}