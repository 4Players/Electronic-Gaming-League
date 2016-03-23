
{if $_get.comment == 'write' AND Isset($member) }
<br>
{include file="devs/hr_black.tpl" width="100%"}
<br>
<a name="comment_write">
 <form method="POST">
	<table border="0" align="center" width="70%">
	 <tr>
	 	<td> <b>Kommentar</b>: </td>
	 </tr>
	 <tr>
		<td align="center"> <textarea name="comment_text" class="egl_textarea" rows="15" style="width:100%"></textarea>	</td>
	 </tr>
	 <tr>
	 	<td align="right"> <input type=submit class="egl_button" value="Send"></td>
	 </tr>
	</table>
 </form>
</a>
{/if}