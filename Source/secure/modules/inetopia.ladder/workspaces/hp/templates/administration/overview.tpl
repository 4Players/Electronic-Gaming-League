<h2>Spielübersicht</h2>

<script language="JavaScript" type="text/javascript" src="javascript/detail_window.js"></script>
{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}

	function change_image_src( obj, pic ){obj.src = pic;}
</script>
{/literal}

<br/>

  {assign var="cats_per_line" value="5"}
  {capture assign="cat_lines"}{compute_lines array=$games items_per_line=$cats_per_line}{/capture}
	<table border="0"  cellpadding="10">
	   {section name=y loop=$cat_lines}
		 <tr>
		   {section name=x loop=$cats_per_line}
		   {assign var="index" value=$smarty.section.y.index*$cats_per_line+$smarty.section.x.index}
		   {if $index < sizeof($games) }
		   		<td align="center"> 
		   			<table bgcolor="#000000" cellpadding="1" cellspacing="0"><tr><td>
		   				<A href="{$url_file}page={$CURRENT_MODULE_ID}:administration.gameladders&game_id={$games[$index]->id}"><img onmousemove="javascript:detailwindow_showdiv('dwindow{$games[$index]->id}');" onmouseout="javascript:detailwindow_hidediv('dwindow{$games[$index]->id}');" border="0" src="{$PATH_GAMES}small/{$games[$index]->logo_small_file}" width="90" height="120"/></a>
					</td></tr></table>		
					<br/><font style="font-size:10px;">{$games[$index]->name}</font>
			   			
		 		</td> 
			 {/if}
			 {/section}
		</tr>
	{/section}
	</table>


<!--# DETAIL WINDOWS #-->
{section name=game loop=$games}
<div id="dwindow{$games[game]->id}" style="position:absolute; visibility:hidden; z-index:2">
	<table width="250" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
	 <tr>
	 	<td bgcolor="{#clr_content#}">
	 	<table><tr><td>
		<b>{$games[game]->name}</b> <br/>
		<br/>
		Aktive Ladder: {$games[game]->num_gameladders}</b> <br/>
		<br/>
		<!--#<font style="font-size:10px;">erstellt am {date timestamp=$games[game]->created format="%d.%m.%y %H:%M:%S"}</font> <br/>#-->
		
		</td></tr>
		</table>
	 	</td>
	 </tr>
	</table>	
</div>
{/section}
