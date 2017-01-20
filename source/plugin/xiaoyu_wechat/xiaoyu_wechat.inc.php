<?php 

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$xiaoyuset = $_G['cache']['plugin']['xiaoyu_wechat'];
$APPID = $xiaoyuset['Fish_appid'];
$APPSCRET = $xiaoyuset['Fish_appsecret'];

include_once libfile('function/register','plugin/xiaoyu_wechat');
if($_GET['mod'] == 'mlogin'){
//获取授权
if (! isset($_GET['code'])) {
	$backurl=_get_url();
	//$backurl = $_G['siteurl']."plugin.php?id=xiaoyu_wechat&mod=mlogin";
	$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $APPID . "&redirect_uri=" .urlencode($backurl) . "&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
	dheader('Location:'.$url);
}else{
	 $code = $_GET['code'];
	 $get_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $APPID . "&secret=" . $APPSCRET . "&code=" . $code . "&grant_type=authorization_code";
     $re = dfsockopen($get_token_url);
	 //JSON数据包
     $jsonarr = json_decode($re, true);        
     $openid = $jsonarr['openid'];
     $unionid = $jsonarr['unionid'];
     $accesstoken = $jsonarr['access_token'];
     //拉取用户信息
     $get_userinfo_url='https://api.weixin.qq.com/sns/userinfo?access_token='.$accesstoken.'&openid='.$openid.'&lang=zh_CN';
     $getuser = dfsockopen($get_userinfo_url);
     $userinfoarr = json_decode($getuser,true);
     $userinfoarr= mult_iconv('UTF-8',CHARSET,$userinfoarr);

     if(!empty($userinfoarr['openid'])){
	 
     	$userinfo = C::t('#xiaoyu_wechat#xiaoyu_wechat_user')->fetch($userinfoarr['openid']);				
     	if(empty($userinfo)){
     		$uid = register_user($userinfoarr);
     		$setarr = array(
     			'openid'=>$userinfoarr['openid'],
     			'nickname'=>$userinfoarr['nickname'],
     			'city'=>$userinfoarr['city'],
     			'province'=>$userinfoarr['province'],
     			'country'=>$userinfoarr['country'],
     			'headimgurl'=>$userinfoarr['headimgurl'],
     			'uid'=>$uid,
     		);
     		
     		C::t('#xiaoyu_wechat#xiaoyu_wechat_user')->insert($setarr);
     		
     	}else{
     		if(!empty($userinfo['uid'])){
     			require libfile('function/member');
     			$uidinfo = getuserbyuid($userinfo['uid']);
				if($userinfo['uid'] != $uidinfo['uid']) {
					C::t('#xiaoyu_wechat#xiaoyu_wechat_user')->delete_by_uid($userinfo['uid']); 
				}else{
     			setloginstatus(array(
     			'uid' => $uidinfo['uid'],
     			'username' => $uidinfo['username'],
     			'password' => $uidinfo['password'],
     			'groupid' => $uidinfo['groupid'],
     			), 0);
				}
     			
     		}
     	}
     	
     }
	
   dheader("Location:".$_G['siteurl']."forum.php?mobile=2");
   
}

}



?>