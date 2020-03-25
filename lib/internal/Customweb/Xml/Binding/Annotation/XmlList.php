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
 * Identifies a given property or method as array / list.
 * e.g.: @XmlList(@XmlSimpleTypeDefinition('xs:string'))
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Xml_Binding_Annotation_XmlList implements Customweb_Xml_Binding_Annotation_IXmlAnnotation {
	
	private $itemType;
	
	private $simple = null;
	
	private $name;
	
	private $namespace;
	
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	public function getItemType(){
		return $this->itemType;
	}

	public function setType($itemType){
		
		if (is_string($itemType)) {
			$this->simple = false;
		}
		else if ($itemType instanceof Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition) {
			$this->simple = true;
		}
		else {
			throw new Exception("Try to set an invalid item type.");
		}
		
		$this->itemType = $itemType;
		return $this;
	}
	
	public function isSimpleType() {
		if ($this->simple === null) {
			throw new Exception("No item type set.");
		}
		return $this->simple;
	}
	
	public function getSimpleType() {
		if (!$this->isSimpleType()) {
			throw new Exception("The item type is a complex type.");
		}
		return $this->itemType;
	}
	
	public function isComplexType() {
		return !$this->isSimpleType();
	}
	
	public function getComplexType() {
		if (!$this->isComplexType()) {
			throw new Exception("Item type is not a complex type.");
		}
		return $this->itemType;
	}

	public function getNamespace(){
		return $this->namespace;
	}
	
	public function setNamespace($namespace){
		$this->namespace = $namespace;
		return $this;
	}
	
	
	
}