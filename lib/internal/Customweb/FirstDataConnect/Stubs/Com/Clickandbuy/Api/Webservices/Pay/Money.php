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
 * amount and currency
 * 
 * @XmlType(name="Money", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money {
	/**
	 * @XmlElement(name="amount", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Amount", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Amount
	 */
	private $amount;
	
	/**
	 * @XmlElement(name="currency", type="Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Currency", namespace="http://api.clickandbuy.com/webservices/pay_1_0_0/")
	 * @var Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Currency
	 */
	private $currency;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money();
		return $i;
	}
	/**
	 * the amount of the purchase
	 * 
	 * Returns the value for the property amount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Amount
	 */
	public function getAmount(){
		return $this->amount;
	}
	
	/**
	 * the amount of the purchase
	 * 
	 * Sets the value for the property amount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Amount $amount
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money
	 */
	public function setAmount($amount){
		if ($amount instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Amount) {
			$this->amount = $amount;
		}
		else {
			throw new BadMethodCallException("Type of argument amount must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Amount.");
		}
		return $this;
	}
	
	
	/**
	 * the currency of the purchase
	 * 
	 * Returns the value for the property currency.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Currency
	 */
	public function getCurrency(){
		return $this->currency;
	}
	
	/**
	 * the currency of the purchase
	 * 
	 * Sets the value for the property currency.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Currency $currency
	 * @return Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Money
	 */
	public function setCurrency($currency){
		if ($currency instanceof Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Currency) {
			$this->currency = $currency;
		}
		else {
			throw new BadMethodCallException("Type of argument currency must be Customweb_FirstDataConnect_Stubs_Com_Clickandbuy_Api_Webservices_Pay_Currency.");
		}
		return $this;
	}
	
	
	
}