﻿<?php
/**
 * 通联支付接口类
 *
 * 
 * by 33hao 好商城V3  www.33hao.com 开发
 */

defined('ByShopKJYP') or exit('Access Invalid!');

class allinpay{
	/**
	 *通联支付网关地址
	 */
	//private $serverUrl = 'http://ceshi.allinpay.com/gateway/index.do';   //测试环境
	private $serverUrl = 'https://service.allinpay.com/gateway/index.do';   //正式环境	
	/**
	 * key
	 *
	 * @var string
	 */
	private $key = '1234567890';
	/**
	 * 商户号
	 *
	 * @var string
	 */	
	private $merchantId = '109310231716002';
	/**
	 * 支付接口标识
	 *
	 * @var string
	 */
    private $code      = 'allinpay';
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
	 * 发送至支付宝的参数
	 *
	 * @var array
	 */
    private $parameter;
    /**
     * 订单类型
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
	 * 支付表单
	 *
	 */
	public function submit(){

	    $model_order = Model('order');
	    $model_hgdata = Model('hgdata');
	    $order= $model_order->getOrderInfo( array('order_id'=>$this->order['order_list'][0]['order_id']),array('order_goods','order_common'));
	    $biz = $model_hgdata->GetBiz($order);
	    $goods_name = $order['extend_order_goods'][0]['goods_name'];
	    if(count($order['extend_order_goods'])>1){
	    	$goods_name .= "等产品";
	    }

	    //$this->order['api_pay_amount'] = 2;
	    $param['serverUrl'] = $this->serverUrl;
	    $param['inputCharset'] = 1;
	    $param['pickupUrl'] = SHOP_SITE_URL."/api/payment/allinpay/pickup.php";
	    $param['receiveUrl'] = SHOP_SITE_URL."/api/payment/allinpay/receive.php";
	    $param['version'] = "v1.0";
	    $param['language'] = "";
	    $param['signType'] = "1";
	    $param['merchantId'] = $this->merchantId;
	    $param['payerName'] = "";
	    $param['payerEmail'] = "";
	    $param['payerTelephone'] = "";
	    $param['payerIDCard'] = "";
	    $param['pid'] = "";
	    $param['orderNo'] = $order['order_sn'];
	    //$param['orderNo'] = "NO20160623152450";
	    $param['orderAmount'] = $this->order['api_pay_amount']*100;;
	    $param['orderDatetime'] = date("YmdHis");
	    //$param['orderDatetime'] = "20160623152450";
	    $param['orderCurrency'] = "";
	    $param['orderExpireDatetime'] = "";
	    $param['productName'] = $goods_name;
	    $param['productId'] = "";
	    $param['productPrice'] = "";
	    $param['productNum'] = "";
	    $param['productDesc'] = "";
	    $param['ext1'] = $order['pay_sn'];
	    $param['ext2'] = "";
	    $param['extTL'] = "";
	    $param['payType'] = "0"; //payType   不能为空，必须放在表单中提交。
	    $param['issuerId'] = ""; //issueId 直联时不为空，必须放在表单中提交。
	    $param['pan'] = "";
	    $param['tradeNature'] = "GOODS";
	    $param['customsExt'] = "<GW_CUSTOMS><CUSTOMS_TYPE>HG016</CUSTOMS_TYPE><ESHOP_ENT_CODE>5012260547</ESHOP_ENT_CODE><ESHOP_ENT_NAME>重庆倍赞电子商务有限公司</ESHOP_ENT_NAME><PAYER_NAME>".$order['extend_order_common']['reciver_name']."</PAYER_NAME><PAPER_TYPE>01</PAPER_TYPE><PAPER_NUMBER>".$order['extend_order_common']['reciver_info']['member_idcard']."</PAPER_NUMBER><NOTE></NOTE></GW_CUSTOMS>";
	    //$param['customsExt'] = "<GW_CUSTOMS><CUSTOMS_TYPE>HG001</CUSTOMS_TYPE><BIZ_TYPE_CODE>".$biz['code']."</BIZ_TYPE_CODE><ESHOP_ENT_CODE>5012260547</ESHOP_ENT_CODE><ESHOP_ENT_NAME>重庆倍赞电子商务有限公司</ESHOP_ENT_NAME><GOODS_FEE>".($order['goods_amount']*100)."</GOODS_FEE><TAX_FEE>".($order['order_tax']*100)."</TAX_FEE><FREIGHT_FEE>0</FREIGHT_FEE><OTHER_FEE>0</OTHER_FEE></GW_CUSTOMS>";
	    $param['key']=$this->key;

	    // var_dump($param);
	    // die();
	 
		list($ext2,$signMsg) = $this->sign($param);
		
		$html = '<html><head></head><body>';
		$html .= '<form method="post" name="E_FORM" action="'.$param['serverUrl'].'">';		
		$html .= '<input type="hidden" name="inputCharset" id="inputCharset" value="'.$param['inputCharset'].'" />';
		$html .= '<input type="hidden" name="pickupUrl" id="pickupUrl" value="'.$param['pickupUrl'].'">';
		$html .= '<input type="hidden" name="receiveUrl" id="receiveUrl" value="'.$param['receiveUrl'].'">';
		$html .= '<input type="hidden" name="version" id="version" value="'.$param['version'].'">';
		$html .= '<input type="hidden" name="language" id="language" value="'.$param['language'].'">';
		$html .= '<input type="hidden" name="signType" id="signType" value="'.$param['signType'].'">';
		$html .= '<input type="hidden" name="merchantId" id="merchantId" value="'.$param['merchantId'].'">';
		$html .= '<input type="hidden" name="payerName" id="payerName" value="'.$param['payerName'].'">';
		$html .= '<input type="hidden" name="payerEmail" id="payerEmail" value="'.$param['payerEmail'].'">';
		$html .= '<input type="hidden" name="payerTelephone" id="payerTelephone" value="'.$param['payerTelephone'].'">';
		$html .= '<input type="hidden" name="payerIDCard" id="payerIDCard" value="'.$param['payerIDCard'].'">';
		$html .= '<input type="hidden" name="pid" id="pid" value="'.$param['pid'].'">';
		$html .= '<input type="hidden" name="orderNo" id="orderNo" value="'.$param['orderNo'].'">';
		$html .= '<input type="hidden" name="orderAmount" id="orderAmount" value="'.$param['orderAmount'].'">';
		$html .= '<input type="hidden" name="orderCurrency" id="orderCurrency" value="'.$param['orderCurrency'].'">';
		$html .= '<input type="hidden" name="orderDatetime" id="orderDatetime" value="'.$param['orderDatetime'].'">';
		$html .= '<input type="hidden" name="orderExpireDatetime" id="orderExpireDatetime" value="'.$param['orderExpireDatetime'].'">';
		$html .= '<input type="hidden" name="productName" id="productName" value="'.$param['productName'].'">';
		$html .= '<input type="hidden" name="productPrice" id="productPrice" value="'.$param['productPrice'].'">';
		$html .= '<input type="hidden" name="productNum" id="productNum" value="'.$param['productNum'].'">';
		$html .= '<input type="hidden" name="productId" id="productId" value="'.$param['productId'].'">';
		$html .= '<input type="hidden" name="productDesc" id="productDesc" value="'.$param['productDesc'].'">';
		$html .= '<input type="hidden" name="ext1" id="ext1" value="'.$param['ext1'].'">';
		$html .= '<input type="hidden" name="ext2" id="ext2" value="'.$ext2.'">';
		$html .= '<input type="hidden" name="extTL" id="extTL" value="'.$param['extTL'].'">';
		$html .= '<input type="hidden" name="payType" value="'.$param['payType'].'">';
		$html .= '<input type="hidden" name="issuerId" value="'.$param['issuerId'].'">';
		$html .= '<input type="hidden" name="pan" value="'.$param['pan'].'">';
		$html .= '<input type="hidden" name="tradeNature" value="'.$param['tradeNature'].'">';
		$html .= '<input type="hidden" name="customsExt" value="'.$param['customsExt'].'">';
		$html .= '<input type="hidden" name="signMsg" id="signMsg" value="'.$signMsg.'">';
	
		$html .= '</form><script type="text/javascript">document.E_FORM.submit();</script>';
		$html .= '</body></html>';
		echo $html;
		exit;
	}
    
	private function sign($param){
		
		
	    //set_include_path(get_include_path() . PATH_SEPARATOR . '/api/payment/allinpay/phpseclib');
		//require("File/X509.php"); 
		//require("Crypt/RSA.php");	
	    //如果不用证书加密，使用php_rsa.php函数
	    require_once(dirname(__FILE__)."/php_rsa.php");	
	   
	    // 生成签名字符串。
	    if($param['inputCharset'] != "")
	        $bufSignSrc=$bufSignSrc."inputCharset=".$param['inputCharset']."&";
	    if($param['pickupUrl'] != "")
	        $bufSignSrc=$bufSignSrc."pickupUrl=".$param['pickupUrl']."&";
	    if($param['receiveUrl'] != "")
	        $bufSignSrc=$bufSignSrc."receiveUrl=".$param['receiveUrl']."&";
	    if($param['version'] != "")
	        $bufSignSrc=$bufSignSrc."version=".$param['version']."&";
	    if($param['language'] != "")
	        $bufSignSrc=$bufSignSrc."language=".$param['language']."&";
	    if($param['signType'] != "")
	        $bufSignSrc=$bufSignSrc."signType=".$param['signType']."&";
	    if($param['merchantId'] != "")
	        $bufSignSrc=$bufSignSrc."merchantId=".$param['merchantId']."&";
	    if($param['payerName'] != "")
	        $bufSignSrc=$bufSignSrc."payerName=".$param['payerName']."&";
	    if($param['payerEmail'] != "")
	        $bufSignSrc=$bufSignSrc."payerEmail=".$param['payerEmail']."&";
	    if($param['payerTelephone'] != "")
	        $bufSignSrc=$bufSignSrc."payerTelephone=".$param['payerTelephone']."&";
	    //需要加密付款人身份证信息
	    if($param['payerIDCard'] != "")
	    {
	        /*
	         //测身份证信息认证使用商户号：20150513442
	         //加密函数从php_rsa.php 调用
	         $publickeyfile = './publickey.txt';
	         $publickeycontent = file_get_contents($publickeyfile);
	    
	         $publickeyarray = explode(PHP_EOL, $publickeycontent);
	         $publickey_arr = explode('=',$publickeyarray[0]);
	         $modulus_arr = explode('=',$publickeyarray[1]);
	         $publickey = trim($publickey_arr[1]);
	         $modulus = trim($modulus_arr[1]);
	         $keylength = 1024;
	         $ciphertext = base64_encode(rsa_encrypt($payerIDCard, $publickey, $modulus, $keylength));
	         */
	        //测身份证信息认证使用商户号：20150513442
	        //加密函数从phpseclib调用
	        $certfile = file_get_contents(dirname(__FILE__).'./TLCert-test.cer');
	        $x509 = new File_X509();
	        $cert = $x509->loadX509($certfile);
	        $pubkey = $x509->getPublicKey();
	        $rsa = new Crypt_RSA();
	        $rsa->loadKey($pubkey);
	        $rsa->setPublicKey();
	        $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
	        $ciphertext = $rsa->encrypt($payerIDCard);
	        $ciphertext = base64_encode($ciphertext);
	        $payerIDCard = $ciphertext;
	        echo $bufSignSrc = $bufSignSrc."payerIDCard=".$payerIDCard."&";
	    }
	    
	    if($param['pid'] != "")
	        $bufSignSrc=$bufSignSrc."pid=".$param['pid']."&";
	    if($param['orderNo'] != "")
	        $bufSignSrc=$bufSignSrc."orderNo=".$param['orderNo']."&";
	    if($param['orderAmount'] != "")
	        $bufSignSrc=$bufSignSrc."orderAmount=".$param['orderAmount']."&";
	    if($param['orderCurrency'] != "")
	        $bufSignSrc=$bufSignSrc."orderCurrency=".$param['orderCurrency']."&";
	    if($param['orderDatetime'] != "")
	        $bufSignSrc=$bufSignSrc."orderDatetime=".$param['orderDatetime']."&";
	    if($param['orderExpireDatetime'] != "")
	        $bufSignSrc=$bufSignSrc."orderExpireDatetime=".$param['orderExpireDatetime']."&";
	    if($param['productName'] != "")
	        $bufSignSrc=$bufSignSrc."productName=".$param['productName']."&";
	    if($param['productPrice'] != "")
	        $bufSignSrc=$bufSignSrc."productPrice=".$param['productPrice']."&";
	    if($param['productNum'] != "")
	        $bufSignSrc=$bufSignSrc."productNum=".$param['productNum']."&";
	    if($param['productId'] != "")
	        $bufSignSrc=$bufSignSrc."productId=".$param['productId']."&";
	    if($param['productDesc'] != "")
	        $bufSignSrc=$bufSignSrc."productDesc=".$param['productDesc']."&";
	    if($param['ext1'] != "")
	        $bufSignSrc=$bufSignSrc."ext1=".$param['ext1']."&";
	    
	    //如果海关扩展字段不为空，需要做个MD5填写到ext2里
	    if($param['ext2'] == "" && $param['customsExt'] != "")
	    {
	        $param['ext2'] = trim(strtoupper(md5($param['customsExt'])));
	        $bufSignSrc=$bufSignSrc."ext2=".$param['ext2']."&";
	    }
	    else if($param['$ext2'] != "")
	    {
	        $bufSignSrc=$bufSignSrc."ext2=".$param['ext2']."&";
	    }
	    if($param['extTL'] != "")
	        $bufSignSrc=$bufSignSrc."extTL".$param['extTL']."&";
	    if($param['payType'] != "")
	        $bufSignSrc=$bufSignSrc."payType=".$param['payType']."&";
	    if($param['issuerId'] != "")
	        $bufSignSrc=$bufSignSrc."issuerId=".$param['issuerId']."&";
	    if($param['pan'] != "")
	        $bufSignSrc=$bufSignSrc."pan=".$param['pan']."&";
	    if($param['tradeNature'] != "")
	        $bufSignSrc=$bufSignSrc."tradeNature=".$param['tradeNature']."&";
	    $bufSignSrc=$bufSignSrc."key=".$param['key']; //key为MD5密钥，密钥是在通联支付网关商户服务网站上设置。
	    //签名，设为signMsg字段值。
	    $signMsg = strtoupper(md5($bufSignSrc));
	   
	    return  array($param['ext2'],$signMsg);
	}
	
	
	//同步和异步都是一样的,所以我只有这么写了
	public function notify_verify(){
	    return $this->return_verify();
	}
	
	public function getPayResult(){
	   return $this->return_verify();
	}

	/**
	 * 通知验证
	 *
	 * @return bool
	 */
	public function return_verify() {
	  
	    //如果需要用证书加密，使用phpseclib包
	    set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
	   
	    require_once("File/X509.php");	   
		require_once("Crypt/RSA.php");
	   
	    //如果不用证书加密，使用php_rsa.php函数
	    require_once(dirname(__FILE__)."/php_rsa.php");	 
	    
	    //测试商户的key! 请修改。
	    $md5key = $this->key;
	    
	    $merchantId=$_POST["merchantId"];
	    $version=$_POST['version'];
	    $language=$_POST['language'];
	    $signType=$_POST['signType'];
	    $payType=$_POST['payType'];
	    $issuerId=$_POST['issuerId'];
	    $paymentOrderId=$_POST['paymentOrderId'];
	    $orderNo=$_POST['orderNo'];
	    $orderDatetime=$_POST['orderDatetime'];
	    $orderAmount=$_POST['orderAmount'];
	    $payDatetime=$_POST['payDatetime'];
	    $payAmount=$_POST['payAmount'];
	    $ext1=$_POST['ext1'];
	    $ext2=$_POST['ext2'];
	    $payResult=$_POST['payResult'];
	    $errorCode=$_POST['errorCode'];
	    $returnDatetime=$_POST['returnDatetime'];
	    $signMsg=$_POST["signMsg"];
	    //var_dump($_POST);
	    $bufSignSrc="";
	    if($merchantId != "")
	        $bufSignSrc=$bufSignSrc."merchantId=".$merchantId."&";
	    if($version != "")
	        $bufSignSrc=$bufSignSrc."version=".$version."&";
	    if($language != "")
	        $bufSignSrc=$bufSignSrc."language=".$language."&";
	    if($signType != "")
	        $bufSignSrc=$bufSignSrc."signType=".$signType."&";
	    if($payType != "")
	        $bufSignSrc=$bufSignSrc."payType=".$payType."&";
	    if($issuerId != "")
	        $bufSignSrc=$bufSignSrc."issuerId=".$issuerId."&";
	    if($paymentOrderId != "")
	        $bufSignSrc=$bufSignSrc."paymentOrderId=".$paymentOrderId."&";
	    if($orderNo != "")
	        $bufSignSrc=$bufSignSrc."orderNo=".$orderNo."&";
	    if($orderDatetime != "")
	        $bufSignSrc=$bufSignSrc."orderDatetime=".$orderDatetime."&";
	    if($orderAmount != "")
	        $bufSignSrc=$bufSignSrc."orderAmount=".$orderAmount."&";
	    if($payDatetime != "")
	        $bufSignSrc=$bufSignSrc."payDatetime=".$payDatetime."&";
	    if($payAmount != "")
	        $bufSignSrc=$bufSignSrc."payAmount=".$payAmount."&";
	    if($ext1 != "")
	        $bufSignSrc=$bufSignSrc."ext1=".$ext1."&";
	    if($ext2 != "")
	        $bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
	    if($payResult != "")
	        $bufSignSrc=$bufSignSrc."payResult=".$payResult."&";
	    if($errorCode != "")
	        $bufSignSrc=$bufSignSrc."errorCode=".$errorCode."&";
	    if($returnDatetime != "")
	        $bufSignSrc=$bufSignSrc."returnDatetime=".$returnDatetime;
	    
	    //验签
	    if($signType == '1')
	    {
	        /*
	         //解析publickey.txt文本获取公钥信息
	    
	         $publickeyfile = './publickey.txt';
	         $publickeycontent = file_get_contents($publickeyfile);
	    
	         $publickeyarray = explode(PHP_EOL, $publickeycontent);
	         $publickey_arr = explode('=',$publickeyarray[0]);
	         $modulus_arr = explode('=',$publickeyarray[1]);
	         $publickey = trim($publickey_arr[1]);
	         $modulus = trim($modulus_arr[1]);
	         $keylength = 1024;
	         //验签结果
	         $verifyResult = rsa_verify($bufSignSrc,$signMsg, $publickey, $modulus, $keylength,"sha1");
	         */
	        //解析证书方式
	        $certfile = file_get_contents('TLCert-test.cer');
	        $x509 = new File_X509();
	        $cert = $x509->loadX509($certfile);
	        $pubkey = $x509->getPublicKey();
	        $rsa = new Crypt_RSA();
	        $rsa->loadKey($pubkey); // public key
	        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
	        $verifyResult = $rsa->verify($bufSignSrc, base64_decode(trim($signMsg)));
	        $verify_Result = null;
	        $pay_Result = null;
	        if($verifyResult){
	            $verify_Result = "报文验签成功!";
	            if($payResult == 1){
	                $pay_Result = "订单支付成功!";
	            }else{
	                $pay_Result = "订单支付失败!";
	            }
	        }else{
	            $verify_Result = "报文验签失败!";
	            $pay_Result = "因报文验签失败，订单支付失败!";
	        }
	    }
	    
	    //signType 0 验签
	    
	    if($payResult == 1)
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	    
	   
	}
	
}