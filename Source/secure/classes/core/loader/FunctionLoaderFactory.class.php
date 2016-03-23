<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ] -



# -[ objectlist ] -
class funcinstance_caller_t
{
	var $filename		= "unknown";
	var $classname		= "unknown";
	var $func_name		= "unknonw";
	var $func_object	= NULL;
	
	function functionloader_interface_t(){}
	function call( $params=array() ){
		return call_user_method_array( $this->func_name, $this->func_object, $params );
	}
};


/*
SAMPLE:
FunctionLoaderFactory::LoadFunction( 'c:\\testfunction.php', 'testfunction' );*/

# -[ class ] -
class FunctionLoaderFactory
{

	/**
	* FunctionLoaderFactory::FunctionLoaderFactory()
	*
	*/    
    function FunctionLoaderFactory ()
    {
    }
    
    
	/**
	* FunctionLoaderFactory::LoadCodeFromFile()
	*
	* @param 	string 	$filename 
	* @return 	string	php sourcecode
	*/    
    function LoadCodeFromFile( $filename )    
    {
    	# declare function buffer
    	$buf_function_code = '';

    	if( file_exists($filename))
    	{
    		if( function_exists('ioncube_read_file') )
    		{
                $res = ioncube_read_file($filename);
                if (is_int($res)) $res = false;
                else $buf_function_code = $res;
       		}
    		else
    		{
		    	$cFile = new File();
		    	if( $cFile->Open( $filename, 'r'))
		    	{
		    		$buf_function_code = $cFile->Read();
		    		$cFile->Close();
		    	}//if
    		}//if
    	}//if
    	return $buf_function_code;
    }
    
    
	/**
	* FunctionLoaderFactory::ModifyCode()
	*
	* @param 	string 	$code php-code
	* @param 	string 	$classname - random header classname like md5() generates l
	* @return 	string	modified code
	*/    
    function ModifyCode( $code, $classname )
    {
    	$code = str_replace('<?php','',$code);
    	$code = str_replace('?>','',$code);
    	return 'class '.$classname.'{ '.$code. ' }; ';
    }
    
  
    
	/**
	* FunctionLoaderFactory::LoadFunctionInstance()
	*
	* @param 	string 	$filename
	* @param 	string 	$modified_code
	* @param 	string 	$classname
	* @param 	string 	$functioname
	* @return 	object	<funcinstance_caller_t>
	*/    

    function InterpretCode( $filename, $modified_code, $classname, $functioname )
    {
    	// execute code
    	eval( $modified_code );
    	
  		$caller = new funcinstance_caller_t();
   		$caller->filename = $filename;
   		$caller->classname = $classname;
   		$caller->func_name = $functioname;

   		# declare class
    	if( !declare_class( $caller->func_object, $classname ) )
    	{
    		return false;
    	}
    	else 
    	{
			return $caller; //return call_user_method_array( $functioname, $object, $params );
    	}//if
    }
    
    
	/**
	* FunctionLoaderFactory::LoadFunctionInstance()
	*
	* @param 	string 	callback-filename
	* @param 	string 	callback function-name, standard 'callback'
	* @return 	object	<funcinstance_caller_t>
	*/    
    function LoadFunctionInstance( $filename, $function_name )
    {
    	$TOP_LEVEL_CLASS_NAME = 'c'.md5( microtime().EGL_TIME );
    	# $TOP_LEVEL_CLASS_NAME = md5( microtime().CreateRandomPassword() ); slow but save !!
    	$modifiedCode = FunctionLoaderFactory::ModifyCode( FunctionLoaderFactory::LoadCodeFromFile( $filename ), $TOP_LEVEL_CLASS_NAME );
    	return FunctionLoaderFactory::InterpretCode( $filename, $modifiedCode, $TOP_LEVEL_CLASS_NAME, $function_name  );
    }
        
};

/*
//$gl_oVars = new global_vars_t;
$caller1 = FunctionLoaderFactory::LoadFunctionInstance( 'c:\\testfunction.php', 'testfunction' );
echo $caller1->call( array( $GLOBALS['gl_oVars'], 'test' ) );
exit;*/

?>