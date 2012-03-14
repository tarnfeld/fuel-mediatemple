<?php

/**
 * Package bootstrap
 *
 * @package (mt) Media Temple ProDev API Package for FuelPHP
 * @see http://github.com/tarnfeld/fuel-mediatemple
 * @author Tom Arnfeld <tarnfeld@me.com>
 */

Autoloader::add_classes(array(
	
	'MediaTemple\\ProDev'					=> __DIR__.'/classes/prodev.php',
	
	'MediaTemple\\ProDev_Addon'				=> __DIR__.'/classes/prodev/addon.php',
	'MediaTemple\\ProDev_Exception'			=> __DIR__.'/classes/prodev/exception.php',
	'MediaTemple\\ProDev_Object'			=> __DIR__.'/classes/prodev/object.php',
	'MediaTemple\\ProDev_OperatingSystem'	=> __DIR__.'/classes/prodev/operatingsystem.php',
	'MediaTemple\\ProDev_Service'			=> __DIR__.'/classes/prodev/service.php',
	'MediaTemple\\ProDev_ServiceType'		=> __DIR__.'/classes/prodev/servicetype.php',
	
));
