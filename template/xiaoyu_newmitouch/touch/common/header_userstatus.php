<?php exit;?>
<!--{if $_G['uid']}-->
<div class="user_wrap">
    <div id="login" class="topbar-info J_userInfo ">
        <a class="user cl"><!--{avatar($_G[uid],small)}--><span class="user_name">{$_G[member][username]}</span></a>
        <div class="user_con" style="display: none;">
            <p>{lang credits}: $_G[member][credits]<br>
                {lang usergroup}: $_G[group][grouptitle]<!--{if $_G[member]['freeze']}--><span class="xi1">({lang freeze})</span><!--{/if}-->
            </p>
            
            <div class="cl">
                <a href="home.php?mod=space&do=pm&mobile=2">短{lang pm_center}
              <!--{if $_G[member][newpm]}--><span style="color:#FF0000; display:inline">($_G[member][newpm])</span><!--{/if}--></a>
                <a href="home.php?mod=space&uid=$_G[uid]&do=thread&view=me&from=space">我的帖子</a>
                <a href="home.php?mod=space&do=favorite&view=me">我的收藏</a>
                <a href="home.php?mod=space&uid={$_G[uid]}&do=profile&mycenter=1">个人资料</a>
                <a href="member.php?mod=logging&action=logout&formhash={FORMHASH}">安全{lang logout}</a>
                
            </div>
            
        </div>
    </div>
						
					</div>
<!--{elseif !empty($_G['cookie']['loginuser'])}-->
<p>
	<strong><a id="loginuser" class="noborder"><!--{echo dhtmlspecialchars($_G['cookie']['loginuser'])}--></a></strong>
	<span class="pipe">|</span><a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)">{lang activation}</a>
	<span class="pipe">|</span><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout}</a>
</p>
<!--{elseif !$_G[connectguest]}-->
<div class="user_wrap">
    <div class="topbar-info J_userInfo" id="login">
        <a href="member.php?mod=logging&action=login" class="loginbtn">登 录</a>
        <a href="member.php?mod=register" class="registerbtn">&nbsp;注册</a>
    </div>
</div>	
<!--{else}-->
<div class="user_wrap">
    <div class="topbar-info J_userInfo" id="login">
        <a class="loginbtn">{$_G[member][username]}</a>
        <a href="member.php?mod=logging&action=logout&formhash={FORMHASH}" class="registerbtn">{lang logout}</a>
    </div>
</div>

<!--{/if}-->
