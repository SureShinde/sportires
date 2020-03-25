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
 * list of order items (at most 128 items)
 * 
 * @XmlType(name="OrderDetailItemList", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList {
	/**
	 * @XmlList(name="item", type='Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem', namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem[]
	 */
	private $item;
	
	public function __construct() {
		$this->item = new ArrayObject();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList();
		return $i;
	}
	/**
	 * details of a single order item
	 * 
	 * Returns the value for the property item.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem[]
	 */
	public function getItem(){
		return $this->item;
	}
	
	/**
	 * details of a single order item
	 * 
	 * Sets the value for the property item.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList
	 */
	public function setItem($item){
		if (is_array($item)) {
			$item = new ArrayObject($item);
		}
		if ($item instanceof ArrayObject) {
			$this->item = $item;
		}
		else {
			throw new BadMethodCallException("Type of argument item must be ArrayObject.");
		}
		return $this;
	}
	
	/**
	 * Adds the given $item to the list of items of item.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemList
	 */
	public function addItem(Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItem $item) {
		if (!($this->item instanceof ArrayObject)) {
			$this->item = new ArrayObject();
		}
		$this->item[] = $item;
		return $this;
	}
	
	
}