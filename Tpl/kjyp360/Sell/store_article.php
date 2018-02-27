<?php
/**
 * 运单打印
 **by 好商城V3 www.33hao.com 运营版*/


defined('ByShopKJYP') or exit('Access Invalid!');
class store_articleControl extends BaseSellerControl{
	public function __construct() {
		parent::__construct() ;
	}

    /**
     * 公告新闻 
     */
    public function indexOp() {
        $article_model	= Model('article');
		$condition 	= array();
		$condition['ac_id']	= 11;
		$condition['article_show']	= '1';
		
		if($_GET['article_title']!="")
		{
			
			$condition['article_title']	=  $_GET['article_title'];
			
		}
		
		
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('admin');
		$article_list	= $article_model->getArticleList($condition,$page);
		//print_r($article_list);
		
		Tpl::output('article',$article_list);
		Tpl::output('show_page',$page->show());
        Tpl::showpage('store_article.index');
    }

    public function articleOp()
    {
    	/**
    	 * 根据文章编号获取文章信息
    	 */
    	$article_model	= Model('article');
    	$article	= $article_model->getOneArticle(intval($_GET['article_id']));
    	if(empty($article) || !is_array($article) || $article['article_show']=='0'){
    		//showMessage("没有找到相关文章",'','html','error');//'该文章并不存在'
    		echo "<script>alert('没有找到相关文章');history.go(-1);</script>";
    		exit();
    	}
    	
    	Tpl::output('article',$article);
    	Tpl::showpage('store_article.show');
    	 
    }

}

