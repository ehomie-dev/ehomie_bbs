<?php exit;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="{if $_G['setting']['mobile'][mobilecachetime] > 0}{$_G['setting']['mobile'][mobilecachetime]}{else}no-cache{/if}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="{if !empty($metakeywords)}{echo dhtmlspecialchars($metakeywords)}{/if}" />
<meta name="description" content="{if !empty($metadescription)}{echo dhtmlspecialchars($metadescription)} {/if},$_G['setting']['bbname']" />
<!--{if $_G['basescript'] == 'portal'}--><base href="{$_G['siteurl']}" /><!--{/if}-->
<!--{if $_G['cache']['plugin']['xiaoyu_newmitouch']}-->
<!--{eval require './source/plugin/xiaoyu_newmitouch/core.inc.php';}-->
<!--{eval require './source/plugin/xiaoyu_newmitouch/cert.php';}-->
<!--{/if}-->
<!--{eval define('STYLEIMGDIR', $_G[style][styleimgdir]);}-->
<title><!--{if !empty($navtitle)}-->$navtitle - <!--{/if}--><!--{if empty($nobbname)}--> $_G['setting']['bbname'] - <!--{/if}--> {lang waptitle} - Powered by Discuz!</title>
<link rel="stylesheet" href="{STATICURL}image/mobile/style.css" type="text/css" media="all">
<script src="{STATICURL}js/mobile/jquery-1.8.3.min.js?{VERHASH}"></script><!--{eval $th = MD5($_G['siteurl']);}-->
<script type="text/javascript">var STYLEID = '{STYLEID}', STATICURL = '{STATICURL}', IMGDIR = '{IMGDIR}', VERHASH = '{VERHASH}', charset = '{CHARSET}', discuz_uid = '$_G[uid]', cookiepre = '{$_G[config][cookie][cookiepre]}', cookiedomain = '{$_G[config][cookie][cookiedomain]}', cookiepath = '{$_G[config][cookie][cookiepath]}', showusercard = '{$_G[setting][showusercard]}', attackevasive = '{$_G[config][security][attackevasive]}', disallowfloat = '{$_G[setting][disallowfloat]}', creditnotice = '<!--{if $_G['setting']['creditnotice']}-->$_G['setting']['creditnames']<!--{/if}-->', defaultstyle = '$_G[style][defaultextstyle]', REPORTURL = '$_G[currenturl_encode]', SITEURL = '$_G[siteurl]', JSPATH = '$_G[setting][jspath]';</script>
<link rel="stylesheet" type="text/css" href="{STYLEIMGDIR}/xiaoyu.css" />
<script src="{STYLEIMGDIR}/js/page_common.js?{VERHASH}" charset="{CHARSET}"></script>
<!--{if $_G[basescript]=='portal' && CURMODULE !='view'}-->
<style>.bg{ background:#e6e6e6}.xiaoyu_mobile .main{ min-height:0; padding-bottom:0}</style>
<script type="text/javascript" src="{STYLEIMGDIR}/js/xiaoyu_move.js"></script> 
<script type="text/javascript" src="{STYLEIMGDIR}/js/slide.js"></script>
<script type="text/javascript" src="{STYLEIMGDIR}/js/xiaoyutec.js"></script>
<!--{else}-->
<link rel="stylesheet" type="text/css" href="{STYLEIMGDIR}/invitation.css" />
<script type="text/javascript" src="{STYLEIMGDIR}/js/base.js"></script>
<!--{/if}-->
<style>$xiaoyu_setting['setingcss']</style>
</head>

<body id="xiaoyu_bg_{$_G[basescript]}" class="bg xiaoyu_mobile {if CURMODULE=='space' && $_GET[do]=='profile'}pg_ucenter{elseif $show_message}pg_showmessage{else}pg_{CURMODULE}{/if}">
<!--{if $th=$thre}--><script>switchMobile.init()</script> <!--{/if}-->
<!--{if $_G[basescript]=='portal' && CURMODULE !='view'}-->
<div class="main">
<div id="showmenuinfo" class="getup">
<!--{template common/showmenuinfo}-->
<div class="wrap">
    <!--{else}-->
   <div class="main"> 
   <div class="xmcomm_header_wrap"> 
    <div class="xmcomm_header"> 
     <a title="$_G[setting][bbname]" href="./" class="logo">$_G[setting][bbname]</a>
       <div class="head_wrap"> 
        <div class="header wrap_990"> 
         <!--{template common/header_userstatus}-->
        </div> 
       </div> 
     <ul class="header_menu">
      <!--{template common/navlist}-->
    </ul>
	</div>
   </div> 
   <!--{/if}-->
<!-- header end -->
