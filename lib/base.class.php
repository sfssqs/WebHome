<?php
if(!defined('IN_MO')){
	exit('Access Denied');
}
class base{
	
	protected $db;                  //数据库连接对象
	protected $pre;                 //表前缀
	protected $lang;                //语言版本表字段标识
	protected $path;                //语言版本路径
	
	protected $gl_id;               //语言版本的seo信息记录id
	protected $gl=array();          //保存全局seo信息的数组
	protected $sy=array();          //保存每个系统seo信息的数组
	static $jsarr=array();          //保存整个页面的js的数组，重复的js不再加载
	static $cssarr=array();         //保存整个页面的css的数组，重复的css不再加载
	
	function __construct(){
		$this->setdb();
		$this->setpre();
		$this->setlang();
		$this->setpath();
		$this->setgl_id();
	}
	
	//把外部的数据库对象引入进来
	protected function setdb(){
		global $db;
		$this->db=$db;
	}
	//把外部的表前缀变量引入进来
	protected function setpre(){
		global $tablepre;
		$this->pre=$tablepre;
	}
	//把外部的语言版本标识变量引入进来
	protected function setlang(){
		global $lang;
		$this->lang=$lang;
	}
	//把外部的语言版本路径变量引入进来
	protected function setpath(){
		global $path;
		$this->path=$path;
	}
	//把外部的语言版本的seo信息的记录id引入进来
	protected function setgl_id(){
		global $gl_id;
		$this->gl_id=$gl_id;
	}
	
	//以下是获取全局的seo信息=============================
	//设置全局的seo记录
	public function setgl($lm){
		$rs=array();
		if ($lm!=''){
			$rs=$this->db->getrs('select * from `'.$this->pre.'gl_setup` where `lm`='.$lm.'');
		}
		$this->gl[$lm]=$rs;
	}
	//获取全局的seo记录
	public function getgl($lm=0){
		$lm=($lm==0)?$this->gl_id:$lm;
		if(!isset($this->gl[$lm])){
			$this->setgl($lm);
		}
		return $this->gl[$lm];
	}

	
	//以下是获取每个系统的seo信息=============================
	//设置每个系统的seo记录
	public function setsy($lm){
		$rs=array();
		if ($lm!=''){
			$rs=$this->db->getrs('select * from `'.$this->pre.'sy_setup` where `sy_id`='.$lm.'');
		}
		$this->sy[$lm]=$rs;
	}
	//获取每个系统的seo记录
	public function getsy($lm){
		if(!isset($this->sy[$lm])){
			$this->setsy($lm);
		}
		return $this->sy[$lm];
	}

	
	//以下是全局方法========================================
	//加载css文件
	public function loadcss($filename){
		if(file_exists($filename)){
			if(!isset(self::$cssarr[$filename])){
				self::$cssarr[$filename]=$filename;
				return '<link href="'.$filename.'" rel="stylesheet" type="text/css" />';
			}
		}else{
			exit($filename.' 文件不存在');
		}
	}
	//加载js文件
	public function loadjs($filename){
		if(file_exists($filename)){
			if(!isset(self::$jsarr[$filename])){
				self::$jsarr[$filename]=$filename;
				return '<script src="'.$filename.'" rel="stylesheet" type="text/javascript" ></script>';
			}
		}else{
			exit($filename.' 文件不存在');
		}
	}	
}
?>