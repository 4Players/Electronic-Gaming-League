<h2>{lng_parser content=$LNG_BASIC.c5004 rights=$clan_first_permission->name}</h2>
{include file="devs/message.tpl"}

{if !$quit && !$success}
	<br/>
	<form name="fleader" action="{$url_file}page={$url_page}&clan_id={$clan->id}&member_id={$member_details->id}&a=go&key={$key}" method="post">
	<table border="0" cellpadding="5" cellspacing="1" align="center" width="400" bgcolor="{#clr_content_border#}">
	 <tr bgcolor="{#clr_content#}">
	 	<td<b>{$LNG_BASIC.c1012}:</b></td>
	 	<td<b>{$clan->name|stripslashes|strip_tags}</b>  </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td><b>{$LNG_BASIC.c5005}:</b> </td>
	 	<td><b>{$member_details->nick_name|strip_tags|stripslashes}</b>  </td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td><b>{$LNG_BASIC.c5006}:</b></td>
	 	<td> <select name="setleader_new_permission" class="egl_select" style="width:200">
	 			{section name=p loop=$cpt}
	 				<option value="{$cpt[p]->const}">{$cpt[p]->name}</option>
	 			{/section}
	 		</select>
	 	</td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td width="35%"><b>{$LNG_BASIC.c5007}:</b> </td>
	 	<td><font size=3 color="#A80000"><b>{$key}</b></font></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td><b>{$LNG_BASIC.c5008}:</b></td>
	 	<td><input type="text" class="egl_text" name="setleader_key"/></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td></td>
	 	<td><input type="checkbox" class="egl_checkbox" value="yes" name="setleader_check"/><b>{$LNG_BASIC.c1208}</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td></td>
	 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.fleader.submit();"}</td>
	 </tr>
	</table>
	
	</form>
{/if}