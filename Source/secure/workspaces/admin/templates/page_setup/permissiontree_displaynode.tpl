

{section name=leaf loop=$node->leaves}
{if $sub==0}
 <tr>
 	<td width="1%" background="images/admin/pagesetup/pt_v.gif" style="background-repeat:repeat-y; background-position:right center;"></td>
{else}
 <tr>
 	<td background="images/admin/pagesetup/pt_v.gif" style="background-repeat:repeat-y; background-position:right center;"></td>
{/if}
 	{section name=td loop=$sub}<td background="images/admin/pagesetup/pt_h.gif" style="background-repeat:repeat-x; background-position:center center;" >&nbsp;</td>{/section}
	<td colspan="{$sub+20}"> 
	
	<table border="0" cellpadding="2" cellspacing="0">
	 <tr>
		{if $sub != 0 && $sub != 1 }	<td><A href=""><img border=0 src="images/admin/pagesetup/up.gif"/></a></td>{/if}
						<td><A href=""><img border=0 src="images/admin/pagesetup/edit.gif"/></td></a>
						<td><A href=""><img border=0 src="images/admin/pagesetup/add.gif"/></td></a>
		{if $sub != 0 }	<td><A href=""><img border=0 src="images/admin/pagesetup/delete.gif"/></a></td>{/if}
				
		{*<td background="images/admin/pagesetup/pt_v.gif" style="background-repeat:repeat-y; background-position:center center;" ></td>*}
		<td class="egl_live_td"> <input size="20" onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#000000');" onFocus="textbox_set_style(this, '#A80000', '#FFFFFF', '#000000');" class='egl_permtree_live_text' type=text name='general_{$workspacefiles[wsf]}' value='{$node->leaves[leaf]->name|strip_tags}' disabled/> </td>
		
		{*<td background="images/admin/pagesetup/pt_v.gif" style="background-repeat:repeat-y; background-position:center center;" ></td>*}
		{*<td class="egl_live_td"> <input size="20"  onBlur="textbox_set_style(this, '{#clr_content#}', '{#clr_content#}', '#000000');" onFocus="textbox_set_style(this, '#A80000', '#FFFFFF', '#000000');"  type=text name='general_{$workspacefiles[wsf]}' value='{$node->leaves[leaf]->const|strip_tags}'/> </td>*}
	  </tr>
	 </table>
	</td>
 <tr>
{/section}

{section name=n loop=$node->nodes}
	{include file="page_setup/permissiontree_displaynode.tpl" node=$node->nodes[n] sub=$sub+1 }
{/section}
