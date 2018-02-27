<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<link rel="stylesheet" href="<?php echo ADMIN_RESOURCE_URL;?>/js/jstree/themes/default/style.min.css" />
<style>
		#container { min-width:320px;  background:white; border-radius:0px; padding:0px;  }
		#tree { float:left; min-width:250px; border-right:1px solid silver; overflow:auto; padding:0px 0; }
		#data { margin-left:251px; }
		#data textarea { margin:0; padding:0; height:100%; width:100%; border:0; background:white; display:block; line-height:18px; }
		#data, #code { font: normal normal normal 12px/18px 'Consolas', monospace !important; }
		</style>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['g_album_manage'];?></h3>
        <h5><?php echo $lang['g_album_manage_subhead'];?></h5>
      </div>
    </div>
  </div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>注：在使用‘替换上传’功能时，请保持图片的扩展名与被替换图片相同。</li>
    </ul>
    <input type="text" value="" style="box-shadow:inset 0 0 4px #eee; width:220px; margin:0; padding:6px 12px; border-radius:4px; border:1px solid silver; font-size:1.1em;" id="search" placeholder="Search" />
  </div>
  <div id="container" role="main">
			<div id="tree"></div>
			<div id="data">
				
				<div class="content code" style="display:none;"><textarea id="code" readonly="readonly"></textarea></div>
				<div class="content folder" style="display:none;"></div>
				<div class="content image" style="display:none; position:relative;"><img src="" alt="" style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;" /></div>
				<div class="content default" ></div>
			</div>
		</div>
</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jstree/jstree.js"></script>
<script>
	$(function () {
		//搜索
		var to = false;
		$('#search').keyup(function () {
			if(to) { clearTimeout(to); }
			to = setTimeout(function () {
				var v = $('#search').val();
				$('#tree').jstree(true).search(v);
			}, 250);
		});
		$(window).resize(function () {
			var h = Math.max($(window).height() - 162, 420);
			$('#container, #data, #tree').height(h).filter('.default').css('lineHeight', h + 'px');
		}).resize();
		$('#tree')
			.jstree({
				'core' : {
					'data' : {
						'url' : 'index.php?m=goods_picture&a=get_node',
						'data' : function (node) {
							return { 'id' : node.id };
						}
					},
					'check_callback' : true,
					'themes' : {
						'responsive' : false
					}
				},
				'force_text' : true,
				'plugins' : ['state', 'search', 'contextmenu','wholerow'],
			})
			.on('delete_node.jstree', function (e, data) {
				$.get('index.php?m=goods_picture&a=delete_node', { 'id' : data.node.id })
				 .done(function (d) {
				 		if(!d.state){
				 			layer.msg(d.msg);
				 			data.instance.refresh();
				 		}
					})
					.fail(function () {
						data.instance.refresh();
					});
			})
			.on('create_node.jstree', function (e, data) {
				$.get('index.php?m=goods_picture&a=create_node', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
					.done(function (d) {
						data.instance.set_id(data.node, d.id);
					})
					.fail(function () {
						data.instance.refresh();
					});
			})
			.on('rename_node.jstree', function (e, data) {
				$.get('index.php?m=goods_picture&a=rename_node', { 'id' : data.node.id, 'text' : data.text })
					.fail(function () {
						data.instance.refresh();
					});
			})
			.on('changed.jstree', function (e, data) {
				if(data && data.selected && data.selected.length) {
					$("#data .default").load('index.php?m=goods_picture&a=get_content&id=' + data.selected.join(':'), function(){
						// Membership card
					});
					/*
					$.get('index.php?m=goods_picture&a=get_content&id=' + data.selected.join(':'), function (d) {
							$('#data .default').text(d.content).show();
					});
					*/
				}
				else {
					$('#data .content').hide();
					$('#data .default').text('Select a file from the tree.').show();
				}
			});
	});
</script>