<?php
/**
 * 
 *
 * 
 *
 * 新税率
 * @copyright  Copyright (c) 2007-2012 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */

defined('ByShopKJYP') or exit('Access Invalid!');

class newtaxModel extends Model{
	public function __construct(){
        parent::__construct('newtax');
    }    
   
	/**
	 * 列表
	 *
	 * @param array $condition 查询条件
	 * @param int $page 分页数
	 * @param string $order 排序
	 * @param string $field 字段
     * @return array
	 */
	public function getTaxList($condition, $page = 0, $order = 'tax_id asc', $field = '*',$limit = ''){
        $link_list = $this->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
		return $link_list;
	}


   public function getTaxInfo($condition, $field = '*') {
        return $this->field($field)->where($condition)->find();
    }
	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getTaxInfoByID($id){
        if (intval($id) > 0){
            $condition = array('Tax_id' => $id);
            $result = $this->where($condition)->find();
            return $result;
        }else {
            return false;
        }
    }
	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getMbAdCount(){
		return Db::getCount('limit');
	}
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addTax($param){
        return $this->insert($param);	
	}
	 /**
     * 取得F码数量
     * @param unknown $condition
     */
    public function getTaxCount($condition) {
        return $this->where($condition)->count();
    }
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @param array $condition 条件
	 * @return bool 布尔类型的返回结果
	 */
	public function updateTax($param, $condition){
        return $this->where($condition)->update($param);
	}
	
	/**
	 * 删除
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function delTax($id){
        if (intval($id) > 0){
            $condition = array('limit_id' => $id);
            return $this->where($condition)->delete();
        } else {
            return false;
        }
    }	

	/*
	 * 批量增加 
	 * @param array $array
	 * @return bool
     *
	 */
    public function addTaxAll($array){
        return $this->insertAll($array);	
    }
	

	
}
