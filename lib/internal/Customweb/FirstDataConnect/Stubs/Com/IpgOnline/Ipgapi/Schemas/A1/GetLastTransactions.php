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
 * @XmlType(name="GetLastTransactions", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions {
	/**
	 * @XmlElement(name="StoreId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $storeId;
	
	/**
	 * @XmlElement(name="count", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_Count", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_Count
	 */
	private $count = '10';
	
	/**
	 * @XmlElement(name="OrderId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	private $orderId;
	
	/**
	 * @XmlElement(name="TDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_TDate", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_TDate
	 */
	private $tDate;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions();
		return $i;
	}
	/**
	 * Returns the value for the property storeId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getStoreId(){
		return $this->storeId;
	}
	
	/**
	 * Sets the value for the property storeId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $storeId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions
	 */
	public function setStoreId($storeId){
		if ($storeId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->storeId = $storeId;
		}
		else {
			throw new BadMethodCallException("Type of argument storeId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property count.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_Count
	 */
	public function getCount(){
		return $this->count;
	}
	
	/**
	 * Sets the value for the property count.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_Count $count
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions
	 */
	public function setCount($count){
		if ($count instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_Count) {
			$this->count = $count;
		}
		else {
			throw new BadMethodCallException("Type of argument count must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_Count.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property orderId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	public function getOrderId(){
		return $this->orderId;
	}
	
	/**
	 * Sets the value for the property orderId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max $orderId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions
	 */
	public function setOrderId($orderId){
		if ($orderId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max) {
			$this->orderId = $orderId;
		}
		else {
			throw new BadMethodCallException("Type of argument orderId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_TDate
	 */
	public function getTDate(){
		return $this->tDate;
	}
	
	/**
	 * Sets the value for the property tDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_TDate $tDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions
	 */
	public function setTDate($tDate){
		if ($tDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_TDate) {
			$this->tDate = $tDate;
		}
		else {
			throw new BadMethodCallException("Type of argument tDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_GetLastTransactions_TDate.");
		}
		return $this;
	}
	
	
	
}