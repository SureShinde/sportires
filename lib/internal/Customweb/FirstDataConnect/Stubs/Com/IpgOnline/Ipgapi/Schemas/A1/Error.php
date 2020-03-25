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
 * @XmlType(name="Error", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error {
	/**
	 * @XmlValue(name="ErrorMessage", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var string
	 */
	private $errorMessage;
	
	/**
	 * @XmlAttribute(name="Code", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String')) 
	 * @var string
	 */
	private $code;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error();
		return $i;
	}
	/**
	 * Returns the value for the property errorMessage.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getErrorMessage(){
		return $this->errorMessage;
	}
	
	/**
	 * Sets the value for the property errorMessage.
	 * 
	 * @param string $errorMessage
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error
	 */
	public function setErrorMessage($errorMessage){
		if ($errorMessage instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->errorMessage = $errorMessage;
		}
		else {
			$this->errorMessage = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($errorMessage);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property code.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getCode(){
		return $this->code;
	}
	
	/**
	 * Sets the value for the property code.
	 * 
	 * @param string $code
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_Error
	 */
	public function setCode($code){
		if ($code instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->code = $code;
		}
		else {
			$this->code = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($code);
		}
		return $this;
	}
	
	
	
}