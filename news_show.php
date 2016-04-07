<?php
require"conn.php";
$news=new news_show(3,0);
$news->init();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//seo信息
$news->showseo();
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
    <?php $news->showlm_1_1('news.php');?>
    <div class="clear"></div>
  </ul>
</div>
<div class="list_b">
   <div class="about">
     <ul class="news">
       <?php $news->showxx_1(); ?>
     </ul>
   </div>
</div>
<div class="clear"></div>
<?php require"footer.php"?>
</body>
</html>
