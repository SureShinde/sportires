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
 * @XmlType(name="InquiryRateReference", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateReference {
	/**
	 * @XmlElement(name="InquiryRateId", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId
	 */
	private $inquiryRateId;
	
	/**
	 * @XmlValue(name="DccApplied", simpleType=@XmlSimpleTypeDefinition(typeName='boolean', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean'), namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var boolean
	 */
	private $dccApplied;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateReference
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateReference();
		return $i;
	}
	/**
	 * Returns the value for the property inquiryRateId.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId
	 */
	public function getInquiryRateId(){
		return $this->inquiryRateId;
	}
	
	/**
	 * Sets the value for the property inquiryRateId.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId $inquiryRateId
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateReference
	 */
	public function setInquiryRateId($inquiryRateId){
		if ($inquiryRateId instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId) {
			$this->inquiryRateId = $inquiryRateId;
		}
		else {
			throw new BadMethodCallException("Type of argument inquiryRateId must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateId.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property dccApplied.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean
	 */
	public function getDccApplied(){
		return $this->dccApplied;
	}
	
	/**
	 * Sets the value for the property dccApplied.
	 * 
	 * @param boolean $dccApplied
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_InquiryRateReference
	 */
	public function setDccApplied($dccApplied){
		if ($dccApplied instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean) {
			$this->dccApplied = $dccApplied;
		}
		else {
			$this->dccApplied = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_Boolean::_()->set($dccApplied);
		}
		return $this;
	}
	
	
	
}