<?php 


class Customweb_Soap_Util_Factory{
	
	/**
	 * 
	 * @param string $targetLocation	The location to where the messages will be send to
	 * @param array  $options			An array of configuration values
	 * @param string $soapNs			The namespace of the soap envelope, depending on the version in use
	 * @return Customweb_Soap_Client
	 */
	public static function getSoapClient($targetLocation, $options = array(), $soapNs = null){
		return new Customweb_Soap_Client($targetLocation, $options, $soapNs);
	}
	
}