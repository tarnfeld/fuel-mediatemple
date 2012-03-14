<?php

/**
 * ServiceType Class
 *
 * @package (mt) Media Temple ProDev API Package for FuelPHP
 * @see http://github.com/tarnfeld/fuel-mediatemple
 * @author Tom Arnfeld <tarnfeld@me.com>
 */

namespace MediaTemple;

class ProDev_ServiceType extends ProDev_Object
{

	/**
	 * Make the constructor private
	 *
	 * @param array $data
	 * @access private
	 */
	private function __construct(array $data)
	{
		$this->_data = $data;
	}
	
	/**
	 * Method to create a new ServiceType from its ID
	 *
	 * @param int $id 
	 * @return ProDev_ServiceType
	 * @static
	 */
	public static function factory($id)
	{
		$instance = new self();

		$instance->id = $id;
		
		return $instance;
	}
	
	/**
	 * Method to list all available service types
	 *
	 * @return array $types
	 * @static
	 */
	public static function list()
	{
		$api = new ProDev();
		
		$response = $api->getRequest('services/types');
		
		$services = array();
		foreach ($response->serviceTypes as $service)
		{
			$services[] = new self($service);
		}
		
		return $services;
	}
}
