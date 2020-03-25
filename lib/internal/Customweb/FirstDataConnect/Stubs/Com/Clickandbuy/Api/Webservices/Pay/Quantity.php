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
 * quantity of items
 * 
 * @XmlType(name="Quantity", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity extends Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Integer {
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Quantity();
		return $i;
	}
	
}