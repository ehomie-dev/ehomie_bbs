<?php exit;?>
<!--{eval $threadsort = $threadsorts = null;}-->
<!--{template common/header}-->

<!-- header start -->
<div class="container_wrap wrap_990 cl"> 
    <div class="plateinfor cl"> 
     <a href="forum.php?mod=forumdisplay&fid=$_G[fid]" class="platename"><!--{eval echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];}--></a> 
     <span class="num">今日:&nbsp; $_G[forum][todayposts] </span><span class="num">&nbsp;主题数:&nbsp; $_G[forum][threads]</span>
     <a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" class="btn sendtheme">+ &nbsp;发表新主题</a> 
</div> 
<!-- header end -->

<!--{hook/viewthread_top_mobile}-->
<!-- main postlist start -->
<div class="contain_right cl fl"> 
	<!--{eval $postcount = 0;}-->
    	<!--{loop $postlist $post}-->
    <!--{if $post['first'] && $th=$thre}-->
	<!--{eval $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);}-->
	<!--{hook/viewthread_posttop_mobile $postcount}-->
    
    <div class="invitation" id="pid$post[pid]"> 
      <div class="invitation_con"> 
        
       <h1> <span></span> <span></span> <span class="name">
               	<!--{if $_G['forum_thread']['typeid'] && $_G['forum']['threadtypes']['types'][$_G['forum_thread']['typeid']]}-->
				[{$_G['forum']['threadtypes']['types'][$_G['forum_thread']['typeid']]}]
            <!--{/if}-->
            <!--{if $threadsorts && $_G['forum_thread']['sortid']}-->
                [{$_G['forum']['threadsorts']['types'][$_G['forum_thread']['sortid']]}]
			<!--{/if}-->
			$_G[forum_thread][subject]
            <!--{if $_G['forum_thread'][displayorder] == -2}--> <span>({lang moderating})</span>
            <!--{elseif $_G['forum_thread'][displayorder] == -3}--> <span>({lang have_ignored})</span>
            <!--{elseif $_G['forum_thread'][displayorder] == -4}--> <span>({lang draft})</span>
            <!--{/if}-->
       </span> </h1> 
       <p class="txt"> <span class="user_msg_mobile"><a href="home.php?mod=space&uid=$post[authorid]" class="user_name">$post[author]</a></span><a href="#" order-by="0" class="publish_address"></a> <span class="time">$post[dateline]</span> <span class="f_r"><i class="msg"></i>$_G[forum_thread][allreplies]</span> <span class="f_r"><i class="see"></i>$_G[forum_thread][views]</span> </p> 
       <div class="invitation_content"> 
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
						<!--{template forum/viewthread_pay}--><!--小.鱼.设.计5.62828385 -->
					<!--{else}-->

                    	<!--{if $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))}-->
                            <div class="grey quote">{lang admin_message_banned}</div>
                        <!--{elseif $post['status'] & 1}-->
                            <div class="grey quote">{lang admin_message_single_banned}</div>
                        <!--{/if}-->
                        <!--{if $_G['forum_thread']['price'] > 0 && $_G['forum_thread']['special'] == 0}-->
                            {lang pay_threads}: <strong>$_G[forum_thread][price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]} </strong> <a href="forum.php?mod=misc&action=viewpayments&tid=$_G[tid]" >{lang pay_view}</a>
                        <!--{/if}-->

                        <!--{if $post['first'] && $threadsort && $threadsortshow}-->
                        	<!--{if $threadsortshow['optionlist'] && !($post['status'] & 1) && !$_G['forum_threadpay']}-->
                                <!--{if $threadsortshow['optionlist'] == 'expire'}-->
                                    {lang has_expired}
                                <!--{else}-->
                                    <div class="box_ex2 viewsort">
                                        <h4>$_G[forum][threadsorts][types][$_G[forum_thread][sortid]]</h4>
                                    <!--{loop $threadsortshow['optionlist'] $option}-->
                                        <!--{if $option['type'] != 'info'}-->
                                            $option[title]: <!--{if $option['value']}-->$option[value] $option[unit]<!--{else}--><span class="grey">--</span><!--{/if}--><br />
                                        <!--{/if}-->
                                    <!--{/loop}-->
                                    </div>
                                <!--{/if}-->
                            <!--{/if}-->
                        <!--{/if}-->
                        <!--{if $post['first'] && $thre}-->
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
                            <!--{elseif $threadplughtml}--><!--小鱼.设计5628.28385 -->
                                $threadplughtml
                                $post[message]
                            <!--{else}-->
                            	$post[message]
                            <!--{/if}-->
                        <!--{else}-->
                            $post[message]
                        <!--{/if}-->

					<!--{/if}-->
                    
                <!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
                <!--{if $post['attachment']}-->
                <div class="grey quote">
                {lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em>
                </div>
                <!--{elseif $post['imagelist'] || $post['attachlist']}-->
                <!--{if $post['imagelist']}-->
                <!--{if count($post['imagelist']) == 1}-->
                <ul class="img_one xiaoyu_img_one">{echo showattach($post, 1)}</ul>
                <!--{else}-->
                <ul class="img_list xiaoyu_img_list cl vm">{echo showattach($post, 1)}</ul>
                <!--{/if}-->
                <!--{/if}-->
                <!--{if $post['attachlist']}-->
                <ul>{echo showattach($post)}</ul>
                <!--{/if}-->
                <!--{/if}-->
                <!--{/if}-->
       </div> 
      </div> 
      <div class="btn_wrap cl"> 
       
            		<!--{if $_G['forum']['ismoderator']}-->
					<!-- manage start -->
					<!--{if $post[first]}-->
						<a href="#moption_$post[pid]" class="popup">{lang manage}</a>
						<div id="moption_$post[pid]" popup="true" class="manage" style="display:none;">
							<!--{if !$_G['forum_thread']['special']}-->
							<input type="button" value="{lang edit}" class="redirect button" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]<!--{if $_G[forum_thread][sortid]}--><!--{if $post[first]}-->&sortid={$_G[forum_thread][sortid]}<!--{/if}--><!--{/if}-->{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page">
							<!--{/if}-->
							<input type="button" value="{lang delete}" class="dialog button" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&operation=delete&optgroup=3&from={$_G[tid]}">
							<input type="button" value="{lang close}" class="dialog button" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&from={$_G[tid]}&optgroup=4">
							<input type="button" value="{lang admin_banpost}" class="dialog button" href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">
							<input type="button" value="{lang topicadmin_warn_add}" class="dialog button" href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">
						</div>
					<!--{else}-->
						<a href="#moption_$post[pid]" class="popup">{lang manage}</a>
						<div id="moption_$post[pid]" popup="true" class="manage" style="display:none;">
							<input type="button" value="{lang edit}" class="redirect button" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page">
							<!--{if $_G['group']['allowdelpost']}--><input type="button" value="{lang modmenu_deletepost}" class="dialog button" href="forum.php?mod=topicadmin&action=delpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
							<!--{if $_G['group']['allowbanpost']}--><input type="button" value="{lang modmenu_banpost}" class="dialog button" href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
							<!--{if $_G['group']['allowwarnpost']}--><input type="button" value="{lang modmenu_warn}" class="dialog button" href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
						</div>
					<!--{/if}-->
					<!-- manage end -->
					<!--{/if}-->
                        <a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$_G[tid]" class="favbtn collect_btn" <!--{if $_G[forum][ismoderator]}-->style="margin-right:10px;"<!--{/if}-->>{lang favorite}</a>
       			<!--{if !IS_ROBOT && !$_GET['authorid'] && !$_G['forum_thread']['archiveid']}-->
				<a href="forum.php?mod=viewthread&tid=$_G[tid]&page=$page&authorid=$_G[forum_thread][authorid]" rel="nofollow" >{lang viewonlyauthorid}</a>
			<!--{elseif !$_G['forum_thread']['archiveid']}-->
				<a href="forum.php?mod=viewthread&tid=$_G[tid]&page=$page" rel="nofollow">{lang thread_show_all}</a>
			<!--{/if}-->
      </div> 
     </div>

   
   <!--{/if}-->
   <!--{hook/viewthread_postbottom_mobile $postcount}-->
   <!--{eval $postcount++;}-->
   <!--{/loop}-->
 
      <div class="reply" id="comment_top">
      
      <div class="reply_con"> 
       <div class="reply_title cl">
        <h3>精彩评论</h3> 
        <span class="replay_num">$_G[forum_thread][allreplies]</span> 
        <div class="nonstop"><a href="forum.php?mod=viewthread&tid=$_G[tid]&ordertype={if $ordertype != 1}1{else}2{/if}" rel="nofollow"><!--{if $ordertype != 1}-->倒序浏览<!--{else}-->正序浏览<!--{/if}--></a>
        </div> 
       </div><!--{if $_G[forum_thread][allreplies]}-->
       <!--{/if}-->
       <ul class="reply_list cl">
    <!--{eval $xiaooyu=0;}-->  
	<!--{loop $postlist $post}-->
    <!--{if !$post['first']}-->
	<!--{eval $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);}-->
	<!--{hook/viewthread_posttop_mobile $postcount}-->
    <li class="reply_list_item cl" id="pid$post[pid]"> 
         <div class="reply_list_img"> 
          <a href="home.php?mod=space&uid=$post[authorid]" class="headportrait" target="_blank">
          <img src="<!--{if !$post['authorid'] || $post['anonymous']}--><!--{avatar(0, small, true)}--><!--{else}--><!--{avatar($post[authorid], small, true)}--><!--{/if}-->" style="width:35px;height:35px;" />
           </a> 
         </div> 
         <div class="reply_list_con"> 
          <div class="auth_msg cl"> 
			<!--{if $post['authorid'] && $post['username'] && !$post['anonymous']}-->
						<a href="home.php?mod=space&uid=$post[authorid]" class="auth_name">$post[author]</a>
					<!--{else}-->
						<!--{if !$post['authorid']}-->
						<a href="javascript:;" class="auth_name">{lang guest} <em>$post[useip]{if $post[port]}:$post[port]{/if}</em></a>
						<!--{elseif $post['authorid'] && $post['username'] && $post['anonymous']}-->
						<!--{if $_G['forum']['ismoderator']}--><a href="home.php?mod=space&uid=$post[authorid]" target="_blank" class="auth_name">{lang anonymous}</a><!--{else}-->{lang anonymous}<!--{/if}-->
						<!--{else}-->
						$post[author] <em>{lang member_deleted}</em>
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

                        <!--{if $post['first'] && $threadsort && $threadsortshow}-->
                        	<!--{if $threadsortshow['optionlist'] && !($post['status'] & 1) && !$_G['forum_threadpay']}-->
                                <!--{if $threadsortshow['optionlist'] == 'expire'}-->
                                    {lang has_expired}
                                <!--{else}-->
                                    <div class="box_ex2 viewsort">
                                        <h4>$_G[forum][threadsorts][types][$_G[forum_thread][sortid]]</h4>
                                    <!--{loop $threadsortshow['optionlist'] $option}-->
                                        <!--{if $option['type'] != 'info'}-->
                                            $option[title]: <!--{if $option['value']}-->$option[value] $option[unit]<!--{else}--><span class="grey">--</span><!--{/if}--><br />
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
                          <!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
                <!--{if $post['attachment']}-->
                <div class="grey quote">
                {lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em>
                </div>
                <!--{elseif $post['imagelist'] || $post['attachlist']}-->
                <!--{if $post['imagelist']}-->
                <!--{if count($post['imagelist']) == 1}-->
                <ul class="img_one xiaoyu_img_one">{echo showattach($post, 1)}</ul>
                <!--{else}-->
                <ul class="img_list xiaoyu_img_list cl vm">{echo showattach($post, 1)}</ul>
                <!--{/if}-->
                <!--{/if}-->
                <!--{if $post['attachlist']}-->
                <ul>{echo showattach($post)}</ul>
                <!--{/if}-->
                <!--{/if}-->
                <!--{/if}-->
          
          </div> 
          <p class="replay_bu">
          <!--{if !$post[first]}-->
			<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page" class="replay_btn">{lang reply}</a>
			<!--{/if}-->
            		<!--{if $_G['forum']['ismoderator']}-->
					<!-- manage start -->
					<!--{if $post[first]}-->
						<a href="#moption_$post[pid]" class="popup replay_btn">{lang manage}</a>
						<div id="moption_$post[pid]" popup="true" class="manage" style="display:none;">
							<!--{if !$_G['forum_thread']['special']}-->
							<input type="button" value="{lang edit}" class="redirect button" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]<!--{if $_G[forum_thread][sortid]}--><!--{if $post[first]}-->&sortid={$_G[forum_thread][sortid]}<!--{/if}--><!--{/if}-->{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page">
							<!--{/if}-->
							<input type="button" value="{lang delete}" class="dialog button" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&operation=delete&optgroup=3&from={$_G[tid]}">
							<input type="button" value="{lang close}" class="dialog button" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&from={$_G[tid]}&optgroup=4">
							<input type="button" value="{lang admin_banpost}" class="dialog button" href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">
							<input type="button" value="{lang topicadmin_warn_add}" class="dialog button" href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">
						</div>
					<!--{else}-->
						<a href="#moption_$post[pid]" class="popup replay_btn">{lang manage}</a>
						<div id="moption_$post[pid]" popup="true" class="manage" style="display:none;">
							<input type="button" value="{lang edit}" class="redirect button" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page">
							<!--{if $_G['group']['allowdelpost']}--><input type="button" value="{lang modmenu_deletepost}" class="dialog button" href="forum.php?mod=topicadmin&action=delpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
							<!--{if $_G['group']['allowbanpost']}--><input type="button" value="{lang modmenu_banpost}" class="dialog button" href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
							<!--{if $_G['group']['allowwarnpost']}--><input type="button" value="{lang modmenu_warn}" class="dialog button" href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}"><!--{/if}-->
						</div>
					<!--{/if}-->
					<!-- manage end -->
					<!--{/if}-->
                    
            </p> 
         </div> </li>

         
   
   <!--{/if}-->
   <!--{hook/viewthread_postbottom_mobile $postcount}-->
   <!--{eval $xiaooyu++;}-->
   <!--{eval $postcount++;}-->
   <!--{/loop}-->
   <div id="post_new"></div>
         </ul>
         </div>
<div class="base_widget_paging"> 
<div class="paging_widget_2"> 
$multipage
</div>
</div>

         </div>
    <div class="reply_area">
	<!--{subtemplate forum/forumdisplay_fastpost}-->
    </div>

</div>
<!-- main postlist end -->
</div>
<!--{hook/viewthread_bottom_mobile}-->

<script type="text/javascript">
	$('.favbtn').on('click', function() {
		var obj = $(this);
		$.ajax({
			type:'POST',
			url:obj.attr('href') + '&handlekey=favbtn&inajax=1',
			data:{'favoritesubmit':'true', 'formhash':'{FORMHASH}'},
			dataType:'xml',
		})
		.success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		})
		.error(function() {
			window.location.href = obj.attr('href');
			popup.close();
		});
		return false;
	});
</script>

<a href="javascript:;" title="{lang scrolltop}" class="scrolltop bottom"></a>
<!--{template common/footer}-->

