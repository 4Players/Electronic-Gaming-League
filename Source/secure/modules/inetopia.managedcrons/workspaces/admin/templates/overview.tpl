{literal}
<style type="text/css">
	A.error_a:link, A.error_a:visited
	{ COLOR: #FFF; text-decoration: underline;font-size: 9px;FONT-FAMILY: verdana;}
	A.error_a:active, A.error_a:hover
	{ COLOR: #FFF; text-decoration: none; font-size: 9px; FONT-FAMILY: verdana; }
</style>
{/literal}

<h2>{$LNG_MODULE.c1000}</h2>
{include file="etc/message.tpl"}

<table cellpadding="5" cellspacing="1" width="100%" bgcolor="{#clr_content_border#}">
{section name=mc loop=$managedcrons}
 <tr bgcolor="{#clr_content#}">
 	 <td>
 	 
 	 	<table border="0" width="100%" cellpadding="2">
 	 	{if $managedcrons[mc].activated}
 	 		 <tr><td valign="top" align="center" width="100"><img src="images/managedcron/managedcron_enabled.gif"/></td>
 	 	 {else}
 	 		 <tr><td valign="top" align="center" width="100"><img src="images/managedcron/managedcron_none.gif"/></td>
 	 	 {/if}
 	 	 	<td>
	 	 	 <table border="0" width="100%"  cellpadding="5">
	 		 {if !$managedcrons[mc].system_requirements}
	 	 	 <tr><td>
	 	 	 	{if $managedcrons[mc].required_moduleid != $smarty.const.EGL_NO_ID}
	 	 	 		{if isset($managedcrons[mc].available_module) }
						<div style="border:1px dashed white; padding:5px; background-Color:#FF3C00;"><font color="white"><b>{lng_parser content=$LNG_MODULE.c1012 module_name=$managedcrons[mc].available_module.name required_version=$managedcrons[mc].required_version}</b></font></div>
	 	 	 		{else}
							<div style="border:1px dashed white; padding:5px; background-Color:#FF3C00;"><font color="white"><b>{$LNG_MODULE.c1013}. <a target="_blank" class="error_a" href="http://www.electronicgamingleague.de/managedcrons/details/{$managedcrons[mc].managedcron_id}.html">{$LNG_MODULE.c1014}</a>.</b></font></div>
	 	 	 		{/if}
	 	 	 	{else}
					
	 	 	 	{/if}
	 	 	 </tr></td>
	 	 	 {/if}
	 	 	 <tr><td><font style="font-size:13px;font-weight:bold;">{$managedcrons[mc].name|strip_tags|stripslashes}</font></td></tr>
	 	 	 <tr><td>{$managedcrons[mc].description|strip_tags|stripslashes}</td></tr>
			{if $managedcrons[mc].activated}
			<tr>
				<td>
					<table cellpadding="5"  style="border:1px dashed #000; padding:5px; width:400px;" >
						<tr>
							<td width="100"><b>{$LNG_MODULE.c1004}:</b></td>
							<td>{date timestamp=$managedcrons[mc].last_call}</td>
						</tr>
						<tr>
							<td><b>{$LNG_MODULE.c1005}:</b></td>
							<td>{$managedcrons[mc].calls|tointeger}
								{if $managedcrons[mc].calls_failed > 0}/ <b>{$managedcrons[mc].calls_failed}  {$LNG_MODULE.c1006}</b>{/if}
							</td>
						</tr>
					</table>
				</td>
			</tr>
			{/if}
	 		 {if $managedcrons[mc].system_requirements}
	 	 	 <tr>
	 	 	 	 <td>
			 	 	{if $managedcrons[mc].activated}
				 	 	{include file="buttons/bt_universal.tpl" fontcolor="#FF3C00" caption=$LNG_MODULE.c1003 link="javascript:document.location.href='`$url_file`page=`$url_page`&managedcron_id=`$managedcrons[mc].managedcron_id`&a=unregister';"}
			 	 	{else}
				 	 	{include file="buttons/bt_universal.tpl" caption=$LNG_MODULE.c1002 link="javascript:document.location.href='`$url_file`page=`$url_page`&managedcron_id=`$managedcrons[mc].managedcron_id`&a=register';"}
			 	 	{/if}
				 </td>
			</tr>
		 	{/if}
			</table>
			
 	 	</td></tr>
 	 	</table>
 	 	
 	 </td>
 </tr>
 {/section}
</table>