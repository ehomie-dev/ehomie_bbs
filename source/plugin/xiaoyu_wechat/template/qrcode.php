<?php exit;?>
<!--{template common/header}-->
<style>.xiaoyu_qrbox{ border:none}</style>
<!--{if empty($_GET['infloat'])}-->
<div id="pt" class="bm cl">
<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>{lang xiaoyu_wechat:op_qrcode}</div>
</div>
<div id="ct" class="wp cl">
<!--{/if}-->
<div class="bm {if empty($_GET['infloat'])}xiaoyu_bigbox{else}xiaoyu_qrbox{/if}">
<!--{if empty($_GET['infloat'])}-->
<div class="bm_h bbs">
<!--{/if}-->
<h3 {if !empty($_GET['infloat'])}class="flb" style="border-bottom: 1px solid #ddd;"{/if}>
<em id="return_qr">{lang xiaoyu_wechat:op_qrcode}</em>
<!--{if !empty($_GET['infloat'])}-->
<span><a href="javascript:;" class="flbc" onclick="hideWindow('xiaoyu_wechat_qrcode');"  title="{lang close}"></a></span>
<!--{/if}-->
</h3>
<!--{if empty($_GET['infloat'])}-->
</div>
<!--{/if}-->
<div class="cl">
<img src="source/plugin/xiaoyu_wechat/api.php?mod=login&action=qrcode&formhash={FORMHASH}&random={$xiaoyu_random}" height="200" width="200">
</div>
</div>
<!--{if empty($_GET['infloat'])}-->
</div>
<!--{/if}-->
<script language="javascript">
var wechat_checkST=null,wechat_checkCount=0;function xiaoyu_wechat_check(){var x=new Ajax();x.get('plugin.php?id=xiaoyu_wechat:check&inajax=1&ajaxmenu=1&formhash={FORMHASH}&xiaoyu_key=$xiaoyu_keys',function(s){if(s=="ok"){if(wechat_checkST!=null){clearTimeout(wechat_checkST)}location.href=location.href}else if(s=="expire"){hideWindow('xiaoyu_wechat_qrcode')}})}function xiaoyu_time(){if(wechat_checkCount>=30){hideWindow('xiaoyu_wechat_qrcode')}else{xiaoyu_wechat_check();wechat_checkCount++;wechat_checkST=setTimeout(function(){xiaoyu_time()},3000)}}xiaoyu_time();
</script>
<!--{template common/footer}-->