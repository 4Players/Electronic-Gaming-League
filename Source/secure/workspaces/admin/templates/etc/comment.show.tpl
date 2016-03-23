
<a name="comment_show">
{if $comments}
	<table border="0" cellpadding="2" cellspacing="1" width="100%" bgcolor="{#clr_content_border#}">
	{section name=comment loop=$comments}
		<tr bgcolor="{#clr_content#}">
			<td width="20%" valign="top">
				<table border="0" cellpadding="2" width="100%">
				 <tr><td>
					{if $comments[comment]->logo_file != 'non'}
						<img src="{$path_logos}members/{$comments[comment]->logo_file}" width="50" height="50">
					<br>
					{/if}
					<A href="{$url_file}page=member.info&member_id={$comments[comment]->author_id}"><b>{$comments[comment]->nick_name|stripslashes|strip_tags}</b></a>
			
					<br><br>
					{date timestamp=$comments[comment]->created format="%d.%m.%y <b>%H:%M </b>"}
				 	</tr></td>
				 </table>
			</td>
			<td valign="top">
				<table border="0" cellpadding="5" cellspacing="0" width="90%">
				 <tr><td>{$comments[comment]->text|stripslashes|strip_tags|nl2br} </td></tr>
				 {if $member->id == $comments[comment]->author_id}
				 	<tr><td align="right"><br> {#clip_start#}<A href='{$url_file}page=comments.edit&comment_id={$comments[comment]->id}'>edit</a>{#clip_end#} </td></tr>
				 {/if}
				</table>
			</td>
		</tr>
	{/section}
	</table>
{/if}
</a>

