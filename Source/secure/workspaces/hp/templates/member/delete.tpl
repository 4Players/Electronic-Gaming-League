<h2>Account`{$member->nick_name}` löschen</h2>
Zur Zeit noch nicht Implementiert. <br/><br/>

<form name="f" action="{$url_file}page={$url_page}&a=go&key={$key}" method="POST">

<table border="0" cellpadding="5" cellspacing="1" align="center" width="400" bgcolor="{#clr_content_border#}">
 <tr>
  	<td colspan="2"> <b> Bestätigung:</b> </td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td width="35%"> <b>Key:</b> </td>
 	<td><font size=3 color="#A80000"> <b>{$key}</b> </font></td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td></td>
 	<td> <input type="text" class="egl_text" name="delmemb_key">  </td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td></td>
 	<td> <input type="checkbox" class="egl_checkbox" name="delmemb_check"> <b>bestätigen</b> </td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td></td>
 	<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Abschicken" link="javascript:document.f.submit();"}</td>
 </tr>
</table>


</form>
