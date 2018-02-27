<?php
/**
 * 订单设置管理
 *
 *
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */



defined('ByShopKJYP') or exit('Access Invalid!');
class order_setControl extends SystemControl {   
    public function __construct(){
        parent::__construct();
        Language::read('type');
    }

    public function indexOp() {
        
        $model_setting = Model('setting');
        $model_storage = Model('storage');
        if (chksubmit()){
            $update_array = array();
            $update_array['address_rule'] = $_POST['address_rule'];
            $update_array['address_message'] = $_POST['address_message'];
            $update_array['order_same_idcard'] = $_POST['order_same_idcard'];
            $update_array['order_same_idcard_msg'] = $_POST['order_same_idcard_msg'];
            $update_array['order_same_address'] = $_POST['order_same_address'];
            $update_array['order_same_address_msg'] = $_POST['order_same_address_msg'];
            $update_array['order_same_phone'] = $_POST['order_same_phone'];
            $update_array['order_same_phone_msg'] = $_POST['order_same_phone_msg'];
            $update_array['order_post_amount'] = $_POST['order_post_amount'];
            $update_array['order_post_num'] = $_POST['order_post_num'];
            //$update_array['order_storage_id'] = $_POST['order_storage_id'];
        
            $result = $model_setting->updateSetting($update_array);
            if ($result === true){
                $this->log(L('nc_edit,dis_dump'),1);
                showMessage(L('nc_common_save_succ'));
            }else {
                $this->log(L('nc_edit,dis_dump'),0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();
        $storage_list = $model_storage->getStroageList(array());
        Tpl::output('list_setting',$list_setting);
        Tpl::output('storage_list',$storage_list);
        Tpl::setDirquna('shop');
        Tpl::showpage('order_set.index');
    }

    
}
