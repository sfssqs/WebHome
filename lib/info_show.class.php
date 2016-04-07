<?php
if(!defined('IN_MO')){
	exit('Access Denied');
}
class info_show extends info{

	public $id;			         //当前id
	public $row;		         //保存当前id的数据数组
	public $prearr;              //用于获取上一篇和下一篇的数据列表

	//构造函数
	function __construct($ty,$id=''){
		//调用上级基类的构造函数
		parent::__construct($ty,$id);
	}
	//析构函数
	function __destruct(){
		unset($this->imgs);
		unset($this->likes);
		unset($this->slist);
	}
	
	//以下是初始化程序========================================
	//实例化后手动执行函数
	public function init(){
		$this->getpar();
		$this->setxx();
	}
	
	//以下是供初始化时执行的方法===============================
	//接受页面传递参数
	public function getpar(){
		//获取参数
		$id=isset($_GET['id'])?$_GET['id']:'';
		
		//id
		if($id==''||!checknum($id)){
			msg('参数错误');
		}else{
			$this->id=$id;
		}
	}
	
	
	//以下是用于显示详细信息的程序==============================
	//设置详细信息
	public function setxx(){
		$rs=$this->db->getrs('select * from '.$this->table_co.' where pass=1 and id='.$this->id.'');
		if (!$rs){
			msg('该信息不存在或已删除');
		}else{
			$this->db->execute('update '.$this->table_co.' set read_num=read_num+1 where id='.$this->id.'');
			if ($rs['lm']>0){
				$this->lm=$rs['lm'];
			}
		}
		$this->row=$rs;
	}
	//获取详细信息
	public function getxx(){
		if ($this->row===NULL){
			$this->setxx();
		}
		return $this->row;
	}
	//获取字段信息
	public function getxx_zd($field){
		$zd='';
		$arr=$this->getxx();
		if (isset($arr[$field])){
			$zd=$arr[$field];	
		}
		return $zd;
	}

	
	//以下是用于显示上一篇和下一篇的程序=========================
	//通过获取上一页列表页的url来获取列表当时的分类
	public function getprelm($url){
		$lm='';
		if ($url!=''){
			$pars = parse_url($url);
			if(isset($pars['query'])){
				parse_str($pars['query'],$params);
				//如果列表页分类不是用"lm"变量保存的话，你自己动手改
				if (isset($params['lm'])){
					$lm=$params['lm'];	
				}
			}
		}
		return $lm;
	}
	//设置信息列表用来做上一篇和下一篇
	public function setprearr(){
		$sq='';
		//通过获取上一页列表页的url来获取列表当时的分类
		$slm=$this->getprelm(isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:'');
		if ($this->fid>0){
			$sq.=' and locate(",'.$this->fid.',",list_lm)>0';
		}
		if ($slm>0){
			$sq.=' and locate(",'.$slm.',",list_lm)>0';
		}
		$sql='select id,title from '.$this->table_co.' where pass=1 '.$sq.' order by px desc,id desc';
		return $this->prearr=$this->db->getrss($sql);
	}
	//获取信息列表用来做上一篇和下一篇
	public function getprearr(){
		if ($this->prearr===NULL){
			$this->setprearr();
		}
		return $this->prearr;
	}
	
	
	//以下是用于显示多图的程序=================================
	//获取多图信息
	public function getimgarr($sy_id=0,$limit=0){
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$lim=($limit>0)?' limit '.$limit:'';
		$sql='select * from `'.$this->pre.'sy_img` where `pl_id`='.$this->id.' and `sy_id`='.$sy_id.' order by px asc,id asc'.$lim;
		return $this->db->getrss($sql);
	}
	
	
	//以下是用于显示相关信息的程序==============================
	//获取从相关信息系统读取的相关信息
	public function getinfoarr($sy_id=0,$limit=0){
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$lim=($limit>0)?' limit '.$limit:'';
		$sql='select * from `'.$this->pre.'sy_info` where `pl_id`='.$this->id.' and `sy_id`='.$sy_id.' order by px asc,id asc'.$lim;
		return $this->db->getrss($sql);
	}
	//获取相关信息
	public function getinfolike($ty,$limit=0){
		//同类随机搜索
		if ($ty==1){
			$sq='';
			$lim='';
			if ($this->lm>0){
				$sq.=' and lm='.$this->lm.'';
			}
			$sq.=' and id<>'.$this->id.'';
			if ($limit>0){
				$lim.=' limit '.$limit;
			}
			$sql='select id,title'.$this->lang.',link_url,apname,img_sl,wtime from '.$this->table_co.' where pass=1 '.$sq.' order by rand()'.$lim;
			$rss=$this->db->getrss($sql);
		//关键词模糊搜索
		}elseif($ty==2){
			$sq='';
			$lim='';
			if($rs=$this->getxx()){
				//如果有多个字段做关键字匹配请调用多次这个函数并用or来连接起来
				$sq.=zusql('title'.$this->lang,$rs['keyword'.$this->lang]);
				if ($sq!=''){
					$sq.=' or '.zusql('keyword'.$this->lang,$rs['keyword'.$this->lang]);
				}else{
					$sq.=zusql('keyword'.$this->lang,$rs['keyword'.$this->lang]);
				}
				if ($sq!=''){
					$sq=' and ('.$sq.') and id<>'.$this->id.'';
				}else{
					$sq=' and 1=2';
				}
			}
			if ($limit>0){
				$lim.=' limit '.$limit;
			}
			$sql='select id,title'.$this->lang.',link_url,apname,img_sl,wtime from '.$this->table_co.' where pass=1 '.$sq.' order by px desc,id desc'.$lim;
			$rss=$this->db->getrss($sql);
		//从相关信息系统读取的相关信息
		}elseif($ty==3){
			$rss=$this->getinfoarr($this->sy_id,$limit);
		//这个也是从相关信息系统里读取（如果同一个系统中有多个“相关信息系统”，只要把“60”改为你的相关信息系统标识就可以了）
		}elseif($ty==4){
			$rss=$this->getinfoarr(60);
		}
		return $rss;
	}
	
	
	//以下是用于显示相关文件的程序==============================
	//获取从相关文件系统读取的相关文件
	public function getfilearr($sy_id=0,$limit=0){
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$lim=($limit>0)?' limit '.$limit:'';
		$sql='select * from `'.$this->pre.'sy_file` where `pl_id`='.$this->id.' and `sy_id`='.$sy_id.' order by px asc,id asc'.$lim;
		return $this->db->getrss($sql);
	}
	//获取相关信息
	public function getfilelike($ty,$limit=0){
		//同类随机搜索
		if ($ty==1){
			$sq='';
			$lim='';
			if ($this->lm>0){
				$sq.=' and lm='.$this->lm.'';
			}
			$sq.=' and id<>'.$this->id.'';
			if ($limit>0){
				$lim.=' limit '.$limit;
			}
			$sql='select id,title'.$this->lang.',link_url,apname,img_sl,fil_sl,wtime from '.$this->table_co.' where pass=1 '.$sq.' order by rand()'.$lim;
			$rss=$this->db->getrss($sql);
		//关键词模糊搜索
		}elseif($ty==2){
			$sq='';
			$lim='';
			if($rs=$this->getxx()){
				//如果有多个字段做关键字匹配请调用多次这个函数并用or来连接起来
				$sq.=zusql('title'.$this->lang,$rs['keyword'.$this->lang]);
				if ($sq!=''){
					$sq.=' or '.zusql('keyword'.$this->lang,$rs['keyword'.$this->lang]);
				}else{
					$sq.=zusql('keyword'.$this->lang,$rs['keyword'.$this->lang]);
				}
				if ($sq!=''){
					$sq=' and ('.$sq.') and id<>'.$this->id.'';
				}else{
					$sq=' and 1=2';
				}
			}
			if ($limit>0){
				$lim.=' limit '.$limit;
			}
			$sql='select id,title'.$this->lang.',link_url,apname,img_sl,fil_sl,wtime from '.$this->table_co.' where pass=1 '.$sq.' order by px desc,id desc'.$lim;
			$rss=$this->db->getrss($sql);
		//从相关文件系统读取的相关文件
		}elseif($ty==3){
			$rss=$this->getfilearr($this->sy_id,$limit);
		//这个也是从相关文件系统里读取（如果同一个系统中有多个“相关文件系统”，只要把“60”改为你的相关文件系统标识就可以了）
		}elseif($ty==4){
			$rss=$this->getfilearr(60);
		}
		return $rss;
	}
	
	
	//以下是用于显示相关视频的程序==============================
	//获取从相关视频系统读取的相关视频
	public function getvideoarr($sy_id=0,$limit=0){
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$lim=($limit>0)?' limit '.$limit:'';
		$sql='select * from `'.$this->pre.'sy_video` where `pl_id`='.$this->id.' and `sy_id`='.$sy_id.' order by px asc,id asc'.$lim;
		return $this->db->getrss($sql);
	}
	//获取相关视频
	public function getvideolike($ty,$limit=0){
		//同类随机搜索
		if ($ty==1){
			$sq='';
			$lim='';
			if ($this->lm>0){
				$sq.=' and lm='.$this->lm.'';
			}
			$sq.=' and id<>'.$this->id.'';
			if ($limit>0){
				$lim.=' limit '.$limit;
			}
			$sql='select id,title'.$this->lang.',link_url,apname,img_sl,vid_sl,wtime from '.$this->table_co.' where pass=1 '.$sq.' order by rand()'.$lim;
			$rss=$this->db->getrss($sql);
		//关键词模糊搜索
		}elseif($ty==2){
			$sq='';
			$lim='';
			if($rs=$this->getxx()){
				//如果有多个字段做关键字匹配请调用多次这个函数并用or来连接起来
				$sq.=zusql('title'.$this->lang,$rs['keyword'.$this->lang]);
				if ($sq!=''){
					$sq.=' or '.zusql('keyword'.$this->lang,$rs['keyword'.$this->lang]);
				}else{
					$sq.=zusql('keyword'.$this->lang,$rs['keyword'.$this->lang]);
				}
				if ($sq!=''){
					$sq=' and ('.$sq.') and id<>'.$this->id.'';
				}else{
					$sq=' and 1=2';
				}
			}
			if ($limit>0){
				$lim.=' limit '.$limit;
			}
			$sql='select id,title'.$this->lang.',link_url,apname,img_sl,vid_sl,wtime from '.$this->table_co.' where pass=1 '.$sq.' order by px desc,id desc'.$lim;
			$rss=$this->db->getrss($sql);
		//从相关视频系统读取的相关视频
		}elseif($ty==3){
			$rss=$this->getvideoarr($this->sy_id,$limit);
		//这个也是从相关视频系统里读取（如果同一个系统中有多个“相关视频系统”，只要把“60”改为你的相关视频系统标识就可以了）
		}elseif($ty==4){
			$rss=$this->getvideoarr(60);
		}
		return $rss;
	}


	//以下是显示页面seo信息的程序===============================
	//显示页面seo信息
	public function showseo(){
		global $sy_seo;
		$rs=array();
		$seo_html='';
		//如果没有启用系统seo，就调用全局的seo信息
		if ($sy_seo==false){
			$rs=$this->getgl();
		}else{
			$rs=$this->getxx();
		}
		//如果上面没有获取到seo信息,就调用全局的seo信息
		if (!$rs||($rs&&$rs['ym_tit'.$this->lang]=='')){
			$rs=$this->getgl();
		}
		if ($rs){
			$seo_html .= '<title>'.$rs['ym_tit'.$this->lang].'</title>'."\n";
			$seo_html .= '<meta name="keywords" content="'.$rs['ym_key'.$this->lang].'"/>'."\n";
			$seo_html .= '<meta name="description" content="'.$rs['ym_des'.$this->lang].'"/>'."\n";
		}
		echo $seo_html;
	}
		
		
	//以下是显示多图的程序(小图在底部)===========================
	//显示多图(不带左右滚动(小图在底部)、不带放大境的固定几张图的切换)
	public function showimg_1_1($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{ width:300px;}	
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px;height:298px;border:1px solid #dcdddd; overflow:hidden;}	/*如果要加放大镜，请删除"overflow:hidden;"，否则放大镜显示不了*/
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:300px; height:72px; margin-top:6px; overflow:hidden;}	
				.duotu_'.$rnd.' .smaimg li{width:72px; height:72px; margin-right:4px; float:left; cursor:pointer; display:inline;}
				.duotu_'.$rnd.' .smaimg li.last{margin-right:0px;}	
				.duotu_'.$rnd.' .smaimg img{width:70px; height:70px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg .on img{border-color:#C00C3E;}
				/*
				提醒：
				如果想把列表小图移动到别的地方
				1.设定.duotu为相对定位 position:relative;
				2.设定.duotu .smaimg为绝对定位并设置好你要的位置 position:absolute; left:320px; top:220px;
				*/
				</style>	
			'."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li><span><img src="'.$this->path.getimgj($v['img_sl'],'z').'"></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smaimg">'."\n";
			$show_html .= '<ul>'."\n";
			$a=1;
			foreach($arr as $v){
				$last=($a==4)?' class="last"':'';
				$show_html .='<li '.$last.'><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				$a++;
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">	
					$(".duotu_'.$rnd.'").slide({ mainCell:".bigimg ul", titCell:".smaimg li", effect:"fold"});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	//显示多图样式(不带左右滚动(小图在底部)、带放大境的固定几张图的切换)
	public function showimg_1_2($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{width:300px;}	
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px;height:298px;border:1px solid #dcdddd;}
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:300px; height:72px; margin-top:6px; overflow:hidden;}	
				.duotu_'.$rnd.' .smaimg li{width:72px; height:72px; margin-right:4px; float:left; cursor:pointer; display:inline;}
				.duotu_'.$rnd.' .smaimg li.last{margin-right:0px;}	
				.duotu_'.$rnd.' .smaimg img{width:70px; height:70px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg .on img{border-color:#C00C3E;}
				/*
				提醒：
				如果想把列表小图移动到别的地方
				1.设定.duotu为相对定位 position:relative;
				2.设定.duotu .smaimg为绝对定位并设置好你要的位置 position:absolute; left:320px; top:220px;
				*/
				</style>	
			'."\n";
			$show_html .= $this->loadcss($this->path.'template/public/css/MagicZoom.css')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/MagicZoom.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li style="display:none;"><span><a href="'.$this->path.getimgj($v['img_sl'],'d').'" rel="zoom-position: right;" class="MagicZoom"><img src="'.$this->path.getimgj($v['img_sl'],'z').'" ></a></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smaimg">'."\n";
			$show_html .= '<ul>'."\n";
			$a=1;
			foreach($arr as $v){
				$last=($a==4)?' class="last"':'';
				$show_html .='<li '.$last.'><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				$a++;
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul",titCell: ".smaimg li", effect:"fold"});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	//显示多图样式(带左右滚动(小图在底部)，不带放大镜)
	public function showimg_1_3($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu{width:300px;}	
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px;height:298px;border:1px solid #dcdddd; overflow:hidden;}/*如果要加放大镜，请删除"overflow:hidden;"，否则放大镜显示不了*/
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}	
				/*左右按钮*/
				.duotu_'.$rnd.' .smallscroll_'.$rnd.'{ margin-top:6px;}
				.duotu_'.$rnd.' .sprev{ width: 14px; height: 63px; float:left; display: block; background: url('.$this->path.'template/public/images/lr_btn_d.png) no-repeat 0 0;}
				.duotu_'.$rnd.' .snext{ width: 14px; height: 63px; float:left; display: block; background: url('.$this->path.'template/public/images/lr_btn_d.png) no-repeat -14px 0;}	
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:268px; float:left; margin-left:4px;}
				.duotu_'.$rnd.' .smaimg li{ width:63px; height:63px;float:left; cursor:pointer; display:inline; margin-right:4px;}
				.duotu_'.$rnd.' .smaimg img{width:61px; height:61px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg li.on img{border-color:#C00C3E;}
				</style>	
			'."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li><span><img src="'.$this->path.getimgj($v['img_sl'],'z').'"></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smallscroll_'.$rnd.'">'."\n";
			if ($arr){
				$show_html .= '<a class="sprev" href="javascript:void(0)"></a>'."\n";
				$show_html .= '<div class="smaimg">'."\n";
				$show_html .= '<ul>'."\n";
				foreach($arr as $v){
					$show_html .='<li><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				}
				$show_html .= '</ul>'."\n";
				$show_html .= '</div>'."\n";
				$show_html .= '<a class="snext" href="javascript:void(0)"></a>'."\n";
			}
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul", titCell: ".smaimg li",effect:"fold"});
					$(".smallscroll_'.$rnd.'").slide({mainCell:".smaimg ul",prevCell:".sprev",nextCell:".snext",effect:"left",scroll:1,vis:4,autoPage:true,pnLoop:false});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	//显示多图样式(带左右滚动(小图在底部)，带放大镜)
	public function showimg_1_4($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{width:300px;}	
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px;height:298px;border:1px solid #dcdddd;}
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}
				/*左右按钮*/
				.duotu_'.$rnd.' .smallscroll_'.$rnd.'{ margin-top:6px;}
				.duotu_'.$rnd.' .sprev{ width: 14px; height: 63px; float:left; display: block; background: url('.$this->path.'template/public/images/lr_btn_d.png) no-repeat 0 0;}
				.duotu_'.$rnd.' .snext{ width: 14px; height: 63px; float:left; display: block; background: url('.$this->path.'template/public/images/lr_btn_d.png) no-repeat -14px 0;}	
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:268px; float:left; margin-left:4px;}
				.duotu_'.$rnd.' .smaimg li{ width:63px; height:63px;float:left; cursor:pointer; display:inline; margin-right:4px;}
				.duotu_'.$rnd.' .smaimg img{width:61px; height:61px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg li.on img{border-color:#C00C3E;}
				</style>	
			'."\n";
			$show_html .= $this->loadcss($this->path.'template/public/css/MagicZoom.css')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/MagicZoom.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li style="display:none;"><span><a href="'.$this->path.getimgj($v['img_sl'],'d').'" rel="zoom-position: right;" class="MagicZoom"><img src="'.$this->path.getimgj($v['img_sl'],'z').'" ></a></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smallscroll_'.$rnd.'">'."\n";
			if ($arr){
				$show_html .= '<a class="sprev" href="javascript:void(0)"></a>'."\n";
				$show_html .= '<div class="smaimg">'."\n";
				$show_html .= '<ul>'."\n";
				foreach($arr as $v){
					$show_html .='<li><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				}
				$show_html .= '</ul>'."\n";
				$show_html .= '</div>'."\n";
				$show_html .= '<a class="snext" href="javascript:void(0)"></a>'."\n";
			}
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul",titCell: ".smaimg li", effect:"fold"});
					$(".smallscroll_'.$rnd.'").slide({mainCell:".smaimg ul",prevCell:".sprev",nextCell:".snext",effect:"left",scroll:1,vis:4,autoPage:true,pnLoop:false});
					
				</script>'."\n";
			echo $show_html;
		}
	}
	
	
	//以下是显示多图的程序(小图在右边)========================================
	//显示多图(不带上下滚动(小图在右边)、不带放大境的固定几张图的切换)
	public function showimg_2_1($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{ width:378px;}	
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px; height:298px; float:left; border:1px solid #dcdddd; overflow:hidden;}	/*如果要加放大镜，请删除"overflow:hidden;"，否则放大镜显示不了*/
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:72; height:300px; float:left; margin-left:6px; overflow:hidden;}	
				.duotu_'.$rnd.' .smaimg li{width:72px; height:72px; margin-bottom:4px; cursor:pointer;}
				.duotu_'.$rnd.' .smaimg li.last{margin-bottom:0px;}	
				.duotu_'.$rnd.' .smaimg img{width:70px; height:70px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg .on img{border-color:#C00C3E;}
				/*
				提醒：
				如果想把列表小图移动到别的地方
				1.设定.duotu为相对定位 position:relative;
				2.设定.duotu .smaimg为绝对定位并设置好你要的位置 position:absolute; left:320px; top:220px;
				*/
				</style>
			'."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li><span><img src="'.$this->path.getimgj($v['img_sl'],'z').'"></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smaimg">'."\n";
			$show_html .= '<ul>'."\n";
			$a=1;
			foreach($arr as $v){
				$last=($a==4)?' class="last"':'';
				$show_html .='<li '.$last.'><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				$a++;
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">	
					$(".duotu_'.$rnd.'").slide({ mainCell:".bigimg ul", titCell:".smaimg li", effect:"fold"});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	//显示多图样式(不带上下滚动(小图在右边)、带放大境的固定几张图的切换)
	public function showimg_2_2($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{ width:378px;}	
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px; height:298px; float:left; border:1px solid #dcdddd;}
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:72; height:300px; float:left; margin-left:6px; overflow:hidden;}	
				.duotu_'.$rnd.' .smaimg li{width:72px; height:72px; margin-bottom:4px; cursor:pointer;}
				.duotu_'.$rnd.' .smaimg li.last{margin-bottom:0px;}	
				.duotu_'.$rnd.' .smaimg img{width:70px; height:70px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg .on img{border-color:#C00C3E;}
				/*
				提醒：
				如果想把列表小图移动到别的地方
				1.设定.duotu为相对定位 position:relative;
				2.设定.duotu .smaimg为绝对定位并设置好你要的位置 position:absolute; left:320px; top:220px;
				*/
				</style>
			'."\n";
			$show_html .= $this->loadcss($this->path.'template/public/css/MagicZoom.css')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/MagicZoom.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li style="display:none;"><span><a href="'.$this->path.getimgj($v['img_sl'],'d').'" rel="zoom-position: right;" class="MagicZoom"><img src="'.$this->path.getimgj($v['img_sl'],'z').'" ></a></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smaimg">'."\n";
			$show_html .= '<ul>'."\n";
			$a=1;
			foreach($arr as $v){
				$last=($a==4)?' class="last"':'';
				$show_html .='<li '.$last.'><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				$a++;
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul",titCell: ".smaimg li", effect:"fold"});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	
	//显示多图样式(带上下滚动(小图在右边)，不带放大镜)
	public function showimg_2_3($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{width:369px;}
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px;height:298px; float:left; border:1px solid #dcdddd; overflow:hidden;}/*如果要加放大镜，请删除"overflow:hidden;"，否则放大镜显示不了*/
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}	
				/*左右按钮*/
				.duotu_'.$rnd.' .smallscroll_'.$rnd.'{ width:63px;margin-left:6px; float:left;}
				.duotu_'.$rnd.' .sprev{ width: 63px; height: 14px; display: block; background: url('.$this->path.'template/public/images/tb_btn_d.png) no-repeat 0 0;}
				.duotu_'.$rnd.' .snext{ width: 63px; height: 14px; display: block; background: url('.$this->path.'template/public/images/tb_btn_d.png) no-repeat 0 -14px;}	
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:63px; margin-top:4px;}
				.duotu_'.$rnd.' .smaimg li{ width:63px; height:63px;cursor:pointer; margin-bottom:4px;}
				.duotu_'.$rnd.' .smaimg img{width:61px; height:61px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg li.on img{border-color:#C00C3E;}
				</style>
			'."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li><span><img src="'.$this->path.getimgj($v['img_sl'],'z').'"></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smallscroll_'.$rnd.'">'."\n";
			if ($arr){
				$show_html .= '<a class="sprev" href="javascript:void(0)"></a>'."\n";
				$show_html .= '<div class="smaimg">'."\n";
				$show_html .= '<ul>'."\n";
				foreach($arr as $v){
					$show_html .='<li><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				}
				$show_html .= '</ul>'."\n";
				$show_html .= '</div>'."\n";
				$show_html .= '<a class="snext" href="javascript:void(0)"></a>'."\n";
			}
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul", titCell: ".smaimg li",effect:"fold"});
					$(".smallscroll_'.$rnd.'").slide({mainCell:".smaimg ul",prevCell:".sprev",nextCell:".snext",effect:"top",scroll:1,vis:4,autoPage:true,pnLoop:false});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	//显示多图样式(带上下滚动(小图在右边)，带放大镜)
	public function showimg_2_4($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{width:369px;}
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px;height:298px; float:left; border:1px solid #dcdddd;}
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}	
				/*左右按钮*/
				.duotu_'.$rnd.' .smallscroll_'.$rnd.'{ width:63px;margin-left:6px; float:left;}
				.duotu_'.$rnd.' .sprev{ width: 63px; height: 14px; display: block; background: url('.$this->path.'template/public/images/tb_btn_d.png) no-repeat 0 0;}
				.duotu_'.$rnd.' .snext{ width: 63px; height: 14px; display: block; background: url('.$this->path.'template/public/images/tb_btn_d.png) no-repeat 0 -14px;}	
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:63px; margin-top:4px;}
				.duotu_'.$rnd.' .smaimg li{ width:63px; height:63px;cursor:pointer; margin-bottom:4px;}
				.duotu_'.$rnd.' .smaimg img{width:61px; height:61px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg li.on img{border-color:#C00C3E;}
				</style>
			'."\n";
			$show_html .= $this->loadcss($this->path.'template/public/css/MagicZoom.css')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/MagicZoom.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li style="display:none;"><span><a href="'.$this->path.getimgj($v['img_sl'],'d').'" rel="zoom-position: right;" class="MagicZoom"><img src="'.$this->path.getimgj($v['img_sl'],'z').'" ></a></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smallscroll_'.$rnd.'">'."\n";
			if ($arr){
				$show_html .= '<a class="sprev" href="javascript:void(0)"></a>'."\n";
				$show_html .= '<div class="smaimg">'."\n";
				$show_html .= '<ul>'."\n";
				foreach($arr as $v){
					$show_html .='<li><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				}
				$show_html .= '</ul>'."\n";
				$show_html .= '</div>'."\n";
				$show_html .= '<a class="snext" href="javascript:void(0)"></a>'."\n";
			}
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul",titCell: ".smaimg li", effect:"fold"});
					$(".smallscroll_'.$rnd.'").slide({mainCell:".smaimg ul",prevCell:".sprev",nextCell:".snext",effect:"top",scroll:1,vis:4,autoPage:true,pnLoop:false});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	
	//以下是显示多图的程序(小图在左边)========================================
	//显示多图(不带上下滚动(小图在左边)、不带放大境的固定几张图的切换)
	public function showimg_3_1($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{ width:378px;}	
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px; height:298px; float:right; border:1px solid #dcdddd; overflow:hidden;}	/*如果要加放大镜，请删除"overflow:hidden;"，否则放大镜显示不了*/
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:72; height:300px; float:left; margin-right:6px; overflow:hidden;}	
				.duotu_'.$rnd.' .smaimg li{width:72px; height:72px; margin-bottom:4px; cursor:pointer;}
				.duotu_'.$rnd.' .smaimg li.last{margin-bottom:0px;}	
				.duotu_'.$rnd.' .smaimg img{width:70px; height:70px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg .on img{border-color:#C00C3E;}
				/*
				提醒：
				如果想把列表小图移动到别的地方
				1.设定.duotu为相对定位 position:relative;
				2.设定.duotu .smaimg为绝对定位并设置好你要的位置 position:absolute; left:320px; top:220px;
				*/
				</style>
			'."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li><span><img src="'.$this->path.getimgj($v['img_sl'],'z').'"></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smaimg">'."\n";
			$show_html .= '<ul>'."\n";
			$a=1;
			foreach($arr as $v){
				$last=($a==4)?' class="last"':'';
				$show_html .='<li '.$last.'><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				$a++;
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">	
					$(".duotu_'.$rnd.'").slide({ mainCell:".bigimg ul", titCell:".smaimg li", effect:"fold"});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	//显示多图样式(不带上下滚动(小图在左边)、带放大境的固定几张图的切换)
	public function showimg_3_2($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{ width:378px;}	
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px; height:298px; float:right; border:1px solid #dcdddd;}
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:72; height:300px; float:left; margin-right:6px; overflow:hidden;}	
				.duotu_'.$rnd.' .smaimg li{width:72px; height:72px; margin-bottom:4px; cursor:pointer;}
				.duotu_'.$rnd.' .smaimg li.last{margin-bottom:0px;}	
				.duotu_'.$rnd.' .smaimg img{width:70px; height:70px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg .on img{border-color:#C00C3E;}
				/*
				提醒：
				如果想把列表小图移动到别的地方
				1.设定.duotu为相对定位 position:relative;
				2.设定.duotu .smaimg为绝对定位并设置好你要的位置 position:absolute; left:320px; top:220px;
				*/
				</style>
			'."\n";
			$show_html .= $this->loadcss($this->path.'template/public/css/MagicZoom.css')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/MagicZoom.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li style="display:none;"><span><a href="'.$this->path.getimgj($v['img_sl'],'d').'" rel="zoom-position: right;" class="MagicZoom"><img src="'.$this->path.getimgj($v['img_sl'],'z').'" ></a></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smaimg">'."\n";
			$show_html .= '<ul>'."\n";
			$a=1;
			foreach($arr as $v){
				$last=($a==4)?' class="last"':'';
				$show_html .='<li '.$last.'><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				$a++;
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul",titCell: ".smaimg li", effect:"fold"});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	
	//显示多图样式(带上下滚动(小图在左边)，不带放大镜)
	public function showimg_3_3($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{width:369px;}
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px;height:298px; float:right; border:1px solid #dcdddd; overflow:hidden;}/*如果要加放大镜，请删除"overflow:hidden;"，否则放大镜显示不了*/
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}	
				/*左右按钮*/
				.duotu_'.$rnd.' .smallscroll_'.$rnd.'{ width:63px;margin-right:6px; float:left;}
				.duotu_'.$rnd.' .sprev{ width: 63px; height: 14px; display: block; background: url('.$this->path.'template/public/images/tb_btn_d.png) no-repeat 0 0;}
				.duotu_'.$rnd.' .snext{ width: 63px; height: 14px; display: block; background: url('.$this->path.'template/public/images/tb_btn_d.png) no-repeat 0 -14px;}	
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:63px; margin-top:4px;}
				.duotu_'.$rnd.' .smaimg li{ width:63px; height:63px;cursor:pointer; margin-bottom:4px;}
				.duotu_'.$rnd.' .smaimg img{width:61px; height:61px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg li.on img{border-color:#C00C3E;}
				</style>
			'."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li><span><img src="'.$this->path.getimgj($v['img_sl'],'z').'"></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smallscroll_'.$rnd.'">'."\n";
			if ($arr){
				$show_html .= '<a class="sprev" href="javascript:void(0)"></a>'."\n";
				$show_html .= '<div class="smaimg">'."\n";
				$show_html .= '<ul>'."\n";
				foreach($arr as $v){
					$show_html .='<li><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				}
				$show_html .= '</ul>'."\n";
				$show_html .= '</div>'."\n";
				$show_html .= '<a class="snext" href="javascript:void(0)"></a>'."\n";
			}
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul", titCell: ".smaimg li",effect:"fold"});
					$(".smallscroll_'.$rnd.'").slide({mainCell:".smaimg ul",prevCell:".sprev",nextCell:".snext",effect:"topLoop",scroll:1,vis:4,autoPage:true,pnLoop:false});
				</script>'."\n";
			echo $show_html;
		}
	}
	
	//显示多图样式(带上下滚动(小图在左边)，带放大镜)
	public function showimg_3_4($sy_id=0,$limit=0){
		//随机名
		$rnd=rand(100,1000);
		$sy_id=($sy_id==0)?$this->sy_id:$sy_id;
		$arr=$this->getimgarr($sy_id,$limit);
		if ($arr){
			$show_html='
				<style>
				.duotu_'.$rnd.'{width:369px;}
				/*中图*/
				.duotu_'.$rnd.' .bigimg{width:298px;height:298px; float:right; border:1px solid #dcdddd;}
				.duotu_'.$rnd.' .bigimg li{ width:298px;height:298px;text-align:center;display:table;}
				.duotu_'.$rnd.' .bigimg li span{vertical-align:middle;display:table-cell;}
				.duotu_'.$rnd.' .bigimg li a{ margin:0px auto;}	
				/*左右按钮*/
				.duotu_'.$rnd.' .smallscroll_'.$rnd.'{ width:63px;margin-right:6px; float:left;}
				.duotu_'.$rnd.' .sprev{ width: 63px; height: 14px; display: block; background: url('.$this->path.'template/public/images/tb_btn_d.png) no-repeat 0 0;}
				.duotu_'.$rnd.' .snext{ width: 63px; height: 14px; display: block; background: url('.$this->path.'template/public/images/tb_btn_d.png) no-repeat 0 -14px;}	
				/*小图*/
				.duotu_'.$rnd.' .smaimg{width:63px; margin-top:4px;}
				.duotu_'.$rnd.' .smaimg li{ width:63px; height:63px;cursor:pointer; margin-bottom:4px;}
				.duotu_'.$rnd.' .smaimg img{width:61px; height:61px; border: 1px solid #dcdddd;}	
				.duotu_'.$rnd.' .smaimg li.on img{border-color:#C00C3E;}
				</style>
			'."\n";
			$show_html .= $this->loadcss($this->path.'template/public/css/MagicZoom.css')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/jquery.SuperSlide.js')."\n";
			$show_html .= $this->loadjs($this->path.'template/public/js/MagicZoom.js')."\n";
			$show_html .= '<div class="duotu_'.$rnd.'">'."\n";
			$show_html .= '<div class="bigimg">'."\n";
			$show_html .= '<ul>'."\n";
			foreach($arr as $v){
				$show_html .='<li style="display:none;"><span><a href="'.$this->path.getimgj($v['img_sl'],'d').'" rel="zoom-position: right;" class="MagicZoom"><img src="'.$this->path.getimgj($v['img_sl'],'z').'" ></a></span></li>'."\n";
			}
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div class="smallscroll_'.$rnd.'">'."\n";
			if ($arr){
				$show_html .= '<a class="sprev" href="javascript:void(0)"></a>'."\n";
				$show_html .= '<div class="smaimg">'."\n";
				$show_html .= '<ul>'."\n";
				foreach($arr as $v){
					$show_html .='<li><a><img src="'.$this->path.$v['img_sl'].'"></a></li>'."\n";
				}
				$show_html .= '</ul>'."\n";
				$show_html .= '</div>'."\n";
				$show_html .= '<a class="snext" href="javascript:void(0)"></a>'."\n";
			}
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '
				<script type="text/javascript">
					$(".duotu_'.$rnd.'").slide({mainCell:".bigimg ul",titCell: ".smaimg li", effect:"fold"});
					$(".smallscroll_'.$rnd.'").slide({mainCell:".smaimg ul",prevCell:".sprev",nextCell:".snext",effect:"top",scroll:1,vis:4,autoPage:true,pnLoop:false});
				</script>'."\n";
			echo $show_html;
		}
	}


	//以下是显示信息字段的程序=====================================================
	public function showxx_zd($field){
		$arr=$this->getxx();
		if (isset($arr[$field])){
			echo $arr[$field];	
		}
	}
	
	
	//显示详细信息(不带tab标签的单个内容)============================================
	public function showxx_1(){
		$show_html='';
		$rs=$this->getxx();
		if ($rs){
			$show_html .='
			<style>
			.detail_page{width:100%;}
			.detail_page .detail_title{text-align:center;font-weight:bold; font-size:14px; padding:5px 0 5px 0px;}
			.detail_page .detail_wtime{text-align:right; line-height:22px; color:#999; padding-bottom:5px;}
			.detail_page .detail_z_body{line-height:200%;}
			.detail_page .detail_goback{margin:10px 0px;text-align:right;}
			</style>'."\n";
			$show_html .= '<div class="detail_page">'."\n";
			$show_html .= '<h2 class="detail_title">'.$rs['title'.$this->lang].'</h2>'."\n";
			$show_html .= '<div class="detail_wtime">'.date("Y-m-d",$rs['wtime']).'</div>'."\n";
			$show_html .= '<div class="detail_z_body">'.$rs['z_body'.$this->lang].'</div>'."\n";
			$show_html .= '<p class="detail_goback"><a href="javascript:history.go(-1)">[返回]</a></p>'."\n";
			$show_html .= '</div>'."\n";
		}
		echo $show_html;
	}
	
	
	//显示详细信息(带tab标签的多个内容)============================================
	public function showxx_2($arr){
		$show_html='';
		$rs=$this->getxx();
		if ($rs){
			$show_html = '
			<style>
			.detit{ width:100%;}
			.detit li {display:inline;cursor:pointer; line-height:110%;} 
			.detit li{float:left; background:url("'.$this->path.'template/tab_1/images/tableftK.gif") no-repeat left top;padding:0 0 0 4px; text-decoration:none;color:#FFF;} 
			.detit li span {float:none;display:block; background:url("'.$this->path.'template/tab_1/images/tabrightK.gif") no-repeat right top; padding:8px 16px 4px 12px; margin-right:2px;} 
			.detit li.on { background-position:0% -42px; } 
			.detit li.on span { background-position:100% -42px; }
			.decon .cons { width:100%;border:1px solid #54545C; padding:15px;}
			</style>'."\n";
			$show_html .='
			<script type="text/javascript">
			function settabs(n){
				tli=document.getElementById("detit").getElementsByTagName("li");
				for(i=0;i<tli.length;i++){
					k=i+1
					if (k==n){
						tli[i].className="cur";
						document.getElementById("con_"+k).style.display="";  
					}else{
						tli[i].className="";
						document.getElementById("con_"+k).style.display="none";
					}
				}
			}
			</script>'."\n";
			$show_html .= '<div class="detail_page">'."\n";
			$show_html .= '<div class="detit" id="detit">'."\n";
			$show_html .= '<ul>'."\n";
			$a=1;
			foreach($arr as $k=>$v){
				$show_html .= '<li onMouseOver="settabs('.$a.')"><span>'.$k.'</span></li>'."\n";
				$a++;
			}
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</ul>'."\n";
			$show_html .= '</div>';
			$show_html .= '<div class="decon">'."\n";
			$a=1;
			foreach($arr as $k=>$v){
				$show_html .= '<div class="cons" id="con_'.$a.'" '.(($a!=1)?'style="display:none;"':'').'>'.$rs[$v.$this->lang].'</div>'."\n";
				$a++;
			}
			$show_html .= '</div>'."\n";
			$show_html .= '<div style="clear:both;"></div>'."\n";
			$show_html .= '</div>'."\n";
		}
		echo $show_html;
	}
	
	//显示上一篇下一篇=============================================
	//显示上一篇
	public function showprev($pname,$sub=0){
		$v=array();
		$arr=$this->getprearr();
		foreach($arr as $ek=>$ev){
			if ($ev['id']==$this->id){
				if (isset($arr[$ek-1])){
					$v=$arr[$ek-1];
					break;
				}
			}
		}
		if ($v){
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			echo '<a href="'.$turl.'" '.$targ.'>'.$title.'</a>';
		}else{
			echo '没有了';
		}
	}
	//显示下一篇
	public function shownext($pname,$sub=0){
		$v=array();
		$arr=$this->getprearr();
		foreach($arr as $ek=>$ev){
			if ($ev['id']==$this->id){
				if (isset($arr[$ek+1])){
					$v=$arr[$ek+1];
					break;
				}
			}
		}
		if ($v){
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			echo '<a href="'.$turl.'" '.$targ.'>'.$title.'</a>';
		}else{
			echo '没有了';
		}
	}
	
	
	//显示相关信息===========================================
	public function showinfolike($pname,$ty=3,$limit=0,$sub=0,$last=0){
		$arr=$this->getinfolike($ty,$limit);
		$show_html = '';
		foreach($arr as $k=>$v){
			//每行最后一条信息加上last样式名
			$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
			//判断是否定义了日期时间同时日期时间大于0
			$time=(isset($v['wtime'])&&$v['wtime']>0)?'<span>'.date('Y-m-d',$v['wtime']).'</span>':'';
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			$show_html .= '<li '.$tlast.'>'.$time.'<a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
		}
		echo $show_html;
	}
	
	
	//显示相关文件===========================================
	public function showfilelike($pname,$ty=3,$limit=0,$sub=0,$last=0){
		$arr=$this->getfilelike($ty,$limit);
		$show_html = '';
		foreach($arr as $v){
			//每行最后一条信息加上last样式名
			$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
			//判断是否定义了日期时间同时日期时间大于0
			$time=(isset($v['wtime'])&&$v['wtime']>0)?'<span>'.date('Y-m-d',$v['wtime']).'</span>':'';
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:(($v['fil_sl']!='')?$v['fil_sl']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:''))));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':(($v['fil_sl']!=''&&strpos($v['fil_sl'],'http://')!==false)?'target="_blank"':'');
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			$show_html .= '<li '.$tlast.'>'.$time.'<a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
		}
		echo $show_html;
	}
	
	
	//显示相关视频==========================================
	public function showvideolike($pname,$ty=3,$limit=0,$sub=0,$last=0){
		$arr=$this->getvideolike($ty,$limit);
		$show_html = '';
		foreach($arr as $v){
			//每行最后一条信息加上last样式名
			$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
			//判断是否定义了日期时间同时日期时间大于0
			$time=(isset($v['wtime'])&&$v['wtime']>0)?'<span>'.date('Y-m-d',$v['wtime']).'</span>':'';
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:(($v['vid_sl']!='')?$v['vid_sl']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:''))));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':(($v['vid_sl']!=''&&strpos($v['fil_sl'],'http://')!==false)?'target="_blank"':'');
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			$show_html .= '<li '.$tlast.'>'.$time.'<a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
		}
		echo $show_html;
	}
}	
?>