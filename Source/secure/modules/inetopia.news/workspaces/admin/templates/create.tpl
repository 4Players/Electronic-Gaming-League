<h2>News schreiben</h2>
{include file="etc/message.tpl"}
<script language="JavaScript" type="text/javascript" src="javascript/detail_window.js"></script>

{if $success}

{else}

<form name="news_form" action="{$url_file}page={$url_page}&cat_id={$_get.cat_id}&a=go" method="POST">
<table width="100%" cellpadding="20" background="images/admin/timenews.gif" style="background-repeat:no-repeat;">
 <tr><td>
 	<br/><br/><br/>
	<table border="0" cellpadding="0" cellspacing="2" width="100%" bgcolor="#C0C0C0">
	 <tr><td bgcolor="#FFFFFF">
		<table border="0" cellpadding="5" cellspacing="1" width="100%">
		<tr bgcolor="{#clr_content#}">
		 	<td><b>Aktuelle Zeit:</b></td>
		 	<td>{date timestamp=$smarty.const.EGL_TIME}</td>
		</tr>
		<tr bgcolor="{#clr_content#}">
		 	<td><b>veröffentlichen am:</b></td>
		 	<td><input type="text" class="egl_text" value="{date timestamp=$smarty.const.EGL_TIME format='%d.%m.%y'}" name="release_date" size="10"/> um <input type="text" class="egl_text" value="{date timestamp=$smarty.const.EGL_TIME format='%H:%M:%S'}" name="release_clock" size="10"> Uhr</td>
		</tr>
		<!--#
		<tr bgcolor="{#clr_content#}">
		 	<td width="1%"><b>Thema:</b></td>
		 	<td><Input type="text" name="news_subject" value="Unbekannt" class="egl_text" style="width:100%" ></td>
		 </tr>
		 #-->
		 <tr bgcolor="{#clr_content#}">
		 	<td><b>Kategorie:</b></td>
			<td><select style="width:300;" name="news_cat_id" class="egl_select">
					<option value="-1">Keine Kategorie ausgewählt</option>					
					<option disabled >------------------------------------</option>					
					{defun name="testrecursion" catroot=$categoryroot level="0"}
					    <option value="{$catroot->oProperties->id}" {if $catroot->oProperties->id == $_get.cat_id}selected{/if} >{section name=c loop=$level}&nbsp;&nbsp;&nbsp;{/section} {$catroot->oProperties->name}</option>
						{foreach from=$catroot->aNodes item=node} 
							{fun name="testrecursion" catroot=$node level=$level+1 }
						{/foreach}
					{/defun}
			 </select>		
			</td>	 
	 	 </tr>
		<tr bgcolor="{#clr_content#}">
		 	<td><b>Title / Überschrift:</b></td>
		 	<td><Input type="text" name="news_title" value="Unbekannt" class="egl_text" style="width:100%"></td>
		</tr>
		<tr bgcolor="{#clr_content#}">
		 	<td><b>Kurztext:</b><br/>(Max. 255 Zeichen)<br/><input name="charcounter" type="text" class="egl_text" disabled value="0" size="5"></td>
		 	<td><textarea  onkeydown="javascript:document.news_form.charcounter.value=this.value.length;" rows="5" name="news_short_text" class="egl_text" cols="50"></textarea></td>
		</tr>
		<tr bgcolor="{#clr_content#}">
			<td><b>Bilder:</b></td>
			<td>
				<table width="100%">
				 <tr>
				<td colspan="2"><input type="radio" checked name="imagetype" value="non"/>Kein Bild benutzen</td>
				 </tr>
				 <tr>
					<td><input type="radio" name="imagetype" value="uploadfile"/>Bild hochladen (120x90)</td>
					<td><input class="egl_text" type="file" name="upload_file"/> &nbsp;-&nbsp; mit Namensendung: <input class="egl_text" type="text" name="file_extension" size="10"/></td>
				 </tr>
				 <tr>
					<td><input type="radio" {if $news->image_file != "non" && strlen($news->image_file)>0}checked{/if} name="imagetype" value="exists"/>Hochgeladenes Bild nutzen</td>
					<td><b>Dateiliste:</b><br/><select class="egl_select" name="image_file" style="width:100%;" size="3">
							{section name=image loop=$imagefiles}
							{if $news->image_file == $imagefiles[image]}
								<option selected value="{$imagefiles[image]}">{$imagefiles[image]}</option>
							{else}
								<option value="{$imagefiles[image]}">{$imagefiles[image]}</option>
							{/if}
							{/section}
						</select>
					</td>
				 </tr>
				 <tr>
				 	<td colspan="2" align="left"><A href="#"><img onmouseover="javascript:detailwindow_showdiv('uploadsettings');" onmouseout="javascript:detailwindow_hidediv('uploadsettings');" title="Upload Einstellungen" src="images/admin/newsconfigure.gif"/></a></td>
				 </tr>
				</table>
			</td>
		</tr>		
		<tr bgcolor="{#clr_content#}">
		 	<td valign="top"><b>Text:</b></td>
		 	<td><textarea rows="10" name="news_text" class="egl_text" style="width:100%"></textarea></td>
		 </tr>
		<tr bgcolor="{#clr_content#}">
		 	<td></td>
		 	<td><b>BBCode2 Enabled!</b></td>
		 </tr>
		 <tr bgcolor="{#clr_content#}">
		 	<td></td>
		 	<td align="right"><input type="image" src="images/buttons/new/bt_send.gif"/></td>
		 </tr>
		</table>
	 </td></tr>
	</table>
	
 </td></tr>
</table>
</form>


<div id="uploadsettings" style="position:absolute; visibility:hidden; z-index:2">
 <table bgcolor="{#clr_content_border#}" cellpadding="0" cellspacing="1">
  <tr>
  	<td bgcolor="{#clr_content#}">
  		<table>
  		 <tr>
  		 	<td>Uploads zugelassen:</td>
  		 	<td>{$UPLOAD_SETTINGS.file_uploads}</td>
  		 </tr>
  		 <tr>
  		 	<td>Max. Upload Größe (Dateigröße der hochzuladenen Datei):</td>
  		 	<td>{$UPLOAD_SETTINGS.upload_max_filesize}</td>
  		 </tr>
  		 <tr>
  		 	<td>Max. Script Speicher (Speicher den ein Script benutzen darf):</td>
  		 	<td>{$UPLOAD_SETTINGS.memory_limit}</td>
  		 </tr>
  		 <tr>
  		 	<td>Max. Daten, die übermittelt werden können:</td>
  		 	<td>{$UPLOAD_SETTINGS.post_max_size}</td>
  		 </tr>
  		 <tr>
  		 	<td>Max. Laufzeit (Zeit des Ausführens eines Scripts)</td>
  		 	<td>{$UPLOAD_SETTINGS.max_execution_time}</td>
  		 </tr>
  		</table>
  	</td>
  </tr>
 </table>
</div>
{/if}
