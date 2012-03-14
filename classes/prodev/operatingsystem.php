<?php

/**
 * OperatingSystem Class
 *
 * @package (mt) Media Temple ProDev API Package for FuelPHP
 * @see http://github.com/tarnfeld/fuel-mediatemple
 * @author Tom Arnfeld <tarnfeld@me.com>
 */

namespace MediaTemple;

class ProDev_OperatingSystem extends ProDev_Object
{

	/**
	 * Make constructor private
	 * 
	 * @access private
	 */
	private function function __construct(array $data)
	{
		$this->_data = $data;
	}
	
	/**
	 * Create a ProDev_OperatingSystem from its Id
	 *
	 * @param int $id 
	 * @return ProDev_OperatingSystem
	 */
	public static function factory($id)
	{
		$instance = new self();
		$instance->id = $id;
		
		return $instance;
	}
	
	/**
	 * Method to list all available operating systems
	 *
	 * @return array $types
	 */
	public static function list()
	{
		$api = new ProDev();
		
		$response = $api->getRequest('services/type/os');
		
		$types = array();
		foreach ($response->osTypes as $os)
		{
			$types[] = new self($os);
		}
		
		return $types;
	}
}
