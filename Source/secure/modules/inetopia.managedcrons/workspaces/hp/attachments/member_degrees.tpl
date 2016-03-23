	<br/>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 <tr><td><h2>Grade</h2></td></tr>
	 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
	</table>

	{if $member_details->premium_activation > 0}
 	<div align="left">
		<table border="0" cellpadding="0">
		 <tr>
			<td align="center"><img src="images/premium_active.gif"/></td>
		 </tr>
		 <tr>
		 	<td align="center"><font class="premium_description">Premium Mitglied</font></td>
		 </tr>
		</table>
	</div>
	{else}
 	<div align="left">
		<table border="0" cellpadding="0">
		 <tr>
			<td align="center"><img src="images/premium_inactive.gif"/></td>
		 </tr>
		 <tr>
		 	<td align="center"><font class="premium_description">Kein Premium Mitglied</font></td>
		 </tr>
		</table>
	</div>
	{/if}
	