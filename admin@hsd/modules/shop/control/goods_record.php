<?php
/**
 * 商品备案
 *
 *
 *
 *
 * @
 * @license    
 * @link
 */



defined('ByShopKJYP') or exit('Access Invalid!');
class goods_recordControl extends SystemControl{

    const EXPORT_SIZE = 5000;
    public function __construct() {
        parent::__construct ();
        Language::read('goods_record');
		Tpl::setDirquna('shop');/*设置模版路径*/
    }

    public function indexOp() {
        $this->goods_recordOp();
    }
	
  	/**
	 * 商品备案列表
	 */
	public function goods_recordOp(){		
		Tpl::showpage('goods_record.index');
	}

	/**
    * 输出XML数据
    */
	public function get_xmlOp()
	{
		$condition=array();
		if ($_POST['query'] != '') {
            $condition[$_POST['qtype']] = array('like', '%' . $_POST['query'] . '%');
        }
		$model_goods_record = Model('goods_record');			
		$order = '';
		$param = array('goods_recordid','goods_serial','goods_goods_name','messagecode','taocode');	
		if (in_array($_POST['sortname'], $param) && in_array($_POST['sortorder'], array('asc', 'desc'))) {
            $order = $_POST['sortname'] . ' ' . $_POST['sortorder'];		
        }	
			
		$page = $_POST['rp'];
		$goods_record_list=$model_goods_record->getGoodsRecordList($condition,$page,$order);
		$data = array();
        $data['now_page'] = $model_goods_record->shownowpage();
        $data['total_num'] = $model_goods_record->gettotalnum();		
		$model_country = Model('country');		
	    foreach($goods_record_list as $value)
	    {
	    	$param = array();
            $param['operation'] = "<a class='btn blue' href='index.php?m=goods_record&a=goods_record_edit&goods_record_id=" . $value['goods_recordid'] . "'><i class='fa fa-pencil-square-o'></i>编辑</a>";
			if($value['messagecode']!='30')
			{
				$param['operation'] .= "<a class='btn red' href='javascript:void(0);' onclick='ajaxget(\"" . urlAdminShop('goods_record','postCustoms',array('goods_recordid'=> $value['goods_recordid'])) . "\")'><i class='fa fa-send-o'></i>海关</a>";
			}
			if($value['taocode']!='1')
			{
				$param['operation'] .= "<a class='btn red' href='javascript:void(0);' onclick='ajaxget(\"" . urlAdminShop('goods_record','postTao',array('goods_record_id'=> $value['goods_recordid'])) . "\")'><i class='fa fa-send-o'></i>仓库</a>";
			}			
			$param['goods_record_id'] = $value['goods_recordid'];
			$param['goods_serial'] = $value['goods_serial'];
			$param['goods_sh_code'] = $value['goods_sh_code'];
			$param['goods_goods_name'] = $value['goods_goods_name'];
			$param['goods_goods_spec'] = $value['goods_goods_spec'];
			$param['goods_declare_unit_id'] = $value['goods_declare_unit_id'];
			$param['goods_legal_unit_id'] = $value['goods_legal_unit_id'];
			$param['goods_in_area_unit_id'] = $value['goods_in_area_unit_id'];
			$param['goods_conv_in_area_unit_num'] = $value['goods_conv_in_area_unit_num'];
			$param['goods_tax_no'] = $value['goods_tax_no'];
			$param['goods_tax_id'] = $this->GetNewTaxById($value['goods_tax_id']);
			$param['goods_added_tax'] = $value['goods_added_tax'];
			$param['goods_gross_weight'] = $value['goods_gross_weight'];
			$param['goods_desp_arri_country_code'] = $value['goods_desp_arri_country_code'];
			$param['goods_ship_tool_code'] = $value['goods_ship_tool_code'];
			$param['goods_port_code'] = $value['goods_port_code'];
			$param['goods_i_e_date'] = date('Y-m-d',$value['goods_i_e_date']);
			$param['goods_mode'] = $value['goods_mode'];
			$param['goods_insured_fee'] = $value['goods_insured_fee'];
			$param['goods_currency'] = $value['goods_currency'];
			$param['goods_net_weight'] = $value['goods_net_weight'];
			$param['messagecode'] = $value['messagecode'] ==  '30' ? '<span class="yes"><i class="fa fa-check-circle"></i>是</span>' : '<span class="no"><i class="fa fa-ban"></i>否</span>';
            $param['taocode'] = $value['taocode'] ==  '1' ? '<span class="yes"><i class="fa fa-check-circle"></i>是</span>' : '<span class="no"><i class="fa fa-ban"></i>否</span>';
			
			$data['list'][$value['goods_recordid']] = $param;
	    }
		echo Tpl::flexigridXML($data);exit();
	}
	
	/**
	 * 新增商品备案
	 * 
	 */
	public function goods_record_addOp()
	{
		$lang   = Language::getLangContent();
		$model_goods_record = Model('goods_record');
		if(chksubmit())
	    {			 
			 //商品备案信息
		   	$insert['goods_serial']                  = $_POST['goods_serial'];
		   	$insert['goods_code']                  = $_POST['goods_code'];
		   	$insert['goods_goods_name']              = $_POST['goods_goods_name'];
		   	$insert['goods_sh_code']                 = $_POST['goods_sh_code'];
		   	$insert['goods_goods_spec']              = $_POST['goods_goods_spec'];
		   	$insert['goods_declare_unit_id']         = $_POST['goods_declare_unit_id'];
		   	$insert['goods_legal_unit_id']           = $_POST['goods_legal_unit_id'];
		   	$insert['goods_conv_legal_unit_num']     = $_POST['goods_conv_legal_unit_num'];
		   	$insert['goods_in_area_unit_id']         = $_POST['goods_in_area_unit_id'];
		   	$insert['goods_conv_in_area_unit_num']   = $_POST['goods_conv_in_area_unit_num'];
		   	$insert['goods_tax_no']                  = $_POST['goods_tax_no'];
		   	$insert['goods_tax_id']                  = $_POST['goods_tax_id'];
		   	$insert['goods_added_tax']               = $_POST['goods_added_tax'];
		   	$insert['goods_is_experiment_goods']     = $_POST['goods_is_experiment_goods'];
		   	$insert['goods_check_org_code']          = $_POST['goods_check_org_code'];
		   	$insert['goods_producer_name']           = $_POST['goods_producer_name'];
		   	$insert['goods_origin_country_code']     = $_POST['goods_origin_country_code'];
		   	$insert['goods_supplier_name']           = $_POST['goods_supplier_name'];
		   	$insert['goods_is_cnca_por']             = $_POST['goods_is_cnca_por'];
		   	//4.8 新加字段
		   	$insert['goods_gross_weight']            = $_POST['goods_gross_weight'];
		   	$insert['goods_desp_arri_country_code']  = $_POST['goods_desp_arri_country_code'];
		   	$insert['goods_ship_tool_code']          = $_POST['goods_ship_tool_code'];
		   	$insert['goods_port_code']               = $_POST['goods_port_code'];
		   	$insert['goods_i_e_date']                = strtotime($_POST['goods_i_e_date']);
		   	$insert['goods_mode']                    = $_POST['goods_mode'];
		   	$insert['goods_insured_fee']             = $_POST['goods_insured_fee'];
		   	$insert['goods_currency']                = $_POST['goods_currency'];
		   	$insert['goods_net_weight']              = $_POST['goods_net_weight'];
		   	//2017-01-03新加字段
		   	$insert['goods_unit2']                   = $_POST['goods_unit2'];
		   	$insert['goods_qty2']                    = $_POST['goods_qty2'];
		   
		 	if(isset($_POST['box'])){
			// 证明有至少一个被选上
				$array = $_POST['box'];
				if(in_array('goods_is_cnca_por_doc',$array)){
					$insert['goods_is_cnca_por_doc']    = 1;
				}
				else
				{
					$insert['goods_is_cnca_por_doc']    = 0;
				}
				if(in_array('goods_is_origin_place_cert',$array)){
					$insert['goods_is_origin_place_cert']    = 1;
				}
				else
				{
					$insert['goods_is_origin_place_cert']    = 0;
	
				}
				if(in_array('goods_is_test_report',$array)){
					$insert['goods_is_test_report']          =1;
				}
				else
				{
					$insert['goods_is_test_report']          =0;
				}
				if(in_array('goods_is_legal_ticket',$array)){
					$insert['goods_is_legal_ticket']         = 1;
				}
				else
				{
					$insert['goods_is_legal_ticket']         = 0;
				}
				if(in_array('goods_is_mark_exchange',$array)){
					$insert['goods_is_mark_exchange']        = 1;
				}
				else
				{
					$insert['goods_is_mark_exchange']        = 0;
				}
				 
			}
		
		   if (!empty($_FILES['goods_cnca_por_doc']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_cnca_por_doc');
				  if ($result){
					  $_POST['goods_cnca_por_doc'] = $upload->file_name;
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			if (!empty($_FILES['goods_origin_place_cert']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_origin_place_cert');
				  if ($result){
					  $_POST['goods_origin_place_cert'] = $upload->file_name;
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			if (!empty($_FILES['goods_test_report']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_test_report');
				  if ($result){
					  $_POST['goods_test_report'] = $upload->file_name;
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			if (!empty($_FILES['goods_legal_ticket']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_legal_ticket');
				  if ($result){
					  $_POST['goods_legal_ticket'] = $upload->file_name;
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			if (!empty($_FILES['goods_mark_exchange']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_mark_exchange');
				  if ($result){
					  $_POST['goods_mark_exchange'] = $upload->file_name;
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
		   
		    $insert['goods_cnca_por_doc']            = $_POST['goods_cnca_por_doc'];
		    $insert['goods_origin_place_cert']       = $_POST['goods_origin_place_cert'];
		    $insert['goods_test_report']             = $_POST['goods_test_report'];
		    $insert['goods_legal_ticket']            = $_POST['goods_legal_ticket'];
		    $insert['goods_mark_exchange']           = $_POST['goods_mark_exchange'];
		  
			if($insert['goods_serial']=="")
		    {
			    showdialog('货号不能为空', '','error');
		    }
		    if($insert['goods_code']=="")
		    {
			    showdialog('条码不能为空', '','error');
		    }
		    if($insert['goods_goods_name']=="")
		    {
			    showdialog('商品名不能为空', '','error');
		    }
		    if($insert['goods_sh_code']=="")
		    {
			    showdialog('商品HS编码不能为空', '','error');
		    }
		    if($insert['goods_goods_spec']=="")
		    {
			    showdialog('规格型号不能为空', '','error');
		    }
		    if($insert['goods_declare_unit_id']=="")
		    {
			    showdialog('申报单位不能为空', '','error');
		    }
		    if($insert['goods_legal_unit_id']=="")
		    {
			    showdialog('法定单位不能为空', '','error');
		    }
		    if($insert['goods_conv_legal_unit_num']=="")
		    {
			    showdialog('法定折算数量不能为空', '','error');
		    }
		    if($insert['goods_in_area_unit_id']=="")
		    {
			    showdialog('入区单位不能为空', '','error');
		    }			
		    if($insert['goods_conv_in_area_unit_num']=="")
		    {
			    showdialog('入区折算数量不能为空', '','error');
		    }		
		    if($insert['goods_tax_no']=="")
		    {
			    showdialog('行邮税号不能为空', '','error');
		    }	
		    $goods_recordid_info=$model_goods_record->getGoodsRecord(array("goods_serial"=>$insert['goods_serial']));
		    if($goods_recordid_info)
		    {
			    showdialog('系统存在相同货号，请重试！', '','error');
		    }	
			  
			$result=$model_goods_record->addGoodsRecord($insert);		
			if($result)
			{
			    showDialog("保存成功！", 'index.php?m=goods_record&a=goods_record', 'succ');
			}
			else
			{
				showDialog("保存失败！");
			}
		}
		$country_list = Model('country')->getCountryList();
		Tpl::output('country_list', $country_list);
		//海关编号
		$unit_list = Model('unit')->getUnitList();
		Tpl::output('unit_list', $unit_list);
		//币制代码
		$currency_lsit = Model()->table("currency")->where(array())->select();
		//print_r($currency_lsit);
		Tpl::output('currency_lsit', $currency_lsit);
		//运输方式 
		$ship_tool_list = Model()->table("ship_tool")->where(array())->select();
		//print_r($ship_tool_list);
		Tpl::output('ship_tool_list', $ship_tool_list);
		//4.8号新税率
		$model_newtax = Model("newtax");
		$newtax_list = $model_newtax->getTaxList(array(),20000);			
		Tpl::output('newtax_list', $newtax_list);		
        Tpl::showpage('goods_record.add');
	}
	
	/**
	 * 修改商品备案
	 */
	public function goods_record_editOp()
	{
		$lang   = Language::getLangContent();
		$model_goods_record = Model('goods_record');
		$goods_recordid = intval($_GET['goods_record_id']);
		/**
         * 保存
         */
        if (chksubmit()){
            //商品备案信息
		    $update['goods_serial']                  = $_POST['goods_serial'];
		    $update['goods_code']                    = $_POST['goods_code'];
		    $update['goods_goods_name']              = $_POST['goods_goods_name'];
		    $update['goods_sh_code']                 = $_POST['goods_sh_code'];
		    $update['goods_goods_spec']              = $_POST['goods_goods_spec'];
		    $update['goods_declare_unit_id']         = $_POST['goods_declare_unit_id'];
		    $update['goods_legal_unit_id']           = $_POST['goods_legal_unit_id'];
		    $update['goods_conv_legal_unit_num']     = $_POST['goods_conv_legal_unit_num'];
		    $update['goods_in_area_unit_id']         = $_POST['goods_in_area_unit_id'];
		    $update['goods_conv_in_area_unit_num']   = $_POST['goods_conv_in_area_unit_num'];
		    $update['goods_tax_no']                  = $_POST['goods_tax_no'];
		    $update['goods_tax_id']                  = $_POST['goods_tax_id'];
		    $update['goods_added_tax']               = $_POST['goods_added_tax'];
		    $update['goods_is_experiment_goods']     = $_POST['goods_is_experiment_goods'];
		    $update['goods_check_org_code']          = $_POST['goods_check_org_code'];
		    $update['goods_producer_name']           = $_POST['goods_producer_name'];
		    $update['goods_origin_country_code']     = $_POST['goods_origin_country_code'];
		    $update['goods_supplier_name']           = $_POST['goods_supplier_name'];
		    $update['goods_is_cnca_por']             = $_POST['goods_is_cnca_por'];
		    //4.8 新加字段
		    $update['goods_gross_weight']            = $_POST['goods_gross_weight'];
		    $update['goods_desp_arri_country_code']  = $_POST['goods_desp_arri_country_code'];
		    $update['goods_ship_tool_code']          = $_POST['goods_ship_tool_code'];
		    $update['goods_port_code']               = $_POST['goods_port_code'];
		    $update['goods_i_e_date']                = strtotime($_POST['goods_i_e_date']);
		    $update['goods_mode']                    = $_POST['goods_mode'];
		    $update['goods_insured_fee']             = $_POST['goods_insured_fee'];
		    $update['goods_currency']                = $_POST['goods_currency'];
		    $update['goods_net_weight']              = $_POST['goods_net_weight'];
		    //2017-01-03新加字段
		   	$update['goods_unit2']                   = $_POST['goods_unit2'];
		   	$update['goods_qty2']                    = $_POST['goods_qty2'];
		   
		    
		 	if(isset($_POST['box'])){
			// 证明有至少一个被选上
				$array = $_POST['box'];
				if(in_array('goods_is_cnca_por_doc',$array)){
					$update['goods_is_cnca_por_doc']    = 1;
				}
				else
				{
					$update['goods_is_cnca_por_doc']    = 0;
				}
				if(in_array('goods_is_origin_place_cert',$array)){
					$update['goods_is_origin_place_cert']    = 1;
				}
				else
				{
					$update['goods_is_origin_place_cert']    = 0;
	
				}
				if(in_array('goods_is_test_report',$array)){
					$update['goods_is_test_report']          =1;
				}
				else
				{
					$update['goods_is_test_report']          =0;
				}
				if(in_array('goods_is_legal_ticket',$array)){
					$update['goods_is_legal_ticket']         = 1;
				}
				else
				{
					$update['goods_is_legal_ticket']         = 0;
				}
				if(in_array('goods_is_mark_exchange',$array)){
					$update['goods_is_mark_exchange']        = 1;
				}
				else
				{
					$update['goods_is_mark_exchange']        = 0;
				}
				 
			}			
	        if(!empty($_FILES['goods_cnca_por_doc']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_cnca_por_doc');
				  if ($result){
					  $_POST['goods_cnca_por_doc'] = $upload->file_name;
					  $update['goods_cnca_por_doc']            = $_POST['goods_cnca_por_doc'];
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			if (!empty($_FILES['goods_origin_place_cert']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_origin_place_cert');
				  if ($result){
					  $_POST['goods_origin_place_cert'] = $upload->file_name;
					   $update['goods_origin_place_cert']       = $_POST['goods_origin_place_cert'];
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			if (!empty($_FILES['goods_test_report']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_test_report');
				  if ($result){
					  $_POST['goods_test_report'] = $upload->file_name;
					    $update['goods_test_report']             = $_POST['goods_test_report'];
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			if (!empty($_FILES['goods_legal_ticket']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_legal_ticket');
				  if ($result){
					  $_POST['goods_legal_ticket'] = $upload->file_name;
					   $update['goods_legal_ticket']            = $_POST['goods_legal_ticket'];
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			if (!empty($_FILES['goods_mark_exchange']['name'])){
				  $upload = new UploadFile();
				  $upload->set('default_dir',ATTACH_COMMON);
				  $result = $upload->upfile('goods_mark_exchange');
				  if ($result){
					  $_POST['goods_mark_exchange'] = $upload->file_name;
					   $update['goods_mark_exchange']           = $_POST['goods_mark_exchange'];
				  }else {
					  showMessage($upload->error,'','','error');
				  }
			}
			
		    if($update['goods_serial']=="")
		    {
			    showdialog('货号不能为空', '','error');
		    }
		     if($update['goods_code']=="")
		    {
			    showdialog('条码不能为空', '','error');
		    }
		    if($update['goods_goods_name']=="")
		    {
			    showdialog('商品名不能为空', '','error');
		    }
		    if($update['goods_sh_code']=="")
		    {
			    showdialog('商品HS编码不能为空', '','error');
		    }
		    if($update['goods_goods_spec']=="")
		    {
			    showdialog('规格型号不能为空', '','error');
	     	}
		    if($update['goods_declare_unit_id']=="")
		    {
			    showdialog('申报单位不能为空', '','error');
		    }
		    if($update['goods_legal_unit_id']=="")
		    {
			    showdialog('法定单位不能为空', '','error');
		    }
		    if($update['goods_conv_legal_unit_num']=="")
		    {
			    showdialog('法定折算数量不能为空', '','error');
		    }
		    if($update['goods_in_area_unit_id']=="")
		    {
			    showdialog('入区单位不能为空', '','error');
		    }			
		    if($update['goods_conv_in_area_unit_num']=="")
		    {
			    showdialog('入区折算数量不能为空', '','error');
		    }		
		    if($update['goods_tax_no']=="")
		    {
			    showdialog('行邮税号不能为空', '','error');
	        }	
			//修改后仓库状态重置
			$update['taocode']=0;
		    $result=$model_goods_record->editGoodsRecord($update,array('goods_recordid'=>$goods_recordid));
	
       	    if($result)
		    {
			       showDialog("保存成功!", 'index.php?m=goods_record&a=goods_record', 'succ');
				   
		    }
		    else
		    {
			       showDialog("保存失败");
		    }
					
		}	
		$condition = array();
		$condition['goods_recordid'] = $goods_recordid;
        $goods_record_array = $model_goods_record->getGoodsRecord($condition);
		if(empty($goods_record_array))
		{		
			showMessage($lang['goods_record_no_record']);
		}
		
		//国家代码	    
		$country_list = Model('country')->getCountryList();
		Tpl::output('country_list', $country_list);
		//海关编号
		$unit_list = Model('unit')->getUnitList();
		Tpl::output('unit_list', $unit_list);
		//币制代码
		$currency_lsit = Model()->table("currency")->where(array())->select();
		//print_r($currency_lsit);
		Tpl::output('currency_lsit', $currency_lsit);
		//运输方式 
		$ship_tool_list = Model()->table("ship_tool")->where(array())->select();
		//print_r($ship_tool_list);
		Tpl::output('ship_tool_list', $ship_tool_list);
		//4.8号新税率
		$model_newtax = Model("newtax");
		$newtax_list = $model_newtax->getTaxList(array(),20000);			
		Tpl::output('newtax_list', $newtax_list);		
        Tpl::output('goods_record_array',$goods_record_array);		
		Tpl::showpage('goods_record.edit');
	}
	
	 /**
     * 提交备案到海关
     */
    public function postCustomsOp() {
        
		$model_datamessage= Model('datamessage');
		$model_goods_record = Model('goods_record');
		$goods_recordid=$_GET['$goods_record_id'];
		if($goods_recordid>0){
			$goods_record_info = $model_goods_record->getGoodsRecord(array("goods_recordid"=>$goods_recordid));
		    $xml_data = $model_datamessage->arraytogoodsxml($goods_record_info);
			$flag = $model_datamessage->datapost($xml_data);
			if($flag){ 					  
		        $update_message['is_postmessage']="1";
				$update = $model_goods_record->editGoodsRecord($update_message,array('goods_recordid'=>$goods_recordid));
				if (!$update) {
				    throw new Exception("操作失败");
				}	  				
				showDialog('提交海关成功', '', 'succ', '$("#flexigrid").flexReload();');
			}
			else{
				showdialog('提交海关失败', '', 'error', '$("#flexigrid").flexReload();');
			}
		}
		else{
			showdialog('参数有误，请重试','index.php?m=goods_record&a=goods_record','error');
		}
		
		
    }
    
    /**
     * 提交淘宝仓
     * 
     * 
     */
   public function postTaoOp()
   {
	   	$slwms_model = Model('slwms');
	   	$model_goods_record = Model('goods_record');
	   	$goods_recordid = $_GET['goods_record_id'];
	   	if($goods_recordid>0)
	   	{
	   		$goods_record_info=$model_goods_record->getGoodsRecord(array("goods_recordid"=>$goods_recordid));	
	   		$res = $slwms_model->skuAdd($goods_record_info);
	   		if($res['RESULTCODE'] == 0){	   			
	   			$update_message['is_taopost']="1";
	   			$update_message['taocode']=$res['result'];
	   			$update = $model_goods_record->editGoodsRecord($update_message,array('goods_recordid'=>$goods_recordid));	   			
	   			if (!$update) {
	   				throw new Exception("操作失败!");
	   			}	   			 	   			
				showDialog('提交丝路仓成功', '', 'succ', '$("#flexigrid").flexReload();');
	   		}
	   		else
	   		{   			
	   		    showdialog($res['RESULTMESSAGE'], '', 'error', '$("#flexigrid").flexReload();');
	   		}
	   	}
	   	else
	   	{
	   		showdialog('参数有误，请重试','index.php?m=goods_record&a=list','error');
	   	}
    } 
	
	/**
	 * 导出数据
	 * 
	 */
	public function export_step1Op()
	{
		$lang   = Language::getLangContent();
        $model_goods_record = Model('goods_record');
        $condition  = array();
        if (preg_match('/^[\d,]+$/', $_GET['goods_recordid'])) {
            $_GET['goods_recordid'] = explode(',',trim($_GET['goods_recordid'],','));
            $condition['goods_recordid'] = array('in',$_GET['goods_recordid']);
        }
        $this->_get_condition($condition);
        $sort_fields = $param = array('goods_recordid','goods_serial','goods_goods_name','messagecode','taocode');	
        if ($_POST['sortorder'] != '' && in_array($_POST['sortname'],$sort_fields)) {
            $order = $_POST['sortname'].' '.$_POST['sortorder'];
        } else {
            $order = 'goods_recordid desc';
        }

        if (!is_numeric($_GET['curpage'])){
            $count = $model_goods_record->getGoodsRecordCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?m=goods_record&a=index');
                Tpl::showpage('export.excel');
            }else{  //如果数量小，直接下载
                $data = $model_goods_record->getGoodsRecordList($condition, '', $order, '*',self::EXPORT_SIZE);
                $this->createExcel($data);
            }
        }else{  //下载
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;            
			$data = $model_goods_record->getGoodsRecordList($condition, '', $order, '*',"{$limit1},{$limit2}");
            $this->createExcel($data);
        }
	}
	
	/**
     * 生成excel
     *
     * @param array $data
     */
	private function createExcel($data = array()){
        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品货号');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'商品HS编码');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'商品名');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'规格型号');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'申报单位');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'法定单位');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'法定折算数量');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'入区单位');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'入区折算数量');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'行邮税号');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'消费税税率');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'增值税率');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'毛重');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'起运国');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'运输方式');
        //data
        foreach ((array)$data as $k=>$goods_record_info){
            
            $list = array();
            $list['goods_recordid'] = $goods_record_info['goods_recordid'];
            $list['goods_serial'] = $goods_record_info['goods_serial'];
			$list['goods_sh_code'] = $goods_record_info['goods_sh_code'];
			$list['goods_goods_name'] = $goods_record_info['goods_goods_name'];
			$list['goods_goods_spec'] = $goods_record_info['goods_goods_spec'];
			$list['goods_declare_unit_id'] = $goods_record_info['goods_declare_unit_id'];
			$list['goods_legal_unit_id'] = $goods_record_info['goods_legal_unit_id'];
			$list['goods_conv_legal_unit_num'] = $goods_record_info['goods_conv_legal_unit_num'];			
			$list['goods_in_area_unit_id'] = $goods_record_info['goods_in_area_unit_id'];
			$list['goods_conv_in_area_unit_num'] = $goods_record_info['goods_conv_in_area_unit_num'];
			$list['goods_tax_no'] = $goods_record_info['goods_tax_no'];
			$list['goods_tax_id'] = $this->GetNewTaxById($goods_record_info['goods_tax_id']);
			$list['goods_added_tax'] = $goods_record_info['goods_added_tax'];
			$list['goods_gross_weight'] = $goods_record_info['goods_gross_weight'];
			$list['goods_desp_arri_country_code'] = $goods_record_info['goods_desp_arri_country_code'];
			$list['goods_ship_tool_code'] = $goods_record_info['goods_ship_tool_code'];

            $tmp = array();
            $tmp[] = array('data'=>$list['goods_recordid']);
			$tmp[] = array('data'=>$list['goods_serial']);
			$tmp[] = array('data'=>$list['goods_sh_code']);
			$tmp[] = array('data'=>$list['goods_goods_name']);
			$tmp[] = array('data'=>$list['goods_goods_spec']);
			$tmp[] = array('data'=>$list['goods_declare_unit_id']);
			$tmp[] = array('data'=>$list['goods_legal_unit_id']);
			$tmp[] = array('data'=>$list['goods_conv_legal_unit_num']);			
			$tmp[] = array('data'=>$list['goods_in_area_unit_id']);
			$tmp[] = array('data'=>$list['goods_conv_in_area_unit_num']);
			$tmp[] = array('data'=>$list['goods_tax_no']);
			$tmp[] = array('data'=>$list['goods_tax_id']);
			$tmp[] = array('data'=>$list['goods_added_tax']);
			$tmp[] = array('data'=>$list['goods_gross_weight']);
			$tmp[] = array('data'=>$list['goods_desp_arri_country_code']);
			$tmp[] = array('data'=>$list['goods_ship_tool_code']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(L('exp_od_order'),CHARSET));
        $excel_obj->generateXML('goods_record-'.$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }
	/**
     * ajax操作
     */
    public function ajaxOp(){
        switch ($_GET['branch']){
            /**
             * 验证商品货号是滞已存在
             */
            case 'check_goods_serial':
                $model_goods_record = Model('goods_record');
                $condition['goods_serial']   = $_GET['goods_serial'];              
                $list = $model_goods_record->getGoodsRecord($condition);
                if (empty($list)){
                    echo 'true';exit;
                }else {
                    echo 'false';exit;
                }
                break;
        }
    }
	
	/**
	 * 通过新税ID取税率
	 */
	private function GetNewTaxById($tax_id)
	{
		$tax_info = Model('newtax')->getTaxInfo(array('tax_id'=>$tax_id));
		return $tax_info['tax_rate'];
	}
	
	/**
     * 处理搜索条件
     */
    private function _get_condition(& $condition) {
        if ($_REQUEST['query'] != '' && in_array($_REQUEST['qtype'],array('goods_serial','goods_goods_name'))) {
            $condition[$_REQUEST['qtype']] = array('like',"%{$_REQUEST['query']}%");
        }
        if ($_GET['keyword'] != '' && in_array($_GET['keyword_type'],array('goods_serial','goods_goods_name'))) {
            if ($_GET['jq_query']) {
                $condition[$_GET['keyword_type']] = $_GET['keyword'];
            } else {
                $condition[$_GET['keyword_type']] = array('like',"%{$_GET['keyword']}%");
            }
        }
       
    }
}
