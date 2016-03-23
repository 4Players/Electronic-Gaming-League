<table cellpadding="5"><tr>
	<td><table cellpadding="1" cellspacing="0" bgcolor="#000000"><tr><td><img src="{$PATH_GAMES}small/{$game->logo_small_file}" width="30" height="40"/></td></tr></table> </td>
	<td><h2>Turnier `{$cup->name|strip_tags|stripslashes}` Turnierbaum</h2></td>
 </tr></table>
{include file="`$page_dir`/admin/cupmenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}
{if $success}
{else}


<table width="100%" background="images/modules/inetopia_cup/cup_overview.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"> <b>Übersicht</b> </td>
			 </tr>
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Teilnehmer:</b></td>
				<td>
					{$cup->num_participants}/{$cup->max_participants}
				</td>
			</tr>
			{if $cup->max_participants > 0}
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Teilnehmer</b>(prozentual):</td>
			 	<td>
			 		<table cellpadding="0" cellspacing="0" width="{$efficiency}%">
			 		 <tr>
			 		 	<td width="1"><img src="images/process/p1_start.gif"/></td>
			 		 	<td align="center" background="images/process/p1_middle.gif"><font style="font-size:10px;">{$efficiency}%</font></td>
			 		 	<td width="1"><img src="images/process/p1_end.gif"/></td>
			 		 </tr>
			 		</table>
			 	</td>
			</tr>
			{/if}
		 	 <tr bgcolor="{#clr_content#}">
		 	 	<td><b>Administratoren:</b></td>
		 	 	<td>
				 	{section name=admin loop=$adminlist}
				 		<A href="{$url_file}page=cms.member.central&member_id={$adminlist[admin]->member_id}">{$adminlist[admin]->nick_name|strip_tags|stripslashes}</a>
				 		{if !$smarty.section.admin.last},{/if}
				 	{/section}
				 	{if sizeof($adminlist)==0}Keine Admins eingetragen{/if}	
		 	 	</td>
		 	 </tr>
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"> <b>Prozeduren</b> </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 <td colspan="2">
			 	<table><tr>
			{if !$cup->encounts_created}
			 	<td>{include file="buttons/bt_universal.tpl" caption="Erstellen & Starten" link="`$url_file`page=`$url_page`&cup_id=`$cup->id`&a=start"}</td>
			 {/if}
			{if !$cup->finished && $cup->encounts_created}
			 	<td>{include file="buttons/bt_universal.tpl" caption="Beenden" link="`$url_file`page=`$url_page`&cup_id=`$cup->id`&a=finish"}</td>
			{/if}
			{if $cup->finished}
			 	<td>{include file="buttons/bt_universal.tpl" caption="Eröffnen" link="`$url_file`page=`$url_page`&cup_id=`$cup->id`&a=open"}</td>
			{/if}
			{if $cup->encounts_created && !$cup->finished}
			 	<td>{include file="buttons/bt_universal.tpl" caption="Resetten" link="javascript: if( confirm('Wollen Sie wirklich das Turnier resetten?\\nAlle Begegnungen werden dadurch gelöscht.')) document.location='`$url_file`page=`$url_page`&cup_id=`$cup->id`&a=reset';"}</td>
			{/if}
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>

{/if}