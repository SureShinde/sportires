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


final class Customweb_Xml_Binding_Reflection_Class extends Customweb_Xml_Binding_Reflection_AbstractItem {
	
	/**
	 * @var Customweb_Xml_Binding_Reflection_Property
	 */
	private $properties = array();
	
	public function __construct($className) {
		parent::__construct(new Customweb_Annotation_ReflectionAnnotatedClass($className));

		foreach ($this->getReflector()->getPropertiesRecursive() as $reflectionProperty) {
			$property = new Customweb_Xml_Binding_Reflection_Property($reflectionProperty->getDeclaringClassName(), $reflectionProperty->getName());
			if (!isset($this->properties[$property->getPhpName()])) {
				$this->properties[$property->getPhpName()] = $property;
			}
		}

		foreach ($this->getReflector()->getMethodsRecursive() as $reflectionMethod) {
			$start = substr($reflectionMethod->getName(), 0, 3);
			if (strlen($reflectionMethod->getName()) > 3 && ($start == 'get' || $start == 'set')) {
				$property = new Customweb_Xml_Binding_Reflection_Property($reflectionMethod->getDeclaringClassName(), Customweb_Core_Util_String::lcFirst(substr($reflectionMethod->getName(), 3)));
				if (!isset($this->properties[$property->getPhpName()])) {
					$this->properties[$property->getPhpName()] = $property;
				}
			}
		}
		
	}
	
	/**
	 * @return Customweb_Annotation_ReflectionAnnotatedClass
	 */
	public function getReflector() {
		return parent::getReflector();
	}
	
	public function getItemPhpClasName() {
		return $this->getReflector()->name;
	}
	
	public function isSimpleType() {
		if ($this->getReflector()->implementsInterface('Customweb_Xml_ISimpleType')) {
			return true;
		}
		else {
			return false;
		}
	}
	
	
	/**
	 * @return Customweb_Xml_Binding_Reflection_Property[]
	 */
	public function getProperties() {
		return $this->properties;
	}

	public function getName() {
		return $this->getXmlTypeAnnotation()->getName();
	}
	
	public function getNamespaceUri() {
		return $this->getXmlTypeAnnotation()->getNamespace();
	}
	
	public function getXmlType() {
		return Customweb_Xml_Type::_($this->getXmlTypeAnnotation()->getName(), $this->getXmlTypeAnnotation()->getNamespace());
	}
	
	/**
	 * 
	 * @throws Exception
	 * @return Customweb_Xml_Binding_Annotation_XmlType
	 */
	protected function getXmlTypeAnnotation() {
		if ($this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlType')) {
			return $this->getReflector()->getAnnotation('Customweb_Xml_Binding_Annotation_XmlType');
		}
		else {
			throw new Exception(Customweb_Core_String::_("The class '@class' has no XmlType annotation.")->format(array('@class' => $this->getReflector()->getName())));
		}
	}
}