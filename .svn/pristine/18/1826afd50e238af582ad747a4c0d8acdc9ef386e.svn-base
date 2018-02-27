<?php defined('ByShopKJYP') or exit('Access Invalid!');?>

<div class="ncc-null-shopping"><i class="ico"></i>
  <h4><?php echo $lang['cart_index_no_goods_in_cart'];?></h4>
  <p>
  	<a href="index.php?m=itemIndex&a=index" class="ncbtn mr10"><i class="icon-reply-all"></i><?php echo $lang['cart_index_shopping_now'];?></a>
    <?php if($_SESSION['store_id']>0){ ?> 
  	<a href="index.php?m=store_order" class="ncbtn"><i class="icon-file-text"></i><?php echo $lang['cart_index_view_my_order'];?></a>
    <?php }else{ ?>
    <a href="index.php?m=s_login&a=show_login&a=show_login" class="ncbtn">
    	<i class="icon-file-text"></i><?php echo $lang['cart_index_view_my_order'];?></a>
    <?php } ?>
  </p>
</div>
<!-- 猜你喜欢 -->
<div id="guesslike_div"></div>
