<head>
<link rel="stylesheet" href="css/eglv2.css" type="text/css"/>
	{literal}	
	<style type="text/css">
	BODY 
	{ FONT-FAMILY: Helvetica; border:0px;margin:0px;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;margin: 0; padding: 0;}
	
	A.header_menu:link, A.header_menu:visited
	{ COLOR: #000; text-decoration: none;font-size: 11px;FONT-FAMILY: Helvetica;}
	A.header_menu:active, A.header_menu:hover
	{ COLOR: #000; text-decoration: none; font-size: 11px; FONT-FAMILY: Helvetica;background-color:#FF7800;}
	
	A.topheader_menu:link, A.topheader_menu:visited
	{ COLOR: #000; text-decoration: none;font-size: 9px;FONT-FAMILY: Helvetica;}
	A.topheader_menu:active, A.topheader_menu:hover
	{ COLOR: #000; text-decoration: none; font-size: 9px; FONT-FAMILY: Helvetica;background-color:#FF7800;}
		
	A.league_a:link, A.league_a:visited
	{ COLOR: #000; text-decoration: none;font-size: 9px;FONT-FAMILY: Helvetica;}
	A.league_a:active, A.league_a:hover
	{ COLOR: #000; text-decoration: none; font-size: 9px; FONT-FAMILY: Helvetica; }
	
	A.top_news:link, A.top_news:visited
	{ COLOR: #FFFFFF;  text-decoration: none;font-size: 13px;FONT-FAMILY: Helvetica; }
	A.top_news:active, A.top_news:hover
	{ COLOR: #FFFFFF; text-decoration: none;font-size: 13px; FONT-FAMILY: Helvetica; background-color:#96938A; }
	
	A.bt_universal:link, A.bt_universal:visited
	{ COLOR: #FFFFFF;  text-decoration: none;font-size: 11px;FONT-FAMILY: Helvetica; font-weight:bold; }
	A.bt_universal:active, A.bt_universal:hover
	{ COLOR: #FFFFFF; text-decoration: none;font-size: 11px; FONT-FAMILY: Helvetica; font-weight:bold; }
	
	A.news_href:link,A.news_href:active
	{ COLOR: #000000; text-decoration: none;font-size: 11px; FONT-FAMILY: Helvetica;}
	A.news_href:visited
	{ COLOR: #000000; text-decoration: none; font-size: 11px; FONT-FAMILY: Helvetica;}
	A.news_href:hover
	{ COLOR: #000000; text-decoration: underline; font-size: 11px; FONT-FAMILY: Helvetica;}
	
	
	
	A.submenu:link, A.submenu:visited
	{ COLOR: #000; text-decoration: none; font-size: 11px; FONT-FAMILY: Helvetica; font-weight: bold;}
	A.submenu:active, A.submenu:hover
	{ COLOR: #000; text-decoration: underline; font-size: 11px; FONT-FAMILY: Helvetica; font-weight: bold;}	
	
	</style>
	{/literal}
<title>EGL v2</title>
</head>
<body bgcolor="#4A4A4A">

	<table bgcolor="#202020" width="1000" height="100%" cellpadding="0" cellspacing="0" align="center">
	 <tr>
		<td height="20" bgcolor="#FFFFFF" align="right"> <a href="" class="header_menu"><b>IMPRESSUM</b></a></td>
	 </tr>
	 <tr>
		<td height="100"></td>
	 </tr>
	 <tr>
		<td height="61">
			<table cellpadding="0" cellspacing="0"><tr>
				<td><img src="images/spacer.gif" width="10"/></td>
				<td><img src="img/eglv2/head_myaccount.gif"/></td>
				<td><img src="img/eglv2/head_news.gif"/></td>
				<td><img src="img/eglv2/head_playgames.gif"/></td>
				<td><img src="img/eglv2/head_community_a.gif"/></td>
			</tr></table>
		</td>
	 </tr>
	 <tr>
		<td bgcolor="#FFFFFF" valign="top" height="30">
		<div style="padding:5px;">
			<table><tr>
				<td><a class="submenu" href="">Forum</a></td>
				<td>&nbsp;<b>·</b>&nbsp;</td>
				<td><a class="submenu" href="">Gamers-Life</a></td>
				<td>&nbsp;<b>·</b>&nbsp;</td>
				<td><a class="submenu" href="">Blogs</a></td>
				<td>&nbsp;<b>·</b>&nbsp;</td>
				<td><a class="submenu" href="{$url_file}page=member.memberlist">Mitglieder</a></td>
			</tr></table>
		</td>
	 </tr>
	 <tr>
	 	<td bgcolor="#0090FF"><img src="images/spacer.gif" height="2"/></td>
	 </tr>
	 <tr><td bgcolor="#FFFFFF">
		</div>
	 		  	 	<table border="0" width="100%"><tr><td>
	 		  	 					{include file=$page_file}
	 		  	 					{if isset($ATTACHED_CONTENT)}{$ATTACHED_CONTENT}{/if}
			 		  	 <div align="center">
			 		  	  <br/><br/><br/><br/>
			 		  	  	<a href="JavaScript:history.back(1)"><b>{$LNG_BASIC.c1101}</b></a> |
			 		  	  	<a href="JavaScript:window.location.reload()"><b>{$LNG_BASIC.c1105|escape}</b></a> 
			 		  	 </div>
	 		  	 	</td></tr></table>  			
		</td>
	 </tr>
	</table>

</body>