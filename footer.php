<div class="footer">
  <div class="foot">
    <dl>
      <dt>关于公司</dt>
      <?php
        $aboutlist=gettolrss(23);
		foreach($aboutlist as $v){
	  ?>
      <dd><a href="about.php?id=<?php echo $v['id']?>"><?php echo $v['title']?></a></dd>
      <?php }?>
    </dl>
    <dl>
      <dt>产品中心</dt>
      <?php
        $prolm=getlmrss('pro_lm');
		foreach($prolm as $v){
	  ?>
      <dd><a href="product.php?lm=<?php echo $v['id_lm']?>"><?php echo $v['title_lm']?></a></dd>
      <?php }?>
    </dl>
    <dl>
      <dt>资料下载</dt>
      <?php
        $downlm=getlmrss('pro_lm');
		foreach($downlm as $v){
	  ?>
      <dd><a href="download.php?lm=<?php echo $v['id_lm']?>"><?php echo $v['title_lm']?></a></dd>
      <?php }?>
    </dl>
    <dl>
      <dt>友情链接</dt>
      <?php
        $linklist=getinforss(35);
		foreach($linklist as $v){
	  ?>
      <dd><a href="<?php echo $v['link_url']?>" target="_blank"><?php echo $v['title']?></a></dd>
      <?php }?>
    </dl>
    <dl>
      <dt><img src="images/index_22.png" /></dt>
      <dd><a href="#">扫一扫关注我们</a></dd>
    </dl>
    <div class="clear"></div>
  </div>
  <div class="foot_b">
    <p>Copyright © 2015, Smartisan Digital Co., Ltd. All Rights Reserved. 深圳市雪锐科技有限公司</p>
    <span>版权所有 <a href="" target="_blank">粤ICP备13018742号-1</a></span> </div>
</div>