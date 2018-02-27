<?php
// 
// +----------------------------------------------------------------------+
// | 发货仓库管理                                                                                                                                            |
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
class storageModel extends Model{
	public function __construct(){
		parent::__construct("storage");
	}

	/**
	 * 新增仓库
	 * @param [type] $insert [description]
	 */
	public function addStroage($insert){
		return $this->insert($insert);
	}

	/**
	 * 取仓库列表
	 * @param  [type]  $condition [description]
	 * @param  integer $page      [description]
	 * @param  string  $order     [description]
	 * @param  string  $field     [description]
	 * @param  string  $limit     [description]
	 * @return [type]             [description]
	 */
	public function getStroageList($condition,$page = 0,  $order = 's_id asc', $field = '*',$limit = ''){
		return $this->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
	}

	/**
	 * 根据条件取仓库
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getStroage($condition){
		return $this->where($condition)->find();
	}

	/**
	 * 根据ID取仓库
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getStroageById($id){
		return $this->where(array('s_id'=>$id))->find();
	}

	/**
	 * 根据条件修改仓库
	 * @param  [type] $condition [description]
	 * @param  [type] $update    [description]
	 * @return [type]            [description]
	 */
	public function editStroage($condition,$update){
		return $this->where($condition)->update($update);
	}

	/**
	 * 根据条件删除仓库
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function delStroage($condition){
		return $this->where($condition)->delete();
	}

	/**
	 * 仓库条数
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getStroageCount($condition){
		return $this->where($condition)->count();
	}
}