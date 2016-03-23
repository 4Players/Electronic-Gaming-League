<a name="comment_show">
{if $comments}
	<table border="0" cellpadding="2" cellspacing="1" width="100%">
	{section name=comment loop=$comments}
		<tr>
			<td align="top">
				<table border="0" cellpadding="2" width="100%">
				 <tr><td>
					{if $comments[comment]->logo_file != 'non'}
						<img align="left" src="{$path_logos}members/{$comments[comment]->logo_file}" width="50" height="50"/>
					{/if}
					<A href="{$url_file}page=member.info&member_id={$comments[comment]->author_id}"><b>{$comments[comment]->nick_name|strip_tags|stripslashes}</b></a><br/>
					{$comments[comment]->text|strip_tags|stripslashes|nl2br}
				 	</tr></td>
				 	<tr><td><font color="#7A7A7A" style="font-size:10px;">
				 		{lng_parser content=$LNG_BASIC.c4201 time=$comments[comment]->created}
				 	</font></td><//tr>
				 </table>
			</td>
		</tr>
		{if !$smarty.section.comment.last}<tr><td colspan="2">{include file="devs/hr2.tpl" width="100%"}</td></tr>{/if}
	{/section}
	</table>
	{if sizeof($comments) == 0}{$LNG_BASIC.c4200}{/if}
{/if}
</a>