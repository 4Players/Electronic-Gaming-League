{include file="devs/message.tpl"}
<h2>Veranstalter registrieren</h2>
{if !$success }

 <form name="f" action="{$url_file}page={$url_page}&a=register" method="POST">
 <table cellpadding="5" cellspacing="1" border="0" align="center" width="300" bgcolor="{#clr_content_border#}">
  <tr bgcolor="{#clr_content#}"><td>
	<table border="0" cellpadding="5" align="center" width="100%">
	 <tr>
	 	<td width="20%"><b>Name:</b></td>
	 	<td><input style="width:100%" type=text class="egl_text" name="name"></td>
	 </tr>
	 <tr>
	 	<td> <b>Homepage: </b></td>
	 	<td><input style="width:100%" type=text class="egl_text" name="hp" value="http://"></td>
	 </tr>
	 <tr>
	 	<td></td>
	 	<td>{include file="buttons/bt_universal.tpl" caption="abschicken" link="javascript:document.f.submit();" color=$GLOBAL_COLOR}</td>
	 </tr>
	</table>
	
 </td></tr>
 </table>
 
 </form>
 
 
 {/if}