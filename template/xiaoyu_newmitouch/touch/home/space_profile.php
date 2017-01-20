<?php exit;?>
<!--{if $_GET['mycenter'] && !$_G['uid']}-->
<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
<!--{/if}-->
<!--{template common/header}-->
<link rel="stylesheet" href="{STYLEIMGDIR}/home.css" type="text/css" media="all">
<!-- header start -->

 
<header class="header" style="display:none">

 <!--{if $_G['setting']['domain']['app']['mobile']}-->
    {eval $nav = 'http://'.$_G['setting']['domain']['app']['mobile'];}
  <!--{else}-->
    {eval $nav = "forum.php";}
  <!--{/if}-->
  <div class="nav">
<div class="header-tit category">
<span class="name"><!--{if $_G['uid'] == $space['uid']}-->{lang myprofile}<!--{else}-->$space[username]{lang otherprofile}<!--{/if}--></span>
		 <div class="header-nav">
<a class="header-btn" href="javascript:;" onclick="history.go(-1);" >
<i class="icon icon-back"></i>
</a>
</div>
</header>

<!-- header end -->
<!-- userinfo start -->



  <div class="container_wrap wrap_990 clearfix"> 
   <div class="person_wrap"> 
    <div class="user clearfix"> 
     <div class="avatar"> 
      <img src="<!--{avatar($space[uid], middle, true)}-->" />
     </div> 
     <div class="info"> 
      <strong class="username">$space[username]</strong>
      <strong class="username"></strong>
      <strong class="username"></strong>
     </div> 
     <div class="score"> 
      <dl style="border:none"> 
       <dt> 
        <span class="txt">$space[credits]</span> 
       </dt> 
       <dd>
        {lang credits} 
       </dd> 
      </dl> 
      <dl> 
       <dt> 
        <span class="txt">$space[threads]</span> 
       </dt> 
       <dd>
        {lang threads_num}
       </dd> 
      </dl> 
      <dl> 
       <dt> 
        <span class="txt">$space[posts]</span> 
       </dt> 
       <dd>
        {lang replay_num}
       </dd> 
      </dl> 
       
     </div> 
    </div> 
    <div class="contain_right"> 
     <div class="session "> 
      <div class="wrap"> 
       <h2>个人资料</h2> 
       <ul class="msg clearfix"> 
        <li> <span class="name">ID:</span> <span class="num">$space[uid]</span> </li> 
        <li> <span class="name">{lang usergroup}:</span> <span class="num">{$space[group][grouptitle]}{$space[group][icon]}</span> </li>
        <!--{loop $_G[setting][extcredits] $key $value}-->
    <!--{if $value[title]}-->
     <li><span class="name">$value[title] : </span> <span class="num">{$space["extcredits$key"]} $value[unit]</span> </li>
    <!--{/if}-->
    <!--{/loop}-->
       </ul> 
      </div> 
       
      <div class="wrap lively"> 
       <h2>活跃概况</h2> 
       <ul class="clearfix">
        
        <li><span class="name">{lang threads_num}</span><span class="num">$space[threads]</span></li>
        <li><span class="name">{lang replay_num}</span><span class="num">$space[posts]</span></li>
        <li><span class="name">{lang friends_num}</span><span class="num"> $space[friends]</span></li>        
        <li><span class="name">{lang doings_num}</span><span class="num">$space[doings]</span></li>            

        
        
       </ul> 
       <dl>        
        <!--{if $space[extgroupids]}-->
        <dd>{lang group_expiry_type_ext} : <span>$space[extgroupids]</span></dd>
        <!--{/if}-->
        <dd>{lang blogs_num}<span>$space[blogs]</span></dd>
        <dd>{lang albums_num}<span>$space[albums]</span></dd>
        <dd>{lang online_time} : <span>$space[oltime] {lang hours}</span></dd>
        <dd>{lang regdate} : <span>$space[regdate]</span></dd>        
       </dl> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div>
<!-- userinfo end -->

                                           
<!--{template common/footer}-->

