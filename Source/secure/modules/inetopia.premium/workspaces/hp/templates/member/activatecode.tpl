<h2>Premium freischalten</h2>
{include file="devs/message.tpl"}

<table cellpadding="5">
 <tr>
 	<td align="center"><a href="{$url_file}page={$CURRENT_MODULE_ID}:member.activatecode"><img border="0" src="images/premium_addcode.gif"/></a></td>
 	<td align="center"><a href="{$url_file}page={$CURRENT_MODULE_ID}:member.coderequest"><img border="0" src="images/premium_newcode.gif"/></a></td>
 </tr>
 <tr>
 	<td align="center">Code freischalten</td>
 	<td align="center">Freischaltcode anfordern</td>
 </tr>
</table>


<table border="0" cellpadding="0" width="100%" cellspacing="0" border="0"> 
	<tr> <td colspan="2"><img width="1" alt="" height="15"/></td></tr> 
	<tr bgcolor="{#clr_content_border#}"><td><img width="1" alt="" height="1"/></td></tr> 
	<tr bgcolor="{#clr_content#}"><td style="padding-left: 4px; padding-bottom:3px; padding-top:2px; font-family:arial,sans-serif;"> <b>Hier kannst du dich als Premium-Mitglied freischalten:</b></td></tr>
	<tr> <td colspan="2"><img width="1" alt="" height="5"/></td> </tr>  
</table> 

{if !$SUCCESS}
<form name="f" action="{$url_file}page={$url_page}&a=activate" method="POST">
<table cellpadding="5" cellspacing="1">
 <tr>
 	<td>Freischaltcode:</td>
 	<td><input type="text" class="egl_text" style="width:200px;" name="code"/></td>
 	<td colspan="2">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}
 </tr>
</table>
</form>
{/if}