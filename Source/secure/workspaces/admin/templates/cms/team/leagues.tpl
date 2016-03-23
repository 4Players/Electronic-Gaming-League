<h2>Ligabetriebe `{$team->name|strip_tags|stripslashes}`</h2>
{include file="cms/member/headermenu.tpl"}
<hr size="1"/>
{include file="etc/message.tpl"}

<table border="0" width="100%" cellpadding="0" cellspacing="1">
 	<tr><td>
	<form>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		 <tr>
		 	<td width="360">
			<select class="egl_select" name="match_option_list" ONCHANGE="location = this.options[this.selectedIndex].value;" style="width:350;">
				<option value="{$url_file}page={$url_page}&team_id={$team->id}">- - - - - - {$LNG_BASIC.c8501} - - - - - - </option>
				{section name=mod loop=$entrylist}
					{if sizeof($entrylist[mod]) > 0}
						<optgroup label="{$modules[mod]->sName|strip_tags|stripslashes}">
							
							{section name=entry loop=$entrylist[mod]}
								{if $selected_module == $modules[mod]->ID && $selected_entry == $entrylist[mod][entry]->Id}
									{if !$entrylist[mod][entry]->sURL}
										<option selected  value="{$url_file}page{$url_page}&mid={$modules[mod]->ID}&team_id={$team->id}&entry_id={$entrylist[mod][entry]->Id}"> 	{$entrylist[mod][entry]->sName|strip_tags}  </option>
									{else}
										<option selected value="$entrylist[mod][entry]->sURL"> 	{$entrylist[mod][entry]->sName|strip_tags|stripslashes}  </option>
									{/if}
								{else}
									{if !$entrylist[mod][entry]->sURL}
										<option value="{$url_file}page={$url_page}&show={$smarty.get.show}&mid={$modules[mod]->ID}&team_id={$team->id}&entry_id={$entrylist[mod][entry]->Id}"> 	{$entrylist[mod][entry]->sName|strip_tags}  </option>
									{else}
										<option value="$entrylist[mod][entry]->sURL"> 	{$entrylist[mod][entry]->sName|strip_tags|stripslashes}  </option>
									{/if}
								{/if}
							{/section}
				 		</optgroup>
				 	{/if}
				{/section}
			</select>
			</td>
			<td>
			
				<select class="egl_select" name="match_viewlist" ONCHANGE="location = this.options[this.selectedIndex].value;" style="width:200px;">
					<option {if $smarty.get.show=="all"}selected{/if} value="{$url_file}page={$url_page}&team_id={$team->id}&mid={$smarty.get.mid}{if isset($smarty.get.team_id)}&team_id={$smarty.get.team_id}{/if}&entry_id={$smarty.get.entry_id}&show=all">Alle Matches</option>
					<option {if $smarty.get.show=="running"}selected{/if} value="{$url_file}page={$url_page}&team_id={$team->id}&mid={$smarty.get.mid}{if isset($smarty.get.team_id)}&team_id={$smarty.get.team_id}{/if}&entry_id={$smarty.get.entry_id}&show=running">Offene Matches</option>
					<option {if $smarty.get.show=="closed"}selected{/if} value="{$url_file}page={$url_page}&team_id={$team->id}&mid={$smarty.get.mid}{if isset($smarty.get.team_id)}&team_id={$smarty.get.team_id}{/if}&entry_id={$smarty.get.entry_id}&show=closed">Geschlossene Matches</option>
					<option {if $smarty.get.show=="locked"}selected{/if} value="{$url_file}page={$url_page}&team_id={$team->id}&mid={$smarty.get.mid}{if isset($smarty.get.team_id)}&team_id={$smarty.get.team_id}{/if}&entry_id={$smarty.get.entry_id}&show=locked">Gesperrte Matches</option>
				</select>
			
			</td>
			</tr>
		</table>
	</form>
 	</td>
</tr>
</table>


{if isset($matches)}

	<table cellpadding="5" cellspacing="1" width="100%">
	<tr bgcolor="{#clr_content_border#}">
		<td width="50"></td>
		<td width="200"><b>Termin:</b></td>
		<td><b>Match:</td>
	</tr>
	{section name=m loop=$matches}
	<tr bgcolor="{#clr_content#}">
		{if $matches[m]->evaluated}
			<td><img src="images/calced.gif"></td>
		{else}
			<td><img src="images/no_calced.gif"></td>
		{/if}
		<td>{date timestamp=$matches[m]->challenge_time}
		<td><a href="{$url_file}page=cms.match.admin&match_id={$matches[m]->id}">{$matches[m]->challenger_name} ({$matches[m]->challenger_points|add_match_sign|match_points})
			&nbsp;<b>Vs.</b>&nbsp;
			{$matches[m]->opponent_name} ({$matches[m]->opponent_points|add_match_sign|match_points})</a>
		</td>
	</tr>
	{/section}
	</table>

{/if}