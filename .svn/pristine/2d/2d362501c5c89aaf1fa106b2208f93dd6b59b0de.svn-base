<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="ncsc-form-goods">
	<dl style="overflow: visible;">
	  <dt><?php echo $lang['store_goods_index_goods_brand'].$lang['nc_colon'];?></dt>
	  <dd>
	    <div class="ncsc-brand-select">
	      <div class="selection">
	        <input name="b_name" id="b_name" value="<?php echo $output['goods']['brand_name'];?>" type="text" class="text w180" readonly /><input type="hidden" name="b_id" id="b_id" value="<?php echo $output['goods']['brand_id'];?>" /><em class="add-on"><i class="icon-collapse"></i></em></div>
	      <div class="ncsc-brand-select-container">
	        <div class="brand-index" data-tid="<?php echo $output['goods_class']['type_id'];?>" data-url="<?php echo urlAdminShop('goods_add', 'ajax_get_brand');?>">
	          <div class="letter" nctype="letter">
	            <ul>
	              <li><a href="javascript:void(0);" data-letter="all">全部品牌</a></li>
	              <li><a href="javascript:void(0);" data-letter="A">A</a></li>
	              <li><a href="javascript:void(0);" data-letter="B">B</a></li>
	              <li><a href="javascript:void(0);" data-letter="C">C</a></li>
	              <li><a href="javascript:void(0);" data-letter="D">D</a></li>
	              <li><a href="javascript:void(0);" data-letter="E">E</a></li>
	              <li><a href="javascript:void(0);" data-letter="F">F</a></li>
	              <li><a href="javascript:void(0);" data-letter="G">G</a></li>
	              <li><a href="javascript:void(0);" data-letter="H">H</a></li>
	              <li><a href="javascript:void(0);" data-letter="I">I</a></li>
	              <li><a href="javascript:void(0);" data-letter="J">J</a></li>
	              <li><a href="javascript:void(0);" data-letter="K">K</a></li>
	              <li><a href="javascript:void(0);" data-letter="L">L</a></li>
	              <li><a href="javascript:void(0);" data-letter="M">M</a></li>
	              <li><a href="javascript:void(0);" data-letter="N">N</a></li>
	              <li><a href="javascript:void(0);" data-letter="O">O</a></li>
	              <li><a href="javascript:void(0);" data-letter="P">P</a></li>
	              <li><a href="javascript:void(0);" data-letter="Q">Q</a></li>
	              <li><a href="javascript:void(0);" data-letter="R">R</a></li>
	              <li><a href="javascript:void(0);" data-letter="S">S</a></li>
	              <li><a href="javascript:void(0);" data-letter="T">T</a></li>
	              <li><a href="javascript:void(0);" data-letter="U">U</a></li>
	              <li><a href="javascript:void(0);" data-letter="V">V</a></li>
	              <li><a href="javascript:void(0);" data-letter="W">W</a></li>
	              <li><a href="javascript:void(0);" data-letter="X">X</a></li>
	              <li><a href="javascript:void(0);" data-letter="Y">Y</a></li>
	              <li><a href="javascript:void(0);" data-letter="Z">Z</a></li>
	              <li><a href="javascript:void(0);" data-letter="0-9">其他</a></li>
	            </ul>
	          </div>
	          <div class="search" nctype="search">
	            <input name="search_brand_keyword" id="search_brand_keyword" type="text" class="text" placeholder="品牌名称关键字查找"/><a href="javascript:void(0);" class="ncbtn-mini" style="vertical-align: top;">Go</a></div>
	        </div>
	        <div class="brand-list" nctype="brandList">
	          <ul nctype="brand_list">
	            <?php if(is_array($output['brand_list']) && !empty($output['brand_list'])){?>
	            <?php foreach($output['brand_list'] as $val) { ?>
	            <li data-id='<?php echo $val['brand_id'];?>'data-name='<?php echo $val['brand_name'];?>'><em><?php echo $val['brand_initial'];?></em><?php echo $val['brand_name'];?></li>
	            <?php } ?>
	            <?php }?>
	          </ul>
	        </div>
	        <div class="no-result" nctype="noBrandList" style="display: none;">没有符合"<strong>搜索关键字</strong>"条件的品牌</div>
	        <div class="tc"><a href="javascript:void(0);" class="ncbtn-mini" onclick="$(this).parents('.ncsc-brand-select-container:first').hide();">关闭品牌列表</a></div>
	      </div>
	      
	    </div>
	  </dd>
	</dl>
	<?php if(is_array($output['attr_list']) && !empty($output['attr_list'])){?>
	<dl>
	  <dt><?php echo $lang['store_goods_index_goods_attr'].$lang['nc_colon']; ?></dt>
	  <dd>
	    <?php foreach ($output['attr_list'] as $k=>$val){?>
	    <span class="property">
	    <label class="mr5"><?php echo $val['attr_name']?></label>
	    <input type="hidden" name="attr[<?php echo $k;?>][name]" value="<?php echo $val['attr_name']?>" />
	    <?php if(is_array($val) && !empty($val)){?>
	    <select name="" attr="attr[<?php echo $k;?>][__NC__]" nc_type="attr_select">
	      <option value='不限' nc_type='0'>不限</option>
	      <?php foreach ($val['value'] as $v){?>
	      <option value="<?php echo $v['attr_value_name']?>" <?php if(isset($output['attr_checked']) && in_array($v['attr_value_id'], $output['attr_checked'])){?>selected="selected"<?php }?> nc_type="<?php echo $v['attr_value_id'];?>"><?php echo $v['attr_value_name'];?></option>
	      <?php }?>
	    </select>
	    <?php }?>
	    </span>
	    <?php }?>
	  </dd>
	</dl>
	<?php }?>
	<?php if (!empty($output['custom_list'])) {?>
	<dl>
	  <dt>自定义属性：</dt>
	  <dd>
	    <?php foreach ($output['custom_list'] as $val) {?>
	    <span class="property">
	      <label class="mr5"><?php echo $val['custom_name'];?></label>
	      <input type="hidden" name="custom[<?php echo $val['custom_id'];?>][name]" value="<?php echo $val['custom_name'];?>" />
	      <input class="text w60" type="text" name="custom[<?php echo $val['custom_id'];?>][value]" value="<?php if ($output['goods']['goods_custom'][$val['custom_id']]['value'] != '') {echo $output['goods']['goods_custom'][$val['custom_id']]['value'];}?>" />
	    </span>
	    <?php }?>
	  </dd>
	</dl>
	<?php }?>   
	<dl>
	  <dt><?php echo $lang['store_goods_index_goods_desc'].$lang['nc_colon'];?></dt>
	  <dd id="ncProductDetails">
	    <div class="tabs" >
	      <ul class="ui-tabs-nav tab-base nc-row">
	        <li class="" nc_type="showdata"><a href="#panel-1"><i class="icon-desktop"></i> 电脑端</a></li>
	        <li class="" nc_type="showdata"><a href="#panel-2"><i class="icon-mobile-phone"></i>手机端</a></li>
	      </ul>
	      <div id="panel-1" class="ui-tabs-panel">
	        <?php showEditor('g_body',$output['goods']['goods_body'],'100%','480px','visibility:hidden;',"false",$output['editor_multimedia']);?>
	        <div class="hr8">
	          <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
	            <input type="file" hidefocus="true" size="1" class="input-file" name="add_album" id="add_album" multiple>
	            </span>
	            <p><i class="icon-upload-alt" data_type="0" nctype="add_album_i"></i>图片上传</p>
	            </a> </div>
	          <a class="ncbtn mt5" nctype="show_desc" href="index.php?m=store_album&a=pic_list&item=des"><i class="icon-picture"></i><?php echo $lang['store_goods_album_insert_users_photo'];?></a> <a href="javascript:void(0);" nctype="del_desc" class="ncbtn mt5" style="display: none;"><i class=" icon-circle-arrow-up"></i>关闭相册</a> 
	          
	          
	         <a class="ncbtn" href="index.php?m=store_album&a=pic_list_1&item=des" nctype="show_desc1"><i class="icon-picture"></i>从图片空间选择</a> 
	          <a href="javascript:void(0);" nctype="del_desc1" class="ncbtn ml5" style="display: none;"><i class="icon-circle-arrow-up"></i>关闭相册</a>  
	          
	        </div> 
	        <p id="des_demo"></p>
	       
	      </div>
	      <div id="panel-2" class="ui-tabs-panel ui-tabs-hide">
	        <div class="ncsc-mobile-editor">
	          <div class="pannel">
	            <div class="size-tip"><span nctype="img_count_tip">图片总数不得超过<em>20</em>张</span><i>|</i><span nctype="txt_count_tip">文字不得超过<em>5000</em>字</span></div>
	            <div class="control-panel" nctype="mobile_pannel">
	              <?php if (!empty($output['goods']['mb_body'])) {?>
	              <?php foreach ($output['goods']['mb_body'] as $val) {?>
	              <?php if ($val['type'] == 'text') {?>
	              <div class="module m-text">
	                <div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_edit" href="javascript:void(0);">编辑</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>
	                <div class="content">
	                  <div class="text-div"><?php echo $val['value'];?></div>
	                </div>
	                <div class="cover"></div>
	              </div>
	              <?php }?>
	              <?php if ($val['type'] == 'image') {?>
	              <div class="module m-image">
	                <div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_rpl" href="javascript:void(0);">替换</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>
	                <div class="content">
	                  <div class="image-div"><img src="<?php echo $val['value'];?>"></div>
	                </div>
	                <div class="cover"></div>
	              </div>
	              <?php }?>
	              <?php }?>
	              <?php }?>
	            </div>
	            <div class="add-btn">
	              <ul class="btn-wrap">
	                <li><a href="javascript:void(0);" nctype="mb_add_img"><i class="icon-picture"></i>
	                  <p>图片</p>
	                  </a></li>
	                <li><a href="javascript:void(0);" nctype="mb_add_txt"><i class="icon-font"></i>
	                  <p>文字</p>
	                  </a></li>
	              </ul>
	            </div>
	          </div>
	          <div class="explain">
	            <dl>
	              <dt>1、基本要求：</dt>
	              <dd>（1）手机详情总体大小：图片+文字，图片不超过20张，文字不超过5000字；</dd>
	              <dd>建议：所有图片都是本宝贝相关的图片。</dd>
	            </dl><dl>
	              <dt>2、图片大小要求：</dt>
	              <dd>（1）建议使用宽度480 ~ 620像素、高度小于等于960像素的图片；</dd>
	              <dd>（2）格式为：JPG\JEPG\GIF\PNG；</dd>
	              <dd>举例：可以上传一张宽度为480，高度为960像素，格式为JPG的图片。</dd>
	            </dl><dl>
	              <dt>3、文字要求：</dt>
	              <dd>（1）每次插入文字不能超过500个字，标点、特殊字符按照一个字计算；</dd>
	              <dd>（2）请手动输入文字，不要复制粘贴网页上的文字，防止出现乱码；</dd>
	              <dd>（3）以下特殊字符“<”、“>”、“"”、“'”、“\”会被替换为空。</dd>
	              <dd>建议：不要添加太多的文字，这样看起来更清晰。</dd>
	            </dl>
	          </div>
	        </div>
	        <div class="ncsc-mobile-edit-area" nctype="mobile_editor_area">
	          <div nctype="mea_img" class="ncsc-mea-img" style="display: none;"></div>
	          <div class="ncsc-mea-text" nctype="mea_txt" style="display: none;">
	            <p id="meat_content_count" class="text-tip"></p>
	            <textarea class="textarea valid" nctype="meat_content"></textarea>
	            <div class="button"><a class="ncbtn ncbtn-bluejeansjeansjeans" nctype="meat_submit" href="javascript:void(0);">确认</a><a class="ncbtn ml10" nctype="meat_cancel" href="javascript:void(0);">取消</a></div>
	            <a class="text-close" nctype="meat_cancel" href="javascript:void(0);">X</a>
	          </div>
	        </div>
	        <input name="m_body" autocomplete="off" type="hidden" value='<?php echo $output['goods']['mobile_body'];?>'>
	      </div>
	    </div>
	  </dd>
	</dl>
	<dl>
	  <dt>关联版式：</dt>
	  <dd> <span class="mr50">
	    <label>顶部版式</label>
	    <select name="plate_top">
	      <option>请选择</option>
	      <?php if (!empty($output['plate_list'][1])) {?>
	      <?php foreach ($output['plate_list'][1] as $val) {?>
	      <option value="<?php echo $val['plate_id']?>" <?php if ($output['goods']['plateid_top'] == $val['plate_id']) {?>selected="selected"<?php }?>><?php echo $val['plate_name'];?></option>
	      <?php }?>
	      <?php }?>
	    </select>
	    </span> <span class="mr50">
	    <label>底部版式</label>
	    <select name="plate_bottom">
	      <option>请选择</option>
	      <?php if (!empty($output['plate_list'][0])) {?>
	      <?php foreach ($output['plate_list'][0] as $val) {?>
	      <option value="<?php echo $val['plate_id']?>" <?php if ($output['goods']['plateid_bottom'] == $val['plate_id']) {?>selected="selected"<?php }?>><?php echo $val['plate_name'];?></option>
	      <?php }?>
	      <?php }?>
	    </select>
	    </span> </dd>
	</dl>
	<!-- 只有可发布虚拟商品才会显示 S -->
	<?php if ($output['goods_class']['gc_virtual'] == 1) {?>
	<h3 id="demo3">特殊商品</h3>
	<dl class="special-01">
	  <dt>虚拟商品<?php echo $lang['nc_colon'];?></dt>
	  <dd>
	    <?php if ($output['edit_goods_sign']) {?>
	      <input type="hidden" name="is_gv" value="<?php echo $output['goods']['is_virtual'];?>">
	    <?php }?>
	    <ul class="ncsc-form-radio-list">
	      <li>
	        <input type="radio" name="is_gv" value="1" id="is_gv_1" <?php if ($output['goods']['is_virtual'] == 1) {?>checked<?php }?> <?php if ($output['edit_goods_sign']) {?>disabled<?php }?>>
	        <label for="is_gv_1">是</label>
	      </li>
	      <li>
	        <input type="radio" name="is_gv" value="0" id="is_gv_0" <?php if ($output['goods']['is_virtual'] == 0) {?>checked<?php }?> <?php if ($output['edit_goods_sign']) {?>disabled<?php }?>>
	        <label for="is_gv_0">否</label>
	      </li>
	    </ul>
	    <p class="hint vital">*虚拟商品不能参加限时折扣和组合销售两种促销活动。也不能赠送赠品和推荐搭配。</p>
	  </dd>
	</dl>
	<dl class="special-01" nctype="virtual_valid" <?php if ($output['goods']['is_virtual'] == 0) {?>style="display:none;"<?php }?>>
	  <dt><i class="required">*</i>虚拟商品有效期至<?php echo $lang['nc_colon'];?></dt>
	  <dd>
	    <input type="text" name="g_vindate" id="g_vindate" class="w80 text" value="<?php if($output['goods']['is_virtual'] == 1 && !empty($output['goods']['virtual_indate'])) { echo date('Y-m-d', $output['goods']['virtual_indate']);}?>"><em class="add-on"><i class="icon-calendar"></i></em>
	    <span></span>
	    <p class="hint">虚拟商品可兑换的有效期，过期后商品不能购买，电子兑换码不能使用。</p>
	  </dd>
	</dl>
	<dl class="special-01" nctype="virtual_valid" <?php if ($output['goods']['is_virtual'] == 0) {?>style="display:none;"<?php }?>>
	  <dt><i class="required">*</i>虚拟商品购买上限<?php echo $lang['nc_colon'];?></dt>
	  <dd>
	    <input type="text" name="g_vlimit" id="g_vlimit" class="w80 text" value="<?php if ($output['goods']['is_virtual'] == 1) {echo $output['goods']['virtual_limit'];}?>">
	    <span></span>
	    <p class="hint">请填写1~10之间的数字，虚拟商品最高购买数量不能超过10个。</p>
	  </dd>
	</dl>
	<dl class="special-01" nctype="virtual_valid" <?php if ($output['goods']['is_virtual'] == 0) {?>style="display:none;"<?php }?>>
	  <dt>支持过期退款<?php echo $lang['nc_colon'];?></dt>
	  <dd>
	    <ul class="ncsc-form-radio-list">
	      <li>
	        <input type="radio" name="g_vinvalidrefund" id="g_vinvalidrefund_1" value="1" <?php if ($output['goods']['virtual_invalid_refund'] ==1) {?>checked<?php }?>>
	        <label for="g_vinvalidrefund_1">是</label>
	      </li>
	      <li>
	        <input type="radio" name="g_vinvalidrefund" id="g_vinvalidrefund_0" value="0" <?php if ($output['goods']['virtual_invalid_refund'] == 0) {?>checked<?php }?>>
	        <label for="g_vinvalidrefund_0">否</label>
	      </li>
	    </ul>
	    <p class="hint">兑换码过期后是否可以申请退款。</p>
	  </dd>
	</dl>
	<?php }?>
	<!-- 只有可发布虚拟商品才会显示 E --> 
</div>
