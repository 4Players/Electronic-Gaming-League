<h2>Build Protokolle</h2>


{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}
</script>
{/literal}

<table border="0" cellpadding="7" cellspacing="1" width="100%">
 <tr bgcolor="{#clr_content_border#}">
 	<td  colspan="2" width="1%"><img src="images/spacer.gif" width="25"/></td>
 	<td><b>Protokoll</b></td>
 	<td width="200"><b>automatisch erstellt am:</b></td>
 </tr>
	<tr background="images/admin/list_header_bg" style="background-repeat:repeat-y;" bgcolor="#EAE7E0">
		<td colspan="4">Reguläre Build Protokolle</td>
	</tr>
{section name=bfile loop=$buildfiles}
 <tr bgcolor="{#clr_content#}" onclick="javascript:document.location='{$url_file}page=debugging.buildprotocol.protocol&file={$buildfiles[bfile].file}&a=show';" onmouseover="load_bgcolor(this, '#F9F9F9');" onmouseout="load_bgcolor(this, '');">
 	<!--#<td><A title="Protokoll löschen" href="{$url_file}page=debugging.buildprotocol.protocol&file={$buildfiles[bfile].file}&a=delete"><img border="0" src="images/admin/small_delete.gif"/></a></td>#-->
 	<td><A title="Protokoll übermitteln" href="{$url_file}page=debugging.buildprotocol.transmit&file={$buildfiles[bfile].file}&a=transfer"><img border="0" src="images/admin/send.gif"/></a></td>
 	<td><A title="Protokoll anschauen" href="{$url_file}page=debugging.buildprotocol.protocol&file={$buildfiles[bfile].file}&a=show"><img border="0" src="images/admin/navi/protocol.gif"/></a></td>
 	<td><A title="Build Datei anschauen"  href="{$url_file}page=debugging.buildprotocol.protocol&file={$buildfiles[bfile].file}">{$buildfiles[bfile].file}</a></td>
 	<td>{date timestamp=$buildfiles[bfile].access}</td>
 </tr>
{/section}
	{*<tr bgcolor="{#clr_content#}" align="left">
		<td colspan="4"> <A href="{$url_file}page=debugging.buildprotocol."><b>Alle löschen</b></a> | <A href=""><b>Neu auflisten</b></a> </td>
	</tr>*}
	<tr background="images/admin/list_header_bg" style="background-repeat:repeat-y;" bgcolor="#EAE7E0">
		<td colspan="4"><font color="#A80000"><b>Spontane Build Protokolle</b></font></td>
	</tr>
{section name=bfile loop=$offhanded_buildfiles}
 <tr bgcolor="{#clr_content#}" onclick="javascript:document.location='{$url_file}page=debugging.buildprotocol.protocol&file=offhanded/{$offhanded_buildfiles[bfile].file}&a=show';" onmouseover="load_bgcolor(this, '#F9F9F9');" onmouseout="load_bgcolor(this,'');">
 	<!--#<td><A title="Protokoll löschen" href="{$url_file}page=debugging.buildprotocol.protocol&file=offhanded/{$offhanded_buildfiles[bfile].file}&a=delete"><img border="0" src="images/admin/small_delete.gif"/></a></td>#-->
 	<td><A title="Protokoll übermitteln" href="{$url_file}page=debugging.buildprotocol.transmit&file=offhanded/{$offhanded_buildfiles[bfile].file}&a=transfer"><img border="0" src="images/admin/send.gif"/></a></td>
 	<td><A title="Protokoll anschauen" href="{$url_file}page=debugging.buildprotocol.protocol&file=offhanded/{$offhanded_buildfiles[bfile].file}&a=show"><img border="0" src="images/admin/navi/protocol.gif"/></a></td>
 	<td><A title="Build Datei anschauen"  href="{$url_file}page=debugging.buildprotocol.protocol&file=offhanded/{$offhanded_buildfiles[bfile].file}">{$offhanded_buildfiles[bfile].file}</a></td>
 	<td>{date timestamp=$offhanded_buildfiles[bfile].access}</td>
 </tr>
{/section}
{if sizeof($offhanded_buildfiles) == 0}
	<tr bgcolor="{#clr_content#}">
		<td colspan="4">Keine weiteren Protokolle erstellt</td>
	</tr>
{else}
	{*<tr bgcolor="{#clr_content#}" align="left">
		<td colspan="4"> <A href=""><b>Alle löschen</b></a> | <A href=""><b>Neu auflisten</b></a> </td>
	</tr>*}
{/if}
</table>
<br/><br/>

<table width="100%" cellpadding="0" cellspacing="2" bgcolor="#C0C0C0">
 <tr><td>
	<table width="100%" bgcolor="{#clr_content#}" cellpadding="5" cellspacing="1">
	 <tr><td>Achtung: Build-Protokolle werden direkt im FTP verwaltet/gelöscht. Zu finden in <b>EGL_ROOT/secure/debug/output/<u>offhanded</u>/</b></td></tr>
	</table>
 </td></tr>
</table>