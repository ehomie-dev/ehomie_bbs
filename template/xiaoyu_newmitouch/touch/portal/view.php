<?php exit;?>
<!--{template common/header}-->
<div class="container_wrap wrap_990 cl"> 
    <div class="plateinfor cl"> 
     <a href="portal.php?mod=list&catid=$article[catid]" class="platename">$cat[catname] <span style="color:#8c8c8c">&rsaquo;{lang view_content}</span></a> <!--{if $article['allowcomment']==1}-->
     <a id="replyid" onclick="location.href=location.href.replace(/(\#.*)/, '')+'#cform';$('message').focus();return false;" class="btn sendtheme">{lang post_comment}</a><!--{/if}-->
    </div> 
<!-- header start -->
  
<div class="contain_right cl fl">

<div class="filtrate invitation"> 
      <div class="invitation_con"> 
        
       <h1> <span></span> <span></span> <span class="name">$article[title]</span> </h1> 
       <p class="txt"> <span class="user_msg_mobile"> <a class="user_name" href="home.php?mod=space&uid=$article[uid]">$article[username]</a></span><span class="time">$article[dateline]</span> <span class="f_r"><i class="msg"></i>{lang view_comments}: <!--{if $article[commentnum] > 0}-->$article[commentnum]<!--{else}-->0<!--{/if}--></span> <span class="f_r"><i class="see"></i><!--{if $article[viewnum] > 0}-->$article[viewnum]<!--{else}-->0<!--{/if}--></span> </p> 
       <div class="invitation_content"> $content[content]</div> 
      </div> 
     </div>
     
     



   <!--{if $article['allowcomment']==1}-->
    <!--{eval $data = &$article}-->
    <!--{subtemplate portal/portal_comment}-->
  <!--{/if}-->


</div>


  

<div class="postlist"> 
   
   <!--{if $article['related']}-->
  <div class="xiaoyu_bm">
    <h3>{lang view_related}</h3>
    <div class="xiaoyu_bm_c">
      <ul class="xiaoyu_sublist">
      <!--{loop $article['related'] $raid $rvalue}-->
        <input type="hidden" value="$raid" />
        <li>&bull; <a href="{$rvalue[uri]}">{$rvalue[title]}</a></li>
      <!--{/loop}-->
      </ul>
    </div>
  </div>
  <!--{/if}-->		
 


  </div>
</div>
</div>
</div>
<!--{template common/footer}-->
