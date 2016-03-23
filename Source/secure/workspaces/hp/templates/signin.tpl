<h2>{$LNG_BASIC.c2400}</h2>
{include file="devs/message.tpl"}

{if $signin_success }
{elseif $is_loggedin}

	{*****************************************}
	{*Falls eingeloggt => nicht anmelde fähig*}
	{*****************************************}


{else}
{********************************}
{*Andernfalls zeige das formular*}
{********************************}

	<form name="f" action="{$url_file}page={$url_page}&a=go" method="POST">
	<table border="0" cellpadding="4" cellspacing="1" align="center" bgcolor="{#clr_content_border#}" width="90%">
	 <tr bgcolor="{#clr_content#}">
		<td><b>{$LNG_BASIC.c1007}:</b></td>
	 	<td><input class="egl_text" type="text" name="signin_email" value="{$signin_buffer.signin_email}" style="width:200px;"></td>
	 </tr>
	 <tr bgcolor="{#clr_content#}">
	 	<td><b>{$LNG_BASIC.c1020}:</b> </td>
	 	<td><input class="egl_text" type="text" name="signin_nick_name" value="{$signin_buffer.signin_nick_name}" style="width:200px;"></td>
	</tr>
	 <tr bgcolor="{#clr_content#}">
		<td><b>{$LNG_BASIC.c2414}:</b></td>
		<td><select name="signin_country_id" class="egl_select" style="width:200px;">
			{section name=c loop=$countries}
				<option value="{$countries[c]->id}">{$countries[c]->name|strip_tags}</option>
			{/section}
			</select>
		</td>
	</tr>
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan="2" align="center"><b>{$LNG_BASIC.c2401}</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content_rel#}">
	 	<td colspan="2" align="center">
	 		<textarea readonly  style="width:100%;" rows="10" >{texts language=$LANGUAGE file="terms_of_use.tpl"}</textarea><br/>
	 		<input type="checkbox" class="" name="signin_terms_of_use" value="accepted"> <b>{$LNG_BASIC.c2403}</b>
	 	</td>
	 </tr>
	 <tr bgcolor="{#clr_content_border#}">
	 	<td colspan="2" align="center"><b>{$LNG_BASIC.c2402}</b></td>
	 </tr>
	 <tr bgcolor="{#clr_content_rel#}">
	 	<td colspan="2" align="center">
	 		<textarea readonly rows="10" style="width:100%;">{texts language=$LANGUAGE file="data_protection.tpl"}</textarea><br/>
	 		<input type="checkbox" class="" name="signin_data_protection" value="accepted"> <b>{$LNG_BASIC.c2404}</b>
	 	</td>
	 </tr>
	 <tr bgcolor="{#clr_content_rel_border#}">
	 	<td colspan="2" align="center">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
	 </tr>
	</form>
	</table>
{/if}