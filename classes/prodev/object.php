<?php

/**
 * Abstract class to allow make getting/setting and json-ing the ProDev objects easier
 *
 * @package (mt) Media Temple ProDev API Package for FuelPHP
 * @see http://github.com/tarnfeld/fuel-mediatemple
 * @author Tom Arnfeld <tarnfeld@me.com>
 */

namespace MediaTemple;

abstract class ProDev_Object
{
	/**
	 * Data for this object (used by __get and __set)
	 * 
	 * @access protected
	 */
	protected $_data = array();
	
	/**
	 * Construct the class with an array of data
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->_data = $data;
	}
	
	/**
	 * Magic method called by $obj->{$attr} = {$value};
	 *
	 * @param string $attr
	 * @param string $value
	 */
	public function __set($attr, $value)
	{
		$this->_data[$attr] = $value;
	}
	
	/**
	 * Magic method called by $obj->{$attr}
	 *
	 * @param string $attr 
	 * @return mixed $value
	 */
	public function __get($attr)
	{
		if (isset($this->_data[$attr]))
		{
			return $this->_data[$attr];
		}
		
		return false;
	}
	
	/**
	 * Magic method called when this object is cast to an array
	 *
	 * @return array $data
	 */
	public function __toArray()
	{
		return (array) $this->_data;
	}
	
	/**
	 * Magic method called when this object is cast to string (so lets turn it into JSON)
	 *
	 * @return string $json
	 */
	public function __toString()
	{
		return json_encode($this->_data);
	}
}
