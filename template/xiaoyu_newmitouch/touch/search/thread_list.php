<?php exit;?>
<div class="theme_con">
<!--{if empty($threadlist)}-->
<ul class="themelistcon cl"><li class="theme_list cl" style="padding-top:0"><a href="javascript:;">{lang search_nomatch}</a></li></ul>
<!--{else}-->
<ul class="themelistcon cl">
<h2 class="xiaoyu_search_thread_tit"><!--{if $keyword}-->{lang search_result_keyword} <!--{if $modfid}--><a href="forum.php?mod=modcp&action=thread&fid=$modfid&keywords=$modkeyword&submit=true&do=search&page=$page" target="_blank">{lang goto_memcp}</a><!--{/if}--><!--{else}-->{lang search_result}<!--{/if}--></h2>
<!--{loop $threadlist $thread}-->
<li class="theme_list cl"> 
<div class="theme_list_img">
        <a href="home.php?mod=space&uid=$thread[authorid]" class="headportrait" target="_blank">
        <!--{avatar($thread[authorid],small)}--></a> 
        </div> 
<div class="theme_list_con"> 
<div class="title"> 
<a href="forum.php?mod=viewthread&tid=$thread[realtid]&highlight=$index[keywords]" class="title_name title_bold " target="_blank" $thread[highlight]>$thread[subject]</a>
</div> 
<div class="auth_msg cl"> 
        <a href="home.php?mod=space&uid=$thread[authorid]" class="user_name" target="_blank">$thread[author]</a> 
        <span class="time txt"> $thread[dateline]</span> 
        <span class="numb view"><i></i>$thread[views]</span> 
        </div> 
</div>
</li>
<!--{/loop}-->
</ul>
<div class="base_widget_paging"> 
<div class="paging_widget_2 xiaoyu_forum_list"> 
$multipage
</div> 
</div>
<!--{/if}-->



</div>
