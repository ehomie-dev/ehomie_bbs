<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$xiaoyuset = $_G['cache']['plugin']['xiaoyu_wechat'];

if(submitcheck('formhash',true)){

	$xiaoyu_key = $_GET['xiaoyu_key'];
	if(empty($xiaoyu_key)){
		myshowmessage(lang('plugin/xiaoyu_wechat','parameter').'1');
	}
	$randcode= authcode($xiaoyu_key,'DECODE',$xiaoyuset['Fish_key']);
	if(empty($randcode)){
		myshowmessage(lang('plugin/xiaoyu_wechat','parameter').'2');
	}

	$scaninfo = C::t('#xiaoyu_wechat#xiaoyu_wechat_scan')->fetch_by_random(daddslashes($randcode));
	
	if(empty($scaninfo)){
		myshowmessage(lang('plugin/xiaoyu_wechat','parameter').'3');
	}
	
	$secrandcode= authcode($scaninfo['xiaoyu_key'],'DECODE',$xiaoyuset['Fish_key']);
	
	if($secrandcode!=$randcode){
		myshowmessage(lang('plugin/xiaoyu_wechat','parameter').'4');
	}
	
	if(TIMESTAMP>$scaninfo['expire']){
		C::t('#xiaoyu_wechat#xiaoyu_wechat_scan')->delete($scaninfo['scene_id']);
		myshowmessage(lang('plugin/xiaoyu_wechat','xiaoyuexpire'));
		
	}
	
	if($scaninfo['status']==1 && !empty($scaninfo['uid'])){
		$uidinfo = getuserbyuid($scaninfo['uid']);
		require libfile('function/member');
		setloginstatus(array(
		'uid' => $uidinfo['uid'],
		'username' => $uidinfo['username'],
		'password' => $uidinfo['password'],
		'groupid' => $uidinfo['groupid'],
		), 0);
		
		C::t('#xiaoyu_wechat#xiaoyu_wechat_scan')->delete($scaninfo['scene_id']);
		
		myshowmessage('ok');
	}
	
	
}


myshowmessage("");
function myshowmessage($msg){
	helper_output::xml($msg);
	exit;
}

?>