<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
loadcache('plugin');
$xiaoyu_setting = $_G['cache']['plugin']['xiaoyu_newmitouch'];
$xiaoyu_setting['indexforum'] = dunserialize($xiaoyu_setting['indexforum']);
$xiaoyu_setting['xiaoyu_perpage'] = $xiaoyu_setting['xiaoyu_perpage'] ? $xiaoyu_setting['xiaoyu_perpage'] : 5;
$xiaoyu_setting['guideforum'] = dunserialize($xiaoyu_setting['guideforum']);
$xiaoyu_setting['guidepagenum'] = $xiaoyu_setting['guidepagenum'] ? $xiaoyu_setting['guidepagenum'] : 10;
$xiaoyu_setting['latestforum'] = dunserialize($xiaoyu_setting['latestforum']);
$xiaoyu_setting['latestpagenum'] = $xiaoyu_setting['latestpagenum'] ? $xiaoyu_setting['latestpagenum'] : 10;
$xiaoyu_setting['hotlistnum'] = $xiaoyu_setting['hotlistnum'] ? $xiaoyu_setting['hotlistnum'] : 5;
$page = addslashes($_GET['page']) ? addslashes($_GET['page']) : 1;
$xiaaoyucatid = $xiaoyu_setting['xiaaoyucatid'];
$xiaoyu_perpage = $xiaoyu_setting['xiaoyu_perpage'];
$portalcodeslides = $xiaoyu_setting['portalcodeslides'];
function get_article_num($aid, $type) {
    $aid = intval($aid);
    $type = trim($type);
    $typearray = array(
        'viewnum',
        'commentnum',
        'favtimes',
        'sharetimes'
    );
    if ($aid == 0 || !in_array($type, $typearray)) {
        return false;
    } else {
        return DB::result_first("SELECT $type FROM " . DB::table('portal_article_count') . " WHERE aid = '$aid'");
    }
}
$wapindex = $xiaoyu_setting['wapindex'];
if ($wapindex == 1) {
    $indexurl = "portal.php?mod=mobile&mobile=2";
} else if ($wapindex == 2) {
    $indexurl = "forum.php?forumlist=1&mobile=2";
} else if ($wapindex == 3) {
    $indexurl = "forum.php?mod=guide&mobile=2";
}
if ($_G['basescript'] == 'portal') {
    if ($page > 1) {
        $cut = ($page - 1) * $xiaoyu_perpage;
    } else {
        $cut = 0;
    }
    $sql = array();
    $sql['select'] = 'SELECT t.*';
    $sql['from'] = 'FROM ' . DB::table('forum_thread') . ' t';
    $wherearr = array();
    $wherearr[] = 't.displayorder >=0';
    if ($xiaoyu_setting['indexforum'][0]) {
        $fidarr = implode(',', $xiaoyu_setting['indexforum']);
        $wherearr[] = "t.fid IN($fidarr)";
    }
    if ($xiaoyu_setting['indextime'] == 2) {
        $dateline = $_G['timestamp'] - 604800;
    } elseif ($xiaoyu_setting['indextime'] == 3) {
        $dateline = $_G['timestamp'] - 2592000;
    } elseif ($xiaoyu_setting['indextime'] == 4) {
        $dateline = $_G['timestamp'] - 7776000;
    } elseif ($xiaoyu_setting['indextime'] == 5) {
        $dateline = $_G['timestamp'] - 31104000;
    }
    if ($dateline) {
        $wherearr[] = "t.dateline >'$dateline'";
    }
    if ($xiaoyu_setting['indexorder'] == 1) {
        $sql['order'] = 'ORDER BY t.dateline DESC';
    } elseif ($xiaoyu_setting['indexorder'] == 2) {
        $sql['order'] = 'ORDER BY t.lastpost DESC';
    } elseif ($xiaoyu_setting['indexorder'] == 3) {
        $sql['order'] = 'ORDER BY t.views DESC';
    } elseif ($xiaoyu_setting['indexorder'] == 4) {
        $sql['order'] = 'ORDER BY t.replies DESC';
    }
    $sql['limit'] = "LIMIT $cut,$xiaoyu_perpage";
    if (!empty($wherearr)) $sql['where'] = ' WHERE ' . implode(' AND ', $wherearr);
    $sqlstring = $sql['select'] . ' ' . $sql['from'] . ' ' . $sql['where'] . ' ' . $sql['order'] . ' ' . $sql['limit'];
    $listcount = 1;
    $num_sql = 'SELECT COUNT(*) ' . $sql['from'] . $sql['where'];
    $listcount = DB::result_first($num_sql);
    if ($listcount) {
        $multi = multi($listcount, $xiaoyu_perpage, $page, "portal.php?mod=mobile&mobile=2", 1000);
        $query = DB::query($sqlstring);
        while ($value = DB::fetch($query)) {
            $value['dateline'] = dgmdate($value['dateline'], 'Y-m-d');
            $xiaoyu_newmitouch['index'][$value['tid']] = $value;
        }
    }
    if ($xiaoyu_setting['xiaoyuhotlist']) {
        $xiaoyu_hot_thread = " t.displayorder >=0 AND t.tid IN($xiaoyu_setting[xiaoyuhotlist]) ";
    } else {
        $xiaoyu_hot_thread = " t.displayorder >=0 ";
    }
    $hotliststring = "SELECT t.* FROM " . DB::table('forum_thread') . " t WHERE " . $xiaoyu_hot_thread . " ORDER BY t.dateline DESC LIMIT 0,$xiaoyu_setting[hotlistnum]";
    $queryhotlist = DB::query($hotliststring);
    while ($value = DB::fetch($queryhotlist)) {
        $table = 'forum_attachment_' . substr($value['tid'], -1);
        $value['aid'] = DB::result_first("SELECT aid FROM " . DB::table($table) . " WHERE tid='$value[tid]' AND isimage!=0 ORDER BY `dateline` ASC");
        $xiaoyu_newmitouch['xiaoyuhotlist'][$value['tid']] = $value;
    }
}
if (CURMODULE == 'guide' && $_GET['show'] != 'latest') {
    require_once libfile('function/forumlist');
    $forums = C::t('forum_forum')->fetch_all_by_status(1);
    $fids = array();
    foreach ($forums as $forum) {
        $fids[$forum['fid']] = $forum['fid'];
    }
    foreach ($forums as $forum) {
        if ($forum['type'] != 'group') {
            if ($forum['type'] == 'forum' && isset($catlist[$forum['fup']])) {
                if (forum($forum)) {
                    $catlist[$forum['fup']]['forums'][] = $forum['fid'];
                    $forumlist[$forum['fid']] = $forum;
                }
            }
        } else {
            $catlist[$forum['fid']] = $forum;
        }
    }
    $xiaoyu_setting['forums'] = dunserialize($xiaoyu_setting['forums']);
    if ($xiaoyu_setting['forums'][0]) {
        $subnum = count($xiaoyu_setting['forums']);
        foreach ($xiaoyu_setting['forums'] as $forumid) {
            $forum = $forumlist[$forumid];
            $substr.= $forum['name'];
        }
    }
    $size = $xiaoyu_setting['guidepagenum'];
    if ($page > 1) {
        $cut = ($page - 1) * $size;
    } else {
        $cut = 0;
    }
    $sql = array();
    $sql['select'] = 'SELECT t.*';
    $sql['from'] = 'FROM ' . DB::table('forum_thread') . ' t';
    $wherearr = array();
    $wherearr[] = 't.displayorder >=0';
    if ($xiaoyu_setting['guideforum'][0]) {
        $fidarr = implode(',', $xiaoyu_setting['guideforum']);
        $wherearr[] = "t.fid IN($fidarr)";
    }
    if ($xiaoyu_setting['guidetime'] == 2) {
        $dateline = $_G['timestamp'] - 604800;
    } elseif ($xiaoyu_setting['guidetime'] == 3) {
        $dateline = $_G['timestamp'] - 2592000;
    } elseif ($xiaoyu_setting['guidetime'] == 4) {
        $dateline = $_G['timestamp'] - 7776000;
    } elseif ($xiaoyu_setting['guidetime'] == 5) {
        $dateline = $_G['timestamp'] - 31104000;
    }
    if ($dateline) {
        $wherearr[] = "t.dateline >'$dateline'";
    }
    if ($xiaoyu_setting['guideorder'] == 1) {
        $sql['order'] = 'ORDER BY t.dateline DESC';
    } elseif ($xiaoyu_setting['guideorder'] == 2) {
        $sql['order'] = 'ORDER BY t.lastpost DESC';
    } elseif ($xiaoyu_setting['guideorder'] == 3) {
        $sql['order'] = 'ORDER BY t.views DESC';
    } elseif ($xiaoyu_setting['guideorder'] == 4) {
        $sql['order'] = 'ORDER BY t.replies DESC';
    }
    $sql['limit'] = "LIMIT $cut,$size";
    if (!empty($wherearr)) $sql['where'] = ' WHERE ' . implode(' AND ', $wherearr);
    $sqlstring = $sql['select'] . ' ' . $sql['from'] . ' ' . $sql['where'] . ' ' . $sql['order'] . ' ' . $sql['limit'];
    $listcount = 1;
    $num_sql = 'SELECT COUNT(*) ' . $sql['from'] . $sql['where'];
    $listcount = DB::result_first($num_sql);
    if ($listcount) {
        $multi = multi($listcount, $size, $page, "forum.php?mod=guide&mobile=2", 1000);
        $query = DB::query($sqlstring);
        while ($value = DB::fetch($query)) {
            $value['dateline'] = dgmdate($value['dateline'], 'Y-m-d');
            $xiaoyu_newmitouch['guide'][$value['tid']] = $value;
        }
    }
} elseif (CURMODULE == 'guide' && $_GET['show'] == 'latest') {
    $size = $xiaoyu_setting['latestpagenum'];
    if ($page > 1) {
        $cut = ($page - 1) * $size;
    } else {
        $cut = 0;
    }
    $sql = array();
    $sql['select'] = 'SELECT t.*';
    $sql['from'] = 'FROM ' . DB::table('forum_thread') . ' t';
    $wherearr = array();
    $wherearr[] = 't.displayorder >=0';
    $wherearr[] = 't.attachment =2';
    if ($xiaoyu_setting['latestforum'][0]) {
        $fidarr = implode(',', $xiaoyu_setting['latestforum']);
        $wherearr[] = "t.fid IN($fidarr)";
    }
    if ($xiaoyu_setting['latesttime'] == 2) {
        $dateline = $_G['timestamp'] - 604800;
    } elseif ($xiaoyu_setting['latesttime'] == 3) {
        $dateline = $_G['timestamp'] - 2592000;
    } elseif ($xiaoyu_setting['latesttime'] == 4) {
        $dateline = $_G['timestamp'] - 7776000;
    } elseif ($xiaoyu_setting['latesttime'] == 5) {
        $dateline = $_G['timestamp'] - 31104000;
    }
    if ($dateline) {
        $wherearr[] = "t.dateline >'$dateline'";
    }
    if ($xiaoyu_setting['latestorder'] == 1) {
        $sql['order'] = 'ORDER BY t.dateline DESC';
    } elseif ($xiaoyu_setting['latestorder'] == 2) {
        $sql['order'] = 'ORDER BY t.lastpost DESC';
    } elseif ($xiaoyu_setting['latestorder'] == 3) {
        $sql['order'] = 'ORDER BY t.views DESC';
    } elseif ($xiaoyu_setting['latestorder'] == 4) {
        $sql['order'] = 'ORDER BY t.replies DESC';
    }
    $sql['limit'] = "LIMIT $cut,$size";
    if (!empty($wherearr)) $sql['where'] = ' WHERE ' . implode(' AND ', $wherearr);
    $sqlstring = $sql['select'] . ' ' . $sql['from'] . ' ' . $sql['where'] . ' ' . $sql['order'] . ' ' . $sql['limit'];
    $listcount = 1;
    $num_sql = 'SELECT COUNT(*) ' . $sql['from'] . $sql['where'];
    $listcount = DB::result_first($num_sql);
    if ($listcount) {
        $multi = multi($listcount, $size, $page, "forum.php?mod=guide&show=latest&mobile=2", 1000);
        $query = DB::query($sqlstring);
        while ($value = DB::fetch($query)) {
            $value['dateline'] = dgmdate($value['dateline'], 'Y-m-d');
            $xiaoyu_newmitouch['latest'][$value['tid']] = $value;
        }
    }
}
?>

