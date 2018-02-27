<?php
/**
 * 
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2012 kjyp Inc
 * @license    http://www.kjyp360.com
 * @link       http://www.kjyp360.com
 * @since      关税
 */

defined('ByShopKJYP') or exit('Access Invalid!');

class taxrateModel extends Model{
	   public function __construct(){ 
           parent::__construct('taxrate');

    }    
  	
    /**
     * 返回税金
     * @param [type] $goods_id        [description]
     * @param [type] $goods_pay_price [description]
     * @param [type] $shipping_fee    [description]
     */
    public function GetAllTax($goods_id,$goods_pay_price,$shipping_fee)
    {
        $excise = $this->GetExcise($goods_id,$goods_pay_price,$shipping_fee);
        $addedvaluetax = $this->GetAddedValueTax($goods_id,$goods_pay_price,$shipping_fee,$excise);
        return $this->GetConsolidatedTax($addedvaluetax,$excise);
        
    }

  	/**
  	 * 计算消费税
  	 */
  	public function GetExcise($goods_id,$goods_pay_price,$shipping_fee)
  	{
        $tax_rate = $this->GetTax($goods_id); //税率
        //法定计征的消费税=（完税价格/(1-消费税税率)）*消费税税率；
        //例如：消费税税率为30%商品，单价为100元，运费为6元的计税公式如下：关税=0
        //消费税=（100+6）/(1-0.3)*0.3=45.43
        if( $tax_rate > 0 )
        {
            $excise =  ($goods_pay_price + $shipping_fee )/(1 -  $tax_rate) *  $tax_rate;
            $excise = number_format($excise,2);
            //return $this->FormatNum($excise );
        }
        else
        {
            $excise = 0;
        }
    
        return $excise;
       
  	}
   	
   	/**
   	 * 计算增值税
   	 */
   	public function GetAddedValueTax($goods_id,$goods_pay_price,$shipping_fee,$excise)
   	{
        //取增值税税率
        $added_tax = $this->GetAddedTax($goods_id);
        //法定计征的增值税=（完税价格+正常计征的消费税税额）*增值税税率；
        return number_format(($goods_pay_price + $shipping_fee + $excise) *  $added_tax,2);
        //return $this->FormatNum(($goods_pay_price + $shipping_fee + $excise) *  $added_tax);
   	}
    
    /**
     * 计算综合税
     */
    public function GetConsolidatedTax($addedvaluetax,$excise)
    {
       //综合税=(消费税+增值税)*0.7
       return  number_format(($addedvaluetax + $excise) * 0.7,2);   
       //return $this->FormatNum(($addedvaluetax + $excise) * 0.7);
    }
   
    /**
     * 通过商品ID取消费税率
     * @param [type] $goods_id [description]
     */
    public function GetTax($goods_id)
    {
        /*
        if($goods_id == 1)
        {
          return 0.3;
        }
        else
        {
          return 0;
        }
        *///
        //获得税率        
        $model_goods = Model('goods');         
        $goods_info = $model_goods->getGoodsInfo(array('goods_id' => $goods_id));        
        $tax_info = $this->GetTaxBySerial($goods_info['goods_serial']);
        return $tax_info['tax_rate']>0?$tax_info['tax_rate']:0;
    }
	   
    /**
     * 格式化数字不四舍五入
     * @param unknown $tax
     * @return string
     */
    public function FormatNum($tax)
    {
    	return sprintf("%.2f",substr(sprintf("%.3f", $tax), 0, -1));
    }

    /**
     * 通过商品ID取增值税率
     * @param [type] $goods_id [description]
     */
    public function GetAddedTax($goods_id)
    {
       
        //获得税率        
        $model_goods = Model('goods'); 
        $model_goods_record = Model("goods_record");       
        $goods_info = $model_goods->getGoodsInfo(array('goods_id' => $goods_id));        
        $goods_record = $model_goods_record->getGoodsRecord(array('goods_serial'=>$goods_info['goods_serial']));
       
        return $goods_record['goods_added_tax']>0?$goods_record['goods_added_tax']:0;
    }

    /**
     * 
     * 通过商品货号取税率
     * @param [type] $goods_serial [description]
     */
    public function GetTaxBySerial($goods_serial)
    {
      
        //获得税率
        $model_tax = Model('newtax');        
        $model_goods_record = Model('goods_record');        
        $goods_record=$model_goods_record->getGoodsRecord(array('goods_serial'=>$goods_serial));
        $tax_info=$model_tax->getTaxInfo(array('tax_id'=>$goods_record['goods_tax_id']));
        //$tax_info = Model() ->table("tax_rate")->where(array("hs_code"=>$goods_record["goods_sh_code"]))->find();
        return $tax_info;
    }

	
}
