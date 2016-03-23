{if isset($forum)}<h2>{$forum->name|strip_tags|stripslashes}</h2>
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

{if sizeof($forums) > 0}
	<table cellpadding="5" cellspacing="1" width="100%">
	 <tr>
		<td colspan="2"><b>FORUM</b></td>
		<td align="center"><b>THEMEN</b></td>
		<td align="center"><b>BEITRÄGE</b></td>
		<td align="center" width="200"><b>LETZTER BEITRAG</b></td>
	 </tr>
	 {if NOT ($forums[0]->section_id > 0)}
	 <tr>
	 	<td colspan="5"><hr style="border: 2px solid {#clr_content_border#};"/></td>
	 </tr>
	 {/if}	 
	 {section name=f loop=$forums}
	 {assign var="last_forum_index" value=$smarty.section.f.index-1}
	 {if $forums[f]->section_id > 0 &&  $forums[f]->section_id != $forums[$last_forum_index]->section_id  }
	 <tr bgcolor="{#clr_content#}">
	 	<td colspan="5"><b>{$forums[f]->section_name|strip_tags|stripslashes}</b></td>
	 </tr>
	 {/if}
	 <tr>
	 	<td width="20"><img src="images/modules/inetopia_forum/forum.gif"/></td>
	 	<td><a href="{$url_file}page={$CURRENT_MODULE_ID}:forums&forum_id={$forums[f]->id}"><b>{$forums[f]->name|strip_tags|stripslashes}</b></a><br/>{$forums[f]->description}</td>
	 	<td align="center">{$forums[f]->topics|tointeger}</td>
	 	<td align="center">{$forums[f]->posts|tointeger}</td>
	 	<td align="center">
	 	
	 	{if $forums[f]->lasttopic_created}
		 	{if $forums[f]->lasttopic_memberid > 0}
			 	{date timestamp=$forums[f]->lasttopic_created}<br/>
			 	<a href="{$url_file}page={$CURRENT_MODULE_ID}:showtopic&topic_id={$forums[f]->last_topic_id}">{cutstr num=30 text=$forums[f]->lasttopic_title|strip_tags|stripslashes}</a>
			 	(<a href="{$url_file}page=member.info&member_id={$forums[f]->lasttopic_memberid}">{$forums[f]->lasttopic_nickname|strip_tags|stripslashes}</a>)
			{else}
				<a href="{$url_file}page={$CURRENT_MODULE_ID}:showtopic&topic_id={$forums[f]->last_topic_id}">{cutstr num=30 text=$forums[f]->lasttopic_title|strip_tags|stripslashes}</a>
				({$forums[f]->lasttopic_username|strip_tags|stripslashes})
		 	{/if}
		{else}
				--------
		{/if}
	 	</td>
	 </tr>
	 {/section}
	</table>

	<br/><br/>
{/if}

{if !$TOPICS_DISABLED}
<div align="left" style="padding:2px;">
	{include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption="Neues Thema" link="`$url_file`page=`$CURRENT_MODULE_ID`:newtopic&forum_id=`$smarty.get.forum_id`"}
</div>
<table cellpadding="5" cellspacing="1" width="100%">
	 <tr bgcolor="{#clr_content_rel_border#}">
		<td colspan="2"><b>THEMEN</b></td>
		<td align="center" width="20"><b>ANTWORTEN</b></td>
		<td align="center"width="70"><b>AUTOR</b></td>
		<!--#<td align="center" width="20"><b>AUFRUFE</b></td>#-->
		<td align="center" width="150"><b>LETZTER BEITRAG</b></td>
	 </tr>
	 
 {section name=t loop=$topics}
 <tr bgcolor="{#clr_content#}">
 
	{if $topics[t]->locked}
		<td width="10"><img src="images/modules/inetopia_forum/locked_topic.gif"/></td>
	{else}
 		{if $topics[t]->type == $smarty.const.EGL_TOPICTYPE_NOTICE}
			<td width="10"><img src="images/modules/inetopia_forum/notice.gif"/></td>
 		{elseif $topics[t]->type == $smarty.const.EGL_TOPICTYPE_IMPORTANT}
			<td width="10"><img src="images/modules/inetopia_forum/important.gif"/></td>
 		{else}
 			{if $topics[t]->posts > 5}
				<td width="10"><img src="images/modules/inetopia_forum/hot_topic.gif"/></td>
 			{else}
				<td width="10"><img src="images/modules/inetopia_forum/topic.gif"/></td>
 			{/if}
 		{/if}
	{/if}
	
	{if $topics[t]->link} 
	 	<td><b>Verschoben:</b>&nbsp;<a href="{$url_file}page={$CURRENT_MODULE_ID}:showtopic&topic_id={$topics[t]->linked_topicid}">{$topics[t]->title|strip_tags|stripslashes}</a></td>
 	{else}
 		{if $topics[t]->type == $smarty.const.EGL_TOPICTYPE_NOTICE}
		 	<td><b>Ankündigung:</b>&nbsp;<a href="{$url_file}page={$CURRENT_MODULE_ID}:showtopic&topic_id={$topics[t]->id}">{$topics[t]->title|strip_tags|stripslashes}</a></td>
 		{elseif $topics[t]->type == $smarty.const.EGL_TOPICTYPE_IMPORTANT}
		 	<td><b>Wichtig:</b>&nbsp;<a href="{$url_file}page={$CURRENT_MODULE_ID}:showtopic&topic_id={$topics[t]->id}">{$topics[t]->title|strip_tags|stripslashes}</a></td>
 		{else}
		 	<td><a href="{$url_file}page={$CURRENT_MODULE_ID}:showtopic&topic_id={$topics[t]->id}">{$topics[t]->title|strip_tags|stripslashes}</a></td>
 		{/if}
 	{/if}
 		
 	<td align="center">{$topics[t]->posts}</td>
 	<td align="center">
 	{if $topics[t]->member_id > 0}
 		<a href="{$url_file}page=member.info&member_id={$topics[t]->member_id}">{$topics[t]->nick_name|strip_tags|stripslashes}</a>
 	{else}
 		{$topics[t]->username|strip_tags|stripslashes}
 	{/if}
 	</td>
 	<!--#<td align="center">{$topics[t]->hits}</td>#-->
 	<td align="center">
	 	{date timestamp=$topics[t]->lastpost_created}<br/>
	 	{if $topics[t]->lastpost_memberid > 0}
		 	<a href="{$url_file}page=member.info&member_id={$topics[t]->lastpost_memberid}">{$topics[t]->lastpost_nickname|strip_tags|stripslashes}</a>
		{else}
			{$topics[t]->lastpost_username|strip_tags|stripslashes}
		{/if}
		{if $topics[t]->link}
		 	<a href="{$url_file}page={$CURRENT_MODULE_ID}:showtopic&topic_id={$topics[t]->linked_topicid}#lastpost"><img border="0" src="images/icon_latest_reply.gif"/></a>
		{else}
		 	<a href="{$url_file}page={$CURRENT_MODULE_ID}:showtopic&topic_id={$topics[t]->id}#lastpost"><img border="0" src="images/icon_latest_reply.gif"/></a>
		{/if}
 	</td>
 </tr>
 {/section}
</table>
{/if}

{if $forum}
	<br/><br/>
	<fieldset style="border: 2px solid {#clr_content_border#};">
		<legend>
			<label for="checkbox_htmlword_data">&nbsp;<b>DETAILS</b>&nbsp;</label>
	
		</legend>
		<table cellpadding="5">
		 <tr>
		 	<td>Moderatoren:</td>
		 	<td></td>
		 </tr>
		 </table>
	</fieldset>
{/if}
