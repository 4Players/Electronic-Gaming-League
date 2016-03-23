<h2>Umfrage erstellen</h2>
<table><tr>
<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Kategorien" link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.categories&cat_id=`$_get.cat_id`"}</td>
<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Neue Umfrgae" link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.create&cat_id=`$_get.cat_id`"}</td>
</tr></table>
{include file="devs/hr2.tpl" width="100%"}<br/>
{include file="devs/message.tpl"}


{if !$success}
<form name="fpoll" action="{$url_file}page={$url_page}&cat_id={$_get.cat_id}&a=go" method="POST">
<table width="100%" cellpadding="20" background="images/hpadmin/adminpoll.gif" style="background-repeat:no-repeat;">
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
						{defun name="recursion" catroot=$categoryroot level="0"}
						    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $_get.cat_id}selected{else}disabled{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
							{foreach from=$catroot->aNodes item=node} 
								{fun name="recursion" catroot=$node level=$level+1 }
							{/foreach}
						{/defun}
				 </select>		
				</td>
	 	 	</tr>				
			 <tr bgcolor="{#clr_content#}">
			 	<td width="100"><b>Startzeit:</b></td>
			 	<td><input value="{date format='%d.%m.%Y'}" name="start_time_date" size="15" type="text" class="egl_text"> Clock: <input size="10" value="{date format='%H:%M'}" name="start_time_clock" type="text" class="egl_text"> </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Endzeit:</b></td>
			 	<td><input value="{date format='%d.%m.%Y'}" name="end_time_date" size="15" type="text" class="egl_text"> Clock: <input size="10" value="{date format='%H:%M'}" name="end_time_clock" type="text" class="egl_text"> </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Sperre:</b></td>
			 	<td><select name="lock_type" class="egl_select" style="width:200;">
			 			<option selected value="ip_lock">IP-Address</option>
			 			<option value="id_lock">Member-ID</option>
			 			<option value="no_lock">Keine Sperre</option>
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
							 	<td><input type="checkbox" value="yes" name="poll_stopped"/>
					 		 	<td>Umfrage gestoppt</td>
							 </tr>
					 		 <tr>
							 	<td><input checked type="checkbox" value="yes" name="poll_show_results"/>
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
			 	<td><input name="poll_question" type="text" class="egl_text" style="width:100%;" ></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td valign="top"><b>Text:</b></td>
			 	<td><textarea style="width:100%" name="poll_text" class="egl_text" rows="5" ></textarea></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td colspan="2">

			 		<b>Antworten</b>
				 	<table border="0" cellpadding="5" cellspacing="0" align="center">
				 	{section name=answer loop=15}
					 <tr bgcolor="{#clr_content#}">
				 		<td><input name="poll_answer_{$smarty.section.answer.index}" type="text" class="egl_text" style="width:300;"/></td>		 	
				 	</tr>
				 	{/section}
				 	</table>
			 
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td></td>
			 	<td align="right">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="erstellen" link="javascript:document.fpoll.submit();"} </td>
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
