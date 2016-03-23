<HTML>
<HEAD>
	{literal}
	<style type="text/css">
	.advices {
		 font-family: arial, sans-serif;
		 font-size: 11px;
	}
	.content{
		 font-family: arial, sans-serif;
		 font-size: 14px;
	}	
	.content_header{
		 font-family: arial, sans-serif;
		 font-size: 14px;
	}	
	
	A.bt_universal:link, A.bt_universal:visited
	{ COLOR: #717171;  text-decoration: none;font-size: 12px;FONT-FAMILY: arial; font-weight:bold; }
	
	A.bt_universal:active, A.bt_universal:hover
	{ COLOR: #717171; text-decoration: none;font-size: 12px; FONT-FAMILY: arial; font-weight:bold; }

	A:link, A:visited
	{ COLOR: #EB4500;  text-decoration: underline; FONT-FAMILY: arial; }
	A:active, A:hover
	{ COLOR: #000000; text-decoration: none; FONT-FAMILY: arial; }
	
	.egl_text{
		width:250px;
		
	}
	.egl_select{
		width:250px;
		
	}	
	
	A.mode_selection:active, A.mode_selection:hover, A.mode_selection:link, A.mode_selection:visited
	{  COLOR: #000000; text-decoration: none; FONT-FAMILY: arial; font-weight:bold; font-size:12px; }
	
	</style>
	{/literal}
	<TITLE>EGL v{$EGL_CURRENT_VERSION} - {$LNG_BASIC.c1000}</TITLE>	
</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

	<table border="0" align="center" width="100%" height="100%" cellpadding="0" cellspacing="0">
	 <tr>
	 	<td align="center">
			<form name="f" action="{$url_file}{url_params}&a=next" method="POST">
	 	
	 		<table border="0" width="800" height="600" cellpadding="5" cellspacing="1">
	 		 <tr>
	 		 	<td  background="images/installwizard/wizard_bg.jpg" valign="top" align="left">
	 		 	
	 		 		<table border="0">
	 		 		 <tr>
	 		 		 	<td colspan="2" align="left">
	 		 		 		<table cellpadding="2" cellspacing="0">
	 		 		 		 <tr>
	 		 		 		 	<td><img src="images/spacer.gif" width=20" height="55"/></td>
	 		 		 		 	<td><font style="font-size:30px;">{$LNG_BASIC.c1000}</font></td>
	 		 		 		 </tr>
	 		 		 		</table>
	 		 		 </tr>
	 		 		 <tr>
	 		 		 	<td><img src="images/space.gif" width="1" height="310"/></td>
	 		 		 	<td>
	 		 		 		<table width="450" height="280" cellpadding="0" cellspacing="0" class="content">
	 		 		 		 <tr>
	 		 		 		 	<td valign="top">
	 		 		 		 	<div style="border : solid 0px #F0F0F0; padding : 0px; width : 450px; height : 260px; overflow : auto; ">
	 		 		 		 		{include file=$page_file}{if isset($ATTACHED_CONTENT)}{$ATTACHED_CONTENT}{/if}
	 		 		 		 	</div>
	 		 		 		 	</td>
	 		 		 		 </tr>
	 		 		 		</table>
	 		 		 	
	 		 		 	</td>
	 		 		 </tr>
	 		 		 <tr>
	 		 		 	<td><img src="images/spacer.gif" width="305" height="15"/></td>
	 		 		 	<td></td>
	 		 		 </tr>
	 		 		 <tr>
	 		 		 	<td><img src="images/space.gif" width="1" height="60"/></td>
	 		 		 	<td>
	 		 		 		<table border="0" cellpadding="5" class="advices">
	 		 		 		 <tr><td valign="top">
	 		 		 		 	<div style="border : solid 0px #F0F0F0; padding : 0px; width : 450px; height : 60px; overflow : auto; ">
	 		 		 		 		{if strlen($PAGE_ADVICE) > 0}
	 		 		 		 		<table class="advices" cellpadding="5" cellspacing="0"><tr>
	 		 		 		 			<td valign="top"><b>{$LNG_BASIC.c1004}:</b></td>
	 		 		 		 			<td valign="top">{$PAGE_ADVICE}</td>
	 		 		 		 		</table>
	 		 		 		 		{else}
	 		 		 		 			{$LNG_BASIC.c1010}
	 		 		 		 		{/if}
	 		 		 		 	</div>
	 		 		 		 		
 		 		 		 	</td></tr>
	 		 		 		</table>
	 		 		 	</td>
	 		 		 </tr>
	 		 		 <tr>
	 		 		 	<td><img src="images/spacer.gif" width="1" height="60"/></td>
	 		 		 	<td align="center" valign="bottom">
	 		 		 	
	 		 		 	<table border="0"><tr>
	 		 		 	
	 		 		 		{if strlen($URL_PREV)>0}<td>{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c1012 link="javascript:document.location.href='`$URL_PREV`';"}</td>{/if}
	 		 		 		{if strlen($URL_PREV)==0 OR $FINISHED }<td><img src="images/spacer.gif" height="1" width="127"/>{/if}
	 		 		 		{if !$FINISHED }<td>{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c1011 link="javascript:document.f.submit();"}</td>{/if}
	 		 		 	</tr></table>
	 		 		 	
	 		 		 	</td>
	 		 		 </tr>
	 		 		</table>
	 		 	
	 		 	</td>
	 		 </tr>
	 		</table>
	 		
		<div align="center">
			<br/><br/>
			<a target="_blank" href="http://www.inetopia.com"><img src="images/inetopia_icon.gif" border="0"/></a><br/>
			<font style="font-size:11px;" face="Arial">Copyright 2004-2007&copy; Inetopia.<br/>All rights reserved. Alle Rechte vorbehalten. <br/>
			EGL v{$EGL_CURRENT_VERSION}, generated in {$BENCH_TIME}s
			
			</font>
		</div>
	 			 	
		</form>
	 	</td>		
 	 </tr>
	</table>

</BODY>
</HTML>