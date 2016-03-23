<table width="100%">
 <tr><td align="right"><b>Durckversion</b></td></tr>
</table>

<h2>{$news->title|strip_tags|stripslashes}</h2>
<b>{$news->short_text|strip_tags|stripslashes}</b>
<hr/>
{$news->text|strip_tags|bbcode2html|nl2br}