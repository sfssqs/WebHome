<?php
require"conn.php";
$pro=new pro(3,0);
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
<div class="banner"><img src="images/index_02.png" border="0" />
<div  style="position: absolute;width: 50px;bottom: -50px;right: 50%;"><a href="#show"><img src="images/index0_03.png" alt="" /></a></div>
</div>
<div id="show" class="list">
  <ul class="list_ul">
    <?php $pro->showlm_1_1('product.php');?>
    <div class="clear"></div>
  </ul>
</div>
<div class="list_b">
  <?php
    $pro->getpar();
	$prolist=$pro->getcoarr(200);
	showmove_2_3($prolist,'product_show.php');
  ?>
</div>
<?php require"footer.php"?>
</body>
</html>
