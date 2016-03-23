<h2>{$LNG_BASIC.c8500}</h2>

<br/>
<table border="0" width="100%" cellpadding="0" cellspacing="1">
 	<tr><td>
	<form>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		 <tr>
		 	<td width="360">
			<select class="egl_select" name="match_option_list" ONCHANGE="location = this.options[this.selectedIndex].value;" style="width:350;">
				<option value="{$url_file}page={$url_page}{$_TEAM_ID_}">- - - - - - {$LNG_BASIC.c8501} - - - - - - </option>
				{section name=mod loop=$entrylist}
					{if sizeof($entrylist[mod]) > 0}
						<optgroup label="{$modules[mod]->sName|strip_tags|stripslashes}">
							
							{section name=entry loop=$entrylist[mod]}
								{if $selected_module == $modules[mod]->ID && $selected_entry == $entrylist[mod][entry]->Id}
									{if !$entrylist[mod][entry]->sURL}
										<option selected  value="{$url_file}page=match.list&mid={$modules[mod]->ID}{$_TEAM_ID_}&entry_id={$entrylist[mod][entry]->Id}"> 	{$entrylist[mod][entry]->sName|strip_tags}  </option>
									{else}
										<option selected value="$entrylist[mod][entry]->sURL"> 	{$entrylist[mod][entry]->sName|strip_tags|stripslashes}  </option>
									{/if}
								{else}
									{if !$entrylist[mod][entry]->sURL}
										<option value="{$url_file}page=match.list&mid={$modules[mod]->ID}{$_TEAM_ID_}&entry_id={$entrylist[mod][entry]->Id}"> 	{$entrylist[mod][entry]->sName|strip_tags}  </option>
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
			
				<select class="egl_select" name="match_viewlist" ONCHANGE="location = this.options[this.selectedIndex].value;" style="width:150px;">
					<option {if $smarty.get.show=="all"}selected{/if} value="{$url_file}page={$url_page}&mid={$smarty.get.mid}{if isset($smarty.get.team_id)}&team_id={$smarty.get.team_id}{/if}&entry_id={$smarty.get.entry_id}&show=all">Alle Matches</option>
					<option {if $smarty.get.show=="running"}selected{/if} value="{$url_file}page={$url_page}&mid={$smarty.get.mid}{if isset($smarty.get.team_id)}&team_id={$smarty.get.team_id}{/if}&entry_id={$smarty.get.entry_id}&show=running">{$LNG_BASIC.c8508}</option>
					<option {if $smarty.get.show=="closed"}selected{/if} value="{$url_file}page={$url_page}&mid={$smarty.get.mid}{if isset($smarty.get.team_id)}&team_id={$smarty.get.team_id}{/if}&entry_id={$smarty.get.entry_id}&show=closed">{$LNG_BASIC.c8509}</option>
					<option {if $smarty.get.show=="locked"}selected{/if} value="{$url_file}page={$url_page}&mid={$smarty.get.mid}{if isset($smarty.get.team_id)}&team_id={$smarty.get.team_id}{/if}&entry_id={$smarty.get.entry_id}&show=locked">{$LNG_BASIC.c8510}</option>
				</select>
			
			</td>
			</tr>
		</table>
	</form>
 	</td>
</tr>
<tr>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" background="images/hr_black.gif" style="background-repeat:repeat-x;">
		 <tr bgcolor="#000000"><td><img width="1" alt="" height="1"/></td></tr>
		</table>
	</td>	
</tr>
<tr >
	<td>
	
	<table border="0" cellpadding="0" cellspacing="5" width="100%">
	{section name=y loop=$NUM_MATCHES}
	 <tr>
		{section name=x loop=2}
	  	{assign var="match_index" value=$smarty.section.y.index*2+$smarty.section.x.index }
		{if $matches[$match_index] }
	 		<td valign="top" width="50%">
	 		
	 			<table border="0" cellpadding="4" cellspacing="1" bgcolor="{#clr_content_rel_border#}" width="300">
	 			{if $matches[$match_index]->participant_type == $smarty.const.PARTTYPE_MEMBER }
	 			<tr>
	 				{*******************************************************************************}
	 				{* Vielleicht noch eine Abfrage, ob $challenger_id / $opponent_id != EGL_NO_ID *}
	 				{*******************************************************************************}
	 				<td align="center"> <A href="{$url_file}page=member.info&member_id={$matches[$match_index]->challenger_id}"><b>{$matches[$match_index]->challenger_name|strip_tags}</b></a> </td>
	 			 </tr>
	 			 <tr>
	 				<td align="center"> <font color="#A80000" size="4"><b>{$LNG_BASIC.c8411}</b></font></td>
	 			 </tr>
	 			 <tr>
	 				<td align="center">  <a href="{$url_file}page=member.info&member_id={$matches[$match_index]->opponent_id}"><b>{$matches[$match_index]->opponent_name|strip_tags}</b></a> </td>
	 			</tr>
	 			{elseif $matches[$match_index]->participant_type == $smarty.const.PARTTYPE_TEAM }
	 			<tr>
	 				{*******************************************************************************}
	 				{* Vielleicht noch eine Abfrage, ob $challenger_id / $opponent_id != EGL_NO_ID *}
	 				{*******************************************************************************}
		 			<td align="center"> <A href="{$url_file}page=clan.info&clan_id={$matches[$match_index]->challenger_clan_id}">{if $matches[$match_index]->challenger_clan_id}<b>{$matches[$match_index]->challenger_clan_tag|strip_tags}</b></a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$matches[$match_index]->challenger_id}"> <b>{$matches[$match_index]->challenger_name|strip_tags}</b> </a>  </td>
	 			 </tr>
	 			 <tr>
	 				<td align="center"> <font color="#A80000" size="4"><b>{$LNG_BASIC.c8411}</b></font></td>
	 			 </tr>
	 			 <tr>
	 				<td align="center" ><a href="{$url_file}page=clan.info&clan_id={$matches[$match_index]->opponent_clan_id}">{if $matches[$match_index]->opponent_clan_id}<b>{$matches[$match_index]->opponent_clan_tag|strip_tags}</b></a> {#arrow_db_right#} {/if}<A href="{$url_file}page=team.info&team_id={$matches[$match_index]->opponent_id}"><b>{$matches[$match_index]->opponent_name|strip_tags}</b></a> </td>
	 			</tr>
	 			{/if}
	 			<tr><td bgcolor="{#clr_content_rel#}">
		 			<table border="0" cellpadding="0" cellspacing="5" width="100%"  style="background-repeat: no-repeat; background-position:center center;">
				 		 <tr>
				 		  	<td colspan="2" align="center">	
				 		  		<!--<hr style="border-color:red;">-->
				 		  		<!--{include file="etc/hr.tpl" type=2 width="80%"}-->
				 		  		
	 							{if $matches[$match_index]->winner_id !=  $smarty.const.EGL_NO_ID }
	 	
		 							{if $matches[$match_index]->participant_type == $smarty.const.PARTTYPE_MEMBER }
		 								{if $matches[$match_index]->winner_id == $participant_id }
						 		  			<b><font color="#00B800">{$LNG_BASIC.c8505}</font></b><br>
						 		  		{else}
						 		  			<b><font color="#A80000">{$LNG_BASIC.c8506}</font></b><br>
						 		  		{/if}
						 		  	{elseif $matches[$match_index]->participant_type == $smarty.const.PARTTYPE_TEAM }
		 								{if $matches[$match_index]->winner_id == $participant_id }
						 		  			<b><font color="#00B800">{$LNG_BASIC.c8505}</font></b><br>
						 		  		{else}
						 		  			<b><font color="#A80000">{$LNG_BASIC.c8506}</font></b><br>
						 		  		{/if}
						 		  	{/if}
						 		{else}
						 		
						 			<br>
						 		
					 		  	{/if}
				 		  		<br/>
			 		  			{$LNG_BASIC.c8402}: 
					  			  	{if $matches[$match_index]->status == $smarty.const.MATCH_RUNNING}{$LNG_BASIC.c8406}{/if}
					  			  	{if $matches[$match_index]->status == $smarty.const.MATCH_LOCKED}{$LNG_BASIC.c8416}{/if}
					  			  	{if $matches[$match_index]->status == $smarty.const.MATCH_CLOSED}{$LNG_BASIC.c8405}{/if}
					  			  	{if $matches[$match_index]->status == $smarty.const.MATCH_REPORTED}{$LNG_BASIC.c8417}{/if}			 		  			
				  			  	<br/>
				 		  	</td>
				 		  </tr>
				 		 <tr><td colspan="2">  </td></tr>
				 		 <tr>
				 		  	<td width="90%">

					 		  	<A href="javascript:OpenMatchReport( '{$matches[$match_index]->id}'); "><img src="images/buttons/bt_match_no_reported.gif" border=0></a> <br>
					 		  	<A href="{$url_file}page=member.newprotest&match_id={$matches[$match_index]->id}"><img src="images/buttons/bt_match_protest.gif" border=0></a>
				 		  	</td>
				 		  	<td>
					 		  	<A href="{$url_file}page=match.info&match_id={$matches[$match_index]->id}"><img src="images/buttons/bt_match_more.gif" border=0></a>
				 		  	</td>
				 		 </tr>
				 		</table>
				 		
				 	 </td></tr>
				 	 <tr>
				 	 
				 	 	<td> 
				 	 	
				 	 		<table border="0" width="100%"><tr>
				 	 		<td> <b>{$LNG_BASIC.c8403}:</b></td>
				 	 		<td> {date timestamp=$matches[$match_index]->challenge_time} </td>
				 	 		</tr></table>
				 	 	
				 	 	</td>
				 	 </tr>
			 	</table>

	 		</td>
 		{/if}
		{/section}
	 </tr>
	{/section}
	</table>

	</td>
 </tr>
</table>

{if sizeof($matches) == 0 }<br/>{$LNG_BASIC.c8507}{/if}