<?php
/* *
 * 功能：报关接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */

class alipayapi{
	
	
	
	function submit($param)
	{		
			require_once("alipay.config.php");
			require_once("lib/alipay_submit.class.php");
		
	/**************************请求参数**************************/
	       
			
	        //报关流水号	
	        $out_request_no = $param['WIDout_request_no'];
	        //支付宝交易号
	
	        $trade_no = $param['WIDtrade_no'];
	        //商户海关备案编号
	
	        $merchant_customs_code = $param['WIDmerchant_customs_code'];
	        //商户海关备案名称
	
	        $merchant_customs_name = $param['WIDmerchant_customs_name'];
	        //报关金额
	
	        $amount = $param['WIDamount'];
	        //海关编号
	        $customs_place = $param['WIDcustoms_place'];
			
	
	/************************************************************/
	
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "alipay.acquire.customs",
				"partner" => trim($alipay_config['partner']),
				"out_request_no"	=> $out_request_no,
				"trade_no"	=> $trade_no,
				"merchant_customs_code"	=> $merchant_customs_code,
				"merchant_customs_name"	=> $merchant_customs_name,
				"amount"	=> $amount,
				"customs_place"	=> $customs_place,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestHttp($parameter);		
		$arr =$this->xml_to_array($html_text);		
		
	    $res = array();
		$res['flag'] = false;
		if(!empty($arr))
		{			
			if($arr['alipay']['result_code']=="SUCCESS"){
				$res['flag'] = true;
				$res['msg'] = "操作成功";
			}
			else{
			    $res['msg'] = $arr['alipay']['detail_error_des'];
			}
		}		
	
		return $res;
	}
	
	function xml_to_array( $xml )
	{
	    $reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
	    if(preg_match_all($reg, $xml, $matches))
	    {
	        $count = count($matches[0]);
	        $arr = array();
	        for($i = 0; $i < $count; $i++)
	        {
	            $key= $matches[1][$i];
	            $val =$this->xml_to_array( $matches[2][$i] );  // 递归
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
//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

?>
