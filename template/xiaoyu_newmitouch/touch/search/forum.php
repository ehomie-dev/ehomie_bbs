<?php exit;?>
<!--{template common/header}-->
<div class="container_wrap wrap_990 cl contain_plate">
<div class="contain_right cl fl">
<div class="theme">
<form id="searchform" class="searchform xiaoyusearchform" method="post" autocomplete="off" action="search.php?mod=forum&mobile=2" {if !empty($searchid) && submitcheck('searchsubmit', 1)} style="border-bottom:1px solid #e6e6e6"{/if} >
			<input type="hidden" name="formhash" value="{FORMHASH}" />

			<!--{subtemplate search/pubsearch}-->

			<!--{eval $policymsgs = $p = '';}-->
			<!--{loop $_G['setting']['creditspolicy']['search'] $id $policy}-->
			<!--{block policymsg}--><!--{if $_G['setting']['extcredits'][$id][img]}-->$_G['setting']['extcredits'][$id][img] <!--{/if}-->$_G['setting']['extcredits'][$id][title] $policy $_G['setting']['extcredits'][$id][unit]<!--{/block}-->
			<!--{eval $policymsgs .= $p.$policymsg;$p = ', ';}-->
			<!--{/loop}-->
			<!--{if $policymsgs}--><p>{lang search_credit_msg}</p><!--{/if}-->
</form>
<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
	<!--{subtemplate search/thread_list}-->
<!--{/if}-->
</div>
</div>
</div>
<!--{template common/footer}-->

