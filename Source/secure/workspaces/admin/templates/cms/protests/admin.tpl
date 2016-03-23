

<table border="0">
 <tr>
 	<td><h2>Protest verwalten</h2><td>
 </tr>
</table>

<hr size=1 width="100%">
<br>

{if $protest}
	<table border="0" width="100%">
		<tr>
			<td width="30%" valign="top" align="center"> 
			
			{if $protest->administrated}
				<A href="javascript:location.reload()"><img border=0 src="images/protest_administrated.gif"></a> <br>
				<br>
				<b>Admin: <u> <A href="{$url_file}page=member.info&member_id={$protest->admin_id}">{$protest->admin_nick_name}</a></u> 
			{else}
				<A href="javascript:location.reload()"><img border=0 src="images/protest.gif"></a> <br>
			{/if}

			<br><br><br>
			
				
			{if $protest->match_id != $smarty.const.EGL_NO_ID } 
				<A href="{$url_file}page=admin.match&match_id={$protest->match_id}" > <img border=0 src="images/buttons/bt_admin_tomatch.gif"> </a> 
				<br>
				[ <a href="{$url_file}page=match.info&match_id={$protest->match_id}">Show</a> ]
			{/if}
			
			
			
			</td>
			<td valign="top">
			<b> Protest erstellt von <A href="{$url_file}page=member.info&member_id={$protest->member_id}"><u>{$protest->member_nick_name}</u></a> </b> am {date timestamp=$protest->created}
					
									
			<br><br>
					
				<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}">
				 <tr>
				 	<td><b>Beschreibung:</b> </td>
				 </tr>
				 <tr bgcolor="{#clr_content#}">
				 	<td>{cutstr num=600 text=$protest->text|nl2br} </td>
				 </tr>
				 </table>
			
				 <br><br>
				 
				 <form action="{$url_file}page={$url_page}&protest_id={$protest->id}&a=go" method="POST">
				<table border="0" width="100%" cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}">
				 <tr>
				 	<td><b>Antwort:</b> </td>
				 </tr>
				 <tr bgcolor="{#clr_content#}" align="center">
				 	<td><textarea name="admin_text" class="egl_text" cols="60"  rows="10">{$protest->admin_text}</textarea>
				 </tr>
				 <tr bgcolor="{#clr_content#}" align="right">
				 {if $protest->administrated}
		 			<td><input type="checkbox" class="egl_checkbox" value="yes" name="administrated" checked> <b>Protest abgearbeitet</b></td>
				 {else}
		 			<td><input type="checkbox" class="egl_checkbox" value="yes" name="administrated"> <b>Protest abgearbeitet</b></td>
				 {/if}
				 </tr>
				 <tr bgcolor="{#clr_content#}" align="right">
		 			<td><input type="submit" class="egl_button" value=" Send "></td>
				 </tr>
				 </table>
				 </form>
				 
			 	<br><br>
			 	
				<table border="0" width="100%" bgcolor="{#clr_content_border#}" cellpadding="3" cellspacing="0">
				 <tr>
				 	<td align="right"> <A href='{$url_file}page={$url_page}&protest_id={$protest->id}&comment=write#comment_write'> <b>Kommentare {#clip_start#}{$num_comments}{#clip_end#}</b> </a> </td> 
				 </tr>
				</table>
				
				{include file="etc/comment.show.tpl"}
				<br>
				{* WRITE ? !! *}
				{include file="etc/comment.write.tpl"}
							 
				 
			</td>
		</tr>
	</table>
{else}
<font color="{#clr_rank_red#}"><b>Protest nicht  gefunden</b></font>
{/if}
