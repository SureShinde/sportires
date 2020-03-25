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
 * @XmlType(name="OrderValueType", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType {
	/**
	 * @XmlValue(name="OrderId", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var string
	 */
	private $orderId;
	
	/**
	 * @XmlValue(name="OrderDate", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $orderDate;
	
	/**
	 * @XmlElement(name="Basket", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket
	 */
	private $basket;
	
	/**
	 * @XmlElement(name="Billing", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	private $billing;
	
	/**
	 * @XmlElement(name="MandateReference", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference
	 */
	private $mandateReference;
	
	/**
	 * @XmlElement(name="Shipping", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping
	 */
	private $shipping;
	
	/**
	 * @XmlElement(name="TransactionValues", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	private $transactionValues;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType();
		return $i;
	}
	/**
	 * Returns the value for the property orderId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getOrderId(){
		return $this->orderId;
	}
	
	/**
	 * Sets the value for the property orderId.
	 * 
	 * @param string $orderId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType
	 */
	public function setOrderId($orderId){
		if ($orderId instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->orderId = $orderId;
		}
		else {
			$this->orderId = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($orderId);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property orderDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getOrderDate(){
		return $this->orderDate;
	}
	
	/**
	 * Sets the value for the property orderDate.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $orderDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType
	 */
	public function setOrderDate($orderDate){
		if ($orderDate instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->orderDate = $orderDate;
		}
		else {
			$this->orderDate = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime::_()->set($orderDate);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property basket.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket
	 */
	public function getBasket(){
		return $this->basket;
	}
	
	/**
	 * Sets the value for the property basket.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket $basket
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType
	 */
	public function setBasket($basket){
		if ($basket instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket) {
			$this->basket = $basket;
		}
		else {
			throw new BadMethodCallException("Type of argument basket must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property billing.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	public function getBilling(){
		return $this->billing;
	}
	
	/**
	 * Sets the value for the property billing.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing $billing
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType
	 */
	public function setBilling($billing){
		if ($billing instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing) {
			$this->billing = $billing;
		}
		else {
			throw new BadMethodCallException("Type of argument billing must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property mandateReference.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference
	 */
	public function getMandateReference(){
		return $this->mandateReference;
	}
	
	/**
	 * Sets the value for the property mandateReference.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference $mandateReference
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType
	 */
	public function setMandateReference($mandateReference){
		if ($mandateReference instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference) {
			$this->mandateReference = $mandateReference;
		}
		else {
			throw new BadMethodCallException("Type of argument mandateReference must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property shipping.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping
	 */
	public function getShipping(){
		return $this->shipping;
	}
	
	/**
	 * Sets the value for the property shipping.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping $shipping
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType
	 */
	public function setShipping($shipping){
		if ($shipping instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping) {
			$this->shipping = $shipping;
		}
		else {
			throw new BadMethodCallException("Type of argument shipping must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property transactionValues.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function getTransactionValues(){
		return $this->transactionValues;
	}
	
	/**
	 * Sets the value for the property transactionValues.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues $transactionValues
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType
	 */
	public function setTransactionValues($transactionValues){
		if ($transactionValues instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues) {
			$this->transactionValues = $transactionValues;
		}
		else {
			throw new BadMethodCallException("Type of argument transactionValues must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues.");
		}
		return $this;
	}
	
	
	
}