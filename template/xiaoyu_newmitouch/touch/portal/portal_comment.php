<?php exit;?>
<div id="comment_top" class="reply">
<div class="reply_con">
<div class="reply_title cl">
<h3>{lang latest_comment}</h3> 
<span class="replay_num"><!--{if $data[commentnum]}-->$data[commentnum]<!--{/if}--></span> 
</div>     
<ul class="reply_list cl">
<!--{loop $commentlist $comment}-->
<!--{template portal/comment_li}-->
<!--{if !empty($aimgs[$comment[cid]])}-->
<!--{/if}-->
<!--{/loop}-->
<!--{if !empty($pricount)}-->
<li class="reply_list_item cl">{lang hide_portal_comment}</li>
<!--{/if}-->
</ul>	
</div>
</div>

<div class="reply_area">
<div class="plc cl">
  <!--{if !$data[htmlmade]}-->
<form id="cform" name="cform" action="$form_url" method="post" autocomplete="off">
<span class="avatar">
<!--{if $_G[uid]}-->{avatar($comment[uid],small)}<!--{else}-->{avatar(0,small)}<!--{/if}-->
</span>
<div class="pi">
<ul class="fastpost">
<li><input type="text" name="message" class="input grey" id="message"></li>
<li id="fastpostsubmitline">
<!--{if $secqaacheck || $seccodecheck}-->
    <!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id);"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
    <div class="mtm"><!--{subtemplate common/seccheck}--></div>
<!--{/if}-->
<button type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="true" class="btn" style="width:80px; height:25px; line-height:25px; border-radius:4px;">{lang comment}</button>
</li>
</ul>
</div>
<!--{if !empty($topicid) }-->
<input type="hidden" name="referer" value="$topicurl#comment" />
<input type="hidden" name="topicid" value="$topicid">
<!--{else}-->
<input type="hidden" name="portal_referer" value="$viewurl#comment">
<input type="hidden" name="referer" value="$viewurl#comment" />
<input type="hidden" name="id" value="$data[id]" />
<input type="hidden" name="idtype" value="$data[idtype]" />
<input type="hidden" name="aid" value="$aid">
<!--{/if}-->
<input type="hidden" name="formhash" value="{FORMHASH}">
<input type="hidden" name="replysubmit" value="true">
<input type="hidden" name="commentsubmit" value="true" />
</form>    
 </div>
<!--{/if}-->
</div>


