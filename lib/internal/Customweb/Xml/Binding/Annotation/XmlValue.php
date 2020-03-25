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
 * Identifies a given property or method to be the content of XML node.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Xml_Binding_Annotation_XmlValue implements Customweb_Xml_Binding_Annotation_IXmlAnnotation {
	
	/**
	 * @var Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition
	 */
	private $simpleType;
	
	private $name;
	
	private $namespace;
	
	public function __construct() {
		$this->simpleType = new Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition();
	}
	
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
		return $this;
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