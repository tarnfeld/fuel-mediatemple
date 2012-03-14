<?php

/**
 * PHP Class for working with the (mt) Media Temple ProDev API
 *
 * @package (mt) Media Temple ProDev API Package for FuelPHP
 * @see http://github.com/tarnfeld/fuel-mediatemple
 * @author Tom Arnfeld <tarnfeld@me.com>
 */

namespace MediaTemple;

class ProDev
{

	/**
	 * API Version
	 *
	 * @var ProDev::VERSION
	 */
	const VERSION = '1';
	
	/**
	 * API Endpoint
	 *
	 * @var ProDev::ENDPOINT
	 */
	const ENDPOINT = 'https://api.mediatemple.net/api';

	/**
	 * API Key
	 *
	 * @var $apikey
	 * @access protected
	 */
	protected static $apikey = false;
	
	/**
	 * Method to set the ProDev APIKey to be used throughout all ProDev API Connections
	 *
	 * @param string $apikey 
	 * @return void
	 * @access public
	 * @static
	 */
	public static function setApikey($apikey)
	{
		self::$apikey = $apikey;
	}
	
	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		if (!self::$apikey)
		{
			\Config::load('prodev', 'prodev');
			if (!$api_key = \Config::get('prodev.apikey'))
			{
				throw new ProDev_Exception('No API key set in config');
			}
			
			self::$apikey = $api_key;
		}
	}
	
	/**
	 * Add a service to the authenticated account
	 *
	 * @param ProDev_ServiceType $service 
	 * @param ProDev_OperatingSystem $os 
	 * @param string $primary_domain 
	 * @return bool
	 */
	public function addService(ProDev_ServiceType $service, ProDev_OperatingSystem $os, $primary_domain = false)
	{
		$params = array(
			'serviceType' => $service->id,
			'operatingSystem' => $os->id
		);
		
		if ($primary_domain)
		{
			$params['primaryDomain'] = $primary_domain;
		}
		
		return $this->_postRequest('service', $params);
	}
	
	/**
	 * Make a GET request to the API
	 *
	 * @param string $path API Path (eg services/{serviceId}/firewall/flush)
	 * @return array $response
	 */
	public function _getRequest($path)
	{
		$r = $this->_curlRequest('GET', $this->api_url() . '/' . $path);
		
		return $r['body'];
	}
	
	/**
	 * Make a POST request to the API
	 *
	 * @param string $path API Path (eg services/{serviceId}/firewall/flush)
	 * @param array $body
	 * @return array $response
	 */
	public function _postRequest($path, $body = array())
	{
		$response = $this->_curlRequest('POST', $this->api_url() . '/' . $path, $body);
		
		return $this->_parseStandardResponse($response['body'], $response['status']);
	}
	
	/**
	 * Make a PUT request to the API
	 *
	 * @param string $path API Path (eg services/{serviceId}/firewall/flush)
	 * @param array $body
	 * @return array $response
	 */
	public function _putRequest($path, array $body)
	{
		$response = $this->_curlRequest('PUT', $this->api_url() . '/' . $path, $body);
		
		return $this->_parseStandardResponse($response['body'], $response['status']);
	}
	
	/**
	 * Parse the response for a standard API call
	 * - Only POST and PUT requests use this as they return standardised responses
	 *
	 * @param string $response 
	 * @return bool
	 * @throws ProDev_Exception
	 * @access protected
	 */
	protected function _parseStandardResponse($response, $response_status)
	{
		$response = (array) $response;
		
		if (!$response || !isset($response['response']))
		{
			throw new ProDev_Exception('Malformed response JSON');
			return false;
		}
		
		$response = $response['response'];
		
		if ((int) $response->statusCode != $response_status)
		{
			throw new ProDev_Exception("API Status Code ({$response->statusCode}) did not match HTTP Status Code ({$response_status})");
			return false;
		}
		
		if ((int) $response->statusCode != 200 && (int) $response->statusCode != 202)
		{
			$json = json_encode($response->errors);
			throw new ProDev_Exception("Non 200 API Status ({$response->statusCode}) Errors JSON: {$json}");
			return false;
		}
		
		return true;
	}
	
	protected function _curlRequest($type, $url, $body = array())
	{
		if (!function_exists('curl_init'))
		{
			throw new ProDev_Exception('Could not find cURL functions');
		}
		
		$headers = array(
			'Content-type: application/json',
			'Authorization: MediaTemple ' . self::$apikey,
			'Accept: application/json',
		);
		
		// Create a curl handle
		$ch = curl_init();
		
		// Set options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($type));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		// If its a POST or PUT set the body
		if (count($body) > 0 && in_array($type, array('POST', 'PUT')))
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
		}
		
		$response = curl_exec($ch);
		
		if ($error = curl_error($ch))
		{
			throw new ProDev_Exception('cURL Error: ' . $error);
		}
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if ($status_code != 200 && $status_code != 202)
		{
			throw new ProDev_Exception('Non 200 API Status ' . $status_code);
		}
		
		if (!$json = json_decode($response))
		{
			throw new ProDev_Exception('Malformed response data');
		}
		
		return array(
			'status' => $status_code,
			'body' => $json
		);
	}
	
	/**
	 * Method to generate the API url (with the version)
	 *
	 * @return string $url
	 */
	protected function api_url()
	{
		return self::ENDPOINT . '/v' . self::VERSION;
	}
}
