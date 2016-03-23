{include file="devs/message.tpl"}
<h2>Protest löschen</h2>
{include file="devs/hr_black.tpl" type="1" width="100%"}

<table cellpadding="5">
 <tr>
 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Proteste-Übersicht"  	link="javascript:document.location.href='`$url_file`page=administration.protests.overview';"}</Td>
 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Proteste-Details"  	link="javascript:document.location.href='`$url_file`page=administration.protests.admin&protest_id=`$protest->id`';"}</Td>
 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="löschen" 				link="javascript:document.location.href='`$url_file`page=administration.protests.delete&protest_id=`$protest->id`';"}</Td>
 </tr>
</table>
<br/><br/><br/>

<table cellpadding="10"><tr>
	<td>Hiermit möchte Ich den Protest löschen</td>
	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="weiter" link="javascript:document.location.href='`$url_file`page=administration.protests.delete&protest_id=`$protest->id`&a=go';"}
</tr></table>