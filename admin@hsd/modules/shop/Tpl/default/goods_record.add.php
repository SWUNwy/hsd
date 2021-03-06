<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="index.php?m=goods_record&a=goods_record" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3><?php echo $lang['goods_record_index_manage']?> - 新增商品备案</h3>
        <h5><?php echo $lang['goods_record_shop_manage_subhead']?></h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>可从管理平台手动添加一名新商品备案，并填写相关信息。</li>
      <li>标识“*”的选项为必填项，其余为选填项。</li>     
    </ul>
  </div>
  <form id="goods_record_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="goods_record_id" value="<?php echo $output['goods_record_array']['goods_recordid'];?>" />    
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label for="goods_serial"><em>*</em>商品货号</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="goods_serial" id="goods_serial" value="<?php echo $output['goods_record_array']['goods_serial'];?>"  />
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="goods_code"><em>*</em>商品条码</label>
        </dt>
        <dd class="opt">
          <input type="text" class="input-txt" name="goods_code" id="goods_code" value="<?php echo $output['goods_record_array']['goods_code'];?>"  />
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="goods_sh_code"><em>*</em>商品HS编码</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_sh_code" name="goods_sh_code" value="<?php echo $output['goods_record_array']['goods_sh_code'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_goods_name"><em>*</em>海关备案商品名</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_goods_name" name="goods_goods_name" value="<?php echo $output['goods_record_array']['goods_goods_name'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>      
 			<dl class="row">
        <dt class="tit">
          <label for="goods_goods_spec"><em>*</em>规格型号</label>
        </dt>
        <dd class="opt">
        	<textarea name="goods_goods_spec" rows="6" class="tarea" id="goods_goods_spec"><?php echo $output['goods_record_array']['goods_goods_spec'];?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_declare_unit_id"><em>*</em>申报单位</label>
        </dt>
        <dd class="opt">
         <select name="goods_declare_unit_id">
            <option value="-1">请选择</option>
            <?php if(is_array($output['unit_list']) && !empty($output['unit_list'])){?>
            <?php foreach($output['unit_list'] as $val) { ?>     
            <option value="<?php echo $val['u_id']?>" <?php if ($val['u_id']== $output['goods_record_array']['goods_declare_unit_id']) {?>selected="selected"<?php }?>><?php echo $val['u_name'];?></option>
            <?php } ?>
            <?php }?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>


      <dl class="row">
        <dt class="tit">
          <label for="goods_declare_unit_id"><em>*</em>第二申报单位</label>
        </dt>
        <dd class="opt">
         <select name="goods_unit2">
            <option value="-1">请选择</option>
            <?php if(is_array($output['unit_list']) && !empty($output['unit_list'])){?>
            <?php foreach($output['unit_list'] as $val) { ?>     
            <option value="<?php echo $val['u_id']?>" <?php if ($val['u_id']== $output['goods_record_array']['goods_unit2']) {?>selected="selected"<?php }?>><?php echo $val['u_name'];?></option>
            <?php } ?>
            <?php }?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="goods_legal_unit_id"><em>*</em>第二法定单位</label>
        </dt>
        <dd class="opt">
        <select name="goods_qty2">
            <option value="-1">请选择</option>
            <?php if(is_array($output['unit_list']) && !empty($output['unit_list'])){?>
            <?php foreach($output['unit_list'] as $val) { ?>     
            <option value="<?php echo $val['u_id']?>" <?php if ($val['u_id']== $output['goods_record_array']['goods_qty2']) {?>selected="selected"<?php }?>><?php echo $val['u_name'];?></option>
            <?php } ?>
            <?php }?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      
 			<dl class="row">
        <dt class="tit">
          <label for="goods_legal_unit_id"><em>*</em>法定单位</label>
        </dt>
        <dd class="opt">
        <select name="goods_legal_unit_id">
            <option value="-1">请选择</option>
            <?php if(is_array($output['unit_list']) && !empty($output['unit_list'])){?>
            <?php foreach($output['unit_list'] as $val) { ?>     
            <option value="<?php echo $val['u_id']?>" <?php if ($val['u_id']== $output['goods_record_array']['goods_legal_unit_id']) {?>selected="selected"<?php }?>><?php echo $val['u_name'];?></option>
            <?php } ?>
            <?php }?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_conv_legal_unit_num"><em>*</em>法定折算数量</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_conv_legal_unit_num" name="goods_conv_legal_unit_num" value="<?php echo $output['goods_record_array']['goods_conv_legal_unit_num'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_in_area_unit_id"><em>*</em>入区单位</label>
        </dt>
        <dd class="opt">
          <select name="goods_in_area_unit_id">
            <option value="-1">请选择</option>
            <?php if(is_array($output['unit_list']) && !empty($output['unit_list'])){?>
            <?php foreach($output['unit_list'] as $val) { ?>     
            <option value="<?php echo $val['u_id']?>" <?php if ($val['u_id']== $output['goods_record_array']['goods_in_area_unit_id']) {?>selected="selected"<?php }?>><?php echo $val['u_name'];?></option>
            <?php } ?>
            <?php }?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_conv_in_area_unit_num"><em>*</em>入区折算数量</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_conv_in_area_unit_num" name="goods_conv_in_area_unit_num" value="<?php echo $output['goods_record_array']['goods_conv_in_area_unit_num'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_tax_no"><em>*</em>行邮税号</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_tax_no" name="goods_tax_no" value="<?php echo $output['goods_record_array']['goods_tax_no'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_tax_id"><em>*</em>消费税税率</label>
        </dt>
        <dd class="opt">
           <select name="goods_tax_id">
            <option value="-1">请选择</option>
            <?php if(is_array($output['newtax_list']) && !empty($output['newtax_list'])){?>
            <?php foreach($output['newtax_list'] as $val) { ?>
     
            <option value="<?php echo $val['tax_id']?>" <?php if ($val['tax_id']== $output['goods_record_array']['goods_tax_id']) {?>selected="selected"<?php }?>><?php echo $val['tax_rate'];?></option>
            <?php } ?>
            <?php }?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_added_tax"><em>*</em>增值税率</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_added_tax" name="goods_added_tax" value="<?php echo $output['goods_record_array']['goods_added_tax'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_gross_weight"><em>*</em>毛重</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_gross_weight" name="goods_gross_weight" value="<?php echo $output['goods_record_array']['goods_gross_weight'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_desp_arri_country_code"><em>*</em>起运国</label>
        </dt>
        <dd class="opt">
          <select name="goods_desp_arri_country_code">
                <option value="-1">请选择</option>
                <?php if(is_array($output['country_list']) && !empty($output['country_list'])){?>
                <?php foreach($output['country_list'] as $val) { ?>         
                <option value="<?php echo $val['c_id']?>" <?php if ($val['c_id']== $output['goods_record_array']['goods_desp_arri_country_code']) {?>selected="selected"<?php }?>><?php echo $val['c_name'];?></option>
                <?php } ?>
                <?php }?>
             </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_ship_tool_code"><em>*</em>运输方式</label>
        </dt>
        <dd class="opt">
          <select name="goods_ship_tool_code">
                <option value="-1">请选择</option>
                <?php if(is_array($output['ship_tool_list']) && !empty($output['ship_tool_list'])){?>
                <?php foreach($output['ship_tool_list'] as $val) { ?>
         
                <option value="<?php echo $val['t_code']?>" <?php if ($val['t_code']== $output['goods_record_array']['goods_ship_tool_code']) {?>selected="selected"<?php }?>><?php echo $val['t_name'];?></option>
                <?php } ?>
                <?php }?>
             </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_port_code"><em>*</em>进口口岸代码</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_port_code" name="goods_port_code" value="<?php echo $output['goods_record_array']['goods_port_code'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_goods_name"><em>*</em>进口日期</label>
        </dt>
        <dd class="opt">
          <input id="goods_i_e_date" name="goods_i_e_date" value="<?php echo $output['goods_record_array']['goods_i_e_date']>0?date("Y-m-d",$output['goods_record_array']['goods_i_e_date']):""; ?>" type="text"  class="txt"  />
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>                                                                                          
 			<dl class="row">
        <dt class="tit">
          <label for="goods_mode"><em>*</em>贸易方式（9610/1210）</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_mode" name="goods_mode" value="<?php echo $output['goods_record_array']['goods_mode'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_insured_fee"><em>*</em>保费</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_insured_fee" name="goods_insured_fee" value="<?php echo $output['goods_record_array']['goods_insured_fee'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
     </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_currency"><em>*</em>币制</label>
        </dt>
        <dd class="opt">
          <select name="goods_currency">
                <option value="-1">请选择</option>
                <?php if(is_array($output['currency_lsit']) && !empty($output['currency_lsit'])){?>
                <?php foreach($output['currency_lsit'] as $val) { ?>         
                <option value="<?php echo $val['c_code']?>" <?php if ($val['c_code']== $output['goods_record_array']['goods_currency']) {?>selected="selected"<?php }?>><?php echo $val['c_name'];?></option>
                <?php } ?>
                <?php }?>
             </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
 			<dl class="row">
        <dt class="tit">
          <label for="goods_net_weight"><em>*</em>净重</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_net_weight" name="goods_net_weight" value="<?php echo $output['goods_record_array']['goods_net_weight'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>  
			<dl class="row">
        <dt class="tit">
          <label for="goods_is_experiment_goods">是否试点商品</label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="show1" class="cb-enable <?php if($output['goods_record_array']['goods_is_experiment_goods'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><?php echo $lang['nc_yes'];?></label>
            <label for="show0" class="cb-disable <?php if($output['goods_record_array']['goods_is_experiment_goods'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><?php echo $lang['nc_no'];?></label>
            <input id="show1" name="goods_is_experiment_goods" <?php if($output['goods_record_array']['goods_is_experiment_goods'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="show0" name="goods_is_experiment_goods" <?php if($output['goods_record_array']['goods_is_experiment_goods'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>    
      <dl class="row">
        <dt class="tit">
          <label for="goods_check_org_code">施检机构</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_check_org_code" name="goods_check_org_code" value="<?php echo $output['goods_record_array']['goods_check_org_code'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>    
      <dl class="row">
        <dt class="tit">
          <label for="goods_producer_name">生产企业名称</label>
        </dt>
        <dd class="opt">
          <input type="text" id="goods_producer_name" name="goods_producer_name" value="<?php echo $output['goods_record_array']['goods_producer_name'];?>" class="input-txt">
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>    
      <dl class="row">
        <dt class="tit">
          <label for="goods_origin_country_code"><em>*</em>原产地</label>
        </dt>
        <dd class="opt">
          <select name="goods_origin_country_code">
            <option value="-1">请选择</option>
            <?php if(is_array($output['country_list']) && !empty($output['country_list'])){?>
            <?php foreach($output['country_list'] as $val) { ?>     
            <option value="<?php echo $val['c_id']?>" <?php if ($val['c_id']== $output['goods_record_array']['goods_origin_country_code']) {?>selected="selected"<?php }?>><?php echo $val['c_name'];?></option>
            <?php } ?>
            <?php }?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>    
      <dl class="row">
        <dt class="tit">
          <label for="goods_is_cnca_por">是否在中国备案</label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="show_1" class="cb-enable <?php if($output['goods_record_array']['goods_is_cnca_por'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><?php echo $lang['nc_yes'];?></label>
            <label for="show_0" class="cb-disable <?php if($output['goods_record_array']['goods_is_cnca_por'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><?php echo $lang['nc_no'];?></label>
            <input id="show_1" name="goods_is_cnca_por" <?php if($output['goods_record_array']['goods_is_cnca_por'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="show_0" name="goods_is_cnca_por" <?php if($output['goods_record_array']['goods_is_cnca_por'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
        </dd>
      </dl>    
      <dl class="row">
        <dt class="tit">
          <label for="goods_net_weight">检测报告</label>
        </dt>
        <dd class="opt">
          <ul class="ncsc-form-radio-list">
	          <li>
	             <input id="goods_is_cnca_por_doc" type="checkbox"  name="box[]"  value="goods_is_cnca_por_doc"  <?php if ($output['goods_record_array']['goods_is_cnca_por_doc'] == 1) {?>checked="checked"<?php }?>><label for="goods_is_cnca_por_doc">食药监局、国家认监委备案附件</label>
	          </li>
	          <li>
	             <input id="goods_is_origin_place_cert" type="checkbox" name="box[]"  value="goods_is_origin_place_cert" <?php if ($output['goods_record_array']['goods_is_origin_place_cert'] == 1) {?>checked="checked"<?php }?>><label for="goods_is_origin_place_cert">原产地证书</label>
	          </li>
	            <li>
	             <input id="goods_is_test_report" type="checkbox" name="box[]"  value="goods_is_test_report" <?php if ($output['goods_record_array']['goods_is_test_report'] == 1) {?>checked="checked"<?php }?>><label for="goods_is_test_report">境外官方及第三方机构检测报告</label>
	          </li>
	            <li>
	             <input id="goods_is_legal_ticket" type="checkbox" name="box[]"  value="goods_is_legal_ticket" <?php if ($output['goods_record_array']['goods_is_legal_ticket'] == 1) {?>checked="checked"<?php }?>><label for="goods_is_legal_ticket">合法采购证明</label>
	          </li>
	            <li>
	           <input id="goods_is_mark_exchange" type="checkbox" name="box[]"  value="goods_is_mark_exchange" <?php if ($output['goods_record_array']['goods_is_mark_exchange'] == 1) {?>checked="checked"<?php }?>><label for="goods_is_mark_exchange">外文标签的中文翻译件</label>
	          </li>
                  
          </ul>
        </dd>
      </dl>    
      <dl class="row">
        <dt class="tit">
          <label for="goods_cnca_por_doc">药监局、国家认监委备案附件</label>
        </dt>
        <dd class="opt">
          <div class="input-file-show"><span class="show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_cnca_por_doc']);?>"> <i class="fa fa-picture-o" onMouseOver="toolTip('<img src=<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_cnca_por_doc']);?>>')" onMouseOut="toolTip()"/></i> </a></span>
          <span class="type-file-box">
            <input type="text" name="textfield" id="textfield1" class="type-file-text" />
            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button" />
            <input class="type-file-file" id="goods_cnca_por_doc" name="goods_cnca_por_doc" type="file" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
          </span></div>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>  
      
      <dl class="row">
        <dt class="tit">
          <label for="goods_origin_place_cert">原产地证书</label>
        </dt>
        <dd class="opt">
          <div class="input-file-show"><span class="show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_origin_place_cert']);?>"> <i class="fa fa-picture-o" onMouseOver="toolTip('<img src=<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_origin_place_cert']);?>>')" onMouseOut="toolTip()"/></i> </a></span>
          <span class="type-file-box">
            <input type="text" name="textfield" id="textfield2" class="type-file-text" />
            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button" />
            <input class="type-file-file" id="goods_origin_place_cert" name="goods_origin_place_cert" type="file" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
          </span></div>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="goods_test_report">境外官方及第三方机构的检测报告</label>
        </dt>
        <dd class="opt">
          <div class="input-file-show"><span class="show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_test_report']);?>"> <i class="fa fa-picture-o" onMouseOver="toolTip('<img src=<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_test_report']);?>>')" onMouseOut="toolTip()"/></i> </a></span>
          <span class="type-file-box">
            <input type="text" name="textfield" id="textfield3" class="type-file-text" />
            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button" />
            <input class="type-file-file" id="goods_test_report" name="goods_test_report" type="file" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
          </span></div>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="goods_cnca_por_doc">合法采购证明（国外进货发票或小票）</label>
        </dt>
        <dd class="opt">
          <div class="input-file-show"><span class="show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_legal_ticket']);?>"> <i class="fa fa-picture-o" onMouseOver="toolTip('<img src=<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_legal_ticket']);?>>')" onMouseOut="toolTip()"/></i> </a></span>
          <span class="type-file-box">
            <input type="text" name="textfield" id="textfield4" class="type-file-text" />
            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button" />
            <input class="type-file-file" id="goods_legal_ticket" name="goods_legal_ticket" type="file" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
          </span></div>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="goods_cnca_por_doc">外文标签的中文翻译件</label>
        </dt>
        <dd class="opt">
          <div class="input-file-show"><span class="show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_mark_exchange']);?>"> <i class="fa fa-picture-o" onMouseOver="toolTip('<img src=<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.DS.$output['goods_record_array']['goods_mark_exchange']);?>>')" onMouseOut="toolTip()"/></i> </a></span>
          <span class="type-file-box">
            <input type="text" name="textfield" id="textfield5" class="type-file-text" />
            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button" />
            <input class="type-file-file" id="goods_mark_exchange" name="goods_mark_exchange" type="file" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
          </span></div>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.js"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jquery.nyroModal.js"></script>

<script type="text/javascript">
	$('#goods_i_e_date').datepicker();
	$("#goods_cnca_por_doc").change(function(){
		$("#textfield1").val($(this).val());
	});
	$("#goods_origin_place_cert").change(function(){
		$("#textfield2").val($(this).val());
	});
	$("#goods_test_report").change(function(){
		$("#textfield3").val($(this).val());
	});
	//v 3-b1 1
	$("#goods_legal_ticket").change(function(){
		$("#textfield4").val($(this).val());
	});
	$("#goods_mark_exchange").change(function(){
		$("#textfield5").val($(this).val());
	});
//裁剪图片后返回接收函数
function call_back(picname){
	$('#member_avatar').val(picname);
	$('#view_img').attr('src','<?php echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR;?>/'+picname+'?'+Math.random())
	   .attr('onmouseover','toolTip("<img src=<?php echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR;?>/'+picname+'?'+Math.random()+'>")');
}
$(function(){	
// 点击查看图片
	$('.nyroModal').nyroModal();
	
$("#submitBtn").click(function(){
    if($("#goods_record_form").valid()){
     $("#goods_record_form").submit();
	}
	});
    $('#goods_record_form').validate({
      errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span.err');
          error_td.append(error);
        },
        rules : {
            goods_serial: {
                required : true,
                remote   : {
                    url :'index.php?m=goods_record&a=ajax&branch=check_goods_serial',
                    type:'get',
                    data:{
                        	goods_serial : function(){
                            return $('#goods_serial').val();
                        },                        
                    }
                }
            },
            goods_sh_code: {
                required : true,             
            },
            goods_goods_name: {
                required : true,             
            },
            goods_goods_spec: {
                required : true,             
            },
            goods_declare_unit_id: {                
                min:0,       
            },
            goods_legal_unit_id: {                
                min:0,       
            },
           	goods_conv_legal_unit_num: {
                required : true,             
            },
            goods_in_area_unit_id: {                
                min:0,       
            },
            goods_conv_in_area_unit_num: {
                required : true,             
            },
            goods_tax_no: {
                required : true,             
            },
            goods_tax_id: {                
                min:0,       
            },
            goods_added_tax: {
                required : true,             
            },
            goods_gross_weight: {
                required : true,             
            },
            goods_desp_arri_country_code: {
                min:0,           
            },
            goods_ship_tool_code: {
                min:0,           
            },
            goods_port_code: {
                required : true,             
            },
            goods_i_e_date: {
                required : true,             
            },
            goods_mode: {
                required : true,             
            },
            goods_insured_fee: {
                required : true,             
            },
            goods_currency: {
                min:0,           
            },
            goods_net_weight: {
                required : true,             
            },
            goods_origin_country_code: {
                min:0,           
            },
        },
        messages : {           
            goods_serial  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写商品货号',   
                remote   : '<i class="fa fa-exclamation-circle"></i>商品货号已存在',
            },
            goods_sh_code  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写商品HS编码',   
            },
            goods_goods_name  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写商品名',   
            },
            goods_goods_spec  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写规格型号',   
            },
            goods_declare_unit_id  : {
                min : '<i class="fa fa-exclamation-circle"></i>请选择申报单位',   
            },
            goods_legal_unit_id  : {
                min : '<i class="fa fa-exclamation-circle"></i>请选择法定单位',   
            },
            goods_conv_legal_unit_num  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写法定折算数量',   
            },
            goods_in_area_unit_id  : {
                min : '<i class="fa fa-exclamation-circle"></i>请选择入区单位',   
            },
            goods_conv_in_area_unit_num  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写入区折算数量',   
            },
            goods_tax_no  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写行邮税号',   
            },
            goods_tax_id  : {
                min : '<i class="fa fa-exclamation-circle"></i>请选择消费税税率',   
            },
            goods_added_tax  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写增值税率',   
            },
            goods_gross_weight  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写毛重',   
            },
            goods_desp_arri_country_code  : {
                min : '<i class="fa fa-exclamation-circle"></i>请选择起运国',   
            },
            goods_ship_tool_code  : {
                min : '<i class="fa fa-exclamation-circle"></i>请选择运输方式',   
            },
            goods_port_code  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写进口口岸代码',   
            },
            goods_i_e_date  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写进口日期',   
            },
            goods_mode  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写贸易方式',   
            },
            goods_insured_fee  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写保费',   
            },
            goods_currency  : {
                min : '<i class="fa fa-exclamation-circle"></i>请选择币制',   
            },
            goods_net_weight  : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写净重',   
            },
            goods_origin_country_code  : {
                min : '<i class="fa fa-exclamation-circle"></i>请选择原产地',   
            },
        }
    });
});
</script> 
