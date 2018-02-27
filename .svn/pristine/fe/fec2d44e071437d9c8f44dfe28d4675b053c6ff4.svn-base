<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="ncsc-form-goods">
	<dl>
      <dt><?php echo $lang['store_goods_index_store_goods_class'].$lang['nc_colon'];?></dt>
      <dd><span class="new_add"><a href="javascript:void(0)" id="add_sgcategory" class="ncbtn"><?php echo $lang['store_goods_index_new_class'];?></a> </span>
        <?php if (!empty($output['store_class_goods'])) { ?>
        <?php foreach ($output['store_class_goods'] as $v) { ?>
        <select name="sgcate_id[]" class="sgcategory">
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php foreach ($output['store_goods_class'] as $val) { ?>
          <option value="<?php echo $val['stc_id']; ?>" <?php if ($v==$val['stc_id']) { ?>selected="selected"<?php } ?>><?php echo $val['stc_name']; ?></option>
          <?php if (is_array($val['child']) && count($val['child'])>0){?>
          <?php foreach ($val['child'] as $child_val){?>
          <option value="<?php echo $child_val['stc_id']; ?>" <?php if ($v==$child_val['stc_id']) { ?>selected="selected"<?php } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
          <?php }?>
          <?php }?>
          <?php } ?>
        </select>
        <?php } ?>
        <?php } else { ?>
        <select name="sgcate_id[]" class="sgcategory">
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php if (!empty($output['store_goods_class'])){?>
          <?php foreach ($output['store_goods_class'] as $val) { ?>
          <option value="<?php echo $val['stc_id']; ?>"><?php echo $val['stc_name']; ?></option>
          <?php if (is_array($val['child']) && count($val['child'])>0){?>
          <?php foreach ($val['child'] as $child_val){?>
          <option value="<?php echo $child_val['stc_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
          <?php }?>
          <?php }?>
          <?php } ?>
          <?php } ?>
        </select>
        <?php } ?>
        <p class="hint"><?php echo $lang['store_goods_index_belong_multiple_store_class'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_index_goods_show'].$lang['nc_colon'];?></dt>
      <dd>
        <ul class="ncsc-form-radio-list">
          <li>
            <label>
            	
              <input name="g_state" value="1" type="radio" <?php if ($output['goods']['goods_state'] == 1 || $output['goods']['goods_state'] == 10) {?>checked="checked"<?php }?> />
              <?php echo $lang['store_goods_index_immediately_sales'];?> </label>
          </li>
          <li>
            <label>
              <input name="g_state" value="0" type="radio" nctype="auto" />
              <?php echo $lang['store_goods_step2_start_time'];?> </label>
            <input type="text" class="w80 text" name="starttime" disabled="disabled" style="background:#E7E7E7 none;" id="starttime" value="<?php echo date('Y-m-d');?>" />
            <select disabled="disabled" style="background:#E7E7E7 none;" name="starttime_H" id="starttime_H">
              <?php foreach ($output['hour_array'] as $val){?>
              <option value="<?php echo $val;?>" <?php $sign_H = 0;if($val>=date('H') && $sign_H != 1){?>selected="selected"<?php $sign_H = 1;}?>><?php echo $val;?></option>
              <?php }?>
            </select>
            <?php echo $lang['store_goods_step2_hour'];?>
            <select disabled="disabled" style="background:#E7E7E7 none;" name="starttime_i" id="starttime_i">
              <?php foreach ($output['minute_array'] as $val){?>
              <option value="<?php echo $val;?>" <?php $sign_i = 0;if($val>=date('i') && $sign_i != 1){?>selected="selected"<?php $sign_i = 1;}?>><?php echo $val;?></option>
              <?php }?>
            </select>
            <?php echo $lang['store_goods_step2_minute'];?> </li>
          <li>
            <label>
              <input name="g_state" value="0" type="radio" <?php if (empty($output['goods']) || (!empty($output['goods']) && $output['goods']['goods_state'] == 0)) {?>checked="checked"<?php }?> />
              <?php echo $lang['store_goods_index_in_warehouse'];?> </label>
          </li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_index_goods_recommend'].$lang['nc_colon'];?></dt>
      <dd>
        <ul class="ncsc-form-radio-list">
          <li>
            <label>
              <input name="g_commend" value="1" <?php if (empty($output['goods']) || $output['goods']['goods_commend'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
              <?php echo $lang['nc_yes'];?></label>
          </li>
          <li>
            <label>
              <input name="g_commend" value="0" <?php if (!empty($output['goods']) && $output['goods']['goods_commend'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
              <?php echo $lang['nc_no'];?></label>
          </li>
        </ul>
        <p class="hint"><?php echo $lang['store_goods_index_recommend_tip'];?></p>
      </dd>
    </dl>
    <?php if (is_array($output['supplier_list'])) {?>
    <dl>
      <dt>供货商：</dt>
      <dd>
        <select name="sup_id">
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php foreach ($output['supplier_list'] as $val) {?>
          <option value="<?php echo $val['sup_id'];?>" <?php if ($output['goods']['sup_id'] == $val['sup_id']) {?>selected<?php }?>><?php echo $val['sup_name']?></option>
          <?php }?>
        </select>
        <p class="hint">可以选择商品的供货商。</p>
      </dd>
    </dl>
    <?php }?>
</div>