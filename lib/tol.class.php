<?php
if(!defined('IN_MO')){
	exit('Access Denied');
}
class tol extends base{

	public $table_co = 'tol_co';	             //内容表
	public $table_lm = 'tol_lm';	             //栏目表
	public $sy_id=1;                             //本系统的seo信息的记录id(同时也是多图、相关信息、相关文件、相关视频的系统区分id，因为整站的多图、相关信息、相关文件、相关视频都是只保存在4个表中)

	public $ty;                                  //当前导航栏目的类型，$ty=1代表只有一条信息，$ty=2代表只有1个固定分类，$ty=3代表有多个分类
												 //$ty=4代表有多个分类(分类有连接，分类连接默认是每个分类的第1篇资料，当分类下只有1篇资料时只显示分类并且分类带那1篇资料的链接，不显示资料列表)
	public $fid;								 //只有$ty=3时，$fid代表是多个分类的父id
	public $lm;									 //当前分类
	public $id;					                 //当前id
	public $row;		                         //保存当前id的数据数组
	
	public $lmrow;		                         //保存分类的数组(按分类id保存)
	public $lmarr;              	             //保存分类的数组(按分类级别保存)
	public $coarr;								 //保存是信息列表(以信息id为键值)
	public $colist;								 //保存是信息列表(以分类id为键值)
	
	
	//构造函数
	function __construct($ty,$id=''){
		//调用上级基类的构造函数
		parent::__construct();
		//调用本类的检查参数函数
		$this->check($ty,$id);
		$this->table_co=$this->pre.$this->table_co;
		$this->table_lm=$this->pre.$this->table_lm;
	}
	
	//析构函数
	function __destruct(){
		unset($this->lmarr);
		unset($this->coarr);
	}
	
	
	//以下是初始化程序============================
	//检查参数函数
	protected function check($ty,$id){
		if ($ty==1){
			if ($id==''||!checknum($id)){
				exit('设置了$ty=1，代表的是只有一条信息，$id就是那条信息的id');
			}
			$this->fid='';
			$this->lm='';
			$this->id=$id;
		}elseif($ty==2){
			if ($id==''||!checknum($id)){
				exit('设置了$ty=2，代表的是只有一个分类，$id就是那个分类的id_lm');
			}
			$this->fid='';
			$this->lm=$id;
			$this->id='';
		}elseif($ty==3){
			if($id===''||!checknum($id)){
				exit('设置了$ty=3，代表的是有多个分类，$id就是多个分类的fid');
			}
			$this->fid=$id;
			$this->lm='';
			$this->id='';
		}elseif($ty==4){
			if($id===''||!checknum($id)){
				exit('设置了$ty=4，代表的是有多个分类，$id就是多个分类的fid');
			}
			$this->fid=$id;
			$this->lm='';
			$this->id='';
		}
		$this->ty=$ty;
	}
	//实例化后手动执行函数---针对$ty来判断默认执行什么函数
	public function init(){
		$this->getpar();
		if($this->ty==2||$this->ty==3||$this->ty==4){
			if ($this->id==''){
				$this->setfxx();
			}
		}
		$this->setxx();
	}
	
	
	//以下用于初始化时执行的方法===========================
	//获取页面传递参数
	public function getpar(){
		//获取参数
		if ($this->ty==2||$this->ty==3||$this->ty==4){
			//id
			$id=isset($_GET['id'])?$_GET['id']:'';
			
			if ($id!=''){
				if(!checknum($id)){
					msg('参数错误');
				}else{
					$this->id=$id;
				}
			}
		}
		//获取其他参数在这里写
		
	}
	//设置默认打开导航栏目时的左侧第1个分类的第1条信息id
	public function setfxx(){
		$lmrow=$this->getlmarr();
		$coarr=$this->getcoarr();
		$fid=($this->fid=='')?0:$this->fid;
		if (isset($lmrow[1][$fid])){
			$this->lm=$lmrow[1][$fid][0]['id_lm'];
			foreach($coarr as $vv){
				if($vv['lm']==$lmrow[1][$fid][0]['id_lm']){
					$this->id=$vv['id'];
					break;
				}
			}
		}
	}
	
	
	//以下是用于显示详细信息程序==============================
	//设置详细信息数组
	public function setxx(){
		$rs=array();
		if ($this->id!=''){
			$arr=$this->getcoarr();
			if (isset($arr[$this->id])){
				$rs=$arr[$this->id];
				if ($rs['lm']>0){
					$this->lm=$rs['lm'];
				}
			}else{
				$rs=$this->db->getrs('select * from `'.$this->table_co .'` where pass=1 and id='.$this->id.'');
				if (!$rs){
					msg('该信息不存在或已删除');
				}else{
					if ($rs['lm']>0){
						$this->lm=$rs['lm'];
					}
				}
			}
			$this->db->execute('update '.$this->table_co.' set read_num=read_num+1 where id='.$this->id.'');
		}
		$this->row=$rs;
	}
	//获取详细数组
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
	//获取信息标题
	public function gettitle_xx(){
		$title='';
		if ($rs=$this->getxx()){
			$title=$rs['title'.$this->lang];
		}
		return $title;
	}
	//获取信息附加的页面名称（用于后台可控制页面名称的伪静态）
	public function getapname_xx(){
		$apname_xx='';
		if ($rs=$this->getxx()){
			$apname_xx=$rs['apname'];
		}
		return $apname_xx;
	}	
	
	//以下是获取单个分类信息==============================
	public function getlm($lm=0){
		$rs=array();
		$lm=($lm==0)?$this->lm:$lm;
		if ($lm!=''){
			$arr=$this->getlmrow();
			if (isset($arr[$lm])){
				$rs=$arr[$lm];
			}else{
				$rs=$this->db->getrs('select * from `'.$this->table_lm .'` where pass=1 and id_lm='.$lm.'');
			}
		}
		return $rs;
	}
	//获取分类字段信息
	public function getlm_zd($field,$lm=0){
		$zd='';
		$lm=($lm==0)?$this->lm:$lm;
		$arr=$this->getlm($lm);
		if (isset($arr[$field])){
			$zd=$arr[$field];	
		}
		return $zd;
	}
	//获取分类标题
	public function gettitle_lm($lm=0){
		$title_lm='';
		$lm=($lm==0)?$this->lm:$lm;
		if ($lm!=''){
			if ($rs=$this->getlm($lm)){
				$title_lm=$rs['title_lm'.$this->lang];
			}
		}
		return $title_lm;
	}
	//获取分类附加的页面名称（用于后台可控制页面名称的伪静态）
	public function getapname_lm($lm=0){
		$apname_lm='';
		$lm=($lm==0)?$this->lm:$lm;
		if ($lm!=''){
			if ($rs=$this->getlm($lm)){
				if (isset($rs['apname_lm'])){
					$apname_lm=$rs['apname_lm'];
				}
			}
		}
		return $apname_lm;
	}


	//以下是获取分类数组(分类id为键值)程序====================
	//设置分类列表数组(分类id为键值)
	public function setlmrow(){
		if ($this->ty==2||$this->ty==3||$this->ty==4){
			$sq='';
			//只有1个固定分类
			if($this->ty==2){
				$sq=' and id_lm='.$this->lm.'';
			//有分类列表
			}elseif($this->ty==3||$this->ty==4){
				if ($this->fid==0){
					$sq='';
				}else{
					$sq=' and locate(",'.$this->fid.',",list_lm)>0';
				}
			}
			$sql='select * from `'.$this->table_lm .'` where pass=1 '.$sq.' order by px desc,id_lm desc';
			$arr=$this->db->getrss($sql);
			$temparr=array();
			foreach($arr as $k=>$v){
				$temparr[$v['id_lm']]=$v;
			}
			$this->lmrow=$temparr;
		}else{
			$this->lmrow=array();
		}
	}
	//获取分类列表数组(分类id为键值)
	public function getlmrow(){
		if ($this->lmrow===NULL){
			$this->setlmrow();
		}
		return $this->lmrow;
	}
	
	
	//以下是获取分类列表数组(分类级别为键值)的程序==========================
	//设置分类列表数组(分类级别为键值)
	public function setlmarr(){
		$arr=$this->getlmrow();
		$level=0;
		if ($this->fid>0){
			$rs=$this->getlm($this->fid);
			$level=$rs['level_lm'];
		}
		$temparr = array();
		foreach($arr as $k=>$v){
			$temparr[($v['level_lm']-$level)][$v['fid']][] = $v;
		}
		$this->lmarr = $temparr;
	}
	//获取分类列表数组(分类级别为键值)
	public function getlmarr(){
		if ($this->lmarr===NULL){
			$this->setlmarr();
		}
		return $this->lmarr;
	}
	
	//以下是获取资料列表数组的程序====================
	//设置资料列表数组
	public function setcoarr(){
		$sq='';
		if ($this->ty==1){
			$sq=' and id='.$this->id.'';
		}elseif ($this->ty==2){
			$sq=' and locate(",'.$this->lm.',",list_lm)>0';
		}elseif(($this->ty==3||$this->ty==4)&&$this->fid>0){
			$sq=' and locate(",'.$this->fid.',",list_lm)>0';
		}
		$sql='select * from '.$this->table_co.' where pass=1 '.$sq.' order by px desc,id desc';
		$arr=$this->db->getrss($sql);
		$temparr=array();
		$templist=array();
		foreach($arr as $k=>$v){
			$temparr[$v['id']]=$v;
			$templist[$v['lm']][]=$v;
		}
		$this->coarr=$temparr;
		$this->colist=$templist;
	}
	//获取资料列表数组
	public function getcoarr(){
		if ($this->coarr===NULL){
			$this->setcoarr();
		}
		return $this->coarr;
	}
	
	//以下是用于显示多图的程序=================================
	//获取多图数组
	public function getimgarr($sy_id=0,$limit=0){
		$lim='';
		if ($sy_id==0){
			$sy_id=$this->sy_id;
		}
		if ($limit>0){
			$lim.=' limit '.$limit;
		}
		$sql='select * from `'.$this->pre.'sy_img` where `pl_id`='.$this->id.' and `sy_id`='.$sy_id.' order by px asc,id asc'.$lim;
		return $this->db->getrss($sql);
	}
	//获取多图数组(带分页)
	public function getimgpagearr($sy_id,$psize=12){
		$sql='select * from `'.$this->pre.'sy_img` where `pl_id`='.$this->id.' and `sy_id`='.$sy_id.' order by px asc,id asc';
		//实例化分页对象
		$this->page=new page(array('pagesize'=>$psize));
		//获取记录集				
		return $this->page->getrss($this->db,$sql);
	}
	
	
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
	
	//获取面包屑
	public function showdao($pname,$tag=' &gt; '){
		$dao='';
		if ($this->ty==1){
			$dao=$tag.'<a href="'.zurl($pname,array('id'=>$this->id),$this->getapname_xx($this->id)).'">'.$this->gettitle_xx().'</a>';
		}elseif ($this->ty==2){
			$dao=$tag.'<a href="'.zurl($pname,array(),$this->getapname_lm($this->lm)).'">'.$this->gettitle_lm($this->lm).'</a>'.$tag.'<a href="'.zurl($pname,array('id'=>$this->id),$this->getapname_xx($this->id)).'">'.$this->gettitle_xx().'</a>';
		}elseif ($this->ty==3){
			if ($this->fid==0){
				$dao=$tag.'<a href="'.zurl($pname,array(),$this->getapname_lm($this->lm)).'">'.$this->gettitle_lm($this->lm).'</a>'.$tag.'<a href="'.zurl($pname,array('id'=>$this->id),$this->getapname_xx($this->id)).'">'.$this->gettitle_xx().'</a>';
			}else{
				$dao=$tag.'<a href="'.zurl($pname,array(),$this->getapname_lm($this->fid)).'">'.$this->gettitle_lm($this->fid).'</a>'.$tag.'<a href="'.zurl($pname,array(),$this->getapname_lm($this->lm)).'">'.$this->gettitle_lm($this->lm).'</a>'.$tag.'<a href="'.zurl($pname,array('id'=>$this->id),$this->getapname_xx($this->id)).'">'.$this->gettitle_xx().'</a>';
			}
		}elseif ($this->ty==4){
			if (isset($this->colist[$this->lm])){
				$count=count($this->colist[$this->lm]);
				$topid=$this->colist[$this->lm][0]['id'];
			}else{
				$count=0;
				$topid=0;
			}
			if ($this->fid==0){
				$dao=$tag.'<a href="'.(($topid==0)?'javascript:;':zurl($pname,array('id'=>$topid),$this->getapname_xx($topid))).'">'.$this->gettitle_lm($this->lm).'</a>'.$tag.'<a href="'.zurl($pname,array('id'=>$this->id),$this->getapname_xx($this->id)).'">'.$this->gettitle_xx().'</a>';
			}else{
				$dao=$tag.'<a href="'.zurl($pname,array(),'').'">'.$this->gettitle_lm($this->fid).'</a>'.$tag.'<a href="'.(($topid==0)?'javascript:;':zurl($pname,array('id'=>$topid),$this->getapname_xx($topid))).'">'.$this->gettitle_lm($this->lm).'</a>'.$tag.'<a href="'.zurl($pname,array('id'=>$this->id),$this->getapname_xx($this->id)).'">'.$this->gettitle_xx().'</a>';
			}
		}
		echo $dao;
	}
	
	//以下是显示分类字段的程序===========================================
	public function showlm_zd($field,$lm=0){
		$lm=($lm==0)?$this->lm:$lm;
		$arr=$this->getlm($lm);
		if (isset($arr[$field])){
			echo $arr[$field];	
		}
	}
	
	//左侧资料列表、左侧带一级分类的资料列表(分类无连接)
	public function showlm($pname,$sub=0){
		$arr=$this->getcoarr();
		$show_html = '';
		if($this->ty==1||$this->ty==2){
			foreach($arr as $k=>$v){
				//检查是否选中
				$tcur=($v['id']==$this->id)!==false?'class="cur"':''; 
				//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接  
				$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:''));
				//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
				$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title = ($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
				$show_html .= '<li><a href="'.$turl.'" '.$targ.' '.$tcur.'>'.$title.'</a></li>'."\n";
			}
		}elseif($this->ty==3){
			//获取分类列表
			$ar=$this->getlmarr();
			$fid=($this->fid=='')?0:$this->fid;
			foreach($ar[1][$fid] as $k=>$v){
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title_lm = ($sub>0)?getstr($v['title_lm'.$this->lang],$sub):$v['title_lm'.$this->lang];
				$show_html .= '<li>'.$title_lm.'';
				$show_html .= '<ul>'."\n";
				foreach($arr as $ek=>$ev){
					if ($ev['lm']==$v['id_lm']){
						//检查是否选中
						$tcur=($ev['id']==$this->id)!==false?'class="cur"':''; 
						//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接  
						$turl=(isset($ev['link_url'])&&$ev['link_url']!='')?$ev['link_url']:zurl($pname,array('id'=>$ev['id']),(isset($ev['apname'])?$ev['apname']:''));
						//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
						$targ=(isset($ev['link_url'])&&$ev['link_url']!=''&&strpos($ev['link_url'],'http://')!==false)?'target="_blank"':'';
						//判断标题是否要截取，一个字母算1位，一个汉字算2位
						$title = ($sub>0)?getstr($ev['title'.$this->lang],$sub):$ev['title'.$this->lang];
						$show_html .= '<li '.$tcur.'><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
					}
				}
				$show_html .= '</ul>'."\n";
				$show_html .= '</li>'."\n";
			}
		}elseif($this->ty==4){
			//获取分类列表
			$ar=$this->getlmarr();
			$fid=($this->fid=='')?0:$this->fid;
			foreach($ar[1][$fid] as $k=>$v){
				if (isset($this->colist[$v['id_lm']])){
					$count=count($this->colist[$v['id_lm']]);
					$topid=$this->colist[$v['id_lm']][0]['id'];
				}else{
					$count=0;
					$topid=0;
				}
				//检查是否选中
				$tcur=($topid==$this->id)?'class="cur"':'';
				//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接  
				$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:(($topid==0)?'javascript:;':(zurl($pname,array('id'=>$topid),(isset($v['apname_lm'])?$v['apname_lm']:''))));
				//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
				$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title_lm = ($sub>0)?getstr($v['title_lm'.$this->lang],$sub):$v['title_lm'.$this->lang];
				$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a>';
				if ($count>1){
					$show_html .= '<ul>'."\n";
					foreach($arr as $ek=>$ev){
						if ($ev['lm']==$v['id_lm']){
							//检查是否选中
							$tcur=($ev['id']==$this->id)!==false?'class="cur"':''; 
							//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接  
							$turl=(isset($ev['link_url'])&&$ev['link_url']!='')?$ev['link_url']:zurl($pname,array('id'=>$ev['id']),(isset($ev['apname'])?$ev['apname']:''));
							//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
							$targ=(isset($ev['link_url'])&&$ev['link_url']!=''&&strpos($ev['link_url'],'http://')!==false)?'target="_blank"':'';
							//判断标题是否要截取，一个字母算1位，一个汉字算2位
							$title = ($sub>0)?getstr($ev['title'.$this->lang],$sub):$ev['title'.$this->lang];
							$show_html .= '<li '.$tcur.'><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
						}
					}
					$show_html .= '</ul>'."\n";
				}
				$show_html .= '</li>'."\n";
			}
		}
		echo $show_html;
	}
	
	//以下是显示信息字段的程序===========================================
	public function showxx_zd($field){
		$arr=$this->getxx();
		if (isset($arr[$field])){
			echo $arr[$field];	
		}
	}
	
	//显示详细信息
	public function showxx(){
		$show_html='';
		$rs=$this->getxx();
		if ($rs){
			$show_html .= $rs['z_body'.$this->lang]."\n";
		}
		echo $show_html;
	}
	
   /**
   	* 显示资料信息里的图片列表(不分页)
	*
	* @parame  $sy_id  默认不用填写，这是系统区分id，因为整站的多图、相关信息、相关文件、相关视频都是只保存在4个表中,用sy_id来区分不同的系统
	* @parame  $psize  每页记录数
	* @parame  $sub    截取标题字数
	* @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
	*/
	public function showimg_1($sy_id=0,$psize=12,$sub=0,$last=0){
		if ($sy_id==0){
			$sy_id=$this->sy_id;
		}
		//获取信息列表
		$arr = $this->getimgarr($sy_id,$psize);
		if ($arr){
			$show_html = '';
			$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.js')."\n";
			$show_html .= loadcss($GLOBALS['path'].'template/fancybox/jquery.fancybox.css')."\n";
			$show_html .= loadjs($GLOBALS['path'].'template/fancybox/jquery.fancybox.js')."\n";
			foreach($arr as $k=>$v){
				//每行最后一条信息加上last样式名
				$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
				$show_html .= '<li '.$tlast.'>';
				$show_html .= '<div class="li_img"><a rel="example_group" href="'.$GLOBALS['path'].getimgj($v['img_sl'],'d').'"><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
				$show_html .= '<span>'.$title.'</span>';
				$show_html .= '</li>'."\n";
			}
			$show_html .= '
			<script type="text/javascript">
				$("a[rel=example_group]").fancybox({
					"transitionIn": "elastic", //设置打开弹出来效果. 可以设置为 "elastic", "fade" 或 "none"
					"transitionOut": "elastic", //设置关闭收回去效果. 可以设置为 "elastic", "fade" 或 "none"
				});
			</script>'."\n";
			echo $show_html;
		}
	}
	
   /**
   	* 显示资料信息里的图片列表(带分页)
	*
	* @parame  $sy_id  默认不用填写，这是系统区分id，因为整站的多图、相关信息、相关文件、相关视频都是只保存在4个表中,用sy_id来区分不同的系统
	* @parame  $psize  每页记录数
	* @parame  $sub    截取标题字数
	* @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
	*/
	public function showimg_2($sy_id=0,$psize=12,$sub=0,$last=0){
		if ($sy_id==0){
			$sy_id=$this->sy_id;
		}
		//获取信息列表
		$arr = $this->getimgpagearr($sy_id,$psize);
		if ($arr){
			$show_html = '';
			$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.js')."\n";
			$show_html .= loadcss($GLOBALS['path'].'template/fancybox/jquery.fancybox.css')."\n";
			$show_html .= loadjs($GLOBALS['path'].'template/fancybox/jquery.fancybox.js')."\n";
			foreach($arr as $k=>$v){
				//每行最后一条信息加上last样式名
				$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
				$show_html .= '<li '.$tlast.'>';
				$show_html .= '<div class="li_img"><a rel="example_group" href="'.$GLOBALS['path'].getimgj($v['img_sl'],'d').'"><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
				$show_html .= '<span>'.$title.'</span>';
				$show_html .= '</li>'."\n";
			}
			$show_html .= '
			<script type="text/javascript">
				$("a[rel=example_group]").fancybox({
					"transitionIn": "elastic", //设置打开弹出来效果. 可以设置为 "elastic", "fade" 或 "none"
					"transitionOut": "elastic", //设置关闭收回去效果. 可以设置为 "elastic", "fade" 或 "none"
				});
			</script>'."\n";
			echo $show_html;
		}
	}
}
?>