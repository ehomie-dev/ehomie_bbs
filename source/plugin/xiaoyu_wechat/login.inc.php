<?php


if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

if (empty($_GET['mod']) || ($_GET['mod'] != 'login')) $_GET['mod'] = 'login';
if ($_GET['mod'] != 'login') {
    xiaoyu_xss_check();
}
$xiaoyuset = $_G['cache']['plugin']['xiaoyu_wechat'];
$xiaoyu_random = random(8);
$xiaoyu_key= authcode($xiaoyu_random,'ENCODE',$xiaoyuset['Fish_key']);
$xiaoyu_keys = urlencode($xiaoyu_key);
require_once libfile('function/cache');
include_once libfile('function/register', 'plugin/xiaoyu_wechat');
$access_token = get_access_token($xiaoyuset['Fish_appid'], $xiaoyuset['Fish_appsecret']);
define(MCURMODULE, $_GET['mod']); //定义常量
define("FISH_TOKEN", $xiaoyuset['Fish_token'] ? $xiaoyuset['Fish_token'] : "xiaoyu_wechat");
define('FISH_ACCESS_TOKEN', $access_token);

include_once libfile('module/login', 'plugin/xiaoyu_wechat');
if ($_GET['action'] == 'qrcode') {
    if (submitcheck('formhash', true)) {
        $expire = 180;
        $scene_id = rand(1, 100000);
        $random = daddslashes($_GET['random']);
        $xiaoyu_key = authcode($_GET['random'], 'ENCODE', $xiaoyuset['Fish_key']);
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . FISH_ACCESS_TOKEN;
        $insertarr = array(
            'scene_id' => $scene_id,
            'expire' => TIMESTAMP + $expire,
            'status' => 0,
            'xiaoyu_key' => $xiaoyu_key,
            'random' => $random,
        );
        $scan = C::t('#xiaoyu_wechat#xiaoyu_wechat_scan')->fetch($scene_id);
        if (!$scan) {
            C::t('#xiaoyu_wechat#xiaoyu_wechat_scan')->insert($insertarr);
        } else {
            unset($insertarr['scene_id']);
            C::t('#xiaoyu_wechat#xiaoyu_wechat_scan')->update($scene_id, $insertarr);
        }
        $data = array(
            'expire_seconds' => $expire,
            'action_name' => 'QR_SCENE',
            'action_info' => array(
                'scene' => array(
                    'scene_id' => $scene_id
                )
            )
        );
        $data = json_encode($data);
        $res = xiaoyu_post($url, $data);
        $json = json_decode($res, true);
        if ($json['ticket']) {
            $qrcode = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($json['ticket']);
            header('Location:' . $qrcode);
            exit;
        }
    }
}
include template('xiaoyu_wechat:qrcode');

/*防XSS函数*/
function xiaoyu_xss_check() {
    static $check = array(
        '"',
        '>',
        '<',
        '\'',
        '(',
        ')',
        'CONTENT-TRANSFER-ENCODING'
    );
    if (isset($_GET['formhash']) && $_GET['formhash'] !== formhash()) {
        system_error('request_tainting');
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $temp = $_SERVER['REQUEST_URI'];
    } elseif (empty($_GET['formhash'])) {
        $temp = $_SERVER['REQUEST_URI'] . file_get_contents('php://input');
    } else {
        $temp = '';
    }
    if (!empty($temp)) {
        $temp = strtoupper(urldecode(urldecode($temp)));
        foreach ($check as $str) {
            if (strpos($temp, $str) !== false) {
                system_error('request_tainting');
            }
        }
    }
    return true;
}

