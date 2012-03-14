<?php

/**
 * Addon Class
 * @see ProDev_Service::addons()
 *
 * @package (mt) Media Temple ProDev API Package for FuelPHP
 * @see http://github.com/tarnfeld/fuel-mediatemple
 * @author Tom Arnfeld <tarnfeld@me.com>
 */

namespace MediaTemple;

class ProDev_Addon extends ProDev_Object
{
	
	/**
	 * Make constructor private
	 * 
	 * @access private
	 */
	private function __construct() { }
	
	/**
	 * Method to create an addon from an Id and Description
	 *
	 * @param int $id 
	 * @param string $description 
	 * @return ProDev_Addon
	 * @static
	 */
	public static function factory($id, $description)
	{
		$instance = new self();
		$instance->id = $id;
		$instance->description = $description;
		
		return $instance;
	}
}
