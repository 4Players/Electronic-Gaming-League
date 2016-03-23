<?php
# ================================ Copyright � 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-



# -[ class ] -
class XMLReader 

{
	/**
	* xml parser resource
	* @var resource
	**/
	var $xml_parser		= NULL;
	
	
	/**
	* XML Handler object
	* @var resourc
	**/
	var $_handlerObj	= NULL;
	
	
	/**
	* xml input string/file
	* @var string
	**/
	var $xml_data		= '';
	
	
	/**
	* parsed data(array)
	* @var array/object
	**/
	var $parsed_data	= '';

		

	/*
	* XMLParser
	*/
	function XMLReader() 
	{
	}
	
	/**
	* init parser
	*/
	function InitParser()
	{
		$this->xml_parser = xml_parser_create();

		if( is_resource($this->xml_parser))
		{
			# set object for handler
			if( !is_resource( $this->_handlerObj ))
				$this->_handlerObj = &$this;

			xml_set_object($this->xml_parser, &$this->_handlerObj );

			# tey setting up handler
			xml_set_element_handler( $this->xml_parser, array(&$this->_handlerObj, 'start_element'), array(&$this->_handlerObj, 'close_Element') );
			xml_set_character_data_handler( $this->xml_parser, array( &$this->_handler, 'character_data') );	
		}else
		{
			# bug-report
		}
	}
	
    function SetHandlerObj(&$obj)
    {
        $this->_handlerObj = &$obj;
        return true;
    }
    
	/*
	* XMLParser::parse
	*/
   	function Parse() 
   	{
		if( $this->xml_data && is_resource($this->xml_parser) )
		{
			
			$result = xml_parse( $this->xml_parser, $this->xml_data );
			if (!$result) 
			{
				die( sprintf("XML error: %s at line %d",	xml_error_string(xml_get_error_code($this->xml_parser)),
															xml_get_current_line_number($this->xml_parser)));
	            return false;
			}
			return $this->parsed_data;
			
		}else return false;
   	}
   	
   	
	/**
	*
	*/
	function SetInputString( $str )
   	{
		$this->xml_data = $str;
		return true;
   	}
   	
   	
	/**
	*
	*/   	
   	function SetInputFile( $file )
   	{
   		$cFile = new File();
   		if( $cFile->Open( $file, 'r' ))
   		{
   			$this->xml_data = $cFile->Read();
			$cFile->Close();
			return true;
   		}
   		return false;
	}


	/**
	*
	*/
	function GetElement( $array, $node_name )
	{
		$num_items = sizeof($array);
		for( $item=0; $item < $num_items; $item++ )
		{
			if( $array[$item]['name'] == $node_name )
			{
				return  $array[$item];
			}
		}//for
		return NULL;
	}//getElement
	
	
	
	/**
	*
	*/
	function GetElementContent($array, $node_name)
	{
		$element = $this->GetElement( $array, $node_name );
		if( $element ) return $element['content'];
		return 'NOT_FOUND';
	}//getElementContent
		
	
	/**
	*
	*/
	function GetData(){ return $this->xml_data; }
	
	/**
	*
	*/	
	function FreeData()
	{
		if( is_resource($this->xml_parser))
		{
			xml_parser_free( $this->xml_parser );
			$this->xml_data = '';
			return true;
		}//if
		else return false;
	}
	
	
	#--------------------------------------------------------------------------------------------------------------
	#--------------------------------------------------------------------------------------------------------------
	#--------------------------------------------------------------------------------------------------------------
	

	/*
	* XMLParser::startHandler
	*/
	function startHandler($parser, $name, $attributes) 
	{
       $data['name'] = $name;
       if ($attributes) { $data['attributes'] = $attributes; }
       $this->data[] = $data;
	}//


	/*
	* XMLParser::dataHandler
	*/
	function dataHandler($parser, $data) 
	{
		if ($data = trim($data)) 
		{
			$index = count($this->data) - 1;
			// begin multi-line bug fix (use the .= operator)
			$this->data[$index]['content'] .= $data;
			// end multi-line bug fix
		}
	}//dataHandler

	/*
	* XMLParser::endHandler
	*/
   function endHandler($parser, $name) 
   {
   	
		if (count($this->data) > 1) 
		{
			$data = array_pop($this->data);
			$index = count($this->data) - 1;
			$this->data[$index]['child'][] = $data;
		}//if
	}//endHandler
			
};


?>