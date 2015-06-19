<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

/***********************************************
A Codeigniter library to encode data into the
JSON data format for PHP versions lower than 5.2

@current version 0.1
@license MIT
***********************************************/

class Json_encode {

	/***********************************************
	Method: encode_array()

	This method enocodes a 1D array of scalars and
	returns a JSON encoded string.

	@access public
	@param (array) $array
	@post void
	@return (string) The encoded array
	@author Nick Pyett
	@since 0.1
	***********************************************/
	function encode_array($array = array())
	{
		// RETURN NULL IF PASSED VAR IS NOT AN ARRAY
		if ( ! is_array($array) )
		{
			return NULL;
		}

		// DECLARE ARRAY TO IMPLODE AND RETURN
		$return_array = array();

		foreach($array as $key => $value)
		{
			$return_array[] = $this->_encode_scalar($key) . ':' . $this->_encode_scalar($value);
		}

		// IMPLODE ARRAY AND RETURN JSON
		return '{' . implode(',', $return_array) . '}';
	}


	/***********************************************
	Method: _encode_scalar()

	This method encodes a scalar. It will return
	NULL for another other data types passed to it.

	@access private
	@param (string/float/other scalar) $scalar
	@post void
	@return (string/float/other scalar) $scalar
	@author Nick Pyett
	@since 0.1
	***********************************************/
	function _encode_scalar($scalar = '')
	{
		if ( ! is_scalar($scalar) )	// NOT A SCALAR, NO DICE
		{
			return NULL;
		}
		elseif ( is_float($scalar) )
		{
			return floatval(str_replace(',', '.', strval($scalar))); // ALWAYS USE '.' FOR FLOATS
		}
		elseif ( is_string($scalar) )
		{
			static $json_replace_array = array(array('\\', '/', "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
			return '"' . str_replace($json_replace_array[0], $json_replace_array[1], $scalar) . '"';
		}
		else return $scalar;
	}

}

// END OF FILE ./APPLICAITON/LIBRARIES/JSON_ENCODE.PHP
