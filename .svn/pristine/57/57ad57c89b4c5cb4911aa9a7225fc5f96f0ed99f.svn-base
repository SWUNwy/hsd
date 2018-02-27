<?php
/**
 * 海关接口
 *
 *
 *
 *
 * @
 * @license   
 * @link
 */



defined('ByShopKJYP') or exit('Access Invalid!');
class customs_apiControl extends SystemControl{

    public function __construct(){
        parent::__construct();
    }

    public function indexOp() {
        $this->customs_api_settingOp();
    }

    public function customs_api_settingOp() {
        $model_setting = Model('setting');
        $setting_list = $model_setting->getListSetting();
        Tpl::output('setting',$setting_list);		
		Tpl::setDirquna('system');
        Tpl::showpage('customs_api');
    }

    public function customs_api_saveOp() {    	
        $model_setting = Model('setting');
		$update_array = array();
        $update_array['hg_isuse'] = intval($_POST['hg_isuse']);
        $update_array['hg_url'] = $_POST['hg_url'];
        $update_array['hg_qyname'] = $_POST['hg_qyname'];
		$update_array['hg_user'] = $_POST['hg_user'];
		$update_array['hg_pwd'] = $_POST['hg_pwd'];
		$update_array['hg_dxpid'] = $_POST['hg_dxpid'];
		$update_array['hg_type'] = $_POST['hg_type'];
        $result = $model_setting->updateSetting($update_array);
        if ($result === true){
          	$this->log('海关接口保存', 1);
            showMessage(Language::get('nc_common_save_succ'));
        }else {
            $this->log('海关接口保存', 0);
            showMessage(Language::get('nc_common_save_fail'));
        }
    }
}
