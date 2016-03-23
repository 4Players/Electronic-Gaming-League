<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
	<TITLE> EGL.ConfigSheet Beta2 &copy;Inetopia.</TITLE>
</HEAD>
{if $is_loggedin}
	 <frameset id="base_frame"  border=0 cols="250,*">
	 
		<frame name="navi" src="admin_frame.php?page=frame.navigation">
		<frameset rows="52,*">
			<frame name="header" src="admin_frame.php?page=frame.header">
			<frame name="page" src="admin_framepage.php?page=home ">
		</frameset>
		<frame name="pagestore" src="admin_frame.php?page=frame.pagestore">
	</frameset>
{else}
	<link rel="stylesheet" href="css/admin.css" type="text/css">
	<body bgcolor="#FFFFFF">
		{include file="`$page_file`"}
	</body>
{/if}
</html>