<?php
/**
 * 海关报文模型
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class datamessageModel extends Model {
	private $model_hgdata;
	public function __construct()
	{
		//$this->model_hgdata = Model("hgdata");
		$this->model_hgdata = Model("hggmdata");
	}

	/**
	 * 取圆通运单号
	 * @param [type] $arr [description]
	 */
	public function GetYtoBill($order)
	{
		$xml_data = $this->taoBody($order,5);
		$res = $this->postTao($xml_data,1);  	
		$res = json_decode($res,true);		
		if($res['result'])
		{
			return $res['data']['code'];
		}  		
	}

	/**
	 * 取邮政运单号
	 */
	public function GetEmsBill($city)
	{
		
		$type=1;
		if($city!="" && strstr($city, "重庆"))
		{
			$type=1;
		}
		else
		{
			$type=4;
		}	
		$xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
		<XMLInfo>
		<sysAccount>50010601256900</sysAccount>
		<passWord>".md5("123456")."</passWord>
		<appKey></appKey>
		<businessType>".$type."</businessType>
		<billNoAmount>1</billNoAmount>
		</XMLInfo>";
		$xml=urlencode(base64_encode($xml));	
		$result=$this->get_getData("http://os.ems.com.cn:8081/zkweb/bigaccount/getBigAccountDataAction.do?method=getBillNumBySys&xml=".$xml);	
		$resultxml=urldecode(base64_decode($result));	
		$billno=$this->xml_to_array1($resultxml);
		//print_r($billno);	
		if(!empty($billno))
		{
			$billno=$billno['response']['assignIds']['assignId']['billno'];
		}

		return $billno;
	}

public function emspost($city)
{
	return ;
	$type=1;
	if($city!="" && strstr($city, "重庆"))
	{
		$type=1;
	}
	else
	{
		$type=4;
	}
	
	$xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<XMLInfo>
	<sysAccount>50010601256900</sysAccount>
	<passWord>".md5("123456")."</passWord>
	<appKey></appKey>
	<businessType>".$type."</businessType>
	<billNoAmount>1</billNoAmount>
	</XMLInfo>";
	$xml=urlencode(base64_encode($xml));
	
	$result=$this->get_getData("http://os.ems.com.cn:8081/zkweb/bigaccount/getBigAccountDataAction.do?method=getBillNumBySys&xml=".$xml);	
	$resultxml=urldecode(base64_decode($result));
	
	$billno=$this->xml_to_array1($resultxml);
	//print_r($billno);
	
	if(!empty($billno))
	{
		$billno=$billno['response']['assignIds']['assignId']['billno'];
	}

	return $billno;
	
}

//xml转数组
public function xml_to_array1( $xml )
{
    $reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
    if(preg_match_all($reg, $xml, $matches))
    {
        $count = count($matches[0]);
        $arr = array();
        for($i = 0; $i < $count; $i++)
        {
            $key= $matches[1][$i];
            $val = $this->xml_to_array1( $matches[2][$i] );  // 递归
            if(array_key_exists($key, $arr))
            {
                if(is_array($arr[$key]))
                {
                    if(!array_key_exists(0,$arr[$key]))
                    {
                        $arr[$key] = array($arr[$key]);
                    }
                }else{
                    $arr[$key] = array($arr[$key]);
                }
                $arr[$key][] = $val;
            }else{
                $arr[$key] = $val;
            }
        }
        return $arr;
    }else{
        return $xml;
    }
}



//ems接收电商信息
public function cqemsbusiness($order)
{
	
	$type=1;
	if($city!="" && strstr($order['extend_order_common']['reciver_info']['address'], "重庆"))
	{
		$type=1;
	}
	else
	{
		$type=4;
	}
	$order_num=0;
	if (!empty($order['extend_order_goods'])){
	        	foreach ($order['extend_order_goods'] as $k => $v){
				$order_num=	$order_num+$v['goods_num']; 
		}
			
	}
	$model_setting = Model('setting');
	$list_setting = $model_setting->getListSetting();

		$xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
		<NewDataSet>
		<EMS_DS_TMP>
		<EMS_CODE>50010601256900</EMS_CODE>
		<BUSINESSTYPE>".$type."</BUSINESSTYPE>
		<ORIGINAL_ORDER_NO>".$order['order_sn']."</ORIGINAL_ORDER_NO>
		<BIZ_TYPE_CODE>I20</BIZ_TYPE_CODE>
		<BIZ_TYPE_NAME>保税进口</BIZ_TYPE_NAME>
		<TRANSPORT_BILL_NO>".$order['shipping_code']."</TRANSPORT_BILL_NO>
		<ESHOP_ENT_CODE>".$list_setting['hg_user']."</ESHOP_ENT_CODE>
		<ESHOP_ENT_NAME>".$list_setting['hg_qyname']."</ESHOP_ENT_NAME>
		<QTY>".$order_num."</QTY>
		<RECEIVER_ID_NO>".trim($order['extend_order_common']['reciver_info']['member_idcard'])."</RECEIVER_ID_NO>
		<RECEIVER_NAME>".trim($order['extend_order_common']['reciver_name'])."</RECEIVER_NAME>
		<RECEIVER_ADDRESS>".preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$order['extend_order_common']['reciver_info']['address'])."</RECEIVER_ADDRESS>
		<RECEIVER_TEL>".trim($order['extend_order_common']['reciver_info']['phone'])."</RECEIVER_TEL>
		</EMS_DS_TMP>
		</NewDataSet>";

		
		
	
		$url = "http://115.28.134.167/cqemsbusiness.asmx?wsdl";
		$r=$this->checkUrl($url);
		if(!$r)
		{
			return false;
		}
     	$client = new SoapClient($url);		
    	$xml=urlencode(base64_encode($xml));
  		$param_ary = array(array("xmlstring"=>$xml,"emscode"=>"50010601256900"));
		$ret=$client->__soapCall("cqems_electronic_business_all",$param_ary);
		$ret=$this->object_array($ret);
		if(!empty($ret))
		{
	 		 $ret=$ret['cqems_electronic_business_allResult'];
		}
		
	
		return $ret;
		
		
	
}



function checkUrl($url, $timeout = 3){
	$ret = false;
	$handle = curl_init();
	curl_setopt($handle, CURLOPT_URL,$url);
	curl_setopt($handle, CURLOPT_NOBODY, true);
	curl_setopt($handle, CURLOPT_TIMEOUT,$timeout);//设置默认超时时间为3秒
	$result = curl_exec($handle);
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	curl_close($handle);
	if(strpos($httpCode,'2') == 0){
		$ret = true;
	}
	return $ret;
}
//ems操作
public function emsoption($order_sn,$type)
{
	
	
	$url = "http://115.28.134.167/cqemsbusiness.asmx?wsdl";
    $client = new SoapClient($url);	
	$param_ary = array(array("ORIGINAL_ORDER_NO"=>$order_sn,"emscode"=>"50010601256900"));

	
	//取消申报 cancel
	if($type=="cancel")
	{
		$ret=$client->__soapCall("cqems_del",$param_ary);
	}//获取申报状态
	else if($type="get")
	{
		$ret=$client->__soapCall("cqems_type",$param_ary);
	}

	$ret=$this->object_array($ret);	
	return $ret;
}

public function get_getData($URL)
{
	
$r=$this->checkUrl($URL);
if(!$r)
{
	return "连接超时，请一会重试";
}	
	
$ch = curl_init($URL) ;
curl_setopt($ch, CURLOPT_TIMEOUT,3);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
$output = curl_exec($ch) ;
//fclose($fp) ;
return $output;
}


	//post提交
public function datapost($xml_data)
{
	
 $model_setting = Model('setting');
 $list_setting = $model_setting->getListSetting();

 $xml_data="data=".urlencode(base64_encode($xml_data));
 $URL= $list_setting['hg_url'];

 $r=$this->checkUrl($URL);
 if(!$r)
 {
 	return "连接超时，请一会重试";
 }
 
 
 $ch = curl_init($URL);
 curl_setopt($ch, CURLOPT_TIMEOUT,3);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $output = curl_exec($ch);

 curl_close($ch);
 return  $output;
}
//postea
public function eapost($xml_data)
{
	
	//测试平台
   //$wsdl = "http://test.eascs.com:7025/easd/webservice/WebServiceEA.jws?wsdl";
    //正式平台
   $wsdl = "http://eagd.eascs.com:7001/easd/webservice/WebServiceEA.jws?wsdl";
   
	

   $client = new SoapClient($wsdl);
   
   
   $xml=$this->eaxml($xml_data);

   return  $ret = $client->GetPoForOutXmlService($xml);
   
   
   
}

//清单生成XML
public function arraytolistxml($array,$level = 0)
{	
	$return = $this->model_hgdata->xmlHead("LIST_INFO","1");
	$return .= $this->model_hgdata->xmlBody($array,5);
	$this->model_hgdata->WriteLog($array['order_sn'],$return,3);
    return $return;
}

//订单生成XML
public function arraytoxml($array,$level = 0)
{	
    $return = $this->model_hgdata->xmlHead("ORDER_INFO","1");
    $return .= $this->model_hgdata->xmlBody($array,1);  
    $this->model_hgdata->WriteLog($array['order_sn'],$return,1);  
    return $return;
}

//支付单生成XML
public function arraytopayxml($array,$level = 0)
{
    $return = $this->model_hgdata->xmlHead("PAYMENT_INFO","1");
    $return .= $this->model_hgdata->xmlBody($array,2);
    $this->model_hgdata->WriteLog($array['order_sn'],$return,2);
    return $return;
}

//退货生成XML
public function arraytotuihuoxml($array,$level = 0)
{	
    $return = $this->model_hgdata->xmlHead("ORDER_RETURN_INFO","1");
    $return .= $this->model_hgdata->xmlBody($array,3);
    $this->model_hgdata->WriteLog($array['order_sn'],$return,5);
    return $return;
}

//商品生成XML
public function arraytogoodsxml($array,$level = 0)
{
    $return =$this->model_hgdata->xmlHead("SKU_INFO","1");
    $return .= $this->model_hgdata->xmlGoodsBody($array,1);
    $this->model_hgdata->WriteLog($array['order_sn'],$return,6);
    return $return;
}
	
//运单号生成XML
public function arraytoemsxml($array,$level = 0)
{	
    //$return = $this->model_hgdata->xmlHead("ORDER_SET_TRANSPORT_NO","1");
    $return .= $this->model_hgdata->xmlBody($array,4);
    $this->model_hgdata->WriteLog($array['order_sn'],$return,4);
    return $return;
}
	
//运单号生成XML
public function arraytoemsxml1($array,$level = 0)
{	
    $return = $this->model_hgdata->xmlHead("BILL_INFO","1");
    $return .= $this->model_hgdata->xmlBody($array,6);
    $this->model_hgdata->WriteLog($array['order_sn'],$return,4);
    return $return;
}

//淘宝仓内容
public function taoBody($arr,$type)
{
	
	$model_goods = Model('goods');
	//$model_hgdata = Model("hgdata");
	$datas = $this->model_hgdata->taoBody($arr,$type);
	
	return $datas;
	//1.商品入库，2.提交订单，3.取运单号，4.取消订单
	if($type=="" || empty($arr))
	{
		return "类型和内容不能为空";
	}
	else if($type==1)
	{
				
	}
	else if($type==2)
	{
		
		foreach($arr['extend_order_goods'] as $k=>$v){			
			
			$model_tax = Model('tax');
			$model_goods_record = Model('goods_record');
			
			$goods_info = $model_goods->getGoodsInfo(array('goods_id' => $v['goods_id']));
			$goods_comman_info = $model_goods->getGoodeCommonInfo(array('goods_commonid' => $goods_info['goods_commonid']));
			$goods_record=$model_goods_record->getGoodsRecord(array('goods_serial'=>$goods_info['goods_serial']));
			$tax_info=$model_tax->getTaxInfo(array('tax_no'=>$goods_record['goods_tax_no']));
			
			//$tax_info=$model_tax->getTaxInfo(array('tax_no'=>$goods_comman_info['goods_tax_no']));
			
			
			
			if($arr['order_tax']>50)
			{
				$v['goods_pay_price']=$v['goods_pay_price']-$v['goods_tax'];
			}
			if($v['goods_tax']==0)
			{
				$v['goods_tax']=$v['goods_pay_price']*$tax_info['tax_rate'];
			}
			if($v['goods_tax']==0)
			{
				return ;
			}
			//判断是否几罐组合
			
			if($goods_info["goods_spec"]!="N;")
			//取标题中的数字
			{
				$arr1 = unserialize($goods_info["goods_spec"]);
				$str=end($arr1);
				$mynum=$this->findNum($str);
				if($mynum==0)
	            {
	                $mynum=1;
	            }
				$v['goods_num']=$v['goods_num']*$mynum;
			}
			if($v['goods_num']>10)
			{
				echo "数量！";
				exit();
			}
			
			if($goods_info['goods_groupprice']>0)
			{
				$goods_info['goods_price']=$goods_info['goods_groupprice'];
			}
			
			$goodsarr[$k]['SKU']=$goods_info['goods_serial'];
			$goodsarr[$k]['QTY']=$v['goods_num'];
			$goodsarr[$k]['GOODS_FEE']=$v['goods_pay_price'];
			$goodsarr[$k]['TAX_FEE']=number_format($v['goods_tax'],2);
		}
		
		
		
		$address=explode("	",$arr['extend_order_common']['reciver_info']['address']);

		if($address[2]=="")
		{
			$address=explode(" ",$arr['extend_order_common']['reciver_info']['address']);
		}		
		
		$address[2]=explode(" ",$address[2]);		
		$address[2][0]=preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","*",$address[2][0]);
		$address[2]=explode("*",$address[2][0]);
	
		$myaddress =$address[2][1];
		if($myaddress=="" && $address[2]!="")
		{
			$myaddress=$address[3];
		}
		
		if($arr['order_tax']>50)
		{
			$fee=$arr['order_tax'];
			$arr['order_amount']=$arr['order_amount']-$arr['order_tax'];
		}
		else
		{
			$fee=0;
		}
		
		$shipping_express_id=$arr['extend_order_common']['shipping_express_id'];	
		$datas = array(
				'time' => date('Y-m-d H:i:s',time()),
				'method' => 'order.out',
				'dhfcode' => "D00023" ,
				'CUSTOMS_CODE' => 8013,
				'ORIGINAL_ORDER_NO' => $arr['order_sn'],
				'DESP_ARRI_COUNTRY_CODE' => "142",
				'SHIP_TOOL_CODE' => "1",
				'receiver_id_no' => trim($arr['extend_order_common']['reciver_info']['member_idcard']),
				'receiver_name' =>  trim($arr['extend_order_common']['reciver_name']),
				//'receiver_address' => preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$arr['extend_order_common']['reciver_info']['address']),
				'receiver_address' => preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$myaddress),
				'receiver_mobile' => trim($arr['extend_order_common']['reciver_info']['phone']),
				'receiver_city' => $address[1],
				'receiver_state' => $address[0],
				'receiver_district' =>$address[2][0],
				'GOODS_FEE' => $arr['order_amount'],
				'TAX_FEE' => $fee,
				'SORTLINE_ID' =>50050 ,
				'BAR_CODE' => $arr['code'],
				'PUSH_HG'  => 'no',
				'CHECK_TYPE' =>'p',
				
	 
		);
		if($shipping_express_id==8)
		{
			$datas['MAILTYPE']="EMS";
			$datas['MAILCODE']=$arr['shipping_code'];
		}
		//生成签名
		
		$datas['sign']=$this->sign($datas);
		$datas['suborders']= $goodsarr;
		
	//print_r($datas);
	//exit();
	}
	else if($type==3)
	{
		$datas = array(
				'time' => date('Y-m-d H:i:s',time()),
				'method' => 'order.wlinfo',
				'dhfcode' => "D00023" ,
				'ORIGINAL_ORDER_NO' =>  $arr['order_sn'],
				
	
		);
		$datas['sign']=$this->sign($datas);
	}
	
	else if($type==4)
	{
		$datas = array(
				'time' => date('Y-m-d H:i:s',time()),
				'method' => 'order.cancle',
				'dhfcode' => "D00023" ,
				'ORIGINAL_ORDER_NO' => $arr['order_amount'],				
	
		);
		$datas['sign']=$this->sign($datas);
	}
	$this->model_hgdata->WriteLog($arr,$datas,6);	
	return $datas;
}

//提交到淘宝仓
public function postTao($datas,$type=1)
{	
	//$model_hgdata = Model("hgdata");
	$output = $this->model_hgdata->postTao($datas,$type=1);
	return  $output;	
}

function postTao1($datas,$type=1) {
	
	//$url="http://cqtest.dhfeng.com/exapi/rest/";
	$url="http://kj.dhfeng.com/exapi/rest/";
	$temps = array();
	
	 
	if($type)
	{
		$post_data=http_build_query($datas);
	}
	else
	{
		foreach ($datas as $key => $value) {
			$temps[] = sprintf('%s=%s', $key, $value);
		}
		
		$post_data = implode('&', $temps);
		
	}
	

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
	
	$file = fopen("2.txt","w+");
	fwrite($file,$gets);
	fclose($file);
	return  $gets;
}


	
//XML头部
public function xmlHead($messagetype,$actiontype)
{
	
	$model_setting = Model('setting');
	$list_setting = $model_setting->getListSetting();
	
	$guid=$this->uuid();
	if($messagetype=="SKU_INFO")
	{
	$return = "<DTC_Message>
	<MessageHead>
    <MessageType>".$messagetype."</MessageType>
    <MessageId>".$guid."</MessageId>
    <ActionType>".$actiontype."</ActionType>
	<MessageTime>".date("Y-m-d H:i:s",time())."</MessageTime>
    <SenderId>".$list_setting['hg_user']."</SenderId>
    <ReceiverId>CQITC</ReceiverId>
    <UserNo>".$list_setting['hg_user']."</UserNo>
    <Password>".md5($guid.$list_setting['hg_pwd'])."</Password>
  </MessageHead>";
	}
	else
	{
	$return = "<DTC_Message>
	<MessageHead>
    <MessageType>".$messagetype."</MessageType>
    <MessageId>".$guid."</MessageId>
    <ActionType>".$actiontype."</ActionType>
	<MessageTime>".date("Y-m-d H:i:s",time())."</MessageTime>
    <SenderId>".$list_setting['hg_user']."</SenderId>
    <ReceiverId>CQITC</ReceiverId>
    <SenderAddress />
    <ReceiverAddress />
    <PlatFormNo />
    <CustomCode />
    <SeqNo />
    <Note />
    <UserNo>".$list_setting['hg_user']."</UserNo>
    <Password>".md5($guid.$list_setting['hg_pwd'])."</Password>
  </MessageHead>";
	}
  return $return;
}

//XML订单和支付单内容
public function xmlBody($order,$type)
{

	
	$model_setting = Model('setting');
	$list_setting = $model_setting->getListSetting();
    $model_goods = Model('goods');

    $alltax=0;
    //税金总和
    foreach($order['extend_order_goods'] as $v){
    	$alltax=$alltax+$v['goods_tax'];
    }	

    
    if($order['order_tax']>50 && intval($order['order_tax'])!=intval($alltax))
    {
    
    	echo "税金出错了，请联系写代码的!";
    	exit();
    }
	//type类型1是订单，2是支付单 ，3退货  4运单号
	
	
	if($type==1)
    {
	
    	
	  //$order['order_amount']=$order['order_amount']-$order['shipping_fee'];
	   if($order['order_tax']>50)
	    {
		  $fee=$order['order_tax'];
		  $order['order_amount']=$order['order_amount']-$order['order_tax'];
		}
		else
	    {
		  	$fee=0;
		}	
		
	//判断验证类型R:收货人 P:支付人
	
	
	$return = "<MessageBody>
     <DTCFlow>
      <ORDER_HEAD>
        <CUSTOMS_CODE>8013</CUSTOMS_CODE>
        <BIZ_TYPE_CODE>I20</BIZ_TYPE_CODE>
        <ORIGINAL_ORDER_NO>".$order['order_sn']."</ORIGINAL_ORDER_NO>
        <ESHOP_ENT_CODE>".$list_setting['hg_user']."</ESHOP_ENT_CODE>
        <ESHOP_ENT_NAME>".$list_setting['hg_qyname']."</ESHOP_ENT_NAME>
        <DESP_ARRI_COUNTRY_CODE>142</DESP_ARRI_COUNTRY_CODE>
        <SHIP_TOOL_CODE>Y</SHIP_TOOL_CODE>
        <RECEIVER_ID_NO>".trim($order['extend_order_common']['reciver_info']['member_idcard'])."</RECEIVER_ID_NO>
        <RECEIVER_NAME>".trim($order['extend_order_common']['reciver_name'])."</RECEIVER_NAME>
        <RECEIVER_ADDRESS>".preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$order['extend_order_common']['reciver_info']['address'])."</RECEIVER_ADDRESS>
        <RECEIVER_TEL>".trim($order['extend_order_common']['reciver_info']['phone'])."</RECEIVER_TEL>
        <GOODS_FEE>".$order['order_amount']."</GOODS_FEE>
        <TAX_FEE>".$fee."</TAX_FEE>
		<SORTLINE_ID>SORTLINE02</SORTLINE_ID>
        <TRANSPORT_FEE>".$order['shipping_fee']."</TRANSPORT_FEE>
        <CHECK_TYPE>".$list_setting['hg_type']."</CHECK_TYPE>
        <PROXY_ENT_CODE />
        <PROXY_ENT_NAME />";
	
	
		foreach($order['extend_order_goods'] as $v){
			
	   	//获得税率
		$model_tax = Model('tax');
		$model_goods_record = Model('goods_record');
		
		$goods_info = $model_goods->getGoodsInfo(array('goods_id' => $v['goods_id']));
		$goods_comman_info = $model_goods->getGoodeCommonInfo(array('goods_commonid' => $goods_info['goods_commonid']));
		$goods_record=$model_goods_record->getGoodsRecord(array('goods_serial'=>$goods_info['goods_serial']));
		$tax_info=$model_tax->getTaxInfo(array('tax_no'=>$goods_record['goods_tax_no']));
		
		//$tax_info=$model_tax->getTaxInfo(array('tax_no'=>$goods_comman_info['goods_tax_no']));
		
		
		
		if($order['order_tax']>50)
	    {
		   $v['goods_pay_price']=$v['goods_pay_price']-$v['goods_tax'];
		}
		if($v['goods_tax']==0)
		{
			$v['goods_tax']=$v['goods_pay_price']*$tax_info['tax_rate'];
		}
		if($v['goods_tax']==0) 
		{
			return ;
		}
		//判断是否几罐组合
		
		if($goods_info["goods_spec"]!="N;")
		//取标题中的数字
		{
			$arr = unserialize($goods_info["goods_spec"]);
			$str=end($arr);
			$mynum=$this->findNum($str);
			if($mynum==0)
            {
                $mynum=1;
            }
			$v['goods_num']=$v['goods_num']*$mynum;



		}
		if($v['goods_num']>10)
		{
			echo "数量！";
			exit();
		}
		 
		
		if($goods_info['goods_groupprice']>0)
		{
			$goods_info['goods_price']=$goods_info['goods_groupprice'];
		}
	
        $return.="
		   <ORDER_DETAIL>
          <SKU>".$goods_info['goods_serial']."</SKU>
          <GOODS_SPEC>".$v['goods_name']."</GOODS_SPEC>
          <CURRENCY_CODE>142</CURRENCY_CODE>
          <PRICE>".sprintf("%.2f", $v['goods_pay_price']/$v['goods_num'])."</PRICE>
          <QTY>".$v['goods_num']."</QTY>
          <GOODS_FEE>".$v['goods_pay_price']."</GOODS_FEE>
          <TAX_FEE>".number_format($v['goods_tax'],2)."</TAX_FEE>
        </ORDER_DETAIL>";
      
		}
	  
	  
     $return.="</ORDER_HEAD>
	 </DTCFlow>
  </MessageBody>
  </DTC_Message>";
     

	}
  if($type==2)
  {
	    //$order['order_amount']=$order['order_amount']-$order['shipping_fee'];
       
	   if($order['order_tax']>50)
	    {
		 
		  $fee=$order['order_tax'];
  		  $order['order_amount']=$order['order_amount']-$order['order_tax'];
		}
		else
	    {
		  	$fee=0;
		}	
	
	   
	  $return = " <MessageBody>
    <DTCFlow>
      <PAYMENT_INFO>
        <CUSTOMS_CODE>8013</CUSTOMS_CODE>
        <BIZ_TYPE_CODE>I20</BIZ_TYPE_CODE>
        <ESHOP_ENT_CODE>".$list_setting['hg_user']."</ESHOP_ENT_CODE>
        <ESHOP_ENT_NAME>".$list_setting['hg_qyname']."</ESHOP_ENT_NAME>
        <PAYMENT_ENT_CODE>".$list_setting['hg_user']."</PAYMENT_ENT_CODE>
        <PAYMENT_ENT_NAME>".$list_setting['hg_qyname']."</PAYMENT_ENT_NAME>
        <PAYMENT_NO>".$order['pay_sn']."</PAYMENT_NO>
        <ORIGINAL_ORDER_NO>".$order['order_sn']."</ORIGINAL_ORDER_NO>
        <PAY_AMOUNT>".$order['order_amount']."</PAY_AMOUNT>
        <GOODS_FEE>".$order['order_amount']."</GOODS_FEE>
        <TAX_FEE>".$fee."</TAX_FEE>
        <CURRENCY_CODE>142</CURRENCY_CODE>
        <MEMO />
      </PAYMENT_INFO>
    </DTCFlow>
  </MessageBody>
  </DTC_Message>
  ";
	  
	  
	  
  }
  
  if($type==3)
  {
	  

  $return = "  <MessageBody>
    <DTCFlow>
      <ORDER_RETURN_INFO>
        <ORIGINAL_ORDER_NO>".$order['order_sn']."</ORIGINAL_ORDER_NO>
        <ESHOP_ENT_CODE>".$list_setting['hg_user']."</ESHOP_ENT_CODE>
        <RETURN_REASON>拍错</RETURN_REASON>
        <QUALITY_REPORT />
      </ORDER_RETURN_INFO>
    </DTCFlow>
  </MessageBody>
   </DTC_Message>
  ";
	  
	  
	  
  }
  
  if($type==4)
  {
	  
  
  if($order['shipping_code']=="" && $order['extend_order_common']['shipping_express_id']==8)
  {
	   $model_order= Model('order');
	   $model_datamessage= Model('datamessage');
	   $order['shipping_code']=$model_datamessage->emspost($order['extend_order_common']['reciver_info']['address']);
	   $update['shipping_code']=$order['shipping_code'];
	   $update = $model_order->editOrder($update,array('order_sn'=>$order['order_sn']));
  }
  
  $return = "<MessageBody>
    <DTCFlow>
      <ORDER_SET_TRANSPORT_NO>
        <ESHOP_ENT_CODE>".$list_setting['hg_user']."</ESHOP_ENT_CODE>
        <ESHOP_ENT_NAME>".$list_setting['hg_qyname']."</ESHOP_ENT_NAME>
        <ORIGINAL_ORDER_NO>".$order['order_sn']."</ORIGINAL_ORDER_NO>
        <TRANSPORT_BILL_NO>".$order['shipping_code']."</TRANSPORT_BILL_NO>
      </ORDER_SET_TRANSPORT_NO>
    </DTCFlow>
  </MessageBody>
  </DTC_Message>
  ";
	  
	  
	  
  }
  
 
 
  return $return;

}



//XML商品审核内容
public function xmlgoodsBody($goods)
{
	
	
	$model_setting = Model('setting');
	$list_setting = $model_setting->getListSetting();

	if($goods['goods_is_experiment_goods']==0)
	{
		$return = " <MessageBody>
		<DTCFlow>
		  <SKU_INFO>
			<ESHOP_ENT_CODE>".$list_setting['hg_user']."</ESHOP_ENT_CODE>
			<ESHOP_ENT_NAME>".$list_setting['hg_qyname']."</ESHOP_ENT_NAME>
			<SKU>".$goods['goods_serial']."</SKU>
			<GOODS_NAME>".$goods['goods_goods_name']."</GOODS_NAME>
			<GOODS_SPEC>".$goods['goods_goods_spec']."</GOODS_SPEC>
			<DECLARE_UNIT>".$goods['goods_declare_unit_id']."</DECLARE_UNIT>
			<POST_TAX_NO>".$goods['goods_tax_no']."</POST_TAX_NO>
			<LEGAL_UNIT>".$goods['goods_legal_unit_id']."</LEGAL_UNIT>
			<CONV_LEGAL_UNIT_NUM>".$goods['goods_conv_legal_unit_num']."</CONV_LEGAL_UNIT_NUM>
			<HS_CODE>".$goods['goods_sh_code']."</HS_CODE>
			<IN_AREA_UNIT>".$goods['goods_in_area_unit_id']."</IN_AREA_UNIT>
			<CONV_IN_AREA_UNIT_NUM>".$goods['goods_conv_in_area_unit_num']."</CONV_IN_AREA_UNIT_NUM>
		  </SKU_INFO>
		</DTCFlow>
	  </MessageBody>
	</DTC_Message>
	  ";
	}
	else if($goods['goods_is_experiment_goods']==1)
	{
		$return = " <MessageBody>
		<DTCFlow>
		  <SKU_INFO>
			<ESHOP_ENT_CODE>".$list_setting['hg_user']."</ESHOP_ENT_CODE>
			<ESHOP_ENT_NAME>".$list_setting['hg_qyname']."</ESHOP_ENT_NAME>
			<SKU>".$goods['goods_serial']."</SKU>
			<GOODS_NAME>".$goods['goods_goods_name']."</GOODS_NAME>
			<GOODS_SPEC>".$goods['goods_goods_spec']."</GOODS_SPEC>
			<DECLARE_UNIT>".$goods['goods_declare_unit_id']."</DECLARE_UNIT>
			<POST_TAX_NO>".$goods['goods_tax_no']."</POST_TAX_NO>
			<LEGAL_UNIT>".$goods['goods_legal_unit_id']."</LEGAL_UNIT>
			<CONV_LEGAL_UNIT_NUM>".$goods['goods_conv_legal_unit_num']."</CONV_LEGAL_UNIT_NUM>
			<HS_CODE>".$goods['goods_sh_code']."</HS_CODE>
			<IN_AREA_UNIT>".$goods['goods_in_area_unit_id']."</IN_AREA_UNIT>
			<CONV_IN_AREA_UNIT_NUM>".$goods['goods_conv_in_area_unit_num']."</CONV_IN_AREA_UNIT_NUM>
			<IS_EXPERIMENT_GOODS>".$goods['goods_is_experiment_goods']."</IS_EXPERIMENT_GOODS>
			<CHECK_ORG_CODE>".$goods['goods_check_org_code']."</CHECK_ORG_CODE>
			<PRODUCER_NAME>".$goods['goods_producer_name']."</PRODUCER_NAME>
			<ORIGIN_COUNTRY_CODE>".$goods['goods_origin_country_code']."</ORIGIN_COUNTRY_CODE>
			<SUPPLIER_NAME>".$goods['goods_supplier_name']."</SUPPLIER_NAME>
			<IS_CNCA_POR>".$goods['	goods_is_cnca_por']."</IS_CNCA_POR>
			<IS_CNCA_POR_DOC>".$goods['goods_is_cnca_por_doc']."</IS_CNCA_POR_DOC>
			<IS_ORIGIN_PLACE_CERT>".$goods['goods_is_origin_place_cert']."</IS_ORIGIN_PLACE_CERT>
			<IS_TEST_REPORT>".$goods['goods_is_test_report']."</IS_TEST_REPORT>
			<IS_LEGAL_TICKET>".$goods['goods_is_legal_ticket']."</IS_LEGAL_TICKET>
			<IS_MARK_EXCHANGE>".$goods['goods_is_mark_exchange']."</IS_MARK_EXCHANGE>
			<CNCA_POR_DOC>".$this->imagesbs64($goods['goods_is_cnca_por_doc'],$goods['goods_cnca_por_doc'])."</CNCA_POR_DOC>
			<ORIGIN_PLACE_CERT>".$this->imagesbs64($goods['goods_is_origin_place_cert'],$goods['goods_origin_place_cert'])."</ORIGIN_PLACE_CERT>
			<TEST_REPORT>".$this->imagesbs64($goods['goods_is_test_report'],$goods['goods_test_report'])."</TEST_REPORT>
			<LEGAL_TICKET>".$this->imagesbs64($goods['goods_is_legal_ticket'],$goods['goods_legal_ticket'])."</LEGAL_TICKET>
			<MARK_EXCHANGE>".$this->imagesbs64($goods['goods_is_mark_exchange'],$goods['goods_mark_exchange'])."</MARK_EXCHANGE>
	
		  </SKU_INFO>
		</DTCFlow>
	  </MessageBody>
	</DTC_Message>
	  ";
	}

 
  return $return;
 
}


public function imagesbs64($type,$images)
{

	if($type==0)
	{
		return ;
	}

	$img="";
	if($images!="")
	{
		
		$file= realpath(dirname(__FILE__).'/../')."/upload/shop/common/".$images;		
		$fp=fopen($file,"rb");
		//$data=base64_encode(fread($fp,filesize($file)));
		$data=fread($fp,filesize($file));
	    
		/**$type=getimagesize($file);//取得图片的大小，类型等
		$fp=fopen($file,"r")or die("Can't open file");
		$file_content=chunk_split(base64_encode(fread($fp,filesize($file))));//base64编码
		switch($type[2]){//判读图片类型
			case 1:$img_type="gif";break;
			case 2:$img_type="jpg";break;
			case 3:$img_type="png";break;
		}
		$img='data:image/'.$img_type.';base64,'.$file_content;//合成图片的base64编码
		fclose($fp);	**/
		$img=bin2hex($data);
		//$img=$data;

	}

	return $img;
}



//ea

public function  eaxml($order)
{	
  $str=$order['extend_order_common']['reciver_info']['address'];
  $arry=preg_split("/[\s]+/",$str);


  
  $city=$arry[0];

  $model_goods = Model('goods');

 
  $return = "<polist>
  <fbtype>GETPO</fbtype>
  <shiptocode>C14.09032</shiptocode>
  <pos>
    <po>
      <pocode>".$order['order_sn']."</pocode>
      <podate>".date("Y-m-d",time())."</podate>
      <shiptoname>".$order['extend_order_common']['reciver_name']."</shiptoname>
      <mobile>".$order['extend_order_common']['reciver_info']['phone']."</mobile>
      <tel></tel>
      <city>".$city."</city>
      <address>".preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$order['extend_order_common']['reciver_info']['address'])."</address>
      <remark1></remark1>
      <remark2></remark2>
      <expresscompany>EMS</expresscompany>
      <expresscode>".$order['shipping_code']."</expresscode>
      <buyerid>".$order['buyer_name']."</buyerid>
      <customcode>".$order['code']."</customcode>


      <pols>";
		
		
		foreach($order['extend_order_goods'] as $v){
	
	
		$goods_info = $model_goods->getGoodsInfo(array('goods_id' => $v['goods_id']));
		$goodscommon_info = $model_goods->getGoodeCommonInfo(array('goods_commonid' => $getGoodsInfo['goods_commonid']));
		if($goodscommon_info['goods_goods_name']!=null)
		{
			$goods_name=$goodscommon_info['goods_goods_name'];   
		}
		else
		{
			$goods_name=$goods_info['goods_name'];
		}
		
		$return.=" <pol>
          <shopid>C14.09032</shopid>
          <shopname>千牛国际贸易</shopname>
          <goodsid></goodsid>
          <barcode>".$goods_info['goods_serial']."</barcode>
          <goodsname>".$goods_name."</goodsname>
          <qty>".$v['goods_num']."</qty>
          <price>".$v['goods_price']."</price>
          <unitname></unitname>
        </pol>";
			

		}
	  
	  
     $return.="
	  </pols>
    </po>
  </pos>
</polist>
  ";
  
  return  $return;
}



public function  getstl()
{	
 
 
 
  $xml = "<stlinfo>
			<fbtype>GETSTL</fbtype>
			<ccode>D165A.Q9</ccode>
			<showp>B</showp>
		</stlinfo>";
   $wsdl = "http://eagd.eascs.com:7001/easd/webservice/WebServiceEA.jws?wsdl";
   $client = new SoapClient($wsdl);
   return  $ret = $client->GetStlXmlService($xml);
   

  
}






public function uuid($prefix = '')  
  {  
    $chars = md5(uniqid(mt_rand(), true));  
    $uuid  = substr($chars,0,8) . '-';  
    $uuid .= substr($chars,8,4) . '-';  
    $uuid .= substr($chars,12,4) . '-';  
    $uuid .= substr($chars,16,4) . '-';  
    $uuid .= substr($chars,20,12);  
    return $prefix . $uuid;  
  }    


                                                         
public function xml_to_array($xml)                              
{                                                        
  $array = (array)(simplexml_load_string($xml));         
  foreach ($array as $key=>$item){                       
    $array[$key]  =  $this->struct_to_array((array)$item);      
  }                                                      
  return $array;                                         
}                                                        
public function struct_to_array($item) {                        
  if(!is_string($item)) {                                
    $item = (array)$item;                                
    foreach ($item as $key=>$val){                       
      $item[$key]  =  $this->struct_to_array($val);             
    }                                                    
  }                                                      
  return $item;                                          
}                   

public function object_array($array) {  
    if(is_object($array)) {  
        $array = (array)$array;  
     } if(is_array($array)) {  
         foreach($array as $key=>$value) {  
             $array[$key] = $this->object_array($value);  
             }  
     }  
     return $array;  
}
//提交淘宝仓签名
public function sign($post)
{
	foreach ($post as $k=>$v)
	{
		if ($k!='sign')
		{
			$p[$k]=$v;
		}
	}
	ksort($p);
	$s='';

	foreach ($p as $k=>$v)
	{
		$s.=$k.$v;
	}

	return md5("ae55d6f458fc96dbbcefdb5cb0a2dc05" . $s. "ae55d6f458fc96dbbcefdb5cb0a2dc05");
}

//取标题中的数字
function findNum($str=''){
	$str=trim($str);
	if(empty($str)){return '';}
	$temp=array('1','2','3','4','5','6','7','8','9','0');
	$result='';
	for($i=0;$i<strlen($str);$i++){
		if(in_array($str[$i],$temp)){
			$result.=$str[$i];
		}
	}
	if($result==0 )
	{
		$result=1;
	}
	return $result;
}
}