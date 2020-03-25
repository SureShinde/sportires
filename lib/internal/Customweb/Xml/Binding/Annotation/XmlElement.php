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
 * Annotates a method as XML element. Sample Annotation:
 * @XmlElement(name='nameOfElement', type='Customweb_..._FooBar', required=true, defaultValue='Some Default Value of type string', namespace="http://some-namespace-uri.com/ns", nillable=true)
 * 
 * Defaults:
 * <ul>
 *   <li>name: The name of the method.</li>
 *   <li>type: The class type </li>
 *   <li>required: false</li>
 *   <li>defaultValue: none</li>
 *   <li>namespace: none</li>
 *   <li>nillable: false</li>
 * </ul>
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Xml_Binding_Annotation_XmlElement implements Customweb_Xml_Binding_Annotation_IXmlAnnotation {

	private $name = null;
	
	private $type = null;
	
	private $required = false;
	
	private $namespace = null;
	
	private $defaultValue = null;
	
	private $nillable = false;
	
	private $simpleType = null;
	
	public function __construct(){
		
	}
	
	public function setType($type){
	
		if (is_string($type)) {
			$this->simpleType = false;
		}
		else if ($type instanceof Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition) {
			$this->simpleType = true;
		}
		else {
			throw new Exception("Try to set an invalid element type.");
		}
	
		$this->type = $type;
		return $this;
	}
	
	public function isTypeSet() {
		return $this->simpleType !== null;
	}
	
	public function isSimpleType() {
		if ($this->simpleType === null) {
			throw new Exception("No element type set.");
		}
		return $this->simpleType;
	}
	
	public function getSimpleType() {
		if (!$this->isSimpleType()) {
			throw new Exception("The element type is a complex type.");
		}
		return $this->type;
	}
	
	public function isComplexType() {
		return !$this->isSimpleType();
	}
	
	public function getComplexType() {
		if (!$this->isComplexType()) {
			throw new Exception("Item element is not a complex type.");
		}
		return $this->type;
	}
	
	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function isRequired(){
		return $this->required;
	}

	public function setRequired($required){
		$this->required = $required;
		return $this;
	}

	public function getNamespace(){
		return $this->namespace;
	}

	public function setNamespace($namespace){
		$this->namespace = $namespace;
		return $this;
	}

	public function getDefaultValue(){
		return $this->defaultValue;
	}

	public function setDefaultValue($defaultValue){
		$this->defaultValue = $defaultValue;
		return $this;
	}

	public function isNillable(){
		return $this->nillable;
	}

	public function setNillable($nillable){
		$this->nillable = $nillable;
		return $this;
	}
	
}