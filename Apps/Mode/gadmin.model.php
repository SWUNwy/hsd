<?php
/**
 * 管理员权限组
 *
 *
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class gadminModel extends Model{
    public function __construct() {
        parent::__construct('gadmin');
    }

    /**
     * 根据id查询后台管理员权限组
     * @param int $id
     * @return array
     */
    public function getGadminInfoById($id) {
        return $this->where(array('gid' => $id))->find();
    }
}
