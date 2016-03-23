<h2>News verwalten</h2>

<form action="{$url_file}page={$url_page}&news_id={$news->id}&a=go" method="POST">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr><td>
	<table border="0" cellpadding="5" cellspacing="1" width="100%">
	 <tr>
	 	<td colspan="2" align="right"><b>Erstellt am {date timestamp=$news->created} </b></td>
	</tr>
	 <tr>
	 	<td width="1%"><b>Thema:</b></td>
	 	<td><Input style="width:100%" type="text" name="news_subject" class="egl_text" value="{$news->subject|stripslashes|htmlspecialchars}"></td>
	 </tr>
	 <tr >
	 	<td><b>Title:</b></td>
	 	<td><Input style="width:100%" type="text" name="news_title" class="egl_text" value="{$news->title|stripslashes|htmlspecialchars}"\></td>
	 </tr>
	 <tr >
	 	<td valign="top"><b>Text:</b></td>
	 	<td><textarea rows="40" name="news_text" style="width:100%">{$news->text|stripslashes|htmlspecialchars}</textarea></td>
	 </tr>
	 <tr>
	 	<td></td>
	 	<td><b>BBCode2 Enabled!</b></td>
	 </tr>
	 <tr>
	 	<td></td>
	 	<td bgcolor="{#clr_content_border#}" align="right"><input type="submit" class="egl_button" value=" Send "></td>
	 </tr>
	</table>
 </td></tr>
</table>
</form>