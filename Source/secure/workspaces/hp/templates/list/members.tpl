<h2>Mitglieder Suchen</h2>

<form name="fmsearch" method="POST">
<table border="0" width="100%" cellpadding="4" cellspacing="1" bgcolor="{#clr_content_border#}">
 <tr bgcolor="{#clr_content#}"><td valign="top">

	<table border="0" width="90%">
	 <tr>
	 	<td width="40%"><B>ID: </b></td>
	 	<td><input name="id" type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>Nick Name: </b></td>
	 	<td><input name="nick_name"  type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>Vorname: </b></td>
	 	<td><input name="first_name" type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>Nachname: </b></td>
	 	<td><input next_name="next_name"  type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>eMail: </b></td>
	 	<td><input name="email"  type="text" class="egl_text"></td>
	 </tr>
	</table> 
 
 </td><td  valign="top">
 
	<table border="0" width="90%">
	 <tr>
	 	<td width="40%"><B>Msn: </b></td>
	 	<td><input name="msn"  type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>ICQ: </b></td>
	 	<td><input name="icq"  type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>AM: </b></td>
	 	<td><input name="am"  type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>IRC: </b></td>
	 	<td><input name="irc"  type="text" class="egl_text"></td>
	 </tr>
	 </table> 
	 
	 <br>
	
	<table border="0" width="90%">
	 <tr>
	 	<td width="40%"><B>Clan-Name: </b></td>
	 	<td><input name="clan_name"  type="text" class="egl_text"></td>
	 </tr>
	 <tr>
	 	<td><B>Clan-Tag: </b></td>
	 	<td><input name="clan_tag"  type="text" class="egl_text"></td>
	 </tr>
	 </table>
	 
 </td></tr>
 <tr bgcolor="{#clr_content#}" align="right">
 	<td colspan="2">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Suche starten" link="javascript:document.fmsearch.submit();"}</td>
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
				<td><b><u>Nickname</td>
				<td><b><u>eMail</td>
				<td><b><u>Clan-Name</td>
				<td><b><u>Land</td>
			</tr>
			{section name=member loop=$results}
			<tr>
				<td>{$results[member]->id}</td>
				<td><A href="{$url_file}page=member.info&member_id={$results[member]->id}">{$results[member]->nick_name|strip_tags}</a></td>
				<td><A href="mailto:{$results[member]->email}"><img border=0 src="images/emailButton.png"></a> <i>(eMail senden)</i></td>
				<td>{$results[member]->clan_name|strip_tags}</td>
				<td>
				
				{section name=country loop=$countries}
					{if $countries[country]->id == $results[member]->country_id}
						<img src="{$path_country}{$countries[country]->image_file}">
					{/if}
				{/section}
				</td>
			</tr>
			{/section}
		
		</table>
		 

 	</td>
 </tr>
</table>

{/if}