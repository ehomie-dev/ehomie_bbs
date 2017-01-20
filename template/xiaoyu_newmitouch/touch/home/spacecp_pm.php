<?php exit;?>
<!--{template common/header}-->
<!--{if $op != ''}-->
<div class="bm_c">{lang user_mobile_pm_error}</div>
<!--{else}-->

<form id="pmform_{$pmid}" name="pmform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=send&touid=$touid&pmid=$pmid&mobile=2" >
	<input type="hidden" name="referer" value="{echo dreferer();}" />
	<input type="hidden" name="pmsubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />

<!-- header start -->
<div class="container_wrap wrap_990 cl contain_plate">
<div class="contain_right cl fl">
<div class="theme">
<div class="theme_con">
<div class="theme_nav">
<a class="theme_nav_list current">{lang send_pm}</a>
<input type="hidden" name="pmsubmit_btn" value="yes" />
<button id="pmsubmit_btn" class="btn_pn sendpm_nav_btn btn_pn_grey" disable="true"><span>{lang sendpm}</span></button>
</div>
<!-- header end -->
<!-- main post_msg_box start -->
<div class="wp">
	<div class="post_msg_from">
		<ul class="xiaoyu_senbox cl">
			<!--{if !$touid}-->
			<li class="bl_line"><input type="text" value="" tabindex="1" class="px" size="30" autocomplete="off" id="username" name="username" placeholder="{lang addressee}"></li>
			<!--{/if}-->
			<li class="bl_none area">
				<textarea class="pt" tabindex="2" autocomplete="off" value="" id="sendmessage" name="message" cols="80" rows="7"  placeholder="{lang thread_content}"></textarea>
			</li>
		</ul>
	</div>
</div>

<!-- main postbox start -->
</form>
<script type="text/javascript">
	(function() {
		$('#sendmessage').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
				$('.btn_pn').attr('disable', 'false');
			} else {
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});
		var form = $('#pmform_{$pmid}');
		$('#pmsubmit_btn').on('click', function() {
			var obj = $(this);
			if(obj.attr('disable') == 'true') {
				return false;
			}
			$.ajax({
				type:'POST',
				url:form.attr('action') + '&handlekey='+form.attr('id')+'&inajax=1',
				data:form.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				popup.open(s.lastChild.firstChild.nodeValue);
			})
			.error(function() {
				popup.open('{lang networkerror}', 'alert');
			});
			return false;
			});
	 })();
</script>
<!--{/if}-->
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->

