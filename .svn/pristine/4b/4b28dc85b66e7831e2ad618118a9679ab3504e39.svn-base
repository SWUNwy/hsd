<?php
/**
 * 微信管理
 *
 *
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class allinpay_customsModel extends Model{

	/**
	 *通联网关地址
	 */
	private $serverUrl = 'http://ceshi.allinpay.com/bizweb/index.do';   //测试环境
	//private $serverUrl = 'https://service.allinpay.com/bizweb/index.do';   //正式环境	
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
	private $merchantId = '100020160720001';
	//private $merchantId = '109310231701001';
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

    private $order_sn;
    /**
     * 订单类型
     * @var unknown
     */
    private $order_type;
    public function getCustomsUrl($order_info){
    	$xml = $this->_getXml($order_info);
    	$xml = $this->trimall($xml);
    	$signMsg = md5($xml."<key>".$this->key."</key>");
    	$xml = "<body>{$xml}<signMsg>".strtoupper($signMsg)."</signMsg></body>";
    	$result = $this->xmlPost($xml);
    	$result = $this->xml_to_array(base64_decode($result));
    	return $this->validation($result);
    }

    private function validation($res){
    	if($res['body']['txInfo']['retCode'] == "0000" && $res['body']['txInfo']['retMsg'] == "报关信息提交成功" ){
    		 $result['flag'] = 1;
    	}else{
    		 $result['flag'] = 0;
    	}
    	return $result;
    }

    private function _getXml($order_info){
    	$model_setting = Model('setting');
    	$this->order_sn = date("YmdHis",time());
		$list_setting = $model_setting->getListSetting();
    	$xml = "<txInfo>
				    <merchantId>". $this->merchantId."</merchantId>
				    <version>v5.2</version>
				    <payType>31</payType>
				    <signType>0</signType>
				    <charset>1</charset>
				    <orderNo>".$this->order_sn."</orderNo>
				    <orderDatetime>".$this->order_sn."</orderDatetime>
				    <customsInfo>
				      <CUSTOMS_TYPE>HG016</CUSTOMS_TYPE>
				      <ESHOP_ENT_CODE>".$list_setting['hg_user']."</ESHOP_ENT_CODE>
				      <ESHOP_ENT_NAME>".$list_setting['hg_qyname']."</ESHOP_ENT_NAME>
				      <BIZ_TYPE_CODE>I20</BIZ_TYPE_CODE>
				      <TOTAL_FEE>".($order_info['order_amount']*100)."</TOTAL_FEE>
				      <GOODS_FEE>".($order_info['goods_amount']*100)."</GOODS_FEE>
				      <TAX_FEE>".($order_info['order_tax']*100)."</TAX_FEE>
				      <FREIGHT_FEE>0</FREIGHT_FEE>
				      <OTHER_FEE>0</OTHER_FEE>
				      <ORIGINAL_ORDER_NO>".$order_info['order_sn']."</ORIGINAL_ORDER_NO>
				      <CURRENCY>156</CURRENCY>
				      <PAY_TIME>".$this->order_sn."</PAY_TIME>
				      <PAYER_NAME>". $order_info['extend_order_common']['reciver_name']."</PAYER_NAME>
				      <PAPER_TYPE>01</PAPER_TYPE>
				      <PAPER_NUMBER>". $order_info['extend_order_common']['reciver_info']['member_idcard']."</PAPER_NUMBER>
				      <MEMO>".$this->order_sn."</MEMO>
				    </customsInfo>
				  </txInfo>";
		return $xml;
    }

    private function trimall($str){
	    $qian=array(" ","　","\t","\n","\r");
	    return str_replace($qian, '', $str);   
	}

	private function xmlPost($xml_data){
		 $url = $this->serverUrl. "?verificationText=".urlencode(base64_encode($xml_data));
		 //$xml_data = "verificationText=".base64_encode($xml_data);
 		 $ch = curl_init($url);
		 curl_setopt($ch, CURLOPT_TIMEOUT,3);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, "");
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 $output = curl_exec($ch);
		 curl_close($ch);
		 return  $output;
	}

	/**
	 * [xml_to_array description]
	 * @param  [type] $xml [description]
	 * @return [type]      [description]
	 */
	private function xml_to_array( $xml ){
		$reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches))
		{
			$count = count($matches[0]);
			$arr = array();
			for($i = 0; $i < $count; $i++)
			{
			$key= $matches[1][$i];
			$val =$this->xml_to_array( $matches[2][$i] );
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
}