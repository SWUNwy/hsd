<?php
/**
 * 
 *
 * 
 *
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class wxch_oauthModel extends Model {
    public function __construct(){
        parent::__construct('wxch_oauth');
    }
    
    /**
     * 版式列表
     * @param array $condition
     * @param string $field
     * @param int $page
     * @return array
     */
    public function getOauthList($condition, $field = '*', $page = 0,$order = 'oid desc') {
        return $this->field($field)->where($condition)->page($page)->order($order)->select();
    }
    
    /**
     * 版式详细信息
     * @param array $condition
     * @return array
     */
    public function getOauthInfo($condition) {
		  return $this->where($condition)->find();
    }
    
    /**
     * 添加版式
     * @param unknown $insert
     * @return boolean
     */
    public function addOauth($insert) {
        return $this->insert($insert);
    }
    
    /**
     * 更新版式
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editOauth($update, $condition) {
        return $this->where($condition)->update($update);
    }
    
    /**
     * 删除版式
     * @param array $condition
     * @return boolean
     */
    public function delOauth($condition) {
        return $this->where($condition)->delete();
    }
}
