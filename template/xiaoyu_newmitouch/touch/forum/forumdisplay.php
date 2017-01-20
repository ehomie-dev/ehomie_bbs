<?php exit;?>
<!--{template common/header}-->
<!--{if $_G['forum'][icon]}-->
<!--{eval $parse = parse_url($_G['forum'][icon]);}-->
<!--{if !isset($parse['host'])}-->
<!--{eval $_G['forum'][icon]=$_G['setting']['attachurl'].'common/'.$_G['forum'][icon];}-->
<!--{/if}-->
<!--{/if}-->
<div class="container_wrap wrap_990 cl contain_plate"> 
    <div class="contain_header"> 
     <div class="wrap">
       <!--{if $_G['forum'][icon]}--><img src="$_G['forum'][icon]" /><!--{else}--><img src="template/xiaoyu_newmitouch/touch/style/img/forumico.jpg" /><!--{/if}-->
     </div> 
     <div class="contain_header_con"> 
      <div > 
      <span class="category xiaoyu_category">
			<!--{if $subexists && $_G['page'] == 1}-->
			<span class="display vm xiaoyu_cater_out cl" href="#subname_list">
				<h2 class="tit"><!--{eval echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];}--></h2>
				<img src="{STATICURL}image/mobile/images/icon_arrow_down.png" style="width:11px; height:7px; margin-left:5px; margin-top:-5px;" />
			</span>
           
			<div id="subname_list" class="subname_list" display="true" style="display:none;">
				<ul>
				<!--{loop $sublist $sub}-->
				<li>
					<a href="forum.php?mod=forumdisplay&fid={$sub[fid]}">{$sub['name']}</a>
				</li>
				<!--{/loop}-->
				</ul>
			</div>
			<!--{else}-->
			<span class="xiaoyu_cater_out">
				<h2><a href="forum.php?mod=forumdisplay&fid=$_G[fid]"><!--{eval echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];}--></a></h2>
			</span>
			<!--{/if}-->
		</span>
        
        
       <!--<a href="forum.php?mod=forumdisplay&fid=$_G[fid]"> <h2><!--{eval echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];}--></h2></a> --> 
       <span class="attention"><a href="home.php?mod=spacecp&ac=favorite&type=forum&id=$_G[fid]&handlekey=favoriteforum&formhash={FORMHASH}">＋收藏</a></span><span class="num">今日:&nbsp; $_G[forum][todayposts]</span> 
       <span class="num">&nbsp; 主题数:&nbsp; $_G[forum][threads]</span>
      </div> 
     </div> 
     <a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" class="btn">+发表新主题</a> 
    </div> 
     
    <div class="contain_right cl fl"> 
     <div class="theme"> 
    <!--{if $_G['forum']['threadtypes']}--><!--小鱼.设计56282.8385 -->
    <div class="filtrate"> 
    <ul class="cl"> 
<li {if !$_GET['filter']}class="a"{/if}><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}"><img src="template/xiaoyu_newmitouch/touch/style/img/Bmh.png" />{lang forum_viewall}</a></li>
    <!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
    <!--{if $_GET['typeid'] == $id}-->
    <li class="current"><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['sortid']}&filter=sortid&sortid=$_GET['sortid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}"><img src="template/xiaoyu_newmitouch/touch/style/img/Bmh.png" />$name</a></li>
    <!--{else}-->
    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}"><img src="template/xiaoyu_newmitouch/touch/style/img/Bmh.png" />$name</a></li>
    <!--{/if}-->
    <!--{/loop}-->
        </ul> 
      </div>
    <!--{/if}-->

      
      <div class="theme_con"> 
       <div class="screen cl"> 
        <div class="dropdown_text_middle alltheme">
         <span data-value="0">全部主题</span>
         <i></i> 
         <ul class="selectlist"> 
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang all}{lang forum_threads}</a></li>
			<!--{if $showpoll}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=poll$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang thread_poll}</a></li><!--{/if}-->
			<!--{if $showtrade}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=trade$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang thread_trade}</a></li><!--{/if}-->
			<!--{if $showreward}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang thread_reward}</a></li><!--{/if}-->
			<!--{if $showactivity}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=activity$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang thread_activity}</a></li><!--{/if}-->
			<!--{if $showdebate}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=debate$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang thread_debate}</a></li><!--{/if}-->
          
         </ul> 
        </div> 
        <div class="dropdown_text_middle alltime">
         <span data-value="0">全部时间</span>
         <i></i> 
         <ul class="selectlist"> 
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if !$_GET['dateline']}class="xw1"{/if}>{lang all}{lang search_any_date}</a></li>
				<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=86400$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '86400'}class="xw1"{/if}>{lang last_1_days}</a></li>
				<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=172800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '172800'}class="xw1"{/if}>{lang last_2_days}</a></li>
				<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=604800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '604800'}class="xw1"{/if}>{lang list_one_week}</a></li>
				<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=2592000$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '2592000'}class="xw1"{/if}>{lang list_one_month}</a></li>
				<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=7948800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '7948800'}class="xw1"{/if}>{lang list_three_month}</a></li>
         </ul> 
        </div> 
        <div class="dropdown_text_middle lastpublish">
         <span data-value="0">默认排序</span>
         <i></i> 
         <ul class="selectlist"> 
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang list_default_sort}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=author&orderby=dateline$forumdisplayadd[author]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang list_post_time}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=replies$forumdisplayadd[reply]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">回复数</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=views$forumdisplayadd[view]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">查看数</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=lastpost&orderby=lastpost$forumdisplayadd[lastpost]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang lastpost}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=heat&orderby=heats$forumdisplayadd[heat]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang order_heats}</a></li>
         </ul> 
        </div> 
        <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=digest&digest=1$forumdisplayadd[digest]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="essence screen_btn {if $_GET['filter'] == 'digest'} visted{/if}">精华</a> 
        <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=lastpost&orderby=lastpost$forumdisplayadd[lastpost]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="screen_btn {if $_GET['filter'] == 'lastpost'} visted{/if} ">最新</a> 
       </div> 
       <!-- main threadlist start -->
<ul class="themelistcon cl"><!--小.鱼.设计56282838.5 -->
		<!--{if $_G['forum_threadcount'] && $thre=$th}-->
		<!--{loop $_G['forum_threadlist'] $key $thread}-->
        <li class="theme_list cl"> 
        <div class="theme_list_img">
        <a href="home.php?mod=space&uid=$thread[authorid]" class="headportrait" target="_blank">
        <!--{avatar($thread[authorid],small)}--></a> 
        </div> 
        <div class="theme_list_con"> 
        <div class="title"> 
        <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra" class="title_name title_bold ">{$thread[subject]}</a> 
        </div> 
        <div class="auth_msg cl"> 
        <a href="home.php?mod=space&uid=$thread[authorid]" class="user_name" target="_blank">$thread[author]</a> 
        <!--{if !empty($verify[$thread['authorid']])}--><i class="vip_icon vip_icon_s "> $verify[$thread[authorid]]</i><!--{/if}-->
        <span class="time txt"> $thread[dateline]</span> 
        <!--{if !$thread['forumstick'] && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
        <!--{if $thread['related_group'] == 0 && $thread['closed'] > 1}-->
        <!--{eval $thread[tid]=$thread[closed];}-->
        <!--{/if}-->
        <!--{if $groupnames[$thread[tid]]}-->
        <a href="forum.php?mod=group&fid={$groupnames[$thread[tid]][fid]}" target="_blank" class="time txt">[{$groupnames[$thread[tid]][name]}]</a>
        <!--{/if}-->
        <!--{/if}-->
        <span class="comefrom txt"> </span> 
        <!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}--><span class="stick txt">&middot;置顶</span><!--{/if}-->
        
        <span class="numb view"><i></i>$thread[views]</span> 
        </div> 
        </div>
        </li> 	
		<!--{/loop}-->
        <!--{else}-->
        <li class="theme_list cl"> {lang forum_nothreads}</li>
        <!--{/if}-->
        </ul>
       

<!-- main threadlist end -->
       
      
       <div class="base_widget_paging"> 
        <div class="paging_widget_2 xiaoyu_forum_list"> 
        $multipage
        </div> 
       </div> 
      </div> 
     </div> 
    </div> 

   </div>
<!-- header start -->
<header class="header" style="display:none">
    <div class="nav">
		<div class="header-tit category">
			<!--{if $subexists && $_G['page'] == 1}-->
					<span class="display name" href="#subname_list">
						<!--{eval echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];}-->
		
					</span>
					<div id="subname_list" class="subname_list" display="true" style="display:none;">
						<ul>
						<!--{loop $sublist $sub}-->
						<li>
							<a href="forum.php?mod=forumdisplay&fid={$sub[fid]}">{$sub['name']}</a>
						</li>
						<!--{/loop}-->
						</ul>
					</div>
					<!--{else}-->
					<span class="name">
						<!--{eval echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];}-->
					</span>
					<!--{/if}-->
		</div>
			<div class="header-nav">
				<a href="forum.php?forumlist=1" class="header-btn">
					<i class="icon icon-back"></i>
				</a>
			</div>
			<div class="header-act">
				<a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" title="{lang send_threads}" class="header-btn"><i class="icon icon-post"></i></a>
			</div>

            </div>
    </header>
<!-- header end -->
  
  <!--{hook/forumdisplay_bottom_mobile}-->
  <div class="pullrefresh" style="display:none;"></div>
</div>
    <script type="text/javascript" src="template/xiaoyu_newmitouch/touch/style/js/plate.js"></script> 
     
<!--{template common/footer}-->

