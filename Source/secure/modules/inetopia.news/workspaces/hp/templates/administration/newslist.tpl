
<h2>News bearbeiten </h2>

<table border=0 cellpadding="5" cellspacing="1" width="100%" bgcolor="{#clr_content_border#}">
 <tr>
 	<td width="25%"><b>Thema</b></td>
 	<td><b>Titel</b></td>
 	<td><b>Erstellt</b></td>
 </tr>
{section name=n loop=$news}
 <tr bgcolor="{#clr_content#}">
 	{*<td><input type="checkbox" name="" class="egl_checkbox"></td>*}
	<td> <A href="{$url_file}page=administration.news&news_id={$news[n]->id}" title="News bearbeiten"><b>{$news[n]->subject|htmlspecialchars|stripslashes}</b></a></td>
	<td> <A href="{$url_file}page=administration.news&news_id={$news[n]->id}" title="News bearbeiten"><b>{$news[n]->title|htmlspecialchars|stripslashes}</b></a></td>
	<td> <b>{date timestamp=$news[n]->created format="%H:%M:%S<br> %d.%m.%y "}</b></td>
 </tr>
{/section}
<tr bgcolor="{#clr_content_rel#}">
	<td colspan="4" align="center">[ <A href="{$url_file}page=administration.news.create"><b>Neue News</b></a>]</td>
</tr>
</table>