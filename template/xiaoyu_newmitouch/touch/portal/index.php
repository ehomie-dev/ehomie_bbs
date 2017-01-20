<?php exit;?>
<!--{template common/header}-->
<!--{eval require STYLEIMGDIR.'/index.php';}-->
<!--{eval $list = array();}-->
<!--{eval $cat['caturl']='portal.php?mod=mobile&mobile=2';}-->
<!--{eval $wheresql = category_get_wheresql($xiaaoyucatid);}-->
<!--{eval $list = category_get_list($cat, $wheresql, $page,$xiaoyu_perpage);}-->
<!-- header start -->

<header>
<!--{if $_G['setting']['domain']['app']['mobile']}-->
			{eval $nav = 'http://'.$_G['setting']['domain']['app']['mobile'];}
		<!--{else}-->
			{eval $nav = "forum.php";}
		<!--{/if}-->
		 <div class="header-tit">$_G[setting][bbname]</div>
		 <a class="header-nav" href="javascript:;" onClick="getnv('showmenuinfo');" id="menu-btn"><i class="icon icon-menu"></i></a>
		 <a class="header-act" href="forum.php?forumlist=1&mobile=2" ><i class="icon icon-post"></i></a>
</header>  		
<nav class="nav"> 
   <div class="nav-container"> 
    <div class="xiaoyu_thread_types"> 
     <ul class="cl">
	 <li class="current"><a href="portal.php?mod=mobile&mobile=2">门户</a></li>
     <!--{loop $xiaoyu_category $cat}--> 
      <li><a href="portal.php?mod=list&catid={$cat['catid']}&mobile=2">$cat['catname']</a></li> 
      <!--{/loop}-->
     </ul> 
    </div>
	<a class="nav-arrow nav-arrow-r"></a>
   </div> 
</nav> 
  <div class="list">
   <div id="scrollContainer" class="scroll-wrapper"> 
    <div id="slider" class="swipe" style="visibility: visible;"> 
     <div class="index_focus" id="index_focus"> 
      <div class="focus_pic swipe-wrap"> 
       <ul style="width: 400%; transform: translate(0%, 0px); transition: all 500ms ease 0s;" class="clearbox">
		 $xiaoyu_setting['portalcodeslides']
       </ul> 
      </div>
      <div class="xiaoyu_posi cl">
      <div class="focus_btn"> 
       <ul> 
        <li class="active"> </li> 
        <li> </li> 
        <li> </li> 
        <li> </li> 
       </ul> 
      </div>
      </div>
     </div> 
    </div> 
   </div>
   <div class="hot"><ul>
   <!--{loop $xiaoyu_newmitouch['xiaoyuhotlist'] $thread}-->
   <li><a href="forum.php?mod=viewthread&tid=$thread[tid]">$thread[subject]</a></li>
   <!--{/loop}-->
   </ul>
    <i></i>
    <i></i>
   </div>
   
<div id="xiaoyulist">
<!--{if $xiaoyu_setting['articlemode'] == 2}-->
   <!--{loop $list['list'] $value}--> 
   <div id="article">
    <a href="portal.php?mod=view&aid=$value[aid]&mobile=2"> <h2> 
      <!--{if $value[pic]}-->
      <!--{eval require STYLEIMGDIR.'/xiaoyupic.php';}-->
	   <img src="{if $value['cover']}$value['cover']{/if}" alt="$value[title]" /> 
      <!--{/if}--> <strong> $value[title] </strong> </h2> <p> $value[summary] </p> </a> 
    </div>
   <!--{/loop}-->
   <!--{else}-->
    <!--{loop $xiaoyu_newmitouch['index'] $key $thread}-->
    <!--{eval require_once(DISCUZ_ROOT."./source/function/function_post.php");}-->
    <!--{if $thread['attachment'] == 2}-->
    <!--{eval $table='forum_attachment_'.substr($thread['tid'], -1);}-->
    <!--{eval $thread['aid'] = DB::result_first("SELECT aid FROM ".DB::table($table)." WHERE tid='$thread[tid]' AND isimage!='0'");}-->
    <!--{/if}-->
    <div id="article">
  		 <a href="forum.php?mod=viewthread&tid=$thread[tid]" class="headportrait">
   		 <h2><!--{if $thread['aid']}--><img src="{eval echo(getforumimg($thread['aid'],0,600,218))}"  /><!--{/if}-->
   		 <strong> $thread[subject]</strong></h2><p><!--{echo messagecutstr(DB::result_first('SELECT `message` FROM '.DB::table('forum_post').' WHERE `tid` ='.$thread[tid].' AND `first` =1'),200);}--></p></a>
    </div>
    <!--{/loop}-->
    <!--{/if}-->
</div>
	<div id="newlist"></div>
</div>
<!--{if $list['multi']}-->
<!--{eval $nextpage = $page + 1; }-->
<!--{eval $loadpages = @ceil(($list['count'])/$xiaoyu_perpage);}-->
<div id="autopage" class="load_more" style="display:block">
<div id="endlist" style="display:none"> 全部加载完成</div>
<div id="autonext" class="showMore"  style="display:none">正在加载, 请稍后... </div>
<div id="seemore" class="showMore"><a href="portal.php?mod=mobile&mobile=2&page=$nextpage" onclick="return ajaxpage(this.href);">查看更多</a></div>
</div> 
<script src="{STYLEIMGDIR}/js/autoload.js?{VERHASH}" type="text/javascript"></script>        
<script type="text/javascript">
var pages=$_G['page'];
function ajaxpage(url){
	jq("autonext").style.display='block';
	jq("seemore").style.display='none';
	var x = new Ajax("HTML");
	pages++;
	url=url+'&page='+pages;
	x.get(url, function (s) {
		s = s.replace(/\\n|\\r/g, "");
		s = s.substring(s.indexOf("<div id=\"article\""), s.indexOf("<div id=\"newlist\"></div>"));
		jq('xiaoyulist').innerHTML+=s;
		jq("autonext").style.display='none';
	if(pages== $loadpages ){							
		jq("endlist").style.display='block';
	}else{
		jq("seemore").style.display='block';
	}
	});
	return false;
}
</script>
<!--{/if}-->
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
