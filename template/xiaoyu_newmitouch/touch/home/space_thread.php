<?php exit;?>
<!--{template common/header}-->
<!-- main threadlist start -->
<div class="container_wrap wrap_990 cl contain_plate">
<div class="contain_right cl fl">
<div class="theme">
<div class="theme_con">
<ul class="themelistcon cl">
	<!--{if $list}-->
		<!--{loop $list $thread}-->
			<li class="theme_list cl">
            <div class="theme_list_img">
            <a target="_blank" class="headportrait" href="home.php?mod=space&uid=$thread[authorid]">
            <!--{avatar($thread[authorid],small)}--></a> 
            </div> 
            <div class="theme_list_con"> 
            <div class="title"> 
            <!--{if $viewtype == 'reply' || $viewtype == 'postcomment'}-->
			<a href="forum.php?mod=redirect&goto=findpost&ptid=$thread[tid]&pid=$thread[pid]" class="title_name title_bold " style="color:#008000" target="_blank">$thread[subject]</a>
			<!--{else}-->
			<a href="forum.php?mod=viewthread&tid=$thread[tid]" target="_blank" {if $thread['displayorder'] == -1}class="grey"{else} class="title_name title_bold" style="color:#008000"{/if} >$thread[subject]</a>
			<!--{/if}-->
            </div> 
            <div class="auth_msg cl"> 
            <a href="home.php?mod=space&uid=$thread[authorid]" class="user_name" target="_blank">$thread[author]</a> 
            <span class="time txt"> $thread[dateline]</span> 
            <!--{if $groupnames[$thread[tid]]}--><a href="forum.php?mod=group&fid={$groupnames[$thread[tid]][fid]}" target="_blank" class="time txt">[{$groupnames[$thread[tid]][name]}]</a><!--{/if}-->
            <span class="numb view"><i></i>$thread[views]</span> 
            </div> 
            </div>
            </li>
		<!--{/loop}-->
	<!--{else}-->
		<li class="theme_list cl">{lang no_related_posts}</li>
	<!--{/if}-->
</ul>
    
<div class="base_widget_paging"> 
<div class="paging_widget_2 xiaoyu_forum_list"> 
$multi
</div> 
</div>
</div>
</div>
</div>
</div>
<!-- main threadlist end -->
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->

