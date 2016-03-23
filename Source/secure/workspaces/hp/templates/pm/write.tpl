{include file="pm/pm_header.tpl"}
<br>
{include file="devs/message.tpl"}

{if !($pm_sent) }
	<form name="f" action='{$url_file}page={$url_page}&a=send' method=POST>
		<table border="0" cellpadding="4" cellspacing="1" align="center" bgcolor="{#clr_content_rel_border#}" width="100%">
		 <tr><td align="center"><b>{$LNG_BASIC.c4915}</b></td></tr>
		 <tr bgcolor="{#clr_content#}"><td>
		 
		<table border=0 width="100%">
		 <tr>
		 	<td width="15%"><b>{$LNG_BASIC.c4916}:</b></td>
		 	<td><input type=tect style="width:50%;" class="egl_text" name="pm_receiver" value="{$pm_last_input.pm_receiver}">
		 	</td>
		 </tr>
		 <tr>
		 	<td><b>{$LNG_BASIC.c4906}:</b></td>
		 	{if isset($pm_re_title)}
			 	<td><input type=text style="width:100%;" class="egl_text" size="50" name="pm_title" value="{lng_parser content=$LNG_BASIC.c4918 old_title=$pm_re_title}"></td>
			 {else}
			 	<td><input type=text style="width:100%;" class="egl_text" size="50" name="pm_title" value="{$pm_last_input.pm_title}"></td>
			 {/if}
		 </tr>
		<tr>
		 	<td valign="top"><b>{$LNG_BASIC.c4917}:</b></td>
		 	<td><textarea class="egl_textbox" name="pm_text" style="width:100%;" rows="20">{$pm_last_input.pm_text}</textarea></td>
		 </tr>
		 <tr>
		 	<td> </td>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
		 </tr>
		</table>
		
	</td></tr>
	</table>
	</form>
{/if}