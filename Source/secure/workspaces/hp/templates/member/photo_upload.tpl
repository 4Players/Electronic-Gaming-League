<h2>{$LNG_BASIC.c4550}</h2><br/>
{include file="devs/message.tpl"}

 		
{* Anzeigen, wenn nicht erfolreich *}
{if !$photo_success }

	<form name="f" enctype="multipart/form-data" action="{$url_file}page={$url_page}&a=go" method="post" >
	<table border="0" cellpadding="4" cellspacing="1" align="center" bgcolor="{#clr_content_border#}" width="90%">
	 <tr bgcolor="{#clr_content#}"><td>

	 
	 <table border=0 align="center" cellpadding="5">
		<tr>
		 <td colspan=2 align="center">  
				
		 		<i> ({$LNG_BASIC.c4551}) </i> <br>
		 		<table border=0 bgcolor="#000000" cellpadding="0" cellspacing="1">
		 		 <tr><td>
		 		 {if $member->photo_file != 'non'}
		 			<img src="{$path_photos}{$member->photo_file}" width="100" height="133">
	 			{else}
		 			<img src="images/photo.na.jpg" width="100" height="133">
		 		{/if}
		 		</td></tr>
		 		</table>
		 		
		 		<br><BR>
			
			</td>
		</tr>
		<tr valign="top"> 
			<td width="40%"><b>{$LNG_BASIC.c4552}:</b></td>
			<td><b><input type='file' class='egl_text' name='upload_photo_file' > </td>			
		</tr>
		<tr>
			<td></td>
			<td><input type="checkbox" class="egl_checkbox" name='upload_photo_delete' value='1'/> {$LNG_BASIC.c4553}</td>
		</tr>
		<tr>
			<td></td>
			<td>{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1018 link="javascript:document.f.submit();"}</td>
		</tr>		
		</table>
		
	</td></tr>
	</table>
	</form>
	
{/if}
