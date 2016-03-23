	<table border="0">
	 <tr><td>
	 
	  {capture assign="cat_lines"}{compute_lines array=$root_tree->aNodes items_per_line=$cats_per_line}{/capture}
		<table border="0">
		   {section name=y loop=$cat_lines}
			 <tr>
			   {section name=x loop=$cats_per_line}
			   {assign var="index" value=$smarty.section.y.index*$cats_per_line+$smarty.section.x.index}
			   {if $index < sizeof($root_tree->aNodes) }
			    <td align="center">
					<table cellpadding="10">
					 <tr>
						<!--#<td><A title="{$root_tree->aNodes[$index]->oProperties->name}" href="{$url_file}page={$url_page}&cat_id={$root_tree->aNodes[$index]->oProperties->id}"><img onmouseout="javascript:change_image_src( this, 'images/admin/folder.gif');" onmouseover="javascript:change_image_src( this, 'images/admin/folder_selected.gif');"  src="images/admin/folder.gif" border="0"/></a></td>#-->
						<td align="center">
							<A title="{$root_tree->aNodes[$index]->oProperties->name}" href="{$url_file}page={$url_page}&cat_id={$root_tree->aNodes[$index]->oProperties->id}"><img src="images/admin/folder.gif" border="0"/></a><br/>
							
							{if $options == "true"}
								{include file="cms/eglviewer/folder_options.tpl" cat_id=$root_tree->oProperties->id properties=$root_tree->aNodes[$index]->oProperties}
							{/if}
						</td>
					 </tr>
					 <tr>
						<td align="center">{$root_tree->aNodes[$index]->oProperties->name}</td>
					 </tr>
					</table>
				</td>
				{/if}
				{/section}
			 </tr>
			{/section}
		</table>
		
		</td></tr>
		<!--#
		<tr><td>

			{* ZUM ROOT *}
			{if $root_tree->oProperties->cat_id == -1}
				<table cellpadding="5">
				 <tr>
					<td><A title="{$root_tree->oProperties->name}" href="{$url_file}page={$url_page}&cat_id=-1"><img src="images/admin/folder_back.gif" border="0"/></a></td>
				 </tr>
				 <tr>
					<td align="center"><font size="1"><i>zurück zum ROOT</i></font></td>
				 </tr>
				</table>
			{else}
		
				{if $root_tree->oSubProperties}
					<table align="left" cellpadding="5">
					 <tr>
						<td><A title="{$root_tree->oSubProperties->name}" href="{$url_file}page={$url_page}&cat_id={$root_tree->oSubProperties->id}"><img src="images/admin/folder_back.gif" border="0"/></a></td>
					 </tr>
					 <tr>
						<td align="center"><i>zurück zu {$root_tree->oSubProperties->name}</i></td>
					 </tr>
					</table>
				{else}
				{/if}
			{/if}
			
		</td></tr>
		#-->
	</table>