<?php
/**
 * 地区模型
 *
 *
 *
 *
 * 
 */
defined('ByShopKJYP') or exit('Access Invalid!');

class unitModel extends Model{

    public function __construct() {
        parent::__construct('unit');
    }

    public function getUnitList($condition = array(),$fields = '*', $group = '') {
        return $this->where($condition)->field($fields)->limit(false)->group($group)->select();
    }
}