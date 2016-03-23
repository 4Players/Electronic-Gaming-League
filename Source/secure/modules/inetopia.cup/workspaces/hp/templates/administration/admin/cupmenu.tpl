<table>
 <tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Übersicht" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.overview&cup_id=`$cup->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Konfiguration" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.configuration&cup_id=`$cup->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Teilnehmer" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.participants&cup_id=`$cup->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Turnierbaum" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.cuptree&cup_id=`$cup->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Administratoren" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.administrator&cup_id=`$cup->id`"}</td>
	<!--#<td>{include file="buttons/bt_universal.tpl" caption="Statistiken" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.admin.statistics&cup_id=`$cup->id`"}</td>#-->
</tr>
<tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Neues Turnier" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.new_cup&game_id=`$game->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Turnierübersicht" 	color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.gamecups&game_id=`$game->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Spielübersicht" 		color=$GLOBAL_COLOR link="`$url_file`page=`$CURRENT_MODULE_ID`:administration.overview"}</td>

 </tr>
</table>