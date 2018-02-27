<?php 
/**
 * 通联扫码支付
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
defined('ByShopKJYP') or exit('Access Invalid!');

class allinpay{

    /**
     * 存放支付订单信息
     * @var array
     */
    private $_order_info = array();

    /**
     * 支付信息初始化
     * @param array $payment_info
     * @param array $order_info
     */
    public function __construct($payment_info = array(), $order_info = array()) {
        $this->_order_info = $order_info;
    }


    /**
     * 组装包含支付信息的url(模式2)
     */
    public function get_payurl() {
        require_once 'AppConfig.php';
        require_once 'AppUtil.php';
        $params = array();
        $params["cusid"] = AppConfig::CUSID;
        $params["appid"] = AppConfig::APPID;
        $params["version"] = AppConfig::APIVERSION;
        $params["trxamt"] = $this->_order_info['api_pay_amount']*100;
        $params["reqsn"] = $this->_order_info['pay_sn'];//订单号,自行生成
        $params["paytype"] = "W01";
        $params["randomstr"] = $this->_order_info['pay_sn'];//
        $params["body"] = $this->_order_info['pay_sn'].'订单';
        $params["remark"] = $this->_order_info['order_type'] == 'vr_order' ? 'v' : 'r';
        $params["acct"] = "";
        $params["limit_pay"] = "no_credit";
        $params["notify_url"] = SHOP_SITE_URL.'/api/payment/allinpay/notify.php';
        $params["sign"] = AppUtil::SignArray($params,AppConfig::APPKEY);//签名
        $paramsStr = AppUtil::ToUrlParams($params);
        $url = AppConfig::APIURL . "/pay";
        $rsp = $this->request($url, $paramsStr);
        $rspArray = json_decode($rsp, true); 
        if($this->validSign($rspArray)){
            $rsp = json_decode($rsp,true);
            return $rsp['payinfo'];
        }else{
            return false;
        }
    }

    function query(){
        $params = array();
        $params["cusid"] = AppConfig::CUSID;
        $params["appid"] = AppConfig::APPID;
        $params["version"] = AppConfig::APIVERSION;
        $params["reqsn"] = "123456";
        $params["randomstr"] = "1450432107647";//
        $params["sign"] = AppUtil::SignArray($params,AppConfig::APPKEY);//签名
        $paramsStr = AppUtil::ToUrlParams($params);
        $url = AppConfig::APIURL . "/query";
        $rsp = request($url, $paramsStr);
        echo "请求返回:".$rsp;
        echo "<br/>";
        $rspArray = json_decode($rsp, true); 
        if(validSign($rspArray)){
            echo "验签正确,进行业务处理";
        }
    }
    
    //发送请求操作仅供参考,不为最佳实践
    function request($url,$params){
        $ch = curl_init();
        $this_header = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);         
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//如果不加验证,就设false,商户自行处理
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);         
        $output = curl_exec($ch);
        curl_close($ch);
        return  $output;
    }
    
    //验签
    function validSign($array){
        if("SUCCESS"==$array["retcode"]){
            $signRsp = strtolower($array["sign"]);
            $array["sign"] = "";
            $sign =  strtolower(AppUtil::SignArray($array, AppConfig::APPKEY));
            if($sign==$signRsp){
                return TRUE;
            }
            else {
                echo "验签失败:".$signRsp."--".$sign;
            }
        }
        else{
            echo $array["retmsg"];
        }
        return FALSE;
    }
}
