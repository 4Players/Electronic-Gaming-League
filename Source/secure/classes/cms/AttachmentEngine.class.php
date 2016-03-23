<?php
# ================================ Copyright © 2004-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ] -



# -[ objectlist ] -


# -[ class ] -
class AttachmentEngine
{
	var $oVars	= NULL;

	/**
	 * Constructor
	 *
	 * @return AttachmentEngine
	 */
    function AttachmentEngine( &$gl_vars )
    {
    	$this->oVars = &$gl_vars;
	}
	
	/**
	 * AttachmentEngine::GenerateModuleAttachment
	 *
	 */
	function GenerateModuleAttachment( $workspace, $url_page )
	{
		$sAttachedContent = '';
		$aModules = $this->oVars->cModuleManager->GetActivatedModules();
		$aAttachmentList = array();
		
	
		// read attachments
		for( $i=0; $i < sizeof($aModules); $i++ )
		{
			# send attachmessage
			$aAttachment = module_sendmessage( $aModules[$i]->ID, 'template_attachment', $__DATA__, $workspace, $url_page  );
			$attachment_root = MODULE_DIR.$aModules[$i]->sModulePath.EGL_DIRSEP.'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP.'attachments'.EGL_DIRSEP;
			
			if( is_array($aAttachment) && file_exists($attachment_root.$aAttachment['template_file']))
			{
				$aAttachment['template_file'] 	= $attachment_root.$aAttachment['template_file'];
				$aAttachment['module_id']		= $aModules[$i]->ID;
				$aAttachmentList[sizeof($aAttachmentList)] = $aAttachment;
				
				/*
				# assign attachement id's
				$this->oVars->cTpl->assign( "ATTACHED_MODULE_ID", $aModules[$i]->ID );
				$sAttachedContent.=$this->oVars->cTpl->fetch( $attachment_root.$aAttachment['template_file'] );*/
			}//if
		}//for
		
		function sort_priority($a, $b) {   
			if ($a['priority'] == $b['priority']) return 0;
			return ($a['priority'] > $b['priority']) ? -1 : 1;
		}		
		// sort attachments based on priority
		usort  ( $aAttachmentList, 'sort_priority' );
		
		
		// für die attached templates setzten:
		// basis sprach daten
		$this->oVars->cTpl->assign( 'LNG_BASIC', $this->oVars->aLngBuffer['basic'] );
		
		// create attachment content
		for( $i=0; $i < sizeof($aAttachmentList); $i++ )
		{
			# assign attachement id's
			$this->oVars->cTpl->assign( 'ATTACHED_MODULE_ID', $aAttachmentList[$i]['module_id'] );
			
			$module_language_file 	= $this->oVars->cModuleManager->GetModuleRoot($aAttachmentList [$i]['module_id']).'workspaces'.EGL_DIRSEP.$workspace.EGL_DIRSEP.'languages'.EGL_DIRSEP;
			$module_language_buffer = array();
			/*
			Anmerkung:
			Hier werden für die attached templates die language-files in smarty geladen
			(1) es könnte sein, dass ein modul (mit sprachdaten) gealden wurde
				=> diese daten müssen zwischengespeichert werden und später (am ende der funktion) wieder zurückgesetzt werden.
				
				NEU: 
			
			*/
			
			# speicher ältere version von LNG_MODULE
			//if( isset($this->oVars->cTpl->_tpl_vars['LNG_MODULE']) )
			
			// daten löschen
			$this->oVars->cTpl->clear_assign('LNG_MODULE');
			 
			# dynamic: loading language file  [for module]
			if( $this->oVars->cLanguage->ParseFile( $module_language_file, $module_language_buffer ) )
				$this->oVars->cTpl->assign('LNG_MODULE',$module_language_buffer);
			
			// now parse template/attachment
			$sAttachedContent.=$this->oVars->cTpl->fetch( $aAttachmentList[$i]['template_file'] );
			
		}//for

		$this->oVars->cTpl->clear_assign('LNG_MODULE');
		$this->oVars->cTpl->clear_assign('LNG_BASIC');
			
		// reguläre language daten zurück(neu) setzten (regulär), da zuvor überschrieben wurde
		//$this->oVars->cTpl->assign('LNG_MODULE', $this->oVars->aLngBuffer['module'] );
		// muss nicht gesetzt werden, da das sowieso erst später passiert
		return $sAttachedContent;
	}
};
?>