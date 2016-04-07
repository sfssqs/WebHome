<?php
/**
 * 公共函数库(获取数据数组)
 * ============================================================================
 *
 */
 
if(!defined('IN_MO')){
	exit('Access Denied');
}


/**
 * 获取分类数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $table     表名
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getlmrs($table,$id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($table,$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].$table.' where pass=1 and id_lm='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($table,$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取分类数据的数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $lm        父类id
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getlmrss($table,$lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and fid='.$lm.'':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id_lm,title_lm'.$GLOBALS['lang'].',apname_lm,url_lm,f_body_lm'.$GLOBALS['lang'].',img_sl_lm,wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where pass=1 '.$sq.' '.$where.' order by px desc,id_lm desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取信息数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $table     表名
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getcors($table,$id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($table,$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].$table.' where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($table,$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取信息数据的数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getcorss($table,$lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取全局的seo表gl_setup记录数组
 *
 * @parame  $lm        lm的值
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getglrs($lm,$field=''){
	$arr=array();
	if ($lm>0){
		$arr=getarr($GLOBALS['tablepre'].'gl_setup',$lm);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'gl_setup where lm='.$lm.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'gl_setup',$lm,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取各系统的seo表sy_setup记录数组
 *
 * @parame  $lm        sy_id的值，用来区分每个系统
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getsyrs($lm,$field=''){
	$arr=array();
	if ($lm>0){
		$arr=getarr($GLOBALS['tablepre'].'sy_setup',$lm);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'sy_setup where sy_id='.$lm.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'sy_setup',$lm,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取Banner数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getbanrs($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'ban_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'ban_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'ban_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取Banner数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getbanrss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl'.$field.' from '.$GLOBALS['tablepre'].'ban_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}

/**
 * 获取资料数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function gettolrs($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'tol_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'tol_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'tol_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取资料数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function gettolrss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].'tol_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取新闻数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getnewsrs($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'news_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'news_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'news_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取新闻数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getnewsrss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl,pic_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].'news_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取案例数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getcasesrs($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'cases_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'cases_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'cases_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取案例数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getcasesrss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl,pic_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].'cases_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取下载数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getdownrs($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'down_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'down_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'down_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取下载数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getdownrss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl,fil_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].'down_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取视频数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getvideors($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'video_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'video_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'video_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取视频数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getvideorss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl,vid_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].'video_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取信息数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getinfors($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'info_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'info_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'info_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取信息数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getinforss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl,pic_sl,fil_sl,vid_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].'info_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取产品数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getprors($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'pro_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'pro_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'pro_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取产品数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getprorss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,pro_can1,f_body'.$GLOBALS['lang'].',img_sl,pic_sl,fil_sl,vid_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].'pro_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取链接数据的数组(一条记录或一个字段的数据)
 *
 * @parame  $id        记录的id
 * @parame  $field     字段名，字段名为空时就是获取整条记录的数组，不为空时就是获取单个字段名的值
 */
function getlinkrs($id,$field=''){
	$arr=array();
	if ($id>0){
		$arr=getarr($GLOBALS['tablepre'].'ban_co',$id);
		if (!$arr){
			$sql='select * from '.$GLOBALS['tablepre'].'link_co where pass=1 and id='.$id.'';
			$arr=$GLOBALS['db']->getrs($sql);
			setarr($GLOBALS['tablepre'].'link_co',$id,$arr);
		}
	}
	if ($arr&&$field){
		return $arr[$field];
	}else{
		return $arr;	
	}
}

/**
 * 获取链接数据的数组(多条记录)
 *
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getlinkrss($lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and locate(",'.$lm.',",list_lm)>0':'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,f_body'.$GLOBALS['lang'].',img_sl'.$field.' from '.$GLOBALS['tablepre'].'link_co where pass=1 '.$sq.' '.$where.' order by ding desc,px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


/**
 * 获取报名表数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getbaomingrss($table,$lm=0,$limit=0,$field='',$where=''){
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title,`rename`,phone,compname,wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where 1=1 '.$where.' order by id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}

/**
 * 获取留言表数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getbookrss($table,$lm=0,$limit=0,$field='',$where=''){
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title,`rename`,phone,compname,wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where pass=1 '.$where.' order by id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}

/**
 * 获取招聘表数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getjobrss($table,$lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and lm='.$lm:'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',num,address'.$GLOBALS['lang'].',wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where pass=1 '.$sq.' '.$where.' order by id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}

/**
 * 获取客服表数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getkfrss($table,$lm=0,$limit=0,$field='',$where=''){
	$sq=($lm>0)?' and lm='.$lm:'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select a.id,a.lx,a.title,a.`rename`'.$GLOBALS['lang'].',b.f_body_lm'.$field.' from '.$GLOBALS['tablepre'].$table.' a left join '.$GLOBALS['tablepre'].'kf_lx b on a.lx=b.id_lm where a.pass=1 '.$sq.' '.$where.' order by a.ding desc,a.px desc,a.id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}

/**
 * 获取相关信息表数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $sy_id     系统id,用来区分每个系统的记录
 * @parame  $pl_id     信息id，这些相关信息隶属那条记录的
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getsyinforss($table,$sy_id=0,$pl_id=0,$limit=0,$field='',$where=''){
	$sq=($sy_id>0)?' and sy_id='.$sy_id:'';
	$sq.=($pl_id>0)?' and pl_id='.$pl_id:'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,img_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where 1=1 '.$sq.' '.$where.' order by px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}

/**
 * 获取相关文件表数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $sy_id     系统id,用来区分每个系统的记录
 * @parame  $pl_id     信息id，这些相关信息隶属那条记录的
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getsyfilerss($table,$sy_id=0,$pl_id=0,$limit=0,$field='',$where=''){
	$sq=($sy_id>0)?' and sy_id='.$sy_id:'';
	$sq.=($pl_id>0)?' and pl_id='.$pl_id:'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,img_sl,fil_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where 1=1 '.$sq.' '.$where.' order by px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}

/**
 * 获取相关图片表数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $sy_id     系统id,用来区分每个系统的记录
 * @parame  $pl_id     信息id，这些相关信息隶属那条记录的
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getsyimgrss($table,$sy_id=0,$pl_id=0,$limit=0,$field='',$where=''){
	$sq=($sy_id>0)?' and sy_id='.$sy_id:'';
	$sq.=($pl_id>0)?' and pl_id='.$pl_id:'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,img_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where 1=1 '.$sq.' '.$where.' order by px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}

/**
 * 获取相关文件表数组(多条记录)
 *
 * @parame  $table     表名
 * @parame  $sy_id     系统id,用来区分每个系统的记录
 * @parame  $pl_id     信息id，这些相关信息隶属那条记录的
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 */
function getsyvideorss($table,$sy_id=0,$pl_id=0,$limit=0,$field='',$where=''){
	$sq=($sy_id>0)?' and sy_id='.$sy_id:'';
	$sq.=($pl_id>0)?' and pl_id='.$pl_id:'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select id,title'.$GLOBALS['lang'].',apname,link_url,img_sl,vid_sl,wtime'.$field.' from '.$GLOBALS['tablepre'].$table.' where 1=1 '.$sq.' '.$where.' order by px desc,id desc'.$limit;
	return $GLOBALS['db']->getrss($sql);
}


//以下是用来保存查询过的单条记录，避免单条数据多次调用多次查询======================
/**
 * 设置公共数组函数(用来保存查询过的单条记录)
 *
 * @parame  $table     表名
 * @parame  $id        记录的id
 * @parame  $arr       已经查询过的单条记录数组
 */
function setarr($table,$id,$arr){
	$GLOBALS[$table][$id]=$arr;
}

//获取公共数组函数(判断公共数组是否有记录，有的话就返回，没有的返回空数组)
function getarr($table,$id){
	if (isset($GLOBALS[$table][$id])){
		return $GLOBALS[$table][$id];
	}else{
		return array();
	}
}


//以下是未完善的程序
/**
 * 获取多个分类的信息记录数组
 *
 * @parame  $table     表名
 * @parame  $lm        分类id，为0时获取整个表
 * @parame  $limit     获取多少条记录，为0时获取所有记录
 * @parame  $field     附件字段，除了默认字段外的需要加入哪些字段
 * @parame  $where     查询条件
 
function getdlrss($table_lm,$table_co,$fid=0,$limit=0,$field='',$where=''){
	$sq=($fid>0)?' and b.fid='.$fid:'';
	$limit=($limit>0)?' limit '.$limit:'';
	$sql='select a.id,a.title,a.apname,a.link_url,a.img_sl,a.wtime'.$field.',b.id_lm,b.title_lm from '.$GLOBALS['tablepre'].$table_co.' a left join '.$GLOBALS['tablepre'].$table_lm.' b on a.lm=b.id_lm where a.pass=1 '.$sq.' '.$where.' order by b.px desc,b.id_lm desc,a.ding desc,a.px desc,a.id desc'.$limit;
	$arr=$GLOBALS['db']->getrss($sql);
	$temparr=array();
	$fieldarr=($field!='')?split(',',$field):array();
	foreach ($arr as $k=>$v){
		$temparr[$v['id_lm']]['id_lm']=$v['id_lm'];
		$temparr[$v['id_lm']]['title_lm']=$v['title_lm'];
		$temparr[$v['id_lm']]['info'][$k]['id']=$v['id'];
		$temparr[$v['id_lm']]['info'][$k]['title']=$v['title'];
		$temparr[$v['id_lm']]['info'][$k]['apname']=$v['apname'];
		$temparr[$v['id_lm']]['info'][$k]['link_url']=$v['link_url'];
		$temparr[$v['id_lm']]['info'][$k]['img_sl']=$v['img_sl'];
		$temparr[$v['id_lm']]['info'][$k]['wtime']=$v['wtime'];
		foreach($fieldarr as $fk=>$fv){
			$temparr[$v['id_lm']]['info'][$k][$fv]=$v[$fv];
		}
	}
	return $temparr;
}
*/
?>