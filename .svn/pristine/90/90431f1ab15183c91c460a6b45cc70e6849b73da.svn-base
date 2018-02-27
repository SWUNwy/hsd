<?php
/**
 * 
 *
 * @copyright  Copyright (c) 2007-2012 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      关税
 */

defined('ByShopKJYP') or exit('Access Invalid!');

class newtaxrateModel extends Model{
	   public function __construct(){ 
           parent::__construct('taxrate');
    }    

    /**
     * 通过货号取税价
     */
    public function GetTax($goods_serial,$amount){   
        $tax_info = $this->GetTaxBySerial($goods_serial);
        $rate = $this->GetCompositeTaxRate($tax_info);
        $tax = $amount - round($amount/(1+$rate),2);
        return $tax;
    }
	
	/**
	 * 根据商品ID取税价
	 */
	public function getTaxByGoodsId($goods_id,$amount){
		$goods_id = intval($goods_id);
		if($goods_id <=0){
			return 0;
		}
		$goods_info = Model("goods")->getGoodsInfo(array('goods_id'=>$goods_id));
		$tax_info = $this->GetTaxBySerial($goods_info['goods_serial']);
        $rate = $this->GetCompositeTaxRate($tax_info);
        $tax = $amount - round($amount/(1+$rate),2);
        return $tax;
	}
	
    /**
     * 取综合税率
     * @param [type] $tax_info [description]
     */
    private function GetCompositeTaxRate($tax_info){
        $rate = ((0+$tax_info['tax_rate']+$tax_info['goods_added_tax']+(0*$tax_info['goods_added_tax']))/(1-$tax_info['tax_rate']))*0.7;
        return $rate;
    }
    /**
     * 
     * 通过商品货号取税率
     * @param [type] $goods_serial [description]
     */
    public function GetTaxBySerial($goods_serial){      
    	$goods_serial = str_replace(array('KJ'),'',$goods_serial);
        //获得税率
        $model_tax = Model('newtax');        
        $model_goods_record = Model('goods_record');        
        $goods_record = $model_goods_record->getGoodsRecord(array('goods_serial'=>$goods_serial));
        $tax_info = $model_tax->getTaxInfo(array('tax_id'=>$goods_record['goods_tax_id']));
        $tax_info['goods_added_tax'] = $goods_record['goods_added_tax'];
        //$tax_info = Model() ->table("tax_rate")->where(array("hs_code"=>$goods_record["goods_sh_code"]))->find();
        return $tax_info;
    }
}
