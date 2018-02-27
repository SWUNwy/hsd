<?php
/**
 * 店铺卖家注销
 *
 *
 *
 * 
 * @license    http://www.kjyp360.com
 * @link
 * @since
 */



defined('ByShopKJYP') or exit('Access Invalid!');

class s_logoutControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();
    }

    public function indexOp() {
        $this->logoutOp();
    }

    public function logoutOp() {
        $this->recordSellerLog('注销成功');
        // 清除店铺消息数量缓存
        setNcCookie('storemsgnewnum'.$_SESSION['seller_id'],0,-3600);
        session_destroy();
        redirect('index.php?m=s_login');
    }

}
