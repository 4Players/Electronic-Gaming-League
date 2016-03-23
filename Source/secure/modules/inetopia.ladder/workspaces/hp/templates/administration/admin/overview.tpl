<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Administratoren</h2>
{include file="`$page_dir`/laddermenu.tpl"}
<hr size="1"/>
{include file="devs/message.tpl"}
{if $success}

{else}
<table width="100%" background="images/modules/inetopia_ladder/ladder_overview.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"><b>Überblick</b></td>
			 </tr>
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Teilnehmer insgesamt:</b></td>
			 	<td>{$num_participants|tointeger}</td>
			</tr>
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Begegnungen insgesamt:</b></td>
			 	<td>{$num_encounts|tointeger}</td>
			</tr>
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Teilnehmergrenze bei:</b></td>
				{if $ladder->max_participants > 0}<td>{$ladder->max_participants}</td>{/if}
				{if $ladder->max_participants == 0}<td>unbegrenzt</td>{/if}
			</tr>
			{if $ladder->max_participants > 0}
		 	<tr bgcolor="{#clr_content#}">
				<td width="200"><b>Teilnehmerverbauch:</b></td>
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
		 	 	<td><b>Zuständige Administratoren:</b></td>
		 	 	<td>
				 	{section name=admin loop=$adminlist}
				 		<A href="{$url_file}page=cms.member.central&member_id={$adminlist[admin]->member_id}">{$adminlist[admin]->nick_name|strip_tags|stripslashes}</a>
				 		{if !$smarty.section.admin.last},{/if}
				 	{/section}
				 	{if sizeof($adminlist)==0}Keine Admins eingetragen{/if}	
		 	 	</td>
		 	 </tr>
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>

{/if}