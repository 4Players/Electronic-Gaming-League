<table>
 <tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Übersicht" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.overview&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Konfiguration" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.configuration&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Teilnehmer" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.participants&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Begegnungen" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.encounts&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Administratoren" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.administrator&ladder_id=`$ladder->id`"}</td>
</tr>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Neue Begegnung" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.newencount&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Neue Ladder" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.newladder&game_id=`$game->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Ladderübersicht" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.gameladders&game_id=`$ladder->game_id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Spielübersicht" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.overview"}</td>
<!--#<td>{include file="buttons/bt_universal.tpl" caption="Statistiken" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.statistics&ladder_id=`$ladder->id`"}</td>#-->
</tr></table>