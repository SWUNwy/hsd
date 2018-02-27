<?php defined('ByShopKJYP') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>菜单设置</h3>
        <h5>菜单相关设置</h5>
      </div>
    </div>
  </div>
  <div class="tab-div">
<div id="tabbar-div">
    <p>
        <span class="tab-front" id="one-table">菜单一</span>
        <span class="tab-back" id="two-table">菜单二</span>
        <span class="tab-back" id="three-table">菜单三</span>
    </p>
</div>

<!-- tab body -->
<div id="tabbody-div">
<form enctype="multipart/form-data" action="" method="post" name="theForm">
 <input type="hidden" name="form_submit" value="ok" />
<!-- 通用信息 -->
 

<table width="50%" id="one-table" align="center">
    <tbody><tr>
            <td class="label">级别&nbsp;&nbsp;</td>
            <td><strong>类型</strong></td>
            <td><strong>名称</strong></td>
            <td><strong>值</strong></td>
    </tr>
    <tr>
        <td class="label">一级菜单：</td>
        <td>
            <select name="first_type[]">
                    <option value="click" <?php echo $output['data']['first'][0]['menu_type']=="click"?"selected":""; ?>>click</option>
                    <option value="view" <?php echo $output['data']['first'][0]['menu_type']=="view"?"selected":""; ?>>view</option>
            </select>  
        </td>
        <td>
                <label><input type="text" name="first[]" value="<?php echo $output['data']['first'][0]['name']; ?>" size="8"></label>
        </td>
        <td>
                <label><input type="text" name="first_value[]" value="<?php echo $output['data']['first'][0]['value']; ?>" size="8"></label>
        </td>
    </tr>
    
    <tr>
       <?php if(!empty($output['data']['second1']) && is_array($output['data']['second1'])){ ?>
        <?php foreach($output['data']['second1'] as $k => $v){ ?>
        <td class="label">二级菜单<?php echo $v['num']; ?>：</td>
        <td>
            <select name="menu_type1[]">
                    <option value="click"  <?php echo $v['menu_type']=="click"?"selected":""; ?>>click</option>
                    <option value="view"   <?php echo $v['menu_type']=="view"?"selected":""; ?>>view</option>
            </select>  
        </td>
        <td>
                <label><input type="text" name="second1[]" value="<?php echo $v['name']; ?>" size="8"></label>
        </td>
        <td>
                <label><input type="text" name="value1[]" value="<?php echo $v['value']; ?>" size="8"></label>
        </td>
    </tr>
      <?php } ?>
     <?php } ?>
    
    
    
    
    </tbody></table>
<table width="50%" id="two-table" align="center" style="display:none">
    <tbody><tr>
            <td class="label">级别&nbsp;&nbsp;</td>
            <td><strong>类型</strong></td>
            <td><strong>名称</strong></td>
            <td><strong>值</strong></td>
    </tr>
    <tr>
        <td class="label">一级菜单：</td>
        <td>
            <select name="first_type[]">
                    <option value="click" <?php echo $output['data']['first'][1]['menu_type']=="click"?"selected":""; ?> >click</option>
                    <option value="view"  <?php echo $output['data']['first'][1]['menu_type']=="view"?"selected":""; ?> >view</option>
            </select>  
        </td>
        <td>
                <label><input type="text" name="first[]" value="<?php echo $output['data']['first'][1]['name']; ?>" size="8"></label>
        </td>
        <td>
                <label><input type="text" name="first_value[]" value="<?php echo $output['data']['first'][1]['value']; ?>" size="8"></label>
        </td>
    </tr>
     <?php if(!empty($output['data']['second2']) && is_array($output['data']['second2'])){ ?>
        <?php foreach($output['data']['second2'] as $k => $v){ ?>
        <td class="label">二级菜单<?php echo $v['num']; ?>：</td>
        <td>
            <select name="menu_type2[]">
                    <option value="click"  <?php echo $v['menu_type']=="click"?"selected":""; ?>>click</option>
                    <option value="view"   <?php echo $v['menu_type']=="view"?"selected":""; ?>>view</option>
            </select>  
        </td>
        <td>
                <label><input type="text" name="second2[]" value="<?php echo $v['name']; ?>" size="8"></label>
        </td>
        <td>
                <label><input type="text" name="value2[]" value="<?php echo $v['value']; ?>" size="8"></label>
        </td>
    </tr>
      <?php } ?>
     <?php } ?>
    
    
        
</tbody></table>
<table width="50%" id="three-table" align="center" style="display:none">
    <tbody><tr>
            <td class="label">级别&nbsp;&nbsp;</td>
            <td><strong>类型</strong></td>
            <td><strong>名称</strong></td>
            <td><strong>值</strong></td>
    </tr>
    <tr>
        <td class="label">一级菜单：</td>
        <td>
            <select name="first_type[]">
                    <option value="click" <?php echo $output['data']['first'][2]['menu_type']=="click"?"selected":""?>>click</option>
                    <option value="view"  <?php echo $output['data']['first'][2]['menu_type']=="view"?"selected":""?>>view</option>
            </select>  
        </td>
        <td>
                <label><input type="text" name="first[]" value="<?php echo $output['data']['first'][2]['name']; ?>" size="8"></label>
        </td>
        <td>
                <label><input type="text" name="first_value[]" value="<?php echo $output['data']['first'][2]['value']; ?>" size="8"></label>
        </td>
    </tr>
        
        <?php if(!empty($output['data']['second3']) && is_array($output['data']['second3'])){ ?>
        <?php foreach($output['data']['second3'] as $k => $v){ ?>
        <td class="label">二级菜单<?php echo $v['num']; ?>：</td>
        <td> 
            <select name="menu_type3[]">
                    <option value="click"  <?php echo $v['menu_type']=="click"?"selected":""; ?>>click</option>
                    <option value="view"   <?php echo $v['menu_type']=="view"?"selected":""; ?>>view</option>
            </select>  
        </td>
        <td>
                <label><input type="text" name="second3[]" value="<?php echo $v['name']; ?>" size="8"></label>
        </td>
        <td>
                <label><input type="text" name="value3[]" value="<?php echo $v['value']; ?>" size="8"></label>
        </td>
    </tr>
      <?php } ?>
     <?php } ?>
    
    
    </tbody></table>

<div class="button-div">
    <input type="submit" value="保存" class="button">

</div>

</form>
</div>
</div>
</div>
<style>
/*
 标签部分的样式
 */
.tab-div {
  background: #EEF8F9;
  border: 1px solid #BBDDE5;
  margin: 0 0 10px 0;
  padding: 1px;
}
#tabbar-div {
  background: #80BDCB;
  padding-left: 10px;
  height: 22px;
  padding-top: 1px;
}

#tabbar-div p {
  margin: 2px 0 0 0;
}

.tab-front {
  background: #BBDDE5;
  line-height: 20px;
  font-weight: bold;
  padding: 4px 15px 4px 18px;
  border-right: 2px solid #278296;
  cursor: hand;
  cursor: pointer;
}

.tab-back {
  color: #FFF;
  line-height: 20px;
  padding: 4px 15px 4px 18px;
  border-right: 1px solid #FFF;
  cursor: hand;
  cursor: pointer;
}

.tab-hover {
  color: #FFF;
  background: #94C9D3;
  line-height: 20px;
  padding: 4px 15px 4px 18px;
  border-right: 1px solid #FFF;
  cursor: hand;
  cursor: pointer;
}

#tabbody-div {
  border: 2px solid #BBDDE5;
  padding: 10px;
  background: #FFF;
}

#tabbody-div img {
  vertical-align: middle;
}

.tab-body {
  border: 0px solid #BBDDE5;
  padding: 10px;
}
</style>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/tab.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/utils.js"></script>
<script language="JavaScript">

var articleId = 0;
var elements  = document.forms['theForm'].elements;




document.getElementById("tabbar-div").onmouseover = function(e)
{
    var obj = Utils.srcElement(e);

    if (obj.className == "tab-back")
    {
        obj.className = "tab-hover";
    }
}

document.getElementById("tabbar-div").onmouseout = function(e)
{
    var obj = Utils.srcElement(e);

    if (obj.className == "tab-hover")
    {
        obj.className = "tab-back";
    }
}

document.getElementById("tabbar-div").onclick = function(e)
{
    var obj = Utils.srcElement(e);

    if (obj.className == "tab-front")
    {
        return;
    }
    else
    {
        objTable = obj.id.substring(0, obj.id.lastIndexOf("-")) + "-table";

        var tables = document.getElementsByTagName("table");
        var spans  = document.getElementsByTagName("span");

        for (i = 0; i < tables.length; i++)
        {
            if (tables[i].id == objTable)
            {
                tables[i].style.display = (Browser.isIE) ? "block" : "table";
            }
            else
            {
                tables[i].style.display = "none";
            }
        }
        for (i = 0; spans.length; i++)
        {
            if (spans[i].className == "tab-front")
            {
                spans[i].className = "tab-back";
                obj.className = "tab-front";
                break;
            }
        }
    }
}

function showNotice(objId)
{
    var obj = document.getElementById(objId);

    if (obj)
    {
        if (obj.style.display != "block")
        {
            obj.style.display = "block";
        }
        else
        {
            obj.style.display = "none";
        }
    }
}


</script>



