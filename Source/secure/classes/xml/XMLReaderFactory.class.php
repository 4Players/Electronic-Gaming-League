<?php
# ================================ Copyright © 2005-2006 Inetopia, All rights reserved. ==========================
# 
#
# Purpose:
# ================================================================================================================


# -[ defines ]-


# -[ class ] -
class XMLReaderFactory
{
	
	/**
	* xml parser resource
	* @var resource
	**/
	var $xml_parser	= NULL;
	
	
	/**
	* XML Handler object
	* @var resourc
	**/
	var $handlerObj	= NULL;
	
	
	/**
	* xml input string/file
	* @var string
	**/
	var $xml_data = '';
	
	
	/**
	* parsed data(array)
	* @var array/object
	**/
	var $parsed_data = '';


	/*
	* XMLParser
	*/
	function XMLReaderFactory() 
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
							
			# set object for handler
			$this->_handlerObj = &$this;

			xml_set_object($this->xml_parser, &$this->_handlerObj);
			xml_set_element_handler($this->xml_parser, array( &$this->_handlerObj, 'startHandler'), array( &$this->_handlerObj, 'endHandler') );
			xml_set_character_data_handler($this->xml_parser, array( &$this->_handlerObj,'dataHandler'));		
			
			return  true;
		}
		else return  false;
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

	
	
	/*
	* XMLParser::parse
	*/
   	function Parse() 
   	{
   		$this->InitParser();
		
   		# xml data avialble?
   		if( $this->xml_data && is_resource($this->xml_parser ))
   		{
			$result = xml_parse($this->xml_parser, $this->xml_data );

			if (!$result) 
			{
				die(sprintf("XML error: %s at line %d",	xml_error_string(xml_get_error_code($this->xml_parser)),
														xml_get_current_line_number($this->xml_parser)));
														xml_parser_free($this->xml_parser
	                 									);
			}
			xml_parser_free( $this->xml_parser );
   		}
		return $this->parsed_data;
	}//


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
		if( $element ) return (string)$element['content'];
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
       $this->parsed_data[] = $data;
	}//


	/*
	* XMLParser::dataHandler
	*/
	function dataHandler($parser, $data) 
	{
		//if ($data = trim($data)) 
		//{
			$index = count($this->parsed_data) - 1;
			// begin multi-line bug fix (use the .= operator)
			$this->parsed_data[$index]['content'] .= $data;
			// end multi-line bug fix
		//}
	}//dataHandler

	/*
	* XMLParser::endHandler
	*/
   function endHandler($parser, $name) 
   {
   	
		if (count($this->parsed_data) > 1) 
		{
			$data = array_pop($this->parsed_data);
			$index = count($this->parsed_data) - 1;
			$this->parsed_data[$index]['child'][] = $data;
		}//if
	}//endHandler
	
};

?>