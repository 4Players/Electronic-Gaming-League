<HTML>
<head>
	<title>EGL v{$EGL_CURRENT_VERSION} &copy;2007 by Inetopia.de - Intelligent E-Sport Solutions</title>
	<meta name="robots" content="index, follow">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="author" 	content="Inetopia">
	<meta name="publisher" 	content="Inetopia">
	<meta name="programmer" content="Inetopia">
	<meta name="copyright" 	content="Inetopia">
	<meta name="keywords" 	content="EGL, EGL.net,liga cms,esport cms,ligascript,liga script, Electronic Gaming League,ElectronicGamingLeague,E-Sport Content Engine,esport software,simple esport software,simgle esport solutions,esport content engine,e-sport software,esport Module-System,best gaming online,Universal E-Sport Solutions,E-Sport,Ladder,Magazin,Cup,Tournament,Best of eSport,E-Sport Solutions,Intelligent WebEngineering,Powerful Platform Solution,Professionelle Plattform Lösungen">
	<meta name="description"content="Inetopia - Intelligent E-Sport Solutions">
	
	<link rel="SHORT ICON" href="http://www.electronicgamingleague.de/public/images/egl.icon.gif"/>
	<link rel="stylesheet" href="css/egl_design.css" type="text/css"/>
	
	<script language="JavaScript" type="text/javascript" src="javascript/base_utils.js"></script>
	<script language="JavaScript" type="text/javascript" src="javascript/menu.js"></script>
	{literal}	
	<style type="text/css">
	BODY 
	{ FONT-FAMILY: Verdana; border:0px;margin:0px;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;margin: 0; padding: 0;}
	
	A.header_menu:link, A.header_menu:visited
	{ COLOR: #FFF; text-decoration: none;font-size: 11px;FONT-FAMILY: arial;}
	A.header_menu:active, A.header_menu:hover
	{ COLOR: #FFF; text-decoration: none; font-size: 11px; FONT-FAMILY: arial;background-color:#FF7800;}
	
	A.topheader_menu:link, A.topheader_menu:visited
	{ COLOR: #FFF; text-decoration: none;font-size: 9px;FONT-FAMILY: verdana;}
	A.topheader_menu:active, A.topheader_menu:hover
	{ COLOR: #FFF; text-decoration: none; font-size: 9px; FONT-FAMILY: verdana;background-color:#FF7800;}
		
	A.league_a:link, A.league_a:visited
	{ COLOR: #000; text-decoration: none;font-size: 9px;FONT-FAMILY: verdana;}
	A.league_a:active, A.league_a:hover
	{ COLOR: #000; text-decoration: none; font-size: 9px; FONT-FAMILY: verdana; }
	
	A.top_news:link, A.top_news:visited
	{ COLOR: #FFFFFF;  text-decoration: none;font-size: 13px;FONT-FAMILY: arial; }
	A.top_news:active, A.top_news:hover
	{ COLOR: #FFFFFF; text-decoration: none;font-size: 13px; FONT-FAMILY: arial; background-color:#96938A; }
	
	A.bt_universal:link, A.bt_universal:visited
	{ COLOR: #FFFFFF;  text-decoration: none;font-size: 11px;FONT-FAMILY: arial; font-weight:bold; }
	A.bt_universal:active, A.bt_universal:hover
	{ COLOR: #FFFFFF; text-decoration: none;font-size: 11px; FONT-FAMILY: arial; font-weight:bold; }
	
	A.news_href:link,A.news_href:active
	{ COLOR: #000000; text-decoration: none;font-size: 11px; FONT-FAMILY: arial;}
	A.news_href:visited
	{ COLOR: #000000; text-decoration: none; font-size: 11px; FONT-FAMILY: arial;}
	A.news_href:hover
	{ COLOR: #000000; text-decoration: underline; font-size: 11px; FONT-FAMILY: arial;}
	</style>
	{/literal}
</head>

{if $smarty.cookies.member.game_id>0}<body onload="_div_init(3);" >{/if}
{if $smarty.cookies.member.game_id<1}<body onload="_div_init(2);" >{/if}
{literal}

<script type="text/javascript">
	function jumpto_link( l_url ) {	window.location = l_url; }
	function change_bg( obj, pic ){
		abg = new Image();
		abg.src = pic;
		obj.style.backgroundImage = "url("+abg.src+")";
	}
	function change_image_src( obj, pic  ){
		obj.src = pic;
	}
	
	function page_clear(){
		document.all.page_content.innerHTML = "test";
	}
</script>
{/literal}

{include file="include/dropdown_menus.tpl"}

<table cellpadding="0" cellspacing="0" align="left" bgcolor="#C0C0C0">
 <tr><td>
 
	<table border="0" cellpadding="0" cellspacing="0" height="1200" width="1024">
	 <tr>
	 	<td colspan="3" bgcolor="#696C75" height="1%">
	
	 		<table border="0" cellpadding="0" cellspacing="0">
	 		 <tr>
	 		 	<td>
		 		 	{if $smarty.cookies.member.game_id > 0}
			 		 	<table border="0" cellpadding="2" cellspacing="1">
			 		 	 <tr>
			 		 	 	<td>
			 		 	 		{section name=pgame loop=$pgames}
			 		 	 		{if $smarty.cookies.member.game_id == $pgames[pgame]->id}
			 		 	 		<table border="0" cellpadding="0" cellspacing="0">
			 		 	 		 <tr onmouseover="stopTime(); _div_show('d1');" onmouseout="startTime();">
			 		 	 		 	<td width="1"><img src="images/eglbeta/chosed_game_left.gif"/></td>
			 		 	 		 	<td width="100%" background="images/eglbeta/chosed_game_middle.gif">
			 		 	 		 	 	 <table cellpadding="0" cellspacing="0">
							   		 	   <tr>
							   		 	   	<td width="1">&nbsp;&nbsp;</td>
							   		 	   	<td width="1%"><img src="{$PATH_GAMES}small/{$pgames[pgame]->logo_small_file}" width="13" height="17"/></td>
							   		 	   	<td width="1%"><img src="images/spacer.gif" width="10" height="1"/></td>
								   		 	<td><A class="chosegame_a" href="{$url_file}page=gameview.summary"><b>{$pgames[pgame]->name|strip_tags|stripslashes|replace:' ':'&nbsp;'}</b></a></td>
								   		  </tr>
								   		</table>
			 		 	 		 	</td>
			 		 	 		 	<td width="1%"><img src="images/eglbeta/chosed_game_right.gif"/></td>
			 		 	 		  </tr>
			 		 	 		  <tr><td colspan="3"><div id="m1" style="position:relative;z-index:1;"><img src="images/spacer.gif" width="250" height="1"/></td></tr>
			 		 	 		 </table>
			 		 	 		 {/if}
			 		 	 		 {/section}
				 		 	 	
			 		 	 	</td>
			 		 	 </tr>
			 		 	</table>
			 		 {else}
			 		 	<table border="0" cellpadding="2" cellspacing="1">
			 		 	 <tr>
			 		 	 	<td>
			 		 	 		<table cellpadding="0" cellspacing="0" border="0">
			 		 	 		 <tr onmouseover="stopTime(); _div_show('d1');" onmouseout="startTime();">
			 		 	 		 	<td width="1"><img src="images/eglbeta/chose_game_left.gif"/></td>
			 		 	 		 	<td width="100%" background="images/eglbeta/chosed_game_middle.gif">
			 		 	 		 	 	 <table cellpadding="0" cellspacing="0">
							   		 	   <tr>
								   		 	<td><A class="chosegame_a" href="{$url_file}page=gameview.gamelist"><b>Bitte Spiel wählen</b></a></td>
								   		  </tr>
								   		</table>
			 		 	 		 	</td>
			 		 	 		 	<td width="1%"><img src="images/eglbeta/chose_game_right.gif"/></td>
			 		 	 		  </tr>
			 		 	 		  <tr><td colspan="3"><div id="m1" style="position:relative;z-index:1;"><img src="images/spacer.gif" width="250" height="1"/></td></tr>
			 		 	 		 </table>
			 		 	 		 		 		 	 	
			 		 	 	</td>
			 		 	 </tr>
			 		 	</table>
			 		 {/if}
			 	
	 		 	</td>
	 		 	<td width="100%">
	 				<table border=0 cellpadding=2 cellspacing=0 align="right">
					 <td> <A href='{$url_file}page=home' class="topheader_menu"><b>{$LNG_BASIC.c4003}</b></A></td>
					 <td> <font color="#FFFFFF">&nbsp;|&nbsp;</font></td>
					 <td> <A href='{$url_file}page=online.members' class="topheader_menu"><b>{$LNG_BASIC.c4004}</b></A></td>
					 <td> <font color="#FFFFFF">&nbsp;|&nbsp;</font></td>
					 <td> <A href='{$url_file}page=member.memberlist' class="topheader_menu"><b>{$LNG_BASIC.c4005}</b></A></td>
					 <td> <font color="#FFFFFF">&nbsp;|&nbsp;</font></td>
					 <td> <A href='{$url_file}page=clan.clanlist' class="topheader_menu"><b>{$LNG_BASIC.c4006}</b></A></td>
					 <td> <font color="#FFFFFF">&nbsp;|&nbsp;</font></td>
					 <td> <A href='{$url_file}page=team.teamlist' class="topheader_menu"><b>{$LNG_BASIC.c4007}</b></A></td>
					 <td> <font color="#FFFFFF">&nbsp;|&nbsp;</font></td>
					 <td> <A href='{$url_file}page=imprint' class="topheader_menu"><b>{$LNG_BASIC.c4008}</b></A></td>
				 	  </td></tr>
				 	 </table>
				</td>
			 </tr>
			</table>
			
	 	</td>
	 </tr>
	 <tr>
	 	<td colspan="3" height="1%" bgcolor="#D4D7d3">
	 		<table border="0" cellspacing="0" cellpadding="0" width="100%" background="images/eglbeta/content/design/{$GLOBAL_COLOR}/header.jpg" style="background-repeat:no-repeat;">
	 		 <tr> <td><A href="{$url_file}page=home"><img border="0" src="images/spacer.gif" width="900" height="133"/></a></td> </tr>
	 		 <!--<tr> <td></td> </tr>-->
	 		</table>
	 	</td>
	 </tr>
	 <tr>
	 	<td colspan="1" height="1%" bgcolor="#7D818B">
			
	 		<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 		 <tr><td bgcolor="#696C75">
	 		 
		 		<table border="0" width="100%" cellpadding=0 cellspacing=0>
		 		 <tr>
		 		 	<td>
		 		 	<!--### HEADER MENU ###-->
		 		 	{if $smarty.cookies.member.game_id > 0}
						<table border="0" cellpadding="5" cellspacing="0"><tr>
						 <td><a href='{$url_file}page=gameview.summary' class="header_menu"><b>{$LNG_BASIC.c4000}</b></a></td>
						 <td>&nbsp;&nbsp;</td>
						 <td><div id="m3" style="position:relative;z-index:1;"><A onmouseover="stopTime(); _div_show('d3');" onmouseout="startTime();" href='{$url_file}page=gameview.leagues' class="header_menu"><b>{$LNG_BASIC.c4001}</b> <img border="0" src="images/eglbeta/menudown.gif"/></a></div></td>
						 <td>&nbsp;&nbsp;</td>
						 <td><a href="{$url_file}page={module_getid cname='INETOPIA_POLLS'}:overview&game_id={$smarty.cookies.member.game_id}" class="header_menu"><b>{$LNG_BASIC.c4002}</b></a></td>
						 {if $CURRENT_GAME->forum_id > 0}
						 <td>&nbsp;&nbsp;</td>
						 <td><a href="{$url_file}page={module_getid cname='INETOPIA_FORUM'}:forums&forum_id={$CURRENT_GAME->forum_id}" class="header_menu"><b>{$LNG_BASIC.c4009}</b></a></td>
						 {/if}
						 </tr></table>
					 {else}
					 	&nbsp;
					 {/if}
		 		 	
		 		 	</td>
		 		 </tr>
		 		</table>
	 	
			</td><td width="230">
	 		{if $is_loggedin}
			 		 	<table border="0" width="100%" cellpadding="0" cellspacing="0">
			 		 	 <tr>
			 		 	 	<td>
			 		 	 		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			 		 	 		 <tr onmouseover="stopTime(); _div_show('d2');" onmouseout="startTime();">
			 		 	 		 	<td width="1"><img src="images/eglbeta/chosed_game_left.gif"/></td>
			 		 	 		 	<td background="images/eglbeta/chosed_game_middle.gif">
			 		 	 		 	 	 <table width="100%" cellpadding="0" cellspacing="0">
							   		 	   <tr>
								   		 	<td><A class="chosegame_a" href="{$url_file}page=member.center"><b>{$member->email|strip_tags|stripslashes}</b></a></td>
								   		  </tr>
								   		</table>
			 		 	 		 	</td>
			 		 	 		 	<td width="1%"><img src="images/eglbeta/chosed_game_right.gif"/></td>
			 		 	 		  </tr>
			 		 	 		  <tr><td><div id="m2" style="position:relative;"><img src="images/spacer.gif" width="1" height="1"/></div></td></tr>
			 		 	 		 </table>
			 		 	 		 		 		 	 	
			 		 	 	</td>
				 	 </tr>
				 	</table>
			{else}
			 		 	<table width="100%" cellpadding="0" cellspacing="0">
			 		 	 <tr>
			 		 	 	<td>
			 		 	 		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			 		 	 		 <tr onmouseover="stopTime(); _div_show('d2');" onmouseout="startTime();">
			 		 	 		 	<td width="1"><img src="images/eglbeta/chose_game_left.gif"/></td>
			 		 	 		 	<td background="images/eglbeta/chosed_game_middle.gif">
			 		 	 		 	 	 <table width="100%" cellpadding="0" cellspacing="0">
							   		 	   <tr>
								   		 	<td><A class="chosegame_a" href="{$url_file}page=login"><b>Einloggen?</b></a></td>
								   		  </tr>
								   		</table>
								   	</div>
			 		 	 		 	</td>
			 		 	 		 	<td width="1%"><img src="images/eglbeta/chose_game_right.gif"/></td>
			 		 	 		  </tr>
			 		 	 		  <tr><td><div id='m2' style="position:relative;"><img src="images/spacer.gif" width="1" height="1"/></td></tr>
			 		 	 		 </table>
			 		 	 		 		 		 	 	
			 		 	 	</td>
				 	 </tr>
				 	</table>
			{/if}
			</td></tr>
		   </table>
		   
	 	</td>
	 	<td colspan="2" bgcolor="#696C75" align="right"><font color="#FFFFFF"><b>EGL v{$EGL_CURRENT_VERSION}, Bench {$BENCH_TIME}s</b></font>&nbsp;</td>
	 </tr>
	 <tr>
	 	<td height="2" bgcolor="#F1F1F1"><img src="images/spacer.gif" width="595" height="1"/></Td>
	 	<td height="2" bgcolor="#F1F1F1"><img src="images/spacer.gif" width="1" height="1"/></Td>
	 	<td height="2" bgcolor="#F1F1F1"><img src="images/spacer.gif" width="1" height="1"/></Td>
	 </tr>
	 <tr>
	 	<td valign="top" bgcolor="#F1F1F1">
	 		<!--### CONTENT START ###-->
		  	 	<table border="0" cellpadding="0" width="100%">
			  	 <tr> <td height="1%"><img src="images/spacer.gif" height="1" width="595" border="0"/></td>
	 		  	 <tr> <td height="100%" valign="top">
	 		  	 	<table border="0" width="100%"><tr><td>
			 		  	<div id="page_content" style="width:100%">
	 		  	 					{include file=$page_file}
	 		  	 					{if isset($ATTACHED_CONTENT)}{$ATTACHED_CONTENT}{/if}
			 		  	 </div>
			 		  	 <div align="center">
			 		  	  <br/><br/><br/><br/>
			 		  	  	<a href="JavaScript:history.back(1)"><b>{$LNG_BASIC.c1101}</b></a> |
			 		  	  	<a href="JavaScript:window.location.reload()"><b>{$LNG_BASIC.c1105|escape}</b></a> 
			 		  	 </div>
	 		  	 	</td></tr></table>
	 		  	 </td></tr>
				</table>
					
		</td>
	 	<td width="1"><img src="images/spacer.gif" width="1"/></td>
	 	
		<td align="left" valign="top" bgcolor="#696C75">
			  	{*** NAVI RIGHT ***}
			  	
			  		<table border=0 cellpadding=0 cellspacing=0 width="200">
			  		 <tr>
			  		 	<td valign="top">
			  		 	 	<br/>
			  		 		<!--###  RIGHT MENU CONTENT START ###-->
			  		 		<table border="0" align="center">
			  		 		 <tr><td>
				  		 		<font color="#FFFFFF"><b>Newsletter abonieren?</b></font><br/>
							  	<form name="fnewsletter_top" method="POST" action="{$url_file}page={module_getid cname='INETOPIA_NEWSLETTER'}:newsletter&a=add">
							  		<input class="egl_text" size="30" name="newsletter_email" type="text" value="Deine E-Mail Adresse?" onclick="this.value='';"/>
							  		{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="einschreiben" link="javascript:document.fnewsletter_top.submit();"}
							  	</form>
							  </td></tr>
							 </table>
							 
				  		 	
			  		 	</td>
			  		 </tr>
			  		</table>

			  		
		<td>
	   </tr>
	  </table>
	  
</td></tr>
</table>
 		<!--### CONTENT END ###-->

</body>
</html>