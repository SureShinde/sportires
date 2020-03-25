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
 * @XmlType(name="RecurringPaymentValues", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues extends Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation {
	/**
	 * @XmlElement(name="State", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues_State", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues_State
	 */
	private $state;
	
	/**
	 * @XmlElement(name="CreationDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate
	 */
	private $creationDate;
	
	/**
	 * @XmlValue(name="FailureCount", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var integer
	 */
	private $failureCount;
	
	/**
	 * @XmlElement(name="NextAttemptDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate
	 */
	private $nextAttemptDate;
	
	/**
	 * @XmlValue(name="RunCount", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var integer
	 */
	private $runCount;
	
	/**
	 * @XmlElement(name="CreditCardData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	private $creditCardData;
	
	/**
	 * @XmlElement(name="DE_DirectDebitData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	private $dE_DirectDebitData;
	
	/**
	 * @XmlElement(name="HostedDataID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	private $hostedDataID;
	
	/**
	 * @XmlElement(name="HostedDataStoreID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $hostedDataStoreID;
	
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
	 * @XmlElement(name="TransactionOrigin", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionOrigin", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionOrigin
	 */
	private $transactionOrigin = 'ECI';
	
	/**
	 * @XmlElement(name="InvoiceNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max
	 */
	private $invoiceNumber;
	
	/**
	 * @XmlElement(name="PONumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	private $pONumber;
	
	/**
	 * @XmlElement(name="Comments", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1024max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1024max
	 */
	private $comments;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues();
		return $i;
	}
	/**
	 * Returns the value for the property state.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues_State
	 */
	public function getState(){
		return $this->state;
	}
	
	/**
	 * Sets the value for the property state.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues_State $state
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setState($state){
		if ($state instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues_State) {
			$this->state = $state;
		}
		else {
			throw new BadMethodCallException("Type of argument state must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues_State.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property creationDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate
	 */
	public function getCreationDate(){
		return $this->creationDate;
	}
	
	/**
	 * Sets the value for the property creationDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate $creationDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setCreationDate($creationDate){
		if ($creationDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate) {
			$this->creationDate = $creationDate;
		}
		else {
			throw new BadMethodCallException("Type of argument creationDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property failureCount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getFailureCount(){
		return $this->failureCount;
	}
	
	/**
	 * Sets the value for the property failureCount.
	 * 
	 * @param integer $failureCount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setFailureCount($failureCount){
		if ($failureCount instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer) {
			$this->failureCount = $failureCount;
		}
		else {
			$this->failureCount = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer::_()->set($failureCount);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property nextAttemptDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate
	 */
	public function getNextAttemptDate(){
		return $this->nextAttemptDate;
	}
	
	/**
	 * Sets the value for the property nextAttemptDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate $nextAttemptDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setNextAttemptDate($nextAttemptDate){
		if ($nextAttemptDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate) {
			$this->nextAttemptDate = $nextAttemptDate;
		}
		else {
			throw new BadMethodCallException("Type of argument nextAttemptDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property runCount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getRunCount(){
		return $this->runCount;
	}
	
	/**
	 * Sets the value for the property runCount.
	 * 
	 * @param integer $runCount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setRunCount($runCount){
		if ($runCount instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer) {
			$this->runCount = $runCount;
		}
		else {
			$this->runCount = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer::_()->set($runCount);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property creditCardData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	public function getCreditCardData(){
		return $this->creditCardData;
	}
	
	/**
	 * Sets the value for the property creditCardData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData $creditCardData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setCreditCardData($creditCardData){
		if ($creditCardData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData) {
			$this->creditCardData = $creditCardData;
		}
		else {
			throw new BadMethodCallException("Type of argument creditCardData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dE_DirectDebitData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function getDE_DirectDebitData(){
		return $this->dE_DirectDebitData;
	}
	
	/**
	 * Sets the value for the property dE_DirectDebitData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData $dE_DirectDebitData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setDE_DirectDebitData($dE_DirectDebitData){
		if ($dE_DirectDebitData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData) {
			$this->dE_DirectDebitData = $dE_DirectDebitData;
		}
		else {
			throw new BadMethodCallException("Type of argument dE_DirectDebitData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData.");
		}
		return $this;
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
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
	 * Returns the value for the property transactionOrigin.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionOrigin
	 */
	public function getTransactionOrigin(){
		return $this->transactionOrigin;
	}
	
	/**
	 * Sets the value for the property transactionOrigin.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionOrigin $transactionOrigin
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setTransactionOrigin($transactionOrigin){
		if ($transactionOrigin instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionOrigin) {
			$this->transactionOrigin = $transactionOrigin;
		}
		else {
			throw new BadMethodCallException("Type of argument transactionOrigin must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionOrigin.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property invoiceNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max
	 */
	public function getInvoiceNumber(){
		return $this->invoiceNumber;
	}
	
	/**
	 * Sets the value for the property invoiceNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max $invoiceNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setInvoiceNumber($invoiceNumber){
		if ($invoiceNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max) {
			$this->invoiceNumber = $invoiceNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument invoiceNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property pONumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	public function getPONumber(){
		return $this->pONumber;
	}
	
	/**
	 * Sets the value for the property pONumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max $pONumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setPONumber($pONumber){
		if ($pONumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max) {
			$this->pONumber = $pONumber;
		}
		else {
			throw new BadMethodCallException("Type of argument pONumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property comments.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1024max
	 */
	public function getComments(){
		return $this->comments;
	}
	
	/**
	 * Sets the value for the property comments.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1024max $comments
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function setComments($comments){
		if ($comments instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1024max) {
			$this->comments = $comments;
		}
		else {
			throw new BadMethodCallException("Type of argument comments must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1024max.");
		}
		return $this;
	}
	
	
	
}