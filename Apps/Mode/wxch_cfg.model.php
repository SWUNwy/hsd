<?php
/**
 * 
 *
 * 
 *
 *
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class wxch_cfgModel extends Model {
    public function __construct(){
        parent::__construct('wxch_cfg');
    }
    
    /**
     * 版式列表
     * @param array $condition
     * @param string $field
     * @param int $page
     * @return array
     */
    public function getCfgList($condition, $field = '*', $page = 0) {
        return $this->field($field)->where($condition)->page($page)->select();
    }
    
    /**
     * 版式详细信息
     * @param array $condition
     * @return array
     */
    public function getCfgInfo($condition) {
		  return $this->where($condition)->find();
    }
    
    /**
     * 添加版式
     * @param unknown $insert
     * @return boolean
     */
    public function addCfg($insert) {
        return $this->insert($insert);
    }
    
    /**
     * 更新版式
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editCfg($update, $condition) {
        return $this->where($condition)->update($update);
    }
    
    /**
     * 删除版式
     * @param array $condition
     * @return boolean
     */
    public function delCfg($condition) {
        return $this->where($condition)->delete();
    }
}
