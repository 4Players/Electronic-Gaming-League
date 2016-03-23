<h2>{$LNG_BASIC.c10000} `{$member->nick_name|strip_tags|stripslashes}`</h2>
{include file="devs/message.tpl"}

<table border="0" cellpadding="5" cellspacing="5" width="100%">
 <tr>
 	<td valign="top" width="10%" align="center">
 	
 	
 		<table border="0" cellpadding="0" cellspacing="1" bgcolor="{#clr_content_border#}">
 		 <tr><td>
	 		{if $member->photo_file != 'non'}
		 		<a href='{$url_file}page=member.info&member_id={$member->id}'><img src="{$path_photos}{$member->photo_file}" width="100" height="133" border="0"></a>
		 	{else}
		 		<a href='{$url_file}page=member.info&member_id={$member->id}'><img src="images/photo.na.jpg" width="100" height="133" border="0"></a>
	 		{/if}
	 	 </td></tr>
	 	</table>
	 	

 	</td>
 	<td valign="top" width="30%">
 		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4352}</b></font> <br/>
 		
 		<a class="commandLink" href='{$url_file}page=member.profile'>{$LNG_BASIC.c4353}</a> <br/>
		<a href='{$url_file}page=member.photo_upload'>{$LNG_BASIC.c4354}</a> <br/>
		<a href='{$url_file}page=member.logo'>{$LNG_BASIC.c4355}</a> <br/>
		<a href='{$url_file}page=member.delete'>{$LNG_BASIC.c4356}</a> <br/>
		<a href='{$url_file}page=member.gameaccounts'>{$LNG_BASIC.c4357}</a> <br/>
		<a href='{$url_file}page=member.select_games'>{$LNG_BASIC.c4358}</a> <br/>
		
		<br/>
		
 		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4370}</b></font> <br/>
		<a href='{$url_file}page=clan.create'>{$LNG_BASIC.c4371}</a> <br/>
		<a href='{$url_file}page=clan.join'>{$LNG_BASIC.c4372}</a> <br/>
		<a href='{$url_file}page=clan.quit'>{$LNG_BASIC.c4373}</a> <br/>
		
		{if $clan_invites > 0} 
			<a href='{$url_file}page=member.invites'><b>{$LNG_BASIC.c4374}({$clan_invites})</b></a> <br/> 
		{else}
			<a href='{$url_file}page=member.invites'>{$LNG_BASIC.c4374} ({$clan_invites})</a> <br/> 
		{/if}
		
		<br/>
		
 		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4390}</b></font> <br/>
		<a href='{$url_file}page=team.create'>{$LNG_BASIC.c4391}</a> <br/>
		<a href='{$url_file}page=team.join'>{$LNG_BASIC.c4392}</a> <br/>
		<a href='{$url_file}page=team.quit'>{$LNG_BASIC.c4393}</a> <br/>
		
		
	</td>
 	<td valign="top" width="30%">
		
		
 		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4400}</b></font> <br/>
		<A href='{$url_file}page=pm.write'>{$LNG_BASIC.c4401}</a>  <br/>
		{if $pm_unread_count > 0} 
			<A href='{$url_file}page=pm.overview'>{$LNG_BASIC.c4402} ({$pm_unread_count})</a>  <br/>
		{else}	
			<font class='font_inactive'> <i>{$LNG_BASIC.c4402}</i> </font> <br/>
		{/if}
		<!--# <A href='{$url_file}page=pm.overview'>{$LNG_BASIC.c4403} </a> <br/> #-->
		<br/>

		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4410}</b></font><br/>
		<!--# COMMING SOON
		<a href='{$url_file}page=member.welcome'>{$LNG_BASIC.c4411}</a> <br/>	
		<a href='{$url_file}page=member.support'>{$LNG_BASIC.c4412}</a> <br/>	
		#-->
		<a href='{$url_file}page=member.protests'>{$LNG_BASIC.c4413}</a> <br/>	
		<a href='{$url_file}page=member.newprotest'>{$LNG_BASIC.c4414}</a> <br/>
		<br/>
		
 		<font color="{#clr_header#}" face="arial" size="2"><b>{$LNG_BASIC.c4420}</b></font><br/>
		<a href="{$url_file}page=member.language">{$LNG_BASIC.c4424}</a> <br/>	
		<!--# COMING SOON
		<a href="{$url_file}page=member.layout">{$LNG_BASIC.c4421}</a> <br/>	
		<a href="{$url_file}page=member.rankbutton">{$LNG_BASIC.c4422}</a> <br/>	
		<a href="{$url_file}page=member.dbinterface">{$LNG_BASIC.c4423}</a> <br/>	
		#-->
		
		
	</td>
	<td valign="top" width="30%">
	
	
	{section name=mod_l loop=$module_links }
		<font color="{#clr_header#}" face="arial" size="2"><b> {$module_links[mod_l]->sCaption} </b></font> <br/>
		{section name=link loop=$module_links[mod_l]->aLinks}
			<A href='{eval var=$module_links[mod_l]->aLinks[link]->sURL}'>{$module_links[mod_l]->aLinks[link]->sName}</a> <br/> 
		{/section}
		<br/>
	{/section}
		
	</td>
 </tr>
 <tr>
 	<td></td>
 	<td colspan="3"> {include file="devs/hr2.tpl" width="100%"} </td>
 </tr>
 <tr>
 	<td></td>
	<td colspan="3" align="right"> {include file="buttons/bt_universal.tpl" color=$GLOBAL_COLOR caption=$LNG_BASIC.c1032 link="`$url_file`page=logout"}</td>
 </tr>
</table>




