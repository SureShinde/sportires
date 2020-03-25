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
 * @XmlType(name="Basket", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket {
	/**
	 * @XmlElement(name="ProductStock", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_ProductStock", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_ProductStock
	 */
	private $productStock;
	
	/**
	 * @XmlList(name="Item", type='Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item', namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item[]
	 */
	private $item;
	
	public function __construct() {
		$this->item = new ArrayObject();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket();
		return $i;
	}
	/**
	 * Returns the value for the property productStock.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_ProductStock
	 */
	public function getProductStock(){
		return $this->productStock;
	}
	
	/**
	 * Sets the value for the property productStock.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_ProductStock $productStock
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket
	 */
	public function setProductStock($productStock){
		if ($productStock instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_ProductStock) {
			$this->productStock = $productStock;
		}
		else {
			throw new BadMethodCallException("Type of argument productStock must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_ProductStock.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property item.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item[]
	 */
	public function getItem(){
		return $this->item;
	}
	
	/**
	 * Sets the value for the property item.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket
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
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item $item
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket
	 */
	public function addItem(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item $item) {
		if (!($this->item instanceof ArrayObject)) {
			$this->item = new ArrayObject();
		}
		$this->item[] = $item;
		return $this;
	}
	
	
}