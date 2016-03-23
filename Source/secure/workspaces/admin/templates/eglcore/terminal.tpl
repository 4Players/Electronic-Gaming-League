<h2>EGL.Core - Terminal</h2>
<br>

<form action="{$url_file}page={$url_page}&a=go" method="POST">
<table border=0 cellpadding=0 cellspacing=1 bgcolor="#C5C5C5" width="95%" align="center">
 <tr><td>
	<table border="0" width="100%" bgcolor="#F5F3EF" cellpadding=10 cellspacing=0 align="center">
	 <tr bgcolor="#E8E5DE">
	 	<td width="50"> <b>Exec:</b></b> </td>
	 	<td class="egl_live_td"> <input name="exec" value="{$_post.exec}" class='egl_terminal_live_text' onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#000000');" onFocus="textbox_set_style(this, '#A80000', '#FFFFFF', '#000000');" type=text name='name_exec'/> </td>
 	</tr>
	 <tr>
	 	<td colspan=3>
	 		<b>Parameter:</b>
	 		<table border="0">
	 		{section name=num_params loop=10}
	 		 <tr>
	 		 	<td><i>Param {$smarty.section.num_params.index} </i></td>
			 	<td><img src="images/spacer.gif" width=50 height=1> </td>
	 			<td>Name:</b>
			 	<td> <input size="20"  name="param_{$smarty.section.num_params.index}_name" class='egl_terminal_live_text' onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#000000');" onFocus="textbox_set_style(this, '#A80000', '#FFFFFF', '#000000');" type=text name='name_exec'/> </td>
			 	<td><img src="images/spacer.gif" width=50 height=1> </td>
	 			<td>Value:</b> 
			 	<td> <input size="20" name="param_{$smarty.section.num_params.index}_value"  " class='egl_terminal_live_text' onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#000000');" onFocus="textbox_set_style(this, '#A80000', '#FFFFFF', '#000000');" type=text name='name_exec'/>
	 		 </tr>
	 		 {/section}
	 		</table>
	 	 	
	 	</td>
	</tr>
	<tr>
		<td valign="top" colspan=3 align="right"><input type="checkbox"/>Detailed  <input type="image" src="images/buttons/new/bt_send.gif"/></td>	
	</tr>
  </table>
 </td></tr>
</table>
</form>


<hr>



<table border=0 cellpadding=0 cellspacing=1 bgcolor="#C5C5C5" width="95%" align="center">
 <tr><td>
	<table border="0" width="100%" bgcolor="#F5F3EF" cellpadding=10 cellspacing=0 align="center">
	 <tr bgcolor="#E8E5DE">
	 	<td> <b>Response in {$bench_time}</b></b> </td>
 	 </tr>
	 <tr>
	 	<td>
	 		<textarea class="egl_textbox" rows=20 style="width:100%">{$soap->request}</textarea>
	 		<textarea class="egl_textbox" rows=20 style="width:100%">{$soap->response}</textarea>
	 	</td>
	</tr>
  </table>
 </td></tr>
</table>



