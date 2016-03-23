
<form>

 <table border="0" cellpadding="0" cellspacing="1" bgcolor="#C5C5C5" width="100%">
  <tr><td>
  
	<table width="100%" cellpadding="5" cellspacing="0">
	 <tr bgcolor="#E8E5DE">
	 	<td width="5%" align="right"><b>Workspace:</b></td>
	 	<td>
		<select name="match_option_list" ONCHANGE="location = this.options[this.selectedIndex].value;">
			<option value="">-Bitte Workspace wählen-</option>
			<option disabled>---------------------</option>
			{section name=ws loop=$workspaces}
				{if $workspaces[ws] == $curr_workspace}
					<option selected value="{$url_file}page={$url_page}&ws={$workspaces[ws]}"> {$workspaces[ws]} </option>
				{else}
					<option value="{$url_file}page={$url_page}&ws={$workspaces[ws]}"> {$workspaces[ws]} </option>
				{/if}
			{/section}
		</select>
		</td>
	 </tr>
	</table>
	
 </td></tr>
</table>

</form>

In this version, not available.
<br><br>

{*
<form>
<table border=0 cellpadding=0 cellspacing=1 bgcolor="#C5C5C5" width="95%" align="center">
 <tr><td>
	<table border="0" width="100%" bgcolor="#F5F3EF" cellpadding=5 cellspacing=0 align="center">
	 <tr bgcolor="#E8E5DE">
	 	<td align="center" width="1%"><b>T</b></td> 
	 	<td><b>Document</b></td>
	 	<td><b>Access-Definition</b></td>
	  </tr>
	 <tr bgcolor="#6576A2">
	 	<td></td>
	 	<td colspan="2"><font color="#FFFFFF"><i>Generals</i></font></td>
 	 </tr>
		{section name=wsf loop=$workspacefiles}
		
		<tr>
				<td><img src="images/admin/pagesetup/nophp_site.gif"></td>
				<td width="30%">{$workspacefiles[wsf]}</td>
				<td class="egl_live_td"> <input onBlur="textbox_set_style(this, '#000000', '{#clr_content#}', '#A00000');" onFocus="textbox_set_style(this, '#A80000', '#FFFFFF', '#000000');" class='egl_live_text' type=text name='general_{$workspacefiles[wsf]}' value='{$workspacefileaccess[wsf]|strip_tags}'> </td>
			</tr>
		{/section}
	 </table>
	 
 </td></tr>
</table>	
*}