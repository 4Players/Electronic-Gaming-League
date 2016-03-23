<table border="0" width="100%" cellpadding="0" cellspacing="0">
 <tr><td valign="top">
	
	<table><tr><td><img src="images/cupicon_gold_small.gif" width="50"/></td><td><font style="font-size:20px;">{$cup->name|strip_tags|stripslashes}</font><br/><b>{$LNG_MODULE.c1200}</b></td></tr></table>
	<br/>
	<table cellpadding="0" cellspacing="0" align="center"  width="400">
	 <tr>
	 	<td width="100"><b>{$LNG_MODULE.c1002}:</b></td><td>{date timestamp=$cup->start_time}</td>
	 </tr>
	 <tr>
	 	<td><b>{$LNG_MODULE.c1201}:</b></td>
	 	<td>{$cuptree_numrounds-1}</td>
	 </tr>
 
	</table>
	<br/>
	
	{if $cup->finished}
		{include file="devs/hr2.tpl" width="100%"}<br/>
		<div align="left"><h2>{$LNG_MODULE.c1008}:</b></h2>
		<br/>
		<table width="100%" border="0" align="center" cellpadding="0">
		 <tr>
			<td>{include file="`$page_dir`/ranking.tpl"}</td>
		 </tr>
		</table>
	{/if}
				
	

 </td>
 <td width="100" align="center" valign="top">
 
	{include file="`$page_dir`/menu_right.tpl"} 
	
 </td></tr>
</table>

<br/><br/>
{include file="devs/hr2.tpl" width="100%"}

<table align="center" cellpadding="0" cellspacing="0"><tr><td>{include file="`$page_dir`/cuptree.display.tpl" }	</td></tr></table>
