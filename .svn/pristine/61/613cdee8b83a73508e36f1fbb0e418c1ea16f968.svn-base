<?php
/**
 * 推送信息到WMS
 *
 *
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class regionModel extends Model{

	public function __construct(){
        parent::__construct('region');
    }
    /**
     * 反回所有上级
     * @return [type] [description]
     */
    public function getParent($name){
        $region = $this->field('id,name')->where(array('name'=>$name))->find();
        $region_list = F('region_list');
        if(empty($region_list)){
            $region_list = $this->field("id,name,parent_id,city_code,zip_code")->limit(10000000)->select();
            F('region_list',$region_list);
        }       
        $data = $this->_getParent($region_list,$region['id']);
        return $data;        
    }

    private function _getParent($data,$parent_id){
        static $ret = array();
        foreach($data as $value){
            if($value['id'] == $parent_id){     
                if($value['id'] == 100000){
                    break;
                }       
                $ret[] = $value;
                $this->_getParent($data,$value['parent_id']);
            }
        }
        return $ret;
    }
}