<table cellpadding="5"><tr>
	<td><table cellpadding="1" cellspacing="0" bgcolor="#000000"><tr><td><img src="{$PATH_GAMES}small/{$game->logo_small_file}" width="30" height="40"/></td></tr></table> </td>
	<td><h2>Turnier `{$cup->name|strip_tags|stripslashes}` Teilnehmer</h2></td>
 </tr></table>
{include file="`$page_dir`/admin/cupmenu.tpl"}
<hr size="1"/>
{if !$cup->encounts_created}
	<table><tr>
	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Check-IN"  		link="`$url_file`page=`$url_page`&cup_id=`$cup->id`&a=global_checkin"}</td>
	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Check-OUT" 		link="`$url_file`page=`$url_page`&cup_id=`$cup->id`&a=global_checkout"}</td>
	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Alle entfernen" 	link="javascript: if( confirm('Wollen Sie wirklich alle Teilnehmer entfernen?')) document.location='`$url_file`page=`$url_page`&cup_id=`$cup->id`&a=global_remove'"}</tr>
	<tr></table>
{/if}
<br/>

{if $success}
	{include file="etc/message.tpl"}
{else}

<table width="100%" background="images/modules/inetopia_cup/cup_configure.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="5">
					<table cellpadding="5"><tr>
						<td><b>Turnier Teilnehmer</b></td>
						<td>Insgesamt {$participants|@count} Teilnehmer vorhanden</td>
					</tr></table>
				</td>
			 </tr>
		 	<tr bgcolor="{#clr_content_header#}">
		 		<td align="center" width="1%"><b>CHECK</b></td>
		 		<td align="center" width="1%"><b>T</b></td>
				 {if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
		 			<td><b>Name:</b></td>
	 			{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
		 			<td><b>Clan {#arrow_db_right#} Team:</b></td>
	 			{/if}
		 		<td><b>Eingetragen am:</b></td>
		 		<td width="100"><b>Option:</b></td>
		 		<!--#<td width="1%"></td>#-->
		 	</tr>
			{section name=part loop=$participants}
			 <tr bgcolor="{#clr_content#}"
				 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
				 onmouseout="javascript:this.style.backgroundColor='';"
				>
			{if $participants[part]->checked}
				<td align="center"><img src="images/modules/inetopia_cup/cup_checked.gif"></td>
			{else}
				<td align="center"><img src="images/modules/inetopia_cup/cup_unchecked.gif"></td>
			{/if}
			 {if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
			 	<td><img src="images/member.gif"></td>
				<td><A href="{$url_file}page=cms.member.central&member_id={$participants[part]->participant_id}">{$participants[part]->participant_name|strip_tags|stripslashes}</a></td>
			 {elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
			 	<td><img src="images/clans.gif"></td>
				<td><A href="{$url_file}page=cms.team.central&team_id={$participants[part]->participant_id}" title="{$participants[part]->participant_clan_name|strip_tags|stripslashes}">{if $participants[part]->participant_clan_id}{$participants[part]->participant_clan_tag}</a> <B>{#arrow_db_right#}</b>{/if} <A title="{$participants[part]->participant_clan_name|strip_tags|stripslashes}" href="{$url_file}page=cms.clan.central&clan_id={$participants[part]->participant_clan_id}"> {$participants[part]->participant_name|strip_tags|stripslashes}</a></td>
			 {/if}
				<td>{date timestamp=$participants[part]->created}</td>
				<td width="100">
					<table cellpadding="2"><tr>
					{if !$cup->encounts_created}
						<td><A href="{$url_file}page={$url_page}&cup_id={$cup->id}&cuppart_id={$participants[part]->id}&a=remove" title="Teilnehmer entfernen"><img border="0" src="images/modules/inetopia_cup/remove.gif"/></a></td>
						{if $participants[part]->checked} 
							<td><A href="{$url_file}page={$url_page}&cup_id={$cup->id}&cuppart_id={$participants[part]->id}&a=checkout" title="Teilnehmer Check-Out"><img border="0" src="images/modules/inetopia_cup/do_uncheck.gif"/></a></td>
						{else}
							<td><A href="{$url_file}page={$url_page}&cup_id={$cup->id}&cuppart_id={$participants[part]->id}&a=checkin" title="Teilnehmer Check-In"><img border="0" src="images/modules/inetopia_cup/do_check.gif"/></a></td> 
						{/if}
					{else}
						<td>Keine&nbsp;Optionen&nbsp;nach&nbsp;Turnierstart&nbsp;möglich</td>
					{/if}
					</tr></table>
				</td>
				<!--#<td><input type="checkbox" class="egl_checkbox"></td>#-->
			 </tr>
			{/section}
			<tr bgcolor="{#clr_content#}">
				<td colspan="3">
				
				<!--# {if !$cup->encounts_created}[ Global <A href="{$url_file}page={$url_page}&cup_id={$cup->id}&a=global_checkin"><b>Check-In</b></a> | <A href="{$url_file}page={$url_page}&cup_id={$cup->id}&a=global_checkout"><b>Check-Out</b></a> | <A href="{$url_file}page={$url_page}&cup_id={$cup->id}&a=global_remove"><b>Remove</b></a> ]{/if}#-->
				</td>
				<td colspan="2" align="right"> <b>{$num_participants}/{$cup->max_participants}</b> Teilnehmer </b> </td>
			</tr>
			</table>
			
	   </td></tr>
	  </table>
	  
	
	<br/><br/>  
	<form name="fpartadd" action="{$url_file}page={$url_page}&cup_id={$cup->id}&a=add_part" method="POST">
	<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr><td>
	 
		<table border="0" cellpadding="10" cellspacing="1" bgcolor="{#clr_content#}">
		 <tr bgcolor="{#clr_content_header#}">
		 	<td colspan="2"> <b>Teilnehmer hinzufügen:</b></td>
		 </tr>
		 <tr>
		 	{if $cup->participant_type == $smarty.const.PARTTYPE_MEMBER }
		  	<td><b>Member-ID:</b></td>
		  	{elseif $cup->participant_type == $smarty.const.PARTTYPE_TEAM }
		  	<td><b>Team-ID:</b></td>
		  	{/if}
		 	<td><input name="add_participant_id" type="text" class="egl_text"/></td>
		 </tr>
		 <tr>
		 	<td></td>
		 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="abschicken" link="javascript:document.fpartadd.submit();"}</td>
		 </tr>
	 	</table>
	 	
	 </td></tr>
	</table>	  
	</form>
		
  </td></tr>
</table>
{/if}