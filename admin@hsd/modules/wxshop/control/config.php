<?php
/**
 * 微信通设置
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
class configControl extends SystemControl{
    
    public function __construct(){
       
        parent::__construct();
    }

    public function indexOp() {

        $model_wxch_cfg = Model('wxch_cfg');
        if($_POST['form_submit']!="ok")
        {
            $wxch_cfg= $model_wxch_cfg->getCfgList($condition);
            Tpl::output('wxch_cfg',$wxch_cfg);
        }
        else
        {
            $data=array();
            $data['murl'] = $_POST['murl'];
            $data['baseurl'] = $_POST['baseurl'];
            $data['imgpath'] = $_POST['imgpath'];
            $data['plustj'] = $_POST['plustj'];
            $data['userpwd'] = $_POST['userpwd'];
            $data['cxbd'] = $_POST['cxbd'];
            $data['bd'] = $_POST['bd'];
            $data['oauth'] = $_POST['oauth'];
            $data['goods'] = $_POST['goods'];
            $data['article'] = $_POST['article'];
            $data['q_name'] = $_POST['q_name'];
            foreach($data as $k=>$v)
            {
                $res =$model_wxch_cfg->editCfg(array('cfg_value'=>$v), array('cfg_name'=>$k));
            }
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
        Tpl::showpage('wxch_cfg');
    }

}
