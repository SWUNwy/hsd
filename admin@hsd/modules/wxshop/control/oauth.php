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
class oauthControl extends SystemControl{
    
    public function __construct(){
       
        parent::__construct();
    }

    public function indexOp() {
		Tpl::setDirquna('wxshop');
		Tpl::showpage('wxch_oauth.index');
    }
    
    public function get_xmlOp(){
        
        $condition=array();
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = array('like', '%' . $_POST['query'] . '%');
        }
        $model_wxch_oauth = Model('wxch_oauth');
		$model_wxch_cfg = Model('wxch_cfg');
        $order = '';
        $param = array('s_id','s_name');
        if (in_array($_POST['sortname'], $param) && in_array($_POST['sortorder'], array('asc', 'desc'))) {
            $order = $_POST['sortname'] . ' ' . $_POST['sortorder'];
        }

        $model_wxch_oauth = Model('wxch_oauth');
        $model_wxch_cfg = Model('wxch_cfg');
        $result=$model_wxch_cfg->getCfgInfo(array("cfg_name"=>"baseurl"));
        $cfg_baseurl = $result['cfg_value'];
        $oauth_url = $cfg_baseurl.'wechat/oauth/wxch_oauth.php?oid=';
        
        $page = $_POST['rp'];
        $oauth_list=$model_wxch_oauth->getOauthList($condition, '*' , $page);
        $data = array();
        $data['now_page'] = $model_wxch_oauth->shownowpage();
        $data['total_num'] = $model_wxch_oauth->gettotalnum();
      
        foreach($oauth_list as $value){
            $param = array();
            $operation = "<a class='btn red confirm-del' href='javascript:void(0)' onclick='oauth_delete(".$value['oid'].")'><i class='fa fa-pencil-square-o'></i>删除</a>";
            $param['operation'] =  $operation."<a class='btn blue' href='javascript:void(0)' onclick='oauth_edit(".$value['oid'].")'><i class='fa fa-pencil-square-o'></i>编辑</a>";
            
            $param['oid'] = $value['oid'];
            $param['name'] = $value['name'];
            $param['contents'] = $value['contents'];
            $param['url'] =  $oauth_url.$value['oid'];;
            $param['count'] = $value['count'];
          
            $data['list'][$value['oid']] = $param;
        }
        echo Tpl::flexigridXML($data);exit();
    }
    
    //微信OAuth增加
    public function  oauthaddOp()
    {
        $model_wxch_oauth = Model('wxch_oauth');
        if($_POST["form_submit"]=="ok")
        {
            $result = array();
            $insert=array();
            $insert['name']=$_POST["name"];
            $insert['contents']=$_POST["contents"];
            $insert['count']=0;
            $insert['status']=1;
            $res=$model_wxch_oauth->addOauth($insert);
            if($res)
            {
                $result['status'] = true;
                $result['msg'] = "操作成功";
                //showMessage("操作成功",'index.php?act=wxch_ent&op=oauth');
            }
            else
            {
                $result['status'] = false;
                $result['msg'] = "操作失败";
                //showMessage("操作失败",'index.php?act=wxch_ent&op=oauth');
            }
            	
            echo json_encode($result);
            exit();
        }
        else
        {
            Tpl::setDirquna('wxshop');
            Tpl::showpage('wxch_oauth.add');
        }
    
    }
    //微信OAuth修改
    public function  oautheditOp()
    {
        $model_wxch_oauth = Model('wxch_oauth');
        if($_POST["form_submit"]=="ok")
        {
            $result = array();
            $update=array();
            $oid = $_POST['oid'];
            $update['name']=$_POST["name"];
            $update['contents']=$_POST["contents"];
            $res=$model_wxch_oauth->editOauth($update, array("oid"=>$oid));
            if($res)
            {
                $result['status'] = true;
                $result['msg'] = "操作成功";
            }
            else
            {
               $result['status'] = false;
               $result['msg'] = "操作失败";
            }
            echo json_encode($result);
            exit();
        }
        else
        {
            $oid=$_GET["oid"];
            
            $wxch_oauth=$model_wxch_oauth->getOauthInfo(array('oid'=>$oid));
            Tpl::output('wxch_oauth',$wxch_oauth);
           
            Tpl::setDirquna('wxshop');
            Tpl::showpage('wxch_oauth.edit');
        }
    
    }
    //微信OAuth删除
    public function  oauthremoveOp()
    {
        $model_wxch_oauth = Model('wxch_oauth');
        $oid=$_GET["oid"];
        if($oid>0)
        {
            $res = array();
            $result = $model_wxch_oauth->delOauth(array('oid'=>$oid));
            $res['state'] = false;
            if($result){
                $res['state'] = true;
                $res['msg'] = "操作成功";
            }else{
                $res['msg'] = "操作失败";
            }
            echo json_encode($res);
            exit();
        }
    }

}
