<?php
/**
 * 订单推送日志
 *
 *
 *
 *
 * @跨境优品
 * @license    http://www.kjyp360.com
 * @link
 */



defined('ByShopKJYP') or exit('Access Invalid!');

class orders_post_logControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        Tpl::setDirquna('shop');
    }

    /**
     * 日志列表
     */
    public function indexOp(){
        $this->listOp();
    }

    /**
     * 日志列表
     */
    public function listOp(){
        Tpl::showpage('orders_post_log.index');
    }

    /**
     * 取列表内容
     * @return [type] [description]
     */
    public function get_xmlOp(){        
        $model_post_log = Model('orders_post_log'); 
        $condition = array();
        if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = array('like', '%' . $_POST['query'] . '%');
        }         
        $order = '';
        $param = array('p_id','order_id','is_true'); 
        if (in_array($_POST['sortname'], $param) && in_array($_POST['sortorder'], array('asc', 'desc'))){
            $order = $_POST['sortname'] . ' ' . $_POST['sortorder'];        
        }   
        $page = $_POST['rp'];
        $log_list = $model_post_log->getOrdersPostList($condition,'*',$page,$order);
        $data = array();
        $data['now_page'] = $model_post_log->shownowpage();
        $data['total_num'] = $model_post_log->gettotalnum();   
        foreach($log_list as $value)
        {
            $param = array();
            $param['p_id'] = $value['p_id'];
            $param['order_id'] = $value['p_id'];
            $param['order_sn'] = $value['order_sn'];
            $param['is_true'] = $value['is_true'] == 1 ? '<span class="yes"><i class="fa fa-check-circle"></i>是</span>' : '<span class="no"><i class="fa fa-ban"></i>否</span>';
            $param['err_msg'] = $value['err_msg'];
            $param['add_time'] = date("Y-m-d H:i:s",$value['add_time']);           
            $data['list'][$value['p_id']] = $param;
        }
        echo Tpl::flexigridXML($data);exit();
    }
}
