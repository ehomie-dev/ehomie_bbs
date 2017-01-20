<?php exit;?>
<!--{eval $_G['home_tpl_titles'] = array('{lang pm}');}-->
<!--{template common/header}-->
<div class="container_wrap wrap_990 cl contain_plate">
<div class="contain_right cl fl">
<div class="theme">
<div class="theme_con">
<!--{if in_array($filter, array('privatepm')) || in_array($_GET[subop], array('view'))}-->

	<!--{if in_array($filter, array('privatepm'))}-->   

<div class="theme_nav">
<a class="theme_nav_list current" >{lang pm_center}</a>
<a class="btn theme_nav_btn" href="home.php?mod=spacecp&ac=pm">{lang send_pm}</a>
</div>
	<!-- main pmlist start -->
    <ul class="themelistcon cl">
    <!--{loop $list $key $value}-->
        <li class="theme_list cl"> 
            <div class="theme_list_img">
            <a target="_blank" class="headportrait" href="home.php?mod=space&uid=$value[authorid]&mobile=2">
            <img src="<!--{if $value[pmtype] == 2}-->{STATICURL}image/common/grouppm.png<!--{else}--><!--{avatar($value[touid] ? $value[touid] : ($value[lastauthorid] ? $value[lastauthorid] : $value[authorid]), small, true)}--><!--{/if}-->" /> 
            </div> 
            <div class="theme_list_con"> 
            <div class="title"> <a href="{if $value[touid]}home.php?mod=space&do=pm&subop=view&touid=$value[touid]{else}home.php?mod=space&do=pm&subop=view&plid={$value['plid']}&type=1{/if}" class="title_name title_bold ">
            <!--{if $value[touid]}-->
            <!--{if $value[msgfromid] == $_G[uid]}-->
            <span class="name">{lang me}{lang you_to} {$value[tousername]}{lang say}:</span>
            <!--{else}-->
            <span class="name">{$value[tousername]} {lang you_to}{lang me}{lang say}:</span>
            <!--{/if}-->
            <!--{elseif $value['pmtype'] == 2}-->
            <span class="name">{lang chatpm_author}:$value['firstauthor']</span>
            <!--{/if}-->
            </a> 
            </div> 
            <div class="auth_msg cl"> 
            <a target="_blank" class="user_name"><!--{date($value[dateline], 'u')}--></a>
            <span class="time txt"> <!--{if $value['pmtype'] == 2}-->[{lang chatpm}]<!--{if $value[subject]}-->$value[subject]<br><!--{/if}--><!--{/if}--><!--{if $value['pmtype'] == 2 && $value['lastauthor']}--><div style="padding:0 0 0 20px;">......<br>$value['lastauthor'] : $value[message]</div><!--{else}-->$value[message]<!--{/if}--></span>
            
            <span class="numb xnews"><!--{if $value[new]}--><i></i>$value[pmnum]<!--{/if}--></span> 
            </div> 
            </div>
        </li>
    <!--{/loop}-->
    </ul>
	<!-- main pmlist end -->

	<!--{elseif in_array($_GET[subop], array('view'))}-->
	<!-- header start -->
    <div class="theme_nav">
    <a class="theme_nav_list current" href="home.php?mod=space&do=pm"><img src="{STATICURL}image/mobile/images/icon_back.png" style="float:left" />{lang viewmypm}</a>
    </div>
	<!-- header end -->
	<!-- main viewmsg_box start -->
	<div class="wp xiaoyu_space_box">
		<div class="msgbox b_m">
			<!--{if !$list}-->
				{lang no_corresponding_pm}
			<!--{else}-->
				<!--{loop $list $key $value}-->
					<!--{subtemplate home/space_pm_node}-->
				<!--{/loop}-->
				$multi
			<!--{/if}-->
		</div>
		<!--{if $list}-->
            <form id="pmform" class="pmform" name="pmform" method="post" action="home.php?mod=spacecp&ac=pm&op=send&pmid=$pmid&daterange=$daterange&pmsubmit=yes&mobile=2" >
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<!--{if !$touid}-->
			<input type="hidden" name="plid" value="$plid" />
			<!--{else}-->
			<input type="hidden" name="touid" value="$touid" />
			<!--{/if}-->
			<div class="space_reply b_m"><input type="text" value="" class="px" autocomplete="off" id="replymessage" name="message"></div>
			<div class="space_reply b_m"><input type="button" name="pmsubmit" id="pmsubmit" class="formdialog button2" value="{lang reply}" /></div>
            </form>

		<!--{/if}-->
	</div>
	<!-- main viewmsg_box end -->

	<!--{/if}-->

<!--{else}-->
	<div class="bm_c">
		{lang user_mobile_pm_error}
	</div>
<!--{/if}-->
</div>
</div>
</div>
</div>
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->

