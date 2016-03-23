<h2>{$LNG_BASIC.c2100}</h2>

{include file="devs/message.tpl"}
{if !$success && $member_details}
	<form name="f" method="POST" action="{$url_file}page={$url_page}&member_id={$member_details->id}&a=go">
		<table border="0" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="100%" align="center">
		 <tr bgcolor="{#clr_content#}">
			<td width="200"><b>{$LNG_BASIC.c2101}:</b></td>
			<td><a href="{$url_file}page=member.info&member_id={$member_details->id}"><b>{$member_details->nick_name|strip_tags}</b></a></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
			<td><b>{$LNG_BASIC.c2102}:</b></td>
			<td><input type="text" style="width:100%;" class="egl_text" name="email_subject" size="40" value="{$_post.email_subject}"></a></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
			<td valign="top" width="30%"><b>{$LNG_BASIC.c2103}:</b></td>
			<td><textarea class="egl_textbox" style="width:100%;" name="email_text" rows="15">{$_post.email_text}</textarea></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td></td>
		 	<td>{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();" color=$GLOBAL_COLOR}</td>
		 </tr>
		</table>
	</form>
{else}
	<!--# <meta http-equiv="refresh" content="2; url={$url_file}page=home"> #-->
{/if}