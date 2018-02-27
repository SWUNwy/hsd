<?php
// 
// +----------------------------------------------------------------------+
// | 进销存仓库管理                                                   |
// +----------------------------------------------------------------------+
// | Copyright (c) 2016, kjyp360 Inc. All rights reserved.            |
// +----------------------------------------------------------------------+
// | Authors: Lijia, kjyp360 Inc.                  					  | 
// +----------------------------------------------------------------------+
 
/**
 * @version  1.0
 * @author   Lijia
 * @date     2016-05-23
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class ci_storageModel extends Model{
	public function __construct(){
		parent::__construct("ci_storage");
	}

	/**
	 * 进销存新增仓库
	 * @param [type] $insert [description]
	 */
	public function addCiStroage($insert){
		return $this->insert($insert);
	}

	/**
	 * 取进销存仓库列表
	 * @param  [type]  $condition [description]
	 * @param  integer $page      [description]
	 * @param  string  $order     [description]
	 * @param  string  $field     [description]
	 * @param  string  $limit     [description]
	 * @return [type]             [description]
	 */
	public function getCiStroageList($condition,$page = 0,  $order = 'id asc', $field = '*',$limit = ''){
		return $this->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
	}

	/**
	 * 根据条件取进销存仓库
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getCiStroage($condition){
		return $this->where($condition)->find();
	}

	/**
	 * 根据条件取进销存仓库
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getCiStroageById($id){
		return $this->where(array('id'=>$id))->find();
	}

	/**
	 * 根据条件修改进销存仓库
	 * @param  [type] $condition [description]
	 * @param  [type] $update    [description]
	 * @return [type]            [description]
	 */
	public function editCiStroage($condition,$update){
		return $this->where($condition)->update($update);
	}

	/**
	 * 根据条件删除进销存仓库
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function delCiStroage($condition){
		return $this->where($condition)->delete();
	}

	/**
	 * 进销存仓库条数
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getCiStroageCount($condition){
		return $this->where($condition)->count();
	}
}