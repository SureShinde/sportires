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
 * details of a single order item
 * 
 * @XmlType(name="OrderDetailItem", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem {
	/**
	 * @XmlElement(name="itemType", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType
	 */
	private $itemType;
	
	/**
	 * @XmlElement(name="description", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText
	 */
	private $description;
	
	/**
	 * @XmlElement(name="quantity", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity
	 */
	private $quantity;
	
	/**
	 * @XmlElement(name="unitPrice", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money
	 */
	private $unitPrice;
	
	/**
	 * @XmlElement(name="totalPrice", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money
	 */
	private $totalPrice;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem();
		return $i;
	}
	/**
	 * Defines a type for an order detail item, which affects its rendering on the Checkout page.
	 *           TEXT ... A simple line of text is rendered. Other fields are ignored.
	 *           ITEM ... Table row with text, quantity, unit-price and total price is rendered.
	 *           SUBTOTAL ... Table row with text and total price is rendered in subtotal format.
	 *           VAT ... Table row with text and total price is rendered in VAT format.
	 *           TOTAL ... Table row with text and total price is rendered in total format.
	 * 
	 * Returns the value for the property itemType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType
	 */
	public function getItemType(){
		return $this->itemType;
	}
	
	/**
	 * Defines a type for an order detail item, which affects its rendering on the Checkout page.
	 *           TEXT ... A simple line of text is rendered. Other fields are ignored.
	 *           ITEM ... Table row with text, quantity, unit-price and total price is rendered.
	 *           SUBTOTAL ... Table row with text and total price is rendered in subtotal format.
	 *           VAT ... Table row with text and total price is rendered in VAT format.
	 *           TOTAL ... Table row with text and total price is rendered in total format.
	 * 
	 * Sets the value for the property itemType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType $itemType
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem
	 */
	public function setItemType($itemType){
		if ($itemType instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType) {
			$this->itemType = $itemType;
		}
		else {
			throw new BadMethodCallException("Type of argument itemType must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType.");
		}
		return $this;
	}
	
	
	/**
	 * text describing an order
	 * 
	 * Returns the value for the property description.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * text describing an order
	 * 
	 * Sets the value for the property description.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText $description
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem
	 */
	public function setDescription($description){
		if ($description instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText) {
			$this->description = $description;
		}
		else {
			throw new BadMethodCallException("Type of argument description must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText.");
		}
		return $this;
	}
	
	
	/**
	 * quantity of items
	 * 
	 * Returns the value for the property quantity.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity
	 */
	public function getQuantity(){
		return $this->quantity;
	}
	
	/**
	 * quantity of items
	 * 
	 * Sets the value for the property quantity.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity $quantity
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem
	 */
	public function setQuantity($quantity){
		if ($quantity instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity) {
			$this->quantity = $quantity;
		}
		else {
			throw new BadMethodCallException("Type of argument quantity must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity.");
		}
		return $this;
	}
	
	
	/**
	 * price of a unit
	 * 
	 * Returns the value for the property unitPrice.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money
	 */
	public function getUnitPrice(){
		return $this->unitPrice;
	}
	
	/**
	 * price of a unit
	 * 
	 * Sets the value for the property unitPrice.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money $unitPrice
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem
	 */
	public function setUnitPrice($unitPrice){
		if ($unitPrice instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money) {
			$this->unitPrice = $unitPrice;
		}
		else {
			throw new BadMethodCallException("Type of argument unitPrice must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money.");
		}
		return $this;
	}
	
	
	/**
	 * total price
	 * 
	 * Returns the value for the property totalPrice.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money
	 */
	public function getTotalPrice(){
		return $this->totalPrice;
	}
	
	/**
	 * total price
	 * 
	 * Sets the value for the property totalPrice.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money $totalPrice
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem
	 */
	public function setTotalPrice($totalPrice){
		if ($totalPrice instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money) {
			$this->totalPrice = $totalPrice;
		}
		else {
			throw new BadMethodCallException("Type of argument totalPrice must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money.");
		}
		return $this;
	}
	
	
	
}