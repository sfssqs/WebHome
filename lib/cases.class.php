<?php
if(!defined('IN_MO')){
	exit('Access Denied');
}
/*
词语说明
导航栏目：指的是前台页面导航上的一个栏目
本系统：指的是后台的对应的系统

函数的命名方式
以set开头设置数据
以get开头获取数据
以show开头显示数据
*/
class cases extends base{

	public $table_co='cases_co';		        //本系统的内容表
	public $table_lm='cases_lm';		        //本系统的分类表
	public $sy_id=3;                            //本系统的seo信息的记录id(同时也是多图、相关信息、相关文件、相关视频的系统区分id，因为整站的多图、相关信息、相关文件、相关视频都是只保存在4个表中)
	
	public $ty;                                 //$ty=1为没有分类，$ty=2只有1个固定分类，ty=3有多个分类(整个系统只用在一个导航栏目或整个系统用在多个导航栏目)
	public $fid='';                             //只有$ty=3时,$fid代表是多个分类的父id
	public $lm='';					            //当前分类
	
	public $keyword='';                         //关键字
	public $flmstr='';                          //保存 以,隔开的第1个分类下面的每级分类的第1个分类	
	public $list_lm;			                //保存当前分类的所有父级和当前分类
	public $lmrow;		                        //保存分类的数组(按分类id保存)
	public $lmarr;              	            //保存分类的数组(按分类级别保存)
	public $page;						        //保存的是分页对象

	
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
		unset($this->lmrow);
		unset($this->lmarr);
	}
	
	
	//以下是初始化程序======================================================
	//实例化时自动执行检查参数是否正确的方法
	protected function check($ty,$id=''){
		if ($ty==1){
			if ($id!=''){
				exit('设置了$ty=1，代表的是无分类，$id是不需要赋值的');
			}
			$this->fid='';
			$this->lm='';
		}elseif($ty==2){
			if ($id==''||!checknum($id)){
				exit('设置了$ty=2，代表的是只有一个固定分类，$id就是那个固定分类的id_lm');
			}
			$this->fid='';
			$this->lm=$id;
		}elseif($ty==3){
			if($id===''||!checknum($id)){
				exit('设置了$ty=3，代表的是有多个分类，$id就是多个分类的fid');
			}
			$this->fid=$id;
			$this->lm='';
		}
		$this->ty=$ty;
	}
	//实例化后手动执行方法
	public function init(){
		$this->getpar();
		//有多个分类，如果默认显示左侧第1个分类信息，就要执行setflm()方法，如果默认显示所有信息就不需执行setflm()
		if($this->ty==3){
			if ($this->lm==''&&$this->keyword==''){
				$this->setflm();
			}
		}
	}
	
	
	//以下是供实例化后手动执行的方法==========================================
	//获取地址栏传递过来的参数
	public function getpar(){
		//获取参数
		$lm=isset($_GET['lm'])?$_GET['lm']:'';
		$keyword=isset($_GET['keyword'])?html($_GET['keyword']):'';
		//分类id
		if($lm!=''){
			if (!checknum($lm)){
				msg('参数错误');
			}else{
				$this->lm=$lm;
			}
		}
		//关键字
		if($keyword!=''){
			$this->keyword = $keyword;
		}
		//如果有其他参数，可在这里添加，同时在setcoarr方法里添加sql搜索
		
	}
	//设置一点击导航栏目显示左侧第1个分类的信息(默认是显示所有的信息),只有是新闻同时$ty=3时才需要执行此函数
	public function setflm(){
		if ($this->ty==3){
			if ($this->lm==''){
				$arr=$this->getlmarr();
				$this->setflmstr($arr,0,$this->fid);
				if ($this->flmstr!=''){
					$this->lm=substr(strrchr($this->flmstr,','),1);
				}
			}
		}
	}
	//递归循环得到 用$st保存 以,隔开的第1个分类下面的每级分类的第1个分类
	public function setflmstr($arr,$i,$id_lm){
		$i=$i+1;
		if (isset($arr[$i][$id_lm])){
			foreach($arr[$i][$id_lm] as $v){
				$this->flmstr.=','.$v['id_lm'];
				$this->setflmstr($arr,$i,$v['id_lm']);
				break;
			}
		}
	} 
	
	
	//以下是用于获取单个分类信息的程序========================================
	//获取单个分类信息
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
	//获取当前分类的父级列表和当前分类
	public function getlist_lm($lm=0){
		$list_lm='';
		$lm=($lm==0)?$this->lm:$lm;
		if($rs=$this->getlm($this->lm)){
			$this->list_lm=$rs['list_lm'];
		}
		return $this->list_lm;
	}


	//以下是用于显示左侧分类的程序(分类id为键值)===============================
	//设置分类列表数组(分类id为键值)
	public function setlmrow(){
		if ($this->ty==2||$this->ty==3){
			$sq='';
			//只有1个固定分类
			if($this->ty==2){
				$sq=' and id_lm='.$this->lm.'';
			//有分类列表
			}elseif($this->ty==3){
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
	
	
	//以下时用于显示左侧分类的程序(分类级别为键值)=============================
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
		$this->lmarr=$temparr;
	}
	//获取分类列表数组(分类级别为键值)
	public function getlmarr(){
		if ($this->lmarr===NULL){
			$this->setlmarr();
		}
		return $this->lmarr;
	}
	
	
	//以下用于显示信息列表的程序==============================================
	//获取信息列表数组
	public function getcoarr($psize){
		$sq='';
		//如果有分类
		if($this->lm!=''){
			$sq.=' and locate(",'.$this->lm.',",list_lm)>0';
		}
		//如果有关键字
		if($this->keyword!=''){
			$sq.=' and title'.$this->lang.' like "%'.$this->keyword.'%"';
		}
		//如果有其他参数可在这里增加
	
		//如果本系统用在多个导航栏目，信息列表获取属于fid的数据
		if ($this->fid>0){
			$sq.=' and locate(",'.$this->fid.',",list_lm)>0';
		}
		//信息列表的sql语句
		$sql='select `id`,`lm`,`title'.$this->lang.'`,`link_url`,`apname`,`wtime`,`img_sl`,`f_body'.$this->lang.'` from '.$this->table_co .' where pass=1 '.$sq.' order by ding desc,px desc,id desc';		
		//实例化分页对象
		$this->page=new page(array('pagesize'=>$psize));
		//获取记录集				
		return $this->page->getrss($this->db,$sql);
	}

	
	
	//以下是显示页面seo信息的程序============================================
	public function showseo(){
		global $sy_seo;
		$rs=array();
		$seo_html='';
		//如果没有启用系统seo，就调用全局的seo信息
		if ($sy_seo==false){
			$rs=$this->getgl($this->gl_id);
		}else{
			//没有分类
			if ($this->ty==1){
				$rs=$this->getsy($this->sy_id);
			//只有1个固定分类
			}elseif($this->ty==2){
				$rs=$this->getlm($this->lm);
			//有分类列表
			}elseif($this->ty==3){
				//本系统只用在一个导航栏目
				if ($this->fid==0){
					//如果没有传分类id,那就调用本系统设置的seo信息
					if ($this->lm==''){
						$rs=$this->getsy($this->sy_id);
					//如果有传分类id，那就调用分类设置的seo信息
					}else{
						$rs=$this->getlm($this->lm);
					}
				//本系统用在多个导航栏目
				}else{
					//如果没有传分类id,那就调用父级设置的seo信息
					if ($this->lm==''){
						$rs=$this->getlm($this->fid);
					//如果有传分类id，那就调用分类设置的seo信息
					}else{
						$rs=$this->getlm($this->lm);
					}
				}
			}
			//如果上面没有获取到seo信息,就调用全局的seo信息
			if (!$rs||($rs&&$rs['ym_tit'.$this->lang]=='')){
				$rs=$this->getgl($this->gl_id);
			}
		}
		if ($rs){
			$seo_html .= '<title>'.$rs['ym_tit'.$this->lang].'</title>'."\n";
			$seo_html .= '<meta name="keywords" content="'.$rs['ym_key'.$this->lang].'"/>'."\n";
			$seo_html .= '<meta name="description" content="'.$rs['ym_des'.$this->lang].'"/>'."\n";
		}
		echo $seo_html;
	}
	
	
	//以下是显示面包屑的程序=================================================
   /**
    * 显示面包屑的程序
	*
	* @parame  $pname    要链接的页面名称
	* @parame  $tag      面包屑符号
	*/
	public function showdao($pname,$tag=' &gt; '){
		$dao='';
		if($this->ty==1){
			$dao='';
		}elseif($this->ty==2){
			$dao=$tag.'<a href="'.zurl($pname,array('lm'=>$this->lm),$this->getapname_lm($this->lm)).'">'.$this->gettitle_lm($this->lm).'</a>';
		}elseif($this->ty==3){
			$list_lm=$this->getlist_lm();
			$a=1;
			if ($this->lm!=''){
				$list_lm=substr($list_lm,1,(strlen($list_lm)-2));
				$arr=explode(',',$list_lm);
				$start=1;
				foreach($arr as $v){
					if ($this->fid>0){
						if ($this->fid==$v){
							$start=2;
						}	
						if($start>1){
							if ($a==1){
								$dao.=$tag.'<a href="'.zurl($pname,array(),$this->getapname_lm($v)).'">'.$this->gettitle_lm($v).'</a>';
							}else{
								$dao.=$tag.'<a href="'.zurl($pname,array('lm'=>$v),$this->getapname_lm($v)).'">'.$this->gettitle_lm($v).'</a>';
							}
							$a++;
						}
					}else{
						if ($a==1){
							$dao.=$tag.'<a href="'.zurl($pname,array(),$this->getapname_lm($v)).'">'.$this->gettitle_lm($v).'</a>';
						}else{
							$dao.=$tag.'<a href="'.zurl($pname,array('lm'=>$v),$this->getapname_lm($v)).'">'.$this->gettitle_lm($v).'</a>';
						}
						$a++;
					}
				}
			}else{
				if ($this->fid>0){
					if ($a==1){
						$dao.=$tag.'<a href="'.zurl($pname,array(),$this->getapname_lm($this->fid)).'">'.$this->gettitle_lm($this->fid).'</a>';
					}else{
						$dao.=$tag.'<a href="'.zurl($pname,array('lm'=>$this->fid),$this->getapname_lm($this->fid)).'">'.$this->gettitle_lm($this->fid).'</a>';
					}
					$a++;
				}
			}
		}
		echo $dao."\n";
	}
	
	
	//以下是显示分类字段的程序===========================================
	public function showlm_zd($field,$lm=0){
		$lm=($lm==0)?$this->lm:$lm;
		$arr=$this->getlm($lm);
		if (isset($arr[$field])){
			echo $arr[$field];	
		}
	}
	
	
	//以下是显示分类列表的程序===============================================
   /**
	* 显示1级分类
	* 
	* @parame  $pname  链接地址
	* @parame  $sub    截取标题字数
	*/
	public function showlm_1_1($pname,$sub=0){
		//获取分类列表
		$arr=$this->getlmarr();
		//获取当前分类的所有父级列表和当前分类
		$list_lm = $this->getlist_lm();
		//获取上级分类id
		$fid=($this->fid=='')?0:$this->fid;
		$show_html = '';
		if(isset($arr[1][$fid])){
			foreach($arr[1][$fid] as $k=>$v){
				//检查是否选中
				$tcur=(strpos($list_lm,','.$v['id_lm'].',')!==false?'class="cur"':''); 
				//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接  
				$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:zurl($pname,array('lm'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:''));
				//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
				$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title_lm = ($sub>0)?getstr($v['title_lm'.$this->lang],$sub):$v['title_lm'.$this->lang];
				$show_html .= '<li '.$tcur.'><a href="'.$turl.'" '.$targ.'>'.$title_lm.'</a></li>'."\n";
			}
		}
		echo $show_html;
	}
	
   /**
	* 显示2级分类(1级有链接，2级有链接)
	* 
	* @parame  $pname  链接地址
	* @parame  $sub    截取标题字数
	*/
	public function showlm_2_1($pname,$sub=0){
		//获取分类列表
		$arr=$this->getlmarr();
		//获取当前分类的所有父级列表和当前分类
		$list_lm = $this->getlist_lm();
		//获取上级分类id
		$fid=($this->fid=='')?0:$this->fid;
		$show_html = '';
		//一级分类
		if(isset($arr[1][$fid])){
			foreach($arr[1][$fid] as $k=>$v){
				//检查是否选中
				$tcur=(strpos($list_lm,','.$v['id_lm'].',')!==false?'class="cur"':''); 
				//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接   
				$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:zurl($pname,array('lm'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:''));
				//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
				$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title_lm = ($sub>0)?getstr($v['title_lm'.$this->lang],$sub):$v['title_lm'.$this->lang];
				$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a>';
				//二级分类
				if(isset($arr[2][$v['id_lm']])){
					$style = $tcur?'style="display:block;"':'style="display:none;"';
					$show_html .= '<ul '.$style.' >'."\n";
					foreach($arr[2][$v['id_lm']] as $ek=>$ev){
						//检查是否选中
						$tcur=(strpos($list_lm,','.$ev['id_lm'].',')!==false?'class="cur"':''); 
						//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接   
						$turl=(isset($ev['url_lm'])&&$ev['url_lm']!='')?$ev['url_lm']:zurl($pname,array('lm'=>$ev['id_lm']),(isset($ev['apname_lm'])?$ev['apname_lm']:''));
						//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
						$targ=(isset($ev['url_lm'])&&$ev['url_lm']!=''&&strpos($ev['url_lm'],'http://')!==false)?'target="_blank"':'';
						//判断标题是否要截取，一个字母算1位，一个汉字算2位
						$title_lm = ($sub>0)?getstr($ev['title_lm'.$this->lang],$sub):$ev['title_lm'.$this->lang];
						$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a></li>'."\n";
					}
					$show_html .= '</ul>'."\n";
				}
				//二级分类结束
				$show_html .= '</li>'."\n";
			}
		}
		//一级分类结束
		echo $show_html;
	}
	
   /**
	* 显示2级分类(1级无链接,2有链接  ,要使用此效果,外层ul 需设置ID为:id='left_nav')
	* 
	* @parame  $pname  链接地址
	* @parame  $sub    截取标题字数
	*/
	public function showlm_2_2($pname,$sub=0){
		//获取分类列表
		$arr=$this->getlmarr();
		//获取当前分类的所有父级列表和当前分类
		$list_lm = $this->getlist_lm();
		//获取上级分类id
		$fid=($this->fid=='')?0:$this->fid;
		$show_html = '';
		$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js');
		$show_html .= '
		<script>
		$(document).ready(function(){
			$("#left_nav li.cur").each(function(){
				$(this).find("ul").eq(0).css("display","block");
			});
			$("#left_nav li a").click(function(){
				$(this).parent("li").addClass("cur");
				$(this).parent("li").siblings("li").removeClass("cur");
				$(this).next("ul").eq(0).slideToggle();
				$(this).parent("li").siblings("li").find("ul").slideUp();
			});
		});
		</script>'."\n";
		
		//一级分类
		if(isset($arr[1][$fid])){
			foreach($arr[1][$fid] as $k=>$v){
				$tcur = (strpos($list_lm,','.$v['id_lm'].',')!==false?'class="cur"':'');
				//检查是否选中
				$tcur=(strpos($list_lm,','.$v['id_lm'].',')!==false?'class="cur"':''); 
				//判断如果有外部链接，就直接外链，没有的话就判断是否有二级分类，如果有二级，一级就是点击效果，如果没有二级，一级分类则按传入的页面名称做链接
				$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:(isset($arr[2][$v['id_lm']])?'javascript:;':zurl($pname,array('lm'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:'')));   
				//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
				$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title_lm = ($sub>0)?getstr($v['title_lm'.$this->lang],$sub):$v['title_lm'.$this->lang];
				$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a>';
				//二级分类
				if(isset($arr[2][$v['id_lm']])){
					$style = $tcur?'style="display:block;"':'style="display:none;"';  //如果选中，则设置 下级层为显示
					$show_html .= '<ul '.$style.' >'."\n";
					foreach($arr[2][$v['id_lm']] as $ek=>$ev){
						//检查是否选中
						$tcur=(strpos($list_lm,','.$ev['id_lm'].',')!==false?'class="cur"':''); 
						//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接   
						$turl=(isset($ev['url_lm'])&&$ev['url_lm']!='')?$ev['url_lm']:zurl($pname,array('lm'=>$ev['id_lm']),(isset($ev['apname_lm'])?$ev['apname_lm']:''));
						//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
						$targ=(isset($ev['url_lm'])&&$ev['url_lm']!=''&&strpos($ev['url_lm'],'http://')!==false)?'target="_blank"':'';
						//判断标题是否要截取，一个字母算1位，一个汉字算2位
						$title_lm = ($sub>0)?getstr($ev['title_lm'.$this->lang],$sub):$ev['title_lm'.$this->lang];
						$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a></li>'."\n";
					}
					$show_html .= '</ul>'."\n";
				}
				//二级分类结束
				$show_html .= '</li>'."\n";
			}
		}
		//一级分类结束
		echo $show_html;
	}
	
   /**
	* 显示3级分类(1级有链接，2级有链接，3级有链接)
	* 
	* @parame  $pname  链接地址
	* @parame  $sub    截取标题字数
	*/
	public function showlm_3_1($pname,$sub=0){
		//获取分类列表
		$arr=$this->getlmarr();
		//获取当前分类的所有父级列表和当前分类
		$list_lm = $this->getlist_lm();
		//获取上级分类id
		$fid=($this->fid=='')?0:$this->fid;
		$show_html = '';
		//一级分类
		if(isset($arr[1][$fid])){
			foreach($arr[1][$fid] as $k=>$v){
				//检查是否选中
				$tcur=(strpos($list_lm,','.$v['id_lm'].',')!==false?'class="cur"':''); 
				//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接   
				$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:zurl($pname,array('lm'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:''));
				//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
				$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title_lm = ($sub>0)?getstr($v['title_lm'.$this->lang],$sub):$v['title_lm'.$this->lang];
				$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a>';
				//二级分类
				if(isset($arr[2][$v['id_lm']])){
					$style = $tcur?'style="display:block;"':'style="display:none;"';   //如果选中，则设置 下级层为显示
					$show_html .= '<ul '.$style.' >';
					foreach($arr[2][$v['id_lm']] as $ek=>$ev){
						//检查是否选中
						$tcur=(strpos($list_lm,','.$ev['id_lm'].',')!==false?'class="cur"':''); 
						//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接   
						$turl=(isset($ev['url_lm'])&&$ev['url_lm']!='')?$ev['url_lm']:zurl($pname,array('lm'=>$ev['id_lm']),(isset($ev['apname_lm'])?$ev['apname_lm']:''));
						//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
						$targ=(isset($ev['url_lm'])&&$ev['url_lm']!=''&&strpos($ev['url_lm'],'http://')!==false)?'target="_blank"':'';
						//判断标题是否要截取，一个字母算1位，一个汉字算2位
						$title_lm = ($sub>0)?getstr($ev['title_lm'.$this->lang],$sub):$ev['title_lm'.$this->lang];
						$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a></li>'."\n";
						//三级分类
						if(isset($arr[3][$ev['id_lm']])){
							$style = $tcur?'style="display:block;"':'style="display:none;"';   //如果选中，则设置 下级层为显示
							$show_html .= '<ul '.$style.' >'."\n";
							foreach($arr[3][$ev['id_lm']] as $sk=>$sv){
								//检查是否选中
								$tcur=(strpos($list_lm,','.$sv['id_lm'].',')!==false?'class="cur"':''); 
								//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接   
								$turl=(isset($sv['url_lm'])&&$sv['url_lm']!='')?$sv['url_lm']:zurl($pname,array('lm'=>$sv['id_lm']),(isset($sv['apname_lm'])?$sv['apname_lm']:''));
								//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
								$targ=(isset($sv['url_lm'])&&$sv['url_lm']!=''&&strpos($sv['url_lm'],'http://')!==false)?'target="_blank"':'';
								//判断标题是否要截取，一个字母算1位，一个汉字算2位
								$title_lm = ($sub>0)?getstr($sv['title_lm'.$this->lang],$sub):$sv['title_lm'.$this->lang];
								$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a></li>'."\n";
							}
							$show_html .= '</ul>'."\n";
						}
						//三级分类结束
						$show_html .= '</li>'."\n";
					}
					$show_html .= '</ul>'."\n";
				}
				//二级分类结束
				$show_html .= '</li>'."\n";
			}
		}
		//一级分类结束
		echo $show_html;
	}
	
   /**
	* 显示3级分类(1,2级无链接,3级有链接 ,要使用此效果,外层ul 需设置ID为:id='left_nav')
	* 
	* @parame  $pname  链接地址
	* @parame  $sub    截取标题字数
	*/
	public function showlm_3_2($pname,$sub=0){
		//获取分类列表
		$arr=$this->getlmarr();
		//获取当前分类的所有父级列表和当前分类
		$list_lm = $this->getlist_lm();
		//获取上级分类id
		$fid=($this->fid=='')?0:$this->fid;
		$show_html = '';
		$show_html .= $this->loadjs($this->path.'template/public/js/jquery.js');
		$show_html .= '
		<script>
		$(document).ready(function(){
			$("#left_nav li.cur").each(function(){
				$(this).find("ul").eq(0).css("display","block");
			});
			$("#left_nav li a").click(function(){
				$(this).parent("li").toggleClass("cur");
				$(this).parent("li").siblings("li").removeClass("cur");
				$(this).next("ul").eq(0).slideToggle();
				$(this).parent("li").siblings("li").find("ul").slideUp();
			});
		});
		</script>'."\n";
		//一级分类
		if(isset($arr[1][$fid])){
			foreach($arr[1][$fid] as $k=>$v){
				$tcur = (strpos($list_lm,','.$v['id_lm'].',')!==false?'class="cur"':'');
				//检查是否选中
				$tcur=(strpos($list_lm,','.$v['id_lm'].',')!==false?'class="cur"':''); 
				//判断如果有外部链接，就直接外链，没有的话就判断是否有二级分类，如果有二级，一级就是点击效果，如果没有二级，一级分类则按传入的页面名称做链接
				$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:(isset($arr[2][$v['id_lm']])?'javascript:;':zurl($pname,array('lm'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:'')));   
				//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
				$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
				//判断标题是否要截取，一个字母算1位，一个汉字算2位
				$title_lm = ($sub>0)?getstr($v['title_lm'.$this->lang],$sub):$v['title_lm'.$this->lang];
				$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a>'."\n";
				//二级分类
				if(isset($arr[2][$v['id_lm']])){
					$style = $tcur?'style="display:block;"':'style="display:none;"';
					$show_html .= '<ul '.$style.' >'."\n";
					foreach($arr[2][$v['id_lm']] as $ek=>$ev){
						//检查是否选中
						$tcur=(strpos($list_lm,','.$ev['id_lm'].',')!==false?'class="cur"':''); 
						//判断如果有外部链接，就直接外链，没有的话就判断是否有三级分类，如果有三级，二级就是点击效果，如果没有三级，二级分类则按传入的页面名称做链接
						$turl=(isset($ev['url_lm'])&&$ev['url_lm']!='')?$ev['url_lm']:(isset($arr[3][$ev['id_lm']])?'javascript:;':zurl($pname,array('lm'=>$ev['id_lm']),(isset($ev['apname_lm'])?$v['apname_lm']:'')));   
						//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
						$targ=(isset($ev['url_lm'])&&$ev['url_lm']!=''&&strpos($ev['url_lm'],'http://')!==false)?'target="_blank"':'';
						//判断标题是否要截取，一个字母算1位，一个汉字算2位
						$title_lm = ($sub>0)?getstr($ev['title_lm'.$this->lang],$sub):$ev['title_lm'.$this->lang];
						$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a>';
						//三级分类
						if(isset($arr[3][$ev['id_lm']])){
							$style = $tcur?'style="display:block;"':'style="display:none;"';
							$show_html .= '<ul '.$style.' >'."\n";
							foreach($arr[3][$ev['id_lm']] as $sk=>$sv){
								//检查是否选中
								$tcur=(strpos($list_lm,','.$sv['id_lm'].',')!==false?'class="cur"':''); 
								//判断如果有外部链接，就直接外链，没有的话则按传入的页面名称做链接   
								$turl=(isset($sv['url_lm'])&&$sv['url_lm']!='')?$sv['url_lm']:zurl($pname,array('lm'=>$sv['id_lm']),(isset($sv['apname_lm'])?$sv['apname_lm']:''));
								//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
								$targ=(isset($sv['url_lm'])&&$sv['url_lm']!=''&&strpos($sv['url_lm'],'http://')!==false)?'target="_blank"':'';
								//判断标题是否要截取，一个字母算1位，一个汉字算2位
								$title_lm = ($sub>0)?getstr($sv['title_lm'.$this->lang],$sub):$sv['title_lm'.$this->lang];
								$show_html .= '<li '.$tcur.'><a href="'.$turl .'" '.$targ.'>'.$title_lm.'</a></li>'."\n";
							}
							$show_html .= '</ul>'."\n";
						}
						//三级分类结束
						$show_html .= '</li>'."\n";
					}
					$show_html .= '</ul>'."\n";
				}
				//二级分类结束
				$show_html .= '</li>'."\n";
			}
		}
		//一级分类结束
		echo $show_html;
	}
	
	
	//以下是显示信息列表的程序===============================================
   /**
    * 列表1(标题+时间)
	*
	* @parame  $pname  要链接的页面名称
	* @parame  $psize  每页记录数
	* @parame  $sub    截取标题字数
	* @parame  $f_sub  截取简要介绍字数
	* @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
	*/
	public function showlist_1($pname,$psize=12,$sub=0,$f_sub=0,$last=0){
		//获取信息列表
		$arr = $this->getcoarr($psize);
		$show_html = '';
		foreach($arr as $k=>$v){
			//每行最后一条信息加上last样式名
			$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			$show_html .= '<li '.$tlast.'><span class="fr">'.date('Y-m-d',$v['wtime']).'</span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
		}
		echo $show_html;
	}
	
   /**
   	*列表2(上图片+下标题)
	*
	* @parame  $pname  链接地址
	* @parame  $psize  每页记录数
	* @parame  $sub    截取标题字数
	* @parame  $f_sub  截取简要介绍字数
	* @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
	*/
	public function showlist_2($pname,$psize=12,$sub=0,$f_sub=0,$last=0){
		//获取信息列表
		$arr = $this->getcoarr($psize);
		$show_html = '';
		foreach($arr as $k=>$v){
			//每行最后一条信息加上last样式名
			$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			$show_html .= '<li '.$tlast.'>'."\n";
			$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$v['img_sl'].'" /></a></div>'."\n";
			$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
			$show_html .= '</li>'."\n";
		}
		echo $show_html;
	}
	
   /**
   	*列表3((上标题+中简要介绍)
	*
	* @parame  $pname  链接地址
	* @parame  $psize  每页记录数
	* @parame  $sub    截取标题字数
	* @parame  $f_sub  截取简要介绍字数
	* @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
	*/
	public function showlist_3($pname,$psize=12,$sub=0,$f_sub=0,$last=0){
		//获取信息列表
		$arr = $this->getcoarr($psize);
		$show_html = '';
		foreach($arr as $k=>$v){
			//每行最后一条信息加上last样式名
			$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			//简要介绍
			$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$this->lang]),$f_sub):strip_tags($v['f_body'.$this->lang]);
			$show_html .= '<li '.$tlast.'>'."\n";
			$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
			$show_html .= '<p>'.$f_body.'</p>'."\n";
			//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
			$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
			$show_html .= '</li>'."\n";
		}
		echo $show_html;
	}
	
   /**
   	*列表4(左图片+右标题+右简要介绍+右时间)
	*
	* @parame  $pname  链接地址
	* @parame  $psize  每页记录数
	* @parame  $sub    截取标题字数
	* @parame  $f_sub  截取简要介绍字数
	* @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
	*/
	public function showlist_4($pname,$psize=12,$sub=0,$f_sub=0,$last=0){
		//获取信息列表
		$arr = $this->getcoarr($psize);
		$show_html = '';
		foreach($arr as $k=>$v){
			//每行最后一条信息加上last样式名
			$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			//简要介绍
			$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$this->lang]),$f_sub):strip_tags($v['f_body'.$this->lang]);
			$show_html .= '<li '.$tlast.'>'."\n";
			$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$v['img_sl'].'" /></a></div>'."\n";
			$show_html .= '<div class="li_con">'."\n";
			$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
			$show_html .= '<p>'.$f_body.'</p>'."\n";
			//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
			$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
			$show_html .= '</div>'."\n";
			$show_html .= '</li>'."\n";
		}
		echo $show_html;
	}
	
   /**
   	*列表3(上图片+中标题+下简要介绍)
	*
	* @parame  $pname  链接地址
	* @parame  $psize  每页记录数
	* @parame  $sub    截取标题字数
	* @parame  $f_sub  截取简要介绍字数
	* @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
	*/
	public function showlist_5($pname,$psize=12,$sub=0,$f_sub=0,$last=0){
		//获取信息列表
		$arr = $this->getcoarr($psize);
		$show_html = '';
		foreach($arr as $k=>$v){
			//每行最后一条信息加上last样式名
			$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
			//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
			$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
			//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
			$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
			//判断标题是否要截取，一个字母算1位，一个汉字算2位
			$title=($sub>0)?getstr($v['title'.$this->lang],$sub):$v['title'.$this->lang];
			//简要介绍
			$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$this->lang]),$f_sub):strip_tags($v['f_body'.$this->lang]);
			$show_html .= '<li '.$tlast.'>'."\n";
			$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$v['img_sl'].'" /></a></div>'."\n";
			$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
			$show_html .= '<p>'.$f_body.'</p>'."\n";
			//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
			$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
			$show_html .= '</li>'."\n";
		}
		echo $show_html;
	}
	
}
?>