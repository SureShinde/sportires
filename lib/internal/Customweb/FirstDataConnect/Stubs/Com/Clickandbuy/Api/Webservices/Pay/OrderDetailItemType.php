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
 * Defines a type for an order detail item, which affects its rendering on the Checkout page.
 *       TEXT ... A simple line of text is rendered. Other fields are ignored.
 *       ITEM ... Table row with text, quantity, unit-price and total price is rendered.
 *       SUBTOTAL ... Table row with text and total price is rendered in subtotal format.
 *       VAT ... Table row with text and total price is rendered in VAT format.
 *       TOTAL ... Table row with text and total price is rendered in total format.
 * 
 * @XmlType(name="OrderDetailItemType", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType extends Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String {
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType
	 */
	public static function TEXT() {
		return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType::_()->set('TEXT');
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType
	 */
	public static function ITEM() {
		return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType::_()->set('ITEM');
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType
	 */
	public static function SUBTOTAL() {
		return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType::_()->set('SUBTOTAL');
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType
	 */
	public static function VAT() {
		return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType::_()->set('VAT');
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType
	 */
	public static function TOTAL() {
		return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType::_()->set('TOTAL');
	}
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_OrderDetailItemType();
		return $i;
	}
	
}