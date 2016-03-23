{if $is_loading}

	<meta http-equiv="refresh" content="5; URL={$url_file}page={$url_page}">

	<table width="100%" height="100%">
	<tr><td align="center">
	
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="715" height="650" id="loading" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="movie" value="images/admin/loading.swf" />
	<param name="loop" value="false" />
	<param name="quality" value="high" />
	<param name="bgcolor" value="#ffffff" />
	<embed src="images/admin/loading.swf" loop="false" quality="high" bgcolor="#ffffff" width="715" height="650" name="loading" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>


	<td></tr>
	</table>

{else}
	<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
	 <tr>
	 	<td colspan="2" align="center" bgcolor="#FFFFFF">
	 	
	 		<form action="{$url_file}page={$url_page}&a=go" method="POST">
	 		 	<table border="0" align="center" bgcolor="#000000" cellpadding="0" cellspacing="1">	
	 		 	 <tr>
	 		 	 	<td><img src="images/admin/login.jpg"></td>
	 		 	 </tr>
	 		 	 <tr><td bgcolor="{#clr_content#}">
	 		 	 	<table border="0" cellpadding="5" cellspacing="0" width="100%">
	 		 	 	<tr><td colspan="2"> Enter the login name into "Login" and password into the "Password" fields respectively. <br> Then click "Login". </td></tr>
			 		 <tr>

			 		 <td><b>Login:</b></td>
			 		 	<td><input name="login_name" type="text" class="" value="Administrator"/></td>
			 		 </tr>
			 		 <tr>
			 		 	<td><b>Passwort:</b></td>
			 		 	<td><input name="login_password" type="password" class=""/></td>
			 		 </tr>
			 		 <tr>
			 		 	<td></td>
			 		 	<td><input type="image" src="images/buttons/new/bt_login.gif"></td>
			 		 </tr>
			 		</table>
			 		
	 		 	 	</td>
	 		 	 </tr>
	 		 	</table>
		 	</form>
		 	<br>
			 EGL ConfigSheet v{$EGL_CURRENT_VERSION} - Copyright&copy; 2004-2007 <a class="standard" href="http://inetopia.de"><b>Inetopia</b></a> <br>
			 All rights reserved. Alle Rechte vorbehalten.
	 	
	 	</td>
	 </tr>
	</table>
{/if}