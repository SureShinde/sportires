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
 * @XmlType(name="IPGApiActionResponse", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse {
	/**
	 * @XmlValue(name="successfully", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var boolean
	 */
	private $successfully;
	
	/**
	 * @XmlValue(name="OrderId", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $orderId;
	
	/**
	 * @XmlElement(name="TransactionId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max
	 */
	private $transactionId;
	
	/**
	 * @XmlElement(name="Error", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error
	 */
	private $error;
	
	/**
	 * @XmlElement(name="ResultInfo", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ResultInfoType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ResultInfoType
	 */
	private $resultInfo;
	
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
	 * @XmlElement(name="Product", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	private $product;
	
	/**
	 * @XmlElement(name="ProductStock", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductStock", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductStock
	 */
	private $productStock;
	
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
	
	/**
	 * @XmlElement(name="RecurringPaymentInformation", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	private $recurringPaymentInformation;
	
	/**
	 * @XmlList(name="DataStorageItem", type='Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_DataStorageItem', namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_DataStorageItem[]
	 */
	private $dataStorageItem;
	
	/**
	 * @XmlValue(name="ProcessorResponseCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorResponseCode;
	
	/**
	 * @XmlValue(name="ProcessorRequestMessage", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorRequestMessage;
	
	/**
	 * @XmlValue(name="ProcessorResponseMessage", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var string
	 */
	private $processorResponseMessage;
	
	/**
	 * @XmlList(name="OrderValues", type='Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType', namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType[]
	 */
	private $orderValues;
	
	/**
	 * @XmlElement(name="CardRateForDCC", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	private $cardRateForDCC;
	
	/**
	 * @XmlElement(name="MerchantRateForDynamicPricing", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	private $merchantRateForDynamicPricing;
	
	public function __construct() {
		$this->dataStorageItem = new ArrayObject();
		$this->orderValues = new ArrayObject();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse();
		return $i;
	}
	/**
	 * Returns the value for the property successfully.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getSuccessfully(){
		return $this->successfully;
	}
	
	/**
	 * Sets the value for the property successfully.
	 * 
	 * @param boolean $successfully
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setSuccessfully($successfully){
		if ($successfully instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->successfully = $successfully;
		}
		else {
			$this->successfully = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean::_()->set($successfully);
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
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
	 * Returns the value for the property transactionId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max
	 */
	public function getTransactionId(){
		return $this->transactionId;
	}
	
	/**
	 * Sets the value for the property transactionId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max $transactionId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setTransactionId($transactionId){
		if ($transactionId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max) {
			$this->transactionId = $transactionId;
		}
		else {
			throw new BadMethodCallException("Type of argument transactionId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PositiveNumeric14max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property error.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error
	 */
	public function getError(){
		return $this->error;
	}
	
	/**
	 * Sets the value for the property error.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error $error
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setError($error){
		if ($error instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error) {
			$this->error = $error;
		}
		else {
			throw new BadMethodCallException("Type of argument error must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property resultInfo.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ResultInfoType
	 */
	public function getResultInfo(){
		return $this->resultInfo;
	}
	
	/**
	 * Sets the value for the property resultInfo.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ResultInfoType $resultInfo
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setResultInfo($resultInfo){
		if ($resultInfo instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ResultInfoType) {
			$this->resultInfo = $resultInfo;
		}
		else {
			throw new BadMethodCallException("Type of argument resultInfo must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ResultInfoType.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
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
	 * Returns the value for the property product.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	public function getProduct(){
		return $this->product;
	}
	
	/**
	 * Sets the value for the property product.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product $product
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setProduct($product){
		if ($product instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product) {
			$this->product = $product;
		}
		else {
			throw new BadMethodCallException("Type of argument product must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property productStock.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductStock
	 */
	public function getProductStock(){
		return $this->productStock;
	}
	
	/**
	 * Sets the value for the property productStock.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductStock $productStock
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setProductStock($productStock){
		if ($productStock instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductStock) {
			$this->productStock = $productStock;
		}
		else {
			throw new BadMethodCallException("Type of argument productStock must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductStock.");
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
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
	
	
	/**
	 * Returns the value for the property recurringPaymentInformation.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues
	 */
	public function getRecurringPaymentInformation(){
		return $this->recurringPaymentInformation;
	}
	
	/**
	 * Sets the value for the property recurringPaymentInformation.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues $recurringPaymentInformation
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setRecurringPaymentInformation($recurringPaymentInformation){
		if ($recurringPaymentInformation instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues) {
			$this->recurringPaymentInformation = $recurringPaymentInformation;
		}
		else {
			throw new BadMethodCallException("Type of argument recurringPaymentInformation must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentValues.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dataStorageItem.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_DataStorageItem[]
	 */
	public function getDataStorageItem(){
		return $this->dataStorageItem;
	}
	
	/**
	 * Sets the value for the property dataStorageItem.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_DataStorageItem $dataStorageItem
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setDataStorageItem($dataStorageItem){
		if (is_array($dataStorageItem)) {
			$dataStorageItem = new ArrayObject($dataStorageItem);
		}
		if ($dataStorageItem instanceof ArrayObject) {
			$this->dataStorageItem = $dataStorageItem;
		}
		else {
			throw new BadMethodCallException("Type of argument dataStorageItem must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of dataStorageItem.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_DataStorageItem $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function addDataStorageItem(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_DataStorageItem $item) {
		if (!($this->dataStorageItem instanceof ArrayObject)) {
			$this->dataStorageItem = new ArrayObject();
		}
		$this->dataStorageItem[] = $item;
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
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
	 * Returns the value for the property processorRequestMessage.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getProcessorRequestMessage(){
		return $this->processorRequestMessage;
	}
	
	/**
	 * Sets the value for the property processorRequestMessage.
	 * 
	 * @param string $processorRequestMessage
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setProcessorRequestMessage($processorRequestMessage){
		if ($processorRequestMessage instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->processorRequestMessage = $processorRequestMessage;
		}
		else {
			$this->processorRequestMessage = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($processorRequestMessage);
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
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
	 * Returns the value for the property orderValues.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType[]
	 */
	public function getOrderValues(){
		return $this->orderValues;
	}
	
	/**
	 * Sets the value for the property orderValues.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType $orderValues
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setOrderValues($orderValues){
		if (is_array($orderValues)) {
			$orderValues = new ArrayObject($orderValues);
		}
		if ($orderValues instanceof ArrayObject) {
			$this->orderValues = $orderValues;
		}
		else {
			throw new BadMethodCallException("Type of argument orderValues must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of orderValues.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function addOrderValues(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_OrderValueType $item) {
		if (!($this->orderValues instanceof ArrayObject)) {
			$this->orderValues = new ArrayObject();
		}
		$this->orderValues[] = $item;
		return $this;
	}
	
	/**
	 * Returns the value for the property cardRateForDCC.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function getCardRateForDCC(){
		return $this->cardRateForDCC;
	}
	
	/**
	 * Sets the value for the property cardRateForDCC.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType $cardRateForDCC
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setCardRateForDCC($cardRateForDCC){
		if ($cardRateForDCC instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType) {
			$this->cardRateForDCC = $cardRateForDCC;
		}
		else {
			throw new BadMethodCallException("Type of argument cardRateForDCC must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property merchantRateForDynamicPricing.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType
	 */
	public function getMerchantRateForDynamicPricing(){
		return $this->merchantRateForDynamicPricing;
	}
	
	/**
	 * Sets the value for the property merchantRateForDynamicPricing.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType $merchantRateForDynamicPricing
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiActionResponse
	 */
	public function setMerchantRateForDynamicPricing($merchantRateForDynamicPricing){
		if ($merchantRateForDynamicPricing instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType) {
			$this->merchantRateForDynamicPricing = $merchantRateForDynamicPricing;
		}
		else {
			throw new BadMethodCallException("Type of argument merchantRateForDynamicPricing must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_InquiryRateType.");
		}
		return $this;
	}
	
	
	
}