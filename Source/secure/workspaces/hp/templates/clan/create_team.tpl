<h2>{$LNG_BASIC.c4830}</h2>
{include file="devs/message.tpl"}

{if !$success }

<form name="f" action="{$url_file}page={$url_page}&clan_id={$clan->id}&a=go" method="POST">
	<table border="0" cellpadding="5" cellspacing="1" width="400" bgcolor="{#clr_content_border#}" align="center">
	<tr bgcolor="{#clr_content#}"><td align="center"> 
	
		<table border="0" width="100%" cellpadding="5">
		 <tr>
		 	<td> <b>{$LNG_BASIC.c4741}:</b> </td>
		 	<td> <b>{$clan->name|strip_tags}</b> <i>({$clan->tag|strip_tags})</i></td>
		 </tr>
		 <tr>
		 	<td> <b>{$LNG_BASIC.c4831}:</b> </td>
		 	<td><input style="width:100%" type=text class="egl_text" name="team_name"></td>
		 </tr>
		 <tr>
		 	<td> <b>{$LNG_BASIC.c4832}:</b> </td>
		 	<td><input style="width:100%" type=text class="egl_text" name="team_tag"></td>
		 </tr>
		 <tr>
		 	<td></td>
		 	<td>{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c1018 color=$GLOBAL_COLOR link="javascript:document.f.submit();"}</td>
		 </tr>
		 
		</table>
	</td></tr>
	</table>
 </form>
 
 
 {/if}