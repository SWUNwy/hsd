<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['goods_record_index_name']?></h3>
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
      <li><?php echo $lang['goods_record_index_help1'];?></li>
      <li><?php echo $lang['goods_record_index_help2'];?></li>
    </ul>
  </div>
  <div id="flexigrid"></div>
</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?m=goods_record&a=get_xml',
        colModel : [   
            {display: '操作', name : 'operation', width : 180, sortable : false, align: 'center', className: ''},
            {display: '备案ID', name : 'goods_recordid', width : 40, sortable : true, align: 'center'},
          	{display: '商品货号', name : 'goods_serial', width : 120, sortable : true, align: 'center'},
          	{display: '商品HS编码', name : 'goods_sh_code', width : 120, sortable : false, align: 'center'},
          	{display: '商品名称', name : 'goods_goods_name', width :200, sortable : true, align: 'left'},
          	{display: '规格型号', name : 'goods_goods_spec', width :300, sortable : false, align: 'left'},
          	{display: '申报单位', name : 'goods_declare_unit_id', width : 50, sortable : false, align: 'center'},
          	{display: '法定单位', name : 'goods_legal_unit_id', width : 50, sortable : false, align: 'center'},
          	{display: '入区单位', name : 'goods_in_area_unit_id', width : 50, sortable : false, align: 'center'},
          	{display: '入区折算数量', name : 'goods_conv_in_area_unit_num', width : 80, sortable : false, align: 'center'},
          	{display: '行邮税号', name : 'goods_tax_no', width : 100, sortable : false, align: 'center'},
          	{display: '消费税', name : 'goods_tax_id', width : 50, sortable : false, align: 'center'},
          	{display: '增值税', name : 'goods_added_tax', width : 50, sortable : false, align: 'center'},
          	{display: '毛重(kg)', name : 'goods_gross_weight', width : 50, sortable : false, align: 'center'},
          	{display: '起运国', name : 'goods_desp_arri_country_code', width : 50, sortable : false, align: 'center'},
          	{display: '运输方式', name : 'goods_ship_tool_code', width : 50, sortable : false, align: 'center'},
          	{display: '进口口岸代码', name : 'goods_port_code', width : 100, sortable : false, align: 'center'},
          	{display: '进口日期', name : 'goods_i_e_date', width : 80, sortable : false, align: 'center'},
          	{display: '贸易方式', name : 'goods_mode', width : 50, sortable : false, align: 'center'},
          	{display: '保费', name : 'goods_insured_fee', width : 40, sortable : false, align: 'center'},
          	{display: '币制', name : 'goods_currency', width : 50, sortable : false, align: 'center'},
          	{display: '净重(kg)', name : 'goods_net_weight', width : 50, sortable : false, align: 'center'},
          	{display: '提交海关', name : 'messagecode', width : 50, sortable : true, align: 'center'},
          	{display: '提交仓库', name : 'taocode', width : 50, sortable : true, align: 'center'},
            ],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', title : '新增数据', onpress : fg_operation },
            {display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'csv', bclass : 'csv', title : '将选定行数据导出excel文件,如果不选中行，将导出列表所有数据', onpress : fg_operation }		
            ],
        searchitems : [
            {display: '商品备案名称', name : 'goods_goods_name'},
            {display: '商品备案货号', name : 'goods_serial'}
            ],
        sortname: "goods_recordid",
        sortorder: "desc",
        title: '商品备案列表'
    });
	
});

function fg_operation(name, bDiv) {
    if (name == 'add') {
        window.location.href = 'index.php?m=goods_record&a=goods_record_add';
    }
    if (name == 'csv') {
        if ($('.trSelected', bDiv).length == 0) {
            if (!confirm('您确定要下载全部数据吗？')) {
                return false;
            }
        }
        var itemids = new Array();
        $('.trSelected', bDiv).each(function(i){
            itemids[i] = $(this).attr('data-id');
        });
        fg_csv(itemids);
    }
}

function fg_csv(ids) {
    id = ids.join(',');
    window.location.href = $("#flexigrid").flexSimpleSearchQueryString()+'&a=export_step1&goods_recordid=' + id;
}
</script> 

