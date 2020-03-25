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


class Customweb_Xml_Binding_Encoder extends Customweb_Xml_Binding_AbstractCodec {
	
	/**
	 *
	 * @var boolean
	 */
	private $appendingXmlSchemaInstanceTypesActive = false;
	
	/**
	 *
	 * @var Customweb_Xml_Namespace[]
	 */
	private $namespacesByPrefix = array();
	
	/**
	 *
	 * @var Customweb_Xml_Namespace[]
	 */
	private $namespacesByUri = array();

	/**
	 * This method returns an XML representation (as string) of the given object.
	 * In case you need
	 * a DOM tree of it see the method encodeToDom().
	 *
	 * @param object $object
	 * @return string
	 */
	public function encode($object){
		$dom = new DOMDocument();
		$this->encodeToDom($object, $dom);
		return $dom->saveXML();
	}

	/**
	 * This method attaches the given object to the given DOM node.
	 * It is important that
	 * the given DOMNode is part of a document. Otherwise no new element can be created and
	 * attached to the DOMNode.
	 *
	 * @param object $object
	 * @param DOMNode $dom
	 * @return void
	 */
	public function encodeToDom($object, DOMNode $dom){
		if ($object === null) {
			throw new Exception("A null object can not be encoded to XML.");
		}
		
		return $this->process($object, new Customweb_Xml_Binding_Reflection_Class(get_class($object)), $dom);
	}

	public function isAppendingXmlSchemaInstanceTypesActive(){
		return $this->appendingXmlSchemaInstanceTypesActive;
	}

	public function setAppendingXmlSchemaInstanceTypesActive($active = true){
		if ($active) {
			$this->appendingXmlSchemaInstanceTypesActive = true;
		}
		else {
			$this->appendingXmlSchemaInstanceTypesActive = false;
		}
		return $this;
	}

	private function process($item, Customweb_Xml_Binding_Reflection_IItem $reflector, DOMNode $dom){
		if ($item instanceof Customweb_Xml_Nil) {
			$this->processNil($item, $reflector, $dom);
		}
		else {
			if ($reflector instanceof Customweb_Xml_Binding_Reflection_Class) {
				$dom = $this->createElement($reflector->getName(), $reflector->getNamespaceUri(), $dom, $reflector);
				$this->processComplexType($item, $reflector, $dom);
			}
			
			$simpleType = $this->isItemSimpleType($item);
			if ($simpleType) {
				$this->processSimpleType($item, $reflector, $dom);
			}
		}
	}

	private function processNil($item, Customweb_Xml_Binding_Reflection_IItem $reflector, DOMElement $dom){
		if (!$reflector->isNillable()) {
			throw new Exception("Can only set nil on item, which is nillable.");
		}
		$dom->setAttribute('xsi:nil', 'true');
	}

	private function processArray($values, Customweb_Xml_Binding_Reflection_Property $reflector, DOMNode $dom){
		$name = $reflector->getName();
		$namespaceURI = $reflector->getNamespaceUri();
		foreach ($values as $value) {
			$child = $this->createElement($name, $namespaceURI, $dom, $reflector);
			if ($value instanceof Customweb_Xml_Nil) {
				$this->processNil($value, $reflector, $child);
			}
			else {
				if ($this->isItemSimpleType($value)) {
					$this->processSimpleType($value, $reflector, $child);
				}
				
				if (is_object($value)) {
					$this->processComplexType($value, new Customweb_Xml_Binding_Reflection_Class(get_class($value)), $child);
				}
			}
		}
	}

	private function processProperty($value, Customweb_Xml_Binding_Reflection_Property $reflector, DOMNode $dom){
		if ($value !== null) {
			$namespaceUri = $reflector->getNamespaceUri();
			if ($reflector->isValue() || $reflector->isElement()) {
				$dom = $this->createElement($reflector->getName(), $namespaceUri, $dom, $reflector);
			}
			else if ($reflector->isAttribute()) {
				$dom = $this->createAttribute($reflector->getName(), $namespaceUri, $dom);
			}
			
			if ($value instanceof Customweb_Xml_Nil) {
				$this->processNil($value, $reflector, $dom);
			}
			else {
				if ($this->isItemSimpleType($value)) {
					$this->processSimpleType($value, $reflector, $dom);
				}
				
				if ($reflector->isArray()) {
					$this->processArray($value, $reflector, $dom);
				}
				else if (is_object($value)) {
					$this->processComplexProperty($value, $reflector, $dom);
				}
			}
		}
	}

	/**
	 * Processes a complex type property.<br>
	 * This method also attempts to solve the problem in polymorphism by adding the ''type'' attribute to the property if, and only if, such a case is detected.
	 * This attribute is optional and not prohibited by the XML specifications in any way, therefore this should not induce any problems.
	 *
	 * @param mixed $value
	 * @param Customweb_Xml_Binding_Reflection_Property $propertyReflector
	 * @param DOMNode $dom
	 */
	private function processComplexProperty($value, $propertyReflector, $dom){
		$typeReflector = new Customweb_Xml_Binding_Reflection_Class(get_class($value));
		if ($typeReflector->getItemPhpClasName() != $propertyReflector->getItemPhpClasName()) {
			$this->appendXmlSchemaInstanceType($typeReflector, $dom);
		}
		$this->processComplexType($value, $typeReflector, $dom);
	}

	private function processComplexType($item, Customweb_Xml_Binding_Reflection_Class $reflector, $dom){
		$class = $reflector->getReflector();
		$hierarchy = array();
		
		while (!empty($class)) {
			$hierarchy[] = $class->getName();
			$class = $class->getParentClass();
		}
		$hierarchy = array_reverse($hierarchy);
		
		$sortedProperties = array();
		$properties = $reflector->getProperties();
		
		foreach ($hierarchy as $className) {
			foreach ($properties as $key => $property) {
				if ($property->isProcessable()) {
					$class = $property->getReflector();
					if ($class->getClassName() == $className) {
						$sortedProperties[] = $property;
						unset($properties[$key]);
					}
				}
				else {
					unset($properties[$key]);
				}
			}
		}
		
		foreach ($sortedProperties as $property) {
			$this->processProperty($property->getValue($item), $property, $dom);
		}
	}

	private function processSimpleType($item, Customweb_Xml_Binding_Reflection_IItem $reflector, DOMNode $dom){
		$value = $this->convertToXmlValue($reflector->getItemPhpClasName(), $item);
		
		// When the value is empty, and their are sub elements, we have to assume that we gone override something, we 
		// definitely do not want. Hence we do not write the value.
		if (empty($value)) {
			foreach ($dom->childNodes as $child) {
				if ($child instanceof DOMElement) {
					return;
				}
			}
		}
		
		if ($value !== null) {
			$dom->nodeValue = $value;
		}
	}

	private function createElement($name, $namespaceURI, DOMNode $dom, Customweb_Xml_Binding_Reflection_IItem $reflector, $value = null){
		$doc = $this->extractOwnerDocument($dom);
		
		if (!empty($namespaceURI)) {
			$prefix = $this->getNamespacePrefix($namespaceURI, $dom);
			$child = $doc->createElementNS($namespaceURI, $prefix . ':' . $name, $value);
		}
		else {
			$child = $doc->createElement($name, $value);
		}
		$dom->appendChild($child);
		
		// Add the xsi:type attribute if required.
		if ($this->isAppendingXmlSchemaInstanceTypesActive()) {
			$this->appendXmlSchemaInstanceTypeFromNode($reflector, $dom, $child);
		}
		
		return $child;
	}

	/**
	 * Adds the attribute ''type'' to the given node.
	 *
	 * @param Customweb_Xml_Binding_Reflection_IItem $reflector
	 * @param DOMNode $dom
	 */
	private function appendXmlSchemaInstanceType(Customweb_Xml_Binding_Reflection_IItem $reflector, DOMNode $dom){
		$this->appendXmlSchemaInstanceTypeFromNode($reflector, $dom, $dom);
	}

	/**
	 * Adds the attribute ''type'' to the heir node, while resolving its namespace prefix from the original node.
	 *
	 * @param Customweb_Xml_Binding_Reflection_IItem $reflector
	 * @param DOMNode $origin
	 * @param DOMNode $heir
	 */
	private function appendXmlSchemaInstanceTypeFromNode(Customweb_Xml_Binding_Reflection_IItem $reflector, DOMNode $origin, DOMNode $heir){
		$type = $reflector->getXmlType();
		$namespaceUri = $type->getNamespaceUri();
		if (!empty($namespaceUri)) {
			$prefix = $origin->lookupPrefix($namespaceUri);
			// Since we do not add here any element / attribute with the given namespace, it is not automatically added. Hence
			// we may need to add the namespace manually.
			if (empty($prefix) && !isset($this->namespacesByUri[strtolower($namespaceUri)])) {
				$prefix = $this->getNamespacePrefix($namespaceUri, $origin);
				$doc = $this->extractOwnerDocument($origin);
				$doc->documentElement->setAttribute("xmlns:" . $prefix, $namespaceUri);
			}
			$prefix = $this->getNamespacePrefix($namespaceUri, $origin);
			$this->createAttribute('type', self::XML_SCHEMA_INSTANCE_NAMESPACE, $heir, $prefix . ':' . $type->getName());
		}
	}

	private function createAttribute($name, $namespaceURI, DOMNode $dom, $value = null){
		if (!($dom instanceof DOMElement)) {
			throw new Customweb_Core_Exception_CastException('DOMElement');
		}
		if (!empty($namespaceURI)) {
			$prefix = $this->getNamespacePrefix($namespaceURI, $dom);
			$dom->setAttributeNS($namespaceURI, $prefix . ':' . $name, $value);
			return $dom->getAttributeNode($prefix . ':' . $name);
		}
		else {
			return $dom->setAttribute($name, $value);
		}
	}

	/**
	 *
	 * @param DOMNode $dom
	 * @throws Exception
	 * @return DOMDocument
	 */
	private function extractOwnerDocument(DOMNode $dom){
		if ($dom instanceof DOMDocument) {
			return $dom;
		}
		else {
			if (!($dom->ownerDocument instanceof DOMDocument)) {
				throw new Exception("Unable to extract the owner document.");
			}
			return $dom->ownerDocument;
		}
	}

	private function addNamespace(Customweb_Xml_Namespace $namespace){
		$this->namespacesByPrefix[strtolower($namespace->getPrefix())] = $namespace;
		$this->namespacesByUri[$namespace->getKey()] = $namespace;
	}

	private function getNamespacePrefix($uri, DOMNode $dom){
		$key = strtolower($uri);
		if (!isset($this->namespacesByUri[$key])) {
			$prefix = $dom->lookupPrefix($uri);
			if (empty($prefix)) {
				$prefix = $this->findNextFreeNamespacePrefix();
			}
			$this->addNamespace(new Customweb_Xml_Namespace($uri, $prefix));
		}
		
		$namespace = $this->namespacesByUri[$key];
		return $namespace->getPrefix();
	}

	private function getNamespaceUri($prefix, DOMNode $dom){
		$key = strtolower($prefix);
		if (!isset($this->namespacesByPrefix[$key])) {
			$uri = $dom->lookupNamespaceUri($prefix);
			if (empty($uri)) {
				throw new Exception(
						Customweb_Core_String::_("Unable to resolve name space prefix '@prefix' to URI.")->format(
								array(
									'@prefix' => $prefix 
								)));
			}
			$this->addNamespace(new Customweb_Xml_Namespace($uri, $prefix));
		}
		
		$namespace = $this->namespacesByPrefix[$key];
		return $namespace->getUri();
	}

	private function findNextFreeNamespacePrefix($increment = 1){
		$prefix = 'ns' . $increment;
		if (!isset($this->namespacesByPrefix[$prefix])) {
			return $prefix;
		}
		else {
			return $this->findNextFreeNamespacePrefix($increment + 1);
		}
	}

	private function isItemSimpleType($item){
		if ($item instanceof Customweb_Xml_ISimpleType || $item instanceof Customweb_Xml_Binding_DateHandler_IDateFormatable) {
			return true;
		}
		else if (is_object($item)) {
			return false;
		}
		else {
			return true;
		}
	}

	private function convertToXmlValue($nativeClassName, $item){
		if ($this->isItemSimpleType($item)) {
			$item = $this->convertToNativeType($nativeClassName, $item);
			
			if ($item === true) {
				return 'true';
			}
			
			if ($item === false) {
				return 'false';
			}
			
			if ($item instanceof Customweb_Xml_Binding_DateHandler_IDateFormatable) {
				return $item->formatForXml();
			}
			
			$item = (string) $item;
			
			return Customweb_Core_Util_Xml::escape($item);
		}
		else {
			throw new Exception("Convert to XML value only possible with simple type.");
		}
	}
}