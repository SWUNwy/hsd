<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<ul>
  <?php foreach((array)$output['address_list'] as $k=>$val){ ?>
  <?php $val['area_info'] = $val['type'].$val['area_info']?>
  <li class="receive_add address_item <?php echo $k == 0 ? 'ncc-selected-item' : null; ?>">
    <input address="<?php echo $val['area_info'].'&nbsp;'.$val['address']; ?>" true_name="<?php echo $val['true_name'];?>" member_idcard="<?php echo $val['member_idcard']; ?>" id="addr_<?php echo $val['address_id']; ?>" nc_type="addr" type="radio" class="radio" city_id="<?php echo $val['city_id']?>" area_id=<?php echo $val['area_id'];?> name="addr" value="<?php echo $val['address_id']; ?>" phone="<?php echo $val['mob_phone'] ? $val['mob_phone'] : $val['tel_phone'];?>" <?php echo $val['is_default'] == '1' ? 'checked' : null; ?> />
    <label for="addr_<?php echo $val['address_id']; ?>"><span class="true-name"><?php echo $val['true_name'];?></span><span class="true-name"><?php echo $val['member_idcard'];?></span><span class="address"><?php echo $val['area_info']; ?>&nbsp;<?php echo $val['address']; ?></span><span class="phone"><i class="icon-mobile-phone"></i><?php echo $val['mob_phone'] ? $val['mob_phone'] : $val['tel_phone'];?></span></label>
    <a href="javascript:void(0);" onclick="delAddr(<?php echo $val['address_id']?>);" class="del">[ 删除 ]</a> </li>
  <?php } ?>
  
</ul>
