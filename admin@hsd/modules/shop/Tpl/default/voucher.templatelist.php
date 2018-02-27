<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['nc_voucher_price_manage'];?></h3>
        <h5><?php echo $lang['nc_voucher_price_manage_subhead'];?></h5>
      </div>
      <ul class="tab-base nc-row">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
        <li><a href="JavaScript:void(0);" class="current"><?php echo $menu['menu_name'];?></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><?php echo $menu['menu_name'];?></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>

  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li><?php echo $lang['admin_voucher_template_list_tip'];?></li>
    </ul>
  </div>

  <div id="flexigrid"></div>

    <div class="ncap-search-ban-s" id="searchBarOpen"><i class="fa fa-search-plus"></i>高级搜索</div>
    <div class="ncap-search-bar">
      <div class="handle-btn" id="searchBarClose"><i class="fa fa-search-minus"></i>收起边栏</div>
      <div class="title">
        <h3>高级搜索</h3>
      </div>
      <form method="get" name="formSearch" id="formSearch">
        <input type="hidden" name="advanced" value="1" />
        <div id="searchCon" class="content">
          <div class="layout-box">
            <dl>
              <dt>代金券名称</dt>
              <dd>
                <input type="text" name="voucher_t_title" class="s-input-txt" placeholder="请输入代金券名称关键字" />
              </dd>
            </dl>
            <dl>
              <dt>店铺名称</dt>
              <dd>
                <input type="text" name="voucher_t_storename" class="s-input-txt" placeholder="请输入店铺名称关键字" />
              </dd>
            </dl>
            <dl>
              <dt>修改时间</dt>
              <dd>
                  <label>
                    <input type="text" name="sdate" data-dp="1" class="s-input-txt" placeholder="请选择筛选时间段起点" />
                  </label>
                  <label>
                    <input type="text" name="edate" data-dp="1" class="s-input-txt" placeholder="请选择筛选时间段终点" />
                  </label>
              </dd>
            </dl>
            <dl>
              <dt>领取方式</dt>
              <dd>
                <select name="voucher_t_gettype" class="s-select">
                    <option value="0" selected>全部</option>
                    <?php if ($output['gettype_arr']){ ?>
                    <?php foreach ($output['gettype_arr'] as $k=>$v){ ?>
                    <option value="<?php echo $v['sign'];?>"><?php echo $v['name'];?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
              </dd>
            </dl>
            <dl>
              <dt>状态</dt>
              <dd>
                <select name="voucher_t_state" class="s-select">
                    <option value="0" selected>全部</option>
                    <?php if ($output['templateState']){ ?>
                    <?php foreach ($output['templateState'] as $k=>$v){ ?>
                    <option value="<?php echo $v[0];?>"><?php echo $v[1];?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
              </dd>
            </dl>
            <dl>
              <dt>推荐</dt>
              <dd>
                <select name="voucher_t_recommend" class="s-select">
                    <option value="" selected>全部</option>
                    <option value="1" >是</option>
                    <option value="0" >否</option>
                </select>
              </dd>
            </dl>
            <dl>
              <dt>活动时期筛选</dt>
              <dd>
                <label>
                    <input type="text" name="pdate1" data-dp="1" class="s-input-txt" placeholder="结束时间不晚于" />
                </label>
                <label>
                    <input type="text" name="pdate2" data-dp="1" class="s-input-txt" placeholder="开始时间不早于" />
                </label>
              </dd>
            </dl>

          </div>
        </div>
        <div class="bottom">
          <a href="javascript:void(0);" id="ncsubmit" class="ncap-btn ncap-btn-green">提交查询</a>
          <a href="javascript:void(0);" id="ncreset" class="ncap-btn ncap-btn-orange" title="撤销查询结果，还原列表项所有内容"><i class="fa fa-retweet"></i><?php echo $lang['nc_cancel_search'];?></a>
        </div>
      </form>
    </div>

</div>

<script>
$(function(){
    var flexUrl = 'index.php?m=voucher&a=templatelist_xml';

    $("#flexigrid").flexigrid({
        url: flexUrl,
        colModel: [
            {display: '操作', name: 'operation', width: 60, sortable: false, align: 'center', className: 'handle'},
            {display: '代金券名称', name: 'voucher_t_title', width: 300, sortable: false, align: 'left'},
            {display: '店铺名称', name: 'voucher_t_storename', width: 200, sortable: false, align: 'left'},
            {display: '代金券分类', name: 'voucher_t_sc_name', width: 200, sortable: false, align: 'left'},
            {display: '面额', name: 'voucher_t_price', width: 80, sortable: true, align: 'left'},
            {display: '消费金额', name: 'voucher_t_limit', width: 80, sortable: true, align: 'left'},
            {display: '会员级别', name: 'voucher_t_mgradelimittext', width: 80, sortable: true, align: 'center'},
            {display: '最后修改时间', name: 'add_time_text', width: 120, sortable: true, align: 'center'},
            {display: '开始时间', name: 'start_time_text', width: 120, sortable: true, align: 'center'},
            {display: '结束时间', name: 'end_time_text', width: 120, sortable: true, align: 'center'},
            {display: '领取方式', name: 'gettype_name', width: 80, sortable: false, align: 'center'},
            {display: '状态', name: 'state_text', width: 80, sortable: false, align: 'center'},
            {display: '推荐', name: 'recommend', width: 80, sortable: false, align: 'center'}
        ],
        searchitems: [
            {display: '代金券名称', name: 'voucher_t_title', isdefault: true},
            {display: '店铺名称', name: 'voucher_t_storename'}
        ],
        sortname: "voucher_t_id",
        sortorder: "desc",
        title: '店铺代金券列表'
    });

    // 高级搜索提交
    $('#ncsubmit').click(function(){
        $("#flexigrid").flexOptions({url: flexUrl + '&' + $("#formSearch").serialize(),query:'',qtype:''}).flexReload();
    });

    // 高级搜索重置
    $('#ncreset').click(function(){
        $("#flexigrid").flexOptions({url: flexUrl}).flexReload();
        $("#formSearch")[0].reset();
    });

    $('[data-dp]').datepicker({dateFormat: 'yy-mm-dd'});

});

$('a.confirm-on-click').live('click', function() {
    return confirm('确定"'+this.innerHTML+'"?');
});
</script>
