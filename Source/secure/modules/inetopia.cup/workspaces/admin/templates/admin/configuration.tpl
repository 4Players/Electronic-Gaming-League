<table cellpadding="5"><tr>
	<td><table cellpadding="1" cellspacing="0" bgcolor="#000000"><tr><td><img src="{$PATH_GAMES}small/{$game->logo_small_file}" width="30" height="40"/></td></tr></table> </td>
	<td><h2>Turnier `{$cup->name|strip_tags|stripslashes}` Konfiguration</h2></td>
 </tr></table>
{include file="`$page_dir`/admin/cupmenu.tpl"}
<hr size="1"/>
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
	function change_game( game_id )
	{
		// clear matchstructurelist
		deleteSelectOptions( document.forms['cup_form'].matchstruct_id );
		
		var num_ms = 0;
		for( i=0; i < num_matchstructures; i++ )
		{
			if( game_id == matchstructures[i]["game_id"] )
			{
				document.forms['cup_form'].matchstruct_id.options[num_ms] = new Option( matchstructures[i]["name"], matchstructures[i]["id"] );
				num_ms++;
			}
		}//for
		
		if( num_ms == 0 ) document.forms['cup_form'].matchstruct_id.options[0] = new Option( "------------------", "-1" );

		// set game image
		for( g=0; g < num_games; g++ )
			if( gamelist[g]["id"] == game_id )
			{
				//document.images["game_pic"].src = gamelist[g]["image_file"];
			}
		
		
		// select game in selectlist
		var game_sel = document.forms['cup_form'].game_id;
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
		var ms_sel = document.forms['cup_form'].matchstruct_id;
		var ms_lngth = ms_sel.length;
		for (i=0; i <ms_lngth; i++)
			if( ms_sel.options[i].value == matchstruct_id )
				ms_sel.options[i].selected = true;
	}
	
	function show_matchstructure(url){
		//alert( document.forms['ladder_form'].matchstruct_id.options
		var __msid = document.forms['cup_form'].matchstruct_id.options[ document.forms['cup_form'].matchstruct_id.selectedIndex ].value;
		if( __msid == -1 )document.location.href = url+"page=cms.match_structures.overview";
		else document.location.href = url+"page=cms.match_structures.admin&ms_id="+__msid;
	}
	function show_category(url){
		var __catid = document.forms['cup_form'].cat_id.options[ document.forms['cup_form'].cat_id.selectedIndex ].value;
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
		if( confirm(question) ){
			add_current_to_pagestore();
		}//if
	}
</script>
{/literal}

<form name="cup_form" action="{$url_file}page={$url_page}&cup_id={$cup->id}&a=change" method="post">
<table width="100%" background="images/modules/inetopia_cup/cup_configure.gif" style="background-repeat:no-repeat;" cellpadding="20">
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
			 	<td width="100"><b>Turnier Name:</b></td>
			 	<td><input name="name" type="text" class="egl_text" style="width:400;" value="{$cup->name|strip_tags|stripslashes}"></td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td width="200"><b>Land:</b></td>
			 	<td><select name="country_id" class="egl_select" style="width:400px;">
			 			{section name=c loop=$countries}
			 				<option {if $cup->country_id == $countries[c]->id}selected{/if} value="{$countries[c]->id}">{$countries[c]->name}</option>
			 			{/section}
			 		</select>
			 	</td>
			 </tr>			 
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Kategorie:</b></td>
				<td><table><tr>
					<td>
					<select style="width:400;" name="cat_id" class="egl_select">
						<option value="-1">Bitte Kategorie wählen</option>					
						<option disabled >------------------------------------</option>					
						{defun name="testrecursion" catroot=$categoryroot level="0"}
						    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $cup->cat_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
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
			 {if $cup->matchstruct_id == -1}<tr bgcolor="FFDB96">
			 {else}<tr bgcolor="{#clr_content#}">{/if}
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
			 	<td><b>Teilnehmer-Art:</b></td>
			 	<td> <select name="participant_type" class="egl_select" style="width:250;">
			 	 		<option value="{$smarty.const.PARTTYPE_MEMBER}">Member</option>
			 	 		<option {if $cup->participant_type == $smarty.const.PARTTYPE_TEAM}selected{/if} value="{$smarty.const.PARTTYPE_TEAM}">Team</option>
			 		</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Modus:</b></td>
			 	<td> <select class="egl_select" style="width:250;">
			 	 		<option value="single">Single-Elimination</option>
			 	 		<!--#<option disabled value="double">Double-Elimination</option>#-->
			 	 		<!--#<option disabled value="groups">Groups</option>#-->
			 		</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Turnier startet am:</b></td>
			 	<td><input value="{date format='%d.%m.%Y' timestamp=$cup->start_time}" name="start_time_date" size="15" type="text" class="egl_text"> Clock: <input size="10" value="{date format='%H:%M' timestamp=$cup->start_time}" name="start_time_clock" type="text" class="egl_text"/> </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Checkin-Time:</b></td>
			 	<td><input name="checkin_time" type="text" class="egl_text" value="{$cup->checkin_time}" size="12"/> <i>(mins)</i> </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Anz. Teilnehmer:</b></td>
			 	<td>
			 		<select style="width:250;" name="max_participants" class="egl_select">
				 		{section name=num_players loop= 12 }
		
					 		{math equation="pow(x,y)" x=2 y=$smarty.section.num_players.index assign="player_count"}
					 		{if $player_count == $cup->max_participants}
				 				<option selected value="{$player_count}">{$player_count}er Baum</option>
				 			{else}
				 				<option value="{$player_count}">{$player_count}er Baum </option>
				 			{/if}
				 		{/section}
				 	</select>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Team Members:</b></td>
			 	<td><input name="num_team_members" type="text" class="egl_text" size="12" value="{$cup->num_team_members}" />
			 		(Nur für Team Mode) </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Check GameAccounts:</b></td>
			 	<td><select name="check_gameacc_id" class="egl_select" style="width:100;">
			 			<option value="1">Ja</option>
			 			{if !$cup->check_gameacc_id}<option selected value="0">Nein</option>{else}<option value="0">Nein</option>{/if}
			 		</select>
			 	</td>		 
			 </tr>
			 <!--#
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Regeln:</b></td>
			 	<td>----</td>
			 </tr>
			 #-->
			 <tr bgcolor="{#clr_content#}">
			 	<td><b>Öffentlich:</b></td>
			 	<td><select style="width:100;" name="is_public" class="egl_select">
			 			<option value="1">Ja</option>
			 			<option value="0">Nein</option>
			 			{if !$cup->is_public} <option selected value="0">Nein</option> {/if}
			 		</select>
			 	</td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td valign="top"><b>Map -Pool:</b></td>
			 	<td><textarea class="egl_text" name="map_pool" style="width:250;" cols="40">{$cup->map_pool|strip_tags}</textarea> </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td valign="top"><b>Beschreibung:</b></td>
			 	<td><textarea style="width:100%;"name="description" class="egl_text" rows="10" cols="80">{$cup->description|strip_tags}</textarea></td>
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
	
	{if $cup }
		<script language="javascript"> 
			change_game( {$cup->game_id} );
			change_matchstructure( {$cup->matchstructure_id} );
		</script>
	{else}
		<script language="javascript"> 
			change_game( gamelist[0]["id"] ); 
		</script>
	{/if}
	
{/if}