<?php
/**
 * 淘宝仓接口
 *
 *
 *
 *
 * @
 * @date   2016-05-13
 * @link
 */



defined('ByShopKJYP') or exit('Access Invalid!');
class storehouse_apiControl extends SystemControl{

    public function __construct(){
        parent::__construct();
    }

    public function indexOp() {
        $this->storehouse_api_settingOp();
    }
	
	/**
	 * 淘宝仓接口设置
	 */
    public function storehouse_api_settingOp() {
        $model_setting = Model('setting');
        $setting_list = $model_setting->getListSetting();
        Tpl::output('setting',$setting_list);		
		Tpl::setDirquna('system');
        Tpl::showpage('wms_api');
    }

	/**
	 * 淘宝仓接口保存
	 */
    public function storehouse_api_saveOp() {    	
        $model_setting = Model('setting');
		$update_array = array();
        $update_array['tao_url'] = $_POST['tao_url'];
        $update_array['tao_dhfcode'] = $_POST['tao_dhfcode'];
        $update_array['tao_secretcode'] = $_POST['tao_secretcode'];
		$update_array['tao_express'] = $_POST['tao_express'];
      

        $result = $model_setting->updateSetting($update_array);
        if ($result === true){
          	$this->log('仓库接口保存', 1);
            showMessage(Language::get('nc_common_save_succ'));
        }else {
            $this->log('仓库接口保存', 0);
            showMessage(Language::get('nc_common_save_fail'));
        }
    }

    /**
     * wms接口保存
     * @return [type] [description]
     */
    public function wms_saveOp() {       
        $model_setting = Model('setting');
        $update_array = array();
        /*
        $update_array['tao_url'] = $_POST['tao_url'];
        $update_array['tao_dhfcode'] = $_POST['tao_dhfcode'];
        $update_array['tao_secretcode'] = $_POST['tao_secretcode'];
        $update_array['tao_express'] = $_POST['tao_express'];
        */
        $update_array['wms_url'] = $_POST['wms_url'];
        $update_array['wms_user'] = $_POST['wms_user'];
        $update_array['wms_code'] = $_POST['wms_code'];
        $update_array['wms_key'] = $_POST['wms_key'];
        $update_array['wms_express'] = $_POST['wms_express'];
        
        $result = $model_setting->updateSetting($update_array);
        if ($result === true){
            $this->log('仓库接口保存', 1);
            showMessage(Language::get('nc_common_save_succ'));
        }else {
            $this->log('仓库接口保存', 0);
            showMessage(Language::get('nc_common_save_fail'));
        }
    }
}
