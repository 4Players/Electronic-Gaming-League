<h2>Ladder</h2>

<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}"> 
 <tr>
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
		 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
		 onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';">
 		<table cellpadding="5" cellspacing="0">
 		 <tr>
 		 	<td><img src="images/games_icon.gif" height="64" width="64"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:overview"><b>Spielübersicht</b></a></td>
 		 </tr>
 		</table>
 	</td>
 {if isset($game)}
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
		 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
		 onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';">	 
 		<table cellpadding="5" cellspacing="0">
 		 <tr>
 		 	<td><img src="images/modules/inetopia_ladder/ladder_icon.gif"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:gameladders&game_id={$game->id}"><b>Ladderübersicht</b></a></td>
 		 </tr>
 		</table>
 	</td>
 {/if}
 {if isset($game) }
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
		 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
		 onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';" >
 		<table cellpadding="5" cellspacing="0">
 		 <tr>
 		 	<td><img src="images/modules/inetopia_ladder/ladder_add.gif"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:newladder&game_id={$game->id}"><b>Neue Ladder</b></a></td>
 		 </tr>
 		</table>
 	</td>
 {/if}
 <!--#<td><img src="images/spacer.gif" width="1"/></td>#-->
 {if isset($ladder)}
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
	 	onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
	 	onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';">
 		<table cellpadding="5" cellspacing="0">
 		 <tr>
 		 	<td><img src="images/modules/inetopia_ladder/ladder_encount_add.gif"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:admin.newencount&game_id={$game->id}&ladder_id={$ladder->id}"><b>Neue Begegnung</b></a></td>
 		 </tr>
 		</table>
 	</td>
 {/if}
 </tr>
</table>
<br/>

{include file="tb/page.open.tpl"}
	{include file="$module_file"}
{include file="tb/page.close.tpl"}