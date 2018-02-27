<?php
/**
 *
 *
 * 
 *
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class wxch_menuModel extends Model {
    public function __construct(){
        parent::__construct('wxch_menu');
    }
    
    /**
     * 版式列表
     * @param array $condition
     * @param string $field
     * @param int $page
     * @return array
     */
    public function getMenuList($condition, $field = '*', $page = 0,$order = 'aid desc') {
        return $this->field($field)->where($condition)->page($page)->order($order)->select();
    }
    
    /**
     * 版式详细信息
     * @param array $condition
     * @return array
     */
    public function getMenuInfo($condition) {
		  return $this->where($condition)->find();
    }
    
    /**
     * 添加版式
     * @param unknown $insert
     * @return boolean
     */
    public function addMenu($insert) {
        return $this->insert($insert);
    }
    
    /**
     * 更新版式
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editMenu($update, $condition) {
        return $this->where($condition)->update($update);
    }
    
    /**
     * 删除版式
     * @param array $condition
     * @return boolean
     */
    public function delMenu($condition) {
        return $this->where($condition)->delete();
    }
	
	public function clearMenu(){
		return Db::query("TRUNCATE TABLE `".DBPRE."wxch_menu`");
	}

}

