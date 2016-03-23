<link rel="stylesheet" href="css/egl_design.css" type="text/css"/>

<h2>{$cup->name|strip_tags|stripslashes}</h2>
<b>Turnierbaum</b><br/>
<br/>

<table width="100%" cellpadding="10" cellspacing="0">
 <tr>
  <td>
	{include file="`$page_dir`/cuptree.display.tpl" }
  </td>
 </tr>
</table>
