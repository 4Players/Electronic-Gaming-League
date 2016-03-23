<h2>Turnier erstellen</h2>
<table>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Neues Turnier" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.new_cup&game_id=`$game->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Turnierübersicht" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.gamecups&game_id=`$game->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Spielübersicht" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.overview"}</td>

 </tr>
</table>

<script language="javascript">
    // copyright (c)2006 inetopia.de. all rights reserved. alle rechte vorbehalten
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
	gamelist[{$smarty.section.game.index}]["name"] = "{$games[game]->name|stripslashes|strip_tags}";
	//gamelist[{$smarty.section.game.index}]["image_file"] = "{$PATH_GAMES}/small/{$games[game]->logo_small_file}";
	gamelist[{$smarty.section.game.index}]["image_file"] = "files/game_pool/small/{$games[game]->logo_small_file}";
	{/section}	
	
</script>
{literal}
<!-- script language="javascript" src="javascript/browser_handling.js"></script -->
<script language="javascript">
    // copyright (c)2006 inetopia.de. all rights reserved. alle rechte vorbehalten
	function deleteSelectOptions(field){
		var lngth = field.length;
		for (i=0; i <lngth; i++){
			field.options[field.length-1] = null;
		}
	}
	function change_game( game_id ){
		// clear matchstructurelist
		deleteSelectOptions( document.forms['cup_form'].matchstruct_id );
		
		var num_ms = 0;
		for( i=0; i < num_matchstructures; i++ ){if( game_id == matchstructures[i]["game_id"] ){
				document.forms['cup_form'].matchstruct_id.options[num_ms] = new Option( matchstructures[i]["name"], matchstructures[i]["id"] );
				num_ms++;
			}
		}//for
		
		if( num_ms == 0 ) document.forms['cup_form'].matchstruct_id.options[0] = new Option( "------------------", "-1" );

		// set game image
		for( g=0; g < num_games; g++ )
			if( gamelist[g]["id"] == game_id ){
				/*
				removed
				*/
				//alert(gamelist[g]["image_file"]);
				//document.images["game_pic"].src = gamelist[g]["image_file"];
				//_getElementbyID("game_pic").src = gamelist[g]["image_file"];
				//alert( _getElementbyID("game_pic").src );
			}
		
		
		// select game in selectlist
		var game_sel = document.forms['cup_form'].game_id;
		var game_lngth = game_sel.length;
		for (i=0; i <game_lngth; i++)
			if( game_sel.options[i].value == game_id )
				game_sel.options[i].selected = true;
	}
</script>
{/literal}

{include file="devs/message.tpl"}
{if !$success}
<form name="cup_form" action="{$url_file}page={$url_page}&a=go" method="POST">
<table border="0" width="100%" cellpadding="20" background="images/modules/inetopia_cup/cup_add_small.gif" style="background-repeat:no-repeat;">
 <tr><td>
 	<br/>
	<table border="0" cellpadding="0" cellspacing="1" bgcolor="#C0C0C0" width="100%">
	 <tr><td bgcolor="#FFFFFF">
		<table border="0" width="100%" width="100%" cellpadding="5" cellspacing="1">

		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Spiel:</b></td>
		 	<td>
		 		 <select onchange="javascript:change_game(this.value);" name="game_id" class="egl_select" style="width:350;">
		 		 {section name=game loop=$games}
		 		 	<option value="{$games[game]->id}">{$games[game]->name}</option>
		 		 {/section}
		 		</select>
		 	</td>
		 <tr bgcolor="{#clr_content#}">
		 	<td width="100"><b>Turnier Name:</b></td>
		 	<td><input name="name" type="text" class="egl_text" style="width:350;"></td>
		 </tr>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Kategorie:</b></td>
			<td><select style="width:350;" name="cat_id" class="egl_select">
					<option value="-1">Bitte Kategorie wählen</option>					
					<option disabled >------------------------------------</option>					
					{defun name="testrecursion" catroot=$categoryroot level="0"}
					    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $cup->cat_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
						{foreach from=$catroot->aNodes item=node} 
							{fun name="testrecursion" catroot=$node level=$level+1 }
						{/foreach}
					{/defun}
			 </select>		
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
			<td><select name="matchstruct_id" class="egl_select" style="width:350;">
					<option value="-1">Bitte Spiel wählen</option>
			 </select>		
			</td>	 
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Teilnehmer-Art:</b></td>
		 	<td> <select name="participant_type" class="egl_select" style="width:250;">
		 	 		<option value="{$smarty.const.PARTTYPE_MEMBER}">Member</option>
		 	 		<option value="{$smarty.const.PARTTYPE_TEAM}">Team</option>
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
		 	<td><input value="{date format='%d.%m.%Y'}" name="start_time_date" size="15" type="text" class="egl_text"> Clock: <input size="10" value="{date format='%H:%M'}" name="start_time_clock" type="text" class="egl_text"> </td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Checkin-Time:</b></td>
		 	<td><input name="checkin_time" type="text" class="egl_text" size="12" value="60"> <i>(mins)</i> </td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Anz. Teilnehmer:</b></td>
		 	<td>
		 	<select name="max_participants" style="width:250;" class="egl_select">
		 		{section name=num_players loop= 12 }
		 			<option value="{math equation="pow(x,y)" x=2 y=$smarty.section.num_players.index}">{math equation="pow(x,y)" x=2 y=$smarty.section.num_players.index}er Baum</option>
		 		{/section}
		 	</select>
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Team Members:</b></td>
		 	<td><input name="num_team_members" type="text" class="egl_text" size="12" value="4" >
		 		<b>Nur für (Clan)Team Mode</b> </td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Check GameAccounts:</b></td>
		 	<td><select name="check_gameacc_id" class="egl_select" style="width:100;">
		 			<option value="1">Ja</option> 	
		 			<option value="0">Nein</option>
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
		 	<td><select name="is_public" class="egl_select" style="width:100;">
		 			<option value="1" selected>Ja</option> 	
		 			<option value="0">Nein</option>
		 		</select>
		 	</td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Map -Pool:</b></td>
		 	<td><textarea class="egl_text" name="map_pool" style="width:250;" cols="40"></textarea> </td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Beschreibung:</b></td>
		 	<td><textarea style="width:100%;"name="description" class="egl_text" rows="10" cols="80"></textarea></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}"><td colspan="2"><hr size="1" color="{#clr_content_header#}"></td></tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td></td>
		 	<td align="right"><input type="image" src="images/buttons/new/bt_send.gif" ></td>
		 </tr>
		</table>
	 </td></tr>
	</table>
	
 </td>
 </tr>
</table>	
</form>
{/if}


{if $_get.game_id}
	<script language="javascript"> 
		change_game( {$_get.game_id} ); 
	</script>
{else}
	<script language="javascript"> 
		change_game( gamelist[0]["id"] ); 
	</script>
{/if}
