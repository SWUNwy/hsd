<?php
/**
 * 微信配置
 *
 * 
 *
 *
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class wxch_configModel extends Model {
    public function __construct(){
        parent::__construct('wxch_config');
    }
    
    /**
     * 版式列表
     * @param array $condition
     * @param string $field
     * @param int $page
     * @return array
     */
    public function getConfigList($condition, $field = '*', $page = 0) {
        return $this->field($field)->where($condition)->page($page)->select();
    }
    
    /**
     * 版式详细信息
     * @param array $condition
     * @return array
     */
    public function getConfigInfo($condition) {
		  return $this->where($condition)->find();
    }
    
    /**
     * 添加版式
     * @param unknown $insert
     * @return boolean
     */
    public function addConfig($insert) {
        return $this->insert($insert);
    }
    
    /**
     * 更新版式
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editConfig($update, $condition) {
        return $this->where($condition)->update($update);
    }
    
    /**
     * 删除版式
     * @param array $condition
     * @return boolean
     */
    public function delConfig($condition) {
        return $this->where($condition)->delete();
    }
}
