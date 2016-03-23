	{capture assign="boxname"}Box{rndname}{/capture}
	<script language="javascript">
	<!--
	function showdescription_{$boxname}()
	{literal}{{/literal}
		if( {$boxname}_short.style.display == 'none' )
		{literal}{ {/literal}
			{$boxname}_short.style.display = 'block'; 
			{$boxname}_long.style.display = 'none'; 
		{literal}} {/literal}
		else
		{literal}{ {/literal} 
			{$boxname}_short.style.display = 'none';
			{$boxname}_long.style.display = 'block'; 
		{literal}} {/literal}
	{literal}}{/literal}
	-->
	</script>

	<div id="{$boxname}_short" style="display:block;">
		{$text|strip_tags|truncate:100|bbcode2html|nl2br}
	</div>
	<div id="{$boxname}_long" style="display:none;">
		{$text|strip_tags|bbcode2html|nl2br}
	</div>
	<div align="right">
	<A href="javascript: showdescription_{$boxname}();">{$link}</a>
	</div>