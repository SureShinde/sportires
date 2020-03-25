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
 * @XmlType(name="Payment", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment {
	/**
	 * @XmlElement(name="HostedDataID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	private $hostedDataID;
	
	/**
	 * @XmlElement(name="HostedDataStoreID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $hostedDataStoreID;
	
	/**
	 * @XmlValue(name="DeclineHostedDataDuplicates", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean'), namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var boolean
	 */
	private $declineHostedDataDuplicates = 'false';
	
	/**
	 * @XmlElement(name="SubTotal", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $subTotal;
	
	/**
	 * @XmlElement(name="ValueAddedTax", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $valueAddedTax;
	
	/**
	 * @XmlElement(name="DeliveryAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $deliveryAmount;
	
	/**
	 * @XmlElement(name="CashbackAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $cashbackAmount;
	
	/**
	 * @XmlElement(name="ChargeTotal", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $chargeTotal;
	
	/**
	 * @XmlElement(name="Currency", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType
	 */
	private $currency;
	
	/**
	 * @XmlElement(name="numberOfInstallments", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_NumberOfInstallments", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_NumberOfInstallments
	 */
	private $numberOfInstallments;
	
	/**
	 * @XmlElement(name="installmentsInterest", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_InstallmentsInterest", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_InstallmentsInterest
	 */
	private $installmentsInterest;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment();
		return $i;
	}
	/**
	 * Returns the value for the property hostedDataID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	public function getHostedDataID(){
		return $this->hostedDataID;
	}
	
	/**
	 * Sets the value for the property hostedDataID.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max $hostedDataID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setHostedDataID($hostedDataID){
		if ($hostedDataID instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max) {
			$this->hostedDataID = $hostedDataID;
		}
		else {
			throw new BadMethodCallException("Type of argument hostedDataID must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property hostedDataStoreID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	public function getHostedDataStoreID(){
		return $this->hostedDataStoreID;
	}
	
	/**
	 * Sets the value for the property hostedDataStoreID.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max $hostedDataStoreID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setHostedDataStoreID($hostedDataStoreID){
		if ($hostedDataStoreID instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max) {
			$this->hostedDataStoreID = $hostedDataStoreID;
		}
		else {
			throw new BadMethodCallException("Type of argument hostedDataStoreID must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property declineHostedDataDuplicates.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getDeclineHostedDataDuplicates(){
		return $this->declineHostedDataDuplicates;
	}
	
	/**
	 * Sets the value for the property declineHostedDataDuplicates.
	 * 
	 * @param boolean $declineHostedDataDuplicates
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setDeclineHostedDataDuplicates($declineHostedDataDuplicates){
		if ($declineHostedDataDuplicates instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->declineHostedDataDuplicates = $declineHostedDataDuplicates;
		}
		else {
			$this->declineHostedDataDuplicates = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean::_()->set($declineHostedDataDuplicates);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property subTotal.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getSubTotal(){
		return $this->subTotal;
	}
	
	/**
	 * Sets the value for the property subTotal.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $subTotal
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setSubTotal($subTotal){
		if ($subTotal instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->subTotal = $subTotal;
		}
		else {
			throw new BadMethodCallException("Type of argument subTotal must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property valueAddedTax.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getValueAddedTax(){
		return $this->valueAddedTax;
	}
	
	/**
	 * Sets the value for the property valueAddedTax.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $valueAddedTax
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setValueAddedTax($valueAddedTax){
		if ($valueAddedTax instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->valueAddedTax = $valueAddedTax;
		}
		else {
			throw new BadMethodCallException("Type of argument valueAddedTax must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property deliveryAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getDeliveryAmount(){
		return $this->deliveryAmount;
	}
	
	/**
	 * Sets the value for the property deliveryAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $deliveryAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setDeliveryAmount($deliveryAmount){
		if ($deliveryAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->deliveryAmount = $deliveryAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument deliveryAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property cashbackAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getCashbackAmount(){
		return $this->cashbackAmount;
	}
	
	/**
	 * Sets the value for the property cashbackAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $cashbackAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setCashbackAmount($cashbackAmount){
		if ($cashbackAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->cashbackAmount = $cashbackAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument cashbackAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property chargeTotal.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getChargeTotal(){
		return $this->chargeTotal;
	}
	
	/**
	 * Sets the value for the property chargeTotal.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $chargeTotal
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setChargeTotal($chargeTotal){
		if ($chargeTotal instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->chargeTotal = $chargeTotal;
		}
		else {
			throw new BadMethodCallException("Type of argument chargeTotal must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property currency.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType
	 */
	public function getCurrency(){
		return $this->currency;
	}
	
	/**
	 * Sets the value for the property currency.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType $currency
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setCurrency($currency){
		if ($currency instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType) {
			$this->currency = $currency;
		}
		else {
			throw new BadMethodCallException("Type of argument currency must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property numberOfInstallments.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_NumberOfInstallments
	 */
	public function getNumberOfInstallments(){
		return $this->numberOfInstallments;
	}
	
	/**
	 * Sets the value for the property numberOfInstallments.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_NumberOfInstallments $numberOfInstallments
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setNumberOfInstallments($numberOfInstallments){
		if ($numberOfInstallments instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_NumberOfInstallments) {
			$this->numberOfInstallments = $numberOfInstallments;
		}
		else {
			throw new BadMethodCallException("Type of argument numberOfInstallments must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_NumberOfInstallments.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property installmentsInterest.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_InstallmentsInterest
	 */
	public function getInstallmentsInterest(){
		return $this->installmentsInterest;
	}
	
	/**
	 * Sets the value for the property installmentsInterest.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_InstallmentsInterest $installmentsInterest
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function setInstallmentsInterest($installmentsInterest){
		if ($installmentsInterest instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_InstallmentsInterest) {
			$this->installmentsInterest = $installmentsInterest;
		}
		else {
			throw new BadMethodCallException("Type of argument installmentsInterest must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment_InstallmentsInterest.");
		}
		return $this;
	}
	
	
	
}