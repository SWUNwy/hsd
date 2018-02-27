<?php
/**
 * 商品管理
 *
 *
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */



defined('ByShopKJYP') or exit ('Access Invalid!');
class goods_onlineControl extends SystemControl {

    private $store_info = array();
    public function __construct() {
        parent::__construct ();
        Language::read ('member_store_goods_index');
        $model_store = Model('store');
        $model_seller = Model('seller');
        $this->store_info = $model_store->getStoreInfoByID(1);
        $this->seller_info = $model_seller->getSellerInfo(array('store_id'=>$this->store_info['store_id']));
        Tpl::setDirquna('shop');
    }
    public function indexOp() {
        $this->goods_listOp();
    }

    /**
     * 出售中的商品列表
     */
    public function goods_listOp() {        
        Tpl::showpage('goods_list.online');
    }
    
    /**
     * 编辑商品页面
     */
    public function edit_goodsOp() {
        $common_id = $_GET['commonid'];
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), '', 'html', 'error');
        }
        $model_goods = Model('goods'); 
        $goodscommon_info = $model_goods->getGoodsCommonInfoByID($common_id);
        //print_r($goodscommon_info); 
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != $this->store_info['store_id'] || $goodscommon_info['goods_lock'] == 1) {
            showMessage(L('wrong_argument'), '', 'html', 'error');
        }
        $where = array('goods_commonid' => $common_id, 'store_id' => $this->store_info['store_id']);
        $goodscommon_info['g_storage'] = $model_goods->getGoodsSum($where, 'goods_storage');        
        $goodscommon_info['spec_name'] = unserialize($goodscommon_info['spec_name']);
        $goodscommon_info['goods_custom'] = unserialize($goodscommon_info['goods_custom']);
        if ($goodscommon_info['mobile_body'] != '') {
            $goodscommon_info['mb_body'] = unserialize($goodscommon_info['mobile_body']);
            if (is_array($goodscommon_info['mb_body'])) {
                $mobile_body = '[';
                foreach ($goodscommon_info['mb_body'] as $val ) {
                    $mobile_body .= '{"type":"' . $val['type'] . '","value":"' . $val['value'] . '"},';
                }
                $mobile_body = rtrim($mobile_body, ',') . ']';
            }
            $goodscommon_info['mobile_body'] = $mobile_body;
        }

        Tpl::output('goods', $goodscommon_info);

        if (intval($_GET['class_id']) > 0) {
            $goodscommon_info['gc_id'] = intval($_GET['class_id']);
        }
        $goods_class = Model('goods_class')->getGoodsClassLineForTag($goodscommon_info['gc_id']);
        Tpl::output('goods_class', $goods_class);

        $model_type = Model('type');
        // 获取类型相关数据
        $typeinfo = $model_type->getAttr($goods_class['type_id'], $this->store_info['store_id'], $goodscommon_info['gc_id']);
        list($spec_json, $spec_list, $attr_list, $brand_list) = $typeinfo;
        Tpl::output('spec_json', $spec_json);
        Tpl::output('sign_i', count($spec_list));
        Tpl::output('spec_list', $spec_list);
        Tpl::output('attr_list', $attr_list);
        Tpl::output('brand_list', $brand_list);
        // 自定义属性
        $custom_list = Model('type_custom')->getTypeCustomList(array('type_id' => $goods_class['type_id']));
        $custom_list = array_under_reset($custom_list, 'custom_id');
        Tpl::output('custom_list', $custom_list);

        // 取得商品规格的输入值
        $goods_array = $model_goods->getGoodsList($where, 'goods_id,goods_marketprice,goods_price,goods_storage,goods_serial,goods_storage_alarm,goods_spec,goods_barcode');
        $sp_value = array();
        if (is_array($goods_array) && !empty($goods_array)) {

            // 取得已选择了哪些商品的属性
            $attr_checked_l = $model_type->typeRelatedList ( 'goods_attr_index', array (
                    'goods_id' => intval ( $goods_array[0]['goods_id'] )
            ), 'attr_value_id' );
            if (is_array ( $attr_checked_l ) && ! empty ( $attr_checked_l )) {
                $attr_checked = array ();
                foreach ( $attr_checked_l as $val ) {
                    $attr_checked [] = $val ['attr_value_id'];
                }
            }
            Tpl::output ( 'attr_checked', $attr_checked );

            $spec_checked = array();
            foreach ( $goods_array as $k => $v ) {
                $a = unserialize($v['goods_spec']);
                if (!empty($a)) {
                    foreach ($a as $key => $val){
                        $spec_checked[$key]['id'] = $key;
                        $spec_checked[$key]['name'] = $val;
                    }
                    $matchs = array_keys($a);
                    sort($matchs);
                    $id = str_replace ( ',', '', implode ( ',', $matchs ) );
                    $sp_value ['i_' . $id . '|marketprice'] = $v['goods_marketprice'];
                    $sp_value ['i_' . $id . '|price'] = $v['goods_price'];
                    $sp_value ['i_' . $id . '|id'] = $v['goods_id'];
                    $sp_value ['i_' . $id . '|stock'] = $v['goods_storage'];
                    $sp_value ['i_' . $id . '|alarm'] = $v['goods_storage_alarm'];
                    $sp_value ['i_' . $id . '|sku'] = $v['goods_serial'];
                    $sp_value ['i_' . $id . '|barcode'] = $v['goods_barcode'];
                }
            }
            Tpl::output('spec_checked', $spec_checked);
        }
        Tpl::output ( 'sp_value', $sp_value );

        // 实例化店铺商品分类模型
        $store_goods_class = Model('store_goods_class')->getClassTree(array('store_id' => $_SESSION ['store_id'], 'stc_state' => '1'));
        Tpl::output('store_goods_class', $store_goods_class);
        //处理商品所属分类
        $store_goods_class_tmp = array();
        if (!empty($store_goods_class)){
            foreach ($store_goods_class as $k=>$v) {
                $store_goods_class_tmp[$v['stc_id']] = $v;
                if (is_array($v['child'])) {
                    foreach ($v['child'] as $son_k=>$son_v){
                        $store_goods_class_tmp[$son_v['stc_id']] = $son_v;
                    }
                }
            }
        }
        $goodscommon_info['goods_stcids'] = trim($goodscommon_info['goods_stcids'], ',');
        $goods_stcids = empty($goodscommon_info['goods_stcids'])?array():explode(',', $goodscommon_info['goods_stcids']);
        $goods_stcids_tmp = $goods_stcids_new = array();
        if (!empty($goods_stcids)){
            foreach ($goods_stcids as $k=>$v){
                $stc_parent_id = $store_goods_class_tmp[$v]['stc_parent_id'];
                //分类进行分组，构造为array('1'=>array(5,6,8));
                if ($stc_parent_id > 0){//如果为二级分类，则分组到父级分类下
                    $goods_stcids_tmp[$stc_parent_id][] = $v;
                } elseif (empty($goods_stcids_tmp[$v])) {//如果为一级分类而且分组不存在，则建立一个空分组数组
                    $goods_stcids_tmp[$v] = array();
                }
            }
            foreach ($goods_stcids_tmp as $k=>$v){
                if (!empty($v) && count($v) > 0){
                    $goods_stcids_new = array_merge($goods_stcids_new,$v);
                } else {
                    $goods_stcids_new[] = $k;
                }
            }
        }
        Tpl::output('store_class_goods', $goods_stcids_new);

        // 是否能使用编辑器
        if(checkPlatformStore()){ // 平台店铺可以使用编辑器
            $editor_multimedia = true;
        } else {    // 三方店铺需要
            $editor_multimedia = false;
            if ($this->store_grade['sg_function'] == 'editor_multimedia') {
                $editor_multimedia = true;
            }
        }
        Tpl::output ( 'editor_multimedia', $editor_multimedia );

        // 小时分钟显示
        $hour_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        Tpl::output('hour_array', $hour_array);
        $minute_array = array('05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');
        Tpl::output('minute_array', $minute_array);

        // 关联版式
        $plate_list = Model('store_plate')->getStorePlateList(array('store_id' => $_SESSION['store_id']), 'plate_id,plate_name,plate_position');
        $plate_list = array_under_reset($plate_list, 'plate_position', 2);
        Tpl::output('plate_list', $plate_list);

        // 供货商
        $supplier_list = Model('store_supplier')->getStoreSupplierList(array('sup_store_id' => $_SESSION['store_id']));
        Tpl::output('supplier_list', $supplier_list);

        //分类  
        $model_goods_class = Model('goods_class');
        $gc_list = $model_goods_class->getGoodsClassListByParentId(0);
        Tpl::output('gc_list',$gc_list);

        //商品图片
        $this->get_image($common_id);
        
        //进销存仓库
        $model_ci_storage = Model('ci_storage');
		/*
        if($ci_goods_info['locationId']>0){
            $ci_storage_list = $model_ci_storage->getCiStroageList(array('id'=>$ci_goods_info['locationId']));
			$this->get_supplier($ci_storage_list[0][id],$goodscommon_info['goods_barcode']);
        }else{
            $ci_storage_list = $model_ci_storage->getCiStroageList(array());
        }
		*/
		//$ci_storage_list = $model_ci_storage->getCiStroageList(array());
		
		$ci_storage_list = $model_ci_storage->getCiStroageList(array());
		//print_r($ci_storage_list);
        Tpl::output('ci_storage_list',$ci_storage_list);
        //货品类型
        $model_wmstype = Model("wmstype");
        $wmstype_list = $model_wmstype->select();
        Tpl::output('wmstype_list',$wmstype_list);
        
        Tpl::output('edit_goods_sign', true);
        Tpl::showpage('goods_add.step2');
    }


    /**
     * 取商品图片
     */
    private function get_image($common_id) {
       
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), urlAdminShop('goods_online'), 'html', 'error');
        }
        $model_goods = Model('goods');
        $common_list = $model_goods->getGoodsCommonInfoByID($common_id, 'store_id,goods_lock,spec_value,is_virtual,is_fcode,is_presell');
        if ($common_list['store_id'] != $this->store_info['store_id'] || $common_list['goods_lock'] == 1) {
            showMessage(L('wrong_argument'), urlAdminShop('goods_online'), 'html', 'error');
        }

        $spec_value = unserialize($common_list['spec_value']);
        Tpl::output('value', $spec_value['1']);

        $image_list = $model_goods->getGoodsImageList(array('goods_commonid' => $common_id));
        $image_list = array_under_reset($image_list, 'color_id', 2);

        $img_array = $model_goods->getGoodsList(array('goods_commonid' => $common_id), 'color_id,min(goods_image) as goods_image', 'color_id');
        // 整理，更具id查询颜色名称
        if (!empty($img_array)) {
            foreach ($img_array as $val) {
                if (isset($image_list[$val['color_id']])) {
                    $image_array[$val['color_id']] = $image_list[$val['color_id']];
                } else {
                    $image_array[$val['color_id']][0]['goods_image'] = $val['goods_image'];
                    $image_array[$val['color_id']][0]['is_default'] = 1;
                }
                $colorid_array[] = $val['color_id'];
            }
        }
        Tpl::output('img', $image_array);


        $model_spec = Model('spec');
        $value_array = $model_spec->getSpecValueList(array('sp_value_id' => array('in', $colorid_array), 'store_id' => $_SESSION['store_id']), 'sp_value_id,sp_value_name');
        if (empty($value_array)) {
            $value_array[] = array('sp_value_id' => '0', 'sp_value_name' => '无颜色');
        }
        Tpl::output('value_array', $value_array);
        Tpl::output('commonid', $common_id);       
        Tpl::output('edit_goods_sign', true);        
    }

    /**
     * 编辑商品保存
     */
    public function edit_save_goodsOp() {
        $logic_goods = Logic('goods');
       
        $result =  $logic_goods->updateGoods(
            $_POST,
            $this->store_info['store_id'], 
            $this->store_info['store_name'], 
            $this->store_info['store_state'], 
            $this->seller_info['seller_id'], 
            $this->seller_info['seller_name'],
            1
        );
        //保存商品图片
        $common_id = intval($_POST['commonid']);
        $rs = Logic('goods')->editSaveImage($_POST['img'], $common_id, $this->store_info['store_id'],$this->seller_info['seller_id'],$this->seller_info['seller_name']);       
        if ($result['state'] && $rs['state']) {
            //提交事务
            $this->log("商品编辑".'[ID:'.$common_id.']',null);
            showDialog(L('nc_common_op_succ'), $_POST['ref_url'], 'succ');
        } else {
            //回滚事务
            showDialog($result['msg'], urlShop('store_goods_online', 'index'));
        }
    }

    /**
     * 异步调用出售中的商品
     */
    public function get_xmlOp(){

        $model_goods = Model('goods');
        $condition = array();
        $condition['store_id'] = $this->store_info['store_id'];
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = array('like', '%' . $_POST['query'] . '%');
        }
        $order = '';
        $param = array('goods_commonid','goods_name','goods_serial','goods_barcode','goods_price','goods_addtime'); 
        if (in_array($_POST['sortname'], $param) && in_array($_POST['sortorder'], array('asc', 'desc'))) {
            $order = $_POST['sortname'] . ' ' . $_POST['sortorder'];        
        }   
        $page = $_POST['rp'];
        $goods_list = $model_goods->getGoodsCommonOnlineList($condition,'*',$page,$order);
        // 计算库存
        $storage_array = $model_goods->calculateStorage($goods_list);        
        $data = array();
        $data['now_page'] = $model_goods->shownowpage();
        $data['total_num'] = $model_goods->gettotalnum();   
        foreach ($goods_list as $k => $v){
                $list = array();
                $list['operation'] = "<a class='btn red' onclick=\"fg_delete({$v['goods_commonid']})\"><i class='fa fa-trash-o'></i>删除</a><a class='btn blue' href='index.php?m=goods_online&a=edit_goods&commonid={$v['goods_commonid']}'><i class='fa fa-pencil-square-o'></i>编辑</a>";
                $list['goods_commonid'] = $v['goods_commonid'];
                //$list['goods_name'] = "<a href='". urlShop('goods', 'index', array('goods_id' => $storage_array[$v['goods_commonid']]['goods_id']))."' target='_blank'>".$v['goods_name']."</a>"; 
                $list['goods_name'] = "<a href='". urlShop('goods_itemIndex', 'index', array('goods_id' => $storage_array[$v['goods_commonid']]['goods_id']))."' target='_blank'>".$v['goods_name']."</a>";
                $list['goods_serial'] = $v['goods_serial'];
                $list['goods_barcode'] = $v['goods_barcode'];
                $list['goods_price'] = $v['goods_price'];
                $list['goods_storage'] = $storage_array[$v['goods_commonid']]['sum'];
                $list['goods_addtime'] = date('Y-m-d H:i:s',$v['goods_addtime']);             
                $data['list'][$v['goods_commonid']] = $list;
            }

        exit(Tpl::flexigridXML($data));
    }

     /**
     * 删除商品
     */
    public function deleteOp() {
        $common_id = $this->checkRequestCommonId($_GET['del_id']);
        $commonid_array = explode(',', $common_id);
        $result = Logic('goods')->goodsDrop($commonid_array, $this->store_info['store_id'], $this->seller_info['seller_id'], $this->seller_info['seller_name']);
        if ($result['state']) {
            // 添加操作日志
            $this->log("商品删除成功".'[ID:'.implode(',',$commonid_array).']',null);
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
    }

    /**
     * 商品下架
     */
    public function goods_unshowOp() {
        $common_id = $this->checkRequestCommonId($_GET['id']);
        $commonid_array = explode(',', $common_id);
        $result = Logic('goods')->goodsUnShow($commonid_array, $this->store_info['store_id'], $_SESSION['seller_id'], $_SESSION['seller_name']);
        if ($result['state']) {
            // 添加操作日志
            $this->log("商品下架成功".'[ID:'.implode(',',$commonid_array).']',null);
            exit(json_encode(array('state'=>true,'msg'=>'下架成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'下架失败')));
        }
    }

    /**
     * 设置广告词
     */
    public function edit_jingleOp() {
        if (chksubmit()) {
            $common_id = $this->checkRequestCommonId($_POST['commonid']);
            $commonid_array = explode(',', $common_id);
            $where = array('goods_commonid' => array('in', $commonid_array), 'store_id' => $this->store_info['store_id']);
            $update = array('goods_jingle' => trim($_POST['g_jingle']));
            $return = Model('goods')->editProducesNoLock($where, $update);
            if ($return) {
                // 添加操作日志
                $this->log("设置广告词".'[ID:'.implode(',',$commonid_array).']',null);
                showDialog(L('nc_common_op_succ'), 'reload', 'succ');               
            } else {
                showDialog(L('nc_common_op_fail'), 'reload');
            }
        }
        $common_id = $this->checkRequestCommonId($_GET['id']);
        Tpl::showpage('goods_list.edit_jingle', 'null_layout');
    }

     /**
     * 设置关联版式
     */
    public function edit_plateOp() {
        if (chksubmit()) {
            $common_id = $this->checkRequestCommonId($_POST['commonid']);
            $commonid_array = explode(',', $common_id);
            $where = array('goods_commonid' => array('in', $commonid_array), 'store_id' => $this->store_info['store_id']);
            $update = array();
            $update['plateid_top']        = intval($_POST['plate_top']) > 0 ? intval($_POST['plate_top']) : '';
            $update['plateid_bottom']     = intval($_POST['plate_bottom']) > 0 ? intval($_POST['plate_bottom']) : '';
            $return = Model('goods')->editGoodsCommon($update, $where);
            if ($return) {
                // 添加操作日志
                $this->log("设置关联版式".'[ID:'.implode(',',$commonid_array).']',null);
                showDialog(L('nc_common_op_succ'), 'reload', 'succ');
            } else {
                showDialog(L('nc_common_op_fail'), 'reload');
            }
        }
        $common_id = $this->checkRequestCommonId($_GET['id']);

        // 关联版式
        $plate_list = Model('store_plate')->getStorePlateList(array('store_id' => $this->store_info['store_id']), 'plate_id,plate_name,plate_position');
        $plate_list = array_under_reset($plate_list, 'plate_position', 2);
        Tpl::output('plate_list', $plate_list);
        Tpl::showpage('goods_list.edit_plate', 'null_layout');
    }

    /**
     * 验证commonid
     */
    private function checkRequestCommonId($common_ids) {
        if (!preg_match('/^[\d,]+$/i', $common_ids)) {
            exit(json_encode(array('state'=>false,'msg'=>'参数错误')));
        }
        return $common_ids;
    }


}
