<table width="100%">
 <tr>
   <td valign="top">

	<table border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" width="100%" align="center"> 
	 <tr bgcolor="#FEFEFE">
	 	<td align="right"> 
	 		<table border="0" width="100%">
	 		 <tr>
	 		 	<td><font color="#000000"><b>{date timestamp=$news->released format="%d.%m.%y / %H:%M"}</b></font></td>
	 		 	<td width="40%"> 
	 		 	
	 		 		<table border="0" cellpadding="0" cellspacing="0" width="100%">
	 		 		 <tr>
	 		 			<td align="right">
	 		 				<table border="0">
	 		 				 <tr>
	 		 				 	<td><img src="images/print_icon.gif"></td>
	 		 				 	<td><a target="_blank" href="{$DOMAIN_ROOT}popup.php?page={$CURRENT_MODULE_ID}:print&news_id={$news->id}"><font color="#000000"><b>{$LNG_MODULE.c1000}</b></font></a></td>
	 		 				 </tr>
	 		 				</table>
	 		 			</td>
	 		 		</table>
	 		 		
	 		  </td></tr>
	 		</table>
	 		
	 </td></tr>
	</table>
	
	<table border="0" cellpadding="5" cellspacing="0" width="100%">
	 <tr>
		<td><h1>{$news->title|strip_tags|stripslashes}</h1></td>
	 </tr>
	 <tr>
		<td><b>{$news->short_text|strip_tags|nl2br|stripslashes}</b></td>
	 </tr>
	 <tr>
	 	<td>{include file="devs/hr2.tpl" width="100%"}</td>
	 </tr>
	 <tr>
	 	<td>{$news->text|strip_tags|nl2br|stripslashes|bbcode2html}</td>
	 </tr>
	</table>
	
	<div align="right">
		<font color="#000000" style="font-size:10px;"> {$num_comments} {$LNG_BASIC.c4203}, {if $news->member_id != $smarty.const.EGL_NO_ID}Geschrieben von <A href="{$url_file}page=member.info&member_id={$news->member_id}"><b>{$news->member_nick_name|strip_tags|stripslashes}</b>,{/if}</a>
	 	{$LNG_MODULE.c1001} {date timestamp=$news->created format="%d.%m.%y %H:%M"}</b></font>	
	 </div>

	<div>{include file="devs/hr2.tpl" width="100%"}</div>

 	<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top">
		<table border="0" class="default_table" width="98%" cellpadding="0" cellspacing="0">
		 <tr>
		 	<td>{include file="etc/comment.show.tpl" comments=$comments}</td>
		 </tr>
			 <tr><td><br/><br/></td></tr>
		 <tr>
		 	<td>{include file="etc/comment.write.tpl" comments=$comments}</td>
		 </tr>
		</table>
	</td></tr>
	</table>

</td>
<td valign="top" width="250">

 	<table width="100%" height="360" border="0" cellpadding="0" cellspacing="0" background="images/eglbeta/content/design/{$GLOBAL_COLOR}/bg_right.gif" style="background-repeat:no-repeat;">
 	 <tr><td valign="top">
 		<table border="0" width="260" cellpadding="10"><tr><td>
 		
 		<b>{$LNG_MODULE.c1004}</b><br/>
 		<br/>
 		<table width="100%">
 		{section name=sn loop=$sectionnews}
 			<tr><td>
 				<table cellpadding="2" cellspacing="0">
 				 <tr>
 					<td><A class="news_href" href="{$url_file}page={$url_page}&news_id={$sectionnews[sn]->id}"><h2>{$sectionnews[sn]->title|strip_tags|stripslashes}</h2></a></td>
 				 </tr>
 				 <tr>
 					<td>{$sectionnews[sn]->short_text|strip_tags|stripslashes}</td>
 				 </tr>
 				 <tr>
 				 	<td><A href="{$url_file}page={$url_page}&news_id={$sectionnews[sn]->id}"><b>{$LNG_MODULE.c1002}</b></a></a>
 				 </tr>
 				</table>
 			</tr></td>
 			{if !$smarty.section.sn.last}<tr><td>{include file="devs/hr2.tpl" width="100%"}</tr></td>{/if}
 		{/section}
 		</table>
 		
		</td></tr>
		</table>
	</td></tr>
	</table>


</td></tr>
</table>