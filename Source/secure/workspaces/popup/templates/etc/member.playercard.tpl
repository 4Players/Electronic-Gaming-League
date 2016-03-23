 <table border=0 bgcolor="#000000" cellpadding="0" cellspacing="1">
  <tr><td>
	<table border="0" background="images/player_card.png" style="" width="400" height="195" bgcolor="#FFFFFF" cellpadding="5" cellspacing="1">
	<tr>
		<td colspan="2"> 
			<table border=0><tr>
			 	<td width="1%"><img src="images/spacer.gif" height="100" width="1"></td>
			 	<td><font size="8"> <i>	<font color="#000000">Player-Card</i> </font></td>
			 </tr></table>
		</td>
	</tr>
	 <tr>
	 	<td width="70%" align="right" valign="top">
	 	 	<font color="#000000">
	 	 	
	 	 	<font face="Verdana" size="4"><b>
			{$player_card_data->first_name}
			{$player_card_data->next_name} <br> 
	 		
	 		`{$player_card_data->nick_name}` <br>
	 		</font>
	 		{section name=country loop=$countries}
	 			{if $player_card_data->country_id == $countries[country]->id}
	 				<img src="{$path_country}{$countries[country]->image_file}">
	 				<i>({$countries[country]->name})</i>
	 			{/if}
	 		{/section}
	 	 	
	 		
	 		</b><br>
			<b>Registriert seit <u>{date timestamp=$player_card_data->created format="%d.%m.%Y"}</u></i></b> <br>
	 		
	 			
	 		</font>	
	 	</td>
	 	<td>  
	 		<table border=0 bgcolor="{#clr_content_border#}" cellpadding="0" cellspacing="1">
	 		 <tr><td>
	 		{if $player_card_data->photo_file != 'non'}
		 		<img src="{$path_photos}{$player_card_data->photo_file}" width="100" height="133">
		 	{else}
		 		<img src="images/photo.na.jpg" width="100" height="133">
	 		{/if}
	 		</td></tr>
	 		</table>	 	
	 	</td>
	 </tr>
	 <tr>
	 	<td valign="top" colspan="2"> 
	 	
	 		<!--
				SHOW CLANS
							-->
	 		 <table border="0" width="100%">
	 			<tr>
	 				<td><font color="#000000"><b>Clans:</b></font></td>
	 				<td><font color="#000000">
						{section name=clan loop=$player_card_clans}
						 	<b>{$player_card_clans[clan]->name}</b>
						 	{if $smarty.section.clan.index < sizeof($player_card_clans)-1 },{/if}
						{/section}
			
						{if !sizeof($player_card_clans) }
							<i>Keine</i>
						{/if}
			 		</font>
	 				<td>
				 </tr>
				</table>		


		</td>
	  </tr>
	  <tr>
	 	<td  valign="top" colspan="2"> 
	 		<!--
				SHOW GAMES
						-->
	 		<font color="#000000">
	 		<u><b>Games:</b></u>

	 		
	 		<br><br>
	 		
	 		
	 		{section name=game loop=$player_card_games}
	 			{if $player_card_games[game]->logo_small_file != 'non'}
	 				<a title="{$player_card_games[game]->name}" href="{$url_file}page=game.info&game_id={$player_card_games[game]->id}"><img border="0" src="{$path_games}small/{$player_card_games[game]->logo_small_file}" alt="{$player_card_games[game]->name}" width="45" height="60"></a>
	 			{else}
	 				<a href="{$url_file}page=game.info&game_id={$player_card_games[game]->id}"><img border="0" src="images/logo.na.jpg" alt="{$player_card_games[game]->name}" width="45" height="60"></a>
	 			{/if}
	 		{/section}
	 		
			{if !sizeof($player_card_games) }
				<i>Keine</i>
			{/if}
	 		
	 		
	 		<br><br><BR>
	 		</font>
	 	</td>
	 </tr>
	 <tr>
	 	<td colspan="2" bgcolor="#FFFFFF" align="center"> <img src="images/player_card_sign.jpg" width="200">	 </td>
	 </tr>
	 
	</table>
 </td></tr>
</table>
	