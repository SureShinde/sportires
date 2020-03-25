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
 * Annotates a method or class property as XML attribute. Sample Annotation:
 * @XmlAttribute(name='nameOfTheAttribute', required=true)
 * 
 * The name is set per default to the name of the method or property name. The 
 * attribute is per default not required.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Xml_Binding_Annotation_XmlAttribute implements Customweb_Xml_Binding_Annotation_IXmlAnnotation {

	private $name = null;
	
	private $namespace = null;
	
	private $required = false;
	
	/**
	 * @var Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition
	 */
	private $simpleType;
	
	public function __construct() {
		$this->simpleType = new Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition();
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setRequired($required) {
		if ($required) {
			$this->required = true;
		}
		else {
			$this->required = false;
		}
		return $this;
	}
	
	public function isRequired() {
		return $this->required;
	}

	public function getNamespace(){
		return $this->namespace;
	}

	public function setNamespace($namespace){
		$this->namespace = $namespace;
		return $this;
	}

	public function getSimpleType(){
		return $this->simpleType;
	}
	
	public function setSimpleType(Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition $simpleType){
		$this->simpleType = $simpleType;
		return $this;
	}
	
}