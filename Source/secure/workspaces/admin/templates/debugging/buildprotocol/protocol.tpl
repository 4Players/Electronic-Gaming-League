<h2>Build Protokoll</h2>


<table border="0" cellpadding="5" cellspacing="1" width="100%">
 <tr bgcolor="{#clr_content#}">
 	<td width="200"><b>Protokoll Datei:</b></td>
 	<td>{$buildfile_root}</td>
 </tr>
 <tr bgcolor="{#clr_content#}">
 	<td width="200"><b>erstellt am:</b></td>
 	<td>{date timestamp=$buildfile_access}</td>
 </tr>
</table>
<br/><br/>

<b>Operationen:</b>
<table border="0" cellpadding="5" cellspacing="0" width="100%">
 <tr bgcolor="{#clr_content#}">
 	<td width="1%"><A title="Build Protokoll melden" href="{$url_file}page=debugging.buildprotocol.transmit&file={$buildfile}"><img src="images/admin/big_transmit.gif" border="0"/></a></td>
 	<td width="1%"><img src="images/spacer.gif" height="1" width="10"/>
 	<td width="1%">{*<A title="Build Protokol drucken [deaktiviert]" href="{$url_file}page=debugging.buildprotocol.print">*}<img src="images/admin/big_print_deactivated.gif" border="0"/>{*</a>*}</td>
 	<td></td>
 </tr>
</table>

<br/><br/>
<b>Protokoll:</b><br/>
<table border="1" cellpadding="5" cellspacing="1" bgcolor="#C0C0C0" width="100%">
 <tr bgcolor="#FFFFFF">
 	<td>{$buildfile_content}</td>
 </tr>
</table>
 	