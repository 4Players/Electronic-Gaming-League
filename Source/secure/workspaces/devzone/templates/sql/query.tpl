<h2>{$LNG_BASIC.c1300}</h2>

<form action="{$url_file}page={$url_page}" name="f" method="POST">
<table width="100%" border="0">
 <tr>
 	<td><textarea name="query" style="width:100%" rows="10">{$smarty.post.query|strip_tags|stripslashes}</textarea></td>
  </tr>
  <tr>
  	<td><input type="submit" value="{$LNG_BASIC.c1301}"/></td>
  </tr>
</table>
</form>

{if isset($NO_RESULTS)}
{$LNG_BASIC.c1303}
{else}
	{if isset($OUTPUT)}<h2>{$LNG_BASIC.c1302}</h2> {$OUTPUT} {/if}
{/if}
<br/>{$ERROR}

<hr/>