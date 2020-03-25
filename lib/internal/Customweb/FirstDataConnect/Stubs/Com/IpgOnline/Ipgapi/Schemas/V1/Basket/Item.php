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
 * @XmlType(name="Item", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item {
	/**
	 * @XmlElement(name="ID", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	private $iD;
	
	/**
	 * @XmlElement(name="Description", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	private $description;
	
	/**
	 * @XmlElement(name="SubTotal", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType
	 */
	private $subTotal;
	
	/**
	 * @XmlElement(name="ValueAddedTax", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType
	 */
	private $valueAddedTax;
	
	/**
	 * @XmlElement(name="DeliveryAmount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType
	 */
	private $deliveryAmount;
	
	/**
	 * @XmlElement(name="ChargeTotal", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType
	 */
	private $chargeTotal;
	
	/**
	 * @XmlElement(name="Currency", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType
	 */
	private $currency;
	
	/**
	 * @XmlValue(name="Quantity", simpleType=@XmlSimpleTypeDefinition(typeName='int', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer'), namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var integer
	 */
	private $quantity;
	
	/**
	 * @XmlList(name="Option", type='Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item_Option', namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item_Option[]
	 */
	private $option;
	
	public function __construct() {
		$this->option = new ArrayObject();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item();
		return $i;
	}
	/**
	 * Returns the value for the property iD.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	public function getID(){
		return $this->iD;
	}
	
	/**
	 * Sets the value for the property iD.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max $iD
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function setID($iD){
		if ($iD instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max) {
			$this->iD = $iD;
		}
		else {
			throw new BadMethodCallException("Type of argument iD must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property description.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * Sets the value for the property description.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max $description
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function setDescription($description){
		if ($description instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max) {
			$this->description = $description;
		}
		else {
			throw new BadMethodCallException("Type of argument description must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property subTotal.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType
	 */
	public function getSubTotal(){
		return $this->subTotal;
	}
	
	/**
	 * Sets the value for the property subTotal.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType $subTotal
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function setSubTotal($subTotal){
		if ($subTotal instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType) {
			$this->subTotal = $subTotal;
		}
		else {
			throw new BadMethodCallException("Type of argument subTotal must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property valueAddedTax.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType
	 */
	public function getValueAddedTax(){
		return $this->valueAddedTax;
	}
	
	/**
	 * Sets the value for the property valueAddedTax.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType $valueAddedTax
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function setValueAddedTax($valueAddedTax){
		if ($valueAddedTax instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType) {
			$this->valueAddedTax = $valueAddedTax;
		}
		else {
			throw new BadMethodCallException("Type of argument valueAddedTax must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property deliveryAmount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType
	 */
	public function getDeliveryAmount(){
		return $this->deliveryAmount;
	}
	
	/**
	 * Sets the value for the property deliveryAmount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType $deliveryAmount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function setDeliveryAmount($deliveryAmount){
		if ($deliveryAmount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType) {
			$this->deliveryAmount = $deliveryAmount;
		}
		else {
			throw new BadMethodCallException("Type of argument deliveryAmount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property chargeTotal.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType
	 */
	public function getChargeTotal(){
		return $this->chargeTotal;
	}
	
	/**
	 * Sets the value for the property chargeTotal.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType $chargeTotal
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function setChargeTotal($chargeTotal){
		if ($chargeTotal instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType) {
			$this->chargeTotal = $chargeTotal;
		}
		else {
			throw new BadMethodCallException("Type of argument chargeTotal must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType.");
		}
		return $this;
	}
	
	
	/**
	 * Currency will be ignored by IPG
	 * 
	 * Returns the value for the property currency.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType
	 */
	public function getCurrency(){
		return $this->currency;
	}
	
	/**
	 * Currency will be ignored by IPG
	 * 
	 * Sets the value for the property currency.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType $currency
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
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
	 * Returns the value for the property quantity.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer
	 */
	public function getQuantity(){
		return $this->quantity;
	}
	
	/**
	 * Sets the value for the property quantity.
	 * 
	 * @param integer $quantity
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function setQuantity($quantity){
		if ($quantity instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer) {
			$this->quantity = $quantity;
		}
		else {
			$this->quantity = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer::_()->set($quantity);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property option.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item_Option[]
	 */
	public function getOption(){
		return $this->option;
	}
	
	/**
	 * Sets the value for the property option.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item_Option $option
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function setOption($option){
		if (is_array($option)) {
			$option = new ArrayObject($option);
		}
		if ($option instanceof ArrayObject) {
			$this->option = $option;
		}
		else {
			throw new BadMethodCallException("Type of argument option must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of option.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item_Option $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item
	 */
	public function addOption(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item_Option $item) {
		if (!($this->option instanceof ArrayObject)) {
			$this->option = new ArrayObject();
		}
		$this->option[] = $item;
		return $this;
	}
	
	
}