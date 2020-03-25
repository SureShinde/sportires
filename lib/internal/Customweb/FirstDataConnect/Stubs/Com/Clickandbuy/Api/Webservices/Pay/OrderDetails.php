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
 * structure defining the order detail, as text and/or an item-list
 * 
 * @XmlType(name="OrderDetails", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails {
	/**
	 * @XmlElement(name="text", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText
	 */
	private $text;
	
	/**
	 * @XmlElement(name="itemList", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList
	 */
	private $itemList;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails();
		return $i;
	}
	/**
	 * text description of the order
	 * 
	 * Returns the value for the property text.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText
	 */
	public function getText(){
		return $this->text;
	}
	
	/**
	 * text description of the order
	 * 
	 * Sets the value for the property text.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText $text
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails
	 */
	public function setText($text){
		if ($text instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText) {
			$this->text = $text;
		}
		else {
			throw new BadMethodCallException("Type of argument text must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailText.");
		}
		return $this;
	}
	
	
	/**
	 * list of order items (at most 128 items)
	 * 
	 * Returns the value for the property itemList.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList
	 */
	public function getItemList(){
		return $this->itemList;
	}
	
	/**
	 * list of order items (at most 128 items)
	 * 
	 * Sets the value for the property itemList.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList $itemList
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetails
	 */
	public function setItemList($itemList){
		if ($itemList instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList) {
			$this->itemList = $itemList;
		}
		else {
			throw new BadMethodCallException("Type of argument itemList must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList.");
		}
		return $this;
	}
	
	
	
}