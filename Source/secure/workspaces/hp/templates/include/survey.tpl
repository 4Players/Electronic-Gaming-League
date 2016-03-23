		 	<form action="{$url_file}page={module_getid cname='INETOPIA_POLLS'}:vote&poll_id={$menu_polls[0]->id}&a=voting" method="POST">
						<table border="0" cellpadding="0" cellspacing="0" width="100%" align="" bgcolor="#CBC9CE">
							 	<tr><td>
									 	<table border="0" cellpadding="0" cellspacing="0" width="100%">
									 	 <tr>
									 	 	<td width="1%"><img src="images/eglbeta/survey.gif"/></td>
									 	 </tr>
									 	</table>
					 		 	</td></tr>
							 	<tr><td>
							 		<table border="0" cellpadding=0 cellspacing=11 width="100%" onmouseover="javascript:change_bg(this, 1, 'images\/eglbeta\/nav_bg_1.gif', 'images\/eglbeta\/nav_bg_2.gif' );" onmouseout="javascript:change_bg(this, 0, 'images\/eglbeta\/nav_bg_1.gif', 'images\/eglbeta\/nav_bg_2.gif' );" style="background-repeat:repeat-y; background-position:center right;" background="images/eglbeta/nav_bg_1.gif">
							 		 <tr><td>
							 		 	<a href="{$url_file}page={module_getid cname='INETOPIA_POLLS'}:overview" class="top_news"><b>{$menu_polls[0]->question}</b></a>
							 		 	
							 		 	<table border="0" width="100%">
							 		 	{section name=qname loop=$menu_polls[0]->answers}
							 		 	 <tr>
								 			<td><input name="poll_vote_{$menu_polls[0]->id}" type="radio" class="egl_radio" value="{$menu_polls[0]->answers[qname]->id}"> </td>
							 		 	 	<td> <font color="#FEFEFE">{$menu_polls[0]->answers[qname]->answer}</font></td>
							 		 	 <tr>
							 		 	 {/section}
										 <tr>
										 	<td colspan="2"><input class="egl_button" type="submit" value="Abstimmen"> [ <A href="{$url_file}page={module_getid cname='INETOPIA_POLLS'}:vote&poll_id={$menu_polls[0]->id}"><font color="#000000"><b>Ergebnis</b></font></a> ]</td> 
										 </tr>

							 		 	</table>
							 		 </td></tr>
							 		</table>
							 		
							 	</td></tr>
							 </table>
						</form>