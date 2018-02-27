<?php
/**
 * 手机短信类
 *
 *
 *
 * 
 */
defined('ByShopKJYP') or exit('Access Invalid!');

class Analysis {
	    /*
	     * 中文分词
	     * 
	     * 
	    */
	public function get_keywords_str($content){
		define('APP_ROOT', str_replace('\\', '/', dirname(__FILE__)));
		require(APP_ROOT.'/phpanalysis.class.php');
		PhpAnalysis::$loadInit = false;
		$pa = new PhpAnalysis('utf-8', 'utf-8', false);
		$pa->LoadDict();
		$pa->SetSource($content);
		$pa->StartAnalysis( false );
		$tags = $pa->GetFinallyResult();
		if($content!="" && $tags=="")
		{
			$tags = $content;
		}
		else
		{
			$tags = str_replace(',', '%', $tags);
		}
		
		return $tags;
	}

	
	
   
}
