<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


class table_xiaoyu_wechat_user extends discuz_table
{
	public function __construct() {

		$this->_table = 'xiaoyu_wechat_user';
		$this->_pk    = 'openid';

		parent::__construct();
	}
	
	public function  delete_by_uid($uid){
		DB::query("DELETE FROM %t WHERE uid=%d",array($this->_table,$uid));
	}

	public function fetch_all_by_sql($where, $order = '', $start = 0, $limit = 0, $count = 0, $alias = '') {
		$where = $where && !is_array($where) ? " WHERE $where" : '';
		if(is_array($order)) {
			$order = '';
		}
		if($count) {
			return DB::result_first('SELECT count(*) FROM '.DB::table($this->_table).'  %i %i %i '.DB::limit($start, $limit), array($alias, $where, $order));
		}
		return DB::fetch_all('SELECT * FROM '.DB::table($this->_table).' %i %i %i '.DB::limit($start, $limit), array($alias, $where, $order));
	}

	
}


?>