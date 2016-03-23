<table width="100%">
{section name=game loop=$gamelist}
 <tr>
 	<td width="1%" valign="top"><img style="border-color:#000000;" border="1" src="{$PATH_GAMES}small/{$gamelist[game]->logo_small_file}" width="60" height="80"/></td>
 	<td valign="top">
		<table width="100%" cellpadding="5" cellspacing="0">
		 <tr>
		 	<td><h2>{$gamelist[game]->name}</h2>({$gamelist[game]->token})</td>
		 </tr>
		 	<td align="left">{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c3010 color=$GLOBAL_COLOR link="`$url_file`page=gameview.summary&game_id=`$gamelist[game]->id`"}</td>
		 <tr>
		 </tr>
		</table>
 	</td>
 </tr>
 {if !$smarty.section.game.last}<tr><td colspan="2">{include file="devs/hr2.tpl" width="100%"}</td></tr>{/if}
 {/section}
</table>