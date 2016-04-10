<div class="footer">
  <div class="foot">
    <dl>
      <dt>About Us</dt>
      <?php
        $aboutlist=gettolrss(23);
		foreach($aboutlist as $v){
	  ?>
      <dd><a href="about.php?id=<?php echo $v['id']?>"><?php echo $v['title_en']?></a></dd>
      <?php }?>
    </dl>
    <dl>
      <dt>Products</dt>
      <?php
        $prolm=getlmrss('pro_lm');
		foreach($prolm as $v){
	  ?>
      <dd><a href="product.php?lm=<?php echo $v['id_lm']?>"><?php echo $v['title_lm_en']?></a></dd>
      <?php }?>
    </dl>
    <dl>
      <dt>Download</dt>
      <?php
        $downlm=getlmrss('pro_lm');
		foreach($downlm as $v){
	  ?>
      <dd><a href="download.php?lm=<?php echo $v['id_lm']?>"><?php echo $v['title_lm_en']?></a></dd>
      <?php }?>
    </dl>
    <dl>
      <dt>Link</dt>
      <?php
        $linklist=getinforss(35);
		foreach($linklist as $v){
	  ?>
      <dd><a href="<?php echo $v['link_url']?>" target="_blank"><?php echo $v['title_en']?></a></dd>
      <?php }?>
    </dl>
    <dl>
      <dt><img src="images/index_22.png" /></dt>
      <dd><a href="#">  Please sweep </a></dd>
    </dl>
    <div class="clear"></div>
  </div>
  <div class="foot_b">
    <p>Copyright © 2015, X.R Technology Co., Ltd. All Rights Reserved. 深圳市雪锐科技有限公司</p>
    <span>版权所有 <a href="" target="_blank">粤ICP备13018742号-1</a></span> </div>
</div>