<?php
/**
 * 推送信息到丝路WMS
 *
 *
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class slwmsModel extends Model{
    //api地址
    //private $api_url = "http://61.128.133.130:8092/T3/ownererp.jsp"; //测试平台
	private $api_url = "http://61.128.133.130:8192/T3/ownererp.jsp";
    //授权码
    //private $idcode = "SLGXTEST_5346765348524";  //测试账号
    private $idcode = "SLGXGJWL_59833452345132";
    //快递企业
    private $express = "YTO";
	
    /**
     * 订单出库
     * @param  [type] $order_info [description]
     * @return [type]             [description]
     */
    public function outOrderAdd($order_info){

        $address = $order_info['extend_order_common']['reciver_info']['address'];
        $street = $order_info['extend_order_common']['reciver_info']['street'];
        $reciver_name = $order_info['extend_order_common']['reciver_name'];
        $phone = $order_info['extend_order_common']['reciver_info']['phone'];
        $area = explode(" ",$order_info['extend_order_common']['reciver_info']['area']);

        $data = array();
        $data['me'] = "outOrderAdd";
        foreach ($order_info['extend_order_goods'] as $key => $value) {
            $goods_info = Model("goods")->field('goods_spec,goods_serial,goods_wmstype')->getGoodsInfoById($value['goods_id']);
            if($goods_info["goods_spec"]!="N;"){
                $arr1 = unserialize($goods_info["goods_spec"]);
                $str = end($arr1);
                $mynum = $this->findNum($str);
                if($mynum == 0){
                    $mynum = 1;
                }
                $goods_num = $value['goods_num'] * $mynum;
            }else{
                $goods_num = $value['goods_num'];
            }
            $skunums .= '{
                        "SKUNUM": "'.$goods_info['goods_serial'].'",
                        "ORDERQTY": "'.$goods_num.'",
                        "PRICE": "'.$value['goods_pay_price'].'",
                        "LOT": "",
                        "SKUCOMM": "备注",
                        "QUALITY": "正品"
                    },';
        }
       
        $data['data'] = '{
                        "IDCODE": "'.$this->idcode.'",
                        "ORDERS": [
                            {
                                "ORDERNUM": "'.$order_info['order_sn'].'",
                                "TBNUM": "",
                                "TBNICK": "",
                                "SLGXID": "",
                                "CUSTOMCODE": "'.$order_info['code'].'",
                                "DATOUBI": "'.$area[1].'",
                                "EXPRESSCODE": "'.$order_info['shipping_code'].'",
                                "EXPRESSCOMPANY": "'.$this->express.'",
                                "PROVINCE": "'.$area[0].'",
                                "CITY": "'.$area[1].'",
                                "ORDERADDRESS": "'.preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$address).'",
                                "CONTACT": "'.$reciver_name.'",
                                "PHONE": "'.$phone.'",
                                "MOBILE": "'.$phone.'",
                                "PREOUTTIME": "'.date('Y-m-d',time()).'",
                                "PREARRIVETIME": "'.date('Y-m-d',strtotime("+3 day")).'",
                                "COMM": "'.$order_info['fremark'].'",
                                "JIBAODI": "",
                                "JIBAODI_CODE": "",
                                "GEKOHAO_CODE": "",
                                "GEKOHAO_CODE_NO": "",
                                "SKUNUMS":[
                                    '.$skunums.'
                                ]
                            }
                        ]
                    }';
        $res = $this->post($data);
        $res = json_decode($res,true);
        return $res;
    }

    /**
     * 订单取消
     * @param  [type] $order_info [description]
     * @return [type]             [description]
     */
    public function outOrderCancell($order_info){
        $data = array();
        $data['me'] = "outOrderCancel";
        $data['data'] = '{
                            "IDCODE": "'.$this->idcode.'",
                            "ORDERS": [
                                {
                                    "ORDERNUM": "'.$order_info['order_sn'].'",
                                    "REASON": ""
                                }
                            ]
                        }';
        $res = $this->post($data);
        $res = json_decode($res,true);
        return $res;
    }

    /**
     * 库存查询
     * @return [type] [description]
     */
    public function invQuery(){

    }

    /**
     * 增加sku
     * @param  [type] $goods_info [description]
     * @return [type]             [description]
     */
    public function skuAdd($goods_info){
        $data = array();
        $data['me'] = "skuAdd";
        $data['data'] = '{"IDCODE": "'.$this->idcode.'",
            "SKUNUMS": [
                {
                    "SKUNUM": "'.$goods_info['goods_serial'].'",
                    "SKUNAME": "'.$goods_info['goods_goods_name'].'",
                    "BARCODE": "'.$goods_info['goods_code'].'",
                    "MODEL": "",
                    "STANDARD": "",
                    "INVPACKNAME": "0",
                    "STATUS": "正常"
                }
            ]
        }';
        $res = $this->post($data);
        $res = json_decode($res,true);
        return $res;
    }
    
	public function post($datas,$type=1){
		$url=$this->api_url;      
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);   
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");        
        if($type){
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas));
        }
        else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $output = curl_exec($ch);
        curl_close($ch);    
        return  $output;
    }

  

    /**
     * 取字符串数字
     * @param  string $str [description]
     * @return [type]      [description]
     */
    private function findNum($str=''){
        $str=trim($str);
        if(empty($str)){return '';}
        $temp=array('1','2','3','4','5','6','7','8','9','0');
        $result='';
        for($i=0;$i<strlen($str);$i++){
            if(in_array($str[$i],$temp)){
                $result.=$str[$i];
            }
        }
        if($result==0 ){
            $result=1;
        }
        return $result;
    }
}