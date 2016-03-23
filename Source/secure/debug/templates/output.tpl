<html>
<head>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=Windows-1252">
</head>
<body bgcolor="#FFFFFF">
<table border="0" cellpadding=4 cellspacing=0 width="100%">
 <tr>	
	<td colspan="2" bgcolor="#CFCFE5"> <font face=arial size=+3> Buildprotocol</font> </td>
 </tr>
 <tr>
 	<td width="1%" bgcolor="#EDEDF5">&nbsp;</td>
 	<td> <h3> <font face="Courier">------- BuildProcess has been started: Project: {$project_name}, Core: {$core_version} -------</font></h3><br/>
 	 	<table cellpadding="5">
	 	 <tr>
	 	 	<td><b>Build-Time:</b></td>
	 	 	<td>{date timestamp=$smarty.const.EGL_TIME}</td>
	 	  </tr>
	 	 <tr>
	 	 	<td><b>Parsed&nbsp;Page:</b></td>
	 	 	<td>{if strlen($module_id)>0}{$module_id}:{/if}{$page}</td>
	 	  </tr>
	 	 <tr>
	 	 	<td><b>Workspace:</b></td>
	 	 	<td>{$workspace}</td>
	 	  </tr>
	 	</table>
	 	
 	</td>
 </tr>
 <tr>	
	<td colspan="2" bgcolor="#DFDFE5"> <font face=arial size=+2> Message-Output</font> </td>
 </tr>
 <tr>
 	<td width="1%" bgcolor="#EDEDF5">&nbsp;</td>
 	<td>
		<table width="100%" cellpadding=4 cellspacing=1>
			<tr>
				<td width="1%"><font size="2" face="Courier"> <b>Bench:</b></font></td>
				<td width="50"><font size="2" face="Courier"> <b>Type:</b></font></td>
				<td><font size="2" face="Courier"> <b>File:</b></font></td>
				<td><font size="2" face="Courier"> <b>Line:</b></font></td>
				<td><font size="2" face="Courier"> <b>Message:</b></font></td>
			</tr>
		{section name=msg loop=$msgs}
		{if $msgs[msg]->type == $smarty.const.MSGTYPE_ERROR 	||
			$msgs[msg]->type == $smarty.const.MSGTYPE_WARNING 	||
			$msgs[msg]->type == $smarty.const.MSGTYPE_INFO }
			
			{if $msgs[msg]->type == $msgs[msg]->real_type}
				{if $msgs[msg]->type == $smarty.const.MSGTYPE_ERROR}
					<tr bgcolor="#FF0000">
				{elseif $msgs[msg]->type == $smarty.const.MSGTYPE_WARNING}
					<tr bgcolor="#FFFF00">
				{else}
					<tr bgcolor="#F1F1F1">
				{/if}
			{else}
					<tr bgcolor="#FF7200">
			{/if}
				<td><font size="2" face="Courier">{$msgs[msg]->bench_time}</a></font></td>
				
				
				{if $msgs[msg]->real_type == $smarty.const.MSGTYPE_ERROR}{assign var="real_type" value="Error"}{/if}
				{if $msgs[msg]->real_type == $smarty.const.MSGTYPE_WARNING}{assign var="real_type" value="Warning"}{/if}
				{if $msgs[msg]->real_type == $smarty.const.MSGTYPE_INFO}{assign var="real_type" value="Info"}{/if}
				
				{if $msgs[msg]->type == $smarty.const.MSGTYPE_ERROR}<td><font size="2" face="Courier"><b>Error</b> {if $msgs[msg]->type != $msgs[msg]->real_type}({$real_type}){/if}</font></td>{/if}
				{if $msgs[msg]->type == $smarty.const.MSGTYPE_WARNING}<td><font size="2" face="Courier"><b>Warning</b> {if $msgs[msg]->type != $msgs[msg]->real_type}({$real_type}){/if}</font></td>{/if}
				{if $msgs[msg]->type == $smarty.const.MSGTYPE_INFO}<td><font size="2" face="Courier">Info</font></td>{/if}
				
				<td><font size="2" face="Courier"><a href="javascript:alert('{$msgs[msg]->file}');" title="{$msgs[msg]->file}">{$msgs[msg]->basefile}</a></font></td>
				<td align="center"><font size="2" face="Courier">{$msgs[msg]->line}</font></td>
				<td><font size="2" face="Courier">{$msgs[msg]->msg}</font></td>
			</tr>
		{/if}
		{/section}
		</table>
 	</td>
 </tr>
 <tr>	
	<td colspan="2" bgcolor="#DFDFE5"> <font face=arial size=+2> Querys</font> </td>
 </tr>
 <tr>
 	<td width="1%" bgcolor="#EDEDF5">&nbsp;</td>
 	<td> 
		<table width="100%">
		{assign var="q_cnt" value="1"}
		{section name=msg loop=$msgs}
		
		{if $msgs[msg]->type == $smarty.const.MSGTYPE_QUERY}
		<tr>
			<td width="50" align="center" bgcolor="#f1f1f1">{$q_cnt}</td>
			<td> <font size='2' face="courier">{$msgs[msg]->msg|replace:"FROM":"<br>FROM"|replace:"LEFT JOIN":"<br>&nbsp;&nbsp;&nbsp;LEFT JOIN"|replace:"WHERE":"<br>WHERE"|replace:"ORDER BY":"<br>ORDER BY"|replace:"GROUP BY":"<br>GROUP BY"|replace:"ON":"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ON"|replace:"LIMIT":"<br>LIMIT"}</font></td></tr>
		<tr><td colspan="2"><hr size="1"/></td></tr>
		{assign var="q_cnt" value=$q_cnt+1}
		{/if}
		{/section}
		</table>
 	
 	</td>
 </tr>
 <tr>	
	<td colspan="2" bgcolor="#DFDFE5"> <font face=arial size=+2> Results</font> </td>
 </tr>
 <tr>
 	<td width="1%" bgcolor="#EDEDF5">&nbsp;</td>
 	<td> <font face="Courier"> BuildProtocol saved in `{$output_file}` <br/>
 	{$project_name} - {$error_counter} Errors, {$warning_counter} Warnings, {$query_counter} Querys, {$info_counter} Information</font><br/>
 	<b>BenchTime: {$bench_time}s
 	</td>
 </tr>
 <tr>	
	<td colspan="2" bgcolor="#CFCFE5"> <font face=arial size=+3> </font> </td>
 </tr>
</table>
 </body>
</html>