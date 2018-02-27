<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>推送记录</h3>
        <h5>推送记录</h5>
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
        url: 'index.php?m=orders_post_log&a=get_xml',
        colModel : [   
            {display: 'ID', name : 'p_id', width : 40, sortable : true, align: 'center'},
          	{display: '订单ID', name : 'order_id', width : 120, sortable : true, align: 'center'},
          	{display: '订单号', name : 'order_sn', width : 120, sortable : false, align: 'center'},
          	{display: '推送成功', name : 'is_true', width :100, sortable : true, align: 'center'},
          	{display: '失败原因', name : 'err_msg', width :300, sortable : false, align: 'left'},
          	{display: '推送时间', name : 'add_time', width :150, sortable : false, align: 'center'},
            ],
        searchitems : [
            {display: '订单号', name : 'order_sn'},
            ],
        sortname: "p_id",
        sortorder: "desc",
        title: '推送日志表'
    });
	
});
</script> 

