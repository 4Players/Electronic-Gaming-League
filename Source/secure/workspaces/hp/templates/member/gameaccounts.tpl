<h2>{$LNG_BASIC.c4530}</h2>
{include file="devs/message.tpl"}

{if !$success}
<form name="f" enctype="multipart/form-data" action="{$url_file}page={$url_page}&a=go" method="post" >

<table border="0" cellpadding="8" cellspacing="1" align="center" width="400" bgcolor="{#clr_content_border#}">
 <tr bgcolor="{#clr_content#}">
 	<td width="35%"><b>{$LNG_BASIC.c4529}:</b></td>
 	<td><select style="width:100%;" name="gameacc_type" class="egl_select">
 		{section name=acctype loop=$gameaccounts}
 			<option value="{$gameaccounts[acctype]->id}">{$gameaccounts[acctype]->name|strip_tags}</option>
 		{/section}
 		</select>
 		</td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td><b>{$LNG_BASIC.c4532}:</b></td>
 	<td><input type="text" style="width:100%;" class="egl_text" name="gameacc_value" size="30" value=""/></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td></td>
 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
 </tr>
</table>

<br>

<table border="0" cellpadding="0" cellspacing="1" width="400" align="center" bgcolor="#A80000">
 <tr><td>
	<table border="0" cellpadding="8" cellspacing="1" align="center" width="100%" bgcolor="{#clr_content_border#}">
	 <tr>
	 	<td colspan="2"><b>{$LNG_BASIC.c4533}:</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td valign="top"><b>{$LNG_BASIC.c4534}:</b></td>
	 	<td><textarea class="egl_textbox" name="gameacc_text" rows="10" cols="40"></textarea></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td width="35%" valign="top"><b>{$LNG_BASIC.c4535}:</b></td>
	 	<td><input type="checkbox" class="egl_checkbox" name="gameacc_activate_media" value="accept"/> <b>{$LNG_BASIC.c4536}</b> <br><br>
			<input type="file" class="egl_text" name="gameacc_media_file"/>
	 		</td>
	 </tr>
 	<tr bgcolor="{#clr_content#}">
 		<td></td>
 		<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
	 </tr>
	 
	</table>
 </td></tr>
</table>

</form>

{/if}