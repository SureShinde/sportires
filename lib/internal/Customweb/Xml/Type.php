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




final class Customweb_Xml_Type {
	
	private $name;
	
	private $namespaceUri;
	
	private static $instances = array();
	
	private function __construct($name, $namespaceUri) {
		$this->name = $name;
		$this->namespaceUri = $namespaceUri;
	}
	
	/**
	 * @param string $name
	 * @param string $namespaceUri
	 * @return Customweb_Xml_Type
	 */
	public static function _($name, $namespaceUri) {
		$key = strtolower($name . '___' . $namespaceUri);
		if (!(isset(self::$instances[$key]))) {
			self::$instances[$key] = new Customweb_Xml_Type($name, $namespaceUri);
		}
		return self::$instances[$key];
	}

	public function getName(){
		return $this->name;
	}

	public function getNamespaceUri(){
		return $this->namespaceUri;
	}
	
	
	
}