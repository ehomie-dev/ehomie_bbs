<?php

/*
 * This is not a freeware, use is subject to license terms
 * From 小鱼设计团队(www.54juju.com)
 */
 
if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$addonid = $pluginarray['plugin']['identifier'].'.plugin';
$array = cloudaddons_getmd5($addonid);
if(cloudaddons_open('&mod=app&ac=validator&ver=2&addonid='.$addonid.($array !== false ? '&rid='.$array['RevisionID'].'&sn='.$array['SN'].'&rd='.$array['RevisionDateline'] : '')) === '0') {
cpmsg('cloudaddons_genuine_message', '', 'error', array('addonid' => $addonid));
}

?>