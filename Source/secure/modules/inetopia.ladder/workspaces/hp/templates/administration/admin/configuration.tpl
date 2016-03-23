<h2>Ladder `{$ladder->name|strip_tags|stripslashes}` Konfiguration</h2>
{include file="`$page_dir`/laddermenu.tpl"}
<hr size="1"/>
{include file="devs/message.tpl"}

{if $success}
{else}
<script language="javascript" src="javascript/browser_handling.js"></script>
<script language="javascript">
	// ========================================================================
    // COPYRIGHT (C)2006 Inetopia. All right reserved. Alle Rechte vorbehalten.
    //
    //
    // Visit www.inetpia.de for more information
	// ========================================================================
	var num_matchstructures = {$matchstructures|@count};
	var matchstructures = new Array();
	
	var gamelist	= new Array();
	var num_games = {$games|@count};
	
	// create matchstructure array
	{section name=ms loop=$matchstructures}
	matchstructures[{$smarty.section.ms.index}] = new Array();
	matchstructures[{$smarty.section.ms.index}]["id"] = {$matchstructures[ms]->id};
	matchstructures[{$smarty.section.ms.index}]["name"] = "{$matchstructures[ms]->name}";
	matchstructures[{$smarty.section.ms.index}]["game_id"] = {$matchstructures[ms]->game_id};
	{/section}
	
	// create matchstructure array
	{section name=game loop=$games}
	gamelist[{$smarty.section.game.index}] = new Array();
	gamelist[{$smarty.section.game.index}]["id"] = {$games[game]->id};
	gamelist[{$smarty.section.game.index}]["name"] = "{$games[game]->name}";
	gamelist[{$smarty.section.game.index}]["image_file"] = "{$PATH_GAMES}small/{$games[game]->logo_small_file}";
	{/section}	
	
</script>
{literal}
<script language="javascript">
	// ========================================================================
    // COPYRIGHT (C)2006 Inetopia. All right reserved. Alle Rechte vorbehalten.
    //
    //
    // Visit www.inetpia.de for more information
	// ========================================================================
	function deleteSelectOptions(field){
		var lngth = field.length;
		for (i=0; i <lngth; i++){
			field.options[field.length-1] = null;
		}
	}
	function change_game( game_id )
	{
		// clear matchstructurelist
		deleteSelectOptions( document.forms['ladder_form'].matchstruct_id );
		
		var num_ms = 0;
		for( i=0; i < num_matchstructures; i++ )
		{
			if( game_id == matchstructures[i]["game_id"] )
			{
				document.forms['ladder_form'].matchstruct_id.options[num_ms] = new Option( matchstructures[i]["name"], matchstructures[i]["id"] );
				num_ms++;
			}
		}//for
		
		if( num_ms == 0 ) document.forms['ladder_form'].matchstruct_id.options[0] = new Option( "------------------", "-1" );

		// set game image
		for( g=0; g < num_games; g++ )
			if( gamelist[g]["id"] == game_id )
			{
				//document.images["game_pic"].src = gamelist[g]["image_file"];
			}
		
		
		// select game in selectlist
		var game_sel = document.forms['ladder_form'].game_id;
		var game_lngth = game_sel.length;
		for (i=0; i <game_lngth; i++)
		{
			if( game_sel.options[i].value == game_id )
				game_sel.options[i].selected = true;
		}
	}
	function change_matchstructure( matchstruct_id )
	{
		// select game in selectlist
		var ms_sel = document.forms['ladder_form'].matchstruct_id;
		var ms_lngth = ms_sel.length;
		for (i=0; i <ms_lngth; i++)
			if( ms_sel.options[i].value == matchstruct_id )
				ms_sel.options[i].selected = true;
	}
	/********************************************************************************************/
</script>
{/literal}

<form name="ladder_form" action="{$url_file}page={$url_page}&ladder_id={$ladder->id}&a=change" method="post">
<table width="100%" background="images/modules/inetopia_ladder/ladder_configure.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/>
 	 <table cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td colspan="2"> <b>Konfiguration</b> </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Spiel:</b></td>
			 	<td>
			 		 <select onchange="javascript:change_game(this.value);" name="game_id" class="egl_select" style="width:400;">
			 		 {section name=game loop=$games}
			 		 	<option value="{$games[game]->id}">{$games[game]->name|strip_tags|stripslashes}</option>
			 		 {/section}
			 		</select>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="200"><b>Ladder-Name:</b></td>
			 	<td><input style="width:400;" type="text" class="egl_text" value="{$ladder->name|strip_tags|stripslashes}" name="name"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Kategorie:</b></td>
				<td><table><tr><td>
					<select style="width:400;" name="cat_id" class="egl_select">
						<option disabled >------------------------------------</option>					
						{defun name="testrecursion" catroot=$categoryroot level="0"}
						    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $ladder->cat_id}selected{else}disabled{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
							{foreach from=$catroot->aNodes item=node} 
								{fun name="testrecursion" catroot=$node level=$level+1 }
							{/foreach}
						{/defun}
					 </select></td>
					 </tr></table>
				</td>	 
			 </tr>			 			 
			 {if $ladder->matchstructure_id == -1}<tr bgcolor="FFDB96">
			 {else}<tr bgcolor="{#clr_content#}">{/if}
			 	<td><b>Match-Struktur:</b></td>
			 	<td><select name="matchstruct_id" class="egl_select" style="width:400;">
							<option value="-1">Bitte Spiel wählen</option>
					 </select>
				</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="200"><b>Calculator:</b></td>
			 	<td><select name="calculator" class="egl_select" style="width:400;">
			 		{section name=calc loop=$calculator}
			 			<option {if $ladder->calculator == $calculator[calc]}selected{/if} value="{$calculator[calc]}">{$calculator[calc]}</option>
			 		{/section}
			 		</select>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Teilnehmer-Art:</b></td>
			 	<td> <select name="participant_type" class="egl_select" style="width:400;">
			 	 		<option value="{$smarty.const.PARTTYPE_MEMBER}">Member</option>
			 	 		<option {if $ladder->participant_type == $smarty.const.PARTTYPE_TEAM}selected{/if} value="{$smarty.const.PARTTYPE_TEAM}">Team</option>
			 		</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="200"><b>Max. Teilnehmer:</b></td>
			 	<td><input type="text" class="egl_text" value="{$ladder->max_participants}" name="max_participants"/>(0 für unbegrenzt)</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Spieler/pro Team:</b><br/>(Nur für Team-Mode)</td>
			 	<td><input name="num_team_members" type="text" class="egl_text" size="10" value="{$ladder->num_team_members}" /></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Unterstützte Challenge-Arten:</b></td>
			 	<td>
			 		<table cellpadding="5" cellspacing="1">
			 		 <tr>
			 		 
			 			<td><input type="checkbox" {if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_SINGLE_MAP}checked{/if} name="single_challenge" value="yes" /></td><td>SingleMap Challenge</td>
			 			<td><input type="checkbox" {if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_DOUBLE_MAP}checked{/if} name="double_challenge" value="yes"/></td><td>DoubleMap Challenge</td>
			 	 	 </tr>
			 		 <tr>
			 			<td><input disabled type="checkbox" {if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_RANDOM_MAP}checked{/if} name="random_challenge" value="yes"/></td><td>RandomMap Challenge<br/></td>
			 	 	 </tr>
			 	 	</table>
			 	 	
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="200"><b>Ladder-Start:</b></td>
			 	<td>
			 		<input size="10" type="text" class="egl_text" value="{date timestamp=$ladder->start_time format='%d.%m.%y'}" name="start_time_date"/>
			 		<input size="5" type="text" class="egl_text" value="{date timestamp=$ladder->start_time format='%H:%M'}" name="start_time_clock"/>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="200"><b>Anmeldesperre:</b></td>
			 	<td>
			 		<select style="width:135;"class="egl_select" name="signin_locked">
			 			<option value="0">Nein</option>
			 			<option value="1" {if $ladder->signin_locked}selected{/if} >Ja</option>
			 		</select>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="200"><b>Join Möglichkeit:</b><br/>(Nach Registration)</td>
			 	<td><input type="text" size="10" class="egl_text" value="{$ladder->join_time}" name="join_time"/> &nbsp; Stunden</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="200"><b>Startpunkte:</b></td>
			 	<td><input type="text" size="10" class="egl_text" value="{$ladder->first_points_score}" name="first_points_score"/></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Check GameAccounts:</b></td>
			 	<td><select name="check_gameacc_id" class="egl_select" style="width:100;">
			 			<option value="1">Ja</option>
			 			{if !$ladder->check_gameacc_id}<option selected value="0">Nein</option>{else}<option value="0">Nein</option>{/if}
			 		</select>
			 	</td>		 
			 </tr>
			  <tr bgcolor="{#clr_content#}">
			 	<td colspan="2" align="right">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="abschicken" link="javascript:document.ladder_form.submit();"}</td>
			 </tr>
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>
</form>
	
	{if $ladder }
		<script language="javascript"> 
			change_game( {$ladder->game_id} );
			change_matchstructure( {$ladder->matchstructure_id} );
		</script>
	{else}
		<script language="javascript"> 
			change_game( gamelist[0]["id"] ); 
		</script>
	{/if}
	
{/if}