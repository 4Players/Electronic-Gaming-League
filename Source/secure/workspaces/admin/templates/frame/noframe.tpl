<HTML>
<HEAD>
	<TITLE>EGL.ConfigSheet &copy;2007 Inetopia.</TITLE>
</HEAD>
	<link rel="stylesheet" href="css/admin.css" type="text/css">
	<link rel="stylesheet" href="css/admin.live_edit.css" type="text/css">
	<script language="JavaScript" type="text/javascript" src="javascript/base_utils.js"></script>
<body bgcolor="#FFFFFF">

{if $is_loggedin}
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="250"  valign="top"><img src="images/spacer.gif" width="250" height="1"/><br/>{include file="frame/navigation.tpl"}</td>
			<td valign="top">
				<table cellpadding="0" cellspacing="0" width="100%">
				 <tr>
				 	<td>{include file="frame/header.tpl"}</td>
				 </tr>				
				 <tr>
				 	<td style="padding:5px;">{include file=$page_file}</td>
				 </tr>				
				</table>
			</td>
		</tr>
	</table>
{else}
	{include file=$page_file}
{/if}	
</body>
</html>
