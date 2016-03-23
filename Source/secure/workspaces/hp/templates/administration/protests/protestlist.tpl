

<table border="0">
 <tr>
 	<td><img src="images/protest_small.gif"><td>
 	<td><h2>Proteste</h2><td>
 </tr>
</table>


<hr size=1>
<br>

<table border="0" width="100%">
	{section name=protest loop=$protests}
		<tr>
			<td valign="top" colspan="2">
			
			
				<b> Protest erstellt von <A href="{$url_file}page=member.info&member_id={$protests[protest]->member_id}"><u>{$protests[protest]->member_nick_name}</u></a> </b> am {date timestamp=$protests[protest]->created}
				
								
				<br><br>
				
				<table border="0">
				 <tr>
				 	<td><b>Beschreibung:</b> </td>
				 </tr>
				 <tr>
				 	<td>{cutstr num=600 text=$protests[protest]->text} </td>
				 </tr>
				 </table>
			
			</td>
		</tr>
		<tr>
			<td width="50%" align="left">  {if $protests[protest]->match_id != $smarty.const.EGL_NO_ID } <img border=0 src="images/buttons/bt_admin_tomatch.gif"> {/if}</td>
			
			<td align="right"> [ <A href="{$url_file}page=administration.protest&protest_id={$protests[protest]->id}"><b>Admin</b></a> ] </td>
		</tr>
		{if !$smarty.section.protest.last}<tr><td colspan="2"><hr size=1></td></tr>{/if}
	{/section}
</table>