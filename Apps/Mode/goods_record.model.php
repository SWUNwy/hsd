<?php
/**
 * 海关商品备案
 *
 * 
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class goods_recordModel extends Model {
    public function __construct(){
        parent::__construct('goods_record');
    }
	
    /**
     * 插入数据
     * 
     * @param unknown $insert
     * @return boolean
     */
    public function addGoodsRecord($insert) {
        return $this->insert($insert);
    }
	
    /**
     * 取得商品备案
     * 
     * @param array $condition
     * @param string $order
     */
    public function getGoodsRecordList($condition,$page = 0,  $order = 'goods_recordid asc', $field = '*',$limit = '') {
        return $this->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
    }	
    
    /**
     * 删除商品备案
     */
    public function delGoodsRecord($condition) {
        return $this->where($condition)->delete();
    }

    /**
     * 取商品备案 
     */
    public function getGoodsRecord($condition) {
        return $this->where($condition)->find();
    }

    /**
     * 商品备案
     */
    public function editGoodsRecord($data, $condition) {
        return $this->where($condition)->update($data);
    }
	
	 /**
     * 取得商品备案数量
     * @param unknown $condition
     */
    public function getGoodsRecordCount($condition) {
        return $this->where($condition)->count();
    }
}
