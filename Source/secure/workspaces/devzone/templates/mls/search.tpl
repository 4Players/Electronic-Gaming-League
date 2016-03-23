<h2>{$LNG_BASIC.c1111}</h2>
<form method="POST">
<input type="hidden" name="action" value="go"/>
<table cellpadding="5"  align="center" border="0" width="700">
	<tr>
		<td>{$LNG_BASIC.c1000}</td>
		<td width="500"><input type="text" name="search_key" value="{$_post.search_key}" style="width:100%;"/></td>
		<td><select name="lng">
				{section name=lng loop=$languages}
				{if isset($_post.lng)}
					<option {if $_post.lng == $languages[lng].token}selected{/if} value="{$languages[lng].token}">{$languages[lng].name}</option>
				{else}
					<option {if $LANGUAGE == $languages[lng].token}selected{/if} value="{$languages[lng].token}">{$languages[lng].name}</option>
				{/if}
				{/section}
					
			</select>
		</td>
		<td><input type="submit" value="{$LNG_BASIC.c1003}"/></td>
	</tr>
	<tr>
		<td></td>
		<td valign="top">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="radio" {if $_post.search_type=="keyword" OR !isset($_post.search_type) }checked{/if} name="search_type" value="keyword"/>{$LNG_BASIC.c1001}</td>
					<td>&nbsp;&nbsp;</td>
					<td><input type="radio" {if $_post.search_type=="id"}checked{/if} name="search_type" value="id"/>{$LNG_BASIC.c1002}</td>
				</tr>
			</table>
		</td>
		<td colspan="2">
			<table width="200">
			<tr><td>
			<select name="workspace" style="width:100%;">
				<option {if $_post.workspace == "all"}selected{/if} value="all">{$LNG_BASIC.c1100}</option>
				{section name=ws loop=$WORKSPACES}
					<option {if $_post.workspace == $WORKSPACES[ws]}selected{/if} value="{$WORKSPACES[ws]}">WS:{$WORKSPACES[ws]}</option>
				{/section}
			</select>
			</td></tr>
			<tr><td>			
			<select  name="platform" style="width:100%;">
				<option {if $_post.platform == "all"}selected{/if} value="all">{$LNG_BASIC.c1101}</option>
				<option {if $_post.platform == "base"}selected{/if} value="base">{$LNG_BASIC.c1102}</option>
				{section name=mod loop=$MODULES}
					<option {if $_post.platform == $MODULES[mod]->ID }selected{/if} value="{$MODULES[mod]->ID}">{$MODULES[mod]->sName} ({$MODULES[mod]->ID})</option>
				{/section}
			</select>
			</td></tr>
			</table>
		</td>
	</tr>
</table>
</form>
{if isset($RESULTS)}
<h2>{$LNG_BASIC.c1103} ({$RESULTS|@count})</h2>
<table width="100%" align="center" cellpadding="5" cellspacing="1">
	<tr bgcolor="#ffe4cf">
		<td width="100"><b>{$LNG_BASIC.c1002}</b></td>
		<td width="100"><b>{$LNG_BASIC.c1107}</b></td>
		<td width="100"><b>{$LNG_BASIC.c1106}</b></td>
		<td width="100"><b>{$LNG_BASIC.c1110}</b></td>
		<td width="400"><b>{$LNG_BASIC.c1105}</b></td>
		<td><b>{$LNG_BASIC.c1109}</b></td>
		<td><b>{$LNG_BASIC.c1104}</b></td>
	</tr>
	{section name=r loop=$RESULTS}
	
	{if $smarty.section.r.index % 2 == 0}
	<tr bgcolor="#EFEFEF">
	{else}
	<tr>
	{/if}
		<td>{$RESULTS[r].key}</td>
		<td>{$RESULTS[r].module_name}</td>
		<td>{$RESULTS[r].location}</td>
		<td>{$RESULTS[r].workspace}</td>
		<td>{cutstr text=$RESULTS[r].value num=50}</td>
		<td><font style="font-size:11px">{literal}{{/literal}$LNG_{if $RESULTS[r].location=="module"}MODULE{/if}{if $RESULTS[r].location=="basic"}BASIC{/if}.{$RESULTS[r].key}{literal}}{/literal}</font></td>
		<td>{$RESULTS[r].file}</td>
	</tr>
	{/section}
</table>
{/if}

<br/><br/><br/>
