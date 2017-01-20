<?php

/*
 * xiaoyu process
 * This is not a freeware, use is subject to license terms
 * From 小鱼设计团队(www.54juju.com)
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
if(!defined('CLOUDADDONS_WEBSITE_URL')) {
   require_once libfile('function/cloudaddons');
}
require_once ('cert.php');
function plugin_ins_error($identifier){
	global $_G;
	$addonid = $identifier.'.plugin';
	$array = cloudaddons_getmd5($addonid);
	if(cloudaddon_open('&mod=app&ac=validator&addonid='.$addonid.($array !== false ? '&rid='.$array['RevisionID'].'&sn='.$array['SN'].'&rd='.$array['RevisionDateline'] : '')) === '0') {
			$md5file = $identifier.'.plugin';
			$dir = DISCUZ_ROOT.'./source/plugin/'.$identifier;
			DB::delete('common_plugin', "identifier='$identifier'");
			$array = cloudaddons_getmd5($md5file);

			if($array === false) {
				cloudaddons_cleardir($dir);
			}else{
				if(!empty($array['RevisionID'])) {
					cloudaddons_removelog($array['RevisionID']);
				}
				@unlink(DISCUZ_ROOT.'./data/addonmd5/'.$md5file.'.xml');
				cloudaddons_cleardir($dir);
			}
	}else{
		cpmsg('plugins_install_succeed', 'action=plugins&hl='.$pluginid, 'succeed');
		
	}
}

function cloudaddon_open($extra, $post = '') {
	return dfsockopen(cloudaddons_url('&from=s').$extra, 0, $post, '', false, CLOUDADDONS_DOWNLOAD_IP, 999);
}
?>