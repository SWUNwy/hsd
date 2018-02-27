<?php
/**
 * 订单推送日志
 *
 *
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */
defined('ByShopKJYP') or exit('Access Invalid!');
class orders_post_logModel extends Model {
    public function __construct(){
        parent::__construct('orders_post_log');
    }

    /**
     * 订单推送日志列表
     * @param array $condition
     * @param string $field
     * @param int $page
     * @return array
     */
    public function getOrdersPostList($condition, $field = '*', $page = 0 ,$order = 'p_id desc' ) {
        return $this->field($field)->where($condition)->page($page)->order($order)->select();
    }

    /**
     * 订单推送详细信息
     * @param array $condition
     * @return array
     */
    public function getOrdersPostInfo($condition) {
        return $this->where($condition)->find();
    }

    /**
     * 添加订单推送日志
     * @param unknown $insert
     * @return boolean
     */
    public function addOrdersPost($insert) {
        //判断是否失败,失败发送邮件
        if($insert['is_true'] == 0){
            $email_to = "3062607724@qq.com";
            $subject = "订单号:".$insert['order_sn']."推送失败!";
            $message = "棋棋出大事了,订单推送失败"."</br>";
            $message .= "订单号:".$insert['order_sn']."</br>";
            $message .= "失败原因:".$insert['err_msg']."</br>";
            $message .= "推送时间:".date("Y-m-d H:i:s",$insert['add_time'])."</br>";
            $email   = new Email();
            $result = $email->send_sys_email($email_to,$subject,$message);
        }
        return $this->insert($insert);
    }

    /**
     * 更新订单推送日志
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editOrdersPost($update, $condition) {
        return $this->where($condition)->update($update);
    }

    /**
     * 删除订单推送日志
     * @param array $condition
     * @return boolean
     */
    public function delOrdersPost($condition) {
        return $this->where($condition)->delete();
    }
}
