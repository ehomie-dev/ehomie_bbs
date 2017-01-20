<?php exit;?>
<li {if $_G[basescript]=='portal' && CURMODULE!='guide'}class="current"{/if}><a href="portal.php?mod=mobile&mobile=2"><i class="icon icon-home"></i>门户</a></li>
<li {if $_G[basescript]=='forum' && CURMODULE!='guide'}class="current"{/if}><a href="forum.php?forumlist=1"><i class="icon icon-bbs"></i>论坛</a></li>
<li {if CURMODULE=='guide'}class="current"{/if}><a href="forum.php?mod=guide"><i class="icon icon-fav"></i>导读</a></li>
<!--{if $_G[basescript] !='portal'}-->
<!--{eval require STYLEIMGDIR.'/index.php';}-->
<!--{if $cat['catid'] > 0}-->
<li>
<span>频道</span>
<div class="header_menu_list" style="display: none;">
<h4>相关分类</h4>
<ul>
<!--{loop $xiaoyu_category $cat}--> 
<li><a href="portal.php?mod=list&catid={$cat['catid']}&mobile=2">$cat['catname']</a></li> 
<!--{/loop}-->
</ul>
</div>
</li>
<!--{/if}-->
<!--{/if}-->
<!--{if CURMODULE =='view'}-->
<!--{eval require STYLEIMGDIR.'/index.php';}-->
<!--{if $cat['catid'] > 0}-->
<li>
<span>频道</span>
<div class="header_menu_list" style="display: none;">
<h4>相关分类</h4>
<ul>
<!--{loop $xiaoyu_category $cat}--> 
<li><a href="portal.php?mod=list&catid={$cat['catid']}&mobile=2">$cat['catname']</a></li> 
<!--{/loop}-->
</ul>
</div>
</li>
<!--{/if}-->
<!--{/if}-->
<li {if $_G[basescript]=='search'}class="current"{/if}><a href="search.php?mod=forum"><i class="icon icon-hd"></i>{lang search}</a></li>

