<table>
 <tr>
	<td>{include file="buttons/bt_universal.tpl" caption="Übersicht" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.overview&cup_id=`$cup->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Konfiguration" 	link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.configuration&cup_id=`$cup->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Teilnehmer" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.participants&cup_id=`$cup->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Turnierbaum" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.cuptree&cup_id=`$cup->id`"}</td>
	<td>{include file="buttons/bt_universal.tpl" caption="Administratoren" 	link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.administrator&cup_id=`$cup->id`"}</td>
	<!--#<td>{include file="buttons/bt_universal.tpl" caption="Statistiken" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.statistics&cup_id=`$cup->id`"}</td>#-->
 </tr>
 <tr>
 	<td>{include file="buttons/bt_universal.tpl" caption="Löschen" 			link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.delete&cup_id=`$cup->id`"}</td>
 	<td>{include file="buttons/bt_universal.tpl" caption="Regelwerk" 		link="`$url_file`page=`$CURRENT_MODULE_ID`:admin.rules&cup_id=`$cup->id`"}</td>
 
 </tr>
</table>