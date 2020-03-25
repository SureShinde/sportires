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



abstract class Customweb_Xml_Binding_Reflection_AbstractItem implements Customweb_Xml_Binding_Reflection_IItem{
	
	/**
	 * @var Customweb_Annotation_IAnnotationReflector
	 */
	private $reflector;
	
	public function __construct(Customweb_Annotation_IAnnotationReflector $reflector) {
		$this->reflector = $reflector;
	}
	
	/**
	 * Returns the reflector.
	 * 
	 * @return Customweb_Annotation_IAnnotationReflector
	 */
	public function getReflector() {
		return $this->reflector;
	}
	
	final public function isTransient(){
		return $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlTransient');
	}
	
	final public function isNillable(){
		return $this->getReflector()->hasAnnotation('Customweb_Xml_Binding_Annotation_XmlNillable');
	}
}