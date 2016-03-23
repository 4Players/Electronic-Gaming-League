<?php /* Smarty version 2.6.12, created on 2006-08-23 12:16:37
         compiled from designs/main.tpl */ ?>
<html>
	<head>
		<title>EGL Devzone &copy;Inetopia., Multilanguage Management</title>
		<?php echo '
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
		'; ?>

		</head>
<body>
	<table cellpadding="5" cellspacing="2" bgcolor="#FF5500" width="100%" border="0">
	 <tr background="images/header_bg.jpg" style="background-position:left top; background-repeat:no-repeat;" bgcolor="#FFFFFF">
	 	<td>
	 		<table width="100%">
	 		<tr><td>
	 			<img src="images/spacer.gif" width="1" height="110"/>
		 		<!--#<font style="font-size:30px;font-weight:bold;">Electronic Gaming League - Devzone</font> <br/>
		 		<b>Software Development Kit</b><br/>#-->
	 		</td>
	 		<td align="right" valign="bottom">
		 		<font style="font-size:11px;"><b>EGL v<?php echo $this->_tpl_vars['EGL_CURRENT_VERSION']; ?>
, Bench <?php echo $this->_tpl_vars['BENCH_TIME']; ?>
s</b></font> 
	 		</td></tr>
	 		</table>
	 	</td>
	 </tr>
	 <tr>
	 	<td>
			<table cellpadding="5"><tr>
				<td><A class="header_menu" href="<?php echo $this->_tpl_vars['url_file']; ?>
page=mls.search">MLS</a></td>
				<td>&#x95;</td>
				<td><A class="header_menu" href="<?php echo $this->_tpl_vars['url_file']; ?>
page=profiler.overview">Profiler</a></td>
			</tr></table>
	 	</td>
	 </tr>
	</table>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['page_file'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<div align="center">
		<br/><br/>
		<a target="_blank" href="http://www.inetopia.com"><img src="images/inetopia_icon.gif" border="0"/></a><br/>
		<font style="font-size:11px;">Copyright 2005-2006&copy; Inetopia.<br/>All rights reserved. Alle Rechte vorbehalten.</font>
	</div>

</body>
</html>