<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>OAuth管理</h3>
        <h5>OAuth管理</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>OAuth管理</li>
    </ul>
  </div>
  <div id="flexigrid"></div>
</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?m=oauth&a=get_xml',
        colModel : [   
            {display: '操作', name : 'operation', width : 120, sortable : false, align: 'center', className: ''},
            {display: 'ID', name : 'oid', width : 40, sortable : true, align: 'center'},
            {display: '规则名称', name : 'name', width : 220, sortable : true, align: 'center'},
          	{display: '网址', name : 'contents', width : 350, sortable : true, align: 'center'},
          	{display: '调用网址', name : 'url', width : 350, sortable : false, align: 'center'},
          	{display: '推送量', name : 'count', width : 220, sortable : false, align: 'center'},
          	
            ],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增', name : 'add', bclass : 'add', title : '新增发货仓', onpress : fg_operation },
           ],
        
        sortname: "s_id",
        sortorder: "desc",
        title: 'OAuth管理'
    });
	
});

function fg_operation(name, bDiv) {
    if (name == 'add') {
    	layer.open({
    		type: 2,
    		title:'新增',
    		area: ['500px', '230px'],
    		fix: true, //不固定
    		maxmin: true,
    		content: 'index.php?m=oauth&a=oauthadd'
    	});            
    }  
}

function oauth_edit(id){
	layer.open({
		type: 2,
		title:'修改',
		area: ['600px', '230px'],
		fix: true, //不固定
		maxmin: true,
		content: 'index.php?m=oauth&a=oauthedit&oid='+id
	});        
}


function oauth_delete(id){
	$.ajax({
        type: "GET",
        dataType: "json",
        url: "index.php?m=oauth&a=oauthremove",
        data: "oid="+id,
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

