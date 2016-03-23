{if isset($poll)}
<table width="100%" cellpadding="10">
 <tr>
 	<td align="center">
 	
 		<table border="0" width="100%" cellpadding="5" cellspacing="1">
 		 <tr bgcolor="{#clr_content_border#}">
 		 	<td colspan="3"><b>{$poll->question|strip_tags|stripslashes}</b></td>
 		 </tr>
 		 {section name=_ans_ loop=$answers}
 		 <tr bgcolor="{#clr_content#}">
 		 	<td>{$answers[_ans_]->answer|strip_tags|stripslashes}</td>
 		 	<td width="30%">
			 	<table border="0" width="{percent max=$poll->num_hits value=$answers[_ans_]->hits}%" cellpadding="0" cellspacing="1">
			 	 <tr><td bgcolor="#FFA901" background="images/poll_processbar.gif" style="background-repeat:repeat-x;"><img src="images/spacer.gif" height="10"></td></tr>
			 	 </table> 		 	
 		 	</td>
	 		<td width="100">{percent max=$poll->num_hits value=$answers[_ans_]->hits}% / {$answers[_ans_]->hits} <br/>
	 		Stimmen	 		
	 		</td>
 		 </tr>
 		 {/section}
 		</table>
 		Insgesamt  {$poll->num_hits} Stimmen
 	</td>
 </tr>
</table>
{/if}