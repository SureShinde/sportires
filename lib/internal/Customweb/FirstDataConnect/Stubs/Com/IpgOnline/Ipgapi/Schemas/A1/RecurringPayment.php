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
 * @XmlType(name="RecurringPayment", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment {
	/**
	 * @XmlElement(name="Function", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Function", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Function
	 */
	private $function;
	
	/**
	 * @XmlElement(name="OrderId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	private $orderId;
	
	/**
	 * @XmlElement(name="StoreId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max
	 */
	private $storeId;
	
	/**
	 * @XmlElement(name="Comments", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1024max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String1024max
	 */
	private $comments;
	
	/**
	 * @XmlElement(name="InvoiceNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max
	 */
	private $invoiceNumber;
	
	/**
	 * @XmlElement(name="DynamicMerchantName", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	private $dynamicMerchantName;
	
	/**
	 * @XmlElement(name="PONumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	private $pONumber;
	
	/**
	 * @XmlElement(name="RecurringPaymentInformation", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation
	 */
	private $recurringPaymentInformation;
	
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
	 * @XmlElement(name="cardFunction", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardFunctionType", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardFunctionType
	 */
	private $cardFunction;
	
	/**
	 * @XmlElement(name="MandateReference", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference
	 */
	private $mandateReference;
	
	/**
	 * @XmlElement(name="ReferencedOrderId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	private $referencedOrderId;
	
	/**
	 * @XmlElement(name="Payment", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	private $payment;
	
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
	 * @XmlElement(name="CreditCard3DSecure", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure
	 */
	private $creditCard3DSecure;
	
	/**
	 * @XmlElement(name="Shipping", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping
	 */
	private $shipping;
	
	/**
	 * @XmlElement(name="Ip", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Ip", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Ip
	 */
	private $ip;
	
	/**
	 * @XmlElement(name="TransactionOrigin", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionOrigin", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionOrigin
	 */
	private $transactionOrigin = 'ECI';
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment();
		return $i;
	}
	/**
	 * Returns the value for the property function.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Function
	 */
	public function getFunction(){
		return $this->function;
	}
	
	/**
	 * Sets the value for the property function.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Function $function
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setFunction($function){
		if ($function instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Function) {
			$this->function = $function;
		}
		else {
			throw new BadMethodCallException("Type of argument function must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Function.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * Returns the value for the property dynamicMerchantName.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	public function getDynamicMerchantName(){
		return $this->dynamicMerchantName;
	}
	
	/**
	 * Sets the value for the property dynamicMerchantName.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max $dynamicMerchantName
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setDynamicMerchantName($dynamicMerchantName){
		if ($dynamicMerchantName instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max) {
			$this->dynamicMerchantName = $dynamicMerchantName;
		}
		else {
			throw new BadMethodCallException("Type of argument dynamicMerchantName must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * Returns the value for the property recurringPaymentInformation.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation
	 */
	public function getRecurringPaymentInformation(){
		return $this->recurringPaymentInformation;
	}
	
	/**
	 * Sets the value for the property recurringPaymentInformation.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation $recurringPaymentInformation
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setRecurringPaymentInformation($recurringPaymentInformation){
		if ($recurringPaymentInformation instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation) {
			$this->recurringPaymentInformation = $recurringPaymentInformation;
		}
		else {
			throw new BadMethodCallException("Type of argument recurringPaymentInformation must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * Returns the value for the property cardFunction.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardFunctionType
	 */
	public function getCardFunction(){
		return $this->cardFunction;
	}
	
	/**
	 * Sets the value for the property cardFunction.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardFunctionType $cardFunction
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setCardFunction($cardFunction){
		if ($cardFunction instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardFunctionType) {
			$this->cardFunction = $cardFunction;
		}
		else {
			throw new BadMethodCallException("Type of argument cardFunction must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardFunctionType.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * Returns the value for the property referencedOrderId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	public function getReferencedOrderId(){
		return $this->referencedOrderId;
	}
	
	/**
	 * Sets the value for the property referencedOrderId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max $referencedOrderId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setReferencedOrderId($referencedOrderId){
		if ($referencedOrderId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max) {
			$this->referencedOrderId = $referencedOrderId;
		}
		else {
			throw new BadMethodCallException("Type of argument referencedOrderId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property payment.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	public function getPayment(){
		return $this->payment;
	}
	
	/**
	 * Sets the value for the property payment.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment $payment
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setPayment($payment){
		if ($payment instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment) {
			$this->payment = $payment;
		}
		else {
			throw new BadMethodCallException("Type of argument payment must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * Returns the value for the property creditCard3DSecure.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure
	 */
	public function getCreditCard3DSecure(){
		return $this->creditCard3DSecure;
	}
	
	/**
	 * Sets the value for the property creditCard3DSecure.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure $creditCard3DSecure
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setCreditCard3DSecure($creditCard3DSecure){
		if ($creditCard3DSecure instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure) {
			$this->creditCard3DSecure = $creditCard3DSecure;
		}
		else {
			throw new BadMethodCallException("Type of argument creditCard3DSecure must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
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
	 * Returns the value for the property ip.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Ip
	 */
	public function getIp(){
		return $this->ip;
	}
	
	/**
	 * Sets the value for the property ip.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Ip $ip
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setIp($ip){
		if ($ip instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Ip) {
			$this->ip = $ip;
		}
		else {
			throw new BadMethodCallException("Type of argument ip must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Ip.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property transactionOrigin.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionOrigin
	 */
	public function getTransactionOrigin(){
		return $this->transactionOrigin;
	}
	
	/**
	 * Sets the value for the property transactionOrigin.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionOrigin $transactionOrigin
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPayment
	 */
	public function setTransactionOrigin($transactionOrigin){
		if ($transactionOrigin instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionOrigin) {
			$this->transactionOrigin = $transactionOrigin;
		}
		else {
			throw new BadMethodCallException("Type of argument transactionOrigin must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionOrigin.");
		}
		return $this;
	}
	
	
	
}