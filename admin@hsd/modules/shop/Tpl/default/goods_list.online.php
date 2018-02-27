<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>出售中的商品</h3>
        <h5>商城出售中的商品管理</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>写代码的很懒，什么都不想写</li>
    </ul>
  </div>
  <div id="flexigrid"></div>
</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
    	url: 'index.php?m=goods_online&a=get_xml',
    	colModel : [
    		{display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
    		{display: 'ID', name : 'goods_commonid', width : 40, sortable : true, align: 'center'},
            {display: '商品名称', name : 'goods_name', width : 240, sortable : true, align: 'left'},
			{display: '商品货号', name : 'goods_serial', width : 150, sortable : true, align: 'left'},
    		{display: '商品条码', name : 'goods_barcode', width : 150, sortable : true, align: 'left'},    		
			{display: '价格', name : 'goods_price', width: 80, sortable : true, align : 'center'},
			{display: '库存', name : 'goods_storage', width: 80, sortable : false, align : 'center'},
            {display: '发布时间', name : 'goods_addtime', width: 160, sortable : true, align : 'center'}   		
    		],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增商品', name : 'add', bclass : 'add', title : '新增数据', onpress : fg_operate },
            {display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定行的商品批量删除', onpress : fg_operate },
            {display: '<i class="fa fa-level-down"></i>下架', name : 'unshow', bclass : 'add', title : '将选定行的商品下架', onpress : fg_operate },
            {display: '设置广告词', name : 'edit_jingle', bclass : 'add', title : '批量设置商品的广告词', onpress : fg_operate },
            {display: '设置关联版式', name : 'edit_plate', bclass : 'add', title : '批量设置商品的关联版式', onpress : fg_operate }
        ],
        searchitems : [
            {display: '商品名称', name : 'goods_name'},
            {display: '商品货号', name : 'goods_serial'},
            {display: '商品条码', name : 'goods_barcode'}
        ],
    	sortname: "goods_commonid",
    	sortorder: "desc",
    	title: '出售中的商品'
    });
    $('input[name="q"]').prop('placeholder','搜索标题内容...');
});
function fg_operate(name, bDiv) {
    if (name == 'del') {        
        if($('.trSelected',bDiv).length>0){
            var itemlist = new Array();
			$('.trSelected',bDiv).each(function(){
				itemlist.push($(this).attr('data-id'));
			});
            fg_delete(itemlist);
        } else {
            alert("请选择要操作的商品！");
            return false;
        }
    } else if (name == 'add') {
    	window.location.href = 'index.php?m=goods_add';
    } else if (name == 'unshow'){
        if($('.trSelected',bDiv).length>0){
            var itemids = new Array();
            $('.trSelected', bDiv).each(function(i){
                itemids[i] = $(this).attr('data-id');
            });
            fg_unshow(itemids);
        } else {
            alert("请选择要操作的商品！");
            return false;
        }
    }else if (name == 'edit_jingle'){
        if($('.trSelected',bDiv).length>0){
            var itemids = new Array();
            $('.trSelected', bDiv).each(function(i){
                itemids[i] = $(this).attr('data-id');
            });
            fg_edit_jingle(itemids);
        } else {
            alert("请选择要操作的商品！");
            return false;
        }
    }else if (name == 'edit_plate'){
        if($('.trSelected',bDiv).length>0){
            var itemids = new Array();
            $('.trSelected', bDiv).each(function(i){
                itemids[i] = $(this).attr('data-id');
            });
            fg_edit_plate(itemids);
        } else {
            alert("请选择要操作的商品！");
            return false;
        }
    }
}

//批量设置商品的广告词
function fg_edit_jingle(id) {   
    _uri = "index.php?m=goods_online&a=edit_jingle&id=" + id;
    CUR_DIALOG = ajax_form('goods_jingle', '设置广告词', _uri, 640);
}

//批量设置关联版式
function fg_edit_plate(id) {   
    _uri = "index.php?m=goods_online&a=edit_plate&id=" + id;
    CUR_DIALOG = ajax_form('goods_plate', '设置关联版式', _uri, 640);
}

function fg_unshow(id)
{
    id = id.join(',');
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "index.php?m=goods_online&a=goods_unshow",
        data: "id="+id,
        success: function(data){
            if (data.state){
                $("#flexigrid").flexReload();
            } else {
                alert(data.msg);
            }
        }
    });
}
//删除
function fg_delete(id) {
	if (typeof id == 'number') {
    	var id = new Array(id.toString());
	};
	if(confirm('删除后将不能恢复，确认删除这 ' + id.length + ' 项吗？')){
		id = id.join(',');
	} else {
        return false;
    }
	$.ajax({
        type: "GET",
        dataType: "json",
        url: "index.php?m=goods_online&a=delete",
        data: "del_id="+id,
        success: function(data){
            if (data.state){
                $("#flexigrid").flexReload();
            } else {
            	alert(data.msg);
            }
        }
    });
}
</script> 
