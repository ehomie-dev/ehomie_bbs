<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

echo <<<HTML
<style>
#tips1lis li{background:none; padding-left:0;display:block!important;}
#tips1lis li#tips1_more{display:none!important;}
#tips1lis .t{margin-right:5px;color:orangered;font-weight:bolder}
#tips1lis .b{margin-right:5px;color:#666;font-weight:bold}
#tips1lis .n{margin-right:5px;color:#666;font-weight:bold}
</style>
HTML;

$message = str_replace(
    array('{url}'),
    array($_G['siteurl'].'source/plugin/xiaoyu_wechat/api.php'),
    lang('plugin/xiaoyu_wechat', 'guidenotice'));
showtips($message, 'tips1', TRUE);

