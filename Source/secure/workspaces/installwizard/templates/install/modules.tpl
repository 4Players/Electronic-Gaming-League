<table class="content_header" cellpadding="0" cellspacing="0"><tr>
	<td><img src="images/installwizard/modules.gif"/></td>
	<td><img src="images/spacer.gif" height="1" width="20"/></td>
	<td><b>{$LNG_BASIC.c2300}</b></td>
</tr></table>
<table cellpadding="10" class="content"><tr><td>


	<div style="border : solid 1px #F0F0F0; background-color:FFFFFF; padding : 0px; width : 420px; height : 160px; overflow : auto; " align="center">
	<table cellpadding="10" cellspacing="0" width="100%">
	{section name=mod loop=$modules}
	<tr	onmouseover="this.style.backgroundColor='#F9F6F6';"
		onmouseout="this.style.backgroundColor='';"
		>
		<td><input type="checkbox" checked name="installmodule_{$smarty.section.mod.index}" value="yes"/></td>
		<td><img src="images/installwizard/module_small_inactive.gif"/></td>
		<td><font style="font-size:12px;">
			<b>{$modules[mod]->sName}</b> {$modules[mod]->sVersion} by {$modules[mod]->sDevelopment}<br/>
			{$modules[mod]->sDescription}
		
			</font>
		</td>
	</tr>
	{/section}
	</table>
	</div>

</td></tr></table>
