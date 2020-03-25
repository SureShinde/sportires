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



class Customweb_Xml_Binding_Decoder extends Customweb_Xml_Binding_AbstractCodec {

	public function decode($string, $rootElementClass){
		$dom = new DOMDocument();
		$dom->loadXML($string);
		return $this->decodeFromDom($dom, $rootElementClass);
	}

	public function decodeFromDom(DOMNode $dom, $rootElementClass){
		if ($dom instanceof DOMDocument) {
			$dom = $dom->documentElement;
		}
		return $this->decodeComplexType($dom, $rootElementClass);
	}

	private function decodeComplexType(DOMNode $dom, $className){
		if ($dom instanceof DOMElement) {
			$typeAttribute = $dom->getAttributeNodeNS(self::XML_SCHEMA_INSTANCE_NAMESPACE, 'type');
			if (!empty($typeAttribute)) {
				$typeAttributeValue = $typeAttribute->value;
				$typePrefix = Customweb_Core_Util_Xml::extractNamespacePrefix($typeAttributeValue);
				$namespace = $typeAttribute->lookupNamespaceUri($typePrefix);
				$typeName = Customweb_Core_Util_Xml::removeNamespacePrefix($typeAttributeValue);
				$xmlInstanceTypeClassName = $this->findPhpClassName($typeName, $namespace);
				if ($xmlInstanceTypeClassName !== null) {
					$className = $xmlInstanceTypeClassName;
				}
			}
		}
		
		Customweb_Core_Util_Class::loadLibraryClassByName($className);
		$reflector = new Customweb_Xml_Binding_Reflection_Class($className);
		
		if ($reflector->isSimpleType()) {
			$object = $this->instantiateSimpleType($className, $dom->nodeValue);
		}
		else {
			$object = $reflector->getReflector()->newInstance();
		}
		
		foreach ($reflector->getProperties() as $property) {
			if ($property->isProcessable()) {
				$value = $this->readPropertyValue($property, $dom);
				if ($value !== null) {
					$property->setValue($object, $value);
				}
			}
		}
		
		return $object;
	}

	private function findPhpClassName($typeName, $namespace){
		$scanner = new Customweb_Annotation_Scanner();
		foreach ($scanner->find('Customweb_Xml_Binding_Annotation_XmlType') as $className => $annotation) {
			if ($annotation instanceof Customweb_Xml_Binding_Annotation_XmlType) {
				if ($annotation->getName() == $typeName && $annotation->getNamespace() == $namespace) {
					return $className;
				}
			}
		}
		return null;
	}

	private function readPropertyValue(Customweb_Xml_Binding_Reflection_Property $reflector, DOMNode $parentNode){
		$namespaceUri = $reflector->getNamespaceUri();
		if ($reflector->isAttribute()) {
			if ($parentNode instanceof DOMElement) {
				if (!empty($namespaceUri)) {
					if ($parentNode->hasAttributeNS($namespaceUri, $reflector->getName())) {
						return $this->instantiateSimpleType($reflector->getItemPhpClasName(), 
								$parentNode->getAttributeNS($namespaceUri, $reflector->getName()));
					}
					else {
						return null;
					}
				}
				else {
					if ($parentNode->hasAttribute($reflector->getName())) {
						return $this->instantiateSimpleType($reflector->getItemPhpClasName(), $parentNode->getAttribute($reflector->getName()));
					}
					else {
						return null;
					}
				}
			}
			else {
				throw new Exception(
						Customweb_Core_String::_("Unable to read attribute @name.")->format(array(
							'@name' => $reflector->getName() 
						)));
			}
		}
		else if ($reflector->isArray()) {
			if ($parentNode instanceof DOMElement) {
				if (!empty($namespaceUri)) {
					$nodeList = $parentNode->getElementsByTagNameNS($namespaceUri, $reflector->getName());
				}
				else {
					$nodeList = $parentNode->getElementsByTagName($reflector->getName());
				}
				if ($nodeList->length > 0) {
					$list = new ArrayObject();
					if ($reflector->isSimpleType()) {
						foreach ($nodeList as $node) {
							$list->append($this->instantiateSimpleType($reflector->getItemPhpClasName(), $node->nodeValue));
						}
					}
					else {
						foreach ($nodeList as $node) {
							$list->append($this->decodeComplexType($node, $reflector->getItemPhpClasName()));
						}
					}
					return $list;
				}
				else {
					return null;
				}
			}
			else {
				throw new Exception(
						Customweb_Core_String::_("Unable to read element @name.")->format(array(
							'@name' => $reflector->getName() 
						)));
			}
		}
		else if ($reflector->isValue()) {
			if ($parentNode instanceof DOMElement) {
				$targetNode = null;
				if (!empty($namespaceUri)) {
					$nodeList = $parentNode->getElementsByTagNameNS($namespaceUri, $reflector->getName());
				}
				else {
					$nodeList = $parentNode->getElementsByTagName($reflector->getName());
				}
				if ($nodeList->length === 0) {
					return null;
				}
				else if ($nodeList->length === 1) {
					$targetNode = $nodeList->item(0);
				}
				else {
					foreach ($nodeList as $node) {
						if ($parentNode->isSameNode($node->parentNode)) { // getElementsByTagName searches recursively, and may return properties from other nodes.
							$targetNode = $node;
						}
					}
				}
				if ($targetNode === null) {
					return null;
				}
				return $this->instantiateSimpleType($reflector->getItemPhpClasName(), $targetNode->nodeValue);
			}
			else {
				throw new Exception(
						Customweb_Core_String::_("Unable to read element @name.")->format(array(
							'@name' => $reflector->getName() 
						)));
			}
		}
		else if ($reflector->isElement()) {
			if ($parentNode instanceof DOMElement) {
				if (!empty($namespaceUri)) {
					$nodeList = $parentNode->getElementsByTagNameNS($namespaceUri, $reflector->getName());
				}
				else {
					$nodeList = $parentNode->getElementsByTagName($reflector->getName());
				}
				
				if ($nodeList->length === 0) {
					return null;
				}
				else if ($nodeList->length === 1) {
					$targetNode = $nodeList->item(0);
				}
				else {
					foreach ($nodeList as $node) {
						if ($parentNode->isSameNode($node->parentNode)) { // getElementsByTagName searches recursively, and may return properties from other nodes.
							$targetNode = $node;
						}
					}
				}
				if ($targetNode === null) {
					return null;
				}
				return $this->decodeComplexType($targetNode, $reflector->getItemPhpClasName());
			}
			else {
				throw new Exception(
						Customweb_Core_String::_("Unable to read element @name.")->format(array(
							'@name' => $reflector->getName() 
						)));
			}
		}
		else {
			throw new Exception("Invalid state.");
		}
	}

	private function instantiateSimpleType($className, $value){
		Customweb_Core_Util_Class::loadLibraryClassByName($className);
		$reflector = new Customweb_Xml_Binding_Reflection_Class($className);
		$object = $reflector->getReflector()->newInstance();
		if ($object instanceof Customweb_Xml_ISimpleType) {
			$value = $this->convertToNativeType($className, $value);
			if ($value === null) {
				return null;
			}
			$object->set($value);
		}
		return $object;
	}
}