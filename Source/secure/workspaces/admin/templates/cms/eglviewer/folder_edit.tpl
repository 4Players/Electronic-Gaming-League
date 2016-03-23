<h2>Kategorie bearbeiten</h2>


{if $CatRoot->oProperties->id != -1}
	<table cellpadding="5" border="0">
	 <tr>
	 	<td><img src="images/admin/folder_opened.gif"/></td>
	 	<td ><b>{$CatRoot->oProperties->name}</b><br/>
			<table cellpadding="2" border="0"><tr>
			 <td align="center"><A title="EGL-ROOT" href="{$url_file}page=cms.eglviewer.overview&cat_id=-1">Root</a></td> <td align="center"><b>	&raquo;</b></td>
			{section name=path loop=$path}
				<td align="center"><A title="{$path[path]->name}" href="{$url_file}page=cms.eglviewer.overview&cat_id={$path[path]->id}">{$path[path]->name}</a></td> {if !$smarty.section.path.last}<td align="center"><b>&raquo;</b></td>{/if}
			{/section}
			</tr></table>
	 	
	 	</td>
	 </tr>
	</table>
{else}

	<table cellpadding="5" border="0">
	 <tr>
	 	<td><img src="images/admin/folder_opened.gif"/></td>
	 	<td><A title="EGL-ROOT" href="{$url_file}page=cms.eglviewer.overview&cat_id=-1">Root</a></td>
	 </tr>
	</table>
	
{/if}

<form name="f" action="{$url_file}{url_params}&a=go" method="POST">
<table cellpadding="5" cellspacing="1" bgcolor="{#clr_content_border#}" width="600">
 <tr bgcolor="{#clr_content#}">
 	<td width="100"><b>Erstellt am:</b></td>
 	<td>{date timestamp=$cat->created}</td>
  </tr>
 <tr bgcolor="{#clr_content#}">
 	<td><b>Verzeichnis:</b></td>
 	<td><select style="width:100%;" name="cat_id" class="egl_select">
			<option value="-1">Bitte Kategorie wählen</option>					
			<option disabled >------------------------------------</option>					
			{defun name="testrecursion" catroot=$categoryroot level="0"}
			    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $cat->cat_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
				{foreach from=$catroot->aNodes item=node} 
					{fun name="testrecursion" catroot=$node level=$level+1 }
				{/foreach}
			{/defun}
		</select> 	
 	</td>
  </tr>
 <tr bgcolor="{#clr_content#}">
 	<td><b>Name:</b></td>
 	<td><input type="text" class="egl_text" value="{$cat->name}" name="name" style="width:100%;"/></td>
  </tr>
  <tr>
  	<td colspan="2">
  	{include file="buttons/bt_universal.tpl" caption="abschicken" link="javascript:document.f.submit();"}
  	</td>
  </tr>
 </table>
 </form>