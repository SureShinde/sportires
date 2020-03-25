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
 * @XmlType(name="Transaction", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction {
	/**
	 * @XmlElement(name="CreditCardTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType
	 */
	private $creditCardTxType;
	
	/**
	 * @XmlElement(name="CreditCardData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardData
	 */
	private $creditCardData;
	
	/**
	 * @XmlElement(name="CreditCard3DSecure", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCard3DSecure
	 */
	private $creditCard3DSecure;
	
	/**
	 * @XmlElement(name="MCC6012Details", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	private $mCC6012Details;
	
	/**
	 * @XmlElement(name="EMVCardPresentRequest", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest
	 */
	private $eMVCardPresentRequest;
	
	/**
	 * @XmlElement(name="cardFunction", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardFunctionType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardFunctionType
	 */
	private $cardFunction;
	
	/**
	 * @XmlElement(name="CustomerCardTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardTxType
	 */
	private $customerCardTxType;
	
	/**
	 * @XmlElement(name="CustomerCardData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData
	 */
	private $customerCardData;
	
	/**
	 * @XmlElement(name="DE_DirectDebitTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType
	 */
	private $dE_DirectDebitTxType;
	
	/**
	 * @XmlElement(name="DE_DirectDebitData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	private $dE_DirectDebitData;
	
	/**
	 * @XmlElement(name="UK_DebitCardTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardTxType
	 */
	private $uK_DebitCardTxType;
	
	/**
	 * @XmlElement(name="UK_DebitCardData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData
	 */
	private $uK_DebitCardData;
	
	/**
	 * @XmlElement(name="ClickandBuyTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType
	 */
	private $clickandBuyTxType;
	
	/**
	 * @XmlElement(name="ClickandBuyData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData
	 */
	private $clickandBuyData;
	
	/**
	 * @XmlElement(name="PayPalTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType
	 */
	private $payPalTxType;
	
	/**
	 * @XmlElement(name="SofortTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_SofortTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_SofortTxType
	 */
	private $sofortTxType;
	
	/**
	 * @XmlElement(name="TopUpTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType
	 */
	private $topUpTxType;
	
	/**
	 * @XmlElement(name="KlarnaTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType
	 */
	private $klarnaTxType;
	
	/**
	 * @XmlValue(name="KlarnaPClassID", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer'), namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var integer
	 */
	private $klarnaPClassID;
	
	/**
	 * @XmlElement(name="Payment", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment
	 */
	private $payment;
	
	/**
	 * @XmlElement(name="TransactionDetails", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionDetails", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionDetails
	 */
	private $transactionDetails;
	
	/**
	 * @XmlElement(name="Billing", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	private $billing;
	
	/**
	 * @XmlElement(name="Shipping", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping
	 */
	private $shipping;
	
	/**
	 * @XmlElement(name="ClientLocale", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClientLocale", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClientLocale
	 */
	private $clientLocale;
	
	/**
	 * @XmlElement(name="Basket", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket
	 */
	private $basket;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction();
		return $i;
	}
	/**
	 * Returns the value for the property creditCardTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType
	 */
	public function getCreditCardTxType(){
		return $this->creditCardTxType;
	}
	
	/**
	 * Sets the value for the property creditCardTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType $creditCardTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setCreditCardTxType($creditCardTxType){
		if ($creditCardTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType) {
			$this->creditCardTxType = $creditCardTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument creditCardTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
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
	 * Returns the value for the property mCC6012Details.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	public function getMCC6012Details(){
		return $this->mCC6012Details;
	}
	
	/**
	 * Sets the value for the property mCC6012Details.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details $mCC6012Details
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setMCC6012Details($mCC6012Details){
		if ($mCC6012Details instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details) {
			$this->mCC6012Details = $mCC6012Details;
		}
		else {
			throw new BadMethodCallException("Type of argument mCC6012Details must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property eMVCardPresentRequest.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest
	 */
	public function getEMVCardPresentRequest(){
		return $this->eMVCardPresentRequest;
	}
	
	/**
	 * Sets the value for the property eMVCardPresentRequest.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest $eMVCardPresentRequest
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setEMVCardPresentRequest($eMVCardPresentRequest){
		if ($eMVCardPresentRequest instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest) {
			$this->eMVCardPresentRequest = $eMVCardPresentRequest;
		}
		else {
			throw new BadMethodCallException("Type of argument eMVCardPresentRequest must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_EMVCardPresentRequest.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
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
	 * Returns the value for the property customerCardTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardTxType
	 */
	public function getCustomerCardTxType(){
		return $this->customerCardTxType;
	}
	
	/**
	 * Sets the value for the property customerCardTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardTxType $customerCardTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setCustomerCardTxType($customerCardTxType){
		if ($customerCardTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardTxType) {
			$this->customerCardTxType = $customerCardTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument customerCardTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardTxType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property customerCardData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData
	 */
	public function getCustomerCardData(){
		return $this->customerCardData;
	}
	
	/**
	 * Sets the value for the property customerCardData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData $customerCardData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setCustomerCardData($customerCardData){
		if ($customerCardData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData) {
			$this->customerCardData = $customerCardData;
		}
		else {
			throw new BadMethodCallException("Type of argument customerCardData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CustomerCardData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dE_DirectDebitTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType
	 */
	public function getDE_DirectDebitTxType(){
		return $this->dE_DirectDebitTxType;
	}
	
	/**
	 * Sets the value for the property dE_DirectDebitTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType $dE_DirectDebitTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setDE_DirectDebitTxType($dE_DirectDebitTxType){
		if ($dE_DirectDebitTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType) {
			$this->dE_DirectDebitTxType = $dE_DirectDebitTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument dE_DirectDebitTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
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
	 * Returns the value for the property uK_DebitCardTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardTxType
	 */
	public function getUK_DebitCardTxType(){
		return $this->uK_DebitCardTxType;
	}
	
	/**
	 * Sets the value for the property uK_DebitCardTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardTxType $uK_DebitCardTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setUK_DebitCardTxType($uK_DebitCardTxType){
		if ($uK_DebitCardTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardTxType) {
			$this->uK_DebitCardTxType = $uK_DebitCardTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument uK_DebitCardTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardTxType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property uK_DebitCardData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData
	 */
	public function getUK_DebitCardData(){
		return $this->uK_DebitCardData;
	}
	
	/**
	 * Sets the value for the property uK_DebitCardData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData $uK_DebitCardData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setUK_DebitCardData($uK_DebitCardData){
		if ($uK_DebitCardData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData) {
			$this->uK_DebitCardData = $uK_DebitCardData;
		}
		else {
			throw new BadMethodCallException("Type of argument uK_DebitCardData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property clickandBuyTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType
	 */
	public function getClickandBuyTxType(){
		return $this->clickandBuyTxType;
	}
	
	/**
	 * Sets the value for the property clickandBuyTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType $clickandBuyTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setClickandBuyTxType($clickandBuyTxType){
		if ($clickandBuyTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType) {
			$this->clickandBuyTxType = $clickandBuyTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument clickandBuyTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property clickandBuyData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData
	 */
	public function getClickandBuyData(){
		return $this->clickandBuyData;
	}
	
	/**
	 * Sets the value for the property clickandBuyData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData $clickandBuyData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setClickandBuyData($clickandBuyData){
		if ($clickandBuyData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData) {
			$this->clickandBuyData = $clickandBuyData;
		}
		else {
			throw new BadMethodCallException("Type of argument clickandBuyData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property payPalTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType
	 */
	public function getPayPalTxType(){
		return $this->payPalTxType;
	}
	
	/**
	 * Sets the value for the property payPalTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType $payPalTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setPayPalTxType($payPalTxType){
		if ($payPalTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType) {
			$this->payPalTxType = $payPalTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument payPalTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property sofortTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_SofortTxType
	 */
	public function getSofortTxType(){
		return $this->sofortTxType;
	}
	
	/**
	 * Sets the value for the property sofortTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_SofortTxType $sofortTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setSofortTxType($sofortTxType){
		if ($sofortTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_SofortTxType) {
			$this->sofortTxType = $sofortTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument sofortTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_SofortTxType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property topUpTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType
	 */
	public function getTopUpTxType(){
		return $this->topUpTxType;
	}
	
	/**
	 * Sets the value for the property topUpTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType $topUpTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setTopUpTxType($topUpTxType){
		if ($topUpTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType) {
			$this->topUpTxType = $topUpTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument topUpTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TopUpTxType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property klarnaTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType
	 */
	public function getKlarnaTxType(){
		return $this->klarnaTxType;
	}
	
	/**
	 * Sets the value for the property klarnaTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType $klarnaTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setKlarnaTxType($klarnaTxType){
		if ($klarnaTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType) {
			$this->klarnaTxType = $klarnaTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument klarnaTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType.");
		}
		return $this;
	}
	
	
	/**
	 * For Invoice please send -1
	 * 
	 * Returns the value for the property klarnaPClassID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getKlarnaPClassID(){
		return $this->klarnaPClassID;
	}
	
	/**
	 * For Invoice please send -1
	 * 
	 * Sets the value for the property klarnaPClassID.
	 * 
	 * @param integer $klarnaPClassID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setKlarnaPClassID($klarnaPClassID){
		if ($klarnaPClassID instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer) {
			$this->klarnaPClassID = $klarnaPClassID;
		}
		else {
			$this->klarnaPClassID = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer::_()->set($klarnaPClassID);
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
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
	 * Returns the value for the property transactionDetails.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionDetails
	 */
	public function getTransactionDetails(){
		return $this->transactionDetails;
	}
	
	/**
	 * Sets the value for the property transactionDetails.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionDetails $transactionDetails
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setTransactionDetails($transactionDetails){
		if ($transactionDetails instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionDetails) {
			$this->transactionDetails = $transactionDetails;
		}
		else {
			throw new BadMethodCallException("Type of argument transactionDetails must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionDetails.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
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
	 * Returns the value for the property clientLocale.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClientLocale
	 */
	public function getClientLocale(){
		return $this->clientLocale;
	}
	
	/**
	 * Sets the value for the property clientLocale.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClientLocale $clientLocale
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
	 */
	public function setClientLocale($clientLocale){
		if ($clientLocale instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClientLocale) {
			$this->clientLocale = $clientLocale;
		}
		else {
			throw new BadMethodCallException("Type of argument clientLocale must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClientLocale.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction
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
	
	
	
}