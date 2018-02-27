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
class goods_offlineControl extends SystemControl {
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
        $this->goods_storageOp();
    }

    /**
     * 仓库中的商品列表
     */
    public function goods_storageOp() {
        Tpl::showpage('goods_list.offline');
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
        $goods_list = $model_goods->getGoodsCommonOfflineList($condition,'*',$page,$order);
        // 计算库存
        $storage_array = $model_goods->calculateStorage($goods_list);        
        $data = array();
        $data['now_page'] = $model_goods->shownowpage();
        $data['total_num'] = $model_goods->gettotalnum();   
        foreach ($goods_list as $k => $v){
                $list = array();
                $list['operation'] = "<a class='btn red' onclick=\"fg_delete({$v['goods_commonid']})\"><i class='fa fa-trash-o'></i>删除</a><a class='btn blue' href='index.php?m=goods_online&a=edit_goods&commonid={$v['goods_commonid']}'><i class='fa fa-pencil-square-o'></i>编辑</a>";
                $list['goods_commonid'] = $v['goods_commonid'];
                $list['goods_name'] = "<a href='". urlShop('goods', 'index', array('goods_id' => $storage_array[$v['goods_commonid']]['goods_id']))."' target='_blank'>".$v['goods_name']."</a>"; 
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
     * 商品上架
     */
    public function goods_showOp() {
        $commonid = $_GET['id'];
        if (!preg_match('/^[\d,]+$/i', $commonid)) {
           exit(json_encode(array('state'=>false,'msg'=>'参数有误，请重试！')));
        }
        $commonid_array = explode(',', $commonid);
        $result = Logic('goods')->goodsShow($commonid_array, $this->store_info['store_id'], $_SESSION['seller_id'], $_SESSION['seller_name']);
        if ($result['state']) {
            $this->log("商品上架成功".'[ID:'.implode(',',$commonid_array).']',null);
            exit(json_encode(array('state'=>true,'msg'=>'上架成功')));
        } else {            
            exit(json_encode(array('state'=>false,'msg'=>'上架失败')));
        }
    }
}
