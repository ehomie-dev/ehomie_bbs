<?php exit;?>
<!--{template common/header}-->

<div class="container_wrap wrap_990 cl">
    <div class="contain_right cl "> 
     <div class="theme"> 
      <div class="theme_con"> 
       <div class="theme_nav"> 
        <a href="forum.php?mod=guide" class="theme_nav_list {if CURMODULE=='guide' && $_GET['show']!='latest'} current {/if}">推荐</a> 
        <a href="forum.php?mod=guide&show=latest" class="theme_nav_list {if CURMODULE=='guide' && $_GET['show'] =='latest'} current{/if}">最新主题</a> 
        <a href="forum.php?forumlist=1&mobile=2" class="btn theme_nav_btn">进入版块</a> 
       </div>
<!-- main threadlist start -->
<!--{if CURMODULE=='guide' && $_GET['show']!='latest'}-->

       <ul class="theme_con_index cl current">
    <!--{loop $xiaoyu_newmitouch['guide'] $key $thread}-->
        <li class="theme_list cl"> 
         <div class="theme_list_img">
          <a href="home.php?mod=space&uid=$thread[authorid]" class="headportrait" target="_blank">
          <!--{avatar($thread[authorid],small)}--></a> 
         </div> 
         <div class="theme_list_con"> 
          <div class="title"> 
           <a href="forum.php?mod=viewthread&tid=$thread[tid]" class="title_name " target="_blank" style="color:#ff0000"> {$thread[subject]}</a>
          </div> 
          <div class="auth_msg cl"> 
           <a href="home.php?mod=space&uid=$thread[authorid]" class="user_name" target="_blank">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--><i class="vip_icon vip_icon_s "> $verify[$thread[authorid]]</i><!--{/if}-->
           <span class="time txt">$thread[dateline]</span> 
           <span class="numb msg"><i></i>$thread[replies]</span> 
           <span class="numb view"><i></i>$thread[views]</span> 
          </div> 
         </div> </li> 
    <!--{/loop}-->
         
       </ul>
       <div class="base_widget_paging"> 
        <div class="paging_widget_2 xiaoyu_forum_list"> 
        $multi 
        </div> 
       </div> 
<!--{elseif CURMODULE=='guide' && $_GET['show']=='latest'}-->

       <ul class="theme_con_index cl current">
   		<!--{loop $xiaoyu_newmitouch['latest'] $key $thread}-->
        <li class="theme_list cl"> 
         <div class="theme_list_img">
          <a href="home.php?mod=space&uid=$thread[authorid]" class="headportrait" target="_blank">
          <!--{avatar($thread[authorid],small)}--></a> 
         </div> 
         <div class="theme_list_con"> 
          <div class="title"> 
           <a href="forum.php?mod=viewthread&tid=$thread[tid]" class="title_name " target="_blank" style="color:#ff0000"> {$thread[subject]}</a>
          </div> 
          <div class="auth_msg cl"> 
           <a href="home.php?mod=space&uid=$thread[authorid]" class="user_name" target="_blank">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--><i class="vip_icon vip_icon_s "> $verify[$thread[authorid]]</i><!--{/if}-->
           <span class="time txt">$thread[dateline]</span> 
           <span class="numb msg"><i></i>$thread[replies]</span> 
           <span class="numb view"><i></i>$thread[views]</span> 
          </div> 
         </div> </li> 
    <!--{/loop}-->
         
       </ul>
       <div class="base_widget_paging"> 
        <div class="paging_widget_2 xiaoyu_forum_list"> 
        $multi 
        </div> 
       </div> 
<!--{/if}-->
<!-- main threadlist end -->

      </div> 
     </div> 
     <script type="text/javascript" src="template/xiaoyu_newmitouch/touch/style/js/personlayer.js"></script> 
    </div> 
    <script type="text/javascript" src="template/xiaoyu_newmitouch/touch/style/js/slide.js"></script> 
   
   </div>

<!--{template common/footer}-->

