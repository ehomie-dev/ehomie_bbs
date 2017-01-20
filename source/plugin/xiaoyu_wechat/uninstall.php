<?php


if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}


$sql = <<<EOF

DROP TABLE `cdb_xiaoyu_wechat_scan`,`cdb_xiaoyu_wechat_user`,`cdb_xiaoyu_wechat_token`;

EOF;

$finish = TRUE;

@unlink(DISCUZ_ROOT . 'source/plugin/xiaoyu_wechat/install.php');
@unlink(DISCUZ_ROOT . 'source/plugin/xiaoyu_wechat/xiaoyu_wechat.inc.php');
@unlink(DISCUZ_ROOT . 'source/plugin/xiaoyu_wechat/uninstall.php');
