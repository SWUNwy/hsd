<?php
/**
 * 类型管理
 *
 * 
 *
 */
defined('ByShopKJYP') or exit('Access Invalid!');

class channelModel extends Model {

	var $data    = array();
	var $child   = array(-1=>array());
	var $layer   = array(-1=>-1);
	var $parent  = array();
	function Tree ($value){
		$this->setNode(0, -1, $value);
	}
	function setNode ($id, $parent, $value,$type,$flag){
		$parent = $parent?$parent:0;
		$this->data[$id] = $value;
		$this->type[$id] = $type;//频道类型
		$this->flag[$id] = $flag;//频道权限
		$this->child[$id] = array();
		$this->child[$parent][]   = $id;
		$this->parent[$id]        = $parent;
		if (!isset($this->layer[$parent])){
			$this->layer[$id] = 0;
		}else{
			$this->layer[$id] = $this->layer[$parent] + 1;
		}
	} // end func
	function getList (&$tree, $root= 0){
		foreach ($this->child[$root] as $key=>$id){
			$tree[] = $id;
			if ($this->child[$id]) $this->getList($tree, $id);
		}
	} // end func
	function getValue ($id){
		return $this->data[$id];
	} // end func
	function getFlag ($id){ //频道权限方法
		return $this->flag[$id];
	} // end func
	function getType ($id){ //频道类型方法
		return $this->type[$id];
	} // end func
	function getLayer ($id, $space = false){
		return $space?str_repeat($space, $this->layer[$id]):$this->layer[$id];
	} // end func
	function getParent ($id){
		return $this->parent[$id];
	} // end func
	function getParents ($id){
		while ($this->parent[$id] != -1){
			$id = $parent[$this->layer[$id]] = $this->parent[$id];
		}
		ksort($parent);
		reset($parent);
		return $parent;
	} // end func
	function getChild ($id){
		return $this->child[$id];
	} // end func
	function getChilds ($id = 0){
		$child = array($id);
		$this->getList($child, $id);
		return $child;
	} // end func
}