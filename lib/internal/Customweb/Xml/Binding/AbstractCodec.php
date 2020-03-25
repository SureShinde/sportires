<?php

/**
 *  * You are allowed to use this API in your web application.
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



class Customweb_Xml_Binding_AbstractCodec {
	const XML_SCHEMA_NAMESPACE = 'http://www.w3.org/2001/XMLSchema';
	const XML_SCHEMA_INSTANCE_NAMESPACE = 'http://www.w3.org/2001/XMLSchema-instance';
	
	private static $annotationsLoaded = false;
	
	public function __construct() {
		self::laodAnnotations();
		
	}
	
	protected final static function laodAnnotations() {
		if (self::$annotationsLoaded === false) {
			Customweb_Core_Util_Class::loadAllClassesOfPackage('Customweb_Xml_Binding_Annotation');
			self::$annotationsLoaded = true;
		}
	}
	
	/**
	 * Converts the given value to the PHP native type.
	 * 
	 * @param string $className
	 * @param mixed $value
	 * @return mixed
	 */
	protected final function convertToNativeType($nativeClassName, $value) {
		if ($value instanceof Customweb_Xml_ISimpleType) {
			$value = $value->get();
		}
		
		if ($value === null) {
			return null;
		}
		
		Customweb_Core_Util_Class::loadLibraryClassByName($nativeClassName);
	
		$rootClassName = Customweb_Core_Util_Class::getRootClassName($nativeClassName);
		$rootClassReflector = new Customweb_Xml_Binding_Reflection_Class($rootClassName);
	
		if ($rootClassReflector->getNamespaceUri() == self::XML_SCHEMA_NAMESPACE) {
			$name = strtolower($rootClassReflector->getName());
			switch($name) {
				case 'integer':
					
					if (is_object($value)) {
						$value = (string)$value;
					}
					
					return (int)$value;
				case 'string':
					return (string)$value;
				case 'boolean':
					if (is_object($value)) {
						$value = (string)$value;
					}
					
					if (is_bool($value)) {
						return $value;
					}
					else if (is_string($value)) {
						$value = strtolower($value);
						if ($value === 'true') {
							return true;
						}
						else if ($value === 'false'){
							return false;
						}
						
					}
					else {
						return (boolean)$value;
					}
				case 'float':
					if ($value instanceof Customweb_Core_Number) {
						return $value->getFormatedNumber();
					}
					else {
						if (is_object($value)) {
							$value = (string)$value;
						}
						return (float)$value;
					}
				case 'date':
					if ($value instanceof Customweb_Xml_Binding_DateHandler_Date) {
						return $value;
					}
					else {
						return Customweb_Xml_Binding_DateHandler_Date::_($value);
					}
				case 'datetime':
					if ($value instanceof Customweb_Xml_Binding_DateHandler_DateTime) {
						return $value;
					}
					else {
						return Customweb_Xml_Binding_DateHandler_DateTime::_($value);
					}
				default:
					throw new Exception("Unable to convert to native type.");
			}
		}
		else {
			return $value;
		}
	}
	
	
}