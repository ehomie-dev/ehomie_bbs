<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_xiaoyu_wechat_scan extends discuz_table
{
	public function __construct() {

		$this->_table = 'xiaoyu_wechat_scan';
		$this->_pk    = 'scene_id';

		parent::__construct();
	}

	public function fetch_by_random($random){
		return DB::fetch_first("SELECT * FROM %t WHERE random=%s",array($this->_table,$random));
	}

	
}

?>