<?php exit;?>
<li id="pid$post[pid]" class="reply_list_item cl">
         <div class="reply_list_img"> 
          <a target="_blank" class="headportrait" href="home.php?mod=space&uid=$post[authorid]">
          <img src="<!--{if !$post['authorid'] || $post['anonymous']}--><!--{avatar(0, small, true)}--><!--{else}--><!--{avatar($post[authorid], small, true)}--><!--{/if}-->" style="width:35px;height:35px;" />
           </a> 
         </div> 
         <div class="reply_list_con"> 
          <div class="auth_msg cl"> 

        <!--{if $post['authorid'] && $post['username'] && !$post['anonymous']}-->
        <a href="home.php?mod=space&uid=$post[authorid]" class="auth_name">$post[author]</a>
        <!--{if $post[authorid] != $_G[uid] && $_G[uid]}-->
        <a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page" title="{lang reply}" class="auth_name" >{lang reply}</a>
        <!--{/if}-->
        <!--{else}-->
        <!--{if !$post['authorid']}-->
        <a href="javascript:;" class="auth_name">{lang guest} $post[useip]{if $post[port]}:$post[port]{/if}</a>
        <!--{elseif $post['authorid'] && $post['username'] && $post['anonymous']}-->
        <!--{if $_G['forum']['ismoderator']}--><a href="home.php?mod=space&uid=$post[authorid]" target="_blank" class="auth_name">{lang anonymous}</a><!--{else}-->{lang anonymous}<!--{/if}-->
        <!--{else}-->
        $post[author]{lang member_deleted}
        <!--{/if}-->
        <!--{/if}-->
           <span class="at"> 发表于</span> 
           <span class="time">$post[dateline]</span> 
          
           <span class="reply_list_float {if $xiaooyu == 1}shafa{elseif $xiaooyu == 2 }bandeng{elseif $xiaooyu == 3 }diban{/if}">
            <!--{if isset($post[isstick])}-->
            <img src ="{IMGDIR}/settop.png" title="{lang replystick}" class="vm" /> {lang from} {$post[number]}{$postnostick}
            <!--{elseif $post[number] == -1}-->
            {lang recommend_post}
            <!--{else}-->
            <!--{if !empty($postno[$post[number]])}-->$postno[$post[number]]<!--{else}-->{$post[number]}{$postno[0]}<!--{/if}-->
            <!--{/if}-->
            </span> 
          </div> 
          <div class="reply_txt">
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
      
      <!--{if $post['first'] && $threadsort && $threadsortshow && $thr}-->
      <!--{if $threadsortshow['optionlist'] && !($post['status'] & 1) && !$_G['forum_threadpay']}-->
      <!--{if $threadsortshow['optionlist'] == 'expire'}-->
      {lang has_expired}
      <!--{else}-->
      <div class="box_ex2 viewsort">
      <h4>$_G[forum][threadsorts][types][$_G[forum_thread][sortid]]</h4>
      <!--{loop $threadsortshow['optionlist'] $option}-->
      <!--{if $option['type'] != 'info'}-->
          $option[title]: <!--{if $option['value']}-->$option[value] $option[unit]<!--{else}--><span class="xg1">--</span><!--{/if}--><br />
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
        <div class="grey quote">
        {lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em>
        </div>
        <!--{elseif $post['imagelist'] || $post['attachlist']}-->
        <!--{if $post['imagelist']}-->
        <!--{if count($post['imagelist']) == 1}-->
        <ul class="img_one">{echo showattach($post, 1)}</ul>
        <!--{else}-->
        <ul class="img_list cl vm">{echo showattach($post, 1)}</ul>
        <!--{/if}-->
        <!--{/if}-->
        <!--{if $post['attachlist']}-->
        <ul>{echo showattach($post)}</ul>
        <!--{/if}-->
        <!--{/if}-->
        <!--{/if}-->
          <p class="replay_bu">
          <!--{if !$post[first]}-->
			<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page" class="replay_btn">{lang reply}</a>
			<!--{/if}-->
                    
            </p>
        </div>
</li>
<!-- manage end -->
                    
             
         





