<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================



# -[ defines ]-



# -[ objectlist ] -


# -[ class ] -
class Templates extends Smarty 
{
	# -[ variables ]-
	
	# -[ functions ]-
	
	
	# =========================================================================
	# PUBLIC
	# =========================================================================
	
	//-------------------------------------------------------------------------------
	// Purpose: constructor
	// Output :
	//-------------------------------------------------------------------------------
	function Init ()
	{
		$this->register_compiler_function('fun', 'smarty_compiler_fun');
		
		$this->register_compiler_function('defun', 'smarty_compiler_defun'); 
		$this->register_compiler_function('/defun', 'smarty_compiler_defun_close');

		$this->register_postfilter('smarty_postfilter_defun');
			
		# ----------------------------
		# register new tools / functions => SMARTY
		# ----------------------------
		$this->register_function(	"session", 			"print_session");
		
		$this->register_function( 	"split_str",		"print_split_str");	
		//$this->register_function(	"date", 			"print_date");
		$this->register_function(	"forwarding", 		"print_forwarding");
		$this->register_function(	"irc_con", 			"print_irc_con");
		$this->register_function(	"hp", 				"print_hp");
		$this->register_function(	"cutstr", 			"print_cut_str");
		$this->register_function(	"back_cutstr", 		"print_back_cut_s");
		$this->register_function(	"pow", 				"print_pow");
		//$this->register_function(	"url_params", 		"print_url_params");
		$this->register_function(	"int", 				"print_int");
		$this->register_function(	"filesize", 		"print_filesize");
		$this->register_function(	"age", 				"print_age");
		$this->register_function(	"file_extension", 	"print_file_extension");
		$this->register_function(	"benchtime", 		"print_benchtime");
		$this->register_function(	"random_string", 	"print_random_string");
		$this->register_function(	"percent", 			"print_percent");

		
		$this->register_function(	"weekday",			"print_weekday");	
		$this->register_function( 	"month",			"print_month");	
		$this->register_function( 	"texts",		 	"print_texts");	

		
		$this->register_function(	"match_status", 	"print_match_status");	


		# register / cmod tools for Smarty Engine
		$this->register_function(	"module_getid", 	"print_module_getid");	
		
		
		
		#----------------------------------------
		# MODIFIERS
		#----------------------------------------
		
		
		
		
		
		#----------------------------------------
		#pre Filters
		#----------------------------------------
		
		//$this->register_prefilter(  "remove_tabs");	
		//$gl_oVars->cTpl->register_prefilter(  "remove_double_breaks");	
		$this->register_prefilter(  "remove_dw_comments");	
	
		
		return 1;
	}// function Init()
	
	
	/**
	* parses & modifies a language string with var evaluation
	*
	* @param	string		language content 
	* @param	array		arraylist of params/variables
	* @return	TPL-Class	template-class
	**/
	function ParseContent( $content, &$cTPL, $params=array() )
	{
	    $cTPL->_compile_source( 'evaluated template', $content, $_var_compiled );
		
		// save language data
		$params['LNG_BASIC'] = $cTPL->_tpl_vars['LNG_BASIC'];
		$params['LNG_MODULE'] = $cTPL->_tpl_vars['LNG_MODULE'];
	
	    $tmp_tplvar_buffer = $cTPL->_tpl_vars;	# => save old tpl-var-smarty buffer
		$cTPL->_tpl_vars = $params ;	# => set overgiven template var-buffer as smarty intra var-buffer
	
				
	    ob_start();
	    $cTPL->_eval( '?>' . $_var_compiled );
	    $_contents = ob_get_contents();
	    ob_end_clean();
	    
	    $cTPL->_tpl_vars = $tmp_tplvar_buffer;	# => restore old tpl-var-smarty buffer
	
		return $_contents;
	}
	
	
};

?>