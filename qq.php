<link href="css/qq.css" rel="stylesheet" type="text/css" />
<div class="qust_contach"> <a href="javascript:void(0);" class="qst_close icon">&nbsp;</a> <br class="clear">
	<ul>
		<!--调用开始-->
		<li style="border-top:none">
			<p><span class="icon zixun"></span>在线咨询</p>
			<b>工作日：9:00-17:30</b>
			<?php $zx = $db -> getRows($db->query("select * from kf_co where lx=5"))?>
			<?php foreach($zx as $v1){?>
			<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v1['title']?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $v1['title']?>:51" alt="" title=""/></a>
			<?php }?>
		</li>
		<li>
			<p><span class="icon shouqian"></span>市场合作</p>
			<?php $hz = $db -> getRows($db->query("select * from kf_co where lx=6"))?>
			<?php foreach($hz as $v2){?>
			<b><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v2['title']?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $v2['title']?>:51" alt="" title=""/></a></b>
			<?php }?>
		</li>
		<li>
			<p><span class="icon shouhou"></span>技术支持</p>
			<?php $zc = $db -> getRows($db->query("select * from kf_co where lx=7"))?>
			<?php foreach($zc as $v3){?>
			<b><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v3['title']?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $v3['title']?>:51" alt="" title=""/></a></b> 
			<?php }?>
		</li>
		<!--调用结束-->
		<li id ="toTop" style="border-bottom:none; height:0px;overflow: hidden;cursor: pointer;"> 
			<a href="javascript:void(0);" class="back_top icon">&nbsp;</a> 
		</li>
	</ul>
</div>
<div class="qust_show" style="display:none;"> 
	<a href="javascript:void(0);"> <span class="icon server"></span><br/>
	<span>在</span><br/>
	<span>线</span><br/>
	<span>咨</span><br/>
	<span>询</span><br/>
	</a> 
 </div>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/contact.js"></script>