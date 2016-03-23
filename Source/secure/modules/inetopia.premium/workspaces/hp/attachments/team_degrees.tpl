{if sizeof($PREMIUM_ACCOUNTS) > 0}
	<br/>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	 <tr><td><h2>Premium-Mitgliedschaft</h2></td></tr>
	 <tr><td>{include file="devs/hr_black.tpl" width="100%"}</td></tr>
	</table>

	<table>
	<tr>

	{section name=prem loop=$PREMIUM_ACCOUNTS}	
	{if $PREMIUM_ACCOUNTS[prem]->access_time*60 > $smarty.const.EGL_TIME-$PREMIUM_ACCOUNTS[prem]->first_activation}	
	
	 	<td>
			<table border="0" cellpadding="0">
			 <tr>
				<td align="center">{if strlen($PREMIUM_ACCOUNTS[prem]->enabled_image) > 0}<img src="files/premium_pool/{$PREMIUM_ACCOUNTS[prem]->enabled_image}"/>{/if}</td>
			 </tr>
			 <tr>
			 	<td align="center"><font class="premium_description">{$PREMIUM_ACCOUNTS[prem]->name|strip_tags|stripslashes}</font></td>
			 </tr>
			</table>
		</td>
	{/if}	
	{/section}
	</tr>
	</table>
{/if}