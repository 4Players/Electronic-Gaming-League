<html>
	<head>
		<title>EGL Devzone - (c)2006 by Inetopia</title>
		{literal}
		<style type="text/css">
		BODY 
		{ FONT-FAMILY: arial,sans-serif;}
		
		A:link,A:active
		{ COLOR: #000000; text-decoration: none;font-size: 11px; FONT-FAMILY: arial;}
		A:visited
		{ COLOR: #000000; text-decoration: none; font-size: 11px; FONT-FAMILY: arial;}
		A:hover
		{ COLOR: #000000; text-decoration: underline; font-size: 11px; FONT-FAMILY: arial;}	

		A.header_menu:link,A.header_menu:active
		{ COLOR: #000000; text-decoration: none;font-weight:bold;font-size: 12px; FONT-FAMILY: arial;}
		A.header_menu:visited
		{ COLOR: #000000; text-decoration: none; font-weight:bold;font-size: 12px; FONT-FAMILY: arial;}
		A.header_menu:hover
		{ COLOR: #000000; text-decoration:underline; font-weight:bold; font-size: 12px; FONT-FAMILY: arial;}
		</style>
		{/literal}
		</head>
<body>
	<table cellpadding="5" cellspacing="2" bgcolor="#FF5500" width="100%" border="0">
	 <tr background="images/header_bg.jpg" style="background-position:left top; background-repeat:no-repeat;" bgcolor="#FFFFFF">
	 	<td>
	 		<table border="0" width="100%">
	 		<tr><td>
	 			<img src="images/spacer.gif" width="1" height="110"/>
		 		<!--#<font style="font-size:30px;font-weight:bold;">Electronic Gaming League - Devzone</font> <br/>
		 		<b>Software Development Kit</b><br/>#-->
		
	 		</td>
	 		<td align="right" valign="bottom">
	 			<table height="110" border="0">
	 			 <tr>
	 			 	<td valign="top" align="right">
	 					<select ONCHANGE="javascript:document.location.href = '{$url_file}page=language&route_page={$url_page}&lng='+this.options[this.selectedIndex].value;">
							{section name=lng loop=$SUPPORTED_LNG}
								<option {if $LANGUAGE == $SUPPORTED_LNG[lng].token}selected{/if} value="{$SUPPORTED_LNG[lng].token}">{$SUPPORTED_LNG[lng].name}</option>
							{/section}		
						</select>
					</td>
	 			 </tr>
	 			 <tr>
		 			<td align="right" valign="bottom"><font style="font-size:11px;"><b>EGL v{$EGL_CURRENT_VERSION}, Bench {$BENCH_TIME}s</b></font></td>
		 		 </tr>
		 		</table>
	 		</td></tr>
	 		</table>
	 	</td>
	 </tr>
	 <tr>
	 	<td>
			<table cellpadding="5"><tr>
				<td><a class="header_menu" href="{$url_file}page=mls.search">{$LNG_BASIC.c1111}</a></td>
				<td>&#x95;</td>
				<td><a class="header_menu" href="{$url_file}page=profiler.overview">{$LNG_BASIC.c1200}</a></td>
				<td>&#x95;</td>
				<td><a class="header_menu" href="{$url_file}page=sql.query">{$LNG_BASIC.c1202}</a></td>
				<td>&#x95;</td>
				<td><a class="header_menu" href="{$url_file}page=sql.mysync">{$LNG_BASIC.c1203}</a></td>
			</tr></table>
	 	</td>
	 </tr>
	</table>
	
	{include file=$page_file}
	
	<div align="center">
		<br/><br/>
		<a target="_blank" href="http://www.inetopia.com"><img src="images/inetopia_icon.gif" border="0"/></a><br/>
		<font style="font-size:11px;">Copyright 2004-2007&copy; Inetopia.<br/>All rights reserved. Alle Rechte vorbehalten.</font>
	</div>

</body>
</html>