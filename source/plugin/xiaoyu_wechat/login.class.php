<?php

/**
 *		(C)2001-2099 xiaoyu.
 *		This is NOT a freeware, use is subject to license terms
 *
 *		$Id: login.class.php by xiaoyu $
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once libfile('function/member');
include_once libfile('function/register', 'plugin/xiaoyu_wechat');
class plugin_xiaoyu_wechat {
    public static function qq_connect_login($connect_member) {
        if (!($member = getuserbyuid($connect_member['uid'], 1))) {
            return false;
        } else {
            if (isset($member['_inarchive'])) {
                C::t('common_member_archive')->move_to_master($member['uid']);
            }
        }
        require_once libfile('function/member');
        $cookietime = 1296000;
        setloginstatus($member, $cookietime);
        dsetcookie('connect_login', 1, $cookietime);
        dsetcookie('connect_is_bind', '1', 31536000);
        dsetcookie('connect_uin', $connect_member['conopenid'], 31536000);
        global $_G;
        $params['mod'] = 'login';
        loadcache('usergroups');
        $usergroups = $_G['cache']['usergroups'][$_G['groupid']]['grouptitle'];
        $param = array(
            'username' => $_G['member']['username'],
            'usergroup' => $_G['group']['grouptitle']
        );
        C::t('common_member_status')->update($connect_member['uid'], array(
            'lastip' => $_G['clientip'],
            'lastvisit' => TIMESTAMP,
            'lastactivity' => TIMESTAMP
        ));
        $ucsynlogin = '';
        if ($_G['setting']['allowsynlogin']) {
            loaducenter();
            $ucsynlogin = uc_user_synlogin($_G['uid']);
        }
        dsetcookie('stats_qc_login', 3, 86400);
        showmessage('login_succeed', dreferer() , $param, array(
            'extrajs' => $ucsynlogin
        ));
        return true;
    }
    public static function qq_getuserinfo($conopenid, $conuintoken, $conuin, $conuinsecret) {
        $connectUserInfo = array();
        global $_G;
        if (!$_G['setting']['connect']['oauth2']) {
            try {
                $connectOAuthClient = Cloud::loadClass('Service_Client_ConnectOAuth');
                $connectUserInfo = $connectOAuthClient->connectGetUserInfo($conopenid, $conuin, $conuinsecret);
                if ($connectUserInfo['nickname']) {
                    $connectUserInfo['nickname'] = strip_tags($connectUserInfo['nickname']);
                }
            }
            catch(Exception $e) {
            }
        } else {
            try {
                $connectOAuthClient = Cloud::loadClass('Service_Client_ConnectOAuth');
                $connectUserInfo = $connectOAuthClient->connectGetUserInfo_V2($conopenid, $conuintoken);
                if ($connectUserInfo['nickname']) {
                    $connectUserInfo['nickname'] = strip_tags($connectUserInfo['nickname']);
                }
            }
            catch(Exception $e) {
            }
        }
        return $connectUserInfo;
    }
    public static function qq_register($username, $return = 0, $otype = 'qq', $groupid = 0, $userinfo = array()) {
        global $_G;
        if (!$username) {
            return;
        }
        if (!$_G['cache']['plugin']) {
            loadcache('plugin');
        }
        $xiaoyuset = $_G['cache']['plugin']['xiaoyu_wechat'];
        loaducenter();
		$groupid = $_G['setting']['newusergroupid'];
        $password = md5(random(10));
        $email = 'qq_' . strtolower(random(10)) . '@qq.com';
        $username = getnewname($username);
        $uid = uc_user_register(addslashes($username) , $password, $email, '', '', $_G['clientip']);
        if ($uid <= 0) {
            if (!$return) {
                if ($uid == - 1) {
                    showmessage('profile_username_illegal');
                } elseif ($uid == - 2) {
                    showmessage('profile_username_protect');
                } elseif ($uid == - 3) {
                    showmessage('profile_username_duplicate');
                } elseif ($uid == - 4) {
                    showmessage('profile_email_illegal');
                } elseif ($uid == - 5) {
                    showmessage('profile_email_domain_illegal');
                } elseif ($uid == - 6) {
                    showmessage('profile_email_duplicate');
                } else {
                    showmessage('undefined_action');
                }
            } else {
                return;
            }
        }
        $init_arr = array(
            'credits' => explode(',', $_G['setting']['initcredits'])
        );
        C::t('common_member')->insert($uid, $username, $password, $email, $_G['clientip'], $groupid, $init_arr);
        if ($_G['setting']['regverify'] == 2) {
            C::t('common_member_validate')->insert(array(
                'uid' => $uid,
                'submitdate' => $_G['timestamp'],
                'moddate' => 0,
                'admin' => '',
                'submittimes' => 1,
                'status' => 0,
                'message' => '',
                'remark' => '',
            ) , false, true);
            manage_addnotify('verifyuser');
        }
        setloginstatus(array(
            'uid' => $uid,
            'username' => $username,
            'password' => $password,
            'groupid' => $groupid,
        ) , 0);
        include_once libfile('function/stat');
        updatestat('register');
        //头像
        syncAvatar($uid, $userinfo['figureurl_qq_2']);
        $gender = $userinfo['gender'] == lang('plugin/xiaoyu_wechat', 'gender2') ? 2 : ($userinfo['gender'] == lang('plugin/xiaoyu_wechat', 'gender1') ? 1 : 0);
        C::t('common_member_profile')->update($uid, array(
            'realname' => $userinfo['nickname'],
            'gender' => $gender,
            'birthyear' => $userinfo['year'],
        ));
        return $uid;
    }
    public function login_callback() {
        global $_G;
        $params = $_GET;
        $referer = dreferer();
        if ($params['op'] != 'callback') {
            return false;
        }
        try {
            $connectOAuthClient = Cloud::loadClass('Service_Client_ConnectOAuth');
        }
        catch(Exception $e) {
            showmessage('qqconnect:connect_app_invalid');
        }
        if (!isset($params['receive'])) {
            $utilService = Cloud::loadClass('Service_Util');
            echo '<script type="text/javascript">setTimeout("window.location.href=\'connect.php?receive=yes&' . str_replace("'", "\'", $utilService->httpBuildQuery($_GET, '', '&')) . '\'", 1)</script>';
            exit;
        }
        if (!$_G['setting']['connect']['oauth2']) {
            try {
                $response = $connectOAuthClient->connectGetAccessToken($params, $_G['cookie']['con_request_token_secret']);
            }
            catch(Exception $e) {
                showmessage('qqconnect:connect_get_access_token_failed_code', $referer, array(
                    'codeMessage' => __getErrorMessage($e->getmessage()) ,
                    'code' => $e->getmessage()
                ));
            }
            dsetcookie('con_request_token');
            dsetcookie('con_request_token_secret');
            $conuin = $response['oauth_token'];
            $conuinsecret = $response['oauth_token_secret'];
            $conopenid = strtoupper($response['openid']);
            if (!$conuin || !$conuinsecret || !$conopenid) {
                showmessage('qqconnect:connect_get_access_token_failed_code', $referer);
            }
        } else {
            if ($_GET['state'] != md5(FORMHASH)) {
                showmessage('qqconnect:connect_get_access_token_failed', $referer);
            }
            try {
                $response = $connectOAuthClient->connectGetOpenId_V2($_G['cookie']['con_request_uri'], $_GET['code']);
            }
            catch(Exception $e) {
                showmessage('qqconnect:connect_get_access_token_failed_code', $referer, array(
                    'codeMessage' => __getErrorMessage($e->getmessage()) ,
                    'code' => $e->getmessage()
                ));
            }
            dsetcookie('con_request_token');
            dsetcookie('con_request_token_secret');
            $conuintoken = $response['access_token'];
            $conopenid = strtoupper($response['openid']);
            if (!$conuintoken || !$conopenid) {
                showmessage('qqconnect:connect_get_access_token_failed', $referer);
            }
        }
        loadcache('connect_blacklist');
        if (in_array($conopenid, array_map('strtoupper', $_G['cache']['connect_blacklist']))) {
            $change_qq_url = $_G['connect']['discuz_change_qq_url'];
            showmessage('qqconnect:connect_uin_in_blacklist', $referer, array(
                'changeqqurl' => $change_qq_url
            ));
        }
        $referer = $referer && (strpos($referer, 'logging') === false) && (strpos($referer, 'mod=login') === false) ? $referer : 'index.php';
        if ($params['uin']) {
            $old_conuin = $params['uin'];
        }
        $is_notify = true;
        $conispublishfeed = 0;
        $conispublisht = 0;
        $is_user_info = 1;
        $is_feed = 1;
        $user_auth_fields = 1;
        $cookie_expires = 2592000;
        dsetcookie('client_created', TIMESTAMP, $cookie_expires);
        dsetcookie('client_token', $conopenid, $cookie_expires);
        $connect_member = array();
        $fields = array(
            'uid',
            'conuin',
            'conuinsecret',
            'conopenid'
        );
        if ($old_conuin) {
            $connect_member = C::t('#qqconnect#common_member_connect')->fetch_fields_by_openid($old_conuin, $fields);
        }
        if (empty($connect_member)) {
            $connect_member = C::t('#qqconnect#common_member_connect')->fetch_fields_by_openid($conopenid, $fields);
        }
        if ($connect_member) {
            $member = getuserbyuid($connect_member['uid']);
            if ($member) {
                if (!$member['conisbind']) {
                    C::t('#qqconnect#common_member_connect')->delete($connect_member['uid']);
                    unset($connect_member);
                } else {
                    $connect_member['conisbind'] = $member['conisbind'];
                }
            } else {
                C::t('#qqconnect#common_member_connect')->delete($connect_member['uid']);
                unset($connect_member);
            }
        }
        $connect_is_unbind = $params['is_unbind'] == 1 ? 1 : 0;
        if ($connect_is_unbind && $connect_member && !$_G['uid'] && $is_notify) {
            dsetcookie('connect_js_name', 'user_bind', 86400);
            dsetcookie('connect_js_params', base64_encode(serialize(array(
                'type' => 'registerbind'

            ))) , 86400);
        }
        if ($_G['uid']) {
            if ($connect_member && $connect_member['uid'] != $_G['uid']) {
                showmessage('qqconnect:connect_register_bind_uin_already', $referer, array(
                    'username' => $_G['member']['username']
                ));
            }
            $isqqshow = !empty($_GET['isqqshow']) ? 1 : 0;
            $current_connect_member = C::t('#qqconnect#common_member_connect')->fetch($_G['uid']);
            if ($_G['member']['conisbind'] && $current_connect_member['conopenid']) {
                if (strtoupper($current_connect_member['conopenid']) != $conopenid) {
                    showmessage('qqconnect:connect_register_bind_already', $referer);
                }
                C::t('#qqconnect#common_member_connect')->update($_G['uid'], !$_G['setting']['connect']['oauth2'] ? array(
                    'conuin' => $conuin,
                    'conuinsecret' => $conuinsecret,
                    'conopenid' => $conopenid,
                    'conisregister' => 0,
                    'conisfeed' => 1,
                    'conisqqshow' => $isqqshow,
                ) : array(
                    'conuintoken' => $conuintoken,
                    'conopenid' => $conopenid,
                    'conisregister' => 0,
                    'conisfeed' => 1,
                    'conisqqshow' => $isqqshow,
                ));
            } else { // debug 当前登录的论坛账号并没有绑定任何QQ号，则可以绑定当前的这个QQ号
                if (empty($current_connect_member)) {
                    C::t('#qqconnect#common_member_connect')->insert(!$_G['setting']['connect']['oauth2'] ? array(
                        'uid' => $_G['uid'],
                        'conuin' => $conuin,
                        'conuinsecret' => $conuinsecret,
                        'conopenid' => $conopenid,
                        'conispublishfeed' => $conispublishfeed,
                        'conispublisht' => $conispublisht,
                        'conisregister' => 0,
                        'conisfeed' => 1,
                        'conisqqshow' => $isqqshow,
                    ) : array(
                        'uid' => $_G['uid'],
                        'conuin' => '',
                        'conuintoken' => $conuintoken,
                        'conopenid' => $conopenid,
                        'conispublishfeed' => $conispublishfeed,
                        'conispublisht' => $conispublisht,
                        'conisregister' => 0,
                        'conisfeed' => 1,
                        'conisqqshow' => $isqqshow,
                    ));
                } else {
                    C::t('#qqconnect#common_member_connect')->update($_G['uid'], !$_G['setting']['connect']['oauth2'] ? array(
                        'conuin' => $conuin,
                        'conuinsecret' => $conuinsecret,
                        'conopenid' => $conopenid,
                        'conispublishfeed' => $conispublishfeed,
                        'conispublisht' => $conispublisht,
                        'conisregister' => 0,
                        'conisfeed' => 1,
                        'conisqqshow' => $isqqshow,
                    ) : array(
                        'conuintoken' => $conuintoken,
                        'conopenid' => $conopenid,
                        'conispublishfeed' => $conispublishfeed,
                        'conispublisht' => $conispublisht,
                        'conisregister' => 0,
                        'conisfeed' => 1,
                        'conisqqshow' => $isqqshow,
                    ));
                }
                C::t('common_member')->update($_G['uid'], array(
                    'conisbind' => '1'
                ));
                C::t('#qqconnect#common_connect_guest')->delete($conopenid);
            }
            if ($is_notify) {
                dsetcookie('connect_js_name', 'user_bind', 86400);
                dsetcookie('connect_js_params', base64_encode(serialize(array(
                    'type' => 'loginbind'
                ))) , 86400);
            }
            dsetcookie('connect_login', 1, 31536000);
            dsetcookie('connect_is_bind', '1', 31536000);
            dsetcookie('connect_uin', $conopenid, 31536000);
            dsetcookie('stats_qc_reg', 3, 86400);
            if ($is_feed) {
                dsetcookie('connect_synpost_tip', 1, 31536000);
            }
            C::t('#qqconnect#connect_memberbindlog')->insert(array(
                'uid' => $_G['uid'],
                'uin' => $conopenid,
                'type' => 1,
                'dateline' => $_G['timestamp'],
            ));
            showmessage('qqconnect:connect_register_bind_success', $referer);
        } else {
            if ($connect_member) { // debug 此分支是用户直接点击QQ登录，并且这个QQ号已经绑好一个论坛账号了，将直接登进论坛了
                C::t('#qqconnect#common_member_connect')->update($connect_member['uid'], !$_G['setting']['connect']['oauth2'] ? array(
                    'conuin' => $conuin,
                    'conuinsecret' => $conuinsecret,
                    'conopenid' => $conopenid,
                    'conisfeed' => 1,
                ) : array(
                    'conuintoken' => $conuintoken,
                    'conopenid' => $conopenid,
                    'conisfeed' => 1,
                ));
                $params['mod'] = 'login';
                __connect_login($connect_member);
                loadcache('usergroups');
                $usergroups = $_G['cache']['usergroups'][$_G['groupid']]['grouptitle'];
                $param = array(
                    'username' => $_G['member']['username'],
                    'usergroup' => $_G['group']['grouptitle']
                );
                C::t('common_member_status')->update($connect_member['uid'], array(
                    'lastip' => $_G['clientip'],
                    'lastvisit' => TIMESTAMP,
                    'lastactivity' => TIMESTAMP
                ));
                $ucsynlogin = '';
                if ($_G['setting']['allowsynlogin']) {
                    loaducenter();
                    $ucsynlogin = uc_user_synlogin($_G['uid']);
                }
                dsetcookie('stats_qc_login', 3, 86400);
                showmessage('login_succeed', $referer, $param, array(
                    'extrajs' => $ucsynlogin
                ));
            } else { // debug 此分支是用户直接点击QQ登录，并且这个QQ号还未绑定任何论坛账号,可跳过登录by xiaoyu
                $userinfo = self::qq_getuserinfo($conopenid, $conuintoken, $conuin, $conuinsecret);
                if ($uid = self::qq_register($userinfo['nickname'], 0, 'qq', 0, $userinfo)) {
                    C::t('#qqconnect#common_member_connect')->insert(array(
                        'uid' => $uid,
                        'conuin' => $conuin,
                        'conuinsecret' => $conuinsecret,
                        'conuintoken' => $conuintoken,
                        'conopenid' => $conopenid,
                        'conispublishfeed' => $conispublishfeed,
                        'conispublisht' => $conispublisht,
                        'conisregister' => '1',
                        'conisqzoneavatar' => 1,
                        'conisfeed' => '1',
                        'conisqqshow' => 1,
                    ));
                    dsetcookie('connect_js_name', 'user_bind', 86400);
                    dsetcookie('connect_js_params', base64_encode(serialize(array(
                        'type' => 'register'
                    ))) , 86400);
                    dsetcookie('connect_login', 1, 31536000);
                    dsetcookie('connect_is_bind', '1', 31536000);
                    dsetcookie('connect_uin', $conopenid, 31536000);
                    dsetcookie('stats_qc_reg', 1, 86400);
                    if ($_GET['is_feed']) {
                        dsetcookie('connect_synpost_tip', 1, 31536000);
                    }
                    C::t('#qqconnect#connect_memberbindlog')->insert(array(
                        'uid' => $uid,
                        'uin' => $conopenid,
                        'type' => '1',
                        'dateline' => $_G['timestamp']
                    ));
                    dsetcookie('con_auth_hash');
                    C::t('#qqconnect#common_connect_guest')->delete($conopenid);
                    if (!function_exists('build_cache_userstats')) {
                        require_once libfile('cache/userstats', 'function');
                    }
                    build_cache_userstats();
                    $userdata = array();
                    $userdata['avatarstatus'] = 1;
                    $userdata['conisbind'] = 1;
                    if ($_G['setting']['connect']['register_groupid']) {
                        $userdata['groupid'] = $groupinfo['groupid'] = $_G['setting']['connect']['register_groupid'];
                    }
                    C::t('common_member')->update($uid, $userdata);
                    if ($_G['setting']['connect']['register_addcredit']) {
                        $addcredit = array(
                            'extcredits' . $_G['setting']['connect']['register_rewardcredit'] => $_G['setting']['connect']['register_addcredit']
                        );
                    }
                    C::t('common_member_count')->increase($uid, $addcredit);
                    self::qq_connect_login(array(
                        'uid' => $uid
                    ));
                }
            }
        }
        dexit();
    }
    public function global_login_extra() {
        global $_G;
        include template('xiaoyu_wechat:module');
        return $header_login;
    }
}
class plugin_xiaoyu_wechat_member extends plugin_xiaoyu_wechat {
    function logging_method() {
        global $_G;
        include template('xiaoyu_wechat:module');
        return $member_login;
    }
    function register_logging_method() {
        global $_G;
        include template('xiaoyu_wechat:module');
        return $member_login;
    }
}
class plugin_xiaoyu_wechat_connect extends plugin_xiaoyu_wechat {
}
class plugin_xiaoyu_wechat_plugin extends plugin_xiaoyu_wechat {
}
class mobileplugin_xiaoyu_wechat {
}
class mobileplugin_xiaoyu_wechat_member extends plugin_xiaoyu_wechat {
    public function logging_bottom_mobile() {
        return '<br><div class="btn_login" ><a class="formdialog pn pnc" href="plugin.php?id=xiaoyu_wechat&mod=mlogin"><span>' . lang('plugin/xiaoyu_wechat', 'wxlogin') . '</span></a></div>';
    }
}
class mobileplugin_xiaoyu_wechat_connect extends plugin_xiaoyu_wechat {
}
class mobileplugin_xiaoyu_wechat_plugin extends plugin_xiaoyu_wechat {
}
?> 
