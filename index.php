<?php
require"conn.php";
$arr=getglrs(1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php showseohtml($arr);?>
<link href="css/style.css" type="text/css" rel="stylesheet" />
<!--[if IE 6]>
<script src="js/DD_belatedPNG.js" mce_src="js/DD_belatedPNG.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<![endif]-->
</head>

<body>
<?php require"top.php";?>
<div class="banner" style="position: relative;"><img src="images/poster_home.jpg" border="0" />
<div  style="position: absolute;width: 50px;bottom: 0;right: 50%;"><a href="#show"><img src="images/index0_03.png" alt="" /></a></div>
</div>
<div class="pro" id="show">
  <div class="pro_t"><span><a href="product.php"><img src="images/index01_03.png"/></a></span> <font>产品展示</font> &nbsp;&nbsp;<em>PRODUCTS</em>
    <div class="clear"></div>
  </div>
  <ul class="pro_ul">
    <?php
      $ipro=getprorss('',3);
	  $a=1;
	  foreach($ipro as $v){
	?>
    <li   <?php if($a%3==0) echo 'class="last"'?>>
      <div class="li_img"><a href="product_show.php?id=<?php echo $v['id']?>"><img src="<?php echo $v['img_sl']?>" width="308" height="174"  /></a></div>
      <span><?php echo $v['title']?></span> <font>产品型号： <?php echo $v['pro_can1']?></font>
      <p><?php echo getstr($v['f_body'],80)?><a href="product_show.php?id=<?php echo $v['id']?>">【更多】</a></p>
    </li>
    <?php $a++;}?>
    <div class="clear"></div>
  </ul>
</div>
<div class="case"> 
<a href="about.php"><img src="images/index_14.png" /></a> 
<a href="news.php"><img src="images/index_15.png" /></a> 
<a href="case.php"><img src="images/index_17.png" /></a> </div>
<?php require"footer.php"?>
</body>
</html>
