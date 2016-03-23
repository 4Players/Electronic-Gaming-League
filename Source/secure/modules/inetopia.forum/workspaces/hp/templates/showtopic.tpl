{if isset($forum)}<a href="{$url_file}page={$CURRENT_MODULE_ID}:forums&forum_id={$forum->id}"><h2>{$forum->name}</a></h2>
	<table>
	<tr>
		<td> > <a href="{$url_file}page={$CURRENT_MODULE_ID}:forums">Forumübersicht</a></td>
	</tr>
	{section name=fpath loop=$forum_path}
	{*if !$smarty.section.fpath.first}>{/if*}
	<tr>
	 <td>{section name=s loop=$smarty.section.fpath.index+1}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{/section} > <a href="{$url_file}page={$CURRENT_MODULE_ID}:forums&forum_id={$forum_path[fpath]->id}">{$forum_path[fpath]->name}</b></a>
	</tr>
	{/section}
	</table>
	<br/>
{/if}


{literal}
<style type="text/css">
	hr.post_hr	{ height: 0px; border: solid #C0C0C0 0px; border-top-width: 1px;}
</style>
{/literal}

<table width="100%"><tr>
	<td><h2>{$topic->title|strip_tags|stripslashes}</h2></td>
	<td width="50%" align="right">{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Antwort" link="`$url_file`page=`$CURRENT_MODULE_ID`:newpost&topic_id=`$topic->id`"}</td>
</tr></table>
<table width="100%" cellpadding="5" cellspacing="1">
	<tr bgcolor="{#clr_content#}">
		<td><b>Autor</b></td>
		<td><b>Nachricht</b></td>
	</tr>
	 <tr bgcolor="{#clr_content_border#}"><td colspan="2"><img width="1" alt="" height="1"/></td></tr> 
	{section name=p loop=$topic_posts}
	{if $smarty.section.p.index % 2 != 0}
		<tr bgcolor="{#clr_content#}">
	{else}
		<tr>
	{/if}
		<td valign="top" width="150">
		{if $topic_posts[p]->member_id > 0}
			<b>{$topic_posts[p]->nick_name|strip_tags|stripslashes}</b><br/>
			Registriert seit {date timestamp=$topic_posts[p]->member_created format="%d.%m.%y"}
		{else}
			<b>{$topic_posts[p]->username|strip_tags|stripslashes}</b><br/>
			Unregistriert
		{/if}
		</td>
		<td>
			<table width="100%">
				<tr><td><font style="font-size:10px;">Verfasst am:{date timestamp=$topic_posts[p]->created} Titel:{$topic_posts[p]->title}</font></td></tr>
				<tr><td><hr class="post_hr"/></td></tr>
				<tr><td><font style="line-height: 1.8;">{$topic_posts[p]->text|stripslashes|htmlentities|nl2br|smilies}</font></td></tr>
			</table>
		</td>
	</tr>
	{if $smarty.section.p.index % 2 != 0}
		<tr bgcolor="{#clr_content#}">
	{else}
		<tr>
	{/if}
		<td></td>
		<td>	<table><tr>
				{if $topic_posts[p]->member_id > 0}
				<td><a href="{$url_file}page=member.info&member_id={$topic_posts[p]->member_id}"/><font style="font-size:11px;"><b>PROFIL</b></font></a></td>
				<td>|</td>
				<td><a href="{$url_file}page=pm.write&member_id={$topic_posts[p]->member_id}"/><font style="font-size:11px;"><b>PM</b></font></a></td>
				<td>|</td>
				<td><a href="{$url_file}page=email_send&member_id={$topic_posts[p]->member_id}"/><font style="font-size:11px;"><b>E-MAIL</b></font></a></td>
				<td>|</td>
				{/if}
				<td><a href="{$url_file}page={$CURRENT_MODULE_ID}:editpost&post_id={$topic_posts[p]->id}"/><font style="font-size:11px;"><b>EDIT</b></font></a></td>
				</tr></table>
		</td>
	<tr>
	<!--# <tr><td colspan="2"><hr style="border:dashed {#clr_content_border#} 1px; "></td></tr>#-->
	{/section}
	 <tr bgcolor="{#clr_content_border#}"><td colspan="2"><img width="1" alt="" height="1"/></td></tr> 
</table>
<div align="right" style="padding:2px;">
	{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Antwort" link="`$url_file`page=`$CURRENT_MODULE_ID`:newpost&topic_id=`$topic->id`"}
</div>
