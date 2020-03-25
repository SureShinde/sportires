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
 * @XmlType(name="IPGApiOrderResponse", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse {
	/**
	 * @XmlValue(name="DebugInformation", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $debugInformation;
	
	/**
	 * @XmlValue(name="ApprovalCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $approvalCode;
	
	/**
	 * @XmlValue(name="AVSResponse", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $aVSResponse;
	
	/**
	 * @XmlValue(name="Brand", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $brand;
	
	/**
	 * @XmlValue(name="Country", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $country;
	
	/**
	 * @XmlValue(name="CommercialServiceProvider", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $commercialServiceProvider;
	
	/**
	 * @XmlValue(name="ErrorMessage", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $errorMessage;
	
	/**
	 * @XmlValue(name="OrderId", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $orderId;
	
	/**
	 * @XmlElement(name="IpgTransactionId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max
	 */
	private $ipgTransactionId;
	
	/**
	 * @XmlValue(name="PayerSecurityLevel", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $payerSecurityLevel;
	
	/**
	 * @XmlValue(name="PaymentType", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $paymentType;
	
	/**
	 * @XmlValue(name="ProcessorApprovalCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorApprovalCode;
	
	/**
	 * @XmlValue(name="ProcessorReceiptNumber", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorReceiptNumber;
	
	/**
	 * @XmlValue(name="ProcessorCCVResponse", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorCCVResponse;
	
	/**
	 * @XmlValue(name="ProcessorReferenceNumber", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorReferenceNumber;
	
	/**
	 * @XmlValue(name="ProcessorResponseCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorResponseCode;
	
	/**
	 * @XmlValue(name="ProcessorResponseMessage", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorResponseMessage;
	
	/**
	 * @XmlValue(name="ProcessorTraceNumber", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorTraceNumber;
	
	/**
	 * @XmlElement(name="ProcessorInstallmentFirstAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorInstallmentFirstAmount;
	
	/**
	 * @XmlElement(name="ProcessorInstallmentOtherAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorInstallmentOtherAmount;
	
	/**
	 * @XmlElement(name="ProcessorInstallmentIssuerFeeAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorInstallmentIssuerFeeAmount;
	
	/**
	 * @XmlElement(name="ProcessorInstallmentTaxesAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorInstallmentTaxesAmount;
	
	/**
	 * @XmlElement(name="ProcessorInstallmentInsuranceAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorInstallmentInsuranceAmount;
	
	/**
	 * @XmlElement(name="ProcessorInstallmentOtherExpensesAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorInstallmentOtherExpensesAmount;
	
	/**
	 * @XmlElement(name="ProcessorInstallmentTotalAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorInstallmentTotalAmount;
	
	/**
	 * @XmlElement(name="ProcessorInstallmentRatePerYear", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorInstallmentRatePerYear;
	
	/**
	 * @XmlElement(name="ProcessorVoucherRemainingAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	private $processorVoucherRemainingAmount;
	
	/**
	 * @XmlValue(name="ProcessorVoucherType", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorVoucherType;
	
	/**
	 * @XmlValue(name="ReferencedTDate", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $referencedTDate;
	
	/**
	 * @XmlValue(name="TDate", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $tDate;
	
	/**
	 * @XmlValue(name="TDateFormatted", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $tDateFormatted;
	
	/**
	 * @XmlValue(name="TerminalID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $terminalID;
	
	/**
	 * @XmlValue(name="TransactionResult", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $transactionResult;
	
	/**
	 * @XmlValue(name="TransactionTime", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $transactionTime;
	
	/**
	 * @XmlElement(name="EMVCardPresentResponse", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse
	 */
	private $eMVCardPresentResponse;
	
	/**
	 * @XmlElement(name="MandateReference", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference
	 */
	private $mandateReference;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse();
		return $i;
	}
	/**
	 * Returns the value for the property debugInformation.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getDebugInformation(){
		return $this->debugInformation;
	}
	
	/**
	 * Sets the value for the property debugInformation.
	 * 
	 * @param string $debugInformation
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setDebugInformation($debugInformation){
		if ($debugInformation instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->debugInformation = $debugInformation;
		}
		else {
			$this->debugInformation = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($debugInformation);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property approvalCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getApprovalCode(){
		return $this->approvalCode;
	}
	
	/**
	 * Sets the value for the property approvalCode.
	 * 
	 * @param string $approvalCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setApprovalCode($approvalCode){
		if ($approvalCode instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->approvalCode = $approvalCode;
		}
		else {
			$this->approvalCode = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($approvalCode);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property aVSResponse.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getAVSResponse(){
		return $this->aVSResponse;
	}
	
	/**
	 * Sets the value for the property aVSResponse.
	 * 
	 * @param string $aVSResponse
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setAVSResponse($aVSResponse){
		if ($aVSResponse instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->aVSResponse = $aVSResponse;
		}
		else {
			$this->aVSResponse = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($aVSResponse);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property brand.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getBrand(){
		return $this->brand;
	}
	
	/**
	 * Sets the value for the property brand.
	 * 
	 * @param string $brand
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setBrand($brand){
		if ($brand instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->brand = $brand;
		}
		else {
			$this->brand = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($brand);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property country.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCountry(){
		return $this->country;
	}
	
	/**
	 * Sets the value for the property country.
	 * 
	 * @param string $country
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setCountry($country){
		if ($country instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->country = $country;
		}
		else {
			$this->country = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($country);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property commercialServiceProvider.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCommercialServiceProvider(){
		return $this->commercialServiceProvider;
	}
	
	/**
	 * Sets the value for the property commercialServiceProvider.
	 * 
	 * @param string $commercialServiceProvider
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setCommercialServiceProvider($commercialServiceProvider){
		if ($commercialServiceProvider instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->commercialServiceProvider = $commercialServiceProvider;
		}
		else {
			$this->commercialServiceProvider = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($commercialServiceProvider);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property errorMessage.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getErrorMessage(){
		return $this->errorMessage;
	}
	
	/**
	 * Sets the value for the property errorMessage.
	 * 
	 * @param string $errorMessage
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setErrorMessage($errorMessage){
		if ($errorMessage instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->errorMessage = $errorMessage;
		}
		else {
			$this->errorMessage = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($errorMessage);
		}
		return $this;
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
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
	 * Returns the value for the property ipgTransactionId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max
	 */
	public function getIpgTransactionId(){
		return $this->ipgTransactionId;
	}
	
	/**
	 * Sets the value for the property ipgTransactionId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max $ipgTransactionId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setIpgTransactionId($ipgTransactionId){
		if ($ipgTransactionId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max) {
			$this->ipgTransactionId = $ipgTransactionId;
		}
		else {
			throw new BadMethodCallException("Type of argument ipgTransactionId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property payerSecurityLevel.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPayerSecurityLevel(){
		return $this->payerSecurityLevel;
	}
	
	/**
	 * Sets the value for the property payerSecurityLevel.
	 * 
	 * @param string $payerSecurityLevel
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setPayerSecurityLevel($payerSecurityLevel){
		if ($payerSecurityLevel instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->payerSecurityLevel = $payerSecurityLevel;
		}
		else {
			$this->payerSecurityLevel = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($payerSecurityLevel);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property paymentType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getPaymentType(){
		return $this->paymentType;
	}
	
	/**
	 * Sets the value for the property paymentType.
	 * 
	 * @param string $paymentType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setPaymentType($paymentType){
		if ($paymentType instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->paymentType = $paymentType;
		}
		else {
			$this->paymentType = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($paymentType);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorApprovalCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorApprovalCode(){
		return $this->processorApprovalCode;
	}
	
	/**
	 * Sets the value for the property processorApprovalCode.
	 * 
	 * @param string $processorApprovalCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorApprovalCode($processorApprovalCode){
		if ($processorApprovalCode instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorApprovalCode = $processorApprovalCode;
		}
		else {
			$this->processorApprovalCode = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorApprovalCode);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorReceiptNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorReceiptNumber(){
		return $this->processorReceiptNumber;
	}
	
	/**
	 * Sets the value for the property processorReceiptNumber.
	 * 
	 * @param string $processorReceiptNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorReceiptNumber($processorReceiptNumber){
		if ($processorReceiptNumber instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorReceiptNumber = $processorReceiptNumber;
		}
		else {
			$this->processorReceiptNumber = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorReceiptNumber);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorCCVResponse.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorCCVResponse(){
		return $this->processorCCVResponse;
	}
	
	/**
	 * Sets the value for the property processorCCVResponse.
	 * 
	 * @param string $processorCCVResponse
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorCCVResponse($processorCCVResponse){
		if ($processorCCVResponse instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorCCVResponse = $processorCCVResponse;
		}
		else {
			$this->processorCCVResponse = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorCCVResponse);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorReferenceNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorReferenceNumber(){
		return $this->processorReferenceNumber;
	}
	
	/**
	 * Sets the value for the property processorReferenceNumber.
	 * 
	 * @param string $processorReferenceNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorReferenceNumber($processorReferenceNumber){
		if ($processorReferenceNumber instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorReferenceNumber = $processorReferenceNumber;
		}
		else {
			$this->processorReferenceNumber = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorReferenceNumber);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorResponseCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorResponseCode(){
		return $this->processorResponseCode;
	}
	
	/**
	 * Sets the value for the property processorResponseCode.
	 * 
	 * @param string $processorResponseCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorResponseCode($processorResponseCode){
		if ($processorResponseCode instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorResponseCode = $processorResponseCode;
		}
		else {
			$this->processorResponseCode = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorResponseCode);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorResponseMessage.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorResponseMessage(){
		return $this->processorResponseMessage;
	}
	
	/**
	 * Sets the value for the property processorResponseMessage.
	 * 
	 * @param string $processorResponseMessage
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorResponseMessage($processorResponseMessage){
		if ($processorResponseMessage instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorResponseMessage = $processorResponseMessage;
		}
		else {
			$this->processorResponseMessage = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorResponseMessage);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorTraceNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorTraceNumber(){
		return $this->processorTraceNumber;
	}
	
	/**
	 * Sets the value for the property processorTraceNumber.
	 * 
	 * @param string $processorTraceNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorTraceNumber($processorTraceNumber){
		if ($processorTraceNumber instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorTraceNumber = $processorTraceNumber;
		}
		else {
			$this->processorTraceNumber = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorTraceNumber);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorInstallmentFirstAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorInstallmentFirstAmount(){
		return $this->processorInstallmentFirstAmount;
	}
	
	/**
	 * Sets the value for the property processorInstallmentFirstAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorInstallmentFirstAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorInstallmentFirstAmount($processorInstallmentFirstAmount){
		if ($processorInstallmentFirstAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorInstallmentFirstAmount = $processorInstallmentFirstAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument processorInstallmentFirstAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorInstallmentOtherAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorInstallmentOtherAmount(){
		return $this->processorInstallmentOtherAmount;
	}
	
	/**
	 * Sets the value for the property processorInstallmentOtherAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorInstallmentOtherAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorInstallmentOtherAmount($processorInstallmentOtherAmount){
		if ($processorInstallmentOtherAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorInstallmentOtherAmount = $processorInstallmentOtherAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument processorInstallmentOtherAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorInstallmentIssuerFeeAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorInstallmentIssuerFeeAmount(){
		return $this->processorInstallmentIssuerFeeAmount;
	}
	
	/**
	 * Sets the value for the property processorInstallmentIssuerFeeAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorInstallmentIssuerFeeAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorInstallmentIssuerFeeAmount($processorInstallmentIssuerFeeAmount){
		if ($processorInstallmentIssuerFeeAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorInstallmentIssuerFeeAmount = $processorInstallmentIssuerFeeAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument processorInstallmentIssuerFeeAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorInstallmentTaxesAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorInstallmentTaxesAmount(){
		return $this->processorInstallmentTaxesAmount;
	}
	
	/**
	 * Sets the value for the property processorInstallmentTaxesAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorInstallmentTaxesAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorInstallmentTaxesAmount($processorInstallmentTaxesAmount){
		if ($processorInstallmentTaxesAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorInstallmentTaxesAmount = $processorInstallmentTaxesAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument processorInstallmentTaxesAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorInstallmentInsuranceAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorInstallmentInsuranceAmount(){
		return $this->processorInstallmentInsuranceAmount;
	}
	
	/**
	 * Sets the value for the property processorInstallmentInsuranceAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorInstallmentInsuranceAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorInstallmentInsuranceAmount($processorInstallmentInsuranceAmount){
		if ($processorInstallmentInsuranceAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorInstallmentInsuranceAmount = $processorInstallmentInsuranceAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument processorInstallmentInsuranceAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorInstallmentOtherExpensesAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorInstallmentOtherExpensesAmount(){
		return $this->processorInstallmentOtherExpensesAmount;
	}
	
	/**
	 * Sets the value for the property processorInstallmentOtherExpensesAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorInstallmentOtherExpensesAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorInstallmentOtherExpensesAmount($processorInstallmentOtherExpensesAmount){
		if ($processorInstallmentOtherExpensesAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorInstallmentOtherExpensesAmount = $processorInstallmentOtherExpensesAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument processorInstallmentOtherExpensesAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorInstallmentTotalAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorInstallmentTotalAmount(){
		return $this->processorInstallmentTotalAmount;
	}
	
	/**
	 * Sets the value for the property processorInstallmentTotalAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorInstallmentTotalAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorInstallmentTotalAmount($processorInstallmentTotalAmount){
		if ($processorInstallmentTotalAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorInstallmentTotalAmount = $processorInstallmentTotalAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument processorInstallmentTotalAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorInstallmentRatePerYear.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorInstallmentRatePerYear(){
		return $this->processorInstallmentRatePerYear;
	}
	
	/**
	 * Sets the value for the property processorInstallmentRatePerYear.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorInstallmentRatePerYear
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorInstallmentRatePerYear($processorInstallmentRatePerYear){
		if ($processorInstallmentRatePerYear instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorInstallmentRatePerYear = $processorInstallmentRatePerYear;
		}
		else {
			throw new BadMethodCallException("Type of argument processorInstallmentRatePerYear must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorVoucherRemainingAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType
	 */
	public function getProcessorVoucherRemainingAmount(){
		return $this->processorVoucherRemainingAmount;
	}
	
	/**
	 * Sets the value for the property processorVoucherRemainingAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType $processorVoucherRemainingAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorVoucherRemainingAmount($processorVoucherRemainingAmount){
		if ($processorVoucherRemainingAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType) {
			$this->processorVoucherRemainingAmount = $processorVoucherRemainingAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument processorVoucherRemainingAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property processorVoucherType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorVoucherType(){
		return $this->processorVoucherType;
	}
	
	/**
	 * Sets the value for the property processorVoucherType.
	 * 
	 * @param string $processorVoucherType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setProcessorVoucherType($processorVoucherType){
		if ($processorVoucherType instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorVoucherType = $processorVoucherType;
		}
		else {
			$this->processorVoucherType = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorVoucherType);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property referencedTDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getReferencedTDate(){
		return $this->referencedTDate;
	}
	
	/**
	 * Sets the value for the property referencedTDate.
	 * 
	 * @param string $referencedTDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setReferencedTDate($referencedTDate){
		if ($referencedTDate instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->referencedTDate = $referencedTDate;
		}
		else {
			$this->referencedTDate = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($referencedTDate);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTDate(){
		return $this->tDate;
	}
	
	/**
	 * Sets the value for the property tDate.
	 * 
	 * @param string $tDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setTDate($tDate){
		if ($tDate instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->tDate = $tDate;
		}
		else {
			$this->tDate = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($tDate);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property tDateFormatted.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTDateFormatted(){
		return $this->tDateFormatted;
	}
	
	/**
	 * Sets the value for the property tDateFormatted.
	 * 
	 * @param string $tDateFormatted
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setTDateFormatted($tDateFormatted){
		if ($tDateFormatted instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->tDateFormatted = $tDateFormatted;
		}
		else {
			$this->tDateFormatted = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($tDateFormatted);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property terminalID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTerminalID(){
		return $this->terminalID;
	}
	
	/**
	 * Sets the value for the property terminalID.
	 * 
	 * @param string $terminalID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setTerminalID($terminalID){
		if ($terminalID instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->terminalID = $terminalID;
		}
		else {
			$this->terminalID = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($terminalID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property transactionResult.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTransactionResult(){
		return $this->transactionResult;
	}
	
	/**
	 * Sets the value for the property transactionResult.
	 * 
	 * @param string $transactionResult
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setTransactionResult($transactionResult){
		if ($transactionResult instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->transactionResult = $transactionResult;
		}
		else {
			$this->transactionResult = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($transactionResult);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property transactionTime.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTransactionTime(){
		return $this->transactionTime;
	}
	
	/**
	 * Sets the value for the property transactionTime.
	 * 
	 * @param string $transactionTime
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setTransactionTime($transactionTime){
		if ($transactionTime instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->transactionTime = $transactionTime;
		}
		else {
			$this->transactionTime = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($transactionTime);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property eMVCardPresentResponse.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse
	 */
	public function getEMVCardPresentResponse(){
		return $this->eMVCardPresentResponse;
	}
	
	/**
	 * Sets the value for the property eMVCardPresentResponse.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse $eMVCardPresentResponse
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function setEMVCardPresentResponse($eMVCardPresentResponse){
		if ($eMVCardPresentResponse instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse) {
			$this->eMVCardPresentResponse = $eMVCardPresentResponse;
		}
		else {
			throw new BadMethodCallException("Type of argument eMVCardPresentResponse must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_EMVCardPresentResponse.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
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
	
	
	
}