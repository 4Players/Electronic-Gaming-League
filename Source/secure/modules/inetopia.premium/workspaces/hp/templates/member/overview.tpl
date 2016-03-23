<h2>Premium-Übersicht</h2> <br/>


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
	<tr bgcolor="{#clr_content#}"><td style="padding-left: 4px; padding-bottom:3px; padding-top:2px; font-family:arial,sans-serif;"> <b>Premium Mitgliedschaften:</b></td></tr>
	<tr> <td colspan="2"><img width="1" alt="" height="5"/></td> </tr>  
</table> 
<table cellpadding="10">
{section name=p loop=$PACKAGES}
<tr>
	<td><img src="files/premium_pool/{$PACKAGES[p]->enabled_image}"/></td>
	<td><a href="{$url_file}page={$CURRENT_MODULE_ID}:packages.info&package_id={$PACKAGES[p]->package_id}">{$PACKAGES[p]->name}</a>, läuft am {date timestamp=$PACKAGES[p]->expired} aus.</td>
</tr>
{sectionelse}
<tr><td>Keine Premium-Mitgliedschaft, <a href="{$url_file}page={$CURRENT_MODULE_ID}:member.register">Jetzt anfordern!</a></td></tr>
{/section}
</table>  	  		
  	  		

<table border="0" cellpadding="0" width="100%" cellspacing="0" border="0"> 
	<tr> <td colspan="2"><img width="1" alt="" height="15"/></td></tr> 
	<tr bgcolor="{#clr_content_border#}"><td><img width="1" alt="" height="1"/></td></tr> 
	<tr bgcolor="{#clr_content#}"><td style="padding-left: 4px; padding-bottom:3px; padding-top:2px; font-family:arial,sans-serif;"> <b>Bereits aktivierte Codes</b></td></tr>
	<tr> <td colspan="2"><img width="1" alt="" height="5"/></td> </tr>  
</table> 
  	  		
<table cellpadding="2">
{section name=code loop=$activated_codes}
<tr>
<td><a href="{$url_file}page={$CURRENT_MODULE_ID}:packages.info&package_id={$activated_codes[code]->package_id}">{$activated_codes[code]->name}</a>, Freischaltcode aktiviert am {date timestamp=$activated_codes[code]->activation_time}</td>
</tr>
{sectionelse}
<tr><td>Noch keine Aktivierungen vorhanden, <a href="{$url_file}page={$CURRENT_MODULE_ID}:member.register">Jetzt anfordern!</a></td></tr>
{/section}
</table>