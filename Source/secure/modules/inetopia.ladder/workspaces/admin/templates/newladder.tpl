<h2>Neue Ladder erstellen</h2>
{include file="etc/message.tpl"}
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
	function change_game( game_id ){
		// clear matchstructurelist
		deleteSelectOptions( document.forms['ladder_form'].matchstruct_id );
		
		var num_ms = 0;
		for( i=0; i < num_matchstructures; i++ ){
			if( game_id == matchstructures[i]["game_id"] ){
				document.forms['ladder_form'].matchstruct_id.options[num_ms] = new Option( matchstructures[i]["name"], matchstructures[i]["id"] );
				num_ms++;
			}
		}//for
		
		if( num_ms == 0 ) document.forms['ladder_form'].matchstruct_id.options[0] = new Option( "------------------", "-1" );

		// set game image
		for( g=0; g < num_games; g++ )
			if( gamelist[g]["id"] == game_id ){
				//document.images["game_pic"].src = gamelist[g]["image_file"];
			}
		
		
		// select game in selectlist
		var game_sel = document.forms['ladder_form'].game_id;
		var game_lngth = game_sel.length;
		for (i=0; i <game_lngth; i++){
			if( game_sel.options[i].value == game_id )
				game_sel.options[i].selected = true;
		}
	}
	function change_matchstructure( matchstruct_id ){
		// select game in selectlist
		var ms_sel = document.forms['ladder_form'].matchstruct_id;
		var ms_lngth = ms_sel.length;
		for (i=0; i <ms_lngth; i++)
			if( ms_sel.options[i].value == matchstruct_id )
				ms_sel.options[i].selected = true;
	}
	
	function show_matchstructure(url){
		//alert( document.forms['ladder_form'].matchstruct_id.options
		var __msid = document.forms['ladder_form'].matchstruct_id.options[ document.forms['ladder_form'].matchstruct_id.selectedIndex ].value;
		if( __msid == -1 )document.location.href = url+"page=cms.match_structures.overview";
		else document.location.href = url+"page=cms.match_structures.admin&ms_id="+__msid;
	}
	function show_category(url){
		var __catid = document.forms['ladder_form'].cat_id.options[ document.forms['ladder_form'].cat_id.selectedIndex ].value;
		if( __catid == -1 )document.location.href = url+"page=cms.eglviewer.overview";
		else document.location.href = url+"page=cms.eglviewer.overview&cat_id="+__catid;
	}	
	/********************************************************************************************/
	/*
	function replaceIt(string,suchen,ersetzen) {
		ausgabe = "" + string;
		while (ausgabe.indexOf(suchen)>-1){
			pos= ausgabe.indexOf(suchen);
			ausgabe = "" + (ausgabe.substring(0, pos) + ersetzen +
			ausgabe.substring((pos + suchen.length), ausgabe.length));
		}
		return ausgabe;
	}
	function add_current_to_pagestore(){
		var url = parent.page.location.href;
		url=replaceIt( url, String.fromCharCode(38), String.fromCharCode(33));		// '&'	=> '|'
		url=replaceIt( url, String.fromCharCode(63), String.fromCharCode(36));		// '?'	=> '$'
		parent.navi.location.href = parent.navi.location.href + "&save_page="+url;
		//alert( url );
	}*/

	function bookmark_page(question){
		if( confirm( question ) ){
			add_current_to_pagestore();
		}//if
	}	
	
</script>
{/literal}

	<form name="ladder_form" action="{$url_file}page={$url_page}&game_id={$game->id}&a=add" method="post">
	<table width="100%" background="images/modules/inetopia_ladder/ladder_add.gif" style="background-repeat:no-repeat;" cellpadding="20">
	 <tr><td>
	 	<br/><br/>
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
				 	<td><input style="width:400;" type="text" class="egl_text" value="" name="name"/><br/>
				 		(automatisiert, falls leer)
				 	</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td width="200"><b>Land:</b></td>
				 	<td><select name="country_id" class="egl_select" style="width:400px;">
				 			{section name=c loop=$countries}
				 				<option {if $LANGUAGE == $countries[c]->token}selected{/if} value="{$countries[c]->id}">{$countries[c]->name}</option>
				 			{/section}
				 		</select>
				 	</td>
				 </tr>
			 	 <tr bgcolor="{#clr_content#}">
				 	<td><b>Kategorie:</b></td>
					<td><table><tr><td>
						<select style="width:400;" name="cat_id" class="egl_select">
							<option value="-1">Bitte Kategorie wählen</option>					
							<option disabled >------------------------------------</option>					
							{defun name="testrecursion" catroot=$categoryroot level="0"}
							    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $ladder->cat_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
								{foreach from=$catroot->aNodes item=node} 
									{fun name="testrecursion" catroot=$node level=$level+1 }
								{/foreach}
							{/defun}
						 </select></td>
						 <td>
						 (<a href="javascript:bookmark_page('{$LNG_BASIC.c1000}');show_category('{$url_file}');">bearbeiten</a>)
						 </td>
						 </tr></table>
					</td>	 
				 </tr>		 			 
				 <tr bgcolor="{#clr_content#}">
					<td></td>
					<td>
						<table><tr>
						 	<td><input type="radio" name="create_subcat" value="yes" checked/>Unterkategorie erstellen</td>
						 	<td><input type="radio" name="create_subcat" value="no" />Keine Unterkategorie erstellen</td>
						</tr></table>
					</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Match-Struktur:</b></td>
					<td><table><tr><td>
						<select name="matchstruct_id" class="egl_select" style="width:400;">
								<option value="-1">Bitte Spiel wählen</option>
						 </select></td>
						 <td>
						 (<a href="javascript:bookmark_page('{$LNG_BASIC.c1000}');show_matchstructure('{$url_file}');">bearbeiten</a>)
						 </td>
						 </tr></table>
					</td>	 
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td width="200"><b>Calculator:</b></td>
				 	<td><select name="calculator" class="egl_select" style="width:400;">
				 		{section name=calc loop=$calculator}
				 			<option value="{$calculator[calc]}">{$calculator[calc]}</option>
				 		{/section}
				 		</select>
				 	</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Teilnehmer-Art:</b></td>
				 	<td> <select name="participant_type" class="egl_select" style="width:400;">
				 	 		<option value="{$smarty.const.PARTTYPE_MEMBER}">Member</option>
				 	 		<option value="{$smarty.const.PARTTYPE_TEAM}">Team</option>
				 		</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td width="200"><b>Max. Teilnehmer:</b></td>
				 	<td><input type="text" class="egl_text" value="0" name="max_participants"/> (0 für unbegrenzt)</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Spieler/pro Team:</b><br/>(Nur für Team-Mode)</td>
				 	<td><input name="num_team_members" type="text" class="egl_text" size="10" value="0" /></td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Unterstützte Challenge-Arten:</b></td>
				 	<td>
				 		<table cellpadding="5" cellspacing="1">
				 		 <tr>
				 		 
				 			<td><input type="checkbox" name="single_challenge" value="yes" /></td><td>SingleMap Challenge</td>
				 			<td><input type="checkbox" name="double_challenge" value="yes"/></td><td>DoubleMap Challenge</td>
				 	 	 </tr>
				 		 <tr>
				 			<td><input type="checkbox" {if $ladder->challenge_types & $smarty.const.CHALLENGETYPE_RANDOM_MAP}checked{/if} name="random_challenge" value="yes"/></td><td>RandomMap Challenge<br/></td>
				 	 	 </tr>
				 	 	</table>
				 	 	
				 	</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td width="200"><b>Fast Challege aktiviert:</b></td>
				 	<td>
				 		<select style="width:135;"class="egl_select" name="fastchallenge_mode">
				 			<option value="0">Deaktiviert</option>
				 			<option value="1" {if $ladder->fastchallenge_mode}selected{/if} >Aktiviert</option>
				 		</select>
				 	</td>
				 </tr>				 
				 <tr bgcolor="{#clr_content#}">
				 	<td width="200"><b>Ladder-Start:</b></td>
				 	<td>
				 		<input size="10" type="text" class="egl_text" value="{date format='%d.%m.%y'}" name="start_time_date"/>
				 		<input size="5" type="text" class="egl_text" value="{date format='%H:%M'}" name="start_time_clock"/>
				 	</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td width="200"><b>Anmeldesperre:</b></td>
				 	<td>
				 		<select style="width:135;"class="egl_select" name="signin_locked">
				 			<option value="0">Nein</option>
				 			<option value="1">Ja</option>
				 		</select>
				 	</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td width="200"><b>Join Möglichkeit:</b><br/>(Nach Registration)</td>
				 	<td><input type="text" size="10" class="egl_text" value="0" name="join_time"/> &nbsp; Stunden</td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td width="200"><b>Startpunkte:</b></td>
				 	<td><input type="text" size="10" class="egl_text" value="1000" name="first_points_score"/></td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td><b>Check GameAccounts:</b></td>
				 	<td><select name="check_gameacc_id" class="egl_select" style="width:100;">
				 			<option selected value="1">Ja</option>
				 			<option value="0">Nein</option>
				 		</select>
				 	</td>		 
				 </tr>
			 	 <tr bgcolor="{#clr_content#}">
				 	<td colspan="2" align="right"><input type="image" src="images/buttons/new/bt_send.gif" /></td>
				 </tr>
				</table>
				
		   </td></tr>
		  </table>
			
	  </td></tr>
	</table>
	</form>
	
	{if $_get.game_id}
		<script language="javascript"> 
			change_game( {$_get.game_id|tointeger} ); 
		</script>
	{else}
		<script language="javascript"> 
			change_game( gamelist[0]["id"] ); 
		</script>
	{/if}
		
{/if}