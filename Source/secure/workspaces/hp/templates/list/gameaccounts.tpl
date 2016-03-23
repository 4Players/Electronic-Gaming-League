

<form method="POST">

<table border="0" width="100%" cellpadding="4" cellspacing="1" bgcolor="{#clr_content_border#}">
 <tr><td colspan="2" align="center"> <b>Gameaccount Suche</b> </td></tr>
 <tr bgcolor="{#clr_content#}"><td valign="top">

	<table border="0" width="100%">
	 <tr><td colspan="2"><u><b>Gameaccount:</b></u></td></tr>
	 <tr>
	 	<td width="30%"><B>Type: </b></td>
	 	<td><select class="egl_text" name="gameacctype_id">
	 	{section name=acctype loop=$gameacctypes}
	 		<option value="{$gameacctypes[acctype]->id}">{$gameacctypes[acctype]->name}</option>
	 	{/section}
	 	</select>
	 	</td>
	 </tr>
	 <tr>
	 	<td><B>Wert: </b></td>
	 	<td><input name="value" type="text" class="egl_text" size="40"></td>
	 </tr>
	</table> 
	 
	 
 </td></tr>
 <tr bgcolor="{#clr_content#}" align="right">
 	<td colspan="2"><input type="submit" class="egl_button" value="Suche starten"></td>
 </tr>
 	
</table>
</form>



{if $search_success}
<br>

<table border="0" width="100%" cellpadding="4" cellspacing="1" bgcolor="{#clr_content_border#}">
 <tr><td colspan="2" align="center"> <b>Suchergebnisse ({$num_results})</b> </td></tr>
	<tr bgcolor="{#clr_content#}"><td valign="top">
		
		<table border="0" width="100%">
			<tr>
				<td><b><u>ID</td>
				<td><b><u>Name</td>
				<td><b><u>Tag</td>
				<td><b><u>Gameaccount</td>
				<td><b><u>Land</td>
			</tr>
			{section name=memb loop=$results}
			<tr>
				<td>{$results[memb]->id}</td>
				<td><A href="{$url_file}page=member.info&member_id={$results[memb]->id}">{$results[memb]->nick_name|strip_tags}</a></td>
				<td>{$results[memb]->clan_tag|strip_tags}</td>
				<td> {$results[memb]->value|strip_tags} </td>
				<td>
				{section name=country loop=$countries}
				{if $countries[country]->id==$results[memb]->country_id}<img src="{$path_country}{$countries[country]->image_file}">{/if}
				{/section}
				</td>
				
				
			</tr>
			{/section}
		
		</table>
		 

 	</td>
 </tr>
</table>

{/if}