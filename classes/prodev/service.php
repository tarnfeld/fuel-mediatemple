<?php

/**
 * Service Class
 *
 * @package (mt) Media Temple ProDev API Package for FuelPHP
 * @see http://github.com/tarnfeld/fuel-mediatemple
 * @author Tom Arnfeld <tarnfeld@me.com>
 */

namespace MediaTemple;

class ProDev_Service extends ProDev_Object
{
	
	/**
	 * List all of services on the authenticated account
	 *
	 * @return array $services
	 * @static
	 */
	public static function listServices()
	{
		$api = new ProDev();
		
		$response = $api->_getRequest('services');
		
		$services = array();
		foreach($response->services as $service)
		{
			$services[] = new self((array) $service);
		}
		
		return $services;
	}
	
	/**
	 * List all of service IDs on the authenticated account
	 *
	 * @return array $service_ids
	 * @static
	 */
	public static function listIds()
	{
		$api = new ProDev();
		
		return $api->_getRequest('services/ids')->serviceIds;
	}
	
	public function friendlyName()
	{
		return '#' . $this->id . ' ' . $this->serviceTypeName . ' - ' . $this->primaryDomain;
	}
	
	/**
	 * Load in the full details about this service (from its Id)
	 * Useful when calling ProDev_Service::listIds() and you only have a ProDev_Service with an Id
	 *
	 * @return ProDev_Service ($this)
	 */
	public function load()
	{
		if (!isset($this->_data['id']))
		{
			throw new ProDev_Exception('No service id to load');
		}
		
		$api = new ProDev();
		$this->_data = (array) $api->_getRequest('services/' . $this->id);
		
		return $this;
	}
	
	/**
	 * Create an array of ProDev_Addon classes for this services addons
	 *
	 * @return array ProDev_Addon
	 */
	public function addons()
	{
		if (isset($this->_data['addons']) && is_array($this->_data['addons']))
		{
			$addons = array();
			foreach ($this->_data['addons'] as $addon)
			{
				$addons[] = ProDev_Addon::factory($addon);
			}
			return $addons;
		}
		
		return array();
	}

	/**
	 * Reboot this service
	 *
	 * @return bool
	 */
	public function reboot()
	{
		$api = new ProDev();
		
		return $api->_postRequest('services/' . $this->id . '/reboot');
	}

	/**
	 * Add temporary disk space to this service
	 *
	 * @return bool
	 */
	public function addTempDiskSpace()
	{
		$api = new ProDev();
		
		return $api->_postRequest('services/' . $this->id . '/disk/temp');
	}
	
	/**
	 * Flush the firewall for this service
	 *
	 * @return bool
	 */
	public function flushFirewall()
	{
		$api = new ProDev();
		
		return $api->_postRequest('services/' . $this->id . '/firewall/flush');
	}

	/**
	 * Set the Plesk password for this service
	 *
	 * @param string $password
	 * @return bool
	 */
	public function setPleskPassword($password)
	{
		$api = new ProDev();
		
		return $api->_putRequest('services/' . $this->id . '/pleskPassword', array( 'password' => $password ));
	}

	/**
	 * Set the root password for this service
	 *
	 * @param string $password
	 * @return bool
	 */
	public function setRootPassword($password)
	{
		$api = new ProDev();
		
		return $api->_putRequest('services/' . $this->id . '/rootPassword', array( 'password' => $password ));
	}

	/**
	 * Generate stats for this service
	 *
	 * @param string $start (The beginning of the range in epoch seconds)
	 * @param string $end (The end of the range in epoch seconds)
	 * @param string $resolution (The interval of data points in seconds to request. The closest actual data point collection interval will be returned, which may result in fewer or greater data points than expected. DEFAULT=15)
	 * @param string $precision (The numeric precision to use in returned data. Digits to the right of the decimal. DEFAULT=2)
	 * @return array $stats
	 * @author Tom Arnfeld
	 */
	public function stats($start = false, $end = false, $resolution = false, $precision = false)
	{
		$api = new ProDev();
		
		$response = (array) $api->_getRequest('stats/' . $this->id, array(
			'start' => $start,
			'end' => $end,
			'resolution' => $resolution,
			'precision' => $precision
		));
		
		if (isset($response['statsList']))
		{
			return $response['statsList']->stats;
		}
		
		return array($response['stats']);
	}
}
