<?php
/**
 * 微信接口
 *
 *
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */

//use Shopwwi\Tpl;

defined('ByShopKJYP') or exit('Access Invalid!');
class wxconfigControl extends SystemControl{
    
    public function __construct(){
       
        parent::__construct();
    }

    public function indexOp() {
		$model_wxch_config = Model('wxch_config');
		if($_POST['form_submit']!="ok")
		{
			$wxch_config= $model_wxch_config->getConfigInfo(array('id'=>1));
			Tpl::output('wxch_config',$wxch_config);
		}
		else
		{
			$update=array();
			$update['token']=$_POST["token"];
			$update['appid']=$_POST["appid"];
			$update['appsecret']=$_POST["appsecret"];
			$res=$model_wxch_config->editConfig($update, array('id'=>1));
			if($res)
			{
				showMessage("修改成功");
			}
			else
			{
				showMessage("修改失败");
			}
		}
		Tpl::setDirquna('wxshop');
		Tpl::showpage('wxch_config');
    }

}
