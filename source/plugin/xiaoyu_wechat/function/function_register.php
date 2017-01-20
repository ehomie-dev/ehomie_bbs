<?php

/**
 *		(C)2001-2099 xiaoyu.
 *		This is NOT a freeware, use is subject to license terms
 *
 *		$Id: function_register.php by xiaoyu $
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function register_user($data){

	global $_G;
	loaducenter();
	$uid =0;
	$password = md5(random(10));
	$email = 'wechat_'.strtolower(random(10)).'@null.com';
	$username=getnewname($data['nickname']);
	$uid = uc_user_register(addslashes($username), $password, $email, '', '', $_G['clientip']);
		if($uid <= 0) {
			if(!$return) {
				if($uid == -1) {
					showmessage('profile_username_illegal');
				} elseif($uid == -2) {
					showmessage('profile_username_protect');
				} elseif($uid == -3) {
					showmessage('profile_username_duplicate');
				} elseif($uid == -4) {
					showmessage('profile_email_illegal');
				} elseif($uid == -5) {
					showmessage('profile_email_domain_illegal');
				} elseif($uid == -6) {
					showmessage('profile_email_duplicate');
				} else {
					showmessage('undefined_action');
				}
			} else {
				return;
			}
		}

	$init_arr = array('credits' => explode(',',$_G['setting']['initcredits']), 'profile'=>'', 'emailstatus' => '');

	C::t('common_member')->insert($uid, $username, $password, $email, $_G['clientip'], $_G['setting']['newusergroupid'], $init_arr);
	
	require_once libfile('cache/userstats', 'function');
	build_cache_userstats();
	require libfile('function/member');

		if($_G['setting']['regctrl'] || $_G['setting']['regfloodctrl']) {
			C::t('common_regip')->delete_by_dateline($_G['timestamp']-($_G['setting']['regctrl'] > 72 ? $_G['setting']['regctrl'] : 72)*3600);
			if($_G['setting']['regctrl']) {
				C::t('common_regip')->insert(array('ip' => $_G['clientip'], 'count' => -1, 'dateline' => $_G['timestamp']));
			}
		}

		if($_G['setting']['regverify'] == 2) {
			C::t('common_member_validate')->insert(array(
				'uid' => $uid,
				'submitdate' => $_G['timestamp'],
				'moddate' => 0,
				'admin' => '',
				'submittimes' => 1,
				'status' => 0,
				'message' => '',
				'remark' => '',
			), false, true);
			manage_addnotify('verifyuser');
		}
	
		setloginstatus(array(
		'uid' => $uid,
		'username' => $_G['username'],
		'password' => $password,
		'groupid' => $_G['setting']['newusergroupid'],
		), 0);

	   syncavatar($uid, $data['headimgurl']);
	return $uid;

}

function getnewname($username) {
	global $_G;
			
	$censor = false;
	$censorexp = '/^('.str_replace(array('\\*', "\r\n", ' '), array('.*', '|', ''), preg_quote(($_G['setting']['censoruser'] = trim($_G['setting']['censoruser'])), '/')).')$/i';
	if(@preg_match($censorexp, $username)) {
		$censor = true;
	}
		
	$newname = cutstr($username, 15, '');
	$newname = preg_replace("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is", "", $newname);
	$newname = preg_replace("#(\\\ue[0-9a-f]{3})#ie","",$newname);
		
	if($newname) {
		$censorexp = '/^('.str_replace(array('\\*', "\r\n", ' '), array('.*', '|', ''), preg_quote(($_G['setting']['censoruser'] = trim($_G['setting']['censoruser'])), '/')).')$/i';
		if(@preg_match($censorexp, $newname) || empty($newname)) {
			$newname = random(3);
		}else{
			loaducenter();
			if($user = uc_get_user($newname)) {
				$newname = cutstr($newname, 10, '');
				$newname = ($newname ? $newname.'_':'').random(3);
			}
		}
	} else {
		$newname = random(3);
	}
	if(dstrlen($newname)<3){
		$newname = $newname.'_'.random(3);
	}
	return $newname;
}

function syncAvatar($uid, $avatar) {

		if(!$uid || !$avatar) {
			return false;
		}

		if(!$content = dfsockopen($avatar)) {
			return false;
		}

		$tmpFile = DISCUZ_ROOT.'./data/avatar/'.TIMESTAMP.random(6);
		file_put_contents($tmpFile, $content);

		if(!is_file($tmpFile)) {
			return false;
		}

		$result = fish_uploadUcAvatar::upload($uid, $tmpFile);
		unlink($tmpFile);

		C::t('common_member')->update($uid, array('avatarstatus'=>'1'));

		return $result;
	}


class fish_uploadUcAvatar {

	public static function upload($uid, $localFile) {

		global $_G;
		if(!$uid || !$localFile) {
			return false;
		}

		list($width, $height, $type, $attr) = getimagesize($localFile);
		if(!$width) {
			return false;
		}

		if($width < 10 || $height < 10 || $type == 4) {
			return false;
		}

		$imageType = array(1 => '.gif', 2 => '.jpg', 3 => '.png');
		$fileType = $imgType[$type];
		if(!$fileType) {
			$fileType = '.jpg';
		}
		$avatarPath = $_G['setting']['attachdir'];
		$tmpAvatar = $avatarPath.'./temp/upload'.$uid.$fileType;
		file_exists($tmpAvatar) && @unlink($tmpAvatar);
		file_put_contents($tmpAvatar, file_get_contents($localFile));

		if(!is_file($tmpAvatar)) {
			return false;
		}

		$tmpAvatarBig = './temp/upload'.$uid.'big'.$fileType;
		$tmpAvatarMiddle = './temp/upload'.$uid.'middle'.$fileType;
		$tmpAvatarSmall = './temp/upload'.$uid.'small'.$fileType;

		$image = new image;
		if($image->Thumb($tmpAvatar, $tmpAvatarBig, 200, 250, 1) <= 0) {
			return false;
		}
		if($image->Thumb($tmpAvatar, $tmpAvatarMiddle, 120, 120, 1) <= 0) {
			return false;
		}
		if($image->Thumb($tmpAvatar, $tmpAvatarSmall, 48, 48, 2) <= 0) {
			return false;
		}

		$tmpAvatarBig = $avatarPath.$tmpAvatarBig;
		$tmpAvatarMiddle = $avatarPath.$tmpAvatarMiddle;
		$tmpAvatarSmall = $avatarPath.$tmpAvatarSmall;

		$avatar1 = self::byte2hex(file_get_contents($tmpAvatarBig));
		$avatar2 = self::byte2hex(file_get_contents($tmpAvatarMiddle));
		$avatar3 = self::byte2hex(file_get_contents($tmpAvatarSmall));

		$extra = '&avatar1='.$avatar1.'&avatar2='.$avatar2.'&avatar3='.$avatar3;
		$result = self::uc_api_post_ex('user', 'rectavatar', array('uid' => $uid), $extra);

		@unlink($tmpAvatar);
		@unlink($tmpAvatarBig);
		@unlink($tmpAvatarMiddle);
		@unlink($tmpAvatarSmall);

		return true;
	}

	public static function byte2hex($string) {
		$buffer = '';
		$value = unpack('H*', $string);
		$value = str_split($value[1], 2);
		$b = '';
		foreach($value as $k => $v) {
			$b .= strtoupper($v);
		}

		return $b;
	}

	public static function uc_api_post_ex($module, $action, $arg = array(), $extra = '') {
		$s = $sep = '';
		foreach($arg as $k => $v) {
			$k = urlencode($k);
			if(is_array($v)) {
				$s2 = $sep2 = '';
				foreach($v as $k2 => $v2) {
					$k2 = urlencode($k2);
					$s2 .= "$sep2{$k}[$k2]=".urlencode(uc_stripslashes($v2));
					$sep2 = '&';
				}
				$s .= $sep.$s2;
			} else {
				$s .= "$sep$k=".urlencode(uc_stripslashes($v));
			}
			$sep = '&';
		}
		$postdata = uc_api_requestdata($module, $action, $s, $extra);
		return uc_fopen2(UC_API.'/index.php', 500000, $postdata, '', TRUE, UC_IP, 20);
	}
}

function get_access_token($appid,$appsecret,$news=0){

	$tokeninfo = C::t('#xiaoyu_wechat#xiaoyu_wechat_token')->fetch('xiaoyu_wechat');
	
	if($news==0 && !empty($tokeninfo['access_token']) && time()<($tokeninfo['expires_in']+$tokeninfo['create_time'])){

		return $tokeninfo['access_token'];


	}else{
	
		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;

		$res = dfsockopen($url);
		$json= json_decode($res,true);
		$insertdata['access_token']=$json['access_token'];
		$insertdata['expires_in']='7200';
		$insertdata['type']='xiaoyu_wechat';
		$insertdata['create_time']=time();

		if(!empty($insertdata['access_token'])){
				
			if(empty($tokeninfo)){
				C::t('#xiaoyu_wechat#xiaoyu_wechat_token')->insert($insertdata);
			}else{
				unset($insertdata['type']);
				C::t('#xiaoyu_wechat#xiaoyu_wechat_token')->update('xiaoyu_wechat',$insertdata);
			}
		}
		return $insertdata['access_token'];

	}
}
//获取当前页面完整URL地址
function _get_url() {
	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}
//mult_iconv对任意维数组转换字符编码
function mult_iconv($in_charset,$out_charset,$data)
{
	
	if(substr($out_charset,-8)=='//IGNORE'){
		$out_charset=substr($out_charset,0,-8);
	}
	if(empty($data) || $in_charset == $out_charset) {
		return $data;
	}
	if(is_array($data)){
		foreach($data as $key => $value){
			if(is_array($value)){
				$key=iconv($in_charset,$out_charset.'//IGNORE',$key);
				$rtn[$key]=mult_iconv($in_charset,$out_charset,$value);
			}elseif(is_string($key) || is_string($value)){
				if(is_string($key)){
					$key=iconv($in_charset,$out_charset.'//IGNORE',$key);
				}
				if(is_string($value)){
					$value=iconv($in_charset,$out_charset.'//IGNORE',$value);
				}
				$rtn[$key]=$value;
			}else{
				$rtn[$key]=$value;
			}
		}
	}elseif(is_string($data)){
		$rtn=iconv($in_charset,$out_charset.'//IGNORE',$data);
	}else{
		$rtn=$data;
	}
	return $rtn;
}

function __getErrorMessage($errroCode) {
    $str = sprintf('connect_error_code_%d', $errroCode);

    return lang('plugin/qqconnect', $str);
}
function __connect_login($connect_member) {
    global $_G;

    if(!($member = getuserbyuid($connect_member['uid'], 1))) {
        return false;
    } else {
        if(isset($member['_inarchive'])) {
            C::t('common_member_archive')->move_to_master($member['uid']);
        }
    }

    require_once libfile('function/member');
    $cookietime = 1296000;
    setloginstatus($member, $cookietime);

    dsetcookie('connect_login', 1, $cookietime);
    dsetcookie('connect_is_bind', '1', 31536000);
    dsetcookie('connect_uin', $connect_member['conopenid'], 31536000);
    return true;
}

function xiaoyu_post($url, $data) {
	if (!function_exists('curl_init')) {
		return '';
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$data = curl_exec($ch);
	if (!$data) {
		error_log(curl_error($ch));
	}
	curl_close($ch);
	return $data;
}


?>