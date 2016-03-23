{if $_get.comment == "write" AND Isset($member) }
<a name="comment_write">
 <form name="comment_write" method="POST">
	<table border="0" align="center" width="100%">
	 <tr>
	 	<td><b>{$LNG_BASIC.c4202}</b>:</td>
	 </tr>
	 <tr>
		<td align="center"> <textarea name="comment_text" class="egl_textbox" rows="15" style="width:100%"></textarea>	</td>
	 </tr>
	 <tr>
	 	<td align="center">{include file="buttons/bt_universal.tpl" caption=$LNG_BASIC.c1018 color=$GLOBAL_COLOR link="javascript:document.comment_write.submit();"}</td>
	 </tr>
	</table>
 </form>
</a>
{/if}