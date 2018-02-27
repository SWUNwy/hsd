<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="ncsc-form-goods">
	<dl nctype="virtual_null" <?php if ($output['goods']['is_virtual'] == 1) {?>style="display:none;"<?php }?>>
      <dt>是否开增值税发票：</dt>
      <dd>
        <ul class="ncsc-form-radio-list">
          <li>
            <label>
              <input name="g_vat" value="1" <?php if (!empty($output['goods']) && $output['goods']['goods_vat'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
              <?php echo $lang['nc_yes'];?></label>
          </li>
          <li>
            <label>
              <input name="g_vat" value="0" <?php if (empty($output['goods']) || $output['goods']['goods_vat'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
              <?php echo $lang['nc_no'];?></label>
          </li>
        </ul>
        <p class="hint"></p>
      </dd>
    </dl>
</div>