<h2>Module</h2>


{include file="tb/page.open.tpl"}

{if $success}
	<script language="javascript">
	<!--
		parent.navi.location.reload();
	-->
	</script>
{/if}


{if !$success}

<table border="0" cellpadding="1" cellspacing="0" width="100%" bgcolor="#C5C5C5" align="left">
 <tr><td>
 
	{section name=mod loop=$modules}
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#F5F3EF">
	 <tr onClick="if (tableShowHide{$smarty.section.mod.index}.style.display == 'none') tableShowHide{$smarty.section.mod.index}.style.display = 'block'; else tableShowHide{$smarty.section.mod.index}.style.display = 'none';">
		<td bgcolor="#E8E5DE"><table><tr><td><font size="5" face="bold;">{$modules[mod]->sName|strip_tags|stripslashes}</font></td></tr></table></td>
	 </tr>
	 <tr>
	 	<td>
	 		<div id="tableShowHide{$smarty.section.mod.index}" style="display:none;">
				<table width="100%"> 
				 <tr>
					<td valign="top"> 
					
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						 <tr>
						 
							<td width="180" align="center"><img src="images/module_part.jpg"/></td>	 
							<td valign="top">
							
								<table border="0" width="100%">
								 <tr>
								 	<td width="100"><b>ID:</b></td>
								 	<td>{$modules[mod]->ID}</td>
								 </tr>
								 <tr>
								 	<td width="100"><b>Version:</b></td>
								 	<td>{$modules[mod]->sVersion}</td>
								 </tr>
								 <tr>
								 	<td><b>Development:</b></td>
								 	<td>&copy; {$modules[mod]->sDevelopment|strip_tags|stripslashes}</td>
								 </tr>
								 <tr>
								 	<td><b>Größe:</b></td>
								 	<td>N/A{*$modules[mod]->iSize*}</td>
								 </tr>
								</table>
							</td>	
						 </tr>
				  		 <tr>
							<td>  </td>
							<td colspan="2"> {$modules[mod]->sDescription|strip_tags|stripslashes} </td>
						 </tr>
						</table>
						
					</td>
				 </tr>
				 <tr>
					<td align="right"> 
					<hr size="1" color="#D5D3CF">
					<table><tr>
					{if $modules[mod]->bInstalled }
						{if $modules[mod]->bActivated }
							<td>{include file="buttons/bt_universal.tpl" caption="Deaktivieren" link="`$url_file`page=`$url_page`&mid=`$modules[mod]->ID`&a=deactivate" fontcolor="red"}</td>
						{else}
							<td>{include file="buttons/bt_universal.tpl" caption="Aktivieren" link="`$url_file`page=`$url_page`&mid=`$modules[mod]->ID`&a=activate" fontcolor="#000000"}</td>
						{/if}	
						<td>{include file="buttons/bt_universal.tpl" caption="Deinstallieren" link="`$url_file`page=`$url_page`&mid=`$modules[mod]->ID`&a=uninstall" fontcolor="red"}</td>
					{else}
						<td>{include file="buttons/bt_universal.tpl" caption="Installieren" link="`$url_file`page=`$url_page`&mid=`$modules[mod]->ID`&a=install" fontcolor="#000000"}</td>
						<!--#<td>{include file="buttons/bt_universal.tpl" caption="Deaktivieren" link="`$url_file`page=`$url_page`&mid=`$modules[mod]->ID`&a=activate" fontcolor="#000000"}</td>#-->
					{/if}	
					</tr></table>
						
							
					</td>
				 </tr>
				</table>
			</div>
	  </td>
	 
	 </tr>
	</table>
	{/section}	
	
 </td></tr>
</table>

{else}
	{include file="etc/message.tpl"}
{/if}


{include file="tb/page.close.tpl"}