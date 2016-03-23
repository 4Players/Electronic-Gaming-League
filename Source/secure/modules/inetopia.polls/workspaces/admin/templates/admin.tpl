<h2>Umfrage</h2>

{include file="etc/message.tpl"}


{if !$success && $poll }
{if !$poll} Umfrage konnte nicht gefunden werden.{/if}

<form action="{$url_file}page={$url_page}&poll_id={$poll->id}&cat_id={$_get.cat_id}" method="POST">
<input type="hidden" name="a" value="change"/>
	
<table width="100%" cellpadding="20" background="images/admin/adminpoll.gif" style="background-repeat:no-repeat;">
 <tr><td>
 	<br/><br/><br/>
		 	
		<table border="0" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0" width="100%">
		 <tr><td bgcolor="#FFFFFF">
		 
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			 <tr><td>
				<table border="0" width="100%" width="100%" cellpadding="5" cellspacing="1">
				<tr bgcolor="{#clr_content#}">
				 	<td><b>Kategorie:</b></td>
					<td><select style="width:300;" name="poll_cat_id" class="egl_select">
							<option value="-1">Keine Kategorie ausgewählt</option>					
							<option disabled >------------------------------------</option>					
							{defun name="recursion" catroot=$categoryroot level="0"}
							    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $poll->cat_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
								{foreach from=$catroot->aNodes item=node} 
									{fun name="recursion" catroot=$node level=$level+1 }
								{/foreach}
							{/defun}
					 </select>		
					</td>
		 	 	</tr>	
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Startzeit:</b></td>
				 	<td><input value="{date format='%d.%m.%Y' timestamp=$poll->start_time}" name="start_time_date" size="15" type="text" class="egl_text" /> <input size="10" value="{date format='%H:%M' timestamp=$poll->start_time}" name="start_time_clock" type="text" class="egl_text"> </td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Endzeit:</b></td>
				 	<td><input value="{date format='%d.%m.%Y' timestamp=$poll->end_time}" name="end_time_date" size="15" type="text" class="egl_text"/> <input size="10" value="{date format='%H:%M' timestamp=$poll->end_time}" name="end_time_clock" type="text" class="egl_text"> </td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Sperre:</b></td>
				 	<td><select name="lock_type" class="egl_select" style="width:200;">
				 			{if $poll->lock_ip}<option selected value="ip_lock">IP-Address</option>{else}<option value="ip_lock">IP-Address</option>{/if}
				 			{if $poll->lock_memberid}<option selected value="memberid_lock">Mitglied-ID</option>{else}<option value="memberid_lock">Member-ID</option>{/if}
				 			{if !$poll->lock_ip && !$poll->lock_memberid}<option selected value="no_lock">Keine Sperre</option>{else}<option value="no_lock">Keine Sperre</option>{/if}
				 			
				 		</select>
				 	</td>		 
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Attribute:</b></td>
				 	<td>
						<table width="100%" cellpadding="0" cellspacing="0">
						 <tr><td valign="top">
						 	
						 		<table>
						 		 <tr>
								 	{if !$poll->stopped}<td><input type="checkbox" value="yes" name="poll_stopped"/>{/if}
								 	{if $poll->stopped}<td><input type="checkbox" checked value="yes" name="poll_stopped"/>{/if}
						 		 	<td>Umfrage gestoppt</td>
								 </tr>
						 		 <tr>
								 	{if !$poll->show_results}<td><input type="checkbox" value="yes" name="poll_show_results"/>{/if}
								 	{if $poll->show_results}<td><input type="checkbox" checked value="yes" name="poll_show_results"/>{/if}
						 		 	<td>Zeige Ergebnisse während der Umfrage</td>
								 </tr>
								</table>

						 	</td>
						 	<td valign="top">
						 	
						 	</td>
						 </tr>
						</table>
						
				 	</td>
				 </tr>		
 	 			<tr bgcolor="{#clr_content#}">
				 	<td width="10%"><b>Frage:</b></td>
				 	<td><input name="poll_question" type="text" class="egl_text" style="width:100%;" value="{$poll->question}"></td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td valign="top"><b>Text:</b></td>
				 	<td><textarea  style="width:100%;" name="poll_text" class="egl_text" rows="5" cols="100">{$poll->text}</textarea></td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
					<td colspan="2" align="right">
					
					 	<table width="100%">
					 	<td><input type="image" src="images/buttons/new/bt_send.gif" ></td>
					 	<td align="right">[ <A href="{$url_file}page={$url_page}&poll_id={$poll->id}&a=delete_poll"><font color="#A80000"><b>Löschen</b></font></a> ]</td>
					 	</table>
				 
				 </td></tr>
				</table>
				
			 </td></tr>
			</table>
		 </td></tr>
		</table>
		<br/>
		<table border="0" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0" width="100%">
		 <tr><td bgcolor="#FFFFFF">
		 
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			 <tr><td>
				<table border="0" width="100%" width="100%" cellpadding="5" cellspacing="1">
				<tr bgcolor="{#clr_content#}">
				 	<td><A name="answers"><b>Antworten:</b></a></td>
				 </tr>
				<tr bgcolor="{#clr_content#}">
				  <td>
					 	<table width="100%" cellpadding="5" cellspacing="1" border="0">
					 	{section name=ans loop=$answers}
					 	<tr bgcolor="{#clr_content#}">
					 		<td width="1%"><b>Antwort&nbsp;{$smarty.section.ans.index+1}:</b></td>
					 		<td><input name="poll_answer_{$smarty.section.ans.index}" type="text" class="egl_text" style="width:400;" value="{$answers[ans]->answer}"/></td>		 	
					 		<td width="60">
					 			<A href="{$url_file}page={$url_page}&poll_id={$poll->id}&answer_id={$answers[ans]->id}&cat_id={$_get.cat_id}&a=change_subindex&dir=up"><img border="0" src="images/admin/arrow_black_up.gif"/></a>
					 			<A href="{$url_file}page={$url_page}&poll_id={$poll->id}&answer_id={$answers[ans]->id}&cat_id={$_get.cat_id}&a=change_subindex&dir=down"><img border="0" src="images/admin/arrow_black_down.gif"/></a>
					 		</td>
					 		<td width="1%"><A title="Löschen" href="{$url_file}page={$url_page}&poll_id={$poll->id}&answer_id={$answers[ans]->id}&a=delete_answer"><img border=0 src="images/modules/inetopia_polls/small_delete.gif"/></a></td>
					 	</tr>
					 	{/section}
					 	{section name=answer loop=5}
					 	<tr bgcolor="{#clr_content_border#}">
					 		<td width="100"><b>Neue&nbsp;Antwort&nbsp;{$smarty.section.answer.index+1 + sizeof($answers)}:</b></td>
					 		<td colspan="3"><input name="poll_new_answer_{$smarty.section.answer.index}" type="text" class="egl_text" style="width:400;"/></td>		 	
					 	</tr>
					 	{/section}
					 	</table>
				 	
				 
				 	</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td colspan="2" align="right"><input type="image" src="images/buttons/new/bt_send.gif" ></td>
				 </tr>
				</table>
			 </td></tr>
			</table>
			
		 </td></tr>
		</table>
		
		
  </td></tr>
</table>
	</form>
{/if}