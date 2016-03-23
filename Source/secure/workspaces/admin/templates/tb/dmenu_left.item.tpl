
 <tr>
 	{if strlen($image) > 0 }	
 		<td width="1%" align="center">  <img src="{$image}"> </td> 
 	{else}
 		<td width="1%" align="center">  <img src="images/spacer.gif" width="20"> </td> 
 	
 	{/if}
 	<td> <A class="base_navi" href="{$url_file}page={$link}"> {$name} </a> </td>
 </tr>