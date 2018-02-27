<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="ncsc-form-goods">
	<dl>
	  <dt><?php echo $lang['store_goods_index_goods_szd'].$lang['nc_colon']?></dt>
	  <dd>
	    <input type="hidden" value="<?php echo $output['goods']['areaid_2'] ? $output['goods']['areaid_2'] : $output['goods']['areaid_1'];?>" name="region" id="region">
	    <input type="hidden" value="<?php echo $output['goods']['areaid_1'];?>" name="province_id" id="_area_1">
	    <input type="hidden" value="<?php echo $output['goods']['areaid_2'];?>" name="city_id" id="_area_2">
	    </p>
	  </dd>
	</dl>
	<dl nctype="virtual_null" <?php if ($output['goods']['is_virtual'] == 1) {?>style="display:none;"<?php }?>>
	  <dt><?php echo $lang['store_goods_index_goods_transfee_charge'].$lang['nc_colon']; ?></dt>
	  <dd>
	    <ul class="ncsc-form-radio-list">
	      <li>
	        <input id="freight_0" nctype="freight" name="freight" class="radio" type="radio" <?php if (intval($output['goods']['transport_id']) == 0) {?>checked="checked"<?php }?> value="0">
	        <label for="freight_0">固定运费</label>
	        <div nctype="div_freight" <?php if (intval($output['goods']['transport_id']) != 0) {?>style="display: none;"<?php }?>>
	          <input id="g_freight" class="w50 text" nc_type='transport' type="text" value="<?php printf('%.2f', floatval($output['goods']['goods_freight']));?>" name="g_freight"><em class="add-on"><i class="icon-renminbi"></i></em> </div>
	      </li>
	      <li>
	        <input id="freight_1" nctype="freight" name="freight" class="radio" type="radio" <?php if (intval($output['goods']['transport_id']) != 0) {?>checked="checked"<?php }?> value="1">
	        <label for="freight_1"><?php echo $lang['store_goods_index_use_tpl'];?></label>
	        <div nctype="div_freight" <?php if (intval($output['goods']['transport_id']) == 0) {?>style="display: none;"<?php }?>>
	          <input id="transport_id" type="hidden" value="<?php echo $output['goods']['transport_id'];?>" name="transport_id">
	          <input id="transport_title" type="hidden" value="<?php echo $output['goods']['transport_title'];?>" name="transport_title">
	          <span id="postageName" class="transport-name" <?php if ($output['goods']['transport_title'] != '' && intval($output['goods']['transport_id'])) {?>style="display: inline-block;"<?php }?>><?php echo $output['goods']['transport_title'];?></span><a href="JavaScript:void(0);" onclick="window.open('index.php?m=goods_transport&type=select')" class="ncbtn" id="postageButton"><i class="icon-truck"></i><?php echo $lang['store_goods_index_select_tpl'];?></a> </div>
	      </li>
	    </ul>
	    <p class="hint">运费设置为 0 元，前台商品将显示为免运费。</p>
	  </dd>
	</dl>
</div>