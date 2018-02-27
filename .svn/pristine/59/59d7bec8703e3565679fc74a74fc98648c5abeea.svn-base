<?php
/**
 * 外部图片
 *
 * 
 *
 *
 */

defined('ByShopKJYP') or exit('Access Invalid!');

class pictureModel extends Model{
    public function __construct(){
        parent::__construct('picture');
    }

   
    /**
     * 全部
     */
    public function Picture_all($condition){
        return $this->where($condition)->find();
    }

	/**
	 * 列表
	 *
	 * @param array $condition 查询条件
	 * @param int $page 分页数
	 * @param string $order 排序
	 * @param string $field 字段
     * @return array
	 */
	public function getPictureList($condition, $page = 0, $order = 'pic_name asc,pic_id desc', $field = '*',$limit = ''){
        $link_list = $this->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
		return $link_list;
	}


   public function getPictureInfo($condition, $field = '*') {
        return $this->field($field)->where($condition)->find();
    }
	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getPictureInfoByID($id){
        if (intval($id) > 0){
            $condition = array('pic_id' => $id);
            $result = $this->where($condition)->find();
            return $result;
        }else {
            return false;
        }
    }
	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getMbAdCount(){
		return Db::getCount('Picture');
	}
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addPicture($param){
        return $this->insert($param);	
	}
	 /**
     * 取得F码数量
     * @param unknown $condition
     */
    public function getPictureCount($condition) {
        return $this->where($condition)->count();
    }
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @param array $condition 条件
	 * @return bool 布尔类型的返回结果
	 */
	public function updatePicture($param, $condition){
        return $this->where($condition)->update($param);
	}
	
	/**
	 * 删除
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function delPicture($id){
        if (intval($id) > 0){
            $condition = array('pic_id' => $id);
            return $this->where($condition)->delete();
        } else {
            return false;
        }
    }	

	/*
	 * 批量增加 
	 * @param array $array
	 * @return bool
     *
	 */
    public function addPictureAll($array){
        return $this->insertAll($array);	
    }

}
