<?php
/**
 * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
*/

/**
 * @XmlType(name="IPGApiOrderRequest", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderRequest {
	/**
	 * @XmlElement(name="Transaction", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionElement", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionElement
	 */
	private $transaction;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderRequest
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderRequest();
		return $i;
	}
	/**
	 * Returns the value for the property transaction.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionElement
	 */
	public function getTransaction(){
		return $this->transaction;
	}
	
	/**
	 * Sets the value for the property transaction.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionElement $transaction
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderRequest
	 */
	public function setTransaction($transaction){
		if ($transaction instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionElement) {
			$this->transaction = $transaction;
		}
		else {
			throw new BadMethodCallException("Type of argument transaction must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionElement.");
		}
		return $this;
	}
	
	
	
}