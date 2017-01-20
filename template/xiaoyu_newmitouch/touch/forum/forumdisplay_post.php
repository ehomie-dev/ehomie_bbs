<?php exit;?>
<div class="$discuz_touchskin[4] {if $post[first]}$discuz_touchskin[6]{/if} {if !$post[first]}$discuz_touchskin[5]{/if} cl">
<!--{if !$post[first]}-->
  <div class="xiaoyu_postav">
    <a href="home.php?mod=space&uid=$post[authorid]">{avatar($post[authorid],middle)}</a>
  </div>
<!--{/if}-->
  <div $discuz_touchskin[3] >
    <!--{if !$post[first]}-->
    <div class="xiaoyu_postuser cl">
      <div class="y">
        <!--{if isset($post[isstick])}-->
        <img src ="{IMGDIR}/settop.png" title="{lang replystick}" class="vm" /> {lang from} {$post[number]}{$postnostick}
        <!--{elseif $post[number] == -1}-->
        {lang recommend_post}
        <!--{else}-->
        <!--{if !empty($postno[$post[number]])}-->$postno[$post[number]]<!--{else}-->{$post[number]}{$postno[0]}<!--{/if}-->
        <!--{/if}-->
      </div>
      <div class="z">
        <!--{if $post['authorid'] && $post['username'] && !$post['anonymous']}-->
        <a href="home.php?mod=space&uid=$post[authorid]">$post[author]</a>
        <!--{else}-->
        <!--{if !$post['authorid']}-->
        <a href="javascript:;">{lang guest}</a><em>$post[useip]{if $post[port]}:$post[port]{/if}</em>
        <!--{elseif $post['authorid'] && $post['username'] && $post['anonymous']}-->
        <!--{if $_G['forum']['ismoderator']}--><a href="home.php?mod=space&uid=$post[authorid]" target="_blank">{lang anonymous}</a><!--{else}-->{lang anonymous}<!--{/if}-->
        <!--{else}-->
        $post[author]<em>{lang member_deleted}</em>
        <!--{/if}-->
        <!--{/if}-->
        <span class="pipe">|</span>$post[dateline]
        <!--{if $_G[uid] && $allowpostreply && !$post[first]}-->
        <span class="pipe">|</span><a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page">{lang reply}</a>
        <!--{/if}-->
        <!--{if $_G['forum']['ismoderator']}-->
        <!-- manage start -->
        <span class="pipe">|</span><a href="#moption_$post[pid]" class="popup">{lang manage}</a>
        <div id="moption_$post[pid]" popup="true" class="manage" style="display:none;">
        <input type="button" value="{lang edit}" class="redirect button" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page">
        <!--{if $_G['group']['allowdelpost']}--><input type="button" value="{lang modmenu_deletepost}" class="dialog button" href="forum.php?mod=topicadmin&action=delpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
        <!--{if $_G['group']['allowbanpost']}--><input type="button" value="{lang modmenu_banpost}" class="dialog button" href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
        <!--{if $_G['group']['allowwarnpost']}--><input type="button" value="{lang modmenu_warn}" class="dialog button" href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
        </div>
        <!-- manage end -->
        <!--{/if}-->
      </div>
    </div>
    <!--{/if}-->
    <div class="message xiaoyu_message"> 
      <!--{if $post['warned']}--> 
      <span class="grey quote">{lang warn_get}</span> 
      <!--{/if}--> 
      <!--{if !$post['first'] && !empty($post[subject])}-->
      <h2><strong>$post[subject]</strong></h2>
      <!--{/if}--> 
      <!--{if $_G['adminid'] != 1 && $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5) || $post['status'] == -1 || $post['memberstatus'])}-->
      <div class="grey quote">{lang message_banned}</div>
      <!--{elseif $_G['adminid'] != 1 && $post['status'] & 1}-->
      <div class="grey quote">{lang message_single_banned}</div>
      <!--{elseif $needhiddenreply}-->
      <div class="grey quote">{lang message_ishidden_hiddenreplies}</div>
      <!--{elseif $post['first'] && $_G['forum_threadpay']}--> 
      <!--{template forum/viewthread_pay}--> 
      <!--{else}--> 
      
      <!--{if $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))}-->
      <div class="grey quote">{lang admin_message_banned}</div>
      <!--{elseif $post['status'] & 1}-->
      <div class="grey quote">{lang admin_message_single_banned}</div>
      <!--{/if}--> 
      <!--{if $_G['forum_thread']['price'] > 0 && $_G['forum_thread']['special'] == 0}--> 
      {lang pay_threads}: <strong>$_G[forum_thread][price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]} </strong> <a href="forum.php?mod=misc&action=viewpayments&tid=$_G[tid]" >{lang pay_view}</a> 
      <!--{/if}--> 
      <!--{if $post['first'] && $threadsortshow}-->
      <!--{if $threadsortshow['optionlist'] && !($post['status'] & 1) && !$_G['forum_threadpay']}--> 
      <!--{if $threadsortshow['optionlist'] == 'expire'}--> 
      {lang has_expired} 
      <!--{else}-->
      <div class="xiaoyu_viewsort">
        <h4>$_G[forum][threadsorts][types][$_G[forum_thread][sortid]]</h4>
        <!--{loop $threadsortshow['optionlist'] $option}--> 
        <!--{if $option['type'] != 'info'}--> 
        <p>$option[title]: <!--{if $option['value']}-->$option[value] $option[unit]<!--{else}--><span class="grey">--</span><!--{/if}--></p>
        <!--{/if}--> 
        <!--{/loop}--> 
      </div>
      <!--{/if}--> 
      <!--{/if}--> 
      <!--{/if}--> 
      <!--{if $post['first']}--> 
      <!--{if !$_G[forum_thread][special]}--> 
      $post[message] 
      <!--{elseif $_G[forum_thread][special] == 1}--> 
      <!--{template forum/viewthread_poll}--> 
      <!--{elseif $_G[forum_thread][special] == 2}--> 
      <!--{template forum/viewthread_trade}--> 
      <!--{elseif $_G[forum_thread][special] == 3}--> 
      <!--{template forum/viewthread_reward}--> 
      <!--{elseif $_G[forum_thread][special] == 4}--> 
      <!--{template forum/viewthread_activity}--> 
      <!--{elseif $_G[forum_thread][special] == 5}--> 
      <!--{template forum/viewthread_debate}--> 
      <!--{elseif $threadplughtml}--> 
      $threadplughtml
      $post[message] 
      <!--{else}--> 
      $post[message] 
      <!--{/if}--> 
      <!--{else}--> 
      $post[message] 
      <!--{/if}--> 
      <!--{/if}--> 
    </div>
    <!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
    <!--{if $post['attachment']}-->
    <div class="grey quote"> {lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em> </div>
    <!--{elseif $post['imagelist'] || $post['attachlist']}--> 
    <!--{if $post['imagelist']}--> 
    <!--{if count($post['imagelist']) == 1}-->
    <div class="xiaoyu_img_one">
      {echo showattach($post, 1)}
    </div>
    <!--{else}-->
    <div class="xiaoyu_img_list cl">
      {echo showattach($post, 1)}
    </div>
    <!--{/if}--> 
    <!--{/if}--> 
    <!--{if $post['attachlist']}-->
    <div>
      {echo showattach($post)}
    </div>
    <!--{/if}--> 
    <!--{/if}--> 
    <!--{/if}--> 
  </div>
</div>


