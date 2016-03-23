{include file="tb/page.open.tpl"}

<h2>Matches</h2>
<br/>


<form name="f" action="javascript:document.location='{$url_file}page=cms.match.admin&match_id='+f.match_id.value;" method="post">
<table width="100%" background="images/match_search.gif" style="background-repeat:no-repeat;" cellpadding="20">
 <tr><td>
 	<br/><br/>
 	 <table cellpadding="0" cellspacing="2" width="300" bgcolor="#C0C0C0">
 	  <tr><td bgcolor="#FFFFFF">
			<table border="0" cellpadding="10" cellspacing="1" width="100%">
			 <tr bgcolor="{#clr_content_border#}">
				<td  align="center"> <b>Schnellsuche</b> </td>
			 </tr>
			 <tr bgcolor="{#clr_content#}">
				<td align="center"><b>ID:</b>&nbsp;&nbsp;<input type="text" class="egl_text" name="match_id" value="{$_post.match_id}" /></td>
			</tr>
			 <tr bgcolor="{#clr_content#}">
			 	<td align="center"><input type="image" src="images/buttons/new/bt_search.gif"/></td>
			 </tr>
			</table>
			
	   </td></tr>
	  </table>
		
  </td></tr>
</table>
</form>

{include file="tb/page.close.tpl"}