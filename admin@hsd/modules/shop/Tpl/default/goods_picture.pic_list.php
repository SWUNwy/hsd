<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script> 
<style>
a.ncbtn-mini {
    line-height: 16px;
    height: 16px;
    padding: 3px 7px;
    border-radius: 2px;
}
a.ncbtn, a.ncbtn-mini {
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
a:active, a:link, a:visited {
    text-decoration: none;
}
a:active, a:link, a:visited {
    text-decoration: none;
}
input[type=file] {
    line-height: 20px;
    background-color: #FBFBFB;
    height: 20px;
    border: solid 1px #D8D8D8;
    cursor: default;
}
.upload-con {
    background-color: #FFF;
    width: 174px;
    padding: 9px;
    border: solid 1px #37839A;
    position: absolute;
    z-index: 99;
    top: 27px;
    right: 0px;
}
/* 按钮样式 */
.nscs-table-handle { font-size: 0; *word-spacing:-1px/*IE6、7*/;}
.nscs-table-handle span { vertical-align: middle; letter-spacing: normal; word-spacing: normal; text-align: center; display: inline-block; padding: 0 4px; border-left: solid 1px #E6E6E6;}
.nscs-table-handle span { *display: inline/*IE6,7*/;}
.nscs-table-handle span:first-child { border-left: none 0;}
.nscs-table-handle span a { color: #777; background-color: #FFF; display: block; padding: 3px 7px; margin: 1px;}
.nscs-table-handle span a i { font-size: 14px; line-height: 16px; height: 16px; display: block; clear: both; margin: 0; padding: 0;}
.nscs-table-handle span a p { font: 12px/16px arial; height: 16px; display: block; clear: both; margin: 0; padding: 0;}
.nscs-table-handle span a:hover { text-decoration: none; color: #FFF; margin: 0; border-style: solid; border-width: 1px;}


.ncsc-upload-btn { vertical-align: top; display: inline-block; *display: inline/*IE7*/; width: 80px; height: 30px; margin: 5px 5px 0 0; *zoom:1;}
.ncsc-upload-btn a { display: block; position: relative; z-index: 1;}
.ncsc-upload-btn span { width: 80px; height: 30px; position: absolute; left: 0; top: 0; z-index: 2; cursor: pointer;}
.ncsc-upload-btn .input-file { width: 80px; height: 30px; padding: 0; margin: 0; border: none 0; opacity:0; filter: alpha(opacity=0); cursor: pointer; }
.ncsc-upload-btn p { font-size: 12px; line-height: 20px; background-color: #F5F5F5; color: #999; text-align: center; color: #666; width: 78px; height: 20px; padding: 4px 0; border: solid 1px; border-color: #DCDCDC #DCDCDC #B3B3B3 #DCDCDC; position: absolute; left: 0; top: 0; z-index: 1;}
.ncsc-upload-btn p i { vertical-align: middle; margin-right: 4px;}
.ncsc-upload-btn a:hover p { background-color: #E6E6E6; color: #333; border-color: #CFCFCF #CFCFCF #B3B3B3 #CFCFCF;}
/*空间相册对应样式*/
.upload-con { background-color: #FFF; width: 174px; padding: 9px; border: solid 1px #37839A; position: absolute; z-index: 99; top: 27px; right: 0px;}
.sticky .upload-con { top: 37px;}
.upload-con-div { line-height: 30px; display: block; height: 30px; padding-bottom: 9px; margin-bottom: 9px; border-bottom: dotted 1px #DDD;}
.upload-con-div .ncsc-upload-btn { vertical-align: middle; display: inline-block; *display: inline/*IE7*/; margin-left: 3px; *zoom:1;}
.upload-pmgressbar {}
.upload-pmgressbar div { background-color: #F7F7F7; width: 146px; height: 24px; margin-top: 4px; padding: 4px 14px;}
.upload-pmgressbar div p { font: 10px/12px Arial; width: 146px; height: 12px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;}
.upload-pmgressbar div p.loading { background:url('../../Tpl/default/images/upload_loading.gif') no-repeat 0 0; height:8px; border-radius: 4px;}
.upload_file { padding: 8px 0 6px;}
.upload-txt { line-height: 18px; font-weight: normal; margin-top: 8px;}
.upload-txt span { color: #999; }

.ncsc-picture-folder {}
.ncsc-album-intro { min-height: 52px; padding: 10px 0 10px 60px; border-bottom: 1px solid #E6E6E6; position: relative; z-index: 1; overflow: hidden;}
.ncsc-album-intro .album-covers { line-height: 0; background-color: #FFF; text-align: center; vertical-align: middle; display: table-cell; *display: block; width: 48px; height: 48px; border: solid 1px #E6E6E6; overflow: hidden; position: absolute; z-index: 1; top: 12px; left: 0; }
.ncsc-album-intro .album-covers img { max-width: 48px; max-height: 48px; margin-top:expression(48-this.height/2); *margin-top:expression(24-this.height/2)/*IE6,7*/;}
.ncsc-album-intro .album-covers i { font-size: 24px; line-height: 48px; color: #DDD;}
.ncsc-album-intro .album-name { font: bold 14px/20px "microsoft yahei"; color: #27A9E3; width: 75%; height: 20px; margin-bottom: 2px;}
.ncsc-album-intro .album-info { font: normal 12px/16px "microsoft yahei"; color: #999; width: 75%; height: 32px; overflow: hidden; }
/*相册图片列表*/
.ncsc-album, .ncsc-picture-list { text-align: left; margin: 20px 0; overflow: hidden;}
.ncsc-album ul, .ncsc-picture-list ul { font-size: 0; *word-spacing:-1px/*IE6、7*/; clear: both; width: 100%; margin: 0 0 -1px -1px;}
.ncsc-album li, .ncsc-picture-list li { vertical-align: top; letter-spacing: normal; word-spacing: normal; display: inline-block; width: 190px; height: 260px; border-style: solid; border-color: #E6E6E6; border-width: 0 0 1px 1px; position: relative; z-index: 1;}
.ncsc-album li, .ncsc-picture-list li { *display: inline/*IE6,7*/;}
.ncsc-album li.hover, .ncsc-picture-list li.hover { z-index: 2;}
.ncsc-album li dl, .ncsc-picture-list li dl { font-size: 12px; width: 162px; height: 232px; padding: 14px; position: absolute; z-index: 1; top: 0; left: 0;}
.ncsc-album li.hover dl, .ncsc-picture-list li.hover dl { background-color: #E6E6E6; border: solid 1px #CCC; top: -1px; left: -1px;}
.ncsc-album li dl dt, .ncsc-picture-list li dl dt { width: 160px; height: 185px; }
.ncsc-album li dl dt .covers, .ncsc-picture-list li dl dt .picture { width: 160px; height: 160px; border: solid 1px #FAFAFA;}
.ncsc-album li dl dt .covers a,
.ncsc-picture-list li dl dt .picture a { line-height: 0; background-color: #FFF; text-align: center; vertical-align: middle; display: table-cell; *display: block; width: 160px; height: 160px; overflow: hidden;}
.ncsc-album li dl dt .covers a img,
.ncsc-picture-list li dl dt .picture a img { max-width: 160px; max-height: 160px; margin-top:expression(160-this.height/2); *margin-top:expression(80-this.height/2)/*IE6,7*/;}
.ncsc-album li dl dt .covers a i { font-size: 64px; text-decoration: none; color: #AAA;}
.ncsc-album li dl dt .covers a:hover i { color: #27A9E3;}
.ncsc-album li dl dt h3 { font-size: 14px; font-weight: lighter; line-height: 20px; color: #555; white-space: nowrap; width: 150px; height: 20px; margin: 5px auto; overflow: hidden;}
.ncsc-album li dl dt h3 a { color: #27A9E3;}
.ncsc-picture-list li dl dt .editInput1 { font-size: 12px; font-weight: bold; line-height: 20px; color: #555; background-color: transparent; width: 140px; height: 20px; border:0; position: absolute; z-index: 1; top: 180px; left: 15px;}
.ncsc-picture-list li dl dt .editInput2 { font-size: 12px; line-height: 18px; color: #333; width: 152px; height: 18px; padding: 1px 3px; border: 1px solid #75B9F0; box-shadow: 0 0 0 2px rgba(82, 168, 236, 0.15); outline: 0 none; position: absolute; z-index: 2; top: 180px; left: 15px;}
.ncsc-picture-list li dl dt .checkbox { position: absolute; z-index: 2; top: 15px; left: 15px;}
.ncsc-picture-list li dl dt span { font-size: 12px; line-height: 16px; vertical-align: middle; text-align: center; width: 16px; height: 16px; position: absolute; z-index: 2; top: 182px; right: 17px;}
.ncsc-album li dl dd.date, .ncsc-picture-list li dl dd.date { font-size: 12px; line-height: 22px; color: #999; width: 160px; height: 60px; position: absolute; z-index: 3; top: 204px; left: 8px; padding: 0 0 0 8px;}
.ncsc-album li dl dd.date { height: 22px; left: 12px;}
.ncsc-picture-list li.hover dl dd.date { display: none;}
.ncsc-album li dl dd.buttons, .ncsc-picture-list li dl dd.buttons { font-size: 0; *word-spacing:-1px/*IE6、7*/; display: none; width: 170px; height: 50px; padding: 0px; position: absolute; top: 205px; left: 12px; z-index: 3;}
.ncsc-album li dl dd.buttons { height: 30px; top: 228px;}
.ncsc-album li.hover dl dd.buttons,
.ncsc-picture-list li.hover dl dd.buttons { display: block;}
.ncsc-picture-list li dl dd.buttons .upload-btn1 { width: 85px; height: 25px; display: inline-block; *display: inline/*IE6,7*/; zoom:1;}
.ncsc-picture-list li dl dd.buttons .upload-btn1 span { width: 80px; height: 20px; position: absolute; left: 0; top: 0; z-index: 2; cursor:pointer;}
.ncsc-picture-list li dl dd.buttons .upload-btn1 .input-file { width:80px; height: 20px; opacity:0; filter: alpha(opacity=0); cursor: pointer; }
.ncsc-picture-list li dl dd.buttons .upload-btn1 .upload-button1 { font-size: 12px; line-height: 20px; width: 68px; height: 16px; padding: 2px 6px; position: absolute; left: 0; top: 0; z-index: 1;}
.ncsc-album li dl dd.buttons a, .ncsc-picture-list li dl dd.buttons a { font-size: 12px; line-height: 16px; color: #999; background-color: #FFF; vertical-align: top; letter-spacing: normal; word-spacing: normal; display: inline-block; width: 68px; height: 16px; padding: 2px 6px; margin: 0 5px 5px 0; border-radius: 2px;}
.ncsc-album li dl dd.buttons a i, .ncsc-picture-list li dl dd.buttons a i { margin-right: 4px;}
.ncsc-album li dl dd a:hover, .ncsc-picture-list li dl dd a:hover { text-decoration: none; color: #27A9E3; box-shadow: 0 0 4px rgba(153,153,153,0.75);}
.tabmenu {
    
    display: block;
    width: 100%;
    height: 38px;
    margin-bottom: 10px;
    position: relative;
    z-index: 99;
   
}
.tabmenu a.ncbtn {
    position: absolute;
    z-index: 1;
    top: -2px;
    right: 0px;
}

a.ncbtn {
    height: 20px;
    padding: 5px 10px;
    border-radius: 3px;
}
a.ncbtn, a.ncbtn-mini {
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
a.ncbtn-aqua {
    background-color: #4FC0E8;
}
</style>
<div class="page" style="padding-top:0px;overflow:inherit;overflow-y: inherit;">
	<table class="search-form">
  <tbody>
    <tr>
      <th>批量处理</th>
      <td><a href="JavaScript:void(0);" class="ncbtn-mini" onclick="checkAll()"><i class="fa  fa-check-square-o"></i>全选</a><a href="JavaScript:void(0);" class="ncbtn-mini" onclick="uncheckAll()"><i class="fa fa-check-square"></i>取消</a><a href="JavaScript:void(0);" class="ncbtn-mini" onclick="switchAll()"><i class="fa fa-square-o"></i>反选</a><a style="display: none;" href="JavaScript:void(0);" class="ncbtn-mini" onclick="submit_form('del')"><i class="fa fa-trash-o"></i>删除</a>
        
       </td>     
    </tr>
  </tbody>
</table>
<div class="tabmenu">
 
  <a id="open_uploader" href="JavaScript:void(0);" class="ncbtn ncbtn-aqua"><i class="fa fa-cloud-upload"></i>上传图片</a>
  <div class="upload-con" id="uploader" style="display: none;">
    <form method="post" action="" id="fileupload" enctype="multipart/form-data">
      <input type="hidden" name="category_id" id="category_id" value="<?php echo $output['pic_channel']?>">
      <div class="upload-con-div">选择文件：
        <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="file" multiple="multiple">
          </span>
          <p><i class="fa fa-upload"></i>上传图片</p>
          </a> </div>
      </div>
      <div nctype="file_msg"></div>
      <div class="upload-pmgressbar" nctype="file_loading"></div>
      <div class="upload-txt"><span>支持Jpg、Gif、Png格式，大小不超过1024KB的图片上传；浏览文件时可以按住ctrl或shift键多选。</span> </div>
    </form>
  </div>
</div>
  <form name="checkboxform" id="checkboxform" method="POST" action="">
  <div class="ncsc-picture-list">
  	 <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
    <ul>
    	<?php foreach($output['list'] as $k => $v){ ?>
      <li class="" style="opacity: 1;">
        <dl>
          <dt>
            <div class="picture"><a  nctype="nyroModal" href="/picture/uploadfile/<?php echo $v['pic_path']?>"> <img id="img_<?php echo $v['pic_id']?>" src="/picture/uploadfile/<?php echo $v['pic_path_240']?>"></a></div>
            <input id="C19" name="id[]" value="<?php echo $v['pic_id']?>" type="checkbox" class="checkbox">
            <input id="<?php echo $v['pic_id']?>" class="editInput1" readonly="" onDblClick="$(this).unbind();_focus($(this));" value="<?php echo $v['pic_name']?>" title="双击名称可以进行编辑" style="cursor:pointer;">
            <span onDblClick="_focus($(this).prev());" title="双击名称可以进行编辑"><i class="fa fa-pencil"></i></span></dt>
          <dd class="date">
            <p>上传时间：<?php echo $v['pic_datetime']?></p>
            
          </dd>
          <dd class="buttons">
            <div class="upload-btn1"><a href="javascript:void(0);"> <span>
              <input type="file" name="file_<?php echo $v['pic_id']?>" id="file_<?php echo $v['pic_id']?>" class="input-file" size="1" hidefocus="true" nctype="replace_image">
              </span>
              <div class="upload-button1"><i class='fa  fa-upload'></i>替换上传</div>
              <input id="submit_button" style="display:none" type="button" value="" onClick="submit_form($(this))">
              </a></div>
             <a href="javascript:void(0)" onClick="ajax_get_confirm('您确定进行该操作吗?\n注意：使用中的图片也将被删除','<?php echo urlAdminShop('goods_picture','album_pic_del',array('id'=>$v['pic_id']))?>');"><i class="fa fa-trash-o"></i>删除图片</a> </dd>
        </dl>
      </li>
      <?php } ?>
    </ul>
 	<?php }else { ?>
  <div class="no-data"><i class="fa fa-exclamation-circle"></i><?php echo $lang['nc_no_record'];?></div>
  <?php } ?>
  </div>
</form>
<div class="pagination"><?php echo $output['page'];?> </div>

</div>
<script type="text/javascript" src="<?php echo ADMIN_RESOURCE_URL;?>/js/jquery.nyroModal.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script>
$(function(){
	 //鼠标触及区域li改变class
	$(".ncsc-picture-list ul li").hover(function() {
	    $(this).addClass("hover");
	}, function() {
	    $(this).removeClass("hover");
	});
	
	$('a[nctype="nyroModal"]').nyroModal();
	$('a[nc_type="delete"]').bind('click',function(){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')) return false;
		cur_note = this;
		$.get("index.php?m=goods_album&a=del_album_pic", {'key':$(this).attr('nc_key')}, function(data){
            if (data == 1) {
            	$(cur_note).parents('li:first').remove();
            } else {
            	alert('<?php echo $lang['nc_common_del_fail'];?>');
            }
        });
	});
	$('#data .default').find('.demo').ajaxContent({
        event:'click', //mouseover
        loaderType:"img",
        loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
        target:'#data .default'
    });
   // 替换图片
    $('input[nctype="replace_image"]').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: '<?php echo urlAdminShop() ?>/index.php?m=goods_picture&a=replace_image_upload&id=' + $(this).attr('id'),
            done: function (e,data) {
                var param = data.result;
                if(param.state == 'true'){
                    img_refresh(param.id);
                } else {
                	layer.msg(param.message);
                  //alert(param.message);
                }
            }
        });
    });
  	
    // ajax 上传图片
    var upload_num = 0; // 上传图片成功数量
    $('#fileupload').fileupload({
        dataType: 'json',
        url: '<?php echo urlAdminShop() ?>/index.php?m=goods_picture&a=image_upload',
        add: function (e,data) {
        	$.each(data.files, function (index, file) {
                $('<div nctype=' + file.name.replace(/\./g, '_') + '><p>'+ file.name +'</p><p class="loading"></p></div>').appendTo('div[nctype="file_loading"]');
            });
        	data.submit();
        },
        done: function (e,data) {
            var param = data.result;
            $this = $('div[nctype="' + param.origin_file_name.replace(/\./g, '_') + '"]');
            $this.fadeOut(3000, function(){
                $(this).remove();
                if ($('div[nctype="file_loading"]').html() == '') {
                    setTimeout("window.location.reload()", 1000);
                }
            });
            if(param.state == 'true'){
                upload_num++;
                $('div[nctype="file_msg"]').html('<i class="fa fa-check-circle">'+'</i>'+'成功上传'+upload_num+'张图片');

            } else {
                $this.find('.loading').html(param.message).removeClass('loading');
            }
        }
    });
		trigger_uploader();

});
	// 重新加载图片，替换上传使用
	function img_refresh(id){
		$('#img_'+id).attr('src',$('#img_'+id).attr('src')+"?"+100*Math.random());
	}
	// 全选
	function checkAll() {
		$('#batchClass').hide();
		$('input[type="checkbox"]').each(function(){
			$(this).attr('checked',true);
		});
	}
	// 取消
	function uncheckAll() {
		$('#batchClass').hide();
		$('input[type="checkbox"]').each(function(){
			$(this).attr('checked',false);
		});
	}
	// 反选
	function switchAll() {
		$('#batchClass').hide();
		$('input[type="checkbox"]').each(function(){
			$(this).attr('checked',!$(this).attr('checked'));
		});
	}
	
	
	//控制图片名称input焦点可编辑
	function _focus(o){
		var name;
	        obj = o;
	        name=obj.val();
	        obj.removeAttr("readonly");
	        obj.attr('class','editInput2');
	        obj.select();
	        obj.blur(function(){
				if(name != obj.val()){
	               _save(this);
				}else{
					obj.attr('class','editInput1');
					obj.attr('readonly','readonly');
				}
	        });
	}
	function _save(obj){
			$.post('index.php?m=goods_picture&a=change_pic_name', {id:obj.id,name:obj.value}, function(data) {
				if(data == 'false'){
					//showError('操作失败');
					layer.msg("操作失败");
				}else{
					//showDialog('操作成功','succ');
					layer.msg("操作成功");
				}
			});
	        obj.className = "editInput1";
	        obj.readOnly = true;
	}
	function submit_form(type){
		if(type != 'move'){
			$('#batchClass').hide();
		}
		var id='';
		$('input[type=checkbox]:checked').each(function(){
			if(!isNaN($(this).val())){
				id += $(this).val();
			}
		});
		if(id == ''){
			//alert('请选择图片');
			layer.msg("请选择图片");
			return false;
		}
		if(type=='del'){
			if(!confirm('您确定进行该操作吗?\n注意：使用中的图片也将被删除')){
				return false;
			}
		}
		$('#checkboxform').attr('action','<?php echo urlAdminShop() ?>/index.php?m=goods_picture&op=album_pic_'+type);
		ajaxpost('checkboxform', '', '', 'onerror');
	}

	function trigger_uploader(){
    // 打开商品mxf="sqde"图片上传器
    $('#open_uploader').unbind('click');
    $('#open_uploader').click(function(){
        if($('#uploader').css('display') == 'none'){
            $('#uploader').show();
            $(this).find('.hide').attr('class','show');
        }else{
            $('#uploader').hide();
            $(this).find('.show').attr('class','hide');
        }
    });
	}

</script> 
