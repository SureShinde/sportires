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



interface Customweb_Xml_Binding_Reflection_IItem {

	/**
	 * Returns the name space URI linked with this item.
	 * 
	 * @return string
	 */
	public function getNamespaceUri();
	
	/**
	 * Returns the name of the node (e.g. attribute name, element tag name etc.).
	 *
	 * @return string
	 */
	public function getName();
	
	/**
	 * Returns true, when the node is nil.
	 *
	 * @return boolean
	 */
	public function isNillable();
	
	/**
	 * Returns true, when the given item is transient. Transient means that the item can be
	 * skipped.
	 *
	 * @return boolean
	 */
	public function isTransient();
	
	/**
	 * Returns true, when it is a simple type.
	 * 
	 * @param mixed $item
	 * @return boolean
	 */
	public function isSimpleType();
	
	/**
	 * Returns the PHP class name of the property.
	 *
	 * @throws Exception
	 * @return string
	 */
	public function getItemPhpClasName();
	
	/**
	 * Returns the XML type of the item.
	 * 
	 * @return Customweb_Xml_Type
	 */
	public function getXmlType();
	
}