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
 * @XmlType(name="ClickandBuyData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData {
	/**
	 * @XmlElement(name="orderDetails", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails
	 */
	private $orderDetails;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData();
		return $i;
	}
	/**
	 * details of the payment
	 * 
	 * Returns the value for the property orderDetails.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails
	 */
	public function getOrderDetails(){
		return $this->orderDetails;
	}
	
	/**
	 * details of the payment
	 * 
	 * Sets the value for the property orderDetails.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails $orderDetails
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData
	 */
	public function setOrderDetails($orderDetails){
		if ($orderDetails instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails) {
			$this->orderDetails = $orderDetails;
		}
		else {
			throw new BadMethodCallException("Type of argument orderDetails must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails.");
		}
		return $this;
	}
	
	
	
}