<?php exit;?>
<!--{template common/header}-->
<!--{if $_GET['forumlist'] != 1}-->
	<!--{eval dheader("Location:$indexurl");exit;}-->
<!--{/if}-->

<script type="text/javascript">
	function getvisitclienthref() {
		var visitclienthref = '';
		if(ios) {
			visitclienthref = 'https://itunes.apple.com/cn/app/zhang-shang-lun-tan/id489399408?mt=8';
		} else if(andriod) {
			visitclienthref = 'http://www.discuz.net/mobile.php?platform=android';
		}
		return visitclienthref;
	}
</script>

<!--{if $_GET['visitclient']}-->

<header class="header" style="display:none">
    <div class="nav">
		<span>{lang warmtip}</span>
    </div>
</header>
<div class="cl" style="display:none">
	<div class="clew_con">
		<h2 class="tit">{lang zsltmobileclient}</h2>
		<p>{lang visitbbsanytime}<input class="redirect button" id="visitclientid" type="button" value="{lang clicktodownload}" href="" /></p>
		<h2 class="tit">{lang iphoneandriodmobile}</h2>
		<p>{lang visitwapmobile}<input class="redirect button" type="button" value="{lang clicktovisitwapmobile}" href="$_GET[visitclient]" /></p>
	</div>
</div>
<script type="text/javascript">
	var visitclienthref = getvisitclienthref();
	if(visitclienthref) {
		$('#visitclientid').attr('href', visitclienthref);
	} else {
		window.location.href = '$_GET[visitclient]';
	}
</script>

<!--{else}-->

<!-- header start -->
<!--{if $showvisitclient}-->

<div class="visitclienttip vm" style="display:block;">
	<a href="javascript:;" id="visitclientid" class="btn_download">{lang downloadnow}</a>	
	<p>
		{lang downloadzslttoshareview}
	</p>
</div>
<script type="text/javascript">
	var visitclienthref = getvisitclienthref();
	if(visitclienthref) {
		$('#visitclientid').attr('href', visitclienthref);
		$('.visitclienttip').css('display', 'block');
	}
</script>

<!--{/if}-->


<!-- header end -->
<!--{hook/index_top_mobile}-->
<!-- main forumlist start -->
<div class="container_wrap wrap_990 cl contain_plate xiaoyu_discuz">
	<!--{loop $catlist $key $cat}-->
	<div class="bm bmw fl theme">
		<div class="subforumshow xiaoyu_forum_bk cl" href="#sub_forum_$cat[fid]">
			<span class="o"><img src="{STATICURL}image/mobile/images/collapsed_<!--{if !$_G[setting][mobile][mobileforumview]}-->yes<!--{else}-->no<!--{/if}-->.png"></span>
		<h2><a href="javascript:;">$cat[name]</a></h2>
		</div>
		<div id="sub_forum_$cat[fid]" class="theme_con">
			<ul class="themelistcon cl">
				<!--{loop $cat[forums] $forumid}-->
				<!--{eval $forum=$forumlist[$forumid];}-->
                
                <li class="theme_list cl"> 
                <div class="xiaoyu_bk_img">
         		<!--{if $forum[icon]}-->$forum[icon]<!--{else}--><a href="forum.php?mod=forumdisplay&fid={$forum['fid']}"><img src="template/xiaoyu_newmitouch/touch/style/img/forum_bk.png" /></a><!--{/if}-->
                </div> 
                <div class="theme_list_con" style="margin-left: 60px;"> 
                <div class="title"> 
                <a target="_blank" style="color:#008000" class="title_name title_bold " href="forum.php?mod=forumdisplay&fid={$forum['fid']}">{$forum[name]}</a> 
                </div> 
                <div class="auth_msg cl">
                <!--{if empty($forum[redirect])}-->
                <a target="_blank" class="user_name">主题:<!--{echo dnumber($forum[threads])}--></a> 
                <span class="time txt">贴数:<!--{echo dnumber($forum[posts])}--></span> 
                <span class="comefrom txt"> </span> 
                <!--{/if}-->
                <span class="numb xnews"><!--{if $forum[todayposts] > 0}--><i></i>$forum[todayposts]<!--{/if}--></span> 
                </div> 
                </div>
                </li>
				<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{/loop}-->
</div>
<!-- main forumlist end -->
<!--{hook/index_middle_mobile}-->
<script type="text/javascript">
	(function() {
		<!--{if !$_G[setting][mobile][mobileforumview]}-->
			$('.sub_forum').css('display', 'block');
		<!--{else}-->
			$('.sub_forum').css('display', 'none');
		<!--{/if}-->
		$('.subforumshow').on('click', function() {
			var obj = $(this);
			var subobj = $(obj.attr('href'));
			if(subobj.css('display') == 'none') {
				subobj.css('display', 'block');
				obj.find('img').attr('src', '{STATICURL}image/mobile/images/collapsed_yes.png');
			} else {
				subobj.css('display', 'none');
				obj.find('img').attr('src', '{STATICURL}image/mobile/images/collapsed_no.png');
			}
		});
	 })();
</script>

<!--{/if}-->
<!--{template common/footer}-->

