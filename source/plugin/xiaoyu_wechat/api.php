<?php
if(!empty($_SERVER['QUERY_STRING'])) {
	$dir = '../../../';
	chdir($dir);
	define('DISABLEXSSCHECK', true);
	$_GET['id']='xiaoyu_wechat:login';
	require 'plugin.php';
	
	
}
