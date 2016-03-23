{include file="tb/page.open.tpl"}

<h2>Administratoren</h2>

<table border="0" cellpadding="1">
 <tr>
 	<td align="center"><A title="Adminstrator hinzufügen" href="{$url_file}page=cms.admin.new"><img border="0" src="images/admin/administrator.gif"/></td>
 </tr>
 <tr>
 	<td align="center"><b>Administrator hinzufügen</b></td>
 </tr>
</table>
 

<hr size="1"/>


<div align="right">
	<A href="javascript: window.location.reload()"><img border=0 src="images/buttons/new/bt_refresh.gif"></a>
</div>

{literal}
<script language="javascript"> 
	function load_bgcolor(obj, color ) { obj.style.backgroundColor 	= color;}
</script>
{/literal}

<table border=0 cellpadding=0 cellspacing=2 bgcolor="#C5C5C5" width="100%">
 <tr><td>
	<table border="0" width="100%" bgcolor="{#clr_content#}" cellpadding=5 cellspacing=1 align="center">
	 <tr bgcolor="#E8E5DE">
	 	<td width="1%"><b>M</b></td>
	 	<td width="1%"><b>ID</b></td>
	 	<td width="1%"><b>Mitglied-ID</b></td>
	 	<td><b>Nick-Name</b></td>
	 	<td><b>E-Mail</b></td>
	 	<td><B>Option</b></td>
	 	<td><B>Anz. Rechte</b></td>
	 	<td><b>Registriert am.</b></td>
	 	<td></td>
	  </tr>
	 {section name=admin loop=$adminlist}
	  <tr onmouseover="javascript:load_bgcolor(this, '#F9F9F9');" onmouseout="javascript:load_bgcolor(this, '{#clr_content#}');">
	  {if $adminlist[admin]->master_permissions=='master'}<td><img src="images/admin/master_admin_small.gif"/></td>{/if}
	  {if $adminlist[admin]->master_permissions!='master'}<td><img src="images/admin/master_admin_no_small.gif"/></td>{/if}
		<td>{$adminlist[admin]->id}</td>  
		<td align="center">{$adminlist[admin]->member_id}</td>  
		<td><A title="Mitglied Zentrale" href="{$url_file}page=cms.member.central&member_id={$adminlist[admin]->member_id}">{$adminlist[admin]->nick_name}</a></td>  
		<td><A title="E-Mail schicken" href="mailto:{$adminlist[admin]->email}">{$adminlist[admin]->email}</td>  
		<td>
		  	<!--#<A title="Admin Profile anzeigen/bearbeiten" href="{$url_file}page=cms.admin.profile&member_id={$adminlist[admin]->id}"><b>Profil</b></a> &nbsp;·&nbsp; #-->
		  	<A title="Admin Profile anzeigen/bearbeiten" href="{$url_file}page=cms.admin.central&admin_id={$adminlist[admin]->id}"><b>Zentrum</b></a>

		</td>
		<td>{$adminlist[admin]->num_permissions}</td>  
		<td>{date timestamp=$adminlist[admin]->created}</td>  
		<td align="center"><A title="Admin löschen?" href="{$url_file}page=cms.admin.admin&admin_id={$adminlist[admin]->id}&a=delete_admin"><img border=0 src="images/buttons/bt_cancel.gif"/></a></a>
	  </tr>
	 {/section}
	 </table>
	 
 </td></tr>
</table>	


{include file="tb/page.close.tpl"}