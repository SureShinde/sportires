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
 * @XmlType(name="Product", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product {
	/**
	 * @XmlElement(name="ProductID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max
	 */
	private $productID;
	
	/**
	 * @XmlElement(name="Description", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String4000max", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String4000max
	 */
	private $description;
	
	/**
	 * @XmlValue(name="OfferStarts", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $offerStarts;
	
	/**
	 * @XmlValue(name="OfferEnds", simpleType=@XmlSimpleTypeDefinition(typeName='dateTime', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_Xml_Binding_DateHandler_DateTime
	 */
	private $offerEnds;
	
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
	 * @XmlList(name="Choice", type='Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductChoice', namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductChoice[]
	 */
	private $choice;
	
	public function __construct() {
		$this->choice = new ArrayObject();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product();
		return $i;
	}
	/**
	 * Returns the value for the property productID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max
	 */
	public function getProductID(){
		return $this->productID;
	}
	
	/**
	 * Sets the value for the property productID.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max $productID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	public function setProductID($productID){
		if ($productID instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max) {
			$this->productID = $productID;
		}
		else {
			throw new BadMethodCallException("Type of argument productID must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property description.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String4000max
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * Sets the value for the property description.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String4000max $description
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	public function setDescription($description){
		if ($description instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String4000max) {
			$this->description = $description;
		}
		else {
			throw new BadMethodCallException("Type of argument description must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String4000max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property offerStarts.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getOfferStarts(){
		return $this->offerStarts;
	}
	
	/**
	 * Sets the value for the property offerStarts.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $offerStarts
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	public function setOfferStarts($offerStarts){
		if ($offerStarts instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->offerStarts = $offerStarts;
		}
		else {
			$this->offerStarts = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime::_()->set($offerStarts);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property offerEnds.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime
	 */
	public function getOfferEnds(){
		return $this->offerEnds;
	}
	
	/**
	 * Sets the value for the property offerEnds.
	 * 
	 * @param Customweb_Xml_Binding_DateHandler_DateTime $offerEnds
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	public function setOfferEnds($offerEnds){
		if ($offerEnds instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime) {
			$this->offerEnds = $offerEnds;
		}
		else {
			$this->offerEnds = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_DateTime::_()->set($offerEnds);
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
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
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
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
	 * Returns the value for the property choice.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductChoice[]
	 */
	public function getChoice(){
		return $this->choice;
	}
	
	/**
	 * Sets the value for the property choice.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductChoice $choice
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	public function setChoice($choice){
		if (is_array($choice)) {
			$choice = new ArrayObject($choice);
		}
		if ($choice instanceof ArrayObject) {
			$this->choice = $choice;
		}
		else {
			throw new BadMethodCallException("Type of argument choice must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of choice.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductChoice $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Product
	 */
	public function addChoice(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_ProductChoice $item) {
		if (!($this->choice instanceof ArrayObject)) {
			$this->choice = new ArrayObject();
		}
		$this->choice[] = $item;
		return $this;
	}
	
	
}