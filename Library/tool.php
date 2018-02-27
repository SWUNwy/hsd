<?php
/**
 * 商品管理
 *
 * 
 *
 *
 **你正在使用的程序由网店运维技术交流中心www.kjyp360.com提供！这里有专业化shopnc技术指导！以便你更好的了解这个程序*/


defined('ByShopKJYP') or exit('Access Invalid!');
class toolControl extends BaseHomeControl {
	 public function indexOp(){
	 	echo date("YmdHis",time()).rand(11111,99999);
	 	//$model_region = Model("region");
	 	//$data = $model_region->getParent("滨海新区");
	 	//$data = Model("jbwms")->sendHgcode("9000000000000101","13211232");
	 	//print_r($data);
	 }

}
