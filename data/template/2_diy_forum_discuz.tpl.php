<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('discuz');
0
|| checktplrefresh('./template/mistyle/forum/discuz.htm', './template/mistyle/forum/discuz_threads.htm', 1484854513, 'diy', './data/template/2_diy_forum_discuz.tpl.php', './template/mistyle', 'forum/discuz')
|| checktplrefresh('./template/mistyle/forum/discuz.htm', './template/mistyle/common/sidefoot.htm', 1484854513, 'diy', './data/template/2_diy_forum_discuz.tpl.php', './template/mistyle', 'forum/discuz')
;?><?php include template('common/header'); ?><?php if(!empty($_G['setting']['pluginhooks']['index_status_extra'])) echo $_G['setting']['pluginhooks']['index_status_extra'];?>
<?php if(empty($gid)) { ?><?php echo adshow("text/wp a_t");?><?php } ?>
<style id="diy_style" type="text/css"></style>
<?php if(empty($gid)) { ?>
<div class="wp">
<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>
<?php } if(!empty($_G['setting']['grid']['showgrid'])) { ?>
<!-- index four grid -->
<div class="fl bm">
<div class="bm bmw cl">
<div id="category_grid" class="bm_c" >
<table cellspacing="0" cellpadding="0"><tr>
<?php if(!$_G['setting']['grid']['gridtype']) { ?>
<td valign="top" class="category_l1">
<div class="newimgbox">
<h4><span class="tit_newimg"></span>最新图片</h4>
<div class="module cl slidebox_grid" style="width:218px">
<script type="text/javascript">
var slideSpeed = 5000;
var slideImgsize = [218,200];
var slideBorderColor = '<?php echo $_G['style']['specialborder'];?>';
var slideBgColor = '<?php echo $_G['style']['commonbg'];?>';
var slideImgs = new Array();
var slideImgLinks = new Array();
var slideImgTexts = new Array();
var slideSwitchColor = '<?php echo $_G['style']['tabletext'];?>';
var slideSwitchbgColor = '<?php echo $_G['style']['commonbg'];?>';
var slideSwitchHiColor = '<?php echo $_G['style']['specialborder'];?>';<?php $k = 1;?><?php if(is_array($grids['slide'])) foreach($grids['slide'] as $stid => $svalue) { ?>slideImgs[<?php echo $k; ?>] = '<?php echo $svalue['image'];?>';
slideImgLinks[<?php echo $k; ?>] = '<?php echo $svalue['url'];?>';
slideImgTexts[<?php echo $k; ?>] = '<?php echo $svalue['subject'];?>';<?php $k++;?><?php } ?>
</script>
<script src="<?php echo $_G['setting']['jspath'];?>forum_slide.js?<?php echo VERHASH;?>" type="text/javascript"></script>
</div>
</div>
</td>
<?php } ?>
<td valign="top" class="category_l2">
<div class="subjectbox">
<h4><span class="tit_subject"></span>最新主题</h4>
        <ul class="category_newlist">
        <?php if(is_array($grids['newthread'])) foreach($grids['newthread'] as $thread) { ?>        	<?php if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { $thread[tid]=$thread[closed];?><?php } ?>
<li><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>"<?php if($thread['highlight']) { ?> <?php echo $thread['highlight'];?><?php } if($_G['setting']['grid']['showtips']) { ?> tip="标题: <strong><?php echo $thread['oldsubject'];?></strong><br/>作者: <?php echo $thread['author'];?> (<?php echo $thread['dateline'];?>)<br/>查看/回复: <?php echo $thread['views'];?>/<?php echo $thread['replies'];?>" onmouseover="showTip(this)"<?php } else { ?> title="<?php echo $thread['oldsubject'];?>"<?php } if($_G['setting']['grid']['targetblank']) { ?> target="_blank"<?php } ?>><?php echo $thread['subject'];?></a></li>
<?php } ?>
         </ul>
         </div>
</td>
<td valign="top" class="category_l3">
<div class="replaybox">
<h4><span class="tit_replay"></span>最新回复</h4>
        <ul class="category_newlist">
        <?php if(is_array($grids['newreply'])) foreach($grids['newreply'] as $thread) { ?>        	<?php if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { $thread[tid]=$thread[closed];?><?php } ?>
<li><a href="forum.php?mod=redirect&amp;tid=<?php echo $thread['tid'];?>&amp;goto=lastpost#lastpost"<?php if($thread['highlight']) { ?> <?php echo $thread['highlight'];?><?php } if($_G['setting']['grid']['showtips']) { ?>tip="标题: <strong><?php echo $thread['oldsubject'];?></strong><br/>作者: <?php echo $thread['author'];?> (<?php echo $thread['dateline'];?>)<br/>查看/回复: <?php echo $thread['views'];?>/<?php echo $thread['replies'];?>" onmouseover="showTip(this)"<?php } else { ?> title="<?php echo $thread['oldsubject'];?>"<?php } if($_G['setting']['grid']['targetblank']) { ?> target="_blank"<?php } ?>><?php echo $thread['subject'];?></a></li>
<?php } ?>
         </ul>
         </div>
</td>
<td valign="top" class="category_l3">
<div class="hottiebox">
<h4><span class="tit_hottie"></span>热帖</h4>
        <ul class="category_newlist">
        <?php if(is_array($grids['hot'])) foreach($grids['hot'] as $thread) { ?>        	<?php if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { $thread[tid]=$thread[closed];?><?php } ?>
<li><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>"<?php if($thread['highlight']) { ?> <?php echo $thread['highlight'];?><?php } if($_G['setting']['grid']['showtips']) { ?> tip="标题: <strong><?php echo $thread['oldsubject'];?></strong><br/>作者: <?php echo $thread['author'];?> (<?php echo $thread['dateline'];?>)<br/>查看/回复: <?php echo $thread['views'];?>/<?php echo $thread['replies'];?>" onmouseover="showTip(this)"<?php } else { ?> title="<?php echo $thread['oldsubject'];?>"<?php } if($_G['setting']['grid']['targetblank']) { ?> target="_blank"<?php } ?>><?php echo $thread['subject'];?></a></li>
<?php } ?>
         </ul>
         </div>
</td>
<?php if($_G['setting']['grid']['gridtype']) { ?>
<td valign="top" class="category_l4">
<div class="goodtiebox">
<h4><span class="tit_goodtie"></span>精华帖子</h4>
<ul class="category_newlist"><?php if(is_array($grids['digest'])) foreach($grids['digest'] as $thread) { if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { $thread[tid]=$thread[closed];?><?php } ?>
<li><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>"<?php if($thread['highlight']) { ?> <?php echo $thread['highlight'];?><?php } if($_G['setting']['grid']['showtips']) { ?> tip="标题: <strong><?php echo $thread['oldsubject'];?></strong><br/>作者: <?php echo $thread['author'];?> (<?php echo $thread['dateline'];?>)<br/>查看/回复: <?php echo $thread['views'];?>/<?php echo $thread['replies'];?>" onmouseover="showTip(this)"<?php } else { ?> title="<?php echo $thread['oldsubject'];?>"<?php } if($_G['setting']['grid']['targetblank']) { ?> target="_blank"<?php } ?>><?php echo $thread['subject'];?></a></li>
<?php } ?>
 </ul>
 	</div>
</td>
<?php } ?>
</table>
</div>
</div>
</div>
<!-- index four grid end -->
<?php } ?>

<!-- main area -->
<div id="ct" class="wp cl" style="padding-top:10px;">
  <table width="100%"><tr>
<!-- 左侧 -->
    <td style="vertical-align:top;padding-right:10px;">
<div class="bm hotforum_area">
          <table width="100%"><tr>
          <td width="140"><?php $hotforums=array();?><?php $maxforums=4;?><a id="allfrouma" onmouseover="showMenu({'ctrlid':'allfrouma'});" href="javascript:;" class="allforums-a" initialized="true">
所有版块<i class="icon icon-down"></i></a>
<!--默认隐藏,鼠标移到所有版块弹出下拉框显示-->
<div id="allfrouma_menu" style="display:none;">
              <div class="header_menu_list">
    <?php if(is_array($catlist)) foreach($catlist as $key => $cat) { ?>                  <h4><?php echo $cat['name'];?></h4>
                  <ul>
  <?php if(is_array($cat['forums'])) foreach($cat['forums'] as $forumid) { ?>    <?php $forum=$forumlist[$forumid];?><?php $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];?><li><a href="<?php echo $forumurl;?>" target="_blank"><?php echo $forum['name'];?></a></li>
<?php if($forum) { ?>
  <?php if(!empty($_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]];?>
<?php } else { ?>
  <?php if(!empty($_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]];?>
<?php } ?>
                  <?php } ?>
  </ul>
  <?php if(!empty($_G['setting']['pluginhooks']['index_catlist'][$cat[fid]])) echo $_G['setting']['pluginhooks']['index_catlist'][$cat[fid]];?>
                <?php } ?>
              </div>
            </div>
            <span class="pipe">|</span>
            热门版块: 
          </td><td>
            <table><tr><?php if(is_array($catlist)) foreach($catlist as $key => $cat) { ?>  <?php if(is_array($cat['forums'])) foreach($cat['forums'] as $forumid) { if($maxforums>0 && (empty($hotforums) || in_array($forumid,$hotforums))) { ?>
  <?php $maxforums-=1;?>  <?php $forum=$forumlist[$forumid];?>  <?php $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];?><td>
  <?php if($forum['icon']) { ?><?php echo $forum['icon'];?><?php } else { ?><a href="<?php echo $forumurl;?>"><img src="<?php echo IMGDIR;?>/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" align="left"></a><?php } ?></td>
                  <td><a class="fname" href="<?php echo $forumurl;?>"><?php echo $forum['name'];?></a></td>
<?php } ?>
              <?php } } ?></tr></table>
          </td>
          </tr></table>
</div>
<?php if(!empty($_G['setting']['pluginhooks']['index_top'])) echo $_G['setting']['pluginhooks']['index_top'];?><div class="bm theme_con">
  <div class="theme_nav">
<a href="forum.php?view=newthread" id="daodu-btn-newthread" class="theme_nav_list" onclick="_hmt.push(['_trackEvent', 'bbs首页', '最新主题button', '']);_msq.push(['trackEvent', 'new','','mibbis_c']);">最新主题</a>
<a href="forum.php?view=new" id="daodu-btn-new" class="theme_nav_list" onclick="_hmt.push(['_trackEvent', 'bbs首页', '内容区', '推荐button']);_msq.push(['trackEvent', 'tj','','mibbis_c']);">最新回复</a>
<a onclick="showWindow('nav', this.href, 'get', 0)" href="forum.php?mod=misc&amp;action=nav" class="mwt-btn mwt-btn-primary" style="font-size:12px;float:right;width:104px;"><i class="icon icon-ask" style="font-size:15px;vertical-align:text-bottom;"></i> 发表新主题</a>
  </div>
  <div id="daodu_threads_div"></div>
</div>
</td><td style="vertical-align:top;width:250px;">
<!-- 右侧 -->
    <!-- 站点公告 -->
<div id="announcement-div"></div>
<?php if(!empty($_G['setting']['pluginhooks']['index_side_top'])) echo $_G['setting']['pluginhooks']['index_side_top'];?>
<!-- 站点统计 -->
<div class="bm micon">
<ul class="xm_index_info">
  <li><span class="num"><?php echo $todayposts;?></span><span class="txt">今日发帖数</span></li>
  <li><span class="num"><?php echo $postdata['0'];?></span><span class="txt">昨日发帖数</span></li>
  <li><span class="num"><?php echo $posts;?></span><span class="txt">论坛总帖数</span></li>
  <li><span class="num"><?php echo $_G['cache']['userstats']['totalmembers'];?></span><span class="txt">论坛会员数</span></li>
</ul>
<?php if(!empty($_G['setting']['pluginhooks']['index_nav_extra'])) echo $_G['setting']['pluginhooks']['index_nav_extra'];?>
</div>
<!-- 在线会员 -->
<?php if(empty($gid) && $_G['setting']['whosonlinestatus'] && $detailstatus) { ?>
<div class="mwt-panel">
  <div class="mwt-head">在线会员
      </div>
  <div class="mwt-body">
        <div class="onnum">
  <ol class="clearfix" style="margin:0;">
<li style="width:52px;">
  <span class="txt" style="color:#ff8b3d;"><?php echo $onlinenum;?></span>
  <span class="txt">人在线</span>
</li>
<li style="width:52px;">
  <span class="txt" style="color:#ff8b3d;"><?php echo $membercount;?></span>
  <span class="txt">会员</span>
</li>
<li style="width:52px;">
  <span class="txt" style="color:#ff8b3d;"><?php echo $invisiblecount;?></span>
  <span class="txt">隐身</span>
</li>
<li style="width:52px;">
  <span class="txt" style="color:#ff8b3d;"><?php echo $guestcount;?></span>
  <span class="txt">位游客</span>
</li>
  </ol>			
</div>
<ul class="cl">
<?php if($whosonline) { ?>
  <?php if(is_array($whosonline)) foreach($whosonline as $key => $online) { ?>    <li class="onli" title="时间: <?php echo $online['lastactivity'];?>">
  <img src="<?php echo STATICURL;?>image/common/<?php echo $online['icon'];?>" alt="icon" />
  <?php if($online['uid']) { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $online['uid'];?>"><?php echo $online['username'];?></a>
  <?php } else { ?>
<?php echo $online['username'];?>
  <?php } ?>
</li>
  <?php } } else { ?>
  <li class="onli" style="width: auto">当前只有游客或隐身会员在线</li>
<?php } ?>
</ul>
  </div>
</div>
<?php } ?>
    <div>
  <?php if(is_array($collectiondata['follows'])) foreach($collectiondata['follows'] as $key => $colletion) { if($forumcolumns>1) { ?>
  <?php if(!empty($_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]];?>
<?php } else { ?>
  <?php if(!empty($_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]];?>
<?php } ?>
    <?php if(!empty($_G['setting']['pluginhooks']['index_followcollection_extra'][$colletion[ctid]])) echo $_G['setting']['pluginhooks']['index_followcollection_extra'][$colletion[ctid]];?>
  <?php } ?>
  <?php if(is_array($collectiondata['data'])) foreach($collectiondata['data'] as $key => $colletion) { ?>    <?php if(!empty($_G['setting']['pluginhooks']['index_datacollection_extra'][$colletion[ctid]])) echo $_G['setting']['pluginhooks']['index_datacollection_extra'][$colletion[ctid]];?>
  <?php } ?>
    </div>
    <!-- 友情链接 -->
<?php if(empty($gid) && ($_G['cache']['forumlinks']['0'] || $_G['cache']['forumlinks']['1'] || $_G['cache']['forumlinks']['2'])) { ?>
    <div class="mwt-panel">
      <div class="mwt-head">友情链接</div>
      <div class="mwt-body lk">
  	<?php if($_G['cache']['forumlinks']['0']) { ?>
  <ul class="m mbn cl"><?php echo $_G['cache']['forumlinks']['0'];?></ul>
<?php } if($_G['cache']['forumlinks']['1']) { ?>
  <div class="mbn cl">
    <?php echo $_G['cache']['forumlinks']['1'];?>
  </div>
<?php } if($_G['cache']['forumlinks']['2']) { ?>
  <ul class="x mbm cl" style="margin-bottom:0px !important;">
    <?php echo $_G['cache']['forumlinks']['2'];?>
  </ul>
<?php } ?>
      </div>
    </div>
<?php } ?>
    <!--全局右侧底部区域-->

<!--APP下载二维码-->
<div class="mwt-panel">
  <div class="mwt-head">扫描二维码下载APP</div>
  <div class="mwt-body">
    <div id="head-qrdiv" style="display:block;position:relative;border:none;height:160px;">
      <span></span>
</div>
  </div>
</div>

<?php if(!empty($_G['setting']['pluginhooks']['index_side_bottom'])) echo $_G['setting']['pluginhooks']['index_side_bottom'];?>
  </td></tr></table>
</div>
<div id="ct_2" class="wp cl<?php if($_G['setting']['forumallowside']) { ?> ct2<?php } ?>">
<!--[diy=diy_chart]--><div id="diy_chart" class="area"></div><!--[/diy]-->
<div class="mn">
<?php if(!empty($_G['setting']['pluginhooks']['index_catlist_top'])) echo $_G['setting']['pluginhooks']['index_catlist_top'];?>
<?php if(!empty($_G['setting']['pluginhooks']['index_middle'])) echo $_G['setting']['pluginhooks']['index_middle'];?>
<div class="wp mtn">
<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>
<?php if(!empty($_G['setting']['pluginhooks']['index_bottom'])) echo $_G['setting']['pluginhooks']['index_bottom'];?>
</div>
<?php if($_G['setting']['forumallowside']) { ?>
<div id="sd" class="sd">
<div class="drag">
<!--[diy=diy2]--><div id="diy2" class="area"></div><!--[/diy]-->
</div>
</div>
<?php } ?>
</div>
<?php if($_G['group']['radminid'] == 1) { helper_manyou::checkupdate();?><?php } if(empty($_G['setting']['disfixednv_forumindex']) ) { ?><script>fixed_top_nv();</script><?php } ?>

<script>
jQuery(document).ready(function() {
    require(["jsapp"],function(jsapp){
jsapp.run('forum/discuz');
});
});
</script><?php include template('common/footer'); ?>