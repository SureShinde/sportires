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
 * Defines a simple xml type.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Xml_Binding_Annotation_XmlSimpleTypeDefinition implements Customweb_Xml_Binding_Annotation_IXmlAnnotation {
	
	private $facets = array();
	
	private $typeName;

	private $typeNamespace;
	
	private $type;
	
	public function getFacets(){
		return $this->facets;
	}

	public function setFacets(array $facets){
		
		foreach ($facets as $facet) {
			if (!($facet instanceof Customweb_Xml_Binding_Annotation_XmlFacet)) {
				throw new Exception(
					Customweb_Core_String::_("The provided XmlFacet is not type of 'Customweb_Xml_Binding_Annotation_XmlFacet'. The type was !type.")->format(array('!type' => get_class($facet)))
				);
			}
		}
		$this->facets = $facets;
		return $this;
	}

	public function getTypeName(){
		return $this->typeName;
	}

	public function setTypeName($typeName){
		$this->typeName = $typeName;
		return $this;
	}

	public function getTypeNamespace(){
		return $this->typeNamespace;
	}

	public function setTypeNamespace($typeNamespace){
		$this->typeNamespace = $typeNamespace;
		return $this;
	}

	public function getType(){
		return $this->type;
	}

	public function setType($type){
		$this->type = $type;
		return $this;
	}
	
	
}