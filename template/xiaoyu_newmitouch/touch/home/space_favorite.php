<?php exit;?>
<!--{template common/header}-->
<div class="container_wrap wrap_990 cl contain_plate">
<div class="contain_right cl fl">
<div class="theme">
<div class="theme_con">
<div class="theme_nav">
<a class="theme_nav_list {if $_GET['type'] != 'forum'}current{/if} " href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=thread">{lang favthread}</a>
<a class="theme_nav_list {if $_GET['type'] == 'forum'}current{/if} " href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=forum">{lang favforum}</a>
</div>
<!-- main collectlist start -->
<!--{if $_GET['type'] == 'forum'}-->
<ul class="themelistcon cl">
		<!--{if $list}-->
			<!--{loop $list $k $value}-->
            <!--{eval $forum=DB::fetch_first("SELECT f.*,l.* FROM ".DB::table('forum_forum').' f,'.DB::table('forum_forumfield')." l WHERE f.fid='$value[id]' AND l.fid=f.fid");}-->
             <li class="theme_list cl"> 
                <div class="xiaoyu_bk_img">
                <a href="forum.php?mod=forumdisplay&fid={$forum['fid']}">
                <!--{if $forum[icon]}-->
                <img src="data/attachment/common/$forum[icon]" />
                <!--{else}-->
                <img src="template/xiaoyu_newmitouch/touch/style/img/forumico.jpg" alt="$forum[name]" width="50"/>
                <!--{/if}-->
                </a>
                </div> 
                <div style="margin-left: 60px;" class="theme_list_con"> 
                <div class="title"> 
                <a href="$value[url]" class="title_name title_bold ">$value[title]</a> 
                </div> 
                <div class="auth_msg cl">
                <a class="user_name" target="_blank">主题:$forum[threads]</a> 
                <span class="time txt">贴数: $forum[posts]</span> 
                </div> 
                </div>
                </li>
			<!--{/loop}-->
		<!--{else}-->
		<li class="theme_list cl">{lang no_favorite_yet}</li>
		<!--{/if}-->
</ul>

<!--{else}-->
<ul class="themelistcon cl">
		<!--{if $list}-->
			<!--{loop $list $k $value}-->
			<li class="theme_list cl">
             
            <div class="theme_list_con" style="margin-left:0;"> 
            <div class="title"> 
  			<a href="$value[url]" class="title_name title_bold">$value[title]</a>
            </div>
            <div class="auth_msg cl"><span class="time txt" style="margin-left:0"><!--{date($value[dateline], 'u')}--></span>
          </div>
            </div>
            </li>
		<!--{/loop}-->
	<!--{else}-->
		<li class="theme_list cl">{lang no_favorite_yet}</li>
		<!--{/if}-->
</ul>
<!--{/if}-->

<div class="base_widget_paging"> 
<div class="paging_widget_2 xiaoyu_forum_list"> 
$multi
</div> 
</div>

</div>
</div>
</div>
</div>
<!-- main collectlist end -->

<!--{template common/footer}-->

