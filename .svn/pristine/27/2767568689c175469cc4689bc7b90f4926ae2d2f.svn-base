<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_RESOURCE_URL;?>/css/datapicker/datepicker3.css" rel="stylesheet">
<script src="<?php echo ADMIN_RESOURCE_URL;?>/js/datapicker/bootstrap-datepicker.js"></script>
<div class="ncsc-form-goods">
	<h3 id="demo1" style="background-color: #fff;padding:0 "></h3>
	<dl>
	    <dt><?php echo $lang['store_goods_index_goods_class'].$lang['nc_colon'];?></dt>
	    <dd id="gcategory">      	
	      <?php echo $output['goods_class']['gc_tag_name'];?>
	      <?php if($output['edit_goods_sign']){ ?>
	      	<a href="javascript:void(0)" id="add_gcategory" class="ncbtn">编辑</a>
	      <?php } ?>	  
	      <select id="gcategory_class1" edit='<?php echo $output['edit_goods_sign']?"0":"1" ?>' style="width: auto;display:<?php echo $output['edit_goods_sign']?"none":"" ?>" >
	        <option value="0">-请选择-</option>
	        <?php if(!empty($output['gc_list']) && is_array($output['gc_list']) ) {?>
	        <?php foreach ($output['gc_list'] as $gc) {?>
	        <option value="<?php echo $gc['gc_id'];?>" data-explain="<?php echo $gc['commis_rate']; ?>"><?php echo $gc['gc_name'];?></option>
	        <?php }?>
	        <?php }?>
      	  </select>
	      	
      	  <span id="error_message" style="color:red;"></span>
	      <input type="hidden" id="cate_id" name="cate_id" value="<?php echo $output['goods_class']['gc_id'];?>" class="text" />
	      <input type="hidden" id="cate_name" name="cate_name" value="<?php echo $output['goods_class']['gc_tag_name'];?>" class="text"/>
	    </dd>
	  </dl>
	  <dl>
	    <dt><i class="required">*</i><?php echo $lang['store_goods_index_goods_name'].$lang['nc_colon'];?></dt>
	    <dd>
	      <input name="g_name" type="text" class="text w400" value="<?php echo $output['goods']['goods_name']; ?>" />
	      <span></span>
	      <p class="hint"><?php echo $lang['store_goods_index_goods_name_help'];?></p>
	    </dd>
	  </dl>
	  <dl>
	    <dt>商品卖点<?php echo $lang['nc_colon'];?></dt>
	    <dd>
	      <textarea name="g_jingle" class="textarea h60 w400"><?php echo $output['goods']['goods_jingle']; ?></textarea>
	      <span></span>
	      <p class="hint">商品卖点最长不能超过140个汉字</p>
	    </dd>
	  </dl>	  
	  <dl>
	    <dt nc_type="no_spec"><i class="required">*</i><?php echo $lang['store_goods_index_store_price'].$lang['nc_colon'];?></dt>
	    <dd nc_type="no_spec">
	      <input name="g_price" value="<?php echo ncPriceFormat($output['goods']['goods_price']); ?>" type="text"  class="text w60" /><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>
	      <p class="hint"><?php echo $lang['store_goods_index_store_price_help'];?>，且不能高于市场价。<br>
	        此价格为商品实际销售价格，如果商品存在规格，该价格显示最低价格。</p>
	    </dd>
	  </dl> 
	  <dl>
	    <dt><i class="required">*</i>市场价<?php echo $lang['nc_colon'];?></dt>
	    <dd>
	      <input name="g_marketprice" value="<?php echo ncPriceFormat($output['goods']['goods_marketprice']); ?>" type="text" class="text w60" /><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>
	      <p class="hint"><?php echo $lang['store_goods_index_store_price_help'];?>，此价格仅为市场参考售价，请根据该实际情况认真填写。</p>
	    </dd>
	  </dl>
	  <dl>
	    <dt>成本价<?php echo $lang['nc_colon'];?></dt>
	    <dd>
	      <input name="g_costprice" value="<?php echo ncPriceFormat($output['goods']['goods_costprice']); ?>" type="text" class="text w60" /><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>
	      <p class="hint">价格必须是0.00~9999999之间的数字，此价格为商户对所销售的商品实际成本价格进行备注记录，非必填选项，不会在前台销售页面中显示。</p>
	    </dd>
	  </dl>
	  <dl>
	    <dt>折扣<?php echo $lang['nc_colon'];?></dt>
	    <dd>
	      <input name="g_discount" value="<?php echo $output['goods']['goods_discount']; ?>" type="text" class="text w60" readonly style="background:#E7E7E7 none;" /><em class="add-on">%</em>
	      <p class="hint">根据销售价与市场价比例自动生成，不需要编辑。</p>
	    </dd>
	  </dl>
	  <?php if(is_array($output['spec_list']) && !empty($output['spec_list'])){?>
	  <?php $i = '0';?>
	  <?php foreach ($output['spec_list'] as $k=>$val){?>
	  <dl nc_type="spec_group_dl_<?php echo $i;?>" nctype="spec_group_dl" class="spec-bg" <?php if($k == '1'){?>spec_img="t"<?php }?>>
	    <dt>
	      <input name="sp_name[<?php echo $k;?>]" type="text" class="text w60 tip2 tr" title="自定义规格类型名称，规格值名称最多不超过4个字" value="<?php if (isset($output['goods']['spec_name'][$k])) { echo $output['goods']['spec_name'][$k];} else {echo $val['sp_name'];}?>" maxlength="4" nctype="spec_name" data-param="{id:<?php echo $k;?>,name:'<?php echo $val['sp_name'];?>'}"/>
	      <?php echo $lang['nc_colon']?></dt>
	    <dd <?php if($k == '1'){?>nctype="sp_group_val"<?php }?>>
	      <ul class="spec">
	        <?php if(is_array($val['value'])){?>
	        <?php foreach ($val['value'] as $v) {?>
	        <li><span nctype="input_checkbox">
	          <input type="checkbox" value="<?php echo $v['sp_value_name'];?>" nc_type="<?php echo $v['sp_value_id'];?>" <?php if($k == '1'){?>class="sp_val"<?php }?> name="sp_val[<?php echo $k;?>][<?php echo $v['sp_value_id']?>]">
	          </span><span nctype="pv_name"><?php echo $v['sp_value_name'];?></span></li>
	        <?php }?>
	        <?php }?>
	        <li data-param="{gc_id:<?php echo $output['goods_class']['gc_id'];?>,sp_id:<?php echo $k;?>,url:'<?php echo urlAdminShop('goods_add', 'ajax_add_spec');?>'}">
	          <div nctype="specAdd1"><a href="javascript:void(0);" class="ncbtn" nctype="specAdd"><i class="icon-plus"></i>添加规格值</a></div>
	          <div nctype="specAdd2" style="display:none;">
	            <input class="text w60" type="text" placeholder="规格值名称" maxlength="40">
	            <a href="javascript:void(0);" nctype="specAddSubmit" class="ncbtn ncbtn-aqua ml5 mr5">确认</a><a href="javascript:void(0);" nctype="specAddCancel" class="ncbtn ncbtn-bittersweet">取消</a></div>
	        </li>
	      </ul>
	      <?php if($output['edit_goods_sign'] && $k == '1'){?>
	      <p class="hint">添加或取消颜色规格时，提交后请编辑图片以确保商品图片能够准确显示。</p>
	      <?php }?>
	    </dd>
	  </dl>
	  <?php $i++;?>
	  <?php }?>
	  <?php }?>
	  <dl nc_type="spec_dl" class="spec-bg" style="display:none; overflow: visible;">
	    <dt><?php echo $lang['srore_goods_index_goods_stock_set'].$lang['nc_colon'];?></dt>
	    <dd class="spec-dd">
	      <div nctype="spec_div" class="spec-div">
	      <table border="0" cellpadding="0" cellspacing="0" class="spec_table">
	        <thead>
	          <?php if(is_array($output['spec_list']) && !empty($output['spec_list'])){?>
	          <?php foreach ($output['spec_list'] as $k=>$val){?>
	        <th nctype="spec_name_<?php echo $k;?>"><?php if (isset($output['goods']['spec_name'][$k])) { echo $output['goods']['spec_name'][$k];} else {echo $val['sp_name'];}?></th>
	          <?php }?>
	          <?php }?>
	          <th class="w90"><span class="red">*</span>市场价
	            <div class="batch"><i class="icon-edit" title="批量操作"></i>
	              <div class="batch-input" style="display:none;">
	                <h6>批量设置价格：</h6>
	                <a href="javascript:void(0)" class="close">X</a>
	                <input name="" type="text" class="text price" />
	                <a href="javascript:void(0)" class="ncbtn-mini" data-type="marketprice">设置</a><span class="arrow"></span></div>
	            </div></th>
	          <th class="w90"><span class="red">*</span><?php echo $lang['store_goods_index_price'];?>
	            <div class="batch"><i class="icon-edit" title="批量操作"></i>
	              <div class="batch-input" style="display:none;">
	                <h6>批量设置价格：</h6>
	                <a href="javascript:void(0)" class="close">X</a>
	                <input name="" type="text" class="text price" />
	                <a href="javascript:void(0)" class="ncbtn-mini" data-type="price">设置</a><span class="arrow"></span></div>
	            </div></th>
	          <th class="w60"><span class="red">*</span><?php echo $lang['store_goods_index_stock'];?>
	            <div class="batch"><i class="icon-edit" title="批量操作"></i>
	              <div class="batch-input" style="display:none;">
	                <h6>批量设置库存：</h6>
	                <a href="javascript:void(0)" class="close">X</a>
	                <input name="" type="text" class="text stock" />
	                <a href="javascript:void(0)" class="ncbtn-mini" data-type="stock">设置</a><span class="arrow"></span></div>
	            </div></th>
	          <th class="w70">预警值
	            <div class="batch"><i class="icon-edit" title="批量操作"></i>
	              <div class="batch-input" style="display:none;">
	                <h6>批量设置预警值：</h6>
	                <a href="javascript:void(0)" class="close">X</a>
	                <input name="" type="text" class="text stock" />
	                <a href="javascript:void(0)" class="ncbtn-mini" data-type="alarm">设置</a><span class="arrow"></span></div>
	            </div></th>
	          <th class="w100"><?php echo $lang['store_goods_index_goods_no'];?></th>
	          <th class="w100">商品条形码</th>
	            </thead>
	        <tbody nc_type="spec_table">
	        </tbody>
	      </table>
	      </div>
	      <p class="hint">点击<i class="icon-edit"></i>可批量修改所在列的值。<br>当规格值较多时，可在操作区域通过滑动滚动条查看超出隐藏区域。</p>
	    </dd>
	  </dl>	 
      <dl>
	    <dt nc_type="no_spec"><i class="required">*</i><?php echo "仓库".$lang['nc_colon'];?></dt>
	    <dd nc_type="no_spec">	      
	      <select name="g_storage_id" id="g_storage_id"  >
	        <option value="-1">-请选择-</option>
	        <?php if(!empty($output['ci_storage_list']) && is_array($output['ci_storage_list']) ) {?>
	        <?php foreach ($output['ci_storage_list'] as $ci_storage) {?>
	        <option value="<?php echo $ci_storage['id'];?>" <?php echo $ci_storage['id']==$output['goods']['goods_storage_id']?"selected":"" ?> ><?php echo $ci_storage['name'];?></option>
	        <?php }?>
	        <?php }?>
      	  </select>
	      <span></span>
	      <p class="hint">如下拉列表中没有仓库,请在仓库系统中商品管理里关联仓库</p>
	    </dd>
	  </dl>


	   <dl>
	    <dt nc_type="no_spec"><i class="required">*</i><?php echo "货品类型".$lang['nc_colon'];?></dt>
	    <dd nc_type="no_spec">	      
	      <select name="goods_wmstype" id="goods_wmstype"  >
	        <?php if(!empty($output['wmstype_list']) && is_array($output['wmstype_list']) ) {?>
	        <?php foreach ($output['wmstype_list'] as $wmstype) {?>
	        <option value="<?php echo $wmstype['id'];?>" <?php echo $wmstype['id']== $output['goods']['goods_wmstype'] ?"selected":"" ?> ><?php echo $wmstype['type_name'];?></option>
	        <?php }?>
	        <?php }?>
      	  </select>
	      <span></span>
	      <p class="hint"></p>
	    </dd>
	  </dl>
      <dl>
	    <dt nc_type="no_spec"><i class="required">*</i><?php echo "有效期".$lang['nc_colon'];?></dt>
	    <dd nc_type="no_spec">	      
	      <div id="datepicker" >
            <input type="text" style="width:70px; height: 27px;" class="text w70 hasDatepicker" name="query_start_date" id="query_start_date" value="<?php echo $output['goods']['expiry_date']>0?date('Y-m',$output['goods']['expiry_date']):"";?>" readonly="readonly">
            <label class="add-on"><i class="icon-calendar"></i></label>
      	  </div>
	      <span></span>
	      <p class="hint">根据商品包装信息输入商品有效期</p>
	    </dd>
	  </dl>  
	  <dl>
	    <dt nc_type="no_spec"><i class="required">*</i><?php echo $lang['store_goods_index_goods_stock'].$lang['nc_colon'];?></dt>
	    <dd nc_type="no_spec">
	      <input name="g_storage" value="<?php echo $output['goods']['g_storage'];?>" type="text" class="text w60" />
	      <span></span>
	      <p class="hint"><?php echo $lang['store_goods_index_goods_stock_help'];?></p>
	    </dd>
	  </dl>
	  <dl>
	    <dt>库存预警值<?php echo $lang['nc_colon'];?></dt>
	    <dd>
	      <input name="g_alarm" value="<?php echo $output['goods']['goods_storage_alarm'];?>" type="text" class="text w60" />
	      <span></span>
	      <p class="hint">设置最低库存预警值。当库存低于预警值时商家中心商品列表页库存列红字提醒。<br>
	        请填写0~255的数字，0为不预警。</p>
	    </dd>
	  </dl>
	  <dl>
	    <dt nc_type="no_spec"><?php echo $lang['store_goods_index_goods_no'].$lang['nc_colon'];?></dt>
	    <dd nc_type="no_spec">
	      <p>
	        <input name="g_serial" value="<?php echo $output['goods']['goods_serial'];?>" type="text" class="text" />
	      </p>
	      <p class="hint"><?php echo $lang['store_goods_index_goods_no_help'];?></p>
	    </dd>
	  </dl>
	  <dl>
	    <dt nc_type="no_spec">商品条形码：</dt>
	    <dd nc_type="no_spec">
	      <p>
	        <input name="g_barcode" value="<?php echo $output['goods']['goods_barcode'];?>" type="text" class="text" />
	      </p>
	      <p class="hint">请填写商品条形码下方数字。</p>
	    </dd>
	  </dl>
	  <input type="hidden" name="image_path" id="image_path" nctype="goods_image" value="<?php echo $output['goods']['goods_image']?>" />	  
</div> 

<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/layer/layer.js"></script>    
<script>
$(function(){
	
	$('#datepicker input').datepicker({
        keyboardNavigation: false,
        forceParse: false,
		format: "yyyy-mm",
        autoclose: true
    });
	
	$("#g_storage_id").change(function(){
		return;
		var id = $(this).val();
		var barCode = $("input[name='g_barcode']").val();
		if(parseInt(id)<=0 || barCode==""){
			return;
		}
		$.ajax({
                type:"get",
                dataType:"json",
                contentType:"application/json;charset=utf-8",
                url:"index.php?m=goods_online&a=get_supplier_xml",
                data: "locationid="+id+"&barCode="+barCode,
                success:function(result){
                	$("#g_supplier_id").empty();
                	$("#g_supplier_id").append('<option value="-1">-请选择-</option>');
            
                	if(result){
                		
                		$.each(result,function(index,value){
	                    $("#g_supplier_id").append("<option g_storage='"+value.totalqty+"' value='"+value.supplier_id+"'>"+value.supplier_name+"</option>");
	                       
	                   });
                	}else{
                		layer.msg("没有找到相关供应商");
                	}
                },               
                async:false             //false表示同步
               });
	})
})	
</script>    