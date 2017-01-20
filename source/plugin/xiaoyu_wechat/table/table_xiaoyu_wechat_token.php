<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_xiaoyu_wechat_token extends discuz_table
{
	public function __construct() {

		$this->_table = 'xiaoyu_wechat_token';
		$this->_pk    = 'type';

		parent::__construct();
	}

	

	
}

?>