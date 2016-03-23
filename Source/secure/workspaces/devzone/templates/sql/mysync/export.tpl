<h2>{$LNG_BASIC.c1400} &#x95; {$LNG_BASIC.c1402}</h2>

<SCRIPT language="javascript"> var num_tables={$LOCAL_MASK|@count};</SCRIPT>
{literal}
<SCRIPT LANGUAGE="JavaScript">
<!--
	function checkAll() {
		for (var j = 0; j < num_tables; j++) {
			box = eval("document.checkboxform.tb_" + j); 
			if (box.checked == false) box.checked = true;
		   }
	}
	
	function uncheckAll() {
		for (var j = 0; j < num_tables; j++) {
			box = eval("document.checkboxform.tb_" + j); 
			if (box.checked == true) box.checked = false;
		}
	}
	
	function switchAll() {
		for (var j = 0; j < num_tables; j++) {
			box = eval("document.checkboxform.tb_" + j); 
			box.checked = !box.checked;
	   }
	}

-->
</SCRIPT>
{/literal}

<form name="checkboxform" action="{$url_file}page=sql.mysync.download" method="POST">
<input type="hidden" name="num_tables" value="{$LOCAL_MASK|@count}"/>

<fieldset>
	<legend>
		<input type="checkbox" name="export_data" value="yes" checked="checked" />
		<label for="checkbox_htmlword_data">{$LNG_BASIC.c1417}</label>
	</legend>
	
	<table>
		<tr><td><input type="checkbox" name="auto_increment" checked="checked" value="yes"/></td>
			<td>AUTO_INCREMENT - {$LNG_BASIC.c1418}</td>
		</tr>
	</table>
</fieldset>
<br/>
<table><tr>
	 	<td><input type=button value="{$LNG_BASIC.c1404}" onClick="checkAll()"></td>
		<td><input type=button value="{$LNG_BASIC.c1405}" onClick="uncheckAll()"></td>
		<td><input type=button value="{$LNG_BASIC.c1406}" onClick="switchAll()"></td>
</tr></table>

<div style="border : solid 3px #C0C0C0; background-color:#FFF2D3; padding : 0px; width : 100%; height : 400px; overflow : auto; ">
<table cellpadding="0" cellspacing="5">
{section name=tb loop=$LOCAL_MASK}
 <tr>
 	<td><input type="checkbox" checked name="tb_{$smarty.section.tb.index}" value="yes" />
 		<input type="hidden" checked name="tb_name_{$smarty.section.tb.index}" value="{$LOCAL_MASK[tb].name}" />
 		</td>
 	<td>{$LOCAL_MASK[tb].name}</td>
 </tr>
{/section}
</table>
</div>
<table><tr>
		<td>
			<table><tr>
				<td><input type="radio" checked name="export_type" value="file"/> {$LNG_BASIC.c1407}</td>
				<td><input type="radio" name="export_type" value="text"/> {$LNG_BASIC.c1408} </td>
			</tr></table>
		</td>
	 	<td>
	 		<input type="submit" value="exportieren" >
	 	</td>
</tr></table>

</form>
