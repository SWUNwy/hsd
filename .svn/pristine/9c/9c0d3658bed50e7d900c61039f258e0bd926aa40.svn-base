<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<style type="text/css">
.d_inline {
      display:inline;
}
a.ncsc-btn-mini {
    line-height: 16px;
    height: 16px;
    padding: 3px 7px;
    border-radius: 2px;
}
a.ncbtn, a.ncsc-btn-mini {
    font: 400 12px/20px "microsoft yahei",arial;
    color: #FFF;
    background-color: #CCD0D9;
    text-align: center;
    vertical-align: middle;
    display: inline-block;
    height: 20px;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
}
</style>
<link href="<?php echo ADMIN_TEMPLATES_URL?>/css/seller_center.css" rel="stylesheet" type="text/css">
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
    <div class="subject">
        <h3>配送区域</h3>
        <h5>配送区域设置</h5>
      </div>
      <ul class="tab-base nc-row">
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['nc_list'];?></span></a></li>
        <li><a href="index.php?m=goods_transport&a=add"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
      <span id="explanationZoom" title="收起提示"></span> </div>
    <ul>
      <li>当管理员添区域时需选择相应的配送范围以及配送金额。</li>
    </ul>
  </div>
<!-----------------list begin------------------------>
<?php if (is_array($output['list'])){?>
<table class="ncsc-default-table order">
  <thead>
    <tr>
      <th class="w120">区域名称：</th>
      <th class="w100"><?php echo $lang['transport_to'];?></th>
      <th class="w100">首件</th>
      <th class="w100"><?php echo $lang['transport_price'];?></th>
      <th class="w100">续件</th>
      <th class="w100"><?php echo $lang['transport_price'];?></th>
    </tr>
  </thead>
  <?php foreach ($output['list'] as $v){?>
  <tbody>
    <tr>
      <td colspan="20" class="sep-row"></td>
    </tr>
    <tr>
      <th colspan="20"><?php if ($_GET['type'] == "select"){?>
        <a class="ml5 ncsc-btn-mini ncsc-btn-orange" data-param="{name:'<?php echo $v['title'];?>',id:'<?php echo $v['id'];?>',price:'<?php echo intval($output['extend'][$v['id']]['price']);?>'}" href="javascript:void(0)"><i class="icon-truck"></i><?php echo $lang['transport_applay'];?></span></a>
        <?php }?><h3><?php echo $v['title'];?></h3>
        
        <span class="fr mr5">
        <time title="<?php echo $lang['transport_tpl_edit_time'];?>"><i class="icon-time"></i><?php echo date('Y-m-d H:i:s',$v['update_time']);?></time>
        <a class="J_Clone ncsc-btn-mini" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><i class="icon-copy"></i><?php echo $lang['transport_tpl_copy'];?></a> <a class="J_Modify ncsc-btn-mini" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><i class="icon-edit"></i><?php echo $lang['transport_tpl_edit'];?></a>                 <a class="J_Delete ncsc-btn-mini" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><i class="icon-trash"></i><?php echo $lang['transport_tpl_del'];?></a></span></th>
    </tr>
    <?php if (is_array($output['extend'][$v['id']]['data'])){?>
    <?php foreach ($output['extend'][$v['id']]['data'] as $value){?>
    <tr>
      <td class="bdl"><?php echo str_replace(array('kd','py','es'),array($lang['transport_type_kd'],$lang['transport_type_py'],'EMS'),$value['type']);?></td>
      <td class="cell-area tl"><?php echo $value['area_name'];?></td>
      <td><?php echo $value['snum'];?></td>
      <td><?php echo $value['sprice'];?></td>
      <td><?php echo $value['xnum'];?></td>
      <td class="bdr"><?php echo $value['xprice'];?></td>
    </tr>
    <?php }?>
    <?php }?>
  </tbody>
  <?php }?>
</table>
<?php } else {?>
<div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div>
<?php } ?>
<?php if (is_array($output['list'])){?>
<div class="pagination"><?php echo $output['show_page']; ?></div>
<?php }?>
<!-----------------list end-----------------------> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script>
$(function(){	
	$('a[class="J_Delete ncsc-btn-mini"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		get_confirm('<?php echo $lang['transport_del_confirm'];?>','index.php?m=goods_transport&a=delete&type=<?php echo $_GET['type'];?>&id='+id);
//		$(this).attr('href','<?php echo ADMIN_SITE_URL;?>/index.php?m=goods_transport&a=delete&type=<?php echo $_GET['type'];?>&id='+id);
//		return true;
	});

	$('a[class="J_Modify ncsc-btn-mini"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		$(this).attr('href','index.php?m=goods_transport&a=edit&type=<?php echo $_GET['type'];?>&id='+id);
		return true;
	});
	
	$('a[class="J_Clone ncsc-btn-mini"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		$(this).attr('href','index.php?m=goods_transport&a=clone&type=<?php echo $_GET['type'];?>&id='+id);
		return true;
	});
	$('a[class="ml5 ncsc-btn-mini ncsc-btn-orange"]').click(function(){
		var data_str = '';
		eval('data_str = ' + $(this).attr('data-param'));
		$("#postageName", opener.document).css('display','inline-block').html(data_str.name);
		$("#transport_title", opener.document).val(data_str.name);
		$("#transport_id", opener.document).val(data_str.id);
		$("#g_freight", opener.document).val(data_str.price);
		window.close();
	});	

});
</script>