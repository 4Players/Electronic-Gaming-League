<h2>Turniere</h2>

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
 		 	<td><img src="images/modules/inetopia_cup/cups.gif"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:gamecups&game_id={$game->id}"><b>Turnierübersicht</b></a></td>
 		 </tr>
 		</table>
 	</td>
 {/if}
 {if isset($game) }
 	<td width="25%" align="center"
 		bgcolor="{#clr_content#}"
		 onmouseover="javascript:this.style.backgroundColor='#FFFFFF';"
		 onmouseout="javascript:this.style.backgroundColor='{#clr_content#}';" >
 		<table cellpadding="5" cellspacing="0" border="0">
 		 <tr>
 		 	<td><img src="images/modules/inetopia_cup/cup_add_small.gif"/></td>
 			<td><A href="{$url_file}page={$CURRENT_MODULE_ID}:new_cup&game_id={$game->id}"><b>Turnier erstellen</b></a></td>
 		 </tr>
 		</table>
 	</td>
 {/if}
 <!--#<td><img src="images/spacer.gif" width="1"/></td>#-->
 </tr>
</table>
<br/>


<br/>
{include file="tb/page.open.tpl"}
	{include file="$module_file"}
{include file="tb/page.close.tpl"}