<?php exit;?>

<!--{template common/header}-->
<!--{eval $list = array();}-->
<!--{eval $cat['caturl']='portal.php?mod=list&catid='.$cat['catid'].'&mobile=2';}-->
<!--{eval $wheresql = category_get_wheresql($cat);}-->
<!--{eval $list = category_get_list($cat, $wheresql, $page);}-->
<!--{loop $_G['cache']['portalcategory'] $value}-->
<!--{if !$value['closed'] && !$value['disallowpublish']}-->
<!--{eval $cats[$value[catid]]=$value}-->
<!--{/if}-->
<!--{/loop}-->
<!-- header start -->
<header>
<!--{if $_G['setting']['domain']['app']['mobile']}-->
			{eval $nav = 'http://'.$_G['setting']['domain']['app']['mobile'];}
		<!--{else}-->
			{eval $nav = "forum.php";}
		<!--{/if}-->
		 <div class="header-tit">$cat[catname]</div>
		 <a class="header-nav" href="javascript:;" onClick="getnv('showmenuinfo');" id="menu-btn"><i class="icon icon-menu"></i></a>
		 <a class="header-act" href="portal.php?mod=mobile&mobile=2" ><i class="icon icon-send"></i></a>
		
</header>
<nav class="nav"> 
   <div class="nav-container"> 
    <div class="xiaoyu_thread_types"> 
     <ul class="cl"> <li><a href="portal.php?mod=mobile&mobile=2">门户</a></li> 
        <!--{loop $cats $value}-->
        <li {if $_G['catid']==$value['catid']}class="current"{/if}><a href="$value['caturl']">$value['catname']</a></li>
        <!--{/loop}-->
     </ul> 
    </div>
	<a class="nav-arrow nav-arrow-r"></a>
   </div> 
  </nav> 
<!-- header end --> 
<div class="list">  
<div id="xiaoyulist">
   <!--{if $list['list']}--> 
   <!-- more pagelist start --> 
   <!--{loop $list['list'] $value}--> 
   <!--{eval $article_url = fetch_article_url($value);}--> 
   <div id="article">
    <a href="$article_url"><h2> 
      <!--{if $value[pic]}-->
      <!--{eval require STYLEIMGDIR.'/xiaoyupic.php';}-->
	   <img src="{if $value['cover']}$value['cover']{/if}" alt="$value[title]" /> 
      <!--{/if}--><strong> $value[title] 
       <!--{if $value[status] == 1}-->({lang moderate_need})
       <!--{/if}--></strong> </h2> <p> $value[summary] </p> </a> 
    </div>
   <!--{/loop}-->
   <!--{else}--> 
   <div id="article"><a><p>该频道没有文章</p></a></div>
   <!--{/if}-->
   <!-- more pagelist end --> 
</div>
<div id="newlist"></div>
</div>
<!--{if $list['multi']}-->
<!--{eval $nextpage = $page + 1; }-->
<!--{eval $loadpages = @ceil(($list['count'])/$cat['perpage']);}-->
<div id="autopage" class="load_more" style="display:block">
<div id="endlist" style="display:none"> 全部加载完成</div>
<div id="autonext" class="showMore"  style="display:none">正在加载, 请稍后... </div>
<div id="seemore" class="showMore"><a href="$cat['caturl']&page=$nextpage" onclick="return ajaxpage(this.href);">查看更多</a></div>
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
</div>
</div>
</div>
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
