<h2>Datenbank &#x95; Synchronisieren</h2>

{literal}
<script language="javascript">
<!--

function ShowHide(id) {
    obj = document.getElementsByTagName("div");
    if (obj[id].style.display == 'block'){
    obj[id].style.display = 'none';
    }
    else {
    obj[id].style.display = 'block';
    }
}
	
-->
</script>
<style type="text/css">
		A.sql_link:link,A.sql_link:active
		{ COLOR: #000000; text-decoration: none; font-size: 15px; FONT-FAMILY: arial;}
		A.sql_link:visited
		{ COLOR: #000000; text-decoration: none; font-size: 15px; FONT-FAMILY: arial;}
		A.sql_link:hover
		{ COLOR: #000000; text-decoration:underline; font-size: 15px; FONT-FAMILY: arial;}
</style>
{/literal}

<form action="{$url_file}page={$url_page}&a=sync" method="POST">
<table cellpadding="5"><tr>
	<td><b>URI:</b></td>
	<td><input type="text" value="{$smarty.post.sync_file|stripslashes}" name="sync_file" style="width:400px;" ></td>
	<td><input type="submit" value="vorschau"/></td>
</tr></table>
</form>
{if isset($SQL_QUERYS) }
	<hr/>
	{if !$DO_SYNC}	
		<b>VORSCHAU</b><br/>
		Insgesamt {$SQL_QUERYS|@count} Modifikationen gefunden!
		<form name="f" action="{$url_file}page={$url_page}&a=do_sync" method="POST">
		<input type="hidden" name="sync_file" value="{$smarty.post.sync_file|stripslashes}"/>
		<table width="100%">
		<tr><td>	
				<table width="100%" cellpadding="1" cellspacing="0">
				{section name=sql loop=$SQL_QUERYS}
				<tr><td valign="top" bgcolor="#F0F0F0" width="20"><font style="font-size:15px">{$smarty.section.sql.index+1}</font></td>
					<td>
					<div style="padding:5px; background-color:#E0E7FF;"><a class="sql_link" href="javascript:ShowHide('sql_query{$smarty.section.sql.index}');">{$SQL_QUERYS[sql].description}</a></div>
				 	<div id="sql_query{$smarty.section.sql.index}" style="display:none;">
				 		<font style="font-size:11px;font-family:courier new;">{$SQL_QUERYS[sql].query|nl2br}</font>
					</div>	
					</td>
				</tr>
				{/section}
				</table>
		</td><td valign="top">
		</td></tr>
		</table>
		
		<table><tr>
		 	<td><input type="submit" value="synchronisieren"/>
		</tr></table>
		</form>
	{else}
		<b>SYNCHRONISATION DURCHGEFÜHRT</b><br/>
		Insgesamt <b>{$QUERYS_OK}</b> von {$SQL_QUERYS|@count} Modifikationen übernommen
		<form name="f" action="{$url_file}page={$url_page}&a=do_sync" method="POST">
		<table width="100%">
		<tr><td>	
				<table width="100%" cellpadding="1" cellspacing="0">
				{section name=sql loop=$SQL_QUERYS}
				<tr><td valign="top" bgcolor="#F0F0F0" width="20"><font style="font-size:15px">{$smarty.section.sql.index+1}</font></td>
					<td>
					
					{if isset($SQL_QUERYS[sql].error)}
						<div style="padding:5px; background-color:#FFEBD4;"><a class="sql_link" href="javascript:ShowHide('sql_query{$smarty.section.sql.index}');">{$SQL_QUERYS[sql].description}</a></div>
					{else}			
						<div style="padding:5px; background-color:#E8FFD4;"><a class="sql_link" href="javascript:ShowHide('sql_query{$smarty.section.sql.index}');">{$SQL_QUERYS[sql].description}</a></div>
					{/if}
					{if isset($SQL_QUERYS[sql].error)}
					 	<div id="sql_query{$smarty.section.sql.index}" style="display:block;">
					 		<font style="font-size:11px;font-family:courier new;">{$SQL_QUERYS[sql].query|nl2br}</font><br/>
							<div style="padding:2px; background-color:#FFD4D4;">
								<font style="font-size:13px;font-family:courier new;"><b>ERROR: {$SQL_QUERYS[sql].error}</b></font>
							</div>
						</div>	
					{else}
					 	<div id="sql_query{$smarty.section.sql.index}" style="display:none;">
					 		<font style="font-size:11px;font-family:courier new;">{$SQL_QUERYS[sql].query|nl2br}</font>
							<div style="padding:2px; background-color:#D6FFD4;">
								<font style="font-size:13px;font-family:courier new;"><b>SQL-Befehl wurde erfolgreich ausgeführt</b></font>
							</div>
						</div>	
					{/if}
					</td>
				</tr>
				{/section}
				</table>
		</td><td valign="top">
		</td></tr>
		</table>
		
	{/if}
{/if}
