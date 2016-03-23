<table>
  <tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Übersicht" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.overview&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Konfiguration" 	link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.configuration&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Teilnehmer" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.participants&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Begegnungen" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.encounts&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Administratoren" 	link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.administrator&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Fast-Challenger" 	link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.fastchallenger&ladder_id=`$ladder->id`"}</td>
	<!--#<td>{include file="buttons/bt_universal.tpl" caption="Statistiken" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.statistics&ladder_id=`$ladder->id`"}</td>#-->
  </tr>
  <tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Löschen" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.delete&ladder_id=`$ladder->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Regelwerk" 	link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.rules&ladder_id=`$ladder->id`"}</td>
  </tr>
</table>