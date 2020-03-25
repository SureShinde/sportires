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

final class Customweb_Xml_Binding_Reflection_Property extends Customweb_Xml_Binding_Reflection_AbstractItem {

	public function __construct($className, $name){
		parent::__construct(new Customweb_Annotation_UnifiedPropertyReflector($className, $name));
	}

	public function isProcessable(){
		if ($this->isTransient()) {
			return false;
		}
		return $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlList') ||
				 $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlAttribute') ||
				 $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlElement') ||
				 $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlValue');
	}

	/**
	 *
	 * @return Customweb_Annotation_UnifiedPropertyReflector
	 */
	public function getReflector(){
		return parent::getReflector();
	}

	public function getValue($object){
		return $this->getReflector()->getValue($object);
	}

	public function setValue($object, $value){
		return $this->getReflector()->setValue($object, $value);
	}

	public function getClassName(){
		return $this->getReflector()->getClassName();
	}

	/**
	 * Returns the name of the PHP property (e.g.
	 * method name without 'get' and 'set' or the class property name).
	 *
	 * @return string
	 */
	public function getPhpName(){
		return $this->getReflector()->getName();
	}

	public function getName(){
		if ($this->isArray()) {
			return $this->getListAnnotation()->getName();
		}
		else if ($this->isAttribute()) {
			return $this->getAttributeAnnotation()->getName();
		}
		else if ($this->isElement()) {
			return $this->getElementAnnotation()->getName();
		}
		else if ($this->isValue()) {
			return $this->getValueAnnotation()->getName();
		}
		throw new Exception("Invalid state.");
	}

	public function getNamespaceUri(){
		if ($this->isArray()) {
			return $this->getListAnnotation()->getNamespace();
		}
		else if ($this->isAttribute()) {
			return $this->getAttributeAnnotation()->getNamespace();
		}
		else if ($this->isElement()) {
			return $this->getElementAnnotation()->getNamespace();
		}
		else if ($this->isValue()) {
			return $this->getValueAnnotation()->getNamespace();
		}
		throw new Exception("Invalid state.");
	}

	/**
	 * Returns the PHP class name of the property.
	 *
	 * @throws Exception
	 * @return string
	 */
	public function getItemPhpClasName(){
		if ($this->isArray()) {
			if ($this->getListAnnotation()->isSimpleType()) {
				return $this->getListAnnotation()->getSimpleType()->getType();
			}
			else {
				return $this->getListAnnotation()->getComplexType();
			}
		}
		else if ($this->isAttribute()) {
			return $this->getAttributeAnnotation()->getSimpleType()->getType();
		}
		else if ($this->isElement()) {
			if ($this->getElementAnnotation()->isSimpleType()) {
				return $this->getElementAnnotation()->getSimpleType()->getType();
			}
			else {
				return $this->getElementAnnotation()->getComplexType();
			}
		}
		else if ($this->isValue()) {
			return $this->getValueAnnotation()->getSimpleType()->getType();
		}
		throw new Exception("Invalid state.");
	}

	public function isArraySimpleType(){
		if ($this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlList')) {
			return $this->getListAnnotation()->isSimpleType();
		}
		else {
			return false;
		}
	}

	public function isSimpleType(){
		if ($this->isArray()) {
			return $this->isArraySimpleType();
		}
		else if ($this->isElement()) {
			return $this->getElementAnnotation()->isSimpleType();
		}
		else {
			return true;
		}
	}
	
	public function getXmlType() {
		if ($this->isArray()) {
			if ($this->getListAnnotation()->isSimpleType()) {
				return $this->getXmlTypeBySimpleTypeAnnotation($this->getListAnnotation()->getSimpleType());
			}
			else {
				return $this->getXmlTypeByComplexType($this->getListAnnotation()->getComplexType());
			}
		}
		else if ($this->isAttribute()) {
			return $this->getXmlTypeBySimpleTypeAnnotation($this->getAttributeAnnotation()->getSimpleType());
		}
		else if ($this->isElement()) {
			if ($this->getElementAnnotation()->isSimpleType()) {
				return $this->getXmlTypeBySimpleTypeAnnotation($this->getElementAnnotation()->getSimpleType());
			}
			else {
				return $this->getXmlTypeByComplexType($this->getElementAnnotation()->getComplexType());
			}
		}
		else if ($this->isValue()) {
			return $this->getXmlTypeBySimpleTypeAnnotation($this->getValueAnnotation()->getSimpleType());
		}
		throw new Exception("Invalid state.");
		
	}

	private function getXmlTypeBySimpleTypeAnnotation(Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition $simpleType) {
		return Customweb_Xml_Type::_($simpleType->getTypeName(), $simpleType->getTypeNamespace());
	}

	private function getXmlTypeByComplexType($complexTypeName) {
		$class = new Customweb_Xml_Binding_Reflection_Class($complexTypeName);
		return $class->getXmlType();
	}
	
	/**
	 * Returns true, when the item is an array.
	 *
	 * @return boolean
	 */
	public function isArray(){
		return $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlList');
	}

	/**
	 * Returns true, when the item is a XML value.
	 *
	 * @return boolean
	 */
	public function isValue(){
		return $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlValue');
	}

	/**
	 * Returns true, when the item is an attribute.
	 *
	 * @return boolean
	 */
	public function isAttribute(){
		return $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlAttribute');
	}

	/**
	 * Returns true, when the given item is an XML element.
	 *
	 * @return boolean
	 */
	public function isElement(){
		return $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlElement');
	}

	/**
	 *
	 * @throws Exception
	 * @return Customweb_Xml_Binding_Annotation_XmlElement
	 */
	private function getElementAnnotation(){
		if ($this->isElement()) {
			return $this->getReflector()->getAnnotation('Customweb_Xml_Binding_Annotation_XmlElement');
		}
		else {
			throw new Exception("This property has no XmlElement annotation.");
		}
	}

	/**
	 *
	 * @throws Exception
	 * @return Customweb_Xml_Binding_Annotation_XmlAttribute
	 */
	private function getAttributeAnnotation(){
		if ($this->isAttribute()) {
			return $this->getReflector()->getAnnotation('Customweb_Xml_Binding_Annotation_XmlAttribute');
		}
		else {
			throw new Exception("This property has no XmlAttribute annotation.");
		}
	}

	/**
	 *
	 * @throws Exception
	 * @return Customweb_Xml_Binding_Annotation_XmlValue
	 */
	private function getValueAnnotation(){
		if ($this->isValue()) {
			return $this->getReflector()->getAnnotation('Customweb_Xml_Binding_Annotation_XmlValue');
		}
		else {
			throw new Exception("This property has no XmlValue annotation.");
		}
	}

	/**
	 *
	 * @throws Exception
	 * @return Customweb_Xml_Binding_Annotation_XmlList
	 */
	private function getListAnnotation(){
		if ($this->isArray()) {
			return $this->getReflector()->getAnnotation('Customweb_Xml_Binding_Annotation_XmlList');
		}
		else {
			throw new Exception("This property has no XmlList annotation.");
		}
	}
}