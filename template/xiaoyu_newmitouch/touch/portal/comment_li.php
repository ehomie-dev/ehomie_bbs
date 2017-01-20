<?php exit;?>
<li class="reply_list_item cl"> 
<div class="reply_list_img"> 
<a target="_blank" class="headportrait" href="home.php?mod=space&uid=$comment[uid]&mobile=2">
{avatar($comment[uid],small)}
</a> 
</div> 
<div class="reply_list_con" style="margin-bottom: 10px;">
<div class="auth_msg cl">
<!--{if !empty($comment['uid'])}-->
<a class="auth_name" href="home.php?mod=space&uid=$comment[uid]">$comment[username]</a>
<!--{else}--><a class="auth_name">{lang guest}</a><!--{/if}-->
<span class="at"> 发表于</span> 
<span class="time"><!--{date($comment[dateline])}--></span>  
</div> 
<div class="reply_txt">
<!--{if $_G[adminid] == 1 || $comment[uid] == $_G[uid] || $comment[status] != 1}-->$comment[message]<!--{else}--> {lang moderate_not_validate}<!--{/if}-->
</div> 

<!-- manage end -->

<p></p> 
</div> </li>













