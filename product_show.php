<?php
require"conn.php";
$pro=new pro_show(3,0);
$pro->init();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//seo信息
$pro->showseo();
?>
<link href="css/style.css" type="text/css" rel="stylesheet" />
<!--[if IE 6]>
<script src="js/DD_belatedPNG.js" mce_src="js/DD_belatedPNG.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<![endif]-->
</head>

<body>
<?php require"top.php";?>
<div class="banner" style="position: relative;"><img src="images/index_02.png" border="0" />
<div  style="position: absolute;width: 50px;bottom: 0;right: 50%;"><a href="#show"><img src="images/index0_03.png" alt="" /></a></div>
</div>
<div id="show" class="list">
  <ul class="list_ul">
    <?php $pro->showlm_1_1('product.php');?>
    <div class="clear"></div>
  </ul>
</div>
<div class="detail">
  <div class="detail_l fl"><img src="<?php $pro->showxx_zd('img_sl');?>" /></div>
  <div class="detail_r fr"> <span style="font-family: 微软雅黑;font-size: 20px;"><?php $pro->showxx_zd('title');?></span> <font style="font-family: 宋体;font-size: 16px;">产品型号： <?php $pro->showxx_zd('pro_can1');?></font>
    <p style="font-family: 宋体; font-size: 14px;"><?php $pro->showxx_zd('f_body');?></p>
  </div>
  <div class="clear"></div>
</div>
<div class="detail_t">
  <div class="detail_tt">产品详情</div>
  <?php $pro->showxx_zd('z_body');?>
</div>
<?php require"footer.php"?>
</body>
</html>
