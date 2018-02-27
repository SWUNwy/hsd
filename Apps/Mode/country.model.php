<?php

defined('ByShopKJYP') or exit('Access Invalid!');

class countryModel extends Model{

    public function __construct() {
        parent::__construct('country');
    }

    public function getCountryList($condition = array(),$fields = '*', $group = '') {
        return $this->where($condition)->field($fields)->limit(false)->group($group)->select();
    }
	public function getCountryInfo($condition, $field = '*') {
        return $this->field($field)->where($condition)->find();
    }
}