<?php
if(!defined('IN_MO')){
	exit('Access Denied');
}

class Db{
	
	/**	 
	 * 数据库连接标识 
	 * @access protected 
	 * @var $link MYSQL连接标识
	 */
	public $link_id=NULL; 
	
	protected $settings = array();
	public $ti=0;
	public $ti_str='';
	/**	 
	 * MSYQL结果集
	 * @access protected
	 * @var $result MYSQL结果集
	 */
	
	public function __construct($host='',$user='',$pwd='',$database='',$charset='utf8',$pconnect=0){
		$this->settings = array('dbhost'=> $host,'dbuser'=> $user,'dbpw'=> $pwd,'dbname'=> $database,'charset'=> $charset,'pconnect' => $pconnect);
	}
	
	/** 	 
	 * 连接数据库
	 * @access public
	 * @param string - $host MYSQL主机
	 * @param string - $user MYSQL用户名
	 * @param string - $pwd  MYSQL用户密码
	 * @param string - $name MYSQL数据库名
	 * @param string - $charset 数据库使用的字符集
	 * @param boolean - $pconnect = false 是否开启之久性连接
	 * @return resource 数据库连接资源
	 */
	public function connect($host='',$user='',$pwd='',$database='',$charset='utf8',$pconnect=0){
		if(!$pconnect){
			$this->link_id = @mysql_connect($host,$user,$pwd) or $this->err();
		}else{
			$this->link_id = @mysql_pconnect($host,$user,$pwd,true) or $this->err();
		}
		$this->selectDatabase($database);
		$this->setCharset($charset);
	}

	/**
	 * 执行SQL语句返回受影响记录数
	 * @access public 
	 * @param  string - $sql SQL语句  
	 * @param  string - $act 操作类型 insert update select 
	 * @param  resource - $link 数据库连接资源
	 * @returm resource 数据库结果集
	 */
	public function query($sql){
        if ($this->link_id=== NULL)
        {
            $this->connect($this->settings['dbhost'], $this->settings['dbuser'], $this->settings['dbpw'], $this->settings['dbname'], $this->settings['charset'], $this->settings['pconnect']);
            $this->settings = array();
        }
		$result = @mysql_query($sql,$this->link_id) or $this->err($sql);
		$this->ti++;
		$this->ti_str.=$sql.'<br/>';
		return $result;
	}

	/**
	 * 执行SQL语句，不返回任何信息 如使用 INSET UPDATE 等
	 * @access public
	 * @param  string - $sql SQL语句
	 */
	public function execute($sql){
        if ($this->link_id=== NULL)
        {
            $this->connect($this->settings['dbhost'], $this->settings['dbuser'], $this->settings['dbpw'], $this->settings['dbname'], $this->settings['charset'], $this->settings['pconnect']);
            $this->settings = array();
        }
		@mysql_query($sql,$this->link_id) or $this->err($sql);
	}

	/**
	 * @access public
	 * @param resource - $result 数据库结果集
	 * @param string - $type=MYSQL_ASSOC 返回类型 MYSQL_ASSOC 等 
	 * @return array
	 */
	public function getRows($result,$type = MYSQL_ASSOC){
		$rows = array();
		while($row = $this->getRow($result,$type)){
			$rows[] = $row;
		}
		return $rows;
	}

	/**
	 * 遍历结果集到一个数组中
	 * @access public
	 * @param resource - $result 数据库结果集
	 * @param string - $type=MYSQL_ASSOC 返回类型 MYSQL_ASSOC MYSQL_NUM 等
	 * @return array
	 */
	public function getRow($result,$type = MYSQL_ASSOC){
		$row = @mysql_fetch_array($result,$type);
		return $row;
	}
	
	/**
	 * 执行sql语句得到单条记录集的数组
	 * @access public
	 * @param string - $sql SQL语句
	 * @param string - $type=MYSQL_ASSOC 返回类型 MYSQL_ASSOC MYSQL_NUM 等
	 * @return array
	 */
	public function getRs($sql,$type=MYSQL_ASSOC){
		$row = array();
		$result = $this->query($sql);
		$row = $this->getRow($result,$type);
		$this->freeResult($result);
		return $row;
	}
	
	/**
	 * 执行sql语句得到多条记录集的数组
	 * @access public
	 * @param string - $sql SQL语句
	 * @param string - $type=MYSQL_ASSOC 返回类型 MYSQL_ASSOC MYSQL_NUM 等
	 * @return array
	 */
	public function getRss($sql,$type=MYSQL_ASSOC){
		$rows = array();
		$result = $this->query($sql);
		while($row = $this->getRow($result,$type)){
			$rows[] = $row;
		}
		$this->freeResult($result);
		return $rows;
	}
	
	/*
	 * 获取指定表的总记录数
	 * @access public
	 * @param string - $table 表名
	 * @return integer
	 */
	 
	public function getQueryAllRow($sql){
		$result = $this->query($sql);
		$num= $this->getRow($result,MYSQL_NUM);
		$this->freeResult($result);
		return $num[0];
	}

	/**
	 * 释放资源
	 * @access public
	 * @param resource - $result 数据库结果集
	 */
	public function freeResult($result){
		@mysql_free_result($result);
	}

	/**
	 * 关闭数据库连接
	 * @access public
	 * @param resource - $link 数据库连接资源
	 */
	public function close(){
		@mysql_close($this->link_id);
	}

	/*
	 * 获取结果集中的行数
	 * @param resource - $result 数据库结果集
	 * @return integer
	 */
	public function getRowsNum($result){
		return @mysql_num_rows($result);
	}

	/**
	 * 返回先前操作所影响的行数
	 * @access public
	 * @return integer
	 */
	public function getAffectedRows(){
		return @mysql_affected_rows($this->link_id);
	}

    function insert_id(){
        return @mysql_insert_id($this->link_id);
    }
	/**		
	 * 设置数据库字符集
	 * @access public
	 * @param  string - $charset	数据库编码 如 utf8
	 */
	public function setCharset($charset){
		$this->execute("SET NAMES '{$charset}'");
	}
	
	/**
	 * 返回MYSQL数据库版本
	 */
	public function getVersion(){
		return mysql_get_client_info();
	}

    /**		
	 * 选择数据库
	 * @access public
	 * @param  string - $database 数据库
	 */
	public function selectDatabase($database){
		@mysql_select_db($database,$this->link_id);	
	}
	 
	/**
	 * 显示错误信息
	 * @access protected 
	 * $param  string - $sql 出错的SQL语句
	 */
	protected function err($sql = null){
		if (MY_ERROR_TIPS){
			echo '<div style="color:#ff0000;font:12px;">出错啦！';
			echo '<br>错误信息：' . $this->getError();
			echo '<br>错误编号：' . $this->getErrno();
			if($sql){
				echo '<br>SQL语句：' . $sql;
			}
			echo '<br><div><hr style="border:1px solid #f69;">';
		}else{
			echo('Mysql Error!');
		}
		exit();
	}

	/**			  
	 * 返回错误信息
	 * @access protected 
	 * @return string
	 */
	protected function getError(){
		return mysql_error();
	}

	/**			   
	 * 返回错误的编号
	 * @access protected 
	 * @return string
	 */
	protected function getErrno(){
		return mysql_errno();
	}
}
?>